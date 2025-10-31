#!/bin/bash

# 📊 MUSAIX PRO MONITORING & BACKUP VERIFICATION SYSTEM
# Comprehensive monitoring, logging, and backup integrity checking

set -euo pipefail

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(dirname "$SCRIPT_DIR")"
MONITOR_DIR="$PROJECT_DIR/monitoring"
BACKUP_DIR="$PROJECT_DIR/backups"
LOG_FILE="$MONITOR_DIR/monitor.log"
ALERT_EMAIL="${ALERT_EMAIL:-admin@musaix.com}"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Create monitoring directory
mkdir -p "$MONITOR_DIR" "$BACKUP_DIR"

# Logging function
log_event() {
    local level="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[$timestamp] [$level] $message" >> "$LOG_FILE"
    
    case $level in
        "ERROR")
            echo -e "${RED}❌ [$level] $message${NC}"
            ;;
        "WARNING")
            echo -e "${YELLOW}⚠️  [$level] $message${NC}"
            ;;
        "SUCCESS")
            echo -e "${GREEN}✅ [$level] $message${NC}"
            ;;
        *)
            echo -e "${BLUE}ℹ️  [$level] $message${NC}"
            ;;
    esac
}

# Check Docker services
check_docker_services() {
    log_event "INFO" "Checking Docker services..."
    
    local services=("musaixpro_wordpress" "musaixpro_db" "musaixpro_phpmyadmin")
    local all_healthy=true
    
    for service in "${services[@]}"; do
        if docker ps --filter "name=$service" --filter "status=running" | grep -q "$service"; then
            log_event "SUCCESS" "Service $service is running"
        else
            log_event "ERROR" "Service $service is not running"
            all_healthy=false
        fi
    done
    
    if [ "$all_healthy" = true ]; then
        log_event "SUCCESS" "All Docker services are healthy"
        return 0
    else
        send_alert "Docker Services Alert" "One or more Docker services are not running"
        return 1
    fi
}

# Check WordPress health
check_wordpress_health() {
    log_event "INFO" "Checking WordPress health..."
    
    local wp_url="${WP_HOME:-http://localhost:8080}"
    local response_code
    
    if response_code=$(curl -s -o /dev/null -w "%{http_code}" "$wp_url"); then
        if [ "$response_code" = "200" ]; then
            log_event "SUCCESS" "WordPress is responding (HTTP $response_code)"
        else
            log_event "WARNING" "WordPress returned HTTP $response_code"
        fi
    else
        log_event "ERROR" "Failed to connect to WordPress"
        send_alert "WordPress Health Alert" "WordPress is not responding at $wp_url"
        return 1
    fi
}

# Check database health
check_database_health() {
    log_event "INFO" "Checking database health..."
    
    if docker exec musaixpro_db mysqladmin ping -h localhost --silent; then
        log_event "SUCCESS" "Database is responding"
        
        # Check database size
        local db_size=$(docker exec musaixpro_db mysql -e "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema='${DB_NAME:-musaixpro_wp}';" | tail -n 1)
        log_event "INFO" "Database size: ${db_size}MB"
        
    else
        log_event "ERROR" "Database is not responding"
        send_alert "Database Health Alert" "Database is not responding"
        return 1
    fi
}

# Check disk space
check_disk_space() {
    log_event "INFO" "Checking disk space..."
    
    local usage=$(df "$PROJECT_DIR" | awk 'NR==2 {print $5}' | sed 's/%//')
    
    if [ "$usage" -gt 85 ]; then
        log_event "ERROR" "Disk usage is ${usage}% - critical level"
        send_alert "Disk Space Alert" "Disk usage is ${usage}% on Musaix Pro server"
    elif [ "$usage" -gt 75 ]; then
        log_event "WARNING" "Disk usage is ${usage}% - warning level"
    else
        log_event "SUCCESS" "Disk usage is ${usage}% - normal"
    fi
}

# Check security logs
check_security_logs() {
    log_event "INFO" "Checking security logs..."
    
    local wp_log_file="$PROJECT_DIR/wordpress/wp-content/debug.log"
    local failed_logins=0
    
    if [ -f "$wp_log_file" ]; then
        # Count failed login attempts in the last hour
        failed_logins=$(grep "Failed login attempt" "$wp_log_file" | grep "$(date '+%Y-%m-%d %H')" | wc -l)
        
        if [ "$failed_logins" -gt 10 ]; then
            log_event "ERROR" "High number of failed login attempts: $failed_logins in the last hour"
            send_alert "Security Alert" "Detected $failed_logins failed login attempts in the last hour"
        elif [ "$failed_logins" -gt 5 ]; then
            log_event "WARNING" "Moderate failed login attempts: $failed_logins in the last hour"
        else
            log_event "SUCCESS" "Normal security activity: $failed_logins failed logins in the last hour"
        fi
    fi
}

