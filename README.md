# Musaix Pro WordPress Development Environment

A local WordPress development environment using Docker for the Musaix Pro website.

## 🚀 Quick Start

### Prerequisites
- Docker and Docker Compose installed
- VS Code with recommended extensions
- Git (optional)

### 1. Start the Development Environment

```bash
# Start all services
docker-compose up -d

# Check if services are running
docker-compose ps
```

### 2. Access Your Site

- **WordPress Site**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **Admin Login**: admin / admin123

### 3. Import Your WordPress Data

First, copy your XML export file to the WordPress container:

```bash
# Copy the XML file to the WordPress container
docker cp musaixpro.WordPress.2025-10-28.xml musaixpro_wordpress:/var/www/html/

# Install WordPress Importer plugin
docker-compose exec wordpress wp plugin install wordpress-importer --activate

# Import the XML data
docker-compose exec wordpress wp import musaixpro.WordPress.2025-10-28.xml --authors=create
```

## 🛠️ Development Commands

### Docker Commands
```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f wordpress

# Restart a service
docker-compose restart wordpress
```

### WP-CLI Commands
```bash
# Install WordPress core (if needed)
docker-compose run --rm wpcli wp core install \
  --url=http://localhost:8080 \
  --title="Musaix Pro" \
  --admin_user=admin \
  --admin_password=admin123 \
  --admin_email=admin@example.com

# Install plugins
docker-compose exec wordpress wp plugin install elementor --activate
docker-compose exec wordpress wp plugin install elementor-pro --activate

# List all posts
docker-compose exec wordpress wp post list

# Update WordPress
docker-compose exec wordpress wp core update
```

### Database Commands
```bash
# Export database
docker-compose exec db mysqldump -u wordpress -pwordpress_password_123 musaixpro_wp > backup.sql

# Import database
docker-compose exec -T db mysql -u wordpress -pwordpress_password_123 musaixpro_wp < backup.sql

# Access MySQL shell
docker-compose exec db mysql -u root -proot_password_123
```

## 📁 Project Structure

```
/home/sterl/wp/
├── docker-compose.yml          # Docker services configuration
├── .env                        # Environment variables
├── uploads.ini                 # PHP upload configuration
├── wordpress/                  # WordPress files (auto-created)
├── .vscode/                    # VS Code configuration
│   ├── settings.json
│   └── tasks.json
└── musaixpro.WordPress.2025-10-28.xml  # Your WordPress export
```

## 🔧 Configuration

### Environment Variables (.env)
- `DB_NAME`: Database name
- `DB_USER`: Database username  
- `DB_PASSWORD`: Database password
- `ADMIN_USER`: WordPress admin username
- `ADMIN_PASSWORD`: WordPress admin password

### VS Code Tasks
Use Ctrl+Shift+P → "Tasks: Run Task" to access:
- Start WordPress Development Environment
- Stop WordPress Development Environment  
- View WordPress Logs
- WP-CLI: Install WordPress
- WP-CLI: Import XML Data

## 🐛 Troubleshooting

### Common Issues

1. **Port already in use**:
   ```bash
   # Change ports in docker-compose.yml
   ports:
     - "8090:80"  # Instead of 8080:80
   ```

2. **Permission issues**:
   ```bash
   # Fix WordPress file permissions
   docker-compose exec wordpress chown -R www-data:www-data /var/www/html
   ```

3. **Database connection issues**:
   ```bash
   # Restart database service
   docker-compose restart db
   ```

4. **Import fails**:
   ```bash
   # Increase memory limit and timeouts
   docker-compose exec wordpress wp config set WP_MEMORY_LIMIT 512M
   ```

### Logs
```bash
# WordPress logs
docker-compose logs wordpress

# Database logs  
docker-compose logs db

# All logs
docker-compose logs
```

## 🚀 Production Deployment

When ready to deploy:

1. Export your database
2. Copy WordPress files 
3. Update wp-config.php with production settings
4. Set up proper web server (Apache/Nginx)
5. Configure SSL certificates
6. Set up backups

## 📝 Notes

- The WordPress files are mounted in `./wordpress/` directory
- Database data persists in Docker volume `db_data`
- PHP settings are configured in `uploads.ini`
- Use phpMyAdmin for database management
- WP-CLI is available for command-line operations

## 🎵 About Musaix Pro

This WordPress site appears to be focused on music production with AI-powered tools including:
- AI Chatbots and Forms
- Tweet Classifier
- Blog Post Generator  
- Business Strategy Advisor
- Elementor-based page builder

The original site was built with Elementor Pro and includes various AI toolkit integrations.