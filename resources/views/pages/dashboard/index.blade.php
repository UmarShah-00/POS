@extends('layout.app')
@section('content')
    <div class="main-content">
        <!-- main-content-inner -->
        <div class="main-content-inner">
            <div class="flex flex-wrap justify-between gap14 items-center">
                <h4 class="heading">Dashboard</h4>
            </div>
            <div class="swiper tf-sw-card swiper-box-shadow">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="wg-card">
                            <div class="content">
                                <div class="title text-secondary">Total Revenue</div>
                                <div class="number">
                                    <h4 class="counter flex">
                                        $<span class="number" data-speed="2000" data-to="3"
                                            data-inviewport="yes">3</span>,261
                                    </h4>
                                    <div class="time text-caption-1 text-secondary">/Month</div>
                                </div>
                            </div>
                            <div class="icon">
                                <i class="icon-hand-coins"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wg-card">
                            <div class="content">
                                <div class="title text-secondary">Total Order</div>
                                <div class="number">
                                    <h4 class="counter">
                                        <span class="number" data-speed="2000" data-to="2135"
                                            data-inviewport="yes">2135</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="icon">
                                <i class="icon-clipboard-text"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wg-card">
                            <div class="content">
                                <div class="title text-secondary">Vendor Store</div>
                                <h4 class="counter">
                                    <span class="number" data-speed="2000" data-to="1235" data-inviewport="yes">1235</span>
                                </h4>
                            </div>
                            <div class="icon">
                                <i class="icon-storefront"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="wg-card">
                            <div class="content">
                                <div class="title text-secondary">Total Shop</div>
                                <h4 class="counter">
                                    <span class="number" data-speed="2000" data-to="112" data-inviewport="yes">112</span>
                                </h4>
                            </div>
                            <div class="icon">
                                <i class="icon-basket"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sw-dots type-circle sw-card-pagination justify-center d-xxl-none d-flex">
                </div>
            </div>
            <div class="tf-grid-layout tf-grid-layout-1">
                <div class="wg-box">
                    <div class="box-top">
                        <h5 class="box-title">Earning Reports</h5>
                    </div>
                    <div id="line-chart-1"></div>
                </div>
                <div class="wg-box">
                    <div class="box-top">
                        <h5 class="box-title">Popular Products</h5>
                    </div>
                    <ul class="list-item">
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-2.jpg" src="images/avatar/user-2.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">Contrasting
                                    sweatshirt</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-3.jpg" src="images/avatar/user-3.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">Faux-leather
                                    trousers</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-4.jpg" src="images/avatar/user-4.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">V-neck knitted
                                    top</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-5.jpg" src="images/avatar/user-5.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">Faux leather
                                    leggings</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-6.jpg" src="images/avatar/user-6.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">Ribbed
                                    long-sleeved</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-7.jpg" src="images/avatar/user-7.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">Ribbed
                                    long-sleeved</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                        <li class="product-item">
                            <div class="image">
                                <img class="lazyload" data-src="images/avatar/user-8.jpg" src="images/avatar/user-8.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <a href="products-list.html" class="text-title name text-line-clamp-1">Satin trousers with
                                    elastic</a>
                                <div class="text-caption-1 sub text-secondary">Women, Clothing</div>
                            </div>
                            <div class="price">$32.00</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="wg-box">
                <div class="box-top">
                    <h5 class="box-title">Recent Orders</h5>
                </div>
                <div class="wg-table table-recent-orders">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-title">Tracking Orders</th>
                                <th class="text-title">Customer</th>
                                <th class="text-title">Products</th>
                                <th class="text-title">Order Date</th>
                                <th class="text-title">Total</th>
                                <th class="text-title">Status</th>
                                <th class="text-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tf-table-item">
                                <td>s184989823</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/avatar/user-9.jpg"
                                                src="images/avatar/user-9.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Theresa Webb
                                            </div>
                                            <div class="text-caption-1 sub">ikaw.in.tmp@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>5</td>
                                <td>Mar 12, 2024</td>
                                <td>$320.44</td>
                                <td>
                                    <div class="box-status w-100 text-button type-pending">Pending
                                    </div>
                                </td>
                                <td>
                                    <a href="orders-details.html" class="hover-tooltips tf-btn-small">
                                        <i class="icon icon-eye"></i>
                                        <span class="tooltips text-caption-1">View Orders</span>
                                    </a>
                                </td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>s423464356</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/avatar/user-10.jpg"
                                                src="images/avatar/user-10.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Brooklyn
                                                Simmons</div>
                                            <div class="text-caption-1 sub">myip9@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>12</td>
                                <td>Mar 12, 2024</td>
                                <td>$480.16</td>
                                <td>
                                    <div class="box-status w-100 text-button type-delivery">Delivery
                                    </div>
                                </td>
                                <td>
                                    <a href="orders-details.html" class="hover-tooltips tf-btn-small">
                                        <i class="icon icon-eye"></i>
                                        <span class="tooltips text-caption-1">View Orders</span>
                                    </a>
                                </td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>s4231265123</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/avatar/user-11.jpg"
                                                src="images/avatar/user-11.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Arlene McCoy
                                            </div>
                                            <div class="text-caption-1 sub">grew-sra@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>3</td>
                                <td>Mar 12, 2024</td>
                                <td>$520.12</td>
                                <td>
                                    <div class="box-status w-100 text-button type-delivery">Delivery
                                    </div>
                                </td>
                                <td>
                                    <a href="orders-details.html" class="hover-tooltips tf-btn-small">
                                        <i class="icon icon-eye"></i>
                                        <span class="tooltips text-caption-1">View Orders</span>
                                    </a>
                                </td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>s867234564</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/avatar/user-12.jpg"
                                                src="images/avatar/user-12.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Darrell
                                                Steward</div>
                                            <div class="text-caption-1 sub">miyatmp_dnr4v@gmail.com
                                            </div>
                                        </div>
                                    </li>
                                </td>
                                <td>2</td>
                                <td>Mar 12, 2024</td>
                                <td>$620.43</td>
                                <td>
                                    <div class="box-status w-100 text-button type-delivery">Delivery
                                    </div>
                                </td>
                                <td>
                                    <a href="orders-details.html" class="hover-tooltips tf-btn-small">
                                        <i class="icon icon-eye"></i>
                                        <span class="tooltips text-caption-1">View Orders</span>
                                    </a>
                                </td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>s543622423</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/avatar/user-13.jpg"
                                                src="images/avatar/user-13.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Marvin
                                                McKinney</div>
                                            <div class="text-caption-1 sub">zyhxh@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>4</td>
                                <td>Mar 12, 2024</td>
                                <td>$210.23</td>
                                <td>
                                    <div class="box-status w-100 text-button type-completed">Completed
                                    </div>
                                </td>
                                <td>
                                    <a href="orders-details.html" class="hover-tooltips tf-btn-small">
                                        <i class="icon icon-eye"></i>
                                        <span class="tooltips text-caption-1">View Orders</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="wg-box">
                <div class="box-top">
                    <h5 class="box-title">Low Stock Products</h5>
                </div>
                <div class="wg-table table-low-stock">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-title">ID</th>
                                <th class="text-title">Product</th>
                                <th class="text-title">Shop</th>
                                <th class="text-title">Amount</th>
                                <th class="text-title">Status</th>
                                <th class="text-title">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tf-table-item">
                                <td>1</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/avatar/user-2.jpg"
                                                src="images/avatar/user-2.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Contrasting
                                                sweatshirt</div>
                                            <div class="text-caption-1 sub">Women, Clothing</div>
                                        </div>
                                    </li>
                                </td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/shop/shop-1.jpg"
                                                src="images/shop/shop-1.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Urban
                                                Threads</div>
                                            <div class="text-caption-1 sub">grew-sra@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>$28.00</td>
                                <td>
                                    <div class="box-status w-100 text-button type-pending">Low Stock
                                    </div>
                                </td>
                                <td>12</td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>2</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/avatar/user-3.jpg"
                                                src="images/avatar/user-3.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Faux-leather
                                                trousers</div>
                                            <div class="text-caption-1 sub">Women, Clothing</div>
                                        </div>
                                    </li>
                                </td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/shop/shop-2.jpg"
                                                src="images/shop/shop-2.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Chic Avenue
                                            </div>
                                            <div class="text-caption-1 sub">grew-sra@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>$26.00</td>
                                <td>
                                    <div class="box-status w-100 text-button type-pending">Low Stock
                                    </div>
                                </td>
                                <td>8</td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>3</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/avatar/user-4.jpg"
                                                src="images/avatar/user-4.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">V-neck
                                                knitted top</div>
                                            <div class="text-caption-1 sub">Women, Clothing</div>
                                        </div>
                                    </li>
                                </td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/shop/shop-3.jpg"
                                                src="images/shop/shop-3.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Fashion
                                                Haven</div>
                                            <div class="text-caption-1 sub">grew-sra@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>$19.00</td>
                                <td>
                                    <div class="box-status w-100 text-button type-pending">Low Stock
                                    </div>
                                </td>
                                <td>16</td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>4</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/avatar/user-5.jpg"
                                                src="images/avatar/user-5.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Ribbed
                                                long-sleeved</div>
                                            <div class="text-caption-1 sub">Women, Clothing</div>
                                        </div>
                                    </li>
                                </td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/shop/shop-4.jpg"
                                                src="images/shop/shop-4.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Trendsetters
                                            </div>
                                            <div class="text-caption-1 sub">grew-sra@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>$33.00</td>
                                <td>
                                    <div class="box-status w-100 text-button type-pending">Low Stock
                                    </div>
                                </td>
                                <td>6</td>
                            </tr>
                            <tr class="tf-table-item">
                                <td>5</td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/avatar/user-6.jpg"
                                                src="images/avatar/user-6.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Satin
                                                trousers with elastic</div>
                                            <div class="text-caption-1 sub">Women, Clothing</div>
                                        </div>
                                    </li>
                                </td>
                                <td>
                                    <li class="product-item type-1">
                                        <div class="image rounded-circle">
                                            <img class="lazyload" data-src="images/shop/shop-5.jpg"
                                                src="images/shop/shop-5.jpg" alt="">
                                        </div>
                                        <div class="content">
                                            <div class="text-title name text-line-clamp-1">Elegant
                                                Attire</div>
                                            <div class="text-caption-1 sub">grew-sra@gmail.com</div>
                                        </div>
                                    </li>
                                </td>
                                <td>$22.00</td>
                                <td>
                                    <div class="box-status w-100 text-button type-pending">Low Stock
                                    </div>
                                </td>
                                <td>3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tf-grid-layout tf-grid-layout-2">
                <div class="wg-box">
                    <div class="box-top">
                        <h5 class="box-title">Recent Withdrawals</h5>
                    </div>
                    <div class="wg-table table-recent-withdrawals">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-title">ID</th>
                                    <th class="text-title">Shop</th>
                                    <th class="text-title">Amount</th>
                                    <th class="text-title">Created</th>
                                    <th class="text-title">Payment</th>
                                    <th class="text-title">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tf-table-item">
                                    <td>1</td>
                                    <td>
                                        <li class="product-item type-1">
                                            <div class="image rounded-circle">
                                                <img class="lazyload" data-src="images/shop/shop-1.jpg"
                                                    src="images/shop/shop-1.jpg" alt="">
                                            </div>
                                            <div class="content">
                                                <div class="text-title name text-line-clamp-1">Urban
                                                    Threads</div>
                                                <div class="text-caption-1 sub">grew-sra@gmail.com
                                                </div>
                                            </div>
                                        </li>
                                    </td>
                                    <td>$7,000</td>
                                    <td>Mar 12, 2024</td>
                                    <td>Cash</td>
                                    <td>
                                        <div class="box-status w-100 text-button type-pending">Pending
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tf-table-item">
                                    <td>2</td>
                                    <td>
                                        <li class="product-item type-1">
                                            <div class="image rounded-circle">
                                                <img class="lazyload" data-src="images/shop/shop-2.jpg"
                                                    src="images/shop/shop-2.jpg" alt="">
                                            </div>
                                            <div class="content">
                                                <div class="text-title name text-line-clamp-1">Chic
                                                    Avenue</div>
                                                <div class="text-caption-1 sub">grew-sra@gmail.com
                                                </div>
                                            </div>
                                        </li>
                                    </td>
                                    <td>$1,000</td>
                                    <td>Mar 12, 2024</td>
                                    <td>Bank</td>
                                    <td>
                                        <div class="box-status w-100 text-button type-pending">Pending
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tf-table-item">
                                    <td>3</td>
                                    <td>
                                        <li class="product-item type-1">
                                            <div class="image rounded-circle">
                                                <img class="lazyload" data-src="images/shop/shop-3.jpg"
                                                    src="images/shop/shop-3.jpg" alt="">
                                            </div>
                                            <div class="content">
                                                <div class="text-title name text-line-clamp-1">Fashion
                                                    Haven</div>
                                                <div class="text-caption-1 sub">grew-sra@gmail.com
                                                </div>
                                            </div>
                                        </li>
                                    </td>
                                    <td>$4,750</td>
                                    <td>Mar 12, 2024</td>
                                    <td>Cash</td>
                                    <td>
                                        <div class="box-status w-100 text-button type-completed">
                                            Approved</div>
                                    </td>
                                </tr>
                                <tr class="tf-table-item">
                                    <td>4</td>
                                    <td>
                                        <li class="product-item type-1">
                                            <div class="image rounded-circle">
                                                <img class="lazyload" data-src="images/shop/shop-4.jpg"
                                                    src="images/shop/shop-4.jpg" alt="">
                                            </div>
                                            <div class="content">
                                                <div class="text-title name text-line-clamp-1">
                                                    Trendsetters</div>
                                                <div class="text-caption-1 sub">grew-sra@gmail.com
                                                </div>
                                            </div>
                                        </li>
                                    </td>
                                    <td>$2,000</td>
                                    <td>Mar 12, 2024</td>
                                    <td>Cash</td>
                                    <td>
                                        <div class="box-status w-100 text-button type-completed">
                                            Approved</div>
                                    </td>
                                </tr>
                                <tr class="tf-table-item">
                                    <td>5</td>
                                    <td>
                                        <li class="product-item type-1">
                                            <div class="image rounded-circle">
                                                <img class="lazyload" data-src="images/shop/shop-5.jpg"
                                                    src="images/shop/shop-5.jpg" alt="">
                                            </div>
                                            <div class="content">
                                                <div class="text-title name text-line-clamp-1">Elegant
                                                    Attire</div>
                                                <div class="text-caption-1 sub">grew-sra@gmail.com
                                                </div>
                                            </div>
                                        </li>
                                    </td>
                                    <td>$2,700</td>
                                    <td>Mar 12, 2024</td>
                                    <td>Cash</td>
                                    <td>
                                        <div class="box-status w-100 text-button type-completed">
                                            Approved</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="wg-box">
                    <div class="box-top">
                        <h5 class="box-title font-instrument fw-6">Transactions</h5>
                    </div>
                    <ul class="list-item overflow-h-408">
                        <li class="product-item type-2">
                            <div class="image">
                                <img class="lazyload" data-src="images/payment/wallet.jpg"
                                    src="images/payment/wallet.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="h6 name text-line-clamp-1 mb-4">Wallet</div>
                                <div class="text-caption-1 text-secondary sub">Starbucks</div>
                            </div>
                            <div class="price text-button font-instrument text-primary">-$70.05</div>
                        </li>
                        <li class="product-item type-2">
                            <div class="image">
                                <img class="lazyload" data-src="images/payment/bank.jpg" src="images/payment/bank.jpg"
                                    alt="">
                            </div>
                            <div class="content">
                                <div class="h6 name text-line-clamp-1 mb-4">Bank Transfer</div>
                                <div class="text-caption-1 text-secondary sub">Add Money</div>
                            </div>
                            <div class="price text-button text-primary font-instrument text-success">
                                +$90.05</div>
                        </li>
                        <li class="product-item type-2">
                            <div class="image">
                                <img class="lazyload" data-src="images/payment/paypal.jpg"
                                    src="images/payment/paypal.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="h6 name text-line-clamp-1 mb-4">PayPal</div>
                                <div class="text-caption-1 text-secondary sub">Client Payment</div>
                            </div>
                            <div class="price text-button text-primary font-instrument text-success">
                                +$170.05</div>
                        </li>
                        <li class="product-item type-2">
                            <div class="image">
                                <img class="lazyload" data-src="images/payment/master-card.jpg"
                                    src="images/payment/master-card.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="h6 name text-line-clamp-1 mb-4">Master Card</div>
                                <div class="text-caption-1 text-secondary sub">Ordered Procuts</div>
                            </div>
                            <div class="price text-button font-instrument text-primary">-$70.05</div>
                        </li>
                        <li class="product-item type-2">
                            <div class="image">
                                <img class="lazyload" data-src="images/payment/master-card.jpg"
                                    src="images/payment/master-card.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="h6 name text-line-clamp-1 mb-4">Master Card</div>
                                <div class="text-caption-1 text-secondary sub">Ordered Procuts</div>
                            </div>
                            <div class="price text-button font-instrument text-primary">-$70.05</div>
                        </li>
                        <li class="product-item type-2">
                            <div class="image">
                                <img class="lazyload" data-src="images/payment/paypal.jpg"
                                    src="images/payment/paypal.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="h6 name text-line-clamp-1 mb-4">PayPal</div>
                                <div class="text-caption-1 text-secondary sub">Client Payment</div>
                            </div>
                            <div class="price text-button text-primary font-instrument text-success">
                                +$170.05</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /main-content-inner -->
    </div>
@endsection
