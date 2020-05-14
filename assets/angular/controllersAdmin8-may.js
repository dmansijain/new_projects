'use strict';

//Controllers
function DashboardCtrl($scope, $http) 
{
	
}



function allPageCtrl($scope, $compile, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $timeout, $routeParams, $window, $filter, $location, $route) 
{
	
	
	
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	$scope.deletePage = deletePage;
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/pages/getAllPage').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']])
        .withOption('createdRow', createdRow);       
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('title').withTitle('Title'),
		 DTColumnBuilder.newColumn(null).withTitle('Banner image').renderWith(function(data, type, full, meta) {
			 if(data.banner_image != "") {
            return '<img src="'+BASE_URL+'uploads/bannerimg/'+data.banner_image+'" style="width:100px;">';
			 } else {
				 return '<img src="'+BASE_URL+'assets/images/dummy.jpg" style="width:100px;">';
			 }
         }),
		 DTColumnBuilder.newColumn('short_description').withTitle('Short description'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			 var encrypted ;
			 encrypted = $scope.encryptStr(data.id);
            return '<a title="Edit" class="EditFaIcons" href="#!/page-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a> <a href="javascript:void(0);" title="delete" class="btn btn-danger btn FaIcons" ng-click="deletePage('+data.id+')"><i class="fa fa-trash"></a>'
         }),
      ];  
	  
	  function deletePage(pageID) {
		 
		if ($window.confirm("Are you want to delete this Page?")) {
			
		var formData = {'page_id': pageID};
          $http.post(BASE_URL+'api/pages/deletePage', formData).then(function(result) {
			  
                if(result.data.success == 'true') {
					 var Gritter = function () {
						$.gritter.add({
							title: "",
							text: "Page deleted successfully"
								});
							return false;
							}(); 
					$timeout($route.reload(), 2000);
					
					
				}
          });
		}
		
	}
	function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}

function GroupManageCtrl($scope, $compile, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $timeout, $routeParams, $window, $filter, $route){
	
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	$scope.deletegroup = deletegroup;
	 $scope.dtInstance = {};
	 $scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/group/getAllGroups').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })
        .withPaginationType('full_numbers')
		 .withOption('createdRow', createdRow);   
    $scope.dtColumns = [
        DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),
       DTColumnBuilder.newColumn('group_name').withTitle('Group Name'),
		
         DTColumnBuilder.newColumn('group_email').withTitle('Group Email'),
		 DTColumnBuilder.newColumn('title').withTitle('Community'),
		 DTColumnBuilder.newColumn('group_description').withTitle('Description'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			var encrypted ;
			 encrypted = $scope.encryptStr(data.id);
			 var html = '<a title="Edit" class="EditFaIcons" href="#!/group-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a><button title="Delete" class="btn btn-danger btn FaIcons" ng-click="deletegroup('+data.id+')"><i class="fa fa-trash"></i></button>';
			 
            return html;
         }),
		  
    ];   
	
	function deletegroup(groupID) {
		if($window.confirm("Are you want to delete this User?")) {
			var formData = {'group_id': groupID};
			$http.post(BASE_URL+'api/group/deleteGroup', formData)
	   .then(function(response) {
		   //console.log(response.data.data);
		   if(response.data.success !='false'){
			    var Gritter = function () {
						$.gritter.add({
							title: "",
							text: "Group deleted successfully"
								});
							return false;
							}(); 
					$timeout($route.reload(), 2000);
			
		   }
		 
		});
		}
	}
	
	function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
	
	 
}

