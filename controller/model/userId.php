<?php 

function getUserId($session_id){
    session_id($session_id);
    session_start();

    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        return null;    
    }
}

?>