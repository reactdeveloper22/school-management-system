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

      $message[2] = 'Subject Register Successfully!';

   }

};

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_image = $conn->prepare("SELECT image FROM `subject` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_img/'.$fetch_delete_image['image']);
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
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>


<?php

if(isset($message[1])){
   foreach($message as $message){
      echo '
      <div class="messages">
      <img src="../error.png" alt="">
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
      <img src="../404-tick.png" alt="">
      <h2>Successfully!</h2>
         <span>'.$message.'</span>
         <a href="subjectAdimnBoard.php">
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
         </a>
      </div>
      ';
   }
}

?>

<h1 class="tittleclass">Add Subject</h1>


<table align="center" cellpadding="10">
<form class="studentF" action="" method="POST" enctype="multipart/form-data">
<div class="containerr">
<tr>
        <td>Select School: </td>
        <td>
        <select name="school" class="box">
            <option value="School of Engineering">School of Engineering</option>
            <option value="School of Technology">School of Technology</option>
            <option value="SLTC Business School">SLTC Business School</option>
            <option value="School of IT & Computing">School of IT & Computing</option>
            <option value="School of Music">School of Music</option>
        </select>
        </td>

    <tr>
        <td>Degree Name: </td>
        <td><input type="text" class="name" name="degree" placeholder="Enter Degree Name"</td>
    </tr>
    <tr>
        <td>Degree Fees: </td>
        <td><input type="number" class="name" name="payment" placeholder="Enter Degree Fees"</td>
    </tr>
    
    <tr>
        <td><input type="submit" class="btn" value="Add Subject" name="add_product"></td>
    </tr>
</div>
    </form>
</table>

<section class="buttenclass">
<a href="teacherDashBoard.php" class="buttonne">Back</a>
</section>
    
</body>
</html>