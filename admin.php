<?php
namespace Phppot;
use Phppot\Member;
session_start();
if (! empty($_SESSION["name"])) {
    $name = $_SESSION["name"];
	require_once __DIR__ . '/lib/Member.php';
	$member = new Member();
	$user = $member->getMember($name);
  if ($user[0]["admin"] != 1){
    session_unset();
    $url = "./index.php";
    header("Location: $url");
  }
	require_once __DIR__ . '/lib/license.php';
	$ds = new license();
  require_once __DIR__ . '/lib/ObjectInfo.php';
	$os = new ObjectInfo();
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}
session_write_close();

if (isset($_POST["tiid"])) {
	$newid = htmlspecialchars($_POST["tiid"]).":nhfcnvbfqljrnjh";
    $lic = strtoupper(md5($newid));
	$query = 'INSERT INTO users(description, user_id, lic) VALUES ("Активированно вручную:\n'.$user[0]["username"]."\n".$user[0]["phone"]."\n".$user[0]["company"]."\n".$user[0]["object_name"].'", "'.htmlspecialchars($_POST["tiid"]).'", "'.$lic.'")';

	$memberRecord = $ds->execute($query);
}
if (isset($_GET['keyquery'])) {
  $query = 'SELECT * FROM users WHERE user_id LIKE "%'.$_GET['keyquery'].'%" OR lic LIKE "%'.$_GET['keyquery'].'%" OR description LIKE "%'.$_GET['keyquery'].'%"';
} else {
  $query = 'SELECT * FROM users';
}

$memberRecord = $ds->select($query);

if (isset($_GET['objquery'])) {
  $query = 'SELECT * FROM objects_info WHERE object_name LIKE "%'.$_GET['objquery'].'%" OR personal_name LIKE "%'.$_GET['objquery'].'%" OR personal_email LIKE "%'.$_GET['objquery'].'%" OR tel_num LIKE "%'.$_GET['objquery'].'%" OR company_name LIKE "%'.$_GET['objquery'].'%" OR sip_server_local_ip LIKE "%'.$_GET['objquery'].'%" OR sip_server_static_ip LIKE "%'.$_GET['objquery'].'%" OR sip_server_login LIKE "%'.$_GET['objquery'].'%" OR sip_server_password LIKE "%'.$_GET['objquery'].'%" OR sip_server_serial LIKE "%'.$_GET['objquery'].'%" OR anydesk LIKE "%'.$_GET['objquery'].'%" OR vnc LIKE "%'.$_GET['objquery'].'%" OR proxmox_local_ip LIKE "%'.$_GET['objquery'].'%" OR proxmox_static_ip LIKE "%'.$_GET['objquery'].'%" OR proxmox_login LIKE "%'.$_GET['objquery'].'%" OR proxmox_password LIKE "%'.$_GET['objquery'].'%" OR second_info LIKE "%'.$_GET['objquery'].'%" OR server_type LIKE "%'.$_GET['objquery'].'%" OR sip_alg LIKE "%'.$_GET['objquery'].'%"';
} else {
  $query = 'SELECT * FROM objects_info';
}

$objectRecord = $os->select($query);
?>
<HTML>
<HEAD>
<TITLE>Админка</TITLE>
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css"
	crossorigin="anonymous">
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<link href="vendor/fontawesome-free-5.15.3-web/css/all.css"
	rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})</script>
</HEAD>
<body class="d-flex h-100 text-center text-white bg-dark">
<script type="text/javascript" src="//www.gstatic.com/firebasejs/3.6.8/firebase.js"></script>
<script type="text/javascript" src="/firebase_subscribe.js"></script>
<div id="wrapper">
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
      <h3 class="float-md-start mb-0"><img src="/images/logo.png" alt="" width="112" height="50"></h3>
	  <h5 class="float-md-start mb-0" style="margin-top: 10px; margin-left: 30px;"><?php echo($user[0]["company"]) ?></h5>
      <nav class="nav nav-masthead justify-content-center float-md-end">
	  
        <a class="nav-link " aria-current="page" href="/home.php">Лицензии</a>
		<?php if ($user[0]["admin"] == 1){echo('<a class="nav-link active" href="#">Админка</a>');} ?>
		<a class="nav-link" href="/settings.php">Настройки</a>
        <a class="nav-link" href="/exit.php">Выйти</a>
      </nav>
    </div>
  </header>

  <main class="px-3">
	  
  <div class="btn-group">
  <a href="/admin.php" class="btn btn-primary<?php if(empty($_GET["act"])){echo(' active" aria-current="page"');}else{echo('"');} ?>>Ключи консьерж</a>
  <a href="/admin.php?act=lic" class="btn btn-primary<?php if($_GET["act"] == "lic"){echo(' active" aria-current="page"');}else{echo('"');} ?>>Ключи SIP</a>
  <a href="/admin.php?act=users" class="btn btn-primary<?php if($_GET["act"] == "users"){echo(' active" aria-current="page"');}else{echo('"');} ?>>Пользователи</a>
  <a href="/admin.php?act=objects" class="btn btn-primary<?php if($_GET["act"] == "objects"){echo(' active" aria-current="page"');}else{echo('"');} ?>>Объекты</a>
  <a href="/admin.php?act=bans" class="btn btn-primary<?php if($_GET["act"] == "bans"){echo(' active" aria-current="page"');}else{echo('"');} ?>>Блокировки</a>
