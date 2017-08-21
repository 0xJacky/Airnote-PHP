<?php
/**
 * Airnote HTTP Library
 */
if (!defined("IN_AIRNOTE")) {
    exit();
}

class http
{
    function info($type)
    {
        switch ($type) {
            case 200:
                $info = "200 OK";
                break;
            case 304:
                $info = "Not Modified";
                break;
            case 400:
                $info = "Bad Request";
                break;
            case 403:
                $info = "Forbidden";
                break;
            case 404:
                $info = "Not Found";
                break;
            case 405:
                $info = "Method Not Allowed";
                break;
            case 4051:
                $info = "Registered";
                break;
            case 4052:
                $info = "Name Conflict";
                break;
            case 4053:
                $info = "Mail Conflict";
                break;
            case 406:
                $info = "Account Not Found & Wrong Password";
                break;
            case 407:
                $info = "Account Banned";
                break;
            case 408:
                $info = "Request Time Out";
                break;
            case 409:
                $info = "Try Too Much";
                break;
            case 500:
                $info = "Internal Server Error";
                break;
            case 503:
                $info = "DataBase Error";
                break;
            default:
                $type = "501";
                $info = "Not Implemented";
                break;
        }
        header("HTTP/1.1 " . $type);
        header("Status: " . $info);
        $message = array(
            'status' => $type,
            'info' => $info
        );
        return $this->response($message);
    }

    function response($message)
    {
        header("Content-type: application/json; charset=UTF-8");
        echo json_encode($message);
        exit();
    }
}

?>
