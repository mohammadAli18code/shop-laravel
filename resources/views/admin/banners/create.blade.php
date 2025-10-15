@extends('layouts.admin')

@section('title', 'ایجاد بنر جدید')

@section('css')

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">پیشخوان</a></li>
            <li><a href="{{ route('admin.banners.index') }}">بنر ها</a></li>
            <li><a href="{{ route('admin.banners.create') }}" class="is-active">ایجاد بنر جدید</a></li>
        </ul>
    </div>
    <div class="main-content  ">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item" href="{{ route('admin.banners.index') }}">لیست بنر ها</a>
                <a class="tab__item is-active" href="{{ route('admin.banners.create') }}">ایجاد بنر جدید</a>
            </div>
        </div>
        <div class="user-info bg-white padding-30 font-size-13">
            @if ($errors->any())
                <div class="alert alert-danger text-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="w-full max-w-md mx-auto mb-6">
                    <label for="banner-upload"
                        class="relative block rounded-xl overflow-hidden shadow-lg cursor-pointer group aspect-[16/9] bg-gray-100">
                        <img id="banner-preview" src="" alt="پیش‌ نمایش بنر"
                            class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-white text-sm md:text-base font-semibold">برای تغییر بنر کلیک کنید</span>
                        </div>
                    </label>
                    <input type="file" id="banner-upload" name="image" accept="image/*" class="hidden">
                </div>
                <input class="text" name="title" placeholder="عنوان">
                <input class="text text-right" name="url" placeholder="آدرس url">
                <br><br>
                <button class="btn btn-netcopy_net">ایجاد بنر</button>
            </form>
        </div>

    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/js.js') }}"></script>
    <script>
        $('#banner-upload').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#banner-preview').attr('src', URL.createObjectURL(file));
            }
        });
    </script>
@endsection
