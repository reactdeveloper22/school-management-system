<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

    $fname = $_POST['fname'];
    $fname = filter_var($fname, FILTER_SANITIZE_STRING);
    $lname = $_POST['lname'];
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);
    $age = $_POST['age'];
    $age = filter_var($age, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $dateOf = $_POST['dateOf'];
    $dateOf = filter_var($dateOf, FILTER_SANITIZE_STRING);
    $home = $_POST['home'];
    $home = filter_var($home, FILTER_SANITIZE_STRING);
    $mobile = $_POST['mobile'];
    $mobile = filter_var($mobile, FILTER_SANITIZE_STRING);
    $gender = $_POST['gender'];
    $gender = filter_var($gender, FILTER_SANITIZE_STRING);
    $idNum = $_POST['idNum'];
    $idNum = filter_var($idNum, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $postal = $_POST['postal'];
    $postal = filter_var($postal, FILTER_SANITIZE_STRING);
    $nationality = $_POST['nationality'];
    $nationality = filter_var($nationality, FILTER_SANITIZE_STRING);


   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `teacher` WHERE fname = ?");
   $select_products->execute([$fname]);

   if($select_products->rowCount() > 0){
      $message[1] = 'Teacher s Name Already Exist!';
   }else{
      $insert_products = $conn->prepare("INSERT INTO `teacher`(`fname`, `lname`, `age`, `email`, `dateOfbirth`, `home`, `mobile`, `gender`, `idNum`, `address`, `postal`,`nationality`, `image`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $insert_products->execute([$fname, $lname, $age, $email, $dateOf, $home, $mobile, $gender, $idNum, $address, $postal, $nationality, $image]);

      if($insert_products){
         if($image_size > 2000000){
            $message[1] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[2] = 'Teacher Register Successfully!';
         }

      }

   }

};

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `teacher` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/'.$fetch_delete_image['image']);
    $delete_products = $conn->prepare("DELETE FROM `teacher` WHERE id = ?");
    $delete_products->execute([$delete_id]);
 
 
 }

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

<div class="header">
  <a href="#default" class="logo">Student Management System</a>
  <div class="header-right">
    <a class="active" href="../home.php">Dashboard</a>
    <a href="../admin_studint.php">Students</a>
    <a href="teacherDashBoard.php">Teachers</a>
    <a href="../subject/subjectAdimnBoard.php">Schools & Degree</a>
    <a href="../About.php">About</a>
  </div>
</div>


<section class="tables">

<h1 class="title">Teachers</h1>  

<table>
   <thead>
      <tr>
         <th>No</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Age</th>
         <th>Email</th>
         <th>Date Of Birth</th>
         <th>Home</th>
         <th>Mobile</th>
         <th>Gender</th>
         <th>ID Number</th>
         <th>Address</th>
         <th>Postal Code</th>
         <th>Nationality</th>
         <th>Action</th>
      </tr>  
   </thead>

   <?php
         $show_products = $conn->prepare("SELECT * FROM `teacher`");
         $show_products->execute();
         if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
               
               echo "<tr><td>". $fetch_products['id'] ."<td/<td>". $fetch_products['fname'] ."<td/<td>". $fetch_products['lname']. "<td/<td>". $fetch_products['age']."<td/<td>". $fetch_products['email']."<td/<td>".$fetch_products['dateOfbirth'] ."<td/<td>". $fetch_products['home'] ."<td/<td>". $fetch_products['mobile'] ."<td/<td>". $fetch_products['gender'] ."<td/<td>". $fetch_products['idNum'] ."<td/<td>". $fetch_products['address'] ."<td/<td>". $fetch_products['postal'] ."<td/<td>". $fetch_products['nationality'] .
                "<td/<td>" ."<a class= option href=teacher_update.php?update=".$fetch_products['id']. ">Update</a>".       
                "<a class= delete onclick=return confirm('delete this product?') href=teacherDashBoard.php?delete=".$fetch_products['id']. ">Delete</a>"."</td/<td>";

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

<section class="buttenclass">
<a href="teacher.php" class="button">Add New Teacher</a>
</section>

</body>
</html>