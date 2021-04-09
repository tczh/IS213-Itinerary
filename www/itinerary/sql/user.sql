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

insert into user values ("elvis@gmail.com", 98789971, "elvis", "leong", "elvisleong",  "singapore", "takashimaya", "admin");
insert into user values ("tim@gmail.com", 999, "timothy", "chia", "timothychia",  "united states", "white house", "user");
insert into user values ("yuhao.neo.2019@sis.smu.edu.sg", 123, "yuhao", "neo", "yuhaoneo",  "africa", "dirt", "user");