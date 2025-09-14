<table class="table">
    <thead>
        <tr class="title-row">
            <th>شناسه</th>
            <th>عکس</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>ایمیل</th>
            <th>شماره موبایل</th>
            <th>سطح کاربری</th>
            <th>تاریخ عضویت</th>
            <th>آی‌پی</th>
            <th>وضعیت حساب</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><a href="#"><?= $user['id'] ?></a></td>
                <td><img class="profile-pic" src="<?= asset($user['image']) ?>" alt=""></td>
                <td><?= $user['first_name'] ?></td>
                <td><?= $user['last_name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['phone_number'] ?></td>
                <td><?= $user['permission'] ?? 'مشتری' ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>1.1.1.1</td>
                <td class="<?= $user['is_active'] == 1 ? 'text-error' : 'text-success' ?>">
                    <?= $user['is_active'] == 1 ? 'تایید نشده' : 'تایید شده' ?>
                </td>
                <td>
                    <a href="<?= url('admin/customers/delete/' . $user['id']) ?>" class="item-delete mlg-15" title="حذف"></a>
                    <a href="<?= url('admin/customers/confirm/' . $user['id']) ?>" class="item-confirm mlg-15" title="تایید"></a>
                    <a href="<?= url('admin/customers/not-confirm/' . $user['id']) ?>" class="item-reject mlg-15" title="رد"></a>
                    <a href="edit-user.html" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                    <a href="<?= url('admin/profile/customer/edit/' . $user['id']) ?>" class="item-edit" title="ویرایش"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
