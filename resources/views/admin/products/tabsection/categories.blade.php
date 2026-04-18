<!-- resources/views/admin/products/tabsection/categories.blade.php -->

<div class="admin-box">

    <h4 class="mb-4">Create Category</h4>

    <div class="row g-3">

        <!-- Category Name -->
        <div class="col-md-6">
            <label class="form-label">Category Name</label>

            <input
                type="text"
                class="form-control"
                placeholder="Enter category name"
            >
        </div>

        <!-- Category Image -->
        <div class="col-md-6">
            <label class="form-label">Category Image</label>

            <input
                type="file"
                class="form-control"
            >
        </div>

        <!-- Description -->
        <div class="col-12">
            <label class="form-label">Description</label>

            <textarea
                class="form-control"
                rows="4"
                placeholder="Enter category description"
            ></textarea>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex gap-2 flex-wrap">

            <button class="btn btn-dark">
                Save Category
            </button>

            <button class="btn btn-outline-dark">
                Reset
            </button>

        </div>

    </div>

</div>