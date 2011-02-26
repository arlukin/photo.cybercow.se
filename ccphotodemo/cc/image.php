<?php
class image
{
	function image($orginalPath_, $path_, $url_,  $width_, $height_)
	{
		$this->_orginalPath = $orginalPath_;
		$this->_path = $path_;
		$this->_url = $url_;

		$this->_width = $width_;
		$this->_maxHeight = $height_;
	}

	function getUrl()
	{
		$this->generateImages();
		return $this->_url;
	}

	public function generateImages()
	{
    if (!file_exists($this->_path))
    {
    	$image = $this->_getImageHandle($this->_orginalPath);
     	if (is_resource($image))
     	{
				$newImage = $this->_getNewImageHandleFromImage($image);
				$this->_saveNewImage($this->_path, $newImage);

				imagedestroy($image);
				imagedestroy($newImage);
			}
    }
	}

	private function _getImageHandle($imagePath_)
	{
		$image = NULL;
		$imgType = $this->getImageType($imagePath_);
		if ($imgType == "jpeg")
		{
			$image = @imagecreatefromjpeg($imagePath_);
		}
		elseif ($imgType == "png")
		{
			$image = @imagecreatefrompng($imagePath_);
		}
		elseif ($imgType == "gif")
		{
			$image = @imagecreatefromgif($imagePath_);
		}

		return $image;
	}

	private function _getNewImageHandleFromImage($image)
	{
		$imageSize = getimagesize($this->_orginalPath);
		$imageWidth = $imageSize[0];
		$imageHeight = $imageSize[1];
		if (($imageWidth < $this->_width) and ($imageHeight < $this->_maxHeight) and !ENLARGE_SMALL_IMAGES)
		{
			$newImageHeight = $imageHeight;
			$newImageWidth = $imageWidth;
		}
		else
		{
			$aspectX = $imageWidth / $this->_width;
			$aspectY = $imageHeight / $this->_maxHeight;
			if ($aspectX > $aspectY)
			{
				$newImageWidth = $this->_width;
				$newImageHeight = $imageHeight / $aspectX;
			}
			else
			{
				$newImageHeight = $this->_maxHeight;
				$newImageWidth = $imageWidth / $aspectY;
			}
		}
		$newImage = @imagecreatetruecolor($newImageWidth, $newImageHeight);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newImageWidth, $newImageHeight, imagesx($image), imagesy($image));

		return $newImage;
	}

	private function _saveNewImage($path_, $image_)
	{
		if (!is_dir(dirname($path_)))
		{
			mkdir(dirname($path_), 0777, true);
		}

		$imgType = $this->getImageType($path_);
		if ($imgType == "jpeg")
		{
			imagejpeg($image_, $path_, JPEG_QUALITY);
		}
		elseif ($imgType == "png")
		{
			imagepng($image_, $path_);
		}
		elseif ($imgType == "gif")
		{
			imagegif($image_, $path_);
		}
	}

  public function getImageType($file)
  {
    $type = strtolower(substr($file, strrpos($file, ".")));
    if (($type == ".jpg") or ($type == ".jpeg"))
    {
      return "jpeg";
    }
    elseif ($type == ".png")
    {
      return "png";
    }
    elseif ($type == ".gif")
    {
      return "gif";
    }
    return FALSE;
  }
}
?>
