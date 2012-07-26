CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cart_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,5) DEFAULT NULL,
  `tax` decimal(15,5) DEFAULT NULL,
  `added_time` datetime DEFAULT NULL,
  `parent_item_id` int(11) DEFAULT 0,
  PRIMARY KEY (`item_id`),
  KEY `cart_id` (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cart_item_index` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value_string` varchar(255) DEFAULT NULL,
  `value_int` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `int_string` (`key`,`value_string`),
  KEY `int_index` (`key`,`value_int`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`);

ALTER TABLE `cart_item_index`
  ADD CONSTRAINT `cart_item_index_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `cart_item` (`item_id`);
