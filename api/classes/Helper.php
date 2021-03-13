<?php
include_once "Database.php";
include_once "Reservation.php";
class Helper{
    function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getInstance();
        $this->reservation = new Reservation();
    }
    function adminExistance(){
        $qy = $this->conn->prepare("SELECT * FROM admin");
        $qy->execute();
        if($qy->rowCount()==0){
            $qy = $this->conn->prepare("INSERT INTO admin SET FullName=:names,AdminEmail=:email,UserName=:username,Password=:pwd");
            $qy->execute(['names'=>'Raban','username'=>'admin','email'=>'mire@gmail.com','pwd'=>base64_encode(12345)]);
            if($qy->rowCount() ==0){
                echo json_encode($qy->errorInfo());
                exit;
            }
        }
    }
    public function login($datas){
//        return $datas;
        $this->adminExistance();
        $this->reservation->cancelExpiredReservation();
        $response = ['status'=>'ok','data'=>[],'message'=>"<div class='alert alert-success'>Successful logged in</div>"];
        $qy = $this->conn->prepare("SELECT * FROM admin WHERE (UserName=:phone OR AdminEmail=:phone) AND Password=:pwd");
        $qy->execute(['phone'=>$datas['username'],'pwd'=>md5($datas['password'])]);
        if($qy->rowCount()==1){//success
            $response['user_info'] = $qy->fetchAll(PDO::FETCH_ASSOC)[0];
            $response['user_info']['category'] = "admin";
        }else{//check resident
            $qyResident = $this->conn->prepare("SELECT * FROM tblstudents WHERE (EmailId=:phone OR MobileNumber=:phone) AND Password=:pwd");
            $qyResident->execute(['phone'=>$datas['username'],'pwd'=>md5($datas['password'])]);
            if($qyResident->rowCount()==1){//success
                $response['user_info'] = $qyResident->fetchAll(PDO::FETCH_ASSOC)[0];
                $response['user_info']['category'] = 'student';
            }else{
                $response['status'] = 'fail';
                $response['message'] = "<div class='alert alert-danger'>Wrong phone number or password ".json_encode([$qyResident->rowCount()])."</div>";
            }
        }
        return $response;
    }
}
?>