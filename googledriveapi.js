 

	function download_googledrive(){
	      
         	 if($('#googledrivefileid').val() == ''){
         		 alert('please insert google drive file id');
         		 return false;
         	  }
         	 	
         	 	//add your progress bar staffs here
				//below codes listen for http feedback from download.php for progress bar
         	 
         	  var http = new XMLHttpRequest();
         	  var url = 'download.php';
         		var params = $('#form').serialize();
         		http.open('POST', url, true);
         
         		//  //Send the proper header information along with the request
         		http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
         
         		http.onreadystatechange = function() {//Call a function when the state changes.
         			if(http.readyState == 4 && http.status == 200) {
         					//alert(http.responseText);
         			}
         			 
         			var res =  http.responseText; //handle response wherever you want
                            
         			 /* process res, check if is 100% then do whatever */
         
         
         			if (this.readyState == 4 && this.status == 200) {
         
         				// do ur staffs
         			}
         			
         			
         			
         			
         		}
         		http.send(params);
         	  
         	 
	}	
	


      // Client ID and API key from the Developer Console, create yours before you proceed
      var clientId = '34435345645345-gkpob8fds7uco9ikbdcvl72o5jf7k1aq.apps.googleusercontent.com';
      var developerKey = 'AIzaSsdFSDFsdfAm9CmfIS3F0tyrDXhdiTtGQ';
 

    // Replace with your own project number from console.developers.google.com.
    // See "Project number" under "IAM & Admin" > "Settings"
//    var appId = "1234563237890";

    // Scope to use to access user's Drive items. go to google console and create Oauth
    var scope = ['https://www.googleapis.com/auth/drive'];

    var pickerApiLoaded = false;
    var oauthToken;


      // Use the Google API Loader script to load the google.picker script.
    function loadPicker() {  
      gapi.load('auth', {'callback': onAuthApiLoad});
      gapi.load('picker', {'callback': onPickerApiLoad});
    }


        function onAuthApiLoad() { 
          window.gapi.auth.authorize(
              {
                'client_id': clientId,
                'scope': scope,
                'immediate': false
              },
              handleAuthResult);
        }

        function handleAuthResult(authResult) { 
              if (authResult && !authResult.error) {
                oauthToken = authResult.access_token; 
                createPicker();
              }else{
                  //alert("handleAuthResult Error: "+authResult.error);
              }
        }


    function onPickerApiLoad() { 
        pickerApiLoaded = true;
        createPicker();
      }
      
      // Create and render a Picker object for selecting from Google Drive
    function createPicker() { 
        if (pickerApiLoaded && oauthToken) { 
          var picker = new google.picker.PickerBuilder().
              addView(google.picker.ViewId.DOCS).
              setOAuthToken(oauthToken).
              setDeveloperKey(developerKey).
              setCallback(pickerCallback).
              build();
          picker.setVisible(true);
        }
      }
    
    var docname="";
	// A simple callback implementation.
    function pickerCallback(data) {
        var url = 'nothing';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
          var doc = data[google.picker.Response.DOCUMENTS][0];
          url = doc[google.picker.Document.URL];
          var id=doc[google.picker.Document.ID];
          docname=doc[google.picker.Document.NAME];
        // alert('load...');
          
                document.getElementById("googledrivefileid").value=id;
                document.getElementById("googledrive_token").value=oauthToken;
//                document.getElementById("googledrive_docname").value=docname; add if you need it
              
           
        }
      }	  
	 
 
		 
	  


