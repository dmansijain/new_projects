'use strict';

var adminapp = angular.module('LiminalAdmins',['ngRoute','ngSanitize','ngAutocomplete','ui.bootstrap','ui.utils','datatables','datatables.tabletools','ngMaterial','ngMessages','md.time.picker']).
        config(['$routeProvider', function ($routeProvider) {
			
                $routeProvider.
                        
						when('/', {
                            templateUrl: BASE_URL+'admin/dashboard',
                            controller: DashboardCtrl,
                            activetab: 'dashboard',
                        }).
						when('/all-pages', {
                            templateUrl: BASE_URL+'admin/pages',
                            controller: allPageCtrl,
                            activetab: 'all-pages'
                        }).
						when('/page-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/editPage';
							},
                            controller: editPageCtrl,
                            activetab: 'all-pages'
                        }).
						when('/all-events', {
                            templateUrl: BASE_URL+'admin/events',
                            controller: allEventCtrl,
                            activetab: 'all-events'
                        }).
						when('/event-detail/:ID', {
                            templateUrl: BASE_URL+'admin/eventDetail',
                            controller: EventdetailCtrl,
                            activetab: 'all-events'
                        }).
						when('/event-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/editEvent';
							},
                            controller: editEventCtrl,
                            activetab: 'all-events'
                        }).
						when('/all-rosters/:ID', {
                            templateUrl: BASE_URL+'admin/rosters',
                            controller: allRosterCtrl,
                            activetab: 'all-rosters'
                        }).
						when('/roster-detail/:ID', {
                            templateUrl: BASE_URL+'admin/rosterDetail',
                            controller: RosterDetailCtrl,
                            activetab: 'all-rosters'
                        }).
						when('/all-skills', {
                            templateUrl: BASE_URL+'admin/skills',
                            controller: allSkillCtrl,
                            activetab: 'all-skills'
                        }).
						when('/skill-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/editSkill';
							},
                            controller: editSkillCtrl,
                            activetab: 'all-skills'
                        }).
						when('/all-testimonials', {
                            templateUrl: BASE_URL+'admin/testimonials',
                            controller: allTestimonialCtrl,
                            activetab: 'all-testimonials'
                        }).
						when('/testimonial-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/editTestimonial';
							},
                            controller: editTestimonialCtrl,
                            activetab: 'all-testimonials'
                        }).
						when('/all-users', {
                            templateUrl: BASE_URL+'admin/users',
                            controller: allUserCtrl,
                            activetab: 'all-users'
                        }).
						when('/user-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/editUser';
							},
                            controller: editUserCtrl,
                            activetab: 'all-users'
                        }).
						when('/user-skills-journey/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/skillsJourney';
							},
                            controller: skillsJourneyCtrl,
                            activetab: 'all-users'
                        }).
						when('/payment-plan-settings', {
                            templateUrl: BASE_URL+'admin/payment_plan_setting',
                            controller: PaymentPlanSettingsCtrl,
                            activetab: 'payment-plan-settings'
                        }).
						when('/all-groups', {
                            templateUrl: BASE_URL+'admin/group_manage',
                            controller: GroupManageCtrl,
                            activetab: 'all-groups'
                        }).
						when('/group-edit/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/editGroup';
							},
                            controller: editGroupCtrl,
                            activetab: 'all-groups'
                        }).
						when('/group-mail/:ID', {
                            templateUrl: function(urlattr){
							return BASE_URL+'admin/emailGroup';
							},
                            controller: GroupMailCtrl,
                            activetab: 'all-groups'
                        }).
						when('/web-settings', {
                            templateUrl: BASE_URL+'admin/settings',
                            controller: webSettingsCtrl,
                            activetab: 'web-settings'
                        }).
						
                        otherwise({redirectTo: '/dashboard'});
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

adminapp.directive('googleplace', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
				
				var place = scope.gPlace.getPlace();
				var coords = place.geometry.location;
			scope.eventinfo.lat=coords.lat();
			scope.eventinfo.lng=coords.lng();
		    
                scope.$apply(function() {
                    model.$setViewValue(element.val()); 

					
                });
            });
        }
    };
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