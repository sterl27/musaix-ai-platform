<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Musaix Pro - AI-Powered Music Creation Platform</title>
    
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
                    Musaix Pro
                </h2>
            </div>
            <div class="musaix-nav-menu" style="display: flex; gap: 2rem;">
                <a href="#home" class="musaix-nav-item active">Home</a>
                <a href="#features" class="musaix-nav-item">Features</a>
                <a href="#ai-tools" class="musaix-nav-item">AI Tools</a>
                <a href="#pricing" class="musaix-nav-item">Pricing</a>
                <a href="#contact" class="musaix-nav-item">Contact</a>
            </div>
            <div class="musaix-nav-actions" style="display: flex; gap: 1rem;">
                <a href="#login" class="musaix-btn musaix-btn-secondary">Login</a>
                <a href="#signup" class="musaix-btn musaix-btn-primary">Get Started</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="musaix-hero" id="home">
    <div class="musaix-container">
        <div class="musaix-hero-content musaix-animate-in">
            <h1 style="margin-bottom: 1.5rem;">
                Create Music with AI
                <span style="display: block; background: var(--musaix-gradient-accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Like Never Before
                </span>
            </h1>
            <p style="font-size: 1.25rem; max-width: 600px; margin: 0 auto 2rem; color: var(--musaix-text-secondary);">
                Transform your musical ideas into reality with our cutting-edge AI technology. 
                Generate, compose, and produce professional-quality music in minutes.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 3rem;">
                <a href="#demo" class="musaix-btn musaix-btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                    <i class="fas fa-play" style="margin-right: 0.5rem;"></i>
                    Try Demo
                </a>
                <a href="#learn-more" class="musaix-btn musaix-btn-secondary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                    Learn More
                </a>
            </div>
            
            <!-- Music Player Demo -->
            <div class="musaix-player" style="max-width: 800px; margin: 0 auto;">
                <div style="text-align: left; margin-bottom: 1rem;">
                    <h4 style="margin: 0; color: var(--musaix-text-primary);">Now Playing: AI Generated Track</h4>
                    <p style="margin: 0.5rem 0; color: var(--musaix-text-muted); font-size: 0.9rem;">Electronic • Upbeat • 128 BPM</p>
                </div>
                <div class="musaix-waveform">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: var(--musaix-text-muted);">
                        <i class="fas fa-music" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
                <div class="musaix-controls">
                    <button class="musaix-btn musaix-btn-secondary" style="width: 3rem; height: 3rem; border-radius: 50%; padding: 0;">
                        <i class="fas fa-step-backward"></i>
                    </button>
                    <button class="musaix-play-btn">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="musaix-btn musaix-btn-secondary" style="width: 3rem; height: 3rem; border-radius: 50%; padding: 0;">
                        <i class="fas fa-step-forward"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="musaix-section" id="features">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem;">Powerful AI Music Tools</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Everything you need to create, edit, and produce professional music with artificial intelligence
            </p>
        </div>
        
        <div class="musaix-features">
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">AI Composition</h3>
                <p>Generate original melodies, harmonies, and rhythms using advanced machine learning algorithms.</p>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Smart Mixing</h3>
                <p>Automatically balance and enhance your tracks with AI-powered mixing and mastering tools.</p>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-microphone"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Voice Synthesis</h3>
                <p>Create realistic vocal performances in any style or language with our neural voice engine.</p>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-waveform-lines"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Audio Enhancement</h3>
                <p>Improve audio quality, remove noise, and restore old recordings with AI processing.</p>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Style Transfer</h3>
                <p>Transform your music into any genre or style while preserving the original melody.</p>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-share-nodes"></i>
                </div>
                <h3 style="margin-bottom: 1rem;">Collaboration</h3>
                <p>Work together in real-time with other musicians and producers from around the world.</p>
            </div>
        </div>
    </div>
</section>

