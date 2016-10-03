$(document).ready(function() {
  'use strict';

  $('.menu > ul').addClass('nav-menu');

  var didScroll = false;

  $(window).scroll(function(event){
    didScroll = true;
  });

  // run hasScrolled() and reset didScroll status
  setInterval(function() {
    if (didScroll) {
      hasScrolled();
      didScroll = false;
    }
  }, 250);

  var headerHeight = $('.site-header').outerHeight(),
      header = $('.header-hover');

  function hasScrolled() {
    if ($(window).scrollTop() >= headerHeight)
      header.addClass('is-scrolled');
    else
      header.removeClass('is-scrolled');
  }

  header.mouseenter(function() {
    header.removeClass('is-hidden');
  });

  header.mouseleave(function() {
    header.addClass('is-hidden');
  })

  // Toggle menu button active state
  // -------------------------------
  var menuToggle = $('.menu-toggle'),
      siteHeader = $('.site-header'),
      mainNav = $('.main-navigation');


  menuToggle.click(function(e) {
    e.preventDefault();

    menuToggle.toggleClass('is-active');
    siteHeader.toggleClass('is-active');
    mainNav.toggleClass('is-active');
  });

  $('html').click(function() {
    //Hide the menus if visible
    if ( menuToggle.hasClass('is-active') ) {
      menuToggle.toggleClass('is-active');
      siteHeader.toggleClass('is-active');
      mainNav.toggleClass('is-active');
    }
  });

  $('.site-header').click(function(e) {
    e.stopPropagation();
  });

  // Header animation on scroll
  // --------------------------
  // var headerHeight = $('.site-header').height();

  // $(window).scroll(function() {
  //   if ($(window).scrollTop() >= headerHeight)
  //     $('.site-header').addClass('is-scrolled');
  //   else
  //     $('.site-header').removeClass('is-scrolled');
  // });
});