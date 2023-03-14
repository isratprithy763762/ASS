<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Assignment of module 6</title>
</head>
<body>
<?php
// Name: Israt Jahan Prithi

// Question: 
/*
Instructions: Complete the following tasks and submit the PHP file and HTML file as part of your assignment.

 

Create an HTML form with the following fields:

Name (text input)

Email (text input)

Password (password input)

Profile Picture (file input)

Submit Button

Write a PHP script that:

Validates the form inputs (ensure that all fields are filled out and the email is in a valid format).

Saves the profile picture to the server in a directory named "uploads" with a unique filename.

Adds the current date and time to the filename of the profile picture before saving it to the server.

Saves the user's name, email, and profile picture filename to a CSV file named "users.csv".

Starts a new session and sets a cookie with the user's name.

Create a new HTML page that displays the contents of the "users.csv" file in a table.



*/

//Answer: Answer is given bellow :-

?>
 <form method="post" action="">
     <label>Name:</label>
     <input type="text" name="name" />
     <br />
     <label>Email:</label>
     <input type="text" name="email" />
     <br />
     <label>Password:</label>
     <input type="password" name="password" />
     <br />
     <label>Profile Picture:</label>
     <input type="file" name="profile_picture" />
     <br />
     <input type="submit" value="Submit" />
   </form>
   <?php
  
   
   if (isset($_POST['name']) && isset($_POST['email']) && isset($_FILES['profile_picture'])) {
       $name = $_POST['name'];
       $email = $_POST['email'];
       $profile_picture = $_FILES['profile_picture'];
       
       
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           echo 'Invalid email';
           exit;
       }
       
       
       $filename = time() . '_' . $profile_picture['name'];
       $filepath = 'uploads/' . $filename;
       move_uploaded_file($profile_picture['tmp_name'], $filepath);
       
       
       $data = [$name, $email, $filename];
       $fp = fopen('users.csv', 'a');
       fputcsv($fp, $data);
       fclose($fp);
       
       
       session_start();
       setcookie('name', $name);
   }
   ?>
   
   
   <table>
       <thead>
           <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Profile Picture</th>
           </tr>
       </thead>
       <tbody>
           <?php
           $fp = fopen('users.csv', 'r');
           while ($data = fgetcsv($fp)) {
               echo '<tr>';
               echo '<td>' . $data[0] . '</td>';
               echo '<td>' . $data[1] . '</td>';
               echo '<td><img src="uploads/' . $data[2] . '" /></td>';
               echo '</tr>';
           }
           fclose($fp);
           ?>
       </tbody>
   </table>
 
</body>
</html>