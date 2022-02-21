window.fbAsyncInit = function() {
    FB.init({
      appId      : 'Your APP ID',
      cookie     : true,
      xfbml      : true,
      version    : 'v13.0'
    });
      
    FB.AppEvents.logPageView(); 
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
        });  
  };
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
        });
    }
    function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {
        const token=response.authResponse.accessToken
        // Call API
        fetch(`./api/loginfb.php`,{
            headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/x-www-form-urlencoded'
            },
            method: "POST",
            body: `token=${token}&&type=facebook`
            })
            .then(res=>res.json())
            .then((mess)=>{
                console.log(mess)
                if(mess==0){
                        console.log('error');
                }
                else{
                    render(mess)
                    return;
                }
            }) 
      
    } else {                                 // Not logged into your webpage or we are unable to tell.
     
        console.log("chưa connect")
    }
  }
    //insert script
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

//    // logout
//    FB.logout(function(response) {
//     });


