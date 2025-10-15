<table class="table">
    <thead>
        <tr class="title-row">
            <th>شناسه</th>
            <th>عکس</th>
            <th>نام</th>
            <th>نام خانوادگی</th>
            <th>ایمیل</th>
            <th>شماره موبایل</th>
            <th>سطح کاربری</th>
            <th>تاریخ عضویت</th>
            <th>وضعیت حساب</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td><img class="profile-pic" src="{{ asset($user->image) }}" alt=""></td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
                @if ($user->is_active)
                    <span class="text-success">تایید شده</span>
                @else
                    <span class="text-error">تایید نشده</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.profile.edit', $user->id) }}" class="item-edit" title="ویرایش"></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }} {{-- pagination --}}
