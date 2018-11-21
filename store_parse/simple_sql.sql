CREATE DATABASE storog;
USE storog;

CREATE TABLE games (
	id int NOT NULL AUTO_INCREMENT,
	title text NOT NULL,
	steam_id int,
	on_gog BOOLEAN NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE users (
	id int NOT NULL,
	username varchar(64) NOT NULL,
	password varchar(255) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE user_games (
	id int NOT NULL,
	title text NOT NULL,
	user_id int NOT NULL,
	game_id int,
	price decimal(6,2) NOT NULL,
	upload_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (game_id) REFERENCES games(id)
);

CREATE TABLE user_votes (
	liker_id int NOT NULL,
	liked_id int NOT NULL,
	PRIMARY KEY(liker_id, liked_id),
	FOREIGN KEY(liker_id) REFERENCES users(id),
	FOREIGN KEY(liked_id) REFERENCES users(id)
);

CREATE TABLE comments (
	id int NOT NULL AUTO_INCREMENT,
	content text NOT NULL,
	date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	profile_id int NOT NULL,
	poster_id int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(profile_id) REFERENCES users(id),
	FOREIGN KEY(poster_id) REFERENCES users(id)
);