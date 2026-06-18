CREATE DATABASE university_lms;
USE university_lms;

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- STUDENTS
-- =========================
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    university_no VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    level INT,
    department VARCHAR(100),

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

-- =========================
-- COURSES
-- =========================
CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    semester VARCHAR(50),
    doctor_name VARCHAR(100)
);

-- =========================
-- STUDENT COURSES
-- =========================
CREATE TABLE student_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,

    FOREIGN KEY (student_id)
    REFERENCES students(student_id)
    ON DELETE CASCADE,

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- MATERIALS
-- =========================
CREATE TABLE materials (
    material_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- ASSIGNMENTS
-- =========================
CREATE TABLE assignments (
    assignment_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATETIME,
    file_path VARCHAR(255),

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- GRADES
-- =========================
CREATE TABLE grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    grade DECIMAL(5,2),

    FOREIGN KEY (student_id)
    REFERENCES students(student_id)
    ON DELETE CASCADE,

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- ATTENDANCE
-- =========================
CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    absence_count INT DEFAULT 0,
    warning_status BOOLEAN DEFAULT FALSE,

    FOREIGN KEY (student_id)
    REFERENCES students(student_id)
    ON DELETE CASCADE,

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- TIMETABLE
-- =========================
CREATE TABLE timetable (
    timetable_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    day_name VARCHAR(20),
    start_time TIME,
    end_time TIME,
    room VARCHAR(50),

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- PROJECTS
-- =========================
CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATETIME,

    FOREIGN KEY (course_id)
    REFERENCES courses(course_id)
    ON DELETE CASCADE
);

-- =========================
-- TRAININGS
-- =========================
CREATE TABLE trainings (
    training_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE
);

-- =========================
-- NEWS
-- =========================
CREATE TABLE news (
    news_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);