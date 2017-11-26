<?
if (!file_exists('tmp')) mkdir ('tmp');
if (!file_exists('pm')) mkdir ('pm');
if (!file_exists('ps')) mkdir ('ps');

$hostname = "127.0.0.1";
$username = "root";
$password = "1122";
$mysqli = new mysqli($hostname, $username, $password);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (!$mysqli->query("DROP DATABASE IF EXISTS `dancefile`;")) {
        printf("Error: %s\n", $mysqli->error);
    }


if (!$mysqli->query("DROP USER 'dancefile'@'localhost';")) {
        printf("Error: %s\n", $mysqli->error);
    }
if (!$mysqli->query("create database dancefile;")) {
        printf("Error: %s\n", $mysqli->error);
    }
$mysqli->select_db ( 'dancefile' );

if (!$mysqli->query("CREATE USER 'dancefile'@'localhost' IDENTIFIED BY '123';")) {
        printf("Error: %s\n", $mysqli->error);
    }

if (!$mysqli->query("GRANT ALL PRIVILEGES ON dancefile. * TO 'dancefile'@'localhost';")) {
        printf("Error: %s\n", $mysqli->error);
   }


$mysqli->query('CREATE TABLE `baskets` (
  `data` datetime NOT NULL,
  `ip` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `b_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

$mysqli->query('CREATE TABLE `down_photo` (
  `photo_id` int(11) NOT NULL,
  `photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

$mysqli->query('CREATE TABLE `flash` (
  `id` int(11)  NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `fromId` int(11) DEFAULT NULL,
  `toId` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `who` varchar(10) DEFAULT NULL,
  `photografer` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');


$mysqli->query("CREATE TABLE `foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zakaz` int(11) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `cd` int(11) DEFAULT NULL,
  `a6` int(11) DEFAULT NULL,
  `a5` int(11) DEFAULT NULL,
  `a4` int(11) DEFAULT NULL,
  `korprice` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `coment` text,
  `del` int(11) DEFAULT '0',
  `sendedmail` int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$mysqli->query('CREATE TABLE `fotografers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kod` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

$mysqli->query("CREATE TABLE `fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL,
  `f` int(11) NOT NULL DEFAULT '0',
  `photografer` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$mysqli->query("CREATE TABLE `pass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `pas` varchar(45) NOT NULL,
  `adm` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


$mysqli->query("INSERT INTO `pass` (`id`, `login`, `pas`, `adm`) VALUES
(1, 'manager', '1', 1);");

$mysqli->query("CREATE TABLE `settings` (
  `kkey` varchar(120) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='';");

$mysqli->query("INSERT INTO `settings` (`kkey`, `value`) VALUES
('curence', 'Руб'),
('last_pic', '0'),
('last_report_date', '2016/11/17'),
('last_report_num', '1'),
('n', 'DANCE FESTIVAL'),
('path_to_folder', 'C:'),
('price10', '12'),
('price15', '17'),
('price20', '25'),
('md5', '".md5(time().gethostname())."'),
('pricecd', '10'),
('printer', '');");

$mysqli->query('CREATE TABLE `url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `parent` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

$mysqli->query("CREATE TABLE `zakaz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summa` int(11) DEFAULT NULL,
  `receipt` int(11) DEFAULT NULL,
  `oplata` int(11) DEFAULT NULL,
  `skidka` int(11) DEFAULT NULL,
  `ok` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `menedger` varchar(45) DEFAULT NULL,
  `opl_sum` int(11) DEFAULT NULL,
  `del` int(11) DEFAULT '0',
  `mail` varchar(200) DEFAULT NULL,
  `mailStatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

unlink('install.php');
header("Location: index.php");