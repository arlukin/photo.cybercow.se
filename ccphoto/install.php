<?php
	require_once('cc/install.php');

	echo "start<br>";
	$install = new install();

	$install->unlinkSymlinks();
	$install->fixDirectoryPermissions();	
	$install->setSymlink('../../photo.cybercow.se.cache', 'cache');
	$install->setSymlink('../../photo.cybercow.se.data', 'data');
	echo "end<br>";
?>

