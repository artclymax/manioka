//import "jarallax/dist/jarallax.min.css";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
//import "aos/dist/aos.css";
import "./scss/style.scss";
//!
import { Swiper } from "swiper/bundle";

//import { jarallax } from "jarallax";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
//import AOS from "AOS";

import { AutoCalc } from "./js/AutoCalc.js";
import { Menu } from "./js/Menu.js";
//import { RunningLine } from './js/RunningLine.js';
//import { BackdropList } from './js/BackdropList.js';
import { Modal } from "./js/Modal.js";
//import { cookies } from "./js/Cookies.js";
//import { AnimationCounter } from "./js/AnimationCounter.js";
//import HiddenDescr from "./js/HiddenDescr.js";
//import HiddenList from "./js/HiddenList.js";
import { imask } from "./js/imask.js";
import { fileBtn } from "./js/FileBtn.js";
//import { CustomFieldSelect } from "./js/CustomFieldSelect.js";
import { Spoiler } from "./js/Spoiler.js";
import { ScrollToTop } from "./js/ScrollToTop.js";
import { MXSwiper } from "./js/MXSwiper.js";
//import { CustomSelect } from "./js/CustomSelect.js";
//import { Tabs } from './js/Tabs.js';
//import { MapScrollLock } from './js/MapScrollLock.js';
//import { cf7CustomValidation } from './js/cf7-validation.js';
//import { SelectFromAcf } from './js/SelectFromAcf.js';
//import { loadMore } from './js/loadMore.js';
//import AirDatepicker from 'air-datepicker';
//import 'air-datepicker/air-datepicker.css';
//document.querySelectorAll('input.form-input-date')?.forEach(input => {
//	new AirDatepicker(input, {
//		selectedDates: [new Date()],
//		isMobile: true,
//		autoClose: true,
//		minDate: new Date(),
//	});
//})
// time
//document.querySelectorAll('input.form-input-time')?.forEach(input => {
//	new AirDatepicker(input, {
//		isMobile: true,
//		autoClose: true,
//		timepicker: true,
//		onlyTimepicker: true
//	});
//})
//cf7CustomValidation();

// FOR CONTACTS FORM 7
//import "./js/redirect-to-thanks-page.js";

new AutoCalc();
//new CustomFieldSelect({
//	input: '.form-wrapper .cf-select',
//	lastEdit: false
//});
new Menu({
	btn: ".burger-btn", //.burger-btn-icon
	menu: ".header-menu",
	activeClass: "open-header-menu",
	closeBtns: ["a", ".cart-btn"],
});
//new Menu({
//	btn: '.filter-mobile-btn',
//	menu: '.filter',
//	activeClass: 'open-filter-menu',
//	closeBtns: ['.filter-close-btn']
//})
//new Menu({
//	btn: '.header__phone-btn', //.burger-btn-icon
//	menu: '.header-phone-box',
//	activeClass: 'open-phone-box',
//	//closeBtns: ['.menu-close-btn']
//})

//new BackdropList();

new Modal();

//jarallax(document.querySelectorAll(".jarallax"), {
//	speed: 0.2,
//});

//cookies();
imask();

Fancybox.bind("[data-fancybox]", {
	placeFocusBack: false,
});

//new RunningLine();
new ScrollToTop();

new Spoiler();

//new Spoiler('[data-spoiler]', {
//	onlyOneOpen: true,
//	activeClass: 'is-open',
//});

//new Spoiler('[data-spoiler]', { media: 'max-width: 768px' });

new MXSwiper();

//new Tabs();

//new CustomSelect({
//	selector: "select",
//	forceSend: true,
//});

//new MapScrollLock();
/*
window.addEventListener('scroll', function () {
	const header = document.querySelector('.header');

	if (window.scrollY > 50) {
		header.classList.add('scrolled');
	} else {
		header.classList.remove('scrolled');
		const valueUnits = header.offsetHeight;
		document.querySelector(':root').style.setProperty(`--header-height`, valueUnits + 'px');
	}
});
*/

fileBtn(); //

//new Tabs();

//document.querySelectorAll('video.wp-video-shortcode').forEach(video => {
//	if (!video.src) {
//		const link = video.querySelector('a');
//		if (link) video.src = link.href;
//	}
//});

//document?.querySelectorAll('.wpcf7-acceptance input[type="checkbox"]')?.forEach(el => {
//	el.checked = true;
//})

//AOS.init({
//	disable: 'mobile',
//	duration: 600,
//	offset: 100
//});

//new SelectFromAcf('.custom-select-product', {
//	data: '.select-products-data'
//})

//loadMore();

//AnimationCounter();

//HiddenDescr();

//HiddenList();

document.addEventListener("DOMContentLoaded", () => {
	const mainSwiperEl = document.querySelector('[data-product-swiper="main"]');
	const thumbsSwiperEl = document.querySelector(
		'[data-product-swiper="thumbs"]',
	);

	if (!mainSwiperEl || !thumbsSwiperEl) return;

	// Ждём загрузки Swiper (если подключается через defer/async)
	const initSliders = () => {
		if (typeof Swiper === "undefined") {
			setTimeout(initSliders, 100);
			return;
		}

		const thumbsSwiper = new Swiper(thumbsSwiperEl, {
			slidesPerView: 3,
			spaceBetween: 10,
			freeMode: true,
			watchSlidesProgress: true,
			breakpoints: {
				768: { spaceBetween: 20,},
			},
		});

		new Swiper(mainSwiperEl, {
			slidesPerView: 1,
			spaceBetween: 20,
			rewind: true,
			thumbs: {
				swiper: thumbsSwiper,
			},
		});
	};

	initSliders();
});
