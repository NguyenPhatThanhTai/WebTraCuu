<?php
include("dataConfig.php");
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
class Data
{
    private $dbReference;
    var $dbConnect;
    var $result;


    function __construct(){

    }

    function __destruct(){

    }

    function getDetail(){
        $this->dbReference = new dataConfig();
        $this->dbConnect = $this->dbReference->connectDB();
        if ($this->dbConnect == null){
            $this->dbReference->sendResponse(503, $this->dbReference->getStatusCodeMeeage(503));
        }
        else{
            if (isset($_GET['Id'])){
                try {
                    $sql = "select * from apidoanjava where Repair_Id ="."'".$_GET['Id']."'";
                    $this->result = $this->dbConnect->query($sql);
                    if ($this->result->num_rows) {
                        $resultSet = array();
                        while ($row = $this->result->fetch_assoc()) {
                            $resultSet[] = $row;
                        }
                        $this->dbReference->sendResponse(200,$resultSet);
                    }else{
                        $this->dbReference->sendResponse(204,'{"items":null}');
                    }
                }catch (Exception $ex){
                    $this->dbReference->sendResponse(204, '{"items":null}');
                }
            }
            else{
                $this->dbReference->sendResponse(204,'not found value');
            }
        }
    }

    function updateData(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            try {
                if ($this->decode($data->name2, $data->name3, $data->name4)){
                    if ($data->name1 == "Ok"){
                        $TinhTrang = "Hoàn thành";
                    }
                    else{
                        $TinhTrang = "Chưa hoàn thành";
                    }
                    $sql1 = "UPDATE `apidoanjava` SET `Status`='".$TinhTrang."' WHERE Repair_Id = '".$data->name."'";
                    if($this->dbConnect->query($sql1) === true){
                        $this->dbReference->sendResponseNotEncode(200, "Ok");
                    }
                    else{
                        $this->dbReference->sendResponseNotEncode(400, "Not Ok");
                    }
                }
                else{
                    $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
                }
            }catch (Exception $ex){
                $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
            }
        }
        else{
            $this->dbReference->sendResponseNotEncode(400, "Not Ok");
        }
    }

    function deleteData(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            try {
                if ($this->decode($data->name1, $data->name2, $data->name3)){
                    $sql1 = "Delete from apidoanjava WHERE Repair_Id = '".$data->name."'";
                    if($this->dbConnect->query($sql1) === true){
                        $this->dbReference->sendResponseNotEncode(200, "Ok");
                    }
                    else{
                        $this->dbReference->sendResponseNotEncode(400, "Not Ok");
                    }
                }
                else{
                    $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
                }
            }catch (Exception $ex){
                $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
            }
        }
        else{
            $this->dbReference->sendResponseNotEncode(400, "Not Ok");
        }
    }

    function updateCustomer(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            try {
                if ($this->decode($data->name4, $data->name5, $data->name6)){
                    $sql1 = "UPDATE `apidoanjava` SET `Customer_Name`='".$data->name1."', `Laptop_Name` = '".$data->name2."', `Email` = '".$data->name3."'
                    WHERE Repair_Id = '".$data->name."'";
                    if($this->dbConnect->query($sql1) === true){
                        $this->dbReference->sendResponseNotEncode(200, "Ok");
                    }
                    else{
                        $this->dbReference->sendResponseNotEncode(400, "Not Ok");
                    }
                }
                else{
                    $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
                }
            }catch (Exception $ex){
                $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
            }
        }
        else{
            $this->dbReference->sendResponseNotEncode(400, "Not Ok");
        }
    }



    function insertItemsJson(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            try {
                if ($this->decode($data->name5, $data->name6, $data->name7)){
                    $sql1 = "insert into apidoanjava (Repair_Id, Customer_Name, Laptop_Name, Email, Status)
                    values ('$data->name', '$data->name1', '$data->name2', '$data->name3', '$data->name4')";
                    if($this->dbConnect->query($sql1) === true){
                        $this->dbReference->sendResponseNotEncode(200, "Ok");
                    }
                    else{
                        $this->dbReference->sendResponseNotEncode(204, "Not Ok");
                    }
                }
                else{
                    $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
                }
            }catch (Exception $ex){
                $this->dbReference->sendResponseNotEncode(401, "Invalid Token, Token maybe experience");
            }
        }
        else{
            $this->dbReference->sendResponseNotEncode(400, "Not Ok");
        }
    }

    function encodeToken(){
        $this->dbReference = new DataConfig();
        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            $this->dbReference->sendResponse(200, $data->name);
        }
        else{
            $this->dbReference->sendResponse(400, "Not Ok");
        }
    }

    function decodeToken(){
        $this->dbReference = new DataConfig();
        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            if ($this->decode($data->name, $data->name1, $data->name2)){
                $this->dbReference->sendResponseNotEncode(200, "Valid");
            }
            else{
                $this->dbReference->sendResponseNotEncode(400, "Invalid");
            }
        }
        else{
            $this->dbReference->sendResponseNotEncode(400, "Not Ok");
        }
    }

    function decode($token, $key, $typ){
        $valid = false;
        try {
            $decodeJwt = JWT::decode($token, $key, array($typ));
            $json = json_encode($decodeJwt);
            $json = json_decode($json, true);

            if ($json['data'] == "Logined"){
                $valid = true;
            }
        }catch (Exception $ex){
            $valid = false;
        }
        return $valid;
    }

}