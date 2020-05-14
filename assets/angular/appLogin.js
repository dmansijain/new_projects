'use strict';

var app = angular.module('AdminLogin',['ngRoute','ngSanitize']).
        config(['$routeProvider', function ($routeProvider) {
                $routeProvider.
                        when('/', {
							templateUrl: function(urlattr){
							return BASE_URL+'login/loginform';
							},
                            //templateUrl: BASE_URL+'login/index',
                            controller: LoginCtrl,
                            activetab: 'login'
                        }).
						when('/reset-password', {
							templateUrl: function(urlattr){
							return BASE_URL+'login/resetpassword';
							},
                            //templateUrl: BASE_URL+'login/index',
                            controller: ResetPassCtrl,
                            activetab: 'reset-password'
                        }).
						
						
                        otherwise({redirectTo: '/'});
            }]).run(['$rootScope', '$http', '$browser', '$timeout', "$route", function ($scope, $http, $browser, $timeout, $route) {

        $scope.$on('$routeChangeStart', function () {
            $scope.isRouteLoading = true;            
        });

        $scope.$on("$routeChangeSuccess", function (scope, next, current) {
			
            $scope.part = $route.current.activetab;
        });

    }]);

//

app.config(['$locationProvider', function ($location) {
        $location.hashPrefix('!');
        //$location.html5Mode(true);
    }]);

//navCtrl definition

	
app.directive('ngFile', ['$parse', function ($parse) {
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

app.controller('navCtrl',function($scope, $route) {
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