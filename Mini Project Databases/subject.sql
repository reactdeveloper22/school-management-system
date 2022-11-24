SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `subject` (
  `id` int(100) NOT NULL,
  `school` varchar(200) NOT NULL DEFAULT 'school of IT',
  `degree` varchar(300) NOT NULL,
  `payment` INT(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `subject`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;