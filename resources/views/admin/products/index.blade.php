@extends('layouts.admin')

@section('title', 'home')


@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}" title="پیشخوان">پیشخوان</a></li>
            <li><a href="{{ route('admin.products') }}" title=" دوره ها" class="is-active">محصولات</a></li>
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
            <div class="t-header-search">
                <form id="product-filter-form" action="{{ route('admin/search/product') }}" method="POST">
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
                                @foreach ($categoryList as $category)
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
            {{ $message = flash('search_filter') }}
            @if (!empty($message))
                <h4 style="color:green">{{ $message }}</h4>
            @endif
        </div>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>ردیف</th>
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
                    {{ $i = 1 }}
                    @foreach ($products as $product)
                        <tr role="row">
                            <td><a href="">{{ $product->id }}</a></td>
                            <td><a href="">{{ $i }}</a></td>
                            {{ $i++ }}
                            <td><img class="product-image" src="{{ asset($product->thumbnail) }}" alt=""></td>
                            <td><a href="">{{ $product->title }}</a></td>

                            <td><a href="" class="color-2b4a83">{{ $product->category->parent }}</a></td>

                            <td><a href="" class="color-2b4a83">{{ $product->category_name }}</a></td>

                            <td><a href="" class="color-2b4a83">{{ number_format($product->price) }}</a></td>

                            <td><a href="" class="color-2b4a83">{{ $product->stock }}</a></td>
                            <td>{{ $product->comment_count }}</td>
                            <td>
                            {{ $stock = $product->stock == null || $product->stock == 0 ? 'نیست' : 'هست' }}
                            {{ echo $stock }}
                            ?></td>
                            <td>در حال بروزرسانی</td>
                            @if($product->status == 'approved')
                            <t class="text-success">منتشر شده</td>
                            @elseif($product->status == 'seen')
                            <td style="color:#ffc107">در صف انتشار<br>(منتظر تایید)</td>
                            @elseif($productInfo->status == 'unseen')
                            <td class="text-error">بررسی نشده</td>
                            @endif
                            <td>
                                <a href="#" class="item-delete mlg-15 btn-product-action" data-action="delete"
                                    data-id="{{ $product->id }}" title="حذف"></a>
                                <a href="#" class="item-reject mlg-15 btn-product-action" data-action="not-active"
                                    data-id="{{ $productInfo->id }}" title="رد"></a>
                                <a href="{{ route('admin.products.edit' , [$product->id]) }}" target="_blank"
                                    class="item-eye mlg-15" title="مشاهده"></a>
                                <a href="#" class="item-confirm mlg-15 btn-product-action" data-action="active"
                                    data-id="<?= $productInfo['id'] ?>" title="تایید"></a>
                                <a href="{{ route('admin.products.edit' , [$product->id]) }}" class="item-edit"
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
@section('scripts')
    <script src="  {{ asset('public/admin-panel/js/jquery-3.4.1.min.js') }}"></script>
    <script src="  {{ asset('public/admin-panel/js/js.js') }}"></script>
@endsection

<script>
        $(document).ready(function() {
            $('#product-filter-form').on('submit', function(e) {
                e.preventDefault(); // جلوگیری از ارسال عادی فرم

                const formData = $(this).serialize(); // جمع آوری داده‌ها

                $.ajax({
                    type: 'POST',
                    url: '<?= url('admin/search/product') ?>',
                    data: formData,
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
        });
</script>
<script>
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-product-action');
            if (!target) return;

            e.preventDefault();

            const productId = target.dataset.id;
            const action = target.dataset.action;

            if (!productId || !action) return;

            // تأییدیه‌ها بر اساس نوع اکشن
            if (action === 'delete' && !confirm('آیا از حذف این محصول مطمئن هستید؟')) return;
            if (action === 'active' && !confirm('آیا از فعال کردن این محصول مطمئن هستید؟')) return;
            if (action === 'not-active' && !confirm('آیا از غیرفعال کردن این محصول مطمئن هستید؟')) return;

            // ارسال AJAX
            $.ajax({
                url: `<?= url('admin/products/') ?>/${action}/${productId}`, // مثلا: admin/products/delete/12
                method: "POST",
                data: {
                    product_id: productId
                },
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            alert(res.message || "عملیات با موفقیت انجام شد.");

                            // حذف ردیف محصول فقط در صورت حذف شدن
                            if (action === 'delete') {
                                target.closest('tr').remove(); // حذف ردیف از جدول
                            } else {
                                // برای حالت‌های active / not-active فقط وضعیت را به‌روز کن
                                const statusCell = target.closest('tr').querySelector(
                                    'td:nth-child(12)');
                                // پاک کردن همه کلاس‌های رنگ قبلی
                                statusCell.classList.remove("text-success", "text-error");
                                statusCell.style.color = ""; // حذف استایل قبلی

                                if (action === 'active') {
                                    statusCell.textContent = "منتشر شده";
                                    statusCell.classList.add("text-success");
                                } else if (action === 'not-active') {
                                    statusCell.innerHTML = "در صف انتشار<br>(منتظر تایید)";
                                    statusCell.style.color = "#ffc107";
                                }
                            }

                        } else {
                            alert(res.message || "عملیات با خطا مواجه شد.");
                        }
                    } catch (e) {
                        alert("پاسخ سرور نامعتبر بود.");
                    }
                },

                error: function() {
                    alert("خطا در ارتباط با سرور.");
                }
            });
        });
</script>
    </html>
