# Getting started
This document goes over how to get started on setting up you're local server for using/developing this project.

# Requirements
You will need the following pieces of software to get started:

- MySQL or MariaDB
- PhpMyAdmin
- Apache2
- PHP7 or above

# Setting up PHP and MySQL
After installing all pre-requisites, you will need to enable the mysqli module in php, which can be done with the following command:

`sudo phpenmod mysqli`

Then, you will need to create a sql account for the backend of the project to access. Usually phpmyadmin will create a account titled 'phpmyadmin' (If you installed it in Linux, a promt should show up asking for a password for that account). For now, set it to '123' (In the future a seperate account will be used to handle communicating with the database. We'll be granting this account full permission with the following command after you've logged into you sql shell (with `sudo mysql`):

`GRANT ALL PRIVILEGES ON *.* TO 'phpmyadmin';`

After this, and assuming the password to that account is 123, the backend should have access to the database.

Next, you need to login into phpmyadmin and create a database titled "PartsList". That's it! The backend will handle creating new tables if they don't exist.
