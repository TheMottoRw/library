<?php

include_once "../classes/Reservation.php";
$reservation = new Reservation();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {

            case 'register':
                echo json_encode($reservation->save($_POST));
                break;
            case 'taken':
                echo json_encode($reservation->taken($_POST));
                break;
            case 'delete':
                echo json_encode($reservation->delete($_POST));
                break;

        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'get':
                echo json_encode($reservation->get());
                break;
            case 'bystudent':
                echo json_encode($reservation->getByStudent($_GET));
                break;
            case 'expired':
                echo json_encode($reservation->expiredReservation());
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