CREATE TABLE user_type (
	user_type_id INT NOT NULL PRIMARY KEY,
	user_type VARCHAR(255)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE users (
	user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_type_id INT,
	FOREIGN KEY (user_type_id) REFERENCES user_type (user_type_id),
	login_name VARCHAR(255) NOT NULL,
	view_name VARCHAR(255),
	email VARCHAR(255) NOT NULL,
	homepage VARCHAR(255),
	passwd CHAR(32),
	UNIQUE (email, login_name)
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


CREATE TABLE posts (
	    post_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	    
user_id INT,
FOREIGN KEY (user_id) REFERENCES users (user_id),
	    user_text TEXT,
	    user_ip VARCHAR(255),
	    user_browser VARCHAR(255),
	    post_date DATE NOT NULL,
	    pic_id INT
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE user_pictures (
	    pic_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	    picture MEDIUMBLOB
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;
