<?php
include_once "Database.php";
class Attendance{
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }
    function get($datas){
        $qy=$this->conn->prepare("SELECT a.*,s.FullName,s.MobileNumber FROM attendance a INNER JOIN tblstudents s ON s.StudentId=a.StudentId");
        $qy->execute();
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
    function getByCard($datas){
        $qy=$this->conn->prepare("SELECT * FROM tblstudents WHERE card=:cardno");
        $qy->execute(array("cardno"=>$datas['cardno']));
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }


    function save($datas){
        $feed = ['status'=>'ok','movement'=>'','student'=>'','phone'=>'','message'=>"<div class='alert alert-success'>Attendance movement successfully recorded</div>"];
        $studentInfo = $this->getByCard($datas);
//        return $studentInfo;
        //entrance in by default
        $indate=date("Y-m-d H:i:s");
        $outdate=null;
//change based on movement

        if(count($studentInfo)>0){
            $student = $studentInfo[0];
            $feed['student'] = $student['FullName'];
            $feed['phone'] = $student['MobileNumber'];
            $lastMoveInfo = $this->getLastVisit($student['StudentId']);
//            return $lastMoveInfo;
                if(gettype($lastMoveInfo)=='array'){
                    $feed['movement'] = $lastMoveInfo['movement'];
                        if($lastMoveInfo['movement']=='NEW'){
                            $qy=$this->conn->prepare("INSERT INTO attendance SET StudentId=:studentId,Full_Name=:names,Department=:dept,EntryDate=:entry,LeavingDate=:leave");
                            $qy->execute(['studentId'=>$student['StudentId'],'names'=>$student['FullName'],'dept'=>$student['Department'],'entry'=>$indate,'leave'=>$outdate]);
                            $feed['stage']=1;
                            $feed['student_info'] = $lastMoveInfo;
                            $feed['error']=$qy->errorInfo();
                        }else{//check his movement
                            $additionalWhere="";
                            if($lastMoveInfo['movement']=='IN'){
                                //movement right coz last was in
                                $qy=$this->conn->prepare("UPDATE attendance SET EntryDate=:entry WHERE id=:id");
                                $qy->execute(array("entry"=>date("Y-m-d H:i:s"),"id"=>$lastMoveInfo['vst_id']));
                                $feed['stage']=2;
                            }
                            if($lastMoveInfo['movement']=='OUT'){
                                //movement right coz last was out
                                $qy=$this->conn->prepare("UPDATE attendance SET LeavingDate=:leave WHERE id=:id");
                                $qy->execute(array("leave"=>date('Y-m-d H:i:s'),"id"=>$lastMoveInfo['id']));
                                $feed['stage']=3;
                                $feed['error']=$qy->errorInfo();
                            }
                        }
                }
        }else{
            $feed['status'] ='notexist';
        }
        return $feed;
    }
    function getLastVisit($studentId){
//        return [$studentId];
        $lastMove="IN";$stmt=[];
        $qry=$this->conn->prepare("SELECT * FROM attendance WHERE StudentId=:student ORDER BY id DESC LIMIT 1");
        $qry->execute(array("student"=>$studentId));
        if($qry->rowCount()>0){
            $stmt=$qry->fetchAll(PDO::FETCH_ASSOC)[0];

            if($stmt['EntryDate']!=null && $stmt['LeavingDate']!=null){//no move done all are completed in movement
                $stmt['movement']='NEW';
            }else{//check whether is out or in based on indate and outdate
                if($stmt['EntryDate']!=null && $stmt['LeavingDate']==null){//last  move was in
                    $stmt['movement']='OUT';
                }else{
                    $stmt['movement']=$lastMove;
                }
            }
        }else{
            $stmt['movement']='NEW';
        }
        return $stmt;
    }
    function setLeft($datas){
        $qy=$this->conn->prepare("UPDATE attendance SET LeavingDate=:leave WHERE id=:id");
        $qy->execute(array("leave"=>date("Y-m-d H:i:s"),"id"=>$datas['id']));
        return ['status'=>'ok',"message"=>"<div class='alert alert-success'>Student has been set s/he left successful</div>"];
    }
}
?>