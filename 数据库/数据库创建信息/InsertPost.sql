use UsersOfOPENBBS;
show tables;
insert into PostOfUsers values(
	7,	#PostID
	4,	#IDofUsers
	'2014-10-3 16:18:00',	#Time
	0,	#IfFollow
	'first',	#Title
	'Hello world!',	#PostAdd
	1,	#FollowNum
	0,	#FollowAdd
	1	#SectionID
);
insert into PostOfUsers values(
	8,
	4,
	'2014-10-3 16:18:00',
	1,
	'second',
	'Hello!',
	0,
	7,
	1
);