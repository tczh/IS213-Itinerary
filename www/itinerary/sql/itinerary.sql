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
    DetailsID int NOT NULL AUTO_INCREMENT,
    ItineraryID int not null, 
    daynumber int not null,
    Location varchar(200) not null,  
    activitynumber int not null,
    TimeStart varchar(50) not null,
    TimeEnd varchar(50) not null,
    Activity varchar(50) not null,
    Description varchar(500) not null,
    constraint Itinerary_details_pk primary key (DetailsID),
    constraint Itinerary_details_fk foreign key(ItineraryID) references Itinerary(ItineraryID)
);

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("elgin@gmail.com", "Frankfurt is Frankly Fun", "family", "Germany", "fall", 8, "https://images.unsplash.com/photo-1467269204594-9661b134dd2b?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80", "2021-03-22 00:00:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (1, 1, "Best Worscht in Town Restaurant", 1, "11:30", "12:30", "Food", "Experience the delights of Frankfurt by eating sausage franks!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (1, 1, "Zoo Frankfurt", 2, "13:00", "14:00", "Explore the Zoo!", "It features over 4,500 animals of more than 510 species on more than 11 hectares. The zoo was founded in 1858 and is the second oldest zoo in Germany, after Berlin Zoological Garden. It lies in the eastern part of the Innenstadt.");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (1, 2, "River Main", 1, "09:00", "09:50", "50-min Sightseeing Cruise", "For travelers that want to sit back, relax, and enjoy a calming sightseeing excursion in Frankfurt shouldn't miss this cruise on the River Main. Choose either the upstream or downstream route before you head out for your cruise on the river. Highlights include the views of notable Frankfurt sights—from the Frankfurt Cathedral to Westhafen Tower—complete with bilingual commentary, and lovely skyline vistas along the way.");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("elgin@gmail.com", "Great Ocean Adventure!", "adventure", "Australia", "spring", 15, "https://images.unsplash.com/photo-1581255078657-13b74a0690c6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1053&q=80", "2021-03-23 12:30:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (2, 1, "On the Road", 1, "12:00", "18:00", "Road Trip", "Take a scenic drive down the Great Ocean Road!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (2, 2, "12 Apostles", 1, "10:00", "13:00", "Visit the 12 Apostles", "The Twelve Apostles is a collection of limestone stacks off the shore of Port Campbell National Park, by the Great Ocean Road in Victoria, Australia. Their proximity to one another has made the site a popular tourist attraction.");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (2, 2, "Bells Beach", 2, "14:00", "17:00", "Surfing", "Ride a wave at Bells Beach, located near Torquay on the southern coast of Victoria in the Great Ocean Road region. Head to Bells Beach over the Easter weekend and watch the world's best surfers carve up the waves at the Rip Curl Pro Surfing Competition. High cliffs provide a dramatic backdrop to the natural amphitheatre of the beach and large swells from the Southern Ocean, which slow down and steepen over the reef-strewn shallows, create the outstanding surf.
If you're a sightseer, Bells Beach is a popular spot with great vantage points along the cliff. For surfers, Bells Beach is really for the experienced. The beach is an exposed reef and point break with excellent right hand breaks, at their best during autumn and winter.");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("yuhao.neo.2019@sis.smu.edu.sg", "Discover Singapore!", "Friends", "Singapore", "Summer", 52, "https://www.businesstimes.com.sg/sites/default/files/styles/large_popup/public/image/2020/08/07/BT_20200807_YSTRUSTS_4196972.jpg?itok=ovd17lZb", "2021-03-11 14:18:00", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (3, 1, "Singapore", 1, "09:30", "11:00", "Ya Kun Breakfast", "Try the traditional breakfast that all Singaporeans enjoy");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (3, 1, "Singapore", 2, "12:00", "15:00", "Shopping", "Experience walking through the busiest streets in Bugis");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (3, 2, "Singapore", 1, "12:00", "14:00", "Buffet", "Can't get enough food? Sign yourself up with the amazing buffet available");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("elgin@gmail.com", "KL Exploration", "Family", "Malaysia", "Summer", 44, "http://static.asiawebdirect.com/m/kl/portals/kuala-lumpur-ws/homepage/pagePropertiesOgImage/kuala-lumpur.jpg.jpg", "2021-03-13 12:22:11", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (4, 1, "Kuala Lumpur", 1, "12:00", "13:30", "Brunch", "Want to sleep late yet not missing any good food? Enjoy having brunch at Birch!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (4, 2, "Kuala Lumpur", 1, "12:00", "15:00", "LegoLand", "Don't miss out the fun at the LegoLand!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (4, 3, "Kuala Lumpur", 1, "11:00", "14:00", "Shopping", "Enjoy great offers from the big brands like Nike at the Pavilion Mall!");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("yuhao.neo.2019@sis.smu.edu.sg", "Winter Wonderland Trip", "Adventure", "SouthKorea", "Winter", 50, "https://res.klook.com/image/upload/fl_lossy.progressive/q_65/c_fill,w_1360/blogen/2018/11/korea-winter-activities-cover.jpg", "2021-03-22 00:00:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (5, 1, "Seoul", 1, "08:00", "09:00", "Sunrise", "Watch the sunrise in Seoul on the skyscrapers");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (5, 1, "Seoul", 2, "14:00", "15:00", "Build snowman", "Build your very own snowman!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (5, 2, "Seoul", 1, "1100", "13:00", "Food", "Have lunch with a reindeer!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (5, 2, "Seoul", 1, "18:00", "18:30", "Snowballfight!", "Go out side of your hotel and throw some snowballs!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (5, 2, "Seoul", 1, "19:00", "20:00", "Chill", "Snuggle in your hotel to warm up!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (5, 3, "Busan", 1, "09:00", "10:00", "Monkas", "Take a train to busan(Becareful of zombies!)");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("elgin@gmail.com", "2D1N Myanmar Adventure!", "Adventure", "Myanmar", "Winter", 28, "https://static.officeholidays.com/images/1280x853c/myanmar_bagan_01.jpg", "2021-04-08 00:00:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (6, 1, "Yangon", 1, "10:00", "13:00", "Seeking Pagodas", "Spend your morning visting pagoda. Myanmar is a country with a rich history!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (6, 1, "Yangon", 1, "14:00", "15:00", "Market", "Collect some fresh produce before you set out on a hike!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (6, 2, "Bagan", 1, "10:00", "13:00", "Bus Ride", "Take a bus ride to bagan");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (6, 2, "Bagan", 1, "14:00", "16:00", "Explore hidden temples", "Between the 11th and 13th centuries, more than 10,000 Buddhist temples, pagodas and monasteries were constructed in the Bagan plains alone.");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (6, 2, "Bagan", 1, "18:00", "18:30", "Sunset", "Catch the sunset before you leave!");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("elvis.leong.2019@sis.smu.edu.sg", "Budget Much", "Family", "Germany", "Summer", 34, "https://cdn.cnn.com/cnnnext/dam/assets/170706112840-germany.jpg", "2021-03-22 00:00:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 1, "Berlin", 1, "08:00", "12:00", "sight-seeing", "Chillax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 1, "Munich", 2, "12:00", "15:00", "more sight-seeing", "Chillax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 1, "Frankfurt", 3, "16:00", "19:00", "even more sight-seeing", "Chillax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 2, "Hamburg", 1, "12:00", "15:00", "much more sight-seeing", "Intensive");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 2, "Cologne", 2, "16:00", "19:00", "much many more sight-seeing", "Intensive");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 2, "Düsseldorf", 3, "20:00", "22:00", "super sight-seeing", "Intensive max");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 3, "Leipzig", 1, "12:00", "15:00", "slack", "Relax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 3, "Stuttgart", 2, "16:00", "19:00", "much slack", "Much Relax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (7, 3, "Bremen", 3, "20:00", "22:00", "more slack", "Intensive Relaxing");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("elvis.leong.2019@sis.smu.edu.sg", "You Will Be Amazed", "Luxury", "Egypt", "Spring", 999, "https://www.worldtravelguide.net/wp-content/uploads/2017/04/Think-Egypt-Giza-Sphynx-178375366-pius99-copy.jpg", "2021-03-22 00:00:01", false);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 1, "Cairo", 1, "08:00", "12:00", "sun tanning", "Chillax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 1, "Alexandria", 2, "12:00", "15:00", "more sun tanning", "Chillax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 1, "Luxor", 3, "16:00", "19:00", "even more sun tanning", "Chillax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 2, "Aswan", 1, "12:00", "15:00", "much more sun tanning", "Intensive");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 2, "Giza", 2, "16:00", "19:00", "much many more sun tanning", "Intensive");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 2, "Hurghada", 3, "20:00", "22:00", "super sun tanning", "Intensive max");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 3, "Edfu", 1, "12:00", "15:00", "sun tanning", "Relax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 3, "Port Said", 2, "16:00", "19:00", "much sun tanning", "Much Relax");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (8, 3, "Asyut", 3, "20:00", "22:00", "more sun tanning", "Intensive Relaxing");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values ("tim@gmail.com", "Wildest Adventure of your life!", "Adventure", "Africa", "Summer", 26, "https://scholarlyoa.com/wp-content/uploads/2020/05/hunting.jpg", "2021-03-22 00:00:01", false);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (9, 1, "East African Jungle Safaris", 1, "11:00", "18:30", "Hunting", "You will be entitled to hunting of 3 wild rabbits and 2 wild deer! following which you will BBQ it");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (9, 2, "East African Jungle Safaris", 2, "08:30", "15:00", "Swimming", "You will be swimming with the ducks and then be able to adopt one back to your country!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (9, 2, "East African Jungle Safaris", 2, "16:00", "19:30", "Cooking", "After swimming, you will be able to pick your own duck to cook! Fresh barbeque!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (9, 2, "East African Jungle Safaris", 3, "08:30", "22:00", "Tribal Visiting", "Learn how to engrave traditional tribal imprints on your hand, not only that you will have the chance to tattoo yourself!");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values("tim@gmail.com", "Freshest meat with Korea", "Family", "Korea", "Winter", 36, "https://thereshegoesagain.org/wp-content/uploads/2018/01/korea-winter-tips.jpg", "2021-03-22 00:00:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (10, 1, "Busan", 1, "11:00", "18:30", "Fishing", "You will be entitled to fish anything you want and possibly bringing fresh fish back to your country!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (10, 2, "Busan", 2, "08:30", "15:00", "Swimming", "Swimming with the fishes!");

insert into Itinerary(ItineraryCreator, TourTitle, TourCategory, Country, Season, Price, Thumbnail, DateTimeCreated, HasApproved)
values("tim@gmail.com", "Enjoy exquisite food testing with China!", "Adventure", "China", "Summer", 19, "https://thepienews.com/wp-content/uploads/2019/07/china-tour-package-3546353_1920-860x375.jpg", "2021-03-22 00:00:01", true);
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (11, 1, "South China Sea", 1, "11:00", "18:30", "Eating", "You will be entitled to want anything you want and possibly bringing fresh fish back to your country!");
insert into ItineraryDetails(itineraryid, daynumber, location, activitynumber, timestart, timeend, activity, description)
values (11, 2, "South China Sea", 2, "08:30", "15:00", "Eating", "Eating with the fishes!");