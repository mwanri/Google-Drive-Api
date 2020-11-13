<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Google Drive File Chooser</title>
	
	
    <!-- The Google API Loader script. -->
	
    <script type="text/javascript" src="googledriveapi.js"></script>
	
	
    <script type="text/javascript" src="https://apis.google.com/js/api.js?"></script>
    <script type="text/javascript" src="https://apis.google.com/js/client.js?"></script> 
	
</head>

<body>
	<form id="form" method="post" name="form"> 
	    <!-- u use ajax to prevent default -->
	  <p>
	    
	    <a href="javascript:loadPicker()">Choose google Drive File</a>
	    
	    
      </p>
	  <p>
	    
	    <input name="googledrivefileid" type="text" id="googledrivefileid" placeholder="Selected google drive fileid">
	    <input name="googledrive_token" type="hidden" id="googledrive_token">
		</p> 
	  <p>
	   <a href="javascript:download_googledrive()">Download file</a>
	  </p>
	</form>
	
</body>
</html>
