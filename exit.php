<?php

session_start();

$_SESSION["username"] = "";
$_SESSION["name"] = "";
$_SESSION["isadmin"] = "";
session_write_close();

header("Location: /");

?>