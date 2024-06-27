-- Active: 1703351512910@@127.0.0.1@3306@ticketingsystemdb2

CREATE DATABASE TicketingSystemDB2;
USE TicketingSystemDB2;

-- User table: Stores information about users who interact with the system
CREATE TABLE User (
    UserID INT NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(50),
    UserEmail VARCHAR(30),
    UserAddress VARCHAR(50),
    UserPhone VARCHAR(50),
    UserPassword VARCHAR(100),
    PRIMARY KEY (UserID)
);
CREATE TABLE Admin (
    AdminID INT NOT NULL AUTO_INCREMENT,
    AdminName VARCHAR(50),
    AdminEmail VARCHAR(30),
    AdminPassword VARCHAR(100),
    PRIMARY KEY (AdminID)
);

-- Driver table: Stores information about bus drivers
CREATE TABLE Driver (
    DriverID INT NOT NULL AUTO_INCREMENT,
    DriverName VARCHAR(50),
    DriverEmail VARCHAR(50),
    DriverPhone VARCHAR(20),
    DriverAddress VARCHAR(20),
    DriverPassword varchar(100),
    PRIMARY KEY (DriverID)
);

-- Route table: Stores locations between which a bus can drive
CREATE TABLE Route (
    RouteID INT NOT NULL AUTO_INCREMENT,
    StartLocation VARCHAR(50),
    EndLocation VARCHAR(50),
    Distance INT,
    PRIMARY KEY (RouteID)
);

-- Bus table: Records details about buses available in the system
-- Create the BusCategory table
CREATE TABLE BusCategory (
    BusCategoryID INT NOT NULL AUTO_INCREMENT,
    BusName VARCHAR(50),
    BusSeatNumbers INT,
    BusCategory VARCHAR(50),
    BusLevel VARCHAR(10),
    PRIMARY KEY (BusCategoryID)
);
ALTER TABLE BusCategory
ADD COLUMN priceFactor DECIMAL(5,5) NOT NULL DEFAULT 0.76000;

ALTER TABLE BusCategory
ADD COLUMN BusPicture LONGTEXT;

-- ALTER TABLE BusCategory
-- ADD COLUMN BusPicture LONGTEXT DEFAULT 'https://img.pikbest.com/png-images/qiantu/orange-vector-cartoon-bus-free_2601110.png!sw800';

-- Create the Bus table
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


-- Ticket table: Represents individual tickets booked by users
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
ALTER TABLE Ticket ADD COLUMN ScheduleID INT;

-- Reservation table: Stores information about reservations made by users
CREATE TABLE Reservation (
    ReservationID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    TicketID INT,
    SeatNumber INT NOT NULL,
    ReservationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID),
    FOREIGN KEY (SeatNumber) REFERENCES Ticket(SeatNumber)
);

-- Payment table: Records payments made by users for their tickets
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

