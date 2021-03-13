<?php
include_once "../classes/Broadcast.php";
$broadcast = new Broadcast();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {
            case 'login':
                header("Content-Type:application/json");
                echo json_encode($broadcast->login($_POST));
                break;
            case 'broadcast':
                echo $broadcast->broadcastEmail($_POST);
                break;

        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'broadcast':
                echo $broadcast->sendEmail("mnzroger@gmail.com", "Manzi Roger", "For the information of updating system", "Hello Roger we are glad to welcome you to our team");
                break;
            default:
                echo json_encode(['error' => "value of parameter category not known"]);
                break;
        }
        break;
    default:
        echo json_encode(['error' => $_SERVER['REQUEST_METHOD'] . "Request method not allowed"]);
        break;
}

?>