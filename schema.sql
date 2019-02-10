CREATE TABLE category (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR,
id_lot INT
);

CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
name CHAR,
description TEXT,
picture CHAR,
start_price INT,
date_close TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
step_bet INT,
id_user INT,
user_win INT,
id_category INT
);

CREATE TABLE bets (
id INT AUTO_INCREMENT PRIMARY KEY,
date_bet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
price_buy INT,
id_user INT,
id_lot INT
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
email CHAR(128) NOT NULL UNIQUE,
name CHAR,
password CHAR(64),
avatar CHAR,
contact CHAR,
date_lot_creat TIMESTAMP,
id_bet INT
);
