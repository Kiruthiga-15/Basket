function initCategory() {

    const form = document.getElementById('categoryForm');

    if (!form) {
            if (window.categoryInitDone) {
                validateForm();
                return;
            }
            window.categoryInitDone = true;
        return;
    }

    const tbody =
        document.querySelector(
            '.table tbody'
        );

    const submitBtn =
        form.querySelector(
            'button[type="submit"]'
        );

    const nameInput =
        form.querySelector(
            'input[name="name"]'
        );

    const imgInput =
        form.querySelector(
            'input[name="image"]'
        );

    const statusInput =
        form.querySelector(
            'select[name="status"]'
        );

    const descInput =
        form.querySelector(
            'textarea[name="description"]'
        );

    const editIdInput =
        document.getElementById(
            'edit_id'
        );

    const csrfToken =
        document.querySelector(
            'input[name="_token"]'
        ).value;


    /* =====================================
    INITIAL
    ===================================== */
    submitBtn.disabled = true;


    /* =====================================
    COMMON JSON RESPONSE
    ===================================== */
    async function getJsonResponse(response)
    {
        const text =
            await response.text();

        try {

            return JSON.parse(text);

        } catch (error) {

            console.log(text);

            throw new Error(
                'Invalid JSON Response'
            );
        }
    }


    /* =====================================
    VALIDATE FORM
    ===================================== */
    function validateForm()
    {
        let id =
            editIdInput.value;

        let nameOk =
            nameInput.value.trim() !== '';

        let imageOk =
            imgInput.files.length > 0;

        if (id) {
            imageOk = true;
        }

        submitBtn.disabled =
            !(nameOk && imageOk);

        submitBtn.innerText =
            id
            ? 'Update Category'
            : 'Save Category';
    }


    /* =====================================
    RESET FORM
    ===================================== */
    function resetForm()
    {
        form.reset();

        editIdInput.value = '';

        submitBtn.innerText =
            'Save Category';

        validateForm();
    }


    /* =====================================
    STATUS HTML
    ===================================== */
    function getStatusHtml(row)
    {
        return `
            <div class="form-check form-switch">

                <input
                    type="checkbox"
                    class="form-check-input statusToggle"
                    data-id="${row.id}"
                    ${row.status == 1 ? 'checked' : ''}
                >

            </div>
        `;
    }


    /* =====================================
    IMAGE HTML
    ===================================== */
    function getImageHtml(image)
    {
        if (image) {

            return `
                <img
                    src="/storage/${image}"
                    width="60"
                    height="60"
                    style="
                        object-fit:cover;
                        border-radius:8px;
                    "
                >
            `;
        }

        return 'No Image';
    }


    /* =====================================
    CREATE TABLE ROW
    ===================================== */
    function getRowHtml(row)
    {
        return `
            <tr id="row_${row.id}">

                <td>
                    ${row.name}
                </td>

                <td>
                    ${getImageHtml(row.image)}
                </td>

                <td>
                    ${getStatusHtml(row)}
                </td>

                <td>

                    <button
                        class="btn btn-sm btn-primary categoryeditBtn"
                        data-id="${row.id}"
                    >
                        Edit
                    </button>

                    <button
                        class="btn btn-sm btn-danger deleteBtn"
                        data-id="${row.id}"
                    >
                        Delete
                    </button>

                </td>

            </tr>
        `;
    }


    /* =====================================
    TOAST SAFE
    ===================================== */
    function toast(message, type)
    {
        if (
            typeof showToast !==
            'undefined'
        ) {

            showToast(
                message,
                type
            );

        } else {

            alert(message);
        }
    }


    /* =====================================
    INPUT EVENTS
    ===================================== */
    nameInput.addEventListener(
        'input',
        validateForm
    );

    imgInput.addEventListener(
        'change',
        validateForm
    );


    /* =====================================
    SUBMIT CREATE / UPDATE
    ===================================== */
    form.addEventListener(
        'submit',
        function (e) {

            e.preventDefault();

            submitBtn.disabled =
                true;

            let id =
                editIdInput.value;

            let url =
                '/admin/category/store';

            submitBtn.innerText =
                id
                ? 'Updating...'
                : 'Saving...';

            if (id) {

                url =
                    '/admin/category/update/' +
                    id;
            }

            let formData =
                new FormData(form);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN':
                        csrfToken,
                    'Accept':
                        'application/json'
                }
            })
            .then(async response => {
                const data = await getJsonResponse(response);

                if (!response.ok) {
                    let message = data.message || 'Request failed';
                    if (data.errors) {
                        message = Object.values(data.errors)
                            .flat()
                            .join(' ');
                    }
                    toast(message, 'error');
                    validateForm();
                    return;
                }

                if (data.status) {

                    if (id) {

                        let oldRow =
                            document.getElementById(
                                'row_' + id
                            );

                        if (oldRow) {

                            oldRow.outerHTML =
                                getRowHtml(
                                    data.data
                                );
                        }

                    } else {

                        tbody.insertAdjacentHTML(
                            'afterbegin',
                            getRowHtml(
                                data.data
                            )
                        );
                    }

                    toast(
                        data.message,
                        'success'
                    );

                    resetForm();

                } else {

                    toast(
                        data.message,
                        'error'
                    );

                    validateForm();
                }

            })
            .catch(error => {

                console.log(error);

                toast(
                    'Server Error',
                    'error'
                );

                validateForm();

            });

        }
    );


    /* =====================================
    EVENT DELEGATION
    EDIT / DELETE
    ===================================== */
    document.addEventListener(
        'click',
        function (e) {

            /* ==========================
            EDIT
            ========================== */
            if (
                e.target.classList.contains(
                    'categoryeditBtn'
                )
            ) {

                let id =
                    e.target.dataset.id;

                fetch(
                    '/admin/category/edit/' +
                    id,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                )
                .then(getJsonResponse)
                .then(data => {

                    if (!data.status) {

                        toast(
                            'Data not found',
                            'error'
                        );

                        return;
                    }

                    nameInput.value =
                        data.data.name;

                    descInput.value =
                        data.data.description ??
                        '';

                    statusInput.value =
                        data.data.status;

                    editIdInput.value =
                        data.data.id;

                    imgInput.value = '';

                    validateForm();

                    window.scrollTo({
                        top: 0,
                        behavior:
                            'smooth'
                    });

                })
                .catch(error => {

                    console.log(error);

                    toast(
                        'Edit load failed',
                        'error'
                    );

                });
            }

            
            if (
                e.target.classList.contains('statusToggle')
            ) {

                let id =
                    e.target.dataset.id;

                fetch(
                    '/admin/category/status/' + id,
                    {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    }
                ) 
                .then(getJsonResponse)
                .then(data => {

                    if (data.status) {

                        toast(
                            data.message,
                            'success'
                        );

                    } else {

                        toast(
                            'Failed',
                            'error'
                        );
                    }

                })
                    .catch(error => {

                    console.log(error);

                    toast(
                        'Status Update Failed',
                        'error'
                    );

                });
            }
            
            /* ==========================
            DELETE
            ========================== */
            if (
                e.target.closest('.deleteBtn')
            ) {

                const deleteBtn = e.target.closest('.deleteBtn');

                let id =
                    deleteBtn.dataset.id;

                let ok =
                    confirm(
                        'Delete this category?'
                    );

                if (!ok) {
                    return;
                }

                fetch(
                    '/admin/category/delete/' +
                    id,
                    {
                        method:
                            'DELETE',
                        headers: {
                            'X-CSRF-TOKEN':
                                csrfToken,
                            'Accept':
                                'application/json'
                        }
                    }
                )
                .then(getJsonResponse)
                .then(data => {

                    if (data.status) {

                        let row =
                            document.getElementById(
                                'row_' + id
                            );
                        if (row) {
                            row.remove();
                        }

                        toast(
                            data.message,
                            'success'
                        );

                    } else {

                        toast(
                            data.message,
                            'error'
                        );
                    }

                })
                .catch(error => {

                    console.log(error);

                    toast(
                        'Delete failed',
                        'error'
                    );

                });
            }

        }
    );


    /* =====================================
    FIRST LOAD
    ===================================== */
    validateForm();

}