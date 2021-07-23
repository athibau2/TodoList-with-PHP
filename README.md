# Andrew Thibaudeau --- 02/22/2021 --- Lab 3 Write Up

## <strong>Executive Summary</strong>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This lab's purpose was to help me gain experience manipulating a database on the server through communication with the client-side. I did this by implementing functions that allow a user to create a new task in the database, update it, and delete it from the database. 

## <strong>Design Overview</strong>

1. This is the UML for Lab 3a. It shows the functionality of creating a new user in a database through a server, and logging users in and out of the task list through the server.<br>
<img src="screenshots/Lab 3a UML.png">

2. This is the UML for Lab 3b. It shows the functionality of creating a new task in the database through the server, and updating and deleting the task in the database through the server.<br>
<img src="screenshots/Lab 3b UML.png">

3. This screenshot shows the task list, displaying two tasks which were created in the database.<br>
<img src="screenshots/Tasks before.png">

4. This screenshot shows the database displaying the two tasks that were shown in the previous screenshot. You can see the done value set to 0 since they are not checked off.<br>
<img src="screenshots/php before.png">

5. This screenshot shows the task list with all three changes. I have created a new task, updated one to be completed, and deleted another.<br>
<img src="screenshots/tasks after.png">

6. This screenshot shows the database reflecting the changes made from the previous screenshot. You can see the deleted task is no longer there, the completed task showing a done value of 1, and the newly created task is inserted.<br>
<img src="screenshots/php after.png">


### <strong>Files</strong>

<em>create_action.php</em>
* This file contains the instructions to add a new task to the database via the server. It retrieves form input by the user and sends a query to the database to insert the new values.

<em>delete_action.php</em>
* This file contains the instructions to delete a task from the database via the server. It retrieves the task id from the delete button form and sends a delete query to the database via the server.

<em>login_action.php</em>
* This file contains the instructions to log a user into their task list via the server. It queries the database for the username, and if it's found it starts a server session and sets the session variables, then redirects to the users task list.

<em>logout_action.php</em>
* This file is simple. It destroys the session and its variables, then redirects back to the login page.

<em>register_action.php</em>
* This file contains the instructions for adding a new user to the database via the server. It retrieves the form data from the user, and queries the database for the username. If it's not found, it also confirms that the two passwords for verification are equal. If both of those tests pass, the server inserts the new user information into the database and automatically logs the user in to their task list.

<em>update_action.php</em>
* This file contains the instructions to change the "done" field of a task in the task table. It retrieves the done value from the form button input, toggles that value between 0 and 1, and updates the "done" field for the task id in the task table.

<em>style.css</em>
* This file contains the visual styling rules for the website.

<em>login.php</em>
* This file provides the structure of the login page for the website. It takes in user login information and sends it to the login_action.php file via the server.

<em>register.php</em>
* This file provides the structure of the register page for the website. It takes in new user information and sends it to the register_action.php file via the server.

<em>index.php</em>
* This file is what contains the task list. Tasks are echoed to the webpage from the database through this file.

<br>

## <strong>Questions</strong>

### <em>Lab 3</em>
1. Describe how cookies are used to keep track of the state. (Where are they stored? How does the server distinguish one user from another? What sets the cookie?)
    * Cookies store bits of information in the browser to keep track of a user's activity on a website. 

### <em>Lab 3b</em>
1. Describe how prepared statements help protect against SQL injection, but not XSS.
    * Prepared statements are aimed more directly toward protecting a database, so it's important to use them to sanitize the input you are storing in a database. XSS is more aimed at entering information that is displayed directly onto a webpage.

2. Describe at least two key differences between the PHP version of the task list and the JavaScript one you completed in labs 2A and 2B.
    * The PHP lab dealt with servers and lasting databases, while the JavaScript lab dealt with browser storage, which is short term.
    * In the PHP lab, it was more important to protect against SQL injection, whereas with the JavaScript lab it was more important to protect again XSS.

3. If we created a new table login_logout in the database to keep track of login and logout times of our various users, what would that table's schema look like? Describe necessary fields, which fields would need to be primary or unique, and what data type you would use for each.
    * A login_logout table would be rather simple. I think what you need to do it create a new time each time a new session is started and store that in the login field, clearing whatever was in the logout field before, because you started a new session. When you logout, that time would be stored in the logout field. It would be simple enough to store strings in those fields. 
<br>

## <strong>Lessons Learned</strong>

1. <em>Toggling Booleans</em>
    * One aspect of this lab was to toggle the "done" field in the task table for a particular task. Initially, one might think to simple do this by setting the variable equal to its opposite, such as:
    $done = !$done;  However, this is incorrect because the variable was declared with a default value of 0. The value zero, while indeed interpretable as a boolean, is just a value. It doesn't toggle. The better way to toggle is to use a ternary operator, as such:
    $done = ($done) ? 0 : 1;

2. <em>Two different display options in an echo statement</em>
    * Another aspect of this lab was to echo out the contents of the task table to the webpage in the index file. However, you needed to echo out a checked check box if the done field was true, and an empty check box if it was false. This is difficult to do in the middle of an echo statement when using an HTML template. One easy, however inefficient, method to accomplish this is to have an if/else if statement that echos each task individually with the correct check box.

3. <em>Switching between login and register</em>
    * One difficulty you may find with routing between the login and register pages is that you want to keep the buttons in a consistent layout, and that is most easily done when it's in the same form. However, when the buttons are in the same form as the input fields, you cannot enter a new action to route to a new page, because that is already taken up by the input fields and submit button. So, you have to make a new form right after it, which means the display will be distorted and you will have to add new CSS styling rules to get the layout you want.

<br>

## <strong>Conclusions</strong>

* Create, update, and delete information in a table in a database via a server.
* Create and destroy sessions variables
* Use HTTP methods
* Read out dynamic data from a database to a webpage.

## <strong>References</strong>

* https://getbootstrap.com/docs/5.0/layout/grid/
* https://www.w3schools.com/php/php_mysql_prepared_statements.asp
* https://www.tutorialrepublic.com/php-tutorial/php-mysql-prepared-statements.php
* https://www.w3schools.com/php/php_sessions.asp