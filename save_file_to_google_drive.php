<?php 
 
$filename="sample.mkv";
$dpath="path to your file in server";

 /* if you have installed google drive client manually */
 /* then make sure you point to correct autoload.php dir */
 /* also if in current environment you cant use/install via */
 /* composer, then you can install it any where in any pc, */
 /* then just copy the whole vendor folder from that pc and */
 /* put it where you want */

 require 'vendor/autoload.php';

$token=$_POST['googledrive_token']; //in my case i get token from js


//create a Google OAuth client
$client = new Google\Client();

$client->setClientId('616764234234974608-gkpob8fds7asdfuco9ikbdcvl72o5jf7k1aq.apps.googleusercontent.com');
$client->setClientSecret('AIzaSyCzasdASDFAsdfsd355hpILqmjRAm9CmfIS3F0tyrDXhdiTtGQ');
$redirect = filter_var('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));

$client->setAccessToken($token);
 
 
 $service = new Google_Service_Drive($client);
 $ftype='video/'.pathinfo($filename); //depends on your file type, you can write any type eg. 'plaintext/text'
 
    //Insert a file
    $file = new Google_Service_Drive_DriveFile();
    $file->setName($filename);
    $file->setDescription('created from fileconverter');
    $file->setMimeType($ftype);
 
  $filePath =$dpath;
  $chunkSizeBytes = 1 * 1024 * 1024;
 
 
 
  // Call the API with the media upload, defer so it doesn't immediately return.
    $client->setDefer(true);
    $request = $service->files->create($file);


// Create a media file upload to represent our upload process.
$media = new Google_Http_MediaFileUpload(
  $client,
  $request,
  $ftype,
  null,
  true,
  $chunkSizeBytes
);

$media->setFileSize(filesize($filePath));

$total_size=filesize($filePath);

  $status = false;
  $handle = fopen($filePath, "rb");
  $total_chunk_number = ceil($total_size / $chunkSizeBytes);
  $i=0;
  while (!$status && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status = $media->nextChunk($chunk);
	  
      $i+=1;
      $prog=round(($i/$total_chunk_number));
        
      echo("##".$prog."##"); //this shall be echod for progress purpose
    
  }

  fclose($handle);
  $client->setDefer(false);
   
        
echo ("##100##");
exit();

 


?>