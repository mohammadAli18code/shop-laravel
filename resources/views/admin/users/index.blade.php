@extends('layouts.admin')

@section('title', 'کاربران')


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
                <a class="tab__item {{ $role == 'all' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'all']) }}">همه کاربران</a>
                <a class="tab__item {{ $role == 'manager' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'manager']) }}">مدیران</a>
                <a class="tab__item {{ $role == 'admin' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'admin']) }}">ادمین ها</a>
                <a class="tab__item {{ $role == 'customer' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'customer']) }}">مشتریان</a>
                <a class="tab__item {{ $role == 'notActiveCustomer' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'notActiveCustomer']) }}">مشتریان
                    تاییده نشده</a>
                <a class="tab__item {{ $role == 'activeCustomer' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'activeCustomer']) }}">مشتریان تایید
                    شده</a>
                <a class="tab__item {{ $role == 'author' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'author']) }}">نویسندگان</a>
                <a class="tab__item {{ $role == 'activeAuthor' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'activeAuthor']) }}">نویسندگان تایید شده</a>
                <a class="tab__item {{ $role == 'notActiveAuthor' ? 'is-active' : '' }}"
                    href="{{ route('admin.users.index', ['role' => 'notActiveAuthor']) }}">نویسندگان تایید
                    نشده</a>
            </div>
        </div>
        <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
            <div class="t-header-search">
                <form id="user-filter-form" action="{{ route('admin.users.index', $role) }}" method="GET">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی کاربر">
                        <div class="t-header-search-content">
                            <input type="text" name="id" class="text" placeholder="آیدی">
                            <input type="text" name="email" class="text" placeholder="ایمیل">
                            <input type="text" name="phone" class="text" placeholder="شماره">
                            <input type="text" name="first_name" class="text margin-bottom-20" placeholder="نام">
                            <input type="text" name="last_name" class="text margin-bottom-20" placeholder="نام خانوادگی">
                            <button type="submit" class="btn btn-netcopy_net">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="table__box" id="users-table">
            @include('admin.users.partials.__table', ['users' => $users])
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/js.js') }}"></script>
@endsection
<script>
    $(document).ready(function() {
        $('#user-filter-form').on('submit', function(e) {
            e.preventDefault(); // جلوگیری از submit معمولی

            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(response) {
                    $('#users-table').html(response); // جایگزین کردن جدول
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        });
    });
</script>

</html>