function editGroupCtrl($scope, $http, $routeParams,$timeout, $window, $location, $uibModal) {
		$scope.date = new Date();
		$scope.gPlace;

	  $scope.alltype = {};
	  $scope.alltypename = {};
	  $scope.roles = ["participant","staff"];
	
	$scope.eventinfo 	= {
		id:"",
event_community:'',
event_category:'',
event_type:'',
event_name:'',
start_date:'',
end_date:'',
start_time:'',
end_time:'',
cost:'',
min_deposit:'',
max_attendees:'',
max_staff:'',
details:'',
details_popup:'',
location:'',
lat:'',
lng:'',
skill_requirement:[],
skill_condition:[''],
skill_earned:'',
invite_code:'',
		};
	
	
	  $http.get(BASE_URL+'api/skill/getallActiveskills')
   .then(function(responses) {
	   $scope.allskills = responses.data.data;
	  
    });
	$http.get(BASE_URL+'api/event/getallcommunity')
   .then(function(responses) {
	   $scope.allcommunity = responses.data.data;
	  
    });
	$http.get(BASE_URL+'api/event/getallcategory')
   .then(function(responses) {
	   $scope.allcategory = responses.data.data;
	  
    });
	
	
     $scope.choices = [''];
	
	$scope.addNewChoice = function() {
     var newItemNo = $scope.choices.length+1;
     $scope.choices.push({'id' : 'choice' + newItemNo, 'name' : 'choice' + newItemNo});
   };
  $scope.removeNewChoice = function() {
     var newItemNo = $scope.choices.length-1;
     if ( newItemNo !== 0 ) {
      $scope.choices.pop();
     }
   };   
	
	CKEDITOR.replace( 'editor'); 
	CKEDITOR.add
	CKEDITOR.replace( 'details_popup');
	CKEDITOR.add
	var tid;
	$scope.groupID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.groupID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.groupID;
	};	
	$timeout($scope.setID(), 2000);
	
	
	
	var formData = {'id': $scope.groupID};
	
	
	
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/group/groupDetail', formData)
   .then(function(response) {
	   $scope.eventinfo = response.data.data;
	   $scope.created_by = response.data.data.created_by;
	  
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.skill_condition = response.data.data.skill_condition.split(',');
	   $scope.eventinfo.leader = response.data.data.leader.split(',');
	   $scope.choices = $scope.eventinfo.skill_requirement;
	   //console.log($scope.eventinfo.choices);
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
	   
	   $scope.eventinfo.details = response.data.data.details;
	   $scope.eventinfo.details_popup = response.data.data.details_popup;
	   CKEDITOR.instances.editor.setData($scope.eventinfo.details);
	   CKEDITOR.instances.details_popup.setData($scope.eventinfo.details_popup);
	  
	  
	   
	   
	   if ($scope.eventinfo.event_category !== "") {
		
		  var formData = {'cat_id': $scope.eventinfo.event_category};
		$http.post(BASE_URL+'api/event/getgrouptype', formData)
		   .then(function(response) {
			  $scope.alltype = response.data.data; 
			});	
      }
	  
	  if ($scope.eventinfo.event_category !== "" || $scope.eventinfo.event_type !== "") {
		  
		  var formData = {'cat_id': $scope.eventinfo.event_category, 'event_type_id': $scope.eventinfo.event_type};
       $http.post(BASE_URL+'api/event/getalltypename', formData)
   .then(function(response) {
      $scope.alltypename = response.data.data; 
    });	
      }
	  
	  
	  
	  if ($scope.eventinfo.skill_requirement !== "") {
		  
		  var formData = {'skill': $scope.eventinfo.skill_requirement, 'condition': $scope.eventinfo.skill_condition};
       $http.post(BASE_URL+'api/event/getallleaders', formData)
   .then(function(response) {
	  
      $scope.allleaders = response.data.data; 
    });	
      }
	  
    });
	
	
		
		$http.get(BASE_URL+'api/user/validate_event_manager?page=editevent&eventid='+ $scope.eventID)
		   .then(function(response) {
			   //console.log(response.data.data);
			   if(response.data.success !='false'){
				   $window.location.href = BASE_URL+'admindashboard#!';
				
			   }
			 
			});
		
		
		}
	
	
	
	
	$scope.getEventtypelist = function () {
      if ($scope.eventinfo.event_category !== "") {
		  
		  var formData = {'cat_id': $scope.eventinfo.event_category};
       $http.post(BASE_URL+'api/event/getgrouptype', formData)
   .then(function(response) {
      $scope.alltype = response.data.data; 
    });	
      }
    };
	
	$scope.getEventtypelists = function () {
      if ($scope.submittypename.cat_id !== "") {
		  
		  var formData = {'cat_id': $scope.submittypename.cat_id};
       $http.post(BASE_URL+'api/event/getalltype', formData)
   .then(function(response) {
      $scope.alltype = response.data.data; 
    });	
      }
    };
	
	
	
	
	$scope.getleaderlist = function () {
      if ($scope.eventinfo.skill_requirement !== "") {
		  
		  var formData = {'skill': $scope.eventinfo.skill_requirement, 'condition': $scope.eventinfo.skill_condition};
       $http.post(BASE_URL+'api/event/getallleaders', formData)
   .then(function(response) {
	  
      $scope.allleaders = response.data.data; 
    });	
      }
    };
	
   
	
	$scope.submitcommunity 	= {id:"",title:'',};		
	$scope.addcommunity = function()
    {
		var fcommunity = new FormData();
		
        fcommunity.append('title', $scope.submitcommunity.title);
		$http({
   method: 'post',
   url: BASE_URL+'api/event/addcommunity',
   data: fcommunity,
   headers: {'Content-Type': undefined},
  }).then(function (rescommunity) 
        { 
            if(rescommunity.data.success == 'true')
            {
		   $scope.submitcommunity.title = '';
           $scope.allcommunity = rescommunity.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Community',
					text: rescommunity.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	$scope.submitcategory 	= {id:"",title:'',};	
    $scope.addcategory = function()
    {
		var fcategory = new FormData();
		
        fcategory.append('title', $scope.submitcategory.title);
		$http({
   method: 'post',
   url: BASE_URL+'api/event/addcategory',
   data: fcategory,
   headers: {'Content-Type': undefined},
  }).then(function (rescategory) 
        { 
            if(rescategory.data.success == 'true')
            {
		   $scope.submitcategory.title = '';
           $scope.allcategory = rescategory.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Category',
					text: rescategory.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	
	
	
	$scope.submitskills 	= {id:"",title:''};
    $scope.addskills = function()
    {
		var fskills = new FormData();
		
        fskills.append('name', $scope.submitskills.title);
		fskills.append('description', '');
		fskills.append('is_active', '1');
		$http({
   method: 'post',
   url: BASE_URL+'api/skill/updateSkill',
   data: fskills,
   headers: {'Content-Type': undefined},
  }).then(function (restype) 
        { 
            if(restype.data.success == 'true')
            {
		   $scope.submitskills.title = '';
           $scope.allskills = restype.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Skills',
					text: restype.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	
$scope.editprofile = function()
    {
		
		//console.log($scope.eventinfo);
		var event_id = $scope.eventinfo.event_id!=undefined ? $scope.eventinfo.event_id :''; 
		var fd = new FormData();
		
        fd.append('event_id', event_id);
		fd.append('event_community', $scope.eventinfo.event_community);
		fd.append('event_category', $scope.eventinfo.event_category);
		fd.append('event_type', $scope.eventinfo.event_type);
        fd.append('group_name', $scope.eventinfo.group_name);
		
		fd.append('group_id', $scope.groupID);
		//fd.append('event_name', $scope.eventinfo.event_name);
		fd.append('start_date', moment($scope.eventinfo.start_date).format("YYYY-MM-DD"));
		fd.append('end_date', moment($scope.eventinfo.end_date).format("YYYY-MM-DD"));
		if($scope.eventinfo.start_time == "") {
			fd.append('start_time', $scope.eventinfo.start_time);
		} else {
		fd.append('start_time', new Date($scope.eventinfo.start_time).getHours() +':'+ new Date($scope.eventinfo.start_time).getMinutes() +':'+ new Date($scope.eventinfo.start_time).getSeconds());
		}
		if($scope.eventinfo.end_time == "") {
		fd.append('end_time', $scope.eventinfo.end_time);
		} else {
			fd.append('end_time', new Date($scope.eventinfo.end_time).getHours() +':'+ new Date($scope.eventinfo.end_time).getMinutes() +':'+ new Date($scope.eventinfo.end_time).getSeconds());
		}
		fd.append('cost', $scope.eventinfo.cost);
		fd.append('min_deposit', $scope.eventinfo.min_deposit);
		fd.append('max_attendees', $scope.eventinfo.max_attendees);
		fd.append('max_staff', $scope.eventinfo.max_staff);
		var raghavs = CKEDITOR.instances.editor.getData($scope.eventinfo.details);
		var raghav = CKEDITOR.instances.details_popup.getData($scope.eventinfo.details_popup)
		fd.append('details', raghavs);
		fd.append('details_popup', raghav);
		if($scope.eventinfo.age_requirement!= undefined) {
			
		fd.append('age_requirement', $scope.eventinfo.age_requirement);
		
		}
		fd.append('location', $scope.eventinfo.location);
		fd.append('lat', $scope.eventinfo.lat);
		fd.append('lng', $scope.eventinfo.lng);
		fd.append('security', $scope.eventinfo.security);
		fd.append('skill_requirement', $scope.eventinfo.skill_requirement);
		fd.append('skill_condition', $scope.eventinfo.skill_condition);
		fd.append('leader', $scope.eventinfo.leader);
		fd.append('invite_code', $scope.eventinfo.invite_code);
		fd.append('skill_earned', $scope.eventinfo.skill_earned);
		fd.append('role', $scope.eventinfo.role);
		
        $http({
   method: 'post',
   url: BASE_URL+'api/group/updateGroupEvent',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(event_id==""){
		        $scope.eventinfo={};
				$scope.eventinfo.description = '';
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

function allUserCtrl($scope, $compile, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $timeout, $routeParams, $window, $filter, $route) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	
	var m;
    $scope.message = '';
    $scope.dtInstance = {};
    $scope.persons = {};
	$scope.deleteuser = deleteuser;
    $scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/user/getAllUsers').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })
        .withPaginationType('full_numbers')
		 .withOption('createdRow', createdRow);   
    $scope.dtColumns = [
        DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),
       DTColumnBuilder.newColumn('first_name').withTitle('First Name'),
		 DTColumnBuilder.newColumn('last_name').withTitle('Last Name'),
         DTColumnBuilder.newColumn('email').withTitle('Email'),
		 DTColumnBuilder.newColumn('role').withTitle('Role'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			var encrypted ;
			 encrypted = $scope.encryptStr(data.ID);
			 var html = '<a title="Edit" class="EditFaIcons" href="#!/user-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a>';
			 if(data.is_login == 0) {
				 html = html + '<button title="Delete" class="btn btn-danger btn FaIcons" ng-click="deleteuser('+data.ID+')"><i class="fa fa-trash"></i></button>';
			 }
            return html;
         }),
		  DTColumnBuilder.newColumn(null).withTitle('Skills').renderWith(function(data, type, full, meta) {
			var encrypted ;
			 encrypted = $scope.encryptStr(data.ID);
            return '<a title="Edit" class="viewskills" href="#!/user-skills-journey/'+encrypted+'">View & Manage</a>'
         }),
    ];   
	
	function deleteuser(userID) {
		if($window.confirm("Are you want to delete this User?")) {
			var formData = {'user_id': userID};
			$http.post(BASE_URL+'api/user/deleteUser', formData)
	   .then(function(response) {
		   //console.log(response.data.data);
		   if(response.data.success !='false'){
			   var Gritter = function () {
						$.gritter.add({
							title: "",
							text: "User deleted successfully"
								});
							return false;
							}(); 
					$timeout($route.reload(), 2000);
			
		   }
		 
		});
		}
	}
	
	function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
	
}

function skillsJourneyCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $filter, $routeParams,$timeout, $window) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	
	$scope.productinfo = {};
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.userID = decrypted.toString(CryptoJS.enc.Utf8);
	};	
	$timeout($scope.setID(), 2000);
	
	$scope.assignskilltouser 	= {id:"",user_id:$scope.userID, skill_id:'' };		
	$scope.addskilltouser = function()
    {
		var fassignskill = new FormData();
		
        fassignskill.append('user_id', $scope.assignskilltouser.user_id);
		fassignskill.append('skill_id', $scope.assignskilltouser.skill_id);
		$http({
   method: 'post',
   url: BASE_URL+'api/skill/assignskill',
   data: fassignskill,
   headers: {'Content-Type': undefined},
  }).then(function (resassignskill) 
        { 
            if(resassignskill.data.success == 'true')
            {
		   $scope.assignskilltouser.skill_id = '';
           $scope.allassignskills = resassignskill.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Skill',
					text: resassignskill.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	
	
	$scope.qty = 10;
  
	$scope.skillsofuser = function()
    {
	$scope.addjourney = false;
	$scope.addskill = true;
	  
	 var formData = {id:$scope.userID};
       $http.post(BASE_URL+'api/skill/getassignskills', formData)
   .then(function(response) {
      $scope.allassignskills = response.data.data; 
	  $scope.alljourneys ="";
    });	
	
	 var formData = {};
       $http.post(BASE_URL+'api/skill/getallActiveskills', formData)
   .then(function(response) {
      $scope.allskills = response.data.data; 
	  $scope.alljourneys ="";
    });	
	
	}
	$scope.skillsofuser();
	
	$scope.journeyofuser = function()
    {
	$scope.addjourney = true;
	$scope.addskill = false;
	
	 var formData = {};
       $http.post(BASE_URL+'api/event/getallevents', formData)
   .then(function(response) {
      $scope.alljourneys = response.data.data;
      $scope.allskills ="";	  
    });	
	   
	}
	
	$scope.increment = function(data) {
	data.id++;
    };
    $scope.decrement = function(data) {
    data.id--;
    };
	
	
	var formData = {'id': $scope.userID};
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
}

function editPageCtrl($scope, $http, $routeParams,$timeout, $window, $location) 
{
	$scope.pageinfo 	= {
	
		id:false,
		title:'',
		short_description:'',
		banner_image:'',
		description:'',
		is_active:'1'
		
	};
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	
	CKEDITOR.replace( 'editor', {
        filebrowserBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php',
        filebrowserImageBrowseUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgbrowser.php?type=Images',
        filebrowserUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php',
        filebrowserImageUploadUrl: BASE_URL+'assets/admin/js/ckeditor/ckeditor/plugins/imageuploader/imgupload.php?type=Images',
        enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P
    });
	
	var tid;
	$scope.pageID = '';
	$scope.formName  = 'editform';
	if($routeParams.ID!=0){
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.pageID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.pageID;
	};	
	$timeout($scope.setID(), 2000);
	
	
	
	var formData = {'id': $scope.pageID};
	
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
		var page_id = $scope.pageinfo.id!="" ? $scope.pageinfo.id :''; 
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
				CKEDITOR.instances.editor.setData('');
				//$scope.pageinfo.description = '';
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


function allEventCtrl($scope, $compile, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $timeout, $routeParams, $window, $filter, $location, $route) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	var m;
    $scope.message = '';
    //$scope.edit = edit;
	//$scope.viewNotes = viewNotes;
	//$scope.addNotes = addNotes;
	//$scope.addAppointment = addAppointment;
    //$scope.delete = deleteRow;
	$scope.newSource = newSource;
    $scope.reloadData = reloadData;
	$scope.deleteEvent = deleteEvent;
    $scope.dtInstance = {};
    $scope.persons = {};
	$scope.createdRow = createdRow;
    $scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/event/getAlladmindata').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })
        .withPaginationType('full_numbers')
		 .withOption('createdRow', createdRow);
		// .withTableTools('vendor/datatables-tabletools/swf/copy_csv_xls_pdf.swf')
        // .withTableToolsButtons({
           // 'dom': 'Bfrtip',
    // 'buttons': [
        // 'copy', 'excel', 'pdf'
    // ]
        // });
    $scope.dtColumns = [
        DTColumnBuilder.newColumn(null).withTitle('Job ID').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),
         DTColumnBuilder.newColumn('cattitle').withTitle('Event Category'),
		 DTColumnBuilder.newColumn('typetitle').withTitle('Event Type'),
         DTColumnBuilder.newColumn(null).withTitle('Event Type Name').renderWith(function(data, type, full, meta) {
			 
			 if(data.typenametitle != null) {
				 return data.typenametitle;
			 } else {
				  return data.event_typename;
				 
			 }
		 }),
		 DTColumnBuilder.newColumn('cost').withTitle('Price'),
		 DTColumnBuilder.newColumn('max_attendees').withTitle('Members'),
		 //DTColumnBuilder.newColumn('max_attendees').withTitle('Round'),
		 DTColumnBuilder.newColumn('location').withTitle('City'),
		 //DTColumnBuilder.newColumn('security').withTitle('Status'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			 var encrypted ;
			 encrypted = $scope.encryptStr(data.id);
			
            return '<a title="Edit" class="EditFaIcons event_ico" href="#!/event-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a> <a href="#!/event-detail/'+encrypted+'" title="view" class="btn btn-danger btn FaIcons event_ico"><i class="fa fa-eye"></i></a><a href="#!/all-rosters/'+encrypted+'" title="Roster Detail" class="btn btn-danger btn FaIcons event_ico" style="color:white;"><i class="fa fa-file-text-o"></i></a></a><button ng-click="deleteEvent('+data.id+');" title="Delete" class="btn btn-danger btn FaIcons event_ico" style="color:white;" ><i class="fa fa-trash"></i></button>'
         })
    ];
	
	function deleteEvent(eventID) {
		if ($window.confirm("Are you want to delete this event?")) {
		
		var formData = {'event_id': eventID};
          $http.post(BASE_URL+'api/event/deleteEvent', formData).then(function(result) {
			  
                if(result.data.success == 'true') {
					 var Gritter = function () {
						$.gritter.add({
							title: "",
							text: "Event deleted successfully"
								});
							return false;
							}(); 
					$timeout($route.reload(), 2000);
					
				}
          });
		}
		
	}
	
	
	$scope.eventinfo 	= {start_date:"",end_date:''};
	function newSource() {
         var defer = $q.defer();
		 console.log($scope.eventinfo);
		 var formData = {'from_date': $scope.eventinfo.start_date  , 'end_date': $scope.eventinfo.end_date };
          $http.post(BASE_URL+'api/event/getAlladmindata', formData).then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
    }
	
	
	function reloadData() {
        var resetPaging = false;
        $scope.dtInstance.reloadData(callback, resetPaging);
    } 
	function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}


function EventdetailCtrl($scope, $http, $anchorScroll, $routeParams, $location, $timeout) 
{
	$anchorScroll();
	
	var tid;
	$scope.event_id = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.event_id = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.event_id;
	};
	
     $timeout($scope.setID(), 2000);
	
	if($routeParams.ID!=0){
	//console.log(res[res.length-1]);
	var formData = {'id': $scope.event_id};
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
       $scope.eventinfo = response.data.data;
	   $scope.eventinfo.event_map_location = response.data.data.location.replace(/\s+/g, '+');
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
    });	
	}
	
	
}

function allRosterCtrl($scope, $compile, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $timeout, $routeParams, $window, $filter, $route) 
{
	
	//alert("sdfdf");return false;
	var tid;
	$scope.current_event_name = '';
	$scope.event_detail = [];
	$scope.eventID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.eventID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.eventID;
	};
	$timeout($scope.setID(), 2000);

	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	$http.get(BASE_URL+'api/event/getAlladmindata')
   .then(function(response) {
	   
     $scope.eventlists = response.data.data;
    });
	
	$scope.eventFilter = function() {
        $window.location.href = '#!/all-rosters/'+$scope.encryptStr($scope.eventID);
	   
	   
   //console.log($scope.selectedItem);
 
    };
		var m;
    $scope.message = '';
	$scope.rostercount = 0;
    $scope.newSource = newSource;
    $scope.reloadData = reloadData;
	$scope.sendEmailNotification = sendEmailNotification;
	$scope.deleteRoster = deleteRoster;
	$scope.completeRoster = completeRoster;
	$scope.selectRoster = selectRoster;
	
    $scope.delete = deleteRow;
    $scope.dtInstance = {};
    $scope.persons = {};
	$scope.selectAll = false;
    $scope.alleventorders = [];
    $scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
		  var formdata = {"event_id": $scope.eventID};
          $http.post(BASE_URL+'api/roster/getAlladmindata',formdata).then(function(result) {
			  $scope.rostercount = result.data.data.length;
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })
        .withPaginationType('full_numbers')
        .withOption('createdRow', createdRow);
    $scope.dtColumns = [
		 DTColumnBuilder.newColumn(null)
                    .withTitle("")
					.notSortable()
					.renderWith(function (data, type, full, meta) {
						if(data.is_complete == 0) {
							var find = $scope.alleventorders.indexOf(data.event_order_id);
							if(find < 0) {
							$scope.alleventorders.push(data.event_order_id);
							}
							
						return "<input type='checkbox' class='checkboxes' name='rosterids[]' value='" + data.event_order_id + "'  ng-click='selectRoster(" + data.event_order_id+ ")' ng-model='selected[" + data.event_order_id + "]' id='selectcheckboxes"+ data.event_order_id +"'/>";
						} else {
							return '-';
						}
                       
                    }),
        DTColumnBuilder.newColumn(null).withTitle('Sr. No').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),
        DTColumnBuilder.newColumn(null).withTitle('Roster Name').renderWith(function(data, type, full, meta) {
            
				return data.full_name + ' - ' + data.typenametitle + ' , ' + $filter('date')(data.start_date, "MM/dd/yyyy");;
			
         }),
		 DTColumnBuilder.newColumn('email').withTitle('Email'),
		 DTColumnBuilder.newColumn('phone_number').withTitle('Phone Number'),
		DTColumnBuilder.newColumn('paid_amount').withTitle('Paid'),
		 DTColumnBuilder.newColumn(null).withTitle('Owed').renderWith(function(data, type, full, meta) {
            if(data.payment_type == "mindeposit"){
				return data.cost-data.paid_amount;
			} else {
				return '00.00';
			}
         }),
		DTColumnBuilder.newColumn('payment_status').withTitle('Status'),
		  DTColumnBuilder.newColumn(null).withTitle('Emails/<br>Notifications').renderWith(function(data, type, full, meta) {
			 
             if(data.payment_type == "mindeposit"){
				var owed = data.cost-data.paid_amount;
				
				if(owed != 0) {
					return '<button  ng-click="sendEmailNotification(' + data.event_order_id + ')" class="btn btn-danger btn FaIcons" title="Send Reminder Mail"><i class="fa fa-bell"></i></button>';
					
				} else {
					return '-';
				}
				
				
			} else {
				return '-';
			}
         }),
		DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			 var encrypted ;
			 encrypted = $scope.encryptStr(data.event_order_id);
            var html = '<a href="#!/roster-detail/'+encrypted+'" class="btn btn-danger btn FaIcons"><i class="fa fa-eye"></i></a><button ng-click = "deleteRoster(' + data.event_order_id + ');" title="delete" class="btn btn-danger btn FaIcons"><i class="fa fa-trash"></i></button>';
			if(data.is_complete == 0) {
			var html = html + '<button ng-click = "completeRoster(' + data.event_order_id + ')" title="complete" class="btn btn-danger btn FaIcons"><i class="fa fa-check"></i></button>';
			}
			return html;
			
         })
			
    ];
	
	 $scope.$on('event:dataTableLoaded', function(evt, loadedDT) {
		
        loadedDT.DataTable.data().each(function(data) {
            $scope.selected[data.event_order_id] = false;
			
        });
    });
	
	$scope.eventinfo 	= {start_date:"",end_date:''};
	function newSource() {
         var defer = $q.defer();
		
		 var formData = {'from_date': $scope.eventinfo.start_date  , 'end_date': $scope.eventinfo.end_date };
          $http.post(BASE_URL+'api/roster/getAlladmindata', formData).then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
    }
	
	
	if($scope.eventID != 0) {
		var formdata = {"id": $scope.eventID};
		$http.post(BASE_URL+'api/event/eventDetail', formdata)
	   .then(function(response) {
		   var eventname = response.data.data.typenametitle ? response.data.data.typenametitle : response.data.data.event_typename;
		   $scope.current_event_name =  eventname+ ', ' + response.data.data.location + ', ' + $filter('date')(response.data.data.start_date, "MM/dd/yyyy");
		   $scope.event_detail = response.data.data;
		  
		   
	   });
	}
	$scope.tmpeventIdCollection = [];
	$scope.checkAll = function(){
		if($scope.selectAll) {
			for (var i=0; i < $scope.alleventorders.length; i++) {
				var ele = document.getElementById('selectcheckboxes'+$scope.alleventorders[i]);
				angular.element(ele).prop('checked', true);
				if(angular.element(ele).val() != undefined) {
				$scope.tmpeventIdCollection.push(parseInt(angular.element(ele).val()));
				}
			}
		} else {
			for (var i=0; i < $scope.alleventorders.length; i++) {
				var ele = document.getElementById('selectcheckboxes'+$scope.alleventorders[i]);
				angular.element(ele).prop('checked', false);
				 var index = $scope.tmpeventIdCollection.indexOf($scope.alleventorders[i]);
				$scope.tmpeventIdCollection.splice(index, 1); 
			}
		}
		
		
	}
	
	
	
	
	function selectRoster(eventOrderID) {
		var ele = document.getElementById('selectcheckboxes'+eventOrderID);
		if(angular.element(ele).is(':checked')) {
		
			$scope.tmpeventIdCollection.push(eventOrderID);
		} else {
			
			 var index = $scope.tmpeventIdCollection.indexOf(eventOrderID);
			
			$scope.tmpeventIdCollection.splice(index, 1); 
			$scope.selectAll = false;
		}
	
		
	}
	
    
	function sendEmailNotification(eventOrderId) {
		var formdata = {"event_order_id": eventOrderId};
		$http.post(BASE_URL+'api/roster/send_notification_mail', formdata)
	   .then(function(response) {
		  if(response.data.success !='false'){
			  $window.alert(response.data.message);
		  }
		   
	   });
    }
    function deleteRoster(eventOrderId) {
		if ($window.confirm("Are you want to delete this Roster?")) {
		var formdata = {"event_order_id": eventOrderId};
		$http.post(BASE_URL+'api/roster/delete_roster', formdata)
	   .then(function(response) {
		  if(response.data.success !='false'){
			   var Gritter = function () {
						$.gritter.add({
							title: "",
							text: "Roster deleted successfully"
								});
							return false;
							}(); 
					$timeout($route.reload(), 2000);
		  }
		   
	   });
		}
    }
    
	function completeRoster(eventOrderId){
		
		if ($window.confirm("Are you want to complete this Roster?")) {
			
			if(eventOrderId != undefined) {
				$scope.orders = [];
				$scope.orders.push(eventOrderId);
				var formdata = {"event_order_id": $scope.orders};
			} else if($scope.tmpeventIdCollection.length != 0){
				
				var formdata = {"event_order_id": $scope.tmpeventIdCollection};
			} else{
				var formdata =  {"event_order_id": ""};
			}
			
			
		$http.post(BASE_URL+'api/roster/complete_roster', formdata)
	   .then(function(response) {
		  if(response.data.success !='false'){
			  $route.reload();
		  } else {
			  $scope.error_message = response.data.message;
		  }
		   
	   });
		}
	}
	
    function deleteRow(person) {
       
		if ($window.confirm("Please confirm?")) {
                    $scope.dtInstance.reloadData();
                } 
    }
    function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
	function reloadData() {
        var resetPaging = false;
        $scope.dtInstance.reloadData(callback, resetPaging);
    } 
  	
	

}


function RosterDetailCtrl($scope, $http, $routeParams,$timeout, $uibModal) 
{
	//alert("sdfdf");return false;
	
	var tid;
	$scope.roasterID = '';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.roasterID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.roasterID;
	};

		$timeout($scope.setID(), 2000);
	//alert($scope.roasterID);
	if($routeParams.ID!=0){
		
		
		$scope.eventOrder = function()
		{
			
			 var formData = {'id': $scope.roasterID};
			   $http.post(BASE_URL+'api/roster/getEventOrderDetail', formData)
		   .then(function(response) {
			  
			   $scope.event_order = response.data.data; 
			});	
		
		}
		$scope.eventOrder();
		$scope.biilinginfo = function()
		{
			
			 var formData = {'id': $scope.roasterID,'table': 'li_billing_info','joincolumn':'billing_id'};
			   $http.post(BASE_URL+'api/roster/getrosterinfo', formData)
		   .then(function(response) {
			  $scope.billinginfo = response.data.data;
				$scope.usertype = $scope.billinginfo.usertype;			  
			  $scope.allattendee = ""; 
			  $scope.payment_infos = "";
			   $scope.agreement_info = "";
			   $scope.health_info = "";
			   $scope.notification_info = "";	
			});	
		
		}
		
		$scope.attendeeinfo = function()
		{
			
			var formData = {'id': $scope.roasterID,'table': 'li_attende_info','joincolumn':'attende_id'};
			   $http.post(BASE_URL+'api/roster/getrosterinfo', formData)
		   .then(function(response) {
			   $scope.usertype = $scope.usertype;	
			  $scope.allattendee = response.data.data;
			  $scope.billinginfo = "";
				$scope.payment_infos = "";
				$scope.agreement_info = "";	
			$scope.notification_info = "";	
				$scope.health_info = "";			
			  
			});	
		
		}
		
		$scope.paymentinfo = function()
		{
			
			 var formData = {'id': $scope.roasterID,'table': 'li_payment','joincolumn':'payment_id'};
			   $http.post(BASE_URL+'api/roster/getrosterinfo', formData)
		   .then(function(response) {
			   $scope.usertype = $scope.usertype;	
			  $scope.billinginfo = "";
			  $scope.allattendee = "";
			  $scope.agreement_info = "";
			  $scope.payment_infos = response.data.data;	
			  $scope.notification_info = "";
			  $scope.health_info = "";
			});	
		
		}
	
			$scope.agreementinfo = function()
			{
				
				 var formData = {'id': $scope.roasterID,'table': 'li_agreements','joincolumn':'agreement_id'};
				   $http.post(BASE_URL+'api/roster/getrosterinfo', formData)
			   .then(function(response) {
				   $scope.usertype = $scope.usertype;	
				  $scope.billinginfo = "";
				  $scope.allattendee = "";
				  $scope.payment_infos = "";	
				  $scope.agreement_info = response.data.data;
				  $scope.notification_info = "";
				  $scope.health_info = "";
				});	
			
			}
		$scope.healthinfo = function()
			{
				
				 var formData = {'id': $scope.roasterID};
				   $http.post(BASE_URL+'api/roster/getrosterhealthinfo', formData)
			   .then(function(response) {
				   $scope.usertype = $scope.usertype;	
				  $scope.billinginfo = "";
				  $scope.allattendee = "";
				  $scope.payment_infos = "";	
				  $scope.agreement_info = "";
				  $scope.health_info = response.data.data;
				   $scope.notification_info = "";
				});	
			
			}
		$scope.notificationinfo = function()
			{
				 var formData = {'id': $scope.roasterID,'table': 'li_notification_info','joincolumn':'notification_info_id'};
				   $http.post(BASE_URL+'api/roster/getrosterinfo', formData)
			   .then(function(response) {
				   $scope.usertype = $scope.usertype;	
				  $scope.billinginfo = "";
				  $scope.allattendee = "";
				  $scope.payment_infos = "";	
				  $scope.agreement_info = "";
				  $scope.health_info = "";
				  $scope.notification_info = response.data.data;
				});	
				
				
				  
				
			
			}
		
		$scope.biilinginfo();
		
	}
	
   
}


function allSkillCtrl($scope, $compile, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $timeout, $routeParams, $window, $filter) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	//$scope.deleteSkill = deleteSkill;
	
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/skill/getallskills').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']]);
                  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('name').withTitle('Skill Name'),
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			var encrypted ;
			 encrypted = $scope.encryptStr(data.id);
			 return '<a title="Edit" class="EditFaIcons" href="#!/skill-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a>';
           // return '<a title="Edit" class="EditFaIcons" href="#!/skill-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a> <a title="delete" class="btn btn-danger btn FaIcons" ng-click="deleteSkill('+data.id+')"><i class="fa fa-trash"></a>'
         }),
      ];

		
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}


