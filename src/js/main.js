(function($) {
  $(document).ready(function() {
    'use strict';

    // $('.menu > ul').addClass('nav-menu');

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

    // var headerHeight = $('.site-header').outerHeight();
    var page = $('#page');

    function hasScrolled() {
      if ($(window).scrollTop() >= 100)
        page.addClass('is-scrolled');
      else
        page.removeClass('is-scrolled');
    }

    // Toggle menu button active state
    // -------------------------------
    var menuToggle = $('.menu-toggle'),
        siteHeader = $('.site-title'),
        mainNav = $('.main-navigation');


    menuToggle.click(function(e) {
      e.preventDefault();

      menuToggle.toggleClass('is-active');
      siteHeader.toggleClass('is-active');
      mainNav.toggleClass('is-active');
    });

    // $('html').click(function() {
    //   //Hide the menus if visible
    //   if ( menuToggle.hasClass('is-active') ) {
    //     menuToggle.toggleClass('is-active');
    //     siteHeader.toggleClass('is-active');
    //     mainNav.toggleClass('is-active');
    //   }
    // });

    // $('.site-header').click(function(e) {
    //   e.stopPropagation();
    // });

    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    // menuToggle.click(function(e) {
    //   $(this).toggleClass('is-active');
    // });

    // Close the dropdown menu if the user clicks outside of it
    // window.onclick = function(event) {
    //   if (!event.target.matches('.menu-toggle')) {
    //     menuToggle.toggleClass('is-active');
    //     siteHeader.toggleClass('is-active');
    //     mainNav.toggleClass('is-active');
    //   }
    // }

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
})( jQuery );