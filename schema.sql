CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE category (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR(128),
id_lot INT
);

CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
name CHAR(128),
description TEXT,
picture TEXT,
start_price INT,
date_close TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
step_bet INT,
id_user INT,
user_win INT,
id_category INT
);

CREATE INDEX n_lots ON lots(name);

CREATE TABLE bets (
id INT AUTO_INCREMENT PRIMARY KEY,
date_place TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
price_buy INT,
id_user INT,
id_lot INT
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
email CHAR(128) NOT NULL UNIQUE,
name TEXT,
password CHAR(64),
avatar TEXT,
contact TEXT
);
