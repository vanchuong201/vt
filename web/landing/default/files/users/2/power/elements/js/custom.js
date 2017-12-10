// JavaScript Document



	$(window).on('load', function() {
	
		"use strict";
						
		/*----------------------------------------------------*/
		/*	Preloader
		/*----------------------------------------------------*/
		
		$("#loader").delay(100).fadeOut();
		$("#loader-wrapper").delay(100).fadeOut("fast");
				
		$(window).stellar({});
		
	});
	
	
	
	$(window).on('scroll', function() {
		
		"use strict";
		
						
		/*----------------------------------------------------*/
		/*	Navigtion Menu Scroll
		/*----------------------------------------------------*/	
		
		var b = $(window).scrollTop();
		
		if( b > 60 ){		
			$(".navbar").addClass("scroll");
		} else {
			$(".navbar").removeClass("scroll");
		}
		
		
		/*----------------------------------------------------*/
		/*	Blue Circle Progress Bars
		/*----------------------------------------------------*/
	
			if ($().easyPieChart) {
				
			var count = 0 ;
			var colors = ['#25c6ff']; // Circle bar color

			$('.percentage').each(function(){

				var imagePos = $(this).offset().top;
				var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {

					$(this).easyPieChart({
						barColor: colors[count],
						trackColor: 'rgba(20, 20, 20, .1)',
						scaleColor: false,
						scaleLength: false,
						lineCap: 'butt',
						rotate: 0,
						lineWidth: 5,
						size: 150,						
						animate: 1350,
						onStep: function(from, to, percent) {
								$(this.el).find('.percent').text(Math.round(percent));
							}
							
						});
					
					}

					count++;
					if (count >= colors.length) { count = 0};
				
				});

			}
				

	});
	
	
	
	$(document).ready(function() {
		
		"use strict";
		

		/*----------------------------------------------------*/
		/*	Header Fixed on Top White Bg
		/*----------------------------------------------------*/
	
		var heHeight = $('#navigation-menu').css("height");	
		if ($('.navbar').hasClass('bg-white')) {
			$('.header').css("margin-bottom", heHeight )
		}
		
		
		/*----------------------------------------------------*/
		/*	Header Fixed on Top Transparent Bg
		/*----------------------------------------------------*/
	
		if ($('.navbar').hasClass('no-bg')) {
			$('.intro-section').addClass('wide-intro')
		}
		
		
		/*----------------------------------------------------*/
		/*	Mobile Menu Toggle
		/*----------------------------------------------------*/
		
		$('.navbar-nav li.nav-link').on('click', function() {				
			$('#navigation-menu').css("height", "1px").removeClass("in").addClass("collapse");
			$('#navigation-menu').removeClass("open");				
		});
		
		
		/*----------------------------------------------------*/
		/*	Countdown
		/*----------------------------------------------------*/
		
		$("#clock").countdown("2017/03/08 20:00:00", function(event) {
			$(this).html( event.strftime(''     
				+ '<div class="cbox-1 clearfix"><span class="cbox-1-digit">%D</span> <span class="cbox-1-txt">Days</span></div>'
				+ '<div class="cbox-1 clearfix"><span class="cbox-1-digit">%H</span> <span class="cbox-1-txt">Hrs</span></div>'
				+ '<div class="cbox-1 clearfix"><span class="cbox-1-digit">%M</span> <span class="cbox-1-txt">Min</span></div>'
				+ '<div class="cbox-1 clearfix"><span class="cbox-1-digit">%S</span> <span class="cbox-1-txt">Sec</span></div>'
			));
		});
				
				
		/*----------------------------------------------------*/
		/*	OnScroll Animation
		/*----------------------------------------------------*/
		
		$('.animated').appear(function() {

	        var elem = $(this);
	        var animation = elem.data('animation');

	        if ( !elem.hasClass('visible') ) {
	        	var animationDelay = elem.data('animation-delay');
	            if ( animationDelay ) {
	                setTimeout(function(){
	                    elem.addClass( animation + " visible" );
	                }, animationDelay);

	            } else {
	                elem.addClass( animation + " visible" );
	            }
	        }
						
		});
		
		
		/*----------------------------------------------------*/
		/*	Intro Typed Text
		/*----------------------------------------------------*/
		
		$(".typed-element").typed({
			strings: ["elegant", "responsive", "functional", "creative", "modern"]
		});
		
		
		/*----------------------------------------------------*/
		/*	Intro Slider
		/*----------------------------------------------------*/
	
		$('.intro_slider').flexslider({
			animation: "fade",
			controlNav: false,
			directionNav: false,  
			slideshowSpeed: 4000,   
			animationSpeed: 700,  
			start: function(slider){
				$('body').removeClass('loading');
			}
		});

		
		/*----------------------------------------------------*/
		/*	Animated Scroll To Anchor
		/*----------------------------------------------------*/
		
		$('.header a[href^="#"], .page a.btn[href^="#"]').on('click', function (e) {
			
			e.preventDefault();

			var target = this.hash,
				$target = jQuery(target);

			$('html, body').stop().animate({
				'scrollTop': $target.offset().top - 60 // - 200px (nav-height)
			}, 'slow', 'easeInSine', function () {
				window.location.hash = '1' + target;
			});
			
		});
		
		
		/*----------------------------------------------------*/
		/*	ScrollUp
		/*----------------------------------------------------*/
		
		$.scrollUp = function (options) {

			// Defaults
			var defaults = {
				scrollName: 'scrollUp', // Element ID
				topDistance: 600, // Distance from top before showing element (px)
				topSpeed: 800, // Speed back to top (ms)
				animation: 'fade', // Fade, slide, none
				animationInSpeed: 200, // Animation in speed (ms)
				animationOutSpeed: 200, // Animation out speed (ms)
				scrollText: '', // Text for element
				scrollImg: false, // Set true to use image
				activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
			};

			var o = $.extend({}, defaults, options),
				scrollId = '#' + o.scrollName;

			// Create element
			$('<a/>', {
				id: o.scrollName,
				href: '#top',
				title: o.scrollText
			}).appendTo('body');
			
			// If not using an image display text
			if (!o.scrollImg) {
				$(scrollId).text(o.scrollText);
			}

			// Minium CSS to make the magic happen
			$(scrollId).css({'display':'none','position': 'fixed','z-index': '2147483647'});

			// Active point overlay
			if (o.activeOverlay) {
				$("body").append("<div id='"+ o.scrollName +"-active'></div>");
				$(scrollId+"-active").css({ 'position': 'absolute', 'top': o.topDistance+'px', 'width': '100%', 'border-top': '1px dotted '+o.activeOverlay, 'z-index': '2147483647' });
			}

			// Scroll function
			$(window).scroll(function(){	
				switch (o.animation) {
					case "fade":
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed) );
						break;
					case "slide":
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed) );
						break;
					default:
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0) );
				}
			});

			// To the top
			$(scrollId).click( function(event) {
				$('html, body').animate({scrollTop:0}, o.topSpeed);
				event.preventDefault();
			});

		};
		
		$.scrollUp();
		
		
		/*----------------------------------------------------*/
		/*	Video Background
		/*----------------------------------------------------*/
		
		$('.video-play').vide("images/video/video", {
			posterType: "jpg"
		});
		
		
		/*----------------------------------------------------*/
		/*	Filterable Portfolio
		/*----------------------------------------------------*/
	
		$("#portfolio-1-2 .row, #portfolio-2-2 .row, #portfolio-2-3 .row").mixitup({
			targetSelector: '.portfolio-item',
		});
		
		
		/*----------------------------------------------------*/
		/*	Single Image Lightbox
		/*----------------------------------------------------*/
				
		 if( $(".image-link").length ){ 
		   $('.image-link').magnificPopup({
			  type: 'image'
			});
		 }
		
		
		/*----------------------------------------------------*/
		/*	Images Gallery Lightbox
		/*----------------------------------------------------*/
		
		$('.gallery-item').magnificPopup({
		  type: 'image',
		  gallery:{
			enabled:true
		  }
		});
		
		
		/*----------------------------------------------------*/
		/*	Video Link Lightbox
		/*----------------------------------------------------*/
		
		$('.video-popup').magnificPopup({
		    type: 'iframe',
		  	  
				iframe: {
					patterns: {
						youtube: {
			   
							index: 'youtube.com',
							src: 'https://www.youtube.com/embed/kuceVNBTJio'
				
								}
							}
						}		  		  
		});
		
		
		/*----------------------------------------------------*/
		/*	Statistic Counter
		/*----------------------------------------------------*/
	
		$('.statistic-number').each(function () {
			$(this).appear(function() {
				$(this).prop('Counter',0).animate({
					Counter: $(this).text()
				}, {
					duration: 4000,
					easing: 'swing',
					step: function (now) {
						$(this).text(Math.ceil(now));
					}
				});
			},{accX: 0, accY: 0});
		});
		
		
		/*----------------------------------------------------*/
		/*	Our Clients Carousel
		/*----------------------------------------------------*/
	
		$(".clients-logo-carousel").owlCarousel({
					  
			slideSpeed : 1200,
			items : 5,
			itemsDesktop : [1199,6],
			itemsDesktopSmall : [991,4],
			itemsTablet: [767,4],
			itemsMobile : [479,2],
			navigation:true,
			pagination:false,
			navigationText : false
					  
		});
		
		
		/*----------------------------------------------------*/
		/*	Screens Carousel
		/*----------------------------------------------------*/
		
		$(".screens_carousel").owlCarousel({
					  
			slideSpeed : 600,
			items : 4,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [991,2],
			itemsTablet: [768,2],
			itemsMobile : [479,1],
			navigation: true,
			pagination: true,
			navigationText : false
					  
		});
				
		// Carousel Navigation
		$(".next").on('click', function(){
			$(".screens_carousel").trigger('owl.next');
		})
		
		$(".prev").on('click', function(){
			$(".screens_carousel").trigger('owl.prev');
		})
		
		
		
		/*----------------------------------------------------*/
		/*	Blog Articles Rotator
		/*----------------------------------------------------*/
	
		$(".blog-posts-holder").owlCarousel({
			
			autoPlay : true,
			slideSpeed : 1000,
			items : 3,
			itemsDesktop : [1199,2],
			itemsDesktopSmall : [991,2],
			itemsTablet: [768,2],
			itemsMobile : [480,1],
			navigation: false,
			pagination: true,
			navigationText : false
					  
		});
		
		
		/*----------------------------------------------------*/
		/*	Testimonials Rotator
		/*----------------------------------------------------*/
		
		$('.flexslider').flexslider({
			animation: "fade",
			controlNav: true,
			directionNav: false,  
			slideshowSpeed: 5000,   
			animationSpeed: 2000,  
			start: function(slider){
				$('body').removeClass('loading');
			}
		});	
		
		
		/*----------------------------------------------------*/
		/*	Contact Form Validation
		/*----------------------------------------------------*/
		
		$(".contact-form").validate({
			rules:{ 
					name:{
						required: true,
						minlength: 1,
						maxlength: 16,
					},
					email:{
						required: true,
						email: true,
					},
					subject:{
						required: true,
						minlength: 4,
						maxlength: 24,
					},		
					message:{
						required: true,
						minlength: 2,
						}
					},
					messages:{
							name:{
								required: "Please enter no more than (1) characters"
							}, 
							email:{
								required: "We need your email address to contact you",
								email: "Your email address must be in the format of name@domain.com"
							}, 
							message:{
								required: "Please enter no more than (2) characters"
							}, 
						}
		});	
		
		
		/*----------------------------------------------------*/
		/*	Callback Form Validation
		/*----------------------------------------------------*/
		
		$(".callback-form").validate({
			rules:{ 
					name:{
						required: true,
						minlength: 2,
						maxlength: 16,
					},
					email:{
						required: true,
						email: true,
						}
					},
					messages:{
							name:{
								required: "Please enter no more than (1) characters"
							}, 
							email:{
								required: "We need your email address to contact you",
								email: "Your email address must be in the format of name@domain.com"
							}, 
						}
		});
		
		
		/*----------------------------------------------------*/
		/*	Register Form Validation
		/*----------------------------------------------------*/
		
		$(".register-form").validate({
			rules:{ 
					name:{
						required: true,
						minlength: 2,
						maxlength: 16,
					},
					email:{
						required: true,
						email: true,
					},
					phone:{
						required: true,
						digits: true,
						}
					},
					messages:{
							name:{
								required: "Please enter no more than (1) characters"
							}, 
							email:{
								required: "We need your email address to contact you",
								email: "Your email address must be in the format of name@domain.com"
							}, 
							phone:{
								required: "Please enter only digits",
								digits: "Please enter a valid number"
							}, 
						}
		});
		
		
		/*----------------------------------------------------*/
		/*	Newsletter Subscribe Form
		/*----------------------------------------------------*/
	
		$('.newsletter-form').ajaxChimp({
        language: 'cm',
        url: 'http://dsathemes.us3.list-manage.com/subscribe/post?u=af1a6c0b23340d7b339c085b4&id=344a494a6e'
            //http://xxx.xxx.list-manage.com/subscribe/post?u=xxx&id=xxx
		});


		$.ajaxChimp.translations.cm = {
			'submit': 'Submitting...',
			0: 'We have sent you a confirmation email',
			1: 'Please enter a value',
			2: 'An email address must contain a single @',
			3: 'The domain portion of the email address is invalid (the portion after the @: )',
			4: 'The username portion of the email address is invalid (the portion before the @: )',
			5: 'This email address looks fake or invalid. Please enter a real email address'
		};
		
					
	});		
	
	
	
