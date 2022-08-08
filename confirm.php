<?php
use Phppot\Member;
session_start();
if (! empty(htmlspecialchars($_GET["code"])) && ! empty(htmlspecialchars($_GET["email"]))) {
    require_once __DIR__ . '/lib/Member.php';
    $name = htmlspecialchars($_GET["email"]);
    $member = new Member();
    $user = $member->getMember($name);
    if($user[0]["confirm"] != htmlspecialchars($_GET["code"])){
        $url = "./index.php";
        header("Location: $url");
    } else {
        $confirm = $member->activateMember(htmlspecialchars($_GET["email"]));
        $html = '
        <div class="card">
  <div class="card-header">
  Почта подтверждена
  </div>
  <div class="card-body">
    <h5 class="card-title">Ура!🎉</h5>
    <p class="card-text">Почта подтверждена, теперь вы можете зайти.</p>
    <a href="/" class="btn btn-primary">Авторизация</a>
  </div>
</div>
        ';
    }
} else {
    $html = '
    <div class="card">
    <div class="card-header">
      Почта
    </div>
    <div class="card-body">
      <h5 class="card-title">Подтвердите почту</h5>
      <p class="card-text">Вам необходимо подтвердить владение данной почтой.</p>
    </div>
  </div>
    

        ';
}
session_write_close();
?>
<HTML>
<HEAD>
<TITLE>Подтверждение почты</TITLE>
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css"
	crossorigin="anonymous">
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<link href="vendor/fontawesome-free-5.15.3-web/css/all.css"
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
</HEAD>
<BODY class="bg-dark">
  <div
		class="d-flex flex-column min-vh-100 justify-content-center  align-items-center">
		<div class="card  ">
			<?php echo $html; ?>
		</div>

</BODY>
</HTML>