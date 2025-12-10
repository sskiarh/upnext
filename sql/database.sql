CREATE DATABASE IF NOT EXISTS upnext;
USE upnext;

-- tabel user untuk login
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    no_telp VARCHAR(20),
    email VARCHAR(100),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- tabel events untuk data event di web
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    poster VARCHAR(255),             
    deskripsi TEXT NOT NULL,
    benefit TEXT,
    register_link VARCHAR(255),
    detail_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- tabel bookmark untuk fitur simpan event
CREATE TABLE bookmarks (
    id_bookmark INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_event INT
);
