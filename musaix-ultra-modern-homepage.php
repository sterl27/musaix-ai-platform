<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Musaix Pro - AI-Powered Music Creation Platform</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Ultra Modern Theme Styles -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/musaix-ultra-modern-theme.css">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class('musaix-dark-theme'); ?>>

<!-- Navigation -->
<nav class="musaix-nav" id="main-nav">
    <div class="musaix-container">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.5rem 0;">
            <div class="musaix-logo">
                <h2 style="color: var(--musaix-accent); margin: 0; font-family: var(--musaix-font-heading); font-size: 1.5rem;">
                    <i class="fas fa-music" style="margin-right: 0.5rem; color: var(--musaix-primary);"></i>
                    Musaix Pro
                </h2>
            </div>
            <div class="musaix-nav-menu" style="display: flex; gap: 2rem;">
                <a href="#home" class="musaix-nav-item active">Home</a>
                <a href="#demo" class="musaix-nav-item">AI Demo</a>
                <a href="#features" class="musaix-nav-item">Features</a>
                <a href="#pricing" class="musaix-nav-item">Pricing</a>
                <a href="#contact" class="musaix-nav-item">Contact</a>
            </div>
            <div class="musaix-nav-actions" style="display: flex; gap: 1rem;">
                <a href="#login" class="musaix-btn musaix-btn-secondary">Login</a>
                <a href="#signup" class="musaix-btn musaix-btn-primary">Get Started Free</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section - Dramatic Impact -->
