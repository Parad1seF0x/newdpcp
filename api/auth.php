<?php
namespace Phppot;
require '../vendor/autoload.php';

use ReallySimpleJWT\Token;
use ReallySimpleJWT\Parse;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Decode;


$hd = getallheaders();

$reqtoken = $hd['token'];

$secret = "donttrustyou";

$result = Token::validate($reqtoken, $secret);
//$exp = Token::validateExpiration($reqtoken);

if ($result) {
    //$jwt = new Jwt($reqtoken, $secret);
    //$parse = new Parse($jwt, new Decode());
    //$parsed = $parse->parse();
    //$data = $parsed->getPayload();
    $pdata = Token::getPayload($reqtoken, $secret);
    $uname = htmlspecialchars($pdata["username"]);
    $password = password_hash(htmlspecialchars($pdata["password"]), PASSWORD_DEFAULT);

    $link = mysqli_connect(
        '127.0.0.1',  /* Хост, к которому мы подключаемся */
        'root',       /* Имя пользователя */
        '',   /* Используемый пароль */
        'dpcp');     /* База данных для запросов по умолчанию */
        //header('mydata: '.$pdata["password"]."   ".$pdata["username"]);
    /* Посылаем запрос серверу */
if ($sqlresult = mysqli_query($link, 'SELECT * FROM tbl_member where username = "'.$uname.'"')) {

    if(mysqli_num_rows($sqlresult) > 0){
    /* Выборка результатов запроса */
    $i = 0;
    while( $row = mysqli_fetch_assoc($sqlresult) ){
        //echo($pdata["password"].' '.$row['password']);
        if (password_verify(htmlspecialchars($pdata["password"]), $row['password'])) {
            $payload = [
                'iat' => time(),
                'data' => $row,
                'exp' => time() + 10,
                'iss' => 'localhost'
            ];
            
            
            $token = Token::customPayload($payload, $secret);
            
            header('HTTP/1.1 404 Not Found');
            header('token: '.$token);
            //header('mydata: '.$user["password"]."   ".$password);
            exit;
    }  
    
    

}
/* Освобождаем используемую память */
mysqli_free_result($sqlresult);
/* Закрываем соединение */
mysqli_close($link);
    exit;
    
        
    } else {
        header('HTTP/1.1 404 Not Found');
        exit;
    }
}

}else {
    //$pdata = Token::getPayload($reqtoken, $secret);
    header('HTTP/1.1 404 Not Found');
    //header('mydata: '.$pdata["password"]."   ".$pdata["username"]);
        exit;
}
/*
$payload = [
    'iat' => time(),
    'uid' => 1,
    'exp' => time() + 10,
    'iss' => 'localhost'
];

$secret = 'Hello&MikeFooBar123';

$token = Token::customPayload($payload, $secret);

echo $token;

*/

?>