<?php
include_once("include/session.php");

if(!($session->logged_in)){
  header("Location: main.php");
} else {

/* creates a compressed zip file */
function create_zip($files = array(),$savedirectory = '',$overwrite = false) {
      $downloadqueue = 0;
      $destination = $savedirectory.'UPAC_Cinema_Download'.strval($downloadqueue).'.zip';
      while(file_exists($destination)) {
        $downloadqueue = $downloadqueue + 1;
        $destination = $savedirectory.'UPAC_Cinema_Download'.strval($downloadqueue).'.zip';
      }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
      
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		if(file_exists($destination)) {
              return 'UPAC_Cinema_Download'.strval($downloadqueue).'.zip';
            } else {
              return false;
            }
	}
	else
	{
		return false;
	}
}

    if($_POST) {
      if($session->isAdmin()) {
        $savedir = '/home/cinema/files/publicity/';
      } elseif($session->isChair()) {
        $savedir = '/home/cinema/files/chair/';
      } elseif($session->isFriday()) {
        $savedir = '/home/cinema/files/fnc/';
      } elseif($session->isSaturday()) {
        $savedir = '/home/cinema/files/snc/';
      } elseif($session->isMidweek()) {
        $savedir = '/home/cinema/files/midweek/';
      } elseif($session->isRep()) {
        $savedir = '/home/cinema/files/rep/';
      } elseif($session->isProj()) {
        $savedir = '/home/cinema/files/projectionists/';
      }
      foreach($_POST['dfile'] as $id => $filename) {
        if (array_key_exists('download', $_POST) and array_key_exists($id, $_POST['download'])) {
          $files_to_download[] = $savedir.$filename;
        }
        if (array_key_exists('delete', $_POST) and array_key_exists($id, $_POST['delete'])) {
          unlink($savedir.$filename);
        }
      }
      
      $result = create_zip($files_to_download, $savedir);
      if($result !== false) {
        header("Location: download.php?download_file=$result");
      } else {
        header("Location: managefiles.php");
      }
    }
}
?>