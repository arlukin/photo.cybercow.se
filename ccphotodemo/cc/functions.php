<?php

/*
 * Returns true if PHP is in safe_mode.  Defaults to 'true' because
 * this will use ini_get which may be disabled.  If ini_get is disabled
 * then we are probably in safe_mode
 */
function isSafeMode()
{
	$retval = true;
	if (function_exists('ini_get'))
	{
		if (ini_get('safe_mode')==true)
		{
			$retval = true;
		}
		else
		{
			$retval = false;
		}
	}
	else
	{
		$retval = true;
	}

	return $retval;
}

function printError($title_)
{
	$errors = error_get_last();
	if (!empty($errors['type']))
	{
		echo "ERROR $title_: " . $errors['type'] . ' ' . $errors['message'] . '<br><br>';
		exit;
	}
}

function deletefolder($path)
{
	if ($handle=opendir($path))
	{
		while (false!==($file=readdir($handle)))
		{
			if ($file<>"." AND $file<>"..")
			{
				$realPath = $path.'/'.$file;
				echo "EVALUTATE " .$realPath  . "<br>";

				if (is_file($realPath) || is_link($realPath))
				{
					echo "unlink $realPath<br>";
					if (!@unlink($realPath))
					{
						printError('unlink');
					}
				}
				elseif (is_dir($realPath))
				{
					deletefolder($realPath);
				}
				else
				{
					echo "cantfint $realPath <br>";
				}
			}
		}

		echo "rmdir $path <br>";
		if (!@rmdir($path))
		{
			printError('rmdir');
		}
	}
}

function copyRecursive($from_, $to_)
{
	if (is_dir($from_))
	{
		if (!file_exists($to_))
		{
			echo "mkdir $to_<br>";
			if (!mkdir($to_, 0777, true)) printError('mkdir');
		}

		$oDir = dir($from_);
		while(($sDir = $oDir->read()) !== false)
		{
			$fromPath =  $from_ . $sDir;
			$toPath =  $to_ . $sDir;

			if ($sDir == '.' || $sDir == '..' )
			{
			}
			elseif (is_file($fromPath))
			{
				if (!file_exists($toPath_))
				{
					echo "copy to $toPath<br>";

					if (!copy($fromPath, $toPath)) printError('copy');
					if (!chmod($toPath, 0777)) printError('file chmod');
				}
			}
			elseif (is_dir($fromPath))
			{
				copyRecursive($fromPath . '/', $toPath . '/');
			}
			else
			{
				echo "dontfind $fromPath to $toPath<br>";
			}
		}
	}
	else
	{
		echo $from_ . ' is not a directory<br>';
	}
}
?>
