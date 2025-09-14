<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://netcopy.ir"></a>
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img">
            <?php if(isset($_SESSION['adminInfo']['image'])){ ?>
            <img src="<?= asset($_SESSION['adminInfo']['image']) ?>" class="avatar___img">
            <?php } ?>
            <input type="file" accept="image/*" class="hidden avatar-img__input">
            <div class="v-dialog__container" style="display: block;"></div>
            <div class="box__camera default__avatar"></div>
        </div>
        <span
            class="profile__name"><?= $_SESSION['adminInfo']['first_name'] . ' ' . $_SESSION['adminInfo']['last_name'] ?></span>
    </div>
    <br>

    <ul>
        <li class="item-li i-dashboard <?= isActiveMenu('admin/dashboard') ?>"><a
                href="<?= url('admin/dashboard') ?>">پیشخوان</a></li>
        <li class="item-li i-users <?= isActiveMenu('admin/users') ?>"><a
                href="<?= url('admin/users/all') ?>">کاربران</a></li>
        <li class="item-li i-categories <?= isActiveMenu('admin/categories') ?>"><a
                href="<?= url('admin/categories') ?>">دسته بندی ها</a></li>
        <li class="item-li i-banners <?= isActiveMenu('admin/banners') ?>"><a href="<?= url('admin/banners') ?>">بنر
                ها</a></li>
        <li class="item-li i-comments <?= isActiveMenu('admin/comments') ?>"><a
                href="<?= url('admin/comments') ?>">نظرات</a></li>
        <li class="item-li i-comments <?= isActiveMenu('admin/products') ?>"><a
                href="<?= url('admin/products') ?>">محصولات</a></li>
        <li class="item-li i-discounts <?= isActiveMenu('admin/discounts') ?>"><a
                href="<?= url('admin/discounts') ?>">تخفیف ها</a></li>
        <li class="item-li i-transactions <?= isActiveMenu('admin/transactions') ?>"><a
                href="<?= url('admin/transactions') ?>">تراکنش ها</a></li>
        <li class="item-li i-discounts <?= isActiveMenu('admin/messages') ?>"><a
                href="<?= url('admin/messages') ?>">پیام ها</a></li>
        <li class="item-li i-user__inforamtion <?= isActiveMenu('admin/profile') ?>"><a
                href="<?= url('admin/profile/admin/edit/' . $_SESSION['adminInfo']['id']) ?>">اطلاعات کاربری</a></li>



        <li class="item-li "><a class="logout" href="<?= url('logout') ?>">خروج</a></li>

    </ul>

</div>
