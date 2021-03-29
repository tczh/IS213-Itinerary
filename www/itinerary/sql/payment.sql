drop database if exists payment;
create database payment;
use payment;

CREATE TABLE IF NOT EXISTS `payment` (
    `paymentID` integer auto_increment NOT NULL,    
    `emailAddr` varchar(50) NOT NULL,
    `isPaid` varchar(5) NOT NULL, 
    `dateBought` datetime NOT NULL,
    `totalPrice` decimal(7,2) NOT NULL,
    constraint payment_pk primary key (paymentID)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE IF NOT EXISTS `paymentItems` (
    `orderNo` integer auto_increment NOT NULL,    
    `paymentID` integer NOT NULL,
    `itineraryID` integer NOT NULL,
    constraint paymentItems_pk primary key (orderNo, paymentID),
    constraint paymentItems_fk foreign key (paymentID) references payment(paymentID)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;
