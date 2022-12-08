
DROP TABLE IF EXISTS user;DROP TABLE IF EXISTS userdata;
CREATE TABLE userdata(
id INT(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(255) NOT NULL,
lastname VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
changeurl VARCHAR(255) NOT NULL,
status ENUM('0','1') NOT NULL DEFAULT '0'
);
