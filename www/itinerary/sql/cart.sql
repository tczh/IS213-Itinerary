drop database if exists cart;
create database cart;
use cart;

CREATE TABLE IF NOT EXISTS `cart` (
    `cartID` integer auto_increment NOT NULL,    
    `emailAddr` varchar(50) NOT NULL,
    constraint cart_pk primary key (cartID)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE IF NOT EXISTS `cartItems` (
    `cartNo` integer auto_increment NOT NULL,    
    `cartID` integer NOT NULL,
    `itineraryID` integer NOT NULL,
    `price` decimal(7,2) NOT NULL,
    `tourtitle` varchar(100) not null,
    constraint cartItems_pk primary key (cartNo, cartID),
    constraint cartItems_fk foreign key (cartID) references cart(cartID)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

