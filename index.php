<?php
use Phppot\Member;
if (! empty(htmlspecialchars($_POST["login-btn"]))) {
    require_once __DIR__ . '/lib/Member.php';
    $member = new Member();
    $loginResult = $member->loginMember();
}
if (! empty(htmlspecialchars($_POST["reg-btn"]))) {
    require_once __DIR__ . '/lib/Member.php';
    $member = new Member();
    $loginResult = $member->regMember();
}
session_start();
if(! empty($_SESSION["name"])){
  session_write_close();
  header("Location: home.php");
}
session_write_close();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css"
	crossorigin="anonymous">
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<link href="vendor/fontawesome/css/all.css"
	rel="stylesheet">

    <style>
	/*
 * Globals
 */


/* Custom default button */
.btn-secondary,
.btn-secondary:hover,
.btn-secondary:focus {
  color: #333;
  text-shadow: none; /* Prevent inheritance from `body` */
}


/*
 * Base structure
 */

body {
  
  box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
}

.cover-container {
  max-width: 42em;
}


/*
 * Header
 */

.nav-masthead .nav-link {
  padding: .25rem 0;
  font-weight: 700;
  color: rgba(255, 255, 255, .5);
  background-color: transparent;
  border-bottom: .25rem solid transparent;
}

.nav-masthead .nav-link:hover,
.nav-masthead .nav-link:focus {
  border-bottom-color: rgba(255, 255, 255, .25);
}

.nav-masthead .nav-link + .nav-link {
  margin-left: 1rem;
}

.nav-masthead .active {
  color: #fff;
  border-bottom-color: #fff;
}
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
<title>Панель лицензий</title>
</head>
<body class="bg-dark">
<?php

if (htmlspecialchars($_GET['action']) == "reg"){
    $template = 2;
} else {
    $template = 1;
}
    


require_once __DIR__ . '/template/login-template' . $template . '.php';

?>
</body>
</html>