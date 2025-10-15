@extends('layouts.admin')

@section('title', 'دسته بندی ها')

@section('css')
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
            border-top: 3px solid #3a6df0;
            /* مشکی پررنگ */
            border-right: 3px solid #3a6df0;
            /* مشکی پررنگ */
            background-color: #eef1f7;
            /* یه رنگ روشن ملایم دلخواه */
        }

        /* کادر فرزندان زمانی که نمایش داده شدند */
        .subcategory {
            background-color: #c1cde9ff;
            /* رنگ خیلی روشن آبی */
            border-left: 3px solid #3a6df0;
            /* یک نوار رنگی سمت چپ */
            padding-left: 15px;
            transition: background-color 0.3s ease;
        }

        .subcategory:hover {
            background-color: #abbef3ff;
            /* رنگ خیلی روشن آبی */
            border-right: 3px solid #ff2600ff;
            /* یک نوار رنگی سمت چپ */
        }

        /* فاصله زیرمجموعه‌ها نسبت به والد */
        .subcategory:not(:last-child) {
            border-bottom: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')



    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="is-active">دسته بندی ها</a></li>
        </ul>
    </div>
    {{-- {{ $message = flash('create_category') }}
    @if (!empty($create_message))
        <h3 class="text-success">{{ $create_message }}</h3>
    @endif
    {{ $delete_message = flash('delete_category') }}
    @if (!empty($delete_message))
        <h3 class="text-success">{{ $delete_message }}</h3>
    @endif --}}
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
                            @foreach ($categories as $category)
                                <tr class="parent-category clickable-row" data-target="<?= $category['id'] ?>">
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <i class="fas fa-chevron-down toggle-icon collapsed"></i>
                                        {{ $category->name }}
                                    </td>
                                    <td>{{ $category->english_name }}</td>
                                    <td>
                                        <button type="button" class="item-delete mlg-15 btn-delete-category"
                                            data-url="{{ route('admin.categories.destroy', [$category->id]) }}"
                                            data-id="{{ $category->id }}" title="حذف"
                                            style="background:none; border:none; cursor:pointer; color:inherit;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="{{ route('admin.categories.edit', [$category->id]) }}" class="item-edit"
                                            title="ویرایش"></a>
                                    </td>
                                </tr>
                                <!-- زیرمجموعه‌ها -->
                                @foreach ($category->children as $sub)
                                    <tr class="subcategory sub-of-{{ $category->id }}" style="display: none;">
                                        <td>{{ $sub->id }}</td>
                                        <td class="pl-4">↳ {{ $sub->name }}</td>
                                        <td>{{ $sub->english_name }}</td>
                                        <td>
                                            <button type="button" class="item-delete mlg-15 btn-delete-category"
                                                data-url="{{ route('admin.categories.destroy', [$sub->id]) }}"
                                                data-id="{{ $category->id }}" title="حذف"
                                                style="background:none; border:none; cursor:pointer; color:inherit;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <a href="{{ route('admin.categories.edit', [$sub->id]) }}" class="item-edit"
                                                title="ویرایش"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- check empty category list -->
                @if (empty($categories))
                    <h3 style="color:white;font-family:serif;margin-top:10px">هیچ دسته بندی ای یافت نشد!</h3>
                @endif

            </div>
            <div class="col-4 bg-white">
                <p class="box__title">ایجاد دسته بندی جدید</p>
                <form id="addCategoryForm">
                    @csrf
                    <input type="text" name="name" placeholder="نام دسته بندی" class="text">
                    <input type="text" name="english_name" placeholder="نام انگلیسی دسته بندی" class="text">
                    <input type="text" name="slug" placeholder="نام منحصر به فرد(slug)" class="text">
                    <p class="box__title margin-bottom-15">انتخاب دسته پدر</p>
                    <select name="parent_id" id="">
                        <option value="">اصلی</option>
                        @foreach ($categories as $parent)
                            <option value="{{ $parent->id }}">
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-netcopy_net">اضافه کردن</button>
                </form>
            </div>
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
        $(document).on('click', '.btn-delete-category', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            let row = $(this).closest('tr');

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این دسته‌بندی حذف خواهد شد!",
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
                                'دسته‌بندی با موفقیت حذف شد.',
                                'success'
                            )
                        },
                        error: function() {
                            Swal.fire(
                                'خطا!',
                                'مشکلی در حذف دسته‌بندی پیش آمد.',
                                'error'
                            )
                        }
                    });
                }
            })
        });
    </script>
    {{-- open & close sub categories list --}}
    <script>
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function(e) {
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
    {{-- add category --}}
    <script>
        $(document).on('submit', '#addCategoryForm', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('admin.categories.store') }}";
            let data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    // فرض: response = {id, name, english_name, parent_id}

                    let rowHtml = '';
                    if (!response.parent_id) {
                        // دسته اصلی
                        rowHtml = `
                    <tr class="parent-category clickable-row" data-target="${response.id}">
                        <td>${response.id}</td>
                        <td><i class="fas fa-chevron-down toggle-icon collapsed"></i> ${response.name}</td>
                        <td>${response.english_name}</td>
                        <td>
                            <button type="button" class="item-delete mlg-15 btn-delete-category"
                                    data-url="/admin/categories/${response.id}" 
                                    title="حذف" style="background:none; border:none; cursor:pointer; color:inherit;">
                                <i class="fas fa-trash"></i>
                            </button>
                            <a href="/admin/categories/${response.id}/edit" class="item-edit" title="ویرایش"></a>
                        </td>
                    </tr>
                `;
                        $('table tbody').append(rowHtml);
                    } else {
                        // زیرمجموعه → باید بعد از والدش اضافه شود
                        rowHtml = `
                    <tr class="subcategory sub-of-${response.parent_id}" style="display:none;">
                        <td>${response.id}</td>
                        <td class="pl-4">↳ ${response.name}</td>
                        <td>${response.english_name}</td>
                        <td>
                            <button type="button" class="item-delete mlg-15 btn-delete-category"
                                    data-url="/admin/categories/${response.id}" 
                                    title="حذف" style="background:none; border:none; cursor:pointer; color:inherit;">
                                <i class="fas fa-trash"></i>
                            </button>
                            <a href="/admin/categories/${response.id}/edit" class="item-edit" title="ویرایش"></a>
                        </td>
                    </tr>
                `;

                        // پیدا کردن ردیف والد و اضافه کردن بعد از آن
                        let parentRow = $(`tr.parent-category[data-target='${response.parent_id}']`);
                        parentRow.after(rowHtml);
                    }

                    // پیام موفقیت
                    Swal.fire({
                        icon: 'success',
                        title: 'موفقیت!',
                        text: 'دسته‌بندی اضافه شد.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    form.trigger('reset'); // خالی کردن فرم
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا!',
                        text: 'افزودن دسته‌بندی با مشکل مواجه شد.',
                    });
                }
            });
        });
    </script>
@endsection



</html>
