@extends('layouts.admin')

@section('title', 'ویرایش بنر')

@section('css')

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.banners.index') }}">بنر ها</a></li>
            <li><a href="{{ route('admin.banners.edit', [$banner->id]) }}" class="is-active">ویراریش بنر</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="user-info bg-white padding-30 font-size-13">
            <form id="banner-edit-form" action="{{ route('admin.banners.update', [$banner->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="w-full max-w-md mx-auto mb-6">
                    <label for="banner-upload"
                        class="relative block rounded-xl overflow-hidden shadow-lg cursor-pointer group aspect-[16/9] bg-gray-100">
                        <img id="banner-preview" src="{{ asset($banner->image) }}" alt="پیش‌نمایش بنر"
                            class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-white text-sm md:text-base font-semibold">برای تغییر بنر کلیک کنید</span>
                        </div>
                    </label>
                    <input type="file" id="banner-upload" name="image" accept="image/*" class="hidden">
                </div>


                <label>عنوان</label>
                <input class="text" name="title" placeholder="عنوان" value="{{ $banner->title }}">
                <label>آدرس بنر</label>
                <input class="text text-right" name="url" placeholder="آدرس url" value="{{ $banner->url }}">
                <br><br>
                <button class="btn btn-netcopy_net">ذخیره تغییرات</button>
            </form>
        </div>

    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/js.js') }}"></script>
    <script>
        $('#banner-edit-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            let url = $(form).attr('action');
            let formData = new FormData(form);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'ویرایش با موفقیت انجام شد!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                },
                error: function(xhr) {
                    let msg = 'مشکلی در ویرایش بنر پیش آمد.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: msg,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        $('#banner-upload').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#banner-preview').attr('src', URL.createObjectURL(file));
            }
        });
    </script>
@endsection
