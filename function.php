<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
/***********************

 DATABASE CONNECTION 
 
 *********************/

$conn = mysqli_connect("localhost","pbuser","@@estk-9A","db_plantback");
// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



/**************************

 DATABASE CONNECTION End
 
 ***************************/


/**************************

LOGIN CHECK FROM DATABASE

 
 ***************************/

if (isset($_POST['login_user'])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {

		$username  = trim($_POST['username']);
		$password   = trim($_POST['password']);
		$md5Password = md5($password);
		$sql = "SELECT * FROM users WHERE username = '" . $username . "' and password = '" . $md5Password . "'";
		$timestamp = time();
	    $current_time = date ("d-m-Y H:i:s", $timestamp);

		$rs = mysqli_query($conn, $sql);
		$getNumRows = mysqli_num_rows($rs);
		if ($getNumRows == 1) {
			$getUserRow = mysqli_fetch_assoc($rs);
			//$userlastligin=$getUserRow['lastlogin'];		
			$_SESSION['username'] = $getUserRow['username'];
			$_SESSION['name'] = $getUserRow['name'];
			$_SESSION['surname'] = $getUserRow['surname'];
			$_SESSION['cash'] = $getUserRow['cash'];
			$_SESSION['paid'] = $getUserRow['paid'];
			$_SESSION['referrer'] = $getUserRow['referrer'];			
			$_SESSION['user_id'] = $getUserRow['id'];
			$_SESSION['affcash'] = $getUserRow['affcash'];
			$_SESSION['successlogin'] = 'Login Successfully.';
			
			$useridlast=$_SESSION['user_id'];		

			 $updatelastlogin = "update users set lastlogin = '$current_time' where id = '$useridlast'";

			$reslastlogin = mysqli_query($conn, $updatelastlogin);
			
			//mysqli_query($conn, "UPDATE users SET lastlogin = '$current_time' WHERE `id`='$useridlast'");
			
						
			$url='/';			
			if(strpos(base64_decode($_GET['redirect']),'company.php')){
				$url='/my-offers.php';
				
			}else if(strpos(base64_decode($_GET['redirectbuy']),'product.php')){
				$url=base64_decode($_GET['redirectbuy']);
				
			}else if(strpos(base64_decode($_GET['rediectremenmber']),'company.php')){
				$url=base64_decode($_GET['rediectremenmber']);
				
			}else if(strpos(base64_decode($_GET['productsignup']),'product.php')){
				$url=base64_decode($_GET['productsignup']);
				
			}else if(strpos(base64_decode($_GET['companysignup']),'company.php')){
				$url=base64_decode($_GET['companysignup']);
				
			}
			header("Location: ". $url);
			//header('location: /');
		} else {

			$_SESSION['unsuccesslogin'] = 'Your detail not match from database';
		}

	}
}

/*******************************

LOGIN CHECK FROM DATABASE END
 
 *******************************/


/*******************************

Register USER IN DATABASE
 
 *******************************/

if (isset($_POST['register_user'])) {
	if (!empty($_POST['useremailtxt'])) {
		if (!empty($_POST['useremailtxt']) && !empty($_POST['userPasswordtxt'])) {

			$fname  = trim($_POST['usernametxt']);
			$suname   = trim($_POST['usersurnametxt']);
			$useremail  = trim($_POST['useremailtxt']);
			$password   = trim($_POST['userPasswordtxt']);
			$refid =  $_SESSION['refid'];
			$password = md5($password);
			$chkbox = $_POST['agree'];
			$timestamp = time();
	        $regicurrent_time = date ("d-m-Y H:i:s", $timestamp);  //19-12-2019 06:59:01  17-12-2019 2019-12-19 07:00:56
			
		

			if ($chkbox == 'agree') {

				$sql_reg_ueser = "SELECT id from users WHERE username = '$useremail'";

				$rs = mysqli_query($conn, $sql_reg_ueser);
				$getNumRows = mysqli_num_rows($rs);

				if ($getNumRows == 0) {

					$result = "INSERT INTO users(name,surname,username,password,address,address2,town,county,postcode,tel,mobile,email,gender,title,dobday,dobmonth,dobyear,payment,validated,hadsignup,terms,cash,paid,timestamp,lastlogin,status,newsletter,referrer,affiliateid,affcash,coreg,bankname,accno,sortcode,paypal,chequename,chk,wherereg,device_reg,device_login,connected_time,country_reference,oauth_uid,oauth_provider,sessionid) VALUES ('$fname','$suname','$useremail','$password','','','','','','','','$useremail','','','','','','','','','','','','$regicurrent_time','','','','$refid','','','','','','','','','','','','','','','','','')";

					$result = mysqli_query($conn, $result);
					if ($result) {


						$response['error'] = 0;
						$_SESSION['Registeredsuccess'] = "Registered success.";
						$response['msg'] = "Registered success";
						header('Refresh: 1; URL=/');					
						////// ////EMAIL SENT FUNCTION/////

						$adminemail = 1;
						$sent_email = paidcash_email($useremail, $tokenid, $adminemail, $conn);
					} else {

						$response['error'] = 1;
						$response['msg'] = "Registered failed";
					}
				} else {

					$response['error'] = 2;
					$response['msg'] = "Duplicate data found";
					$_SESSION['Registeredunsuccess'] = "Duplicate data found.";
				}
			} else {

				$_SESSION['Registeredunsuccess'] = "Term and conditions Required.";
			}
		}
	}
}

/*******************************

Register USER IN DATABASE End
 
 *******************************/





/*******************************

FORGET PASS CHECK FROM DATABASE

 
 *******************************/

if (isset($_POST['forget_pass'])) {
	if (!empty($_POST['email'])) {

		$email  = trim($_POST['email']);


		$sql = "select * from users where username = '$email'";

		$rs = mysqli_query($conn, $sql);
		$getNumRows = mysqli_num_rows($rs);
		if ($getNumRows == 1) {
			$getUserRow = mysqli_fetch_assoc($rs);
			$usernameemail = $getUserRow['username'];
			$userid = $getUserRow['id'];
			$tokenid = base64_encode(serialize($userid));
			$adminemail = 2;
			$sent_email = paidcash_email($usernameemail, $tokenid, $adminemail, $conn);
			$_SESSION['successr'] = "Reset password sent link on your email";
		} else {
			$_SESSION['failurer'] = "Email Is Not Exists";
		}
		
	}
}


/************************************

FORGET PASS CHECK FROM DATABASE END

 
 *************************************/


/********************************************

Passwordreset PASS CHECK FROM DATABASE
 
 ********************************************/


if (isset($_POST['passwordreset'])) {
	if (!empty($_POST['new_password'])) {
		$newpassword  = trim($_POST['new_password']);
		$confirmpassword  = trim($_POST['con_password']);
		$uid  = trim($_POST['uid']);
		$uids = unserialize(base64_decode($uid));
		$tokenid = base64_encode(serialize($uid));
		$sql = "select * from users where id = '$uids'";
		$rs = mysqli_query($conn, $sql);
		$getUserRow = mysqli_fetch_assoc($rs);

		$usernameemail = $getUserRow['username'];

		$getNumRows = mysqli_num_rows($rs);

		if ($getNumRows == 1) {
			if (isset($_POST['passwordreset'])) {

				if ($newpassword == $confirmpassword) {
					$md5 = md5($newpassword);
					$updatepassword = "update users set password = '$md5' where id = '$uids'";

					$res = mysqli_query($conn, $updatepassword);
					if ($res) { }


					/********************************************

							   EMAIL SENT FUNCTION 
					 ********************************************/
					$adminemail = 3;
					$sent_email = paidcash_email($usernameemail, $tokenid, $adminemail, $conn);
					$_SESSION['successr'] = "Your password Changed successfully";
				} else {

					$_SESSION['failurer']  = "New password and Confirm Password Should be Same !!";
				}
			}
		} else {
			echo "not record";
		}
		$success = true;
	}
	return $success;
}


