<?php 
 
$file_name = $_POST['googledrive_docname'];//if you have pass it, otherwise spacify your name
$new_directory = "tempdir";
$oAuthToken=$_POST['googledrive_token']; 
$fileId=$_POST['googledrivefileid'];

 $basedir="temp"; //make sure you create this directory in you base location, othrwise spacify any folder
		
if (!file_exists($basedir.'/'.$new_directory)) {
	mkdir($basedir.'/'.$new_directory, 0777, true);
	mkdir($basedir.'/'.$new_directory.'/input', 0777, true);
	mkdir($basedir.'/'.$new_directory.'/output', 0777, true);
}

define('FILE_NAME', $basedir.'/'.$new_directory.'/input/'.$file_name);

 
 $targetFile = fopen( $basedir.'/'.$new_directory.'/input/'.$file_name, 'w' );
 
 
 
 
 
    $getUrl = 'https://www.googleapis.com/drive/v2/files/' . $fileId . '?alt=media';
    $authHeader = 'Authorization: Bearer ' . $oAuthToken;
     

    $ch = curl_init($getUrl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'progressCallback' ); //this is what will return progress
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_NOPROGRESS, false );
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [$authHeader]);

    curl_setopt($ch, CURLOPT_FILE, $targetFile );
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_errno($ch);
    curl_close($ch);

fclose( $targetFile );


function progressCallback ($resource, $download_size, $downloaded_size, $upload_size, $uploaded_size)
{ 
	set_time_limit(0);
	error_reporting(0);
	
	
    static $previousProgress = 0;
    
    if ( $download_size == 0 )
        $progress = 0;
    else
        $progress = round( $downloaded_size * 100 / $download_size );
    
    if ( $progress > $previousProgress)
    {
        $previousProgress = $progress;	
		
		$file_size = number_format($download_size/1024/1024,2).'MB';
		$downloaded_size = number_format($downloaded_size/1024/1024,2).'MB';

		
		$json['st']  = 1;
		$json['total']  = 0;
		$json['process']  = 0;
		$json['file_size']  = $file_size;
		$json['downloaded_size']  = $downloaded_size;
		$json['status']  = $progress;
		$json['base_name']  = basename(FILE_NAME);
		$json['file_name']  = FILE_NAME;
		
		
		
		echo json_encode($json).'||';
		
		/* || above will be used to separate each feedback so can be processed by split on js receiving feedback side */
		 
		ob_flush();
        flush();
        sleep(0.5);
		
    }
    
     ob_end_flush();
}


?>