<?php
include_once "Database.php";
class Attendance{
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }
    function save($datas){
        $student = $this->getByCard($datas);
    }
    function get($datas){

    }
    function getByCard($datas){
        $qy=$this->conn->prepare("SELECT * FROM tblstudents WHERE StudentId=:cardno");
        $qy->execute(array("cardno"=>$datas['cardno']));
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }


    function addVisits($datas){
        $feed = 'ok';
        $studentInfo = $this->getByCard($datas);

        //entrance in by default
        $indate=date("Y-m-d H:i:s");
        $outdate="0000-00-00 00:00:00";
//change based on movement

        if(count($studentInfo)>0){
            $student = $studentInfo[0];
            $lastMoveInfo = $this->getLastVisit($studentInfo['StudentId']);

                if(gettype($lastMoveInfo)=='array'){
                        if($lastMoveInfo['movement']=='NEW'){
                            $qy=$this->conn->prepare("INSERT INTO attendance SET StudentId=:studentId,Full_Name=:names,Department=:dept,EntryDate=:entry,LeaveDate=:leave");
                            $qy->execute(['studentId'=>$student['StudentId'],'names'=>$student['FullName'],'dept'=>$student['department'],'entry'=>$indate,'leave'=>$outdate]);
                        }else{//check his movement
                            $additionalWhere="";
                            if($lastMoveInfo['movement']=='IN'){
                                //movement right coz last was in
                                $qy=$this->conn->prepare("UPDATE attendance SET EntryDate=:entry WHERE id=:id");
                                $qy->execute(array("entry"=>date("Y-m-d H:i:s"),"id"=>$lastMoveInfo['vst_id']));
                            }
                            if($lastMoveInfo['movement']=='OUT'){
                                //movement right coz last was out
                                $qy=$this->conn->prepare("UPDATE attendance SET LeavingDate=:leave WHERE id=:id");
                                $qy->execute(array("leave"=>"'".date("Y-m-d H:i:s")."'","id"=>$lastMoveInfo['id']));
                            }
                        }
                }
        }else{
            $feed='notexist';
        }
        return $feed;
    }
    function getLastVisit($studentId){
        $lastMove="IN";$stmt=[];
        $qry=$this->conn->prepare("SELECT * FROM attendance WHERE StudentId=:student ORDER BY id DESC LIMIT 1");
        $qry->execute(array("student"=>$studentId));
        if($qry->rowCount()>0){
            $stmt=$qry->fetchAll(PDO::FETCH_ASSOC)[0];
            if($stmt['EntryDate']!='0000-00-00 00:00:00' && $stmt['LeavingDate']!='0000-00-00 00:00:00'){//no move done all are completed in movement
                $stmt['movement']='NEW';
            }else{//check whether is out or in based on indate and outdate
                if($stmt['EntryDate']!='0000-00-00 00:00:00' && $stmt['LeavingDate']=='0000-00-00 00:00:00'){//last  move was in
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
}
?>