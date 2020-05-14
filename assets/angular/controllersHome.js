'use strict';

//Controllers
function HomeCtrl($scope, $http, $anchorScroll) 
{
	$anchorScroll();
		var formData = {'id': 1};
	$http.post(BASE_URL+'api/pages/ActivepageDetail', formData , {
			headers:{		
				'token':TOKEN,
				'Content-Type':'application/json',
			}
			})
   .then(function(response) {
      $scope.contentinfo = response.data.data;
	 
    });
}
function ChurchesCtrl($scope, $http, $anchorScroll) 
{
	$anchorScroll();
}
function EventbillingCtrl($scope, $http, $anchorScroll, $routeParams, $timeout, $route, $location) 
{
	
	
	$anchorScroll();
	$scope.eventslug = $routeParams.ID;
	var res = $routeParams.ID.split("-");
	$scope.billinginfo = {
		ID:false,
		different_attende:'0',
		event_id:res[res.length-1],
		zip_code:'',
		phone_number:''
	}; 
	
	$scope.attendeinfo = {};
	$scope.getProfile = function()
	{
		$http.get(BASE_URL+'api/user/getprofile')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		$scope.billinginfo = response.data.data;
		$scope.billinginfo.zip_code = response.data.data.zip;
		$scope.billinginfo.phone_number = response.data.data.phone;
	   }
	 
    });
	
	
	}
	$scope.getProfile();
/* 	$http.get(BASE_URL+'api/checkout/getAllSessiondata')
   .then(function(response) {
	    if(response.data.data.billinginfo !=undefined){
       $scope.billinginfo = response.data.data.billinginfo;
	   $scope.attendeinfo = response.data.data.attendeinfo;
	   } 
	   
    });   */
	
	//console.log(res[res.length-1]);
	var formData = {'id': res[res.length-1]};
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   if(response.data.data.skill_requirement.indexOf(',') > -1) {
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   } else {
		    $scope.eventinfo.skill_requirement = response.data.data.skill_requirement;
	   }
	  
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
	   $scope.billinginfo.event_id = response.data.data.id;
    });
	
	

$scope.checkprocess = function()
    {
		 var fd = new FormData();
		//fd.billinginfo = this.billinginfo;
		//fd.attendeinfo = this.attendeinfo;
		fd = {
			billinginfo : this.billinginfo,
			attendeinfo : this.attendeinfo,
		}
		 
		$http({
   method: 'post',
   url: BASE_URL+'api/checkout/updateAttende',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		 var result = res.data;	
            if(result.success == 'true')
            { 
		 $route.current.activetab = 'payment';
		 //alert($routeParams.ID);
		 $location.url('payment/'+$routeParams.ID+'/'+result.data);
			/* 	$timeout(function() {
			var el = document.getElementById('payment');
			angular.element(el).click();
			
			}); */
						//$scope.message = res.data.message;
            }
			if(result.success == "false")
            {
                $scope.billing = res.data.message.billing;
				$scope.attende = res.data.message.attende;
            } 
		
            
                   
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        }); 
	
	
    }
 	
}

function EventPaymentCtrl($scope, $http, $anchorScroll, $routeParams, $timeout, $route,$locale, $location) 
{
	 $scope.currentYear = new Date().getFullYear();
	 $scope.currentMonth = new Date().getMonth() + 1
     $scope.months = $locale.DATETIME_FORMATS.MONTH
	$anchorScroll();
	
	$scope.eventslug = $routeParams.ID;
	$scope.orderID = $routeParams.OrderID;
	var res = $routeParams.ID.split("-");
	
	$scope.paymentinfo = {
		payment_type:'fullpayment',
		event_id: res[res.length-1],
		gateway: 'pay',
		min_deposit:'',
		cost:'',
		order_id:$routeParams.OrderID,
		nocost:0
	};
	var formdata = {'order_id': $routeParams.OrderID, 'field' : 'payment_id','event_slug': $routeParams.ID};
	$http.post(BASE_URL+'api/checkout/validate_payment_user', formdata)
   .then(function(response) {
	   
	   if(response.data.success == 'true'){
		   if($location.url() != '/'+response.data.redirect_url) {
			   $location.url(response.data.redirect_url);
		   } 
		  
		
	   }
    });
	$http.get(BASE_URL+'api/pages/settingsDetail')
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data!=undefined){
       $scope.admindata = response.data.data;
	   }
    });
	
	
	
	$http.get(BASE_URL+'api/pages/getPaymentPlans')
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data!=undefined){
       $scope.paymentplan = response.data.data;
	   }
    });
	var formdata = {'event_id': res[res.length-1]};
	$http.post(BASE_URL+'api/checkout/checkPaymentPlan', formdata)
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data!=undefined){
       $scope.checkpaymentplan = response.data.data;
	    $scope.paymentinfo.eventPaymentPlanCost = response.data.payment_plan_cost;
	   }
    });
	
	
	/* $http.get(BASE_URL+'api/checkout/getAllSessiondata')
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data.paymentinfo!=undefined){
       $scope.paymentinfo = response.data.data.paymentinfo;
	  
	   }
    }); */
	//console.log(res[res.length-1]);
	var formData = {'id': res[res.length-1]};
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   if(response.data.data.skill_requirement.indexOf(',') > -1) {
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   } else {
		    $scope.eventinfo.skill_requirement = response.data.data.skill_requirement;
	   }
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
	   $scope.paymentinfo.min_deposit = response.data.data.min_deposit;
	   $scope.paymentinfo.cost = response.data.data.cost;
	   $scope.paymentinfo.event_id = response.data.data.id;
    });
	
  $scope.setGateway = function(){
	  if($scope.paymentinfo.payment_type == "paymentplan") {
		$scope.paymentinfo.gateway = 'pay';
	  } 
  }
$scope.checkprocess = function()
    {
		
		 var fd = new FormData();
		
		fd = {
			paymentinfo : this.paymentinfo
		}
		
	$http({
   method: 'post',
   url: BASE_URL+'api/checkout/dopayment',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        { 
			
		//console.log(res);
            var result = res.data;	
            if(result.success == 'true')
            { 
				if(fd.paymentinfo.gateway == "payviacheck") {
					
					$('#payviacheckmodal').modal("hide");
					$('.modal-backdrop').remove();
					$('body').removeClass("modal-open");
				}
			
			$route.current.activetab = 'agreements';
			$timeout(function() {
			var el = document.getElementById('agreements');
			angular.element(el).click();
			}); 
                $scope.message = res.data.message;
				$location.url('agreements/'+$routeParams.ID+'/'+$routeParams.OrderID);
				$route.reload();
            }
			if(result.success == "false")
            {
                $scope.billing = res.data.message.billing;
				$scope.attende = res.data.message.attende;
            } 
                   
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        }); 
	
    }
 	
}

function EventAgreementsCtrl($scope, $http, $anchorScroll, $routeParams, $timeout, $uibModal, $route, $location) 
{

	$anchorScroll();
	$scope.different_attende = '';
	$scope.eventslug = $routeParams.ID;
	$scope.orderID = $routeParams.OrderID;
	var res = $routeParams.ID.split("-");
	$scope.agreementinfo = {
		event_id: res[res.length-1],
		event_agreed: '0',
		financial_agreed:'0',
		copyright_agreed:'0',
		order_id: $routeParams.OrderID
	};
	
	var formdata = {'order_id': $routeParams.OrderID, 'field' : 'payment_id','event_slug': $routeParams.ID};
	$http.post(BASE_URL+'api/checkout/validate_payment_user', formdata)
   .then(function(response) {
	   
	   if(response.data.success == 'true'){
		      
		   if($location.url() != '/'+response.data.redirect_url) {
			   $location.url(response.data.redirect_url);
		   } 
		
	   }
    });
	
	
	//console.log(res[res.length-1]);
	var formData = {'id': res[res.length-1]};
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
    });
	
	$http.get(BASE_URL+'api/pages/agreements')
   .then(function(response) {
       $scope.agreementlist = response.data.data;
    });
	
	$scope.eventAgreed = function()
    { 
		$scope.agreementinfo.event_agreed = true;
	};
	$scope.financialAgreed = function()
    { 
		$scope.agreementinfo.financial_agreed = true;
	};
	$scope.copyrightAgreed = function()
    { 
		$scope.agreementinfo.copyright_agreed = true;
	};
	
	$scope.printDiv = function(divName) {
	  var printContents = document.getElementById(divName).innerHTML;
	  
	  var popupWin = window.open('', '_blank');
	  popupWin.document.open();
	  popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
	  popupWin.document.close();
	} 

