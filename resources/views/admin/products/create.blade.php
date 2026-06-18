@extends('layouts.admin-layout')

@section('content')
<style>
    .form-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .form-section-header {
        background: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }
    .form-section-body {
        padding: 20px;
    }
    .image-preview-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .image-preview-item {
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-preview-item .remove-img {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: red;
        color: white;
        border: none;
        font-size: 12px;
        cursor: pointer;
    }
    .required-star {
        color: red;
    }
    .image-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    .image-upload-area:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
    }
    .category-attr-btn {
        border: 2px solid #dee2e6;
        padding: 8px 18px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
        font-weight: 500;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .category-attr-btn:hover {
        border-color: #0d6efd;
        background: #f0f4ff;
        transform: translateY(-2px);
    }
    .category-attr-btn.active {
        border-color: #0d6efd;
        background: #0d6efd;
        color: white;
    }
    .category-attr-btn i {
        font-size: 14px;
    }
    .attr-fields-container {
        background: #f8f9fa;
        padding: 0;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
        margin-top: 15px;
        display: none;
        overflow: hidden;
    }
    .attr-fields-container.show {
        display: block !important;
        animation: slideDown 0.4s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); max-height: 0; }
        to { opacity: 1; transform: translateY(0); max-height: 2000px; }
    }
    .attr-fields-container .attr-header {
        background: #e9ecef;
        font-weight: 600;
        padding: 10px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .attr-fields-container .attr-body {
        padding: 15px;
    }
    .attr-btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 15px 0;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid #eef2f6;
    }
    .attr-btn-group .category-attr-btn {
        flex: 0 1 auto;
    }
    .form-label-sm {
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 4px;
        display: block;
        color: #495057;
    }
    .form-control-sm {
        font-size: 13px;
    }
</style>

