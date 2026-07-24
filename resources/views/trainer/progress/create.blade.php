@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-primary text-white">
            <h4>Add Member Progress</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('trainer.progress.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <!-- Member -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Member <span class="text-danger">*</span></label>

                        <select name="member_id" class="form-control" required>

                            <option value="">Select Member</option>

                            @foreach($members as $member)

                                <option value="{{ $member->id }}">
                                    {{ $member->name }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- Date -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Progress Date</label>

                        <input type="date"
                               name="progress_date"
                               class="form-control"
                               value="{{ date('Y-m-d') }}"
                               required>

                    </div>

                    <!-- Weight -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Weight (Kg)</label>

                        <input type="number"
                               step="0.01"
                               id="weight"
                               name="weight"
                               class="form-control"
                               required>

                    </div>

                    <!-- Height -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Height (cm)</label>

                        <input type="number"
                               step="0.01"
                               id="height"
                               name="height"
                               class="form-control"
                               required>

                    </div>

                    <!-- BMI -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">BMI</label>

                        <input type="text"
                               id="bmi"
                               class="form-control"
                               readonly>

                    </div>

                    <!-- Body Fat -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Body Fat (%)</label>

                        <input type="number"
                               step="0.01"
                               name="body_fat"
                               class="form-control">

                    </div>

                    <!-- Chest -->
                    <div class="col-md-4 mb-3">

                        <label>Chest</label>

                        <input type="number"
                               step="0.01"
                               name="chest"
                               class="form-control">

                    </div>

                    <!-- Waist -->
                    <div class="col-md-4 mb-3">

                        <label>Waist</label>

                        <input type="number"
                               step="0.01"
                               name="waist"
                               class="form-control">

                    </div>

                    <!-- Hips -->
                    <div class="col-md-4 mb-3">

                        <label>Hips</label>

                        <input type="number"
                               step="0.01"
                               name="hips"
                               class="form-control">

                    </div>

                    <!-- Left Arm -->
                    <div class="col-md-6 mb-3">

                        <label>Left Arm</label>

                        <input type="number"
                               step="0.01"
                               name="left_arm"
                               class="form-control">

                    </div>

                    <!-- Right Arm -->
                    <div class="col-md-6 mb-3">

                        <label>Right Arm</label>

                        <input type="number"
                               step="0.01"
                               name="right_arm"
                               class="form-control">

                    </div>

                    <!-- Left Thigh -->
                    <div class="col-md-6 mb-3">

                        <label>Left Thigh</label>

                        <input type="number"
                               step="0.01"
                               name="left_thigh"
                               class="form-control">

                    </div>

                    <!-- Right Thigh -->
                    <div class="col-md-6 mb-3">

                        <label>Right Thigh</label>

                        <input type="number"
                               step="0.01"
                               name="right_thigh"
                               class="form-control">

                    </div>

                    <!-- Before Photo -->
                    <div class="col-md-6 mb-3">

                        <label>Before Photo</label>

                        <input type="file"
                               name="before_photo"
                               class="form-control">

                    </div>

                    <!-- After Photo -->
                    <div class="col-md-6 mb-3">

                        <label>After Photo</label>

                        <input type="file"
                               name="after_photo"
                               class="form-control">

                    </div>

                    <!-- Notes -->
                    <div class="col-md-12 mb-3">

                        <label>Notes</label>

                        <textarea name="notes"
                                  rows="4"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <button class="btn btn-success">

                    <i class="fas fa-save"></i>

                    Save Progress

                </button>

                <a href="{{ route('trainer.progress.index') }}"
                   class="btn btn-secondary">

                    Back

                </a>

            </form>

        </div>

    </div>

</div>

<script>

function calculateBMI(){

    let weight = parseFloat(document.getElementById('weight').value);

    let height = parseFloat(document.getElementById('height').value);

    if(weight && height){

        let bmi = weight / ((height/100) * (height/100));

        document.getElementById('bmi').value = bmi.toFixed(2);

    }

}

document.getElementById('weight').addEventListener('keyup',calculateBMI);
document.getElementById('height').addEventListener('keyup',calculateBMI);

</script>

@endsection