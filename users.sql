CREATE TABLE 'users'(
    'id' int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    'firstname' varchar(30) NOT NULL,
    'lastname' varchar(30) NOT NULL,
    'email' varchar(255) NOT NULL,
    'username' varchar(30) NOT NULL,
    'password' varchar(30) NOT NULL,
    'country' char(2) NOT NULL,
    'date' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    'archive' enum('Y', 'N') NOT NULL DEFAULT 'Y'
);