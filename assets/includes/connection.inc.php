<?php
/*
* connection variables
*/
if (!isset($debug)){
	$debug = false;
}

if ($debug === true){
	define('EZSQL_DB_NAME', 'globalcalcium');
	define('EZSQL_DB_USER', 'root');
	define('EZSQL_DB_PASSWORD', '');
	define('EZSQL_DB_HOST', 'localhost');
	define('EZSQL_DB_CHARSET', 'utf8');
	define('EZSQL_DB_COLLATE', '');
} else {
	define("EZSQL_DB_USER", "globalcalcium");
	define("EZSQL_DB_PASSWORD", "global123!@#");
	define("EZSQL_DB_NAME", "globalcalcium");
	define("EZSQL_DB_HOST", "localhost");
	define('EZSQL_DB_CHARSET', 'utf8');
	define('EZSQL_DB_COLLATE', '');
	}

?>