<section class="musaix-hero" id="home">
    <div class="musaix-container">
        <div class="musaix-hero-content musaix-animate-in">
            <h1 style="margin-bottom: 2rem; line-height: 1.1;">
                Create Music with AI
                <span style="display: block; margin-top: 1rem;">Like Never Before</span>
            </h1>
            <p style="font-size: 1.5rem; max-width: 700px; margin: 0 auto 3rem; color: var(--musaix-text-secondary); line-height: 1.6;">
                Transform your musical ideas into reality with our cutting-edge AI technology. 
                Generate, compose, and produce professional-quality music in minutes.
            </p>
            
            <!-- Trust Signals -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 3rem; margin-bottom: 3rem; font-size: 0.9rem; color: var(--musaix-text-muted);">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-users" style="color: var(--musaix-primary);"></i>
                    <span>100K+ Creators</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-music" style="color: var(--musaix-accent);"></i>
                    <span>1M+ Tracks Generated</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-star" style="color: var(--musaix-secondary);"></i>
                    <span>4.9/5 Rating</span>
                </div>
            </div>
            
            <div style="display: flex; gap: 1.5rem; justify-content: center; margin-bottom: 4rem;">
                <a href="#demo" class="musaix-btn musaix-btn-primary" style="font-size: 1.2rem; padding: 1.2rem 2.5rem;">
                    <i class="fas fa-play" style="margin-right: 0.5rem;"></i>
                    Try AI Demo
                </a>
                <a href="#features" class="musaix-btn musaix-btn-secondary" style="font-size: 1.2rem; padding: 1.2rem 2.5rem;">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                    Learn More
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Interactive AI Demo Section - The Star of the Show -->
<section class="musaix-section" id="demo" style="background: var(--musaix-bg-secondary); position: relative;">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem; font-size: 3.5rem;">Experience AI in Action</h2>
            <p style="font-size: 1.3rem; max-width: 800px; margin: 0 auto; color: var(--musaix-text-secondary);">
                Don't just read about it - create music with AI right now. Type a prompt and watch our AI compose in real-time.
            </p>
        </div>
        
        <!-- Interactive Demo Interface -->
        <div class="musaix-card" style="max-width: 900px; margin: 0 auto; padding: 3rem; background: var(--musaix-bg-glass); border: 2px solid var(--musaix-border-glow);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; color: var(--musaix-primary);">
                    <i class="fas fa-robot" style="margin-right: 0.5rem;"></i>
                    AI Music Generator
                </h3>
                <p style="color: var(--musaix-text-muted);">Describe the music you want and watch AI create it</p>
            </div>
            
            <!-- Demo Input -->
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <input type="text" 
                           id="ai-prompt" 
                           class="musaix-input" 
                           placeholder="e.g., 'upbeat electronic dance music with heavy bass'"
                           style="flex: 1; font-size: 1.1rem; padding: 1rem;"
                           value="upbeat electronic dance music">
                    <button id="generate-btn" class="musaix-btn musaix-btn-accent" style="padding: 1rem 2rem; font-size: 1.1rem;">
                        <i class="fas fa-magic" style="margin-right: 0.5rem;"></i>
                        Generate
                    </button>
                </div>
                
                <!-- Quick Prompts -->
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center;">
                    <button class="quick-prompt musaix-btn musaix-btn-secondary" data-prompt="chill lofi hip hop beats" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Lofi Hip Hop</button>
                    <button class="quick-prompt musaix-btn musaix-btn-secondary" data-prompt="epic orchestral cinematic" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Epic Orchestral</button>
                    <button class="quick-prompt musaix-btn musaix-btn-secondary" data-prompt="jazz piano with saxophone" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Jazz Combo</button>
                    <button class="quick-prompt musaix-btn musaix-btn-secondary" data-prompt="ambient electronic soundscape" style="font-size: 0.9rem; padding: 0.5rem 1rem;">Ambient</button>
                </div>
            </div>
            
            <!-- Real-time Generation Visualization -->
            <div id="generation-area" style="min-height: 300px; background: var(--musaix-bg-primary); border-radius: var(--musaix-radius-lg); padding: 2rem; position: relative; overflow: hidden;">
                <div id="idle-state" style="text-align: center; padding: 4rem 0;">
                    <i class="fas fa-waveform-lines" style="font-size: 4rem; color: var(--musaix-primary); opacity: 0.3; margin-bottom: 1rem;"></i>
                    <p style="color: var(--musaix-text-muted); font-size: 1.1rem;">Enter a prompt above to start generating music</p>
                </div>
                
                <div id="generating-state" style="display: none; text-align: center; padding: 2rem 0;">
                    <div style="margin-bottom: 2rem;">
                        <div class="ai-thinking" style="display: inline-block; width: 60px; height: 60px; border: 3px solid var(--musaix-primary); border-top: 3px solid transparent; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    </div>
                    <h4 style="margin-bottom: 1rem; color: var(--musaix-primary);">AI is composing your track...</h4>
                    <div id="generation-steps" style="text-align: left; max-width: 400px; margin: 0 auto;">
                        <div class="step" style="margin-bottom: 0.5rem; color: var(--musaix-text-muted); opacity: 0.5;">
                            <i class="fas fa-circle-notch"></i> Analyzing prompt...
                        </div>
                        <div class="step" style="margin-bottom: 0.5rem; color: var(--musaix-text-muted); opacity: 0.5;">
                            <i class="fas fa-circle-notch"></i> Generating melody...
                        </div>
                        <div class="step" style="margin-bottom: 0.5rem; color: var(--musaix-text-muted); opacity: 0.5;">
                            <i class="fas fa-circle-notch"></i> Adding harmonies...
                        </div>
                        <div class="step" style="margin-bottom: 0.5rem; color: var(--musaix-text-muted); opacity: 0.5;">
                            <i class="fas fa-circle-notch"></i> Mixing & mastering...
                        </div>
                    </div>
                </div>
                
                <div id="completed-state" style="display: none;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--musaix-accent); margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--musaix-accent); margin-bottom: 0.5rem;">Track Generated Successfully!</h4>
                        <p id="track-info" style="color: var(--musaix-text-muted);">Upbeat Electronic • 128 BPM • Key of C</p>
                    </div>
                    
                    <!-- Music Player Interface -->
                    <div class="musaix-player">
                        <div class="musaix-waveform" id="demo-waveform">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <i class="fas fa-music" style="font-size: 2rem; color: var(--musaix-primary); opacity: 0.5;"></i>
                                <p style="margin: 0.5rem 0 0; font-size: 0.9rem; color: var(--musaix-text-muted);">Click play to hear your AI-generated track</p>
                            </div>
                        </div>
                        <div class="musaix-controls">
                            <button class="musaix-btn musaix-btn-secondary" style="width: 3rem; height: 3rem; border-radius: 50%; padding: 0;">
                                <i class="fas fa-step-backward"></i>
                            </button>
                            <button class="musaix-play-btn" id="demo-play-btn">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="musaix-btn musaix-btn-secondary" style="width: 3rem; height: 3rem; border-radius: 50%; padding: 0;">
                                <i class="fas fa-step-forward"></i>
                            </button>
                        </div>
                        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem;">
                            <button class="musaix-btn musaix-btn-primary">
                                <i class="fas fa-download" style="margin-right: 0.5rem;"></i>
                                Download WAV
                            </button>
                            <button class="musaix-btn musaix-btn-secondary">
                                <i class="fas fa-share" style="margin-right: 0.5rem;"></i>
                                Share Track
                            </button>
                            <button id="try-again-btn" class="musaix-btn musaix-btn-accent">
                                <i class="fas fa-redo" style="margin-right: 0.5rem;"></i>
                                Generate Another
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="musaix-section" id="features">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 4rem;">
            <h2 style="margin-bottom: 1rem; font-size: 3rem;">Powerful AI Music Tools</h2>
            <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto; color: var(--musaix-text-secondary);">
                Everything you need to create, edit, and produce professional music with artificial intelligence
            </p>
        </div>
        
        <div class="musaix-features">
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: var(--musaix-primary);">AI Composition</h3>
                <p style="margin-bottom: 1.5rem;">Generate original melodies, harmonies, and rhythms using advanced neural networks trained on millions of tracks.</p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    <span style="background: var(--musaix-primary-light); color: var(--musaix-primary); padding: 0.25rem 0.75rem; border-radius: var(--musaix-radius-full); font-size: 0.8rem;">Melody Generation</span>
                    <span style="background: var(--musaix-primary-light); color: var(--musaix-primary); padding: 0.25rem 0.75rem; border-radius: var(--musaix-radius-full); font-size: 0.8rem;">Chord Progressions</span>
                </div>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: var(--musaix-accent);">Smart Mixing</h3>
                <p style="margin-bottom: 1.5rem;">Automatically balance and enhance your tracks with AI-powered mixing and mastering that learns from Grammy-winning engineers.</p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    <span style="background: var(--musaix-accent-light); color: var(--musaix-accent); padding: 0.25rem 0.75rem; border-radius: var(--musaix-radius-full); font-size: 0.8rem;">Auto EQ</span>
                    <span style="background: var(--musaix-accent-light); color: var(--musaix-accent); padding: 0.25rem 0.75rem; border-radius: var(--musaix-radius-full); font-size: 0.8rem;">Mastering</span>
                </div>
            </div>
            
            <div class="musaix-card musaix-feature musaix-animate-in">
                <div class="musaix-feature-icon">
                    <i class="fas fa-microphone"></i>
                </div>
                <h3 style="margin-bottom: 1rem; color: var(--musaix-secondary);">Voice Synthesis</h3>
                <p style="margin-bottom: 1.5rem;">Create realistic vocal performances in any style or language with our advanced neural voice engine.</p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    <span style="background: var(--musaix-secondary-light); color: var(--musaix-secondary); padding: 0.25rem 0.75rem; border-radius: var(--musaix-radius-full); font-size: 0.8rem;">50+ Languages</span>
                    <span style="background: var(--musaix-secondary-light); color: var(--musaix-secondary); padding: 0.25rem 0.75rem; border-radius: var(--musaix-radius-full); font-size: 0.8rem;">Custom Voices</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modern Pricing Section - Conversion Optimized -->