function allTestimonialCtrl($scope, $http, $q, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $window, $compile, $filter, $location, $route,$timeout) 
{
	$scope.encryptStr = function(id)
	{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "Liminaladmin");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
			return str;
		}
		else{
			return $scope.encryptStr(id);
		}
		
	};
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	$scope.deleteTestimonial = deleteTestimonial;
	$scope.dtOptions = DTOptionsBuilder
       .fromFnPromise(function() {
          var defer = $q.defer();
          $http.get(BASE_URL+'api/testimonials/getAllTestimonial').then(function(result) {
            defer.resolve(result.data.data);
          });
          return defer.promise;
        })    
        .withOption('lengthMenu', [[10, 50, 100,-1], [10, 50, 100,'All']])
       .withOption('createdRow', createdRow);  
      $scope.dtColumns = [       
         DTColumnBuilder.newColumn(null).withTitle('#').renderWith(function(data, type, full, meta) {
            return meta.row + 1
         }),  
         DTColumnBuilder.newColumn('name').withTitle('Name'),
		 DTColumnBuilder.newColumn('description').withTitle('Description'),
		/*  DTColumnBuilder.newColumn(null).withTitle('User image').renderWith(function(data, type, full, meta) {
			  if(data.user_image != "") {
           
            return '<img src="'+BASE_URL+'uploads/testimonialImages/'+data.user_image+'" style="width: 100px;">'
			 } else {
				 return '<img src="'+BASE_URL+'assets/images/dummy_user.jpg" style="width:100px;">';
			 }
         }), */
		 DTColumnBuilder.newColumn(null).withTitle('Action').renderWith(function(data, type, full, meta) {
			var encrypted ;
			 encrypted = $scope.encryptStr(data.id);
			 var index = meta.row + 1;
            return '<a title="Edit" class="EditFaIcons" href="#!/testimonial-edit/'+encrypted+'"><i class="fa fa-pencil"></i></a> <button title="delete" class="btn btn-danger btn FaIcons" ng-click="deleteTestimonial('+data.id+')"><i class="fa fa-trash"></button>'
         }),
      ];   
	  
	  function deleteTestimonial(testimonialID) {
		 
		if ($window.confirm("Are you want to delete this testimonial?")) {
			
		var formData = {'testimonial_id': testimonialID};
          $http.post(BASE_URL+'api/testimonials/deleteTestimonial', formData).then(function(result) {
			  
                if(result.data.success == 'true') {
					 var Gritter = function () {
						$.gritter.add({
							title: "",
							text: "Testimonial deleted successfully"
								});
							return false;
							}(); 
					$timeout($route.reload(), 2000);
					
				}
          });
		}
		
	}
	
	function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
	
	 $scope.deleteRow= function test(i) {
		 console.log(i);
       $scope.employees.splice(i, 1);
   };
}


