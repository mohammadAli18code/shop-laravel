<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <title>قالب پنل مدیریت |نت کپی</title>
    <link rel="stylesheet" href="<?= asset('public/admin-panel/css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/admin-panel/css/responsive_991.css') ?>" media="(max-width:991px)">
    <link rel="stylesheet" href="<?= asset('public/admin-panel/css/responsive_768.css') ?>" media="(max-width:768px)">
    <link rel="stylesheet" href="<?= asset('public/admin-panel/css/font.css') ?>">
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            color: #fff;
            display: inline-block;
        }
        .badge-success { background-color: #28a745; }
        .badge-pending { background-color: #ffc107; }
        .badge-unseen { background-color: #ff0707ff; }
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
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
</head>

<body>
<?php require_once(BASE_PATH . '/views/panel/layouts/sidebar.php'); ?>

<div class="content">
<?php require_once(BASE_PATH . '/views/panel/layouts/header.php'); ?>

    <div class="breadcrumb">
        <ul>
            <li><a href="<?= url('admin/dashboard') ?>">پیشخوان</a></li>
            <li><a href="<?= url('admin/comments') ?>" class="is-active">نظرات</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="btn-comment-status tab__item is-active" href="<?= url('admin/comments') ?>" data-action="all">همه نظرات</a>
                <a class="btn-comment-status tab__item" href="<?= url('admin/comments') ?>" data-action="approved">تایید شده</a>
                <a class="btn-comment-status tab__item" href="<?= url('admin/comments') ?>" data-action="seen">در انتظار تایید</a>
                <a class="btn-comment-status tab__item" href="<?= url('admin/comments') ?>" data-action="unseen">بررسی نشده</a>
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
                    <?php foreach($comments as $comment): ?>
                        <tr id="comment-row-<?= $comment['id'] ?>">
                            <td><?= $comment['id'] ?></td>
                            <td><?= $comment['first_name'] . ' ' . $comment['last_name'] ?></td>
                            <td><?= $comment['customer_id'] ?></td>
                            <td><?= $comment['title'] ?></td>
                            <td><?= $comment['product_id'] ?></td>
                            <td>
                                <span><?= mb_substr($comment['comment'], 0, 50) ?>...</span><br>
                                <a href="#" class="view-full-btn open-modal" data-comment="<?= htmlspecialchars($comment['comment']) ?>">مشاهده کامل</a>
                            </td>
                            <td><?= time_elapsed_string($comment['created_at']) ?></td>
                            <td>
                                <?php if($comment['status'] == 'approved'): ?>
                                    <span class="badge badge-success">تایید شده</span>
                                <?php elseif($comment['status'] == 'unseen'): ?>
                                    <span class="badge badge-unseen">بررسی نشده</span>
                                <?php else: ?>
                                    <span class="badge badge-pending">در انتظار تایید</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="#" class="ajax-comment-action item-delete mlg-15" data-id="<?= $comment['id'] ?>" data-action="delete" title="حذف"></a>
                                <a href="#" class="ajax-comment-action item-reject mlg-15" data-id="<?= $comment['id'] ?>" data-action="reject" title="رد"></a>
                                <?php if ($comment['status'] != 'approved'): ?>
                                    <a href="#" class="ajax-comment-action item-confirm mlg-15" data-id="<?= $comment['id'] ?>" data-action="approve" title="تایید"></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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

</body>
<script src="<?= asset('public/admin-panel/js/jquery-3.4.1.min.js') ?>"></script>
<script src="<?= asset('public/admin-panel/js/js.js') ?>"></script>
<script>
    document.addEventListener('click', function (e) {
        const target = e.target.closest('.btn-comment-status');
        if (!target) return;

        e.preventDefault();
            const status = target.dataset.action;
            $.ajax({
                type: 'GET',
                url: `<?= url("admin/comments/") ?>/${status}`,
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
    $(document).ready(function () {
        $('.open-modal').click(function (e) {
            e.preventDefault();
            var comment = $(this).data('comment');
            $('#modalText').text(comment);
            $('#commentModal').css('display', 'flex');
        });
        $('#closeModal').click(function () {
            $('#commentModal').fadeOut();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // لودر
    const $loader = $('<div class="loader" style="display: none; text-align: center; padding: 20px;">در حال بارگذاری...</div>');
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
            url: `<?= url("admin/comments/") ?>/${status}`,
            dataType: 'json', // مشخص کردن نوع پاسخ به‌صورت JSON
            success: function(response) {
                $loader.hide();
                if (response.success && Array.isArray(response.comments)) {
                    let html = '';
                    response.comments.forEach(comment => {
                        // ساخت HTML برای هر نظر
                        const statusBadge = comment.status === 'approved'
                            ? '<span class="badge badge-success">تایید شده</span>'
                            : comment.status === 'unseen'
                            ? '<span class="badge badge-unseen">بررسی نشده</span>'
                            : '<span class="badge badge-pending">در انتظار تایید</span>';

                        const approveBtn = comment.status !== 'approved'
                            ? `<a href="#" class="ajax-comment-action item-confirm mlg-15" data-id="${comment.id}" data-action="approve" title="تایید"></a>`
                            : '';

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
                    $('table tbody').html('<tr><td colspan="9" class="text-center">نظری یافت نشد</td></tr>');
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
            delete: { title: 'آیا مطمئن هستید؟', text: 'این نظر برای همیشه حذف خواهد شد!' },
            approve: { title: 'تایید نظر', text: 'آیا این نظر تایید شود؟' },
            reject: { title: 'رد نظر', text: 'آیا این نظر رد شود؟' }
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
                    url: `<?= url('admin/comment/') ?>/${action}/${commentId}`,
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { id: commentId, action: action },
                    success: function(res) {
                        $loader.hide();
                        if (res.success) {
                            if (action === 'delete') {
                                row.fadeOut(300, function() { $(this).remove(); });
                                Swal.fire('موفقیت', res.message || 'نظر با موفقیت حذف شد.', 'success');
                            } else {
                                const statusTd = row.find('td').eq(7);
                                const actionsTd = row.find('td').eq(8);
                                if (action === 'approve') {
                                    statusTd.html('<span class="badge badge-success">تایید شده</span>');
                                    row.find('.item-confirm').remove();
                                } else if (action === 'reject') {
                                    statusTd.html('<span class="badge badge-pending">در انتظار تایید</span>');
                                    if (!row.find('.item-confirm').length) {
                                        actionsTd.append(
                                            `<a href="#" class="ajax-comment-action item-confirm mlg-15" data-id="${commentId}" data-action="approve" title="تایید"></a>`
                                        );
                                    }
                                }
                                Swal.fire('موفقیت', res.message || 'وضعیت با موفقیت به‌روزرسانی شد.', 'success');
                            }
                        } else {
                            Swal.fire('خطا', res.message || 'عملیات با خطا مواجه شد.', 'error');
                        }
                    },
                    error: function(xhr) {
                        $loader.hide();
                        Swal.fire('خطا', `خطا در ارتباط با سرور: ${xhr.status}`, 'error');
                    }
                });
            }
        });
    });
});
</script>



</html>