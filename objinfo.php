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
  if ($user[0]["admin"] != 1){
    session_unset();
    $url = "./index.php";
    header("Location: $url");
  }
	require_once __DIR__ . '/lib/ObjectInfo.php';
	$ds = new ObjectInfo();
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}
if ($user[0]['admin'] != '1') {
    session_unset();
    $url = "./index.php?tel_num=".$_GET['tel_num'];
    header("Location: $url");
}
session_write_close();

if (isset($_GET['edit'])) {
  switch ($_GET['edit']) {
    case 'contacts':
      $query = 'SELECT * FROM objects_info WHERE id = "'.$_GET['id'].'"';
      break;

    case 'object':
      $query = 'SELECT * FROM objects_info WHERE object_id = "'.$_GET['id'].'"';
      break;
    
    default:
      $query = 'SELECT * FROM objects_info';
      break;
  }
} else {
  if (isset($_GET['tel_num'])) {
    $query = 'SELECT * FROM objects_info WHERE tel_num = '.$_GET['tel_num'];
  } else {
    $query = 'SELECT * FROM objects_info WHERE object_id = "'.$_GET['object_id'].'"';
  }
}



$memberRecord = $ds->select($query);
?>
<HTML>
<HEAD>
<TITLE>Объекты по номеру <?php if (isset($_GET['tel_num'])) {echo $_GET['tel_num'];} ?></TITLE>
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
  <header class="mb-3">
    <div>
      <h3 class="float-md-start mb-0"><img src="/images/logo.png" alt="" width="112" height="50"></h3>
	  <h5 class="float-md-start mb-0" style="margin-top: 10px; margin-left: 30px;"><?php echo($user[0]["company"]) ?></h5>
      <nav class="nav nav-masthead justify-content-center float-md-end">
	  
        <a class="nav-link active" aria-current="page" href="/home.php">Лицензии</a>
		<?php if ($user[0]["admin"] == 1){echo('<a class="nav-link" href="/admin.php">Админка</a>');} ?>
		<a class="nav-link" href="/settings.php">Настройки</a>
        <a class="nav-link" href="/exit.php">Выйти</a>
      </nav>
    </div>
  </header>

  <main class="px-3">
	  <!-- start -->
      

  <br>

  <?php
        if (isset($_GET['edit'])) {
          switch ($_GET['edit']) {
            case 'contacts':
              $i = 1;
		foreach ($memberRecord as &$value) {
      if ($i == 1) {
        echo ' <form action="/objinfo.php?edit=savecontacts" method="post">
        <div class="card bg-light" style="width: 100%; text-shadow: 0 0 0; color: #333">
  <div class="card-body">
    <h5 class="card-title">Контакты</h5>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a1" class="form-label text-black">Имя</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a1" class="form-control mb-2" name="personal_name" value="'.htmlspecialchars($value["personal_name"]).'" >

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a2" class="form-label">Почта</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a2" class="form-control mb-2" name="personal_email" value="'.htmlspecialchars($value["personal_email"]).'" >

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a3" class="form-label">Телефон</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a3" class="form-control mb-2" name="tel_num" value="'.htmlspecialchars($value["tel_num"]).'" >

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a4" class="form-label">Компания</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a4" class="form-control" name="company_name" value="'.htmlspecialchars($value["company_name"]).'" >
    <br>
    <input name="id" value="'.htmlspecialchars($value["id"]).'" hidden>
    <button type="submit" class="btn btn-primary">Сохранить</button>

    <a href="/admin.php?act=objects" class="btn btn-secondary" style="color:white">Отмена</a>
  </div>
</div><br></form>
        ';
      }}
              break;

            case 'object':
              $i = 1;
		foreach ($memberRecord as &$value) {
      echo(' <form action="/objinfo.php?edit=saveobjects" method="post">
      <div class="card text-black" style="text-shadow: 0 0 0; color: #333">
        <div class="card-header">
          '.htmlspecialchars($value["object_name"]).'
        </div>
        <div class="card-body text-start">
        
      <div class="card bg-light" style="width: 100%;">
        <div class="card-body">
          <h5 class="card-title">Данные</h5>
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b1" class="form-label text-black">Anydesk</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b1" class="form-control mb-2" name="anydesk" value="'.htmlspecialchars($value["anydesk"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b2" class="form-label">VNC</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b2" class="form-control mb-2" name="vnc" value="'.htmlspecialchars($value["vnc"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b3" class="form-label">Тип сервера</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b3" class="form-control mb-2" name="server_type" value="'.htmlspecialchars($value["server_type"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b4" class="form-label">SIP ALG</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b4" class="form-control" name="sip_alg" value="'.htmlspecialchars($value["sip_alg"]).'" >
          
        </div>
      </div>
      <div class="card bg-light" style="width: 100%; margin-top:15px">
        <div class="card-body">
          <h4 class="card-title">Сервер</h4>
      
          <div class="row">
            <div class="col">
              <h5 class="card-title">SIP</h5>
      
              <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c1" class="form-label text-black">Local IP</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c1" class="form-control mb-2" name="sip_server_local_ip" value="'.htmlspecialchars($value["sip_server_local_ip"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c2" class="form-label">Static IP</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c2" class="form-control mb-2" name="sip_server_static_ip" value="'.htmlspecialchars($value["sip_server_static_ip"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c3" class="form-label">Login</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c3" class="form-control mb-2" name="sip_server_login" value="'.htmlspecialchars($value["sip_server_login"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c4" class="form-label">Password</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c4" class="form-control mb-2" name="sip_server_password" value="'.htmlspecialchars($value["sip_server_password"]).'" >
          <input type="checkbox" onclick="mySFunction'.htmlspecialchars($value["id"]).'()">Show Password
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c5" class="form-label">Serial #</label>
          
            </div>
            <div class="col">
              <h5 class="card-title">PROX</h5>
      
              <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d1" class="form-label text-black">Local IP</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d1" class="form-control mb-2" name="proxmox_local_ip" value="'.htmlspecialchars($value["proxmox_local_ip"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d2" class="form-label">Static IP</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d2" class="form-control mb-2" name="proxmox_static_ip" value="'.htmlspecialchars($value["proxmox_static_ip"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d3" class="form-label">Login</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d3" class="form-control mb-2" name="proxmox_login" value="'.htmlspecialchars($value["proxmox_login"]).'" >
      
          <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d4" class="form-label">Password</label>
          <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d4" class="form-control" name="proxmox_password" value="'.htmlspecialchars($value["proxmox_password"]).'" >
          
            </div>
        </div>
        
          
        </div>
      </div><br>
      <label for="exampleFormControlTextarea1" class="form-label">Комментарий</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" name="second_info" rows="5">'.htmlspecialchars($value["second_info"]).'</textarea>
          <br>
          <input name="id" value="'.htmlspecialchars($value["id"]).'" hidden>
          <button type="submit" class="btn btn-primary">Сохранить</button>
          <a href="/admin.php?act=objects" class="btn btn-secondary" style="color:white">Отмена</a>
        </div></form>');
    }
              break;

              case 'savecontacts':
                $query = 'UPDATE objects_info SET personal_name = "'.$_POST['personal_name'].'", personal_email = "'.$_POST['personal_email'].'", tel_num = "'.$_POST['tel_num'].'", company_name = "'.$_POST['company_name'].'" WHERE id = "'.$_POST['id'].'";';

    $deletesql = $ds->update($query);

    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Контакты обновлены! 
</div>
    ');
                break;

              case 'saveobjects':


                $query = 'UPDATE objects_info SET anydesk = "'.$_POST['anydesk'].'", vnc = "'.$_POST['vnc'].'", server_type = "'.$_POST['server_type'].'", sip_alg = "'.$_POST['sip_alg'].'", sip_server_local_ip = "'.$_POST['sip_server_local_ip'].'", sip_server_static_ip = "'.$_POST['sip_server_static_ip'].'", sip_server_login = "'.$_POST['sip_server_login'].'", sip_server_password = "'.$_POST['sip_server_password'].'", sip_server_serial = "'.$_POST['sip_server_serial'].'", proxmox_local_ip = "'.$_POST['proxmox_local_ip'].'", proxmox_static_ip = "'.$_POST['proxmox_static_ip'].'", proxmox_login = "'.$_POST['proxmox_login'].'", proxmox_password = "'.$_POST['proxmox_password'].'", second_info = "'.$_POST['second_info'].'" WHERE id = "'.$_POST['id'].'";';

    $deletesql = $ds->update($query);

    echo('<br><br>
    <div class="alert alert-primary" role="alert">
  Объект обновлен! 
</div>
    ');
                break;
            
            default:
              # code...
              break;
          }
        } else {
      ?>


  <div class="accordion" id="accordionExample">
	  <?php
	  $i = 1;
		foreach ($memberRecord as &$value) {
      if ($i == 1) {
        echo '
        <div class="card bg-light" style="width: 100%; text-shadow: 0 0 0; color: #333">
  <div class="card-body">
    <h5 class="card-title">Контакты</h5>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a1" class="form-label text-black">Имя</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a1" class="form-control mb-2" value="'.htmlspecialchars($value["personal_name"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a2" class="form-label">Почта (<a href="mailto:'.htmlspecialchars($value["personal_email"]).'" class="card-link">Написать</a>)</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a2" class="form-control mb-2" value="'.htmlspecialchars($value["personal_email"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a3" class="form-label">Телефон (<a href="tel:'.htmlspecialchars($value["tel_num"]).'" class="card-link">Позвонить</a>)</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a3" class="form-control mb-2" value="'.htmlspecialchars($value["tel_num"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'a4" class="form-label">Компания</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'a4" class="form-control" value="'.htmlspecialchars($value["company_name"]).'" readonly>
    <br>
    <a href="/objinfo.php?edit=contacts&id='.htmlspecialchars($value["id"]).'" class="btn btn-primary">Редактировать</a>
  </div>
</div><br>
        ';
      }
			echo '

      <div class="accordion-item rounded">
<div class="card text-black" style="text-shadow: 0 0 0; color: #333">
<h2 class="accordion-header" id="heading'.htmlspecialchars($value["id"]).'">
  <div class="card-header accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse'.htmlspecialchars($value["id"]).'" aria-expanded="false" aria-controls="collapse'.htmlspecialchars($value["id"]).'">
    '.htmlspecialchars($value["object_name"]).'
  </div>
  </h2>
  <div id="collapse'.htmlspecialchars($value["id"]).'" class="accordion-collapse collapse hide" aria-labelledby="heading'.htmlspecialchars($value["id"]).'" data-bs-parent="#accordionExample">
  <div class="card-body text-start">
  
<div class="card bg-light" style="width: 100%;">
  <div class="card-body">
    <h5 class="card-title">Данные</h5>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b1" class="form-label text-black">Anydesk (<a href="anydesk://'.htmlspecialchars($value["anydesk"]).'" class="card-link">Подключиться</a>)</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b1" class="form-control mb-2" value="'.htmlspecialchars($value["anydesk"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b2" class="form-label">VNC</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b2" class="form-control mb-2" value="'.htmlspecialchars($value["vnc"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b3" class="form-label">Тип сервера</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b3" class="form-control mb-2" value="'.htmlspecialchars($value["server_type"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'b4" class="form-label">SIP ALG</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'b4" class="form-control" value="'.htmlspecialchars($value["sip_alg"]).'" readonly>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c5" class="form-control" name="sip_server_serial" value="'.htmlspecialchars($value["sip_server_serial"]).'" >
          
          <script>
        function mySFunction'.htmlspecialchars($value["id"]).'() {
          var x = document.getElementById("disabledTextInput'.htmlspecialchars($value["id"]).'c4");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
        </script>
  </div>
</div>
<div class="card bg-light" style="width: 100%; margin-top:15px">
  <div class="card-body">
    <h4 class="card-title">Сервер</h4>

    <div class="row">
      <div class="col">
        <h5 class="card-title">SIP</h5>

        <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c1" class="form-label text-black">Local IP</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c1" class="form-control mb-2" value="'.htmlspecialchars($value["sip_server_local_ip"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c2" class="form-label">Static IP  (<a href="http://'.htmlspecialchars($value["sip_server_static_ip"]).':8080/" target="_blank" class="card-link">Открыть</a>)</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c2" class="form-control mb-2" value="'.htmlspecialchars($value["sip_server_static_ip"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c3" class="form-label">Login</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c3" class="form-control mb-2" value="'.htmlspecialchars($value["sip_server_login"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c4" class="form-label">Password</label>
    <input type="password" id="disabledTextInput'.htmlspecialchars($value["id"]).'c4" class="form-control mb-2" value="'.htmlspecialchars($value["sip_server_password"]).'" readonly>
    <input type="checkbox" onclick="mySFunction'.htmlspecialchars($value["id"]).'()"> Show Password
          <script>
        function mySFunction'.htmlspecialchars($value["id"]).'() {
          var x = document.getElementById("disabledTextInput'.htmlspecialchars($value["id"]).'c4");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
        </script><br>
    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'c5" class="form-label">Serial #</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'c5" class="form-control" value="'.htmlspecialchars($value["sip_server_serial"]).'" readonly>
    
      </div>
      <div class="col">
        <h5 class="card-title">PROX</h5>

        <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d1" class="form-label text-black">Local IP</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d1" class="form-control mb-2" value="'.htmlspecialchars($value["proxmox_local_ip"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d2" class="form-label">Static IP  (<a href="https://'.htmlspecialchars($value["proxmox_static_ip"]).':8006/" target="_blank" class="card-link">Открыть</a>)</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d2" class="form-control mb-2" value="'.htmlspecialchars($value["proxmox_static_ip"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d3" class="form-label">Login</label>
    <input type="text" id="disabledTextInput'.htmlspecialchars($value["id"]).'d3" class="form-control mb-2" value="'.htmlspecialchars($value["proxmox_login"]).'" readonly>

    <label for="disabledTextInput'.htmlspecialchars($value["id"]).'d4" class="form-label">Password</label>
    <input type="password" id="disabledTextInput'.htmlspecialchars($value["id"]).'d4" class="form-control" value="'.htmlspecialchars($value["proxmox_password"]).'" readonly>
    <input type="checkbox" onclick="myPFunction'.htmlspecialchars($value["id"]).'()"> Show Password
            </div>
        </div>
        
        <script>
        function myPFunction'.htmlspecialchars($value["id"]).'() {
          var x = document.getElementById("disabledTextInput'.htmlspecialchars($value["id"]).'d4");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
        </script>

    
    
  </div>
</div>
    <br>
    <a href="/objinfo.php?edit=object&id='.htmlspecialchars($value["object_id"]).'" class="btn btn-primary">Редактировать</a>
  </div>
  <div class="card-footer overflow-auto text-muted" style="text-align: left; max-height:200px">
  <code style="white-space: pre; text-align: left;">'.htmlspecialchars($value["second_info"]).'</code>
  </div>
</div>
</div>
			';
			$i++;
		} }
	  ?>
 
  </div>

<!-- end -->
  </main>
  <br>
  <footer class="mt-auto text-white-50">
    <p>© 2010-2022. «<a href="https://true-ip.ru/" class="text-white">Тру Ай Пи</a>», Все права защищены .</p>
  </footer>
</div>


    
  
</div>
</body>
</HTML>
