<?php

require_once('functions.php');

class install
{
	public function fixDirectoryPermissions()
	{
		$copyDir = realpath('../' . trim(substr(getcwd(), strrpos(getcwd(), "/")), '/'));
		$backupDir = $this->_getBackupName($copyDir);

		echo "Create backup: $backupDir<br>";
		if (!rename($copyDir, $backupDir)) printError('rename');

		copyRecursive($backupDir. '/', $copyDir. '/');
	}

	public function unlinkSymlinks()
	{
		echo "Remove symlinks<br>";
		$this->_unlinkSymlinks('data');
		$this->_unlinkSymlinks('cache');
	}

	private function _unlinkSymlinks($linkName)
	{
		$link = $this->_getCCPhotoPath() . $linkName;
		if (file_exists($link))
		{
			unlink($link);
		}
	}

	public function setSymlink($dataPath_, $linkName)
	{
		$dataPath = realPath(trim($dataPath_, '/'));
		$link = $this->_getCCPhotoPath() . $linkName;
		if (file_exists($dataPath))
		{
			echo "Create link at $link <br>";
			echo "From $dataPath <br>";

			if (!symlink($dataPath, $link))
				printError('symlink');
		}
		else
		{
			echo("ERROR: Couldn't find $dataPath_ please create that directory and install again");
		}
	}

	private function _getBackupName($sourceDir_, $num = 1)
	{
		$fileName = $sourceDir_ . '_' . str_pad($num, 3, "0", STR_PAD_LEFT);
		if (file_exists($fileName))
		{
			$fileName = $this->_getBackupName($sourceDir_, $num+1);
		}
		return $fileName;
	}

	private function _getCCPhotoPath()
	{
		$urlToCurrentFolder = str_replace(realPath($_SERVER['DOCUMENT_ROOT']), '', dirname(__FILE__));
		$ccPhotoUrl = strtolower(substr($urlToCurrentFolder, 0, strrpos($urlToCurrentFolder, "/")));
		$ccPhotoPath = realpath($_SERVER['DOCUMENT_ROOT'] . $ccPhotoUrl);

		return $ccPhotoPath . '/';
	}
}
?>

