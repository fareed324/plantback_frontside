
<?php
session_start();
include_once 'function.php';

ini_set('display_errors', 0);
header('Content-type: text/html; charset=utf-8');


if ($_REQUEST['action'] == 'gettopoffers') {
	
    $data = top_advertise_offers_list($conn);
	//$data = $user->top_advertise_offers_list();

	$response["status"] = true;
	$response["data"] = $data;
	/* echo "<pre>";
    print_r($response);
	echo "</pre>";
	die; */
    echo json_encode($response);	
}

if ($_REQUEST['action'] == 'getadvertdetails') {
    
	//$data = $user->view_advert_id($_POST["advertid"]);
	$data = view_advert_id($_POST["advertid"],$conn);

	$response["status"] = true;
	$response["data"] = $data;
    echo json_encode($response);
	
}


if ($_REQUEST['action'] == 'rateadvert') {
    
	$userid = 0;
	
	//$data = $user->add_vote($userid, $_POST["advertid"], $_POST["adscore"]);
	
	$userid  = $_SESSION['user_id'];
		
	$data = add_vote($userid, $_POST["advertid"], $_POST["adscore"],$conn);

	$response["status"] = true;
	$response["data"] = $data;
	
    echo json_encode($response);
	
}




if ($_REQUEST['action'] == 'getadvertlatestproducts') {
    
	//$data = $user->view_prod($_POST["advertid"], $_POST["limit"]);
	$data = view_prod($_POST["advertid"], $_POST["limit"],$conn);

	$response["status"] = true;
	$response["data"] = $data;
	
    echo json_encode($response);
	
}


if ($_REQUEST['action'] == 'getadvertbycategory') {
    
	$pageno = isset($_REQUEST['pageno']) ? $_REQUEST['pageno'] : 0;
	$pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : 12;
	

    $dataval = find_advert($_POST["catid"],$pageno,$pagesize,$conn);
  
	// $data = $user->find_advert($_POST["catid"], $pageno, $pagesize,$conn);
	
	 $response["status"] = true;

	 $response["data"] = $dataval;
	 	
    echo json_encode($response);
	
}

/* if($_REQUEST['action'] == 'addtomyoffer')
{
	$data = $user->addMyOffer($_POST["userid"], $_POST["advertid"]);
	$userId  = $_SESSION['user_id'];
	

	
	$data = addMyOffer($_POST["userid"], $_POST["advertid"],$conn);
	$response["status"] = true;
	$response["data"] = $data;
	
    echo json_encode($response);
	
} */

/* if($_REQUEST['action'] == 'removefrommyoffer')
{
	$data = $user->removeMyOffer($_POST["userid"], $_POST["advertid"]);
	
	$data = removeMyOffer($_POST["userid"], $_POST["advertid"],$conn);

	$response["status"] = true;
	$response["data"] = $data;
	
    echo json_encode($response);
	
} */

/* if($_REQUEST['action'] == 'getmyoffers')
{
	//$data = $user->myOffers($_POST["userid"], $conn);
			
	$data = myOffers($_POST["userid"], $conn);

	$response["status"] = true;
	$response["data"] = $data;
	
    echo json_encode($response);
	
} */

if($_REQUEST['action'] == 'getsearchhistory')
{
	//$data = $user->my_historylist($_POST["userid"]);
	
	$data = my_historylist($_POST["userid"],$conn);

	$response["status"] = true;
	$response["data"] = $data;

    echo json_encode($response);
	
}


if($_REQUEST['action'] == 'advertvisit')
{
	$data = $user->advert_visit($_POST["userid"], $_POST["advertid"]);

	$response["status"] = true;
	$response["data"] = $data;
	
    echo json_encode($response);
	
}



?>