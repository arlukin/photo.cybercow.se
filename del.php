<?php

	function getBackupName($sourceDir_, $num = 1)
	{
		$fileName = $sourceDir_ . '_' . str_pad($num, 3, "0", STR_PAD_LEFT);
		if (file_exists($fileName))
		{
			$fileName = getBackupName($sourceDir_, $num+1);
		}
		return $fileName;
	}
	$sourceDir = 'delete/ccph2oto';
	$sourceDir = getBackupName($sourceDir, 1);




include('ccphoto/cc/functions.php');
unlink('/hsphere/local/home/arlukin/photo.cybercow.se/ccphoto/install.php');
echo "done"

?>
