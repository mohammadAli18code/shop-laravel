<header class="fixed w-full border-b z-40 bg-white">
    <!-- header -->
    <div class="flex items-center justify-between pt-2 pb-4 gap-y-5 flex-wrap lg:flex-nowrap">
        <!-- btn menu mobile -->
        <svg class="md:hidden mr-3 md:mr-5" onclick="showNavbarMobile()" xmlns="http://www.w3.org/2000/svg" width="32"
            height="32" fill="#000000" viewBox="0 0 256 256">
            <path
                d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,72H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z">
            </path>
        </svg>
        <!-- navbar moblie -->
        <div class="flex absolute w-full h-screen z-50 -right-full top-0 transition-all ease-out duration-500"
            id="navbarMobile">
            <div class="bg-white w-9/12 h-screen py-5 drop-shadow-2xl max-w-md">
                <div class="mx-auto mb-5">
                    <a href="#">
                        <img class="w-44 mx-auto" src="{{ asset('app/assets/images/logo.png') }}" alt="">
                    </a>
                </div>
                <ul class="flex flex-col gap-y-3 px-2">
                    <li class="text-zinc-700 hover:text-zinc-900 hover:bg-gray-200 transition p-2 rounded-lg">
                        <a href="{{ route('app.home') }} ">
                            صفحه اصلی
                        </a>
                    </li>
                    <li class="text-zinc-700 hover:text-zinc-900 group">
                        <a class="relative">
                            <div class="flex gap-x-1 items-center hover:bg-gray-200 transition p-2 rounded-lg">
                                فروشگاه
                                <svg class="group-hover:rotate-180 transition-all duration-500"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>
                            </div>
                            <div
                                class="bg-white hidden group-hover:flex flex-col p-2 top-5 w-full rounded-lg shadow-xl">
                                @foreach ($parent_cats as $parent_cat)
                                    <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                                        href="{{ route('app.product.index', ['category' => $parent_cat->slug]) }}">
                                        {{ $parent_cat->name }}
                                    </a>
                                @endforeach
                                <!-- <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all" href="#">
                                            موبایل
                                        </a>
                                        <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all" href="#">
                                            لپ تاپ
                                        </a>
                                        <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all" href="#">
                                            لوازم خانگی
                                    </a> -->
                            </div>
                        </a>
                    </li>
                    <li class="text-zinc-700 hover:text-zinc-900 hover:bg-gray-200 transition p-2 rounded-lg">
                        <a href="{{ route('app.product.index', ['special' => 1]) }}">
                            شگفت انگیز ها
                        </a>
                    </li>
                    <!-- <li class="text-zinc-700 hover:text-zinc-900 hover:bg-gray-200 transition p-2 rounded-lg">
                            <a href="#">
                                پرفروش ترین ها
                            </a>
                        </li> -->
                    <li class="text-zinc-700 hover:text-zinc-900 hover:bg-gray-200 transition p-2 rounded-lg">
                        <a href="{{ route('app.home') }}">
                            ارتباط با ما
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bg-white/30 w-3/12 sm:w-5/12 backdrop-blur-sm" onclick="hideNavbarMobile()">
            </div>
        </div>
        <!-- fixed navbar mobile -->
        <div class="bg-white shadow-lg rounded-2xl fixed bottom-1 w-full border flex md:hidden">
            <div class="flex-1 group">
                <a href="{{ route('account.dashboard') }}"
                    class="flex items-end justify-center text-center mx-auto px-1 pt-2 w-full text-gray-400 group-hover:text-sky-600">
                    <span class="flex flex-col justify-center items-center pt-1 pb-1">
                        <svg class="fill-zinc-700 group-hover:fill-sky-600" xmlns="http://www.w3.org/2000/svg"
                            width="26" height="26" fill="" viewBox="0 0 256 256">
                            <path
                                d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                            </path>
                        </svg>
                        <span class="block text-xs pb-1 pt-1">
                            پروفایل
                        </span>
                        <span class="block w-5 mx-auto h-1 group-hover:bg-sky-600 rounded-full"></span>
                    </span>
                </a>
            </div>
            <div class="flex-1 group">
                <a href=" {{ route('app.cart.index') }} "
                    class="flex items-end justify-center text-center mx-auto px-1 pt-2 w-full text-gray-400 group-hover:text-sky-600">
                    <span class="flex flex-col justify-center items-center pt-1 pb-1">
                        <svg class="fill-zinc-700 group-hover:fill-sky-600" xmlns="http://www.w3.org/2000/svg"
                            width="26" height="26" fill="" viewBox="0 0 256 256">
                            <path
                                d="M230.14,58.87A8,8,0,0,0,224,56H62.68L56.6,22.57A8,8,0,0,0,48.73,16H24a8,8,0,0,0,0,16h18L67.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,160,204a28,28,0,1,0,28-28H91.17a8,8,0,0,1-7.87-6.57L80.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,230.14,58.87ZM104,204a12,12,0,1,1-12-12A12,12,0,0,1,104,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,200,204Zm4-74.57A8,8,0,0,1,196.1,136H77.22L65.59,72H214.41Z">
                            </path>
                        </svg>
                        <span class="block text-xs pb-1 pt-1">
                            سبد خرید
                        </span>
                        <span class="block w-5 mx-auto h-1 group-hover:bg-sky-600 rounded-full"></span>
                    </span>
                </a>
            </div>
            <div class="flex-1 group">
                <a href=" {{ route('app.home') }}"
                    class="flex items-end justify-center text-center mx-auto px-1 pt-2 w-full text-sky-600">
                    <span class="flex flex-col justify-center items-center pt-1 pb-1">
                        <svg class="fill-sky-600" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                            fill="" viewBox="0 0 256 256">
                            <path
                                d="M240,208H224V136l2.34,2.34A8,8,0,0,0,237.66,127L139.31,28.68a16,16,0,0,0-22.62,0L18.34,127a8,8,0,0,0,11.32,11.31L32,136v72H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM48,120l80-80,80,80v88H160V152a8,8,0,0,0-8-8H104a8,8,0,0,0-8,8v56H48Zm96,88H112V160h32Z">
                            </path>
                        </svg>
                        <span class="block text-xs pb-1 pt-1">
                            صفحه اصلی
                        </span>
                        <span class="block w-5 mx-auto h-1 bg-sky-600 rounded-full"></span>
                    </span>
                </a>
            </div>
            <div class="flex-1 group relative">
                <button
                    class="flex items-end justify-center text-center mx-auto px-1 pt-2 w-full text-gray-400 group-hover:text-sky-600">
                    <span class="flex flex-col justify-center items-center pt-1 pb-1">
                        <svg class="fill-zinc-700 group-hover:fill-sky-600" xmlns="http://www.w3.org/2000/svg"
                            width="26" height="26" fill="" viewBox="0 0 256 256">
                            <path
                                d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                            </path>
                        </svg>
                        <span class="block text-xs pb-1 pt-1">
                            جستجو
                        </span>
                        <span class="block w-5 mx-auto h-1 group-hover:bg-sky-600 rounded-full"></span>
                    </span>
                </button>
                <div
                    class="items-center hidden group-hover:flex rounded-xl p-3 justify-between bg-gray-100 absolute -top-14 -left-10 w-80 mx-auto border">
                    <input class="text-base text-gray-700 flex-grow outline-none bg-gray-100" type="text"
                        placeholder="نام محصول را وارد کنید" />
                    <button class="absolute left-1 bg-sky-500 hover:bg-sky-600 transition rounded-xl h-10 w-10">
                        <svg class="fill-white mx-auto" xmlns="http://www.w3.org/2000/svg" width="26"
                            height="26" fill="" viewBox="0 0 256 256">
                            <path d="M192,112a80,80,0,1,1-80-80A80,80,0,0,1,192,112Z" opacity="0.2"></path>
                            <path
                                d="M229.66,218.34,179.6,168.28a88.21,88.21,0,1,0-11.32,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex-1 group">
                <button id="btn-back-to-top" onclick="backToTop()"
                    class="flex items-end justify-center text-center mx-auto px-1 pt-2 w-full text-gray-400 group-hover:text-sky-600">
                    <span class="flex flex-col justify-center items-center pt-1 pb-1">
                        <svg class="fill-zinc-700 group-hover:fill-sky-600" xmlns="http://www.w3.org/2000/svg"
                            width="26" height="26" fill="" viewBox="0 0 256 256">
                            <path
                                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm37.66-101.66a8,8,0,0,1-11.32,11.32L136,107.31V168a8,8,0,0,1-16,0V107.31l-18.34,18.35a8,8,0,0,1-11.32-11.32l32-32a8,8,0,0,1,11.32,0Z">
                            </path>
                        </svg>
                        <span class="block text-xs pb-1 pt-1">
                            بالا
                        </span>
                        <span class="block w-5 mx-auto h-1 group-hover:bg-sky-600 rounded-full"></span>
                    </span>
                </button>
            </div>
        </div>
        <!-- logo -->
        <div class="mr-0 md:mr-5">
            <a href=" {{ route('app.home') }}">
                <img class="w-32 md:w-44" src="{{ asset('app/assets/images/logo.png') }} " alt="">
            </a>
        </div>
        <!-- search input -->
        <div class="md:w-5/12 lg:w-4/12 hidden md:block">
            <form action="{{ route('app.product.search') }}" method="GET">
                <div class="items-center rounded-xl p-3 justify-between flex bg-gray-100 relative">
                    <input class="text-base text-gray-700 flex-grow outline-none bg-gray-100" type="text"
                        name="search" placeholder="نام محصول را وارد کنید" />
                    <button class="absolute left-1 bg-sky-500 hover:bg-sky-600 transition rounded-xl h-10 w-10 p-1">
                        <img class="" src="{{ asset('app/assets/images/search.png') }}" alt="">
                    </button>
                </div>
            </form>
        </div>
        <!-- buttonn -->
        <div class="flex items-center justify-center gap-x-3 ml-3 md:ml-5">
            <!-- card -->
            @if (auth()->check())
                <div class="flex items-center hover:bg-sky-100 p-2 rounded-lg">
                    @if (auth()->check())
                        <button class="relative" onclick="showCard()">
                            <img class="w-10" src="{{ asset('app/assets/images/Cart.png') }}" alt="">
                            <span
                                class="absolute -right-3 -top-3 flex h-5 w-5 drop-shadow-lg items-center justify-center rounded-full bg-sky-500 text-sm font-semibold text-white">
                                {{-- <?= $_SESSION['cart_count']['count'] ?> --}}
                            </span>
                        </button>
                    @endif
                    <div class="left-0 top-0 w-[22rem] sm:w-[400px] rounded-lg bg-gray-300 shadow-lg absolute h-screen z-50 hidden"
                        id="cardHeader">
                        <div onclick="closeCard()"
                            class="overflow-x-hidden overflow-y-auto fixed h-full inset-0 -z-10 bg-gray-600 bg-opacity-50 w-full">
                        </div>
                        <div class="bg-white h-screen">
                            <!-- Head -->
                            <div class="flex items-center justify-between p-4 pb-2 border-b mx-5 bg-white">
                                <div class="text-zinc-500">
                                    {{-- <?= $_SESSION['cart_count']['count'] ?> کالا --}}
                                </div>
                                <button onclick="closeCard()" type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- main -->
                            <div class="h-full">
                                <!-- Items -->
                                <div class="h-60 bg-white">
                                    <ul
                                        class="main-scroll h-full space-y-2 divide-y divide-gray-100 overflow-y-auto p-5 pl-2">
                                        @foreach ($cartItems as $item)
                                            <li class="border-b">
                                                <div class="flex gap-x-2 py-5">
                                                    <!-- Product -->
                                                    <div class="relative min-w-fit">
                                                        <a
                                                            href="{{ route('app.product.show', $item->product->id) }} ">
                                                            <img alt="" class="h-[120px] w-[120px]"
                                                                src="{{ asset($item->product->thumbnail) }} ">
                                                        </a>
                                                    </div>
                                                    <div class="w-full space-y-1.5">
                                                        <!-- Title -->
                                                        <a class="line-clamp-2 h-12 text-zinc-700"
                                                            href="{{ route('app.product.show', $item->product->id) }}">
                                                            {{ $item->product->title }}
                                                        </a>
                                                        <!-- Attribute -->
                                                        <!-- <div class="flex items-center gap-x-2 text-xs text-zinc-500">
                                                        <div class="flex items-center gap-x-2">
                                                        <span class="h-4 w-4 rounded-full bg-gray-900"></span>
                                                        <span>مشکی</span>
                                                        </div>
                                                    </div> -->
                                                        <div class="flex items-center gap-x-2 text-xs text-zinc-500">
                                                            <div class="flex items-center gap-x-2">
                                                                <svg class="fill-red-700"
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" fill="#4d4d4d"
                                                                    viewBox="0 0 256 256">
                                                                    <path
                                                                        d="M245.57,117.78l-14-35a13.93,13.93,0,0,0-13-8.8H182V64a6,6,0,0,0-6-6H24A14,14,0,0,0,10,72V184a14,14,0,0,0,14,14H42.6a30,30,0,0,0,58.8,0h53.2a30,30,0,0,0,58.8,0H232a14,14,0,0,0,14-14V120A6,6,0,0,0,245.57,117.78ZM182,86h36.58a2,2,0,0,1,1.86,1.26L231.14,114H182ZM22,72a2,2,0,0,1,2-2H170v68H22ZM72,210a18,18,0,1,1,18-18A18,18,0,0,1,72,210Zm82.6-24H101.4a30,30,0,0,0-58.8,0H24a2,2,0,0,1-2-2V150H170v15.48A30.1,30.1,0,0,0,154.6,186ZM184,210a18,18,0,1,1,18-18A18,18,0,0,1,184,210Zm50-26a2,2,0,0,1-2,2H213.4A30.05,30.05,0,0,0,184,162c-.67,0-1.34,0-2,.07V126h52Z">
                                                                    </path>
                                                                </svg>
                                                                <span>ارسال پست پیشتاز</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center justify-between gap-x-2">
                                                            <!-- Price -->
                                                            <div class="text-gray-700">
                                                                <span
                                                                    class="text-lg font-bold">{{ number_format($item->product->final_price) }}</span>
                                                                <span class="text-sm">تومان</span>
                                                            </div>
                                                            <!-- Quantity -->
                                                            <div
                                                                class="flex h-10 w-24 items-center justify-between rounded-lg border border-gray-100 px-2 py-1">
                                                                <!-- <button type="button" data-action="increment">
                                                                        <svg xlink:href="#plus" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                        fill="#4d4d4d" viewBox="0 0 256 256">
                                                                        <path
                                                                            d="M222,128a6,6,0,0,1-6,6H134v82a6,6,0,0,1-12,0V134H40a6,6,0,0,1,0-12h82V40a6,6,0,0,1,12,0v82h82A6,6,0,0,1,222,128Z">
                                                                        </path>
                                                                        </svg>
                                                                    </button> -->
                                                                <input value="{{ $item->quantity }}" disabled=""
                                                                    type="number"
                                                                    class="flex h-5 w-full grow select-none items-center justify-center bg-transparent text-center text-sm text-zinc-700 outline-none">
                                                                <!-- <button type="button" data-action="decrement">
                                                                    <svg xlink:href="#minus" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                    fill="#4d4d4d" viewBox="0 0 256 256">
                                                                    <path d="M222,128a6,6,0,0,1-6,6H40a6,6,0,0,1,0-12H216A6,6,0,0,1,222,128Z"></path>
                                                                    </svg>
                                                                </button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- Down Price -->
                                <div
                                    class="flex items-center justify-between border-t border-gray-100 p-5 absolute w-full bottom-0 bg-white">
                                    <div class="flex flex-col items-center gap-y-1">
                                        <div class="text-sm text-zinc-600">
                                            مبلغ قابل پرداخت
                                        </div>
                                        {{-- <div class="text-zinc-600">
                                            <span class="font-bold">
                                                <?php
                                                $all_price = 0;
                                                foreach ($_SESSION['cart'] as $price) {
                                                    $all_price += $price['total_price'];
                                                }
                                                echo number_format($all_price);
                                                ?>
                                            </span>
                                            <span class="text-xs">تومان</span>
                                        </div> --}}
                                    </div>
                                    <a href="{{ route('app.cart.index') }}"
                                        class="w-28 py-3 text-sm bg-sky-500 hover:bg-sky-400 transition text-gray-100 rounded-xl text-center">
                                        <button type="button">
                                            ثبت سفارش
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Account -->
            <div class="flex items-center py-2 px-2 rounded-lg border border-sky-300 hover:bg-sky-100 group relative">
                <button class="text-sky-500 flex gap-x-2 items-center" type="button">
                    <svg class="fill-sky-500" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        fill="" viewBox="0 0 256 256">
                        <path d="M192,96a64,64,0,1,1-64-64A64,64,0,0,1,192,96Z" opacity="0.2"></path>
                        <path
                            d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                        </path>
                    </svg>
                    <span class="hidden md:block text-sm">
                        @if (auth()->check())
                            <a href="{{ route('account.dashboard') }}">پروفایل من</a>
                        @endif
                        @if (!auth()->check())
                            <a href=" {{ route('login') }} ">ورود | ثبت نام</a>
                        @endif
                    </span>
                </button>
                @if (auth()->check())
                    <div
                        class="z-50 group-hover:block left-0 top-[39px] w-60 rounded-lg bg-white shadow-lg hidden absolute">
                        <ul class="space-y-1 p-2">
                            <li class="border-b">
                                <a class="flex items-center justify-between gap-x-2 rounded-lg p-2 text-zinc-700 hover:text-zinc-800 transition hover:bg-gray-100"
                                    href="{{ route('account.dashboard') }}">
                                    <span class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#4d4d4d" viewBox="0 0 256 256">
                                            <path
                                                d="M229.19,213c-15.81-27.32-40.63-46.49-69.47-54.62a70,70,0,1,0-63.44,0C67.44,166.5,42.62,185.67,26.81,213a6,6,0,1,0,10.38,6C56.4,185.81,90.34,166,128,166s71.6,19.81,90.81,53a6,6,0,1,0,10.38-6ZM70,96a58,58,0,1,1,58,58A58.07,58.07,0,0,1,70,96Z">
                                            </path>
                                        </svg>
                                        <span>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center justify-between gap-x-2 rounded-lg p-2 text-zinc-700 hover:text-zinc-800 transition hover:bg-gray-100"
                                    href="{{ route('account.orders.index') }}">
                                    <span class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#4d4d4d" viewBox="0 0 256 256">
                                            <path
                                                d="M237.9,198.36l-14.25-120a14.06,14.06,0,0,0-14-12.36H174V64a46,46,0,0,0-92,0v2H46.33a14.06,14.06,0,0,0-14,12.36l-14.25,120a14,14,0,0,0,14,15.64H223.92a14,14,0,0,0,14-15.64ZM94,64a34,34,0,0,1,68,0v2H94ZM225.5,201.3a2.07,2.07,0,0,1-1.58.7H32.08a2.07,2.07,0,0,1-1.58-.7,1.92,1.92,0,0,1-.49-1.53l14.26-120A2,2,0,0,1,46.33,78H209.67a2,2,0,0,1,2.06,1.77l14.26,120A1.92,1.92,0,0,1,225.5,201.3Z">
                                            </path>
                                        </svg>
                                        <span class="text-sm">سفارش ها</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center justify-between gap-x-2 rounded-lg p-2 text-zinc-700 hover:text-zinc-800 transition hover:bg-gray-100"
                                    href="{{ route('account.favorites') }}">
                                    <span class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#4d4d4d" viewBox="0 0 256 256">
                                            <path
                                                d="M178,34c-21,0-39.26,9.47-50,25.34C117.26,43.47,99,34,78,34A60.07,60.07,0,0,0,18,94c0,29.2,18.2,59.59,54.1,90.31a334.68,334.68,0,0,0,53.06,37,6,6,0,0,0,5.68,0,334.68,334.68,0,0,0,53.06-37C219.8,153.59,238,123.2,238,94A60.07,60.07,0,0,0,178,34ZM128,209.11C111.59,199.64,30,149.72,30,94A48.05,48.05,0,0,1,78,46c20.28,0,37.31,10.83,44.45,28.27a6,6,0,0,0,11.1,0C140.69,56.83,157.72,46,178,46a48.05,48.05,0,0,1,48,48C226,149.72,144.41,199.64,128,209.11Z">
                                            </path>
                                        </svg>
                                        <span class="text-sm">علاقه مندی ها</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center justify-between gap-x-2 rounded-lg p-2 text-zinc-700 hover:text-zinc-800 transition hover:bg-gray-100"
                                    href="{{ route('account.messages') }}">
                                    <span class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#4d4d4d" viewBox="0 0 256 256">
                                            <path
                                                d="M227.33,91l-96-64a6,6,0,0,0-6.66,0l-96,64A6,6,0,0,0,26,96V200a14,14,0,0,0,14,14H216a14,14,0,0,0,14-14V96A6,6,0,0,0,227.33,91ZM100.18,152,38,195.9V107.65Zm12.27,6h31.1l62.29,44H50.16Zm43.37-6L218,107.65V195.9ZM128,39.21l85.43,57L143.53,146H112.47L42.57,96.17Z">
                                            </path>
                                        </svg>
                                        <span>پیغام ها</span>
                                    </span>
                                    <span class="relative flex h-5 w-5">
                                        <span
                                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sky-500 opacity-75"></span>
                                        <span
                                            class="relative inline-flex h-5 w-5 items-center justify-center rounded-full bg-sky-500 text-sm text-white">
                                            4
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <!-- لینک خروج -->
                                <a class="flex items-center justify-between gap-x-2 rounded-lg p-2 text-red-500 hover:text-red-600 transition hover:bg-red-100"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#4d4d4d" viewBox="0 0 256 256">
                                            <path
                                                d="M110,216a6,6,0,0,1-6,6H48a14,14,0,0,1-14-14V48A14,14,0,0,1,48,34h56a6,6,0,0,1,0,12H48a2,2,0,0,0-2,2V208a2,2,0,0,0,2,2h56A6,6,0,0,1,110,216Zm110.24-92.24-40-40a6,6,0,0,0-8.48,8.48L201.51,122H104a6,6,0,0,0,0,12h97.51l-29.75,29.76a6,6,0,1,0,8.48,8.48l40-40A6,6,0,0,0,220.24,123.76Z">
                                            </path>
                                        </svg>
                                        <span>خروج از حساب کاربری</span>
                                    </div>
                                </a>

                                <!-- فرم مخفی برای logout -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>

                                {{-- <a class="flex items-center justify-between gap-x-2 rounded-lg p-2 text-red-500 hover:text-red-600 transition hover:bg-red-100"
                                    href=" {{ route('logout') }} ">
                                    <div class="flex items-center gap-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="#4d4d4d" viewBox="0 0 256 256">
                                            <path
                                                d="M110,216a6,6,0,0,1-6,6H48a14,14,0,0,1-14-14V48A14,14,0,0,1,48,34h56a6,6,0,0,1,0,12H48a2,2,0,0,0-2,2V208a2,2,0,0,0,2,2h56A6,6,0,0,1,110,216Zm110.24-92.24-40-40a6,6,0,0,0-8.48,8.48L201.51,122H104a6,6,0,0,0,0,12h97.51l-29.75,29.76a6,6,0,1,0,8.48,8.48l40-40A6,6,0,0,0,220.24,123.76Z">
                                            </path>
                                        </svg>
                                        <span>خروج از حساب کاربری</span>
                                    </div>
                                </a> --}}
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- menus -->
    <div class="hidden md:block pb-2">
        <ul class="flex gap-x-3 lg:gap-x-3 xl:gap-x-5">
            <li class="text-zinc-700 transition group">
                <a class="relative block">
                    <div
                        class="flex gap-x-1 items-center group-hover:text-zinc-600 hover:bg-gray-200 transition p-2 rounded-lg">
                        <svg class="fill-gray-600" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="" viewBox="0 0 256 256">
                            <path
                                d="M104,40H56A16,16,0,0,0,40,56v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V56A16,16,0,0,0,104,40Zm0,64H56V56h48v48Zm96-64H152a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V56A16,16,0,0,0,200,40Zm0,64H152V56h48v48Zm-96,32H56a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V152A16,16,0,0,0,104,136Zm0,64H56V152h48v48Zm96-64H152a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V152A16,16,0,0,0,200,136Zm0,64H152V152h48v48Z">
                            </path>
                        </svg>
                        فروشگاه
                        <svg class="group-hover:rotate-180 transition-all duration-500 fill-zinc-600"
                            xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#000000"
                            viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                            </path>
                        </svg>
                    </div>
                    <div style="flex-wrap:wrap; max-height: 600px; overflow-y: auto;"
                        class="absolute hidden group-hover:flex top-28 h-auto rounded-lg w-11/12 lg:w-10/12 shadow-lg border z-50 bg-white items-top gap-x-5 xl:gap-x-14 py-5">
                        @foreach ($parent_cats as $parent_cat)
                            <div style="margin-top:10px;margin-right:50px" class="space-y-2">
                                <a href="{{ route('app.product.index', ['category' => $parent_cat->slug]) }}"
                                    class="flex items-center gap-x-1 text-zinc-700 hover:text-sky-600">
                                    <span class="h-5 w-0.5 rounded-full bg-sky-500"></span>
                                    <div style="font-weight:bold" class="text-sm">{{ $parent_cat->name }}</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        fill="#4d4d4d" viewBox="0 0 256 256">
                                        <path
                                            d="M164.24,203.76a6,6,0,1,1-8.48,8.48l-80-80a6,6,0,0,1,0-8.48l80-80a6,6,0,0,1,8.48,8.48L88.49,128Z">
                                        </path>
                                        <path
                                            d="M164.24,203.76a6,6,0,1,1-8.48,8.48l-80-80a6,6,0,0,1,0-8.48l80-80a6,6,0,0,1,8.48,8.48L88.49,128Z">
                                        </path>
                                    </svg>
                                </a>
                                <ul>
                                    @foreach ($children_cats as $children_cat)
                                        <li>
                                            @if ($children_cat->parent_id == $parent_cat->id)
                                                <a class="block py-2 text-xs text-zinc-600 hover:text-sky-700"
                                                    href="{{ route('app.product.index', ['category' => $children_cat->slug]) }}">
                                                    {{ $children_cat->name }}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                    <!-- <img class="w-36 lg:w-64 mx-auto h-full" src="./assets/image/Electronics.webp" alt=""> -->
                    <!-- </div> -->
                </a>
            </li>
            <li class="text-zinc-700 hover:text-zinc-600 hover:bg-gray-100 transition p-2 rounded-lg">
                <a href="{{ route('app.product.index', ['filter' => 1]) }}">
                    شگفت انگیز ها
                </a>
            </li>
            <!-- <li class="text-zinc-700 hover:text-zinc-600 hover:bg-gray-100 transition p-2 rounded-lg">
          <a href="./search.html">
            پرفروش ترین ها
          </a>
        </li> -->
            <li class="text-zinc-700 hover:text-zinc-600 hover:bg-gray-100 transition p-2 rounded-lg">
                <a href="{{ route('app.home') }}">
                    ارتباط با ما
                </a>
            </li>
            <!-- <li class="text-zinc-700 hover:text-zinc-600 hover:bg-gray-100 transition p-2 rounded-lg">
          <a href="./blog.html">
            وبلاگ
          </a>
        </li> -->
            <!-- <li class="text-zinc-700 transition group">
          <a class="relative block" href="#">
            <div
              class="flex gap-x-1 items-center group-hover:text-zinc-600 hover:bg-gray-200 transition p-2 rounded-lg">
              صفحات
              <svg class="group-hover:rotate-180 transition-all duration-500 group-hover:fill-sky-500"
                xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#000000" viewBox="0 0 256 256">
                <path
                  d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                </path>
              </svg>
            </div>
            <div class="bg-white hidden group-hover:flex flex-col p-2 absolute top-28 w-44 rounded-lg shadow-xl">
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all" href="./404.html">
                خطای 404
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./about-us.html">
                درباره ما
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./blog.html">
                بلاگ
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./cart.html">
                سبد خرید
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./checkout.html">
                پرداخت
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./login.html">
                ورود یا ثبت نام
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./profile.html">
                پروفایل داشبورد
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./search.html">
                جستجو محصول
              </a>
              <a class="hover:bg-sky-500 hover:text-gray-50 px-2 py-1 rounded-md mb-1 transition-all"
                href="./single-product.html">
                جزئیات محصول
              </a>
            </div>
          </a>
        </li> -->
        </ul>
    </div>
</header>
