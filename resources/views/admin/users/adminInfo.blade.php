@extends('layouts.admin')

@section('title', 'home')


@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="index.html">پیشخوان</a></li>
            <li><a href="user-information.html" class="is-active">اطلاعات کاربری</a></li>
        </ul>
    </div>
    <div class="main-content  ">
        <div class="user-info bg-white padding-30 font-size-13">
            {{ $message = flash('change_info_message') }}
            @if (!empty($message))
                <div style="font-size:18px;" class="text-success">
                    <small class="form-text text-danger">
                        {{ $message }}
                    </small>
                </div>
            @endif
            <form action="{{ route('admin.users.update', [$admin->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="profile__info border cursor-pointer text-center">
                    <div class="avatar__img"><img src="{{ asset($admin->image) }}" class="avatar___img">
                        <input type="file" name="image" accept="image/*" class="hidden avatar-img__input">
                        <div class="v-dialog__container" style="display: block;"></div>
                        <div class="box__camera default__avatar"></div>
                    </div>
                    <span class="profile__name">{{ $admin->first_name . ' ' . $admin->last_name }}</span>
                </div><br>
                <label for="">نام</label>
                <input class="text" name="first_name" placeholder="نام" value="{{ $admin->first_name }}">
                <label for="">نام خانوادگی</label>
                <input class="text text-right" name="last_name" placeholder="نام خانوادگی" value="{{ $admin->last_name }}">
                <label for="">سن</label>
                <input class="text text-right" name="age" placeholder="سن" value="{{ $admins->age . ' سال' }}">
                <label for="">ایمیل</label>
                <input class="text text-right" name="email" placeholder="ایمیل" value="{{ $admin->email }}">
                <label for="">شماره همراه</label>
                <input class="text text-right" name="phone_number" placeholder="شماره موبایل"
                    value="{{ $admin->phone_number }}">
                <!-- <input class="text text-right"  name=""             placeholder="شماره کارت بانکی">
                                        <input class="text text-right"  name=""             placeholder="شماره شبا بانکی"> -->
                <label for="">آدرس</label>
                <input class="text text-right" name="address" placeholder="آدرس" value="{{ $admin->address }}">
                <label for="">رشته تحصیلی</label>
                <input class="text text-right" name="major" placeholder="رشته تحصیلی" value="{{ $admin->major }}">
                <label for="">استان</label>
                <input class="text text-right" name="city" placeholder="استان" value="{{ $admin->city }}">
                <label for="">کشور</label>
                <input class="text text-right" name="country" placeholder="کشور" value="{{ $admin->country }}">
                <!-- <p class="input-help text-left margin-bottom-12" dir="ltr">
                                            
                                            <a href="https//netcopy/tutors/"></a>
                                        </p> -->
                <input style="pointer-events:none" name="password" class="text text-right" type="password"
                    placeholder="رمز عبور" value="{{ $admin->password }}">
                <button style="color:white;background-color:blue;padding:8px;border-radius:5px" href="">تغییر رمز
                    عبور</button>
                <!-- <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                                            غیر الفبا مانند <strong>!@#$%^&*()</strong> باشد.</p> -->
                <br><br>
                <label for="">توضیحات</label>
                <textarea class="text" name="additional_info" placeholder="درباره من  "></textarea>
                <br>
                <br>
                <button class="btn btn-netcopy_net">ذخیره تغییرات</button>
            </form>
        </div>
    </div>
    </div>
@section('scripts')
    <script src="  {{ asset('public/admin-panel/js/jquery-3.4.1.min.js') }}"></script>
    <script src="  {{ asset('public/admin-panel/js/js.js') }}"></script>
@endsection

</html>
