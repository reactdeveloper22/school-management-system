SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `teacher` (
  `id` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `age` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dateOfbirth` DATE NOT NULL,
  `home` int(20) NOT NULL,
  `mobile` int(20) NOT NULL,
  `gender` varchar(20) NOT NULL DEFAULT 'male',
  `idNum` int(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postal` int(20) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `teacher`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;