function editTestimonialCtrl($scope, $http, $routeParams,$timeout, $window) 
{
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	$scope.testimonialinfo 	= {
	
		id:'',
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
	$scope.testimonialID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.testimonialID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.testimonialID;
	};	
	$timeout($scope.setID(), 2000);
	 
	
	
	var formData = {'id': $scope.testimonialID};
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/testimonial/testimonialDetail', formData)
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
   url: BASE_URL+'api/testimonial/updateTestimonial',
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


function editEventCtrl($scope, $http, $routeParams,$timeout, $uibModal, $window, $location) 
{
	$scope.date = new Date();
$scope.gPlace;
$scope.grouptype = false;
$scope.allgroups = {};
	  $scope.alltype = {};
	  $scope.alltypename = {};
	  $scope.roles = ["participant","staff"];
	
	$scope.eventinfo 	= {
		id:"",
event_community:'',
event_category:'',
event_type:'',
event_name:'',
start_date:'',
end_date:'',
start_time:'',
end_time:'',
cost:'',
min_deposit:'',
max_attendees:'',
max_staff:'',
details:'',
details_popup:'',
location:'',
lat:'',
lng:'',
skill_requirement:[],
skill_condition:[''],
skill_earned:'',
invite_code:'',
		};
	
	
	  $http.get(BASE_URL+'api/skill/getallActiveskills')
   .then(function(responses) {
	   $scope.allskills = responses.data.data;
	  
    });
	$http.get(BASE_URL+'api/event/getallcommunity')
   .then(function(responses) {
	   $scope.allcommunity = responses.data.data;
	  
    });
	$http.get(BASE_URL+'api/event/getallcategory')
   .then(function(responses) {
	   $scope.allcategory = responses.data.data;
	  
    });
	$http.get(BASE_URL+'api/group/getAllGroups')
	   .then(function(response) {
		  $scope.allgroups = response.data.data; 
		});	
	
     $scope.choices = [''];
	
	$scope.addNewChoice = function() {
     var newItemNo = $scope.choices.length+1;
     $scope.choices.push({'id' : 'choice' + newItemNo, 'name' : 'choice' + newItemNo});
   };
  $scope.removeNewChoice = function() {
     var newItemNo = $scope.choices.length-1;
     if ( newItemNo !== 0 ) {
      $scope.choices.pop();
     }
   };   
	
	CKEDITOR.replace( 'editor'); 
	CKEDITOR.add
	CKEDITOR.replace( 'details_popup');
	CKEDITOR.add
	var tid;
	$scope.eventID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.eventID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.eventID;
	};	
	$timeout($scope.setID(), 2000);
	
	
	
	var formData = {'id': $scope.eventID};
	
	
	
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/event/eventDetail', formData)
   .then(function(response) {
	   $scope.eventinfo = response.data.data;
	   $scope.created_by = response.data.data.created_by;
	  
	   $scope.eventinfo.skill_requirement = response.data.data.skill_requirement.split(',');
	   $scope.eventinfo.skill_condition = response.data.data.skill_condition.split(',');
	   $scope.eventinfo.leader = response.data.data.leader.split(',');
	   $scope.choices = $scope.eventinfo.skill_requirement;
	   //console.log($scope.eventinfo.choices);
	   $scope.eventinfo.start_time = new Date(response.data.data.start_date +' '+ response.data.data.start_time);
	   $scope.eventinfo.end_time = new Date(response.data.data.end_date +' '+ response.data.data.end_time);
	   
	   $scope.eventinfo.details = response.data.data.details;
	   $scope.eventinfo.details_popup = response.data.data.details_popup;
	   CKEDITOR.instances.editor.setData($scope.eventinfo.details);
	   CKEDITOR.instances.details_popup.setData($scope.eventinfo.details_popup);
	  
	   if($scope.eventinfo.group_id != null){
		   $scope.grouptype = true;
	   }
	   if ($scope.eventinfo.event_category !== "") {
		  
		  var formData = {'cat_id': $scope.eventinfo.event_category};
       $http.post(BASE_URL+'api/event/getalltype', formData)
   .then(function(response) {
      $scope.alltype = response.data.data; 
    });	
      }
	  
	  if ($scope.eventinfo.event_category !== "" || $scope.eventinfo.event_type !== "") {
		  
		  var formData = {'cat_id': $scope.eventinfo.event_category, 'event_type_id': $scope.eventinfo.event_type};
       $http.post(BASE_URL+'api/event/getalltypename', formData)
   .then(function(response) {
      $scope.alltypename = response.data.data; 
    });	
      }
	  
	  
	  
	  if ($scope.eventinfo.skill_requirement !== "") {
		  
		  var formData = {'skill': $scope.eventinfo.skill_requirement, 'condition': $scope.eventinfo.skill_condition};
       $http.post(BASE_URL+'api/event/getallleaders', formData)
   .then(function(response) {
	  
      $scope.allleaders = response.data.data; 
    });	
      }
	  
    });
	
	
		
		$http.get(BASE_URL+'api/user/validate_event_manager?page=editevent&eventid='+ $scope.eventID)
		   .then(function(response) {
			   //console.log(response.data.data);
			   if(response.data.success !='false'){
				   $window.location.href = BASE_URL+'admindashboard#!';
				
			   }
			 
			});
		
		
		}
	
	$scope.getEventType = function() {
		 if ($scope.eventinfo.event_type !== "") {
			  var formData = {'id': $scope.eventinfo.event_type};
			   $http.post(BASE_URL+'api/event/geteventtypeByid', formData)
		   .then(function(response) {
			   if(response.data.data.title == "groups") {
				   $scope.grouptype = true; 
			   }else {
				   $scope.grouptype = false; 
			   }
			  
			});	 
		 }
		
	};
	
	
	$scope.getEventtypelist = function () {
      if ($scope.eventinfo.event_category !== "") {
		  
		  var formData = {'cat_id': $scope.eventinfo.event_category};
       $http.post(BASE_URL+'api/event/getalltype', formData)
   .then(function(response) {
      $scope.alltype = response.data.data; 
    });	
      }
    };
	
	$scope.getEventtypelists = function () {
      if ($scope.submittypename.cat_id !== "") {
		  
		  var formData = {'cat_id': $scope.submittypename.cat_id};
       $http.post(BASE_URL+'api/event/getalltype', formData)
   .then(function(response) {
      $scope.alltype = response.data.data; 
    });	
      }
    };
	
	
	  
	$scope.getEventtypenamelist = function () {
      if ($scope.eventinfo.event_category !== "" || $scope.eventinfo.event_type !== "") {
		  
		  var formData = {'cat_id': $scope.eventinfo.event_category, 'event_type_id': $scope.eventinfo.event_type};
       $http.post(BASE_URL+'api/event/getalltypename', formData)
   .then(function(response) {
      $scope.alltypename = response.data.data; 
    });	
      }
    };
	
	
	$scope.getleaderlist = function () {
      if ($scope.eventinfo.skill_requirement !== "") {
		  
		  var formData = {'skill': $scope.eventinfo.skill_requirement, 'condition': $scope.eventinfo.skill_condition};
       $http.post(BASE_URL+'api/event/getallleaders', formData)
   .then(function(response) {
	  
      $scope.allleaders = response.data.data; 
    });	
      }
    };
	
   
	
	$scope.submitcommunity 	= {id:"",title:'',};		
	$scope.addcommunity = function()
    {
		var fcommunity = new FormData();
		
        fcommunity.append('title', $scope.submitcommunity.title);
		$http({
   method: 'post',
   url: BASE_URL+'api/event/addcommunity',
   data: fcommunity,
   headers: {'Content-Type': undefined},
  }).then(function (rescommunity) 
        { 
            if(rescommunity.data.success == 'true')
            {
		   $scope.submitcommunity.title = '';
           $scope.allcommunity = rescommunity.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Community',
					text: rescommunity.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	$scope.submitcategory 	= {id:"",title:'',};	
    $scope.addcategory = function()
    {
		var fcategory = new FormData();
		
        fcategory.append('title', $scope.submitcategory.title);
		$http({
   method: 'post',
   url: BASE_URL+'api/event/addcategory',
   data: fcategory,
   headers: {'Content-Type': undefined},
  }).then(function (rescategory) 
        { 
            if(rescategory.data.success == 'true')
            {
		   $scope.submitcategory.title = '';
           $scope.allcategory = rescategory.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Category',
					text: rescategory.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	$scope.submittype 	= {id:"",title:'', cat_id : '',};
    $scope.addeventtype = function()
    {
		var ftype = new FormData();
		
        ftype.append('title', $scope.submittype.title);
		ftype.append('category', $scope.submittype.cat_id);
		$http({
   method: 'post',
   url: BASE_URL+'api/event/addtype',
   data: ftype,
   headers: {'Content-Type': undefined},
  }).then(function (restype) 
        { 
            if(restype.data.success == 'true')
            {
		   $scope.submittype.title = '';
		   $scope.submittype.cat_id = '';
           $scope.alltype = restype.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Event Type',
					text: restype.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	$scope.submittypename 	= {id:"",title:'', cat_id : '', event_type : '',};
    $scope.addeventtypename = function()
    {
		var ftypename = new FormData();
		
        ftypename.append('title', $scope.submittypename.title);
		ftypename.append('category', $scope.submittypename.cat_id);
		ftypename.append('event_type', $scope.submittypename.event_type);
		$http({
   method: 'post',
   url: BASE_URL+'api/event/addtypename',
   data: ftypename,
   headers: {'Content-Type': undefined},
  }).then(function (restype) 
        { 
            if(restype.data.success == 'true')
            {
		   $scope.submittypename.title = '';
		   $scope.submittypename.cat_id = '';
		   $scope.submittypename.event_type = '';
           $scope.alltypename = restype.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Event Type Name',
					text: restype.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}	
	
	$scope.submitskills 	= {id:"",title:''};
    $scope.addskills = function()
    {
		var fskills = new FormData();
		
        fskills.append('name', $scope.submitskills.title);
		fskills.append('description', '');
		fskills.append('is_active', '1');
		$http({
   method: 'post',
   url: BASE_URL+'api/skill/updateSkill',
   data: fskills,
   headers: {'Content-Type': undefined},
  }).then(function (restype) 
        { 
            if(restype.data.success == 'true')
            {
		   $scope.submitskills.title = '';
           $scope.allskills = restype.data.data; 
            }
			var Gritter = function () {
				$.gritter.add({
					title: 'Skills',
					text: restype.data.message
				});
			return false;
			}();				
        },function(error) 
        {
            
                $scope.message = error.data.error;
            
        });
	}
	
$scope.editprofile = function()
    {
		
		//console.log($scope.eventinfo);
		var event_id = $scope.eventinfo.id!=undefined ? $scope.eventinfo.id :''; 
		var fd = new FormData();
		//console.log($scope.grouptype);
		$scope.eventinfo.group_id = $scope.grouptype == true ? $scope.eventinfo.group_id :''; 
		//console.log($scope.eventinfo.group_id);return false;
        fd.append('event_id', event_id);
		fd.append('event_community', $scope.eventinfo.event_community);
		fd.append('event_category', $scope.eventinfo.event_category);
		fd.append('event_type', $scope.eventinfo.event_type);
        fd.append('event_typename', $scope.eventinfo.event_typename);
		
		fd.append('group_id', $scope.eventinfo.group_id);
		//fd.append('event_name', $scope.eventinfo.event_name);
		fd.append('start_date', moment($scope.eventinfo.start_date).format("YYYY-MM-DD"));
		fd.append('end_date', moment($scope.eventinfo.end_date).format("YYYY-MM-DD"));
		if($scope.eventinfo.start_time == "") {
			fd.append('start_time', $scope.eventinfo.start_time);
		} else {
		fd.append('start_time', new Date($scope.eventinfo.start_time).getHours() +':'+ new Date($scope.eventinfo.start_time).getMinutes() +':'+ new Date($scope.eventinfo.start_time).getSeconds());
		}
		if($scope.eventinfo.end_time == "") {
		fd.append('end_time', $scope.eventinfo.end_time);
		} else {
			fd.append('end_time', new Date($scope.eventinfo.end_time).getHours() +':'+ new Date($scope.eventinfo.end_time).getMinutes() +':'+ new Date($scope.eventinfo.end_time).getSeconds());
		}
		fd.append('cost', $scope.eventinfo.cost);
		fd.append('min_deposit', $scope.eventinfo.min_deposit);
		fd.append('max_attendees', $scope.eventinfo.max_attendees);
		fd.append('max_staff', $scope.eventinfo.max_staff);
		var raghavs = CKEDITOR.instances.editor.getData($scope.eventinfo.details);
		var raghav = CKEDITOR.instances.details_popup.getData($scope.eventinfo.details_popup)
		fd.append('details', raghavs);
		fd.append('details_popup', raghav);
		if($scope.eventinfo.age_requirement!= undefined) {
			
		fd.append('age_requirement', $scope.eventinfo.age_requirement);
		
		}
		fd.append('location', $scope.eventinfo.location);
		fd.append('lat', $scope.eventinfo.lat);
		fd.append('lng', $scope.eventinfo.lng);
		fd.append('security', $scope.eventinfo.security);
		fd.append('skill_requirement', $scope.eventinfo.skill_requirement);
		fd.append('skill_condition', $scope.eventinfo.skill_condition);
		fd.append('leader', $scope.eventinfo.leader);
		fd.append('invite_code', $scope.eventinfo.invite_code);
		fd.append('skill_earned', $scope.eventinfo.skill_earned);
		fd.append('role', $scope.eventinfo.role);
		
        $http({
   method: 'post',
   url: BASE_URL+'api/event/updateEvent',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(event_id==""){
		        $scope.eventinfo={};
				$scope.eventinfo.description = '';
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


function editSkillCtrl($scope, $http, $routeParams,$timeout, $window) 
{
	
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	  //this.myTime = new Date();
      //this.isOpen = false;
	$scope.skillinfo 	= {
		id:"",
name:'',
description:'',
is_active:'1'

		};
	
	
	var tid;
	$scope.skillID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.skillID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.skillID;
	};	
	$timeout($scope.setID(), 2000);
	var formData = {'id': $scope.skillID};
	if($routeParams.ID!=0){
	$http.post(BASE_URL+'api/skill/skillDetail', formData)
   .then(function(response) {
	   $scope.skillinfo = response.data.data;
    });
	}
	
$scope.editprofile = function()
    {
		var skill_id = $scope.skillinfo.id!=undefined ? $scope.skillinfo.id :''; 
		var fd = new FormData();
		
        fd.append('skill_id', skill_id);
        fd.append('name', $scope.skillinfo.name);
		fd.append('description', $scope.skillinfo.description);
		fd.append('is_active', $scope.skillinfo.is_active);
		
        $http({
   method: 'post',
   url: BASE_URL+'api/skill/updateSkill',
   data: fd,
   headers: {'Content-Type': undefined},
  }).then(function (res) 
        {  
		
            var result = res.data;	
            if(result.success == 'true')
            { 
		if(skill_id==""){
		        $scope.skillinfo={};
				$scope.skillinfo.description = '';
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


function webSettingsCtrl($scope, $http, $window) 
{
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	$scope.formName  = 'editform';
	
	$http.get(BASE_URL+'api/pages/settingsDetail')
   .then(function(response) {
      $scope.settingsinfo = response.data.data;
	 
    });
	$http.get(BASE_URL+'api/pages/currencyList')
   .then(function(response) {
      $scope.currencies = response.data.data;
	 
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
		fd.append('currency_id', $scope.settingsinfo.currency_id);
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
			 var Gritter = function () {
				$.gritter.add({
					title: "Web Setting",
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

function PaymentPlanSettingsCtrl($scope, $http, $window) 
{
	$http.get(BASE_URL+'api/user/validate_event_manager')
   .then(function(response) {
	   //console.log(response.data.data);
	   if(response.data.success !='false'){
		   $window.location.href = BASE_URL+'admindashboard#!';
		
	   }
	 
    });
	$http.get(BASE_URL+'api/pages/getPaymentPlans')
   .then(function(response) {
      $scope.settingsinfo = response.data.data;
	 
    });
	$scope.timeperiods = {
        weekly : "Weekly",
        monthly : "Monthly",
        days : "Daywise"
    }
	
	$scope.editpaymentsettings = function()
    {
		 if($scope.settingsinfo.payment_plan_id != undefined) {
			var settings_id = $scope.settingsinfo.payment_plan_id;
		} else {
			var settings_id = "";
		} 
		
		var fd = new FormData();
		
        fd.append('payment_plan_id', settings_id);
        fd.append('time_period', $scope.settingsinfo.time_period);
		fd.append('payment_division', $scope.settingsinfo.payment_division);
		
  
        $http({
   method: 'post',
   url: BASE_URL+'api/pages/update_payment_plan_settings',
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

function editUserCtrl($scope, $http, $routeParams,$timeout, $window, Auth) 
{ 
console.log(Auth.setUser.user);
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
	$scope.userID = '';
	$scope.formName  = 'editform';
	$scope.setID = function(){
		var decrypted = CryptoJS.AES.decrypt($routeParams.ID, "Liminaladmin");
		$scope.userID = decrypted.toString(CryptoJS.enc.Utf8);
		tid = $scope.userID;
		
	};	
	$timeout($scope.setID(), 2000);
	
	if($scope.userID != "") {
	var formData = {'id': $scope.userID};
	} else{
		$scope.userID = $routeParams.ID;
		var formData = {'id': $routeParams.ID};
	}
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
	   $scope.productinfo.is_login = response.data.data.is_login;
    });
	}
	
	$http.get(BASE_URL+'api/user/validate_event_manager?page=edituser&userid='+$routeParams.ID)
	   .then(function(response) {
		   //console.log(response.data.data);
		   if(response.data.success !='false'){
			   $window.location.href = BASE_URL+'admindashboard#!';
			
		   }
		 
		});
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
