<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $user_type = $_POST['user_type'];


   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[1] = 'User Email Already Exist!';
   }else{
      if($pass != $cpass){
         $message[1] = 'Confirm Password Not Matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, phone, email, password) VALUES(?,?,?,?)");
         $insert->execute([$name, $phone, $email, $pass]);

         $message[2] = 'Registered successfully!';

      }
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
      <h2>Thank You</h2>
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
        <div class="containerr">
          <h1>Register <br>student management system for university</h1>
          
          <form action="" class="forms" enctype="multipart/form-data" method="POST">

          <input type="text" name="name" class="box" placeholder="Enter Your Name" required>
            <input type="number" name="phone" placeholder="Mobile Number" required>
            <input type="email" name="email" class="box" placeholder="Enter Your Email" required>
            <input type="password" name="pass" class="box" placeholder="Enter Your Password" required>
            <input type="password" name="cpass" class="box" placeholder="Conform Your Password" required>
            <input type="submit" value="Register Now" class="btn" name="submit">

            <br>
            <br>
            <a href="index.php">Already have an account?</a>
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
      <script>
         let popup = document.getElementById("popup");

         function openPopup(){
         popup.classList.add("open-popup");
         }
         function closePopup(){
         popup.classList.remove("open-popup");
         }
      </script>
</body>
</html>