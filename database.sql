CREATE DATABASE IF NOT EXISTS upnext;
USE upnext;

-- tabel user untuk login
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255)
);

-- tabel events untuk data event di web
CREATE TABLE events (
    id_event INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200),
    kategori VARCHAR(100),
    deskripsi TEXT,
    tanggal DATE,
    poster VARCHAR(255),
    pdf_file VARCHAR(255)
);

-- tabel bookmark untuk fitur simpan event
CREATE TABLE bookmarks (
    id_bookmark INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_event INT
);
