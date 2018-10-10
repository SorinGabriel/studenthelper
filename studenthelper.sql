-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2017 at 05:25 PM
-- Server version: 5.7.17-0ubuntu1
-- PHP Version: 7.0.15-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studenthelper`
--

-- --------------------------------------------------------

--
-- Table structure for table `administratori`
--

CREATE TABLE `administratori` (
  `admin_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administratori`
--

INSERT INTO `administratori` (`admin_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `articole`
--

CREATE TABLE `articole` (
  `articol_id` int(6) NOT NULL,
  `titlu` varchar(50) NOT NULL,
  `continut` text NOT NULL,
  `autor` varchar(50) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articole`
--

INSERT INTO `articole` (`articol_id`, `titlu`, `continut`, `autor`, `data`) VALUES
(4, 'Long article', '<ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            <ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>\n            ', 'admin', '2017-04-20 01:23:36'),
(6, 'Articol facut de moderator', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur justo elit, gravida et tincidunt eu, ultricies at tortor. Donec ut eros volutpat leo hendrerit pretium. Etiam eget bibendum dui, placerat lacinia nulla. Nam molestie ipsum nisi, at commodo eros eleifend ac. Vivamus convallis nisl at condimentum feugiat. Aliquam semper neque nec fringilla faucibus. Quisque vel tortor scelerisque, bibendum nunc quis, lobortis odio. Maecenas maximus pretium purus at volutpat. Mauris porttitor, libero et porta maximus, libero elit blandit felis, quis bibendum ipsum dolor eu felis. Curabitur maximus metus tincidunt, scelerisque risus sed, auctor urna. Nam consequat maximus sem, quis eleifend nulla cursus quis. Cras venenatis congue sodales. Duis scelerisque vitae ipsum at consequat.<br><br>Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur venenatis, lorem id dignissim ultrices, velit sapien convallis dolor, id eleifend odio justo dignissim justo. Mauris dignissim felis eget lectus malesuada, in scelerisque nulla varius. Curabitur sit amet consectetur dui. Sed at fermentum diam. Vivamus hendrerit libero ut lacus rutrum porta. Suspendisse urna nisl, maximus et tortor eget, volutpat vulputate turpis. In tempor, nibh vel semper ultricies, quam neque tempus magna, a pulvinar risus eros mollis mi. Curabitur ligula tellus, rutrum eleifend bibendum in, elementum eu neque. Integer lacus sem, hendrerit et iaculis vel, maximus nec felis. Fusce sollicitudin risus id tristique venenatis. Nullam ac euismod augue, sed congue ante. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis id purus eu dolor luctus interdum. Donec ex dui, aliquet vitae leo eget, ornare fringilla sapien.<br><br>Quisque sed velit ac mi mattis vestibulum. Maecenas egestas sem sed auctor aliquet. Duis vulputate metus turpis, pulvinar consectetur tortor blandit quis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla efficitur placerat turpis, nec efficitur lorem lobortis sit amet. Vivamus nibh arcu, bibendum vitae imperdiet a, posuere at felis. Quisque sit amet tellus sodales, placerat ligula mollis, tempor orci. Aliquam id leo iaculis mauris pellentesque molestie at ut nisl. Integer eget dictum ante. Praesent et purus eu tellus feugiat blandit vel vitae est. Donec mi lorem, condimentum sed quam et, sollicitudin tempus turpis.<br><br>Fusce ullamcorper lacus massa, et bibendum ligula porttitor non. Aliquam pulvinar dapibus erat id auctor. Mauris vulputate lacus dolor, eu feugiat ante pharetra et. Proin ullamcorper consectetur lectus efficitur mattis. Suspendisse eu felis iaculis, rhoncus enim a, ultricies neque. Pellentesque eu massa consequat, euismod arcu nec, dapibus tortor. Sed vulputate sem in metus ultricies porta. Vestibulum sed mi mi. Mauris maximus augue risus. Suspendisse potenti. Nullam tincidunt elit nisi, nec condimentum nulla commodo sagittis.<br><br>Curabitur at ex pharetra, fermentum sem et, pellentesque metus. Pellentesque odio enim, semper pellentesque mi ac, consequat malesuada dui. Curabitur semper eros congue, ultrices nulla in, gravida leo. Vestibulum non tristique massa. Duis pulvinar sed felis sed rhoncus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus metus augue, luctus in justo ut, sagittis interdum metus. Aenean porta tempor elit at condimentum. In hac habitasse platea dictumst. Aliquam malesuada consequat rutrum.<br><br>Donec ac imperdiet turpis. Morbi lacinia nulla sed felis rutrum posuere. Morbi neque enim, rutrum sit amet lectus eget, congue lobortis massa. Morbi porttitor ligula et sem bibendum, ut efficitur diam tincidunt. Vivamus mattis dapibus mauris. In tincidunt eros libero, vel volutpat ligula sodales non. Sed et pellentesque nisi, eget pretium arcu. Proin sapien libero, dignissim vel feugiat sit amet, condimentum vel lorem. Maecenas vulputate dui id malesuada ultrices. Quisque molestie odio vitae ultricies pulvinar. Curabitur tortor tellus, vulputate vitae aliquet aliquam, gravida eget lectus.<br><br>Nullam ultricies interdum vulputate. Duis faucibus suscipit nibh, id ullamcorper sem bibendum eu. Morbi maximus dapibus tristique. Nunc luctus sagittis quam. Ut id tincidunt velit. Suspendisse tristique, nunc vitae vehicula vehicula, tellus mi pharetra dolor, lobortis tempor nunc elit vitae arcu. Duis tristique eros et mollis maximus. In ullamcorper nibh id erat efficitur fermentum. Nullam eget diam semper, porttitor odio at, hendrerit purus. Suspendisse in orci lacinia, ullamcorper diam eget, hendrerit orci. Nunc vehicula convallis dolor, ut mollis leo posuere sed. In mattis justo ipsum, a commodo augue posuere vitae. Nulla nibh risus, ullamcorper vitae varius a, mollis at ligula.', 'moderatorarticole', '2017-04-20 01:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `categorichestionare`
--

CREATE TABLE `categorichestionare` (
  `id` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `page` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorichestionare`
--

INSERT INTO `categorichestionare` (`id`, `nume`, `page`) VALUES
(2, 'Nume categorie', 'nume-categorie.php'),
(5, 'Nume categorie24', 'Nume-categorie24.php');

-- --------------------------------------------------------

--
-- Table structure for table `cereriparola`
--

CREATE TABLE `cereriparola` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `keylink` varchar(100) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chestionare`
--

CREATE TABLE `chestionare` (
  `id` int(11) NOT NULL,
  `titlu` varchar(50) NOT NULL,
  `descriere` text NOT NULL,
  `timp` int(10) NOT NULL,
  `data` datetime NOT NULL,
  `id_cat` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chestionare`
--

INSERT INTO `chestionare` (`id`, `titlu`, `descriere`, `timp`, `data`, `id_cat`, `user_id`) VALUES
(4, 'A doua intrebare', 'Da', 32, '2017-04-20 01:49:13', 2, 1),
(5, 'Chestionar smecher', 'Da', 15, '2017-04-20 01:51:49', 2, 1),
(8, 'Chestionar smecher', 'da', 10, '2017-04-20 02:31:28', 2, 4),
(9, 'Chestionar tare', 'Bun', 121, '2017-04-20 13:26:10', 2, 3),
(11, 'dsafas', 'dqwdwq', 123, '2017-04-20 14:08:07', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comentarticole`
--

CREATE TABLE `comentarticole` (
  `id` int(6) NOT NULL,
  `articol` int(6) NOT NULL,
  `utilizator` int(6) NOT NULL,
  `mesaj` text NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comentarticole`
--

INSERT INTO `comentarticole` (`id`, `articol`, `utilizator`, `mesaj`, `data`) VALUES
(3, 4, 4, 'smecher', '2017-04-20 01:55:30'),
(8, 6, 5, 'fsasf', '2017-04-20 14:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `facultate`
--

CREATE TABLE `facultate` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facultate`
--

INSERT INTO `facultate` (`id`, `nume`) VALUES
(2, 'Facultatea de matematica si informatica, UNIBUC'),
(4, 'Facultate de biologie, UNIBUC');

-- --------------------------------------------------------

--
-- Table structure for table `grupa`
--

CREATE TABLE `grupa` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `serie` varchar(100) NOT NULL,
  `an` varchar(100) NOT NULL,
  `specializare` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT '../images/emptyorar.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupa`
--

INSERT INTO `grupa` (`id`, `nume`, `serie`, `an`, `specializare`, `image`) VALUES
(1, '332', '33', '3', '2', '../orar/01269660e7d157eef981b46943adc8f94ab5aa9911fc11aed149db11f950aad7332.jpg'),
(7, 'Singura grupa', '1', '1', '6', '../images/emptyorar.png');

-- --------------------------------------------------------

--
-- Table structure for table `intrebari`
--

CREATE TABLE `intrebari` (
  `id_intrebare` int(11) NOT NULL,
  `intrebare` varchar(300) NOT NULL,
  `raspuns1` varchar(150) NOT NULL,
  `raspuns2` varchar(150) NOT NULL,
  `raspuns3` varchar(150) NOT NULL,
  `raspuns4` varchar(150) NOT NULL,
  `corect` int(1) NOT NULL,
  `id_chestionar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `intrebari`
--

INSERT INTO `intrebari` (`id_intrebare`, `intrebare`, `raspuns1`, `raspuns2`, `raspuns3`, `raspuns4`, `corect`, `id_chestionar`) VALUES
(2, 'q', '1', '2', '3', '4', 4, 2),
(4, 'Da?', 'Nu', 'Nu', 'Nu', 'Da', 4, 4),
(5, 'doi', '1', '2', '3', '4', 3, 5),
(6, 'nu', 'a', 'b', 'c', 'd', 4, 5),
(11, 'O intrebare', 'Da', 'Nu', 'Poate', 'Nu stiu', 3, 8),
(12, 'Ceva', 'DA', 'ra', 'nu', 'pa', 4, 9),
(13, 'q', 'a', 'b', 'c', 'd', 3, 10),
(14, 'dwq', '1', '2', '3', '4', 4, 11);

-- --------------------------------------------------------

--
-- Table structure for table `moderatori`
--

CREATE TABLE `moderatori` (
  `moderator_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `articole` int(11) NOT NULL,
  `qa` int(11) NOT NULL,
  `chestionare` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moderatori`
--

INSERT INTO `moderatori` (`moderator_id`, `user_id`, `articole`, `qa`, `chestionare`) VALUES
(1, 2, 1, -1, -1),
(2, 4, -1, 1, -1),
(3, 3, -1, -1, 1),
(5, 5, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `qacat`
--

CREATE TABLE `qacat` (
  `id` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `page` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qacat`
--

INSERT INTO `qacat` (`id`, `nume`, `page`) VALUES
(4, 'Nume categorie', 'nume-categorie2.php'),
(6, 'Nume categorie23', 'Nume-categorie23.php');

-- --------------------------------------------------------

--
-- Table structure for table `qapost`
--

CREATE TABLE `qapost` (
  `id` int(6) NOT NULL,
  `user` int(6) NOT NULL,
  `date` datetime NOT NULL,
  `subiect` varchar(250) NOT NULL,
  `mesaj` text NOT NULL,
  `grup` int(6) NOT NULL,
  `categorie` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qapost`
--

INSERT INTO `qapost` (`id`, `user`, `date`, `subiect`, `mesaj`, `grup`, `categorie`) VALUES
(7, 1, '2017-04-20 01:46:42', 'Prima intrebare', '1 2 3 nu', 1, 4),
(8, 1, '2017-04-20 01:46:45', 'RE:Prima intrebare', '5 6 7 8', 1, 4),
(9, 2, '2017-04-20 01:53:58', 'RE:Prima intrebare', 'misto intrebare dar vreau sa iti raspund', 1, 4),
(10, 2, '2017-04-20 01:54:26', 'Intrebare smechera', 'Ce faceti bai frumosilor?', 2, 4),
(11, 4, '2017-04-20 01:56:36', 'RE:Intrebare smechera', 'Interesant.As vrea sa vorbim mai multe', 2, 4),
(14, 3, '2017-04-20 02:50:03', 'Intrebarea mea', 'Scriu ce vreau aici pentru ca e postat de mine', 3, 4),
(15, 1, '2017-04-20 14:05:48', 'fsafa', 'qwe wqeq eqw qw', 4, 6),
(16, 1, '2017-05-01 17:15:54', 'test', 'test surpriza pentru q and a ', 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ratingarticole`
--

CREATE TABLE `ratingarticole` (
  `id` int(11) NOT NULL,
  `articol_id` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratingarticole`
--

INSERT INTO `ratingarticole` (`id`, `articol_id`, `nota`, `user_id`) VALUES
(3, 4, 8, 1),
(5, 4, 10, 4),
(7, 6, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ratingchestionare`
--

CREATE TABLE `ratingchestionare` (
  `id` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `chestionar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratingchestionare`
--

INSERT INTO `ratingchestionare` (`id`, `nota`, `chestionar_id`, `user_id`) VALUES
(3, 1, 5, 1),
(4, 10, 5, 2),
(5, 10, 4, 2),
(6, 10, 4, 4),
(8, 5, 5, 3),
(9, 9, 8, 4),
(10, 10, 4, 1),
(11, 10, 8, 1),
(12, 10, 9, 3),
(13, 9, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ratingqa`
--

CREATE TABLE `ratingqa` (
  `id` int(11) NOT NULL,
  `qa_id` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratingqa`
--

INSERT INTO `ratingqa` (`id`, `qa_id`, `nota`, `user_id`) VALUES
(5, 7, 9, 1),
(6, 8, 10, 1),
(7, 7, 4, 2),
(8, 10, 10, 2),
(9, 10, 10, 4),
(10, 10, 10, 3),
(11, 10, 9, 1),
(12, 14, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rezultate`
--

CREATE TABLE `rezultate` (
  `id` int(11) NOT NULL,
  `id_chestionar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `corecte` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rezultate`
--

INSERT INTO `rezultate` (`id`, `id_chestionar`, `id_user`, `data`, `corecte`, `total`) VALUES
(3, 5, 1, '2017-04-20 01:52:01', 0, 2),
(4, 5, 2, '2017-04-20 01:54:50', 0, 2),
(5, 4, 2, '2017-04-20 01:55:07', 1, 1),
(6, 4, 4, '2017-04-20 01:57:00', 1, 1),
(8, 5, 3, '2017-04-20 02:01:43', 0, 2),
(9, 8, 4, '2017-04-20 02:31:38', 0, 1),
(10, 4, 1, '2017-04-20 12:53:41', 1, 1),
(11, 8, 1, '2017-04-20 12:53:56', 1, 1),
(12, 9, 3, '2017-04-20 13:26:24', 1, 1),
(13, 11, 1, '2017-04-20 14:08:15', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schimbarimail`
--

CREATE TABLE `schimbarimail` (
  `id` int(11) NOT NULL,
  `keylink` varchar(100) NOT NULL,
  `user` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `newmail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `specializare`
--

CREATE TABLE `specializare` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `id_facultate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specializare`
--

INSERT INTO `specializare` (`id`, `nume`, `id_facultate`) VALUES
(1, 'Matematica', 2),
(2, 'Informatica', 2),
(3, 'Calculatoare si tehnologia informatiei', 2),
(6, 'Biologie', 4);

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `user_id` int(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `poza` varchar(150) NOT NULL DEFAULT 'uploads/user.png',
  `grupa` varchar(30) NOT NULL DEFAULT '-1',
  `detalii` text,
  `publicmail` int(1) NOT NULL DEFAULT '-1',
  `github` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`user_id`, `username`, `password`, `mail`, `poza`, `grupa`, `detalii`, `publicmail`, `github`) VALUES
(1, 'admin', '14950db4044c8fd546cb42e99edf4d2d', 'sorinmarica4@gmail.com', '../uploads/4fe31bb8693a0e60414b4b52acb171be1.jpeg', '1', 'Sunt administratorul site-ului', 1, 'http://github.com/SorinGabriel'),
(2, 'moderatorarticole', '14950db4044c8fd546cb42e99edf4d2d', 'soryyo2010@gmail.com', 'uploads/user.png', '-1', NULL, -1, NULL),
(3, 'moderatorchestionare', '14950db4044c8fd546cb42e99edf4d2d', 'soryeo@gmail.com', '../uploads/d823defa7a442e43c7c177a06588f95dScreenshot from 2017-04-19 14-52-25.png', '-1', '', -1, ''),
(4, 'moderatorqa', '14950db4044c8fd546cb42e99edf4d2d', 'sorin-gabriel.marica@my.fmi.unibuc.ro', 'uploads/user.png', '-1', NULL, -1, NULL),
(5, 'username', '14950db4044c8fd546cb42e99edf4d2d', 'studenthelperlicenta@gmail.com', 'uploads/user.png', '-1', NULL, -1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administratori`
--
ALTER TABLE `administratori`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `articole`
--
ALTER TABLE `articole`
  ADD PRIMARY KEY (`articol_id`);

--
-- Indexes for table `categorichestionare`
--
ALTER TABLE `categorichestionare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cereriparola`
--
ALTER TABLE `cereriparola`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indexes for table `chestionare`
--
ALTER TABLE `chestionare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comentarticole`
--
ALTER TABLE `comentarticole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facultate`
--
ALTER TABLE `facultate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupa`
--
ALTER TABLE `grupa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intrebari`
--
ALTER TABLE `intrebari`
  ADD PRIMARY KEY (`id_intrebare`);

--
-- Indexes for table `moderatori`
--
ALTER TABLE `moderatori`
  ADD PRIMARY KEY (`moderator_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `qacat`
--
ALTER TABLE `qacat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page` (`page`);

--
-- Indexes for table `qapost`
--
ALTER TABLE `qapost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratingarticole`
--
ALTER TABLE `ratingarticole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratingchestionare`
--
ALTER TABLE `ratingchestionare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratingqa`
--
ALTER TABLE `ratingqa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rezultate`
--
ALTER TABLE `rezultate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schimbarimail`
--
ALTER TABLE `schimbarimail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indexes for table `specializare`
--
ALTER TABLE `specializare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administratori`
--
ALTER TABLE `administratori`
  MODIFY `admin_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `articole`
--
ALTER TABLE `articole`
  MODIFY `articol_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `categorichestionare`
--
ALTER TABLE `categorichestionare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cereriparola`
--
ALTER TABLE `cereriparola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chestionare`
--
ALTER TABLE `chestionare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `comentarticole`
--
ALTER TABLE `comentarticole`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `facultate`
--
ALTER TABLE `facultate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `grupa`
--
ALTER TABLE `grupa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `intrebari`
--
ALTER TABLE `intrebari`
  MODIFY `id_intrebare` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `moderatori`
--
ALTER TABLE `moderatori`
  MODIFY `moderator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `qacat`
--
ALTER TABLE `qacat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `qapost`
--
ALTER TABLE `qapost`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `ratingarticole`
--
ALTER TABLE `ratingarticole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ratingchestionare`
--
ALTER TABLE `ratingchestionare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ratingqa`
--
ALTER TABLE `ratingqa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rezultate`
--
ALTER TABLE `rezultate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `schimbarimail`
--
ALTER TABLE `schimbarimail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specializare`
--
ALTER TABLE `specializare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