<div class="container">
    <div class="row" style="margin-left:200px;"> 
        <div class="col-12">
            <div class="form-section">
                <div class="form-section-header">
                    <i class="fas fa-plus-circle me-2 text-primary"></i> Add New Product
                </div>
                <div class="form-section-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="row">
                            <!-- LEFT COLUMN (8 columns) -->
                            <div class="col-md-8">
                                <!-- Basic Information Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Basic Information</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Product Name <span class="required-star">*</span></label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label>Top Category <span class="required-star">*</span></label>
                                                <select name="top_category_id" id="top_category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($topCategories as $tc)
                                                        <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Category <span class="required-star">*</span></label>
                                                <select name="category_id" id="category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Sub Category <span class="required-star">*</span></label>
                                                <select name="sub_category_id" id="sub_category" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach($subCategories as $sub)
                                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Brand</label>
                                                <select name="brand_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($brands as $b)
                                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Product Type</label>
                                                <select name="product_type_id" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    @foreach($productTypes as $pt)
                                                        <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- ✅ NEW: Size Chart ID Field -->
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label>Size Chart</label>
                                                <select name="size_chart_id" class="form-control">
                                                    <option value="">-- Select Size Chart --</option>
                                                    @foreach($sizeCharts ?? [] as $sc)
                                                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted">Select a size chart for this product</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Category Attributes -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <i class="fas fa-cog me-2 text-primary"></i> Product Attributes
                                        <small class="text-muted ms-2">Select one category to see relevant attributes</small>
                                    </div>
                                    <div class="card-body">
                                        <!-- Attribute Buttons -->
                                        <div class="attr-btn-group">
                                            <button type="button" class="category-attr-btn" data-attr="dress">
                                                <i class="fas fa-tshirt"></i> Dress
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="equipment">
                                                <i class="fas fa-dumbbell"></i> Equipment
                                            </button>
                                            <button type="button" class="category-attr-btn" data-attr="supplements">
                                                <i class="fas fa-flask"></i> Supplements
                                            </button>
                                        </div>

                                        <!-- Dress Attributes -->
                                        <div id="dress_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-tshirt me-2"></i> Dress Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Size <span class="required-star">*</span></label>
                                                        <select name="attributes[dress][size]" class="form-control form-control-sm">
                                                            <option value="">Select Size</option>
                                                            <option value="XS">XS</option>
                                                            <option value="S">S</option>
                                                            <option value="M">M</option>
                                                            <option value="L">L</option>
                                                            <option value="XL">XL</option>
                                                            <option value="XXL">XXL</option>
                                                            <option value="XXXL">XXXL</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Material</label>
                                                        <select name="attributes[dress][material]" class="form-control form-control-sm">
                                                            <option value="">Select Material</option>
                                                            <option value="Cotton">Cotton</option>
                                                            <option value="Polyester">Polyester</option>
                                                            <option value="Linen">Linen</option>
                                                            <option value="Silk">Silk</option>
                                                            <option value="Spandex">Spandex</option>
                                                            <option value="Wool">Wool</option>
                                                            <option value="Denim">Denim</option>
                                                            <option value="Leather">Leather</option>
                                                            <option value="Nylon">Nylon</option>
                                                            <option value="Rayon">Rayon</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Sleeve Type</label>
                                                        <select name="attributes[dress][sleeve]" class="form-control form-control-sm">
                                                            <option value="">Select Sleeve</option>
                                                            <option value="Full Sleeve">Full Sleeve</option>
                                                            <option value="Half Sleeve">Half Sleeve</option>
                                                            <option value="Sleeveless">Sleeveless</option>
                                                            <option value="Rolled Up">Rolled Up</option>
                                                            <option value="Cap Sleeve">Cap Sleeve</option>
                                                            <option value="Three Quarter">Three Quarter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Fit Type</label>
                                                        <select name="attributes[dress][fit]" class="form-control form-control-sm">
                                                            <option value="">Select Fit</option>
                                                            <option value="Regular">Regular</option>
                                                            <option value="Slim">Slim</option>
                                                            <option value="Oversized">Oversized</option>
                                                            <option value="Relaxed">Relaxed</option>
                                                            <option value="Athletic">Athletic</option>
                                                            <option value="Compression">Compression</option>
                                                            <option value="Loose">Loose</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color</label>
                                                        <input type="text" name="attributes[dress][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red, Blue">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Gender</label>
                                                        <select name="attributes[dress][gender]" class="form-control form-control-sm">
                                                            <option value="Men">Men</option>
                                                            <option value="Women">Women</option>
                                                            <option value="Unisex">Unisex</option>
                                                            <option value="Kids">Kids</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Pattern</label>
                                                        <select name="attributes[dress][pattern]" class="form-control form-control-sm">
                                                            <option value="">Select Pattern</option>
                                                            <option value="Solid">Solid</option>
                                                            <option value="Striped">Striped</option>
                                                            <option value="Checked">Checked</option>
                                                            <option value="Printed">Printed</option>
                                                            <option value="Camouflage">Camouflage</option>
                                                            <option value="Floral">Floral</option>
                                                            <option value="Polka Dot">Polka Dot</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Neck Type</label>
                                                        <select name="attributes[dress][neck]" class="form-control form-control-sm">
                                                            <option value="">Select Neck</option>
                                                            <option value="Round Neck">Round Neck</option>
                                                            <option value="V-Neck">V-Neck</option>
                                                            <option value="Collar">Collar</option>
                                                            <option value="Turtleneck">Turtleneck</option>
                                                            <option value="Scoop">Scoop</option>
                                                            <option value="Sweetheart">Sweetheart</option>
                                                            <option value="Halter">Halter</option>
                                                            <option value="Off Shoulder">Off Shoulder</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Equipment Attributes -->
                                        <div id="equipment_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-dumbbell me-2"></i> Equipment Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Weight Capacity (kg)</label>
                                                        <input type="number" name="attributes[equipment][weight_capacity]" class="form-control form-control-sm" min="0" placeholder="Max weight in kg">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Material</label>
                                                        <select name="attributes[equipment][material]" class="form-control form-control-sm">
                                                            <option value="">Select Material</option>
                                                            <option value="Steel">Steel</option>
                                                            <option value="Cast Iron">Cast Iron</option>
                                                            <option value="Rubber">Rubber</option>
                                                            <option value="Plastic">Plastic</option>
                                                            <option value="Wood">Wood</option>
                                                            <option value="Aluminium">Aluminium</option>
                                                            <option value="Chrome">Chrome</option>
                                                            <option value="PVC">PVC</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Dimensions (cm)</label>
                                                        <input type="text" name="attributes[equipment][dimensions]" class="form-control form-control-sm" placeholder="e.g. 50x30x20 cm">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Warranty (Months)</label>
                                                        <input type="number" name="attributes[equipment][warranty]" class="form-control form-control-sm" value="12" min="0">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Assembly Required</label>
                                                        <select name="attributes[equipment][assembly]" class="form-control form-control-sm">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="Professional">Professional Installation</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Usage Type</label>
                                                        <select name="attributes[equipment][usage]" class="form-control form-control-sm">
                                                            <option value="">Select Usage</option>
                                                            <option value="Commercial">Commercial</option>
                                                            <option value="Home">Home</option>
                                                            <option value="Both">Both</option>
                                                            <option value="Professional">Professional</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Color</label>
                                                        <input type="text" name="attributes[equipment][color]" class="form-control form-control-sm" placeholder="e.g. Black, Red">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Product Weight (kg)</label>
                                                        <input type="number" step="0.01" name="attributes[equipment][product_weight]" class="form-control form-control-sm" min="0" placeholder="Weight of product">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Additional Features</label>
                                                        <input type="text" name="attributes[equipment][features]" class="form-control form-control-sm" placeholder="e.g. Adjustable, Foldable, Portable">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Supplements Attributes -->
                                        <div id="supplements_attrs" class="attr-fields-container">
                                            <div class="attr-header"><i class="fas fa-flask me-2"></i> Supplement Attributes</div>
                                            <div class="attr-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Weight (kg/gm) <span class="required-star">*</span></label>
                                                        <select name="attributes[supplements][weight]" class="form-control form-control-sm">
                                                            <option value="">Select Weight</option>
                                                            <option value="250g">250g</option>
                                                            <option value="500g">500g</option>
                                                            <option value="750g">750g</option>
                                                            <option value="1kg">1kg</option>
                                                            <option value="2kg">2kg</option>
                                                            <option value="3kg">3kg</option>
                                                            <option value="5kg">5kg</option>
                                                            <option value="10kg">10kg</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Flavor</label>
                                                        <input type="text" name="attributes[supplements][flavor]" class="form-control form-control-sm" placeholder="e.g. Vanilla, Chocolate, Strawberry">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Serving Size</label>
                                                        <input type="text" name="attributes[supplements][serving_size]" class="form-control form-control-sm" placeholder="e.g. 1 scoop (30g)">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Servings Count</label>
                                                        <input type="number" name="attributes[supplements][servings_count]" class="form-control form-control-sm" value="0" min="0">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Expiry Date</label>
                                                        <input type="date" name="attributes[supplements][expiry]" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label-sm">Protein Type</label>
                                                        <select name="attributes[supplements][protein_type]" class="form-control form-control-sm">
                                                            <option value="">Select Type</option>
                                                            <option value="Whey">Whey Protein</option>
                                                            <option value="Casein">Casein</option>
                                                            <option value="Soy">Soy Protein</option>
                                                            <option value="Plant Protein">Plant Protein</option>
                                                            <option value="Mass Gainer">Mass Gainer</option>
                                                            <option value="BCAA">BCAA</option>
                                                            <option value="Creatine">Creatine</option>
                                                            <option value="Glutamine">Glutamine</option>
                                                            <option value="Pre-Workout">Pre-Workout</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Ingredients</label>
                                                        <textarea name="attributes[supplements][ingredients]" class="form-control form-control-sm" rows="2" placeholder="List of ingredients"></textarea>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Nutrition Facts</label>
                                                        <textarea name="attributes[supplements][nutrition]" class="form-control form-control-sm" rows="2" placeholder="Calories: 120, Protein: 24g, Carbs: 5g, Fat: 2g"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Usage Instructions</label>
                                                        <textarea name="attributes[supplements][usage]" class="form-control form-control-sm" rows="2" placeholder="How to use this supplement"></textarea>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label class="form-label-sm">Caution / Allergy</label>
                                                        <textarea name="attributes[supplements][caution]" class="form-control form-control-sm" rows="2" placeholder="Allergy warnings, storage instructions"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-2">
                                                        <label class="form-label-sm">Dietary</label>
                                                        <div class="d-flex flex-wrap gap-3">
                                                            <label class="me-2"><input type="checkbox" name="attributes[supplements][veg]" value="1"> Vegetarian</label>
                                                            <label class="me-2"><input type="checkbox" name="attributes[supplements][vegan]" value="1"> Vegan</label>
                                                            <label class="me-2"><input type="checkbox" name="attributes[supplements][gluten_free]" value="1"> Gluten-Free</label>
                                                            <label class="me-2"><input type="checkbox" name="attributes[supplements][keto]" value="1"> Keto</label>
                                                            <label><input type="checkbox" name="attributes[supplements][organic]" value="1"> Organic</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Description</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Short Description</label>
                                            <textarea name="short_description" class="form-control" rows="2" placeholder="Brief description for listing page"></textarea>
                                        </div>
                                        
                                        <!-- ✅ NEW: Description Title Field -->
                                        <div class="mb-3">
                                            <label>Description Title</label>
                                            <input type="text" name="description_title" class="form-control" placeholder="e.g. Product Features, Specifications">
                                            <small class="text-muted">Title for the description section</small>
                                        </div>

                                        <!-- ✅ NEW: Description Details Field -->
                                        <div class="mb-3">
                                            <label>Description Details</label>
                                            <textarea name="description_details" class="form-control" rows="4" placeholder="Detailed product description with features, specifications, etc."></textarea>
                                            <small class="text-muted">Detailed description of the product</small>
                                        </div>

                                        <div class="mb-3">
                                            <label>Full Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Detailed product description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN (4 columns) -->
                            <div class="col-md-4">
                                <!-- Pricing Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Pricing</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Price (₹) <span class="required-star">*</span></label>
                                            <input type="number" step="0.01" name="price" class="form-control" required min="0">
                                        </div>
                                        <div class="mb-3">
                                            <label>Discount Price (₹)</label>
                                            <input type="number" step="0.01" name="discount_price" class="form-control" min="0" placeholder="Sale price">
                                        </div>
                                        <div class="mb-3">
                                            <label>MRP (₹)</label>
                                            <input type="number" step="0.01" name="mrp" class="form-control" min="0" placeholder="Maximum retail price">
                                        </div>
                                        <div class="mb-3">
                                            <label>GST (%)</label>
                                            <select name="gst_percentage" class="form-control">
                                                <option value="0">0%</option>
                                                <option value="5">5%</option>
                                                <option value="12">12%</option>
                                                <option value="18" selected>18%</option>
                                                <option value="28">28%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inventory Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Inventory</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Stock Quantity <span class="required-star">*</span></label>
                                            <input type="number" name="stock" id="stock" class="form-control" value="0" min="0" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Min Stock Alert</label>
                                            <input type="number" name="min_stock_alert" class="form-control" value="5" min="0">
                                            <small class="text-muted">Notify when stock reaches this level</small>
                                        </div>
                                        <div class="mb-3">
                                            <label>Weight</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="weight" class="form-control" min="0" placeholder="0.5">
                                                <select name="weight_unit" class="form-control" style="width: 80px;">
                                                    <option value="kg">kg</option>
                                                    <option value="g">g</option>
                                                    <option value="lb">lb</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Dimensions</label>
                                            <input type="text" name="dimensions" class="form-control" placeholder="L × W × H cm">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Draft">Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Images Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Product Images</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="d-block">Product Images <span class="required-star">*</span> <span class="text-muted">(1 to 4 images)</span></label>
                                            <div class="image-upload-area" onclick="document.getElementById('product_images_input').click()">
                                                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                                <p class="mb-0">Click to upload images</p>
                                                <small class="text-muted">You can select 1 to 4 images</small>
                                            </div>
                                            <input type="file" id="product_images_input" name="images[]" class="form-control mt-2" accept="image/*" multiple style="display: block;" onchange="previewImages(this)">
                                            <div id="images_preview" class="image-preview-container mt-3"></div>
                                            <div id="image_count_warning" class="alert alert-warning mt-2" style="display: none; font-size: 12px; padding: 8px;">
                                                <i class="fas fa-exclamation-triangle me-1"></i> You can upload maximum 4 images. Please remove some images.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Video URL</label>
                                            <input type="url" name="video_url" class="form-control" placeholder="YouTube or Vimeo video link">
                                            <small class="text-muted">Add product demo video link</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Info Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Shipping Info</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Shipping Information</label>
                                            <textarea name="shipping_info" class="form-control" rows="3" placeholder="Shipping details, delivery time, shipping charges, etc."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Return & Warranty Card -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">Return & Warranty</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label>Return Days</label>
                                            <select name="return_days" class="form-control">
                                                <option value="7">7 Days</option>
                                                <option value="15">15 Days</option>
                                                <option value="30" selected>30 Days</option>
                                                <option value="0">Non-returnable</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Return Policy</label>
                                            <textarea name="return_policy" class="form-control" rows="2" placeholder="Return policy details"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Warranty (Months)</label>
                                            <input type="number" name="warranty_months" class="form-control" value="0" min="0">
                                            <small class="text-muted">0 = No warranty</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Save Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 ms-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // ========== ATTRIBUTE BUTTON TOGGLE - RADIO BUTTON BEHAVIOR ==========
        $('.category-attr-btn').on('click', function() {
            var attrName = $(this).data('attr');
            
            // Check if this button is already active
            var isActive = $(this).hasClass('active');
            
            // Remove active class from all buttons and hide all containers
            $('.category-attr-btn').removeClass('active');
            $('.attr-fields-container').removeClass('show');
            
            // If the clicked button was not active, activate it and show its container
            if (!isActive) {
                $(this).addClass('active');
                $('#' + attrName + '_attrs').addClass('show');
            }
        });

        // ========== CATEGORY CHANGE HANDLER ==========
        $('#category').on('change', function() {
            var catId = $(this).val();
            
            if (catId) {
                $.get('/admin/get-subcategories/' + catId, function(data) {
                    var subSelect = $('#sub_category');
                    subSelect.empty().append('<option value="">-- Select Sub Category --</option>');
                    $.each(data, function(i, sub) {
                        subSelect.append('<option value="' + sub.id + '">' + sub.name + '</option>');
                    });
                    $('select[name="product_type_id"]').empty().append('<option value="">-- Select Product Type --</option>');
                });
            }
        });

        // ========== DYNAMIC CATEGORY FILTERING ==========
        $('#top_category').on('change', function() {
            var topId = $(this).val();
            if (topId) {
                $.get('/admin/get-categories/' + topId, function(data) {
                    var categorySelect = $('#category');
                    categorySelect.empty().append('<option value="">-- Select Category --</option>');
                    $.each(data, function(i, cat) {
                        categorySelect.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                    });
                    $('#sub_category').empty().append('<option value="">-- Select Sub Category --</option>');
                    $('select[name="product_type_id"]').empty().append('<option value="">-- Select Product Type --</option>');
                });
            }
        });

        $('#sub_category').on('change', function() {
            var subId = $(this).val();
            if (subId) {
                $.get('/admin/get-producttypes/' + subId, function(data) {
                    var ptSelect = $('select[name="product_type_id"]');
                    ptSelect.empty().append('<option value="">-- Select Product Type --</option>');
                    $.each(data, function(i, pt) {
                        ptSelect.append('<option value="' + pt.id + '">' + pt.name + '</option>');
                    });
                });
            }
        });

        // ========== IMAGE FUNCTIONS ==========
        window.previewImages = function(input) {
            var files = Array.from(input.files);
            var totalFiles = window.imageFiles ? window.imageFiles.length + files.length : files.length;
            
            if (totalFiles > 4) {
                alert('You can upload maximum 4 images only. You have ' + totalFiles + ' images selected.');
                input.value = '';
                return;
            }
            
            if (!window.imageFiles) {
                window.imageFiles = [];
            }
            window.imageFiles = window.imageFiles.concat(files);
            updateImagePreview();
            checkImageCount();
        };

        function updateImagePreview() {
            var preview = $('#images_preview');
            preview.empty();
            
            if (!window.imageFiles || window.imageFiles.length === 0) return;
            
            window.imageFiles.forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.append(
                        '<div class="image-preview-item">' +
                            '<img src="' + e.target.result + '">' +
                            '<button type="button" class="remove-img" onclick="removeImage(' + index + ')">×</button>' +
                            '<span class="badge ' + (index === 0 ? 'bg-primary' : 'bg-secondary') + ' d-block text-center">' + (index === 0 ? 'Main Image' : 'Image ' + (index + 1)) + '</span>' +
                        '</div>'
                    );
                };
                reader.readAsDataURL(file);
            });
        }

        window.removeImage = function(index) {
            window.imageFiles.splice(index, 1);
            updateImagePreview();
            checkImageCount();
            
            var dataTransfer = new DataTransfer();
            for (var i = 0; i < window.imageFiles.length; i++) {
                dataTransfer.items.add(window.imageFiles[i]);
            }
            document.getElementById('product_images_input').files = dataTransfer.files;
        };
        
        function checkImageCount() {
            if (window.imageFiles && window.imageFiles.length > 4) {
                $('#image_count_warning').show();
            } else {
                $('#image_count_warning').hide();
            }
        }

        // ========== FORM SUBMIT HANDLER ==========
        $('#productForm').on('submit', function(e) {
            var stock = parseInt($('#stock').val());
            if (isNaN(stock) || stock < 0) {
                e.preventDefault();
                alert('Stock cannot be negative. Please enter 0 or more.');
                return false;
            }
            
            if (!window.imageFiles || window.imageFiles.length === 0) {
                e.preventDefault();
                alert('Please upload at least 1 product image.');
                return false;
            }
            
            if (window.imageFiles.length > 4) {
                e.preventDefault();
                alert('Maximum 4 images allowed. Please remove some images.');
                return false;
            }
            
            var dataTransfer = new DataTransfer();
            for (var i = 0; i < window.imageFiles.length; i++) {
                dataTransfer.items.add(window.imageFiles[i]);
            }
            document.getElementById('product_images_input').files = dataTransfer.files;
            
            return true;
        });
    });
</script>
@endsection