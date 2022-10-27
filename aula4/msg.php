<?php
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "configs/utils.php";
    require_once "configs/methods.php";

    require_once "model/Msg.php";
    require_once "model/User.php";


    if(isMetodo("POST")){
        if(parametrosValidos($_POST, ["text", "userId"])){
            
            $text = $_POST["text"];
            $userId = $_POST["userId"];

            if(User::exists($userId)){
                $result = Msg::create($text, $userId);
                if($result){
                    response(201, ["status"=> "OK",]);
                }
                else{
                    response(500, ["status"=> "BAD"]);
                }
            }
            else{
                response(400, ["status"=> "BAD"]);
            }
        }
        else{
            response(400, ["status"=> "BAD"]);
        }
    }

    if(isMetodo("GET")){
        $result = MSg::getAll();
        response(200, $result);
    }

?>