$scope.checkprocess = function()
    {
		 var fd = new FormData();
		
		fd = {
			agreementinfo : this.agreementinfo
		}
	$http({
   method: 'post',
   url: BASE_URL+'api/checkout/agreement',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {
            var result = res.data;	
            if(result.success == 'true')
            { 
		$route.current.activetab = 'healthinfo';
		$timeout(function() {
	var el = document.getElementById('healthinfo');
	angular.element(el).click();
	});
                $scope.message = res.data.message;
				$location.url('healthinfo/'+$routeParams.ID+'/'+$routeParams.OrderID);
            }
			if(result.success == "false")
            {
                $scope.agreement = res.data.message.agreement;
				
            } 
                   
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        }); 
	
	
    }
 	
}


function EventHealthinfoCtrl($scope, $http, $anchorScroll, $routeParams, $timeout, $route, $location, $filter) 
{
	
	$anchorScroll();
	$scope.different_attende = '';
	$scope.eventslug = $routeParams.ID;
	$scope.orderID = $routeParams.OrderID;
	var res = $routeParams.ID.split("-");
	$scope.healthinfo = {
		event_id: res[res.length-1],
		order_id: $routeParams.OrderID
	};
	
	
	var formdata = {'order_id': $routeParams.OrderID, 'field' : 'healthinfo_id','event_slug': $routeParams.ID};
	$http.post(BASE_URL+'api/checkout/validate_payment_user', formdata)
   .then(function(response) {
	   
	   if(response.data.success == 'true'){
		   
		   if($location.url() != '/'+response.data.redirect_url) {
			   $location.url(response.data.redirect_url);
		   } 
		
	   }
    });
	
	/* $http.get(BASE_URL+'api/checkout/getAllSessiondata')
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data.healthinfo!=undefined){
       $scope.healthinfo = response.data.data.healthinfo;
	   }
    }); */
	//console.log(res[res.length-1]);
	var formData = {'id': res[res.length-1]};
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
    });
	
	 $http.get(BASE_URL+'api/user/getprofile')
   .then(function(response) {
	    if(response.data.data != ""){
		  $scope.healthinfo.address_1 = response.data.data.address;
		  $scope.healthinfo.address_2 = response.data.data.address;
		  $scope.healthinfo.state = response.data.data.state;
		  $scope.healthinfo.city = response.data.data.city;
		  $scope.healthinfo.zipcode = response.data.data.zip;
		  $scope.healthinfo.full_name = response.data.data.first_name+' '+response.data.data.last_name;
		  $scope.healthinfo.user_id = response.data.data.ID;
		}
	  
	  
	 
    }); 
	
$http.get(BASE_URL+'api/user/get_user_health_info')
   .then(function(response) {
	   if(response.data.data != ""){
		   $scope.healthinfo = response.data.data;
		   $scope.healthinfo.birth_date =  new Date(response.data.data.birth_date);
		     $scope.healthinfo.signature_date =  new Date(response.data.data.signature_date);
	   }
	
	 
    }); 

