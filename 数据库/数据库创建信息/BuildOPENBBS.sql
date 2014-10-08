create database UsersOfOPENBBS;
show databases;
use UsersOfOPENBBS;
create table BaseInfOfUsers(SysID int NOT NULL AUTO_INCREMENT,Name varchar(10),Code varchar(16),Picture varchar(15),Root int(2),Rank int(8),
Email varchar(5),Gender int(2),Age int(200),primary key(SysID));
create table PostOfUsers(PostID int NOT NULL AUTO_INCREMENT,IDofUsers varchar(7),Time varchar(20),IfFollow int(2),PostAdd varchar(20),
FellowNum int(255),FellowAdd varchar(20),primary key(PostID),foreign key (IDofUsers) references BaseInfOfUsers (SysID));
