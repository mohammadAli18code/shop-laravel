<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <title>قالب پنل مدیریت |نت کپی</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/responsive_991.css') }}" media="(max-width:991px)">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/responsive_768.css') }}" media="(max-width:768px)">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/font.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('css')

    {{-- <link rel="stylesheet" href="{{ url('public/app/assets/css/main.css') }} "> --}}

</head>

<body class="mx-auto bg-[#fcfcfc]">

    @include('partials.admin.sidebar')

    @include('partials.admin.header')

    @yield('content')

    <!-- AJAX Modal -->
    <!-- AJAX Modal Professional -->
    <!-- AJAX Modal Modern -->



    {{-- <div id="ajaxModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <!-- پس‌زمینه تاریک با بلور -->
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity"></div>

        <!-- مودال اصلی -->
        <div class="bg-white rounded-3xl shadow-2xl w-11/12 sm:w-96 mx-auto z-50 overflow-hidden transform scale-95 opacity-0 transition-all duration-300"
            id="ajaxModalBox">
            <!-- هدر مودال -->
            <div class="p-5 flex items-center gap-3 border-b border-gray-200">
                <div id="ajaxModalIcon" class="text-2xl"></div>
                <h3 id="ajaxModalTitle" class="text-lg font-semibold text-gray-700 flex-1">پیام</h3>
                <button id="ajaxModalClose"
                    class="text-gray-400 hover:text-gray-700 text-2xl font-bold transition-transform hover:scale-110">&times;</button>
            </div>

            <!-- محتوا -->
            <div id="ajaxModalContent" class="p-5 text-gray-600 text-sm"></div>

            <!-- دکمه‌ها -->
            <div id="ajaxModalButtons" class="p-5 flex justify-end gap-3"></div>
        </div>
    </div> --}}




</body>
@yield('script')

</html>
