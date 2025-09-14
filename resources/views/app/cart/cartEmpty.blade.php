@extends('layouts.app')

@section('title', 'سبد خالی است')

@section('content')

    <main class="pt-24 md:pt-36 max-w-[1600px] mx-auto px-3 md:px-6">
        <span class="flex items-center justify-center mt-4 mb-8 md:mt-10 md:mb-14 gap-x-5">
            <div class="w-full h-px bg-zinc-300">
            </div>
            <div class="text-xl md:text-4xl font-semibold text-zinc-700 min-w-max text-center">
                سبد خرید
            </div>
            <div class="w-full h-px bg-zinc-300">
            </div>
        </span>
        <div class="text-center text-xl md:text-2xl text-zinc-600 font-semibold">
            سبد خرید خالی است!
            <a href=""
                class="text-gray-50 mx-auto w-fit mb-2 block px-6 md:px-8 py-2 mt-5 rounded-lg bg-gradient-to-r from-sky-500 to-sky-600 hover:opacity-80 transition">
                محصولات پرطرفدار
            </a>
        </div>
    </main>

@endsection

@section('script')
    <!-- main javaScript code -->
    <script src="{{ asset('app/assets/js/main.js') }}"></script>
@endsection

</html>
