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
    constraint cartItems_pk primary key (cartNo, cartID),
    constraint cartItems_fk foreign key (cartID) references cart(cartID)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

/* Create 2 users' cart */
insert into cart (`emailAddr`) values ("yuhao.neo.2019@sis.smu.edu.sg");
insert into cart (`emailAddr`) values ("yuhaoneo@gmail.com");

/* Create items for first user */
insert into cartItems (`cartID`, `itineraryID`) values (1, 100);
insert into cartItems (`cartID`, `itineraryID`) values (1, 200);

/* Create items for second user */
insert into cartItems (`cartID`, `itineraryID`) values (2, 300);
insert into cartItems (`cartID`, `itineraryID`) values (2, 400);