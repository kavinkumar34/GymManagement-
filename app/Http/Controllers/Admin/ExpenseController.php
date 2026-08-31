<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Get all expenses - no filter by default
        $expenses = Expense::with('createdBy')
            ->orderBy('expense_date', 'desc')
            ->get();

        // Calculate totals
        $totalExpenses = $expenses->sum('amount');
        $totalCash = $expenses->where('payment_type', 'cash')->sum('amount');
        $totalOnline = $expenses->where('payment_type', 'online')->sum('amount');

        // Get unique months for filter
        $months = Expense::selectRaw('DATE_FORMAT(expense_date, "%Y-%m") as month')
            ->distinct()
            ->orderBy('month', 'desc')
            ->pluck('month');

        // Set default month (current month)
        $month = $request->month ?? now()->format('Y-m');

        return view('admin.expenses.index', compact(
            'expenses',
            'totalExpenses',
            'totalCash',
            'totalOnline',
            'months',
            'month'
        ));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string|max:500',
            'amounts' => 'required|array|min:1',
            'amounts.*' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:cash,online',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle receipt image upload
        $receiptPath = null;
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $request->file('receipt_image')->store('expense-receipts', 'public');
        }

        $descriptions = $request->descriptions;
        $amounts = $request->amounts;
        $totalAmount = 0;

        foreach ($descriptions as $index => $description) {
            if (!empty($description) && isset($amounts[$index]) && $amounts[$index] > 0) {
                Expense::create([
                    'expense_date' => $request->expense_date,
                    'description' => $description,
                    'amount' => $amounts[$index],
                    'payment_type' => $request->payment_type,
                    'receipt_image' => $receiptPath,
                    'created_by' => auth('admin')->id(),
                ]);
                $totalAmount += $amounts[$index];
            }
        }

        return redirect()->route('admin.expenses.index')
            ->with('success', count($descriptions) . ' expense(s) added successfully! Total: ₹' . number_format($totalAmount, 2));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'expense_date' => 'required|date',
            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:cash,online',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle receipt image upload
        if ($request->hasFile('receipt_image')) {
            if ($expense->receipt_image && Storage::disk('public')->exists($expense->receipt_image)) {
                Storage::disk('public')->delete($expense->receipt_image);
            }
            $receiptPath = $request->file('receipt_image')->store('expense-receipts', 'public');
            $expense->receipt_image = $receiptPath;
        }

        $expense->update([
            'expense_date' => $request->expense_date,
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
        ]);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense->receipt_image && Storage::disk('public')->exists($expense->receipt_image)) {
            Storage::disk('public')->delete($expense->receipt_image);
        }

        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully!');
    }
}