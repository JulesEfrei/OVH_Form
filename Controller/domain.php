<?php

    session_start();

    include_once ("Model/request.php");
    include_once ("Controller/req.php");


    function home() {

        include_once ("Template/home_page.php");

        // If data exist
        if(isset($_POST) && !empty($_POST)) {

            //ask cartId if we don't have one
            if(!isset($_SESSION['cartId'])) {

                $cartId = getCartId();

                $_SESSION['cartId'] = $cartId;

            }

            //Ask domain
            $exist = askDomain($_SESSION['cartId']);

            $_SESSION['domain'] = $exist['domain'];
            $_SESSION['is_orderable'] = $exist['is_orderable'];


            //Echo domain availability
            include_once ("Template/alert.php");



        }


    }