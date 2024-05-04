<?php
require_once "./vendor/autoload.php";

use Sjtech\SimpleRest;

$simpleRest = new SimpleRest();
$simpleRest->get("/", function () {
    echo "We are innnnn!";
});
$simpleRest->get("/post/(id)", function ($id) {
    echo "ID: " . $id . " ";
});

$simpleRest->finish();
