create database adromindsmobile;

CREATE TABLE Profile(
	ID int AUTO_INCREMENT primary key,
	Name varchar(50) NOT NULL,
	Company varchar(150) NOT NULL,
	Email varchar(50) NOT NULL,
	Mobile varchar(10) NOT NULL,
	Address varchar(500) NULL,
	GST varchar(50) NULL,
	Logo varchar(100) Null,
	Landline varchar(15) Null,
	Website varchar(50) Null,
	AccountNumber varchar(15) Null,
	Branchname varchar(20) Null,
	Bankname varchar(20) Null,
	Ifsc varchar(15) Null,
	CreatedDate TIMESTAMP default current_timestamp,
	ModifiedDate TIMESTAMP default current_timestamp on update current_timestamp,
	unique(Email)
);

Create Table Login (
	Id int primary key auto_increment,
	Email varchar(50) not null,
	Password varchar(350) not null,
	IsSlave bit default 0,
	CreatedDate TIMESTAMP default current_timestamp,
	ModifiedDate TIMESTAMP default current_timestamp on update current_timestamp
);

Create table activities (
	id int AUTO_INCREMENT PRIMARY key,
	Date varchar(15) not null,
	Type varchar(25) not null,
	Category varchar(25) not null,
	Model varchar(25) not null,
	IMEI varchar(40) not null,
	Storage varchar(10) not null,
	RAM varchar(10) not null,
	Color varchar(20) not null,
	Client varchar(50) not null,
	Price decimal(10, 0) not null,
	Phone varchar(10) not null,
	Status bit default 0,
	Notes varchar(100),
	AddedBy varchar(50) not null,
	AddedDate timestamp default current_timestamp(),
	ModifiedBy varchar(10) not null,
	ModifiedDate TIMESTAMP default current_timestamp on update current_timestamp
);

create table Expense(
	id int AUTO_INCREMENT PRIMARY key,
	date varchar(15) not null,
	category varchar(25) not null,
	price decimal(10, 0) not null,
	notes varchar(50) not null,
	isactive bit(1) default 0,
	createdby varchar(50) not null,
	CreatedDate TIMESTAMP default current_timestamp,
	modifiedby varchar(50) not null,
	ModifiedDate TIMESTAMP default current_timestamp on update current_timestamp
);


--SELECT count(*) as totalcount, sum(Price) as totalamount FROM `activities` where Category = 'in' and type = 'sales in' and date between '01/09/2020' and '30/09/2020';

-- SELECT count(*) as totalcount, sum(Price) as totalamount FROM `activities` where Category = 'out' and type = 'sales out' and date between '01/09/2020' and '30/09/2020';

--SELECT count(*) as totalcount, sum(Price) as totalamount FROM `activities` where Category = 'in' and type = 'service in' and date between '01/09/2020' and '30/09/2020';

--SELECT count(*) as totalcount, sum(Price) as totalamount FROM `activities` where Category = 'out' and type = 'service out' and date between '01/09/2020' and '30/09/2020';

-- SELECT sum(price) as totalexpense FROM `expense` where date between '01/09/2020' and '30/09/2020';