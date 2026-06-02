@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="card shadow-sm" style="margin-left:200px;">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-plus me-2 text-primary"></i>Add New Attribute</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.attributes.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Attribute Label <span class="text-danger">*</span></label>
                        <input type="text" name="label" class="form-control" required>
                        <small class="text-muted">Display name (e.g., Size, Color, Weight)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Attribute Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                        <small class="text-muted">Unique identifier (e.g., size, color, weight)</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Field Type</label>
                        <select name="type" class="form-control">
                            <option value="text">Text Input</option>
                            <option value="select">Dropdown Select</option>
                            <option value="radio">Radio Button</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="color">Color Picker</option>
                            <option value="size">Size Selector</option>
                            <option value="weight">Weight Selector</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Placeholder</label>
                        <input type="text" name="placeholder" class="form-control" placeholder="Enter placeholder text">
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="required" value="1" id="required">
                            <label class="form-check-label" for="required">Required Field</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Values (for dropdown/radio/checkbox)</label>
                        <div class="input-group">
                            <input type="text" id="values_input" class="form-control" placeholder="e.g., S, M, L, XL">
                            <button type="button" class="btn btn-secondary" onclick="addValues()">Add Values</button>
                        </div>
                        <small class="text-muted">Comma separated values for select/radio/checkbox type</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered" id="values_table">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Additional Price (₹)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Attribute</button>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary ms-2">Cancel</a>
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
                <td><input type="number" step="0.01" name="additional_prices[]" class="form-control" placeholder="Extra price" value="0"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">Remove</button></td>
            `;
        }
    });
    input.value = '';
}
</script>
@endsection