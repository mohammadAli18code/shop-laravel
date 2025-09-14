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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...زیاد..." crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<style>
.toggle-icon {
    font-size: 16px;
    margin-left: 8px;
    transition: transform 0.3s ease;
    cursor: pointer;
    color: #444;
}

.toggle-icon.collapsed {
    transform: rotate(-90deg);
}

.clickable-row {
    cursor: pointer;
}

/* .subcategory {
    transition: all 0.3s ease;
    overflow: hidden;
} */

/* کادر دسته اصلی */
.parent-category {
  border: 1px solid #ccc;
  background-color: #f9f9f9;
  transition: background-color 0.3s ease;
}

.parent-category:hover {
  border: 3px solid #ccc;
  background-color: #55c8e8ff;
  transition: background-color 0.3s ease;
}
.parent-category.active {
    border-top: 3px solid #3a6df0; /* مشکی پررنگ */
    border-right: 3px solid #3a6df0; /* مشکی پررنگ */
    background-color: #eef1f7;     /* یه رنگ روشن ملایم دلخواه */
}

/* کادر فرزندان زمانی که نمایش داده شدند */
.subcategory {
  background-color: #c1cde9ff; /* رنگ خیلی روشن آبی */
  border-left: 3px solid #3a6df0; /* یک نوار رنگی سمت چپ */
  padding-left: 15px;
  transition: background-color 0.3s ease;
}
.subcategory:hover {
  background-color: #abbef3ff; /* رنگ خیلی روشن آبی */
  border-right: 3px solid #ff2600ff; /* یک نوار رنگی سمت چپ */
}

/* فاصله زیرمجموعه‌ها نسبت به والد */
.subcategory:not(:last-child) {
  border-bottom: 1px solid #ddd;
}

</style>


<body>
    <!-- sidebar -->
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
                <li><a href="<?= url('admin/categories') ?>" class="is-active">دسته بندی ها</a></li>
            </ul>
        </div>
        <?php $message = flash('create_category');
        if(!empty($create_message)){
        ?>
        <h3 class="text-success"><?= $create_message ?></h3>
    
        <?php } $delete_message = flash('delete_category');
        if(!empty($delete_message)){
        ?>
        <h3 class="text-success"><?= $delete_message ?></h3>

        <?php } ?>

        <div class="main-content padding-0 categories">
            <div class="row no-gutters  ">
                <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                    <p class="box__title">دسته بندی ها</p>
                    <div class="table__box">
                    <table class="table">
                        <thead>
                            <tr class="title-row">
                                <th>شناسه</th>
                                <th>نام دسته‌بندی</th>
                                <th>نام انگلیسی</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <?php if ($category['parent_id'] == null): ?>
                                        <tr class="parent-category clickable-row" data-target="<?= $category['id'] ?>">
                                            <td><?= $category['id'] ?></td>
                                            <td>
                                                <i class="fas fa-chevron-down toggle-icon collapsed"></i>
                                                <?= $category['name'] ?>
                                            </td>
                                            <td><?= $category['english_name'] ?></td>
                                            <td>
                                                <a href="#" class="item-delete mlg-15 btn-delete-category" data-id="<?= $category['id'] ?>" title="حذف"></a>
                                                <a href="<?= url('admin/category/edit/' . $category['id']) ?>" class="item-edit" title="ویرایش"></a>
                                            </td>
                                        </tr>


                                    <!-- زیرمجموعه‌ها -->
                                    <?php foreach ($categories as $sub): ?>
                                        <?php if ($sub['parent_id'] == $category['id']): ?>
                                            <tr class="subcategory sub-of-<?= $category['id'] ?>" style="display: none;">
                                                <td><?= $sub['id'] ?></td>
                                                <td class="pl-4">↳ <?= $sub['name'] ?></td>
                                                <td><?= $sub['english_name'] ?></td>
                                                <td>
                                                    <a href="#" class="item-delete mlg-15 btn-delete-category" data-id="<?= $sub['id'] ?>" title="حذف"></a>
                                                    <a href="<?= url('admin/category/edit/' . $sub['id']) ?>" class="item-edit" title="ویرایش"></a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    </div>
                    <!-- check empty category list -->
                    <?php if (empty($categories)) { ?>
                        <h3 style="color:white;font-family:serif;margin-top:10px">هیچ دسته بندی ای یافت نشد!</h3>
                    <?php } ?>

                </div>
                <div class="col-4 bg-white">
                    <p class="box__title">ایجاد دسته بندی جدید</p>
                    <form id="categoryForm" action="<?= url('category/create') ?>" method="post" class="padding-30">
                        <input type="text" name="name" placeholder="نام دسته بندی" class="text">
                        <input type="text" name="english_name" placeholder="نام انگلیسی دسته بندی" class="text">
                        <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
                        <select name="parent_id" id="">
                            <option value="">اصلی</option>
                            <?php foreach ($categoryList as $category) { ?>
                                <option value="<?= $category['id'] ?>">
                                    <?= $category['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-netcopy_net">اضافه کردن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?= asset('public/admin-panel/js/jquery-3.4.1.min.js') ?>"></script>
<script src="<?= asset('public/admin-panel/js/js.js') ?>"></script>
<script src="<?= asset('public/admin-panel/js/tagsInput.js') ?>"></script>

<script>
    document.addEventListener('click', function (e) {
        const target = e.target.closest('.btn-delete-category');
        if (!target) return;

        e.preventDefault();

        const categoryId = target.dataset.id;
        if (!categoryId) return;

        if (!confirm("آیا از حذف این دسته بندی مطمئن هستید؟")) return;

        $.ajax({
            url: `<?= url('admin/category/delete/') ?>/${categoryId}`, // مثلاً: admin/category/delete/12
            method: "POST",
            data: { category_id: categoryId }, // اگر سمت سرور نیاز داره
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert(res.message || "✅ دسته‌بندی با موفقیت حذف شد.");
                        target.closest('tr').remove(); // حذف ردیف دسته‌بندی از جدول
                    } else {
                        alert(res.message || "❌ عملیات حذف با خطا مواجه شد.");
                    }
                } catch (err) {
                    alert("❌ پاسخ سرور نامعتبر بود.");
                }
            },
            error: function () {
                alert("❌ خطا در ارتباط با سرور.");
            }
        });
    });

