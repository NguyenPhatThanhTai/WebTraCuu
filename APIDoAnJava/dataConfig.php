<?php
require 'vendor/autoload.php';
include 'randomKey.php';
use Firebase\JWT\JWT;
class dataConfig{
    var $dbConnect;

    function __construct(){

    }

    function __destruct() {
//        $this->dbConnect->close();
    }

    function connectDB(){
        $this->dbConnect = new mysqli("localhost:3366", "root", "", "apidoanjava");

        if($this->dbConnect->connect_errno){
            return null;
        }else{
            return $this->dbConnect;
        }
    }

    function getStatusCodeMeeage($status){
        $codes = Array(
            100 => "Continue",
            101 => "Switching Protocols",
            200 => "OK",
            201 => "Created",
            202 => "Accepted",
            203 => "Non-Authoritative Information",
            204 => "No Content",
            205 => "Reset Content",
            206 => "Partial Content",
            300 => "Multiple Choices",
            301 => "Moved Permanently",
            302 => "Found",
            303 => "See Other",
            304 => "Not Modified",
            305 => "Use Proxy",
            306 => "Unused",
            307 => "Temporary Redirect",
            400 => "Bad Request",
            401 => "Unauthorized",
            402 => "Payment Required",
            403 => "Forbidden",
            404 => "Not Found",
            405 => "Method Not Allowed",
            406 => "Not Acceptable",
            407 => "Proxy Authentication Required",
            408 => "Request Timeout",
            409 => "Conflict",
            410 => "Gone",
            411 => "Length Required",
            412 => "Precondition Failed",
            413 => "Request Entity Too Large",
            414 => "Request-URI Too Long",
            415 => "Unsupported Media Type",
            416 => "Requested Range Not Satisfiable",
            417 => "Expectation Failed",
            500 => "Internal Server Error",
            501 => "Not Implemented",
            502 => "Bad Gateway",
            503 => "Service Unavailable",
            504 => "Gateway Timeout",
            505 => "HTTP Version Not Supported"
        );

        return (isset($codes[$status])) ? $codes[$status] : ”;
    }
    function sendResponse($Header = "", $body = "", $content_type = "text/html")
    {
        $secret_key = get_rand_alphanumeric(10);
        $issuer_claim = "000webhostapp.com"; // this can be the servername
        $audience_claim = "ThanhTai";
        $issuedat_claim = time(); // issued at
        $expire_claim = $issuedat_claim + 60; // expire time in seconds
        $token = array(
            "key" => $secret_key,
            "status" => $Header,
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => $body
        );

        $status_header = "HTTP/1.1 $Header";
        header($status_header);
        header("Content-type: " . $content_type);

        $encodeJwt = JWT::encode($token, $secret_key);
        $decodeJwt = JWT::decode($encodeJwt, $secret_key, array('HS256'));

        $response = array(
            "token" => $encodeJwt,
            "decode" => $decodeJwt
        );

        $encode = json_encode($response);
        echo $encode;
    }

    function sendResponseNotEncode($Header = "", $body = "", $content_type = "text/html")
    {
        $response = array(
            "Status" => $Header,
            "Check" => $body
        );

        $encode = json_encode($response);
        echo $encode;
    }
}
