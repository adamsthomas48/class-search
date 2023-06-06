<?php

/**
README - 11/4/2022

The following code in the globalLibraryLoader Function can be used to load any and all Classes as needed from the oulib/classes folder in this directory. 
Copy and paste the following code into your local site/folder application and change the localLibraryLoader path if necessary.  
If not necessary, you may delete that function and corresponding Loader function. 

Currently in use on USU/directory

If you have any questions, please see Danielle Bosco. 

##########
**/

spl_autoload_register('localLibraryLoader');


function localLibraryLoader($className) {
	$path = '/u/web/domains/usu/classroomsupport/_resources/dev/classroom-search/priv/';
	$ext = '.php';
	$fullPath = $path . $className . $ext;

	if (file_exists($fullPath)) {
		include_once $fullPath;
	} 

}

