<?php

    function email_exist($email, $con){
        $result = mysqli_query($con, "select userID from userinfo where email='$email'");
        if (mysqli_num_rows($result) == 1){
            return true;
        }
        else {
            return false;
        }
    }

?>