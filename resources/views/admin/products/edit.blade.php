@extends('layouts.admin')

@section('title', 'home')
@section('css')
    <style>
        .upload-gallery-box {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .gallery-label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .gallery-note {
            color: #666;
            font-size: 12px;
            display: block;
            margin-top: 10px;
        }

        .gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .preview-image-container {
            position: relative;
            width: 90px;
            height: 90px;
        }

        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .remove-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* 📱 Responsive for smaller screens */
        @media (max-width: 600px) {
            .preview-image-container {
                width: 70px;
                height: 70px;
            }

            .upload-gallery-box {
                padding: 15px;
            }

            .gallery-label {
                font-size: 14px;
            }

            .gallery-note {
                font-size: 11px;
            }
        }

        .preview-color-container {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #ccc;
            padding: 8px 12px;
            border-radius: 8px;
            background: #fff;
            margin: 5px 0;
        }

        .color-box {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 1px solid #333;
        }

        .color-name {
            font-size: 13px;
            color: #333;
        }

        .remove-color-btn {
            background: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-right: auto;
        }

        .remove-color-btn:hover {
            background: #c10d00ff;
            transition: .3s;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.products.index') }}">محصولات</a></li>
            <li><a href="{{ route('admin.products.edit', [$product->id]) }}" class="is-active">ویرایش محصول</a>
            </li>
        </ul>
    </div>
    <div class="main-content  ">
        <div class="user-info bg-white padding-30 font-size-13">

            {{-- {{ $message = flash('update_alert') }}
            @if (!empty($message))
            <h3 class="text-error">{{ $message }}</h3>
            @endif --}}
            <form action="{{ route('admin.products.update', [$product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!--general info -->
                <h2 class="text-lg font-semibold text-gray-800 mb-4">ویرایش محصول</h2>

                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">اطلاعات کلی</h2>
                    <label for="">عنوان</label>
                    <input class="text" name="title" placeholder="عنوان" value="{{ $product->title }}">
                    <label for="">توضیحات</label>
                    <input class="text" name="description" placeholder="توضیحات" value="{{ $product->description }}">
                    <label for="">تعداد</label>
                    <input class="text" name="stock" placeholder="تعداد" value="{{ $product->stock }}">
                    <label for="">قیمت(تومان)</label>
                    <input class="text text-right" name="price" placeholder="قیمت(تومان)"
                        value="{{ number_format($product->price) }}">
                    <label class="block text-gray-700 font-semibold mb-2">دسته بندی</label>
                    <label for="">دسته بندی</label>
                    <select name="category_id" id="">
                        <option value="{{ $product->category->id }}" selected>
                            {{ $product->category->name }}
                        </option>
                        @foreach ($categories as $category)
                            @if ($category->parent_id != null && $category->id != $product->category->id)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>



                <!-- ویژگی‌های محصول -->
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mt-10">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">ویژگی‌های محصول</h2>

                    <!-- لیست ویژگی‌های فعلی -->
                    <div id="attributeList" class="space-y-3">
                        @foreach ($product->attributeValues as $attribute)
                            <div class="flex items-center justify-between px-4 py-2 bg-gray-50 border rounded-md attribute-item"
                                data-id="{{ $attribute->id }}">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <span class="font-semibold">{{ $attribute->name }}:</span>
                                    <span>{{ $attribute->value }}</span>
                                </div>
                                <button type="button" class="text-red-500 hover:text-red-700 text-lg"
                                    onclick="deleteAttribute({{ $attribute->id }}, this)">✖</button>
                            </div>
                        @endforeach
                        <!-- hidden inputs -->
                        <div id="attributeHiddenFields"></div>

                    </div>

                    <!-- افزودن ویژگی جدید -->
                    <div class="mt-8">
                        <h3 class="text-gray-800 font-bold mb-4">افزودن ویژگی جدید</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                            <input type="text" id="attributeName" placeholder="نام ویژگی (مثلاً جنس)"
                                class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-100">
                            <input type="text" id="attributeValue" placeholder="مقدار ویژگی (مثلاً پنبه)"
                                class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-100">
                            <button type="button" onclick="addAttribute({{ $product->id }})"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">افزودن
                                ویژگی</button>
                        </div>
                    </div>
                </div>
                <!--image -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">ویژگی‌های محصول</h2>

                    <!-- عکس‌های قبلاً ذخیره‌شده -->
                    <div class="">
                        <label class="block text-gray-700 font-semibold mb-2"> عکس های فعلی محصول:</label>
                        <div id="existingImages" class="gallery-preview">
                            @foreach ($product->images as $image)
                                <div class="preview-image-container" data-id="{{ $image->id }}">
                                    <img src="{{ asset($image->path) }}" class="preview-image">
                                    <button class="remove-btn" type="button"
                                        onclick="deleteImage({{ $image->id }} , this)">✖</button>
                                </div>
                            @endforeach
                            <div id="galleryPreview" class="gallery-preview"></div>

                        </div>
                    </div>
                    <hr class="my-6">
                    <!-- آپلود عکس‌های جدید (ثبت در دیتابیس فقط هنگام ارسال فرم) -->
                    <label class="block text-gray-700 font-semibold mb-2"> افزودن عکس جدید:</label>
                    <input type="file" id="galleryInput" name="gallery_images[]" accept="image/*" multiple>
                    <small class="gallery-note">حداکثر ۱۰ عکس قابل انتخاب است.</small>
                    <div id="galleryPreview" class="gallery-preview"></div>
                </div>
                <!-- color-->
                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">رنگ ها</h2>
                    <!-- پیش‌نمایش رنگ‌های قبلی -->
                    <div class="">
                        <label class="block text-gray-700 font-semibold mb-2">رنگ های فعلی محصول:</label>
                        <div id="productColorsPreview" class="gallery-preview">
                            @foreach ($product->colors as $color)
                                <div class="preview-color-container" data-id="{{ $color->id }}">
                                    <div class="color-box" style="background-color:{{ $color->hex_code }};"></div>
                                    <span class="color-name">{{ $color->name }}</span>
                                    <button type="button" class="remove-color-btn"
                                        onclick="deleteColor({{ $color->id }}, this)">✖</button>
                                </div>
                            @endforeach
                            <div id="customColorsPreview" class="flex flex-wrap gap-4"></div>
                            <div id="customColorsFields"></div>

                        </div>
                    </div>
                    <hr class="my-6">
                    <!-- رنگ‌های موجود (از دیتابیس) -->
                    <div class="">
                        <label class="block text-gray-700 font-semibold mb-2"> رنگ های موجود:</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                            @foreach ($colors as $color)
                                <label
                                    class="flex items-center gap-3 p-3 border rounded-lg shadow-sm cursor-pointer transition hover:shadow-md">
                                    <input type="checkbox" name="color_ids[]" value="{{ $color->id }}"
                                        class="form-checkbox text-indigo-500 w-5 h-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full border border-gray-400 shadow-inner"
                                            style="background-color:{{ $color->hex_code }}"></div>
                                        <span class="text-sm text-gray-800">{{ $color->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <hr class="my-6">
                    <!-- افزودن رنگ دلخواه -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">افزودن رنگ دلخواه:</label>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <input type="text" id="colorName" placeholder="نام رنگ"
                                class="w-full sm:w-1/2 px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-100">
                            <input type="color" id="colorCode" class="w-12 h-12 p-0 border rounded-md cursor-pointer">
                            <!-- <input type="hidden" name="custom_colors_names[]" value="">
                                                                                    <input type="hidden" name="custom_colors_hex[]" value=""> -->
                            <button type="button" id="addCustomColor"
                                class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 transition">
                                افزودن رنگ
                            </button>
                        </div>
                    </div>
                    <!-- پیش‌نمایش رنگ‌های اضافه‌شده -->
                    <div id="customColorsPreview" class="flex flex-wrap gap-4"></div>
                    <!-- فیلدهای hidden برای ارسال رنگ‌ها -->
                    <div id="customColorsFields"></div>
                </div>
                <button class="btn btn-netcopy_net">ذخیره تغییرات</button>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="  {{ asset('public/admin-panel/js/jquery-3.4.1.min.js') }}"></script>
    <script src="  {{ asset('public/admin-panel/js/js.js') }}"></script>
@endsection
<script>
    let attributes = []; // ویژگی‌های جدید اضافه‌شده

    function addAttribute(productId) {
        const name = document.getElementById('attributeName').value.trim();
        const value = document.getElementById('attributeValue').value.trim();

        if (!name || !value) return alert("نام و مقدار ویژگی را وارد کنید.");

        attributes.push({
            name,
            value
        });
        renderAttributes();

        document.getElementById('attributeName').value = '';
        document.getElementById('attributeValue').value = '';
    }

    function renderAttributes() {
        const preview = document.getElementById('attributeList');
        const hidden = document.getElementById('attributeHiddenFields');

        // حذف قبلی
        hidden.innerHTML = '';
        // نمایش ویژگی‌های جدید
        attributes.forEach((attr, index) => {
            const div = document.createElement('div');
            div.className = "flex items-center justify-between px-4 py-2 bg-gray-100 border rounded-md mb-2";
            div.innerHTML = `<span>${attr.name}: ${attr.value}</span>
                         <button type="button" onclick="removeAttribute(${index})">✖</button>`;
            preview.appendChild(div);

            // hidden inputs
            hidden.innerHTML += `<input type="hidden" name="attributes[${index}][name]" value="${attr.name}">
                             <input type="hidden" name="attributes[${index}][value]" value="${attr.value}">`;
        });
    }

    function removeAttribute(index) {
        attributes.splice(index, 1);
        renderAttributes();
    }

    // حذف ویژگی از دیتابیس
    function deleteAttribute(id, btn) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "این ویژگی حذف خواهد شد!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، حذف شود!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/admin/attributes/${id}/delete`, {
                        _method: 'DELETE'
                    })
                    .then(res => btn.closest('.attribute-item').remove())
                    .catch(err => Swal.fire('خطا', 'حذف انجام نشد', 'error'));
            }
        });
    }
</script>


<script>
    const galleryInput = document.getElementById("galleryInput");
    const galleryPreview = document.getElementById("galleryPreview");

    galleryInput.addEventListener("change", function() {
        const files = Array.from(this.files);
        files.forEach(file => {
            if (!file.type.startsWith("image/")) return;
            const reader = new FileReader();
            reader.onload = e => {
                const container = document.createElement("div");
                container.className = "preview-image-container";
                container.innerHTML =
                    `<img src="${e.target.result}" class="preview-image">
                                   <button type="button" class="remove-btn" onclick="removePreviewImage(this)">✖</button>`;
                galleryPreview.appendChild(container);
            }
            reader.readAsDataURL(file);
        });
    });

    function removePreviewImage(btn) {
        btn.closest('.preview-image-container').remove();
    }

    // حذف عکس از دیتابیس
    function deleteImage(id, btn) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "این عکس حذف خواهد شد!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then(result => {
            if (result.isConfirmed) {
                axios.post(`/admin/images/${id}/delete`, {
                        _method: 'DELETE'
                    })
                    .then(res => btn.closest('.preview-image-container').remove())
                    .catch(err => Swal.fire('خطا', 'حذف انجام نشد', 'error'));
            }
        });
    }
</script>


<script>
    let customColors = [];

    document.getElementById('addCustomColor').addEventListener('click', () => {
        const name = document.getElementById('colorName').value.trim();
        const code = document.getElementById('colorCode').value;
        if (!name) return alert("نام رنگ را وارد کنید.");
        customColors.push({
            name,
            code
        });
        renderCustomColors();
    });

    function renderCustomColors() {
        const preview = document.getElementById('customColorsPreview');
        const hidden = document.getElementById('customColorsFields');
        preview.innerHTML = '';
        hidden.innerHTML = '';
        customColors.forEach((color, index) => {
            preview.innerHTML += `<div class="preview-color-container">
                                <div class="color-box" style="background-color:${color.code}"></div>
                                <span>${color.name}</span>
                                <button type="button" onclick="removeCustomColor(${index})">✖</button>
                              </div>`;
            hidden.innerHTML += `<input type="hidden" name="custom_colors[${index}][name]" value="${color.name}">
                             <input type="hidden" name="custom_colors[${index}][hex]" value="${color.code}">`;
        });
    }

    function removeCustomColor(index) {
        customColors.splice(index, 1);
        renderCustomColors();
    }

    // حذف رنگ از دیتابیس
    function deleteColor(id, btn) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "این رنگ حذف خواهد شد!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then(result => {
            if (result.isConfirmed) {
                axios.post(`/admin/colors/${id}/delete`, {
                        _method: 'DELETE'
                    })
                    .then(res => btn.closest('.preview-color-container').remove())
                    .catch(err => Swal.fire('خطا', 'حذف انجام نشد', 'error'));
            }
        });
    }
</script>

</html>
