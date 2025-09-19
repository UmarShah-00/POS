@extends('layout.app')
<style>
    .swal2-confirm {
        background-color: #181818 !important;
        border-radius: 0.25rem !important;
        color: #fff !important;
    }
</style>
@section('content')
    <!-- main-content -->
    <div class="main-content">
        <!-- main-content-inner -->
        <div class="main-content-inner">
            <div class="flex flex-wrap justify-between gap14 items-center">
                <h4 class="heading">Categories</h4>
                <a href="{{ route('category.create') }}" class="tf-button text-btn-uppercase">
                    Create Category
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
                                <th class="text-title" style="width: 35px;">ID</th>
                                <th class="text-title" style="width: 149px;">Name</th>
                                <th class="text-title" style="width: 109px;">Image</th>
                                <th class="text-title" style="width: 73px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr class="tf-table-item item-row">
                                    <td style="width: 95px;">{{ $item->id }}</td>
                                    <td style="width: 216;" class="text-caption-1">{{ $item->name }}</td>
                                    <td class="text-caption-1" style="width: 161px;"><img
                                            src="{{ asset('storage/' . $item->image) }}" alt="" width="60px"
                                            height="60px"></td>
                                    <td class="d-flex gap8 justify-content-start" style="width:82px;">
                                        <a href="{{ route('category.edit', $item->id) }}"
                                            class="hover-tooltips tf-btn-small">
                                            <i class="icon icon-edit"></i>
                                            <span class="tooltips text-caption-1">Edit</span>
                                        </a>
                                        <a href="javascript:void(0);"
                                            class="hover-tooltips tf-btn-small btns-trash delete-category"
                                            data-id="{{ $item->id }}">
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
    </div>
    <!-- /main-content -->
@endsection
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.delete-category').forEach(button => {
            // sab purane listeners remove kar do jo theme ne lagaye hain
            let newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);

            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); // ✅ koi aur listener trigger na ho

                const userId = this.getAttribute('data-id');
                const row = this.closest('tr');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#181818',
                    cancelButtonColor: '#181818',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/category/delete/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        "content"),
                                    "Accept": "application/json"
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('Deleted!', data.message, 'success')
                                        .then(() => {
                                            row
                                        .remove(); // ✅ Ab sirf DB success pe hi remove hoga
                                        });
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire('Error!', 'Request failed.', 'error');
                            });
                    }
                });
            });
        });
    });
</script>
