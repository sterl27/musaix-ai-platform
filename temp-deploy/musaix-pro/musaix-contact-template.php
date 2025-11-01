<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact - Musaix Pro</title>
    
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
                <a href="/about" class="musaix-nav-item">About</a>
                <a href="/features" class="musaix-nav-item">Features</a>
                <a href="/pricing" class="musaix-nav-item">Pricing</a>
                <a href="/contact" class="musaix-nav-item active">Contact</a>
            </div>
            <div class="musaix-nav-actions" style="display: flex; gap: 1rem;">
                <a href="#login" class="musaix-btn musaix-btn-secondary">Login</a>
                <a href="#signup" class="musaix-btn musaix-btn-primary">Get Started</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="musaix-hero" style="min-height: 50vh; display: flex; align-items: center;">
    <div class="musaix-container">
        <div class="musaix-hero-content musaix-animate-in">
            <h1 style="margin-bottom: 1.5rem;">
                Get in Touch
                <span style="display: block; background: var(--musaix-gradient-accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    We're Here to Help
                </span>
            </h1>
            <p style="font-size: 1.25rem; max-width: 600px; margin: 0 auto; color: var(--musaix-text-secondary);">
                Have questions about Musaix Pro? Want to learn more about our AI music tools? 
                We'd love to hear from you.
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="musaix-section">
    <div class="musaix-container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
            <!-- Contact Form -->
            <div class="musaix-animate-in">
                <h2 style="margin-bottom: 2rem;">Send us a Message</h2>
                <form class="musaix-form" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="musaix-form-group">
                            <label for="firstName" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">First Name</label>
                            <input type="text" id="firstName" name="firstName" class="musaix-input" placeholder="Your first name" required>
                        </div>
                        <div class="musaix-form-group">
                            <label for="lastName" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Last Name</label>
                            <input type="text" id="lastName" name="lastName" class="musaix-input" placeholder="Your last name" required>
                        </div>
                    </div>
                    
                    <div class="musaix-form-group">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                        <input type="email" id="email" name="email" class="musaix-input" placeholder="your@email.com" required>
                    </div>
                    
                    <div class="musaix-form-group">
                        <label for="subject" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Subject</label>
                        <select id="subject" name="subject" class="musaix-input" required>
                            <option value="">Select a topic</option>
                            <option value="general">General Inquiry</option>
                            <option value="support">Technical Support</option>
                            <option value="billing">Billing Question</option>
                            <option value="partnership">Partnership Opportunity</option>
                            <option value="feedback">Feedback & Suggestions</option>
                            <option value="press">Press & Media</option>
                        </select>
                    </div>
                    
                    <div class="musaix-form-group">
                        <label for="message" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Message</label>
                        <textarea id="message" name="message" class="musaix-input" rows="6" placeholder="Tell us how we can help you..." required></textarea>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
                        <input type="checkbox" id="newsletter" name="newsletter" style="accent-color: var(--musaix-primary);">
                        <label for="newsletter" style="font-size: 0.9rem; color: var(--musaix-text-secondary);">
                            I'd like to receive updates about new features and music industry insights
                        </label>
                    </div>
                    
                    <button type="submit" class="musaix-btn musaix-btn-primary" style="margin-top: 1rem;">
                        <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i>
                        Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div class="musaix-animate-in">
                <h2 style="margin-bottom: 2rem;">Contact Information</h2>
                
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <div class="musaix-card">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: var(--musaix-gradient-primary); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-envelope" style="color: white; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; margin-bottom: 0.25rem;">Email</h4>
                                <p style="margin: 0; color: var(--musaix-text-secondary);">hello@musaixpro.com</p>
                            </div>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--musaix-text-muted);">
                            We typically respond within 24 hours
                        </p>
                    </div>
                    
                    <div class="musaix-card">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: var(--musaix-gradient-accent); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-comments" style="color: white; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; margin-bottom: 0.25rem;">Live Chat</h4>
                                <p style="margin: 0; color: var(--musaix-text-secondary);">Available 24/7</p>
                            </div>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--musaix-text-muted);">
                            Click the chat bubble in the bottom right corner
                        </p>
                    </div>
                    
                    <div class="musaix-card">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: var(--musaix-gradient-secondary); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; margin-bottom: 0.25rem;">Headquarters</h4>
                                <p style="margin: 0; color: var(--musaix-text-secondary);">San Francisco, CA</p>
                            </div>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--musaix-text-muted);">
                            123 Music Street, Suite 100<br>
                            San Francisco, CA 94103
                        </p>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div style="margin-top: 3rem;">
                    <h3 style="margin-bottom: 1.5rem;">Follow Us</h3>
                    <div style="display: flex; gap: 1rem;">
                        <a href="#" class="musaix-btn musaix-btn-secondary" style="width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="fab fa-twitter" style="font-size: 1.2rem;"></i>
                        </a>
                        <a href="#" class="musaix-btn musaix-btn-secondary" style="width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="fab fa-linkedin" style="font-size: 1.2rem;"></i>
                        </a>
                        <a href="#" class="musaix-btn musaix-btn-secondary" style="width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="fab fa-youtube" style="font-size: 1.2rem;"></i>
                        </a>
                        <a href="#" class="musaix-btn musaix-btn-secondary" style="width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="fab fa-discord" style="font-size: 1.2rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="musaix-section musaix-section-dark">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem;">Frequently Asked Questions</h2>
            <p style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Quick answers to common questions about Musaix Pro
            </p>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="musaix-faq-item musaix-animate-in" style="margin-bottom: 1.5rem;">
                <div class="musaix-card" style="cursor: pointer;" onclick="toggleFaq(this)">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0;">How does AI music generation work?</h4>
                        <i class="fas fa-chevron-down" style="color: var(--musaix-primary); transition: transform 0.3s ease;"></i>
                    </div>
                    <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                        <p style="margin-top: 1rem; margin-bottom: 0; color: var(--musaix-text-secondary);">
                            Our AI models are trained on vast datasets of music across multiple genres. They learn patterns, 
                            harmonies, and structures to generate original compositions based on your input parameters like 
                            mood, tempo, key, and style.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="musaix-faq-item musaix-animate-in" style="margin-bottom: 1.5rem;">
                <div class="musaix-card" style="cursor: pointer;" onclick="toggleFaq(this)">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0;">Can I use generated music commercially?</h4>
                        <i class="fas fa-chevron-down" style="color: var(--musaix-primary); transition: transform 0.3s ease;"></i>
                    </div>
                    <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                        <p style="margin-top: 1rem; margin-bottom: 0; color: var(--musaix-text-secondary);">
                            Yes! Pro plan subscribers receive full commercial licensing rights for all music generated 
                            on our platform. Free plan users can use generated music for personal projects only.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="musaix-faq-item musaix-animate-in" style="margin-bottom: 1.5rem;">
                <div class="musaix-card" style="cursor: pointer;" onclick="toggleFaq(this)">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0;">What file formats do you support?</h4>
                        <i class="fas fa-chevron-down" style="color: var(--musaix-primary); transition: transform 0.3s ease;"></i>
                    </div>
                    <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                        <p style="margin-top: 1rem; margin-bottom: 0; color: var(--musaix-text-secondary);">
                            We support all major audio formats including WAV, MP3, FLAC, and AIFF. You can also export 
                            MIDI files for further editing in your preferred DAW.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="musaix-faq-item musaix-animate-in" style="margin-bottom: 1.5rem;">
                <div class="musaix-card" style="cursor: pointer;" onclick="toggleFaq(this)">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0;">Is there a free trial available?</h4>
                        <i class="fas fa-chevron-down" style="color: var(--musaix-primary); transition: transform 0.3s ease;"></i>
                    </div>
                    <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                        <p style="margin-top: 1rem; margin-bottom: 0; color: var(--musaix-text-secondary);">
                            Yes! We offer a 14-day free trial of our Pro plan, and our Free plan is always available 
                            with no time limits. You can upgrade or downgrade anytime.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Support Section -->