<!-- AI Showcase Section -->
<section class="musaix-section musaix-section-dark" id="ai-tools">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem;">See AI in Action</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Experience the future of music creation with our interactive AI demonstrations
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
            <div>
                <h3 style="margin-bottom: 1.5rem; font-size: 2rem;">Real-time Composition</h3>
                <p style="margin-bottom: 2rem; font-size: 1.1rem;">
                    Watch as our AI creates music in real-time based on your input parameters. 
                    Adjust mood, tempo, key, and style to see instant results.
                </p>
                <div style="margin-bottom: 2rem;">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <span class="musaix-btn musaix-btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">Electronic</span>
                        <span class="musaix-btn musaix-btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">Jazz</span>
                        <span class="musaix-btn musaix-btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">Rock</span>
                        <span class="musaix-btn musaix-btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">Classical</span>
                        <span class="musaix-btn musaix-btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">Hip-Hop</span>
                    </div>
                </div>
                <a href="#try-now" class="musaix-btn musaix-btn-accent">
                    <i class="fas fa-rocket" style="margin-right: 0.5rem;"></i>
                    Try Now
                </a>
            </div>
            <div class="musaix-card" style="background: var(--musaix-bg-primary); min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <div class="musaix-text-center">
                    <i class="fas fa-robot" style="font-size: 4rem; color: var(--musaix-primary); margin-bottom: 1rem;"></i>
                    <p style="color: var(--musaix-text-muted);">Interactive AI Demo</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="musaix-section" id="pricing">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem;">Choose Your Plan</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Start creating with our free plan or unlock unlimited possibilities with Pro
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 900px; margin: 0 auto;">
            <!-- Free Plan -->
            <div class="musaix-card" style="text-align: center;">
                <div class="musaix-card-header">
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Free</h3>
                    <div style="font-size: 3rem; font-weight: 700; color: var(--musaix-primary);">$0</div>
                    <p style="color: var(--musaix-text-muted); margin: 0;">per month</p>
                </div>
                <ul style="list-style: none; padding: 0; margin: 2rem 0; text-align: left;">
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        5 AI compositions per month
                    </li>
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        Basic audio quality
                    </li>
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        Community support
                    </li>
                </ul>
                <a href="#signup-free" class="musaix-btn musaix-btn-secondary" style="width: 100%;">Get Started</a>
            </div>
            
            <!-- Pro Plan -->
            <div class="musaix-card" style="text-align: center; border: 2px solid var(--musaix-primary); position: relative;">
                <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--musaix-gradient-primary); padding: 0.5rem 1.5rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; color: white;">
                    POPULAR
                </div>
                <div class="musaix-card-header">
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Pro</h3>
                    <div style="font-size: 3rem; font-weight: 700; color: var(--musaix-primary);">$29</div>
                    <p style="color: var(--musaix-text-muted); margin: 0;">per month</p>
                </div>
                <ul style="list-style: none; padding: 0; margin: 2rem 0; text-align: left;">
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        Unlimited AI compositions
                    </li>
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        High-quality audio (320kbps)
                    </li>
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        Advanced AI tools
                    </li>
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        Priority support
                    </li>
                    <li style="padding: 0.5rem 0; display: flex; align-items: center;">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.5rem;"></i>
                        Commercial licensing
                    </li>
                </ul>
                <a href="#signup-pro" class="musaix-btn musaix-btn-primary" style="width: 100%;">Start Pro Trial</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="musaix-section musaix-section-gradient">
    <div class="musaix-container musaix-text-center">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Ready to Create Amazing Music?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Join thousands of musicians and producers who are already using AI to enhance their creativity
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="#get-started" class="musaix-btn musaix-btn-accent" style="font-size: 1.1rem; padding: 1rem 2rem;">
                <i class="fas fa-rocket" style="margin-right: 0.5rem;"></i>
                Get Started Now
            </a>
            <a href="#demo" class="musaix-btn musaix-btn-secondary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                <i class="fas fa-play" style="margin-right: 0.5rem;"></i>
                Watch Demo
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
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--musaix-text-secondary);">About</a></li>
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

// Music player demo functionality
document.querySelector('.musaix-play-btn').addEventListener('click', function() {
    const icon = this.querySelector('i');
    if (icon.classList.contains('fa-play')) {
        icon.classList.remove('fa-play');
        icon.classList.add('fa-pause');
        // Add playing animation here
    } else {
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-play');
        // Stop playing animation here
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>