create schema event;
USE event;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(255),
    address VARCHAR(255),
    city VARCHAR(255),
    state VARCHAR(255),
    zip_code VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user'
);

CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    start_date DATE,
    end_date DATE,
    location VARCHAR(255),
    capacity INT,
    user_id INT,
    link VARCHAR(255) DEFAULT '',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE event_registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (event_id) REFERENCES events(event_id)
);

-- Insert Admin User
INSERT INTO users (name, email, phone, address, city, state, zip_code, password, role) 
VALUES ('admin', 'admin@admin.com', '555-1234', '1234 Street', 'City', 'State', 'Zip', '$2y$10$tWhKIID95xVyg1bD/usygOvRmov7QoT36.KiXET9g8u2ne9tENSq.', 'admin');

-- Populate Events
INSERT INTO events (name, start_date, end_date, location, capacity, user_id) VALUES
('Teknologi Blockchain', '2024-04-01', '2024-04-01', 'Auditorium Universitas ABC', 100, NULL),
('Pengembangan Web Modern', '2024-04-15', '2024-04-15', 'Online', 100, NULL),
('AI dan Machine Learning', '2024-06-15', '2024-06-15', 'Online', 100, NULL),
('Pengolahan Citra', '2024-07-20', '2024-07-20', 'Auditorium Universitas ABC', 100, NULL);

