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
                        $this->dbReference->sendResponse("200",$resultSet);
                    }else{
                        $this->dbReference->sendResponse("400",'{"items":null}');
                    }
                }catch (Exception $ex){
                    $this->dbReference->sendResponse("400", '{"items":null}');
                }
            }
            else{
                $this->dbReference->sendResponse("400",'not found value');
            }
        }
    }

    function updateData(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        if(isset($_GET['Id'])&& isset($_GET['Status'])){
            $Id = $_GET['Id'];
            $Status = $_GET['Status'];
            if ($Status == "Ok"){
                $TinhTrang = "Hoàn thành";
            }
            else{
                $TinhTrang = "Chưa hoàn thành";
            }
                $sql1 = "UPDATE `apidoanjava` SET `Status`='".$TinhTrang."' WHERE Repair_Id = '".$Id."'";
                if($this->dbConnect->query($sql1) === true){
                    $this->dbReference->sendResponse(200, "Ok");
                }
            else{
                $this->dbReference->sendResponse(400, "Not Ok");
            }
        }
        else{
            $this->dbReference->sendResponse(400, "Not Ok");
        }
    }

    function insertItemsJson(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
//            $sqlDelete = "Delete from apidoanjava";
//            $this->dbConnect->query($sqlDelete);

            $sql1 = "insert into apidoanjava (Repair_Id, Customer_Name, Laptop_Name, Email, Status)
                    values ('$data->name', '$data->name1', '$data->name2', '$data->name3', '$data->name4')";
            if($this->dbConnect->query($sql1) === true){
                $this->dbReference->sendResponse(200, "Ok");
            }
            else{
                $this->dbReference->sendResponse(400, "Not Ok");
            }
        }
        else{
            $this->dbReference->sendResponse(400, "Not Ok");
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
                $this->dbReference->sendResponseNotEncode(200, "Invalid");
            }
        }
        else{
            $this->dbReference->sendResponseNotEncode(400, "Not Ok");
        }
    }

    function decode($token, $key, $typ){
        $valid = false;
        $decodeJwt = JWT::decode($token, $key, array($typ));
        $json = json_encode($decodeJwt);
        $json = json_decode($json, true);

        if ($json['data'] == "Logined"){
            $valid = true;
        }
        return $valid;
    }

}