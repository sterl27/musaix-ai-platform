<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About - Musaix Pro</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Musaix Dark Theme Styles -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/musaix-dark-theme.css">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class('musaix-dark-theme'); ?>>

<!-- Navigation -->
<nav class="musaix-nav" id="main-nav">
    <div class="musaix-container">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 0;">
            <div class="musaix-logo">
                <h2 style="color: var(--musaix-accent); margin: 0; font-family: var(--musaix-font-heading);">
                    <i class="fas fa-music" style="margin-right: 0.5rem;"></i>
                    <a href="/" style="color: inherit; text-decoration: none;">Musaix Pro</a>
                </h2>
            </div>
            <div class="musaix-nav-menu" style="display: flex; gap: 2rem;">
                <a href="/" class="musaix-nav-item">Home</a>
                <a href="/about" class="musaix-nav-item active">About</a>
                <a href="/features" class="musaix-nav-item">Features</a>
                <a href="/pricing" class="musaix-nav-item">Pricing</a>
                <a href="/contact" class="musaix-nav-item">Contact</a>
            </div>
            <div class="musaix-nav-actions" style="display: flex; gap: 1rem;">
                <a href="#login" class="musaix-btn musaix-btn-secondary">Login</a>
                <a href="#signup" class="musaix-btn musaix-btn-primary">Get Started</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="musaix-hero" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="musaix-container">
        <div class="musaix-hero-content musaix-animate-in">
            <h1 style="margin-bottom: 1.5rem;">
                Revolutionizing Music
                <span style="display: block; background: var(--musaix-gradient-accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Through AI Innovation
                </span>
            </h1>
            <p style="font-size: 1.25rem; max-width: 700px; margin: 0 auto; color: var(--musaix-text-secondary);">
                We're passionate about empowering musicians, producers, and creators with cutting-edge 
                artificial intelligence technology that enhances human creativity rather than replacing it.
            </p>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="musaix-section">
    <div class="musaix-container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <div class="musaix-animate-in">
                <h2 style="margin-bottom: 2rem; font-size: 2.5rem;">Our Story</h2>
                <p style="margin-bottom: 1.5rem; font-size: 1.1rem;">
                    Founded in 2023 by a team of musicians, audio engineers, and AI researchers, 
                    Musaix Pro was born from a simple vision: to democratize music creation and 
                    make professional-quality production accessible to everyone.
                </p>
                <p style="margin-bottom: 1.5rem; font-size: 1.1rem;">
                    We believe that artificial intelligence should enhance human creativity, not replace it. 
                    Our tools are designed to inspire new ideas, accelerate workflows, and help artists 
                    break through creative blocks.
                </p>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <div class="musaix-stat">
                        <div style="font-size: 2.5rem; font-weight: 700; color: var(--musaix-primary); margin-bottom: 0.5rem;">100K+</div>
                        <p style="margin: 0; color: var(--musaix-text-muted);">Active Users</p>
                    </div>
                    <div class="musaix-stat">
                        <div style="font-size: 2.5rem; font-weight: 700; color: var(--musaix-accent); margin-bottom: 0.5rem;">1M+</div>
                        <p style="margin: 0; color: var(--musaix-text-muted);">Tracks Created</p>
                    </div>
                    <div class="musaix-stat">
                        <div style="font-size: 2.5rem; font-weight: 700; color: var(--musaix-secondary); margin-bottom: 0.5rem;">50+</div>
                        <p style="margin: 0; color: var(--musaix-text-muted);">Countries</p>
                    </div>
                </div>
            </div>
            <div class="musaix-card musaix-animate-in" style="background: var(--musaix-gradient-primary); min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <div class="musaix-text-center">
                    <i class="fas fa-music" style="font-size: 4rem; color: white; margin-bottom: 1rem; opacity: 0.8;"></i>
                    <p style="color: rgba(255,255,255,0.8); font-size: 1.1rem;">Music Creation Timeline</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="musaix-section musaix-section-dark">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem; font-size: 2.5rem;">Our Mission</h2>
            <p style="font-size: 1.2rem; max-width: 800px; margin: 0 auto;">
                To empower every person on Earth to express themselves through music, 
                regardless of their technical background or musical training.
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="musaix-card musaix-animate-in">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-heart" style="font-size: 2.5rem; color: var(--musaix-accent);"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Accessibility</h3>
                <p>Making music creation accessible to everyone, from complete beginners to professional producers.</p>
            </div>
            
            <div class="musaix-card musaix-animate-in">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-rocket" style="font-size: 2.5rem; color: var(--musaix-primary);"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Innovation</h3>
                <p>Pushing the boundaries of what's possible with AI and music technology while maintaining artistic integrity.</p>
            </div>
            
            <div class="musaix-card musaix-animate-in">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-users" style="font-size: 2.5rem; color: var(--musaix-secondary);"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Community</h3>
                <p>Building a global community of creators who support, inspire, and collaborate with each other.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="musaix-section">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem; font-size: 2.5rem;">Meet the Team</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                The passionate individuals behind Musaix Pro's innovative technology
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            <div class="musaix-card musaix-team-member musaix-animate-in">
                <div style="width: 120px; height: 120px; border-radius: 50%; background: var(--musaix-gradient-primary); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="font-size: 3rem; color: white;"></i>
                </div>
                <h3 style="margin-bottom: 0.5rem;">Alex Chen</h3>
                <p style="color: var(--musaix-accent); margin-bottom: 1rem; font-weight: 500;">CEO & Co-Founder</p>
                <p style="margin-bottom: 1.5rem;">Former music producer turned tech entrepreneur with 15 years of industry experience.</p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="#" style="color: var(--musaix-text-secondary);"><i class="fab fa-linkedin"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary);"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="musaix-card musaix-team-member musaix-animate-in">
                <div style="width: 120px; height: 120px; border-radius: 50%; background: var(--musaix-gradient-accent); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="font-size: 3rem; color: white;"></i>
                </div>
                <h3 style="margin-bottom: 0.5rem;">Sarah Rodriguez</h3>
                <p style="color: var(--musaix-accent); margin-bottom: 1rem; font-weight: 500;">CTO & Co-Founder</p>
                <p style="margin-bottom: 1.5rem;">AI researcher specializing in neural networks and machine learning for audio processing.</p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="#" style="color: var(--musaix-text-secondary);"><i class="fab fa-linkedin"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary);"><i class="fab fa-github"></i></a>
                </div>
            </div>
            
            <div class="musaix-card musaix-team-member musaix-animate-in">
                <div style="width: 120px; height: 120px; border-radius: 50%; background: var(--musaix-gradient-secondary); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user" style="font-size: 3rem; color: white;"></i>
                </div>
                <h3 style="margin-bottom: 0.5rem;">Marcus Johnson</h3>
                <p style="color: var(--musaix-accent); margin-bottom: 1rem; font-weight: 500;">Head of Product</p>
                <p style="margin-bottom: 1.5rem;">Grammy-nominated audio engineer with expertise in digital signal processing and music production.</p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="#" style="color: var(--musaix-text-secondary);"><i class="fab fa-linkedin"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary);"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="musaix-section musaix-section-gradient">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem; font-size: 2.5rem; color: white;">Our Values</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto; color: rgba(255,255,255,0.9);">
                The principles that guide everything we do
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="musaix-animate-in" style="text-align: center;">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-lightbulb" style="font-size: 2.5rem; color: var(--musaix-accent);"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: white;">Creativity First</h3>
                <p style="color: rgba(255,255,255,0.8);">We believe technology should enhance human creativity, not constrain it.</p>
            </div>
            
            <div class="musaix-animate-in" style="text-align: center;">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: var(--musaix-accent);"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: white;">Ethical AI</h3>
                <p style="color: rgba(255,255,255,0.8);">We're committed to developing AI that respects artists' rights and intellectual property.</p>
            </div>
            
            <div class="musaix-animate-in" style="text-align: center;">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-globe" style="font-size: 2.5rem; color: var(--musaix-accent);"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: white;">Global Impact</h3>
                <p style="color: rgba(255,255,255,0.8);">Making music creation accessible to everyone, regardless of location or background.</p>
            </div>
            
            <div class="musaix-animate-in" style="text-align: center;">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-handshake" style="font-size: 2.5rem; color: var(--musaix-accent);"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: white;">Collaboration</h3>
                <p style="color: rgba(255,255,255,0.8);">Building tools that bring musicians together and foster creative collaboration.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="musaix-section">
    <div class="musaix-container musaix-text-center">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Join Our Mission</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Be part of the future of music creation. Start your journey with Musaix Pro today.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="#get-started" class="musaix-btn musaix-btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                <i class="fas fa-rocket" style="margin-right: 0.5rem;"></i>
                Get Started
            </a>
            <a href="/contact" class="musaix-btn musaix-btn-secondary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>
                Contact Us
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer style="background: var(--musaix-bg-primary); border-top: 1px solid var(--musaix-border); padding: 3rem 0 1rem;">
    <div class="musaix-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            <div>
                <h3 style="color: var(--musaix-accent); margin-bottom: 1rem;">
                    <i class="fas fa-music" style="margin-right: 0.5rem;"></i>
                    Musaix Pro
                </h3>
                <p style="margin-bottom: 1rem;">
                    The future of music creation powered by artificial intelligence.
                </p>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.2rem;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.2rem;"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">Product</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Features</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Pricing</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">API</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Integrations</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">Support</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Help Center</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Contact Us</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Community</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Status</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">Company</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;"><a href="/about" style="color: var(--musaix-text-secondary);">About</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Blog</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Careers</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">Press</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top: 1px solid var(--musaix-border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p style="margin: 0; color: var(--musaix-text-muted); font-size: 0.9rem;">
                © 2025 Musaix Pro. All rights reserved.
            </p>
            <div style="display: flex; gap: 2rem;">
                <a href="#" style="color: var(--musaix-text-muted); font-size: 0.9rem;">Privacy Policy</a>
                <a href="#" style="color: var(--musaix-text-muted); font-size: 0.9rem;">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script>
// Smooth scrolling for navigation links
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

// Add scroll effects to navigation
window.addEventListener('scroll', function() {
    const nav = document.getElementById('main-nav');
    if (window.scrollY > 100) {
        nav.style.background = 'rgba(15, 15, 35, 0.98)';
    } else {
        nav.style.background = 'rgba(15, 15, 35, 0.95)';
    }
});

// Animate elements on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.musaix-animate-in').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
    observer.observe(el);
});
</script>

<?php wp_footer(); ?>
</body>
</html>