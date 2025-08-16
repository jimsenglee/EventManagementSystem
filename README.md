# Event Management System

This is a web-based Event Management System developed as part of my Final Year Project (FYP). The system is designed to streamline the process of managing events, bookings, and related activities for an organization or institution.

## Features

- **User Authentication:** Secure login and registration for users and administrators.
- **Event Management:** Add, edit, view, and delete events. Admins can manage all event details.
- **Venue Booking:** Users can book venues for events, view booking history, and manage their reservations.
- **Booking Approval:** Admins can approve or reject booking requests and update booking statuses.
- **Event Results:** Manage and display event results, including adding, editing, and viewing results.
- **Merchandise:** Manage and purchase event-related merchandise.
- **News & Announcements:** Post and view important updates related to events.
- **Contact & Feedback:** Users can contact the admin, provide feedback, and view information about the system.

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Other Libraries:** PHPMailer for email notifications, TCPDF for PDF generation

## Folder Structure

- `booking/` - Venue booking and management
- `event_management/` - Event CRUD operations
- `event_results/` - Event results management
- `header&footer/` - Common header and footer components
- `homePage/` - Home page and related scripts
- `includes/` - Third-party libraries (e.g., PHPMailer)
- `info/` - Informational pages (About Us, Contact, FAQ, etc.)
- `login/` - User authentication and profile management
- `merchandise/` - Merchandise management
- `newsandannouncement/` - News and announcements
- `payment/` - Payment-related files
- `tcpdf/` - PDF generation library
- `ticket/` - Ticket management
- `config/` - Helper and configuration files
- `css/` - Stylesheets
- `image/`, `lsimage/` - Images used in the system

## How to Run

1. Clone the repository:
   ```
   git clone https://github.com/jimsenglee/EventManagementSystem.git
   ```
2. Set up a local web server (e.g., XAMPP, WAMP) and import the database (SQL file not included here).
3. Place the project files in the web server's root directory.
4. Configure database connection in `event_management/connect.php` and other relevant config files.
5. Access the system via your browser (e.g., http://localhost/EventManagementSystem).

## Author

- **GitHub:** [jimsenglee](https://github.com/jimsenglee)
- **Email:** gimsheng.lee@gmail.com

## Purpose

This project demonstrates my ability to design and implement a full-stack web application, including user authentication, CRUD operations, and integration with third-party libraries. It is intended to showcase my skills to potential employers and can be referenced in my resume.

---

Feel free to contact me for more information or collaboration opportunities!
