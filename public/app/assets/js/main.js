//////////////////////////////// Quiantity Input
function quantityDecrement(e) {
  const btn = e.target.parentNode.parentElement.querySelector(
    'button[data-action="increment"]'
  );
  const target = btn.nextElementSibling;
  let value = Number(target.value);
  if (value == 1) return;
  value--;
  target.value = value;
}

function quantityIncrement(e) {
  const btn = e.target.parentNode.parentElement.querySelector(
    'button[data-action="increment"]'
  );
  const target = btn.nextElementSibling;
  let value = Number(target.value);
  value++;
  target.value = value;
}

const quantityDecrementButtons = document.querySelectorAll(
  `button[data-action="decrement"]`
);

const quantityIncrementButtons = document.querySelectorAll(
  `button[data-action="increment"]`
);

quantityDecrementButtons.forEach((btn) => {
  btn.addEventListener("click", quantityDecrement);
});

quantityIncrementButtons.forEach((btn) => {
  btn.addEventListener("click", quantityIncrement);
});

/////////////////////////////////////////////// profile edit address modal
function showCard() {
  let showCard = document.getElementById("cardHeader");
  showCard.classList.remove("hidden");
}
function closeCard() {
  let showCard = document.getElementById("cardHeader");
  showCard.classList.add("hidden");
}

////////////////////////////////////////////// open hover menu header
function showNavbarMobile() {
  let showNavbarMobile = document.getElementById("navbarMobile");
  showNavbarMobile.classList.remove("-right-full");
  showNavbarMobile.classList.add("right-0");
  showNavbarMobile.classList.remove("hidden");
}
function hideNavbarMobile() {
  let hideNavbarMobile = document.getElementById("navbarMobile");
  hideNavbarMobile.classList.add("-right-full");
  hideNavbarMobile.classList.add("hidden");
}
//////////////////////////////////////// off slider
(function () {
  const second = 1000,
    minute = second * 60,
    hour = minute * 60,
    day = hour * 24;

  //I'm adding this section so I don't have to keep updating this pen every year :-)
  //remove this if you don't need it
  let today = new Date(),
    yyyy = today.getFullYear(),
    dayMonth = "12/29/",
    birthday = dayMonth + yyyy;

  const countDown = new Date(birthday).getTime(),
    x = setInterval(function () {
      const now = new Date().getTime(),
        distance = countDown - now;
      // (document.getElementById("days").innerText = Math.floor(distance / day)),
      for (let i = 0; i < document.querySelectorAll("#days").length; i++) {
        document.querySelectorAll("#days")[i].innerText = Math.floor(
          distance / day
        );
        document.querySelectorAll("#hours")[i].innerText = Math.floor(
          (distance % day) / hour
        );
        document.querySelectorAll("#minutes")[i].innerText = Math.floor(
          (distance % hour) / minute
        );
        document.querySelectorAll("#seconds")[i].innerText = Math.floor(
          (distance % minute) / second
        );
      }
    }, 1000);
})();

////////////////////////////////// btn go to up
let mybutton = document.getElementById("btn-back-to-top");
function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
/////////////////////////////////////////////// profile edit address modal
function showEditAddress(id, province, city, addressLine, postalCode, houseNumber, unitNumber) {
  let showEditAddress = document.getElementById("showEditAddress");
  showEditAddress.classList.remove("hidden");

  document.querySelector('input[name="province"]').value = province;
  document.querySelector('input[name="city"]').value = city;
  document.querySelector('input[name="address_line"]').value = addressLine;
  document.querySelector('input[name="postal_code"]').value = postalCode;
  document.querySelector('input[name="house_number"]').value = houseNumber;
  document.querySelector('input[name="unit_number"]').value = unitNumber;

  document.querySelector('input[name="address_id"]').value = id;
}
function closeEditAddress() {
  let showEditAddress = document.getElementById("showEditAddress");
  showEditAddress.classList.add("hidden");
}
//////////////////////////////////// Verify 4 Code

