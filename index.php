<?php

<<<<<<< HEAD
    include_once("Controller/domain.php");
    include_once("Controller/cart.php");

    if(isset($_GET['action'])) {

        if($_GET['action'] == "domain") {
            home();
        } elseif ($_GET['action'] == "destroye") {
            session_destroy();
            header('Location: index.php?action=domain');
        } elseif ($_GET['action'] == "newitem") {
            newitem();
            header('Location: index.php?action=domain');
        } elseif ($_GET['action'] == "deleteitem") {
            deleteItem($_GET['id']);
            header('Location: index.php?action=domain');
        }

    } else {
        home();
    }
=======
    include_once ("Controller/controller.php");

    switch ($_GET){
        case "index.php":
            home();
        default :
            home();
    }
>>>>>>> e889cb993df8e4dc7e6a78aadd2f38ccd7e33c52
