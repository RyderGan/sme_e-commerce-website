# E-Commerce-Website-Using-PHP

## Summary
Hello friends, This is my first full e-commerce project. This is free. Anybody can use and moderate this project.

## Platform Used
### Front-End
  (i) HTML5 <br>
  (ii) CSS3 <br>
  (iii) JavaScript <br>

### Back-End
  (i) PHP <br>
  (ii) MySQL <br>

## Key Features
### Public User
(i) Search Product <br>
(ii) View Product <br>
(iii) Create User Account <br>

### Signin User
(i) Search Product <br>
(ii) View Product <br>
(iii) Create Order <br>
(iv) Change Email & Password <br>
(v) Can View Previous Order with UPDATE and DELETE <br>

### Admin
(i) Add New Product <br>
(ii) Update Product <br>
(iii) Delete Product <br>
(iv) Confirm Order <br>

## Conclusion
There are also many more feature which are not in the list. Feel free to use this project

(a)	How to set up the project locally
1)	Go to the github repository at https://github.com/mohsinenur/E-Commerce-Website-Using-PHP/tree/master.  
2)	On the github repository, click on the ‘Code’ dropdown and copy the HTTPS clone URL in the right menu and click the "Copy to clipboard" button.
 
3)	Launch your terminal and navigate to the parent directory where you would like to clone your GitHub repository.
Note: we would recomment to clone into the htdocs directory of your xampp folder as we will be using xampp to run the website on our localhost.
4)	Run ‘git clone <<HTTPS clone URL>>’ in your terminal.
5)	Congratulations. You’ve successfully cloned the project into your local machine!

(b)	How to set up the database using xampp.
1)	Assuming that you have already set up XAMPP, launch XAMPP and:
•	Start the database server ("MySQL Database")
•	Start the PHP environment ("Apache Web Server")
 
2)	Go to https://github.com/mohsinenur/E-Commerce-Website-Using-PHP/tree/master/Updated/sql and download the grocery.sql file, which is the database script file to create tables and populate them with data.
3)	Go to http://localhost/phpmyadmin/ and create a new database named ‘grocerydb’. 
4)	Copy and paste the content of the sql file under the ‘SQL’ tab.
 
5)	Add the statement ‘USE grocerydb;’ just before the ‘CREATE TABLE ‘admin’’ statement.
Note: This is an error in the sql file as it doesn’t have this ‘USE grocerydb;’ statement which will ultimately result in an error saying ‘no database selected’.
 
6)	Done! You should see a ‘grocerydb’ database with 5 tables namely ‘admin’, ‘cart’, ‘orders’, ‘products’, ‘user’ on your left panel.
 

(c)	How to run project on your localhost
1)	Assuming that you have already set up XAMPP, launch XAMPP and:
•	Start the database server ("MySQL Database")
•	Start the PHP environment ("Apache Web Server")
 
2)	Go to http://localhost/E-Commerce-Website-Using-PHP/Updated/ in your browser.
3)	The index.php file will be displayed in your browser.
 


