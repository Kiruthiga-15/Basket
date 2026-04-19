document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('variationTypeForm');
    const table = document.getElementById('variationTypeTable');
    const csrf = document.querySelector('input[name="_token"]').value;

    const nameInput = form.querySelector('input[name="name"]');
    const statusInput = form.querySelector('select[name="status"]');
    const submitBtn = form.querySelector('button[type="submit"]');
    const editId = document.getElementById('variation_edit_id');

    /* =========================
    INIT
    ========================= */
    submitBtn.disabled = true;

    function validateForm() {

        let name = nameInput.value.trim();

        if (name.length > 0) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    nameInput.addEventListener('input', validateForm);


    /* =========================
    SUBMIT
    ========================= */
    form.addEventListener('submit', function (e) {

        e.preventDefault();

        submitBtn.disabled = true;
        submitBtn.innerText = 'Saving...';

        let id = editId.value;

        let url = '/admin/variation-type/store';

        if (id) {
            url = '/admin/variation-type/update/' + id;
        }

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

            if (data.status) {

                if (id) {

                    document.getElementById('vt_' + id).outerHTML =
                        buildRow(data.data);

                } else {

                    table.insertAdjacentHTML('afterbegin', buildRow(data.data));
                }

                showToast(data.message, 'success');

                form.reset();
                editId.value = '';

            } else {

                // 👇 duplicate error handling
                showToast(data.message || 'Already exists', 'error');
            }

            submitBtn.innerText = 'Save Variation Name';
            validateForm();

        })
        .catch(() => {

            showToast('Server Error', 'error');

            submitBtn.innerText = 'Save Variation Name';
            validateForm();

        });

    });


    /* =========================
    CLICK EVENTS
    ========================= */
    document.addEventListener('click', function (e) {

        /* EDIT */
        if (e.target.classList.contains('editVariation')) {

            let id = e.target.dataset.id;

            fetch('/admin/variation-type/edit/' + id)
            .then(res => res.json())
            .then(data => {

                nameInput.value = data.data.name;
                statusInput.value = data.data.status;
                editId.value = data.data.id;

                submitBtn.innerText = 'Update Variation';

                validateForm();

            });

        }


        /* DELETE */
        if (e.target.classList.contains('deleteVariation')) {

            let id = e.target.dataset.id;

            if (!confirm('Delete this variation?')) return;

            fetch('/admin/variation-type/delete/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {

                    document.getElementById('vt_' + id).remove();

                    showToast(data.message, 'success');
                }

            });

        }


        /* STATUS */
        if (e.target.classList.contains('statusToggle')) {

            let id = e.target.dataset.id;

            fetch('/admin/variation-type/status/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                showToast(data.message, 'success');

            });

        }

    });


    /* =========================
    ROW BUILDER
    ========================= */
    function buildRow(row)
    {
        return `
        <tr id="vt_${row.id}">

            <td>${row.name}</td>

            <td>
                <div class="form-check form-switch">

                    <input
                        class="form-check-input statusToggle"
                        type="checkbox"
                        data-id="${row.id}"
                        ${row.status == 1 ? 'checked' : ''}
                    >

                </div>
            </td>

            <td>

                <button class="btn btn-sm btn-primary editVariation" data-id="${row.id}">
                    Edit
                </button>

                <button class="btn btn-sm btn-danger deleteVariation" data-id="${row.id}">
                    Delete
                </button>

            </td>

        </tr>
        `;
    }

});