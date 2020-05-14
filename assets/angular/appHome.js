'use strict';

var homeapp = angular.module('LiminalHomes',['ngRoute','ngSanitize','ui.bootstrap','ui.utils','datatables','ngMaterial','ngMessages']).filter('slugify', Filter).filter('slugencry', EncFilter).config(['$routeProvider', '$locationProvider', function ($routeProvider,$locationProvider) {
	
                $routeProvider.
                        
						when('/', {
                            templateUrl: BASE_URL+'home/home',
                            controller: HomeCtrl,
                            activetab: 'home',
                        }).
						when('/home', {
                            templateUrl: BASE_URL+'home/home',
                            controller: HomeCtrl,
                            activetab: 'home'
                        }).
						when('/churches', {
                            templateUrl: BASE_URL+'home/churches',
                            controller: ChurchesCtrl,
                            activetab: 'churches'
                        }).
						when('/mens', {
                            templateUrl: BASE_URL+'home/mens',
                            controller: MensCtrl,
                            activetab: 'mens'
                        }).
						when('/womens', {
                            templateUrl: BASE_URL+'home/womens',
                            controller: WomensCtrl,
                            activetab: 'womens'
                        }).
						when('/couples', {
                            templateUrl: BASE_URL+'home/couples',
                            controller: CouplesCtrl,
                            activetab: 'couples'
                        }).
						when('/success', {
                            templateUrl: BASE_URL+'home/success',
                            controller: EventSuccessCtrl,
                            activetab: ''
                        }).
						when('/eventlist', {
                            templateUrl: BASE_URL+'home/eventlist',
                            controller: EventlistCtrl,
                            activetab: 'eventlist'
                        }).
						when('/myprofile/eventlist/:eventType', {
                            templateUrl: BASE_URL+'customer/eventlist',
                            controller: ProfileEventlistCtrl,
                            activetab: 'eventlist'
                        }).
						when('/eventdetail/:ID', {
                            templateUrl: BASE_URL+'home/eventdetail',
                            controller: EventdetailCtrl,
                            activetab: 'eventlist'
                        }).
						when('/billing/:ID', {
                            templateUrl: BASE_URL+'checkout/billing',
                            controller: EventbillingCtrl,
                            activetab: 'billing'
                        }).
						when('/payment/:ID/:OrderID', {
                            templateUrl: BASE_URL+'checkout/payment',
                            controller: EventPaymentCtrl,
                            activetab: 'payment'
                        }).
						when('/healthinfo/:ID/:OrderID', {
                            templateUrl: BASE_URL+'checkout/healthinfo',
                            controller: EventHealthinfoCtrl,
                            activetab: 'healthinfo'
                        }).
						when('/agreements/:ID/:OrderID', {
                            templateUrl: BASE_URL+'checkout/agreements',
                            controller: EventAgreementsCtrl,
                            activetab: 'agreements'
                        }).
						when('/notifications/:ID/:OrderID', {
                            templateUrl: BASE_URL+'checkout/notifications',
                            controller: EventNotificationCtrl,
                            activetab: 'notifications'
                        }).
						
						when('/myprofile', {
                            templateUrl: BASE_URL+'customer/myprofile',
                            controller: MyprofileCtrl,
                            activetab: 'myprofile'
                        }).
						when('/myprofile/rewards', {
                            templateUrl: BASE_URL+'customer/myrewards',
                            controller: MyrewardsCtrl,
                            activetab: 'myrewards'
                        }).
						when('/myprofile/skills', {
                            templateUrl: BASE_URL+'customer/myskills',
                            controller: MyskillsCtrl,
                            activetab: 'myskills'
                        }).
						when('/myprofile/changepassword', {
                            templateUrl: BASE_URL+'customer/changepassword',
                            controller: ChangePasswordCtrl,
                            activetab: 'myprofile'
                        }).
						when('/myprofile/event', {
                            templateUrl: BASE_URL+'customer/myevent',
                            controller: MyeventCtrl,
                            activetab: 'myevent'
                        }).
						when('/myprofile/healthinfo', {
                            templateUrl: BASE_URL+'customer/healthinfo',
                            controller: MyhealthinfoCtrl,
                            activetab: 'myhealthinfo'
                        }).
						when('/myprofile/journey', {
                            templateUrl: BASE_URL+'customer/myjourney',
                            controller: MyjourneyCtrl, 
                            activetab: 'myjourney'
                        }).
						when('/myprofile/group', {
                            templateUrl: BASE_URL+'customer/mygroup',
                            controller: MygroupCtrl, 
                            activetab: 'mygroup'
                        }).
						when('/mygroup/send_mail/:ID', {
                            templateUrl: BASE_URL+'customer/group_mail',
                            controller: GroupMailCtrl,
                            activetab: 'healthinfo'
                        }).
						when('/myprofile/results', {
                            templateUrl: BASE_URL+'customer/myresults',
                            controller: MyresultsCtrl, 
                            activetab: 'myresults'
                        }).
						when('/about', {
                            templateUrl: BASE_URL+'home/about',
                            controller: AboutCtrl,
                            activetab: 'about'
                        }).
						when('/contact', {
                            templateUrl: BASE_URL+'home/contact',
                            controller: ContactCtrl,
                            activetab: 'contact'
                        }).
						when('/logout', {
                            templateUrl: BASE_URL+'home/logout',
							controller: LogoutCtrl,
                        }).
						when('/depositepay/:ID', {
                            templateUrl: BASE_URL+'customer/depositePayment',
                            controller: EventDepositePaymentCtrl,
                            activetab: 'pay'
                        }).
						
                        otherwise({redirectTo: '/home'});
						$locationProvider.html5Mode(true);
            }]).run(['$rootScope', '$http', '$browser', '$timeout', "$route", "$window",'Auth', function ($scope, $http, $browser, $timeout, $route, $window, Auth) {

        $scope.$on('$routeChangeStart', function (event) {
			
            $scope.isRouteLoading = true;            
        });

        $scope.$on("$routeChangeSuccess", function (scope, next, current) {
			
            $scope.part = $route.current.activetab;
			
        });

    }]);