/********************************************

Passwordreset PASS CHECK FROM DATABASE END
 
 ********************************************/


/************************

EMAIL SENT FUNCTION
 
 ************************/

function paidcash_email($usernameemail, $tokenid, $adminmailid, $conn)
{
	$sqlmail = select("admin_email", "id='$adminmailid'", $conn);
	$row           = mysqli_fetch_object($sqlmail);
	$subject       = stripslashes($row->adminmail_subject);
	$message       = stripslashes($row->adminmail_message);
	$head          = stripslashes($row->adminmail_header);
	$footer        = stripslashes($row->adminmail_footer);
	$fromdb        = stripslashes($row->adminmail_from);
	$fromdb   = "info@paidcash.co.uk";
	$reset  =     "Click this <a href='https://www.paidcash.co.uk/confirmlink.php?token=$tokenid'>Link</a> to reset your password.";
	$message = str_replace("[password_reset_link]", $reset, $message);
	$headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
	$headers   .=  "From: $fromdb\n";
	$body .= $head;
	$body .= $message;
	$body .= $footer;
	$success = mail($usernameemail, $subject, $body, $headers);
}

/************************

EMAIL SENT FUNCTION END
 
 ************************/


/*****************************

GET SELECT DATA FROM DATABASE
 
 *******************************/


function select($tblname, $where = '', $conn)
{

	if ($where != '') {
		$se = "select * from $tblname where $where";
		$sel = mysqli_query($conn, $se);
	} else {
		$se = "select * from $tblname";
		$sel = mysqli_query($conn, $se);
	}
	return $sel;
}


/***********************************

GET SELECT DATA FROM DATABASE END
 
 ************************************/

/***********************************

GET advert DATA FROM DATABASE

 
 ************************************/


function find_advert($subcat_id, $pageno, $pagesize, $conn)
{

	$start = $pageno * $pagesize;

	$paging = $pagesize > 0 ? " limit $start, $pagesize " : "";


	$sqlcount = "SELECT count(*) as count FROM advert where (subcat1= $subcat_id or subcat2=$subcat_id or subcat3=$subcat_id) and status=1  ";

	$sql = mysqli_query($conn, "SELECT * FROM advert where (subcat1= $subcat_id or subcat2=$subcat_id or subcat3=$subcat_id) and status=1  order by id  ASC " . $paging);


	$userid = 0;

	if (isset($_SESSION["login"]["list"]["id"]) && $_SESSION["login"]["list"]["id"] > 0) {
		$userid = $_SESSION["login"]["list"]["id"];
		$myoffersql = " SELECT advertid  FROM myoffers WHERE  userid = '" . $userid . "' ";
		$myofferresult = mysqli_query($conn, $myoffersql);

		while ($myoffer = mysqli_fetch_assoc($conn, $myofferresult)) {
			$myoffers[] = intval($myoffer["advertid"]);
		}
	}

	$categorycount = mysqli_query($conn, $sqlcount);
	$categorycountresult = mysqli_fetch_assoc($categorycount);

	while ($categoryObj = mysqli_fetch_assoc($sql)) {

		$categoryObj["isMyOffer"] = false;

		if (isset($myoffers) && is_array($myoffers) && count($myoffers) > 0) {
			if (in_array($categoryObj["id"], $myoffers)) {
				$categoryObj["isMyOffer"] = true;
			}
		}



		$id = $categoryObj['id'];
		$bannerimage = $categoryObj['bannerimage'];
		$buttonimage = $categoryObj['buttonimage'];
		$urllink = $categoryObj['urllink'];
		$companyname = $categoryObj['companyname'];
		$smalldesc =  htmlspecialchars($categoryObj['smalldesc']);
		$howearn = $categoryObj['howearn'];
		$money = $categoryObj['money'];
		$largedesc = $categoryObj['largedesc'];
		$subcat1 = $categoryObj['subcat1'];
		$subcat2 = $categoryObj['subcat2'];
		$subcat3 = $categoryObj['subcat3'];
		$clicks = $categoryObj['clicks'];
		$approved = $categoryObj['approved'];
		$earnings = $categoryObj['earnings'];
		$timestamp = $categoryObj['timestamp'];
		$network = $categoryObj['network'];
		$networks_id = $categoryObj['networks_id'];
		$status = $categoryObj['status'];
		$tickets = $categoryObj['tickets'];
		$product = $categoryObj['product'];
		$brand = $categoryObj['brand'];
		$brand_power = $categoryObj['brand_power'];
		$pay_out = $categoryObj['pay_out'];
		$payout_level = $categoryObj['payout_level'];
		$payout_given = $categoryObj['payout_given'];
		$country_reference = $categoryObj['country_reference'];
		$payout_type = $categoryObj['payout_type'];
		$productfeed = $categoryObj['productfeed'];
		$feed_link = $categoryObj['feed_link'];
		$last_update = $categoryObj['last_update'];
		$lge = $categoryObj['lge'];
		$minisite_status = $categoryObj['minisite_status'];
		$isMyOffer = $categoryObj['isMyOffer'];




		$products['id'] = $id;
		$products['bannerimage'] = $bannerimage;
		$products['buttonimage'] = $buttonimage;
		$products['companyname'] = $companyname;
		$products['smalldesc'] = $smalldesc;

		$category1[] = $products;
	}

	if ($category1) {
		$category['list'] = $category1;
		$category['error'] = 0;
		$category['msg'] = 'All advert List';
		$category["totalpages"] = ceil($categorycountresult["count"] / $pagesize);
		$category["pageno"] = $pageno;
		$category["pagesize"] = $pagesize;
	} else {
		$category['error'] = 1;
		$category['msg'] = 'No advert List';
	}

	return $category;
}

/***********************************

GET advert DATA FROM DATABASE END

 
 ************************************/


/***********************************

GET categorylist FROM DATABASE
 
 ************************************/

function get_category_menu_data($conn)
{



	$categorylist = mysqli_query($conn, "SELECT mc.id, mc.name as maincatname, ca.name as catname,ca.id as catid FROM maincat mc, cats ca WHERE  mc.id=ca.maincatid AND mc.status=1 AND ca.active=1 ORDER BY mc.name asc,ca.name");



	while ($categorydetail = mysqli_fetch_array($categorylist)) {


		$categorydetail1['id'] = $categorydetail['id'];


		$categorydetail1['name'] = $categorydetail['maincatname'];
		$categorydetail1['catname'] = $categorydetail['catname'];
		$categorydetail1['catid'] = $categorydetail['catid'];
		$category1[] = $categorydetail1;
	}

	if ($category1) {
		$category['list'] = $category1;
		$category['error'] = 0;
		$category['msg'] = 'All Category List';
	} else {
		$category['error'] = 1;
		$category['msg'] = 'NO Category List';
	}



	return $category;
}


/***********************************

GET categorylist FROM DATABASE END

 
 ************************************/


/************************

 home top offers list
 
 ****************** ******/

