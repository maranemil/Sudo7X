# Sudo7X
Sudo7X Login for Sugar ( minimal functionality which not involve yet REST API)

# Installation
1. Download zip package
2. Unzip and Repack (Zip) as Zip Format for Sugar (zip -r ../Package.zip *) 
```
$ cd Sudo7X-master
$ zip -r ../Package.zip *
```
Upload `Package.zip` through Admin > Module Loader and install it.

# Usage
Simply goto desired user and click on "Login as {username}"

Based On Karl Metum Code: 
https://gist.github.com/karlingen/5265c27ad78fb83fb774

#TODO's
- sudo on REST API
```
{
   "grant_type":"password",
   "client_id":"sugar",
   "client_secret":"",
   "username":"admin",
   "password":"password",
   "platform":"myspecialapp" // change 'myspecialapp' to whatever you want to refer to your app as
}

var username = "someuser";
$.ajax({         
  url: '/rest/v10/oauth2/sudo/' + username,
  headers: { "OAuth-Token": app.api.getOAuthToken() },
  success: function(data)
  {
    console.log(data);
  },
  type: "POST",
  async: false
});
```