//

homeapp.config(['$locationProvider', function ($location) {
        //$location.hashPrefix('!');
        $location.html5Mode({ enabled: true,  requireBase: false});
		
		
    }]);

//navCtrl definition
homeapp.factory('Auth', function(){
var user;

return{
    setUser : function(aUser){
        user = aUser;
    },
    isLoggedIn : function(){
        return(user)? user : false;
    }
  }
})

homeapp.directive('ngFile', ['$parse', function ($parse) {
 return {
  restrict: 'A',
  link: function(scope, element, attrs) {
   element.bind('change', function(){

    $parse(attrs.ngFile).assign(scope,element[0].files)
    scope.$apply();
   });
  }
 };
}]);

function Filter() {
        return function (input) {
            if (!input)
                return;

            // make lower case and trim
            var slug = input.toLowerCase().trim();

            // replace invalid chars with spaces
            slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

            // replace multiple spaces or hyphens with a single hyphen
            slug = slug.replace(/[\s-]+/g, '-');

            return slug;
        };
    }
	
	
function EncFilter() {
        return function (id) {
            if (!id)
                return;

            var qry = id.toString();
			
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		
		var str = encrypted.toString();
			return str;
        };
    }
function LogoutCtrl($scope, $http, $routeParams,$timeout, $window) 
{
	
$window.location.href = BASE_URL;
           
}	

homeapp.controller('navCtrl',function($scope, $route, $http) {
	
   $scope.$route = $route;
   $http.get(BASE_URL+'api/pages/settingsDetail')
   .then(function(response) {
      $scope.settingsinfo = response.data.data;
	 
    });
	
});

homeapp.controller('LoginCtrl',function($scope, $http, $routeParams,$timeout, $window,$location) {
   $scope.logininfo 	= {
		id:false,
		username:'',
		password:'',
		rememberme:false,
		
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
		fd.append('rememberme', $scope.logininfo.rememberme);
		fd.append('redirect_url', $location.path());
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
});
homeapp.controller('RegisterCtrl',function($scope, $http, $routeParams,$timeout, $window) {
	$scope.registrationinfo 	= {
		id:"",
		first_name:'',
		last_name:'',
		email:'',
		phone:'',
		password:'',
		confirmpassword:'',
		address:'',
		profilepic:'',
		city:'',
		state:'',
		zip:'',
		active:1
		
	};
	$scope.formName  = 'editform';
$scope.editproduct = function()
    {
		var user_id = $scope.registrationinfo.id!=undefined ? $scope.registrationinfo.id :''; 
		var fd = new FormData();
		angular.forEach($scope.profilepic,function(profilepic){
  fd.append('profilepic', profilepic);
 });

        fd.append('user_id', user_id);
		fd.append('email', $scope.registrationinfo.email);
		fd.append('first_name', $scope.registrationinfo.first_name);
		fd.append('last_name', $scope.registrationinfo.last_name);
		fd.append('password', $scope.registrationinfo.password);
		fd.append('confirmpassword', $scope.registrationinfo.confirmpassword);
		fd.append('phone', $scope.registrationinfo.phone);
		fd.append('address', $scope.registrationinfo.address);
		fd.append('city', $scope.registrationinfo.city);
		fd.append('state', $scope.registrationinfo.state);
		fd.append('zip', $scope.registrationinfo.zip);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/user/registration',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		   if(user_id==""){
		        $scope.registrationinfo={};
		    }
                $scope.rmessage = res.data.message;
            }
                        
        },function(error) 
        {
            
                $scope.rmessage = error.data.error;
            
        });
    }
	
	
	
});

homeapp.controller('ResetPassCtrl',function($scope, $http, $routeParams,$timeout, $window) {
	
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
	
	
});


homeapp.controller('TestimonialCtrl', function($scope, $route, $http) {
	 $scope.owlOptionsTestimonials = {
            navigation: true, 
			autoplay: true, 
			pagination: true, 
			rewindNav : false,
			  responsiveClass: true,
				responsive: {
					0:{
					  items: 1
					},
					480:{
					  items: 1
					},
					769:{
					  items: 3
					}
				}
        }
	 $http.get(BASE_URL+'api/testimonial/getallActivetestimonials')
   .then(function(response) {
      $scope.items1 = response.data.data;
	 
    });
  
 
}).directive("owlCarousel", function() {
    return {
        restrict: 'E',
        transclude: false,
        link: function (scope) {
            scope.initCarousel = function(element) {
              // provide any default options you want
                var defaultOptions = {
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for(var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
    };
})
.directive('owlCarouselItem', [function() {
    return {
        restrict: 'A',
        transclude: false,
        link: function(scope, element) {
          // wait for the last item in the ng-repeat then call init
            if(scope.$last) {
                scope.initCarousel(element.parent());
            }
        }
    };
}]);
	
function uploadPreview(id) {
	
    $("input[id='upload_image"+id+ "']").click();
}

function showPreview(objFileInput) {
	
    if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
			$("#targetLayer").html('<img src="'+e.target.result+'" />');
        }
		fileReader.readAsDataURL(objFileInput.files[0]);
    }
}