const button = document.querySelector("button");
let arrayInputs = [];
arrayInputs = document.querySelectorAll(".inputVerify");
arrayInputs.forEach((input, index1) => {
  input.addEventListener("keyup", (e) => {
    const currentInput = input,
      nextInput = input.nextElementSibling,
      prevInput = input.previousElementSibling;
    if (currentInput.value.length > 1) {
      currentInput.value = "";
      return;
    }
    if (
      nextInput &&
      nextInput.hasAttribute("disabled") &&
      currentInput.value !== ""
    ) {
      nextInput.removeAttribute("disabled");
      nextInput.focus();
    }
    if (e.key === "Backspace") {
      arrayInputs.forEach((input, index2) => {
        if (index1 <= index2 && prevInput) {
          input.setAttribute("disabled", true);
          input.value = "";
          prevInput.focus();
        }
      });
    }
    if (!arrayInputs[3].disabled && arrayInputs[3].value !== "") {
      button.classList.add("active");
      return;
    }
    button.classList.remove("active");
  });
});
window.addEventListener("load", () => arrayInputs[0].focus());
///////////////////////////////////////////////// verify resend code
var minutes = 0;
var seconds = 60;

var x = setInterval(function () {
  if (seconds != 0) {
    seconds--;
  } else if (seconds == 0) {
    minutes--;
    seconds = 59;
  }
  if (document.getElementById("verify-code")) {
    document.getElementById("verify-code").innerHTML = "ارسال مجدد کد بعد از " + "ثانیه " + seconds;
  }
  if (seconds == 0 && minutes == 0) {
    clearInterval(x);
    document.getElementById("block-verify-code").innerHTML =
      "<a href='#'>ارسال مجدد</a>";
  }
}, 1000);


/////////////////////////////////////////// product comparision show select product
function showSelectProduct() {
  let showSelectP = document.getElementById("showSelectP");
  showSelectP.classList.remove("hidden");
}
function closeSelectP() {
  let showSelectP = document.getElementById("showSelectP");
  showSelectP.classList.add("hidden");
}
/////////////////////////////////////////// product images modal
function showImagesProduct() {
  let showImagesP = document.getElementById("showImagesModal");
  showImagesP.classList.remove("hidden");
}
function closeImagesProduct() {
  let showImagesP = document.getElementById("showImagesModal");
  showImagesP.classList.add("hidden");
}
/////////////////////////////////////////// slide show single product
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides((slideIndex += n));
}

function currentSlide(n) {
  showSlides((slideIndex = n));
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}








function showModal({
  title = 'پیام',
  message = '',
  type = 'info',   // info, success, error, confirm
  confirmCallback = null
}) {
  const modal = $('#ajaxModal');
  const modalBox = $('#ajaxModalBox');
  const modalTitle = $('#ajaxModalTitle');
  const modalContent = $('#ajaxModalContent');
  const modalButtons = $('#ajaxModalButtons');
  const modalIcon = $('#ajaxModalIcon');

  modalTitle.text(title);
  modalContent.html(message);
  modalButtons.html('');

  // انتخاب آیکون
  let iconHTML = '';
  if (type === 'success') iconHTML = '<span class="text-green-500">✔️</span>';
  if (type === 'error') iconHTML = '<span class="text-red-500">❌</span>';
  if (type === 'info') iconHTML = '<span class="text-blue-500">ℹ️</span>';
  if (type === 'confirm') iconHTML = '<span class="text-yellow-500">⚠️</span>';
  modalIcon.html(iconHTML);

  if (type === 'confirm') {
    modalButtons.append('<button id="modalYes" class="px-4 py-2 bg-green-500 text-white rounded-xl shadow hover:bg-green-600 transition">بله</button>');
    modalButtons.append('<button id="modalNo" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-xl shadow hover:bg-gray-400 transition">خیر</button>');

    $('#modalYes').click(function () {
      if (confirmCallback) confirmCallback();
      hideModal();
    });
    $('#modalNo').click(hideModal);
  } else {
    let btnClass = 'bg-blue-500';
    if (type === 'success') btnClass = 'bg-green-500';
    if (type === 'error') btnClass = 'bg-red-500';

    modalButtons.append(`<button id="modalOk" class="px-4 py-2 ${btnClass} text-white rounded-xl shadow hover:opacity-80 transition">تایید</button>`);
    $('#modalOk').click(hideModal);
  }

  // نمایش مودال با انیمیشن نرم
  modal.removeClass('hidden');
  setTimeout(() => {
    modalBox.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
  }, 50);
}

function hideModal() {
  const modal = $('#ajaxModal');
  const modalBox = $('#ajaxModalBox');
  modalBox.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
  setTimeout(() => {
    modal.addClass('hidden');
  }, 200);
}

// بستن با ضربدر
$('#ajaxModalClose').click(hideModal);
