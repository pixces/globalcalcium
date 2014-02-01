<?php
/**
* functions.php
*/

// function to clean the variables
//detecting the data type of the variable
function clean($var , $array = 0){
	if ($array == 0)
		{
		$data = sanitize($var);
		} 
	else if ($array == 1)
		{
		foreach($var as $key=>$val){		
				$data[$key] = sanitize($val);
			}
		}
	return $data;
}

//basic function to remove unwanted 
//issues from the variable
function sanitize($var){
	if ($var)
		{
		$var = trim($var);
		$var = addslashes($var);	
		return $var;
		}
}


/**
* function to clean up the database
* when the user enters into the system
*/ 
function doCleanUp(){
	
	global $db;

	$oldTime = date("z")-1;
	//delete all the entries in the user table
	//which are older than 1 day
	$sQl = "delete from users where user_date = '".$oldTime."'";
	$result = $db->query($sQl);
}

/**
* function to generate a new users
*/
function generateNewUser(){
	global $db;
	if (!$_SESSION['uId'])
		{
		//create a new user
		$newTime= date("z");
		$userSession = session_id();
		$uId = time();
		
		//get a new card id
		$cartId = md5(microtime());
		
		//add it into the database
		$sQl = "insert into users values ('','".$uId."','".$cartId."','".$userSession."','".$newTime."')";
		$result = $db->query($sQl);
			if ($result)
				{
					$_SESSION['cartId'] = $cartId;
					$_SESSION['uId'] = $uId;
					return true;
				} else {
					return false;
					}
		}
}


/***
* function to check if the user 
* is logged in or not
*/
function isUserLoggedIn(){
	
	global $db;
	if ($_SESSION['loggedIn'] === true)
		{
		$userId = $_SESSION['userId'];
		$sQl = "select * from slh_users where user_id = '$userId'";
		$result = $db->get_row($sQl);
		if ($result) 
			{
			return true;	
			} else {
				return false;
				}
		} else {
			return false;
			}
}


/**
* function to do
* user logout process
*/
function doUserLogout(){
	
	unset($_SESSION['loggedIn']);
	unset($_SESSION['userId']);
	
	session_destroy();
	
	//redirect to the home page
	header("location: index.php");
	exit;	
}

	/**
	* function to convert 
	* a string in to a well format
	* data structure.
	*/
	function string2date($string){
		if (empty($string))
			{
			return false;
			}	
		$timeStamp = strtotime($string);
		return date("M d, Y", $timeStamp);
	}


	/**
	* function to generate 
	* randon 5 character string
	*/
	function generateCaptcha( $count, $type = NULL ){
		
		if (is_null($type)){
			$listVal = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
			} else {
				$listVal = '1234056789';
			}
			
		$num = "";
		for ($i=0; $i < $count; $i++)
			{
			$num .= $listVal[rand(0,strlen($listVal))];
			}
		return $num;
	}
	
	
	/**
	* to validate email id
	*/
	function is_valid($email){
		if (!$email)
			{
			return false;
			}
		
		if ( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )
			{
			return true;
			} else {
				return false;
				}
	}
	
	/**
	* get basic site configuration
	*/
	function getConfiguration(){
		global $db;
		$sQl = "select * from cms_config ";
		$result = $db->get_row($sQl);
		if ($result)
			{
			$config = array();
			foreach($result as $key=>$val)
				{
				$config[$key] = $val;
				}
			return $config;
			} else {
				return false;
				}				 
	}	
	
	
	/**
	* function to convert the GET array into 
	* GET URL
	*/

	function arrayToQuerystring($myArray) {

		foreach( $myArray as $key=>$value ) {

			if ($key == 'pn') continue;

			$queryParts[] = urlencode($key) . "=" . urlencode($value);

		}

		return implode( '&', $queryParts );

	}


	/**
	* function to create the activation code
	* for the user for email validation
	*/

	function md5_hash( $str ){
	
 		return md5( $str );
	
	}
	
	
	
/*
* select box of country
*/
function getCountrySelect($name = NULL, $selected = 'India'){
$countryList = array('Afghanistan','Arabia', 'Saudi','Argentina','Australia','Bahrain','Bangladesh','Bhutan','Brazil','Cambodia','Canada','China','Colombia','Costa Rica','Cuba','Czech Republic','Denmark','Egypt','Europe','European Union','Fiji','Finland','France','Germany','Ghana','Haiti','Holland','Hong Kong, (China)','Hungary','Iceland','India','Indonesia','Iran, Islamic Republic of','Iraq','Israel','Italy','Japan','Korea, Dem. Peoples Rep.','Korea, (South) Republic of','Kuwait',
'Malaysia','Maldives','Mexico','Middle East','Morocco','Myanmar (ex-Burma)','Nepal','New Zealand','Oman','Pakistan','Philippines','Qatar','Russia (Russian Fed.)','Saudi Arabia','Seychelles','Singapore','South Africa','South America','Sri Lanka (ex-Ceilan)','Sudan','Switzerland','Syrian Arab Republic','Taiwan','Thailand','Turkey','United Arab Emirates','United Kingdom','United States');
	
	if (is_null($name))
		{
		$name = "country";
		}
	
	$sBox = '<select name="'.$name.'" id="countryCombo" style="width:200px;">';
	$sBox .= '<option value="">--- Select Country ---</option>';
	foreach ($countryList as $country)
		{
		if ($selected != NULL )
			{
			if ($country == $selected) { $sel = 'selected="selected"'; } else { $sel =''; }
			}
		$sBox .= '<option value="'.$country.'" '.$sel.'>'.$country.'</option>';
		}
	$sBox .= "</select>";

	return $sBox;
}
	

