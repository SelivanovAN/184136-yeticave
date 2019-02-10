INSERT INTO category (name,id_lot) VALUES ("доски и лыжи", 1);
INSERT INTO category (name,id_lot) VALUES ("крепления", 2);
INSERT INTO category (name,id_lot) VALUES ("ботинки", 3);
INSERT INTO category (name,id_lot) VALUES ("одежда", 4);
INSERT INTO category (name,id_lot) VALUES ("инструменты", 5);
INSERT INTO category (name,id_lot) VALUES ("разное", 6);

INSERT INTO users (email, name, password, avatar, contact) VALUES ("alex@mail.ru", "Alex", 123, "pusto", "Moscow");
INSERT INTO users (email, name, password, avatar, contact) VALUES ("oleg@mail.ru", "Oleg", 1234, "pusto", "Piter");

INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES (date_create, "Helmet", "2014 Rossignol District Snowboard", "img/lot-1.jpg", 10999, date_close, 100, 1, 1, 1);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES (date_create, "Helmet", "DC Ply Mens 2016/2017 Snowboard", "img/lot-2.jpg", 159999, date_close, 100, 1, 1, 1);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES (date_create, "Helmet", "Крепления Union Contact Pro 2015 года размер L/XL", "img/lot-3.jpg", 8000, date_close, 100, 1, 1, 2);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES (date_create, "Helmet", "Ботинки для сноуборда DC Mutiny Charocal", "img/lot-4.jpg", 10999, date_close, 100, 1, 1, 3);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES (date_create, "Helmet", "Куртка для сноуборда DC Mutiny Charocal", "img/lot-5.jpg", 7500, date_close, 100, 1, 1, 4);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES (date_create, "Helmet", "Маска Oakley Canopy", "img/lot-6.jpg", 5400, date_close, 100, 1, 1, 6);

INSERT INTO bets (date_bet, price_buy, id_user, id_lot) VALUES (date_bet, 15500, 1, 1);
INSERT INTO bets (date_bet, price_buy, id_user, id_lot) VALUES (date_bet, 200500, 1, 2);
INSERT INTO bets (date_bet, price_buy, id_user, id_lot) VALUES (date_bet, 9500, 1, 3);
INSERT INTO bets (date_bet, price_buy, id_user, id_lot) VALUES (date_bet, 15500, 2, 4);
INSERT INTO bets (date_bet, price_buy, id_user, id_lot) VALUES (date_bet, 10500, 2, 5);
INSERT INTO bets (date_bet, price_buy, id_user, id_lot) VALUES (date_bet, 6500, 2, 6);
