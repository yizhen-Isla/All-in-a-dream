-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-10-04 14:29:14
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `all_in_a_dream`
--

-- --------------------------------------------------------

--
-- 資料表結構 `category`
--

CREATE TABLE `category` (
  `categoryid` int(10) UNSIGNED NOT NULL,
  `categoryname` varchar(100) NOT NULL,
  `categorysort` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`categoryid`, `categoryname`, `categorysort`) VALUES
(1, '手機/平板', 1),
(2, '電腦/筆電', 2),
(3, '資訊週邊', 3),
(4, '其他', 4);

-- --------------------------------------------------------

--
-- 資料表結構 `memberdata`
--

CREATE TABLE `memberdata` (
  `m_id` int(11) NOT NULL,
  `m_name` varchar(20) NOT NULL,
  `m_email` varchar(50) NOT NULL,
  `m_passwd` varchar(100) NOT NULL,
  `m_sex` enum('Female','Male') NOT NULL,
  `m_birthday` date DEFAULT NULL,
  `m_level` enum('admin','member') NOT NULL DEFAULT 'member',
  `m_phone` varchar(100) DEFAULT NULL,
  `m_address` varchar(100) DEFAULT NULL,
  `m_login` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `m_logintime` datetime DEFAULT NULL,
  `m_jointime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `order`
--

CREATE TABLE `order` (
  `orderid` int(10) UNSIGNED NOT NULL,
  `total` int(10) UNSIGNED DEFAULT NULL,
  `customername` varchar(100) DEFAULT NULL,
  `customeremail` varchar(100) DEFAULT NULL,
  `customeraddress` varchar(100) DEFAULT NULL,
  `customerphone` varchar(100) DEFAULT NULL,
  `paytype` enum('ATM匯款','線上刷卡','貨到付款') DEFAULT 'ATM匯款'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderdetailid` int(10) UNSIGNED NOT NULL,
  `orderid` int(10) UNSIGNED DEFAULT NULL,
  `productid` int(10) UNSIGNED DEFAULT NULL,
  `productname` varchar(254) DEFAULT NULL,
  `unitprice` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `productID` int(10) UNSIGNED NOT NULL,
  `categoryID` int(10) UNSIGNED NOT NULL,
  `productName` varchar(100) DEFAULT NULL,
  `productPrice` int(10) UNSIGNED DEFAULT NULL,
  `productImg` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`productID`, `categoryID`, `productName`, `productPrice`, `productImg`, `description`) VALUES
(1, 1, 'Samsung 三星 Galaxy Z Fold6 5G 7.6吋(12G/512G/高通驍龍8 Gen3/5000萬鏡頭畫素/AI手機)', 58888, '../image/C1_01.webp', '★7.6吋可摺式大螢幕\r\n★幕史上最輕巧 纖薄輕盈 方便攜\r\n★多重視窗分割畫面模式'),
(2, 1, 'ASUS 華碩 ROG Phone 8 Pro 5G 6.78吋(16G/512G/高通驍龍8 Gen3/5000萬鏡頭畫素/AI手機)', 36838, '../image/C1_02.webp', '★旗艦處理器高通S8Gen3\r\n★5500mAh大電量、無線充電\r\n★IP68防水防塵電競手機'),
(3, 1, 'SONY 索尼 Xperia 1 VI 5G 6.5吋(12G/512G/高通驍龍8 Gen3/4800萬鏡頭畫素)', 37990, '../image/C1_03.webp', '★八核心處理器 最高支援至1TB\r\n★強悍防水防塵等級\r\n★充電模式自由選擇'),
(4, 1, 'OPPO Find N3 Flip 6.8吋(12G/256G/聯發科天璣9200/5000萬鏡頭畫素)', 18990, '../image/C1_04.webp', '★超大3.26吋人性化直式外螢幕\r\n★無感摺痕+44W閃充+超大電量\r\n★三鏡頭設計，全Sony感光元件'),
(5, 1, 'realme 12 Pro+ 5G 6.7吋(12G/512G/高通驍龍7s Gen 2/5000萬鏡頭畫素)', 12880, '../image/C1_05.webp', '★Sony IMX890 OIS\r\n★超光影潛望長焦\r\n★120Hz旗艦護眼曲面螢幕'),
(6, 1, 'Google Pixel 9 Pro XL 5G 6.8吋(16G/256G/Tensor G4/5000萬鏡頭畫素/AI手機)', 39990, '../image/C1_06.webp', '★內建 AI 助理 Gemini\r\n★搭載全新一起拍功能\r\n★提供7年的作業系統、安全性'),
(7, 1, '官方旗艦館 小米 Xiaomi MIX Flip 6.86吋(12G/512G/Snapdragon 8 Gen 3/5000萬像素)', 29999, '../image/C1_07.webp', '★4.01 吋超大折疊外螢幕\r\n★Leica 專業光學雙鏡頭\r\n★67W 超級快充'),
(8, 1, 'vivo V30 5G 6.78吋(12G/256G/高通驍龍7 Gen 3/5000萬鏡頭畫素)', 10290, '../image/C1_08.webp', '★6.78吋/5000萬前置\r\n★5000+5000萬主相機\r\n★12G RAM/256G RO'),
(9, 1, 'Samsung 三星 Galaxy A15 5G 6.5吋(4G/128G/聯發科天璣6100+/5000萬鏡頭畫素)', 4990, '../image/C1_09.webp', '★6.5吋U極限全螢幕\r\n★5000萬高畫素主鏡頭\r\n★5000mAh大電量 支援快充'),
(10, 2, 'Apple iPhone 16(128G/6.1吋)', 29900, '../image/C2_10.webp', '★6.1 吋「動態島」螢幕\r\n★相機控制鍵\r\n★A18 仿生晶片'),
(11, 2, 'Apple iPhone 16(512G/6.1吋)', 40400, '../image/C2_10.webp', '★6.1 吋「動態島」螢幕\r\n★相機控制鍵\r\n★A18 仿生晶片'),
(12, 2, 'Apple 預購賣場★iPhone 16 Pro(128G/6.3吋)(40W雙孔閃充組)', 37700, '../image/C2_12.webp', '★A18 Pro 晶片\r\n★超Retina XDR 顯示器\r\n★防潑、抗水與防塵 IP68等級'),
(13, 3, 'Lenovo Tab P12 12.7吋 8G/256G WIFI 平板電腦(內含筆+鍵盤)', 13990, '../image/C3_13.webp', '★3K超高解析度\r\n★搭載四道JBL揚聲器\r\n★13MP前置超廣角相機'),
(14, 3, 'SAMSUNG 三星 Tab A9+ 11吋 8G/128G WiFi X210 平板電腦', 7690, '../image/C3_14.webp', '★長效電力，15W快速充電\r\n★Samsung Dex\r\n★POGO接點可外接鍵盤'),
(15, 3, 'SAMSUNG 三星 Tab S9 Ultra 14.6吋 12G/256G Wi-Fi X910 平板電腦 鍵盤套裝組', 41990, '../image/C3_15.webp', '★GoodNotes獨家合作\r\n★S Pen智慧升級\r\n★多工跨裝置應用');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- 資料表索引 `memberdata`
--
ALTER TABLE `memberdata`
  ADD PRIMARY KEY (`m_id`),
  ADD UNIQUE KEY `m_username` (`m_email`),
  ADD KEY `m_phone` (`m_phone`);

--
-- 資料表索引 `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderid`);

--
-- 資料表索引 `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderdetailid`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `memberdata`
--
ALTER TABLE `memberdata`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order`
--
ALTER TABLE `order`
  MODIFY `orderid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `orderdetailid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
