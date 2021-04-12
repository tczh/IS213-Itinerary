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
values (2, "elvis.leong.2019@sis.smu.edu.sg", 3, "Wow so cool!","2021-03-23 00:00:01");
insert into review(ItineraryID, EmailAddr, ReviewRating, ReviewMessage, ReviewDateTime)
values (2, "yuhao.neo.2019@sis.smu.edu.sg", 2, "It's ok i guess...","2021-03-23 00:00:01");
insert into review(ItineraryID, EmailAddr, ReviewRating, ReviewMessage, ReviewDateTime)
values (2, "wcng.2019@sis.smu.edu.sg", 2, "cool!!","2021-03-23 00:00:01");