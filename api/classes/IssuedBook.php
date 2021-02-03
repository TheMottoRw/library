<?php
include_once "Database.php";
include_once "Broadcast.php";

class IssuedBook
{
    public $conn;
    public $fine;
    public $broadcast;

    /*
     * Return status 0:Pending,1:Returned,2:Missing
     * Book should be returned in 3 days
     * Remind student on D-Day of return and after Each daily delay
     * Penalty of 150 per day on delay
     * Delay of submission disable access library for 2 weeks
     */
    function __construct()
    {
        $db = new Database();
        $this->broadcast = new Broadcast();
        $this->conn = $db->connection();
        $this->fine = 100;
    }

    function studentDashboard($datas)
    {
        $student = $datas['stdid'];
        $qy = $this->conn->prepare("SELECT * FROM tblbooks b INNER JOIN tblissuedbookdetails ib ON ib.BookId=b.id WHERE ib.RetrunStatus=:status AND ib.StudentID=:student");// 0 Pending,1 Returned,2 Missing
        $qy->execute(['status' => 0, 'student' => $student]);
        $countNotReturned = $qy->rowCount();

        $qy->execute(['status' => 1, 'student' => $student]);
        $countReturned = $qy->rowCount();
        return ['notreturned' => $countNotReturned, 'returned' => $countReturned];
    }

