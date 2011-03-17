<?php

$fileLocation = "/var/application/Gawk/MainSite/";

ini_set("include_path",
	// Site specific includes
	$fileLocation . PATH_SEPARATOR .
	$fileLocation . "Application/" . PATH_SEPARATOR .
	$fileLocation . "Test/PHPUnit/" . PATH_SEPARATOR .
	PEAR_INSTALL_DIR
);

//ini_set("memory_limit", "16M");

require_once "Bootstrap.php";
$application = CoreFactory::getApplication();
$application->setDebug(true);
$application->setContentType("text/plain");