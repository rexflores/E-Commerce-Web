-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 02:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recordsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `adminID` int(11) NOT NULL,
  `adUsername` varchar(50) NOT NULL,
  `adPassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`adminID`, `adUsername`, `adPassword`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `checkout_tbl`
--

CREATE TABLE `checkout_tbl` (
  `checkoutID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalprice` varchar(50) NOT NULL,
  `orderdate` date NOT NULL,
  `shippingdetails` varchar(255) NOT NULL,
  `modeOfPayment` varchar(50) NOT NULL,
  `orderStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout_tbl`
--

INSERT INTO `checkout_tbl` (`checkoutID`, `customerID`, `productID`, `quantity`, `totalprice`, `orderdate`, `shippingdetails`, `modeOfPayment`, `orderStatus`) VALUES
(53, 1, 6, 1, '60', '2024-02-01', 'Quezon City', 'Cash on Delivery', 'Processing'),
(54, 1, 8, 3, '30', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(55, 1, 3, 3, '30', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(56, 1, 4, 1, '15', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(57, 1, 8, 3, '30', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(58, 1, 6, 1, '60', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(59, 1, 6, 1, '60', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(60, 1, 3, 3, '30', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(61, 1, 6, 1, '60', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending'),
(62, 1, 6, 1, '60', '2024-02-02', 'Quezon City', 'Cash on Delivery', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `customer_tbl`
--

CREATE TABLE `customer_tbl` (
  `cusID` int(11) NOT NULL,
  `cusFname` varchar(50) NOT NULL,
  `cusMname` varchar(50) NOT NULL,
  `cusLname` varchar(50) NOT NULL,
  `cusEmail` varchar(50) NOT NULL,
  `cusUsername` varchar(50) NOT NULL,
  `cusPassword` varchar(50) NOT NULL,
  `cusAddress` varchar(255) NOT NULL,
  `cusPicture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_tbl`
--

INSERT INTO `customer_tbl` (`cusID`, `cusFname`, `cusMname`, `cusLname`, `cusEmail`, `cusUsername`, `cusPassword`, `cusAddress`, `cusPicture`) VALUES
(1, 'Rex Daivid', 'L.', 'Flores', 'rexluci.flores@gmail.com', 'rexdaivid', '5b067627bb4cd43123a9f5a3a682682c598b6628', 'Quezon City', '1406554.png'),
(2, 'Cath', 'K.', 'Miranda', 'cathmiranda@gmail.com', 'cathy123', 'bb1ca7593c07f3787b3495bfba7667743fa467e6', 'Makati CIty', '914237.jpg'),
(4, 'Roy', 'H.', 'Gaum', 'roygaum@gmail.com', 'roygaum12', '67121b52faf87158a0cdae697180c9259b13c0b1', 'Japan', '347376.png'),
(5, 'Hannah', 'K.', 'Liza', 'hannahliza@gmail.com', 'hannahliza', 'b9dded9ba2322be68955542bbcba9bef49ec72cf', 'Caloocan City', '3268061.jpg'),
(6, 'Hilary', 'M.', 'Cruz', 'hilarycruz@gmail.com', 'hilary123', '858f5a0e63ed7a7cf1f770b0e103013a00884e58', 'Paranaque City', '2274406.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

CREATE TABLE `order_tbl` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalprice` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tbl`
--

INSERT INTO `order_tbl` (`orderID`, `customerID`, `productID`, `quantity`, `totalprice`) VALUES
(14, 1, 3, 3, '30'),
(15, 1, 4, 1, '15'),
(16, 6, 3, 2, '20'),
(17, 1, 8, 3, '30'),
(18, 6, 9, 1, '120'),
(19, 6, 2, 1, '20'),
(20, 1, 6, 1, '60');

-- --------------------------------------------------------

--
-- Table structure for table `products_tbl`
--

CREATE TABLE `products_tbl` (
  `productID` int(100) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `productPrice` varchar(255) NOT NULL,
  `productPicture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_tbl`
--

INSERT INTO `products_tbl` (`productID`, `productName`, `description`, `productPrice`, `productPicture`) VALUES
(2, 'Puto Pao', 'Puto Pao is a Filipino snack that combines the flavors of two popular Filipino delicacies: puto and siopao. Puto is a type of steamed rice cake, while siopao is a steamed bun usually filled with savory ingredients like meat, eggs, or vegetables.', '20', '552301.jpg'),
(3, 'Lumpiang Shanghai', 'Shanghai lumpia, also known as lumpiang Shanghai, is a type of Filipino spring roll. It is typically made with ground pork, minced onions, carrots, and spices, all wrapped in a thin egg wrapper and then deep-fried until crispy. It\'s a popular appetizer or snack in Filipino cuisine and is often served with a sweet and sour dipping sauce. The name \"Shanghai\" comes from the city in China, although the dish itself has Filipino origins. It\'s a flavorful and crispy treat enjoyed by many both in the Philippines and around the world.', '10', '308434.jpg'),
(4, 'Ube Turon', 'Ube turon is a Filipino dessert that combines two popular treats: turon and ube. Turon is a type of spring roll made with sliced bananas and sometimes jackfruit, wrapped in a spring roll wrapper, and fried until crispy. Ube, on the other hand, refers to purple yam, a staple ingredient in Filipino cuisine known for its vibrant color and sweet flavor.', '15', '8918914.jpg'),
(5, 'Lumpiang Togue', 'Lumpiang Togue, also known as \"Bean Sprout Spring Roll\" or \"Vegetable Spring Roll,\" is a traditional Filipino dish. It\'s a type of spring roll typically made with mung bean sprouts (togue), along with various vegetables such as carrots, green beans, and sometimes cabbage or bell peppers. These vegetables are usually sautéed with garlic, onions, and often some meat like ground pork or shrimp, seasoned with soy sauce and other spices. The mixture is then wrapped in thin crepe-like wrappers made from flour and water, and deep-fried until crispy.', '10', '892710.jpg'),
(6, 'Avocado Graham Cake', 'Avocado graham cake is a dessert made primarily with ripe avocados, graham crackers, condensed milk, and cream. The ripe avocados are mashed and combined with condensed milk to create a creamy base, which is then layered with crushed graham crackers. Some variations may include adding whipped cream or gelatin to achieve a firmer texture. It\'s a popular dessert in the Philippines, known for its unique combination of creamy avocado flavor and the slight sweetness from the condensed milk and graham crackers. It\'s often chilled before serving and can be garnished with additional toppings like sliced avocado or grated cheese.', '60', '175945.jpg'),
(7, 'Ginataang Mais', 'Ginataang Mais is a traditional Filipino dessert made from glutinous rice, coconut milk, sugar, and corn kernels. \"Ginataan\" refers to dishes cooked with coconut milk, and \"mais\" means corn in Filipino. To prepare Ginataang Mais, the glutinous rice and corn kernels are cooked in coconut milk until the mixture thickens and the flavors meld together. It\'s often served warm and enjoyed as a comforting snack or dessert, particularly during colder months or rainy days in the Philippines. Sometimes, it\'s also topped with slices of ripe jackfruit or drizzled with coconut cream for added richness and flavor. It\'s a delightful and comforting dish that highlights the sweetness of corn combined with the creaminess of coconut milk.', '25', '1749174.jpg'),
(8, 'Puto & Kutsinta', 'Puto Kutsinta is a Filipino delicacy that combines two traditional desserts: Puto, a steamed rice cake, and Kutsinta, a sticky rice cake. Puto Kutsinta is typically made from rice flour, brown sugar, and lye water (or sometimes baking powder) for texture. It\'s often served with grated coconut or sometimes with a drizzle of caramel sauce.', '10', '6962002.jpg'),
(9, 'Mango Graham Cake', 'Mango graham cake is a popular Filipino dessert that combines layers of graham crackers, sweetened whipped cream, condensed milk, and ripe mango slices. It\'s a no-bake dessert that\'s easy to assemble and requires only a few ingredients. The graham crackers soften as the dessert chills, creating a creamy and delicious treat with the sweetness of mangoes complementing the creamy layers. It\'s often served chilled and is a favorite dessert during special occasions or simply as a refreshing treat on a hot day.', '120', '2962922.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `checkout_tbl`
--
ALTER TABLE `checkout_tbl`
  ADD PRIMARY KEY (`checkoutID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  ADD PRIMARY KEY (`cusID`);

--
-- Indexes for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `order_tbl_ibfk_2` (`productID`);

--
-- Indexes for table `products_tbl`
--
ALTER TABLE `products_tbl`
  ADD PRIMARY KEY (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `checkout_tbl`
--
ALTER TABLE `checkout_tbl`
  MODIFY `checkoutID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `customer_tbl`
--
ALTER TABLE `customer_tbl`
  MODIFY `cusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_tbl`
--
ALTER TABLE `order_tbl`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products_tbl`
--
ALTER TABLE `products_tbl`
  MODIFY `productID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout_tbl`
--
ALTER TABLE `checkout_tbl`
  ADD CONSTRAINT `checkout_tbl_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer_tbl` (`cusID`),
  ADD CONSTRAINT `checkout_tbl_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`);

--
-- Constraints for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD CONSTRAINT `order_tbl_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer_tbl` (`cusID`),
  ADD CONSTRAINT `order_tbl_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products_tbl` (`productID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
