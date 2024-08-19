Setting Up Feedback Hub360 Locally with XAMPP
This guide walks you through setting up the Feedback Hub360 database locally using XAMPP.


Prerequisites
XAMPP server installed on your machine. You can download it from [ Apache Friends.](https://www.apachefriends.org/)


Steps
Start XAMPP

Open the XAMPP Control Panel.
Start both Apache and MySQL modules by clicking the "Start" buttons next to them.
Access phpMyAdmin


Open a web browser and navigate to http://localhost/phpmyadmin/.
Create the Database

In the left panel of phpMyAdmin, click on "New".
In the "Create database" field, enter fbh.
Click "Create" to create the database.
Import Database Schema

Click on the newly created database fbh in the left panel.


In the main panel, switch to the "SQL" tab.

Paste the following SQL code into the query box:

sql
Copy code
CREATE TABLE Organizations (
    orgId INT AUTO_INCREMENT PRIMARY KEY,
    orgName VARCHAR(255) NOT NULL,
    orgType VARCHAR(50) NOT NULL,
    address VARCHAR(255) NOT NULL,
    approval_status VARCHAR(50)
);

CREATE TABLE Admins (
    adminId INT AUTO_INCREMENT PRIMARY KEY,
    orgId INT,
    adminName VARCHAR(255) NOT NULL,
    adminEmail VARCHAR(255) NOT NULL,
    adminPassword VARCHAR(255) NOT NULL,
    FOREIGN KEY (orgId) REFERENCES Organizations(orgId)
);

ALTER TABLE Organizations AUTO_INCREMENT = 1;
ALTER TABLE Admins AUTO_INCREMENT = 1;
Click "Go" to execute the SQL code and create the tables in your database.

Deploy the Feedback Hub360 Application

Make sure the cloned Feedback Hub360 project is in the htdocs folder of your XAMPP installation (typically located at C:\xampp\htdocs on Windows or /Applications/XAMPP/htdocs on macOS).
Open a web browser and navigate to http://localhost/FBH.
Follow any additional on-screen instructions to complete the setup.