</div>
<?php

//////////
//////////    Управление ключами
//////////

if (empty($_GET["act"])){
  if (!empty($_GET["del"])) {
    
    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Ключ '.htmlspecialchars($_GET["del"]).' будет удалён!
   
  <hr>
  <a href="/admin.php?realdel='.$_GET["del"].'" class="btn btn-danger">Удалить</a>
  <a href="/admin.php" class="btn btn-primary">Отмена</a>
</div>
    ');
  }
  if (!empty($_GET["realdel"])) {
    $query = 'DELETE FROM users WHERE lic = "'.$_GET["del"].'"';

    $deletesql = $ds->select($query);

    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Ключ '.htmlspecialchars($_GET["del"]).' успешно удалён! 
</div>
    ');
  }
    ?><br><br>
    <form method="get" action="/admin.php">
    <div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Запрос" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyquery">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit">Найти</button>
  </div>
</div>
    </form>
  <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ключ активации</th>
      <th scope="col">ID</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  $i = 1;
		foreach ($memberRecord as &$value) {
      if ($_GET["del"] != $value["lic"]) {
        echo '
			<tr >
      <th scope="row">'.$i.'</th>
      <td width="40%"><input class="form-control" type="text" value="'.$value["lic"].'" aria-label="readonly input example" readonly></td>
      <td>'.$value["user_id"].'</td>
      <!--<td style="word-wrap: break-word;min-width: 160px;max-width: 160px;">'.$value["description"].'</td>-->
      <td><button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#Modal'.$value["id"].'" >
      <i class="fas fa-info mt-2" style="color:white"></i>
    </button> <a href="/admin.php?del='.$value["lic"].'" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Удаляет только из базы, лицензия у клиента не слетает"><i class="fas fa-times mt-2"></a></td>
        
      </tr>

      <!-- Modal -->
<div class="modal fade" id="Modal'.$value["id"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modald-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: black; text-shadow:none;">Описание</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="color: black; text-shadow:none;">
      <textarea class="form-control" id="exampleFormControlTextarea1" name="second_info" rows="5" disabled>
      '.$value["description"].'
      </textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="color: white; text-shadow:none;">Закрыть</button>
      </div>
    </div>
  </div>
</div>
			';
      $i++;
      }
			
			
		}
	  ?>
  </tbody>
</table>
<?php
} 


if ($_GET["act"] == "lic") {
  $str = "";
  if (isset($_GET["id"])){
    $prekey = $_GET["id"];
    for ($i=0; $i < strlen($prekey); $i++) { 
      $char = chr(ord($prekey[$i]) - 5);
      $str = $str . $char;
    }
    $key = "nhfcnvb" . substr($str, 0, strlen($str) - 17) . "fqljrnjh" . substr($str, strlen($str) - 17, 17) . "nhefqgb";
    echo '<br><br><div class="alert alert-success" role="alert">
    ' . md5($key) . '
  </div>';
  }
  echo '
  <br>
	<div class="card text-dark" style="text-shadow: none;" >
  <div class="card-header">
    Выпуск новой лицензии
  </div>
  <form name="activate" action="/admin.php?act=lic" method="get">
  <div class="card-body">
  <input type="id" class="form-control" name="act" value="lic" hidden id="inputPassword">
  <div class="mb-3 row">
    <label for="inputPassword" class="col-sm-3 col-form-label">ID Сервера</label>
    <div class="col-8">
      <input type="id" class="form-control" name="id" id="inputPassword">
    </div>
  </div>
  

  <div class="mb-3 row">
    <label for="inputPassword" class="col-sm-3 col-form-label">Описание</label>
    <div class="col-8">
      <input type="id" class="form-control" name="desc" id="inputPassword">
    </div>
    </div>

    <div class="mb-3 row">
    <label for="inputPassword" class="col-sm-3 col-form-label">ФИО</label>
    <div class="col-8">
      <input type="id" class="form-control" name="fio" id="inputPassword">
    </div>
    </div>

  <input type="submit" value="Активировать"
  class="btn bg-primary text-white col-sm-3"
  name="login-btn">
  </div>
  </form>
</div>
	';
}

