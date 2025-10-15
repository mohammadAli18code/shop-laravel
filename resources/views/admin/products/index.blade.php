@extends('layouts.admin')

@section('title', 'لیست محصولات')


@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}" title="پیشخوان">پیشخوان</a></li>
            <li><a href="{{ route('admin.products.index') }}" title=" دوره ها" class="is-active">محصولات</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active">لیست محصولات</a>
                <!-- <a class="tab__item" href="">محصولات تایید شده</a>
                                                                                                                                                                                                                                                                    <a class="tab__item" href="">محصولات تایید نشده</a> -->
                <a class="tab__item" href="{{ route('admin.products.create') }}">ایجاد محصول جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="t-header-search">
                <form id="product-filter-form" action="{{ route('admin.products.index') }}" method="POST">
                    @csrf
                    <div class="t-header-searchbox font-size-13">
                        <div type="text" class="text search-input__box ">جستجوی محصول</div>
                        <div class="t-header-search-content ">
                            <input type="text" name="title" class="text" placeholder="نام محصول">
                            <input type="text" name="id" class="text" placeholder="شناسه">
                            <input type="text" name="minPrice" class="text" placeholder="کمترین قیمت">
                            <input type="text" name="maxPrice" class="text" placeholder="بیشترین قیمت">
                            <select name="category_id" id="">
                                <option value="" selected disabled>انتخاب دسته بندی</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-netcopy_net">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- {{ $message = flash('search_filter') }}
            @if (!empty($message))
                <h4 style="color:green">{{ $message }}</h4>
            @endif --}}
        </div>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>عکس</th>
                        <th>عنوان</th>
                        <th>دسته بندی پدر</th>
                        <th>دسته بندی</th>
                        <th>قیمت</th>
                        <th>تعداد</th>
                        <th>نظرات</th>
                        <th>موجود</th>
                        <th>درصد فروش</th>
                        <th>وضعیت محصول</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr role="row">
                            <td><a href="">{{ $product->id }}</a></td>
                            <td><img class="product-image" src="{{ Storage::url($product->thumbnail) }}" alt="">
                            </td>
                            <td><a href="">{{ $product->title }}</a></td>

                            <td><a href=""
                                    class="color-2b4a83">{{ $product->category->parent ? $product->category->parent->name : 'بدون دسته' }}</a>
                            </td>

                            <td><a href=""
                                    class="color-2b4a83">{{ $product->category ? $product->category->name : 'بدون دسته' }}</a>
                            </td>

                            <td><a href="" class="color-2b4a83">{{ number_format($product->price) }}</a></td>

                            <td><a href="" class="color-2b4a83">{{ $product->stock }}</a></td>
                            <td>{{ $product->comment_count }}</td>
                            <td>
                                {{ $stock = $product->stock == null || $product->stock == 0 ? 'نیست' : 'هست' }}</td>
                            <td>در حال بروزرسانی</td>
                            @if ($product->status == 'approved')
                                <td style="color:#28a745">تایید شده(منتشر شده)</td>
                            @elseif($product->status == 'pending')
                                <td style="color:#ffc107">در صف انتشار<br>(منتظر تایید)</td>
                            @elseif($product->status == 'unseen')
                                <td style="color:#dc3545">بررسی نشده</td>
                            @endif
                            <td>
                                <button type="button" class="mlg-15 btn-product-action item-delete"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('admin.products.destroy', $product->id) }}" data-action="delete"
                                    title="حذف" style="background:none; border:none; cursor:pointer; color:inherit;">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <button type="button"
                                    class="mlg-15 btn-product-toggle {{ $product->status === 'approved' ? 'item-reject' : 'item-confirm' }}"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('admin.products.toggle', $product->id) }}"
                                    data-status="{{ $product->status }}"
                                    title="{{ $product->status === 'approved' ? 'رد کردن' : 'تایید کردن' }}"
                                    style="background:none; border:none; cursor:pointer; color:inherit;">
                                    <i class="fas fa-power-off"></i>
                                </button>
                                <a href="{{ route('admin.products.edit', [$product->id]) }}" target="_blank"
                                    class="item-eye mlg-15" title="مشاهده"></a>
                                <a href="{{ route('admin.products.edit', [$product->id]) }}" class="item-edit"
                                    title="ویرایش"></a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/js.js') }}"></script>

    {{-- AJAX حذف محصول --}}
    <script>
        $(document).on('click', '.btn-product-action.item-delete', function(e) {
            e.preventDefault();
            let btn = $(this);
            let url = btn.data('url');
            let row = btn.closest('tr');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این محصول حذف خواهد شد!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'بله، حذف شود',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            row.remove();
                            Swal.fire('حذف شد!', 'محصول با موفقیت حذف شد.', 'success');
                        },
                        error: function() {
                            Swal.fire('خطا!', 'مشکلی در حذف محصول پیش آمد.', 'error');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.btn-product-toggle', function(e) {
            e.preventDefault();
            let btn = $(this);
            let url = btn.data('url');
            let row = btn.closest('tr');
            let currentStatus = btn.data('status'); // active / pending / unseen

            let titleText = currentStatus === 'approved' ? 'آیا می‌خواهید این محصول رد شود؟' :
                'آیا می‌خواهید این محصول تایید شود؟';
            let confirmText = currentStatus === 'approved' ? 'بله، رد شود' : 'بله، تایید شود';
            let confirmButtonColor = currentStatus === 'approved' ? '#d33' : 'rgba(0, 177, 12, 1)';

            Swal.fire({
                title: titleText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#3085d6',
                confirmButtonText: confirmText,
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // ستون وضعیت محصول
                            let statusTd = row.find('td').eq(
                                10); // شماره ستون وضعیت را با جدول شما تنظیم کنید
                            if (response.status === 'approved') {
                                statusTd.html(
                                    '<span class="badge badge-success" style="color:#28a745">تایید شده <br> (منتشر شده)</span>'
                                );
                            } else if (response.status === 'pending') {
                                statusTd.html(
                                    '<span class="badge badge-pending"  style="color:#ffc107">در صف انتشار<br>(منتظر تایید)</span>'
                                );
                            } else {
                                statusTd.html(
                                    '<span class="badge badge-unseen"  style="color:#dc3545">بررسی نشده</span>'
                                );
                            }

                            // آپدیت دکمه‌ها
                            let newBtnHtml = '';
                            if (response.status === 'approved') {
                                newBtnHtml = `<button type="button" class="mlg-15 btn-product-toggle item-reject" 
                            data-id="${btn.data('id')}" 
                            data-url="${btn.data('url')}" 
                            data-status="approved" 
                            title="رد کردن" 
                            style="background:none; border:none; cursor:pointer; color:inherit;">
                            <i class="fas fa-power-off"></i>
                        </button>`;
                            } else if (response.status === 'pending') {
                                newBtnHtml = `<button type="button" class="mlg-15 btn-product-toggle item-confirm" 
                            data-id="${btn.data('id')}" 
                            data-url="${btn.data('url')}" 
                            data-status="pending" 
                            title="تایید کردن" 
                            style="background:none; border:none; cursor:pointer; color:inherit;">
                            <i class="fas fa-power-off"></i>
                        </button>`;
                            } else {
                                newBtnHtml = `<button type="button" class="mlg-15 btn-product-toggle item-confirm" 
                            data-id="${btn.data('id')}" 
                            data-url="${btn.data('url')}" 
                            data-status="unseen" 
                            title="تایید کردن" 
                            style="background:none; border:none; cursor:pointer; color:inherit;">
                            <i class="fas fa-power-off"></i>
                        </button>`;
                            }

                            btn.replaceWith(newBtnHtml);

                            Swal.fire(
                                response.status === 'approved' ? 'تایید شد!' : 'رد شد!',
                                'وضعیت محصول با موفقیت تغییر کرد.',
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire('خطا!', 'مشکلی در تغییر وضعیت محصول پیش آمد.', 'error');
                        }
                    });
                }
            });
        });
    </script>


@endsection
