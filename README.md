# Sh0rt me - Advanced URL Shortener 🔗

**sh0rt me** is a feature-rich PHP web application for URL shortening with advanced analytics and file management capabilities. Create short, memorable links with custom text options and track their performance through a powerful admin dashboard.

## ✨ Features

- **URL Shortening**
  - Custom URL support
  - Automatic short URL generation
  - URL validation and security checks
  - Copy-to-clipboard functionality

- **Advanced Analytics**
  - Click tracking
  - Visitor analytics
  - Geographic data
  - User agent information
  - Interactive charts

- **Admin Dashboard**
  - Real-time statistics
  - URL management
  - Detailed analytics
  - File management system
  - Secure admin login

- **File Management**
  - File upload/download
  - Public/private file sharing
  - Multiple file support
  - File type detection
  - Secure file handling

## 🚀 Getting Started

1. **Clone the Repository**
   ```bash
   git clone https://github.com/r04nx/sh0rt-me.git
   cd sh0rt-me
   ```

2. **Database Setup**
   - Create a MySQL database named `sh0rtme`
   - Import the database structure from `Database/sh0rtme.sql`
   - Update database credentials in `db.php`

3. **Server Configuration**
   - Ensure PHP 7.2+ is installed
   - Configure your web server to use the `.htaccess` file
   - Set appropriate permissions for the `uploads` directory:
     ```bash
     chmod 755 uploads/
     ```

4. **Admin Access**
   - Default admin password: `admin123`
   - Change this in production!

## 📊 Dashboard Preview

![Admin Dashboard](https://raw.githubusercontent.com/r04nx/sh0rt-me/main/Assets/1-min.png)

## 🛠 Technical Requirements

- PHP 7.2+
- MySQL 5.7+
- Apache/Nginx with mod_rewrite
- Modern web browser

## 🔒 Security Features

- SQL injection protection
- XSS prevention
- Secure file handling
- Protected admin access
- Input sanitization

## 🌐 Live Demo

Experience sh0rt me in action: [Live Demo](https://sh0rt.rf.gd)

## 📝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Support

For support, email [r04nx.work@gmail.com] or open an issue in the repository.

Made with ❤️ by [r04nx]