    function getIssuedBook()
    {
        $qy = $this->conn->prepare("SELECT tblstudents.FullName,tblbooks.id as book_id,tblbooks.BookPrice,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.RetrunStatus,tblissuedbookdetails.fine,tblissuedbookdetails.id as rid,DATE_ADD(LEFT(tblissuedbookdetails.IssuesDate,10), INTERVAL 3 DAY) AS submission_date from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId order by tblissuedbookdetails.id desc");// 0 Pending,1 Returned,2 Missing
        $qy->execute();
        $data = $qy->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $k => $obj) {
            if ($obj['RetrunStatus'] == 0) {
                $fineInfo = $this->calculateFine($obj['submission_date']);
                $data[$k]['estimated_fine'] = $fineInfo['fine'];
                $data[$k]['delay'] = $fineInfo['days_delay'];
            } else {
                $data[$k]['estimated_fine'] = 0;
                $data[$k]['delay'] = 0;
            }
        }
        return $data;
    }

    function returnIssuedBook($datas)
    {
        $id = $datas['id'];
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Book returned successfully</div>"];
        $qy = $this->conn->prepare("SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.id as BookId,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.RetrunStatus,tblissuedbookdetails.fine,tblissuedbookdetails.id as rid,DATE_ADD(LEFT(tblissuedbookdetails.IssuesDate,10), INTERVAL 3 DAY) AS submission_date from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId WHERE tblissuedbookdetails.id=:id AND tblissuedbookdetails.RetrunStatus in (0,2)");// 0 Pending,1 Returned,2 Missing
        $qy->execute(['id' => $id]);
        $issuedBook = $qy->fetchAll(PDO::FETCH_ASSOC);
        if (count($issuedBook) > 0) {
            $fineInfo = $this->calculateFine($issuedBook[0]['submission_date']);
            $qy = $this->conn->prepare("UPDATE tblissuedbookdetails SET fine=:fine,RetrunStatus=1 WHERE id=:id");// 0 Pending,1 Returned,2 Missing
            $qy->execute(['fine' => $fineInfo['fine'], 'id' => $id]);
            //change book status
            $qy0 = $this->conn->prepare("UPDATE tblbooks SET status=:status WHERE id=:id");// 0 Pending,1 Returned,2 Missing
            $qy0->execute(['status' => 'available', 'id' => $id]);

            if (!$qy) {
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update book submitted</div>"];
            }
        }
        return $feed;
    }

    function marksAsStolen($datas)
    {
        $id = $datas['id'];
        $bookid = $datas['bookid'];
        $fine = $datas['fine'];
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Book marked as missing successfully</div>"];
        $qy = $this->conn->prepare("SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.RetrunStatus,tblissuedbookdetails.fine,tblissuedbookdetails.id as rid,DATE_ADD(LEFT(tblissuedbookdetails.IssuesDate,10), INTERVAL 3 DAY) AS submission_date from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId WHERE tblissuedbookdetails.id=:id AND tblissuedbookdetails.RetrunStatus = 0");// 0 Pending,1 Returned,2 Missing
        $qy->execute(['id' => $id]);
        $issuedBook = $qy->fetchAll(PDO::FETCH_ASSOC);
        if (count($issuedBook) > 0) {
            $qy0 = $this->conn->prepare("UPDATE tblissuedbookdetails SET fine=:fine,RetrunStatus=2 WHERE id=:id");// 0 Pending,1 Returned,2 Missing
            $qy0->execute(['fine' => $fine, 'id' => $id]);
            if ($qy0->rowCount()>0) {
                $qy1 = $this->conn->prepare("UPDATE tblbooks SET status=:status WHERE id=:id");
                $qy1->execute(['id' => $bookid, 'status' => 'missing']);
            } else
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to remove book</div>"];
        }else
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Select issued book not available</div>"];
        return $feed;
    }

    function getIssuedBookByStudent($datas)
    {
        $student = $datas['stdid'];
        $qy = $this->conn->prepare("SELECT * FROM tblbooks b INNER JOIN tblissuedbookdetails ib ON ib.BookId=b.id WHERE ib.StudentID=:student");// 0 Pending,1 Returned,2 Missing
        $qy->execute(['student' => $student]);
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }

    function getIssuedBookByStatusAndRange($datas)
    {
        $status = $datas['status'];
        $additionalWhere = "";
        if (isset($datas['status'])) {
            $additionalWhere = " WHERE ib.RetrunStatus=$status";
        }
        if (isset($datas['start']) && isset($datas['end'])) {
            $additionalWhere .= ($additionalWhere == "" ? " WHERE " : " AND ") . " ib.IssuesDate BETWEEN '" . $datas['start'] . "' AND '" . $datas['end'] . "'";
        }
        $qy = $this->conn->prepare("SELECT * FROM tblbooks b INNER JOIN tblissuedbookdetails ib ON ib.BookId=b.id " . $additionalWhere);// 0 Pending,1 Returned,2 Missing
        $qy->execute(['status' => $status]);
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }

    function fineBookIssuedSubmissionDelay()
    {
        $qy = $this->conn->prepare("SELECT ib.*,b.BookName,b.ISBNNumber,s.FullName,s.Email,DATE_ADD(LEFT(ib.IssuesDate,10), INTERVAL 3 DAY) AS submission_date FROM tblissuedbookdetails ib INNER JOIN tblbook b ON ib.BookId=b.id INNER JOIN tblstudent s ON s.id=ib.StudentID WHERE ib.RetrunStatus IS 0 AND DATE_ADD(LEFT(ib.IssuesDate,10), INTERVAL 3 DAY)>=CURRENT_DATE");// Delay of submission
        $qy->execute();
        $delayedData = $qy->fetchAll(PDO::FETCH_ASSOC);
        foreach ($delayedData as $k => $obj) {
            $this->prepareEmail($obj);
        }
        return;
    }

    function prepareEmail($obj)
    {
        $finesInfo = $this->calculateFine($obj['submission_date']);
        $subject = "Reminding " . $obj['BookName'] . "(" . $obj['ISBNNumber'] . ") book submission";
        $message = "Dear <b>" . $obj['FullName'] . "</b><br> We are reminding you that you have delayed submission of the book" . $obj['BookName'] . " with <b>ISBN Number " . $obj['ISBNNumber'] . "</b><br>";
        $message .= " You delayed for <b>" . $finesInfo['days_delay'] . "</b> wtih total fine of <b>" . $finesInfo['fine'] . "</b>";
        $message .= "<br> Kind Regards!";

        $this->broadcast->sendEmail($obj['Email'], $obj['FullName'], $subject, $message);
    }

    function calculateFine($submissionDate)
    {
        $daysDelayed = $this->dateDifference($submissionDate, date("Y-m-d"));
        $totalFine = $daysDelayed * $this->fine;
        return ['days_delay' => $daysDelayed, 'fine' => $totalFine];
    }

    function dateDifference($start_date, $end_date)
    {
        $date1 = strtotime($start_date);
        $date2 = strtotime($end_date);


//        $date1 = strtotime(date("Y-m-d"));
//        $date2 = strtotime("2020-10-31");

// Formulate the Difference between two dates
        $diff = abs($date2 - $date1);


// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
        $years = floor($diff / (365 * 60 * 60 * 24));


// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
        $months = ceil(($diff / (30 * 60 * 60 * 24)));
        $days = ceil(($diff / (60 * 60 * 24)));
        return $days;
    }

}

?>