function top_advertise_offers_list($conn)
{


	$sql = mysqli_query($conn, "SELECT ad.*, av.companyname, av.bannerimage, av.buttonimage, av.smalldesc FROM advertise ad left join advert av on ad.advertids = av.id ORDER BY orderno ASC");

	$advertiselist = array();


	$userid = 0;

	if (isset($_SESSION["login"]["list"]["id"]) && $_SESSION["login"]["list"]["id"] > 0) {
		$userid = $_SESSION["login"]["list"]["id"];
		$myoffersql = " SELECT advertid  FROM myoffers WHERE  userid = '" . $userid . "' ";
		$myofferresult = mysql_query($myoffersql);

		while ($myoffer = mysql_fetch_assoc($myofferresult)) {
			$myoffers[] = intval($myoffer["advertid"]);
		}
	}


	while ($advertisedetail = mysqli_fetch_array($sql)) {


		$advertisedetail["isMyOffer"] = false;

		if (isset($myoffers) && is_array($myoffers) && count($myoffers) > 0) {
			if (in_array($advertisedetail["advertids"], $myoffers)) {
				$advertisedetail["isMyOffer"] = true;
			}
		}


		$advertiselist[] = $advertisedetail;
	}

/* echo "<pre>";
print_r($advertiselist);
echo "</pre>" ; */

	if (count($advertiselist)  > 0) {
		$response['list'] = $advertiselist;
		$response['error'] = 0;
		$response['msg'] = 'All Category List';
	} else {
		$response['error'] = 1;
		$response['msg'] = 'NO Category List';
	}

	return $response;
}

/**************************

 home top offers list End
 
 ****************** *********/




/**************************

 Search Marchant Function
 
 ****************** *********/

function search_merchant_banner($conn)
{


	$search_terms = $_POST['search_term'];

	$searchKeys = explode(" ", $search_terms);
	for ($i = 0; $i < count($searchKeys); $i++) {
		$key .= $searchKeys[$i] . "%";
	}
	$keysearch = rtrim($key, "%");


	$query = mysqli_query($conn, "SELECT a.id, a.companyname,a.howearn, a.buttonimage FROM (SELECT CONCAT(Product,',',BRAND) nm, id, companyname, howearn,  buttonimage, brand_power, product, brand, country_reference, STATUS, payout_level FROM advert) a WHERE ( a.companyname LIKE '$keysearch' OR (a.nm = '$keysearch' OR a.nm LIKE '$keysearch,%' OR a.nm LIKE '%, $keysearch,%' OR a.nm LIKE '%, $keysearch')) AND a.status='1'  ORDER BY TRIM(a.companyname)  limit 0,10");


	while ($res = mysqli_fetch_assoc($query)) {

		$prod['id'] = $res['id'];
		$prod['companyname'] = html_entity_decode($res['companyname']);
		$prod['howearn'] = htmlspecialchars($res['howearn']);
		$prod['buttonimage'] = $res['buttonimage'];

		$productslist1[] = $prod;
	}




	if ($productslist1) {
		$responses['list'] = $productslist1;
		$responses['error'] = 0;
		$responses['message'] = "All mercant list";
	} else {
		$responses['error'] = 1;
		$responses['message'] = "no mercant list fount";
	}

	return $responses;
}

/******************************

 Search Marchant Function End
 
 ****************** ************/




/******************************

 Search product Function list
 
 ****************** ************/

function search_products($search_term, $search_category, $pagesize, $pageno, $orderby, $order, $stockval, $freedeliveryval, $filter, $merchantid, $conn)
{

	if ($freedeliveryval  == "true") {
		$freedelivery = '1';
	} else {

		$freedelivery = '';
	}


	if ($stockval  == "true") {

		$stock = '1';
	} else {

		$stock = '';
	}



	$recoffset = $pageno * $pagesize;
	$categories = array();
	$topCat = "";


	$orderby = "p.fee";

	$searchImage = "";

	if (trim($search_term) != "" || $merchantid > 0) {
		$c = "";

		if (trim($search_term) != "") {
			$c = "SELECT COUNT(cat),cat FROM products WHERE prod_name LIKE '%$search_term%' ";

			if ($merchantid > 0) {
				$c .= " And advertId = '" . $merchantid . "' ";
			}

			$c .= " GROUP BY cat  ORDER BY COUNT(cat) DESC ";
		} else if ($merchantid > 0) {
			$c = "SELECT COUNT(cat),cat FROM products WHERE advertId = '$merchantid' GROUP BY cat  ORDER BY COUNT(cat) DESC";
		}

		if ($c != "") {

			$cr = mysqli_query($conn, $c);
			$catCounter = 0;



			while ($crr = mysqli_fetch_array($cr)) {


				$category["name"] = $crr["cat"];

				$category["count"] = $crr["COUNT(cat)"];

				if ($search_category != "" && $search_category != "All") {
					$category["selected"] = $search_category == $crr["cat"] ? true : false;
				} else if ($catCounter == 0 && $search_category !== "All") {
					$category["selected"] = true;
				} else {
					$category["selected"] = false;
				}

				$categories[] = $category;
				$catCounter = $catCounter +  1;
			}
		}
	}
	$output["categories"] = $categories;

	$where = "";
	$merchantwhere = "";
	$whereCount = "";


	$query = "SELECT p.*, a.pay_out, a.buttonimage, a.smalldesc,a.companyname FROM products p left join advert a on p.advertId = a.id AND a.network='4' ";

	$queryCount = "SELECT count(*) count FROM products p left join advert a on p.advertId = a.id AND a.network='4' ";


	if ($search_term != "") {
		$where = "  WHERE p.prod_name LIKE '%$search_term%' ";

		$whereCount = " WHERE p.prod_name LIKE '%$search_term%' ";
	}

	if ($search_category == "") {
		$search_category = str_replace($special_char,  "%", $categories[0]["name"]);
	}

	if ($search_category != "" && $search_category != "All") {
		if ($where == "") {
			$where .= "  Where ";

			$whereCount .= " Where ";
		} else {
			$where .= "  And ";

			$whereCount .= " And ";
		}

		$where .= "  p.cat like '$search_category' ";

		$whereCount .= "  p.cat like '$search_category' ";
	}



	if ($stock != "") {

		if ($where == "") {
			$where .= "  Where ";

			$whereCount .= " Where ";
		} else {
			$where .= "  And ";
			$whereCount .= " And ";
		}

		if ($stock == 1) {
			$where .= "  p.in_stock > 0 ";

			$whereCount .= " p.in_stock > 0 ";
		} else {
			$where .= "  p.in_stock <= 0 ";

			$whereCount .= " p.in_stock <= 0 ";
		}
	}

	if ($freedelivery != "") {


		if ($where == "") {
			$where .= "  Where ";
			$whereCount .= " Where ";
		} else {
			$where .= "  And ";
			$whereCount .= " And ";
		}

		if ($freedelivery == 1) {

			$where .= "  p.delivery = 0 ";
			$whereCount .= " p.delivery = 0 ";
		}
	}



	if ($filter != "all") {

		if ($where == "") {
			$where .= "  Where ";
			$whereCount .= " Where ";
		} else {
			$where .= "  And ";
			$whereCount .= " And ";
		}

		$filter = explode("-", $filter);

		if ($filter[1] == "") {
			$where .= "  p.fee > " . $filter[0];
			$whereCount .= " p.fee > " . $filter[0];
		} else {
			$where .= "  (p.fee >= " . $filter[0] . " and p.fee <= " . $filter[1] . ") ";
			$whereCount .= " (p.fee >= " . $filter[0] . " and p.fee <= " . $filter[1] . ") ";
		}
	}


	if ($merchantid != "") {
		if ($where == "") {
			$where .= "  Where ";
			$whereCount .= " Where ";
		} else {
			$where .= "  And ";
			$whereCount .= " And ";
		}



		$where .= "  p.advertId = " . $merchantid;
		$whereCount .= " p.advertId = " . $merchantid;
	}

	$query .= $where;
	$queryCount .= $whereCount;



	$query .= " order by $orderby $order LIMIT $recoffset, $pagesize ";


	$qr = mysqli_query($conn, $query);
	$qnum = mysqli_num_rows($qr);

	$qrcount = mysqli_query($conn, $queryCount);
	$qrcountt = mysqli_fetch_array($qrcount);


	if ($qnum > 0) {
		while ($qrow = mysqli_fetch_assoc($qr)) {
			if ($qrow["aw_img"] != "" && $searchImage == "") {

				$prodimg["id"] = $qrow["id"];
				$prodimg["name"] = $qrow["name"];
				$prodimg["aw_img"] = $qrow["aw_img"];
				$prodimg["aw_deeplink"] = $qrow["aw_deeplink"];
				$prodimg["count"] = $qrow["count"];
				$prodimg["prod_name"] = utf8_decode($qrow["prod_name"]);
				$prodimg["details"] = htmlspecialchars($qrow["details"]);
				$prodimg["cat"] = $qrow["cat"];
				$prodimg["fee"] = $qrow["fee"];
				$prodimg["aw_id"] = $qrow["aw_id"];
				$prodimg["mer_id"] = $qrow["mer_id"];
				$prodimg["advertId"] = $qrow["advertId"];
				$prodimg["in_stock"] = $qrow["in_stock"];
				$prodimg["delivery"] = $qrow["delivery"];
				$prodimg["valid_to"] = $qrow["valid_to"];
				$prodimg["rrp"] = $qrow["rrp"];
				$prodimg["last_update"] = $qrow["last_update"];
				$prodimg["ean_no"] = $qrow["ean_no"];
				$prodimg["isbn_no"] = $qrow["isbn_no"];
				$prodimg["stock_qty"] = $qrow["stock_qty"];
				$prodimg["viewed"] = $qrow["viewed"];
				$prodimg["searched"] = $qrow["searched"];
				$prodimg["pay_out"] = $qrow["pay_out"];
				$prodimg["buttonimage"] = $qrow["buttonimage"];
				$prodimg["smalldesc"] = htmlspecialchars($qrow["smalldesc"]);

				$prodimg["companyname"] = html_entity_decode($qrow["companyname"]);

				$result[] = $prodimg;
			}
		}
	}

	$firstprodid = $result[0]['id'];
	$current_userid = 0;

	if (isset($_SESSION['username'])) {
		$current_userid = $_SESSION['user_id'];

		//} 

		$timestamp = time();
		$mysqltime = date("d-m-Y H:i:s", $timestamp);
		$ipaddress = $_SERVER['REMOTE_ADDR'];

		//if($current_userid == $_SESSION['user_id'])
		//{         
		if ($pageno == 0) {
			$sqlSearches = "INSERT INTO advertlog (searchkey, user_id, ipaddress, search_type, search_time,total_result,first_product)         
 			VALUES ('" . $search_term . "','" . $current_userid . "','" . $ipaddress . "','website','" . $mysqltime . "','" . $qrcountt["count"] . "','" . $firstprodid . "')";

			mysqli_query($conn, $sqlSearches);
		}
	}





	$output["result"] = $result;
	$output["resultcount"] = $qrcountt[0];
	$output["totalpages"] = ceil($qrcountt[0] / $pagesize);



	return $output;
}

