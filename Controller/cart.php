<?php

    include_once ("Model/request.php");
    include_once ("Controller/req.php");

    function newitem() {

        $post = new PostReq();
        $get = new GetReq();

        $array = [
            'domain'=> $_SESSION['domain']
        ];

        $post->makePostReq("https://www.ovh.com/engine/apiv6/order/cart/" . $_SESSION['cartId'] . "/domain?domain=", $array);

        $_SESSION['item-id'] = json_decode($get->makeGetReq("https://www.ovh.com/engine/apiv6/order/cart/" . $_SESSION['cartId'] . "/item"), true);

    }

    function getNameFromId($elm) {

        $get = new GetReq();

        $data = json_decode($get->makeGetReq("https://www.ovh.com/engine/apiv6/order/cart/" . $_SESSION['cartId'] . "/item/" . $elm), true);

        $_SESSION['item-name'] = [];

        array_push($_SESSION['item-name'], $data["settings"]["domain"]);

        echo($data["settings"]["domain"]);

    }

    function deleteItem($id) {

        $delete = new DeleteReq();

        $data = $delete->makeDeleteReq("https://www.ovh.com/engine/apiv6/order/cart/" . $_SESSION['cartId'] . "/item/" . $id);

        $nb = array_search(intval($id), $_SESSION['item-id']);
        unset($_SESSION['item-id'][$nb]);
        unset($_SESSION['item-name'][$nb]);

    }