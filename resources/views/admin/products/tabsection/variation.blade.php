<!-- resources/views/admin/products/tabsection/variation.blade.php -->

<div class="row g-4">

    <!-- ===================================
    LEFT SIDE : VARIATION NAME
    ==================================== -->
    <div class="col-lg-5">

        <div class="admin-box h-100">

            <h4 class="mb-4">Variation Names</h4>

            <form id="variationTypeForm">

                @csrf

                <input type="hidden" id="variation_edit_id">

                <div class="row g-3">

                    <!-- Variation Name -->
                    <div class="col-12">
                        <label class="form-label">Variation Name</label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="Ex: Color / Size / Material"
                        >
                    </div>

                    <!-- Status -->
                    <div class="col-12">
                        <label class="form-label">Status</label>

                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Save -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark w-100">
                            Save Variation Name
                        </button>
                    </div>

                </div>

            </form>

            <!-- ===================================
            TABLE FROM DB
            ==================================== -->
            <div class="mt-4">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th width="30%">Action</th>
                            </tr>
                        </thead>

                        <tbody id="variationTypeTable">

                            @foreach($variationTypes as $row)

                            <tr id="vt_{{ $row->id }}">

                                <td>{{ $row->name }}</td>

                                <td>

                                    <div class="form-check form-switch">

                                        <input
                                            class="form-check-input statusToggle"
                                            type="checkbox"
                                            data-id="{{ $row->id }}"
                                            {{ $row->status == 1 ? 'checked' : '' }}
                                        >

                                    </div>

                                </td>

                                <td>

                                    <button
                                        class="btn btn-sm btn-primary editVariation"
                                        data-id="{{ $row->id }}"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        class="btn btn-sm btn-danger deleteVariation"
                                        data-id="{{ $row->id }}"
                                    >
                                        Delete
                                    </button>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================
    RIGHT SIDE : VARIATION VALUES
    ==================================== -->
    <div class="col-lg-7">

        <div class="admin-box h-100">

            <h4 class="mb-4">Variation Values</h4>

            <div class="row g-3">

                <!-- Select Variation -->
                <div class="col-md-6">
                    <label class="form-label">Select Variation</label>

                    <select class="form-select">
                        <option>Select Variation Name</option>
                        <option>Color</option>
                        <option>Size</option>
                        <option>Storage</option>
                    </select>
                </div>

                <!-- Input Type -->
                <div class="col-md-6">
                    <label class="form-label">Value Type</label>

                    <select class="form-select">
                        <option>Select Type</option>
                        <option>Text</option>
                        <option>Color Picker</option>
                    </select>
                </div>

                <!-- Text Value -->
                <div class="col-md-6">
                    <label class="form-label">Value Name</label>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Ex: Large / Small / 128GB"
                    >
                </div>

                <!-- Color -->
                <div class="col-md-6">
                    <label class="form-label">Choose Color</label>

                    <input
                        type="color"
                        class="form-control form-control-color w-100"
                        value="#000000"
                    >
                </div>

                <!-- Hint -->
                <div class="col-12">

                    <small class="text-muted">
                        Size Example:
                        S (Small), M (Medium), L (Large)
                    </small>

                </div>

                <!-- Save -->
                <div class="col-12">

                    <button class="btn btn-dark">
                        Save Variation Value
                    </button>

                </div>

                <!-- Existing Values -->
                <div class="col-12">

                    <div class="border rounded p-3 bg-light">

                        <strong class="d-block mb-2">
                            Added Values
                        </strong>

                        <span class="badge bg-secondary me-2 mb-2">
                            Red
                        </span>

                        <span class="badge bg-secondary me-2 mb-2">
                            Blue
                        </span>

                        <span class="badge bg-secondary me-2 mb-2">
                            Large
                        </span>

                        <span class="badge bg-secondary me-2 mb-2">
                            Small
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>