-- Transaction table: Records various transactions related to users
CREATE TABLE Transaction (
    TransactionID INT AUTO_INCREMENT,
    UserID INT,
    Price REAL,
    TransactionDateTime DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    TransactionType VARCHAR(20),
    PRIMARY KEY (TransactionID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
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
    BusCategory ON Bus.BusCategoryID = BusCategory.BusCategoryID;

-- Insert data into the User table
SELECT * from route;
INSERT INTO admin(AdminEmail,AdminPassword,AdminName) VALUES('root@ticket.com','root','root');
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
    
-- ALTERING DRIVER TABLE BY ADDING AN ATTRIBUTE DriverPassword IN TO IT
-- ALTER TABLE Driver ADD COLUMN DriverPassword varchar(20);
-- Insert data into the Route table

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
-- Insert data into the Driver table
SELECT * from bus;
INSERT INTO Driver (DriverName, DriverEmail, DriverPhone, DriverAddress, DriverPassword)
VALUES
    ('Muhammed Samson', 'muhammed@example.com', '1234567890', 'Bole', 'password1'),
    ('Fahmi Dinsefa', 'fahmi@example.com', '9876543210', 'Adama', 'password2'),
    ('Nebiyu Musbah', 'nebiyu@example.com', '5555555555', 'Addis Ababa', 'password3'),
    ('Abel Gezu', 'abel@example.com', '1111111111', 'China', 'password1'),
    ('Asegid Adane', 'asegid@example.com', '9999999999', 'Dubai', 'password2'),
    ('Yohannes Gezachew', 'yohannes@example.com', '5555555555', 'Addis Ababa', 'password3');


-- Insert data into the Ticket table
-- INSERT INTO Ticket (DepartureCity, DestinationCity, DepartureDateTime, ArrivalDateTime, Price, SeatNumber, UserID, DriverID)
-- VALUES
--     ('Addis Ababa', 'Dire Dawa', '2024-02-01 08:00:00', '2024-02-01 16:00:00', 150.00, 10, 1, 1),
--     ('Bishoftu', 'Adama', '2024-02-02 09:30:00', '2024-02-02 18:00:00', 180.00, 15, 2, 2),
--     ('Mekelle', 'Jimma', '2024-02-03 11:15:00', '2024-02-03 20:30:00', 200.00, 20, 3, 3),
--     ('Bahir Dar', 'Arba Minch', '2024-02-04 10:45:00', '2024-02-04 19:15:00', 170.00, 12, 4, 4),
--     ('Bishoftu', 'Dessie', '2024-02-05 12:30:00', '2024-02-05 21:45:00', 190.00, 18, 5, 5),
--     ('Adama', 'Sodo', '2024-02-06 14:20:00', '2024-02-06 23:30:00', 160.00, 8, 6, 6);

INSERT INTO BusCategory (BusName, BusSeatNumbers, BusCategory, BusLevel)
VALUES
    ('Coach', 50, 'Regular', 'Level 1'),
    ('Mini Bus', 30, 'Regular', 'Level 2'),
    ('Abadulla', 20, 'Premium', 'Level 3'),
    ('Dolphine', 40, 'Regular', 'Level 1'),
    ('Selambus', 10, 'Premium', 'Level 2'),
    ('Oda Bus', 25, 'Premium', 'Level 3'),
    ('Geda Bus', 35, 'Regular', 'Level 1'),
    ('Air Bus', 15, 'Regular', 'Level 2'),
    ('Isizu', 45, 'Regular', 'Level 3'),
    ('Hiace', 20, 'Premium', 'Level 1');


-- Insert data into the Bus table
INSERT INTO Bus (BusLevel, BusType, LicensePlate, CurrentCity, DriverID, SeatNumbers, RouteID, BusCategoryID)
VALUES
    ('Level 1', 'Coach', 'ABC123', 'Addis Ababa', 1, 50, 1, 1),
    ('Level 2', 'Mini Bus', 'DEF456', 'Adama', 2, 20, 2, 2),
    ('Level 3', 'Sleeper Bus', 'GHI789', 'Dire Dawa', 3, 30, 3, 3),
    ('Level 1', 'Coach', 'JKL012', 'Bahir Dar', 4, 50, 4, 1),
    ('Level 2', 'Mini Bus', 'MNO345', 'Hawassa', 5, 20, 5, 2),
    ('Level 3', 'Sleeper Bus', 'PQR678', 'Mekelle', 6, 30, 6, 3),
    ('Level 1', 'Coach', 'STU901', 'Gondar', 1, 50, 7, 1),
    ('Level 2', 'Mini Bus', 'VWX234', 'Jimma', 2, 20, 8, 2),
    ('Level 3', 'Sleeper Bus', 'YZA567', 'Addis Ababa', 3, 30, 9, 3),
    ('Level 1', 'Coach', 'BCD890', 'Dire Dawa', 4, 50, 10, 1);

                                                                            

-- Insert data into the Reservation table
-- INSERT INTO Reservation (UserID, TicketID, SeatNumber)
-- VALUES
--     (1, 1, 10),
--     (2, 2, 15),
--     (3, 3, 20),
--     (4, 4, 12),
--     (5, 5, 18),
--     (6, 6, 8);

-- Insert data into the Payment table with different payment methods
-- INSERT INTO Payment (UserID, TicketID, PaymentMethod, Price, Status)
-- VALUES
--     (1, 1, 'Telebirr', 150.00, 'Paid'),
--     (2, 2, 'CBE', 180.00, 'Paid'),
--     (3, 3, 'Cash', 200.00, 'Paid'),
--     (4, 4, 'Telebirr', 170.00, 'Paid'),
--     (5, 5, 'Cash', 190.00, 'Paid'),
--     (6, 6, 'CBE', 160.00, 'Paid');
-- alter table buscategory add priceFactor 
-- Insert data into the Transaction table for payments
-- INSERT INTO Transaction (UserID, price, TransactionType)
-- VALUES
--     (1, 150.00, 'Payment'),
--     (2, 180.00, 'Payment'),
--     (3, 200.00, 'Payment'),
--     (4, 170.00, 'Payment'),
--     (5, 190.00, 'Payment'),
--     (6, 160.00, 'Payment');
-- Insert sample data into Driver table
INSERT INTO Driver (DriverName, DriverEmail, DriverPhone, DriverAddress, DriverPassword) VALUES
('John Doe', 'john.doe@example.com', '123-456-7890', '123 Elm St', 'password123'),
('Jane Smith', 'jane.smith@example.com', '234-567-8901', '456 Oak St', 'password456'),
('Alice Johnson', 'alice.johnson@example.com', '345-678-9012', '789 Pine St', 'password789'),
('Bob Brown', 'bob.brown@example.com', '456-789-0123', '101 Maple St', 'password101'),
('Charlie Davis', 'charlie.davis@example.com', '567-890-1234', '202 Birch St', 'password202'),
('Eve Adams', 'eve.adams@example.com', '678-901-2345', '303 Cedar St', 'password303');

-- Insert sample data into Route table
INSERT INTO Route (StartLocation, EndLocation, Distance) VALUES
('City A', 'City B', 100),
('City C', 'City D', 200),
('City E', 'City F', 150),
('City G', 'City H', 120),
('City I', 'City J', 180),
('City K', 'City L', 210);

-- Insert sample data into BusCategory table
INSERT INTO BusCategory (BusName, BusSeatNumbers, BusCategory, BusLevel) VALUES
('Bus Alpha', 30, 'Economy', 'Level 1'),
('Bus Bravo', 45, 'Standard', 'Level 2'),
('Bus Charlie', 50, 'Premium', 'Level 3'),
('Bus Delta', 30, 'Economy', 'Level 1'),
('Bus Echo', 45, 'Standard', 'Level 2'),
('Bus Foxtrot', 50, 'Premium', 'Level 3');

-- Insert sample data into Bus table
INSERT INTO Bus (BusLevel, BusType, LicensePlate, CurrentCity, DriverID, SeatNumbers, RouteID, BusCategoryID) VALUES
('Level 1', 'Minibus', 'ABC123', 'City A', 1, 30, 1, 1),
('Level 2', 'Autobus', 'DEF456', 'City B', 2, 45, 2, 2),
('Level 3', 'Selambus', 'GHI789', 'City C', 3, 50, 3, 3),
('Level 1', 'Dolphine', 'JKL012', 'City D', 4, 30, 4, 4),
('Level 2', 'Minibus', 'MNO345', 'City E', 5, 45, 5, 5),
('Level 3', 'Autobus', 'PQR678', 'City F', 6, 50, 6, 6);

-- -- ------------------------------------------------------ Transaction ---------------------------------------------------------
-- use TicketingSystemDB2;
-- START TRANSACTION;
-- -- Step 1: User Registration
-- INSERT INTO User (UserName, UserEmail, UserAddress, UserPhone, UserPassword)
-- VALUES ('Yonas Zekarias', 'yonas.zekarias@example.com', '123 Main St', '555-1234', 'password123');

-- -- Get the ID of the newly added user
-- SET @yonasUserId = LAST_INSERT_ID();

-- -- Display the details of the new user
-- SELECT * FROM User WHERE UserID = @yonasUserId;

-- -- Step 2: Ticket Selection
-- SET @selectedTicketId = 1;  

-- -- Display the available ticket details
-- SELECT * FROM Ticket WHERE TicketID = @selectedTicketId;

-- -- Step 3: Reservation
-- -- User makes a reservation
-- INSERT INTO Reservation (UserID, TicketID, SeatNumber)
-- VALUES (@yonasUserId, @selectedTicketId, 15);  -- we can enter desired seat number

-- -- Display the reservation details
-- SELECT * FROM Reservation WHERE UserID = @yonasUserId;

-- -- Step 4: Payment
-- SET @paymentMethod = 'Telebirr';  

-- -- user makes payment
-- INSERT INTO Payment (UserID, TicketID, PaymentMethod, Price, Status)
-- VALUES (@yonasUserId, @selectedTicketId, @paymentMethod, 150.00, 'Paid');

-- -- Step 4: Transaction

-- -- Record the payment transaction
-- INSERT INTO Transaction (UserID, Price, TransactionType)
-- VALUES (@yonasUserId, @ticketPrice, 'Payment');
-- -- Display the transaction history for the user
-- SELECT * FROM Transaction WHERE UserID = @yonasUserId;
-- COMMIT;
    
-- select * FROM schedule;
    -- Add multiple schedules for buses
    -- SELECT * FROM Schedule WHERE BusID = 11;
INSERT INTO Schedule (TravelingDate, BusID, StartingTime, TravelStatus) VALUES
    ('2024-06-01', 11, '08:00:00', 'pending'),
    ('2024-06-02', 11, '08:00:00', 'pending'),
    ('2024-06-01', 12, '09:00:00', 'pending'),
    ('2024-06-02', 12, '09:00:00', 'pending'),
    ('2024-06-02', 13, '10:00:00', 'pending'),
    ('2024-06-03', 13, '10:00:00', 'pending'),
    ('2024-06-02', 14, '11:00:00', 'pending'),
    ('2024-06-03', 14, '11:00:00', 'pending'),
    ('2024-06-03', 15, '12:00:00', 'pending'),
    ('2024-06-04', 15, '12:00:00', 'pending'),
    ('2024-06-03', 16, '13:00:00', 'pending'),
    ('2024-06-04', 16, '13:00:00', 'pending'),
    ('2024-06-04', 17, '14:00:00', 'pending'),
    ('2024-06-05', 17, '14:00:00', 'pending'),
    ('2024-06-04', 18, '15:00:00', 'pending'),
    ('2024-06-05', 18, '15:00:00', 'pending');

-- ------------------------------------------------------ View  --------------------------------------------------------------------------------------------
    --This view combines user information with reservation details.
CREATE VIEW UserReservations AS
SELECT 
    u.UserID, 
    u.UserName, 
    u.UserEmail, 
    u.UserPhone, 
    r.ReservationID, 
    r.SeatNumber, 
    r.ReservationDateTime, 
    t.DepartureCity, 
    t.DestinationCity, 
    t.DepartureDateTime, 
    t.ArrivalDateTime
FROM 
    User u
JOIN 
    Reservation r ON u.UserID = r.UserID
JOIN 
    Ticket t ON r.TicketID = t.TicketID;

--provid information about drivers and the buses they are assigned to.
CREATE VIEW DriverBusInfo AS
SELECT
    d.DriverName,
    d.DriverEmail,
    d.DriverAddress,
    d.DriverPhone,
    b.LicensePlate,
    b.BusType,
    b.BusLevel
FROM
    Driver d
LEFT JOIN
    Bus b ON d.DriverID = b.DriverID;

SELECT * FROM DriverBusInfo;
-- combine route information with details of buses operating on those routes.
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
-- provide comprehensive ticket information including user and bus details.
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
-- combine payment details with corresponding user and ticket information.
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
--provide transaction details along with user information.
CREATE VIEW TransactionDetails AS
SELECT 
    tr.TransactionID, 
    tr.Price, 
    tr.TransactionDateTime, 
    tr.TransactionType, 
    u.UserName, 
    u.UserEmail
FROM 
    Transaction tr
JOIN 
    User u ON tr.UserID = u.UserID;

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

    -- SELECT * FROM driverbusinfo ;
USE TicketingSystemDB2;

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

-- SELECT * FROM BusDriverRouteView;
-- SELECT * FROM Schedule ;
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

SELECT * from UserTicketView where UserID=1;
-- ------------------------------------------------------ Procedure  --------------------------------------------------------------------------------------------
-- SELECT DriverID, DriverName FROM Driver WHERE DriverID NOT IN (SELECT DriverID FROM Bus);
-- SELECT d.DriverID, d.DriverName, d.DriverEmail, d.DriverPhone, d.DriverAddress
-- FROM Driver d
-- LEFT JOIN Bus b ON d.DriverID = b.DriverID
-- WHERE b.DriverID IS NULL;

-- ------------------------------------------------------ Triggers  --------------------------------------------------------------------------------------------

-- -- A Table To store Audit Information for a specifc table
-- CREATE TABLE AuditTrail (
--     AuditID INT AUTO_INCREMENT,
--     Action VARCHAR(10),     
--     TableName VARCHAR(50),   
--     RecordID INT,            
--     Timestamp DATETIME,      
--     PRIMARY KEY (AuditID)
-- );
 
--  -- Trigger for User table
-- DELIMITER //
-- CREATE TRIGGER User_Audit
-- AFTER INSERT ON User
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('INSERT', 'User', NEW.UserID, NOW());
-- END;
-- //

-- DELIMITER ;

-- DELIMITER //
-- CREATE TRIGGER User_Audit_Update
-- AFTER UPDATE ON User
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('UPDATE', 'User', NEW.UserID, NOW());
-- END;
-- //

-- DELIMITER ;

-- DELIMITER //
-- CREATE TRIGGER User_Audit_Delete
-- AFTER DELETE ON User
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('DELETE', 'User', OLD.UserID, NOW());
-- END;
-- //

-- DELIMITER ;

-- -- Trigger for Driver table
-- DELIMITER //
-- CREATE TRIGGER Driver_Audit
-- AFTER INSERT ON Driver
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('INSERT', 'Driver', NEW.DriverID, NOW());
-- END;
-- //

-- DELIMITER ;


-- DELIMITER //
-- CREATE TRIGGER Driver_Audit_Update
-- AFTER UPDATE ON Driver
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('UPDATE', 'Driver', NEW.DriverID, NOW());
-- END;
-- //

-- DELIMITER ;


-- DELIMITER //
-- CREATE TRIGGER Driver_Audit_Delete
-- AFTER DELETE ON Driver
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('DELETE', 'Driver', OLD.DriverID, NOW());
-- END;
-- //

-- DELIMITER ;

-- -- Trigger for Ticket table
-- DELIMITER //
-- CREATE TRIGGER Ticket_Audit
-- AFTER INSERT ON Ticket
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('INSERT', 'Ticket', NEW.TicketID, NOW());
-- END;
-- //

-- DELIMITER ;


-- DELIMITER //
-- CREATE TRIGGER Ticket_Audit_Update
-- AFTER UPDATE ON Ticket
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('UPDATE', 'Ticket', NEW.TicketID, NOW());
-- END;
-- //

-- DELIMITER ;


-- DELIMITER //
-- CREATE TRIGGER Ticket_Audit_Delete
-- AFTER DELETE ON Ticket
-- FOR EACH ROW
-- BEGIN
--     INSERT INTO AuditTrail (Action, TableName, RecordID, Timestamp)
--     VALUES ('DELETE', 'Ticket', OLD.TicketID, NOW());
-- END;
-- //
-- DELIMITER ;

-- SHOW TRIGGERS;

-- -- ---------------------------------------------------- Security ------------------------------------------------------------------------------

-- -- Yonas
-- CREATE USER 'Yonas'@'localhost' IDENTIFIED BY '12345678';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.User TO 'Yonas'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Driver TO 'Yonas'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Payment TO 'Yonas'@'localhost';

-- SHOW GRANTS FOR 'Yonas'@'localhost';

-- -- Naol
-- CREATE USER 'Naol'@'localhost' IDENTIFIED BY '12345678';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Bus TO 'Naol'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Reservation TO 'Naol'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Ticket TO 'Naol'@'localhost';

-- SHOW GRANTS FOR 'Naol'@'localhost';

-- -- Abuzer
-- CREATE USER 'Abuzer'@'localhost' IDENTIFIED BY '12345678';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.User TO 'Abuzer'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Driver TO 'Abuzer'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Bus TO 'Abuzer'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Ticket TO 'Abuzer'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Reservation TO 'Abuzer'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Payment TO 'Abuzer'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON TicketingSystemDB2.Transaction TO 'Abuzer'@'localhost';

-- SHOW GRANTS FOR 'Abuzer'@'localhost';
