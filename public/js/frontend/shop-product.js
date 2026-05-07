/* add inside @section('page-js') or shop.js */

document.addEventListener('DOMContentLoaded', function () {

    console.log("js loaded from shop page");

    // View switching
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    const gridWrap = document.getElementById('gridViewWrap');
    const listWrap = document.getElementById('listViewWrap');

    if (gridBtn && listBtn) {
        gridBtn.addEventListener('click', function () {
            gridWrap.style.display = 'block';
            listWrap.style.display = 'none';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        });

        listBtn.addEventListener('click', function () {
            gridWrap.style.display = 'none';
            listWrap.style.display = 'block';
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        });
    }

    // Filtering functionality
    const categoryFilter = document.getElementById('categoryFilter');
    const priceMinFilter = document.getElementById('priceMinFilter');
    const priceMaxFilter = document.getElementById('priceMaxFilter');
    const searchFilter = document.getElementById('searchFilter');
    const applyFiltersBtn = document.getElementById('applyFiltersBtn');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');

    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            loadProducts();
        });
    }

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            clearFilters();
        });
    }

    // Search on enter
    if (searchFilter) {
        searchFilter.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                loadProducts();
            }
        });
    }

    function loadProducts(page = 1) {
        const params = new URLSearchParams();

        if (categoryFilter && categoryFilter.value) {
            params.append('category', categoryFilter.value);
        }

        if (priceMinFilter && priceMinFilter.value) {
            params.append('min_price', priceMinFilter.value);
        }

        if (priceMaxFilter && priceMaxFilter.value) {
            params.append('max_price', priceMaxFilter.value);
        }

        if (searchFilter && searchFilter.value) {
            params.append('search', searchFilter.value);
        }

        params.append('page', page);

        fetch('/api/products?' + params.toString())
            .then(response => response.json())
            .then(data => {
                updateProductViews(data.products, data.wishlisted || []);
                updatePagination(data.pagination);
            })
            .catch(error => {
                console.error('Error loading products:', error);
            });
    }

    function clearFilters() {
        if (categoryFilter) categoryFilter.value = '';
        if (priceMinFilter) priceMinFilter.value = '';
        if (priceMaxFilter) priceMaxFilter.value = '';
        if (searchFilter) searchFilter.value = '';

        // Reload all products
        loadProducts();
    }

    function updateProductViews(products, wishlistedIds = []) {
        const gridContainer = document.getElementById('productGridContainer');
        const listContainer = document.getElementById('productListContainer');

        if (gridContainer) {
            gridContainer.innerHTML = generateGridHTML(products.data, wishlistedIds);
        }

        if (listContainer) {
            listContainer.innerHTML = generateListHTML(products.data, wishlistedIds);
        }
    }

    function generateGridHTML(products, wishlistedIds = []) {
        if (!products || products.length === 0) {
            return `
                <div class="col-12">
                    <div class="text-center py-5">
                        <h4>No products found</h4>
                        <p>Please check back later for new products.</p>
                    </div>
                </div>
            `;
        }

        return products.map(product => {
            const isWishlisted = wishlistedIds.includes(product.id);
            return `
            <div class="col-12 col-md-6 col-xl-4">
                <div class="product-card">
                    <div class="product-image-container">
                        <img
                            src="${product.images && product.images.length > 0 ? '/storage/' + product.images[0].image : '/product/product2.jpg'}"
                            class="img-fluid w-100"
                            alt="${product.name}"
                        >
                        <button class="wishlist-btn ${isWishlisted ? 'active' : ''}" data-product-id="${product.id}" type="button">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    <div class="product-info">
                        <h5>${product.name}</h5>
                        <p>${product.short_description || 'Premium Handcrafted Design'}</p>
                        <div class="price-row">
                            ${product.discount_price && product.discount_price < product.price ?
                                `<span><del>₹${parseFloat(product.price).toFixed(2)}</del> ₹${parseFloat(product.discount_price).toFixed(2)}</span>` :
                                `<span>₹${parseFloat(product.price).toFixed(2)}</span>`
                            }
                            <a href="/cart" class="add-to-cart-btn" data-product-id="${product.id}">Add</a>
                        </div>
                        ${product.variation_type_size && product.variation_value_size ?
                            `<small class="text-muted">${product.variation_type_size.name}: ${product.variation_value_size.value_name}</small>` : ''
                        }
                        ${product.variation_type_color && product.variation_value_color ?
                            `<small class="text-muted">${product.variation_type_color.name}: ${product.variation_value_color.value_name}</small>` : ''
                        }
                    </div>
                </div>
            </div>
        `}).join('');
    }

    function generateListHTML(products, wishlistedIds = []) {
        if (!products || products.length === 0) {
            return `
                <div class="col-12">
                    <div class="text-center py-5">
                        <h4>No products found</h4>
                        <p>Please check back later for new products.</p>
                    </div>
                </div>
            `;
        }

        return products.map(product => {
            const isWishlisted = wishlistedIds.includes(product.id);
            return `
            <div class="list-product-card">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-4">
                        <div class="product-image-container">
                            <img
                                src="${product.images && product.images.length > 0 ? '/storage/' + product.images[0].image : '/product/product3.jpg'}"
                                class="img-fluid w-100"
                                alt="${product.name}"
                            >
                            <button class="wishlist-btn ${isWishlisted ? 'active' : ''}" data-product-id="${product.id}" type="button">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="list-info">
                            <h4>${product.name}</h4>
                            <p>${product.short_description || 'Stylish handcrafted bag for daily use, travel and premium fashion styling.'}</p>
                            ${product.category ? `<small class="text-muted">Category: ${product.category.name}</small><br>` : ''}
                            ${product.variation_type_size && product.variation_value_size ?
                                `<small class="text-muted">${product.variation_type_size.name}: ${product.variation_value_size.value_name}</small><br>` : ''
                            }
                            ${product.variation_type_color && product.variation_value_color ?
                                `<small class="text-muted">${product.variation_type_color.name}: ${product.variation_value_color.value_name}</small><br>` : ''
                            }
                            ${product.sku ? `<small class="text-muted">SKU: ${product.sku}</small><br>` : ''}
                            ${product.stock ? `<small class="text-muted">Stock: ${product.stock}</small><br>` : ''}
                            <div class="price-row">
                                ${product.discount_price && product.discount_price < product.price ?
                                    `<span><del>₹${parseFloat(product.price).toFixed(2)}</del> ₹${parseFloat(product.discount_price).toFixed(2)}</span>` :
                                    `<span>₹${parseFloat(product.price).toFixed(2)}</span>`
                                }
                                <a href="/cart" class="add-to-cart-btn" data-product-id="${product.id}">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `}).join('');
    }

    function updatePagination(pagination) {
        // Update pagination links if they exist
        const paginationContainer = document.querySelector('.pagination');
        if (paginationContainer) {
            // You can implement pagination HTML generation here
            console.log('Pagination:', pagination);
        }
    }

    // Check if user is logged in
    const isLoggedIn = document.querySelector('meta[name="user-id"]') !== null;

    // Wishlist functionality
    document.addEventListener('click', function(e) {
        const wishlistBtn = e.target.closest('.wishlist-btn');
        if (wishlistBtn) {
            e.preventDefault();
            e.stopPropagation();
            const productId = wishlistBtn.dataset.productId;
            toggleWishlist(productId, wishlistBtn);
        }
    });

    function toggleWishlist(productId, btn) {
        if (!isLoggedIn) {
            showWishlistToast('Please login to add items to wishlist', 'warning');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1500);
            return;
        }

        const isActive = btn.classList.contains('active');

        if (isActive) {
            removeFromWishlist(productId, btn);
        } else {
            addToWishlist(productId, btn);
        }
    }

    function addToWishlist(productId, btn) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/wishlist/add', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                btn.classList.add('active');
                showWishlistToast('❤️ Added to wishlist', 'success');
            } else {
                showWishlistToast(data.message || 'Error adding to wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showWishlistToast('Error adding to wishlist', 'error');
        });
    }

    function removeFromWishlist(productId, btn) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/wishlist/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                btn.classList.remove('active');
                showWishlistToast('💔 Removed from wishlist', 'success');
            } else {
                showWishlistToast('Error removing from wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showWishlistToast('Error removing from wishlist', 'error');
        });
    }

    function showWishlistToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `wishlist-toast wishlist-toast-${type}`;
        toast.innerHTML = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 14px 20px;
            border-radius: 6px;
            z-index: 10000;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

});