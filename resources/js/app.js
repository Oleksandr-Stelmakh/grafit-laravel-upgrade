
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

// import 'bootstrap/dist/js/bootstrap.bundle';

import * as bootstrap from 'bootstrap/dist/js/bootstrap.bundle';

window.bootstrap = bootstrap;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import './modern/script.js';

// === Carousel helper ===
window.goToSlide = function (index) {
   const carousel = document.querySelector('#MaketsCarousel');
   const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);

   bsCarousel.to(index);
   setActiveSlide(index);
}

// подсветка активного элемента
function setActiveSlide(index) {
   document.querySelectorAll('.slide-one').forEach(el => {
      el.classList.remove('active');

      if (parseInt(el.dataset.index) === index) {
         el.classList.add('active');
      }
   });
}

// события карусели
document.addEventListener('DOMContentLoaded', function () {
   const carousel = document.querySelector('#MaketsCarousel');

   if (!carousel) return;

   carousel.addEventListener('slid.bs.carousel', function (e) {
      setActiveSlide(e.to);
   });

   // начальная подсветка
   setActiveSlide(0);
});
