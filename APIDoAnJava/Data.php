<?php
include("dataConfig.php");

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
                        $this->dbReference->sendResponse($resultSet);
                    }else{
                        $this->dbReference->sendResponse('{"items":null}');
                    }
                }catch (Exception $ex){
                    $this->dbReference->sendResponse('{"items":null}');
                }
            }
            else{
                $this->dbReference->sendResponse('not found value');
            }
        }
    }
    function insertItemsJson(){
        $this->dbReference = new DataConfig();
        $this->dbConnect = $this->dbReference->connectDB();

        $json  = file_get_contents('php://input', true);
        $data = json_decode($json);
        if($json != null && $data->name != null){
            $sql1 = "insert into apidoanjava (Repair_Id, Customer_Name, Laptop_Name, Email, Status)
                    values ('$data->name', '$data->name1', '$data->name2', '$data->name3', '$data->name4')";
            if($this->dbConnect->query($sql1) === true){
                $this->dbReference->sendResponse(201, '{"message":'.$this->dbReference->getStatusCodeMeeage(201).'}');
            }
            else{
                $this->dbReference->sendResponse(400, $this->dbReference->getStatusCodeMeeage(400));
            }
        }
        else{
            $this->dbReference->sendResponse(400, $this->dbReference->getStatusCodeMeeage(300));
        }
    }

}