function getCitySelect($name){

	global $db;
	$citySql = "select `city_name` from rnp_cities order by `city_name` ASC";
	$result = $db->get_results($citySql);
	
	if ($result){
	
		$cityBox = "";
		$cityBox .= '<select name="'.$name.'" id="bill_city" size="1" style="width:200px;"><option value="">Select a City</option>';
		
		foreach($result as $city){	
			$cityBox .= '<option value="'.$city->city_name.'">'.$city->city_name.'</option>';	
			}
	}	
	return $cityBox;
}


function getDateSelect(){
	$dateBox = "";
	$dateBox .= '<select name="date" id="date" size="1"><option value="">Date</option>';
	
	for($x=1; $x<=31; $x++)
		{
		$dateBox .= '<option value="'.str_pad($x,2).'">'.str_pad($x,2).'</option>';	
		}
	$dateBox .= '</select>';
	
	return $dateBox;
}

function getMonthSelect(){

	$monthArray=array('Jan','feb','march','april','may','june','july','aug','sept','oct','nov','dec');
	
	$dateBox = "";
	$dateBox .= '<select name="month" id="month" size="1"><option value="">Month</option>';
	
	for($x=0; $x < count($monthArray); $x++)
		{
		$dateBox .= '<option value="'.str_pad(($x+1),2).'">'.ucwords($monthArray[$x]).'</option>';	
		}
	$dateBox .= '</select>';
	
	return $dateBox;
}

function getYearSelect($future=NULL){

	$dateBox = "";
	$dateBox .= '<select name="year" id="year" size="1"><option value="">Year</option>';
	
	if ($future != NULL)
		{
		$start = date('Y');
		
		} else {
			$start = 1940;
			}
	$end = $start + 60;

	for($x=$start; $x <= $end; $x++)
		{
		$dateBox .= '<option value="'.str_pad($x,4).'">'.str_pad($x,4).'</option>';	
		}
	$dateBox .= '</select>';
	
	return $dateBox;
}
	
/* get page content */
function get_page($link_id){
	$page = array();
	global $db;
	$sQl = "select * from pages where link_id = '".$link_id."'";
	$result = $db->get_row($sQl);

	if ($result){
		if ($result->filename){
			//get the page content;
			$url = SITE_ROOT."assets/pages/".$result->filename;
			$content = file_get_contents($url);
		}	else {
			$content = "Coming soon";
		}
	
		$page['title'] = $result->title;
		$page['keyword'] = $result->keyword;
		$page['description'] = $result->description;
		$page['file_name'] = $result->filename;
		$page['content'] = htmlentities($content);
		return $page;		
	} else {
		return false;
		}
}

/* function to get link list */
function get_addl_link($id){
	#get siblings of this link
	$linkObj = new Link($id);
	
	if ($config['sef_url'] != 0){ $linkObj->sef = true; }	
	
	$siblings = $linkObj->get_siblings();
	
	if (sizeof($siblings)){
		return $siblings;
	} else {
		return false;
		}
}

/* function to get formated link list 
for the footer */

function get_footer_links($id){
		
	$linkObj = new Link;	
	$siteLink = $linkObj->get_links($id);
	
	$list = "";
	foreach($siteLink as $link){
		$list .= '<li><a href="'.$link['href'].'">'.$link['name'].'</a></li>';
	}
	return "<ul>".$list."</ul>";
}

/* function to get the meta info if page id is provided */
function get_meta_info($id = null,$section = 'page'){
	#default information
	#can be used on all pages
	$meta['page_title'] = "Calcium Suppliers: Calcium Gluconate, Calcium & Mineral Salts - Global Calcium";
	$meta['meta_description'] = "Global Calcium is a leading supplier of quality calcium compounds to Nutraceuticals, pharmaceutical, food and beverage sectors. Products include calcium salts, mineral salts, Calcium Gluconate, and more.";
	$meta['meta_key'] = "Calcium Suppliers, Nutraceuticals, Calcium, Mineral, Salts, Suppliers, Calcium Gluconate, Global Calcium.";
	$meta['meta_robots'] = "ALL";
	
	if (!is_null($id)){
		$metaObj = new Metatag();
		$tags = $metaObj->get_meta_info($id,$section);
		
		if ($tags){
			return $tags;
			} else {
				return $meta;
				}
	} else {
		return $meta;
		}
}


?>