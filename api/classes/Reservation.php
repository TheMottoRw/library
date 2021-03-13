<?php
include_once "Database.php";

class Reservation
{
    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();
        $this->reservation_time = "30";//in minute
    }

    function save($datas)
    {
        $feed = ['status' => 'ok', "message" => "<div class='alert alert-success'>Book successfully reserved for an hour</div>"];
        $qy = $this->conn->prepare("SELECT * FROM tblreservedbooks WHERE BookId=:bookid OR BookId IN (SELECT BookId FROM tblissuedbooks WHERE  tblissuedbooks.BookId=:bookid)");
        $qy->execute(['bookid' => $datas['bookid']]);
        if ($qy->rowCount() == 0) {
            $qy = $this->conn->prepare("INSERT INTO tblreservedbooks SET BookId=:bookid,StudentId=:studentid");
            $qy->execute(['bookid' => $datas['bookid'], 'studentid' => $datas['studentid']]);
        } else {
            $feed = ['status' => 'ok', "message" => "<div class='alert alert-danger'>Book not available for reservation</div>"];
        }
        return $feed;
    }
    function get(){
        $qy=$this->conn->prepare("SELECT tblreservedbooks.*,tblstudents.FullName,tblstudents.Department,tblbooks.BookName,tblbooks.ISBNNumber,tblbooks.identifier,department.Dep_Name,tblcategory.CategoryName,tblauthors.AuthorName FROM tblreservedbooks INNER JOIN tblbooks ON tblbooks.id=tblreservedbooks.BookId LEFT JOIN department ON tblbooks.department=department.id LEFT JOIN tblcategory ON tblcategory.id=tblbooks.CatId LEFT JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId INNER JOIN tblstudents ON tblstudents.StudentId=tblreservedbooks.StudentId");
        $qy->execute();
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
    function getByStudent($datas){
        $qy=$this->conn->prepare("SELECT tblreservedbooks.*,tblbooks.BookName,tblbooks.ISBNNumber,tblbooks.identifier,department.Dep_Name,tblcategory.CategoryName,tblauthors.AuthorName FROM tblreservedbooks INNER JOIN tblbooks ON tblbooks.id=tblreservedbooks.BookId LEFT JOIN department ON tblbooks.department=department.id LEFT JOIN tblcategory ON tblcategory.id=tblbooks.CatId LEFT JOIN tblauthors ON tblauthors.id=tblbooks.AuthorId WHERE tblreservedbooks.StudentId=:studentid");
        $qy->execute(['studentid'=>$datas['studentid']]);
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }

    function delete($datas){
        $feed = ['status' => 'ok', "message" => "<div class='alert alert-success'>Your Book reservation cancelled successfully</div>"];
        $qy=$this->conn->prepare("DELETE FROM tblreservedbooks where id=:id AND StudentId=:student");
        $qy->execute(['id'=>$datas['id'],'student'=>$datas['studentid']]);

        if($qy->rowCount()==0){
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Failed to cancel your reservation</div>"];
        }
        return $feed;
    }
    function taken($datas){
        $feed = ['status' => 'ok', "message" => "<div class='alert alert-success'>Reserved book taken successful</div>"];
        $qy0=$this->conn->prepare("SELECT * FROM tblreservedbooks where id=:id AND StudentId=:student");
        $qy0->execute(['id'=>$datas['id'],'student'=>$datas['studentid']]);

        if($qy0->rowCount()!=0){
            $reservationInfo = $qy0->fetch(PDO::FETCH_ASSOC);
            //issue book
            $qy1=$this->conn->prepare("INSERT INTO tblissuedbookdetails SET StudentId=:student AND BookId=:bookid");
            $qy1->execute(['id'=>$datas['id'],'student'=>$datas['studentid'],'bookid'=>$reservationInfo['BookId']]);
            if($qy1->rowCount()>1){
                //delete from reservation
                $qy2=$this->conn->prepare("DELETE FROM tblreservedbooks where id=:id AND StudentId=:student");
                $qy2->execute(['id'=>$datas['id'],'student'=>$datas['studentid']]);

            }
        }else {
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Can't find reservation</div>"];
        }
        return $feed;
    }
    function expiredReservation(){
        $qy = $this->conn->prepare("SELECT *,DATE_ADD(RegDate,INTERVAL :expire_time MINUTE) AS expire_at FROM tblreservedbooks WHERE DATE_ADD(RegDate,INTERVAL :expire_time MINUTE)<CURRENT_TIMESTAMP");
        $qy->execute(['expire_time'=>$this->reservation_time]);
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cancelExpiredReservation(){
        $qy = $this->conn->prepare("DELETE FROM tblreservedbooks WHERE DATE_ADD(RegDate,INTERVAL :expire_time MINUTE)<CURRENT_TIMESTAMP AND id!=0");
        $qy->execute(['expire_time'=>$this->reservation_time]);
    }

}

?>