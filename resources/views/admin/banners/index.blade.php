@extends('layouts.admin')

@section('title', 'لیست بنر ها')

@section('css')

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.banners.index') }}" class="is-active">بنر ها</a></li>
        </ul>
    </div>

    @if (session('success'))
        <h3 class="text-success">
            {{ session('success') }}
        </h3>
    @elseif(session('error'))
        <h3 class="text-error">
            {{ session('error') }}
        </h3>
    @endif
    <!-- alerts -->

    {{-- {{ $failed_update_message = flash('update_banner_failed') }}
    @if (!empty($failed_update_message))
    <h3 class="text-error">{{ $failed_update_message }}</h3>
    @endif
    {{ $success_update_message = flash('update_banner_success') }}
    @if (!empty($success_update_message)) 
    <h3 class="text-success">{{ $success_update_message }}</h3>
    @endif
    {{ $failed_delete_message = flash('delete_banner_failed') }} 
    @if (!empty($failed_delete_message))
    <h3 class="text-error">{{ $failed_delete_message }}</h3>
    @endif
    {{ $success_delete_message = flash('delete_banner_success') }}
    @if (!empty($success_delete_message))
    <h3 class="text-success">{{ $success_delete_message }}</h3>
    @endif --}}

    <!-- end alerts -->

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin.banners.index') }}">لیست بنر ها</a>
                <a class="tab__item " href="{{ route('admin.banners.create') }}">ایجاد بنر جدید</a>
            </div>
        </div>
        <div class="table__box">
            <table class="table">

                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th class="p-r-90">شناسه</th>
                        <th>عنوان</th>
                        <th>تصویر</th>
                        <th>لینک</th>
                        <th>تاریخ ایجاد</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $banner)
                        <tr role="row" class="">
                            <td><a href="">{{ $banner->id }}</a></td>
                            <td><a href="">{{ $banner->title }}</a></td>
                            <td><a href=""><img class="img__slideshow" src="{{ asset($banner->image) }}"alt=""></a>
                            </td>
                            <td><a href=""> {{ $banner->url }}</a></td>
                            <td>{{ $banner->created_at }}</td>
                            @if ($banner->status == 'inactive')
                                <td class="text-error">غیر فعال</td>
                            @elseif($banner->status == 'active')
                                <td class="text-success">فعال</td>
                            @endif
                            <td>
                                <button type="button" class="item-delete mlg-15 btn-banner-action"
                                    data-id="{{ $banner->id }}"
                                    data-url="{{ route('admin.banners.destroy', $banner->id) }}" data-action="delete"
                                    title="حذف" style="background:none; border:none; cursor:pointer; color:inherit;">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button type="button"
                                    class="btn-toggle-active mlg-15 {{ $banner->status === 'active' ? 'item-reject' : 'item-confirm' }}"
                                    data-id="{{ $banner->id }}"
                                    data-url="{{ route('admin.banners.toggle', $banner->id) }}"
                                    data-status="{{ $banner->status }}"
                                    title="{{ $banner->status === 'active' ? 'غیرفعال کردن' : 'فعال کردن' }}"
                                    style="background:none; border:none; cursor:pointer; color:inherit;">
                                    <i class="fas fa-power-off"></i>
                                </button>
                                <a href="{{ route('admin.banners.edit', [$banner->id]) }}" target="_blank"
                                    class="item-eye mlg-15" title="مشاهده"></a>
                                {{-- <a href="#" class="item-confirm mlg-15 btn-banner-action"
                                    data-id="{{ $banner->id }}" data-action="active" title="تایید"></a> --}}
                                <a href="{{ route('admin.banners.edit', [$banner->id]) }}" class="item-edit"
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
    <script src="{{ asset('admin/assets/js/tagsInput.js') }}"></script>

    {{-- delete --}}
    <script>
        $(document).on('click', '.btn-banner-action', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            let row = $(this).closest('tr');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این بنر حذف خواهد شد!",
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
                            Swal.fire(
                                'حذف شد!',
                                'بنر با موفقیت حذف شد.',
                                'success'
                            )
                        },
                        error: function() {
                            Swal.fire(
                                'خطا!',
                                'مشکلی در حذف بنر پیش آمد.',
                                'error'
                            )
                        }
                    });
                }
            });
        });
    </script>
    {{-- change status --}}
    <script>
        $(document).on('click', '.btn-toggle-active', function(e) {
            e.preventDefault();
            let btn = $(this);
            let url = btn.data('url');
            let row = btn.closest('tr'); // ردیف کامل
            let status = btn.data('status'); // active یا inactive

            let titleText = status === 'active' ? 'آیا مطمئن هستید میخواهید غیرفعال شود؟' :
                'آیا مطمئن هستید میخواهید فعال شود؟';
            let confirmText = status === 'active' ? 'بله، غیرفعال شود' : 'بله، فعال شود';
            let confirmButtonColor = status === 'active' ? '#d33' : 'rgba(0, 177, 12, 1)';

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
                            // آپدیت ستون وضعیت
                            let statusTd = row.find('td').eq(5); // ستون وضعیت
                            if (response.status === 'active') {
                                statusTd.text('فعال').removeClass('text-error').addClass(
                                    'text-success');
                            } else {
                                statusTd.text('غیر فعال').removeClass('text-success').addClass(
                                    'text-error');
                            }

                            // آپدیت دکمه خودش در جدول
                            let newBtnHtml = '';
                            if (response.status === 'active') {
                                newBtnHtml = `
                                    <button type="button" class="item-reject mlg-15 btn-toggle-active"
                                        data-id="${btn.data('id')}"
                                        data-url="${btn.data('url')}"
                                        data-status="active"
                                        title="غیرفعال کردن"
                                        style="background:none; border:none; cursor:pointer; color:inherit;">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                `;
                            } else {
                                newBtnHtml = `
                                    <button type="button" class="item-confirm mlg-15 btn-toggle-active"
                                        data-id="${btn.data('id')}"
                                        data-url="${btn.data('url')}"
                                        data-status="inactive"
                                        title="فعال کردن"
                                        style="background:none; border:none; cursor:pointer; color:inherit;">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                `;
                            }

                            btn.replaceWith(newBtnHtml);

                            // پیام موفقیت
                            Swal.fire(
                                response.status === 'active' ? 'فعال شد!' : 'غیرفعال شد!',
                                'بنر با موفقیت ' + (response.status === 'active' ?
                                    'فعال شد.' : 'غیرفعال شد.'),
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire('خطا!', 'مشکلی در تغییر وضعیت بنر پیش آمد.', 'error');
                        }
                    });
                }
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-banner-action');
            if (!target) return;

            e.preventDefault();

            const bannerId = target.dataset.id;
            const action = target.dataset.action;

            if (!bannerId || !action) return;

            // تاییدیه‌ها
            if (action === 'delete' && !confirm('آیا از حذف این بنر مطمئن هستید؟')) return;
            if (action === 'active' && !confirm('آیا از تایید این بنر مطمئن هستید؟')) return;
            if (action === 'not-active' && !confirm('آیا از رد این بنر مطمئن هستید؟')) return;

            $.ajax({
                url: `<?= url('admin/banner/') ?>/${action}/${bannerId}`, // مثل: admin/banner/delete/3
                method: 'POST',
                data: {
                    banner_id: bannerId
                },
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            alert(res.message || 'عملیات با موفقیت انجام شد.');

                            // حذف ردیف اگر حذف شد
                            if (action === 'delete') {
                                target.closest('tr').remove();
                            } else {
                                // بروزرسانی وضعیت بنر
                                const statusCell = target.closest('tr').querySelector(
                                'td:nth-child(6)');
                                statusCell.classList.remove('text-success', 'text-error');
                                statusCell.style.color = '';

                                if (action === 'active') {
                                    statusCell.textContent = 'تایید شده';
                                    statusCell.classList.add('text-success');
                                } else if (action === 'not-active') {
                                    statusCell.textContent = 'تایید نشده';
                                    statusCell.classList.add('text-error');
                                }
                            }

                        } else {
                            alert(res.message || 'عملیات با خطا مواجه شد.');
                        }
                    } catch (e) {
                        alert('پاسخ سرور نامعتبر بود.');
                    }
                },
                error: function() {
                    alert('خطا در ارتباط با سرور.');
                }
            });
        });
    </script> --}}
@endsection
