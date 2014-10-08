create database UsersOfOPENBBS;
show databases;
use UsersOfOPENBBS;
create table BaseInfOfUsers(SysID int NOT NULL AUTO_INCREMENT,Name varchar(15),Code varchar(40),Picture varchar(40),Root int(1),Rank int(8),
Email varchar(50),Gender int(2),Age smallint,primary key(SysID));
create table PostOfUsers(PostID int NOT NULL AUTO_INCREMENT,IDofUsers varchar(7),Time varchar(20),IfFollow int(2),PostAdd varchar(20),
FellowNum int(255),FellowAdd varchar(20),primary key(PostID));
