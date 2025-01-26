# Online Realtime Chatting System

A real-time online chatting system developed in PHP and MySQL. Real-time functionality is achieved using AJAX and periodic intervals to fetch data. The project includes user and admin modules, enabling private and group chats, with some advanced features for user interaction.

---

## Features

### User Module
- **User Registration & Login**: Secure authentication system for users.
- **Private Chat**:
  - Search for other users and start private conversations.
  - Real-time messaging using AJAX and set intervals.
  - Send images as chat messages.
- **User Profile**:
  - Edit profile details, including name and profile picture.
  - Block users if needed.
- **Group Chat** (Partial Implementation):
  - Create groups and add participants.
  - Group chat UI on the home page is incomplete.

### Admin Module
- **Admin Login**: Secure authentication for admins.
- **Dashboard**: Provides an overview of:
  - Total registered users.
  - Total active users.
  - Reports about messages exchanged.
- **User Management**: View and manage the list of registered users.

---

## Technology Stack
- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript (AJAX for real-time updates)
- **Server**: XAMMP Apache (local server)

---

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/online-realtime-chat.git
   ```

2. **Setup the Database**
   - Create `onlinechat` database in phpMyAdmin.
   - Import the `onlinechat.sql` file from SQL folder into your MySQL server (phpMyAdmin).
   - Update database connection details in the `db.php` file in both Admin and User:
    ```php
    $host = "localhost";
    $user = "your_database_username";
    $pass = "your_database_password";
    $db = "onlinechat";
    ```

3. **Start the Local Server**
   - Ensure Apache and MySQL are running.
   - Place the project folder in the `htdocs` directory (if using XAMPP).
   - Access the website via `http://localhost/OnlineChat/`.

4. **Admin Credentials**
   - Default admin credentials can be updated in the database under the `admin` table.

---

## Limitations
- Group chat functionality is not fully implemented; UI for group chat on the home page needs completion.
- Real-time functionality relies on AJAX with set intervals; WebSocket implementation could improve efficiency.

---

## Future Enhancements
- Complete the group chat UI and functionality.
- Integrate WebSocket for true real-time messaging.
- Add typing indicators and message read receipts.
- Improve UI/UX using modern frontend frameworks (e.g., React or Vue.js).
- Enhance admin reports with more detailed analytics.

---

## Author
**Nikul Suthar** -> [Nikulsuthar2](https://github.com/Nikulsuthar2)

---
## Screenshots

![index]()

![signup]()

![login]()

![home]()

![profile]()

![chat]()

![search]()

![block]()

![index]()

![index]()

![index]()