<!DOCTYPE html>
<html lang="fa" dir="rtl" class="scroll-smooth">
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ارتباط با ما</title>

  <link rel="stylesheet" href="<?= url('public/app/assets/css/main.css') ?>">

</head>
<body class="mx-auto bg-[#fcfcfc]">
	<!-- header -->
	<?php
	require_once (BASE_PATH . '/views/app/layouts/header.php')
	?>
	<!-- end header -->
  <main class="pt-24 md:pt-36 max-w-[1600px] mx-auto px-3 md:px-6">
    <div class="bg-white border rounded-xl shadow-lg p-4">
      <div>
        <span class="flex items-center justify-center mt-4 mb-8 md:mt-10 md:mb-14 gap-x-5">
          <div class="w-full h-px bg-zinc-300">
          </div>
          <div class="text-xl md:text-4xl font-semibold text-zinc-700 min-w-max text-center">
            ارتباط با ما
          </div>
          <div class="w-full h-px bg-zinc-300">
          </div>
        </span>
        <div class="border border-dashed border-zinc-400 p-5 rounded-lg mt-10 grid md:grid-cols-2 gap-5">
          <div>
            <div class="text-2xl font-semibold text-zinc-600">
              با ما در ارتباط باشید
            </div>
            <div>
            <?php $sending_done_message = flash('sending_message_done');
                    $message = flash('sending_message');
                    if(!empty($message)){ ?>
                    <h3 style="color:red"><?= $message ?></h3>
            <?php } 
              if(!empty($sending_done_message)){ ?>
                <h3 style="color:green"><?= $sending_done_message ?></h3>
            <?php } ?>
            </div>
            <form action="<?= url('contact-us/sendMessage') ?>" method="POST">
            <div class="grid grid-cols-2 gap-5 mt-4 mb-3">
              <input class="border p-2 rounded-lg border-zinc-400 focus:outline-none" type="text" name="first_name" placeholder="نام">
              <input class="border p-2 rounded-lg border-zinc-400 focus:outline-none" type="text" name="last_name" placeholder="نام خانوادگی">
            </div>
            <div class="grid grid-cols-2 gap-5 mt-4 mb-3">
              <input class="border p-2 rounded-lg border-zinc-400 focus:outline-none" type="text" name="phone_number" placeholder="شماره همراه">
              <input class="border p-2 rounded-lg border-zinc-400 focus:outline-none" type="email" name="email" placeholder="ایمیل">
              <input class="border p-2 rounded-lg border-zinc-400 focus:outline-none" type="text"  name="title" placeholder="موضوع">
            </div>
            <div>
              <textarea class="border p-2 rounded-lg border-zinc-400 focus:outline-none w-full" placeholder="توضیحات" name="message" id="" cols="30" rows="5"></textarea>
            </div>
            <div>
              <button class="bg-sky-600 hover:bg-sky-700 transition px-8 py-2 mt-2 rounded-lg text-white">
                ارسال اطلاعات
              </button>
            </div>
          </form>
          </div>
          <!-- <div>
            <iframe class="rounded-3xl w-full mt-5" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5487.320972393403!2d59.6102611712093!3d36.28800020180445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f6c91ef5993b861%3A0xbc78a4fdeb4d00b5!2z2K3YsdmFINin2YXYp9mFINix2LbYpyDYudmE24zZhyDYp9mE2LPZhNin2YU!5e0!3m2!1sen!2sus!4v1690833786920!5m2!1sen!2sus" width="" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div> -->
        </div>
      </div>
    </div>
  </main>
	<!-- footer -->
	<?php
	require_once (BASE_PATH . '/views/app/layouts/footer.php')
	?>
	<!-- end footer -->
</body>
  <!-- main javaScript code -->
  <script src="<?= url('public/app/assets/js/main.js') ?>"></script>

</html>