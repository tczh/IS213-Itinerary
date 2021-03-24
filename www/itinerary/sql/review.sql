drop database if exists Review;
create schema Review;
use Review;

create table Review(
    ReviewID int not null AUTO_INCREMENT,
    ItineraryID int not null,
    EmailAddr varchar(50) not null,
    ReviewRating int not null,
    ReviewMessage varchar(100) not null,
    ReviewDateTime timestamp not null,
    constraint review_pk primary key (ReviewID)
);


insert into review(ItineraryID, EmailAddr, ReviewRating, ReviewMessage, ReviewDateTime) 
values (1, "wcng.2019@sis.smu.edusg", 4, "Testing","2021-03-23 00:00:01");

insert into review(ItineraryID, EmailAddr, ReviewRating, ReviewMessage, ReviewDateTime) 
values (1, "elvis.leong.2019@sis.smu.edu.sg", 3, "Testing","2021-03-23 00:00:01");