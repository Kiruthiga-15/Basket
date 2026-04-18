document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('categoryForm');
    const btn = form.querySelector('button[type="submit"]');

    const nameInput = form.querySelector('input[name="name"]');
    const imgInput = form.querySelector('input[name="image"]');

    btn.disabled = true;

    /* ==========================
    VALIDATE
    ========================== */
    function validateForm() {

        let editId = document.getElementById('edit_id').value;

        let nameOk = nameInput.value.trim() !== '';

        let imageOk = imgInput.files.length > 0;

        if (editId) {
            imageOk = true;
        }

        btn.disabled = !(nameOk && imageOk);

    }

    nameInput.addEventListener('input', validateForm);
    imgInput.addEventListener('change', validateForm);

    /* ==========================
    SUBMIT
    ========================== */
    form.addEventListener('submit', function (e) {

        e.preventDefault();

        btn.disabled = true;
        btn.innerText = 'Saving...';

        let id = document.getElementById('edit_id').value;

        let url = '/admin/category/store';

        if (id) {
            url = '/admin/category/update/' + id;
        }

        let formData = new FormData(form);

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN':
                    document.querySelector(
                        'input[name="_token"]'
                    ).value
            }
        })
        .then(res => res.json())
        .then(data => {

            showToast(data.message);

            setTimeout(() => {
                location.reload();
            }, 700);

        });

    });

    /* ==========================
    EDIT
    ========================== */
    document.querySelectorAll('.editBtn').forEach(btn => {

        btn.addEventListener('click', function () {

            let id = this.dataset.id;

            fetch('/admin/category/edit/' + id)
            .then(res => res.json())
            .then(data => {

                form.name.value = data.data.name;
                form.description.value =
                    data.data.description;

                form.status.value =
                    data.data.status;

                document.getElementById('edit_id').value =
                    data.data.id;

                btn.innerText = 'Update Category';

                validateForm();

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

            });

        });

    });

    /* ==========================
    DELETE
    ========================== */
    document.querySelectorAll('.deleteBtn').forEach(btn => {

        btn.addEventListener('click', function () {

            if (!confirm('Delete this category?')) {
                return;
            }

            let id = this.dataset.id;

            fetch('/admin/category/delete/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'input[name="_token"]'
                        ).value
                }
            })
            .then(res => res.json())
            .then(data => {

                showToast(data.message);

                setTimeout(() => {
                    location.reload();
                }, 700);

            });

        });

    });

});
function showToast(message)
{
    let toast = document.getElementById('toastMsg');

    toast.innerText = message;

    toast.classList.add('show-toast');

    setTimeout(function () {

        toast.classList.remove('show-toast');

    }, 3000);
}