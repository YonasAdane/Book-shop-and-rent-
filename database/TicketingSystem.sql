CREATE DATABASE letsgov1;
USE letsgov1;
CREATE TABLE User (
    UserID INT NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(50),
    UserEmail VARCHAR(30),
    UserAddress VARCHAR(50),
    UserPhone VARCHAR(50),
    UserPassword VARCHAR(100),
    PRIMARY KEY (UserID)
);
CREATE TABLE Driver (
    DriverID INT NOT NULL AUTO_INCREMENT,
    DriverName VARCHAR(50),
    DriverEmail VARCHAR(50),
    DriverPhone VARCHAR(20),
    DriverAddress VARCHAR(20),
    DriverPassword varchar(100),
    PRIMARY KEY (DriverID)
);
CREATE TABLE Route (
    RouteID INT NOT NULL AUTO_INCREMENT,
    StartLocation VARCHAR(50),
    EndLocation VARCHAR(50),
    Distance INT,
    PRIMARY KEY (RouteID)
);
CREATE TABLE BusCategory (
    BusCategoryID INT NOT NULL AUTO_INCREMENT,
    BusName VARCHAR(50),
    BusSeatNumbers INT,
    BusCategory VARCHAR(50),
    BusLevel VARCHAR(10),
    priceFactor DECIMAL(5,5) NOT NULL DEFAULT 0.76000,
    PRIMARY KEY (BusCategoryID)
);
CREATE TABLE Bus (
    BusID INT NOT NULL AUTO_INCREMENT,
    BusLevel VARCHAR(10),
    BusType VARCHAR(20),
    LicensePlate VARCHAR(10),
    CurrentCity VARCHAR(50),
    DriverID INT,
    SeatNumbers INT,
    RouteID INT,
    BusCategoryID INT ,
    PRIMARY KEY (BusID),
    FOREIGN KEY (DriverID) REFERENCES Driver(DriverID),
    FOREIGN KEY (RouteID) REFERENCES Route(RouteID),
    FOREIGN KEY (BusCategoryID) REFERENCES BusCategory(BusCategoryID)
);
CREATE TABLE Ticket (
    TicketID INT AUTO_INCREMENT,
    DepartureCity VARCHAR(50),
    DestinationCity VARCHAR(50),
    DepartureDateTime DATETIME NOT NULL,
    ArrivalDateTime DATETIME NOT NULL,
    Price REAL,
    SeatNumber INT NOT NULL,
    UserID INT,
    BusID INT,
    DriverID INT,
    PRIMARY KEY (TicketID),
    INDEX (SeatNumber),
    INDEX (Price),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (BusID) REFERENCES Bus(BusID),
    FOREIGN KEY (DriverID) REFERENCES Driver(DriverID)
);
CREATE TABLE Payment (
    PaymentID INT AUTO_INCREMENT,
    UserID INT,
    TicketID INT,
    PaymentMethod VARCHAR(20),
    Price REAL,
    TransactionDateTime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Status VARCHAR(20),
    PRIMARY KEY (PaymentID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID),
    FOREIGN KEY (Price) REFERENCES Ticket(Price)
);

