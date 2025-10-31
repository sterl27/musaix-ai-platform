<?php
/**
 * Database Setup for Training Data
 * Creates the training_data table with proper structure
 */

// Load WordPress
require_once(dirname(__FILE__) . '/wp-config.php');
require_once(dirname(__FILE__) . '/wp-load.php');

global $wpdb;

$table_name = $wpdb->prefix . 'training_data';

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    file_path varchar(500),
    file_type varchar(50) NOT NULL,
    file_size bigint(20) NOT NULL DEFAULT 0,
    category varchar(100) NOT NULL DEFAULT 'general',
    content longtext,
    metadata text,
    status varchar(50) NOT NULL DEFAULT 'pending',
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_category (category),
    INDEX idx_file_type (file_type),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

// Check if table was created
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

if ($table_exists) {
    echo "✅ Training data table created successfully: $table_name\n";
    
    // Get table structure
    $columns = $wpdb->get_results("DESCRIBE $table_name");
    echo "\n📋 Table Structure:\n";
    foreach ($columns as $column) {
        echo "  - {$column->Field}: {$column->Type}\n";
    }
    
    // Insert sample data for testing
    $sample_data = [
        [
            'name' => 'Sample Music Theory Document',
            'file_path' => null,
            'file_type' => 'pdf',
            'file_size' => 1024000,
            'category' => 'theory',
            'content' => 'Sample content about music theory, scales, and composition techniques.',
            'metadata' => json_encode(['pages' => 25, 'topics' => ['scales', 'harmony', 'composition']]),
            'status' => 'processed'
        ],
        [
            'name' => 'AI Music Generation Research',
            'file_path' => null,
            'file_type' => 'url',
            'file_size' => 50000,
            'category' => 'research',
            'content' => 'Research paper on neural networks for music generation.',
            'metadata' => json_encode(['url' => 'https://example.com/research', 'word_count' => 5000]),
            'status' => 'processed'
        ],
        [
            'name' => 'Chord Progressions Dataset',
            'file_path' => '/uploads/training-data/chord_progressions.json',
            'file_type' => 'json',
            'file_size' => 2048000,
            'category' => 'samples',
            'content' => 'JSON dataset containing common chord progressions in various keys.',
            'metadata' => json_encode(['entries' => 1500, 'keys' => 12, 'genres' => ['pop', 'jazz', 'classical']]),
            'status' => 'processed'
        ]
    ];
    
    foreach ($sample_data as $data) {
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE name = %s",
            $data['name']
        ));
        
        if (!$existing) {
            $wpdb->insert($table_name, $data);
            echo "  ✅ Added sample: {$data['name']}\n";
        }
    }
    
    // Show current data count
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    echo "\n📊 Current training data entries: $count\n";
    
} else {
    echo "❌ Failed to create training data table\n";
}

// Create uploads directory structure
$upload_dir = wp_upload_dir();
$training_dir = $upload_dir['basedir'] . '/training-data/';

if (!file_exists($training_dir)) {
    if (wp_mkdir_p($training_dir)) {
        echo "✅ Created training data directory: $training_dir\n";
        
        // Create subdirectories
        $subdirs = ['documents', 'audio', 'json', 'temp'];
        foreach ($subdirs as $subdir) {
            $subdir_path = $training_dir . $subdir . '/';
            if (wp_mkdir_p($subdir_path)) {
                echo "  ✅ Created subdirectory: $subdir\n";
            }
        }
        
        // Create .htaccess for security
        $htaccess_content = "# Deny direct access to uploaded files\n";
        $htaccess_content .= "Options -Indexes\n";
        $htaccess_content .= "<FilesMatch \"\\.(php|phtml|php3|php4|php5|pl|py|jsp|asp|sh|cgi)$\">\n";
        $htaccess_content .= "    Order deny,allow\n";
        $htaccess_content .= "    Deny from all\n";
        $htaccess_content .= "</FilesMatch>\n";
        
        file_put_contents($training_dir . '.htaccess', $htaccess_content);
        echo "  ✅ Created .htaccess security file\n";
        
    } else {
        echo "❌ Failed to create training data directory\n";
    }
} else {
    echo "✅ Training data directory already exists: $training_dir\n";
}

echo "\n🎉 Database setup complete! Training system is ready.\n";
echo "🌐 Access the training page at: http://localhost:8080/training/\n";
?>