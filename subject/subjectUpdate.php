<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];


if(isset($_POST['update_product'])){

    $pid = $_POST['pid'];
    $school = $_POST['school'];
    $school = filter_var($school, FILTER_SANITIZE_STRING);
    $degree = $_POST['degree'];
    $degree = filter_var($degree, FILTER_SANITIZE_STRING);
    $payment = $_POST['payment'];
    $payment = filter_var($payment, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `subject` SET `school`= ?,`degree`= ?,`payment`= ? WHERE id =?");
   $update_product->execute([$school, $degree, $payment, $pid]);

   $message[2] = 'Degree updated successfully!';

}else{
    
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/update.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tiro+Devanagari+Sanskrit&display=swap" rel="stylesheet">
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
<h1 class="tittleclass">Update Degree</h1>
<section class="update-product">

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `subject` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      

      <table align="center" cellpadding="10">
<form class="studentF" action="" method="POST" enctype="multipart/form-data">
<div class="containerr">
<tr>
        <td>Select School: </td>
        <td>
        <select name="school" class="box">
            <option selected><?= $fetch_products['school']; ?></option>
            <option value="School of Engineering">School of Engineering</option>
            <option value="School of Technology">School of Technology</option>
            <option value="SLTC Business School">SLTC Business School</option>
            <option value="School of IT & Computing">School of IT & Computing</option>
            <option value="School of Music">School of Music</option>
        </select>
        </td>

    <tr>
        <td>Degree Name: </td>
        <td><input type="text" class="name" name="degree" placeholder="Enter Degree Name" value="<?= $fetch_products['degree']; ?>"></td>
    </tr>
    <tr>
        <td>Degree Fees: </td>
        <td><input type="number" class="namesnames" name="payment" placeholder="Enter Degree Fees"value="<?= $fetch_products['payment']; ?>"></td>
    </tr>
    <tr>
        <td><input type="submit" class="btn" value="Update Degree" name="update_product"></td>
    </tr>
</div>
    </form>
</table>

     
   <?php
}
      }else{
         echo '<p class="empty">no products found!</p>';
      }
   ?>

</section>

<section class="buttenclass">
<a href="subjectAdimnBoard.php" class="buttonne">Back</a>
</section>
    
</body>
</html>