
# LetsGO ticketing System

## Overview

LetsGO ticketing System is a web application that allows users to book bus tickets online, view schedules, and manage their profiles. Admins can manage buses, routes, schedules, and users. Drivers can view their assigned routes and validate tickets.

## Features

- User Registration and Login
- View and Book Bus Tickets
- View Booking History
- Profile Management
- Admin Dashboard to Manage Buses,Drivers, Routes, and Schedules
- Driver Dashboard to View Assigned Routes and Validate Tickets
- Generate and Validate QR Codes for Tickets

## Technologies Used

- PHP
- MySQL
- HTML
- CSS (TailwindCSS)
- JavaScript

## Database Schema

### User Table
```sql
CREATE TABLE User (
    UserID INT NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(50),
    UserEmail VARCHAR(30),
    UserAddress VARCHAR(50),
    UserPhone VARCHAR(50),
    UserPassword VARCHAR(100),
    PRIMARY KEY (UserID)
);
```

### Admin Table
```sql
CREATE TABLE Admin (
    AdminID INT NOT NULL AUTO_INCREMENT,
    AdminName VARCHAR(50),
    AdminEmail VARCHAR(30),
    AdminPassword VARCHAR(100),
    PRIMARY KEY (AdminID)
);
```

### Driver Table
```sql
CREATE TABLE Driver (
    DriverID INT NOT NULL AUTO_INCREMENT,
    DriverName VARCHAR(50),
    DriverEmail VARCHAR(50),
    DriverPhone VARCHAR(20),
    DriverAddress VARCHAR(20),
    DriverPassword VARCHAR(100),
    PRIMARY KEY (DriverID)
);
```

### BusCategory Table
```sql
CREATE TABLE BusCategory (
    BusCategoryID INT NOT NULL AUTO_INCREMENT,
    BusName VARCHAR(50),
    BusSeatNumbers INT,
    BusCategory VARCHAR(50),
    BusLevel VARCHAR(10),
    PriceFactor DECIMAL(5,5) NOT NULL DEFAULT 0.76000,
    PRIMARY KEY (BusCategoryID)
);
```
### Other Tables
- `Route`
- `Schedule`
- `Bus`
- `Ticket`
- `Payment`

Refer to the SQL scripts provided in the project for detailed table structures.

## Installation

1. **Clone the Repository:**
    ```bash
    git clone https://github.com/YonasAdane/LetsGO_bus_Ticketing.git
    ```

2. **Navigate to the Project Directory:**
    ```bash
    cd LetsGO_bus_Ticketing
    ```

3. **Set Up the Database:**
   - Import the SQL scripts provided in the `database` directory into your MySQL database.

4. **Configure the Database Connection:**
   - Update the database connection details in `database/connection.php`.

5. **Start the Server:**
   - Use a local server (like XAMPP, WAMP, or MAMP) to run the application.

## Usage

#### User Registration and Login

- Users can register an account and log in using their email and password.

##### Booking a Ticket

- Once logged in, users can view available buses and schedules, select a travel date and time, choose seats, and book tickets.

##### Driver Dashboard

- Drivers can log in to view their assigned routes,buse and Schedules.

##### Watch Customers

- Drivers can log in to view their assigned customers by selecting the schedules.
  
##### Scan Ticket

- Drivers can validate tickets using QR codes.
  
##### Admin Dashboard

- Admins can log in and watch the report and all users
##### View Drivers and Add Driver

- Admins can watch or Search driver,add and delete Driver.the sesarch is done by Driver Name,Driver Adress,Driver phoneNumber and Driver Email.
##### Buses and Add Bus

- Admins can add schedule,remove schedule,update Schedule,create Schedule by watching and selecting Buses.the admin can also add bus by selecting the add bus option from the navigation.
##### View Bus Category and Add Bus category

- Admins can  and add Bus Category eg(tata,Toyota dolphin,etc) and Delete Category Delete Category and Update Category.
##### Routes

- Admins can  create, watch,delete and update by using Start city,Destination city and distance.
  
## Team Members

**Group Members**
 1. Yonas Adane        UGR/25464/14   
 2. Yonas Zekariyas    UGR/25332/14
 3. Hanamariam Mesfin  UGR/25483/14
 4. Etsehiwot Mengistu UGR/25562/14
 5. Abuzer Jemal       UGR/25351/14
