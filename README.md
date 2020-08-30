# camagru
A php version of image sharing instagram

Requirements
- PHP
- Javascript
- MAMP : https://bitnami.com/stack/mamp
# Installation
## How to download the source code
-	Navigate to https://github.com/bngweny/camagru.git, click on clone or download
-	Once you have downloaded the source code copy folder to the folder htdocs whcich gets used my the apache server to host applications
## How to set up and configure the database
-	Download MAMP from the bitnami website
-	Open the manager-osx. Go to the Manage servers tabs and make sure mysql database is running. If not press Restart.
-	Press configure, this should show details about the port.
-	Open a web browser and go to http://localhost:(the port)/phpmyadmin
-	Create the database titled camagru, navigate to import and upload the file camagru.sql
## How to run the program
-	run node entry to start the server
-	navigate to localhost:{port} in your browser to open the website
## Code Breakdown
###	Back end technologies
-	JavaScript
-	PHP
###	Front-end technologies
-	HTML
-	CSS
###	Database management systems
-	mysql
-	phpmyadmin
###	Break down of app folder structure
- config
  - database.php
  - setup.php
  - utilities.php
- css
  - cam.css
  - style.css
- php
  - auth.php
  - booth.php
  - change_password.php
  - feed.php
  - gallery.php
  - home.php
  - login.php
  - logout.php
  - merge.php
  - profile.php
  - register.php
- index.php
       
#Testing
https://github.com/wethinkcode-students/corrections_42_curriculum/blob/master/camagru.markingsheet.pdf
