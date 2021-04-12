drop database if exists user;
create database user;
use user;

create table user(
emailaddr varchar(50) not null,
phonenumber int not null,
firstname varchar(50) not null,
lastname varchar(50) not null,
password varchar(50) not null,
country varchar(50) not null,
address varchar(95) not null,
role varchar(20) not null,
constraint user_pk primary key(emailaddr)
);

insert into user values ("admin@gmail.com", 91234567, "Admin", "Admin", "admin",  "singapore", "takashimaya", "admin");
insert into user values ("tim@gmail.com", 91234568, "timothy", "chia", "timothychia",  "united states", "white house", "user");
insert into user values ("yuhao.neo.2019@sis.smu.edu.sg", 91234569, "yuhao", "neo", "yuhaoneo",  "africa", "dirt", "user");