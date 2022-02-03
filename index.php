<?php

// Initialize variables
$user = json_decode($_POST['user'], true);
$domain = $_POST['domain'];

// Convert string to array
$domain = str_replace("[", "", $domain);
$domain = str_replace('"', "", $domain);
$domain = str_replace("]", "", $domain);
$domain = explode(",", $domain);
