SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE news (
  id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  title varchar(255) NOT NULL,
  description text NOT NULL,
  picture varchar(255) NOT NULL,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  archive enum('N','Y') NOT NULL DEFAULT 'N'
);
