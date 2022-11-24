SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `school` (
  `id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT 'school of IT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `school`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
  
INSERT INTO `school` (`name`) VALUES ('School of Engineering');
INSERT INTO `school` (`name`) VALUES ('School of Technology');
INSERT INTO `school` (`name`) VALUES ('SLTC Business School');
INSERT INTO `school` (`name`) VALUES ('School of IT & Computing');
INSERT INTO `school` (`name`) VALUES ('School of Music');
