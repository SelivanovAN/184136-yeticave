INSERT INTO category (name,id_lot) VALUES ("доски и лыжи", 1);
INSERT INTO category (name,id_lot) VALUES ("крепления", 2);
INSERT INTO category (name,id_lot) VALUES ("ботинки", 3);
INSERT INTO category (name,id_lot) VALUES ("одежда", 4);
INSERT INTO category (name,id_lot) VALUES ("инструменты", 5);
INSERT INTO category (name,id_lot) VALUES ("разное", 6);

INSERT INTO users (email, name, password, avatar, contact) VALUES ("alex@mail.ru", "Alex", 123, "pusto", "Moscow");
INSERT INTO users (email, name, password, avatar, contact) VALUES ("oleg@mail.ru", "Oleg", 1234, "pusto", "Piter");

INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES ("2019-01-01 01:01:00", "Snowboard", "2014 Rossignol District Snowboard", "img/lot-1.jpg", 10999, "2019-06-06 01:01:00", 100, 1, 1, 1);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES ("2019-02-03 01:01:00", "Snowboard", "DC Ply Mens 2016/2017 Snowboard", "img/lot-2.jpg", 159999, "2019-08-08 01:01:00", 100, 1, 1, 1);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES ("2019-02-10 01:01:00", "Mounts", "Крепления Union Contact Pro 2015 года размер L/XL", "img/lot-3.jpg", 8000, NULL, 100, 1, 1, 2);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES ("2019-02-10 01:01:00", "Boots", "Ботинки для сноуборда DC Mutiny Charocal", "img/lot-4.jpg", 10999, NULL, 100, 1, 1, 3);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES ("2019-02-09 01:01:00", "Jacket", "Куртка для сноуборда DC Mutiny Charocal", "img/lot-5.jpg", 7500, NULL, 100, 1, 1, 4);
INSERT INTO lots (date_create, name, description, picture, start_price, date_close, step_bet, id_user, user_win, id_category)
 VALUES ("2018-01-01 01:01:00", "Mask", "Маска Oakley Canopy", "img/lot-6.jpg", 5400, "2019-07-07 01:01:00", 100, 1, 1, 6);

INSERT INTO bets (date_place, price_buy, id_user, id_lot) VALUES ("2019-06-06 01:01:00", 15500, 1, 1);
INSERT INTO bets (date_place, price_buy, id_user, id_lot) VALUES ("2019-08-08 01:01:00", 200500, 1, 2);
INSERT INTO bets (date_place, price_buy, id_user, id_lot) VALUES ("2019-02-10 01:01:00", 9500, 1, 3);
INSERT INTO bets (date_place, price_buy, id_user, id_lot) VALUES ("2019-02-10 01:01:00", 15500, 2, 4);
INSERT INTO bets (date_place, price_buy, id_user, id_lot) VALUES ("2019-02-09 01:01:00", 10500, 2, 5);
INSERT INTO bets (date_place, price_buy, id_user, id_lot) VALUES ("2019-07-07 01:01:00", 6500, 2, 6);

SELECT * FROM category ORDER BY name ASC;
SELECT l.id, l.name, l.start_price, l.picture, b.price_buy, c.name, l.date_create, l.date_close FROM lots l JOIN category c ON l.id_category = c.id_lot JOIN bets b ON l.id = b.id_lot ORDER BY l.date_create DESC;
SELECT l.id, c.name FROM lots l JOIN category c ON l.id_category = c.id_lot;
UPDATE lots SET name = "Snowboard-test" WHERE id = 1;
SELECT b.id, b.date_place, l.name FROM bets b JOIN lots l ON l.id = b.id_lot ORDER BY b.date_place DESC;
