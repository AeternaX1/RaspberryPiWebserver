# RaspberryPiWebserver

*************************************************************************************************************************
THIS IS A SIMPLE HOBBY PROJECT. IT IS IN NO WAY INTENDED TO BE USED COMMERCIALLY
As such, all passwords used and chosen during setup are included. 
You are welcome to change these.

PLEASE FOLLOW THE INSTRUCTIONS BELOW. THE WEBSITE CREATED IS INTENDED TO BE USED ON A WEBSERVER, INSALLED AND CONFIGURED
ON THE RASPBERRY PI
*************************************************************************************************************************





### Introduction
This topic demonstrates how the internals of the Raspberry Pi work, and the intended project will make use of the GPIO pins available on the device. 
This project will also demonstrate the power of the RPi by creating robust and dynamic website that will be hosted on a webserver installed on the RPi, 
with security as a top priority.
 
Objectives:
Configure the following on the Raspberry Pi (RPi)
Apache2 webserver
MariaDB database server
PHPMyAdmin to administrate the database

Create a dynamic website that is hosted on the Apache2 RPi webserver, allowing the user to remotely turn on/off LEDs, 
as well as view the output of Linux commands stored within Python scripts running on a webpage
Only allow users to interact with the RPi if they’re registered via secure login/registration.
Account details will be stored in MariaDB





### Install Raspberry Pi Apache2 webserver

Install Apache2:
sudo apt install apache2 -y 

To check if Apache2 has been installed correctly, enter the RPi’s IP address into a browser.

Eg: 192.168.0.18

In the context of this document, all references to the Raspberry Pi's IP address will be refeffered to as 192.168.0.18
Where appropriate, change this value to your RPis IP address

This should display a Debian splash page to indicate that the webserver is up and running.
If IP address is unknown, run this:

	- hostname -I

Allow for modifications
Normally, to make changes to the “/var/www/html” directory, “sudo su” would need to be entered to execute commands as the root user. 
To avoid this, permissions can be configured. Add the default “pi” user to the “www-data” group (the default group for Apache2). 
Then, give ownership of all the files and folders in the “/var/www/html” directory to the “www-data” group. 

	- sudo usermod -a -G www-data pi
	- sudo chown -R -f www-data:www-data /var/www/html

Changes can be made to the default splash page: 

	- nano /var/www/html/index.html

The Apache2 webserver will serve all files within “var/www/html”.





### PHP7 Installation
PHP7 will need to be installed to allow for dynamic webpages.
•	sudo apt install php7.4 libapache2-mod-php7.4 php7.4-mbstring php7.4-mysql php7.4-curl php7.4-gd php7.4-zip -y
Dynamic webpages can be created under the “var/www/html” directory. This project is contained in the “var/www/html/RaspberryPiWebserver” directory. 
When loading the project, enter the RPi’s IP address followed by the project name, “192.168.0.18/RaspberryPiWebserver”. 
If an index.php file is included, the browser will load that by default. 

Run this:
	- sudo nano var/www/html/RaspberryPiWebserver/index.php

Exit nano and navigate to 192.168.0.18/RaspberryPiWebserver/index.php. “index.php” will be empty, but the webserver will be hosting it. 





### Configure Apache Virtual Host
When configuring webservers, its good practice to configure a virtual host, allowing for more than one website on a webserver.
This is recommended if more than one website will be hosted, or if the website will public-facing. 
Once installed, activate the virtual host, this allows for a  Domain Name Server (DNS) to be pointed to the RPi’s public IP address and 
serve the files for the requested domain name. Port forwarding will need to be configured in order to enable this. 





### MariaDB
Configure MariaDB. 
	- sudo apt install mariadb-server

Secure the installation:
	- sudo mysql_secure_installation

MariaDB will prompt the user to set up a root password. 
Its recommended to answer “Y” to all user prompts, which will remove features allowing someone to gain easier access to MariaDB . 
Those were the actions taken here. 
For extra security, store the password in a secure password locker such as LastPass. 

Access MySQL:
	- sudo mysql -u root -p

Login with the new password. 
MariaDB allows for the creation of users that can have the rights to manage the database assigned to them. 





### Creating a MariaDB Database and User

	- CREATE DATABASE users;


Assign user to MariaDB database:

	A MariaDB user will be assigned to the database called “patrick” and will have the password “patrick”.
	Feel free to change this, however this user will be used in the conect of this document

	- CREATE USER 'patrick'@'localhost' IDENTIFIED BY 'patrick';


Grant all permissions to interact with the “users” database. 

	- GRANT ALL PRIVILEGES ON users.* TO patrick@'localhost';


Flush the privilege table. If this isn’t done, database access won’t be possible. 

	- FLUSH PRIVILEGES

Databases can also be managed via PHPMyAdmin, which was the preferred method for this mini-project. 
It may seem redundant installing MariaDB and creating a user, as later on, one will be created via PHPMyAdmin, but to this was still done to avoid confusion.


### PHPMySQL Connector
Install a connector to use MariaDB with PHP
- sudo apt install php-mysql





### PHPMyAdmin
PHPMyAdmin utilises a GUI format for database administration.
- sudo apt install phpMyAdmin

User input will be required.  
A screen will display asking the type of webserver PHPMyAdmin will operate from. Select “apache2”. 





