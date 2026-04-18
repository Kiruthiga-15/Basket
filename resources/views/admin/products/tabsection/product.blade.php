<!-- resources/views/admin/products/tabsection/product.blade.php -->

<div class="admin-box">

    <h4 class="mb-4">Create Product</h4>

    <div class="row g-3">

        <!-- Product Name -->
        <div class="col-md-6">
            <label class="form-label">Product Name</label>

            <input
                type="text"
                class="form-control"
                placeholder="Enter product name"
            >
        </div>

        <!-- Price -->
        <div class="col-md-6">
            <label class="form-label">Price</label>

            <input
                type="number"
                class="form-control"
                placeholder="Enter product price"
            >
        </div>

        <!-- Category -->
        <div class="col-md-6">
            <label class="form-label">Category</label>

            <select class="form-select">
                <option>Select Category</option>
            </select>
        </div>

        <!-- Variation -->
        <div class="col-md-6">
            <label class="form-label">Variation</label>

            <select class="form-select">
                <option>Select Variation</option>
            </select>
        </div>

        <!-- SKU -->
        <div class="col-md-6">
            <label class="form-label">SKU Code</label>

            <input
                type="text"
                class="form-control"
                placeholder="SKU12345"
            >
        </div>

        <!-- Stock -->
        <div class="col-md-6">
            <label class="form-label">Stock Quantity</label>

            <input
                type="number"
                class="form-control"
                placeholder="Enter stock quantity"
            >
        </div>

        <!-- Delivery Charge -->
        <div class="col-md-6">
            <label class="form-label">Delivery Charge</label>

            <input
                type="number"
                class="form-control"
                placeholder="Enter delivery charge"
            >
        </div>

        <!-- Discount Type -->
        <div class="col-md-3">
            <label class="form-label">Discount Type</label>

            <select class="form-select">
                <option value="">Select</option>
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed</option>
            </select>
        </div>

        <!-- Discount Value -->
        <div class="col-md-3">
            <label class="form-label">Discount Value</label>

            <input
                type="number"
                class="form-control"
                placeholder="Enter discount"
            >
        </div>

        <!-- Main Image -->
        <div class="col-md-6">
            <label class="form-label">Main Image</label>

            <input
                type="file"
                class="form-control"
            >
        </div>

        <!-- Gallery -->
        <div class="col-md-6">
            <label class="form-label">Gallery Images</label>

            <input
                type="file"
                class="form-control"
                multiple
            >
        </div>

        <!-- Short Description -->
        <div class="col-12">
            <label class="form-label">Short Description</label>

            <textarea
                class="form-control"
                rows="3"
                placeholder="Enter short description"
            ></textarea>
        </div>

        <!-- Long Description -->
        <div class="col-12">
            <label class="form-label">Long Description</label>

            <textarea
                class="form-control"
                rows="6"
                placeholder="Enter long description"
            ></textarea>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex gap-2 flex-wrap">

            <button class="btn btn-dark">
                Save Product
            </button>

            <button class="btn btn-outline-dark">
                Reset
            </button>

        </div>

    </div>

</div>