<?php

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