create database onlinechat_db;
use onlinechat_db;

CREATE TABLE applicant_record(
id int not null AUTO_INCREMENT,
    applicant_number varchar(80) not null UNIQUE,
    surname varchar(50) not null,
    firstname varchar(50) not null,
    othername varchar(50) null DEFAULT '',
    email_one varchar(100) not null UNIQUE,
    email_two varchar(100) null DEFAULT '',
    phoneCode varchar(20) not null,
    phone_one varchar(50) not null UNIQUE,
    phone_two varchar(50) null DEFAULT '',
    gender_id  int null DEFAULT 0,
    dob varchar(10) not null DEFAULT 0,
    mob varchar(10) null DEFAULT 0,
    yob varchar(10) null DEFAULT 0,
    age varchar(10) null DEFAULT 0,
    language_code varchar(20) null DEFAULT '',
    pwd_auth_hash varchar(80) null DEFAULT '',
    pwd_auth varchar(80) null DEFAULT '',
    status_id INT NOT NULL DEFAULT 1,
    record_status int not null DEFAULT 1,
    visibility int not null DEFAULT 1,
    created_by int not null,
    modified_by int not null,
    date_login date null,
    time_login time null,
    date_created date not null,
    time_created time not null,
    date_modified date not null,
    time_modified time not null,
    PRIMARY KEY(id)
);


CREATE TABLE IF NOT EXISTS chats_tbl(
id int not null AUTO_INCREMENT,
    user_chat_id varchar(80) not null,
    chatSessionID varchar(100) not null,
    attendant_id int not null DEFAULT 0,
    status_id INT NOT NULL DEFAULT 1,
    record_status int not null DEFAULT 1,
    visibility int not null DEFAULT 1,
    date_created date not null,
    time_created time not null,
    date_modified date not null,
    time_modified time not null,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS message_tbl(
id int not null AUTO_INCREMENT,
    chatSessionID varchar(100) not null,
    attendant_id int not null DEFAULT 0,
    message_text TEXT,
    status_id INT NOT NULL DEFAULT 1,
    record_status int not null DEFAULT 1,
    visibility int not null DEFAULT 1,
    date_created date not null,
    time_created time not null,
    date_modified date not null,
    time_modified time not null,
    PRIMARY KEY(id)
);