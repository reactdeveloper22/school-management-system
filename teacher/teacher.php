<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

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
      $insert_products = $conn->prepare("INSERT INTO `teacher`(`fname`, `lname`, `age`, `email`, `dateOfbirth`, `home`, `mobile`, `gender`, `idNum`, `address`, `postal`, `nationality`, `image`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
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
    header('location:student.php');
    
    
    }

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/teacher.css">
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
         <a href="teacherDashBoard.php">
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
         </a>
      </div>
      ';
   }
}

?>

<h1 class="tittleclass">Add Teacher</h1>


<table align="center" cellpadding="10">
<form class="studentF" action="" method="POST" enctype="multipart/form-data">
<div class="containerr">
    <tr>
        <td>First Name: </td>
        <td><input type="text" class="name" name="fname" placeholder="Enter First Name"</td>
    </tr>
    <tr>
        <td>Last Name: </td>
        <td><input type="text" class="name" name="lname" placeholder="Enter Last Name"</td>
    </tr>
    <tr>
        <td>Age: </td>
        <td><input type="number" class="name" name="age" placeholder="Enter Age"</td>
    </tr>
    <tr>
        <td>Email: </td>
        <td><input type="email" class="name" name="email" placeholder="Enter Email"</td>
    </tr>
    <tr>
        <td>Date Of Birth: </td>
        <td><input type="date" class="name" name="dateOf" placeholder="Enter Date of birth"</td>
    </tr>
    <tr>
    <td>Contact Number</td>
        <td class="num">Home: <input type="number" class="phone" name="home" placeholder="Enter Mobile number"> Mobile: <input type="number" class="phone" name="mobile" placeholder="Enter Mobile number"</td>
    </tr>
    <tr>
    <td>Gender: </td>
        <td>
        <select name="gender" class="box">
        <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="custom">Custom</option>
        </select>
        </td>
    </tr>
    <tr>
        <td>ID Number: </td>
        <td><input type="number" class="idNum" name="idNum" placeholder="Enter Id number"</td>
    </tr>
    <tr>
        <td>Address: </td>
        <td><textarea name="address" rows="6" cols="50" placeholder="Enter Address" ></textarea></td>
    </tr>
    <tr>
        <td>Postal Code: </td>
        <td><input type="text" class="name" name="postal" placeholder="Enter postal code"</td>
    </tr>
    <tr>
        <td>Nationality: </td>
        <td><input type="text" class="name" name="nationality" placeholder="Enter nationality"</td>
    </tr>
    <tr>
        <td>Profile picture: </td>
        <td><input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png"></td>
    </tr>
    <tr>
        <td><input type="submit" class="btn" value="Add Teacher" name="add_product"></td>
    </tr>
</div>
    </form>
</table>

<section class="buttenclass">
<a href="teacherDashBoard.php" class="buttonne">Back</a>
</section>
    
</body>
</html>