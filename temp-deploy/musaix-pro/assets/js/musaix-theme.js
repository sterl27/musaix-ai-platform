/**
 * Musaix Pro Theme JavaScript
 * 
 * Enhanced interactivity for the Musaix Pro dark theme
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        
        // Initialize theme features
        initSmoothScrolling();
        initNavigationEffects();
        initAnimations();
        initMusicPlayer();
        initContactForm();
        initFAQ();
        
    });

    /**
     * Smooth Scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'easeInOutCubic');
            }
        });
    }

    /**
     * Navigation scroll effects
     */
    function initNavigationEffects() {
        const nav = $('#main-nav');
        let lastScrollTop = 0;
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            // Background opacity effect
            if (scrollTop > 100) {
                nav.css('background', 'rgba(15, 15, 35, 0.98)');
                nav.css('backdrop-filter', 'blur(10px)');
            } else {
                nav.css('background', 'rgba(15, 15, 35, 0.95)');
                nav.css('backdrop-filter', 'blur(5px)');
            }
            
            // Hide/show navigation on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                nav.css('transform', 'translateY(-100%)');
            } else {
                nav.css('transform', 'translateY(0)');
            }
            
            lastScrollTop = scrollTop;
        });
        
        // Active nav item highlighting
        const sections = $('section[id]');
        $(window).on('scroll', function() {
            const scrollPos = $(window).scrollTop() + 100;
            
            sections.each(function() {
                const section = $(this);
                const sectionTop = section.offset().top;
                const sectionHeight = section.outerHeight();
                const sectionId = section.attr('id');
                
                if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                    $('.musaix-nav-item').removeClass('active');
                    $(`a[href="#${sectionId}"]`).addClass('active');
                }
            });
        });
    }

    /**
     * Scroll-triggered animations
     */
    function initAnimations() {
        const animatedElements = $('.musaix-animate-in');
        
        // Set initial state
        animatedElements.css({
            'opacity': '0',
            'transform': 'translateY(30px)',
            'transition': 'opacity 0.8s ease-out, transform 0.8s ease-out'
        });
        
        // Intersection Observer for animations
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        $(entry.target).css({
                            'opacity': '1',
                            'transform': 'translateY(0)'
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            animatedElements.each(function() {
                observer.observe(this);
            });
        } else {
            // Fallback for older browsers
            $(window).on('scroll', function() {
                const windowHeight = $(window).height();
                const scrollTop = $(window).scrollTop();
                
                animatedElements.each(function() {
                    const element = $(this);
                    const elementTop = element.offset().top;
                    
                    if (elementTop < scrollTop + windowHeight - 100) {
                        element.css({
                            'opacity': '1',
                            'transform': 'translateY(0)'
                        });
                    }
                });
            });
        }
    }

    /**
     * Music Player Demo
     */
    function initMusicPlayer() {
        $('.musaix-play-btn').on('click', function() {
            const button = $(this);
            const icon = button.find('i');
            const waveform = button.closest('.musaix-player').find('.musaix-waveform');
            
            if (icon.hasClass('fa-play')) {
                // Start playing
                icon.removeClass('fa-play').addClass('fa-pause');
                button.addClass('playing');
                
                // Animate waveform
                waveform.addClass('playing');
                
                // Demo progress animation
                setTimeout(function() {
                    if (button.hasClass('playing')) {
                        icon.removeClass('fa-pause').addClass('fa-play');
                        button.removeClass('playing');
                        waveform.removeClass('playing');
                    }
                }, 30000); // 30 second demo
                
            } else {
                // Stop playing
                icon.removeClass('fa-pause').addClass('fa-play');
                button.removeClass('playing');
                waveform.removeClass('playing');
            }
        });
    }

    /**
     * Contact Form Handling
     */
    function initContactForm() {
        $('.musaix-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = new FormData(this);
            formData.append('action', 'musaix_contact_form');
            formData.append('nonce', musaix_ajax.nonce);
            
            // Show loading state
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
            
            // AJAX request
            $.ajax({
                url: musaix_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        form[0].reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('Sorry, there was an error. Please try again.', 'error');
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * FAQ Accordion
     */
    function initFAQ() {
        $('.musaix-faq-item .musaix-card').on('click', function() {
            const card = $(this);
            const answer = card.find('.faq-answer');
            const icon = card.find('i');
            const isOpen = answer.hasClass('open');
            
            // Close all other FAQs
            $('.faq-answer').removeClass('open').css('max-height', '0');
            $('.musaix-faq-item i').css('transform', 'rotate(0deg)');
            
            if (!isOpen) {
                // Open this FAQ
                answer.addClass('open').css('max-height', answer[0].scrollHeight + 'px');
                icon.css('transform', 'rotate(180deg)');
            }
        });
    }

    /**
     * Show notification
     */
    function showNotification(message, type) {
        const notification = $(`
            <div class="musaix-notification musaix-notification-${type}">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
                <button class="musaix-notification-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(function() {
            notification.addClass('show');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            removeNotification(notification);
        }, 5000);
        
        // Close button handler
        notification.find('.musaix-notification-close').on('click', function() {
            removeNotification(notification);
        });
    }

    /**
     * Remove notification
     */
    function removeNotification(notification) {
        notification.removeClass('show');
        setTimeout(function() {
            notification.remove();
        }, 300);
    }

    /**
     * Easing function for smooth animations
     */
    $.easing.easeInOutCubic = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

    /**
     * Lazy loading for images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Mobile menu toggle
     */
    function initMobileMenu() {
        const mobileToggle = $('.musaix-mobile-toggle');
        const navMenu = $('.musaix-nav-menu');
        
        mobileToggle.on('click', function() {
            $(this).toggleClass('active');
            navMenu.toggleClass('active');
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.musaix-nav').length) {
                mobileToggle.removeClass('active');
                navMenu.removeClass('active');
            }
        });
    }

    // Initialize additional features
    initLazyLoading();
    initMobileMenu();

})(jQuery);