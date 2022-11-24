<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_product'])){

    $pid = $_POST['pid'];
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
    $idNum = $_POST['idNum'];
    $idNum = filter_var($idNum, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $postal = $_POST['postal'];
    $postal = filter_var($postal, FILTER_SANITIZE_STRING);
    $school = $_POST['school'];
    $school = filter_var($school, FILTER_SANITIZE_STRING);
    $diggers = $_POST['diggers'];
    $diggers = filter_var($diggers, FILTER_SANITIZE_STRING);
    $nationality = $_POST['nationality'];
    $nationality = filter_var($nationality, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];


   $update_product = $conn->prepare("UPDATE `student` SET `fname`= ?,`lname`= ?,`age`= ?,`email`= ?,`dateOfbirth`= ?,`home`= ?,`mobile`= ?, `idNum`= ?,`address`= ?,`postal`= ?,`school`= ?,`diggers`= ?,`nationality`= ? WHERE id = ?");
   $update_product->execute([$fname, $lname, $age, $email, $dateOf, $home, $mobile, $idNum, $address, $postal, $school, $diggers, $nationality, $pid]);

   $message[2] = 'product updated successfully!';

   if(!empty($image)){
      if($image_size > 2000000){
         $message[1] = 'image size is too large!';
      }else{

         $update_image = $conn->prepare("UPDATE `student` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);

         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[2] = 'Student updated successfully!';
         }
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
      <h2>Successfully!</h2>
         <span>'.$message.'</span>
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
      </div>
      ';
   }
}

?>
<h1 class="tittleclass">Update Student</h1>
<section class="update-product">

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `student` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      

      <table align="center" cellpadding="10">
<form class="studentF" action="" method="POST" enctype="multipart/form-data">
<div class="containerr">
    <tr>
        <td>First Name: </td>
        <td><input type="text" class="name" name="fname" placeholder="Enter First Name" value="<?= $fetch_products['fname']; ?>"></td>
    </tr>
    <tr>
        <td>Last Name: </td>
        <td><input type="text" class="name" name="lname" placeholder="Enter Last Name" value="<?= $fetch_products['lname']; ?>"></td>
    </tr>
    <tr>
        <td>Age: </td>
        <td><input type="number" class="name" name="age" placeholder="Enter Age" value="<?= $fetch_products['age']; ?>"></td>
    </tr>
    <tr>
        <td>Email: </td>
        <td><input type="email" class="name" name="email" placeholder="Enter Email" value="<?= $fetch_products['email']; ?>"></td>
    </tr>
    <tr>
        <td>Date Of Birth: </td>
        <td><input type="date" class="name" name="dateOf" placeholder="Enter Date of birth" value="<?= $fetch_products['dateOfbirth']; ?>"></td>
    </tr>
    <tr>
    <td>Contact Number</td>
        <td class="num">Home: <input type="number" class="phone" name="home" placeholder="Enter Mobile number"value="<?= $fetch_products['home']; ?>"> Mobile: <input type="number" class="phone" name="mobile" placeholder="Enter Mobile number" value="<?= $fetch_products['mobile']; ?>"></td>
    </tr>
    <tr>
        <td>ID Number: </td>
        <td><input type="number" class="idNum" name="idNum" placeholder="Enter Id number" value="<?= $fetch_products['idNum']; ?>"></td>
    </tr>
    <tr>
        <td>Address: </td>
        <td><textarea name="address" rows="6" cols="50" placeholder="<?= $fetch_products['address']; ?>"></textarea></td>
    </tr>
    <tr>
        <td>Postal Code: </td>
        <td><input type="text" class="name" name="postal" placeholder="Enter postal code" value="<?= $fetch_products['postal']; ?>"></td>
    </tr>
    <tr>
        <td>Select Your School: </td>
        <td>
        <select name="school" class="box" >
            <option selected><?= $fetch_products['school']; ?></option>
            <option value="School of Engineering">School of Engineering</option>
            <option value="School of Technology">School of Technology</option>
            <option value="SLTC Business School">SLTC Business School</option>
            <option value="School of IT & Computing">School of IT & Computing</option>
            <option value="School of Music">School of Music</option>
        </select>
        </td>
    </tr>
    <tr>
        <td>Diggers: </td>
        <td><select name="diggers" class="box">
            <option selected><?= $fetch_products['diggers']; ?></option>
            <option value="BSc (Hons) in Engineering in Electronics and Power Systems">BSc (Hons) in Engineering in Electronics and Power Systems</option>
            <option value="BSc (Hons) in Engineering in Electronics and Telecommunication">BSc (Hons) in Engineering in Electronics and Telecommunication</option>
            <option value="BSc (Hons) in Engineering in Electronics and Engineering Management">BSc (Hons) in Engineering in Electronics and Engineering Management</option>
            <option value="BSc (Hons) in Engineering in Information and Communication Engineering (Software Engineering)">BSc (Hons) in Engineering in Information and Communication Engineering (Software Engineering)</option>
            <option value="BSc (Hons) in Engineering in Civil Engineering">BSc (Hons) in Engineering in Civil Engineering</option>
            <option value="BSc (Hons) in Engineering in Mechatronics Engineering">BSc (Hons) in Engineering in Mechatronics Engineering</option>
            <option value="BSc (Hons) in Bio Systems Engineering">BSc (Hons) in Bio Systems Engineering</option>
            <option value="BTech (Hons) in Electronics">BTech (Hons) in Electronics</option>
            <option value="BTech (Hons) in Agricultural Technology">BTech (Hons) in Agricultural Technology</option>
            <option value="BTech (Hons) in Environmental Technology">BTech (Hons) in Environmental Technology</option>
            <option value="BSc in Textile and Clothing Technology">BSc in Textile and Clothing Technology</option>
            <option value="BSc in Fashion Merchandise Management">BSc in Fashion Merchandise Management</option>
            <option value="BBM (Hons) in Human Resource Management">BBM (Hons) in Human Resource Management</option>
            <option value="BBM (Hons) in Accounting and Finance">BBM (Hons) in Accounting and Finance</option>
            <option value="BBM (Hons) in Operations Management">BBM (Hons) in Operations Management</option>
            <option value="BBM (Hons) in Supply Chain Management">BBM (Hons) in Supply Chain Management</option>
            <option value="BSc (Hons) in Travel and Tourism Management">BSc (Hons) in Travel and Tourism Management</option>
            <option value="BSc (Hons) in E-Tourism and Digital Marketing">BSc (Hons) in E-Tourism and Digital Marketing</option>
            <option value="BSc (Hons) in Information Technology in Software Engineering">BSc (Hons) in Information Technology in Software Engineering</option>
            <option value="BSc (Hons) in Information Technology in Cloud Computing">BSc (Hons) in Information Technology in Cloud Computing</option>
            <option value="BSc (Hons) in Information Technology in Cyber Security">BSc (Hons) in Information Technology in Cyber Security</option>
            <option value="BSc (Hons) in Information Technology in Data Science">BSc (Hons) in Information Technology in Data Science</option>
            <option value="Bachelor of Applied Information Technology (BAIT)">Bachelor of Applied Information Technology (BAIT)</option>
            <option value="Bachelor of Music">Bachelor of Music</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Nationality: </td>
        <td><input type="text" class="name" name="nationality" placeholder="Enter nationality" value="<?= $fetch_products['nationality']; ?>"></td>
    </tr>
    <tr>
        <td>Profile picture: </td>
        <td><img src="uploaded_img/<?= $fetch_products['image']; ?>" alt=""><input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png"></td>
    </tr>
    <tr>
        <td><input type="submit" class="btn" value="Update Student" name="update_product"></td>
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
<a href="admin_studint.php" class="buttonne">Back</a>
</section>
    
</body>
</html>