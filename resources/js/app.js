// YuraiCars Premium Experience
require('./bootstrap');

const Alpine = require('alpinejs').default;

// Make Alpine available globally
window.Alpine = Alpine;

// Premium Interactions and Effects
document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Enhanced car image loading with fade-in effect
    const carImage = document.querySelector('.car-image');
    if (carImage) {
        carImage.addEventListener('load', function() {
            this.style.opacity = '1';
            this.style.transform = 'translateY(0)';
        });
    }

    // Parallax effect for smoke backgrounds
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const smokeElements = document.querySelectorAll('.smoke-bg');
        smokeElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Add premium hover effects to glass cards
    const glassCards = document.querySelectorAll('.glass-card');
    glassCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0, 255, 135, 0.2)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = 'none';
        });
    });

    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.animate-fade-in, .animate-fade-in-delay, .animate-fade-in-delay-2').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.8s ease-out';
        observer.observe(el);
    });

    // Premium loading states for buttons
    document.querySelectorAll('.btn-premium, .btn-secondary').forEach(button => {
        button.addEventListener('click', function(e) {
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="loading-spinner inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span> Loading...';
            this.disabled = true;

            // Simulate loading (remove this in production)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 2000);
        });
    });

    // Performance optimization: Preload critical images
    const criticalImages = [
        '/images/Car3d.png'
    ];

    criticalImages.forEach(src => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = src;
        document.head.appendChild(link);
    });

    // Dark mode toggle functionality (if needed)
    window.toggleDarkMode = function() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
    };

    // Initialize dark mode from localStorage
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    }

    // Add premium cursor effects
    document.addEventListener('mousemove', function(e) {
        const cursor = document.querySelector('.premium-cursor');
        if (cursor) {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        }
    });

    // Add typing effect for gradient text (optional)
    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.innerHTML = '';
        
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }

    // Initialize typing effect for main heading (optional)
    const mainHeading = document.querySelector('.gradient-text');
    if (mainHeading && mainHeading.dataset.typewriter) {
        const originalText = mainHeading.textContent;
        typeWriter(mainHeading, originalText, 80);
    }

    console.log('🚗 YuraiCars Premium Experience Loaded');
});

// Start Alpine.js
Alpine.start();