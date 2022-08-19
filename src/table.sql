
DROP TABLE IF EXISTS user;

CREATE TABLE user (
id INT(15) NOT NULL UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(255) NOT NULL,
lastname VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
activationurl VARCHAR(255) NOT NULL,
status ENUM('0','1') NOT NULL
);