<section class="musaix-section">
    <div class="musaix-container musaix-text-center">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Need Immediate Help?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Check out our comprehensive help center or join our community for quick answers
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="#help-center" class="musaix-btn musaix-btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                <i class="fas fa-question-circle" style="margin-right: 0.5rem;"></i>
                Help Center
            </a>
            <a href="#community" class="musaix-btn musaix-btn-secondary" style="font-size: 1.1rem; padding: 1rem 2rem;">
                <i class="fas fa-users" style="margin-right: 0.5rem;"></i>
                Join Community
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
                    <li style="margin-bottom: 0.5rem;"><a href="/contact" style="color: var(--musaix-text-secondary);">Contact Us</a></li>
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

// FAQ Toggle Function
function toggleFaq(element) {
    const answer = element.querySelector('.faq-answer');
    const icon = element.querySelector('i');
    
    if (answer.style.maxHeight && answer.style.maxHeight !== '0px') {
        answer.style.maxHeight = '0px';
        icon.style.transform = 'rotate(0deg)';
    } else {
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}

// Contact Form Submission
document.querySelector('.musaix-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Show success message (in a real app, you'd send this to your backend)
    alert('Thank you for your message! We\'ll get back to you within 24 hours.');
    
    // Reset form
    this.reset();
});
</script>

<?php wp_footer(); ?>
</body>
</html>