create database morsecode;
use morsecode;
create table code (id int primary key auto_increment, encoded varchar(255) not null, decoded varchar(255) not null);
