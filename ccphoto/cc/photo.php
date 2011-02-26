<?php
/**
 * @category   Image Stripper
 * @author     Daniel Lindh <daniel@cybercow.se>
 * @since      1.0.0
 */

require_once "image.php";

/**
 *
 */
class photo
{
	public function photo($settings_, $imageUrl_, $fileName_)
	{
		$this->_settings = $settings_;
		$this->_setTitleFromFileName($fileName_);

		$this->_imagePath = $this->_settings->getAlbumPath() . ltrim($imageUrl_, '/');

		$this->_thumb = new image
		(
			$this->_imagePath,
			$this->_settings->getThumbPath($imageUrl_),
			$this->_settings->getThumbUrl($imageUrl_),
			$this->_settings->getThumbMaxWidth(),
			$this->_settings->getThumbMaxHeight()
		);

		$this->_image = new image
		(
			$this->_imagePath,
			$this->_settings->getImagePath($imageUrl_),
			$this->_settings->getImageUrl($imageUrl_),
			$this->_settings->getImageMaxWidth(),
			$this->_settings->getImageMaxHeight()
		);
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function getThumbUrl()
	{
		return $this->_thumb->getUrl();
	}

	public function getImageUrl()
	{
		return $this->_image->getUrl();
	}

	public function getDate()
	{
		return date('Y-m-d H:i', filemtime($this->_imagePath));
	}

	public function getLink()
	{
		return $this->_image->getUrl();
	}

	private function _setTitleFromFileName($fileName_)
	{
		// Remove file extension
		$this->_title = substr($fileName_, 0, strrpos($fileName_, "."));

		// Replace underscore
		$this->_title = str_replace("_", " ", $this->_title);
	}

	private $_title;
	private $_thumb;
	private $_image;
	private $_imagePath;
	private $_link;

	private $_settings;
}
?>
