<?php

include_once "../classes/Helper.php";
$helper = new Helper();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['cate']) {
            case 'login':
                echo json_encode($helper->login($_POST));
                break;

        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'studentdashboard':
                echo json_encode($helper->getIssuedBookByStudent($_GET));
                break;

            case 'loadbystudent':
                // header("Content-Type:application/json");
                echo json_encode($helper->getIssuedBookByStudent($_GET));
                break;

            case 'missingbook':
                // header("Content-Type:application/json");
                echo json_encode($helper->getIssuedBookByStatusAndRange($_GET));
                break;

            case 'byfilter':
//                 header("Content-Type:application/json");
                echo json_encode($helper->getIssuedBookByStatusAndRange($_GET));
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