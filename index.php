<?php
/**
 * Filename: index.php
 * Description:
 *	php-gae-router routing script.
 *
 * Author: Joe Burnett <info@audiopoison.com>
 *
 */

namespace php-gae-router;

define(_NAMESPACE, "php-gae-router");
define(_MODULE_PATH, "./modules");

if (!isset($_SERVER["REQUEST_URI"])) {
	die("Server encountered an internal problem.");
} else {
	// Get requested script name (usable with routing algorithm below)
	$position = strpos($_SERVER["REQUEST_URI"], "?");
	$length = ($position == false ? strlen($_SERVER["REQUEST_URI"]) : $position);
	$module = substr($_SERVER["REQUEST_URI"], 1,
		$length - 1);
}

// Dynamic routing
if (!strcmp(substr($module, 0, 3), "get")) {
	if (file_exists(_MODULE_PATH."/".$module.".php")) {

		include(_MODULE_PATH."/".$module.".php");
		$class = _NAMESPACE."\\".$module."\\".$module;
		$class_obj = new $class($_SERVER["QUERY_STRING"]);
		
		$class_obj->display();
	}
	exit(0);
} else {
	include(_MODULE_PATH."/index.php");
}
?>