/**********************************

 Search product Function list  End
 
 ****************** *****************/



/**************************************

 Search view product Function list
 
 ****************** *********************/
function viewproduct_byadvertid($advertid, $prodid, $conn)
{

	$categorylist = mysqli_query($conn, "SELECT * FROM `advert`,`products` WHERE advert.id=$advertid and advert.id=products.advertId and products.id=$prodid");

	while ($categorydetail = mysqli_fetch_assoc($categorylist)) {

		$categorydetails['id'] = $categorydetail['id'];
		$categorydetails['bannerimage'] = $categorydetail['bannerimage'];
		$categorydetails['buttonimage'] = $categorydetail['buttonimage'];
		$categorydetails['urllink'] = $categorydetail['urllink'];
		$categorydetails['companyname'] = $categorydetail['companyname'];
		$categorydetails['smalldesc'] = htmlspecialchars($categorydetail['smalldesc']);
		$categorydetails['howearn'] = htmlspecialchars($categorydetail['howearn']);
		$categorydetails['money'] = $categorydetail['money'];
		$categorydetails['largedesc'] = htmlspecialchars($categorydetail['largedesc']);
		$categorydetails['subcat1'] = $categorydetail['subcat1'];
		$categorydetails['subcat2'] = $categorydetail['subcat2'];
		$categorydetails['subcat3'] = $categorydetail['subcat3'];
		$categorydetails['clicks'] = $categorydetail['clicks'];
		$categorydetails['earnings'] = $categorydetail['earnings'];
		$categorydetails['timestamp'] = $categorydetail['timestamp'];
		$categorydetails['network'] = $categorydetail['network'];
		$categorydetails['networks_id'] = $categorydetail['networks_id'];
		$categorydetails['status'] = $categorydetail['status'];
		$categorydetails['tickets'] = $categorydetail['tickets'];
		$categorydetails['product'] = htmlspecialchars($categorydetail['product']);
		$categorydetails['brand'] = htmlspecialchars($categorydetail['brand']);
		$categorydetails['brand_power'] = $categorydetail['brand_power'];
		$categorydetails['pay_out'] = $categorydetail['pay_out'];
		$categorydetails['payout_level'] = $categorydetail['payout_level'];
		$categorydetails['payout_given'] = $categorydetail['payout_given'];
		$categorydetails['country_reference'] = $categorydetail['country_reference'];
		$categorydetails['payout_type'] = $categorydetail['payout_type'];
		$categorydetails['productfeed'] = $categorydetail['productfeed'];
		$categorydetails['feed_link'] = $categorydetail['feed_link'];
		$categorydetails['last_update'] = $categorydetail['last_update'];
		$categorydetails['lge'] = $categorydetail['lge'];
		$categorydetails['minisite_status'] = $categorydetail['minisite_status'];
		$categorydetails['name'] = $categorydetail['name'];
		$categorydetails['aw_img'] = $categorydetail['aw_img'];
		$categorydetails['aw_deeplink'] = $categorydetail['aw_deeplink'];
		$categorydetails['count'] = $categorydetail['count'];
		$categorydetails['prod_name'] = html_entity_decode($categorydetail['prod_name']);
		$categorydetails['details'] = html_entity_decode($categorydetail['details']);
		$categorydetails['cat'] = $categorydetail['cat'];
		$categorydetails['fee'] = $categorydetail['fee'];
		$categorydetails['aw_id'] = $categorydetail['aw_id'];
		$categorydetails['mer_id'] = $categorydetail['mer_id'];
		$categorydetails['advertId'] = $categorydetail['advertId'];
		$categorydetails['in_stock'] = $categorydetail['in_stock'];
		$categorydetails['delivery'] = $categorydetail['delivery'];
		$categorydetails['valid_to'] = $categorydetail['valid_to'];
		$categorydetails['rrp'] = $categorydetail['rrp'];
		$categorydetails['ean_no'] = $categorydetail['ean_no'];
		$categorydetails['isbn_no'] = $categorydetail['isbn_no'];
		$categorydetails['stock_qty'] = $categorydetail['stock_qty'];
		$categorydetails['viewed'] = $categorydetail['viewed'];
		$categorydetails['searched'] = $categorydetail['searched'];

		$category1[] = $categorydetails;
	}

	if ($category1) {
		$category['list'] = $category1;
		$category['error'] = 0;
		$category['msg'] = 'All advert List by ID';
	} else {
		$category['error'] = 1;
		$category['msg'] = 'No advert List';
	}

	return $category;
}