### Connect PHPMyAdmin with MariaDB
More details are needed for PHPMyAdmin. Select “<Yes>” at the next prompt.

Set PHPMyAdmin root password 
Create a different password to the root MySQL. 
Doing this will help ensure server integrity. 
An alphanumeric 8-character password was chosen
Password = SZhqMLtn
This password is what PHPMyAdmin will use to connect to the MariaDB server. 

Create new user
PHPMyAdmin does not allow for root user login by default. Instead, create a new user to access databases/tables. To do this, login to the MariaDB command line.  
	- sudo mysql -u root -p
	
Log in to the MariaDB “root” user with the password that was set up earlier.
Create user and permit them to access all databases on MariaDB 

Run the following
	- GRANT ALL PRIVILEGES ON *.* TO 'patrick'@'localhost' IDENTIFIED BY 'H3LRrXhr' WITH GRANT OPTION;
Exit MariaDB.

	
	
	
	
### Configuring PHPMyAdmin
Before PHPMyAdmin can be booted, some changes need to be made to the webserver. Edit the “Apache2.conf” file.
	- sudo nano /etc/apache2/apache2.conf

Add this line to the BOTTOM of this file. This line will include PHPMyAdmin’s configuration and allow it to be loaded in and listened to by Apache2.
	- Include /etc/phpmyadmin/apache.conf

Save, exit, and restart the Apache2 service. This will flush the current Apache2 configuration and make it load in the modified file.
	- sudo service apache2 restart

	
	


### Accessing PHPMyAdmin
To test PHPMyAdmin, type the following address in a browser.
	- http://192.168.0.18/phpmyadmin
	- Replace the IP address if it differs

Use the user created earlier to log in. 
DO NOT use the root user as this is disabled by default. 

Create user table
Login to PHPMyAdmin and create a user table containing the columns “username”, “email” and “password”.

	



### Test Website Structure
This directory structure was created:

root
index.php
- The basic welcome page

register_screen.php
- Secure user registration

login_screen.php
- Secure user login

led.php
Allows LEDs to be turned on and off. 
- For each individual LED, a form including buttons to switch them on and off is included. 
- When one of these buttons is clicked, the data for the corresponding button is sent to PHP. 
- This page can only be seen by logged in users.

linux_commands.php
- Outputted Linux commands via the PHP “shell_exec()” function to execute Python scripts on the browser.
- This page can only be seen by logged in users.

includes
db_connection.php
- Allows a connection to the Pi’s MySQL database

attempt_login.php
- Upon login, the form data from login_screen.php is passed to this script.

attempt_register.php
- Upon registration, the form data from register_screen.php is passed to this script.

attempt_logout.php
- Upon logout, the session is unset and destroyed. Redirection to index.php occurs

python_scripts
- Python scripts contain Linux commands that are passed to os.system
- The commands themselves are stored inside “cmd” variables.

rpi_cpugpu.py
- vcgencmd get_mem arm && vcgencmd get_mem gpu

rpi_cpuinfo.py
- cat /proc/cpuinfo 

rpi_free.py
 - free -h

rpi_hostname.py
 - hostname && hostname -I

rpi_measure_clock.py
- vcgencmd measure_clock arm

rpi_uptime.py
- uptime”

rpi_version.py
- cat /proc/version

rpi_volts.py
- vcgencmd measure_volts


rpi_temp.py
- The gpiozero library is imported; a variable called cpu is assigned to a “CPUTemperature()” function.
- A print statement then calls cpu.temperature

css
style.css
- Style data for each of the webpages

	



### LEDs
The LEDs are controlled using the PHP function “shell_exec()” to set the output mode of the GPIO pin on the RPi and controlling the on/off function with an HTML button. 
When “Switch On” is clicked, the value “red_on” is posted to the PHP code, which is checked via “isset()”. The GPIO pin’s output mode is set, followed by changing the write value to “1”, turning the LED on.
When “Switch Off” is pressed, the write value is set to “0” and the LED is turned off.
This same process will occur for the other LEDs located at different pins. 
The GPIO pin for the red LED is 23, the blue LED is 20, and the green LED is 25. 
With multiple LEDs, a form passes “all_led_on” to PHP when the “Turn All LED On” button is pressed, setting all the GPIO pin write values to 1. When the “Turn All LED Off” button is pressed, the LEDs will turn off. 





### Linux Terminal Commands
To output Linux commands to HTML,  Python scripts store a command inside a variable, and pass it to os.system. 
That Python file is then executed on the browser via PHP with “exec_file()”. An example of this is outputting the clock speed of the RPi’s processor, the command “vcgencmd measure_clock arm” is stored inside a variable called “cmd”, and that variable is then passed to “os.system”. 

	



### Security Considerations
Incorrect information or empty fields cannot be entered into the database. 
All fields must be populated, if fields are empty, authentication cannot occur. 
Stripslashes, prepared statements and mysqli_real_escape_string are used to protect against SQL injections.
PHP Sessions control what’s displayed, protecting against unauthorised access to the RPi. 
Registered users can access the LEDs and view outputted Linux commands. 
Unregistered users can only see the Home, Login, and Register tabs. 
If logged out users attempt to manually type a page name viewable only by logged in users, such as led.php and linux_commands.php, they will be redirected to login or register. 
If logged in users try to manually access pages intended for logged out users, they will be redirected to index.php. 
