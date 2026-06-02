@extends('layouts.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-edit me-2 text-primary"></i>Edit Attribute</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Attribute Label <span class="text-danger">*</span></label>
                        <input type="text" name="label" class="form-control" value="{{ old('label', $attribute->label) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Attribute Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $attribute->name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Field Type</label>
                        <select name="type" class="form-control">
                            <option value="text" {{ $attribute->type == 'text' ? 'selected' : '' }}>Text Input</option>
                            <option value="select" {{ $attribute->type == 'select' ? 'selected' : '' }}>Dropdown Select</option>
                            <option value="number" {{ $attribute->type == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="textarea" {{ $attribute->type == 'textarea' ? 'selected' : '' }}>Text Area</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Placeholder</label>
                        <input type="text" name="placeholder" class="form-control" value="{{ old('placeholder', $attribute->placeholder) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="required" value="1" id="required" {{ $attribute->required ? 'checked' : '' }}>
                            <label class="form-check-label" for="required">Required Field</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Values (for dropdown)</label>
                        <div class="input-group">
                            <input type="text" id="values_input" class="form-control" placeholder="e.g., S, M, L, XL">
                            <button type="button" class="btn btn-secondary" onclick="addValues()">Add Values</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered" id="values_table">
                            <thead>
                                <tr><th>Value</th><th>Additional Price (₹)</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                @foreach($attribute->values as $val)
                                <tr>
                                    <td><input type="text" name="values[]" value="{{ $val->value }}" class="form-control" required></td>
                                    <td><input type="number" step="0.01" name="additional_prices[]" value="{{ $val->additional_price }}" class="form-control" placeholder="Extra price"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">Remove</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Attribute</button>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addValues() {
    const input = document.getElementById('values_input');
    const values = input.value.split(',').map(v => v.trim());
    const tbody = document.querySelector('#values_table tbody');
    
    values.forEach(val => {
        if (val) {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td><input type="text" name="values[]" value="${val}" class="form-control" required></td>
                <td><input type="number" step="0.01" name="additional_prices[]" class="form-control" placeholder="Extra price"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">Remove</button></td>
            `;
        }
    });
    input.value = '';
}
</script>
@endsection