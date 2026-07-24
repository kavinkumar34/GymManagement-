@extends('layouts.trainer-layout')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-warning text-dark">
            <h4>Edit Member Progress</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('trainer.progress.update',$progress->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <!-- Member -->
                    <div class="col-md-6 mb-3">
                        <label>Member</label>

                        <select name="member_id" class="form-control" required>

                            @foreach($members as $member)

                                <option value="{{ $member->id }}"
                                    {{ $progress->member_id == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Progress Date -->
                    <div class="col-md-6 mb-3">

                        <label>Progress Date</label>

                        <input type="date"
                               name="progress_date"
                               class="form-control"
                               value="{{ $progress->progress_date }}"
                               required>

                    </div>

                    <!-- Weight -->
                    <div class="col-md-6 mb-3">

                        <label>Weight (Kg)</label>

                        <input type="number"
                               step="0.01"
                               id="weight"
                               name="weight"
                               value="{{ $progress->weight }}"
                               class="form-control"
                               required>

                    </div>

                    <!-- Height -->
                    <div class="col-md-6 mb-3">

                        <label>Height (cm)</label>

                        <input type="number"
                               step="0.01"
                               id="height"
                               name="height"
                               value="{{ $progress->height }}"
                               class="form-control"
                               required>

                    </div>

                    <!-- BMI -->
                    <div class="col-md-6 mb-3">

                        <label>BMI</label>

                        <input type="text"
                               id="bmi"
                               value="{{ $progress->bmi }}"
                               class="form-control"
                               readonly>

                    </div>

                    <!-- Body Fat -->
                    <div class="col-md-6 mb-3">

                        <label>Body Fat (%)</label>

                        <input type="number"
                               step="0.01"
                               name="body_fat"
                               value="{{ $progress->body_fat }}"
                               class="form-control">

                    </div>

                    <!-- Chest -->
                    <div class="col-md-4 mb-3">

                        <label>Chest</label>

                        <input type="number"
                               step="0.01"
                               name="chest"
                               value="{{ $progress->chest }}"
                               class="form-control">

                    </div>

                    <!-- Waist -->
                    <div class="col-md-4 mb-3">

                        <label>Waist</label>

                        <input type="number"
                               step="0.01"
                               name="waist"
                               value="{{ $progress->waist }}"
                               class="form-control">

                    </div>

                    <!-- Hips -->
                    <div class="col-md-4 mb-3">

                        <label>Hips</label>

                        <input type="number"
                               step="0.01"
                               name="hips"
                               value="{{ $progress->hips }}"
                               class="form-control">

                    </div>

                    <!-- Left Arm -->
                    <div class="col-md-6 mb-3">

                        <label>Left Arm</label>

                        <input type="number"
                               step="0.01"
                               name="left_arm"
                               value="{{ $progress->left_arm }}"
                               class="form-control">

                    </div>

                    <!-- Right Arm -->
                    <div class="col-md-6 mb-3">

                        <label>Right Arm</label>

                        <input type="number"
                               step="0.01"
                               name="right_arm"
                               value="{{ $progress->right_arm }}"
                               class="form-control">

                    </div>

                    <!-- Left Thigh -->
                    <div class="col-md-6 mb-3">

                        <label>Left Thigh</label>

                        <input type="number"
                               step="0.01"
                               name="left_thigh"
                               value="{{ $progress->left_thigh }}"
                               class="form-control">

                    </div>

                    <!-- Right Thigh -->
                    <div class="col-md-6 mb-3">

                        <label>Right Thigh</label>

                        <input type="number"
                               step="0.01"
                               name="right_thigh"
                               value="{{ $progress->right_thigh }}"
                               class="form-control">

                    </div>

                    <!-- Before Photo -->
                    <div class="col-md-6 mb-3">

                        <label>Before Photo</label>

                        <input type="file"
                               name="before_photo"
                               class="form-control">

                        @if($progress->before_photo)
                            <img src="{{ asset('storage/'.$progress->before_photo) }}"
                                 width="120"
                                 class="mt-2 border">
                        @endif

                    </div>

                    <!-- After Photo -->
                    <div class="col-md-6 mb-3">

                        <label>After Photo</label>

                        <input type="file"
                               name="after_photo"
                               class="form-control">

                        @if($progress->after_photo)
                            <img src="{{ asset('storage/'.$progress->after_photo) }}"
                                 width="120"
                                 class="mt-2 border">
                        @endif

                    </div>

                    <!-- Notes -->
                    <div class="col-md-12 mb-3">

                        <label>Notes</label>

                        <textarea name="notes"
                                  rows="4"
                                  class="form-control">{{ $progress->notes }}</textarea>

                    </div>

                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Progress
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
function calculateBMI() {
    let weight = parseFloat(document.getElementById('weight').value);
    let height = parseFloat(document.getElementById('height').value);

    if(weight && height){
        let bmi = weight / ((height/100) * (height/100));
        document.getElementById('bmi').value = bmi.toFixed(2);
    }
}

document.getElementById('weight').addEventListener('keyup', calculateBMI);
document.getElementById('height').addEventListener('keyup', calculateBMI);
</script>

@endsection