</script>

<script>
document.getElementById('categoryForm').addEventListener('submit', function(event) {
    event.preventDefault(); // جلوگیری از ارسال فرم عادی

    // گرفتن مقادیر
    const name = this.elements['name'].value.trim();
    const englishName = this.elements['english_name'].value.trim();
    const parentId = this.elements['parent_id'].value;

    // اعتبارسنجی ساده
    if (!name) {
        alert('نام دسته بندی الزامی است.');
        return;
    }
    if (!englishName) {
        alert('نام انگلیسی الزامی است.');
        return;
    }

    // آماده کردن داده‌ها برای ارسال
    const formData = new FormData(this);

    // ارسال با Fetch API
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('✅ دسته‌بندی با موفقیت اضافه شد!');
            location.reload(); // یا فقط بروزرسانی جدول بدون رفرش کامل
        } else {
            alert('❌ خطا: ' + (data.message || 'خطایی رخ داده است.'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ خطایی در ارتباط با سرور رخ داده است.');
    });
});
</script>


<script>
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', function (e) {
            if (e.target.closest('a')) return;

            const parentId = this.dataset.target;
            const icon = this.querySelector('.toggle-icon');
            const subRows = document.querySelectorAll(`.sub-of-${parentId}`);

            const isCollapsed = icon.classList.toggle('collapsed');

            // تغییر کلاس فعال (border-bottom مشکی)
            if (!isCollapsed) {
                this.classList.add('active');
            } else {
                this.classList.remove('active');
            }

            subRows.forEach(sub => {
                if (!isCollapsed) {
                    sub.style.display = 'table-row';
                    sub.style.opacity = 0;
                    sub.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => sub.style.opacity = 1, 10);
                } else {
                    sub.style.transition = 'opacity 0.3s ease';
                    sub.style.opacity = 0;
                    setTimeout(() => sub.style.display = 'none', 300);
                }
            });
        });
    });

</script>
<script>
$(document).on('click', '.btn-delete-category', function(e) {
    e.preventDefault();

    if (!confirm('آیا از حذف دسته بندی مطمئن هستید؟')) return;

    const id = $(this).data('id');
    const $row = $(this).closest('tr');

    $.ajax({
        url: "<?= url('admin/category/delete') ?>/" + id,
        type: 'POST',
        data: {
            _method: 'DELETE' // یا فقط id، بستگی داره PHP سمت سرور چجوری هندل کنه
        },
        success: function(response) {
            $row.css('background', '#f8d7da'); // قرمز کم‌رنگ قبل از حذف
            $row.fadeOut(300, function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            alert('خطا در حذف! دوباره تلاش کنید.');
        }
    });
});
</script>


</html>