CREATE TABLE Schedule (
    ScheduleID INT NOT NULL AUTO_INCREMENT,
    TravelingDate DATE NOT NULL,
    BusID INT NOT NULL,
    StartingTime TIME NOT NULL,
    TravelStatus ENUM('done', 'pending', 'failed') DEFAULT 'pending',
    PRIMARY KEY (ScheduleID),
    FOREIGN KEY (BusID) REFERENCES Bus(BusID)
);
CREATE TABLE Comments (
    CommentID INT NOT NULL AUTO_INCREMENT,
    UserID INT NOT NULL,
    CommentText TEXT NOT NULL,
    CommentDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (CommentID),
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);
INSERT INTO User (UserName, UserEmail, UserAddress, UserPhone, UserPassword)
VALUES
    ('Yohannes Gezachew', 'yohannes@example.com', '123 Addis Ababa', '1234567890', 'password1'),
    ('Fatima Ali', 'fatima@example.com', '456 Oromia', '9876543210', 'password2'),
    ('Ephrem Negash', 'ephrem@example.com', '789 Tigray', '5555555555', 'password3'),
    ('Aida Wondimu', 'aida@example.com', '321 Amhara', '1111111111', 'password4'),
    ('Abdullah Mohammed', 'abdullah@example.com', '654 Southern Nations, Nationalities, and Peoples', '9999999999', 'password5'),
    ('Sara Abate', 'sara@example.com', '987 Afar', '8888888888', 'password6'),
    ('Yordanos Tadesse', 'yordanos@example.com', '753 Somali', '7777777777', 'password7'),
    ('Hassan Omar', 'hassan@example.com', '852 Benishangul-Gumuz', '6666666666', 'password8'),
    ('Daniel Girma', 'daniel@example.com', '159 Dire Dawa', '5555555555', 'password9'),
    ('Selamawit Hailu', 'selamawit@example.com', '357 Gambela', '4444444444', 'password10'),
    ('Ibrahim Ahmed', 'ibrahim@example.com', '753 Harari', '3333333333', 'password11'),
    ('Betelhem Alemu', 'betelhem@example.com', '159 Sidama', '2222222222', 'password12'),
    ('Tsehay Solomon', 'tsehay@example.com', '357 SNNPR', '1111111111', 'password13'),
    ('Mohammed Ali', 'mohammed@example.com', '753 Addis Ababa', '9999999999', 'password14'),
    ('Amina Hassan', 'amina@example.com', '159 Oromia', '8888888888', 'password15'),
    ('Hassan Ahmed', 'hassan@example.com', '357 Tigray', '7777777777', 'password16'),
    ('Yasin Ali', 'yasin@example.com', '753 Jumeirah Rd, Dubai', '6666666666', 'password17'),
    ('Firdaws Omar', 'firdaws@example.com', '159 Oxford St, London', '5555555555', 'password18'),
    ('Layla Mohammed', 'layla@example.com', '357 Champs-Élysées, Paris', '4444444444', 'password19'),
    ('Ahmed Abdi', 'ahmed@example.com', '753 5th Avenue, New York', '3333333333', 'password20');
INSERT INTO Route (StartLocation, EndLocation, Distance)
VALUES
    ('Addis Ababa', 'Adama', 100),
    ('Adama', 'Dire Dawa', 400),
    ('Dire Dawa', 'Bahir Dar', 600),
    ('Bahir Dar', 'Hawassa', 300),
    ('Hawassa', 'Mekelle', 700),
    ('Mekelle', 'Gondar', 450),
    ('Gondar', 'Jimma', 550),
    ('Jimma', 'Addis Ababa', 250),
    ('Addis Ababa', 'Dire Dawa', 550),
    ('Dire Dawa', 'Hawassa', 450);
INSERT INTO Driver (DriverName, DriverEmail, DriverPhone, DriverAddress, DriverPassword)
VALUES
    ('Muhammed Samson', 'muhammed@example.com', '1234567890', 'Bole', 'password1'),
    ('Fahmi Dinsefa', 'fahmi@example.com', '9876543210', 'Adama', 'password2'),
    ('Nebiyu Musbah', 'nebiyu@example.com', '5555555555', 'Addis Ababa', 'password3'),
    ('Abel Gezu', 'abel@example.com', '1111111111', 'China', 'password1'),
    ('Asegid Adane', 'asegid@example.com', '9999999999', 'Dubai', 'password2'),
    ('Yohannes Gezachew', 'yohannes@example.com', '5555555555', 'Addis Ababa', 'password3');
CREATE VIEW DriverBuses AS
SELECT 
    d.DriverID, 
    d.DriverName, 
    d.DriverEmail, 
    d.DriverPhone, 
    b.BusID, 
    b.LicensePlate, 
    b.BusType, 
    b.CurrentCity
FROM 
    Driver d
JOIN 
    Bus b ON d.DriverID = b.DriverID;