$scope.checkprocess = function()
    {
		var fd = new FormData();
		 $scope.healthinfo.signature_date = $filter('date')($scope.healthinfo.signature_date, "yyyy-MM-dd");
		$scope.healthinfo.birth_date = $filter('date')($scope.healthinfo.birth_date, "MM/dd/yyyy"); 
		$scope.healthinfo.order_id = $routeParams.OrderID;
		fd = {
			healthinfo : this.healthinfo
		}
		
	$http({
   method: 'post',
   url: BASE_URL+'api/checkout/healthinfo',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {
            var result = res.data;	
			
            if(result.success == 'true')
            { 
			$route.current.activetab = 'notifications';
			$timeout(function() {
			var el = document.getElementById('notifications');
			angular.element(el).click();
			});
				$scope.error_message = "";
				$scope.health = [];
                $scope.message = res.data.message;
				$location.url('notifications/'+$routeParams.ID+'/'+$routeParams.OrderID);
            }
			if(result.success == "validation_error")
            {
				$scope.message = "";
				$scope.error_message = "Please Fill All Fields!";
                $scope.health = res.data.message.health;
				
            } 
                   
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	
    }
 	
}

function EventNotificationCtrl($scope, $http, $anchorScroll, $routeParams, $timeout, $location) 
{
	$anchorScroll();
	$scope.different_attende = '';
	$scope.eventslug = $routeParams.ID;
	$scope.orderID = $routeParams.OrderID;
	var res = $routeParams.ID.split("-");
	var res = $routeParams.ID.split("-");
	$scope.notificationinfo = {
		event_id: res[res.length-1],
		notification_check: "true",
		order_id:$routeParams.OrderID
	};
	
	var formdata = {'order_id': $routeParams.OrderID, 'field' : 'notification_info_id','event_slug': $routeParams.ID};
	$http.post(BASE_URL+'api/checkout/validate_payment_user', formdata)
   .then(function(response) {
	   
	   if(response.data.success == 'true'){
		   
		   if($location.url() != '/'+response.data.redirect_url) {
			   $location.url(response.data.redirect_url);
		   } 
		
	   }
    });
	
	/* $http.get(BASE_URL+'api/checkout/getAllSessiondata')
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data.notificationinfo!=undefined){
		$scope.notificationinfo = response.data.data.notificationinfo;
	   }
    }); */
	var formData = {'id': res[res.length-1]};
	
	
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
    });

$scope.checkprocess = function()
    {
		 var fd = new FormData();
		
		fd = {
			notificationinfo : this.notificationinfo
		}
		
	$http({
   method: 'post',
   url: BASE_URL+'api/checkout/finalcheckout',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {
            var result = res.data;	
            if(result.success == 'true')
            { 
		
                $scope.message = res.data.message;
				
		       $location.url('success'); 
            }
			if(result.success == "false")
            {
                $scope.message = res.data.message;
				
            } 
                   
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        }); 
	
    }
 	
}

function EventSuccessCtrl($scope, $http, $anchorScroll) {
	$anchorScroll();
	
	$scope.message = "Your order is confirmed.";
	$http.get(BASE_URL+'api/checkout/getAllSessiondata')
   .then(function(response) {
	   console.log(response.data.data);
	   if(response.data.data!=undefined){
		$scope.successinfo = response.data.data;
	   }
    }); 
}


function MensCtrl($scope, $http, $anchorScroll, $location, $filter, $compile, $rootScope) 
{
    $anchorScroll();
	$scope.eventlists=[];
	$scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	$scope.eventdates = ['newest', 'oldest'];
	$scope.selectedCategory = '1';
	$scope.selectedDate = 'newest';
	$scope.Searchkeyword = '';
	$scope.selectedSkill = '';
	 var places = [];
	 $scope.Typelists = [];
	var formDatac = {'cat_id': $scope.selectedCategory,'limit':6};
	$http.post(BASE_URL+'api/event/getalltype', formDatac)
   .then(function(response) {
      $scope.Typelists = response.data.data;
	  
    });	
	
	$http.get(BASE_URL+'api/skill/getallskills')
   .then(function(response) {
      $scope.skillists = response.data.data;
    });	
	
	var formData = {'category': $scope.selectedCategory, 'type': $scope.selectedType, 'orderby': $scope.selectedDate};
	$http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
      $scope.eventlists = response.data.data;
	  var places = [];
	   for (var j = 0; j < response.data.data.length; j++){
		   var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		 $scope.mapview(places);  
	  
    });	
    $scope.getSelectedText = function (event_type) {
		
      if ($scope.selectedCategory !== undefined || event_type !== undefined || $scope.selectedDate !== undefined) {
		   $scope.selectedType = event_type;
		  var formData = {'category': $scope.selectedCategory, 'type': event_type, 'orderby': $scope.selectedDate, 'keyword': $scope.Searchkeyword, 'skill': $scope.selectedSkill};
       $http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
		$scope.eventlists = response.data.data;
		$scope.currentPage = 0;
		$scope.pageSize = 3;
		$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);  
		var places = [];
		for (var j = 0; j < response.data.data.length; j++){
			var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		
		 $scope.mapview(places);  

		
    }
	
	});	
      } 
    }; 
	
      $scope.mapview = function(locations) {
		var el = document.getElementById('map_view');
		
		//angular.element(el).click();
		//console.log($scope.place);
		 $scope.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: { lat: 25, lng: 80 }
            });



           

            $scope.infowindow = new google.maps.InfoWindow({
                content: ''
            });


            for (var i = 0; i < locations.length; i++) {


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                    map: $scope.map,
                    title: locations[i].event_name
                });

               var content = '<h4>' + locations[i].event_name + ', ' + locations[i].event_location  + ', ' + locations[i].start_date + '</h4>';
                var compiledContent = $compile(content)($scope)
					console.log(content);
                google.maps.event.addListener(marker, 'click', (function(marker, content, scope) {
                    return function() {
                        scope.infowindow.setContent(content);
                        scope.infowindow.open(scope.map, marker);
                    };
                })(marker, compiledContent[0], $scope));

            }
  

        };
     // google.maps.event.addDomListener(window, 'load', initialize);
	
	$scope.slugStr = function(input)
	{
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
			
	$scope.gotocart = function (eventdetail) {
	
	 if (eventdetail.id !== "") {
		  
		  var formData = {'category': eventdetail.event_category,'event_id': eventdetail.id, 'skill_requirement': eventdetail.skill_requirement};
       $http.post(BASE_URL+'api/event/gotocartstatus', formData)
   .then(function(response) {
	   if(response.data.success=='false'){
    $scope.message = response.data.message;
	   } else {
		 $scope.message = response.data.message;
		var eventtitle = eventdetail.typenametitle ? eventdetail.typenametitle : eventdetail.event_typename;
		$location.url('billing/'+$scope.slugStr(eventtitle)+'-'+eventdetail.id); 
	   }
	
    });	
      }
    };
}
function WomensCtrl($scope, $http, $anchorScroll, $location,$compile, $rootScope) 
{
	 $anchorScroll();
	 var places = [];
	$scope.eventlists=[];
	$scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	$scope.eventdates = ['newest', 'oldest'];
	$scope.selectedCategory = '2';
	$scope.selectedDate = 'newest';
	$scope.Searchkeyword = '';
	$scope.selectedSkill = '';
	var formDatac = {'cat_id': $scope.selectedCategory,'limit':6};
	$http.post(BASE_URL+'api/event/getalltype', formDatac)
   .then(function(response) {
      $scope.Typelists = response.data.data;
	  
    });	
	
	$http.get(BASE_URL+'api/skill/getallskills')
   .then(function(response) {
      $scope.skillists = response.data.data;
    });	
	
	var formData = {'category': $scope.selectedCategory, 'type': $scope.selectedType, 'orderby': $scope.selectedDate};
	$http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
      $scope.eventlists = response.data.data;
	  var places = [];
	  for (var j = 0; j < response.data.data.length; j++){
		  var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		 
		 $scope.mapview(places);	 
		 
		 
    });	
    $scope.getSelectedText = function (event_type) {
		
      if ($scope.selectedCategory !== undefined || event_type !== undefined || $scope.selectedDate !== undefined) {
		  $scope.selectedType = event_type;
		  var formData = {'category': $scope.selectedCategory, 'type': event_type, 'orderby': $scope.selectedDate, 'keyword': $scope.Searchkeyword, 'skill': $scope.selectedSkill};
       $http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
    $scope.eventlists = response.data.data;
	$scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	var places = [];
	for (var j = 0; j < response.data.data.length; j++){
		var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		 
		 
		 
	  $scope.mapview(places);	 
		 
    });	
      } 
    }; 
	/* $scope.listview = function() {
		
		var el = document.getElementById('map');
		angular.element(el).html('');
	}; */
		
	$scope.mapview = function(locations) {
		console.log(locations);
		 $scope.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: { lat: 25, lng: 80 }
            });

		$scope.infowindow = new google.maps.InfoWindow({
                content: ''
            });


            for (var i = 0; i < locations.length; i++) {


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                    map: $scope.map,
                    title: locations[i].event_name
                });

                var content = '<h4>' + locations[i].event_name + ', ' + locations[i].event_location  + ', ' + locations[i].start_date + '</h4>';
                var compiledContent = $compile(content)($scope)
					console.log(content);
                google.maps.event.addListener(marker, 'click', (function(marker, content, scope) {
                    return function() {
                        scope.infowindow.setContent(content);
                        scope.infowindow.open(scope.map, marker);
                    };
                })(marker, compiledContent[0], $scope));

            }
  
  

        };
	
     // google.maps.event.addDomListener(window, 'load', initialize);
	  
	$scope.slugStr = function(input)
	{
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
	
	$scope.gotocart = function (eventdetail) {
	
	 if (eventdetail.id !== "") {
		  
		  var formData = {'category': eventdetail.event_category,'event_id': eventdetail.id, 'skill_requirement': eventdetail.skill_requirement};
       $http.post(BASE_URL+'api/event/gotocartstatus', formData)
   .then(function(response) {
	   if(response.data.success=='false'){
			$scope.message = response.data.message;
	   } else {
			$scope.message = response.data.message; 
			var eventtitle = eventdetail.typenametitle ? eventdetail.typenametitle : eventdetail.event_typename;
		$location.url('billing/'+$scope.slugStr(eventtitle)+'-'+eventdetail.id);
	   }
	
    });	
      }
    };
}
function CouplesCtrl($scope, $http, $anchorScroll, $location, $compile, $rootScope) 
{
	 $anchorScroll();
	
	$scope.eventlists=[];
	$scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	$scope.eventdates = ['newest', 'oldest'];
	$scope.selectedCategory = '3';
	$scope.selectedDate = 'newest';
	$scope.Searchkeyword = '';
	$scope.selectedSkill = '';
	var formDatac = {'cat_id': $scope.selectedCategory,'limit':6};
	$http.post(BASE_URL+'api/event/getalltype', formDatac)
   .then(function(response) {
      $scope.Typelists = response.data.data;
	 
    });	
	
	$http.get(BASE_URL+'api/skill/getallskills')
   .then(function(response) {
      $scope.skillists = response.data.data;
    });	
	
	var formData = {'category': $scope.selectedCategory, 'type': $scope.selectedType, 'orderby': $scope.selectedDate};
	$http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
      $scope.eventlists = response.data.data;
	  var places = [];
	  for (var j = 0; j < response.data.data.length; j++){
		  var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		$scope.mapview(places);
    });
	
	
     // google.maps.event.addDomListener(window, 'load', initialize);
	
	
		$scope.slugStr = function(input)
	{
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

	$scope.gotocart = function (eventdetail) {
	
	 if (eventdetail.id !== "") {
		  
		  var formData = {'category': eventdetail.event_category,'event_id': eventdetail.id, 'skill_requirement': eventdetail.skill_requirement};
       $http.post(BASE_URL+'api/event/gotocartstatus', formData)
   .then(function(response) {
	   if(response.data.success=='false'){
    $scope.message = response.data.message;
	   } else {
		 $scope.message = response.data.message; 
		var eventtitle = eventdetail.typenametitle ? eventdetail.typenametitle : eventdetail.event_typename;
		$location.url('billing/'+$scope.slugStr(eventtitle)+'-'+eventdetail.id);
	   }
	
    });	
      }
    };

	
    $scope.getSelectedText = function (event_type) {
		
      if ($scope.selectedCategory !== undefined || event_type !== undefined || $scope.selectedDate !== undefined) {
		  
		   $scope.selectedType = event_type;
		   
		  var formData = {'category': $scope.selectedCategory, 'type': event_type, 'orderby': $scope.selectedDate, 'keyword': $scope.Searchkeyword, 'skill': $scope.selectedSkill};
       $http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
    $scope.eventlists = response.data.data;
	$scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	var places = [];
	for (var j = 0; j < response.data.data.length; j++){
		var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		 
		  $scope.mapview(places);
	
    });	
      } 
    };
	
	
	 $scope.mapview = function(locations) {
		var el = document.getElementById('map_view');
		
		//angular.element(el).click();
		//console.log($scope.place);
		 $scope.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: { lat: 25, lng: 80 }
            });



           

            $scope.infowindow = new google.maps.InfoWindow({
                content: ''
            });


            for (var i = 0; i < locations.length; i++) {


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                    map: $scope.map,
                    title: locations[i].event_name
                });

                var content = '<h4>' + locations[i].event_name + ', ' + locations[i].event_location  + ', ' + locations[i].start_date + '</h4>';
                var compiledContent = $compile(content)($scope)
					console.log(content);
                google.maps.event.addListener(marker, 'click', (function(marker, content, scope) {
                    return function() {
                        scope.infowindow.setContent(content);
                        scope.infowindow.open(scope.map, marker);
                    };
                })(marker, compiledContent[0], $scope));

            }
  

        };
}
function EventlistCtrl($scope, $http, $anchorScroll, $location, $compile, $rootScope) 
{
	$scope.eventlists=[];
	$scope.place = [];
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	$http.post(BASE_URL+'api/event/getallevents')
   .then(function(response) {
	   
      $scope.eventlists = response.data.data;
	   var places = [];
	  for (var j = 0; j < response.data.data.length; j++){
		  var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		 
	  $scope.mapview(places);
    });	
	$http.get(BASE_URL+'api/event/getallcategory')
   .then(function(responses) {
	   $scope.eventcats = responses.data.data;
	  
    });
	
	
	//$scope.eventcats = ['men', 'women', 'couple'];
	//$scope.eventtypes = ['weekend', 'groups', 'retreats'];
	$scope.eventdates = ['newest', 'oldest'];
    $scope.selectedCategory = undefined;
	$scope.selectedType = undefined;
	$scope.selectedDate = undefined;
	$scope.Searchkeyword = "";
    $scope.getSelectedText = function () {
		//if ($scope.selectedCategory !== "") {
		  
		  var formData = {'cat_id': $scope.selectedCategory};
       $http.post(BASE_URL+'api/event/getalltype', formData)
   .then(function(response) {
      $scope.eventtypes = response.data.data; 
    });	
     // }
      if ($scope.selectedCategory !== undefined || $scope.selectedType !== undefined || $scope.selectedDate !== undefined || $scope.Searchkeyword !== "") {
		  
		  var formData = {'category': $scope.selectedCategory, 'type': $scope.selectedType, 'orderby': $scope.selectedDate, 'keyword': $scope.Searchkeyword};
       $http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
	   
      $scope.eventlists = response.data.data;
	  $scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	var places = [];
	for (var j = 0; j < response.data.data.length; j++){
		var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		  
		  $scope.mapview(places);
	
    });	
      } else {
		  $http.post(BASE_URL+'api/event/getallevents')
   .then(function(response) {
	   
      $scope.eventlists = response.data.data;
	  var places = [];
	  for (var j = 0; j < response.data.data.length; j++){
		  var event_typename = response.data.data[j].typenametitle ? response.data.data[j].typenametitle : response.data.data[j].event_typename;
			 places[j] = {
				 event_name:event_typename,
				 event_location:response.data.data[j].location,
				 start_date:response.data.data[j].start_date,
				 lat:response.data.data[j].lat,
				 lng:response.data.data[j].lng
				 
			 };
		 }
		 
	  $scope.mapview(places);
    });	
	  }
    }; 
	
	 $scope.mapview = function(locations) {
		var el = document.getElementById('map_view');
		
		//angular.element(el).click();
		console.log(locations);
		 $scope.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: { lat: 25, lng: 80 }
            });



           

            $scope.infowindow = new google.maps.InfoWindow({
                content: ''
            });


            for (var i = 0; i < locations.length; i++) {


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                    map: $scope.map,
                    title: locations[i].event_name
                });

               var content = '<h4>' + locations[i].event_name + ', ' + locations[i].event_location  + ', ' + locations[i].start_date + '</h4>';
                var compiledContent = $compile(content)($scope)
					console.log(content);
                google.maps.event.addListener(marker, 'click', (function(marker, content, scope) {
                    return function() {
                        scope.infowindow.setContent(content);
                        scope.infowindow.open(scope.map, marker);
                    };
                })(marker, compiledContent[0], $scope));

            }
  

        };

     // google.maps.event.addDomListener(window, 'load', initialize);
	
	$scope.slugStr = function(input)
	{
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
	
	$scope.gotocart = function (eventdetail) {
	
	 if (eventdetail.id !== "") {
		  
		  var formData = {'category': eventdetail.event_category,'event_id': eventdetail.id, 'skill_requirement': eventdetail.skill_requirement};
       $http.post(BASE_URL+'api/event/gotocartstatus', formData)
   .then(function(response) {
	   if(response.data.success=='false'){
    $scope.message = response.data.message;
	   } else {
		 $scope.message = response.data.message; 
		var eventtitle = eventdetail.typenametitle ? eventdetail.typenametitle : eventdetail.event_typename;
		$location.url('billing/'+$scope.slugStr(eventtitle)+'-'+eventdetail.id); 
	   }
	
    });	
      }
    };
	
}

