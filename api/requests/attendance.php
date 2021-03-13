<?php

include_once "../classes/Attendance.php";
$attendance = new Attendance();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['cate']) {
            case 'attendance':
                echo json_encode($attendance->save($_POST));
                break;
            case 'leave':
                echo json_encode($attendance->setLeft($_POST));
                break;

        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {
            case 'load':
                echo json_encode($attendance->get($_GET));
                break;
          
            default:
                echo json_encode(['error'=>"value of parameter category not known"]);
                break;
        }
        break;
    default:
        echo json_encode(['error'=>$_SERVER['REQUEST_METHOD'] . "Request method not allowed"]);
        break;
}

?>