<?php

function error_builder($code = 0, $comment = "Unknown error.")
{
    $error["status"] = "error#".$code;
    switch ($code) {
        case 0:
            $error["message"] = "Error unlisted.";
            break;
        
        case 100:
            $error["message"] = "Unknown method.";
            break;

        default:
            $error["message"] = "Error unlisted.";
            break;
    }
    $error["dev"] = $comment;
    return(json_encode($error));
}

if (!empty($_GET["method"])) {
    
    $method = htmlspecialchars($_GET["method"]);

    switch ($method) {
        case 'login':
            # code...
            break;
        
        default:
            print(error_builder(100,"Default switch"));
            break;
    }

}

?>