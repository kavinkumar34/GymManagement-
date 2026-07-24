{{ route('member.progress.index') }}@extends('layouts.member-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-success text-white">
            <h4>
                <i class="fas fa-chart-line"></i>
                My Progress
            </h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Trainer</th>
                            <th>Weight</th>
                            <th>Height</th>
                            <th>BMI</th>
                            <th>Body Fat %</th>
                            <th>Chest</th>
                            <th>Waist</th>
                            <th>View</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($progress as $row)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ date('d-m-Y', strtotime($row->progress_date)) }}</td>

                            <td>{{ $row->trainer->name ?? '-' }}</td>

                            <td>{{ $row->weight }} Kg</td>

                            <td>{{ $row->height }} cm</td>

                            <td>{{ $row->bmi }}</td>

                            <td>{{ $row->body_fat }} %</td>

                            <td>{{ $row->chest }}</td>

                            <td>{{ $row->waist }}</td>

                            <td>

                                <button class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#progressModal{{ $row->id }}">

                                    View

                                </button>
                                <button class="btn btn-success btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#chartModal{{ $row->member_id }}">
    Chart
</button>
                                

                            </td>

                        </tr>

                        <!-- Modal -->

                        <div class="modal fade"
                             id="progressModal{{ $row->id }}"
                             tabindex="-1">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">

                                            Progress Details

                                        </h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <strong>Weight:</strong> {{ $row->weight }} Kg
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Height:</strong> {{ $row->height }} cm
                                            </div>

                                            <div class="col-md-6">
                                                <strong>BMI:</strong> {{ $row->bmi }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Body Fat:</strong> {{ $row->body_fat }} %
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Chest:</strong> {{ $row->chest }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Waist:</strong> {{ $row->waist }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Hips:</strong> {{ $row->hips }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Left Arm:</strong> {{ $row->left_arm }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Right Arm:</strong> {{ $row->right_arm }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Left Thigh:</strong> {{ $row->left_thigh }}
                                            </div>

                                            <div class="col-md-6">
                                                <strong>Right Thigh:</strong> {{ $row->right_thigh }}
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <strong>Notes:</strong><br>
                                                {{ $row->notes ?? '-' }}
                                            </div>

                                        </div>

                                        <hr>

                                        <div class="row">

                                            <div class="col-md-6 text-center">

                                                <h5>Before Photo</h5>

                                                @if($row->before_photo)

                                                    <img src="{{ asset('storage/'.$row->before_photo) }}"
                                                         class="img-fluid rounded border">

                                                @else

                                                    No Image

                                                @endif

                                            </div>

                                            <div class="col-md-6 text-center">

                                                <h5>After Photo</h5>

                                                @if($row->after_photo)

                                                    <img src="{{ asset('storage/'.$row->after_photo) }}"
                                                         class="img-fluid rounded border">

                                                @else

                                                    No Image

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

<!-- Chart Modal Start -->

<div class="modal fade"
     id="chartModal{{ $row->member_id }}"
     tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    My Progress Chart
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <canvas id="chart{{ $row->member_id }}" height="120"></canvas>

            </div>

        </div>

    </div>

</div>

<!-- Chart Modal End -->
                        @empty

                        <tr>

                            <td colspan="10" class="text-center">

                                No Progress Records Found

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $progress->links() }}
            </div>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

@foreach($progress->unique('member_id') as $row)

new Chart(document.getElementById('chart{{ $row->member_id }}'), {

    type: 'line',

    data: {

        labels: {!! json_encode(
            \App\Models\Progress::where('member_id',$row->member_id)
                ->orderBy('progress_date')
                ->pluck('progress_date')
        ) !!},

        datasets: [

            {
                label:'Weight',

                data:{!! json_encode(
                    \App\Models\Progress::where('member_id',$row->member_id)
                        ->orderBy('progress_date')
                        ->pluck('weight')
                ) !!},

                borderColor:'blue',

                fill:false
            },

            {
                label:'BMI',

                data:{!! json_encode(
                    \App\Models\Progress::where('member_id',$row->member_id)
                        ->orderBy('progress_date')
                        ->pluck('bmi')
                ) !!},

                borderColor:'green',

                fill:false
            }

        ]

    },

    options:{
        responsive:true
    }

});

@endforeach

</script>

@endsection