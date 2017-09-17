create database document_tracking_system;
use document_tracking_system;

create table doc(
	ID int primary key auto_increment,
	reference_date date not null,
    reference_no varchar(40),
    if_incoming enum('Y', 'N') not null,
    if_od enum('Y', 'N') not null,
    attach_name varchar(50),
    attach_image blob);
create table doc_code_list(
	doc_code_id int(3) primary key not null auto_increment,
	doc_code varchar(10) not null,
	doc_name varchar(50) not null);
	
create table doc_info(
	ID int,
	doc_code_id int(3),
	doc_info JSON,
	foreign key(ID) references doc(ID),
	foreign key(doc_code_id) references doc_code_list(doc_code_id));
	
create table doc_log(
	doc_ID int,
	status enum('IN', 'OUT', 'PENDING') not null,
	remarks_particulars varchar(50) not null,
	dateReceived_Transmitted date,
	sender_recipient varchar(30),
	updated_by varchar(30) not null,
	time_stamp time not null);
	
create table employee(
	employee_ID int(5) primary key auto_increment,
	name char(30) not null,
	gender char(1) not null,
	position char(20) not null,
	department char(20) not null);
    
create table admin(
	username varchar(40) not null,
    password varchar(40) not null);
    
create table users(
	userID int(9) NOT NULL auto_increment, 
	fullname VARCHAR(50) NOT NULL,
	username VARCHAR(40) NOT NULL,
	email VARCHAR(40) NOT NULL,
	password VARCHAR(100) NOT NULL, 
	PRIMARY KEY(userID));
