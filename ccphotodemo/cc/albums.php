<?php
/**
 * @category   Image Stripper
 * @author     Daniel Lindh <daniel@cybercow.se>cow
 * @since      1.0.0
 */

require_once "settings.php";
require_once "album.php";

/**
 *
 */
class albums
{
	public function albums($url_)
	{
		$this->_settings = new settings($url_);
	}

	function getAlbums()
	{
		$this->_fetchSubFolders();

		return $this->_folders;
	}

	private function _fetchSubFolders($path_ = '/')
	{
		if (is_dir($this->getPath($path_)))
		{
			$oDir = dir($this->getPath($path_));
			while(($sDir = $oDir->read()) !== false)
			{
				if($this->isValidDir($path_ , $sDir))
				{
					$fullPath = $path_ . $sDir . '/';

					// Only add the deepest folder.
					if($this->_fetchSubFolders($fullPath))
					{
						$this->_folders[] = new album
						(
							$this->_settings,
							$fullPath,
							trim(str_replace('/', ' ', $fullPath))
						);
					}
				}
			}

			$oDir->close();
		}

		return empty($fullPath);
	}

	private function isValidDir($path_, $sDir_)
	{
		if
		(
			$sDir_ != '.' &&
			$sDir_ != '..' &&
			substr($sDir_,0, 1) != '_' &&
			substr($sDir_,0, 1) != '.'	&&
			is_dir($this->getPath($path_) . $sDir_)
		)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getPath($folder_)
	{
		return $this->_settings->getAlbumPath() . $folder_;
	}

	private $_url;
	private $_folders = array();
	private $_settings;
}
?>
