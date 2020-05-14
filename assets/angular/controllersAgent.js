'use strict';

//Controllers
function DashboardCtrl($scope, $http) 
{
	
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
