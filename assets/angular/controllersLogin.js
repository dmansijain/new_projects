
'use strict';


function LoginCtrl($scope, $http, $routeParams,$timeout, $window) 
{
	
$scope.logininfo 	= {
	
		id:false,
		username:'',
		password:'',
		
	};
	
	$http.get(BASE_URL+'api/login/getcookiedata')
   .then(function(response) {
	   if(response.data.success == "true") {
		$scope.logininfo = response.data.data;
	   }
	 
    });
$scope.validatelogin = function()
    { 
	
		var fd = new FormData();
        fd.append('username', $scope.logininfo.username);
        fd.append('password', $scope.logininfo.password);
		
        $http({
   method: 'post',
   url: BASE_URL+'api/login/validatelogin',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		console.log(BASE_URL+result.url);
		        $window.location.href = BASE_URL+result.url;
            }
            if(res.data.success == "false")
            {
                $scope.message = res.data.message;
            }            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
}


function ResetPassCtrl($scope, $http, $routeParams,$timeout, $window) 
{ 

$scope.logininfo 	= {
		email:''
		
	};
$scope.resetpassword = function()
    {  
		var fd = new FormData();
        fd.append('email', $scope.logininfo.email);
		
        $http({
   method: 'post',
   url: BASE_URL+'api/login/resetpassword',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		console.log(BASE_URL+result.url);
		        $window.location.href = BASE_URL+result.url;
            }
            if(res.data.success == "false")
            {
                $scope.message = res.data.message;
            }            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
}


