-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql-app: 3306
-- Generation Time: May 09, 2020 at 04:18 AM
-- Server version: 5.7.29
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social-media`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user1` int(11) DEFAULT NULL,
  `user2` int(11) DEFAULT NULL,
  `chat` longtext,
  `msgcount` int(11) NOT NULL DEFAULT '0',
  `new` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user1`, `user2`, `chat`, `msgcount`, `new`) VALUES
(8, 1, 5, 'jane_doe: hey what are you doing tomorrow?%%%jenniech: nothing, you?%%%jane_doe: im going to visit my mom for mothers day%%%jane_doe: do you wanna hang after?%%%', 4, 0),
(9, 1, 2, NULL, 0, 0),
(10, 5, 2, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `numposts`
--

CREATE TABLE `numposts` (
  `id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '7'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `numposts`
--

INSERT INTO `numposts` (`id`, `num`) VALUES
(1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `caption` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `comments` text,
  `numcomments` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `caption`, `user_id`, `image`, `likes`, `comments`, `numcomments`) VALUES
(1, 'this is cool!', 1, 'public/pasta.jpg', 3, 'jane_doe: love,   jenniech: post more content!', 2),
(7, 'cooking :)', 3, 'public/NCI_Visuals_Food_Hot_Dog.jpg', 1, '', 0),
(8, 'fooood', 2, 'public/mouse.jpg', 1, '', 0),
(9, 'more food', 2, 'public/food-salad-healthy-lunch.jpg', 0, 'jane_doe: mmmm', 1),
(10, 'mmm', 2, 'public/food-dinner-lunch-unhealthy-70497.jpg', 0, '', 0),
(11, 'more food', 2, 'public/before.jpg', 1, 'jane_doe: Nice!', 1),
(12, 'lunch!', 2, 'public/food-salad-healthy-lunch.jpg', 1, '', 0),
(13, 'hey!', 6, 'public/top-view-photo-of-food-dessert-1099680.jpg', 0, '', 0),
(14, 'PIZZA!', 6, 'public/SSP_3739_preview.jpeg.jpg', 1, '', 0),
(15, 'burger night!', 6, 'public/food-dinner-lunch-unhealthy-70497.jpg', 1, '', 0),
(16, 'yum! first post!', 5, 'public/pexels-photo-704569.jpeg', 1, 'jenniech: &lt;button&gt;hi&lt;/button&gt;', 1),
(17, 'look at this spread!', 2, 'public/photo-1498837167922-ddd27525d352 (1).jpg', 1, 'jane_doe: nice!', 1),
(18, 'dinner!', 5, 'public/photo-1521354414378-fcffad1d3d6a.jpg', 1, 'jenniech: hi', 1),
(19, 'love', 5, 'public/photo-1467453678174-768ec283a940.jpg', 2, 'jane_doe: awesome!', 1),
(20, 'yummmm', 5, 'public/photo-1528216142275-f64d7a59d8d5.jpg', 1, '', 0),
(21, 'i love pizza', 7, 'public/SSP_3739_preview.jpeg.jpg', 0, 'jenniech: yummy!', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `following` varchar(250) DEFAULT NULL,
  `user_image` varchar(50) DEFAULT NULL,
  `likedposts` text,
  `convos` int(11) NOT NULL DEFAULT '0',
  `newmsg` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `following`, `user_image`, `likedposts`, `convos`, `newmsg`) VALUES
(1, 'jane_doe', 'jenniech@buffalo.edu', '$2y$09$vRWOVnHWckdf4jubLEbY9OWSRlGBXT5rDew0Y.0Hg73iR9nVlje6i', ',2,3,6,5,2,2,5,5,7', 'public/guyfieri.jpg', '8,8,8,8,8,8,8,8,8,8,8,8,8,8,13,13,9,9,15,1,1,15,15,1,1,8,8,8,11,14,17,17,19,17,17,17,1,1,20,20,20,1,20,', 2, 0),
(2, 'fake_user', 'jechepenuk@gmail.com', '$2y$09$.2lzGXCwQwVIz8TMyI40DunuH0ORp5oxUsovclCzFrrwl84C4FTBi', ',1,3', 'public/intro-1573597941.jpg', NULL, 0, 0),
(3, 'guy_fieri', 'gfieri@gmail.com', '$2y$09$5fPIoARbiJHT.9pb7evo.ugXbCfKvSYbPpMwnLrm5mi9fxWmWEg8y', NULL, NULL, NULL, 0, 0),
(5, 'jenniech', 'jenniech@gmail.com', '$2y$09$XKO6i//VMHVjAq6.ePhSSuUaE9XpQxtJvVVqOYZe2XC.f7L8yoQSW', '1,1,1,1,1,1,2,2,2,1,2,2', 'public/79b4be6b0207b4c9d709f67f928fc436.jpg', '16,19,19,19,18,20,20,20,20,20,20,20,', 2, 1),
(6, 'cardib', 'cardib@gmail.com', '$2y$09$v5JH8qYl1GAOuxhwozj2cO4Z6JUmyl53Efv2.EbzVahYS9eX2DCia', ',2,1', NULL, '1,1,1,', 0, 0),
(7, 'egg', 'egg@gmail.com', '$2y$09$Rm5IZaMl3RlEGUEkW4dLLuKoaOUqw4NlGDEePFeXZkxtbiorRUQmm', ',2,2,2,3', 'public/mouse.jpg', NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `numposts`
--
ALTER TABLE `numposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `numposts`
--
ALTER TABLE `numposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
