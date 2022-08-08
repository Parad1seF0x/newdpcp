<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
namespace Phppot;

class Member
{   
    

    //Create an instance; passing `true` enables exceptions
    

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        

    //Load Composer's autoloader
        require 'vendor/autoload.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';
        $this->ds = new DataSource();
        
    }

    public function getMember($username)
    {
        $query = 'SELECT * FROM tbl_member where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $memberRecord = $this->ds->select($query, $paramType, $paramValue);
        return $memberRecord;
    }
    public function allMembers()
    {
        $query = 'SELECT * FROM tbl_member';
        
        $memberRecord = $this->ds->select($query);
        return $memberRecord;
    }
    public function createMember($username, $password, $phone, $company, $object)
    {
        $confirm = md5($username.$password);
        $query = 'INSERT INTO tbl_member(username, password, phone, company, object_name, confirm, create_at) VALUES ("'.$username.'", "'.$password.'", "'.$phone.'", "'.$company.'", "'.$object.'", "'.$confirm.'", NOW())';
       
        $memberRecord = $this->ds->insert($query);
        return $memberRecord;
    }

    public function sendMessage($username, $password){
        $user = $this->getMember($username);
        $code = $user[0]["confirm"];
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug  = 0;                        //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;                                  //Enable SMTP authentication
            $mail->Username   = 'paradisefoxstudio@gmail.com';                     //SMTP username
            $mail->Password   = 'Fjc51db9S3122@@';                               //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            //$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true);
            //Recipients
            $mail->setFrom('paradisefoxstudio@gmail.com', 'No Reply');
            $mail->addAddress($username);     //Add a recipient
        
            //Content
            #$mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Подтверждение почты';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            $confirmurl = 'http://' . $_SERVER['SERVER_NAME'] . '/confirm.php?code=' . $code . '&email=' . $username;
            require 'mail.php';
            $content = generateMail($confirmurl, $username, $password);
            $mail->MsgHTML($content); 
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function activateMember($username){
        $user = $this->getMember($username);
        
        $query = 'UPDATE tbl_member SET confirm = "0" WHERE username = "'.$username.'"';
       
        $memberRecord = $this->ds->execute($query);
    }

    public function banMember($username){
        $user = $this->getMember($username);
        
        $query = 'UPDATE tbl_member SET banned = 1 WHERE username = "'.$username.'"';
       
        $memberRecord = $this->ds->execute($query);
    }

    public function unbanMember($username){
        $user = $this->getMember($username);
        
        $query = 'UPDATE tbl_member SET banned = 0 WHERE username = "'.$username.'"';
       
        $memberRecord = $this->ds->execute($query);
    }

    public function loginMember()
    {
        $memberRecord = $this->getMember(htmlspecialchars($_POST["username"]));
        $loginPassword = 0;
        if (! empty($memberRecord)) {
            if (! empty(htmlspecialchars($_POST["password"]))) {
                $password = htmlspecialchars($_POST["password"]);
            }
            $hashedPassword = $memberRecord[0]["password"];
            $loginPassword = 0;
            if (password_verify($password, $hashedPassword)) {
                $loginPassword = 1;
            }
        } else {
            $loginPassword = 0;
        }
        if ($loginPassword == 1) {
            // login sucess so store the member's username in
            // the session
            
            session_start();
            $_SESSION["username"] = $memberRecord[0]["username"];
            $_SESSION["name"] = $memberRecord[0]["username"];
            session_write_close();
            
            if ($memberRecord[0]["confirm"] == "0") {
                $url = "home.php";
            } else {
                $url = "confirm.php";
            }

            if ($_POST['tel'] != '') {
                $url = "objinfo.php?tel_num=".$_POST['tel'];
            }
            
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Неверный логин или пароль.";
            return $loginStatus;
        }
    }
    public function regMember() 
    {
        $memberRecord = $this->getMember(htmlspecialchars($_POST["username"]));
        $regStatus = 0;
        if (empty($memberRecord)) {
            if(htmlspecialchars($_POST["password"]) == htmlspecialchars($_POST["repassword"])){
                if (! empty(htmlspecialchars($_POST["password"]))) {
                    $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
                    if (! empty(htmlspecialchars($_POST["phone"])) && ! empty(htmlspecialchars($_POST["company"])) && ! empty(htmlspecialchars($_POST["object"]))) {
                        $newmember = $this->createMember(htmlspecialchars($_POST["username"]), $password, htmlspecialchars($_POST["phone"]), htmlspecialchars($_POST["company"]), htmlspecialchars($_POST["object"]));
                        $regStatus = 1;
                    } else {
                        $loginStatus = "Проверьте поля телефона, компании и объекта.";
                        $regStatus = 0;
                    }
                } else {
                    $regStatus = 0;
                }
            } else {
                $loginStatus = "Пароли не совпадают.";
                $regStatus = 0;
            }
            

            
        } else {
            $loginStatus = "Пользователь с такой почтой уже есть.";
            $regStatus = 0;
        }
        if ($regStatus == 1) {
            // login sucess so store the member's username in
            // the session
            session_start();
            $_SESSION["username"] = htmlspecialchars($_POST["username"]);
            $_SESSION["name"] = htmlspecialchars($_POST["username"]);
            session_write_close();
            //$this->sendMessage(htmlspecialchars($_POST["username"]), htmlspecialchars($_POST["password"]));
            $url = "home.php";
            header("Location: $url");
        } else if ($regStatus == 0) {
            
            return $loginStatus;
        }
    }
}