function ProfileEventlistCtrl($scope, $http, $anchorScroll, $location, $routeParams) 
{
	$scope.eventType = $routeParams.eventType
	$scope.eventlists=[];
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
    var formdata = {'event_type': $scope.eventType};
	$http.post(BASE_URL+'api/event/get_user_event_list', formdata)
   .then(function(response) {
      $scope.eventlists = response.data.data;
    });	
	
	
	$http.get(BASE_URL+'api/event/getallcategory')
   .then(function(responses) {
	   $scope.eventcats = responses.data.data;
	  
    });
	
	
	//$scope.eventcats = ['men', 'women', 'couple'];
	//$scope.eventtypes = ['weekend', 'groups', 'retreats'];
	$scope.eventdates = ['newest', 'oldest'];
    $scope.selectedCategory = undefined;
	$scope.selectedType = undefined;
	$scope.selectedDate = undefined;
	$scope.Searchkeyword = "";
    $scope.getSelectedText = function () {
		//if ($scope.selectedCategory !== "") {
		  
		  var formData = {'cat_id': $scope.selectedCategory};
       $http.post(BASE_URL+'api/event/getalltype', formData)
   .then(function(response) {
      $scope.eventtypes = response.data.data; 
    });	
     // }
      if ($scope.selectedCategory !== undefined || $scope.selectedType !== undefined || $scope.selectedDate !== undefined || $scope.Searchkeyword !== "") {
		  
		  var formData = {'category': $scope.selectedCategory, 'type': $scope.selectedType, 'orderby': $scope.selectedDate, 'keyword': $scope.Searchkeyword,'event_type': $scope.eventType};
       $http.post(BASE_URL+'api/event/get_user_event_list', formData)
   .then(function(response) {
      $scope.eventlists = response.data.data;
	  $scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
    });	
      } else {
		    var formdata = {'event_type': $scope.eventType};
		  $http.post(BASE_URL+'api/event/get_user_event_list', formdata)
   .then(function(response) {
      $scope.eventlists = response.data.data;
    });	
	  }
    }; 
	
	$scope.slugStr = function(input)
	{
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

homeapp.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});


function EventdetailCtrl($scope, $http, $anchorScroll, $routeParams, $location) 
{
	$anchorScroll();
	
	//console.log($routeParams.ID);
	var res = $routeParams.ID.split("-");
	//console.log(res[res.length-1]);
	var formData = {'id': res[res.length-1]};
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   $scope.eventinfo.event_map_location = response.data.data.location.replace(/\s+/g, '+');
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
    });	
	$scope.slugStr = function(input)
	{
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
	
	$scope.gotocart = function (eventdetail) {
	
	 if (eventdetail.id !== "") {
		  
		  var formData = {'category': eventdetail.event_category,'event_id': eventdetail.id, 'skill_requirement': eventdetail.skill_requirement[0]};
       $http.post(BASE_URL+'api/event/gotocartstatus', formData)
   .then(function(response) {
	   if(response.data.success=='false'){
    $scope.message = response.data.message;
	   } else {
		 $scope.message = response.data.message; 
		var eventtitle = eventdetail.typenametitle ? eventdetail.typenametitle : eventdetail.event_typename;
		$location.url('billing/'+$scope.slugStr(eventtitle)+'-'+eventdetail.id); 
	   }
	
    });	
      }
    };
}

