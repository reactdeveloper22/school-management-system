<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == 'user'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:home.php');

      }elseif($row['user_type'] == 'user'){
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }else{
         $message[1] = 'No User Found!';
      }

   }else{
      $message[1] = 'Incorrect Email Or Password!';
   }

}

?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<?php

if(isset($message[1])){
   foreach($message as $message){
      echo '
      <div class="messages">
      <img src="error.png" alt="">
      <h2>Sorry!</h2>
         <span>'.$message.'</span>
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
      </div>
      ';
   }
}else if (isset($message[2])) {
   foreach($message as $message){
      echo '
      <div class="messages">
      <img src="404-tick.png" alt="">
      <h2>Done</h2>
         <span>'.$message.'</span>
         <a href="index.php">
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
         </a>
      </div>
      ';
   }
}

?>
    <div class="wrapper">
        <div class="container">
          <h1>Welcome <br>student management system for university</h1>
          
          <form class="form" action="" method="POST">
          <input type="email" name="email" class="box" placeholder="User Email" required>
          <input type="password" name="pass" class="box" placeholder="User Password" required>
            <input type="submit" value="Login" class="btn" name="submit">
            <br>
            <br>
            <a href="register.php">Sign up for system</a>
          </form>
        </div>
        
        <ul class="bg-bubbles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          
        </ul>
      </div>
      <script type="text/javascript" src="script.js"></script>
</body>
</html>