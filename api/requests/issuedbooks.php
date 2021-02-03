<?php

include_once "../classes/IssuedBook.php";
$issuedbook = new IssuedBook();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {

            case 'return':
                echo json_encode($issuedbook->returnIssuedBook($_POST));
                break;
            case 'stolen':
                echo json_encode($issuedbook->marksAsStolen($_POST));
                break;

            case 'update':
               echo json_encode($issuedbook->update($_POST));
                break;

        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'get':
                echo json_encode($issuedbook->getIssuedBook());
                break;
            case 'studentdashboard':
                echo json_encode($issuedbook->getIssuedBookByStudent($_GET));
                break;

            case 'loadbystudent':
                // header("Content-Type:application/json");
                echo json_encode($issuedbook->getIssuedBookByStudent($_GET));
                break;

            case 'missingbook':
                // header("Content-Type:application/json");
                echo json_encode($issuedbook->getIssuedBookByStatusAndRange($_GET));
                break;

            case 'byfilter':
//                 header("Content-Type:application/json");
                echo json_encode($issuedbook->getIssuedBookByStatusAndRange($_GET));
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