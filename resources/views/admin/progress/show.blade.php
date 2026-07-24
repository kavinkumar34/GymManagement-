@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">

    <div class="container-fluid">

        <div class="card">

            <div class="card-header text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4>
                    <i class="fas fa-chart-line"></i>
                    Member Progress Details
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Member Name</strong>
                        <p>{{ $progress->member->name ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Trainer Name</strong>
                        <p>{{ $progress->trainer->name ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Progress Date</strong>
                        <p>{{ date('d-m-Y', strtotime($progress->progress_date)) }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Weight</strong>
                        <p>{{ $progress->weight }} Kg</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Height</strong>
                        <p>{{ $progress->height }} cm</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>BMI</strong>
                        <p>{{ $progress->bmi }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Body Fat</strong>
                        <p>{{ $progress->body_fat }} %</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Chest</strong>
                        <p>{{ $progress->chest }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Waist</strong>
                        <p>{{ $progress->waist }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Hips</strong>
                        <p>{{ $progress->hips }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Left Arm</strong>
                        <p>{{ $progress->left_arm }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Right Arm</strong>
                        <p>{{ $progress->right_arm }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Left Thigh</strong>
                        <p>{{ $progress->left_thigh }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Right Thigh</strong>
                        <p>{{ $progress->right_thigh }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Trainer Notes</strong>
                        <p>{{ $progress->notes ?? '-' }}</p>
                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6 text-center">

                        <h5>Before Photo</h5>

                        @if($progress->before_photo)

                            <img src="{{ asset('storage/'.$progress->before_photo) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:300px;">

                        @else

                            <p>No Before Photo</p>

                        @endif

                    </div>

                    <div class="col-md-6 text-center">

                        <h5>After Photo</h5>

                        @if($progress->after_photo)

                            <img src="{{ asset('storage/'.$progress->after_photo) }}"
                                 class="img-fluid rounded border"
                                 style="max-height:300px;">

                        @else

                            <p>No After Photo</p>

                        @endif

                    </div>

                </div>

                <div class="mt-4">

                    <a href="{{ route('admin.progress.index') }}"
                       class="btn btn-secondary">

                        <i class="fas fa-arrow-left"></i>

                        Back

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection