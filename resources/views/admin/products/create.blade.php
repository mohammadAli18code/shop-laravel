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

        .color-box {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ccc;
            cursor: pointer;
            position: relative;
        }

        .color-box .remove-color {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.products.index') }}">محصولات</a></li>
            <li><a href="{{ route('admin.products.create') }}" class="is-active">ایجاد محصول جدید</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item " href="{{ 'admin.products' }}">لیست محصولات</a>
                <a class="tab__item is-active" href="{{ route('admin.products.create') }}">ایجاد محصول جدید</a>
            </div>
        </div>
        <div class="user-info bg-white padding-30 font-size-13">
            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <h2 class="text-lg font-semibold text-gray-800 mb-4">ایجاد محصول جدید</h2>
                {{-- {{ $message = flash('sending_error') }}
                        @if (!empty($message))
                        <div class="text-error">
                            <h3>
                                {{ $message }}
                            </h3>
                        </div>
                        <@endif
                        @if (!empty($message))
                        <h3 class="text-error">*</h3>
                        @endif --}}
                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">اطلاعات کلی</h2>
                    <label for="">عنوان اصلی محصول</label>
                    <input class="text" name="title" placeholder="عنوان">
                    {{-- @if (!empty($message))
                            <h3 class="text-error">*</h3>
                            @endif --}}
                    <label for="">توضیحات محصول</label>
                    <input class="text text-right" name="description" placeholder="توضیحات">
                    <label for="">تعداد</label>
                    <input class="text text-right" name="stock" placeholder="تعداد">
                    <label for="">قیمت محصول(تومان)</label>
                    <input class="text text-right" name="price" placeholder="قیمت(تومان)">
                    <hr class="my-6">
                    <label class="block text-gray-700 font-semibold mb-2">دسته بندی</label>
                    <label for="">دسته بندی محصول</label>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <select name="category_id" id="">
                        <option value="" selected disabled>انتخاب دسته بندی</option>
                        @foreach ($child_categories as $category)
                            @if ($category->parent_id != null)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <!-- add attributes -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">افزودن ویژگی</h2>

                    <!-- ورودی افزودن ویژگی -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center mb-6">
                        <input type="text" id="attributeName" placeholder="نام ویژگی (مثلاً جنس)"
                            class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-100">
                        <input type="text" id="attributeValue" placeholder="مقدار ویژگی (مثلاً پنبه)"
                            class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-blue-100">
                        <button type="button" id="addAttributeBtn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">افزودن
                            ویژگی</button>
                    </div>

                    <!-- پیش‌نمایش ویژگی‌ها -->
                    <div id="attributePreview" class="space-y-2 mb-4"></div>

                    <!-- hidden inputs for attributes -->
                    <div id="attributeHiddenFields"></div>
                </div>

                <!-- add images -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <label for="galleryInput" class="gallery-label">افزودن عکس‌ (حداکثر 10 عدد):</label>
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">افزودن عکس</h2>
                    <input type="file" id="galleryInput" name="gallery_images[]" accept="image/*" multiple>
                    <small class="gallery-note">حداکثر ۱۰ تصویر قابل انتخاب است.</small>
                    <!-- preview added images -->
                    <div id="galleryPreview" class="gallery-preview"></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md mb-10 mt-10 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">افزودن رنگ‌ها</h2>
                    <!-- colors(from database) -->
                    <label class="block text-gray-700 font-semibold mb-2">رنگ‌های موجود:</label>
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
                    <hr class="my-6">
                    <button type="submit" class="btn btn-netcopy_net">ایجاد محصول</button>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/js.js') }}"></script>
    <script>
        // افزودن ویژگی به صورت داینامیک
        let attributes = [];

        document.getElementById('addAttributeBtn').addEventListener('click', () => {
            const name = document.getElementById('attributeName').value.trim();
            const value = document.getElementById('attributeValue').value.trim();

            if (!name || !value) {
                alert("نام و مقدار ویژگی را وارد کنید.");
                return;
            }

            attributes.push({
                name,
                value
            });
            renderAttributes();

            // پاک کردن ورودی‌ها
            document.getElementById('attributeName').value = '';
            document.getElementById('attributeValue').value = '';
        });

        function renderAttributes() {
            const preview = document.getElementById('attributePreview');
            const hidden = document.getElementById('attributeHiddenFields');
            preview.innerHTML = '';
            hidden.innerHTML = '';

            attributes.forEach((attr, index) => {
                // پیش‌نمایش
                const div = document.createElement('div');
                div.className = "flex items-center justify-between bg-gray-100 p-3 rounded-lg shadow-sm";

                const label = document.createElement('span');
                label.textContent = `${attr.name}: ${attr.value}`;
                label.className = "text-gray-700 text-sm";

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = "&times;";
                removeBtn.className = "text-red-500 text-xl hover:text-red-700";
                removeBtn.onclick = () => {
                    attributes.splice(index, 1);
                    renderAttributes();
                };

                div.appendChild(label);
                div.appendChild(removeBtn);
                preview.appendChild(div);

                // hidden inputs
                const inputName = document.createElement('input');
                inputName.type = "hidden";
                inputName.name = `attributes[${index}][name]`;
                inputName.value = attr.name;

                const inputValue = document.createElement('input');
                inputValue.type = "hidden";
                inputValue.name = `attributes[${index}][value]`;
                inputValue.value = attr.value;

                hidden.appendChild(inputName);
                hidden.appendChild(inputValue);
            });
        }


        // images gallery  (upload images & preview)
        const galleryInput = document.getElementById("galleryInput");
        const galleryPreview = document.getElementById("galleryPreview");

        galleryInput.addEventListener("change", function() {
            const files = Array.from(this.files);
            const currentPreviewCount = galleryPreview.querySelectorAll(".preview-image-container").length;

            if (files.length + currentPreviewCount > 10) {
                alert("حداکثر می‌توانید ۱۰ تصویر انتخاب کنید.");
                this.value = "";
                return;
            }

            files.forEach((file) => {
                if (!file.type.startsWith("image/")) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.createElement("div");
                    container.className = "preview-image-container";

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "preview-image";

                    const btn = document.createElement("button");
                    btn.innerText = "✖";
                    btn.className = "remove-btn";
                    btn.type = "button";

                    btn.onclick = function() {
                        container.remove();
                        alert("برای حذف عکس باید دوباره انتخاب کنید.");
                    };

                    container.appendChild(img);
                    container.appendChild(btn);
                    galleryPreview.appendChild(container);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>

@endsection
