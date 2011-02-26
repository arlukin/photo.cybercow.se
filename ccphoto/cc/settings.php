<?php
/**
 * All variables including a folder path/url should end with trailing /.
 * 	/var/www/
 *
 */

define('ENLARGE_SMALL_IMAGES', FALSE);
define('JPEG_QUALITY', 75);

class settings
{
	public function settings($albumUrl_)
	{
		// Settings that can be modified by user.
		$this->_imageMaxWidth = 1600;
		$this->_imageMaxHeight = 1200;
		$this->_thumbMaxWidth = 160;
		$this->_thumbMaxHeight = 160;

		// Programatic settings, user should not touch.
		$this->_setCacheUrl();
		$this->_setAlbumPath($albumUrl_);
	}

	public function getAlbumPath()
	{
		return $this->getDocumentRoot() . ltrim($this->_albumUrl, '/');
	}

	public function getThumbPath($url_)
	{
		return $this->getDocumentRoot() . ltrim($this->getThumbUrl($url_), '/');
	}

	public function getThumbUrl($url_)
	{
		$thumbUrl =  $this->_cacheUrl . $this->_thumbMaxWidth . 'x' . $this->_thumbMaxHeight . $this->_orginalAlbumUrl. trim($url_, '/');;
		return $this->_replaceInvalidsFileCharacters($thumbUrl);
	}

	public function getImagePath($url_)
	{
		return $this->getDocumentRoot() . ltrim($this->getImageUrl($url_), '/');
	}

	public function getImageUrl($url_)
	{
		$imageUrl = $this->_cacheUrl . $this->_imageMaxWidth . 'x' . $this->_imageMaxHeight . $this->_orginalAlbumUrl . trim($url_, '/');
		return $this->_replaceInvalidsFileCharacters($imageUrl);
	}

	public function getImageMaxWidth()
	{
		return $this->_imageMaxWidth;
	}

	public function getImageMaxHeight()
	{
		return $this->_imageMaxHeight;
	}

	public function getThumbMaxWidth()
	{
		return $this->_thumbMaxWidth;
	}

	public function getThumbMaxHeight()
	{
		return $this->_thumbMaxHeight;
	}

	private function _setCacheUrl()
	{
		$this->_cacheUrl = $this->_getCCPhotoUrl() . 'cache/';
	}

	private function _getCCPhotoUrl()
	{
		$urlToCurrentFolder = str_replace(realPath($_SERVER['DOCUMENT_ROOT']), '', dirname(__FILE__));

		$ccPhotoUrl = strtolower(substr($urlToCurrentFolder, 0, strrpos($urlToCurrentFolder, "/")));

		return $ccPhotoUrl . '/';
	}

	private function _setAlbumPath($albumUrl_)
	{
		$this->_orginalAlbumUrl = '/' . trim($albumUrl_, '/') . '/';
		$this->_albumUrl = $this->_getCCPhotoUrl() . 'data' . $this->_orginalAlbumUrl;

		if (!is_dir($this->getAlbumPath()))
		{
			$this->_albumUrl = $this->_cacheUrl . $this->_imageMaxWidth . 'x' . $this->_imageMaxHeight . $this->_orginalAlbumUrl;

			if (!is_dir($this->getAlbumPath()))
			{
				die('No existing folder.');
			}
		}
	}

	private function getDocumentRoot()
	{
		return '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/';
	}

	private function _replaceInvalidsFileCharacters($url_)
	{
		$search  = array(" ", "å", "ä", "ö", "Å", "Ä", "Ö");
		$replace = array("_", "a", "a", "o", "a", "a", "o");

		return str_replace($search, $replace, $url_);
	}

	private $_albumUrl;
}
?>
