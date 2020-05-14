'use strict';

var adminapp = angular.module('SoohooAgent',['ngRoute','ngSanitize','ui.bootstrap','ui.utils','datatables']).
        config(['$routeProvider', function ($routeProvider) {
			
                $routeProvider.
                        
						when('/', {
                            templateUrl: BASE_URL+'agent/dashboard',
                            controller: DashboardCtrl,
                            activetab: 'dashboard',
                        }).
						when('/availability', {
                            templateUrl: BASE_URL+'agent/availability',
                            controller: allPageCtrl,
                            activetab: 'availability'
                        }).
						when('/availability/:ID', {
                            templateUrl: BASE_URL+'agent/availability',
                            controller: allPageCtrl,
                            activetab: 'availability'
                        }).
						when('/appointments', {
                            templateUrl: BASE_URL+'agent/appointments',
                            controller: allAppointmentCtrl,
                            activetab: 'appointments'
                        }).
						when('/appointments/:ID', {
                            templateUrl: BASE_URL+'agent/appointments',
                            controller: allAppointmentCtrl,
                            activetab: 'appointments'
                        }).
						when('/user-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'agent/editUser';
							},
                            controller: editUserCtrl,
                            activetab: 'user-edit'
                        }).
						
                        otherwise({redirectTo: '/agentdashboard'});
            }]).run(['$rootScope', '$http', '$browser', '$timeout', "$route", "$window",'Auth', function ($scope, $http, $browser, $timeout, $route, $window, Auth) {

        $scope.$on('$routeChangeStart', function (event) {
			// if (!Auth.isLoggedIn()) {
            // console.log('DENY');
            // event.preventDefault();
            // $window.location.href= BASE_URL;
       // }
       // else {
            // console.log('ALLOW');
           // $window.location.href= '#!/dashboard';
       // }
            $scope.isRouteLoading = true;            
        });

        $scope.$on("$routeChangeSuccess", function (scope, next, current) {
			
            $scope.part = $route.current.activetab;
        });

    }]);

//

adminapp.config(['$locationProvider', function ($location) {
        $location.hashPrefix('!');
        //$location.html5Mode(true);
    }]);

//navCtrl definition
adminapp.factory('Auth', function(){
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
	
adminapp.directive('ngFile', ['$parse', function ($parse) {
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

adminapp.controller('navCtrl',function($scope, $route) {
   $scope.$route = $route;
});


	
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

function deletepage(id) {
	if(confirm("Are you sure you want to remove it?"))
		{
	var myKeyVals = { 'id' : id };
	$.ajax({
            type: 'post',
            url: BASE_URL+'api/pages/deletePage',
            data: myKeyVals,
            success: function (res) {
			location.reload();	
			
            }
		}); 
		}
    
}

function deleteTestimonial(id) {
	if(confirm("Are you sure you want to remove it?"))
		{
	var myKeyVals = { 'id' : id };
	$.ajax({
            type: 'post',
            url: BASE_URL+'api/testimonials/deleteTestimonial',
            data: myKeyVals,
            success: function (res) {
			location.reload();	
			
            }
		}); 
		}
    
}
function deleteSlider(id) {
	if(confirm("Are you sure you want to remove it?"))
		{
	var myKeyVals = { 'id' : id };
	$.ajax({
            type: 'post',
            url: BASE_URL+'api/sliders/deleteSlider',
            data: myKeyVals,
            success: function (res) {
			location.reload();	
			
            }
		}); 
		}
    
}

function deleteCategory(id) {
	if(confirm("Are you sure you want to remove it?"))
		{
	var myKeyVals = { 'id' : id };
	$.ajax({
            type: 'post',
            url: BASE_URL+'api/categories/deleteCategory',
            data: myKeyVals,
            success: function (res) {
			location.reload();	
			
            }
		}); 
		}
    
}

function deleteProduct(id) {
	if(confirm("Are you sure you want to remove it?"))
		{
	var myKeyVals = { 'id' : id };
	$.ajax({
            type: 'post',
            url: BASE_URL+'api/products/deleteProduct',
            data: myKeyVals,
            success: function (res) {
			location.reload();	
			
            }
		}); 
		}
    
}