# Verify backup integrity
verify_backup_integrity() {
    log_event "INFO" "Verifying backup integrity..."
    
    local latest_backup=$(find "$BACKUP_DIR" -name "musaix_backup_*.tar.gz" -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -d' ' -f2-)
    
    if [ -n "$latest_backup" ] && [ -f "$latest_backup" ]; then
        log_event "INFO" "Found latest backup: $(basename "$latest_backup")"
        
        # Test backup file integrity
        if tar -tzf "$latest_backup" >/dev/null 2>&1; then
            log_event "SUCCESS" "Backup file integrity verified"
            
            # Check backup age
            local backup_age=$(( ($(date +%s) - $(stat -c %Y "$latest_backup")) / 86400 ))
            
            if [ "$backup_age" -gt 7 ]; then
                log_event "WARNING" "Latest backup is $backup_age days old"
                send_alert "Backup Age Alert" "Latest backup is $backup_age days old - consider running backup"
            else
                log_event "SUCCESS" "Backup is recent ($backup_age days old)"
            fi
        else
            log_event "ERROR" "Backup file is corrupted: $latest_backup"
            send_alert "Backup Integrity Alert" "Backup file is corrupted: $(basename "$latest_backup")"
        fi
    else
        log_event "ERROR" "No backup files found"
        send_alert "Backup Missing Alert" "No backup files found in $BACKUP_DIR"
    fi
}

# Performance monitoring
check_performance() {
    log_event "INFO" "Checking performance metrics..."
    
    # Check load average
    local load_avg=$(uptime | awk -F'load average:' '{print $2}' | awk '{print $1}' | sed 's/,//')
    log_event "INFO" "System load average: $load_avg"
    
    # Check memory usage
    local memory_usage=$(free | awk '/^Mem:/{printf "%.1f", $3/$2 * 100.0}')
    log_event "INFO" "Memory usage: ${memory_usage}%"
    
    if (( $(echo "$memory_usage > 90" | bc -l) )); then
        log_event "WARNING" "High memory usage: ${memory_usage}%"
    fi
    
    # Check container resource usage
    if command -v docker &> /dev/null; then
        docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}" | tail -n +2 | while read line; do
            log_event "INFO" "Container stats: $line"
        done
    fi
}

# Send alert notification
send_alert() {
    local subject="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    
    # Log alert
    log_event "ALERT" "$subject: $message"
    
    # Send email if mail command is available
    if command -v mail &> /dev/null; then
        echo "[$timestamp] Musaix Pro Alert: $message" | mail -s "$subject" "$ALERT_EMAIL"
        log_event "INFO" "Alert email sent to $ALERT_EMAIL"
    fi
    
    # Write to alert file
    echo "[$timestamp] $subject: $message" >> "$MONITOR_DIR/alerts.log"
}

# Generate monitoring report
generate_report() {
    local report_file="$MONITOR_DIR/health_report_$(date +%Y%m%d_%H%M%S).txt"
    
    cat > "$report_file" << EOF
MUSAIX PRO HEALTH REPORT
========================
Generated: $(date)

SYSTEM STATUS:
$(check_docker_services >/dev/null 2>&1 && echo "✅ Docker Services: HEALTHY" || echo "❌ Docker Services: ISSUES DETECTED")
$(check_wordpress_health >/dev/null 2>&1 && echo "✅ WordPress: HEALTHY" || echo "❌ WordPress: ISSUES DETECTED")
$(check_database_health >/dev/null 2>&1 && echo "✅ Database: HEALTHY" || echo "❌ Database: ISSUES DETECTED")

RESOURCE USAGE:
- Disk Usage: $(df "$PROJECT_DIR" | awk 'NR==2 {print $5}')
- Memory Usage: $(free | awk '/^Mem:/{printf "%.1f%%", $3/$2 * 100.0}')
- Load Average: $(uptime | awk -F'load average:' '{print $2}' | awk '{print $1}' | sed 's/,//')

BACKUP STATUS:
$(ls -la "$BACKUP_DIR"/*.tar.gz 2>/dev/null | tail -5 || echo "No backups found")

RECENT ALERTS:
$(tail -10 "$MONITOR_DIR/alerts.log" 2>/dev/null || echo "No recent alerts")

EOF
    
    log_event "SUCCESS" "Health report generated: $report_file"
}

# Main monitoring function
main() {
    log_event "INFO" "Starting Musaix Pro monitoring check..."
    
    case "${1:-all}" in
        "docker")
            check_docker_services
            ;;
        "wordpress")
            check_wordpress_health
            ;;
        "database")
            check_database_health
            ;;
        "security")
            check_security_logs
            ;;
        "backup")
            verify_backup_integrity
            ;;
        "performance")
            check_performance
            ;;
        "report")
            generate_report
            ;;
        "all")
            check_docker_services
            check_wordpress_health
            check_database_health
            check_disk_space
            check_security_logs
            verify_backup_integrity
            check_performance
            ;;
        *)
            echo "Usage: $0 [docker|wordpress|database|security|backup|performance|report|all]"
            exit 1
            ;;
    esac
    
    log_event "INFO" "Monitoring check completed"
}

# Set up cron job for automated monitoring
setup_monitoring_cron() {
    local cron_entry="*/15 * * * * $SCRIPT_DIR/$(basename "$0") all >/dev/null 2>&1"
    
    if ! crontab -l 2>/dev/null | grep -q "$(basename "$0")"; then
        (crontab -l 2>/dev/null; echo "$cron_entry") | crontab -
        log_event "SUCCESS" "Monitoring cron job installed (runs every 15 minutes)"
    else
        log_event "INFO" "Monitoring cron job already exists"
    fi
}

# Run main function
main "$@"