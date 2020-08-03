-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2020 at 08:03 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `name` varchar(30) NOT NULL COMMENT 'name of admin',
  `email` varchar(50) NOT NULL COMMENT 'email of admin',
  `mobile` bigint(10) NOT NULL COMMENT 'mobile of admin',
  `password` varchar(20) NOT NULL COMMENT 'password of admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `product_id` int(1) NOT NULL COMMENT 'order id of customer',
  `order_id` varchar(30) NOT NULL DEFAULT '' COMMENT 'order_id of product',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 means purchased 0 means not',
  `useremail` varchar(50) NOT NULL COMMENT 'order of customer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forget`
--

CREATE TABLE `forget` (
  `email` varchar(50) NOT NULL COMMENT 'email id of user',
  `Q1` varchar(50) NOT NULL COMMENT 'answer of 1st question',
  `Q2` varchar(50) NOT NULL COMMENT 'answer of 2nd question',
  `Q3` varchar(50) NOT NULL COMMENT 'answer of 3rd question',
  `Q4` varchar(50) NOT NULL COMMENT 'answer of 4th question'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL COMMENT 'product id',
  `product_name` varchar(30) NOT NULL COMMENT 'product name',
  `discription` varchar(1000) NOT NULL COMMENT 'discription of product',
  `image` varchar(30) NOT NULL COMMENT 'image of product',
  `price` decimal(10,0) NOT NULL COMMENT 'price of product',
  `type` varchar(15) NOT NULL COMMENT 'electric or non-electric',
  `useremail` varchar(20) NOT NULL COMMENT 'user name who upload the product',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT 'status of the product'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `name` varchar(30) NOT NULL COMMENT 'team member name',
  `email` varchar(50) NOT NULL COMMENT 'team member email',
  `mobile` varchar(10) NOT NULL COMMENT 'team member mobile',
  `address` varchar(100) NOT NULL COMMENT 'team member address'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `name` varchar(30) NOT NULL COMMENT 'name of user',
  `email` varchar(50) NOT NULL COMMENT 'email of user',
  `mobile` bigint(10) NOT NULL COMMENT 'mobile number of user',
  `password` varchar(20) NOT NULL COMMENT 'password of user',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT 'address of user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `forget`
--
ALTER TABLE `forget`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