//////////
//////////    Управление пользователями
//////////

if ($_GET["act"] == "users") {
  if (!empty($_GET["login"])) {
            session_start();
            $_SESSION["username"] = htmlspecialchars($_GET["login"]);
            $_SESSION["name"] = htmlspecialchars($_GET["login"]);
            $_SESSION["isadmin"] = "admin";
            session_write_close();
            $url = "home.php";
            header("Location: $url");
  }
  if (!empty($_GET["ban"])) {
    $ban = $member->banMember(htmlspecialchars($_GET["ban"]));
    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Пользователь '.htmlspecialchars($_GET["ban"]).' успешно заблокирован! 
</div>
    ');
}
if (!empty($_GET["unban"])) {
  $unban = $member->unbanMember(htmlspecialchars($_GET["unban"]));
    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Пользователь '.htmlspecialchars($_GET["unban"]).' успешно разблокирован! 
</div>
    ');
}
if (!empty($_GET["key"])) {
  $edituser = $member->getMember($_GET["key"]);
  require_once __DIR__ . '/lib/DataSource.php';
  $nm = new DataSource();
  if (!empty($_POST["c"])) {
    $query = 'UPDATE tbl_member SET count = '.$_POST["c"].' WHERE username = "'.$_GET["key"].'"';
       
    $done = $nm->execute($query);
    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Сохранено! 
</div>
    ');
  } else {
    
    echo('<br><br>
    <div class="card" style="color:black;text-shadow:none;">
  <div class="card-header">
    Кол-во ключей у '.$_GET["key"].'
  </div>
  <div class="card-body">
    <form name="login" action="?act=users&key='.$_GET["key"].'" method="post">
    <input type="number" value="'.$edituser[0]["count"].'" class="form-control" placeholder="Количество лицензий"
    name="c" min="0"><br>
    <input type="submit" value="Применить"
							class="btn bg-primary float-end text-white w-100"
							name="login-btn">
    </form>
  </div>
</div>
    ');
  }
}
if(!empty($_GET["confirm"])){
  $unban = $member->activateMember(htmlspecialchars($_GET["confirm"]));
  echo('
  <br><br>
    <div class="alert alert-primary" role="alert">
  Почта пользователя активированна! 
</div>
  ');
}
?>



<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Почта</th>
      <th scope="col">Телефон</th>
      <th scope="col">Компания</th>
      <th scope="col">Оъект</th>
      <th scope="col">Действия</th>
    </tr>
  </thead>
  <tbody>
	  <?php
      $allusers = $member->allMembers();
	  $i = 1;
		foreach ($allusers as &$value) {
            if($value["banned"] == 1){
                $email = "<p style='color: red'>".$value["username"]."</p>";
                $button = '<a href="/admin.php?act=users&unban='.$value["username"].'" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="right" title="Разбанить пользователя"><i class="fas fa-unlock"></i></a>';
                
            } else {
                $email = $value["username"];
                if ($value["confirm"] != "0") {
                  $button = '<a href="/admin.php?act=users&login='.$email.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Войти в аккаунт"><i class="fas fa-eye"></i></a> <a href="/admin.php?act=users&ban='.$email.'" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Блокировка пользователя"><i class="fas fa-times"></i></a> <a href="/admin.php?act=users&key='.$email.'" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="right" title="Изменить кол-во лицензий"><i class="fas fa-key" style="color: white;"></i></a> <a href="/admin.php?act=users&confirm='.$email.'" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="right" title="Подтвердить почту"><i class="fas fa-envelope-open-text"></i></a>';

                } else {
                  $button = '<a href="/admin.php?act=users&login='.$email.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Войти в аккаунт"><i class="fas fa-eye"></i></a> <a href="/admin.php?act=users&ban='.$email.'" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Блокировка пользователя"><i class="fas fa-times"></i></a> <a href="/admin.php?act=users&key='.$email.'" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="right" title="Изменить кол-во лицензий"><i class="fas fa-key" style="color: white;"></i></a>';

                }
                            }
      $num = substr($value["phone"], 0, 1);
      if ($num == "8") {
        $num = "7".substr($value["phone"], 1);
      } elseif ($num == "+") {
        $num = substr($value["phone"], 1);
      } else {
        $num = $value["phone"];
      }
			echo '
			<tr>
      <th scope="row">'.$value["id"].'</th>
      <td>'.$email.'</td>
      <td><a href="/objinfo.php?tel_num='.$num.'">'.$value["phone"].'</a></td>
      <td>'.$value["company"].'</td>
      <td>'.$value["object_name"].'</td>
      <td>'.$button.'</td>
    </tr>
			';
			$i++;
		}
	  ?>
  </tbody>
</table>



<?php
}
if ($_GET["act"] == "objects") {

?>
<br><br>
    <form method="get" action="/admin.php?act=objects">
    <div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Запрос" aria-label="Recipient's username" aria-describedby="basic-addon2" name="objquery">
  <input type="text" name="act" value="objects" hidden>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit">Найти</button>
  </div>
</div>
    </form>
  <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Объект</th>
      <th scope="col">Компания</th>
      <th scope="col">Телефон</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
	  <?php
	  $i = 1;
		foreach ($objectRecord as &$value) {
        echo '
			<tr >
      <th scope="row">'.$i.'</th>
      <td ><div style="width:250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$value["object_name"].'</div></td>
      <td><div style="width:130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$value["company_name"].'</div></td>
      <td width="40%"><input class="form-control" type="text" value="'.$value["tel_num"].'" aria-label="readonly input example" readonly></td>
      <td width="10%"><a href="/objinfo.php?object_id='.$value["object_id"].'" class="btn btn-primary" ><i class="fas fa-info mt-2" style="color:white"></i></a>
      <a href="/disabled_admin.php?del='.$value["tel_num"].'" disabled class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Удаляет только из базы, лицензия у клиента не слетает"><i class="fas fa-times mt-2"></a></td>
        
      </tr>

     
			';
      $i++;
			
			
		}
	  ?>
  </tbody>
</table>

<?php
}
if ($_GET["act"] == "bans") {
  if (!empty($_POST["type"]) && !empty($_POST["c"])) {
    require_once __DIR__ . '/lib/DataSource.php';
  $nm = new DataSource();
    $query = 'INSERT INTO tbl_banhammer(param, data) VALUES ("'.$_POST["type"].'", "'.$_POST["c"].'")';
       
    $done = $nm->execute($query);
    switch ($_POST["type"]) {
      case '1':
        echo '
        <div class="alert alert-primary" role="alert">
        Все пользователи, содержащие в почте "'.$_POST["c"].'", будут блокироваться автоматически.
      </div>
        ';
        break;

      case '2':
        echo '
        <div class="alert alert-primary" role="alert">
        Все пользователи, содержащие в названии компании "'.$_POST["c"].'", будут блокироваться автоматически.
      </div>
        ';
        break;

      case '3':
        echo '
        <div class="alert alert-primary" role="alert">
        Все пользователи, содержащие в названии объекта "'.$_POST["c"].'", будут блокироваться автоматически.
      </div>
        ';
        break;

      case '4':
        echo '
        <div class="alert alert-primary" role="alert">
        Все пользователи, указавшие номер телефона "'.$_POST["c"].'", будут блокироваться автоматически.
      </div>
        ';
        break;

      case '5':
        echo '
        <div class="alert alert-primary" role="alert">
        Все пользователи, с диапазоном ip "'.$_POST["c"].'", будут блокироваться автоматически.
      </div>
        ';
        break;
      
      default:
      echo '
      <div class="alert alert-danger" role="alert">
      Неверный пункт списка.
    </div>
      ';
        break;
    }
  }
?>
<br><br>
    <div class="card" style="color:black;text-shadow:none;">
  <div class="card-header">
    Добавить правило блокировки.
  </div>
  <div class="card-body">
    <form name="login" action="?act=bans" method="post">
    <select class="form-select" name="type" aria-label="Default select example">
  <option value="1" selected>Блокировать пользователя, если в почте содержится:</option>
  <option value="2">Блокировать пользователя, если в названии компании содержится:</option>
  <option value="3">Блокировать пользователя, если в названии объекта содержится:</option>
  <option value="4">Блокировать пользователя, если номер телефона:</option>
  <option value="5">Блокировать пользователя, если ip адрес входит в диапазон(192.168.4.205-192.168.4.210):</option>
</select>
    <input type="text" class="form-control" placeholder="Данные"
    name="c"><br>
    <input type="submit" value="Добавить"
							class="btn bg-primary float-end text-white w-100"
							name="login-btn">
    </form>
  </div>
</div>
<?php
}

?>

  </main>

  <footer class="mt-auto text-white-50">
    <p>© 2010-2022. «<a href="https://true-ip.ru/" class="text-white">Тру Ай Пи</a>», Все права защищены .</p>
  </footer>
</div>


    
  <script>
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
  </script>
</div>
</body>
</HTML>
