// public/js/admin/product.js

document.addEventListener('DOMContentLoaded', function () {

    console.log('product.js loaded');

    const form = document.getElementById('productForm');

    if (!form) return;

    const submitBtn =
        form.querySelector(
            'button[type="submit"]'
        );

    const editId =
        document.getElementById(
            'edit_id'
        );

    const csrfToken =
        document.querySelector(
            'input[name="_token"]'
        ).value;

    const nameInput =
        form.querySelector(
            'input[name="name"]'
        );

    const priceInput =
        form.querySelector(
            'input[name="price"]'
        );

    const categoryInput =
        form.querySelector(
            'select[name="category_id"]'
        );

    const mainImage =
        form.querySelector(
            'input[name="main_image"]'
        );

    const galleryInput =
        form.querySelector(
            'input[name="gallery[]"]'
        );

    const preview =
        document.getElementById(
            'imagePreview'
        );

    const galleryPreview =
        document.getElementById(
            'galleryPreview'
        );

    const discountType =
        form.querySelector(
            'select[name="discount_type"]'
        );

    const discountValue =
        form.querySelector(
            'input[name="discount_value"]'
        );

    const finalPrice =
        document.getElementById(
            'discountPrice'
        );

    const variationTypes =
        document.querySelectorAll(
            '.variationType'
        );

    const variationValues =
        document.querySelectorAll(
            '.variationValue'
        );


    /* ======================
       TOAST
    ====================== */
    function toast(message, type)
    {
        if (typeof showToast !== 'undefined') {

            showToast(message, type);

        } else {

            alert(message);
        }
    }


    /* ======================
       VALIDATION
    ====================== */
    function validateForm()
    {
        let ok =
            nameInput.value.trim() !== '' &&
            priceInput.value.trim() !== '' &&
            categoryInput.value !== '';

        if (
            !editId.value &&
            mainImage.files.length === 0
        ) {
            ok = false;
        }

        submitBtn.disabled = !ok;

        submitBtn.innerText =
            editId.value
            ? 'Update Product'
            : 'Save Product';
    }


    /* ======================
       RESET FORM
    ====================== */
    function resetForm()
    {
        form.reset();

        editId.value = '';

        preview.innerHTML = '';
        galleryPreview.innerHTML = '';
        document.getElementById('existingGallery').innerHTML = '';

        finalPrice.value = '';

        submitBtn.innerText =
            'Save Product';

        validateForm();
    }


    /* ======================
       DELETE GALLERY IMAGE
    ====================== */
    function deleteGalleryImage(imageId, container)
    {
        fetch('/admin/products/delete-image/' + imageId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                container.remove();
                toast('Image deleted successfully', 'success');
            } else {
                toast('Failed to delete image', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toast('Error deleting image', 'error');
        });
    }


    /* ======================
       MAIN IMAGE PREVIEW
    ====================== */
    mainImage.addEventListener(
        'change',
        function () {

            preview.innerHTML = '';

            const file =
                this.files[0];

            if (!file) return;

            const img =
                document.createElement('img');

            img.src =
                URL.createObjectURL(file);

            img.style.width = '70px';
            img.style.height = '70px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';

            preview.appendChild(img);

            validateForm();
        }
    );


    /* ======================
       GALLERY PREVIEW
    ====================== */
    galleryInput.addEventListener(
        'change',
        function () {

            galleryPreview.innerHTML = '';

            Array.from(
                this.files
            ).forEach(file => {

                const img =
                    document.createElement(
                        'img'
                    );

                img.src =
                    URL.createObjectURL(
                        file
                    );

                img.style.width = '70px';
                img.style.height = '70px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.margin = '4px';

                galleryPreview.appendChild(
                    img
                );

            });
 
        }
    ); 


    /* ======================
       DISCOUNT PRICE
    ====================== */
    function calculatePrice()
    {
        let price =
            parseFloat(
                priceInput.value
            ) || 0;

        let dis =
            parseFloat(
                discountValue.value
            ) || 0;

        let total = price;

        if (
            discountType.value ===
            'percentage'
        ) {
            total =
                price -
                (price * dis / 100);
        }

        if (
            discountType.value ===
            'fixed'
        ) {
            total =
                price - dis;
        }

        if (total < 0) {
            total = 0;
        }

        finalPrice.value =
            total.toFixed(2);
    }


    /* ======================
       FILTER VARIATION
    ====================== */
    function filterValues(
        typeSelect,
        valueSelect
    ) {

        const selectedText =
            typeSelect.options[
                typeSelect.selectedIndex
            ].text
            .toLowerCase()
            .trim();

        const options =
            valueSelect.querySelectorAll(
                'option'
            );

        options.forEach(option => {

            if (
                option.value === ''
            ) {
                option.hidden = false;
                return;
            }

            const type =
                option.dataset.type
                ?.toLowerCase()
                .trim();

            option.hidden =
                type !== selectedText;
        });

        valueSelect.value = '';
    }


    variationTypes.forEach(
        function (
            typeSelect,
            index
        ) {

            typeSelect.addEventListener(
                'change',
                function () {

                    filterValues(
                        typeSelect,
                        variationValues[index]
                    );

                }
            );

        }
    );


    /* ======================
       INPUT EVENTS
    ====================== */
    nameInput.addEventListener(
        'input',
        validateForm
    );

    priceInput.addEventListener(
        'input',
        function () {
            validateForm();
            calculatePrice();
        }
    );

    categoryInput.addEventListener(
        'change',
        validateForm
    );

    discountType.addEventListener(
        'change',
        calculatePrice
    );

    discountValue.addEventListener(
        'input',
        calculatePrice
    );


    /* ======================
       CREATE / UPDATE
    ====================== */
    form.addEventListener(
        'submit',
        function (e) {

            e.preventDefault();

            submitBtn.disabled =
                true;

            let id =
                editId.value;

            let url =
                '/admin/products/store';

            if (id) {
                url =
                    '/admin/products/update/' +
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
            .then(res => res.json())
            .then(data => {

                toast(
                    data.message
                );

                if (
                    data.status
                ) {
                    location.reload();
                }

                validateForm();

            })
            .catch(error => {

                console.log(error);

                toast(
                    'Server Error'
                );

                validateForm();

            });

        }
    );


    /* ======================
       EDIT BUTTON
    ====================== */
    document.addEventListener(
        'click',
        function (e) {

            if (
                e.target.classList.contains(
                    'producteditBtn'
                )
            ) {

                let id =
                    e.target.dataset.id;

                fetch(
                    '/admin/products/edit/' +
                    id
                )
                .then(res => res.json())
                .then(data => {

                    let d =
                        data.data;

                    editId.value =
                        d.id;

                    form.querySelector(
                        '[name="name"]'
                    ).value =
                        d.name;

                    form.querySelector(
                        '[name="price"]'
                    ).value =
                        d.price;

                    form.querySelector(
                        '[name="category_id"]'
                    ).value =
                        d.category_id;

                    form.querySelector(
                        '[name="sku"]'
                    ).value =
                        d.sku;

                    form.querySelector(
                        '[name="stock"]'
                    ).value =
                        d.stock;

                    form.querySelector(
                        '[name="delivery_charge"]'
                    ).value =
                        d.delivery_charge;

                    form.querySelector(
                        '[name="discount_type"]'
                    ).value =
                        d.discount_type;

                    form.querySelector(
                        '[name="discount_value"]'
                    ).value =
                        d.discount_value;

                    form.querySelector(
                        '[name="discount_price"]'
                    ).value =
                        d.discount_price;

                    form.querySelector(
                        '[name="status"]'
                    ).value =
                        d.status;

                    // ======================
                    // VARIATION FIX (IMPORTANT)
                    // ======================

                    // get selects
                    const sizeTypeSelect =
                        form.querySelector('[name="variation_type_size_id"]');

                    const sizeValueSelect =
                        form.querySelector('[name="variation_value_size_id"]');

                    const colorTypeSelect =
                        form.querySelector('[name="variation_type_color_id"]');

                    const colorValueSelect =
                        form.querySelector('[name="variation_value_color_id"]');

                    // set type first
                    sizeTypeSelect.value =
                        d.variation_type_size_id;

                    colorTypeSelect.value =
                        d.variation_type_color_id;

                    // 🔥 filter options based on type
                    filterValues(
                        sizeTypeSelect,
                        sizeValueSelect
                    );

                    filterValues(
                        colorTypeSelect,
                        colorValueSelect
                    );

                    // THEN set values
                    sizeValueSelect.value =
                        d.variation_value_size_id;

                    colorValueSelect.value =
                        d.variation_value_color_id;

                    // descriptions
                    form.querySelector('[name="short_description"]').value =
                        d.short_description ?? '';

                    form.querySelector('[name="long_description"]').value =
                        d.long_description ?? '';
                    
                    preview.innerHTML = '';

                    if (d.main_image) {

                        const img = document.createElement('img');

                        img.src = '/storage/' + d.main_image;

                        img.style.width = '70px';
                        img.style.height = '70px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';

                        preview.appendChild(img);
                    }

                    galleryPreview.innerHTML = '';

                    // Populate existing gallery with delete buttons
                    const existingGallery = document.getElementById('existingGallery');
                    existingGallery.innerHTML = '';

                    if (d.images && d.images.length > 0) {
                        d.images.forEach(imgObj => {
                            const container = document.createElement('div');
                            container.style.position = 'relative';
                            container.style.display = 'inline-block';
                            container.style.margin = '4px';

                            const img = document.createElement('img');
                            img.src = '/storage/' + imgObj.image;
                            img.style.width = '70px';
                            img.style.height = '70px';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '8px';

                            const deleteBtn = document.createElement('button');
                            deleteBtn.type = 'button';
                            deleteBtn.innerHTML = '×';
                            deleteBtn.style.position = 'absolute';
                            deleteBtn.style.top = '-5px';
                            deleteBtn.style.right = '-5px';
                            deleteBtn.style.background = 'red';
                            deleteBtn.style.color = 'white';
                            deleteBtn.style.border = 'none';
                            deleteBtn.style.borderRadius = '50%';
                            deleteBtn.style.width = '20px';
                            deleteBtn.style.height = '20px';
                            deleteBtn.style.cursor = 'pointer';
                            deleteBtn.style.fontSize = '14px';
                            deleteBtn.style.lineHeight = '1';
                            deleteBtn.dataset.imageId = imgObj.id;

                            deleteBtn.addEventListener('click', function() {
                                if (confirm('Are you sure you want to delete this image?')) {
                                    deleteGalleryImage(this.dataset.imageId, container);
                                }
                            });

                            container.appendChild(img);
                            container.appendChild(deleteBtn);
                            existingGallery.appendChild(container);
                        });
                    }

                    submitBtn.innerText =
                        'Update Product';

                    validateForm();

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                });

            }

        }
    );


    /* ======================
       DELETE BUTTON
    ====================== */
    document.addEventListener(
        'click',
        function (e) {

            if (
                e.target.classList.contains(
                    'deleteBtn'
                )
            ) {

                if (
                    !confirm(
                        'Delete this product?'
                    )
                ) return;

                let id =
                    e.target.dataset.id;

                fetch(
                    '/admin/products/delete/' +
                    id,
                    {
                        method:
                            'DELETE',
                        headers: {
                            'X-CSRF-TOKEN':
                                csrfToken
                        }
                    }
                )
                .then(res => res.json())
                .then(data => {

                    toast(
                        data.message
                    );

                    if (
                        data.status
                    ) {

                        document.getElementById(
                            'row_' + id
                        ).remove();

                    }

                });

            }

        }
    );

    /* ======================
    STATUS TOGGLE
    ====================== */
    document.addEventListener('change', function (e) {

        if (e.target.classList.contains('productStatusToggle')) {

            let id = e.target.dataset.id;

            fetch('/admin/products/status/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {

                    toast('Status Updated');

                } else {

                    toast('Failed');

                }

            })
            .catch(err => {

                console.log(err);
                toast('Error updating status');

            });

        }

    });


    validateForm();

});