create database UsersOfOPENBBS;
show databases;
use UsersOfOPENBBS;
create table BaseInfOfUsers(SysID int NOT NULL AUTO_INCREMENT,Name varchar(15),Code varchar(40),Picture varchar(40),Root int(1),Rank int(8),Email varchar(50),Gender int(2),Age smallint,primary key(SysID));
create table PostOfUsers(PostID int NOT NULL AUTO_INCREMENT,IDofUsers int,Time varchar(20),IfFollow int(1),Title varchar(100),PostAdd text,FellowNum smallint,FellowAdd int,primary key(PostID));
