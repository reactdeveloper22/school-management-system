<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../index.php');
};

if(isset($_POST['add_product'])){

    $school = $_POST['school'];
    $school = filter_var($school, FILTER_SANITIZE_STRING);
    $degree = $_POST['degree'];
    $degree = filter_var($degree, FILTER_SANITIZE_STRING);
    $payment = $_POST['payment'];
    $payment = filter_var($payment, FILTER_SANITIZE_STRING);


   $select_products = $conn->prepare("SELECT * FROM `subject` WHERE degree = ?");
   $select_products->execute([$degree]);

   if($select_products->rowCount() > 0){
      $message[1] = 'Subject Name Already Exist!';
   }else{
      $insert_products = $conn->prepare("INSERT INTO `subject`(`school`, `degree`, `payment`) VALUES(?,?,?)");
      $insert_products->execute([$school, $degree, $payment]);

      if($insert_products){
         if($image_size > 2000000){
            $message[1] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[2] = 'Subject Register Successfully!';
         }

      }

   }

};

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `subject` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $delete_products = $conn->prepare("DELETE FROM `subject` WHERE id = ?");
    $delete_products->execute([$delete_id]);
 
 
 }

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/subject.css">
    <title>Document</title>
</head>
<body>

<div class="header">
  <a href="#default" class="logo">Student Management System</a>
  <div class="header-right">
    <a class="active" href="../home.php">Dashboard</a>
    <a href="../admin_studint.php">Students</a>
    <a href="../teacher/teacherDashBoard.php">Teachers</a>
    <a href="subjectAdimnBoard.php">Schools & Degree</a>
    <a href="../About.php">About</a>
  </div>
</div>


<section class="tables">

<h1 class="title">Schools & Degree</h1>  

<table>
   <thead>
      <tr>
         <th>No</th>
         <th>School</th>
         <th>Degree</th>
         <th>Fees</th>
         <th>Action</th>
      </tr>  
   </thead>

   <?php
         $show_products = $conn->prepare("SELECT * FROM `subject`");
         $show_products->execute();
         if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
               
               echo "<tr><td>". $fetch_products['id'] ."<td/<td>". $fetch_products['school'] ."<td/<td>". $fetch_products['degree']. "<td/<td>". $fetch_products['payment'].
                "<td/<td>" ."<a class= option href=subjectUpdate.php?update=".$fetch_products['id']. ">Update</a>".       
                "<a class= delete onclick=return confirm('delete this product?') href=subjectAdimnBoard.php?delete=".$fetch_products['id']. ">Delete</a>"."</td/<td>";

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

<section class="buttenclass">
<a href="subjectAdd.php" class="button">Add New Degree</a>
</section>

</body>
</html>