function ChangePasswordCtrl($scope, $http, $anchorScroll) {
	$anchorScroll();
	$http.get(BASE_URL+'api/user/getprofile')
   .then(function(response) {
      $scope.profileinfo = response.data.data;
	 
    });
	$scope.changepassword = function() {
		if($scope.profileinfo.new_password == $scope.profileinfo.confirm_password) {
		var user_id = $scope.profileinfo.ID!=undefined ? $scope.profileinfo.ID :''; 
		var fd = new FormData();
		fd.append('user_id', user_id);
		 fd.append('new_password', $scope.profileinfo.new_password);
         fd.append('confirm_password', $scope.profileinfo.confirm_password);
		  $http({
		   method: 'post',
		   url: BASE_URL+'api/user/changepassword',
		   data: fd,
		   headers: {'Content-Type': undefined},
		  }).then(function (res) 
				{  
				
					var result = res.data;	
					if(result.success == 'true')
					{ 
					$scope.error  = "";
						$scope.errors = [];
						$scope.message = res.data.message;
						$scope.profileinfo.new_password = "";
						$scope.profileinfo.confirm_password = "";
						
					}
					if(result.success == "error")
					{
						$scope.message = "";
						$scope.error  = "";
						$scope.errors = res.data.error;
					}
					if(result.success == "false")
					{
						$scope.message = "";
						$scope.errors = [];
						$scope.error = res.data.error;
					}
								
				},function(error) 
				{
					
						$scope.message = error.data.error;
					
				});
		} else {
			$scope.error = "New Password and confirm password should be same!";
		}
	}
}

function MyprofileCtrl($scope, $http, $anchorScroll) 
{
	$anchorScroll();
	$http.get(BASE_URL+'api/user/getprofile')
   .then(function(response) {
      $scope.profileinfo = response.data.data;
	 
    });
	
	
	$scope.editprofile = function()
    {
		var user_id = $scope.profileinfo.ID!=undefined ? $scope.profileinfo.ID :''; 
		var fd = new FormData();
		angular.forEach($scope.profilepic,function(profilepic){
  fd.append('profilepic', profilepic);
 });

        fd.append('user_id', user_id);
        fd.append('bio', $scope.profileinfo.bio);
		fd.append('first_name', $scope.profileinfo.first_name);
		fd.append('last_name', $scope.profileinfo.last_name);
		fd.append('phone', $scope.profileinfo.phone);
		fd.append('address', $scope.profileinfo.address);
		fd.append('city', $scope.profileinfo.city);
		fd.append('state', $scope.profileinfo.state);
		fd.append('zip', $scope.profileinfo.zip);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/user/updateprofile',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		
                $scope.message = res.data.message;
            }
            if(result.success == "false")
            {
                $scope.message = res.data.message;
            }
                        
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
}

function MyrewardsCtrl($scope, $http, $timeout) {
	
}

function MyresultsCtrl($scope, $http, $timeout) {
	
}

function MyskillsCtrl($scope, $http, $timeout) {
	$scope.skills=[];
	 $scope.profileinfo = [];
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.skills.length/$scope.pageSize);                
    }
	
	$http.get(BASE_URL+'api/user/getuserskills')
   .then(function(response) {
      $scope.skills = response.data.data;
	   $scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.skills.length/$scope.pageSize);                
    }
	 
    });
}

function MyeventCtrl($scope, $http) 
{
	$scope.eventlists=[];
	$scope.reconnectevents = [];
	$scope.skillsevents = [];
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	
	$scope.skillscurrentPage = 0;
    $scope.skillspageSize = 10;
	$scope.skillsnumberOfPages=function(){
        return Math.ceil($scope.skillsevents.length/$scope.skillspageSize);                
    }
	
	 $scope.reconnectcurrentPage = 0;
    $scope.reconnectpageSize = 10;
	$scope.reconnectnumberOfPages=function(){
        return Math.ceil($scope.reconnectevents.length/$scope.reconnectpageSize);                
    }
	$http.get(BASE_URL+'api/user/get_users_upcoming_event')
   .then(function(response) {
      $scope.eventlists = response.data.data;
	   $scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	 
    });
	
	$http.get(BASE_URL+'api/user/get_training_staffing_event')
   .then(function(response) {
      $scope.skillsevents = response.data.data;
	   $scope.skillscurrentPage = 0;
    $scope.skillspageSize = 3;
	$scope.skillsnumberOfPages=function(){
        return Math.ceil($scope.skillsevents.length/$scope.skillspageSize);                
    }
	 
    });
	
	
	$http.get(BASE_URL+'api/user/get_users_reconnect_events')
   .then(function(response) {
      $scope.reconnectevents = response.data.data;
	  $scope.reconnectcurrentPage = 0;
    $scope.reconnectpageSize = 3;
	$scope.reconnectnumberOfPages=function(){
        return Math.ceil($scope.reconnectevents.length/$scope.reconnectpageSize);                
    }
	 
    });
	
}

function MyhealthinfoCtrl($scope, $http, $anchorScroll, $routeParams, $timeout, $route, $location, $filter) {
	
	$scope.healthinfo =[];
	$scope.health = [];
	
	 $http.get(BASE_URL+'api/user/getprofile')
   .then(function(response) {
      $scope.healthinfo.address_1 = response.data.data.address;
	  $scope.healthinfo.address_2 = response.data.data.address;
	  $scope.healthinfo.state = response.data.data.state;
	  $scope.healthinfo.city = response.data.data.city;
	  $scope.healthinfo.zipcode = response.data.data.zip;
	  $scope.healthinfo.full_name = response.data.data.first_name+' '+response.data.data.last_name;
	  $scope.healthinfo.user_id = response.data.data.ID;
	  
	  
	 
    }); 
	
	 $http.get(BASE_URL+'api/user/get_user_health_info')
   .then(function(response) {
	   
	   if(response.data.data.user_id != null){
			$scope.healthinfo = response.data.data;
		    $scope.healthinfo.birth_date =  new Date(response.data.data.birth_date);
		    $scope.healthinfo.signature_date =  new Date(response.data.data.signature_date);
	   }
	
	 
    }); 
	
	
	$scope.edithealthinfo = function()
    {
		 
		var fd = new FormData();
		 $scope.healthinfo.signature_date = $filter('date')($scope.healthinfo.signature_date, "yyyy-MM-dd");
		$scope.healthinfo.birth_date = $filter('date')($scope.healthinfo.birth_date, "MM/dd/yyyy"); 
	
		
		
        fd.append('user_id', $scope.healthinfo.user_id);
        fd.append('full_name', $scope.healthinfo.full_name);
		fd.append('birth_date', $scope.healthinfo.birth_date);
		fd.append('address_1', $scope.healthinfo.address_1);
		fd.append('address_2', $scope.healthinfo.address_2);
		fd.append('city', $scope.healthinfo.city);
		fd.append('state', $scope.healthinfo.state);
		fd.append('zipcode', $scope.healthinfo.zipcode);
		fd.append('em_contactname', $scope.healthinfo.em_contactname);
        fd.append('em_contactaddress', $scope.healthinfo.em_contactaddress);
		fd.append('em_relation_withyou', $scope.healthinfo.em_relation_withyou);
		fd.append('em_phone_number', $scope.healthinfo.em_phone_number);
		fd.append('health_insure_company', $scope.healthinfo.health_insure_company);
		fd.append('health_insure_phone', $scope.healthinfo.health_insure_phone);
		fd.append('insure_primary_holder', $scope.healthinfo.insure_primary_holder);
		fd.append('insure_group_number', $scope.healthinfo.insure_group_number);
		fd.append('insure_idnumber', $scope.healthinfo.insure_idnumber);
		fd.append('primary_physician', $scope.healthinfo.primary_physician);
        fd.append('physician_address', $scope.healthinfo.physician_address);
		fd.append('physician_phone', $scope.healthinfo.physician_phone);
		
		fd.append('list_all_medications', $scope.healthinfo.list_all_medications);
		fd.append('list_any_psychiatric', $scope.healthinfo.list_any_psychiatric);
		fd.append('list_any_orthopedic', $scope.healthinfo.list_any_orthopedic);
		fd.append('your_personal_safety', $scope.healthinfo.your_personal_safety);
		fd.append('suffer_from_hiv', $scope.healthinfo.suffer_from_hiv);
		fd.append('addicted_to_alcohol', $scope.healthinfo.addicted_to_alcohol);
		fd.append('otc_medications', $scope.healthinfo.otc_medications);
        fd.append('other_contact_allergies', $scope.healthinfo.other_contact_allergies);
		fd.append('allergic_to_striped', $scope.healthinfo.allergic_to_striped);
		fd.append('list_food_allergies', $scope.healthinfo.list_food_allergies);
		fd.append('allow_staffmedic_review', $scope.healthinfo.allow_staffmedic_review);
		fd.append('signature', $scope.healthinfo.signature);
		fd.append('signature_date', $scope.healthinfo.signature_date);
		
        $http({
		   method: 'post',
		   url: BASE_URL+'api/user/updatehealthinfo',
		   data: fd,
		   headers: {'Content-Type': undefined},
		  }).then(function (res) 
				{  
				
            var result = res.data;	
            if(result.success == 'true')
            { 
				$scope.error_message = "";
				$scope.health = [];
                $scope.message = res.data.message;
            }
            if(result.success == "validation_error")
            {
				$scope.message = "";
				$scope.error_message = "Please Fill All Fields!";
                $scope.health = res.data.message.health;
            }
                        
        },function(error) 
        {
            
                $scope.error_message = error.data.error;
            
        });
  
    }
	
	
}

