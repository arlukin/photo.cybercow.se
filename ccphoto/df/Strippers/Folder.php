<?php
/**
 * @category   Image Stripper
 * @author     Daniel Lindh <daniel@cybercow.se>
 * @since      1.0.0
 */


require_once "ImageFetcher.php";
require_once "../cc/albums.php";
require_once "../cc/functions.php";

if (!isSafeMode())
{
	set_time_limit(0);
}

ini_set('memory_limit', '50000000');


/**
 * This class strips images from a folder in the filesystem based on folder path.
 * @since 14 april 2009
 * @version 1.0.0
 */
class Strippers_Folder extends ImageFetcher
{
	public function Strippers_Folder($url)
	{
		$albums = new albums($url);
		foreach($albums->getAlbums() as $album)
		{
			foreach($album->getPhotos() as $photo)
			{
				$this->_addPhoto($album, $photo);
			}
		}
		ksort($this->photos);
	}

	private function _addPhoto($album_, $photo_)
	{
		$this->photos[$album_->getTitle()][] = array
		(
			'title' => $photo_->getTitle(),
			'thumb' => $photo_->getThumbUrl(),
			'image' => $photo_->getImageUrl(),
			'date'  => $photo_->getDate(),
			'link'  => $photo_->getLink(),
		);
	}
}
?>