CREATE VIEW RouteBuses AS
SELECT 
    r.RouteID, 
    r.StartLocation, 
    r.EndLocation, 
    r.Distance, 
    b.BusID, 
    b.LicensePlate, 
    b.BusType, 
    b.SeatNumbers, 
    bc.BusCategory, 
    bc.BusLevel
FROM 
    Route r
JOIN 
    Bus b ON r.RouteID = b.RouteID
JOIN 
    BusCategory bc ON b.BusCategoryID = bc.BusCategoryID;
CREATE VIEW TicketDetails AS
SELECT 
    t.TicketID, 
    t.DepartureCity, 
    t.DestinationCity, 
    t.DepartureDateTime, 
    t.ArrivalDateTime, 
    t.Price, 
    t.SeatNumber, 
    u.UserName, 
    u.UserEmail, 
    b.LicensePlate, 
    b.BusType
FROM 
    Ticket t
JOIN 
    User u ON t.UserID = u.UserID
JOIN 
    Bus b ON t.BusID = b.BusID;
CREATE VIEW PaymentDetails AS
SELECT 
    p.PaymentID, 
    p.PaymentMethod, 
    p.Price, 
    p.TransactionDateTime, 
    p.Status, 
    u.UserName, 
    u.UserEmail, 
    t.DepartureCity, 
    t.DestinationCity, 
    t.DepartureDateTime, 
    t.ArrivalDateTime
FROM 
    Payment p
JOIN 
    User u ON p.UserID = u.UserID
JOIN 
    Ticket t ON p.TicketID = t.TicketID;

INSERT INTO Driver (DriverName, DriverEmail, DriverPhone, DriverAddress, DriverPassword) VALUES
('John Doe', 'john.doe@example.com', '123-456-7890', '123 Elm St', 'password123'),
('Jane Smith', 'jane.smith@example.com', '234-567-8901', '456 Oak St', 'password456'),
('Alice Johnson', 'alice.johnson@example.com', '345-678-9012', '789 Pine St', 'password789'),
('Bob Brown', 'bob.brown@example.com', '456-789-0123', '101 Maple St', 'password101'),
('Charlie Davis', 'charlie.davis@example.com', '567-890-1234', '202 Birch St', 'password202'),
('Eve Adams', 'eve.adams@example.com', '678-901-2345', '303 Cedar St', 'password303');
INSERT INTO Route (StartLocation, EndLocation, Distance) VALUES
('City A', 'City B', 100),
('City C', 'City D', 200),
('City E', 'City F', 150),
('City G', 'City H', 120),
('City I', 'City J', 180),
('City K', 'City L', 210);
INSERT INTO BusCategory (BusName, BusSeatNumbers, BusCategory, BusLevel) VALUES
('Bus Alpha', 30, 'Economy', 'Level 1'),
('Bus Bravo', 45, 'Standard', 'Level 2'),
('Bus Charlie', 50, 'Premium', 'Level 3'),
('Bus Delta', 30, 'Economy', 'Level 1'),
('Bus Echo', 45, 'Standard', 'Level 2'),
('Bus Foxtrot', 50, 'Premium', 'Level 3');
INSERT INTO Bus (BusLevel, BusType, LicensePlate, CurrentCity, DriverID, SeatNumbers, RouteID, BusCategoryID) VALUES
('Level 1', 'Minibus', 'ABC123', 'City A', 1, 30, 1, 1),
('Level 2', 'Autobus', 'DEF456', 'City B', 2, 45, 2, 2),
('Level 3', 'Selambus', 'GHI789', 'City C', 3, 50, 3, 3),
('Level 1', 'Dolphine', 'JKL012', 'City D', 4, 30, 4, 4),
('Level 2', 'Minibus', 'MNO345', 'City E', 5, 45, 5, 5),
('Level 3', 'Autobus', 'PQR678', 'City F', 6, 50, 6, 6);




CREATE VIEW DriverBusInfo AS
SELECT
    d.DriverName,
    d.DriverID,
    d.DriverEmail,
    d.DriverAddress,
    d.DriverPhone,
    b.LicensePlate,
    b.BusType,
    b.BusLevel
