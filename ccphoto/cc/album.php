<?php
/**
 * @category   Image Stripper
 * @author     Daniel Lindh <daniel@cybercow.se>
 * @since      1.0.0
 */
require_once "photo.php";

/**
 *
 */
class album
{
	public function album($settings_, $albumUrl_, $folderName_)
	{
		$this->_settings = $settings_;
		$this->_photos = array();

		$this->_albumUrl = $albumUrl_;
		$this->_setTitleFromFolderName($folderName_);
	}

	private function _setTitleFromFolderName($folderName_)
	{
		// Replace underscore
		$this->_title = str_replace("_", " ", $folderName_);
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function getPhotos()
	{
		$this->_fetchPhotos();
		return $this->_photos;
	}

	private function _getAlbumPath()
	{
		return $this->_settings->getAlbumPath() . ltrim($this->_albumUrl, '/');
	}

	private function _fetchPhotos()
	{
		if (is_dir($this->_getAlbumPath()))
		{
			$oDir = dir($this->_getAlbumPath());
			while(($fileName = $oDir->read()) !== false)
			{
				if($this->isValidFile($fileName))
				{
					$this->_photos[] = new photo
					(
						$this->_settings,
						$this->_albumUrl . $fileName,
						$fileName
					);
				}
			}
			$oDir->close();
		}
	}

	private function isValidFile($fileName_)
	{
		$fileExtension = strtolower(substr($fileName_, strrpos($fileName_, ".")));

		if
		(
			image::getImageType($fileName_) != false &&
			is_file($this->_getAlbumPath() . '/' . $fileName_)
		)
		{

			return true;
		}
		else
		{
			return false;
		}
	}

	private $_title;
	private $_settings;
}
?>
