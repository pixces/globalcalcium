<?php
/*
* check for admin login
*/
function getCountrySelect($name = NULL, $selected = NULL){
$countryList = array('Afghanistan','Africa','Albania','Algeria','American Samoa','Andorra','Angola','Anguilla','Antarctica','Antigua & Barbuda','Antilles, Netherlands','Arabia, Saudi','Argentina','Armenia','Aruba','Asia','Australia','Austria','Azerbaijan','Bahamas, The','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bermuda','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana','Bouvet Island','Brazil','British Indian Ocean Terr.','British Virgin Islands','Brunei Darussalam','Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Canada','Cape Verde','Caribbean, the','Cayman Islands','Central African Republic','Central America','Chad','Chile','China','Christmas Island','Cocos (Keeling) Islands','Colombia','Comoros','Congo','Congo, Dem. Rep. of the','Cook Islands','Costa Rica','Cote DIvoire','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','East Timor (Timor-Leste)','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Europe','European Union','Falkland Islands (Malvinas)','Faroe Islands','Fiji','Finland','France','French Guiana','French Polynesia','French Southern Territories','Gabon','Gambia, the','Georgia','Germany','Ghana','Gibraltar','Greece','Greenland','Grenada','Guadeloupe','Guam','Guatemala','Guernsey and Alderney','Guiana, French','Guinea','Guinea-Bissau','Guinea, Equatorial','Guyana','Haiti','Heard & McDonald Is. (AU)','Holy See (Vatican)','Holland (see Netherlands)','Honduras','Hong Kong, (China)','Hungary','Iceland','India','Indonesia','Iran, Islamic Republic of','Iraq','Ireland','Israel','Italy','Ivory Coast (Cote dIvoire)','Jamaica','Japan','Jersey','Jordan','Kazakhstan','Kenya','Kiribati','Korea, Dem. Peoples Rep.','Korea, (South) Republic of','Kosovo','Kuwait','Kyrgyzstan','Lao Peoples Democ. Rep.','Latvia','Lebanon','Lesotho','Liberia','Libyan Arab Jamahiriya','Liechtenstein','Lithuania','Luxembourg','Macao, (China)','Macedonia, TFYR','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Man, Isle of','Marshall Islands','Martinique','Mauritania','Mauritius','Mayotte','Mexico','Micronesia, Fed. States of','Middle East','Moldova, Republic of','Monaco','Mongolia','Montenegro','Montserrat','Morocco','Mozambique','Myanmar (ex-Burma)','Namibia','Nauru','Nepal','Netherlands','Netherlands Antilles','New Caledonia','New Zealand','Nicaragua','Niger','Nigeria','Niue','Norfolk Island','North America','Northern Mariana Islands','Norway','Oceania','Oman','Pakistan','Palau','Palestinian Territory','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Pitcairn Island','Poland','Portugal','Puerto Rico','Qatar','Reunion (FR)','Romania','Russia (Russian Fed.)','Rwanda','Sahara','Saint Barthelemy (FR)','Saint Helena (UK)','Saint Kitts and Nevis','Saint Lucia','Saint Martin (FR)','S Pierre & Miquelon (FR)','S Vincent & Grenadines','Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia ','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South America','S.Georgia & S.Sandwich ','Spain','Sri Lanka (ex-Ceilan)','Sudan','Suriname','Svalbard & Jan Mayen Is.','Swaziland','Sweden','Switzerland','Syrian Arab Republic','Taiwan','Tajikistan','Tanzania, United Rep. of','Thailand','Timor-Leste (East Timor)','Togo','Tokelau','Tonga','Trinidad & Tobago','Tunisia','Turkey','Turkmenistan','Turks and Caicos Islands','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','US Minor Outlying Islands','Uruguay','Uzbekistan','Vanuatu','Vatican (Holy See)','Venezuela','Viet Nam','Virgin Islands, British','Virgin Islands, U.S.','Wallis and Futuna','Western Sahara','Yemen','Zambia','Zimbabwe');
	
	if (is_null($name))
		{
		$name = "country";
		}
		
	
	$sBox = '<select name="'.$name.'" id="'.$name.'" style="width:200px;">';
	$sBox .= '<option value="">--- Select Country ---</option>';
	foreach ($countryList as $country)
		{
		if ($selected != NULL )
			{
			if ($country == $selected) { $sel = "selected"; } else { $sel =''; }
			}
		$sBox .= '<option value="'.$country.'" '.$sel.'>'.$country.'</option>';
		}
	$sBox .= "</select>";

	return $sBox;
}

function isLoggedIn(){
	global $db;
	if ($_SESSION['loggedIn'] == 'yes')
		{	
		$adminId = $_SESSION['adminId'];
		//check if this exists in the database and has not logged out
		$sQl = "select * from cms_admin where id = '".$adminId."'";
		$result = $db->get_row($sQl);
		if ( ($result) && ($db->num_rows == 1) )
			{
			$logedIn =  true;
			} else {
				$logedIn = false;
				}	
		} else {
			$logedIn = false;
			}		

	if (!$logedIn)
		{
		header("location: login.php");
		exit;
		}
}

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