function EventDepositePaymentCtrl($scope, $http, $routeParams, $timeout, $route, $location, $window, $filter) {
	
	$scope.eventorderID = $routeParams.ID;
	$scope.eventorderinfo = [];
	
	
	var formData = {'unique_event_order': $scope.eventorderID};
	$http.post(BASE_URL+'api/event/get_event_order_by_unique_order_id', formData)
   .then(function(response) {
	   if(response.data.success == 'true') {
		$scope.eventorderinfo = response.data.data;
		$scope.payment_date = $filter('date')(new Date(response.data.data.paymentdata.payment_date),'MM/dd/yyyy');
		$scope.totalamount = response.data.data.cost - response.data.data.paid_amount;
		$scope.eventorderinfo.depositeamount = $scope.totalamount;
	   }
	   
    });
	
	 $scope.setPrice = function(){
	  
		$scope.eventorderinfo.depositeamount = $scope.totalamount;
	 
  }
  
  $scope.validatePrice = function() {
	  console.log($scope.eventorderinfo.depositeamount);
	  if(($scope.eventorderinfo.depositeamount < 0) || ($scope.eventorderinfo.depositeamount > $scope.totalamount) || ($scope.eventorderinfo.depositeamount == undefined)) {
		  $window.alert("Price should be valid");
		 $scope.eventorderinfo.depositeamount = $scope.totalamount;
		 
	  }
	 
	  
  }
  
  	$scope.slugStr = function(input)
	{
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
  
	
	$http.get(BASE_URL+'api/pages/settingsDetail')
   .then(function(response) {
	   //console.log(response.data.data.paymentinfo);
	   if(response.data.data!=undefined){
       $scope.admindata = response.data.data;
	   }
    });
	
	$scope.checkprocess = function()
    {
		
		 var fd = new FormData();
		
		fd = {
			paymentinfo : this.eventorderinfo
		}
		
	$http({
   method: 'post',
   url: BASE_URL+'api/checkout/depositepayment',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        { 
			
		//console.log(res);
            var result = res.data;	
            if(result.success == 'true')
            { 
					$('#payviacheckmodal').modal("hide");
					$('.modal-backdrop').remove();
					$('body').removeClass("modal-open");
				
			
				if(result.data == 'agreement') {
					$location.url('agreements/'+$scope.slugStr($scope.eventorderinfo.typenametitle)+'-'+$scope.eventorderinfo.event_id+'/'+$scope.eventorderinfo.unique_event_order);
				} else if(result.data == 'healthinfo') {
					$location.url('healthinfo/'+$scope.slugStr($scope.eventorderinfo.typenametitle)+'-'+$scope.eventorderinfo.event_id+'/'+$scope.eventorderinfo.unique_event_order);
				} else if(result.data == 'notificationinfo'){
					$location.url('notifications/'+$scope.slugStr($scope.eventorderinfo.typenametitle)+'-'+$scope.eventorderinfo.event_id+'/'+$scope.eventorderinfo.unique_event_order);
					
				}else {
						$location.url('myprofile/event');
					
					
				}
				
            }
			if(result.success == "false")
            {
                $scope.billing = res.data.message.billing;
				$scope.attende = res.data.message.attende;
            } 
                   
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        }); 
	
    }
	
}

function MyjourneyCtrl($scope, $http) 
{
	$scope.eventlists=[];
	
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	
	$http.get(BASE_URL+'api/user/get_users_past_event')
   .then(function(response) {
      $scope.eventlists = response.data.data;
	   $scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.eventlists.length/$scope.pageSize);                
    }
	 
    });
	
}

function MygroupCtrl($scope, $http) 
{
	
	$scope.grouplists=[];
	
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.grouplists.length/$scope.pageSize);                
    }
	
	$http.get(BASE_URL+'api/group/get_users_group')
   .then(function(response) {
      $scope.grouplists = response.data.data;
	   $scope.currentPage = 0;
    $scope.pageSize = 3;
	$scope.numberOfPages=function(){
        return Math.ceil($scope.grouplists.length/$scope.pageSize);                
    }
	 
    });
	
}

function GroupMailCtrl($scope, $http, $routeParams, $timeout) {
	$scope.groupID = "";
	var tid = "";
	
	$scope.groupinfo = {
		subject:"",
		message:""
		
	}
	 var formData = {'group_id': $routeParams.ID};
	$http.post(BASE_URL+'api/group/get_decrypt_groupID', formData)
		   .then(function(response) {
			   //console.log(response.data.data);
			   if(response.data.success !='false'){
				   $scope.groupID = response.data.data;
				$http.post(BASE_URL+'api/group/groupDetail', {'id':  $scope.groupID})
		   .then(function(response) {
			   //console.log(response.data.data);
			   if(response.data.success !='false'){
				   $scope.groupdata = response.data.data;
				$scope.groupinfo.to = response.data.data.group_email;
			   }
			 
			});
			   }
			 
			});
	$scope.sendmail = function()
    {
		if($scope.groupID != 0 && $scope.groupID != ""){
			
		var fd = new FormData();
		
        fd.append('group_id', $scope.groupID);
		fd.append('subject', $scope.groupinfo.subject);
		fd.append('message', $scope.groupinfo.message);
		      $http({
		   method: 'post',
		   url: BASE_URL+'api/group/send_group_mail',
		   data: fd,
		   headers: {'Content-Type': undefined},
		  }).then(function (res) 
				{  
				
					var result = res.data;	
					if(result.success == 'true')
					{ 
				$scope.groupinfo.subject = "";
						$scope.groupinfo.message ="";
					
				
						$scope.message = res.data.message;
						$scope.errors =  "";
					} else {
						$scope.message = "";
						$scope.errors =  res.data.message
					}
						       
				},function(error) 
				{
					$scope.message =  "";
						$scope.errors = error.data.error;
					
				});	
		} else {
			$scope.message = "Invalid Group";
					      
		}
	}
	
	
}

function MyresultsCtrl($scope, $http) 
{
	
	$http.get(BASE_URL+'api/user/getprofile')
   .then(function(response) {
      $scope.profileinfo = response.data.data;
	 
    });
	
}

