<?php

if (!fromIndex){die('You must access this through the root index!');}

    require_once('./Database/Connection.php');
    
    if (isset($_POST['loginUser']) && isset($_POST['loginPass'])){
    	
        $username = htmlspecialchars($_POST['loginUser']);
        $password = htmlspecialchars($_POST['loginPass']);
        
        connect();

        if ($connection === null || !mysqli_ping($connection)){
            die('Database connection failed');
        }else{
            require_once('./Database/UserIO.php');
            $valid = userGetPasswordIsValidByName($username, $password);
            if ($valid){
                $_SESSION['authorized'] = $valid;
            }
        }
    }elseif (isset($_SESSION['authorized'])){
        $_SESSION['authorized'] = null;
    }else{
    	unset($_POST['loginUser']);
    	unset($_POST['loginPass']);
    }

?>