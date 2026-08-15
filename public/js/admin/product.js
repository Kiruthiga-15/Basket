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

    const skuInput =
        form.querySelector(
            'input[name="sku"]'
        );

    const stockInput =
        form.querySelector(
            'input[name="stock"]'
        );

    const categoryInput =
        form.querySelector(
            'select[name="category_id"]'
        );

    const productTypeInput =
        document.getElementById('productType');

    const normalProductFields =
        document.getElementById('normalProductFields');

    const variableProductFields =
        document.getElementById('variableProductFields');

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
            categoryInput.value !== '';

        const selectedType =
            productTypeInput.value;

        if (
            selectedType === 'normal'
        ) {

            ok = ok &&
                priceInput.value.trim() !== '' &&
                skuInput.value.trim() !== '' &&
                stockInput.value.trim() !== '';

        } else if (
            selectedType === 'variable'
        ) {

            // For variable products, check if at least one variation row exists
            const variationRows =
                document.querySelectorAll(
                    '#variationTable tbody tr'
                );

            ok = ok && variationRows.length > 0;

            // Validate each variation row
            variationRows.forEach(row => {

                const skuInput =
                    row.querySelector('.sku-input');

                const priceInput =
                    row.querySelector('.price-input');

                const stockInput =
                    row.querySelector('.stock-input');

                if (
                    skuInput.value.trim() === '' ||
                    priceInput.value.trim() === '' ||
                    stockInput.value.trim() === ''
                ) {

                    ok = false;

                }

            });

        }

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
       PRODUCT TYPE CHANGE
    ====================== */
    productTypeInput.addEventListener(
        'change',
        function () {

            const selectedType =
                this.value;

            if (
                selectedType === 'normal'
            ) {

                normalProductFields.style.display = 'block';
                variableProductFields.style.display = 'none';

            } else if (
                selectedType === 'variable'
            ) {

                normalProductFields.style.display = 'none';
                variableProductFields.style.display = 'block';

            } else {

                normalProductFields.style.display = 'none';
                variableProductFields.style.display = 'none';

            }

            validateForm();

        }
    );

    // Initialize product type display
    const initialType =
        productTypeInput.value;

    if (
        initialType === 'normal'
    ) {

        normalProductFields.style.display = 'block';
        variableProductFields.style.display = 'none';

    } else if (
        initialType === 'variable'
    ) {

        normalProductFields.style.display = 'none';
        variableProductFields.style.display = 'block';

    } else {

        normalProductFields.style.display = 'none';
        variableProductFields.style.display = 'none';

    }


    /* ======================
       VARIATION MANAGEMENT
    ====================== */
    const variationTable =
        document.getElementById(
            'variationTable'
        );

    const addVariationTypeBtn =
        document.getElementById(
            'addVariationTypeBtn'
        );

    const generateVariationsBtn =
        document.getElementById(
            'generateVariationsBtn'
        );

    // Add variation row
    function addVariationRow(
        size = '',
        color = '',
        sku = '',
        price = '',
        discountPercent = '',
        stock = ''
    ) {

        const tbody =
            variationTable.querySelector(
                'tbody'
            );

        const row =
            document.createElement('tr');

        // Get variation data from button attributes
        const variationTypesData =
            JSON.parse(
                addVariationTypeBtn.getAttribute(
                    'data-variation-types'
                ) || '[]'
            );

        const variationValuesData =
            JSON.parse(
                addVariationTypeBtn.getAttribute(
                    'data-variation-values'
                ) || '[]'
            );

        // Build size options
        let sizeOptions = '<option value="">Select Size</option>';

        variationTypesData.forEach(type => {

            if (type.name.toLowerCase() === 'size') {

                variationValuesData.forEach(value => {

                    if (value.variation_type_id === type.id) {

                        const selected =
                            value.id == size ? 'selected' : '';

                        sizeOptions +=
                            `<option value="${value.id}" ${selected}>${value.value}</option>`;

                    }

                });

            }

        });

        // Build color options
        let colorOptions = '<option value="">Select Color</option>';

        variationTypesData.forEach(type => {

            if (type.name.toLowerCase() === 'color') {

                variationValuesData.forEach(value => {

                    if (value.variation_type_id === type.id) {

                        const selected =
                            value.id == color ? 'selected' : '';

                        colorOptions +=
                            `<option value="${value.id}" ${selected}>${value.value}</option>`;

                    }

                });

            }

        });

        row.innerHTML = `
            <td>
                <select class="form-select size-select">
                    ${sizeOptions}
                </select>
            </td>
            <td>
                <select class="form-select color-select">
                    ${colorOptions}
                </select>
            </td>
            <td>
                <input type="text" class="form-control sku-input" value="${sku}">
            </td>
            <td>
                <input type="number" class="form-control price-input" step="0.01" value="${price}">
            </td>
            <td>
                <input type="number" class="form-control discount-percent-input" step="0.01" value="${discountPercent}">
            </td>
            <td>
                <input type="number" class="form-control discount-amount-input" step="0.01" readonly>
            </td>
            <td>
                <input type="number" class="form-control stock-input" value="${stock}">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-variation">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(row);

        // Add event listeners for this row
        const discountPercentInput =
            row.querySelector('.discount-percent-input');

        const priceInput =
            row.querySelector('.price-input');

        const discountAmountInput =
            row.querySelector('.discount-amount-input');

        // Calculate discount amount when price or discount percent changes
        function calculateDiscountAmount() {

            const price =
                parseFloat(priceInput.value) || 0;

            const discountPercent =
                parseFloat(discountPercentInput.value) || 0;

            const discountAmount =
                price * discountPercent / 100;

            discountAmountInput.value =
                discountAmount.toFixed(2);

        }

        priceInput.addEventListener(
            'input',
            calculateDiscountAmount
        );

        discountPercentInput.addEventListener(
            'input',
            calculateDiscountAmount
        );

        // Remove row
        row.querySelector('.remove-variation').addEventListener(
            'click',
            function () {

                row.remove();
                validateForm();

            }
        );

        validateForm();

    }

    // Add variation type button
    if (addVariationTypeBtn) {

        addVariationTypeBtn.addEventListener(
            'click',
            function () {

                addVariationRow();

            }
        );

    }

    // Generate variations button
    if (generateVariationsBtn) {

        generateVariationsBtn.addEventListener(
            'click',
            function () {

                const variationTypesData =
                    JSON.parse(
                        addVariationTypeBtn.getAttribute(
                            'data-variation-types'
                        ) || '[]'
                    );

                const variationValuesData =
                    JSON.parse(
                        addVariationTypeBtn.getAttribute(
                            'data-variation-values'
                        ) || '[]'
                    );

                // Get size and color values
                let sizes = [];
                let colors = [];

                variationTypesData.forEach(type => {

                    if (type.name.toLowerCase() === 'size') {

                        variationValuesData.forEach(value => {

                            if (value.variation_type_id === type.id) {

                                sizes.push(value);

                            }

                        });

                    } else if (type.name.toLowerCase() === 'color') {

                        variationValuesData.forEach(value => {

                            if (value.variation_type_id === type.id) {

                                colors.push(value);

                            }

                        });

                    }

                });

                // Clear existing rows
                variationTable.querySelector('tbody').innerHTML = '';

                // Generate combinations
                if (sizes.length > 0 && colors.length > 0) {

                    sizes.forEach(size => {

                        colors.forEach(color => {

                            addVariationRow(
                                size.id,
                                color.id,
                                '', // sku
                                '', // price
                                '', // discountPercent
                                ''  // stock
                            );

                        });

                    });

                } else if (sizes.length > 0) {

                    sizes.forEach(size => {

                        addVariationRow(
                            size.id,
                            '', // color
                            '', // sku
                            '', // price
                            '', // discountPercent
                            ''  // stock
                        );

                    });

                } else if (colors.length > 0) {

                    colors.forEach(color => {

                        addVariationRow(
                            '', // size
                            color.id,
                            '', // sku
                            '', // price
                            '', // discountPercent
                            ''  // stock
                        );

                    });

                }

                toast('Variations generated successfully');

            }
        );

    }
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

            // Add variation data for variable products
            const selectedType =
                productTypeInput.value;

            if (
                selectedType === 'variable'
            ) {

                const variationRows =
                    variationTable.querySelectorAll(
                        'tbody tr'
                    );

                variationRows.forEach(
                    (row, index) => {

                        const sizeSelect =
                            row.querySelector('.size-select');

                        const colorSelect =
                            row.querySelector('.color-select');

                        const skuInput =
                            row.querySelector('.sku-input');

                        const priceInput =
                            row.querySelector('.price-input');

                        const discountPercentInput =
                            row.querySelector('.discount-percent-input');

                        const stockInput =
                            row.querySelector('.stock-input');

                        formData.append(
                            `variations[${index}][size_id]`,
                            sizeSelect.value
                        );

                        formData.append(
                            `variations[${index}][color_id]`,
                            colorSelect.value
                        );

                        formData.append(
                            `variations[${index}][sku]`,
                            skuInput.value
                        );

                        formData.append(
                            `variations[${index}][price]`,
                            priceInput.value
                        );

                        formData.append(
                            `variations[${index}][discount_percent]`,
                            discountPercentInput.value
                        );

                        formData.append(
                            `variations[${index}][stock]`,
                            stockInput.value
                        );

                    }
                );

            }

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