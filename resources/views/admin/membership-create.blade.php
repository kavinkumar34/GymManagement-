@extends('layouts.admin-layout')

@section('content')

<div class="admin-main-content">
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header text-white"
                style="background: linear-gradient(180deg,#0d1b2a 0%,#1b3a5c 50%,#0d1b2a 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-id-card"></i>
                    Add Membership
                </h4>

            </div>

            <div class="card-body">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('admin.membership.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <!-- Plan Name -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Plan Name
                            </label>

                            <input type="text"
                                name="plan_name"
                                class="form-control"
                                value="{{ old('plan_name') }}"
                                required>

                        </div>

                        <!-- Image -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Membership Image
                            </label>

                            <input type="file"
                                name="image"
                                id="image"
                                class="form-control"
                                accept="image/*"
                                onchange="previewImage(event)">

                        </div>

                        <div class="col-md-12 text-center mb-3">

                            <img id="preview"
                                src=""
                                style="display:none;
                                width:150px;
                                height:150px;
                                border-radius:10px;
                                border:1px solid #ddd;
                                object-fit:cover;">

                        </div>

                        <!-- Duration -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Duration
                            </label>

                            <input type="number"
                                name="duration"
                                class="form-control"
                                value="{{ old('duration') }}"
                                required>

                        </div>

                        <!-- Duration Type -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Duration Type
                            </label>

                            <select name="duration_type"
                                class="form-control">

                                <option value="Days">Days</option>

                                <option value="Months">Months</option>

                                <option value="Years">Years</option>

                            </select>

                        </div>

                        <!-- Price -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Price
                            </label>

                            <input type="number"
                                step="0.01"
                                id="price"
                                name="price"
                                class="form-control"
                                value="{{ old('price') }}"
                                onkeyup="calculatePrice()"
                                onchange="calculatePrice()"
                                required>

                        </div>

                        <!-- Discount Type -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Discount Type
                            </label>

                            <select name="discount_type"
                                id="discount_type"
                                class="form-control"
                                onchange="calculatePrice()">

                                <option value="Flat">
                                    Flat
                                </option>

                                <option value="Percentage">
                                    Percentage
                                </option>

                            </select>

                        </div>

                        <!-- Discount -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Discount
                            </label>

                            <input type="number"
                                step="0.01"
                                id="discount"
                                name="discount"
                                value="0"
                                class="form-control"
                                onkeyup="calculatePrice()"
                                onchange="calculatePrice()">

                        </div>

                        <!-- Final Price -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Final Price
                            </label>

                            <input type="text"
                                id="final_price"
                                name="final_price"
                                class="form-control"
                                readonly>

                        </div>

                        <!-- Description -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-bold">
                                Description
                            </label>

                            <textarea name="description"
                                rows="4"
                                class="form-control">{{ old('description') }}</textarea>

                        </div>

                        <!-- Status -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Status
                            </label>

                            <select name="status"
                                class="form-control">

                                <option value="Active">
                                    Active
                                </option>

                                <option value="Inactive">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                    <hr>

                    <button type="submit"
                        class="btn btn-success">

                        <i class="fas fa-save"></i>

                        Save Membership

                    </button>

                    <a href="{{ route('admin.membership.index') }}"
                        class="btn btn-secondary">

                        Back

                    </a>

                </form>

            </div>

        </div>

    </div>
</div>

<script>

function calculatePrice(){

    let price = parseFloat(document.getElementById('price').value) || 0;

    let discount = parseFloat(document.getElementById('discount').value) || 0;

    let type = document.getElementById('discount_type').value;

    let finalPrice = price;

    if(type=="Flat"){

        finalPrice = price-discount;

    }else{

        finalPrice = price-((price*discount)/100);

    }

    if(finalPrice<0){

        finalPrice=0;

    }

    document.getElementById('final_price').value=finalPrice.toFixed(2);

}

function previewImage(event){

    let reader=new FileReader();

    reader.onload=function(){

        let output=document.getElementById('preview');

        output.src=reader.result;

        output.style.display='block';

    }

    reader.readAsDataURL(event.target.files[0]);

}

calculatePrice();

</script>

@endsection