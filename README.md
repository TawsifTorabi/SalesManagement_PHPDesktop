# WeeklySalesRegister_SQLite
Sales Management System in PHP and SQLite set to Run in phpdesktop</br>
This is a simple sales management application.</br>
This web application works in the principle of selling copies of magazine. It does not track the stock. </br>
It only tracks the sells and records the payments and dues from selling agents.</br>
Language: English in this version

### Installation:
#### 💻 PHP Desktop:
This web application directly runs on [phpdesktop ]([url](https://github.com/cztomczak/phpdesktop)) </br>
You need to add all the contents from the src folder to the www folder of the phpdesktop application. </br>
And you can customize the phpdesktop by modifying or replacing the settings.json at the root folder of phpdesktop.
#### 🌍 Xampp or Apache Server:
You just copy this web application src folder to the xampp's htdocs folder.</br>
Then enable sqlite from php.ini </br>
To activate SQLite3 in Xampp (v3.2.2).</br> 
- Open xampp/php/php.ini 
- un-comment the line ;extension=sqlite3 (just remove the ; from the line)
- save the php.ini and restart your Xampp server.

## Features
1. Adding Agents
2. Recording Weekly Consumption
3. Adding Due Payments
4. Agent Profile
5. Agent Report Generator
6. Print Agent Report
7. Statistics at Homepage
8. SQLite Standalone


### Default Login Credentials:
**Username:** user </br>
**Password:** pass

## Important Note: 
Before Starting to use api/pdf.php - Unzip **api.zip** in this directory with pdf.php </br>
Youtube Tutorial Video will be available soon. </br>
This folder should look alike, </br>

	/Vendor
	/composer.json
	/composer.lock
	/pdf.php
	/readme.md
  
</br>
I used mPDF previously to get support to print Bangla and Unicode Fonts.</br>
DOmPDF is just lightweight, I'm using it again to print English and ANSI Fonts.</br>
