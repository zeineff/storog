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
	profile_id int NOT NULL,
	user_id int NOT NULL,
	content text NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(profile_id) REFERENCES users(id),
	FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE user_votes (
	liker_id int NOT NULL,
	liked_id int NOT NULL,
	PRIMARY KEY(liker_id, liked_id), 
	FOREIGN KEY(liker_id) REFERENCES users(id),
	FOREIGN KEY(liked_id) REFERENCES users(id)
);

INSERT INTO users (username, password) VALUES (asdf, $2y$10$W.YSfjNTBGPDs1XpWFoAQ.QqgsxLqy89pf/GuxfHLNSVEn11Q.L86);
INSERT INTO users (username, password) VALUES (qwer, $2y$10$mpD.9G8HSCz1MzV612Qb.uLgCUfqVp9mixr4FG6kMIRR5h61R8XZS);
INSERT INTO users (username, password) VALUES (zxcv, $2y$10$bScT1VuGjwLKUn4BLK1kuO5Zsx4682vjUs2hBtsinzUk2hqXsJMn.);

INSERT INTO comments (profile_id, user_id, content) VALUES (1, 2, "The quick brown fox jumps over the lazy dog.");
INSERT INTO comments (profile_id, user_id, content) VALUES (1, 3, "Lorem Ipsum.");
INSERT INTO comments (profile_id, user_id, content) VALUES (2, 1, "Qwertyuiop");

CREATE VIEW view_comments AS
SELECT c.id AS comment_id, c.profile_id, c.user_id AS poster_id, u.username AS poster, c.content
FROM users u, comments c
WHERE c.user_id = u.id
GROUP BY comment_id;