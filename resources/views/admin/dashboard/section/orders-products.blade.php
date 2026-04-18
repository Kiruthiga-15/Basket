<!-- resources/views/admin/dashboard/section/orders-products.blade.php -->

<section class="mb-4">

    <div class="row g-4">

        <div class="col-lg-7">

            <div class="dash-box">

                <h5>Recent Orders</h5>

                <div class="table-responsive">

                    <table class="table admin-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>#1001</td>
                                <td>Ankit</td>
                                <td>₹2,500</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>

                            <tr>
                                <td>#1002</td>
                                <td>Riya</td>
                                <td>₹4,200</td>
                                <td><span class="badge bg-success">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>#1003</td>
                                <td>John</td>
                                <td>₹1,900</td>
                                <td><span class="badge bg-info">Shipped</span></td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-5">

            <div class="dash-box">

                <h5>Top Products</h5>

                <ul class="dash-list">

                    <li>Leather Bag <span>120 Sold</span></li>
                    <li>Travel Bag <span>98 Sold</span></li>
                    <li>Mini Tote <span>80 Sold</span></li>
                    <li>Classic Basket <span>75 Sold</span></li>

                </ul>

            </div>

        </div>

    </div>

</section>