@extends('layout.app')
@section('content')
    <!-- main-content -->
    <div class="main-content">
        <!-- main-content-inner -->
        <div class="main-content-inner">
            <div class="flex flex-wrap justify-between gap14 items-center">
                <h4 class="heading">Users List</h4>
                <a href="{{ route('staff.create') }}" class="tf-button text-btn-uppercase">
                    Create User
                </a>
            </div>
            <div class="wg-box">
                <div class="box-top">
                    <form class="form-search-2">
                        <fieldset class="name">
                            <input type="text" placeholder="Search by keyword" class="show-search" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search-1 link"></i></button>
                        </div>
                    </form>
                    <div class="d-flex gap12 flex-wrap">
                        <div class="tf-select">
                            <select class="">
                                <option selected>All Categories</option>
                                <option>TShirt</option>
                                <option>Pants</option>
                                <option>Hat</option>
                            </select>
                        </div>
                        <div class="tf-select">
                            <select class="">
                                <option selected>All Status</option>
                                <option>Publish</option>
                                <option>Draft</option>
                            </select>
                        </div>
                        <div class="tf-select">
                            <select class="">
                                <option selected>Sort by (Defaut)</option>
                                <option>ID</option>
                                <option>Name</option>
                                <option>Store</option>
                                <option>Day</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wg-table table-categories list-item-function">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-title">ID</th>
                                <th class="text-title">Name</th>
                                <th class="text-title" style="width: 226px;">Email</th>
                                <th class="text-title" style="width: 80px;">Role</th>
                                <th class="text-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="tf-table-item item-row">
                                    <td>{{ $user->id }}</td>
                                    <td class="text-caption-1">{{ $user->name }}</td>
                                    <td class="text-caption-1" style="width: 220px;">{{ $user->email }}</td>
                                    <td  style="width: 118px;">
                                        <div class="box-status text-button type-completed">
                                            {{ $user->roles->pluck('name')->implode(', ') ?: 'No Role' }}
                                        </div>
                                    </td>
                                    <td class="d-flex gap8 justify-content-start">
                                        <a href="" class="hover-tooltips tf-btn-small">
                                            <i class="icon icon-edit"></i>
                                            <span class="tooltips text-caption-1">Edit</span>
                                        </a>
                                        <a href="javascript:void(0);" class="hover-tooltips tf-btn-small btns-trash">
                                            <i class="icon icon-trash"></i>
                                            <span class="tooltips text-caption-1">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="wg-pagination">
                    <ul>
                        <li>
                            <a href="#">1</a>
                        </li>
                        <li class="active">
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#"><i class="icon icon-chevron-right"></i></a>
                        </li>
                    </ul>
                    <p class="text-secondary">Showing 1 to 9 of 16 entries</p>
                </div>
            </div>
        </div>
        <!-- /main-content-inner -->
        <!-- bottom-page -->
        <div class="bottom-page">
            <div class="copyright">
                <div class="text-caption-1 text-secondary">©2025 Modave. All Rights Reserved.</div>
                <div class="tf-cur">
                    <div class="tf-currencies">
                        <select class="image-select style-default type-languages center w-100">
                            <option selected>English</option>
                            <option>Vietnam</option>
                        </select>
                    </div>
                    <div class="tf-languages">
                        <select class="image-select style-default type-currencies center w-100">
                            <option selected data-thumbnail="images/country/fr.svg">USD</option>
                            <option data-thumbnail="images/country/us.svg">USD</option>
                            <option data-thumbnail="images/country/vn.svg">VND</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap8">
                <div class="text-caption-1 text-secondary">Payment:</div>
                <ul class="d-flex align-items-center gap8">
                    <li><img src="images/payment/img-1.png" alt=""></li>
                    <li><img src="images/payment/img-2.png" alt=""></li>
                    <li><img src="images/payment/img-3.png" alt=""></li>
                    <li><img src="images/payment/img-4.png" alt=""></li>
                    <li><img src="images/payment/img-5.png" alt=""></li>
                    <li><img src="images/payment/img-6.png" alt=""></li>
                </ul>
            </div>
        </div>
        <!-- /bottom-page -->
    </div>
    <!-- /main-content -->
@endsection
