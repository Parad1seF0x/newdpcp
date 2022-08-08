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
<TITLE>Настройки</TITLE>
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css"
	crossorigin="anonymous">
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<link href="vendor/fontawesome-free-5.15.3-web/css/all.css"
	rel="stylesheet">
    <link href="vendor/fontawesome/css/all.css"
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
	  
        <a class="nav-link " aria-current="page" href="/home.php">Лицензии</a>
		<?php if ($user[0]["admin"] == 1){echo('<a class="nav-link " href="/admin.php">Админка</a>');} ?>
		<a class="nav-link active" href="#">Настройки</a>
        <a class="nav-link" href="/exit.php">Выйти</a>
      </nav>
    </div>
  </header>

  <main class="px-3">
	  
  
  <div class="card p-4 mb-5">
			<div class="card-header" style="background-color: white; color: #212529; text-shadow: none">
				<h3><a href="/" style="text-decoration: none; "><</a> Настройки</h3>
			</div>
			<div class="card-body w-100">
				<form name="login" action="" method="post">
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-user mt-2"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo($user[0]["username"]); ?>" placeholder="Почта"
							name="username">
					</div>
					
					
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-phone mt-2"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo($user[0]["phone"]); ?>" placeholder="Телефон"
							name="phone">
					</div>
					
					<div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-building mt-2"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo($user[0]["object_name"]); ?>" placeholder="Название объекта"
							name="object">
					</div>
					<?php 
					
	  				if ($_SESSION["isadmin"] != "admin") {
						  echo '<div class="input-group form-group mt-3">
						  <div class="bg-primary text-light rounded-start">
							  <span class="m-3"><i class="fas fa-key mt-2"></i></span>
						  </div>
						  <input type="password" class="form-control" placeholder="Старый пароль"
							  name="password">
					  </div>';
					  }

					?>
                    
                    <div class="input-group form-group mt-3">
						<div class="bg-primary text-light rounded-start">
							<span class="m-3"><i class="fas fa-key mt-2"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Новый пароль(Можно оставить пустым)"
							name="repassword">
					</div>

					<div class="form-group mt-3">
						<input type="submit" value="Изменить настройки"
							class="btn bg-primary float-end text-white w-100"
							name="reg-btn">
					</div>
				</form>
                <?php if(!empty($loginResult)){?>
				<div class="text-danger"><?php echo $loginResult;?></div>
				<?php }?>
			</div>
			
			
		</div>




  </main>

  <footer class="mt-auto text-white-50">
    <p>© 2010-2022. «<a href="https://true-ip.ru/" class="text-white">Тру Ай Пи</a>», Все права защищены .</p>
  </footer>
</div>


    
  
</div>
</body>
</HTML>
