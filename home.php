<?php
namespace Phppot;
use Phppot\Member;
session_start();

if (! empty($_SESSION["name"])) {
    $name = $_SESSION["name"];
	require_once __DIR__ . '/lib/Member.php';
	$member = new Member();
	$user = $member->getMember($name);
  if ($user[0]["banned"] == "1") {
    session_unset();
    session_write_close();
    header("Location: /banned.html");
  }
	require_once __DIR__ . '/lib/license.php';
	$ds = new license();
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}
session_write_close();

if (!empty(htmlspecialchars($_POST["tiid"]))) {
	$newid = htmlspecialchars($_POST["tiid"]).":nhfcnvbfqljrnjh";
    $lic = strtoupper(md5($newid));
	$query = 'INSERT INTO users(description, user_id, lic) VALUES ("Активированно вручную:\n'.$user[0]["username"]."\n".$user[0]["phone"]."\n".$user[0]["company"]."\n".$user[0]["object_name"].'", "'.htmlspecialchars($_POST["tiid"]).'", "'.$lic.'")';

	$memberRecord = $ds->execute($query);
}

$query = 'SELECT * FROM users WHERE description LIKE "%'.$user[0]["username"].'%" OR description LIKE "%'.$user[0]["phone"].'%" OR description LIKE "%'.$user[0]["company"].'%" OR description LIKE "%'.$user[0]["object_name"].'%"';

$memberRecord = $ds->select($query);
?>
<HTML>
<HEAD>
<TITLE>Ваши лицензии</TITLE>
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css"
	crossorigin="anonymous">
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<link href="vendor/fontawesome-free-5.15.3-web/css/all.css"
	rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
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
  text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
  
}

#wrapper { 
    width:100%;
    height: 100%;
	box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
  overflow: auto;
}

.cover-container {
  max-width: 60em;
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
<body class="d-flex h-100 text-center text-white bg-dark">
<div id="wrapper">
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
      <h3 class="float-md-start mb-0"><img src="/images/logo.png" alt="" width="112" height="50"></h3>
	  <h5 class="float-md-start mb-0" style="margin-top: 10px; margin-left: 30px;"><?php echo($user[0]["company"]) ?></h5>
      <nav class="nav nav-masthead justify-content-center float-md-end">
	  
        <a class="nav-link active" aria-current="page" href="#">Лицензии</a>
		<?php if ($user[0]["admin"] == 1){echo('<a class="nav-link" href="/admin.php">Админка</a>');} ?>
		<a class="nav-link" href="/settings.php">Настройки</a>
        <a class="nav-link" href="/exit.php">Выйти</a>
      </nav>
    </div>
  </header>

  <main class="px-3">
	  <?php
	  if (!empty(htmlspecialchars($_POST["tiid"]))) {
		  echo '
		  <div class="alert alert-success " style="text-shadow: none;" role="alert">
		  Лицензия активированна: '.$lic.'
		</div> 
		  ';
	  }
		$num = count($memberRecord);
		if ($num >= $user[0]["count"]) {
			echo '
			<div class="alert alert-danger " style="text-shadow: none;" role="alert">
  Количество бесплатных лицензий для вас кончилось. Для приобритения новой лицензии обратитесь в <a href="mailto:info@true-ip.ru" class="alert-link">Отдел продаж</a>.
</div>
			';
		}
		if ($num != 0) {
			
	  ?>
  
  <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ключ активации</th>
      <th scope="col">ID</th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  $i = 1;
		foreach ($memberRecord as &$value) {
			echo '
			<tr>
      <th scope="row">'.$i.'</th>
      <td><input class="form-control" type="text" value="'.$value["lic"].'" aria-label="readonly input example" readonly></td>
      <td>'.$value["user_id"].'</td>
    </tr>
			';
			$i++;
		}
	  ?>
  </tbody>
</table>
<?php

}
if ($num < $user[0]["count"]) {
	echo '
	<div class="card text-dark" style="text-shadow: none;" >
  <div class="card-header">
    Выпуск новой лицензии
  </div>
  <form name="activate" action="/home.php" method="post">
  <div class="card-body">
  <div class="mb-3 row">
  
    <label for="inputPassword" class="col-sm-3 col-form-label">TI-Concierge ID</label>
    <div class="col-sm-5">
      <input type="id" class="form-control" name="tiid" id="inputPassword">
    </div>
	<input type="submit" value="Активировать"
							class="btn bg-primary text-white col-sm-3"
							name="login-btn">
	
  </div>
    
  </div>
  </form>
</div>
	';
}
?>




  </main>

  <footer class="mt-auto text-white-50">
    <p>© 2010-2022. «<a href="https://true-ip.ru/" class="text-white">Тру Ай Пи</a>», Все права защищены .</p>
  </footer>
</div>


    
  
</div>
</body>
</HTML>
