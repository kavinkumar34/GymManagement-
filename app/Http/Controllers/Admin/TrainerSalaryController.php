<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainerSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainerSalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainerSalary::with('trainer', 'createdBy');

        // Filter by month
        if ($request->month) {
            $month = Carbon::parse($request->month);
            $query->whereYear('salary_month', $month->year)
                  ->whereMonth('salary_month', $month->month);
        }

        $salaries = $query->orderBy('salary_month', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->get();

        // 🔥 Group salaries by month for display (unique months)
        $groupedSalaries = [];
        $processedMonths = [];

        foreach ($salaries as $salary) {
            $monthKey = $salary->salary_month->format('Y-m');
            $monthYear = $salary->salary_month->format('M Y');
            
            if (!in_array($monthKey, $processedMonths)) {
                $monthSalaries = $salaries->filter(function($s) use ($monthKey) {
                    return $s->salary_month->format('Y-m') === $monthKey;
                });
                
                $groupedSalaries[] = (object) [
                    'month_key' => $monthKey,
                    'month_year' => $monthYear,
                    'payment_date' => $monthSalaries->first()->payment_date ?? null,
                    'payment_type' => $monthSalaries->first()->payment_type ?? 'cash',
                    'total_amount' => $monthSalaries->sum('salary_amount'),
                    'trainers' => $monthSalaries->map(function($s) {
                        return (object) [
                            'name' => $s->trainer->name ?? 'N/A',
                            'specialization' => $s->trainer->specialization ?? 'General',
                            'amount' => $s->salary_amount,
                        ];
                    }),
                    'id' => $monthSalaries->first()->id ?? null,
                ];
                $processedMonths[] = $monthKey;
            }
        }

        // Calculate totals
        $totalAmount = $salaries->sum('salary_amount');
        $cashTotal = $salaries->where('payment_type', 'cash')->sum('salary_amount');
        $bankTotal = $salaries->where('payment_type', 'bank')->sum('salary_amount');
        $onlineTotal = $salaries->where('payment_type', 'online')->sum('salary_amount');

        // Get unique months for filter
        $months = TrainerSalary::selectRaw('DATE_FORMAT(salary_month, "%Y-%m") as month')
            ->distinct()
            ->orderBy('month', 'desc')
            ->pluck('month');

        $trainers = Trainer::where('status', 'Active')->orderBy('name')->get();

        return view('admin.trainer-salaries.index', compact(
            'groupedSalaries',
            'totalAmount',
            'cashTotal',
            'bankTotal',
            'onlineTotal',
            'months',
            'trainers'
        ));
    }

    public function create()
    {
        $trainers = Trainer::where('status', 'Active')->orderBy('name')->get();
        return view('admin.trainer-salaries.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'salary_month' => 'required|date',
            'payment_date' => 'required|date',
            'payment_type' => 'required|in:cash,bank,online',
            'trainer_ids' => 'required|array|min:1',
            'trainer_ids.*' => 'exists:trainers,id',
            'amounts' => 'required|array|min:1',
            'amounts.*' => 'required|numeric|min:0.01',
            'common_notes' => 'nullable|string|max:500',
        ]);

        $trainerIds = $request->trainer_ids;
        $amounts = $request->amounts;
        $commonNotes = $request->common_notes;
        $createdCount = 0;
        $totalAmount = 0;

        foreach ($trainerIds as $index => $trainerId) {
            $amount = $amounts[$index] ?? 0;

            if ($amount <= 0) {
                continue;
            }

            // Check if salary already exists for this trainer and month
            $existing = TrainerSalary::where('trainer_id', $trainerId)
                ->whereYear('salary_month', Carbon::parse($request->salary_month)->year)
                ->whereMonth('salary_month', Carbon::parse($request->salary_month)->month)
                ->first();

            if ($existing) {
                continue;
            }

            TrainerSalary::create([
                'trainer_id' => $trainerId,
                'salary_month' => $request->salary_month,
                'salary_amount' => $amount,
                'payment_date' => $request->payment_date,
                'payment_type' => $request->payment_type,
                'reference_number' => null,
                'notes' => $commonNotes,
                'created_by' => auth('admin')->id(),
            ]);

            $createdCount++;
            $totalAmount += $amount;
        }

        if ($createdCount === 0) {
            return back()->with('error', 'No salaries were added. Either all trainers already have salary for this month or invalid amounts.');
        }

        return redirect()->route('admin.trainer-salaries.index')
            ->with('success', $createdCount . ' trainer(s) salary added successfully! Total: ₹' . number_format($totalAmount, 2));
    }

    public function edit($id)
    {
        /*
         * The index page is grouped by month and uses the first salary
         * record ID of that month as the edit identifier. Therefore,
         * load every salary record for that same month here.
         */
        $salary = TrainerSalary::with('trainer')->findOrFail($id);

        $salaries = TrainerSalary::with('trainer')
            ->whereYear('salary_month', Carbon::parse($salary->salary_month)->year)
            ->whereMonth('salary_month', Carbon::parse($salary->salary_month)->month)
            ->orderBy('id')
            ->get();

        // Show all active trainers. Existing salary records for this month
        // will be checked and their amounts will be pre-filled in the view.
        $trainers = Trainer::where('status', 'Active')
            ->orderBy('name')
            ->get();

        $salaryByTrainer = $salaries->keyBy('trainer_id');

        return view('admin.trainer-salaries.edit', compact(
            'salary',
            'salaries',
            'trainers',
            'salaryByTrainer'
        ));
    }

    public function update(Request $request, $id)
    {
        $salary = TrainerSalary::findOrFail($id);

        $request->validate([
            'salary_month' => 'required|date',
            'payment_date' => 'required|date',
            'payment_type' => 'required|in:cash,bank,online',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
            'trainer_ids' => 'required|array|min:1',
            'trainer_ids.*' => 'required|exists:trainers,id',
            'amounts' => 'required|array|min:1',
        ]);

        $trainerIds = array_values(array_unique(array_map('intval', $request->trainer_ids)));
        $amounts = $request->input('amounts', []);
        $newMonth = Carbon::parse($request->salary_month);

        // Every selected trainer must have a valid salary amount.
        foreach ($trainerIds as $trainerId) {
            $amount = $amounts[$trainerId] ?? null;

            if ($amount === null || !is_numeric($amount) || (float) $amount <= 0) {
                return back()
                    ->withInput()
                    ->with('error', 'Please enter a valid salary amount for every selected trainer.');
            }
        }

        try {
            DB::transaction(function () use (
                $request,
                $salary,
                $trainerIds,
                $amounts,
                $newMonth
            ) {
            /*
             * All records belonging to the month represented by the
             * clicked Edit button.
             */
            $oldSalaries = TrainerSalary::whereYear(
                    'salary_month',
                    Carbon::parse($salary->salary_month)->year
                )
                ->whereMonth(
                    'salary_month',
                    Carbon::parse($salary->salary_month)->month
                )
                ->get();

            $oldSalaryIds = $oldSalaries->pluck('id')->toArray();

            /*
             * Prevent duplicate trainer + month records when the user
             * changes the salary month during editing.
             */
            foreach ($trainerIds as $trainerId) {
                $existing = TrainerSalary::where('trainer_id', $trainerId)
                    ->whereYear('salary_month', $newMonth->year)
                    ->whereMonth('salary_month', $newMonth->month)
                    ->whereNotIn('id', $oldSalaryIds)
                    ->first();

                if ($existing) {
                    $trainer = Trainer::find($trainerId);

                    throw new \RuntimeException(
                        'Salary already recorded for ' .
                        ($trainer->name ?? 'this trainer') .
                        ' for ' .
                        $newMonth->format('F Y') . '.'
                    );
                }
            }

            $oldTrainerIds = $oldSalaries->pluck('trainer_id')->map(function ($value) {
                return (int) $value;
            })->toArray();

            /*
             * Update existing salary records.
             * If an existing trainer is unchecked in the edit screen,
             * remove that trainer from this month's salary group.
             */
            foreach ($oldSalaries as $oldSalary) {
                if (in_array((int) $oldSalary->trainer_id, $trainerIds, true)) {
                    $oldSalary->update([
                        'salary_month' => $request->salary_month,
                        'salary_amount' => $amounts[$oldSalary->trainer_id],
                        'payment_date' => $request->payment_date,
                        'payment_type' => $request->payment_type,
                        'reference_number' => $request->reference_number,
                        'notes' => $request->notes,
                    ]);
                } else {
                    $oldSalary->delete();
                }
            }

            /*
             * Create a salary record for a newly selected trainer who did
             * not have a salary record in the original month.
             */
            foreach ($trainerIds as $trainerId) {
                if (!in_array($trainerId, $oldTrainerIds, true)) {
                    TrainerSalary::create([
                        'trainer_id' => $trainerId,
                        'salary_month' => $request->salary_month,
                        'salary_amount' => $amounts[$trainerId],
                        'payment_date' => $request->payment_date,
                        'payment_type' => $request->payment_type,
                        'reference_number' => $request->reference_number,
                        'notes' => $request->notes,
                        'created_by' => auth('admin')->id(),
                    ]);
                }
            }
            });
        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.trainer-salaries.index')
            ->with(
                'success',
                'Salary details updated successfully for ' . $newMonth->format('F Y') . '.'
            );
    }

    public function destroy($id)
    {
        /*
         * The index displays one row per month. The ID passed here is the
         * first salary record ID of that month, so use it to identify the
         * month and delete every trainer salary record for that month.
         */
        $salary = TrainerSalary::findOrFail($id);

        $salaryMonth = Carbon::parse($salary->salary_month);
        $monthYear = $salaryMonth->format('F Y');

        $deletedCount = TrainerSalary::whereYear(
                'salary_month',
                $salaryMonth->year
            )
            ->whereMonth(
                'salary_month',
                $salaryMonth->month
            )
            ->delete();

        return redirect()
            ->route('admin.trainer-salaries.index')
            ->with(
                'success',
                $deletedCount .
                ' trainer salary record(s) deleted successfully for ' .
                $monthYear . '.'
            );
    }

    public function report(Request $request)
    {
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;

        $monthlyLabels = [];
        $monthlyData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $total = TrainerSalary::whereYear('salary_month', $date->year)
                ->whereMonth('salary_month', $date->month)
                ->sum('salary_amount') ?? 0;

            $monthlyData[] = $total;
        }

        $trainerSalaries = Trainer::with(['salaries' => function($query) use ($year, $month) {
            $query->whereYear('salary_month', $year)
                  ->whereMonth('salary_month', $month);
        }])
        ->where('status', 'Active')
        ->get();

        $yearlyTotal = TrainerSalary::whereYear('salary_month', $year)->sum('salary_amount');
        $monthlyTotal = TrainerSalary::whereYear('salary_month', $year)
            ->whereMonth('salary_month', $month)
            ->sum('salary_amount');

        $cashTotal = TrainerSalary::whereYear('salary_month', $year)
            ->whereMonth('salary_month', $month)
            ->where('payment_type', 'cash')
            ->sum('salary_amount');

        $bankTotal = TrainerSalary::whereYear('salary_month', $year)
            ->whereMonth('salary_month', $month)
            ->where('payment_type', 'bank')
            ->sum('salary_amount');

        $onlineTotal = TrainerSalary::whereYear('salary_month', $year)
            ->whereMonth('salary_month', $month)
            ->where('payment_type', 'online')
            ->sum('salary_amount');

        return view('admin.trainer-salaries.report', compact(
            'monthlyLabels',
            'monthlyData',
            'trainerSalaries',
            'yearlyTotal',
            'monthlyTotal',
            'cashTotal',
            'bankTotal',
            'onlineTotal',
            'year',
            'month'
        ));
    }

    public function export(Request $request)
    {
        $query = TrainerSalary::with('trainer');

        if ($request->month) {
            $month = Carbon::parse($request->month);
            $query->whereYear('salary_month', $month->year)
                  ->whereMonth('salary_month', $month->month);
        }

        $salaries = $query->orderBy('salary_month', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="trainer_salaries_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($salaries) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['#', 'Trainer', 'Month', 'Amount', 'Payment Type', 'Payment Date', 'Notes']);

            foreach ($salaries as $index => $salary) {
                fputcsv($file, [
                    $index + 1,
                    $salary->trainer->name ?? 'N/A',
                    $salary->month_year,
                    $salary->salary_amount,
                    $salary->payment_type_label,
                    $salary->formatted_date,
                    $salary->notes ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}