-- Database: `grocery`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `cart`

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `cart`

INSERT INTO `cart` (`id`, `uid`, `pid`, `quantity`) VALUES
(11, 2, 12, 0),
(12, 0, 46, 0),
(15, 43, 47, 0),
(19, 42, 54, 0),
(20, 42, 53, 0),
(21, 0, 47, 0),
(22, 0, 99, 0),
(23, 46, 81, 0);



-- Table structure for table `orders`

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `oplace` text NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `dstatus` varchar(10) NOT NULL DEFAULT 'no',
  `odate` date NOT NULL,
  `ddate` date NOT NULL,
  `delivery` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table structure for table `products`
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `item` varchar(100) NOT NULL,
  `picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `name`, `price`, `item`, `picture`) VALUES

(1, 'Peas', 7, 'cans', 'peas.png'),
(2, 'Tuna', 5, 'cans', 'tuna.png'),

(3, 'Chips', 3, 'snacks', 'chips.png'),
(4, 'Dount', 5, 'snacks', 'dount.png'),

(5, 'Small Candy', 1, 'sweets', 'smallCandy.png'),
(6, 'Wafer', 2, 'sweets', 'wafer.png'),

(7, 'Cola', 3, 'drinks', 'cola.png'),
(8, 'Pepsi', 3, 'drinks', 'pepsi.png'),

(9, 'Salt', 2, 'condiments', 'salt.png'),
(10, 'Papper', 4, 'condiments', 'pepper.png'),

(11, 'Toothbrush', 9, 'hygiene', 'toothbrush.png'),
(12, 'Razor', 4, 'hygiene', 'razor.png'),

(13, 'Long Hair Shampoo', 15, 'shampoo', 'shampoo1.png'),
(14, 'Short Hair Shampoo', 12, 'shampoo', 'shampoo2.png'),

(15, 'Liquid Soap', 8, 'soap', 'liquidSoap.png'),
(16, 'Soap', 7, 'soap', 'soap1.png');



-- Table structure for table `user`

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirmCode` varchar(10) NOT NULL,
  `activation` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `user`

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `mobile`, `address`, `password`, `confirmCode`, `activation`) VALUES
(44, 'Jo', 'Castaneda', 'joanmcastaneda@gmail.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '69a9dc1da83c4c3e58a5ecb7c9de78fa', '0', 'yes'),
(45, 'KO', 'KOOOO', 'ko@w.com', '123', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '25d55ad283aa400af464c76d713c07ad', '289477', 'no'),
(46, 'Czyke', 'Correa', 'czyke@yahoo.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '7c09a95be9c2e9612c2bda758fc17e42', '0', 'yes');

-- Indexes for dumped tables

-- Indexes for table `cart`
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `orders`
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `products`
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `user`
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for table `cart`
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

-- AUTO_INCREMENT for table `orders`
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

-- AUTO_INCREMENT for table `products`
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

-- AUTO_INCREMENT for table `user`
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;
