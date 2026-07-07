//sticky header
import {stickyHeader} from 'lib/header';
stickyHeader();

import {search} from 'lib/search';
search();

import {cursor} from 'lib/cursor';
const elements = document.querySelectorAll('.value > p');
cursor(elements);

import {accordion} from 'lib/accordion';
accordion();


import {hamburger} from 'lib/navigation';
hamburger();

import {copyToClipboard} from 'lib/clipboard';

document.querySelectorAll('.value[data-copy]').forEach(el => {
	el.addEventListener('click', copyToClipboard);
});
	

// import {setHeight} from 'lib/height';
// import {equalheight} from 'lib/height';

// window.addEventListener("load", function(){
//   equalheight('.panel-eq-height')
// })
// window.addEventListener("resize", function(){
//   setTimeout(function(){
//     equalheight('.panel-eq-height')
//   })
// })

import {submenus} from 'lib/navigation';
submenus();

import {mobilesubnav} from 'lib/navigation';
mobilesubnav();

// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

// import styles bundle
import 'swiper/css/bundle';

// init Swiper:
const swiper = new Swiper('.swiper-container', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  slidesPerView: '1',

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
});