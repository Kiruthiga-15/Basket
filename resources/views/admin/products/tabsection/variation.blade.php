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

            <form id="variationValueForm">
                @csrf

                <input type="hidden" id="variation_value_edit_id">

                <div class="row g-3">

                    <!-- Variation Type -->
                    <div class="col-md-6">
                        <label>Variation Type</label>

                        <select name="variation_type_id" class="form-select">
                            <option value="">Select</option>

                            @foreach($variationTypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Value Type -->
                    <div class="col-md-6">
                        <label>Value Type</label>

                        <select name="value_type" id="valueType" class="form-select">
                            <option value="text">Text</option>
                            <option value="color">Color</option>
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6">
                        <input type="text" name="value_name" class="form-control" placeholder="Value Name">
                    </div>

                    <!-- Color -->
                    <div class="col-md-6" id="colorBox">
                        <input type="color" name="color_code" class="form-control form-control-color w-100">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Save -->
                    <div class="col-12">
                        <button class="btn btn-dark w-100" type="submit">
                            Save Value
                        </button>
                    </div>

                </div>
            </form>

            <div class="mt-4">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody id="variationValueTable">

                @foreach($variationValues as $row)

                <tr id="vv_{{ $row->id }}">

                    <td>{{ $row->type->name }}</td>
                    <td>{{ $row->value_name }}</td>
                    <td>{{ $row->value_type }}</td>

                    <td>
                        <div class="form-check form-switch">

                            <input
                                class="form-check-input valueStatusToggle"
                                type="checkbox"
                                data-id="{{ $row->id }}"
                                {{ $row->status == 1 ? 'checked' : '' }}
                            >

                        </div>
                    </td>

                    <td>
                        <button class="editValue btn btn-primary btn-sm" data-id="{{ $row->id }}">Edit</button>
                        <button class="deleteValue btn btn-danger btn-sm" data-id="{{ $row->id }}">Delete</button>
                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>


        </div>
    </div>

</div>