/**************************************

 Search view product Function list  End
 
 ****************** *********************/



/**************************************

 get_more_products_from_seller
 
 ****************** *********************/

function get_more_products_from_seller($advertid, $productid, $conn)
{


	$relatedProductsQuery = "SELECT aw_deeplink, id, aw_img, prod_name, details, cat, fee, in_stock, delivery, advertId FROM `products` where advertid = " . $advertid . " and id <> " . $productid . "  order by id desc limit 0,3 ";

	$response = array();
	$productList = array();

	$products = mysqli_query($conn, $relatedProductsQuery);

	while ($sellerproduct = mysqli_fetch_assoc($products)) {

		$sellerproductmore['aw_deeplink'] = $sellerproduct['aw_deeplink'];
		$sellerproductmore['id'] = $sellerproduct['id'];
		$sellerproductmore['aw_img'] = $sellerproduct['aw_img'];
		$sellerproductmore['prod_name'] = html_entity_decode($sellerproduct['prod_name']);
		$sellerproductmore['details'] = $sellerproduct['details'];
		$sellerproductmore['cat'] = $sellerproduct['cat'];
		$sellerproductmore['fee'] = $sellerproduct['fee'];
		$sellerproductmore['in_stock'] = $sellerproduct['in_stock'];
		$sellerproductmore['delivery'] = $sellerproduct['delivery'];
		$sellerproductmore['advertId'] = $sellerproduct['advertId'];

		$productList[] = $sellerproductmore;
	}

	if ($productList) {
		$response['list'] = $productList;
		$response['error'] = 0;
		$response['msg'] = '';
	} else {
		$response['error'] = 1;
		$response['msg'] = 'No products to show';
	}

	return $response;
}

/**************************************

 get_more_products_from_seller  End
 
 ****************** *********************/






/**************************************

 SELECT PRODUCT OF SELLER FUNCTION
 
 ****************** *********************/

function view_prod($advertId, $limt, $conn)
{

	$sql = "SELECT * FROM products where advertId = '$advertId' order by id ASC limit $limt, 30 ";
	$categorylist = mysqli_query($conn, $sql);

	while ($categorydetail = mysqli_fetch_array($categorylist)) {
		$categorydetails['id'] = $categorydetail['id'];
		$categorydetails['name'] = $categorydetail['name'];
		$categorydetails['aw_img'] = $categorydetail['aw_img'];
		$categorydetails['aw_deeplink'] = $categorydetail['aw_deeplink'];
		$categorydetails['count'] = $categorydetail['count'];
		$categorydetails['prod_name'] = $categorydetail['prod_name'];
		$categorydetails['details'] = $categorydetail['details'];
		$categorydetails['cat'] = $categorydetail['cat'];
		$categorydetails['fee'] = $categorydetail['fee'];
		$categorydetails['aw_id'] = $categorydetail['aw_id'];
		$categorydetails['mer_id'] = $categorydetail['mer_id'];
		$categorydetails['advertId'] = $categorydetail['advertId'];
		$categorydetails['in_stock'] = $categorydetail['in_stock'];
		$categorydetails['delivery'] = $categorydetail['delivery'];
		$categorydetails['valid_to'] = $categorydetail['valid_to'];
		$categorydetails['rrp'] = $categorydetail['rrp'];
		$categorydetails['last_update'] = $categorydetail['last_update'];
		$categorydetails['ean_no'] = $categorydetail['ean_no'];
		$categorydetails['isbn_no'] = $categorydetail['isbn_no'];
		$categorydetails['stock_qty'] = $categorydetail['stock_qty'];
		$categorydetails['viewed'] = $categorydetail['viewed'];
		$categorydetails['searched'] = $categorydetail['searched'];
		$category1[] = $categorydetails;
	}

	$category['sql'] = $sql;

	if ($category1) {
		$category['list'] = $category1;
		$category['error'] = 0;
		$category['msg'] = 'All advert List';
	} else {
		$category['error'] = 1;
		$category['msg'] = 'No advert List';
	}

	return $category;
}

/**************************************

 SELECT PRODUCT OF SELLER FUNCTION End
 
 ****************** *********************/


/**************************************

 SELECT and View advert_id FUNCTION 
 
 ****************** *********************/

function view_advert_id($advertid, $conn)
{

	$categorylist = mysqli_query($conn, "SELECT id,bannerimage,buttonimage,smalldesc,howearn,largedesc,urllink,pay_out FROM `advert` WHERE id=$advertid and status=1");

	if (!isset($_SESSION["offertype"])) {

		$configResult = mysqli_query($conn, " SELECT * FROM `config` where varname = 'offertype' ");

		if (mysqli_num_rows($configResult) > 0) {
			while ($configItem = mysqli_fetch_assoc($configResult)) {
				$_SESSION["offertype"] = $configItem["value"];
			}
		}
	}

	$userid = 0;

	$rate = 0;
	$total = 0;
	$count = 0;

	$ratingsql = "SELECT total, count FROM advertratings WHERE advertid = '" . $advertid . "' ";
	$ratingresult = mysqli_query($conn, $ratingsql);
	$ratingresultrows = mysqli_num_rows($ratingresult);

	if ($ratingresultrows > 0) {

		$ratingdata = mysqli_fetch_assoc($ratingresult);

		$total = $ratingdata["total"];
		$count = $ratingdata["count"];


		if ($count != 0) {
			$rate = $total / $count;
		}
	}

	/* if(isset($_SESSION["login"]["list"]["id"]) && $_SESSION["login"]["list"]["id"] > 0)
	{ 
	  
	} */

	$userid = $_SESSION["login"]["list"]["id"];
	//$myoffersql = " SELECT advertid  FROM myoffers WHERE  userid = '".$userid."' ";
	$myoffersql = " SELECT advertid  FROM myoffers ";
	$myofferresult = mysqli_query($conn, $myoffersql);

	while ($myoffer = mysqli_fetch_assoc($myofferresult)) {
		$myoffers[] = intval($myoffer["advertid"]);
	}
	while ($categorydetail = mysqli_fetch_assoc($categorylist)) {



		//print_r($categorydetail);

		$categorydetail["isMyOffer"] = false;

		/* if(isset($myoffers) && is_array($myoffers) && count($myoffers) > 0)
	  {
		if(in_array($categorydetail["id"], $myoffers))
		{   
			$categorydetail["isMyOffer"] = true; */

		$categorydetails['id'] = $categorydetail['id'];
		$categorydetails['bannerimage'] = $categorydetail['bannerimage'];
		$categorydetails['buttonimage'] = $categorydetail['buttonimage'];
		$categorydetails['urllink'] = $categorydetail['urllink'];
		$categorydetails['companyname'] = $categorydetail['companyname'];
		$categorydetails['smalldesc'] = htmlspecialchars($categorydetail['smalldesc']);



		$categorydetails['howearn'] = utf8_encode($categorydetail['howearn']);
		//$categorydetails['howearn'] = mysqli_set_charset($categorydetail['howearn'], 'utf8mb4'); 

		$categorydetails['money'] = $categorydetail['money'];
		$categorydetails['largedesc'] = utf8_encode($categorydetail['largedesc']);
		$categorydetails['subcat1'] = $categorydetail['subcat1'];
		$categorydetails['subcat2'] = $categorydetail['subcat2'];
		$categorydetails['subcat3'] = $categorydetail['subcat3'];
		$categorydetails['clicks'] = $categorydetail['clicks'];
		$categorydetails['approved'] = $categorydetail['approved'];
		$categorydetails['earnings'] = $categorydetail['earnings'];
		$categorydetails['timestamp'] = $categorydetail['timestamp'];
		$categorydetails['network'] = $categorydetail['network'];
		$categorydetails['networks_id'] = $categorydetail['networks_id'];
		$categorydetails['status'] = $categorydetail['status'];
		$categorydetails['tickets'] = $categorydetail['tickets'];
		$categorydetails['product'] = htmlspecialchars($categorydetail['product']);
		$categorydetails['brand'] = htmlspecialchars($categorydetail['brand']);
		$categorydetails['brand_power'] = $categorydetail['brand_power'];


		$sub_string = '£';
		$str = $categorydetail['pay_out'];
		if (substr($str, 0, strlen($sub_string)) == $sub_string) {
			$strval = substr($str, strlen($sub_string));
		}

		$categorydetails['pay_out'] = $strval;


		$categorydetails['payout_level'] = $categorydetail['payout_level'];
		$categorydetails['payout_given'] = $categorydetail['payout_given'];
		$categorydetails['country_reference'] = $categorydetail['country_reference'];
		$categorydetails['payout_type'] = $categorydetail['payout_type'];
		$categorydetails['productfeed'] = $categorydetail['productfeed'];
		$categorydetails['feed_link'] = $categorydetail['feed_link'];
		$categorydetails['last_update'] = $categorydetail['last_update'];
		$categorydetails['lge'] = $categorydetail['lge'];
		$categorydetails['minisite_status'] = $categorydetail['minisite_status'];

		//}
		//}

		$categorydetail["howearn"] = str_replace("#OFFERTYPE#", $_SESSION["offertype"], $categorydetail["howearn"]);


		$categorydetail["rate"] = $rate;
		$categorydetail["total"] = $total;
		$categorydetail["count"] = $count;


		$category1[] = $categorydetail;
	}


	if ($category1) {
		$category['list'] = $category1;
		$category['error'] = 0;
		$category['msg'] = 'view advert';
	} else {
		$category['error'] = 1;
		$category['msg'] = 'No advert ';
	}

	return $category;
}

