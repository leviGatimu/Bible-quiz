
# 📖 Bible Insights Academy: Online Assessment System

A professional, full-stack **Online Examination Platform** built to test Biblical knowledge through a structured, high-stakes assessment environment. This system is specifically designed for students to track performance across various difficulty levels while maintaining academic integrity.



---

## ✨ Key Features

* **Three Difficulty Tiers**: Automatically scales the exam length and complexity based on selection:
    * **Easy**: 20 Questions.
    * **Medium**: 10 Questions.
    * **Hard**: 5 Questions.
* **Strict Assessment Mode**: No instant feedback is provided during the test to simulate a real-world examination environment.
* **Live Leaderboard**: A real-time ranking system that displays the top 10 scholars based on their marks and difficulty level.
* **Modern UI**: A clean, academic design utilizing CSS variables, smooth transitions, and a mobile-responsive layout.
* **Full-Stack Architecture**: Built using a robust PHP backend and MySQL for persistent data storage.
* **Advanced Logic**: Questions are pulled randomly from a diverse database to ensure every test attempt is unique.

---

## 📂 Project Structure



```
BIBLE-GAMES-APP/
│
├── api/                   
│   ├── db_config.php      # Secure PDO database connection
│   ├── get_questions.php  # Fetches randomized questions based on level
│   └── save_score.php     # Records student marks to the MySQL database
│
├── index.php              # Main Exam Portal (Name entry & Test logic)
├── leaderboard.php        # Real-time ranking and scholar display
└── database.sql           # SQL script for 50+ questions and score tables
```
🚀 Getting Started
1. Prerequisites
Install XAMPP or WAMP.

Ensure Apache and MySQL services are active in your control panel.

2. Database Setup
Open phpMyAdmin (http://localhost/phpmyadmin).

Create a new database named bible_games.

Import the provided database.sql file to populate the 50 questions and the scores table.

3. Installation
Move the BIBLE-GAMES-APP folder into your server's root directory (e.g., C:/xampp/htdocs/).

Access the application via: http://localhost/BIBLE-GAMES-APP/index.php.

⚙️ Technical Specifications
Backend: PHP 8.x with PDO (PHP Data Objects) for secure, prepared database queries.

Frontend: Vanilla JavaScript (ES6+), HTML5, and CSS3.

Database: MySQL.

Security: Implements strict SQL injection prevention and input sanitization.

🎓 About the Developer
Developed by Levi Gatimu Ngugi, a student at New Generation Academy, Kenya. This project showcases advanced proficiency in full-stack web development, database architecture, and academic UI/UX design.
