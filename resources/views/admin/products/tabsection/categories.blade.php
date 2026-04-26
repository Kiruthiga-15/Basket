<!-- resources/views/admin/products/tabsection/categories.blade.php -->

<div class="admin-box">

    <h4 class="mb-4">Create Category</h4>

    <form id="categoryForm" enctype="multipart/form-data">

        @csrf
        <!-- hidden field inside form -->

        <input
            type="hidden"
            name="edit_id"
            id="edit_id"
        >
        <div class="row g-3">

            <!-- Category Name -->
            <div class="col-md-6">
                <label class="form-label">Category Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Enter category name"
                >
            </div>

            <!-- Category Image -->
            <div class="col-md-6">
                <label class="form-label">Category Image</label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                >
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label">Status</label>

                <select
                    name="status"
                    class="form-select"
                >
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <!-- Description -->
            <div class="col-12">
                <label class="form-label">Description</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                    placeholder="Enter category description"
                ></textarea>
            </div>

            <!-- Button -->
            <div class="col-12">

                <button
                    type="submit"
                    class="btn btn-dark"
                >
                    Save Category
                </button>

            </div>

        </div>

    </form>

</div>



<!-- ===============================
CATEGORY TABLE
=============================== -->
<div class="admin-box mt-4">

    <h4 class="mb-3">Category List</h4>

    <div class="table-responsive">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>
                    <th width="30%">Name</th>
                    <th width="20%">Image</th>
                    <th width="20%">Status</th>
                    <th width="30%">Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($categories as $row)

                <tr>

                    <!-- Name -->
                    <td>
                        {{ $row->getName() }}
                    </td>

                    <!-- Image -->
                    <td>

                        @if($row->getImage())

                            <img
                                src="{{ asset('storage/'.$row->image) }}"
                                width="60"
                                height="60"
                                style="object-fit:cover;border-radius:8px;"
                            >

                        @else

                            No Image

                        @endif

                    </td>

                    <!-- Status -->
                    <td id="status_col_{{ $row->id }}">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input statusToggle"
                                type="checkbox"
                                data-id="{{ $row->id }}"
                                {{ $row->status == 1 ? 'checked' : '' }}
                            >

                        </div>

                    </td>

                    <!-- Action -->
                    <td>

                        <button class="btn btn-sm btn-primary categoryeditBtn" data-id="{{ $row->id }}">
                            Edit
                        </button>

                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $row->id }}">
                            Delete
                        </button>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center">
                        No Categories Found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



