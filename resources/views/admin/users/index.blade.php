@extends('layouts.admin')

@section('title', 'home')


@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="index.html">پیشخوان</a></li>
            <li><a href="courses.html" class="is-active">کاربران</a></li>
        </ul>
    </div>
    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{{ route('admin/users/all') }}">همه کاربران</a>
                <a class="tab__item" href="{{ route('admin.users/admins') }}">مدیران</a>
                <a class="tab__item" href="{{ route('admin.users/customers') }}">مشتریان</a>
                <a class="tab__item" href="{{ route('admin.users/not-active-customers') }}">کاربران تاییده نشده</a>
                <a class="tab__item" href="{{ route('admin.users/active-customers') }}">کاربران تایید شده</a>
            </div>
        </div>
        <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی کاربر">
                        <div class="t-header-search-content ">
                            <input type="text" class="text" placeholder="ایمیل">
                            <input type="text" class="text" placeholder="شماره">
                            <input type="text" class="text" placeholder="آی پی">
                            <input type="text" class="text margin-bottom-20" placeholder="نام و نام خانوادگی">
                            <btutton class="btn btn-netcopy_net">جستجو</btutton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>عکس</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>ایمیل </th>
                        <th>شماره موبایل </th>
                        <th>سطح کاربری </th>
                        <th> تاریخ عضویت</th>
                        <th>ای پی</th>
                        <th>وضعیت حساب</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color:#189bc3" role="row" class="">
                        <td><a href="">{{ auth()->user()->id }}</a></td>
                        <td><img class="profile-pic" src="{{ asset(auth()->user()->image) }}" alt="">
                        </td>
                        <td>{{ auth()->user()->first_name }}</td>
                        <td>{{ auth()->user()->last_name }}</td>
                        <td>{{ auth()->user()->email }}</td>
                        <td>{{ auth()->user()->phone_number }}</td>
                        <td>ادمین</td>
                        <td>{{ auth()->user()->created_at }}</td>
                        <td>1.1.1.1</td>
                        <td class="text-success">تایید شده</td>
                        <td>
                            <a href="{{ route('admin/profile/admin/edit/' . auth()->user()->id) }}" class="item-edit "
                                title="ویرایش"></a>
                        </td>
                    </tr>
                    @foreach ($users as $user)
                        <tr role="row" class="">
                            <td><a href="">{{ $user->id }}</a></td>
                            <td><img class="profile-pic" src="{{ asset($user->image) }}" alt=""></td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            @if ($user->role == 'admin')
                                <td>ادمین</td>
                            @elseif($user->role == 'user')
                                <td>مشتری</td>
                            @elseif($user->role == 'author')
                                <td>نویسنده</td>
                            @elseif($user->role == 'manager')
                                <td>مدیر</td>
                            @endif
                            <td>{{ $user->created_at }}</td>
                            <td>1.1.1.1</td>
                            @if ($allUser->is_active == 1)
                                <td class="text-error">تایید نشده</td>
                            @elseif($user->is_active == 2)
                                <td class="text-success">تایید شده</td>
                            @endif
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
@section('scripts')
    <script src="  {{ asset('public/admin-panel/js/jquery-3.4.1.min.js') }}"></script>
    <script src="  {{ asset('public/admin-panel/js/js.js') }}"></script>
@endsection

</html>
