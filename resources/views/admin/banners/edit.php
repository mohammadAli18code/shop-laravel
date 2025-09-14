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
    <script src="https://cdn.tailwindcss.com"></script>

    <style>


    </style>
</head>

<body>
<?php
    require_once(BASE_PATH . '/views/panel/layouts/sidebar.php');
    ?>

    <div class="content">

    <!-- header -->
    <?php
    require_once(BASE_PATH . '/views/panel/layouts/header.php');
    ?>
        <div class="breadcrumb">
            <ul>
                <li><a href="<?= url('admin/dashboard') ?>">پیشخوان</a></li>
                <li><a href="<?= url('admin/banners') ?>">بنر ها</a></li>
                <li><a href="<?= url('admin/banner/edit/' . $id) ?>" class="is-active">ویراریش بنر</a></li>
            </ul>
        </div>
        <?php if($_SESSION['adminInfo']['is_active'] == 2){ ?>

        <div class="main-content  ">
            <div class="user-info bg-white padding-30 font-size-13">
                <form action="<?= url('admin/banner/update/' . $banner['id']) ?>" method="POST" enctype="multipart/form-data">
                    <div class="w-full max-w-md mx-auto mb-6">
                        <label for="banner-upload" class="relative block rounded-xl overflow-hidden shadow-lg cursor-pointer group aspect-[16/9] bg-gray-100">
                            <img
                                id="banner-preview"
                                src="<?= asset($banner['image']) ?>"
                                alt="پیش‌نمایش بنر"
                                class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-white text-sm md:text-base font-semibold">برای تغییر بنر کلیک کنید</span>
                            </div>
                        </label>
                        <input type="file" id="banner-upload" name="image" accept="image/*" class="hidden">
                    </div>



                    <input class="text"            name="title" placeholder="عنوان" value="<?= $banner['title'] ?>">
                    <input class="text text-right" name="url"   placeholder="آدرس url"  value="<?= $banner['url']?>">
                    <br><br>
                    <button class="btn btn-netcopy_net">ذخیره تغییرات</button>
                </form>
            </div>

        </div>
    </div>
    <?php }else{ ?>
        <h4 style="color:red" ><?php echo '* توجه : ' . $_SESSION['adminInfo']['first_name'] . ' ' . 'جان ، ابتدا نسبت به فعالسازی حساب کاربری خود اقدام کنید' ; ?></h4>
    <?php } ?>
    
</body>
<script src="  <?= asset('public/admin-panel/js/jquery-3.4.1.min.js') ?> "></script>
<script src="  <?= asset('public/admin-panel/js/js.js') ?> "></script>

<script>
    document.getElementById('banner-upload').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('banner-preview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                preview.src = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</html>







<!-- <form action="<?= url('admin/profile/update/' . $customers['id']) ?>" method="POST" enctype="multipart/form-data">
                    <div class="profile__info border cursor-pointer text-center">
                       <div class="avatar__img"><img src="<?= asset($customers['image']) ?>" class="avatar___img">
                            <input type="file" name="image" accept="image/*" class="hidden avatar-img__input">
                            <div class="v-dialog__container" style="display: block;"></div>
                            <div class="box__camera default__avatar"></div>
                        </div>
                        <span class="profile__name"><?= $customers['first_name'] . ' ' . $customers['last_name'] ?></span>
                    </div><br>
                    <input class="text"            name="title" placeholder="عنوان"     value="<?= $customers['title'] ?>">
                    <input class="text text-right" name="url"   placeholder="آدرس url"  value="<?= $customers['url'] ?>">
                    <br><br>
                    <button class="btn btn-netcopy_net">ذخیره تغییرات</button>
                </form> -->