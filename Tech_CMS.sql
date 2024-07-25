-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 25, 2024 at 02:13 PM
-- Server version: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Tech_CMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(1000) NOT NULL,
  `blog_description` varchar(5000) NOT NULL,
  `blog_image` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `published_status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `blog_title`, `blog_description`, `blog_image`, `category_id`, `user_id`, `published_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'learn about js', 'Welcome to our JavaScript blog, where we dive deep into the heart of web development! Whether you\'re a seasoned developer or just starting out, our blog covers everything from foundational concepts to the latest advancements in JavaScript. Explore topics such as ES6+ features, asynchronous programming, and popular frameworks like React and Node.js. Join us as we demystify JavaScript and equip you with the knowledge to build dynamic, high-performance web applications. Stay tuned for tutorials, tips, and industry insights that will help you stay ahead in the ever-evolving world of JavaScript.\"', 'JavaScript_in_Web_Development.jpg', 3, 2, '1', '2024-07-19 08:01:48', '2024-07-22 09:42:57', '0000-00-00 00:00:00'),
(2, 'Understanding the Basics of HTML', 'Hypertext Markup Language (HTML) is the standard language used to create and design documents on the World Wide Web. Developed by Tim Berners-Lee in the late 1980s, HTML provides the structure of a webpage, allowing text, images, and other elements to be displayed in a browser. At its core, HTML consists of a series of elements, which you can use to enclose or wrap different parts of the content to make it appear or act in a certain way.\r\n\r\nHTML elements are the building blocks of HTML pages. ', 'HTML-Full-Form.jpg', 1, 2, '1', '2024-07-21 13:24:19', '2024-07-22 09:43:10', '0000-00-00 00:00:00'),
(3, 'Mastering CSS: Tips, Tricks', 'Dive into the world of CSS with our comprehensive blog that covers everything from the basics to advanced techniques. Whether you\'re a beginner looking to understand the fundamentals or a seasoned developer seeking to refine your skills, this blog offers valuable insights and practical advice on styling your web projects. Learn how to create stunning layouts, optimize responsive designs, and harness the power of modern CSS features like Grid, Flexbox, and custom properties. With step-by-step tutorial.', 'sta-je-css.png', 2, 2, '1', '2024-07-21 14:10:19', '2024-07-23 07:48:39', '0000-00-00 00:00:00'),
(9, 'js', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'i.jpeg', 3, 2, '0', '2024-07-22 04:58:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'python', 'pppppppppppppppppppppppppppppp', 'download.jpeg', 5, 2, '0', '2024-07-22 05:00:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'learned about php', 'php aaaaaaaaaaaaa', 'Screenshot from 2024-07-12 17-45-31.png', 4, 2, '0', '2024-07-22 05:02:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'js', 'bbbbbbbbbbbbbbbbbbbb', 'mainbg.jpeg', 3, 2, '0', '2024-07-22 05:04:24', '0000-00-00 00:00:00', '2024-07-22 06:02:06'),
(13, 'fffff', 'gggggggggggggggggggggggggg', 'image.jpeg', 1, 2, '0', '2024-07-22 05:05:33', '0000-00-00 00:00:00', '2024-07-22 06:01:10'),
(14, 'Unlocking  Power of Python', 'Python has taken the programming world by storm, and for good reason. It\'s versatile, powerful, and easy to learn. Whether you\'re a complete beginner or an experienced coder looking to expand your skills, Python offers something for everyone. In this blog post, we\'ll explore what makes Python so special, how to get started with it, and some of the exciting things you can do once you\'ve mastered the basics.', 'Python-programming-india.jpg', 5, 1, '1', '2024-07-22 06:54:35', '2024-07-23 09:45:59', '0000-00-00 00:00:00'),
(15, 'js', 'jsssssssssssssssssssssss', 'u2.jpg', 3, 1, '0', '2024-07-22 07:07:04', '2024-07-22 07:07:50', '2024-07-22 07:08:40'),
(16, 'Unlocking the Power of PHP', 'PHP, or Hypertext Preprocessor, is a widely-used open-source scripting language suited for web development. Known for its efficiency in server-side scripting, PHP powers millions of websites and applications. Whether you\'re new to PHP or looking to sharpen your skills, this guide will walk you through everything you need to know, from the basics to advanced techniques.', 'php-programming-language.jpg', 4, 4, '1', '2024-07-22 07:12:59', '2024-07-24 08:06:54', '0000-00-00 00:00:00'),
(17, 'JavaScript Insights', '\"Dive into the world of JavaScript with our comprehensive blog dedicated to all things JS! From beginner tutorials to advanced techniques, we cover the full spectrum of JavaScript programming. Stay updated with the latest trends, explore in-depth guides on frameworks like React, Angular, and Vue, and learn best practices for writing clean, efficient code. Whether you\'re building your first web app or enhancing an existing project, our blog offers the resources and inspiration you need to master JavaScript and elevate your web development skills. Join our community of developers and start your journey to becoming a JavaScript expert today.\"\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'images (1).jpeg', 3, 5, '1', '2024-07-23 05:36:04', '2024-07-25 06:18:59', '0000-00-00 00:00:00'),
(18, 'JavaScript Insights: Navigating the Future of Web Development', '\"Dive into the world of JavaScript with our comprehensive blog dedicated to all things JS! From beginner tutorials to advanced techniques, we cover the full spectrum of JavaScript programming. Stay updated with the latest trends, explore in-depth guides on frameworks like React, Angular, and Vue, and learn best practices for writing clean, efficient code. Whether you\'re building your first web app or enhancing an existing project, our blog offers the resources and inspiration you need to master JavaScript and elevate your web development skills. Join our community of developers and start your journey to becoming a JavaScript expert today.\"\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'images (1).jpeg', 3, 5, '1', '2024-07-23 05:37:11', '0000-00-00 00:00:00', '2024-07-23 05:42:22'),
(19, 'Python Chronicles: Unlocking the Power of Versatile Programming', '\"Welcome to Python Chronicles, your go-to source for all things Python! Whether you\'re a novice coder or an experienced developer, our blog is designed to help you harness the full potential of Python. Discover in-depth tutorials, explore the latest libraries and frameworks, and learn best practices for writing clean, efficient code. From data science and machine learning to web development and automation, we cover a wide range of topics to cater to your interests and needs. Stay informed with industry insights, coding tips, and project ideas that will inspire you to take your Python skills to the next level.\"', 'images (2).jpeg', 5, 5, '1', '2024-07-23 05:40:16', '2024-07-23 06:07:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'HTML', '2024-07-19 10:53:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'CSS', '2024-07-19 11:22:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'JavaScript', '2024-07-19 11:24:08', '2024-07-19 11:37:32', '0000-00-00 00:00:00'),
(4, 'PHP', '2024-07-19 11:26:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Python', '2024-07-19 11:26:55', '2024-07-19 11:36:07', '0000-00-00 00:00:00'),
(6, 'NET', '2024-07-19 11:44:25', '2024-07-19 11:44:32', '2024-07-19 11:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `role` enum('Admin','Author') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `email`, `password`, `profile`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Anjali ', 'anjalia@svaapta.com', '872f4efa9f7985a25eb96b0b35132ec9', 'png-transparent-female-avatar-girl-face-woman-user-flat-classy-users-icon.png', 'Author', '2024-07-19 10:37:09', '2024-07-24 08:03:17', '0000-00-00 00:00:00'),
(2, 'Anjali Agrawal', 'agrawalanjali8743@gmail.com', 'e6e061838856bf47e1de730719fb2609', 'download.jpeg', 'Admin', '2024-07-19 10:38:06', '2024-07-23 10:16:58', '0000-00-00 00:00:00'),
(3, 'karishma', 'karu@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'i.jpeg', 'Author', '2024-07-19 13:22:46', '0000-00-00 00:00:00', '2024-07-22 08:08:23'),
(4, 'Shaily Shah', 'shaily@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'user.jpeg', 'Author', '2024-07-22 06:10:41', '2024-07-22 07:14:33', '0000-00-00 00:00:00'),
(5, 'Jaynil Pandya', 'jainilpandya001@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'u1.jpg', 'Author', '2024-07-22 13:20:25', '2024-07-23 05:30:49', '0000-00-00 00:00:00'),
(6, 'Shivangi', 'shivangini9898@gmail.com', 'b4cfcb5848d9c1e9e4e671b3025f67ab', 'view.jpeg', 'Author', '2024-07-23 11:20:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
