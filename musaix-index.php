<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
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
                    <a href="<?php echo home_url(); ?>" style="color: inherit; text-decoration: none;">
                        <?php bloginfo('name'); ?>
                    </a>
                </h2>
            </div>
            <div class="musaix-nav-menu" style="display: flex; gap: 2rem;">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'musaix-nav-items',
                    'container' => false,
                    'fallback_cb' => 'musaix_fallback_menu'
                ));
                ?>
            </div>
            <div class="musaix-nav-actions" style="display: flex; gap: 1rem;">
                <a href="#login" class="musaix-btn musaix-btn-secondary">Login</a>
                <a href="#signup" class="musaix-btn musaix-btn-primary">Get Started</a>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="musaix-main">
    <div class="musaix-container" style="padding: 4rem 1rem;">
        
        <?php if (have_posts()) : ?>
            
            <!-- Page/Post Title -->
            <header class="page-header" style="text-align: center; margin-bottom: 3rem;">
                <?php if (is_home() && !is_front_page()) : ?>
                    <h1 style="font-size: 3rem; margin-bottom: 1rem; background: var(--musaix-gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <?php single_post_title(); ?>
                    </h1>
                <?php elseif (is_archive()) : ?>
                    <h1 style="font-size: 3rem; margin-bottom: 1rem; background: var(--musaix-gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <?php the_archive_title(); ?>
                    </h1>
                    <?php if (get_the_archive_description()) : ?>
                        <div style="font-size: 1.1rem; color: var(--musaix-text-secondary); max-width: 600px; margin: 0 auto;">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                <?php elseif (is_search()) : ?>
                    <h1 style="font-size: 3rem; margin-bottom: 1rem; background: var(--musaix-gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Search Results for: "<?php echo get_search_query(); ?>"
                    </h1>
                <?php endif; ?>
            </header>
            
            <!-- Posts Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('musaix-card'); ?>>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div style="margin-bottom: 1.5rem; border-radius: 8px; overflow: hidden;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 200px; object-fit: cover;')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <header class="entry-header" style="margin-bottom: 1rem;">
                            <h2 style="margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>" style="color: var(--musaix-text-primary); text-decoration: none;">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.9rem; color: var(--musaix-text-muted);">
                                <span>
                                    <i class="fas fa-calendar" style="margin-right: 0.25rem;"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span>
                                    <i class="fas fa-user" style="margin-right: 0.25rem;"></i>
                                    <?php the_author(); ?>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span>
                                        <i class="fas fa-folder" style="margin-right: 0.25rem;"></i>
                                        <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>
                        
                        <div class="entry-content" style="margin-bottom: 1.5rem; color: var(--musaix-text-secondary);">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="musaix-btn musaix-btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                Read More
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </footer>
                        
                    </article>
                    
                <?php endwhile; ?>
                
            </div>
            
            <!-- Pagination -->
            <div style="margin-top: 3rem; text-align: center;">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
                    'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
                    'class' => 'musaix-pagination'
                ));
                ?>
            </div>
            
        <?php else : ?>
            
            <!-- No Posts Found -->
            <div class="musaix-card" style="text-align: center; padding: 3rem;">
                <i class="fas fa-search" style="font-size: 3rem; color: var(--musaix-primary); margin-bottom: 1rem;"></i>
                <h2 style="margin-bottom: 1rem;">Nothing Found</h2>
                <p style="margin-bottom: 2rem; color: var(--musaix-text-secondary);">
                    <?php if (is_search()) : ?>
                        Sorry, but nothing matched your search terms. Please try again with some different keywords.
                    <?php else : ?>
                        It seems we can't find what you're looking for. Perhaps searching can help.
                    <?php endif; ?>
                </p>
                
                <!-- Search Form -->
                <form role="search" method="get" action="<?php echo home_url('/'); ?>" style="max-width: 400px; margin: 0 auto; display: flex; gap: 1rem;">
                    <input type="search" 
                           placeholder="Search..." 
                           value="<?php echo get_search_query(); ?>" 
                           name="s"
                           class="musaix-input"
                           style="flex: 1;">
                    <button type="submit" class="musaix-btn musaix-btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<!-- Footer -->
<footer style="background: var(--musaix-bg-primary); border-top: 1px solid var(--musaix-border); padding: 3rem 0 1rem;">
    <div class="musaix-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            <div>
                <h3 style="color: var(--musaix-accent); margin-bottom: 1rem;">
                    <i class="fas fa-music" style="margin-right: 0.5rem;"></i>
                    <?php bloginfo('name'); ?>
                </h3>
                <p style="margin-bottom: 1rem;">
                    <?php 
                    $description = get_bloginfo('description');
                    echo $description ? $description : 'The future of music creation powered by artificial intelligence.';
                    ?>
                </p>
                
                <!-- Social Media Links -->
                <div style="display: flex; gap: 1rem;">
                    <?php
                    $socials = array('twitter', 'facebook', 'instagram', 'youtube', 'linkedin', 'discord');
                    foreach ($socials as $social) {
                        $url = get_theme_mod('musaix_' . $social . '_url');
                        if ($url) {
                            $icon = $social === 'discord' ? 'fab fa-discord' : 'fab fa-' . $social;
                            echo '<a href="' . esc_url($url) . '" style="color: var(--musaix-text-secondary); font-size: 1.2rem;" target="_blank" rel="noopener"><i class="' . $icon . '"></i></a>';
                        }
                    }
                    ?>
                </div>
            </div>
            
            <!-- Footer Widget Area -->
            <?php if (is_active_sidebar('footer-widgets')) : ?>
                <div style="grid-column: 2 / -1;">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div style="border-top: 1px solid var(--musaix-border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <p style="margin: 0; color: var(--musaix-text-muted); font-size: 0.9rem;">
                © <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
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
</script>

<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Fallback menu if no menu is assigned
 */
function musaix_fallback_menu() {
    echo '<div style="display: flex; gap: 2rem;">';
    echo '<a href="' . home_url() . '" class="musaix-nav-item">Home</a>';
    echo '<a href="' . home_url('/about') . '" class="musaix-nav-item">About</a>';
    echo '<a href="' . home_url('/blog') . '" class="musaix-nav-item">Blog</a>';
    echo '<a href="' . home_url('/contact') . '" class="musaix-nav-item">Contact</a>';
    echo '</div>';
}
?>