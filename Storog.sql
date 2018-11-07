CREATE DATABASE storog;
USE storog;

CREATE TABLE games (
	id int NOT NULL AUTO_INCREMENT,
	title varchar(255) NOT NULL,
	steam_id int,
	PRIMARY KEY(id)
);

CREATE TABLE users (
	id int NOT NULL AUTO_INCREMENT,
	username varchar(64) NOT NULL,
	password varchar(255) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE user_games (
	id int NOT NULL AUTO_INCREMENT,
	user_id int NOT NULL,
	game_id int,
	title varchar(255) NOT NULL,
	price float(24) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(game_id) REFERENCES games(id)
);

CREATE TABLE comments (
	id int NOT NULL AUTO_INCREMENT,
	user_id int NOT NULL,
	content text NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id)
);