function AboutCtrl($scope, $http, $anchorScroll) 
{
	$anchorScroll();
	var formData = {'id': 2};
	$http.post(BASE_URL+'api/pages/ActivepageDetail', formData , {
			headers:{		
				'token':TOKEN,
				'Content-Type':'application/json',
			}
			})
   .then(function(response) {
      $scope.contentinfo = response.data.data;
	 
    });
}
function ContactCtrl($scope, $http, $anchorScroll) 
{
	$anchorScroll();
	$scope.contactinfo = [];
	$scope.sendmessage = function() {
		
		var fd = new FormData();
		
		 fd.append('name', $scope.contactinfo.name);
         fd.append('email', $scope.contactinfo.email);
		 fd.append('phone', $scope.contactinfo.phone);
		 fd.append('message', $scope.contactinfo.message);
		  
		  $http({
		   method: 'post',
		   url: BASE_URL+'api/pages/contact_us',
		   data: fd,
		   headers: {'Content-Type': undefined},
		  }).then(function (res) 
				{  
				
					var result = res.data;	
					if(result.success == 'true')
					{ 
					$scope.error  = "";
						$scope.errors = [];
						$scope.message = res.data.message;
						 $scope.contactinfo.name = "";
						 $scope.contactinfo.email = "";
						 $scope.contactinfo.phone = "";
						 $scope.contactinfo.message = "";
						
					}
					if(result.success == "error")
					{
						$scope.message = "";
						$scope.error  = "";
						$scope.errors = res.data.error;
					}
					if(result.success == "false")
					{
						$scope.message = "";
						$scope.errors = [];
						$scope.error = res.data.message;
					}
								
				},function(error) 
				{
					
						$scope.message = error.data.error;
					
				});
		
	}
}



function allPageCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) 
{
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/pages/getAllPage').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('title').withTitle('Title'),
		 DTColumnBuilder.newColumn(null).withTitle('Banner image').renderWith(function(data, type, full, meta) {
			 
            return '<img src="'+BASE_URL+'data/images/'+data.banner_image+'">'
         }),
		 DTColumnBuilder.newColumn('short_description').withTitle('Short description'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			
            return '<a class="back_btn" href="#!/page-edit/'+data.id+'"><i class="fa fa-pencil"></i> Edit</a><button type="button" class="btn btn-danger btn back_btn" onclick="deletepage('+data.id+')">Delete</button>'
         }),
      ];  
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}


function allAppointmentCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) 
{
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/pages/getAllPage').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('title').withTitle('Title'),
		 DTColumnBuilder.newColumn(null).withTitle('Banner image').renderWith(function(data, type, full, meta) {
			 
            return '<img src="'+BASE_URL+'data/images/'+data.banner_image+'">'
         }),
		 DTColumnBuilder.newColumn('short_description').withTitle('Short description'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			
            return '<a class="back_btn" href="#!/page-edit/'+data.id+'"><i class="fa fa-pencil"></i> Edit</a><button type="button" class="btn btn-danger btn back_btn" onclick="deletepage('+data.id+')">Delete</button>'
         }),
      ];  
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}


function allUserCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) 
{
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/user/getAllUsers').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
		 DTColumnBuilder.newColumn('first_name').withTitle('First Name'),
		 DTColumnBuilder.newColumn('last_name').withTitle('Last Name'),
         DTColumnBuilder.newColumn('email').withTitle('Email'),
		 DTColumnBuilder.newColumn('role').withTitle('Role'),
		 
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			
            return '<a class="back_btn" href="#!/user-edit/'+data.ID+'"><i class="fa fa-pencil"></i> Edit</a><button type="button" class="btn btn-danger btn back_btn" onclick="deleteuser('+data.ID+')">Delete</button>'
         }),
      ];  
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}

function editPageCtrl($scope, $http, $routeParams,$timeout) 
{
	$scope.pageinfo 	= {
	
		id:false,
		title:'',
		short_description:'',
		banner_image:'',
		description:'',
		is_active:'1'
		
	};
	
	CKEDITOR.replace( 'editor', {
        filebrowserBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php',
        filebrowserImageBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php?type=Images',
        filebrowserUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php',
        filebrowserImageUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php?type=Images',
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P
    });
	
	var tid;
	$scope.companyID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.companyID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.companyID;
	};	
	$timeout($scope.setID(), 2000);
	var formData = {'id': $routeParams.ID};
	if($routeParams.ID!=0){
	//$scope.pageinfo = false;
	$http.post(BASE_URL+'api/pages/pageDetail', formData)
   .then(function(response) {
                $scope.pageinfo.id 					= response.data.data.id;
				$scope.pageinfo.title 				= response.data.data.title;
				$scope.pageinfo.short_description 		= response.data.data.short_description;
				$scope.pageinfo.is_active 	= response.data.data.is_active;
				$scope.pageinfo.banner_image 	= response.data.data.banner_image;
				$scope.pageinfo.description 			= response.data.data.description;
				
				CKEDITOR.instances.editor.setData($scope.pageinfo.description);
	 
    });
	}
	
$scope.editprofile = function()
    {
		var page_id = $scope.pageinfo.id!=undefined ? $scope.pageinfo.id :''; 
		var fd = new FormData();
		angular.forEach($scope.banner_image,function(banner_image){
  fd.append('banner_image', banner_image);
 });
 
        $scope.pageinfo.description 	= CKEDITOR.instances.editor.getData();
        fd.append('page_id', page_id);
        fd.append('title', $scope.pageinfo.title);
		fd.append('short_description', $scope.pageinfo.short_description);
		fd.append('description', $scope.pageinfo.description);
		fd.append('is_active', $scope.pageinfo.is_active);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/pages/updatePage',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(page_id==""){
		        $scope.pageinfo={};
				//$scope.pageinfo.description = '';
		}
                $scope.message = res.data.message;
            }
            if(res.data.status == "error")
            {
                $scope.message = res.data.error;
            }            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
	
}

function allTestimonialCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) 
{
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/testimonials/getAllTestimonial').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('name').withTitle('Name'),
		 DTColumnBuilder.newColumn(null).withTitle('User image').renderWith(function(data, type, full, meta) {
			 
            return '<img src="'+BASE_URL+'img/testimonialImages/'+data.user_image+'">'
         }),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			
            return '<a class="back_btn" href="#!/testimonial-edit/'+data.id+'"><i class="fa fa-pencil"></i> Edit</a><button type="button" class="btn btn-danger btn back_btn" onclick="deleteTestimonial('+data.id+')">Delete</button>'
         }),
      ];   
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}


function editTestimonialCtrl($scope, $http, $routeParams,$timeout) 
{
	$scope.testimonialinfo 	= {
	
		id:false,
		name:'',
		user_image:'',
		description:'',
		is_active:'1'
		
	};
	CKEDITOR.replace( 'editor', {
        filebrowserBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php',
        filebrowserImageBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php?type=Images',
        filebrowserUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php',
        filebrowserImageUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php?type=Images',
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P
    });
	
	var tid;
	$scope.companyID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.companyID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.companyID;
	};	
	$timeout($scope.setID(), 2000);
	var formData = {'id': $routeParams.ID};
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/testimonials/testimonialDetail', formData)
   .then(function(response) {
	   $scope.testimonialinfo.id = response.data.data.id;
	   $scope.testimonialinfo.name = response.data.data.name;
	   $scope.testimonialinfo.is_active = response.data.data.is_active;
	   $scope.testimonialinfo.user_image = response.data.data.user_image;
	   $scope.testimonialinfo.description = response.data.data.description;
	   CKEDITOR.instances.editor.setData($scope.testimonialinfo.description);
      
    });
	}
	
$scope.editprofile = function()
    {
		var testimonial_id = $scope.testimonialinfo.id!=undefined ? $scope.testimonialinfo.id :''; 
		var fd = new FormData();
		
		angular.forEach($scope.user_image,function(user_image){
  fd.append('user_image', user_image);
 });
 $scope.testimonialinfo.description 	= CKEDITOR.instances.editor.getData();
        fd.append('testimonial_id', testimonial_id);
        fd.append('name', $scope.testimonialinfo.name);
		fd.append('description', $scope.testimonialinfo.description);
		fd.append('is_active', $scope.testimonialinfo.is_active);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/testimonials/updateTestimonial',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(testimonial_id==""){
		        $scope.testimonialinfo={};
				$scope.testimonialinfo.description = '';
		}
                $scope.message = res.data.message;
            }
            if(res.data.status == "error")
            {
                $scope.message = res.data.error;
            }            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
	
}

function allSliderCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) 
{
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/sliders/getAllSliders').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('title').withTitle('Title'),
		 DTColumnBuilder.newColumn(null).withTitle('Slider image').renderWith(function(data, type, full, meta) {
			 
            return '<img src="'+BASE_URL+'img/sliderimage/'+data.banner_image+'">'
         }),
		 DTColumnBuilder.newColumn('slider_link').withTitle('Slider Link'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			
            return '<a class="back_btn" href="#!/slider-edit/'+data.id+'"><i class="fa fa-pencil"></i> Edit</a><button type="button" class="btn btn-danger btn back_btn" onclick="deleteSlider('+data.id+')">Delete</button>'
         }),
      ];   
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}

function editSliderCtrl($scope, $http, $routeParams,$timeout) 
{
	
	var tid;
	$scope.companyID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.companyID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.companyID;
	};	
	$timeout($scope.setID(), 2000);
	var formData = {'id': $routeParams.ID};
	if($routeParams.ID!=0){
	$scope.sliderinfo = false;
	$http.post(BASE_URL+'api/sliders/sliderDetail', formData)
   .then(function(response) {
      $scope.sliderinfo = response.data.data;
	 
    });
	}
	
$scope.editprofile = function()
    {
		var slider_id = $scope.sliderinfo.id!=undefined ? $scope.sliderinfo.id :''; 
		var fd = new FormData();
		angular.forEach($scope.banner_image,function(banner_image){
  fd.append('banner_image', banner_image);
 });
        fd.append('slider_id', slider_id);
        fd.append('title', $scope.sliderinfo.title);
		fd.append('slider_link', $scope.sliderinfo.slider_link);
		fd.append('description', $scope.sliderinfo.description);
		fd.append('is_active', $scope.sliderinfo.is_active);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/sliders/updateSlider',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(slider_id==""){
		        $scope.sliderinfo={};
				$scope.sliderinfo.description = '';
		}
                $scope.message = res.data.message;
            }
            if(res.data.status == "error")
            {
                $scope.message = res.data.error;
            }            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
	
}

function webSettingsCtrl($scope, $http) 
{
	
	$scope.formName  = 'editform';
	
	$http.get(BASE_URL+'api/pages/settingsDetail')
   .then(function(response) {
      $scope.settingsinfo = response.data.data;
	 
    });
	
	
$scope.editsettings = function()
    {
		var settings_id = $scope.settingsinfo.id!=undefined ? $scope.settingsinfo.id :''; 
		var fd = new FormData();
		angular.forEach($scope.logo,function(logo){
  fd.append('logo', logo);
 });
        fd.append('settings_id', settings_id);
        fd.append('title', $scope.settingsinfo.title);
		fd.append('tagline', $scope.settingsinfo.tagline);
		fd.append('website', $scope.settingsinfo.website);
		fd.append('email', $scope.settingsinfo.email);
		fd.append('phone_number', $scope.settingsinfo.phone_number);
		fd.append('copyright', $scope.settingsinfo.copyright);
		fd.append('address', $scope.settingsinfo.address);
		fd.append('facebook', $scope.settingsinfo.facebook);
		fd.append('twitter', $scope.settingsinfo.twitter);
		fd.append('instagram', $scope.settingsinfo.instagram);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/pages/updateSettings',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(settings_id==""){
		        $scope.settingsinfo={};
		}
                $scope.message = res.data.message;
            }
            if(result.success == "false")
            {
                $scope.message = res.data.message;
            }            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
}

function allCategoryCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) 
{
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/categories/getAllCategories').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('title').withTitle('Title'),
		 DTColumnBuilder.newColumn(null).withTitle('Feature image').renderWith(function(data, type, full, meta) {
			 
            return '<img src="'+BASE_URL+'img/categories/'+data.feature_image+'">'
         }),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			
            return '<a class="back_btn" href="#!/category-edit/'+data.id+'"><i class="fa fa-pencil"></i> Edit</a><button type="button" class="btn btn-danger btn back_btn" onclick="deleteCategory('+data.id+')">Delete</button>'
         }),
      ];   
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}

function editCategoryCtrl($scope, $http, $routeParams,$timeout) 
{
	$scope.categoryinfo 	= {
	
		id:false,
		title:'',
		feature_image:'',
		description:'',
		is_active:'1'
		
	};
	
	CKEDITOR.replace( 'editor', {
        filebrowserBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php',
        filebrowserImageBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php?type=Images',
        filebrowserUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php',
        filebrowserImageUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php?type=Images',
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P
    });
	
	var tid;
	$scope.companyID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Amistos");
		$scope.companyID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.companyID;
	};	
	$timeout($scope.setID(), 2000);
	var formData = {'id': $routeParams.ID};
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/categories/categoryDetail', formData)
   .then(function(response) {
	   $scope.categoryinfo.id = response.data.data.id;
	   $scope.categoryinfo.title = response.data.data.title;
	   $scope.categoryinfo.is_active = response.data.data.is_active;
	   $scope.categoryinfo.feature_image = response.data.data.feature_image;
	   $scope.categoryinfo.description = response.data.data.description;
	   CKEDITOR.instances.editor.setData($scope.categoryinfo.description);
    });
	}
	
$scope.editcategory = function()
    {
		var category_id = $scope.categoryinfo.id!=undefined ? $scope.categoryinfo.id :''; 
		var fd = new FormData();
		angular.forEach($scope.feature_image,function(feature_image){
  fd.append('feature_image', feature_image);
 });
 $scope.categoryinfo.description 	= CKEDITOR.instances.editor.getData();
        fd.append('category_id', category_id);
        fd.append('title', $scope.categoryinfo.title);
		fd.append('description', $scope.categoryinfo.description);
		fd.append('is_active', $scope.categoryinfo.is_active);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/categories/updateCategory',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		   if(category_id==""){
		        $scope.categoryinfo={};
		    }
                $scope.message = res.data.message;
            }
            

            var Gritter = function () {
				$.gritter.add({
					title: res.data.title,
					text: res.data.message
				});
			return false;
			}();            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
	
}

 

function editUserCtrl($scope, $http, $routeParams,$timeout) 
{ 
	$scope.productinfo 	= {
		id:"",
		username:'',
		first_name:'',
		last_name:'',
		email:'',
		role:'',
		password:'',
		status:'',
		profilepic:'',
		active:'1'
		
	};
	
	
	
	var tid;
	$scope.companyID = '';
	$scope.formName  = 'editform';
	
	//$timeout($scope.setID(), 2000);
	var formData = {'id': $routeParams.ID};
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/user/userDetail', formData)
   .then(function(response) {
	   $scope.productinfo.id = response.data.data.ID;
	   $scope.productinfo.login_id = response.data.data.login_id;
	   $scope.productinfo.email = response.data.data.email;
	   $scope.productinfo.first_name = response.data.data.first_name;
	   $scope.productinfo.last_name = response.data.data.last_name;
	   $scope.productinfo.password = "";
	   $scope.productinfo.active = response.data.data.active;
	   $scope.productinfo.role = response.data.data.role;
	   $scope.productinfo.profilepic = response.data.data.profilepic;
    });
	}
	
$scope.editproduct = function()
    {
		var user_id = $scope.productinfo.id!=undefined ? $scope.productinfo.id :''; 
		var fd = new FormData();
		angular.forEach($scope.profilepic,function(profilepic){
  fd.append('profilepic', profilepic);
 });

        fd.append('user_id', user_id);
        fd.append('login_id', $scope.productinfo.login_id);
		fd.append('email', $scope.productinfo.email);
		fd.append('first_name', $scope.productinfo.first_name);
		fd.append('last_name', $scope.productinfo.last_name);
		fd.append('password', $scope.productinfo.password);
		fd.append('role', $scope.productinfo.role);
		fd.append('active', $scope.productinfo.active);
  
        $http({
   method: 'post',
   url: BASE_URL+'api/user/updateUser',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		   if(user_id==""){
		        $scope.productinfo={};
		    }
                $scope.message = res.data.message;
            }
            

            var Gritter = function () {
				$.gritter.add({
					title: res.data.title,
					text: res.data.message
				});
			return false;
			}();            
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
    }
	
	
	
}