<section class="musaix-section" id="pricing" style="background: var(--musaix-bg-secondary);">
    <div class="musaix-container">
        <div class="musaix-text-center" style="margin-bottom: 3rem;">
            <h2 style="margin-bottom: 1rem; font-size: 3rem;">Choose Your Plan</h2>
            <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 2rem; color: var(--musaix-text-secondary);">
                Trusted by 100,000+ producers worldwide
            </p>
            
            <!-- Monthly/Annual Toggle -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 2rem;">
                <label style="color: var(--musaix-text-secondary);">Monthly</label>
                <div class="pricing-toggle" style="position: relative; width: 60px; height: 30px; background: var(--musaix-bg-glass); border-radius: var(--musaix-radius-full); cursor: pointer; border: 1px solid var(--musaix-border-glass);">
                    <div class="toggle-slider" style="position: absolute; top: 2px; left: 2px; width: 26px; height: 26px; background: var(--musaix-primary); border-radius: 50%; transition: var(--musaix-transition-base);"></div>
                </div>
                <label style="color: var(--musaix-text-secondary);">Annual <span style="color: var(--musaix-accent); font-weight: 600;">(Save 20%)</span></label>
            </div>
        </div>
        
        <div class="musaix-pricing">
            <!-- Free Plan -->
            <div class="musaix-pricing-card musaix-animate-in">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--musaix-text-primary);">Starter</h3>
                    <div style="font-size: 3rem; font-weight: 800; color: var(--musaix-primary); margin-bottom: 0.5rem;">
                        $0
                        <span style="font-size: 1rem; color: var(--musaix-text-muted); font-weight: 400;">/month</span>
                    </div>
                    <p style="color: var(--musaix-text-muted); margin: 0;">Perfect for trying out AI music</p>
                </div>
                
                <ul style="list-style: none; padding: 0; margin: 2rem 0; text-align: left;">
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        5 AI compositions per month
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        MP3 downloads (128kbps)
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Community support
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Personal use only
                    </li>
                </ul>
                
                <a href="#signup-free" class="musaix-btn musaix-btn-secondary" style="width: 100%; justify-content: center; padding: 1rem;">
                    Start Free
                </a>
            </div>
            
            <!-- Pro Plan - Most Popular -->
            <div class="musaix-pricing-card popular musaix-animate-in">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--musaix-text-primary);">Professional</h3>
                    <div style="font-size: 3rem; font-weight: 800; color: var(--musaix-primary); margin-bottom: 0.5rem;">
                        $29
                        <span style="font-size: 1rem; color: var(--musaix-text-muted); font-weight: 400;">/month</span>
                    </div>
                    <p style="color: var(--musaix-text-muted); margin: 0;">For serious music creators</p>
                </div>
                
                <ul style="list-style: none; padding: 0; margin: 2rem 0; text-align: left;">
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Unlimited AI compositions
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        HD audio (320kbps + WAV)
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Advanced AI tools
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Commercial licensing
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Priority support
                    </li>
                </ul>
                
                <a href="#signup-pro" class="musaix-btn musaix-btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                    Start 14-Day Free Trial
                </a>
            </div>
            
            <!-- Enterprise Plan -->
            <div class="musaix-pricing-card musaix-animate-in">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--musaix-text-primary);">Studio</h3>
                    <div style="font-size: 3rem; font-weight: 800; color: var(--musaix-primary); margin-bottom: 0.5rem;">
                        $99
                        <span style="font-size: 1rem; color: var(--musaix-text-muted); font-weight: 400;">/month</span>
                    </div>
                    <p style="color: var(--musaix-text-muted); margin: 0;">For teams and studios</p>
                </div>
                
                <ul style="list-style: none; padding: 0; margin: 2rem 0; text-align: left;">
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Everything in Professional
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Team collaboration (5 users)
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        API access
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Custom AI model training
                    </li>
                    <li style="padding: 0.75rem 0; display: flex; align-items: center; color: var(--musaix-text-secondary);">
                        <i class="fas fa-check" style="color: var(--musaix-accent); margin-right: 0.75rem; font-size: 1.1rem;"></i>
                        Dedicated support
                    </li>
                </ul>
                
                <a href="#contact" class="musaix-btn musaix-btn-accent" style="width: 100%; justify-content: center; padding: 1rem;">
                    Contact Sales
                </a>
            </div>
        </div>
        
        <!-- Social Proof -->
        <div style="text-align: center; margin-top: 4rem; padding-top: 3rem; border-top: 1px solid var(--musaix-border);">
            <p style="color: var(--musaix-text-muted); margin-bottom: 2rem;">Trusted by creators at</p>
            <div style="display: flex; justify-content: center; align-items: center; gap: 3rem; flex-wrap: wrap; opacity: 0.6;">
                <div style="font-size: 1.5rem; font-weight: 600; color: var(--musaix-text-secondary);">Sony Music</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: var(--musaix-text-secondary);">Universal</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: var(--musaix-text-secondary);">Warner Bros</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: var(--musaix-text-secondary);">Netflix</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="musaix-section musaix-section-gradient">
    <div class="musaix-container musaix-text-center">
        <h2 style="font-size: 3.5rem; margin-bottom: 1.5rem; color: white;">Ready to Create Amazing Music?</h2>
        <p style="font-size: 1.3rem; margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto; color: rgba(255,255,255,0.9);">
            Join the AI music revolution. Start creating professional tracks in minutes, not hours.
        </p>
        <div style="display: flex; gap: 1.5rem; justify-content: center;">
            <a href="#get-started" class="musaix-btn musaix-btn-accent" style="font-size: 1.3rem; padding: 1.5rem 3rem;">
                <i class="fas fa-rocket" style="margin-right: 0.5rem;"></i>
                Start Creating Now
            </a>
            <a href="#demo" class="musaix-btn musaix-btn-secondary" style="font-size: 1.3rem; padding: 1.5rem 3rem;">
                <i class="fas fa-play" style="margin-right: 0.5rem;"></i>
                Try Demo Again
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer style="background: var(--musaix-bg-primary); border-top: 1px solid var(--musaix-border); padding: 4rem 0 2rem;">
    <div class="musaix-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; margin-bottom: 3rem;">
            <div>
                <h3 style="color: var(--musaix-accent); margin-bottom: 1.5rem; font-size: 1.5rem;">
                    <i class="fas fa-music" style="margin-right: 0.5rem; color: var(--musaix-primary);"></i>
                    Musaix Pro
                </h3>
                <p style="margin-bottom: 1.5rem; line-height: 1.7;">
                    The future of music creation powered by artificial intelligence. Create, collaborate, and produce like never before.
                </p>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.5rem; transition: var(--musaix-transition-base);"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.5rem; transition: var(--musaix-transition-base);"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.5rem; transition: var(--musaix-transition-base);"><i class="fab fa-youtube"></i></a>
                    <a href="#" style="color: var(--musaix-text-secondary); font-size: 1.5rem; transition: var(--musaix-transition-base);"><i class="fab fa-discord"></i></a>
                </div>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; color: var(--musaix-text-primary);">Product</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">AI Composition</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Smart Mixing</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Voice Synthesis</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">API Access</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; color: var(--musaix-text-primary);">Support</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Help Center</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Contact Us</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Community</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Status</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem; color: var(--musaix-text-primary);">Company</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">About</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Careers</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Press</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="#" style="color: var(--musaix-text-secondary); transition: var(--musaix-transition-base);">Legal</a></li>
                </ul>
            </div>
        </div>
        
        <div style="border-top: 1px solid var(--musaix-border); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p style="margin: 0; color: var(--musaix-text-muted);">
                © 2025 Musaix Pro. All rights reserved.
            </p>
            <div style="display: flex; gap: 2rem;">
                <a href="#" style="color: var(--musaix-text-muted); font-size: 0.9rem;">Privacy Policy</a>
                <a href="#" style="color: var(--musaix-text-muted); font-size: 0.9rem;">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Enhanced JavaScript for Interactive Demo -->