/**************************************

 SELECT and View advert_id FUNCTION 
 
 ****************** *********************/



/********************************

Rate And vote Function 
 
 ****************** ***************/

function add_vote($userid, $advertid, $vote, $conn)
{


	$sql = mysqli_query($conn, "SELECT * FROM `advertratinglog` WHERE `advertid`=$advertid and `userid`=$userid");

	$res = mysqli_fetch_assoc($sql);
	if (!$res) {

		//$timestamp = time();

		$query = "INSERT INTO `advertratinglog`(`advertid`, `userid`, `rating`) VALUES ($advertid, '$userid', $vote)";


		$qry = mysqli_query($conn, $query);

		if ($qry) {
			$sql1 = mysqli_query($conn, "SELECT * FROM `advertratings` WHERE `advertid`=$advertid");
			$res1 = mysqli_fetch_assoc($sql1);
			if ($res1) {
				$count = $res1['count'] + 1;
				$total = $res1['total'] + $vote;


				$sql1 = mysqli_query($conn, "UPDATE advertratings SET total=$total,count=$count WHERE `advertid`=$advertid");
			} else {

				$sql1 = mysqli_query($conn, "INSERT INTO `advertratings`(`advertid`, `total`, `count`) VALUES  ($advertid,$vote,1)");
			}
		}


		$response['error'] = 0;
		$response['message'] = 'Success';
	} else {
		$response['error'] = 1;
		$response['message'] = 'Failed';
	}
	return $response;
}

/********************************

Rate And vote Function End
 
 ****************** ***************/


/********************************

Myoffers Function End
 
 *********************************/

function myOffers($userId, $conn)
{

	$query = "SELECT * FROM myoffers, advert  WHERE myoffers.advertid = advert.id AND userid = '$userId'";

	$qry = mysqli_query($conn, $query);

	if ($qry) {

		while ($myofferresult = mysqli_fetch_assoc($qry)) {

			$result1['myofferid'] = $myofferresult['myofferid'];
			$result1['advertid'] = $myofferresult['advertid'];
			$result1['userid '] = $myofferresult['userid'];
			$result1['timestamp '] = $myofferresult['timestamp'];
			$result1['id'] = $myofferresult['id'];
			$result1['bannerimage'] = $myofferresult['bannerimage'];
			$result1['buttonimage'] = $myofferresult['buttonimage'];
			$result1['urllink'] = $myofferresult['urllink'];
			$result1['companyname'] = $myofferresult['companyname'];
			$result1['smalldesc'] = htmlspecialchars($myofferresult['smalldesc']);
			$result1['howearn'] = htmlspecialchars($myofferresult['howearn']);
			$result1['money'] = $myofferresult['money'];
			$result1['largedesc'] = htmlspecialchars($myofferresult['largedesc']);
			$result1['subcat1'] = $myofferresult['subcat1'];
			$result1['subcat2'] = $myofferresult['subcat2'];
			$result1['subcat3'] = $myofferresult['subcat3'];
			$result1['clicks'] = $myofferresult['clicks'];
			$result1['earnings'] = $myofferresult['earnings'];
			$result1['timestamp'] = $myofferresult['timestamp'];
			$result1['network'] = $myofferresult['network'];
			$result1['networks_id'] = $myofferresult['networks_id'];
			$result1['status'] = $myofferresult['status'];
			$result1['tickets'] = $myofferresult['tickets'];
			$result1['product'] = htmlspecialchars($myofferresult['product']);
			$result1['brand'] = htmlspecialchars($myofferresult['brand']);
			$result1['brand_power'] = $myofferresult['brand_power'];
			$result1['pay_out'] = $myofferresult['pay_out'];
			$result1['payout_level'] = $myofferresult['payout_level'];
			$result1['payout_given'] = $myofferresult['payout_given'];
			$result1['country_reference'] = $myofferresult['country_reference'];
			$result1['payout_type'] = $myofferresult['payout_type'];
			$result1['productfeed'] = $myofferresult['productfeed'];
			$result1['feed_link'] = $myofferresult['feed_link'];
			$result1['last_update'] = $myofferresult['last_update'];
			$result1['lge'] = $myofferresult['lge'];
			$result1['minisite_status'] = $myofferresult['minisite_status'];

			$data[] = $result1;
		}


		if ($data) {
			$category['list'] = $data;
			$category['error'] = 0;
			$category['msg'] = 'Success';
		} else {
			$category['error'] = 1;
			$category['msg'] = 'Sorry';
		}
	} else {
		$category['error'] = 1;
		$category['msg'] = 'Sorry';
	}


	return $category;
}

/********************************

Myoffers Function End
 
 ****************** ***************/



/********************************

Add Myoffers Function 
 
 ****************** ***************/

/*     function addMyOffer($userId, $advertid, $conn) {
	   echo $userId;
	 die;

		$timestamp = time();
	$mysqltime = date ("d-m-Y H:i:s", $timestamp);
		$query = "INSERT INTO `myoffers` (`myofferid`, `advertid`, `userid`, `timestamp`) VALUES (NULL, '$advertidd', '$useridd', '$timestamp')";
	
	
		$qry = mysqli_query($query, $conn);
		if ($qry) {
			$response['error'] = 0;
			$response['msg'] = "success";
		} else {
			$response['error'] = 1;
			$response['msg'] = "sorry";
		}
		return $response;
	}   */