function sanitize($var){
	if ($var)
		{
		$var = trim($var);
		$var = addslashes($var);	
		return $var;
		}
}

function createBreadCrumb($l2=NULL, $l2_href=NULL, $l3=NULL){
	
	/**
	* breadcrumb style
	* Home/Article/Page Name
	*/
	$breadCrumb = array();
	$sep = '<span class="sep">/</span>';
	$breadCrumb[] = '<span class="level1"><a href="index.php">Home</a></span>';
	
	if ($l2 != NULL)
		{
		$breadCrumb[] = '<span class="level2"><a href="'.$l2_href.'">'.ucwords(strtolower($l2)).'</a></span>';
		}
		
	if ($l3 != NULL)
		{
		$breadCrumb[] = '<span class="level3">'.ucwords(strtolower($l3)).'</span>';
		}	
	
	return implode($sep,$breadCrumb);	
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
		
		//add it into the database
		$sQl = "insert into users values ('','".$uId."','".$userSession."','".$newTime."')";
		$result = $db->query($sQl);
		
		$_SESSION['uId'] = $uId;
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
* function to do admin logout
*/
function do_Admin_Logout(){
	print_r($_SESSION);
	
	unset($_SESSION['adminId']);
	unset($_SESSION['loggedIn']);
	
	session_destroy();
	
	header("location: index.php");
	exit;
}


function validEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
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


/**
* function to prepare query statement
*/
function doGetQuery($var,$rem=NULL){

	if (!is_array($var))
		{
		return false;
		}
	
	$link_list = "";
	foreach($var as $key=>$val)
		{
		if ($key != $rem)
			{
			$link_list .= "".$key."=".$val."&&"; 
			}
		}
	return $link_list;	
}


function getConfiguration(){
	global $db;
	$result = $db->get_row("select * from cms_config");
	if ($result)
		{
		$config = array();
		foreach($result as $key=>$val)
			{
			$config[$key] = $val;
			}
		return $config;		
		}


}


function getSectionCombo($selected=NULL){
	global $db;
	
	$box= "";
	$box .= '<select size="1" name="sec_parent" style="width:250px;"><option value="0">-- Main Section ---</option>';
	
	$sQl = "select * from cms_tbl_section where section_parent = '0' order by section_id ASC";
	$result = $db->get_results($sQl);
	if ($result)
		{
		foreach($result as $sel)
			{
			if(!is_null($selected)){
				if($sel->section_id == $selected){
					$sec_opt = 'selected="selected"';
					} else {
						$sec_opt = NULL;
				} 
				
			}
			$box .= '<option value="'.$sel->section_id.'"'.$sec_opt.'>'.$sel->section_name.'</option>';						
			
			}
		
		}
				
	$box .= '</select>';
	
	return $box;
}

/**
* Function to convert a title into SEF title.
* Remove all the special character inputs into en dashes (-)
*/
function convert_sef_name($data){
	$title = strtolower(addslashes(trim($data)));
	$search = array('`','!','@','#','%','^','&','*','(',')','+','|',':',';','[',']','{','}','.','/',' ');
	$repl = '-';
	$sef_title = str_replace($search, $repl, $title);
	return $sef_title;
}

/**
* Function to Remove en dashes from a given name.
* Remove all en dashes (-) into spaces
*/
function remove_dashes($data){
	$title = strtolower(addslashes(trim($data)));
	$search = '-';
	$repl = ' ';
	$undashed_name = ucwords(str_replace($search, $repl, $title));
	return $undashed_name;
}

/**
* Function to upload a image. 
*/
function uploadImage($imgeDtls){
	echo count($imageDtls);
	exit;
	
	$allowed_filetypes = array('.png','.jpg','.jpeg','.gif'); // These will be the types of file that will pass the validation.
	$upload_path = './images/content/'; // The place the files will be uploaded to (currently a 'files' directory).
	
	 $imageName = $_FILES['content_image']['name']; // Get the name of the file (including file extension).
	 $ImageFName = substr($imageName, 0, strpos($imageName,'.'));
	 $imageExt = substr($imageName, strpos($imageName,'.'), strlen($imageName)-1); // Get the extension from the filename.
	
	if(file_exists($upload_path . $filename)){
		$newImageName ="img_".$ImageFName.rand(0,999).$imageExt;
		} else {
			$newImageName = $imageName;
	}
	
	// Check if the filetype is allowed, if not DIE and inform the user.
	if(!in_array($imageExt,$allowed_filetypes))
		die('The file you attempted to upload is not allowed.');
		// Upload the file to your specified path.
	if(move_uploaded_file($_FILES['content_image']['tmp_name'],$upload_path . $newImageName)){
		 return true;
			}
		else {
			echo 'There was an error during the file upload.  Please try again.'; // 
	}
}

// Array of the product groups
$product_groups = array('pharmaceutical'=>'Pharmaceuticals','nutrition'=>'Nutrition','premix'=>'Fortified Premixes','veterinary'=>'Veterinary','cosmetics'=>'Cosmetics');

?>