<script>
// Advanced Demo Functionality
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generate-btn');
    const promptInput = document.getElementById('ai-prompt');
    const quickPrompts = document.querySelectorAll('.quick-prompt');
    const idleState = document.getElementById('idle-state');
    const generatingState = document.getElementById('generating-state');
    const completedState = document.getElementById('completed-state');
    const steps = document.querySelectorAll('.step');
    const playBtn = document.getElementById('demo-play-btn');
    const waveform = document.getElementById('demo-waveform');
    const tryAgainBtn = document.getElementById('try-again-btn');
    
    // Quick prompt selection
    quickPrompts.forEach(btn => {
        btn.addEventListener('click', function() {
            promptInput.value = this.dataset.prompt;
            quickPrompts.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Generate button click
    generateBtn.addEventListener('click', function() {
        if (!promptInput.value.trim()) return;
        
        startGeneration();
    });
    
    // Enter key support
    promptInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            generateBtn.click();
        }
    });
    
    function startGeneration() {
        // Hide idle state, show generating
        idleState.style.display = 'none';
        generatingState.style.display = 'block';
        completedState.style.display = 'none';
        
        // Disable generate button
        generateBtn.disabled = true;
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
        
        // Animate steps
        animateGenerationSteps();
    }
    
    function animateGenerationSteps() {
        steps.forEach((step, index) => {
            setTimeout(() => {
                step.style.opacity = '1';
                step.style.color = 'var(--musaix-primary)';
                const icon = step.querySelector('i');
                icon.className = 'fas fa-check-circle';
                
                // Play sound effect (if available)
                playStepSound();
                
                // Complete generation after last step
                if (index === steps.length - 1) {
                    setTimeout(() => {
                        completeGeneration();
                    }, 1000);
                }
            }, (index + 1) * 1500);
        });
    }
    
    function completeGeneration() {
        generatingState.style.display = 'none';
        completedState.style.display = 'block';
        
        // Reset generate button
        generateBtn.disabled = false;
        generateBtn.innerHTML = '<i class="fas fa-magic"></i> Generate';
        
        // Update track info based on prompt
        updateTrackInfo();
        
        // Add success animation
        completedState.style.opacity = '0';
        completedState.style.transform = 'translateY(20px)';
        setTimeout(() => {
            completedState.style.transition = 'all 0.5s ease';
            completedState.style.opacity = '1';
            completedState.style.transform = 'translateY(0)';
        }, 100);
    }
    
    function updateTrackInfo() {
        const prompt = promptInput.value.toLowerCase();
        let genre = 'Electronic';
        let bpm = '128';
        let key = 'C';
        
        // Simple genre detection
        if (prompt.includes('jazz')) { genre = 'Jazz'; bpm = '120'; key = 'F'; }
        else if (prompt.includes('rock')) { genre = 'Rock'; bpm = '140'; key = 'E'; }
        else if (prompt.includes('classical')) { genre = 'Classical'; bpm = '100'; key = 'G'; }
        else if (prompt.includes('hip hop') || prompt.includes('rap')) { genre = 'Hip Hop'; bpm = '90'; key = 'A'; }
        else if (prompt.includes('ambient')) { genre = 'Ambient'; bpm = '70'; key = 'D'; }
        
        document.getElementById('track-info').textContent = `${genre} • ${bpm} BPM • Key of ${key}`;
    }
    
    // Play button functionality
    playBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (icon.classList.contains('fa-play')) {
            icon.classList.remove('fa-play');
            icon.classList.add('fa-pause');
            waveform.classList.add('playing');
            
            // Simulate 30-second demo
            setTimeout(() => {
                if (icon.classList.contains('fa-pause')) {
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-play');
                    waveform.classList.remove('playing');
                }
            }, 30000);
        } else {
            icon.classList.remove('fa-pause');
            icon.classList.add('fa-play');
            waveform.classList.remove('playing');
        }
    });
    
    // Try again button
    tryAgainBtn.addEventListener('click', function() {
        completedState.style.display = 'none';
        idleState.style.display = 'block';
        
        // Reset steps
        steps.forEach(step => {
            step.style.opacity = '0.5';
            step.style.color = 'var(--musaix-text-muted)';
            const icon = step.querySelector('i');
            icon.className = 'fas fa-circle-notch';
        });
        
        // Reset waveform
        waveform.classList.remove('playing');
        const playIcon = playBtn.querySelector('i');
        playIcon.classList.remove('fa-pause');
        playIcon.classList.add('fa-play');
    });
    
    function playStepSound() {
        // Create a simple beep sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.2);
    }
    
    // Pricing toggle
    const pricingToggle = document.querySelector('.pricing-toggle');
    const toggleSlider = document.querySelector('.toggle-slider');
    let isAnnual = false;
    
    if (pricingToggle) {
        pricingToggle.addEventListener('click', function() {
            isAnnual = !isAnnual;
            if (isAnnual) {
                toggleSlider.style.transform = 'translateX(30px)';
                // Update pricing (would normally update all prices)
            } else {
                toggleSlider.style.transform = 'translateX(0)';
            }
        });
    }
    
    // Enhanced animations
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
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        observer.observe(el);
    });
    
    // Smooth scrolling
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
    
    // Navigation effects
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('main-nav');
        if (window.scrollY > 100) {
            nav.style.background = 'rgba(0, 0, 0, 0.95)';
            nav.style.backdropFilter = 'blur(20px)';
        } else {
            nav.style.background = 'rgba(0, 0, 0, 0.8)';
            nav.style.backdropFilter = 'blur(20px)';
        }
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .ai-thinking {
        animation: spin 1s linear infinite;
    }
    
    .quick-prompt.active {
        background: var(--musaix-primary-light) !important;
        color: var(--musaix-primary) !important;
        border-color: var(--musaix-primary) !important;
    }
    
    .step {
        transition: opacity 0.3s ease, color 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>

<?php wp_footer(); ?>
</body>
</html>