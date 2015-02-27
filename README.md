Portal-BBS
==========
1.简介

  OPEN-BBS是开源的论坛项目，目前以GPL协议第二版进行授权。
  本项目使用PHP进行开发，旨在实现设计与架构工作分离、基本功能模块化等特性，目标是打造轻量级的社区门户交流平台。

2.使用指南

2.1 环境要求
  Apache: >= 2.0
  PHP: >= 5.0.0
  MySQL: >= 4.1.0
  phpMyAdmin(推荐): >=4.0

2.2 快速安装

Windows:
  1.从GITHUB上获取项目文件(https://github.com/NJUOPEN/Portal-BBS/)，点击Download ZIP即可下载；
  2.安装WAMP，配置服务器(参考http://jingyan.baidu.com/article/22fe7ced7ba5403003617f60.html)；
  3.将下载的Portal-BBS-master中src文件夹的内容复制到WAMP的www文件夹下(覆盖粘贴)；
  4.在WAMP的www文件夹中，根据wamp配置编辑config.php。例如，你的MySQL用户名为user，密码为password，则修改以下两行
	define('SQL_ACCOUNT','root');
	define('SQL_PASSWORD','');
  为
	define('SQL_ACCOUNT','user');
	define('SQL_PASSWORD','password');
  5.导入“数据库/数据库创建信息”文件夹下的“BuildOPENBBS.sql”，可以使用WAMP自带的phpMyAdmin；
  6.在浏览器里访问127.0.0.1，即可浏览论坛页面。

Linux:
  1.从GITHUB上获取项目文件(https://github.com/NJUOPEN/Portal-BBS/)；
  2.安装apache、PHP、MySQL；
  3.配置apache，为项目文件夹分配一个前端路径；
  4.修改config.php，将SQL_HOST、SQL_ACCOUNT、SQL_PASSWORD更改成对应的前端路径、数据库用户名和密码；
  5.导入“数据库/数据库创建信息”文件夹下的“BuildOPENBBS.sql”，可使用phpMyAdmin；
  6.在浏览器里访问127.0.0.1，即可浏览论坛页面。