/********************************

Add Myoffers Function End
 
 ****************** ***************/



/********************************

Remove Myoffers Function 
 
 ****************** ***************/

function removeMyOffer($userId, $advertid, $conn)
{

	$query = "Delete FROM `myoffers` WHERE `advertid`='$advertid' and `userid`='$userId'";

	$qry = mysqli_query($conn, $query);


	if ($qry) {
		$response['error'] = 0;
		$response['msg'] = "success";
	} else {
		$response['error'] = 1;
		$response['msg'] = "sorry";
	}

	return $response;
}

/********************************

Remove Myoffers Function End
 
 ****************** ***************/



/********************************

My-history Function End
 
 ****************** ***************/

function my_historylist($userid, $conn)
{

	$sql1 = mysqli_query($conn, "SELECT * FROM `advertlog` WHERE `user_id`=$userid order by advertlog_id desc LIMIT 12");

	//$sql1 = mysqli_query($conn,"SELECT * FROM advertlog LEFT JOIN advert ON advertlog.searchkey=advert.companyname  WHERE `user_id`=$userid order by advertlog_id desc");

	$resul = array();

	while ($res1 = mysqli_fetch_assoc($sql1)) {
		$resul['advertlog_id'] = $res1['advertlog_id'];
		$resul['searchkey'] = $res1['searchkey'];
		$resul['user_id'] = $res1['user_id'];
		$resul['ipaddress'] = $res1['ipaddress'];
		$resul['search_type'] = html_entity_decode($res1['search_type']);
		$resul['search_time'] = $res1['search_time'];
		$resul['total_result'] = $res1['total_result'];
		$resul['showuser'] = $res1['showuser'];
		$resul['first_product'] = $res1['first_product'];
		$rest = $resul['first_product'];
		$sql2 = mysqli_query($conn, "SELECT aw_img FROM products WHERE `id`=$rest");
		while ($res1 = mysqli_fetch_assoc($sql2)) {
			$resul['aw_img'] = $res1['aw_img'];
		}
		$res[] = $resul;
	}


	if ($res) {
		$response['list'] = $res;
		$response['error'] = 0;
		$response['message'] = 'Success';
	} else {
		$response['error'] = 1;
		$response['message'] = 'Failed';
	}
	return $response;
}

/********************************

My-history Function End
 
 ****************** ***************/


/**********************************

Start Save Profile Information

********************************/

if (isset($_POST['action']) && $_POST['action'] == 'save_profile') {
	unset($_POST['action']);
	if(empty($_SESSION['user_id'])) {
		$result = insert('users', $_POST);
	} else {
		$where = ['id' => $_SESSION['user_id']];
		$result = update('users', $_POST, $where);
	}
	if ($result) {
		$_SESSION['successsave']="Data Updated Successfully.";
	} else {
		$_SESSION['unsuccesssave']="Something went wrong.";
	}
}

/**********************************

Start Save Profile Information End

************************************/


 /**********************************
 
Start Update Email or Password

************************************/

if (isset($_POST['action']) && $_POST['action'] == 'update_email_password') {
	unset($_POST['action']);

	$current_password = $_POST['current_password'];
	$new_password = $_POST['new_password'];
	$confirm_password = $_POST['confirm_password'];
	$email = (empty($_POST['email'])) ? $_SESSION['username'] : $_POST['email'];

	if (!empty($current_password) && !empty($new_password)) {

		$verify_current_password = read('users', ['id' => $_SESSION['user_id']]);

		if ($verify_current_password['password'] !== md5($current_password)) {
			$_SESSION['unsuccesspass']="Current Password not Matched.";
			
		} else if ($current_password === $new_password) {
			$_SESSION['unsuccesspass']="Current Password and new Password are same.";
		} else if ($new_password !== $confirm_password) {
			$_SESSION['unsuccesspass']="New Password and Confirm Password are not matched.";
		} else {
			$data = ['username' => $email, 'password' => md5($new_password)];
			$where = ['id' => $_SESSION['user_id']];
		}
	} else {
		$data = ['username' => $email];
		$where = ['id' => $_SESSION['user_id']];
	}

	if (!empty($data) && !empty($where)) {
		$result = update('users', $data, $where);

		if ($result) {
			$_SESSION['successpass']="Data Updated Successfully.";
		} else {
			$_SESSION['unsuccesspass']="Something went wrong.";
		}
	}
}

 /**********************************
 
Start Update Email or Password End

************************************/


/******************************************

Insert, Update, Delete Functions Start

********************************************/

function read($table, $fields = array())
{
	global $conn;

	if (!empty($fields)) {
		$key = "" . implode(',', array_keys($fields)) . "";
		$value = "'" . implode("','", array_values($fields)) . "'";
		$sql = "SELECT * FROM " . $table . " WHERE " . $key . " = " . $value . "";
	} else {
		$sql = "SELECT * FROM " . $table . "";
	}

	$query = mysqli_query($conn, $sql);
	$res = mysqli_fetch_assoc($query);
	if ($res) {
		return $res;
	} else {
		return false;
	}
}

function insert($table, $fields)
{
	global $conn;

	$keys = "" . implode(',', array_keys($fields)) . "";
	$values = "'" . implode("','", array_values($fields)) . "'";
	 $sql = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $values . ")";
	 
	$res = mysqli_query($conn, $sql);

	if ($res) {
		$last_id = mysqli_insert_id($conn);
		return $last_id;
	} else {
		return false;
	}
}

function update($table, $fields, $where)
{
	global $conn;
	$set = '';
	$x = 1;
	foreach ($fields as $name => $value) {
		$set .= "{$name} = \"{$value}\"";
		if ($x < count($fields)) {
			$set .= ',';
		}
		$x++;
	}

	if (!empty($where)) {
		$keys = "" . implode(',', array_keys($where)) . "";
		$values = "'" . implode("','", array_values($where)) . "'";
	}

	$sql = "UPDATE {$table} SET {$set} WHERE {$keys} = {$values}";

	$query = mysqli_query($conn, $sql);
	if ($query) {
		return true;
	} else {
		return false;
	}
}

/******************************************

Insert, Update, Delete Functions Start End

********************************************/
 
 /********************************

Fetch Click Data End
 
 *********************************/

function clickdata($userId, $conn, $start = 'hello', $end = 0) {
	if($end == '0') {
		$query = "SELECT * FROM click WHERE userid = '$userId' and (status='1' or status='2' or status='3') ORDER BY clickid DESC";
	} else {
	  $query = "SELECT * FROM click WHERE userid = '$userId' and (status='1' or status='2' or status='3') ORDER BY clickid DESC limit $start, $end";
	}

	$qry = mysqli_query($conn, $query);

	if($qry) {

		while ($clickresult = mysqli_fetch_assoc($qry)) {

			$click1['timestamp'] = $clickresult['timestamp'];
			$click1['status'] = $clickresult['status'];
			$click1['payment'] = $clickresult['payment'];
			$click1['clickid'] = $clickresult['clickid'];
			$click1['advertid'] = $clickresult['advertid'];
			$click1['user_commission'] = $clickresult['user_commission'];
			$click1['paid_date'] = $clickresult['paid_date'];
			$click1['approved_date'] = $clickresult['approved_date'];
			
			 
			 	
			$data[] = $click1;
		}


		if ($data) {
			$category['list'] = $data;
			$category['error'] = 0;
			$category['msg'] = 'Success';
		} else {
			$category['error'] = 1;
			$category['msg'] = 'Sorry';
		}
	} else {
		$category['error'] = 1;
		$category['msg'] = 'Sorry';
	}

	return $category;
}


 /********************************

Fetch Click Data End
 
 *********************************/

