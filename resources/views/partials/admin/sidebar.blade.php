<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://netcopy.ir"></a>
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img">
            @if (auth()->user()->image)
                <img src="{{ asset(auth()->user()->image) }}" class="avatar___img">
            @endif
            <input type="file" accept="image/*" class="hidden avatar-img__input">
            <div class="v-dialog__container" style="display: block;"></div>
            <div class="box__camera default__avatar"></div>
        </div>
        <span class="profile__name">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
    </div>
    <br>

    <ul>
        <li class="item-li i-dashboard {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">پیشخوان</a>
        </li>

        <li class="item-li i-users {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.users.index') }}">کاربران</a>
        </li>

        <li class="item-li i-categories {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.categories.index') }}">دسته بندی ها</a>
        </li>

        <li class="item-li i-banners {{ request()->routeIs('admin.banners.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.banners.index') }}">بنرها</a>
        </li>

        <li class="item-li i-comments {{ request()->routeIs('admin.comments.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.comments.index') }}">نظرات</a>
        </li>

        <li class="item-li i-products {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.products.index') }}">محصولات</a>
        </li>

        <li class="item-li i-discounts {{ request()->routeIs('admin.discounts.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.discounts.index') }}">تخفیف ها</a>
        </li>

        <li class="item-li i-transactions {{ request()->routeIs('admin.transactions.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.transactions.index') }}">تراکنش ها</a>
        </li>

        <li class="item-li i-messages {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.messages.index') }}">پیام ها</a>
        </li>

        <li class="item-li i-user__information {{ request()->routeIs('admin.profile.*') ? 'is-active' : '' }}">
            <a href="{{ route('admin.profile.edit', auth()->guard('admin')->id()) }}">اطلاعات کاربری</a>
        </li>

        <li class="item-li">
            <a class="logout" href="{{ route('logout') }}">خروج</a>
        </li>
    </ul>
</div>
