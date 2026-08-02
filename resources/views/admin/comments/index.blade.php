@extends('layouts.admin')

@section('title', 'لیست کامنت ها')

@section('css')
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            color: #fff;
            display: inline-block;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-pending {
            background-color: #ffc107;
        }

        .badge-unseen {
            background-color: #ff0707ff;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            left: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }

        .view-full-btn {
            display: inline-block;
            margin-top: 4px;
            padding: 4px 8px;
            background-color: #007bff;
            color: white;
            font-size: 12px;
            border-radius: 4px;
            text-decoration: none;
        }

        .view-full-btn:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.comments.index') }}" class="is-active">نظرات</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="btn-comment-status tab__item is-active" href="{{ route('admin.comments.index') }}"
                    data-action="all">همه نظرات</a>
                <a class="btn-comment-status tab__item" href="{{ route('admin.comments.index') }}"
                    data-action="approved">تایید شده</a>
                <a class="btn-comment-status tab__item" href="{{ route('admin.comments.index') }}" data-action="seen">در
                    انتظار تایید</a>
                <a class="btn-comment-status tab__item" href="{{ route('admin.comments.index') }}"
                    data-action="unseen">بررسی نشده</a>
            </div>
        </div>

        <div class="bg-white padding-20">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">نظرات</h2>

            <div class="table__box">
                <table class="table">
                    <thead>
                        <tr class="title-row">
                            <th>ردیف</th>
                            <th>ارسال کننده</th>
                            <th>شناسه کاربر</th>
                            <th>نام محصول</th>
                            <th>شناسه محصول</th>
                            <th>دیدگاه</th>
                            <th>تاریخ</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr id="comment-row-{{ $comment->id }}">
                                <td>{{ $comment->id }}</td>
                                <td>{{ $comment->user->first_name . ' ' . $comment->user->last_name }}</td>
                                <td>
                                    {{ $comment->user_id }}
                                    <br>
                                    <a href="{{ route('admin.users.edit', $comment->user_id) }}"
                                        class="view-full-btn">مشاهده کاربر
                                    </a>
                                </td>
                                <td>{{ $comment->title }}</td>
                                <td>{{ $comment->product_id }}</td>
                                <td>
                                    <span>{{ mb_substr($comment->comment, 0, 50) }}...</span><br>
                                    <a href="#" class="view-full-btn open-modal"
                                        data-comment="{{ htmlspecialchars($comment->content) }}">مشاهده کامل</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</td>
                                <td>
                                    @if ($comment->status === 'approved')
                                        <span class="badge badge-success">تایید شده</span>
                                    @elseif($comment->status === 'seen')
                                        <span class="badge badge-pending">در انتظار تایید</span>
                                    @elseif($comment->status === 'rejected')
                                        <span class="badge badge-unseen">رد شده</span>
                                    @elseif($comment->status === 'unseen')
                                        <span class="badge badge-pending">بررسی نشده</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="item-delete mlg-15 btn-comment-delete"
                                        data-id="{{ $comment->id }}"
                                        data-url="{{ route('admin.comments.destroy', $comment->id) }}" title="حذف"
                                        style="background:none; border:none; cursor:pointer; color:inherit;">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <button type="button"
                                        class="mlg-15 btn-comment-toggle {{ $comment->status === 'approved' ? 'item-reject' : 'item-confirm' }}"
                                        data-id="{{ $comment->id }}"
                                        data-url="{{ route('admin.comments.toggle', $comment->id) }}"
                                        data-status="{{ $comment->status }}"
                                        title="{{ $comment->status === 'approved' ? 'رد کردن' : 'تایید کردن' }}"
                                        style="background:none; border:none; cursor:pointer; color:inherit;">
                                        <i class="fas fa-power-off"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="commentModal">
        <div class="modal-content">
            <span class="close-modal" id="closeModal">×</span>
            <div id="modalText"></div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/js.js') }}"></script>
    {{-- reject & confirm --}}

    {{-- delete comment --}}
    <script>
        $(document).on('click', '.btn-comment-delete', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            let row = $(this).closest('tr');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این کامنت حذف خواهد شد!",
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
                                'کامنت با موفقیت حذف شد.',
                                'success'
                            )
                        },
                        error: function() {
                            Swal.fire(
                                'خطا!',
                                'مشکلی در حذف کامنت پیش آمد.',
                                'error'
                            )
                        }
                    });
                }
            });
        });
    </script>
    {{-- toggle comment status --}}
    <script>
        $(document).on('click', '.btn-comment-toggle', function(e) {
            e.preventDefault();
            let btn = $(this);
            let url = btn.data('url');
            let row = btn.closest('tr'); // ردیف کامل
            let currentStatus = btn.data('status'); // approved / unseen / pending

            let titleText = currentStatus === 'approved' ? 'آیا می‌خواهید این کامنت رد شود؟' :
                'آیا می‌خواهید این کامنت تایید شود؟';
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
                            // آپدیت ستون وضعیت
                            let statusTd = row.find('td').eq(7); // ستون وضعیت
                            if (response.status === 'approved') {
                                statusTd.html(
                                    '<span class="badge badge-success">تایید شده</span>');
                            } else if (response.status === 'unseen') {
                                statusTd.html(
                                    '<span class="badge badge-unseen">بررسی نشده</span>');
                            } else {
                                statusTd.html(
                                    '<span class="badge badge-pending">در انتظار تایید</span>'
                                );
                            }

                            // آپدیت دکمه خودش
                            let newBtnHtml = '';
                            if (response.status === 'approved') {
                                newBtnHtml = `
                            <button type="button" class="mlg-15 btn-comment-toggle item-reject"
                                data-id="${btn.data('id')}"
                                data-url="${btn.data('url')}"
                                data-status="approved"
                                title="رد کردن"
                                style="background:none; border:none; cursor:pointer; color:inherit;">
                                <i class="fas fa-power-off"></i>
                            </button>
                        `;
                            } else {
                                newBtnHtml = `
                            <button type="button" class="mlg-15 btn-comment-toggle item-confirm"
                                data-id="${btn.data('id')}"
                                data-url="${btn.data('url')}"
                                data-status="unapproved"
                                title="تایید کردن"
                                style="background:none; border:none; cursor:pointer; color:inherit;">
                                <i class="fas fa-power-off"></i>
                            </button>
                        `;
                            }

                            btn.replaceWith(newBtnHtml);

                            // پیام موفقیت
                            Swal.fire(
                                response.status === 'approved' ? 'تایید شد!' : 'رد شد!',
                                'وضعیت کامنت با موفقیت تغییر کرد.',
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire('خطا!', 'مشکلی در تغییر وضعیت کامنت پیش آمد.', 'error');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-comment-status');
            if (!target) return;

            e.preventDefault();
            const status = target.dataset.action;
            $.ajax({
                type: 'GET',
                url: `{{ url('admin/comments/') }}/${status}`,
                success: function(response) {
                    // فرض: پاسخ، فقط <tr>‌هاست
                    $('table tbody').html(response);
                },
                error: function(xhr) {
                    alert('خطا در ارتباط با سرور');
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.open-modal').click(function(e) {
                e.preventDefault();
                var comment = $(this).data('comment');
                $('#modalText').text(comment);
                $('#commentModal').css('display', 'flex');
            });
            $('#closeModal').click(function() {
                $('#commentModal').fadeOut();
            });
        });
    </script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    {{-- <script>
        $(document).ready(function() {
            // تابع برای escape کردن HTML برای جلوگیری از XSS
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) {
                    return map[m];
                });
            }

            // لودر
            const $loader = $(
                '<div class="loader" style="display: none; text-align: center; padding: 20px;">در حال بارگذاری...</div>'
            );
            $('.table__box').prepend($loader);

            // فیلتر کردن نظرات
            document.addEventListener('click', function(e) {
                const target = e.target.closest('.btn-comment-status');
                if (!target) return;

                e.preventDefault();
                const status = target.dataset.action;

                // تغییر حالت فعال برای تب‌ها
                $('.btn-comment-status').removeClass('is-active');
                $(target).addClass('is-active');

                $loader.show();
                $.ajax({
                    type: 'GET',
                    url: `{{ url('admin/comments/') }}/${status}`,
                    dataType: 'json', // مشخص کردن نوع پاسخ به‌صورت JSON
                    success: function(response) {
                        $loader.hide();
                        if (response.success && Array.isArray(response.comments)) {
                            let html = '';
                            response.comments.forEach(comment => {
                                // ساخت HTML برای هر نظر
                                const statusBadge = comment.status === 'approved' ?
                                    '<span class="badge badge-success">تایید شده</span>' :
                                    comment.status === 'unseen' ?
                                    '<span class="badge badge-unseen">بررسی نشده</span>' :
                                    '<span class="badge badge-pending">در انتظار تایید</span>';

                                const approveBtn = comment.status !== 'approved' ?
                                    `<a href="#" class="ajax-comment-action item-confirm mlg-15" data-id="${comment.id}" data-action="approve" title="تایید"></a>` :
                                    '';

                                html += `
                            <tr id="comment-row-${comment.id}">
                                <td>${comment.id}</td>
                                <td>${escapeHtml(comment.first_name + ' ' + comment.last_name)}</td>
                                <td>${comment.customer_id}</td>
                                <td>${escapeHtml(comment.title)}</td>
                                <td>${comment.product_id}</td>
                                <td>
                                    <span>${escapeHtml(comment.comment.substring(0, 50))}...</span><br>
                                    <a href="#" class="view-full-btn open-modal" data-comment="${escapeHtml(comment.comment)}">مشاهده کامل</a>
                                </td>
                                <td>${comment.created_at}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <a href="#" class="ajax-comment-action item-delete mlg-15" data-id="${comment.id}" data-action="delete" title="حذف"></a>
                                    <a href="#" class="ajax-comment-action item-reject mlg-15" data-id="${comment.id}" data-action="reject" title="رد"></a>
                                    ${approveBtn}
                                </td>
                            </tr>`;
                            });
                            $('table tbody').html(html);
                        } else {
                            Swal.fire('خطا', response.message || 'نظری یافت نشد', 'error');
                            $('table tbody').html(
                                '<tr><td colspan="9" class="text-center">نظری یافت نشد</td></tr>'
                            );
                        }
                    },
                    error: function(xhr) {
                        $loader.hide();
                        Swal.fire('خطا', `خطا در ارتباط با سرور: ${xhr.status}`, 'error');
                        console.log(xhr.responseText);
                    }
                });
            });

            // مدیریت مودال
            $(document).on('click', '.open-modal', function(e) {
                e.preventDefault();
                $('#modalText').text($(this).data('comment'));
                $('#commentModal').css('display', 'flex');
            });

            $('#closeModal').click(function() {
                $('#commentModal').fadeOut();
            });

            // مدیریت عملیات نظرات
            $(document).on('click', '.ajax-comment-action', function(e) {
                e.preventDefault();
                const btn = $(this);
                const commentId = btn.data('id');
                const action = btn.data('action');
                const row = $(`#comment-row-${commentId}`);

                const confirmMessages = {
                    delete: {
                        title: 'آیا مطمئن هستید؟',
                        text: 'این نظر برای همیشه حذف خواهد شد!'
                    },
                    approve: {
                        title: 'تایید نظر',
                        text: 'آیا این نظر تایید شود؟'
                    },
                    reject: {
                        title: 'رد نظر',
                        text: 'آیا این نظر رد شود؟'
                    }
                };

                Swal.fire({
                    title: confirmMessages[action].title,
                    text: confirmMessages[action].text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $loader.show();
                        $.ajax({
                            url: `{{ url('admin/comment/') }}/${action}/${commentId}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: commentId,
                                action: action
                            },
                            success: function(res) {
                                $loader.hide();
                                if (res.success) {
                                    if (action === 'delete') {
                                        row.fadeOut(300, function() {
                                            $(this).remove();
                                        });
                                        Swal.fire('موفقیت', res.message ||
                                            'نظر با موفقیت حذف شد.', 'success');
                                    } else {
                                        const statusTd = row.find('td').eq(7);
                                        const actionsTd = row.find('td').eq(8);
                                        if (action === 'approve') {
                                            statusTd.html(
                                                '<span class="badge badge-success">تایید شده</span>'
                                            );
                                            row.find('.item-confirm').remove();
                                        } else if (action === 'reject') {
                                            statusTd.html(
                                                '<span class="badge badge-pending">در انتظار تایید</span>'
                                            );
                                            if (!row.find('.item-confirm').length) {
                                                actionsTd.append(
                                                    `<a href="#" class="ajax-comment-action item-confirm mlg-15" data-id="${commentId}" data-action="approve" title="تایید"></a>`
                                                );
                                            }
                                        }
                                        Swal.fire('موفقیت', res.message ||
                                            'وضعیت با موفقیت به‌روزرسانی شد.',
                                            'success');
                                    }
                                } else {
                                    Swal.fire('خطا', res.message ||
                                        'عملیات با خطا مواجه شد.', 'error');
                                }
                            },
                            error: function(xhr) {
                                $loader.hide();
                                Swal.fire('خطا', `خطا در ارتباط با سرور: ${xhr.status}`,
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script> --}}

@endsection