FROM
    Driver d
left JOIN
    Bus b ON d.DriverID = b.DriverID;
CREATE VIEW BusDriverRouteView AS
SELECT 
    bc.BusName,
    d.DriverName,
    b.BusType,
    b.BusID,
    d.DriverID,
    r.StartLocation,
    r.EndLocation,
    r.RouteID
FROM 
    Bus b
JOIN 
    Driver d ON b.DriverID = d.DriverID
JOIN 
    BusCategory bc ON b.BusCategoryID = bc.BusCategoryID
JOIN 
    Route r ON b.RouteID = r.RouteID;
-- ALTER TABLE BusCategory
-- ADD COLUMN priceFactor DECIMAL(5,5) NOT NULL DEFAULT 0.76000;

CREATE VIEW UserTicketView AS
SELECT 
    Ticket.TicketID,
    Ticket.DepartureCity,
    Ticket.DestinationCity,
    Ticket.DepartureDateTime,
    Ticket.ArrivalDateTime,
    Ticket.Price,
    Ticket.SeatNumber,
    User.UserName,
    User.UserEmail,
    User.UserAddress,
    User.UserPhone,
    Bus.BusLevel,
    Bus.BusType,
    Bus.LicensePlate,
    Bus.CurrentCity,
    Driver.DriverName,
    Driver.DriverEmail,
    Driver.DriverPhone,
    Driver.DriverAddress,
    User.UserID,
    Bus.BusID,
    Driver.DriverID
FROM Ticket
JOIN User ON Ticket.UserID = User.UserID
JOIN Bus ON Ticket.BusID = Bus.BusID
JOIN Driver ON Ticket.DriverID = Driver.DriverID;

CREATE TABLE Admin (
    AdminID INT NOT NULL AUTO_INCREMENT,
    AdminName VARCHAR(50),
    AdminEmail VARCHAR(30),
    AdminPassword VARCHAR(100),
    PRIMARY KEY (AdminID)
);
-- INSERT INTO `driver`(`DriverEmail`,`DriverAddress`,`DriverName`,`DriverPhone`,`DriverPassword`) VALUES('zapi@gmail.com','addis ababa','Zapi Doja','09304212','123456');
DELETE FROM `driver` WHERE `DriverID`=15;
SELECT 
    Bus.BusID,
    Bus.BusLevel,
    Bus.BusType,
    Bus.LicensePlate,
    Bus.CurrentCity,
    Driver.DriverName,
    Route.StartLocation,
    Route.EndLocation,
    BusCategory.BusName,
    BusCategory.BusSeatNumbers,
    BusCategory.BusCategory
FROM 
    Bus
JOIN 
    Driver ON Bus.DriverID = Driver.DriverID
JOIN 
    Route ON Bus.RouteID = Route.RouteID
JOIN 
    BusCategory ON Bus.BusCategoryID = BusCategory.BusCategoryID LIMIT 100;
ALTER TABLE BusCategory
ADD COLUMN BusPicture LONGTEXT;
CREATE VIEW BDCRouteView AS
SELECT 
    bc.BusName,
    bc.BusPicture,
    d.DriverName,
    b.BusType,
    b.BusID,
    d.DriverID,
    r.StartLocation,
    r.EndLocation,
    r.RouteID
FROM 
    Bus b
JOIN 
    Driver d ON b.DriverID = d.DriverID
JOIN 
    BusCategory bc ON b.BusCategoryID = bc.BusCategoryID
JOIN 
    Route r ON b.RouteID = r.RouteID;
    use letsgov1;

ALTER TABLE Ticket ADD COLUMN ScheduleID INT;
ALTER TABLE Ticket ADD FOREIGN KEY (ScheduleID) REFERENCES Schedule(ScheduleID);
ALTER TABLE `buscategory` 
	CHANGE `priceFactor` `priceFactor` float NOT NULL DEFAULT 0.76 ;
INSERT INTO admin(AdminEmail,AdminPassword,AdminName) VALUES('admin@gmail.com','123456','admin');
