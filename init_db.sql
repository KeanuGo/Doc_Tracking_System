create database document_tracking_system;
use document_tracking_system;

create table doc(
	ID int primary key auto_increment,
	reference_date date not null);
	
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
	date_updated date not null,
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
	password VARCHAR(40) NOT NULL, 
	PRIMARY KEY(userID));
    
use document_tracking_system;
CREATE VIEW `Incoming_Doc_Log` AS
select doc_log.doc_id as ID,
	concat('IN', convert(doc_log.doc_id, char(5))) as Incoming_ID,
	doc_log.dateReceived_Transmitted,
	doc_log.sender_recipient,
	doc_code_list.doc_code,
	doc.reference_date,
	doc_log.remarks_particulars
from 
	doc_log, doc_code_list, doc, doc_info
where
	doc.id = doc_info.id and
    doc_info.doc_code_id = doc_code_list.doc_code_id and
    doc_log.status='IN';
    
use document_tracking_system;
CREATE VIEW `Outgoing_Doc_Log` AS
select doc_log.doc_id,
	concat('OUT', convert(doc_log.doc_id, CHAR(5))) as Outgoing_ID,
	incoming_doc_log.Incoming_ID,
	doc_log.dateReceived_Transmitted,
	doc_log.sender_recipient,
	doc_code_list.doc_code,
	doc.reference_date,
	doc_log.remarks_particulars
from 
	doc_log, doc_code_list, doc, doc_info, incoming_doc_log
where
	incoming_doc_log.ID = doc_log.doc_id and
	doc.id = doc_info.id and
    doc_info.doc_code_id = doc_code_list.doc_code_id and
    doc_log.status='OUT';
    