function paymentdata($userId, $conn, $start = 'hello', $end = 0) {
	if($end == '0') {
		$query = "SELECT * FROM payment  WHERE userid = '$userId' ORDER BY id DESC)";
	} else {
		$query = "SELECT * FROM payment  WHERE userid = '$userId' ORDER BY id DESC limit $start, $end";
	}

	$qry = mysqli_query($conn, $query);

	if($qry) {
		

		while ($clickresult = mysqli_fetch_assoc($qry)) {

			$click1['payment'] = $clickresult['payment'];
			$click1['paid_date'] = $clickresult['paid_date'];
			$click1['status'] = $clickresult['status'];
			$click1['method'] = $clickresult['method'];
			$click1['request_date'] = $clickresult['request_date'];
			
			///$click1['clickid'] = $clickresult['clickid'];
			//$click1['advertid'] = $clickresult['advertid'];
			//$click1['user_commission'] = $clickresult['user_commission'];
			//$click1['paid_date'] = $clickresult['paid_date'];
			
			
			 
			 	
			$data[] = $click1;
		}


		if ($data) {
			$category['list'] = $data;
			$category['error'] = 0;
			$category['msg'] = 'Success';
		} else {
			$category['error'] = 1;
			$category['msg'] = 'Sorry';
		}
	} else {
		$category['error'] = 1;
		$category['msg'] = 'Sorry';
	}

	return $category;
}


function clickdatacount($userId, $conn) {
	$query = "SELECT * FROM click WHERE userid = '$userId' and (status='1' or status='2' or status='3')";
	$qry = mysqli_query($conn, $query);
	$count = mysqli_num_rows($qry);
	

	return $count;
}

/********************************

Fetch Click Data End
 
****************** ***************/


/********************************

My Friend Account Statement
 
****************** ***************/

function clickdatafriend($referrerid, $conn, $start = 'hello', $end = 0) {
	if($end == '0') {
		  $query = "SELECT * FROM click WHERE referrer = '$referrerid' and paid='1' ORDER BY clickid DESC";
	} else {
		  $query = "SELECT * FROM click WHERE referrer = '$referrerid' and paid='1' ORDER BY clickid DESC limit $start, $end";
	}

	$qry = mysqli_query($conn, $query);

	if($qry) {

		while ($clickresult = mysqli_fetch_assoc($qry)) {

			$click1['timestamp'] = $clickresult['timestamp'];
			$click1['status'] = $clickresult['status'];
			$click1['payment'] = $clickresult['payment'];
			$click1['clickid'] = $clickresult['clickid'];
			$click1['advertid'] = $clickresult['advertid'];
			$click1['user_commission'] = $clickresult['user_commission'];
			$click1['paid_date'] = $clickresult['paid_date'];
			$click1['approved_date'] = $clickresult['approved_date'];
			$click1['referrer_comission'] = $clickresult['referrer_comission'];
			
			
			 
			 	
			$data[] = $click1;
		}


		if ($data) {
			$category['list'] = $data;
			$category['error'] = 0;
			$category['msg'] = 'Success';
		} else {
			$category['error'] = 1;
			$category['msg'] = 'Sorry';
		}
	} else {
		$category['error'] = 1;
		$category['msg'] = 'Sorry';
	}

	return $category;
}


function clickdatacountfri($userId, $conn) {
	$query = "SELECT * FROM click WHERE referrer ='$referrerid' and (status='1' or status='2' or status='3')";
	$qry = mysqli_query($conn, $query);
	$count = mysqli_num_rows($qry);
	

	return $count;
}
/***********************************

Insert and update request submit GET PAID PROCESS
 
****************** ***************/

if(isset($_POST['requestsubmitbtn']))	
{
   $reqeuserid = $_SESSION['user_id'];			
   $avabalpaid = $_POST['balance'];  /// 1000
   $withdraw_amt = $_POST['withdraw_amt'];  /// 1000
  
 
   //$adminconfigbals = $_POST['requstbalance'];		//// 4.9 
   $timestamp = time();
   $requestime = date ("d-m-Y H:i:s", $timestamp);
   $reqetype = "1";
   $requestmethod = "PayPal";
   $reqestatus = "0";
   $useravlblc = $avabalpaid - $withdraw_amt;
  
   if($avabalpaid >= $withdraw_amt)
   {
	   
   $updaterequst = mysqli_query($conn,"update users set paid = '$useravlblc' where id = '$reqeuserid'");    
   $requrtres = mysqli_query($conn, "INSERT INTO payment (payment,userid,type,paid_date,method,request_date,status) VALUES ('$withdraw_amt','$reqeuserid','$reqetype','$requestime','$requestmethod','$requestime','$reqestatus')");
   if($updaterequst){
	   
	   $transactioncompleted =  "Transaction Completed Successfully";	   
	   $_SESSION['transactioncompleted'] = $transactioncompleted;
	   
   }else{
	    
		$transactioncompleted =  "Transaction Not Completed Successfully";	   
	    $_SESSION['transactioncompleted'] = $transactioncompleted;
   }	   
   }   
   else
   {
	     $balancemsg =  "Account Balance are not available ";
		 $_SESSION['transactioncompleted'] = $balancemsg;
		 
   }   
}
  


/***************************************

Insert and update request submit End
 
****************** *********************/


/***************************************

fetch click data from product table
 
****************** *********************/

function clickproductdata($prodid) {
global $conn;

if($prodid > 0)
{
		
	$productitems = array();
    $prodQuery = "Select * from products where id = $prodid";
	$productqr = mysqli_query($conn,$prodQuery);
	
    while($productitemrow = mysqli_fetch_assoc($productqr)){
		
    $productitems[] = $productitemrow;

}
return $productitems;

}

}

/***************************************

fetch click data from product table End
 
****************** *********************/


function lastclickid($fields) {

	$userid =  $fields['userid'];

	global $conn;
	$keys = "" . implode(',', array_keys($fields)) . "";
	$values = "'" . implode("','", array_values($fields)) . "'";
    $sql = "INSERT INTO click (" . $keys . ") VALUES (" . $values . ")";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		$lastclickid = mysqli_query($conn, "SELECT max(clickid) FROM click where userid = '$userid'");
		$row = mysqli_fetch_row($lastclickid);
		$lastid = $row[0];
		return $lastid;
	} else {
		return false;
	}
}

/***************************************

fetch last click id from clik
 
****************** *********************/




/***************************************

fetch last click id from clik End
 
****************** *********************/



/***************************************

fetch seller click data 
 
****************** *********************/

function sellerclickadvertdata($advertprodid) {
	global $conn;
	
	if($advertprodid > 0)
	{
			
		$productitems = array();
		$prodQuery = "Select * from advert where id = $advertprodid";
		$productqr = mysqli_query($conn,$prodQuery);
		
		while($productitemrow = mysqli_fetch_assoc($productqr)){
			
		$productitems[] = $productitemrow;
	
	}
	return $productitems;
	
	}
	
	}
function redirect_page($location)
    {

        if (!headers_sent()) {

            header('Location: ' . $location);

            exit;

        } else {
            echo '<script type="text/javascript">';
        }

        echo 'window.location.href="' . $location . '";';

        echo '</script>';

        echo '<noscript>';

        echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';

        echo '</noscript>';

    }

	/***************************************
	
    fetch seller click data End
	 
	****************** *********************/