<?php

$return ['cart'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `cart` (
    `cart_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    `created_time` TEXT    DEFAULT NULL
);
sqlite;

$return['cart_item'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `cart_item` (
    `item_id`        INTEGER PRIMARY KEY AUTOINCREMENT,
    `cart_id`        INTEGER               NOT NULL,
    `description`    VARCHAR(255)  DEFAULT NULL,
    `quantity`       INTEGER               NOT NULL,
    `price`          DECIMAL(15,5) DEFAULT NULL,
    `tax`            DECIMAL(15,5) DEFAULT NULL,
    `added_time`     TEXT          DEFAULT NULL,
    `parent_item_id` INTEGER       DEFAULT 0,
    `metadata`       BLOB
);
sqlite;

return $return;
