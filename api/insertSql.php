<?php
function insertData($username,$photo,$email,$type){
    require 'connect.php';
    $sql="INSERT INTO `user_list` (`name`, `photo`, `email`, `email_type`) 
    VALUES ('$username', '$photo', '$email','$type')
    ON DUPLICATE KEY UPDATE `name` = '$username',`photo`='$photo'";
    $res=mysqli_query($connect,$sql);
} 