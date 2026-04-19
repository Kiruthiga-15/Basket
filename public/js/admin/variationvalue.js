document.addEventListener('DOMContentLoaded', function () {

    console.log("✅ variation value js loaded");

    /* =========================
    ELEMENTS
    ========================= */
    const form = document.getElementById('variationValueForm');
    const csrf = document.querySelector('input[name="_token"]').value;

    const table = document.getElementById('variationValueTable');
    const editId = document.getElementById('variation_value_edit_id');
    const submitBtn = form.querySelector('button[type="submit"]');

    const valueType = document.getElementById('valueType');
    const colorBox = document.getElementById('colorBox');

    const valueName = form.querySelector('input[name="value_name"]');
    const variationSelect = form.querySelector('select[name="variation_type_id"]');
    const colorInput = form.querySelector('input[name="color_code"]');

    let checkTimer = null;

    /* =========================
    INIT
    ========================= */
    submitBtn.disabled = true;
    colorInput.value = "#000000";

    /* =========================
    VALIDATION (FIXED)
    ========================= */
    function validateForm() {

        let name = valueName.value.trim();
        let type = variationSelect.value;
        let vtype = valueType.value;
        let color = colorInput.value;

        let ok = (name !== '' && type !== '');

        // if color type → must have valid hex
        if (vtype === 'color') {
            ok = ok && /^#([0-9A-Fa-f]{6})$/.test(color);
        }

        submitBtn.disabled = !ok;

        console.log("🧪 validateForm:", {
            name,
            type,
            vtype,
            color,
            ok
        });
    }
    /* =========================
    NAME → COLOR
    ========================= */
    function nameToColor(val) {

        const map = {
            red: "#ff0000",
            blue: "#0000ff",
            green: "#00ff00",
            black: "#000000",
            white: "#ffffff",
            yellow: "#ffff00",
            orange: "#ffa500",
            pink: "#ffc0cb",
            brown: "#8b4513",
            purple: "#800080"
        };

        val = val.toLowerCase().trim();

        if (map[val]) {
            colorInput.value = map[val];
        }
    }

    /* =========================
    COLOR → NAME (FIXED SAFE)
    ========================= */
    function colorToName(color) {

        try {
            if (typeof colorNamer !== 'undefined') {
                let res = colorNamer(color);

                if (res?.html?.length) {
                    valueName.value = res.html[0].name;
                }
            }
        } catch (e) {
            console.log("colorNamer error", e);
        }
    }

    /* =========================
    LIVE INPUTS (FIXED FLOW)
    ========================= */
    valueName.addEventListener('input', function () {
        nameToColor(this.value);
        validateForm();
        checkDuplicate();
    });

    variationSelect.addEventListener('change', function () {
        validateForm();
        checkDuplicate();
        toggleColorBox();
    });

    colorInput.addEventListener('input', function () {
        colorToName(this.value);
        validateForm();
    });

    colorInput.addEventListener('change', function () {
        colorToName(this.value);
        validateForm();
    });

    /* =========================
    VALUE TYPE TOGGLE (FIXED)
    ========================= */
    valueType.addEventListener('change', function () {
        toggleColorBox();
        validateForm();
    });

    function toggleColorBox() {

        let variationText =
            variationSelect.options[variationSelect.selectedIndex]?.text?.toLowerCase() || '';

        let valueTypeVal = valueType.value;

        if (variationText === 'color' && valueTypeVal === 'color') {
            colorBox.style.display = 'block';
        } else {
            colorBox.style.display = 'none';
        }

        console.log("🎨 toggleColorBox:", variationText, valueTypeVal);
    }

    /* =========================
    DUPLICATE CHECK
    ========================= */
    function checkDuplicate() {

        clearTimeout(checkTimer);

        checkTimer = setTimeout(() => {

            let name = valueName.value.trim();
            let type = variationSelect.value;
            let id = editId.value;

            if (!name || !type) return;

            fetch(`/admin/variation-value/check?variation_type_id=${type}&value_name=${name}&id=${id}`)
                .then(res => res.json())
                .then(data => {

                    if (data.exists) {
                        submitBtn.disabled = true;
                        showToast("Already exists", "error");
                    } else {
                        validateForm();
                    }

                });

        }, 300);
    }

    /* =========================
    SUBMIT (NO RELOAD SAFE)
    ========================= */
    form.addEventListener('submit', function (e) {

        e.preventDefault();

        submitBtn.disabled = true;
        submitBtn.innerText = 'Saving...';

        let id = editId.value;

        let url = id
            ? `/admin/variation-value/update/${id}`
            : `/admin/variation-value/store`;

        let formData = new FormData(form);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {

            submitBtn.disabled = false;
            submitBtn.innerText = 'Save Value';

            if (!data.status) {
                showToast(data.message, 'error');
                return;
            }

            let row = buildRow(data.data);

            if (id) {
                document.getElementById('vv_' + id).outerHTML = row;
            } else {
                table.insertAdjacentHTML('afterbegin', row);
            }

            form.reset();
            editId.value = '';
            colorBox.style.display = 'none';
            colorInput.value = "#000000";

            validateForm();
            showToast(data.message, 'success');

        });

    });

    /* =========================
    CLICK EVENTS (EDIT / DELETE / STATUS)
    ========================= */
    document.addEventListener('click', function (e) {

        /* EDIT */
        const editBtn = e.target.closest('.editValue');

        if (editBtn) {

            let id = editBtn.dataset.id;

            fetch(`/admin/variation-value/edit/${id}`)
                .then(res => res.json())
                .then(data => {

                    let r = data.data;

                    variationSelect.value = r.variation_type_id;
                    valueName.value = r.value_name;
                    valueType.value = r.value_type;
                    colorInput.value = r.color_code ?? '#000000';

                    editId.value = r.id;

                    toggleColorBox();

                    submitBtn.innerText = 'Update Value';

                    nameToColor(valueName.value);
                    colorToName(colorInput.value);

                    setTimeout(validateForm, 50);
                });
        }

        /* DELETE */
        const del = e.target.closest('.deleteValue');

        if (del) {

            let id = del.dataset.id;

            if (!confirm('Delete?')) return;

            fetch(`/admin/variation-value/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {
                    document.getElementById('vv_' + id)?.remove();
                    showToast(data.message, 'success');
                }

            });
        }

        /* STATUS */
        const toggle = e.target.closest('.valueStatusToggle');

        if (toggle) {

            console.log("clicked toggle");

            let id = toggle.dataset.id;

            fetch(`/admin/variation-value/status/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {
                    showToast(data.message || "Status updated", "success");
                } else {
                    showToast(data.message || "Error", "error");
                }

            })
            .catch(err => {
                console.log(err);
                showToast("Server error", "error");
            });
        }

    });

    /* =========================
    ROW BUILDER
    ========================= */
    function buildRow(row) {

        return `
        <tr id="vv_${row.id}">
            <td>${row.type?.name ?? ''}</td>
            <td>${row.value_name}</td>
            <td>${row.value_type}</td>
            <td>
                <div class="form-check form-switch">

                    <input
                        class="form-check-input valueStatusToggle"
                        type="checkbox"
                        data-id="${row.id}"
                        ${row.status ? 'checked' : ''}
                    >

                </div>
            </td>
            <td>
                <button class="editValue btn btn-primary btn-sm" data-id="${row.id}">Edit</button>
                <button class="deleteValue btn btn-danger btn-sm" data-id="${row.id}">Delete</button>
            </td>
        </tr>`;
    }

});