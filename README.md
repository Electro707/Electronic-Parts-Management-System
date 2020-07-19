#### Note: This is still in development, but feel free to explore around :)

# Electro707's Electronic Parts Management System (EEPMS)

This website is for an electronics/hobbyist parts management, complete (or will be) with parametric searches, and beign able to import a BOM file to add to your stock, and more features. This project started because I couldn't find any adequate part management systems (cathered to electronics) that I liked.

Here is a screenshot at the software as of one of the latest commits:

![Latest update](documentation/images/Screenshot_20200719_045650.png)

## TODO:

- [ ] Create the parametric search
- [x] Convert a number to it's engineering notation (1000 to 1k for example)
- [ ] Better layout the page
- [x] Handle if a column doesn't exist (Adds it to the table)
- [x] Handle if a table doesn't exist (Creates it)
- [x] Handle an 'initializer' for the database
- [ ] Add more components
- [x] Add sorting in the table
- [ ] Add import BOM option
- [ ] Add import PCB option
- [ ] Add a warning for when there is less than a certain amount of parts (configurable)
- [ ] Add PCB-assembly import to check against stock
- [ ] Add GUI to add to stock
- [ ] Add GUI to add new component
- [ ] Add a cross-link between the parts and Octopart 
- [x] Add a warning if the stock for a part is too low (configurable)
- [ ] Add a settings popup

## Database

The database is a mySql database, with the database name called "PartsList". Each part has it's own table, and is created if a part is clicked and the table doesn't exist. As of right now, there is no way to add a part except for manually doing it thru something like phpMyAdmin. This feature will be added in the future :)

## Getting Started

If you feel incline to run this webserver (for testing or development), there is a quick getting started guide of sorts ![HERE!](documentation/getting_started.md). That guide will be more refined as time goes on.
