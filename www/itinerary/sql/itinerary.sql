drop database if exists Itinerary;
create schema Itinerary;
use Itinerary;

create table Itinerary(
    ItineraryID int not null AUTO_INCREMENT,
    ItineraryCreator varchar(50) not null,
    TourTitle varchar(100) not null,
    TourCategory varchar(50) not null,
    Country varchar(50) not null,
    Season varchar(10) not null,
    Price decimal(7,2) not null,
    Thumbnail varchar(1000) not null,
    DateTimeCreated timestamp not null,
    HasApproved boolean,
    constraint itinerary_pk primary key (itineraryid)
);

create table ItineraryDetails(
    DetailsID int NOT NULL,
    ItineraryID int not null, 
    Location varchar(200) not null,  
    Date varchar(50) not null,
    TimeStart varchar(50) not null,
    TimeEnd varchar(50) not null,
    Activity varchar(50) not null,
    Description varchar(500) not null,
    constraint Itinerary_details_pk primary key (DetailsID, ItineraryID),
    constraint Itinerary_details_fk foreign key(ItineraryID) references Itinerary(ItineraryID)
);

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("yuhao.neo.2019@sis.smu.edu.sg", "Best Korea Trip", "Adventure", "Korea", "Winter", 50.2, "abc.jpg", "2021-03-22 00:00:01", true);

insert into ItineraryDetails(detailsid, itineraryid, location, date, timestart, timeend, activity, description)
values (1, 1, "Seoul", "2021-03-22", "1000", "1300", "Running", "Having fun");