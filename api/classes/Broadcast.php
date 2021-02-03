<?php
//include_once "Database.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

class Broadcast
{
    private $conn;

    function __construct()
    {
//        $db = new Database();
//        $this->conn = $db->connection();
    }

    function getUser($email)
    {
        $user = null;
        $qy = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
        $qy->execute(['email' => $email]);
        if ($qy->rowCount() > 0) {
            $user = $qy->fetch(PDO::FETCH_ASSOC);
            $user['user_type'] = 'user';
        } else {
            $qyPolice = $this->conn->prepare("SELECT * FROM police WHERE email=:email");
            $qyPolice->execute(['email' => $email]);
            if ($qyPolice->rowCount() > 0) {
                $user = $qyPolice->fetch();
                $user['user_type'] = 'police';
            }
        }
        return $user;

    }

    function sendEmail($to, $toName, $subject, $message)
    {
        $resetCode = $this->generate();
        $expireDate = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "+ 1 days"));
//        $user = $this->getUser($to);

        $user = ['email' => 'mnzroger@gmail.com', 'name' => 'ASUA'];
        if ($user !== null) {
            $mail = new PHPMailer();
            $mail->IsSMTP();

            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Host = "smtp.gmail.com";
            $mail->Username = "hasua.mr@gmail.com";
            $mail->Password = "Roger2709";

            $mail->IsHTML(true);
            $mail->AddAddress($to, $toName);
            $mail->SetFrom("hasua.mr@gmail.com", "Manzi Roger SMTP");
            $mail->AddReplyTo("hasua.mr@gmail.com", "Manzi Roger SMTP");
//$mail->AddCC("cc-recipient-email", "cc-recipient-name");
            $mail->Subject = $subject;
            $content = $message;

            $mail->MsgHTML($content);

            if (!$mail->Send()) {
                $feed = "error";
                var_dump($mail);
            } else {
                $feed = "ok";
            }
        } else {
            $feed = "not_found";
        }
        return $feed;
    }

    function generate()
    {
        return random_int(900001, 999999);
    }
}

//$br = new Broadcast();
//$res = $br->sendEmail($_GET['email']);
//if($res=='ok'){
//    echo "<script>alert('Check your email to verify and reset your code');</script>";
////    echo "<script>window.location='http://localhost/RUT/library/reset_password.php?user=".$_POST['email']."';</script>";
//}
?>