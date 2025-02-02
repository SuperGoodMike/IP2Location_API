# IP2Location_API
IP Geolocation PHP-based API service

## Features
- IP Geolocation (City, Region, Country, Latitude, Longitude, Timezone, Local Time, Temperature, Humidity)
- Local Time and Weather Data
- API Key Management
- Rate Limiting
- Admin Dashboard

## Installation

### Server Requirements
- PHP 7.4+ with MySQL PDO extension
- MySQL/MariaDB
- Apache/Nginx
- Composer
- MaxMind GeoLite2 License Key (Free)

### Directory Structure
``` Structure
/srv/www/your-domain.com/
├── ip-api/
│ ├── admin/
│ ├── api/
│ ├── docs/
│ ├── includes/
│ ├── data/ # GeoLite2 database storage
│ └── .htaccess
```


### Database Setup
```sql
-- Create database and user
CREATE DATABASE ip_api;
CREATE USER 'ip_api_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON ip_api.* TO 'ip_api_user'@'localhost';
FLUSH PRIVILEGES;

-- Create tables
USE ip_api;

CREATE TABLE apikeys (
  id INT AUTO_INCREMENT PRIMARY KEY,
  key VARCHAR(64) UNIQUE NOT NULL,
  notes VARCHAR(255),
  rate_limit INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rate_limits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  api_key VARCHAR(64),
  ip VARCHAR(45),
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add indexes
CREATE INDEX idx_api_key ON rate_limits (api_key);
CREATE INDEX idx_timestamp ON rate_limits (timestamp);
```

### Package Installation

```bash
# Install PHP extensions
sudo apt install php php-mysql php-curl php-sqlite3

# Install Composer
cd /srv/www/your-domain.com/ip-api
curl -sS https://getcomposer.org/installer | php

# Install MaxMind DB Reader
php composer.phar require maxmind-db/reader
```

### File Permissions
``` bash
sudo chown -R www-data:www-data /srv/www/your-domain.com/ip-api
sudo find /srv/www/your-domain.com/ip-api -type d -exec chmod 755 {} \;
sudo find /srv/www/your-domain.com/ip-api -type f -exec chmod 644 {} \;

# Secure sensitive files
sudo chmod 640 /srv/www/your-domain.com/ip-api/includes/config.php
sudo chmod 750 /srv/www/your-domain.com/ip-api/data
```

### Configuration

- Get a free MaxMind License Key
  -- Sign up at MaxMind Portal
	-- Add free license key to config.php
- Edit includes/config.php
``` php
// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'ip_api');
define('DB_USER', 'ip_api_user');
define('DB_PASS', 'strong_password');

// MaxMind
define('MAXMIND_LICENSE_KEY', 'your_license_key');
define('MAXMIND_DB_PATH', __DIR__ . '/../data/GeoLite2-City.mmdb');

// Security
define('RATE_LIMIT', 100);         // Default requests/minute
define('RATE_LIMIT_WINDOW', 60);   // Seconds

```
### Admin Panel Security Setup
#### Create .htpasswd File
- Location: Store outside web root (e.g., /etc/secure/ip-api/.htpasswd)
``` bash
# Install Apache utils (if not installed)
sudo apt install apache2-utils

# Create .htpasswd file (replace /path/to/ with your secure directory)
sudo mkdir -p /etc/secure/ip-api/
sudo htpasswd -B /etc/secure/ip-api/.htpasswd admin
```
- You’ll be prompted to set a password for the admin user
#### Set Permissions
``` bash
sudo chown www-data:www-data /etc/secure/ip-api/.htpasswd
sudo chmod 640 /etc/secure/ip-api/.htpasswd
```
#### Configure .htaccess in Admin Directory
Create/update /ip-api/admin/.htaccess:
``` bash
AuthType Basic
AuthName "Admin Area - Restricted Access"
AuthUserFile /etc/secure/ip-api/.htpasswd
Require valid-user

# Block direct access to .htaccess
<Files ".htaccess">
    Require all denied
</Files>
```

### Cron Jobs
- Update GeoLite2 Database (Weekly) (replace "YOUR_KEY" with your free api key from maxmind)
``` bash
0 0 * * 0 wget "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=YOUR_KEY&suffix=tar.gz" -O /path/to/ip-api/data/geolite.tar.gz && tar -xzf /path/to/ip-api/data/geolite.tar.gz --strip-components=1 -C /path/to/ip-api/data/GeoLite2-City.mmdb
```
- Purge Old Rate Limits (Daily)
```bash
0 3 * * * mysql -u ip_api_user -pstrong_password -e "USE ip_api; DELETE FROM rate_limits WHERE timestamp < NOW() - INTERVAL 7 DAY;"
```
## Security Best Practices
### HTTPS Enforcement
- Configure in includes/config.php
-Requires valid SSL certificate
### Admin Panel Protection
- Use .htaccess + .htpasswd authentication
- Keep admin credentials secure
### Regular Backups
- Database: mysqldump -u ip_api_user -p ip_api > ip_api_backup.sql
- Config files: Backup includes/config.php

## Troubleshooting
### Common Issues:
 - Most error deatils are found in Apache error logs (/var/log/apache2/error.log)
 - 500/403 Errors: Check Apache error logs (/var/log/apache2/error.log)
 - Permission Issues: Verify www-data ownership
 - GeoLite2 Updates: Test cron job manually first

### Debugging Rate Limits:
``` sql
-- Check requests for a key
SELECT * FROM rate_limits WHERE api_key = 'YOUR_KEY' ORDER BY timestamp DESC;
```

## License
MIT License - Modify and distribute freely
