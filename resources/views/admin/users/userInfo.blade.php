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
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="profile__info border cursor-pointer text-center">
                    <div class="avatar__img"><img src="{{ asset($user->image) }}" class="avatar___img">
                        <input type="file" name="image" accept="image/*" class="hidden avatar-img__input">
                        <div class="v-dialog__container" style="display: block;"></div>
                        <div class="box__camera default__avatar"></div>
                    </div>
                    <span class="profile__name">{{ $user->first_name . ' ' . $user->last_name }}</span>
                </div><br>
                <input class="text" name="first_name" placeholder="نام" value="{{ $user->first_name }}">
                <input class="text text-right" name="last_name" placeholder="نام خانوادگی" value="{{ $user->last_name }}">
                <input class="text text-right" name="age" placeholder="سن" value="{{ $user->age . ' سال' }}">
                <input class="text text-right" name="email" placeholder="ایمیل" value="{{ $user->email }}">
                <input class="text text-right" name="phone_number" placeholder="شماره موبایل"
                    value="{{ $user->phone_number }}">
                <!-- <input class="text text-right"  name=""             placeholder="شماره کارت بانکی">
                                                                                <input class="text text-right"  name=""             placeholder="شماره شبا بانکی"> --><input
                    class="text text-right" name="address" placeholder="آدرس" value="{{ $user->address }}">
                <!-- <p class="input-help text-left margin-bottom-12" dir="ltr">
                                                                                    
                                                                                    <a href="https//netcopy/tutors/"></a>
                                                                                </p> --><input style="pointer-events:none"
                    name="password" class="text text-right" type="password" placeholder="رمز عبور"
                    value="{{ $user->password }}">
                <button style="color:white;background-color:blue;padding:8px;border-radius:5px" href="">تغییر رمز
                    عبور</button>
                <!-- <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                                                                                    غیر الفبا مانند <strong>!@#$%^&*()</strong> باشد.</p> --><br><br>
                <textarea class="text" placeholder="درباره من مخصوص مدرسین"></textarea>
                <br>
                <br>
                <button class="btn btn-netcopy_net">ذخیره تغییرات</button>
            </form>
        </div>

    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('public/admin-panel/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/admin-panel/js/js.js') }}"></script>
@endsection

</html>
