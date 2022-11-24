<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Document</title>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h2>Student Management System</h2>
        <ul>
        <li><a href="home.php"><i class="fas fa-home"></i>Dashboard</a></li>
            <li><a href="admin_studint.php"><i class="fas fa-user"></i>Students</a></li>
            <li><a href="teacher/teacherDashBoard.php"><i class="fas fa-address-card"></i>Teachers</a></li>
            <li><a href="subject/subjectAdimnBoard.php"><i class="fas fa-building"></i>Schools</a></li>
            <li><a href="subject/subjectAdimnBoard.php"><i class="fas fa-graduation-cap"></i>Degree</a></li>
            <li><a href="About.php"><i class="fas fa-blog"></i>About</a></li>
        </ul> 
        <div class="social_media">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <div class="main_content">
        <div class="header">Welcome!! Have a nice day.</div>  
        <div class="info"></div>
    

    <div class="box-container">

    <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `student`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Students added</p>
      <a href="admin_studint.php" class="button">See Students</a>
      </div>

      <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `teacher`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Teachers added</p>
      <a href="teacher/teacherDashBoard.php" class="button">See Teachers</a>
      </div>

      <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `school`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Schools added</p>
      <a href="subject/subjectAdimnBoard.php" class="button">See Schools</a>
      </div>

      <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `subject`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Degree added</p>
      <a href="subject/subjectAdimnBoard.php" class="button">See Degree</a>
      </div>


    <section class="tables">

<h1 class="title">Students</h1>  

<table>
   <thead>
      <tr>
         <th>First Name</th>
         <th>Age</th>
         <th>Email</th>
         <th>Gender</th>
         <th>ID Number</th>
         <th>Address</th>
         <th>School</th>
         <th>Digger</th>
      </tr>  
   </thead>

   <?php
         $show_products = $conn->prepare("SELECT * FROM `student`");
         $show_products->execute();
         if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
               
               echo "<tr><td>".$fetch_products['fname'] ."<td/<td>". $fetch_products['age']."<td/<td>". $fetch_products['email']."<td/<td>". $fetch_products['gender'] ."<td/<td>". $fetch_products['idNum'] ."<td/<td>". $fetch_products['address'] ."<td/<td>".$fetch_products['school'] ."<td/<td>". $fetch_products['diggers'].
               "</td/<td>";

            }
            echo "</table>";
   ?>
</table>

<?php
   }else{
      echo '<p class="empty">No Student Added Yet!</p>';
   }
   ?>

   

</section>


<section class="tabless">

 

<table class="teacherTable">
   <thead>
   <h1 class="title">Teachers</h1> 
      <tr>
         <th>First Name</th>
         <th>Age</th>
         <th>Email</th>
         <th>Mobile</th>
         <th>Date Of Birth</th>
         <th>Gender</th>
         <th>ID Number</th>
         <th>Address</th>
      </tr>  
   </thead>

   <?php
         $show_products = $conn->prepare("SELECT * FROM `teacher`");
         $show_products->execute();
         if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
               
               echo "<tr><td>".$fetch_products['fname'] ."<td/<td>". $fetch_products['age']."<td/<td>". $fetch_products['email']."<td/<td>". $fetch_products['mobile'] ."<td/<td>".$fetch_products['dateOfbirth'] ."<td/<td>". $fetch_products['gender'] ."<td/<td>". $fetch_products['idNum'] ."<td/<td>". $fetch_products['address'];

            }
            echo "</table>";
   ?>
</table>

<?php
   }else{
      echo '<p class="empty">No Teacher Added Yet!</p>';
   }
   ?>

</section>

<section class="tabless">

 

<table class="teacherTable">
   <thead>
   <h1 class="title">Schools & Degree</h1> 
      <tr>
         <th>No</th>
         <th>School</th>
         <th>Degree</th>
         <th>Fees</th>
      </tr>  
   </thead>

   <?php
         $show_products = $conn->prepare("SELECT * FROM `subject`");
         $show_products->execute();
         if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
               
               echo "<tr><td>". $fetch_products['id'] ."<td/<td>". $fetch_products['school'] ."<td/<td>". $fetch_products['degree']. "<td/<td>". $fetch_products['payment'];

            }
            echo "</table>";
   ?>
</table>

<?php
   }else{
      echo '<p class="empty">No Teacher Added Yet!</p>';
   }
   ?>

</section>
    
    </div>


</body>
</html>