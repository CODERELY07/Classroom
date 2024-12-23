-- Users Table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Teacher', 'Student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Classes Table
CREATE TABLE Classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    section VARCHAR(255) NULL,
    subject VARCHAR(255) NULL,
    class_code VARCHAR(8) NULL,
    description TEXT,
    teacher_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES Users(id)
);

-- Class Members Table
CREATE TABLE Class_Members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('Teacher Assistant', 'Student') NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- Assignments Table
CREATE TABLE Assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id)
);

-- Submissions Table
CREATE TABLE Submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT NOT NULL,
    student_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    grade DECIMAL(5, 2),
    feedback TEXT,
    FOREIGN KEY (assignment_id) REFERENCES Assignments(id),
    FOREIGN KEY (student_id) REFERENCES Users(id)
);

-- Announcements Table
CREATE TABLE Announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id)
);

-- Comments Table
CREATE TABLE Comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    assignment_id INT,
    announcement_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (assignment_id) REFERENCES Assignments(id),
    FOREIGN KEY (announcement_id) REFERENCES Announcements(id)
);

-- Resources Table
CREATE TABLE Resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    resource_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id)
);

-- Notifications Table
CREATE TABLE Notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('New Assignment', 'Graded Submission', 'Class Update') NOT NULL,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- Attendance Table
CREATE TABLE Attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    student_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('Present', 'Absent') NOT NULL,
    FOREIGN KEY (class_id) REFERENCES Classes(id),
    FOREIGN KEY (student_id) REFERENCES Users(id)
);

-- Calendar Table
CREATE TABLE Calendar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    event_title VARCHAR(255) NOT NULL,
    event_description TEXT,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id)
);

-- Groups Table
CREATE TABLE Groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    group_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id)
);

-- Group Members Table
CREATE TABLE Group_Members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('Leader', 'Member') NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES Groups(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- Quizzes Table
CREATE TABLE Quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES Classes(id)
);

-- Quiz Questions Table
CREATE TABLE Quiz_Questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    question_type ENUM('Multiple Choice', 'True/False') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES Quizzes(id)
);

-- Question Options Table
CREATE TABLE Question_Options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    option_text TEXT NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (question_id) REFERENCES Quiz_Questions(id)
);

-- Quiz Responses Table
CREATE TABLE Quiz_Responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    student_id INT NOT NULL,
    score DECIMAL(5, 2),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES Quizzes(id),
    FOREIGN KEY (student_id) REFERENCES Users(id)
);
