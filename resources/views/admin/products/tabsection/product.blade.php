<!-- resources/views/admin/products/tabsection/product.blade.php -->

<div class="admin-box">

    <h4 class="mb-4">
        Create Product
    </h4>

    <form
        id="productForm"
        enctype="multipart/form-data"
    >
        @csrf

        <input
            type="hidden"
            name="edit_id"
            id="edit_id"
        >

        <div class="row g-3">

            <!-- Product Name -->
            <div class="col-md-4">
                <label class="form-label">
                    Product Name
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Enter product name"
                >
            </div>

            <!-- Price -->
            <div class="col-md-4">
                <label class="form-label">
                    Price
                </label>

                <input
                    type="number"
                    name="price"
                    class="form-control"
                >
            </div>

            <!-- Category -->
            <div class="col-md-4">
                <label class="form-label">
                    Category
                </label>

                <select
                    name="category_id"
                    class="form-select"
                >
                    <option value="">
                        Select Category
                    </option>

                    @foreach($categories as $row)
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                    @endforeach
                </select>
            </div>


            <!-- Variation Type 1 -->
            <div class="col-md-3">
                <label class="form-label">
                    Variation Type 1
                </label>

                <select
                    name="variation_type_size_id"
                    class="form-select variationType"
                >
                    <option value="">
                        Select Type
                    </option>

                    @foreach($variationTypes as $row)
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Variation Value 1 -->
            <div class="col-md-3">
                <label class="form-label">
                    Variation Value 1
                </label>

                <select
                    name="variation_value_size_id"
                    class="form-select variationValue"
                >
                    <option value="">
                        Select Value
                    </option>

                    @foreach($variationValues as $row)
                        <option
                            value="{{ $row->id }}"
                            data-type="{{ strtolower($row->type->name ?? '') }}"
                        >
                            {{ $row->value_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Variation Type 2 -->
            <div class="col-md-3">
                <label class="form-label">
                    Variation Type 2
                </label>

                <select
                    name="variation_type_color_id"
                    class="form-select variationType"
                >
                    <option value="">
                        Select Type
                    </option>

                    @foreach($variationTypes as $row)
                    <option value="{{ $row->id }}">
                        {{ $row->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Variation Value 2 -->
            <div class="col-md-3">
                <label class="form-label">
                    Variation Value 2
                </label>

                <select
                    name="variation_value_color_id"
                    class="form-select variationValue"
                >
                    <option value="">
                        Select Value
                    </option>

                    @foreach($variationValues as $row)
                        <option
                            value="{{ $row->id }}"
                            data-type="{{ strtolower($row->type->name ?? '') }}"
                        >
                            {{ $row->value_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- SKU -->
            <div class="col-md-4">
                <label class="form-label">
                    SKU
                </label>

                <input
                    type="text"
                    name="sku"
                    class="form-control"
                >
            </div>

            <!-- Stock -->
            <div class="col-md-4">
                <label class="form-label">
                    Stock
                </label>

                <input
                    type="number"
                    name="stock"
                    class="form-control"
                >
            </div>

            <!-- Delivery Charge -->
            <div class="col-md-4">
                <label class="form-label">
                    Delivery Charge
                </label>

                <input
                    type="number"
                    name="delivery_charge"
                    class="form-control"
                >
            </div>


            <!-- Discount Type -->
            <div class="col-md-4">
                <label class="form-label">
                    Discount Type
                </label>

                <select
                    name="discount_type"
                    class="form-select"
                >
                    <option value="">
                        Select
                    </option>

                    <option value="percentage">
                        Percentage
                    </option>

                    <option value="fixed">
                        Fixed
                    </option>
                </select>
            </div>

            <!-- Discount Value -->
            <div class="col-md-4">
                <label class="form-label">
                    Discount Value
                </label>

                <input
                    type="number"
                    name="discount_value"
                    class="form-control"
                >
            </div>

            <!-- Final Price -->
            <div class="col-md-4">
                <label class="form-label">
                    Final Price
                </label>

                <input
                    type="text"
                    name="discount_price"
                    id="discountPrice"
                    class="form-control bg-light"
                    readonly
                >
            </div>


            <!-- Main Image -->
            <div class="col-md-6">
                <label class="form-label">
                    Main Image
                </label>

                <input
                    type="file"
                    name="main_image"
                    class="form-control"
                >

                <div id="imagePreview" class="mt-2"></div>
            </div>

            <!-- Gallery -->
            <div class="col-md-6">
                <label class="form-label">
                    Gallery Images
                </label>

                <input
                    type="file"
                    name="gallery[]"
                    multiple
                    class="form-control"
                >
                <div
                    id="galleryPreview"
                    class="mt-2 d-flex flex-wrap"
                ></div>
            </div>


            <!-- Short Description -->
            <div class="col-12">
                <label class="form-label">
                    Short Description
                </label>

                <textarea
                    name="short_description"
                    rows="3"
                    class="form-control"
                ></textarea>
            </div>

            <!-- Long Description -->
            <div class="col-12">
                <label class="form-label">
                    Long Description
                </label>

                <textarea
                    name="long_description"
                    rows="5"
                    class="form-control"
                ></textarea>
            </div>


            <!-- Status -->
            <div class="col-md-4">
                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="form-select"
                >
                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>
                </select>
            </div>


            <!-- Buttons -->
            <div class="col-12 mt-3">

                <button
                    type="submit"
                    class="btn btn-dark"
                >
                    Save Product
                </button>

                <button
                    type="reset"
                    class="btn btn-outline-dark"
                >
                    Reset
                </button>

            </div>

        </div>

    </form>

</div>


<!-- ===================================
PRODUCT LIST TABLE
=================================== -->
<div class="admin-box mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="mb-0">
            Product List
        </h4>

        <small class="text-muted">
            Horizontal Scroll Enabled
        </small>

    </div>

    <div class="table-responsive">

        <table
            class="table table-bordered table-hover align-middle text-nowrap"
            id="productTable"
            style="min-width:1800px;"
        >

            <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Main Image</th>

                    <th>Name</th>

                    <th>Category</th>

                    <th>Price</th>

                    <th>Final Price</th>

                    <th>SKU</th>

                    <th>Stock</th>

                    <th>Size</th>

                    <th>Color</th>

                    <th>Delivery</th>

                    <th>Status</th>

                    <th>Created</th>

                    <th width="180">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody id="productTableBody">

                @forelse($products ?? [] as $row)

                <tr id="row_{{ $row->id }}">

                    <td>
                        {{ $row->id }}
                    </td>

                    <td>
                        @if($row->main_image)

                        <img
                            src="{{ asset('storage/'.$row->main_image) }}"
                            width="55"
                            height="55"
                            style="
                                object-fit:cover;
                                border-radius:8px;
                            "
                        >

                        @endif
                    </td>

                    <td>
                        {{ $row->name }}
                    </td>

                    <td>
                        {{ $row->category->name ?? '-' }}
                    </td>

                    <td>
                        ₹{{ $row->price }}
                    </td>

                    <td>
                        ₹{{ $row->discount_price }}
                    </td>

                    <td>
                        {{ $row->sku }}
                    </td>

                    <td>
                        {{ $row->stock }}
                    </td>

                    <td>
                        {{ $row->sizeValue->value_name ?? '-' }}
                    </td>

                    <td>
                        {{ $row->colorValue->value_name ?? '-' }}
                    </td>

                    <td>
                        ₹{{ $row->delivery_charge }}
                    </td>

                    <td>

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input productStatusToggle"
                                type="checkbox"
                                data-id="{{ $row->id }}"
                                {{ $row->status == 1 ? 'checked' : '' }}
                            >

                        </div>

                    </td>

                    <td>
                        {{ $row->created_at->format('d-m-Y') }}
                    </td>

                    <td>

                        <button
                            class="btn btn-sm btn-primary producteditBtn"
                            data-id="{{ $row->id }}"
                        >
                            Edit
                        </button>

                        <button
                            class="btn btn-sm btn-danger deleteBtn"
                            data-id="{{ $row->id }}"
                        >
                            Delete
                        </button>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="14"
                        class="text-center text-muted"
                    >
                        No Products Found
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>