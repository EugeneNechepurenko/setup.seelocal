(function(){
	angular.module('seelocal', ['ngRoute', 'ngMessages', 'LocalStorageModule', 'flow','angucomplete'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
	})
	.config(['$routeProvider', '$locationProvider', 'localStorageServiceProvider', 'flowFactoryProvider', '$httpProvider', 
			function($routeProvider, $locationProvider, localStorageServiceProvider, flowFactoryProvider, $httpProvider){
            $locationProvider.html5Mode(true);
			
			
            $routeProvider
                .when('/step/:step', {
                    templateUrl: function(params){
                    	console.log(params);
                    	console.log('when');
                       if(parseInt(params.step) >= 1 && parseInt(params.step) <= 5) {
						   return 'templates/steps/' + params.step + '.html';
					   }
						else {
						   window.location.pathname = '/login';
					   }
                    },
                    controller: 'StepsController'
                    //preload: true
                })
                .when('/auth/login_remote_:key', {
                    templateUrl: 'templates/auth/login.html',
                    controller: 'LoginController'
                    //preload: true
                })
                .when('/login', {
                    templateUrl: 'templates/auth/login.html',
                    controller: 'LoginController'
                    //preload: true
                })
                .when('/register', {
                    templateUrl: 'templates/auth/register.html',
                    controller: 'RegisterController'
                    //preload: true
                })
                .when('/account', {
					templateUrl: 'templates/auth/account.html',
					controller: 'AcountController'
                    //preload: true
                })
                .when('/reset-password', {
                    templateUrl: 'templates/auth/password_reset.html'
                    //preload: true
				})
				.when('/contact-us', {
					templateUrl: 'templates/contact.html',
					controller: 'ContactCtrl'
				})
				.when('/thank-you', {
					templateUrl: 'templates/steps/thankyou.html'
					//preload: true
				})
                .when('/', {
                    redirectTo: '/step/1'
                })
                .otherwise({
                    redirectTo: '/'
                });


            localStorageServiceProvider
                .setPrefix('seelocal');

            flowFactoryProvider.defaults = {
                maxChunkRetries: 1,
                chunkRetryInterval: 5000,
			progressCallbacksInterval:0,
                target: 'api/upload_images'
            };
    }])
	.run([ 'AuthService', '$rootScope', '$templateCache','$http','localStorageService', '$location','$routeParams',
		function(AuthService, $rootScope, $templateCache, $http,localStorageService, $location,$routeParams){
		console.log('run');
        console.log($.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }));

        if(!$routeParams.key) {
            AuthService.checkServerLogin();
        }


//         console.log('login');
//             console.log('****************************');
//             console.log(responce);
//             console.log('****************************');
//
//                 console.log(responce.user);
//                 localStorageService.clearAll();
//                 $rootScope.sel_lang = '';
//                 for (var prop in $rootScope) {
//                     if (prop.substring(0,1) !== '$') {
//                         delete $rootScope[prop];
//                     }
//                 }
//                 $rootScope.imges_arr_tmp = false;
//                 $rootScope.step_completed_mark = {
//                     's1':false,
//                     's2':false,
//                     's3':false,
//                     's4':false,
//                     's5':false
//                 };
//                 localStorageService.set('token', responce.user.remember_token);
//                 localStorageService.set('user_id', responce.user.id);
//                 if ( responce.info != 'no' ) {
//                     for ( key in responce.info ) {
//                         localStorage.setItem(key, responce.info[key]);
//                         if(key = 'seelocal.campaign_images_arr'){
// //                                                                 console.log(responce.info[key]);
//                         }
//                     }
//                 }

		$rootScope.$on('$viewContentLoaded', function() {
			//$templateCache.removeAll();
		});
		
		
		/*
		$scope.$watch(function() {
			return $rootScope.show_header;
		}, function() {
			console.log('ch header');
			console.log($rootScope.show_header);
		}, true);
		*/
		$rootScope.active_sub_tab = 1;
		$rootScope.show_header = true;
		// console.log($location.path());
		if($location.path() == '/login'){
			$rootScope.show_header = false;
		}else{
			$rootScope.show_header = true;
		}
		
		$rootScope.step_completed_mark = {
			's1':false,
			's2':false,
			's3':false,
			's4':false,
			's5':false
		};
		$rootScope.s2_sub = {
			's1':false,
			's2':false,
			's3':false,
			's4':false,
			's5':false
		};
		
		$rootScope.s3_sub = {
			's1':false,
			's2':false,
			's3':false,
			's4':false,
			's5':false
		};
		
		
		$rootScope.step_completed_mark.s1 = localStorageService.get('s1') ? true : false;
		$rootScope.step_completed_mark.s2 = localStorageService.get('s2') ? true : false;
		$rootScope.step_completed_mark.s3 = localStorageService.get('s3') ? true : false;
		$rootScope.step_completed_mark.s4 = localStorageService.get('s4') ? true : false;
		$rootScope.step_completed_mark.s5 = $rootScope.step_completed_mark.s4 ? true : false;
		$rootScope.s2_sub.s1 = localStorageService.get('s2_sub_s1') ? true : false;
		$rootScope.s2_sub.s2 = localStorageService.get('s2_sub_s2') ? true : false;
		$rootScope.s2_sub.s3 = localStorageService.get('s2_sub_s3') ? true : false;
		$rootScope.s2_sub.s4 = localStorageService.get('s2_sub_s4') ? true : false;
		$rootScope.s2_sub.s5 = localStorageService.get('s2_sub_s4') ? true : false;
		$rootScope.s3_sub.s1 = true;
		$rootScope.s3_sub.s2 = true;
		$rootScope.s3_sub.s3 = localStorageService.get('s3_sub_s3') ? true : false;
		$rootScope.s3_sub.s4 = localStorageService.get('s3_sub_s4') ? true : false;
		$rootScope.s3_sub.s5 = localStorageService.get('s3_sub_s5') ? true : false;
		$rootScope.from_age = localStorageService.get('campaign_age_from') || '';
		$rootScope.to_age = localStorageService.get('campaign_age_to') || '';
		
		
		$rootScope.sel_lang = '';
		$rootScope.login_error_msg = false;
		$rootScope.active_sub_tab = 1;
		$rootScope.campaing_phone_msg = false;
		$rootScope.campaing_name_msg = false;
		$rootScope.campaing_languages_msg = false;
		$rootScope.campaing_gender_msg = false;
		$rootScope.campaing_location_location_msg = false;
		$rootScope.campaing_location_radius_msg = false;
		$rootScope.campaing_location_postcode_msg = false;
		$rootScope.campaing_location_cities_msg = false;
		$rootScope.campaing_selected_interests_msg = false;
		$rootScope.campaing_keywords_msg_0 = false;
		$rootScope.campaing_keywords_msg_1 = false;
		$rootScope.campaing_keywords_msg_2 = false;
		$rootScope.campaing_logo_img_msg = false;
		$rootScope.campaing_logo_msg = false;
		$rootScope.campaing_images_msg = false;
		$rootScope.campaing_promotion_msg = false;
		$rootScope.campaing_periode_msg = false;
		$rootScope.campaing_periode_date_msg = false;
		$rootScope.campaing_age_from_msg = false;
		$rootScope.campaing_age_to_msg = false;
		$rootScope.imges_arr = [];
		$rootScope.imges_arr_tmp = [];
		// $rootScope.campaing_phone = '';
		
    }])
    .controller('AuthController', ['$rootScope','$scope', '$location','$window', 'AuthService', 'localStorageService','sharedService', function($rootScope,$scope, $location, $window,AuthService, localStorageService,sharedService){
		console.log('AuthController');
		// console.log($location.path());
					
		
		
					$scope.$watch(function() {
						return $rootScope.show_header;
					}, function() {
						// console.log('ch header');
						// console.log($rootScope.show_header);
						if(!$rootScope.show_header){
							if($location.path() == '/login'){
								$rootScope.show_header = false;
							}else{
								$rootScope.show_header = true;
							}
							// console.log('ch header reset');
						}
					}, true);
					
					if($location.path() == '/login'){
						$rootScope.show_header = false;
					}else{
						$rootScope.show_header = true;
					}
					
					
					
					
					
            $scope.logged = AuthService.checkUserLoggedIn();
            $scope.$on('update_logged', function () {
                $scope.logged = sharedService.values;
            });
            $scope.logout = function(){
                AuthService.logout(function(responce){
                    $scope.logged = AuthService.checkUserLoggedIn();
                    $location.path('/login');
                });
            };

        }])
// page - Login
    .controller('LoginController', ['$http', '$rootScope','$scope', '$location', '$window', 'AuthService','localStorageService','sharedService','$routeParams',
		function($http, $rootScope,$scope, $location,$window, AuthService, localStorageService,sharedService, $routeParams){
		console.log('LoginController');
		console.log($routeParams);
            if($location.path() == '/login'){
                $rootScope.show_header = false;
            }
            else{
                $rootScope.show_header = true;
                if($routeParams.key != false) {
                    $rootScope.show_header = false;
                    $http.get('auth/remote_data_' + $routeParams.key).success(function (responce) {
                        console.log(responce);
                        console.log(responce.login);
                        $location.search('reorder','new');
                        $scope.user = {email: responce.login, password: responce.pass};
                        AuthService.login($scope.user, function (responce) {
                            if(responce == 'false'){
                                $rootScope.login_error_msg = true;
                            }else{
                                $rootScope.login_error_msg = false;
                                sharedService.passData(AuthService.checkUserLoggedIn());
                                $rootScope.step_completed_mark = {
                                    's1':false,
                                    's2':false,
                                    's3':false,
                                    's4':false,
                                    's5':false
                                };
                                $rootScope.s2_sub = {
                                    's1':false,
                                    's2':false,
                                    's3':false,
                                    's4':false,
                                    's5':false
                                };

                                $rootScope.s3_sub = {
                                    's1':false,
                                    's2':false,
                                    's3':false,
                                    's4':false,
                                    's5':false
                                };
                                $rootScope.step_completed_mark.s1 = localStorageService.get('s1') ? true : false;
                                $rootScope.step_completed_mark.s2 = localStorageService.get('s2') ? true : false;
                                $rootScope.step_completed_mark.s3 = localStorageService.get('s3') ? true : false;
                                $rootScope.step_completed_mark.s4 = localStorageService.get('s4') ? true : false;
                                $rootScope.step_completed_mark.s5 = $rootScope.step_completed_mark.s4 ? true : false;
                                $rootScope.s2_sub.s1 = localStorageService.get('s2_sub_s1') ? true : false;
                                $rootScope.s2_sub.s2 = localStorageService.get('s2_sub_s2') ? true : false;
                                $rootScope.s2_sub.s3 = localStorageService.get('s2_sub_s3') ? true : false;
                                $rootScope.s2_sub.s4 = localStorageService.get('s2_sub_s4') ? true : false;
                                $rootScope.s2_sub.s5 = localStorageService.get('s2_sub_s4') ? true : false;
                                $rootScope.s3_sub.s1 = true;
                                $rootScope.s3_sub.s2 = true;
                                $rootScope.s3_sub.s3 = localStorageService.get('s3_sub_s3') ? true : false;
                                $rootScope.s3_sub.s4 = localStorageService.get('s3_sub_s4') ? true : false;
                                $rootScope.s3_sub.s5 = localStorageService.get('s3_sub_s5') ? true : false;
                                $rootScope.from_age = localStorageService.get('campaign_age_from') || '';
                                $rootScope.to_age = localStorageService.get('campaign_age_to') || '';
                                $rootScope.sel_lang = '';
                                window.location.reload();
                                $location.path('/step/5');
                            }
                        });
                    }).error(function (error) {
                        console.log(error);
                    });
                }else {
                    $rootScope.show_header = true;
                }
            }

            $scope.forgot = false;
		$scope.email_forgot_fail = false;
		$scope.email_forgot_new = false;
		// console.log($location.path());

		$scope.email_forgot = '';
			$rootScope.login_error_msg = false;
		$rootScope.active_sub_tab = 1;
		$rootScope.campaing_phone_msg = false;
		$rootScope.campaing_name_msg = false;
		$rootScope.campaing_languages_msg = false;
		$rootScope.campaing_gender_msg = false;
		$rootScope.campaing_location_location_msg = false;
		$rootScope.campaing_location_radius_msg = false;
		$rootScope.campaing_location_postcode_msg = false;
		$rootScope.campaing_location_cities_msg = false;
		$rootScope.campaing_selected_interests_msg = false;
		$rootScope.campaing_keywords_msg_0 = false;
		$rootScope.campaing_keywords_msg_1 = false;
		$rootScope.campaing_keywords_msg_2 = false;
		$rootScope.campaing_logo_img_msg = false;
		$rootScope.campaing_logo_msg = false;
		$rootScope.campaing_images_msg = false;
		$rootScope.campaing_promotion_msg = false;
		$rootScope.campaing_periode_msg = false;
		$rootScope.campaing_periode_date_msg = false;
		$rootScope.campaing_age_from_msg = false;
		$rootScope.campaing_age_to_msg = false;
		$rootScope.imges_arr = []; 
		$rootScope.imges_arr_tmp = [];
		$scope.login = function(user) {
			if ($scope.loginForm.$valid){
				AuthService.login(user, function (responce) {
					// console.log(responce);
					if(responce == 'false'){
						$rootScope.login_error_msg = true;
					}else{
						$rootScope.login_error_msg = false;
						sharedService.passData(AuthService.checkUserLoggedIn());
					
						
						
						$rootScope.step_completed_mark = {
							's1':false,
					  's2':false,
					  's3':false,
					  's4':false,
					  's5':false
						};
						$rootScope.s2_sub = {
							's1':false,
					  's2':false,
					  's3':false,
					  's4':false,
					  's5':false
						};
						
						$rootScope.s3_sub = {
							's1':false,
					  's2':false,
					  's3':false,
					  's4':false,
					  's5':false
						};
						
						$rootScope.step_completed_mark.s1 = localStorageService.get('s1') ? true : false;
						$rootScope.step_completed_mark.s2 = localStorageService.get('s2') ? true : false;
						$rootScope.step_completed_mark.s3 = localStorageService.get('s3') ? true : false;
						$rootScope.step_completed_mark.s4 = localStorageService.get('s4') ? true : false;
						$rootScope.step_completed_mark.s5 = $rootScope.step_completed_mark.s4 ? true : false;
						$rootScope.s2_sub.s1 = localStorageService.get('s2_sub_s1') ? true : false;
						$rootScope.s2_sub.s2 = localStorageService.get('s2_sub_s2') ? true : false;
						$rootScope.s2_sub.s3 = localStorageService.get('s2_sub_s3') ? true : false;
						$rootScope.s2_sub.s4 = localStorageService.get('s2_sub_s4') ? true : false;
						$rootScope.s2_sub.s5 = localStorageService.get('s2_sub_s4') ? true : false;
						$rootScope.s3_sub.s1 = true;
						$rootScope.s3_sub.s2 = true;
						$rootScope.s3_sub.s3 = localStorageService.get('s3_sub_s3') ? true : false;
						$rootScope.s3_sub.s4 = localStorageService.get('s3_sub_s4') ? true : false;
						$rootScope.s3_sub.s5 = localStorageService.get('s3_sub_s5') ? true : false;
						$rootScope.from_age = localStorageService.get('campaign_age_from') || '';
						$rootScope.to_age = localStorageService.get('campaign_age_to') || '';
						// console.log($rootScope.s2_sub);
                                                $rootScope.sel_lang = '';
                                                
                                                // console.log($rootScope);
                                                // console.log($scope);
                                                window.location.reload();	
												$location.path('/step/1');
													

					}
				});
			}
		};

		$scope.send_mew_pass = function(){
			console.log($scope.email_forgot);
			$http.post('api/auth/forgot_pass', {'email':$scope.email_forgot}).success(function(responce){
				console.log(responce);
				if(responce == 'false'){
					$scope.email_forgot_fail = true;
					$scope.email_forgot_new = false;
				}
				else if(responce == 'ok'){
					$scope.email_forgot_fail = false;
					$scope.email_forgot_new = true;
				}
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		};
		if (AuthService.checkUserLoggedIn()){
			$location.path('/step/1');
		}
    }])
// page - Contact us
.controller('ContactCtrl', ['$http', '$rootScope','$scope', function($http, $rootScope, $scope){
	console.log('ContactCtrl');
	$scope.name = '';
	$scope.client_id = '';
	$scope.email = '';
	$scope.message = '';
	$scope.phone = '';
	$scope.text = '';

	$scope.is_error = false;

	$scope.name_error = false;
	$scope.email_error = false;
	$scope.message_error = false;
	$scope.phone_error = false;

	$scope.submit = function(){
		console.log('1');
		if($scope.is_error == true){ $scope.is_error = false;}
		if($scope.name == ''){ $scope.name_error = true; $scope.is_error = true;}else{ $scope.name_error = false }
		if($scope.email == ''){ $scope.email_error = true; $scope.is_error = true;}else{ $scope.email_error = false }
		if($scope.message == ''){ $scope.message_error = true; $scope.is_error = true;}else{ $scope.message_error = false }
		if($scope.phone == ''){ $scope.phone_error = true; $scope.is_error = true;}else{ $scope.phone_error = false }
		if($scope.is_error == false){
			var data = {
				'name': $scope.name,
				'client_id': $scope.client_id,
				'email': $scope.email,
				'message': $scope.message,
				'phone': $scope.phone,
				'text': $scope.text
			};
			// $http.post('api/contactus', data).success(function(responce){
			// 	console.log(responce);
			// }).error(function(error){ console.log(error); });
		}
	};

    }])
// page - Registration
	.controller('RegisterController', ['$route','$http','$scope', '$location', 'AuthService','sharedService', '$rootScope', function($route, $http, $scope, $location, AuthService, sharedService, $rootScope){
		console.log('RegisterController');
		$scope.$watch(function() {
			return $rootScope.show_header;
		}, function() {
			if(!$rootScope.show_header){
				$rootScope.show_header = true;
			}
		}, true);
		// var s = document.createElement("script");
		// s.type = "text/javascript";
		// s.src = "https://www.google.com/recaptcha/api.js?hl=en&onload=onloadCallback";
		// $("head").append(s);

		$rootScope.show_header = true;
		$scope.register = function() {
			$rootScope.show_header = true;

			$scope.error_first_name = false;
			$scope.error_company_name = false;
			$scope.error_email = false;
			$scope.error_phone_number = false;
			$scope.error_password = false;
			$scope.error_password_confirmation = false;
			
			$scope.emailInvalid = '';
			$scope.phoneInvalid = '';
			$scope.matchPassword = '';
			
			$scope.error_first_name =  !$scope.first_name;
			$scope.error_company_name = !$scope.company_name;

			if(!$scope.email){
				$scope.error_email = true;
				console.log(1);
			}else{
				var success_email = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				
				if( !success_email.test($scope.email) ) {
					$scope.emailInvalid = 'Invalid email address';
					$scope.error_email = true;
					console.log(2);
				}else{
					$scope.emailInvalid = '';
					$scope.error_email = false;
					console.log(3);
				}
			}

			if(!$scope.phone_number){
				$scope.error_phone_number = true;
			}else{
				if( isNaN($scope.phone_number) ) {
					$scope.phoneInvalid = 'Invalid phone number';
					$scope.error_phone_number = true;
				}else{
					$scope.phoneInvalid = '';
					$scope.error_phone_number = false;
				}
			}
			
			if(!$scope.password){
				$scope.error_password = true;
			}else{
				$scope.error_password = false; 
			}
			
			if(!$scope.password_confirmation){
				$scope.error_password_confirmation = true;
			}else{
				if($scope.password != $scope.password_confirmation){
					$scope.error_password_confirmation = true; 
					$scope.matchPassword = "Passwords don't match";
				}else{
					$scope.error_password_confirmation = false;
					$scope.matchPassword = '';
				}
			}

// 			var tmp111 = {'secret':'6LdEECUTAAAAALLPCByf5sZX8rAGYWTG6rBUBj3B','response':grecaptcha.getResponse()};
// 			$http.post('https://www.google.com/recaptcha/api/siteverify', {'secret':'6LdEECUTAAAAALLPCByf5sZX8rAGYWTG6rBUBj3B','response':grecaptcha.getResponse()}).success(function(responce){
// // 				localStorageService.set('token', responce.remember_token);
// // 				success(responce);
// 				console.log(responce);
// 			}).error(function(error){
// 				console.log(error);
// 				//                     console.log(error);
// 			});
// 			
// 			$http.post($scope.url, tmp111, { withCredentials: true, headers: { 'Content-Type': 'application/x-www-form-urlencoded;'} }).
// 			success(function (data, status)
// 			{
// 				console.log(data);
// 				console.log(status);
// 			}).
// 			error(function (data, status) {
// 				
// 				console.log(data);
// 				console.log(status);
// 			}
// 			);

			var user = {
				'first_name': $scope.first_name,
				'last_name': $scope.first_name,
				'company_name': $scope.company_name,
				'phone_number': $scope.phone_number,
				'email': $scope.email,
				'password': $scope.password
			};
			// if(grecaptcha.getResponse() != ''){
			// 	$('.g-recaptcha iframe').css('border','');
				if ($scope.registerForm.$valid){
					if($scope.error_email == false &&
					$scope.error_phone_number == false &&
					$scope.error_password == false &&
					$scope.error_password_confirmation == false)
					{
						AuthService.register(user, function (responce) {
							sharedService.passData(AuthService.checkUserLoggedIn());
							$location.path('/login');
						});
					}
				}
			// }else{
			// 	$('.g-recaptcha iframe').css('border','1px solid red');
			// }
		};
		if (AuthService.checkUserLoggedIn()){
			sharedService.passData(AuthService.checkUserLoggedIn());
			$location.path('/step/1');
		}
    }])
// page - Thank you
	.controller('ThankyouController', ['$route','$http','$scope', '$location', 'AuthService','sharedService', '$rootScope', function($route, $http, $scope, $location, AuthService, sharedService, $rootScope){
		console.log('ThankyouController');
		
		$scope.$watch(function() {
			return $rootScope.show_header;
		}, function() {
			// console.log('ch header');
			// console.log($rootScope.show_header);
			if(!$rootScope.show_header){
				$rootScope.show_header = true;
				// console.log('ch header reset');
			}
		}, true);
		
	}])
	.controller('TabsController', ['$scope', 'TabsService', '$rootScope', 'subtabs','$location', function($scope, TabsService, $rootScope, subtabs, $location){
		console.log('TabsController');
		// console.log($location.path());
		if($location.path() == '/login'){
			$rootScope.show_header = false;
		}else{
			$rootScope.show_header = true;
		}
		
		$scope.selectedTab = TabsService.constructSelectedTab();
		
		$scope.$on('subtabs', function () {
			// console.log(subtabs.values);
			var tab = $scope.selectedTab;
			var tab2 = $rootScope.active_sub_tab;
			
			// console.log('ch tab old = ' + tab);
			if(subtabs.values == '+'){
				tab = tab + 1;
			}
			
			if(subtabs.values == '-'){
				tab = tab - 1;
			}
			
			// console.log('ch tab new' + tab);
			
			$rootScope.active_sub_tab = tab;
			TabsService.setSelectedTab(tab);
			$scope.selectedTab = tab;
			
		});
		
		$scope.selectTab = function(id){
			TabsService.setSelectedTab(id);
			$scope.selectedTab = id;
			$rootScope.active_sub_tab = id;
			// console.log($location.path());
			if ( $rootScope.active_sub_tab == 5 && $location.path() == '/step/3') {
				promo_textarea_change_size();
			}
			
		};
		
		$scope.isSelectedTab = function(id){
			return $scope.selectedTab === id;
		};
	}])
	.controller('StepsController', ['Confirm_btn','$scope', '$http', '$location', '$rootScope', '$routeParams', 'StepsService', 'localStorageService', 'AuthService','subtabs', function(Confirm_btn, $scope, $http, $location, $rootScope, $routeParams, StepsService, localStorageService, AuthService, subtabs){
		if(parseInt($routeParams.step) > 1 && parseInt($routeParams.step) < 5){
			console.log('2');
		}else{
			// $location.path('/login');
			console.log('1');
		}


		console.log($routeParams.step);

		console.log('StepsController');
		// console.log($location.path());
		if($location.path() == '/login'){
			$rootScope.show_header = false;
		}else{
			$rootScope.show_header = true;
		}
					
		$rootScope.selectedPeriod = localStorageService.get('campaign_period') || 0;
		
		$scope.step = $routeParams.step;
		var tmp_tabs = $location.search();
		
		// console.log(tmp_tabs.tab);
		
		if(tmp_tabs.tab == 'undefined'){ $rootScope.active_sub_tab = 1; }
		
 		// console.log('___');
 		// console.log($rootScope.active_sub_tab);
 		// console.log('___');
		
		$scope.leftMarginPer = 18.7;
		$scope.stepsDesc = [
		'choose the objective of your campaign',
		'enter your campaign demographics',
		'upload your images',
		'choose your budget and timescale',
		'review and pay'
		];
		$scope.isStepPassed = function(step){ return localStorageService.get('step_' + step + '_passed') ? true : false; };
		$scope.isStepActive = function(step){ return step == $scope.step; };
		
		
		$scope.is_step_clicable = function(step){
			// 			console.log('STEP');
			// 			console.log(step);
			var prev_step = parseInt(step);
			prev_step = prev_step - 1;
			
			if(step == 1){
				return true;
			}
			else if($rootScope.step_completed_mark['s'+ step] == true) {
				return true;
			}
			else if($rootScope.step_completed_mark['s'+ prev_step] == true){
				return true;
			}
		};
		
		
        var $last = '';
        if($scope.step == 2){ $last = 5; }
        if($scope.step == 3){ $last = 5; }
        $scope.error_msg = false;

		if($scope.step == 2){
			$(document).on('click','.from_age',function(){
				if($('.from_age').val() == ''){
					$rootScope.from_age = 18;
				}
			});
			
			
			
			$(document).on('click','.to_age',function(){	
				if($('.to_age').val() == ''){
					$rootScope.to_age = 65;
				}
			});
			
			var wto;
			var wto2;
			$(document).on('keyup','.from_age',function(){
				clearTimeout(wto);
				wto = setTimeout(function() {
					var val =  parseInt($('.from_age').val());
					var old_val = parseInt($('.from_age').data('old'));
					var min = parseInt($('.from_age').attr('min'));
					var max = parseInt($('.from_age').attr('max'));
					if(val < min || val > max){ $('.from_age').val(old_val); $rootScope.from_age = old_val; }
					if(val > min && val < max){ $('.from_age').data('old',val); $('.to_age').attr('min',val); $rootScope.from_age = val; }
				}, 500);
			});	
			$(document).on('keyup','.to_age',function(){
				clearTimeout(wto2);
				wto2 = setTimeout(function() {
					var val =  parseInt($('.to_age').val());
					var old_val = parseInt($('.to_age').data('old'));
					var min = parseInt($('.to_age').attr('min'));
					var max = parseInt($('.to_age').attr('max'));
					if(val < min || val > max){ $rootScope.to_age = old_val; $('.to_age').val(old_val); }
					if(val > min && val < max){ $('.to_age').data('old',val); $('.from_age').attr('max',val); $rootScope.to_age = val; }
				}, 500);
			});
		}
		
		$('#ex1_value').on( 'change', function () { /*console.log(this);*/ });


		$scope.pay_btn = function () {
			Confirm_btn.passData('click_pay_btn');	
		}
		
		
		$scope.saveData = function (step) {
			if($rootScope.active_sub_tab === 'undefined' || !$rootScope.active_sub_tab){ 
				$rootScope.active_sub_tab = 1; 
			}
			// console.log('active_sub_tab = ' + $rootScope.active_sub_tab);
			if ( $rootScope.active_sub_tab == 4 && $scope.step == 3) {
				promo_textarea_change_size();
			}
			
// STEP 2
            if ($scope.step < step && $scope.step == 2) {
console.log('step2');

                if ($rootScope.active_sub_tab == 1) {
                	console.log('step2_1');

					if (!$rootScope.campaing_name) { $rootScope.campaing_name_msg = true; }
					else { $rootScope.campaing_name_msg = false; }
					
                    if (!$rootScope.campaing_phone) { $rootScope.campaing_phone_msg = true; }
                    else { $rootScope.campaing_phone_msg = false; }

                    if (!$rootScope.campaing_languages) 
						{
						$rootScope.campaing_languages_msg = true;
						$('#ex1_value').addClass('valid_error');
						} 
                    else
						{
						$rootScope.campaing_languages_msg = false;
						$('#ex1_value').removeClass('valid_error');
						}

					if (!$rootScope.campaing_age_from && !$rootScope.from_age) { $rootScope.campaing_age_from_msg = true; } 
					else { $rootScope.campaing_age_from_msg = false; }
                    
					if (!$rootScope.campaing_age_to && !$rootScope.to_age) { $rootScope.campaing_age_to_msg = true; }
					else { $rootScope.campaing_age_to_msg = false; }
					
					if (!$rootScope.campaing_gender) { $rootScope.campaing_gender_msg = true; }
                    else { $rootScope.campaing_gender_msg = false; }

                    if (!$rootScope.campaing_name || !$rootScope.campaing_phone || !$rootScope.campaing_gender || !$rootScope.campaing_languages) { 
						$scope.error_msg = true; 
						
						$(".content").animate({ scrollTop: $('.content').height() }, "slow");
					}
                    else { $scope.error_msg = false; }
                    
                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
                        console.log('step2_if');
						
						
							$rootScope.s2_sub.s1 = true;
							localStorageService.set('s2_sub_s1', true);
						
						
						$rootScope.$broadcast('saveData', step);
						
						/*	-------------------- */
						var campaing_location_cities = document.getElementById('locality_0').value;
						if(
							$rootScope.campaing_name      &&
							$rootScope.campaing_phone     &&
							$rootScope.campaing_languages &&
							$rootScope.campaing_age_from  &&
							$rootScope.campaing_age_to    &&
							$rootScope.campaing_gender    &&
							
							$rootScope.campaing_location[0].location &&
							campaing_location_cities				&&
							$rootScope.campaing_location[0].radius	&&
							
							$rootScope.campaing_selected_interests.length >= 3 &&
							
							$rootScope.campaing_keywords[0].name &&
							$rootScope.campaing_keywords[1].name &&
							$rootScope.campaing_keywords[2].name
							
						){
							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
						}
						/*	-------------------- */
						$rootScope.active_sub_tab = 1;
                        $location.path('step/' + step);
                    }
                    else {
						console.log('step2_else');
                        if ($scope.error_msg == false) {
                            $rootScope.activ_lats_tab = false;
							
							// console.log($rootScope.s2_sub);
							if(!$rootScope.s2_sub){
								$rootScope.s2_sub = {
									's1':false,
									's2':false,
									's3':false,
									's4':false,
									's5':false
								}
							}
								$rootScope.s2_sub.s1 = true;
								localStorageService.set('s2_sub_s1', true);
							
							
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {

                                    $rootScope.$broadcast('saveData', step);
									
									/*	-------------------- */
									var campaing_location_cities = document.getElementById('locality_0').value;
									if(
										$rootScope.campaing_name      &&
										$rootScope.campaing_phone     &&
										$rootScope.campaing_languages &&
										$rootScope.campaing_age_from  &&
										$rootScope.campaing_age_to    &&
										$rootScope.campaing_gender    &&
										
										$rootScope.campaing_location[0].location &&
										campaing_location_cities				&&
										$rootScope.campaing_location[0].radius	&&
										
										$rootScope.campaing_selected_interests.length >= 3 &&
										
										$rootScope.campaing_keywords[0].name &&
										$rootScope.campaing_keywords[1].name &&
										$rootScope.campaing_keywords[2].name
										
									){
										$rootScope.step_completed_mark['s' + $scope.step] = true;
										localStorageService.set('s' + $scope.step,true);
									}
									/*	-------------------- */
									$rootScope.active_sub_tab = 1;
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }

                            }
                        }
                    }
                }

                
                else if ($rootScope.active_sub_tab == 2) {
                    var len = $rootScope.campaing_location.length;
					for(var i=0;i<len;++i){
						if (!$rootScope.campaing_location[i].location) { $rootScope.campaing_location[i].location_msg = true; }
						else { $rootScope.campaing_location[i].location_msg = false; }
						
						$rootScope.campaing_location[i].cities = document.getElementById('locality_' + i).value;
						$rootScope.campaing_location[i].postcode = document.getElementById('postal_code_' + i).value;
						if (!$rootScope.campaing_location[i].cities) { $rootScope.campaing_location[i].cities_msg = true; }
						else { $rootScope.campaing_location[i].cities_msg = false; }
						
						if (!$rootScope.campaing_location[i].radius) { $rootScope.campaing_location[i].radius_msg = true; }
						else { $rootScope.campaing_location[i].radius_msg = false; }
						
						if (!$rootScope.campaing_location[i].location || !$rootScope.campaing_location[i].cities || !$rootScope.campaing_location[i].radius) { $rootScope.campaing_location[i].error_msg = true; }
						else { $rootScope.campaing_location[i].error_msg = false; }
					}
                    for(var i=0;i<len;++i){
                        if($rootScope.campaing_location[i].error_msg == true){ $scope.error_msg = true; break; }
                        else{ $scope.error_msg = false; }
                    }
                    
                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
						var campaing_location_cities = document.getElementById('locality_0').value;
						
						if($rootScope.campaing_location[0].location &&
							campaing_location_cities				&&
							$rootScope.campaing_location[0].radius){
							$rootScope.s2_sub.s2 = true;
							localStorageService.set('s2_sub_s2', true);
						// console.log('sub_s2');
						}
						
						$rootScope.$broadcast('saveData', step);
						
						/*	-------------------- */
						
						if(
							$rootScope.campaing_name      &&
							$rootScope.campaing_phone     &&
							$rootScope.campaing_languages &&
							$rootScope.campaing_age_from  &&
							$rootScope.campaing_age_to    &&
							$rootScope.campaing_gender    &&
							
							$rootScope.campaing_location[0].location &&
							campaing_location_cities				&&
							$rootScope.campaing_location[0].radius	&&
							
							$rootScope.campaing_selected_interests.length >= 3 &&
							
							$rootScope.campaing_keywords[0].name &&
							$rootScope.campaing_keywords[1].name &&
							$rootScope.campaing_keywords[2].name
							
						){
							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
						}
						/*	-------------------- */
						$rootScope.active_sub_tab = 1;
                        $location.path('step/' + step);
                    }
                    else {
                        if ($scope.error_msg == false) {
							var campaing_location_cities = document.getElementById('locality_0').value;
							
							if($rootScope.campaing_location[0].location &&
								campaing_location_cities				&&
								$rootScope.campaing_location[0].radius){
								$rootScope.s2_sub.s2 = true;
							localStorageService.set('s2_sub_s2', true);
							// console.log('sub_s2');
								}
							
							if($rootScope.campaing_name && $rootScope.campaing_phone && $rootScope.campaing_languages && $rootScope.campaing_age_from  && $rootScope.campaing_age_to    && $rootScope.campaing_gender){
								$rootScope.s2_sub.s1 = true;
								localStorageService.set('s2_sub_s1', true);
							}
							
                            $rootScope.activ_lats_tab = false;
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {
                                    $rootScope.$broadcast('saveData', step);
									
									/*	-------------------- */
									var campaing_location_cities = document.getElementById('locality_0').value;
									if(
										$rootScope.campaing_name      &&
										$rootScope.campaing_phone     &&
										$rootScope.campaing_languages &&
										$rootScope.campaing_age_from  &&
										$rootScope.campaing_age_to    &&
										$rootScope.campaing_gender    &&
										
										$rootScope.campaing_location[0].location &&
										campaing_location_cities				&&
										$rootScope.campaing_location[0].radius	&&
										
										$rootScope.campaing_selected_interests.length >= 3 &&
										
										$rootScope.campaing_keywords[0].name &&
										$rootScope.campaing_keywords[1].name &&
										$rootScope.campaing_keywords[2].name
										
									){
										$rootScope.step_completed_mark['s' + $scope.step] = true;
										localStorageService.set('s' + $scope.step,true);
									}
									/*	-------------------- */
									$rootScope.active_sub_tab = 1;
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }

                            }
                        }
                    }
                }

                
                else if ($rootScope.active_sub_tab == 3) {

					if ($rootScope.campaing_selected_interests.length == 0 || $rootScope.campaing_selected_interests.length < 3) {
                        $rootScope.campaing_selected_interests_msg = true;
                    }else {
                        $rootScope.campaing_selected_interests_msg = false;
                    }


                    if ($rootScope.campaing_selected_interests_msg) {
                        $scope.error_msg = true;
                    }else {
                        $scope.error_msg = false;
                    }

                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
						
						
						if($rootScope.campaing_selected_interests.length >= 3){
							$rootScope.s2_sub.s3 = true;
							localStorageService.set('s2_sub_s3', true);
							// console.log('sub_s3');
						}
						
                        $rootScope.$broadcast('saveData', step);
								
						/*	-------------------- */
						var campaing_location_cities = document.getElementById('locality_0').value;
						if(
							$rootScope.campaing_name      &&
							$rootScope.campaing_phone     &&
							$rootScope.campaing_languages &&
							$rootScope.campaing_age_from  &&
							$rootScope.campaing_age_to    &&
							$rootScope.campaing_gender    &&
							
							$rootScope.campaing_location[0].location &&
							campaing_location_cities				&&
							$rootScope.campaing_location[0].radius	&&
							
							$rootScope.campaing_selected_interests.length >= 3 &&
							
							$rootScope.campaing_keywords[0].name &&
							$rootScope.campaing_keywords[1].name &&
							$rootScope.campaing_keywords[2].name
							
						){
							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
						}
						/*	-------------------- */
						$rootScope.active_sub_tab = 1;
                        $location.path('step/' + step);
                    }
                    else {
                        if ($scope.error_msg == false) {
                            $rootScope.activ_lats_tab = false;
							
							if($rootScope.campaing_selected_interests.length >= 3){
								$rootScope.s2_sub.s3 = true;
								localStorageService.set('s2_sub_s3', true);
								// console.log('sub_s3');
							}
							
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {
                                    $rootScope.$broadcast('saveData', step);
									
									/*	-------------------- */
									var campaing_location_cities = document.getElementById('locality_0').value;
									if(
										$rootScope.campaing_name      &&
										$rootScope.campaing_phone     &&
										$rootScope.campaing_languages &&
										$rootScope.campaing_age_from  &&
										$rootScope.campaing_age_to    &&
										$rootScope.campaing_gender    &&
										
										$rootScope.campaing_location[0].location &&
										campaing_location_cities				&&
										$rootScope.campaing_location[0].radius	&&
										
										$rootScope.campaing_selected_interests.length >= 3 &&
										
										$rootScope.campaing_keywords[0].name &&
										$rootScope.campaing_keywords[1].name &&
										$rootScope.campaing_keywords[2].name
										
									){
										$rootScope.step_completed_mark['s' + $scope.step] = true;
										localStorageService.set('s' + $scope.step,true);
									}
									/*	-------------------- */
									$rootScope.active_sub_tab = 1;
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }

                            }
                        }
                    }

                }


                else if ($rootScope.active_sub_tab == 4) {
					
					
					if ($rootScope.campaing_keywords[0].name) {
						$rootScope.campaing_keywords_msg_0 = false;
					}else {
						$rootScope.campaing_keywords_msg_0 = true;
					}
					
					if ($rootScope.campaing_keywords[1].name) {
						$rootScope.campaing_keywords_msg_1 = false;
					}else {
						$rootScope.campaing_keywords_msg_1 = true;
					}
					
					if ($rootScope.campaing_keywords[2].name) {
						$rootScope.campaing_keywords_msg_2 = false;
					}else {
						$rootScope.campaing_keywords_msg_2 = true;
					}
										
					if ($rootScope.campaing_keywords_msg_0 || 
						$rootScope.campaing_keywords_msg_1 || 
						$rootScope.campaing_keywords_msg_2) {
						$scope.error_msg = true;
					}else {
						$scope.error_msg = false;
					}
					
					
					
                    
                    
                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
						
						
						if($rootScope.campaing_keywords[0].name &&
							$rootScope.campaing_keywords[1].name &&
							$rootScope.campaing_keywords[2].name){
							$rootScope.s2_sub.s4 = true;
							localStorageService.set('s2_sub_s4', true);
							// console.log('sub_s4');
						}
						
						$rootScope.$broadcast('saveData', step);
						
						/*	-------------------- */
						var campaing_location_cities = document.getElementById('locality_0').value;
						if(
							$rootScope.campaing_name      &&
							$rootScope.campaing_phone     &&
							$rootScope.campaing_languages &&
							$rootScope.campaing_age_from  &&
							$rootScope.campaing_age_to    &&
							$rootScope.campaing_gender    &&
							
							$rootScope.campaing_location[0].location &&
							campaing_location_cities				&&
							$rootScope.campaing_location[0].radius	&&
							
							$rootScope.campaing_selected_interests.length >= 3 &&
							
							$rootScope.campaing_keywords[0].name &&
							$rootScope.campaing_keywords[1].name &&
							$rootScope.campaing_keywords[2].name
							
						){
							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
						}
						/*	-------------------- */
						$rootScope.active_sub_tab = 1;
                        $location.path('step/' + step);
                    }
                    else {
                        if ($scope.error_msg == false) {
                            //console.log('s3');
                            $rootScope.activ_lats_tab = false;
							
							if($rootScope.campaing_keywords[0].name &&
								$rootScope.campaing_keywords[1].name &&
								$rootScope.campaing_keywords[2].name){
								$rootScope.s2_sub.s4 = true;
							localStorageService.set('s2_sub_s4', true);
							// console.log('sub_s4');
								}
								
                            if ($scope.step < step) {
//                                 console.log('s4');
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
//                                 console.log('s5');
                                if ($rootScope.active_sub_tab == 1) {
//                                     console.log('s6');

                                    $rootScope.$broadcast('saveData', step);
									
									/*	-------------------- */
									var campaing_location_cities = document.getElementById('locality_0').value;
									if(
										$rootScope.campaing_name      &&
										$rootScope.campaing_phone     &&
										$rootScope.campaing_languages &&
										$rootScope.campaing_age_from  &&
										$rootScope.campaing_age_to    &&
										$rootScope.campaing_gender    &&
										
										$rootScope.campaing_location[0].location &&
										campaing_location_cities				&&
										$rootScope.campaing_location[0].radius	&&
										
										$rootScope.campaing_selected_interests.length >= 3 &&
										
										$rootScope.campaing_keywords[0].name &&
										$rootScope.campaing_keywords[1].name &&
										$rootScope.campaing_keywords[2].name
										
									){
										$rootScope.step_completed_mark['s' + $scope.step] = true;
										localStorageService.set('s' + $scope.step,true);
									}
									/*	-------------------- */
									$rootScope.active_sub_tab = 1;
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    // console.log('s7');
                                    subtabs.passData('-');
                                }

                            }
                        }
                    }
                }


                else if ($rootScope.active_sub_tab == 5) {
					// console.log('***SUBSTEP 5 - START***');
                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step) {
                        $rootScope.$broadcast('saveData', step);
						// console.log('To IF');
						
						
						// console.log('stor');
						// console.log(localStorageService.get('campaign_age_from'));
						// console.log(localStorageService.get('campaign_age_to'));
						// console.log('stor');
						/*	-------------------- */
						var campaing_location_cities = document.getElementById('locality_0').value;
						if(
							$rootScope.campaing_name      &&
							$rootScope.campaing_phone     &&
							$rootScope.campaing_languages &&
							localStorageService.get('campaign_age_from')  &&
							localStorageService.get('campaign_age_to')    &&
							$rootScope.campaing_gender    &&
							
							$rootScope.campaing_location[0].location &&
							campaing_location_cities				&&
							$rootScope.campaing_location[0].radius	&&
							
							$rootScope.campaing_selected_interests.length >= 3 &&
							
							$rootScope.campaing_keywords[0].name &&
							$rootScope.campaing_keywords[1].name &&
							$rootScope.campaing_keywords[2].name
							
						){
							// console.log('step_completed_mark = true');
							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
						}else{
							// console.log('step_completed_mark = false');
							
							// console.log($rootScope.campaing_name);
							// console.log($rootScope.campaing_phone);
							// console.log($rootScope.campaing_languages);
							// console.log($rootScope.campaing_age_from);
							// console.log($rootScope.campaing_age_to);
							// console.log($rootScope.campaing_gender);
							// console.log($rootScope.campaing_location[0].location);
							// console.log(campaing_location_cities);
							// console.log($rootScope.campaing_location[0].radius);
							// console.log($rootScope.campaing_selected_interests.length);
							// console.log($rootScope.campaing_keywords[0].name);
							// console.log($rootScope.campaing_keywords[1].name);
							// console.log($rootScope.campaing_keywords[2].name);
							
						}
						/*	-------------------- */
						$rootScope.active_sub_tab = 1;
                        $location.path('step/' + step);
						
                    }else{
						// console.log('To ELSE');
						
						if ($scope.error_msg == false) {
							// console.log('error = false');
                            $rootScope.activ_lats_tab = false;
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {
                                    $rootScope.$broadcast('saveData', step);
									
									/*	-------------------- */
									var campaing_location_cities = document.getElementById('locality_0').value;
									if(
										$rootScope.campaing_name      &&
										$rootScope.campaing_phone     &&
										$rootScope.campaing_languages &&
										$rootScope.campaing_age_from  &&
										$rootScope.campaing_age_to    &&
										$rootScope.campaing_gender    &&
										
										$rootScope.campaing_location[0].location &&
										campaing_location_cities				&&
										$rootScope.campaing_location[0].radius	&&
										
										$rootScope.campaing_selected_interests.length >= 3 &&
										
										$rootScope.campaing_keywords[0].name &&
										$rootScope.campaing_keywords[1].name &&
										$rootScope.campaing_keywords[2].name
										
									){
										$rootScope.step_completed_mark['s' + $scope.step] = true;
										localStorageService.set('s' + $scope.step,true);
									}
									/*	-------------------- */
									$rootScope.active_sub_tab = 1;
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }

                            }
                        }
                        else{
							// console.log('error = true');
                        }
                    }
                    // console.log('***SUBSTEP 5 - END***');
                }
                
                else{
					console.log('step2_else');
				}
            }

// STEP 3
    else if ($scope.step < step && $scope.step == 3) {
		var tmp_images_arr_tab4 = $scope.images_tmp = localStorageService.get('campaign_images_arr') || '';


            if ($rootScope.active_sub_tab == 3) {
                    if ($rootScope.campaing_logo) {
                        $rootScope.campaing_logo_msg = false;
                        $scope.error_msg = false;
                    }else {
                         if ($rootScope.campaing_have_src){
                             $rootScope.campaing_logo_msg = false;
                             $scope.error_msg = false;
                         }else{
                            $rootScope.campaing_logo_msg = true;
                            $scope.error_msg = true;
                         }
                    }

                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
                        
						
						if($rootScope.campaing_logo || $rootScope.campaing_have_src){
							$rootScope.s3_sub.s3 = true;
							localStorageService.set('s3_sub_s3', true);
						}
						
						$rootScope.$broadcast('saveData', step);
                        $rootScope.step_completed_mark['s' + $scope.step] = true;
						localStorageService.set('s' + $scope.step,true);
                        $location.path('step/' + step);
                    }
                    else {
                        if ($scope.error_msg == false) {
                            $rootScope.activ_lats_tab = false;
							
							
							if($rootScope.campaing_logo || $rootScope.campaing_have_src){
								// console.log($rootScope.s3_sub);
								if(!$rootScope.s3_sub){
									$rootScope.s3_sub = {
										's1':false,
										's2':false,
										's3':false,
										's4':false,
										's5':false
									}
								}
								$rootScope.s3_sub.s3 = true;
								localStorageService.set('s3_sub_s3', true);
							}
							
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {
                                    $rootScope.$broadcast('saveData', step);
                                    $rootScope.step_completed_mark['s' + $scope.step] = true;
									localStorageService.set('s' + $scope.step,true);
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }
                            }
                        }
                    }
                }


            else if ($rootScope.active_sub_tab == 4) {
				if (!$rootScope.campaing_images && tmp_images_arr_tab4 == '') {
					$rootScope.campaing_images_msg = true;
                    $scope.error_msg = true;
				}else{
					$rootScope.campaing_images_msg = false;
					$scope.error_msg = false;
				}
                    
				var tmp = $('.campaing_images_btn').hasClass('ng-hide');

                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && tmp) {

						
						if(tmp || tmp_images_arr_tab4 != ''){
							$rootScope.s3_sub.s4 = true;
							localStorageService.set('s3_sub_s4', true);
						}
						
						
						$rootScope.$broadcast('saveData', step);
                        $rootScope.step_completed_mark['s' + $scope.step] = true;
						localStorageService.set('s' + $scope.step,true);
                        $location.path('step/' + step);
                    }
                    else {
						// console.log(tmp);
						// console.log(tmp_images_arr_tab4);
						if (tmp || tmp_images_arr_tab4 != '') {
							
							if(tmp || tmp_images_arr_tab4 != ''){
								$rootScope.s3_sub.s4 = true;
								localStorageService.set('s3_sub_s4', true);
							}
							
                            $rootScope.activ_lats_tab = false;
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {
                                    $rootScope.$broadcast('saveData', step);
                                    $rootScope.step_completed_mark['s' + $scope.step] = true;
									localStorageService.set('s' + $scope.step,true);
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }
                            }
                        }
                    }
                }


            else if ($rootScope.active_sub_tab == 5) {
                if ($rootScope.campaing_promotion.length == 0) {
                        $rootScope.campaing_promotion_msg = true;
                        $scope.error_msg = true;
                    }else {
                            $rootScope.campaing_promotion_msg = false;
                            $scope.error_msg = false;
                    }

                    if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
						
						if($rootScope.campaing_promotion.length > 0){
							$rootScope.s3_sub.s5 = true;
							localStorageService.set('s3_sub_s5', true);
						}
						
						$rootScope.$broadcast('saveData', step);
                        $rootScope.step_completed_mark['s' + $scope.step] = true;
						localStorageService.set('s' + $scope.step,true);
					
						
						/*	-------------------- */
 						if(($rootScope.campaing_logo || $rootScope.campaing_have_src) && 
							$rootScope.campaing_images && 
							$rootScope.campaing_promotion.length > 0
							){
 							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
 						}
						/*	-------------------- */
						
						
						
						
						
						
                        $location.path('step/' + step);
                    }
                    else {
                        if ($scope.error_msg == false) {
                            $rootScope.activ_lats_tab = false;
							
							if($rootScope.campaing_promotion.length > 0){
								$rootScope.s3_sub.s5 = true;
								localStorageService.set('s3_sub_s5', true);
							}
							
                            if ($scope.step < step) {
                                subtabs.passData('+');
                                $rootScope.$broadcast('saveData', step);
                            }
                            if ($scope.step > step) {
                                if ($rootScope.active_sub_tab == 1) {
                                    $rootScope.$broadcast('saveData', step);
                                    $rootScope.step_completed_mark['s' + $scope.step] = true;
									localStorageService.set('s' + $scope.step,true);
                                    $location.path('step/' + step);
                                } else {
                                    $rootScope.$broadcast('saveData', step);
                                    subtabs.passData('-');
                                }
                            }
                        }
                    }
                }

                else{
					$rootScope.activ_lats_tab = false;
					if ($scope.step < step) {
						subtabs.passData('+');
						$rootScope.$broadcast('saveData', step);
					}
					if ($scope.step > step) {
						if ($rootScope.active_sub_tab == 1) {
							$rootScope.$broadcast('saveData', step);
							$rootScope.step_completed_mark['s' + $scope.step] = true;
							localStorageService.set('s' + $scope.step,true);
							$location.path('step/' + step);
						} else {
							$rootScope.$broadcast('saveData', step);
							subtabs.passData('-');
						}
					}
				}
            }

// STEP 4
            else if ($scope.step < step && $scope.step == 4) {

				
				if($rootScope.selectedPeriod == 0){ $scope.s4_price = $rootScope.selectedPrice0; }     
				if($rootScope.selectedPeriod == 1){ $scope.s4_price = $rootScope.selectedPrice1; }     
				if($rootScope.selectedPeriod == 2){ $scope.s4_price = $rootScope.selectedPrice2; }     
				
				if($scope.s4_price == '' || !$scope.s4_price){ 
					$rootScope.campaing_periode_msg = true;
					$scope.error_msg = true;
					// console.log('_-_');
				}else{
					$rootScope.campaing_periode_msg = false;
					$scope.error_msg = false;
					// console.log('_+_');
				}
				
				// console.log($scope.s4_price);
				// console.log($scope.error_msg);
/*
                if (!$('.period_select_check').hasClass('active')) {
                    $rootScope.campaing_periode_msg = true;
                    $scope.error_msg = true;
                }
                else {
                    $rootScope.campaing_periode_msg = false;
                    $scope.error_msg = false;
                }*/


// console.log('*********************************');
// date for each period
if($rootScope.selectedPeriod == 0){
	// start date
	if(s_date_s4 == ''){
		var $tmp = $('.start-date #start').text().split(".");
		s_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
		localStorageService.set('s4_time1_start',s_date_s4);
	}else{
		if(s_date_s4.indexOf('.') > -1){
			var $tmp = s_date_s4.split(".");
			s_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
		}
		localStorageService.set('s4_time1_start',s_date_s4);
	}
	//end date
	if ($('.end-date #end').text() != ''){
		// console.log($('.end-date #end').text());
		$rootScope.campaing_periode_date_msg = false;
		$scope.error_msg = false;
		if(e_date_s4 == ''){
			var $tmp = $('.end-date #end').text().split(".");
			e_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
			localStorageService.set('s4_time1_end',e_date_s4);
		}else{
			if(e_date_s4.indexOf('.') > -1){
				var $tmp = e_date_s4.split(".");
				e_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
			}
			localStorageService.set('s4_time1_end',e_date_s4);
		}
	}else{
		// console.log('else ERROR');
		$rootScope.campaing_periode_date_msg = true;
		$scope.error_msg = true;
	}
	
}
// console.log('*********************************');



if($rootScope.selectedPeriod == 1){
	$rootScope.campaing_periode_date_msg = false;
	$scope.error_msg = false;
	//start date
	if(date_s4 == ''){
		var $tmp = $('.start-date #start').text().split(".");
		date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
		localStorageService.set('s4_time2',date_s4);
	}else{
		if(date_s4.indexOf('.') > -1){
			var $tmp = date_s4.split(".");
			date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
		}
		localStorageService.set('s4_time2',date_s4);
	}
}





if($rootScope.selectedPeriod == 2){
	//start date
	if(s_date_s4 == ''){
		var $tmp = $('.start-date #start').text().split(".");
		s_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
		localStorageService.set('s4_time3_start',s_date_s4);
	}else{
		if(s_date_s4.indexOf('.') > -1){
			var $tmp = s_date_s4.split(".");
			s_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
		}
		localStorageService.set('s4_time3_start',s_date_s4);
	}
	//end date
	if ($('.end-date #end').text() != ''){
		$rootScope.campaing_periode_date_msg = false;
		$scope.error_msg = false;
		if(e_date_s4 == ''){
			var $tmp = $('.end-date #end').text().split(".");
			e_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
			localStorageService.set('s4_time3_end',e_date_s4);
		}else{
			if(e_date_s4.indexOf('.') > -1){
				var $tmp = e_date_s4.split(".");
				e_date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
			}
			localStorageService.set('s4_time3_end',e_date_s4);
		};
	}else{
		$rootScope.campaing_periode_date_msg = true;
		$scope.error_msg = true;
	}
}




                if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step && $scope.error_msg == false) {
                    $rootScope.$broadcast('saveData', step);
                    $rootScope.step_completed_mark['s' + $scope.step] = true;
					localStorageService.set('s' + $scope.step,true);
                    $location.path('step/' + step);
                }
                else {
                    if ($scope.error_msg == false) {
                        $rootScope.activ_lats_tab = false;
                        if ($scope.step < step) {
                            subtabs.passData('+');
                            $rootScope.$broadcast('saveData', step);
                        }
                        if ($scope.step > step) {
                            if ($rootScope.active_sub_tab == 1) {
                                $rootScope.$broadcast('saveData', step);
                                $rootScope.step_completed_mark['s' + $scope.step] = true;
								localStorageService.set('s' + $scope.step,true);
                                $location.path('step/' + step);
                            } 
                            else {
                                $rootScope.$broadcast('saveData', step);
                                subtabs.passData('-');
                            }
                        }
                    }
                }




            }

// ELSE STEPS
            else {
            	console.log('steps_ELSE');

                if (($rootScope.active_sub_tab == $last || $scope.step == 1 || $scope.step == 4) && $scope.step < step) {
                	console.log('steps_ELSE if');
                    //console.log('s2');
                    $rootScope.$broadcast('saveData', step);
                    $rootScope.step_completed_mark['s' + $scope.step] = true;
                    localStorageService.set('s' + $scope.step,true);
                    $location.path('step/' + step);
                }
                else {
					console.log('steps_ELSE else');
					if ($scope.error_msg == false) {
						console.log('s3');
						$rootScope.activ_lats_tab = false;
						if ($scope.step < step) {
                            console.log('s4');
							subtabs.passData('+');
							$rootScope.$broadcast('saveData', step);
						}
						if ($scope.step > step) {
                            console.log('s5');
							if ($rootScope.active_sub_tab == 1) {
                                console.log('s6');
								$rootScope.$broadcast('saveData', step);
								// $rootScope.step_completed_mark['s' + $scope.step] = true;
								// localStorageService.set('s' + $scope.step,true);
								$location.path('step/' + step);
							} else {
								$rootScope.$broadcast('saveData', step);
                                console.log('s7');
								subtabs.passData('-');
							}

						}
					}
                }
            }
        };
        $rootScope.campaing_logo_img_msg = false;
        $rootScope.campaing_have_src_msg = false;

        if (!AuthService.checkUserLoggedIn()){ $location.path('/login'); }
    }])
    .directive('navigationTop', ['$route', function($route){
            return {
              restrict: 'E',
              templateUrl:'templates/steps/navigation-top.html'
            };
        }])
    .directive('navigationBottom', ['$route', function($route){
            return {
                restrict: 'E',
                templateUrl:'templates/steps/navigation-bottom.html'
            };
        }])
// page - My Account
	.controller('AcountController', ['$scope', '$http', 'localStorageService', 'PlacesAutocomplete', 'SavingToLocalStorageService','$routeParams','$rootScope', function($scope, $http, localStorageService, PlacesAutocomplete, SavingToLocalStorageService, $routeParams, $rootScope){
		console.log('AcountController');
		$scope.test_var = 'test_test';
		$scope.user_id = '';
		$scope.user_phone = '';
		$scope.user_f_name = '';
		$scope.user_l_name = '';
		$scope.user_email = '';
		$scope.user_pass = '';
		$scope.last_id_campaing = '';
		$scope.user_fl_name = false;
		$scope.user_phone_btn = false;
		$scope.user_email_btn = false;
		$scope.user_pass_btn = false;
		$scope.user_address_btn = false;
		
		$scope.user_street = '';
		$scope.user_region = '';
		$scope.user_city = '';
		$scope.user_zip = '';
		
		$scope.num_invoices = 0;
		$scope.invoice = [];
		
		
		$http.post('api/auth/user').success(function(responce){
			// console.log(responce);
			$scope.user_id = responce.user_data.id;
			$scope.user_phone = responce.user_data.phone_number;
			$scope.user_f_name = responce.user_data.first_name;
			$scope.user_l_name = responce.user_data.last_name;
			$scope.user_email = responce.user_data.email;
			
			$scope.last_id_campaing = responce.address.id;
			$scope.user_street = responce.address.street;
			$scope.user_region = responce.address.state_code;
			$scope.user_city = responce.address.city;
			$scope.user_zip = responce.address.postal_code;
			
			$http.post('api/auth/user_invoices',{'skip':'0','id': $scope.user_id}).success(function(responce){
				// console.log(responce);
				if(responce.length > 0){
					for(var i=0; i<responce.length; ++i){
						$scope.invoice.push({
							date: formatDate(Date.parse(responce[i].created_date)),
						  id: responce[i].id
						});
					}
					$scope.num_invoices = $scope.num_invoices + responce.length;
				}
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		}).error(function(error){
			console.log(error);
			console.log('error');
			window.location.reload();
		});
		
		
		$scope.save_fl_name = function(){
			$http.post('api/auth/update_user', {'field': 'f_name', 'data': $scope.user_f_name, 'id': $scope.user_id }).success(function(responce){
				// console.log(responce);
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
			$http.post('api/auth/update_user', {'field': 'l_name', 'data': $scope.user_l_name, 'id': $scope.user_id }).success(function(responce){
				// console.log(responce);
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		};
		
		$scope.save_phone = function(){
			$http.post('api/auth/update_user', {'field': 'phone', 'data': $scope.user_phone, 'id': $scope.user_id }).success(function(responce){
				// console.log(responce);
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		};
		
		$scope.save_email = function(){
			$http.post('api/auth/update_user', {'field': 'email', 'data': $scope.user_email, 'id': $scope.user_id }).success(function(responce){
				// console.log(responce);
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		};
		
		$scope.save_pass = function(){
			$http.post('api/auth/update_user', {'field': 'pass', 'data': $scope.user_pass, 'id': $scope.user_id }).success(function(responce){
				// console.log(responce);
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		};
		
		$scope.save_address = function(){
			
			var address_fields = {
				'field': 'address',
				'data': $scope.user_email,
				'id': $scope.user_id,
				'user_street': $scope.user_street,
				'user_region': $scope.user_region,
				'user_city': $scope.user_city,
				'user_zip': $scope.user_zip,
				'last_id_campaing': $scope.last_id_campaing
			};
		
			$http.post('api/auth/update_user', address_fields).success(function(responce){
					// console.log(responce);
				}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
				});
		};
		
		$scope.add_invoices = function(){
			$http.post('api/auth/user_invoices',{'skip':$scope.num_invoices,'id': $scope.user_id}).success(function(responce){
				// console.log(responce);
				if(responce.length > 0){
					for(var i=0; i<responce.length; ++i){
						$scope.invoice.push({
							date: formatDate(Date.parse(responce[i].created_date)),
							id: responce[i].id
						});
					}
					$scope.num_invoices = $scope.num_invoices + responce.length;
				}
			}).error(function(error){
				console.log(error);
				console.log('error');
				window.location.reload();
			});
		};
		
		}])
// STEP 1
	.controller('ObjectivesController', ['$scope', '$http', '$location', '$rootScope', 'TabsService', 'localStorageService', function($scope, $http, $location, $rootScope, TabsService, localStorageService){
			console.log('ObjectivesController');
			$scope.objectives = [];
			$http.post('api/objectives').success(function(data){
				console.log(Array.isArray(data));
				if(Array.isArray(data)){
					$scope.objectives = data;
				}else{
					console.log(data);
					localStorageService.remove('token');
					$location.path('/login');
				}
			}).error(function(error){
				console.log('error');
				if(error == 'Unauthorized.'){
					$http.post('api/auth/logout').success(function(responce){
						localStorageService.remove('token');
						console.log(responce);
						$location.path('/login');
					}).error(function(error){
						console.log(error);
						localStorageService.remove('token');
						$location.path('/login');
					});
				}else{
					console.log(error);
					console.log('error');
					window.location.reload();
				}
			});
			$scope.$on('saveData', function(event, data){
				localStorageService.set('campaign_objective', TabsService.selectedTab);
				localStorageService.set('campaign_objective_name', $scope.objectives[TabsService.selectedTab - 1].title);
				$rootScope.active_sub_tab = 1;
			});
        }])
// STEP 2	
	.controller('DemographicsController', ['$filter','$scope', '$http', 'localStorageService', 'PlacesAutocomplete', 'SavingToLocalStorageService','$routeParams','$rootScope', function($filter, $scope, $http, localStorageService, PlacesAutocomplete, SavingToLocalStorageService, $routeParams, $rootScope){
		// console.log('DemographicsController');



		$scope.showMsgs = false;
		$scope.name = localStorageService.get('campaign_name') || '';
		$scope.phone = localStorageService.get('campaign_phone') || '';
		$scope.rel_status = localStorageService.get('campaign_rel_status') || 'All';
		$scope.jb_target = localStorageService.get('campaign_jb_target') || '';
		$scope.age_from = localStorageService.get('campaign_age_from') || '';
		$scope.age_to = localStorageService.get('campaign_age_to') || '';
		$scope.gender = localStorageService.get('campaign_gender') || '';
		$scope.languages = localStorageService.get('campaign_languages') || '';
		
		if($scope.languages != ''){
			// 				$scope.languages = JSON.parse($scope.languages);
			// 				$timeout(function(){$scope.val = true}, 3000);  
			
			
			setTimeout(function() {
				$('#ex1_value').val($scope.languages);
			}, 1000);
			

		}
		
		$scope.locations = localStorageService.get('campaign_locations') || [{}];
		$scope.selectedInterests = localStorageService.get('campaign_interests') || [];
		$scope.interests = [];
		$scope.keywords = localStorageService.get('campaign_keywords') || [{},{},{},{}];
		$scope.websites = localStorageService.get('campaign_websites') || [{},{},{},{}];
		
		$scope.jb_target_arr = localStorageService.get('campaign_jb_target_arr') || [{}];
		
		var keywordsLength = $scope.keywords.length;
		var websitesLength = $scope.websites.length;
		
		if(keywordsLength < 4) {
			for (var i = 4 - keywordsLength; i > 0; i--) {
				$scope.keywords.push({});
			}
		}
		if(websitesLength < 4) {
			for (var i = 4 - websitesLength; i > 0; i--) {
				$scope.websites.push({});
			}
		}
		$scope.addKeyword = function(){
			$scope.keywords.push({});
		};
		$scope.addWebsite = function(){
			$scope.websites.push({});
		};
		$scope.add_jb_target = function(){
			$scope.jb_target_arr.push({});
		};

		$scope.remove_jb_target = function(key){
			$scope.jb_target_arr.splice(key, 1);
		};

		/* -------------- interests -------------- */
		$http.post('api/interests').success(function(responce){
			$scope.interests = responce;
			$scope.selectedInterests.forEach(function(selectInt, i, arr){
				$scope.interests = $scope.interests.filter(function(inter, i){
					return inter.name !== selectInt.name;
				});
			});
			$scope.interests_new = $scope.interests;
			$scope.interests_all = $scope.interests;
		}).error(function(error){
			console.log(error);
			console.log('error');
			window.location.reload();
		});
		
		$scope.$watch('searchInterest', function(newValue, oldValue) {
			$scope.interests_new = $filter('filter')($scope.interests_all, $scope.searchInterest);
			// console.log($scope.interests_new);
			if(!$scope.searchInterest){
				$scope.interests = $scope.interests_all;
			}else{
				$scope.interests = $scope.interests_new;
			}

		});
		$scope.selectInterest = function(key){
			if(!$scope.searchInterest){
				$scope.interests = $scope.interests;
				$scope.interests = $scope.interests_all;
				// console.log('!if');
			}else{
				$scope.interests_new = $filter('filter')($scope.interests, $scope.searchInterest);
				$scope.interests = $scope.interests_new;
				// console.log('!else');
			}

			$scope.selectedInterests.push( $scope.interests_new[key] );

			// console.log($scope.interests);
			for(var i=0; i<$scope.interests_all.length; ++i){

				if($scope.interests_all[i].id == $scope.interests_new[key].id){
					// console.log($scope.interests_new[key]);
					$scope.interests_all.splice(i,1);
				}
			}

			if(!$scope.searchInterest){
				$scope.interests = $scope.interests_all;
			}else{
				$scope.interests = $filter('filter')($scope.interests_all, $scope.searchInterest);
			}

		};

		
		$scope.unselectInterest = function(key){

			$scope.interests_all.push( $scope.selectedInterests[key] );
			$scope.interests = $scope.interests_all;
			$scope.selectedInterests.splice(key, 1);

		};
		
		$scope.selectAllInterests = function(){
			$scope.interests.forEach(function(item){
				$scope.selectedInterests.push( item );
			});
			$scope.interests.splice(0);
		};
		
		/* --------------- locations ---------------- */
		$scope.autocomplete = function(i){
			// console.log('init');
			PlacesAutocomplete.initAutocomplete(i);
			
		};


		$scope.addLocation = function(){
			// console.log('_1_');
			$scope.locations.push({});
			// console.log('_2_');
			// 			  PlacesAutocomplete.initAutocomplete($scope.locations.length - 1);
			// console.log('_3_');
			
		};
		
		$scope.removeLocation = function(key){
			$scope.locations.splice(key, 1);
		};
		
		
		
		
		$(document).on('click','.from_age',function(){
			if($('.from_age').val() == ''){
				$scope.age_from = 18; 
				$rootScope.from_age = 18;
				$('.from_age').val(18);
			}
		});
		
		
		
		$(document).on('click','.to_age',function(){	
			if($('.to_age').val() == ''){
				$scope.age_to = 65;
				$rootScope.to_age = 65;
				$('.to_age').val(65);
			}
		});
		
		
		$scope.countries = [
		{"code":"ab","name":"Abkhaz","nativeName":"аҧсуа"},
		{"code":"aa","name":"Afar","nativeName":"Afaraf"},
		{"code":"af","name":"Afrikaans","nativeName":"Afrikaans"},
		{"code":"ak","name":"Akan","nativeName":"Akan"},
		{"code":"sq","name":"Albanian","nativeName":"Shqip"},
		{"code":"am","name":"Amharic","nativeName":"አማርኛ"},
		{"code":"ar","name":"Arabic","nativeName":"العربية"},
		{"code":"an","name":"Aragonese","nativeName":"Aragonés"},
		{"code":"hy","name":"Armenian","nativeName":"Հայերեն"},
		{"code":"as","name":"Assamese","nativeName":"অসমীয়া"},
		{"code":"av","name":"Avaric","nativeName":"авар мацӀ, магӀарул мацӀ"},
		{"code":"ae","name":"Avestan","nativeName":"avesta"},
		{"code":"ay","name":"Aymara","nativeName":"aymar aru"},
		{"code":"az","name":"Azerbaijani","nativeName":"azərbaycan dili"},
		{"code":"bm","name":"Bambara","nativeName":"bamanankan"},
		{"code":"ba","name":"Bashkir","nativeName":"башҡорт теле"},
		{"code":"eu","name":"Basque","nativeName":"euskara, euskera"},
		{"code":"be","name":"Belarusian","nativeName":"Беларуская"},
		{"code":"bn","name":"Bengali","nativeName":"বাংলা"},
		{"code":"bh","name":"Bihari","nativeName":"भोजपुरी"},
		{"code":"bi","name":"Bislama","nativeName":"Bislama"},
		{"code":"bs","name":"Bosnian","nativeName":"bosanski jezik"},
		{"code":"br","name":"Breton","nativeName":"brezhoneg"},
		{"code":"bg","name":"Bulgarian","nativeName":"български език"},
		{"code":"my","name":"Burmese","nativeName":"ဗမာစာ"},
		{"code":"ca","name":"Catalan; Valencian","nativeName":"Català"},
		{"code":"ch","name":"Chamorro","nativeName":"Chamoru"},
		{"code":"ce","name":"Chechen","nativeName":"нохчийн мотт"},
		{"code":"ny","name":"Chichewa; Chewa; Nyanja","nativeName":"chiCheŵa, chinyanja"},
		{"code":"zh","name":"Chinese","nativeName":"中文 (Zhōngwén), 汉语, 漢語"},
				{"code":"cv","name":"Chuvash","nativeName":"чӑваш чӗлхи"},
			 {"code":"kw","name":"Cornish","nativeName":"Kernewek"},
			 {"code":"co","name":"Corsican","nativeName":"corsu, lingua corsa"},
			 {"code":"cr","name":"Cree","nativeName":"ᓀᐦᐃᔭᐍᐏᐣ"},
			 {"code":"hr","name":"Croatian","nativeName":"hrvatski"},
			 {"code":"cs","name":"Czech","nativeName":"česky, čeština"},
			 {"code":"da","name":"Danish","nativeName":"dansk"},
			 {"code":"dv","name":"Divehi; Dhivehi; Maldivian;","nativeName":"ދިވެހި"},
			 {"code":"nl","name":"Dutch","nativeName":"Nederlands, Vlaams"},
			 {"code":"en","name":"English","nativeName":"English"},
			 {"code":"eo","name":"Esperanto","nativeName":"Esperanto"},
			 {"code":"et","name":"Estonian","nativeName":"eesti, eesti keel"},
			 {"code":"ee","name":"Ewe","nativeName":"Eʋegbe"},
			 {"code":"fo","name":"Faroese","nativeName":"føroyskt"},
			 {"code":"fj","name":"Fijian","nativeName":"vosa Vakaviti"},
			 {"code":"fi","name":"Finnish","nativeName":"suomi, suomen kieli"},
			 {"code":"fr","name":"French","nativeName":"français, langue française"},
			 {"code":"ff","name":"Fula; Fulah; Pulaar; Pular","nativeName":"Fulfulde, Pulaar, Pular"},
			 {"code":"gl","name":"Galician","nativeName":"Galego"},
			 {"code":"ka","name":"Georgian","nativeName":"ქართული"},
			 {"code":"de","name":"German","nativeName":"Deutsch"},
			 {"code":"el","name":"Greek, Modern","nativeName":"Ελληνικά"},
			 {"code":"gn","name":"Guaraní","nativeName":"Avañeẽ"},
			 {"code":"gu","name":"Gujarati","nativeName":"ગુજરાતી"},
			 {"code":"ht","name":"Haitian; Haitian Creole","nativeName":"Kreyòl ayisyen"},
			 {"code":"ha","name":"Hausa","nativeName":"Hausa, هَوُسَ"},
			 {"code":"he","name":"Hebrew (modern)","nativeName":"עברית"},
				{"code":"hz","name":"Herero","nativeName":"Otjiherero"},
			 {"code":"hi","name":"Hindi","nativeName":"हिन्दी, हिंदी"},
			 {"code":"ho","name":"Hiri Motu","nativeName":"Hiri Motu"},
			 {"code":"hu","name":"Hungarian","nativeName":"Magyar"},
			 {"code":"ia","name":"Interlingua","nativeName":"Interlingua"},
			 {"code":"id","name":"Indonesian","nativeName":"Bahasa Indonesia"},
			 {"code":"ie","name":"Interlingue","nativeName":"Originally called Occidental; then Interlingue after WWII"},
			 {"code":"ga","name":"Irish","nativeName":"Gaeilge"},
			 {"code":"ig","name":"Igbo","nativeName":"Asụsụ Igbo"},
			 {"code":"ik","name":"Inupiaq","nativeName":"Iñupiaq, Iñupiatun"},
			 {"code":"io","name":"Ido","nativeName":"Ido"},
			 {"code":"is","name":"Icelandic","nativeName":"Íslenska"},
			 {"code":"it","name":"Italian","nativeName":"Italiano"},
			 {"code":"iu","name":"Inuktitut","nativeName":"ᐃᓄᒃᑎᑐᑦ"},
			 {"code":"ja","name":"Japanese","nativeName":"日本語 (にほんご／にっぽんご)"},
				{"code":"jv","name":"Javanese","nativeName":"basa Jawa"},
			 {"code":"kl","name":"Kalaallisut, Greenlandic","nativeName":"kalaallisut, kalaallit oqaasii"},
			 {"code":"kn","name":"Kannada","nativeName":"ಕನ್ನಡ"},
			 {"code":"kr","name":"Kanuri","nativeName":"Kanuri"},
			 {"code":"ks","name":"Kashmiri","nativeName":"कश्मीरी, كشميري‎"},
			 {"code":"kk","name":"Kazakh","nativeName":"Қазақ тілі"},
			 {"code":"km","name":"Khmer","nativeName":"ភាសាខ្មែរ"},
			 {"code":"ki","name":"Kikuyu, Gikuyu","nativeName":"Gĩkũyũ"},
			 {"code":"rw","name":"Kinyarwanda","nativeName":"Ikinyarwanda"},
			 {"code":"ky","name":"Kirghiz, Kyrgyz","nativeName":"кыргыз тили"},
			 {"code":"kv","name":"Komi","nativeName":"коми кыв"},
			 {"code":"kg","name":"Kongo","nativeName":"KiKongo"},
			 {"code":"ko","name":"Korean","nativeName":"한국어 (韓國語), 조선말 (朝鮮語)"},
				{"code":"ku","name":"Kurdish","nativeName":"Kurdî, كوردی‎"},
			 {"code":"kj","name":"Kwanyama, Kuanyama","nativeName":"Kuanyama"},
			 {"code":"la","name":"Latin","nativeName":"latine, lingua latina"},
			 {"code":"lb","name":"Luxembourgish, Letzeburgesch","nativeName":"Lëtzebuergesch"},
			 {"code":"lg","name":"Luganda","nativeName":"Luganda"},
			 {"code":"li","name":"Limburgish, Limburgan, Limburger","nativeName":"Limburgs"},
			 {"code":"ln","name":"Lingala","nativeName":"Lingála"},
			 {"code":"lo","name":"Lao","nativeName":"ພາສາລາວ"},
			 {"code":"lt","name":"Lithuanian","nativeName":"lietuvių kalba"},
			 {"code":"lu","name":"Luba-Katanga","nativeName":""},
			 {"code":"lv","name":"Latvian","nativeName":"latviešu valoda"},
			 {"code":"gv","name":"Manx","nativeName":"Gaelg, Gailck"},
			 {"code":"mk","name":"Macedonian","nativeName":"македонски јазик"},
			 {"code":"mg","name":"Malagasy","nativeName":"Malagasy fiteny"},
			 {"code":"ms","name":"Malay","nativeName":"bahasa Melayu, بهاس ملايو‎"},
			 {"code":"ml","name":"Malayalam","nativeName":"മലയാളം"},
			 {"code":"mt","name":"Maltese","nativeName":"Malti"},
			 {"code":"mi","name":"Māori","nativeName":"te reo Māori"},
			 {"code":"mr","name":"Marathi (Marāṭhī)","nativeName":"मराठी"},
				{"code":"mh","name":"Marshallese","nativeName":"Kajin M̧ajeļ"},
			 {"code":"mn","name":"Mongolian","nativeName":"монгол"},
			 {"code":"na","name":"Nauru","nativeName":"Ekakairũ Naoero"},
			 {"code":"nv","name":"Navajo, Navaho","nativeName":"Diné bizaad, Dinékʼehǰí"},
			 {"code":"nb","name":"Norwegian Bokmål","nativeName":"Norsk bokmål"},
			 {"code":"nd","name":"North Ndebele","nativeName":"isiNdebele"},
			 {"code":"ne","name":"Nepali","nativeName":"नेपाली"},
			 {"code":"ng","name":"Ndonga","nativeName":"Owambo"},
			 {"code":"nn","name":"Norwegian Nynorsk","nativeName":"Norsk nynorsk"},
			 {"code":"no","name":"Norwegian","nativeName":"Norsk"},
			 {"code":"ii","name":"Nuosu","nativeName":"ꆈꌠ꒿ Nuosuhxop"},
			 {"code":"nr","name":"South Ndebele","nativeName":"isiNdebele"},
			 {"code":"oc","name":"Occitan","nativeName":"Occitan"},
			 {"code":"oj","name":"Ojibwe, Ojibwa","nativeName":"ᐊᓂᔑᓈᐯᒧᐎᓐ"},
			 {"code":"cu","name":"Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic","nativeName":"ѩзыкъ словѣньскъ"},
			 {"code":"om","name":"Oromo","nativeName":"Afaan Oromoo"},
			 {"code":"or","name":"Oriya","nativeName":"ଓଡ଼ିଆ"},
			 {"code":"os","name":"Ossetian, Ossetic","nativeName":"ирон æвзаг"},
			 {"code":"pa","name":"Panjabi, Punjabi","nativeName":"ਪੰਜਾਬੀ, پنجابی‎"},
			 {"code":"pi","name":"Pāli","nativeName":"पाऴि"},
			 {"code":"fa","name":"Persian","nativeName":"فارسی"},
			 {"code":"pl","name":"Polish","nativeName":"polski"},
			 {"code":"ps","name":"Pashto, Pushto","nativeName":"پښتو"},
			 {"code":"pt","name":"Portuguese","nativeName":"Português"},
			 {"code":"qu","name":"Quechua","nativeName":"Runa Simi, Kichwa"},
			 {"code":"rm","name":"Romansh","nativeName":"rumantsch grischun"},
			 {"code":"rn","name":"Kirundi","nativeName":"kiRundi"},
			 {"code":"ro","name":"Romanian, Moldavian, Moldovan","nativeName":"română"},
			 {"code":"ru","name":"Russian","nativeName":"русский язык"},
			 {"code":"sa","name":"Sanskrit (Saṁskṛta)","nativeName":"संस्कृतम्"},
				{"code":"sc","name":"Sardinian","nativeName":"sardu"},
			 {"code":"sd","name":"Sindhi","nativeName":"सिन्धी, سنڌي، سندھی‎"},
			 {"code":"se","name":"Northern Sami","nativeName":"Davvisámegiella"},
			 {"code":"sm","name":"Samoan","nativeName":"gagana faa Samoa"},
			 {"code":"sg","name":"Sango","nativeName":"yângâ tî sängö"},
			 {"code":"sr","name":"Serbian","nativeName":"српски језик"},
			 {"code":"gd","name":"Scottish Gaelic; Gaelic","nativeName":"Gàidhlig"},
			 {"code":"sn","name":"Shona","nativeName":"chiShona"},
			 {"code":"si","name":"Sinhala, Sinhalese","nativeName":"සිංහල"},
			 {"code":"sk","name":"Slovak","nativeName":"slovenčina"},
			 {"code":"sl","name":"Slovene","nativeName":"slovenščina"},
			 {"code":"so","name":"Somali","nativeName":"Soomaaliga, af Soomaali"},
			 {"code":"st","name":"Southern Sotho","nativeName":"Sesotho"},
			 {"code":"es","name":"Spanish; Castilian","nativeName":"español, castellano"},
			 {"code":"su","name":"Sundanese","nativeName":"Basa Sunda"},
			 {"code":"sw","name":"Swahili","nativeName":"Kiswahili"},
			 {"code":"ss","name":"Swati","nativeName":"SiSwati"},
			 {"code":"sv","name":"Swedish","nativeName":"svenska"},
			 {"code":"ta","name":"Tamil","nativeName":"தமிழ்"},
			 {"code":"te","name":"Telugu","nativeName":"తెలుగు"},
			 {"code":"tg","name":"Tajik","nativeName":"тоҷикӣ, toğikī, تاجیکی‎"},
			 {"code":"th","name":"Thai","nativeName":"ไทย"},
			 {"code":"ti","name":"Tigrinya","nativeName":"ትግርኛ"},
			 {"code":"bo","name":"Tibetan Standard, Tibetan, Central","nativeName":"བོད་ཡིག"},
			 {"code":"tk","name":"Turkmen","nativeName":"Türkmen, Түркмен"},
			 {"code":"tl","name":"Tagalog","nativeName":"Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔"},
			 {"code":"tn","name":"Tswana","nativeName":"Setswana"},
			 {"code":"to","name":"Tonga (Tonga Islands)","nativeName":"faka Tonga"},
				{"code":"tr","name":"Turkish","nativeName":"Türkçe"},
			 {"code":"ts","name":"Tsonga","nativeName":"Xitsonga"},
			 {"code":"tt","name":"Tatar","nativeName":"татарча, tatarça, تاتارچا‎"},
			 {"code":"tw","name":"Twi","nativeName":"Twi"},
			 {"code":"ty","name":"Tahitian","nativeName":"Reo Tahiti"},
			 {"code":"ug","name":"Uighur, Uyghur","nativeName":"Uyƣurqə, ئۇيغۇرچە‎"},
			 {"code":"uk","name":"Ukrainian","nativeName":"українська"},
			 {"code":"ur","name":"Urdu","nativeName":"اردو"},
			 {"code":"uz","name":"Uzbek","nativeName":"zbek, Ўзбек, أۇزبېك‎"},
			 {"code":"ve","name":"Venda","nativeName":"Tshivenḓa"},
			 {"code":"vi","name":"Vietnamese","nativeName":"Tiếng Việt"},
			 {"code":"vo","name":"Volapük","nativeName":"Volapük"},
			 {"code":"wa","name":"Walloon","nativeName":"Walon"},
			 {"code":"cy","name":"Welsh","nativeName":"Cymraeg"},
			 {"code":"wo","name":"Wolof","nativeName":"Wollof"},
			 {"code":"fy","name":"Western Frisian","nativeName":"Frysk"},
			 {"code":"xh","name":"Xhosa","nativeName":"isiXhosa"},
			 {"code":"yi","name":"Yiddish","nativeName":"ייִדיש"},
			 {"code":"yo","name":"Yoruba","nativeName":"Yorùbá"},
			 {"code":"za","name":"Zhuang, Chuang","nativeName":"Saɯ cueŋƅ, Saw cuengh"}
		];
		
		
		if($('#exl_dropdown').length){
			$('.content').animate({
				scrollTop: $("#ex1_value").offset().top
			}, 500);
		}
		
		
		
		$scope.$watch("languages", function(newValue, oldValue) {
			// 				console.log(newValue.title);
			// 				$scope.languages.originalObject.name
			$rootScope.campaing_languages = $scope.languages;
		});
		$scope.$watch(function() {
			return $scope.languages;
		}, function(newValue, oldValue) {
			// 				console.log("change detected: " + newValue);
			// 				console.log($scope.languages);
		});			
		
		
		
		
		
		
		
		
		/* ------------------ saving data to LocalStorage -------------- */
		
		function saveLocationsAutocomplete(){
			$scope.locations.forEach(function(location, i, arr){
				location.location = document.getElementById('location_' + i).value;
				location.cities = document.getElementById('locality_' + i).value;
				location.postcode = document.getElementById('postal_code_' + i).value;
			});
		}
		$scope.$on('saveData', function(){
			if($scope.rel_status == ''){
				$scope.rel_status = 'All';
			}
			$scope.age_from = $rootScope.from_age;
			$scope.age_to = $rootScope.to_age;
			
			// 				console.log($scope.languages.originalObject);
			
			if(typeof $scope.languages.originalObject !== 'undefined'){
				// 					console.log('11111');
				$tmp_lang = $scope.languages.originalObject.name;
				
			}else{
				$tmp_lang = $scope.languages;
			}
			
			
			saveLocationsAutocomplete();
			SavingToLocalStorageService.saveToLocalStorage('campaign_name',  $scope.name);
			SavingToLocalStorageService.saveToLocalStorage('campaign_phone',  $scope.phone);
			
			SavingToLocalStorageService.saveToLocalStorage('campaign_rel_status',  $scope.rel_status);
			SavingToLocalStorageService.saveToLocalStorage('campaign_jb_target',  $scope.jb_target);
			
			SavingToLocalStorageService.saveToLocalStorage('campaign_locations',  SavingToLocalStorageService.clearArrayFromEmptyObjs($scope.locations));
			SavingToLocalStorageService.saveToLocalStorage('campaign_age_from', $scope.age_from);
			SavingToLocalStorageService.saveToLocalStorage('campaign_age_to', $scope.age_to);
			SavingToLocalStorageService.saveToLocalStorage('campaign_gender', $scope.gender);
			SavingToLocalStorageService.saveToLocalStorage('campaign_languages', $tmp_lang);
			SavingToLocalStorageService.saveToLocalStorage('campaign_interests',  $scope.selectedInterests);
			SavingToLocalStorageService.saveToLocalStorage('campaign_keywords',   SavingToLocalStorageService.clearArrayFromEmptyObjs($scope.keywords));
			SavingToLocalStorageService.saveToLocalStorage('campaign_websites',   SavingToLocalStorageService.clearArrayFromEmptyObjs($scope.websites));
			
			SavingToLocalStorageService.saveToLocalStorage('campaign_jb_target_arr',   SavingToLocalStorageService.clearArrayFromEmptyObjs($scope.jb_target_arr));
		});
		// 			autocomplete = new google.maps.places.Autocomplete(document.getElementById("loc"),{types: ["geocode"] });	
// 		$('#ex1_value').attr('autocomplete','off');

		
	}])
// STEP 3
	.controller('UploadingController', ['$scope', '$http', 'localStorageService', 'SavingToLocalStorageService','$rootScope', function($scope, $http, localStorageService, SavingToLocalStorageService, $rootScope){
		// console.log('UploadingController');
		angular.element(document).ready(function () {
                    autosize(jQuery('textarea'));
                });
                $scope.promotion = localStorageService.get('campaign_promotion') || '';
                $scope.images =  localStorageService.get('campaign_images') || {};

                // console.log(localStorageService.get('campaign_images_arr'));
                // console.log(typeof(localStorageService.get('campaign_images_arr')));
                
				$scope.progress_of_upload = 0;

                //images logo START
                $scope.img_logo_src =  localStorageService.get('campaign_logo') || '';
				$rootScope.campaing_have_src = localStorageService.get('campaign_logo') || '';
                if($scope.img_logo_src == ''){
                    $('#img_logo_tmp').attr('src','data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
                }else{
                    $('#img_logo_tmp').attr('src',$scope.img_logo_src);
                    $scope.logo_img_name =  localStorageService.get('campaign_logo_img_name') || '';
					$('.progress_bar_logo').css('width','100%');
                    $scope.have_src = true;
                }
                $scope.submitteds = function($files, $event, $flow){
                    $scope.logo_img = $flow.files[0];
                    $scope.logo_img_name = $scope.logo_img.name;
                    // console.log($scope.logo_img_name);
		    $rootScope.campaing_logo_img = $scope.logo_img_name;
                    localStorageService.set('campaign_logo_img_name',  $scope.logo_img_name);
                };
                $scope.processFiles = function( $files, $event, $flow ){
                    angular.forEach($files, function(flowFile, i){
                        var fileReader = new FileReader();
                        fileReader.onload = function (event) {
                            $('#img_logo_tmp').attr('src',event.target.result);
							
							$('.progress_bar_logo').css('width','100%');
                            localStorageService.set('campaign_logo',  event.target.result);
			    $rootScope.campaing_have_src = event.target.result;
                        };
                        fileReader.readAsDataURL(flowFile.file);
                    });
                };
                //images logo END


                $scope.obj = {};
                $scope.get_flow = function(){
                        $scope.obj.flow.files = $rootScope.imges_arr;
                };
                $scope.someHandlerMethod = function($files, $event, $flow){ };



						// $rootScope.imges_arr_tmp = [];

              $scope.success_1 = function( $file, $message, $flow ){

                  $rootScope.imges_arr = $flow.files;
                  angular.forEach($flow.files, function(flowFile, i){
                   $arr = $('.images_array');
                  $rootScope.imges_arr_tmp[i] = {
                  'name': flowFile.file.name,
                  'type': flowFile.file.type,
                  'src': $($arr[i]).attr('src')
                  };
         
									});
// 									console.log($rootScope.imges_arr_tmp);
                  localStorageService.set('campaign_images_arr',  $rootScope.imges_arr_tmp);

              };
                $scope.processFiles_m = function( $files, $event, $flow){ };




				$scope.progress_images = function( $file, $flow ){
					// console.log($file);
					// console.log($flow);
					$scope.progress_of_upload = $file.progress();
					// console.log($scope.progress_of_upload);
				};


        $scope.$on('saveData', function(){
            // localStorageService.set('campaign_images',  $scope.images);
            //localStorageService.set('campaign_logo',  $scope.logo);
            localStorageService.set('campaign_promotion',  $scope.promotion);
        });

		
		
		
    }])
// STEP 4
	.controller('DatesController', ['$scope', '$http', 'localStorageService','$rootScope', function($scope, $http, localStorageService,$rootScope){
		// console.log('DatesController');
        /* ---------------  initialize ----------------- */
        $scope.periods = [ '2 Weeks', '1 Month', '3 Months' ];
		
		$scope.selectedPeriod = localStorageService.get('campaign_period') || 0;
		$rootScope.selectedPeriod = localStorageService.get('campaign_period') || 0;
		
		
		$scope.subscription_month = localStorageService.get('s4_subscription_month') || '';
	
        $scope.showedDatesFields = false;
		
		$scope.time1_start = localStorageService.get('s4_time1_start') || '';
		$scope.time1_end = localStorageService.get('s4_time1_end') || '';
		$scope.time2 = localStorageService.get('s4_time2') || '';
		$scope.time3_start = localStorageService.get('s4_time3_start') || '';
		$scope.time3_end = localStorageService.get('s4_time3_end') || '';
		
		$scope.selectedPlan0 = localStorageService.get('campaign_plan0') || false;
		$scope.selectedPlan1 = localStorageService.get('campaign_plan1') || false;
		$scope.selectedPlan2 = localStorageService.get('campaign_plan2') || false;
		
		$scope.selectedPrice0 = localStorageService.get('campaign_price0') || '';
		$scope.selectedPrice1 = localStorageService.get('campaign_price1') || '';
		$scope.selectedPrice2 = localStorageService.get('campaign_price2') || '';
		
		$rootScope.selectedPrice0 = localStorageService.get('campaign_price0') || '';
		$rootScope.selectedPrice1 = localStorageService.get('campaign_price1') || '';
		$rootScope.selectedPrice2 = localStorageService.get('campaign_price2') || '';

		var $element = $('.month_range_input');
		var $handle;

		$element
			.rangeslider({
				polyfill: false,
				onInit: function() {
					$handle = $('.rangeslider__handle', this.$range);
					updateHandle($handle[0], this.value);
				}
			})
			.on('input', function() {
				updateHandle($handle[0], this.value);
			});


		$scope.input_range_month = localStorageService.get('$scope.input_range_month') || 3;
		$('.month_range_input').val($scope.input_range_month).change();

	$scope.test_plans_single = [
	{
		'id':1,
		'title':"starter",
		'price':"279.00",
	},
	{
		'id':2,
		'title':"advanced",
		'price':"499.00",
	},
	{
		'id':3,
		'title':"expert",
		'price':"899.00",
	},
	{
		'id':4,
		'title':"VIP",
		'price':"1749.00",
	}
	];
	// console.log($scope.test_plans_single);
	
	$scope.test_plans_subscription = [
	{
		'id':1,
		'title':"starter",
		'price':"299.00",
		'month':'3'
	},
	{
		'id':2,
		'title':"advanced",
		'price':"459.00",
		'month':'6'
	},
	{
		'id':3,
		'title':"expert",
		'price':"839.00",
		'month':'9'
	},
	{
		'id':4,
		'title':"VIP",
		'price':"1649.00",
		'month':'12'
	}
	];
	

	
	
	
	$scope.test_plans_other = [
	{
		'id':1,
		'price':"149.00"
	}
	];
	
	
        var startDate = localStorageService.get('campaign_start_date') || null;

        if (startDate == null){
            $scope.startDate = new Date();
            $scope.startDate.setDate($scope.startDate.getDate() + 7);
        }
        else{
            $scope.startDate = new Date(localStorageService.get('campaign_start_date'));
        }


        $scope.setPeriod = function(key){
			// console.log(key);

			if(key == 1){
				$('.rangeslider').css('opacity','1');
				$('.month_range_input').val($scope.input_range_month).change();
			}else{
				$('.rangeslider').css('opacity','0');
			}

			$scope.selectedPeriod = key;
			$rootScope.selectedPeriod = key;
			
			if($scope.selectedPeriod == 0){
				$('#start').html(set_start_data);
						if($scope.time1_start != '' && $scope.time1_end != ''){
								// console.log('time1');
								// console.log($scope.time1_start);
								// console.log($scope.time1_end);
								var $tmp_s = $scope.time1_start.split("-");
								var $tmp_e = $scope.time1_end.split("-");
								var tmp_d_date_start = new Date($tmp_s[0], $tmp_s[1], $tmp_s[2]);
								var tmp_d_date_end = new Date($tmp_e[0], $tmp_e[1], $tmp_e[2]);
								$('#datepicker').datepicker('setDate', [tmp_d_date_start,tmp_d_date_end]);
								// for start
									var dd = tmp_d_date_start.getDate();
									var mm = tmp_d_date_start.getMonth()+1; //January is 0!
									var yyyy = tmp_d_date_start.getFullYear();
									if(dd<10){ dd='0'+dd } 
									if(mm<10){ mm='0'+mm } 
									var tmp_d_date_start = dd+'.'+mm+'.'+yyyy;
									$('.start-date #start').text(tmp_d_date_start);
									// console.log(tmp_d_date_start);
								// for end
									var dd = tmp_d_date_end.getDate();
									var mm = tmp_d_date_end.getMonth()+1; //January is 0!
									var yyyy = tmp_d_date_end.getFullYear();
									if(dd<10){ dd='0'+dd } 
									if(mm<10){ mm='0'+mm } 
									var tmp_d_date_end = dd+'.'+mm+'.'+yyyy;
									$('.end-date #end').text(tmp_d_date_end);
									// console.log(tmp_d_date_end);
							}
				$scope.test_plans_single.forEach(function(item){
					if (item.id == $scope.selectedPlan0){
						$scope.selectedPrice0 = item['price'];
						$rootScope.selectedPrice0 = item['price'];
						// console.log($scope.selectedPrice0);
					}
				});
			}
			if($scope.selectedPeriod == 1){
				$('#start').html(set_start_data);
								if($scope.time2 != ''){
									// console.log('time2');
									// console.log($scope.time2);
									var $tmp = $scope.time2.split("-");
									var tmp_d_date = new Date($tmp[0], $tmp[1], $tmp[2]);
									$('#datepicker-blue').datepicker('setDate', tmp_d_date);

									var dd = tmp_d_date.getDate();
									var mm = tmp_d_date.getMonth()+1; //January is 0!
									var yyyy = tmp_d_date.getFullYear();
									if(dd<10){ dd='0'+dd } 
									if(mm<10){ mm='0'+mm } 
									var tmp_d_date = dd+'.'+mm+'.'+yyyy;
									$('.start-date #start').text(tmp_d_date);
									// console.log(tmp_d_date);
									
								}
				$scope.test_plans_subscription.forEach(function(item){
					if (item.id == $scope.selectedPlan1){
						$scope.selectedPrice1 = item['price'];
						$rootScope.selectedPrice1 = item['price'];
						// console.log($scope.selectedPrice1);
						$scope.subscription_month = item['month'];
					}
				});
			}
			if($scope.selectedPeriod == 2){
				$('#start').html(set_start_data);
									if($scope.time3_start != '' && $scope.time3_end != ''){
										// console.log('time3');
										// console.log($scope.time3_start);
										// console.log($scope.time3_end);
										var $tmp_s = $scope.time3_start.split("-");
										var $tmp_e = $scope.time3_end.split("-");
										var tmp_d_date_start = new Date($tmp_s[0], $tmp_s[1], $tmp_s[2]);
										var tmp_d_date_end = new Date($tmp_e[0], $tmp_e[1], $tmp_e[2]);
										$('#datepicker').datepicker('setDate', [tmp_d_date_start,tmp_d_date_end]);
										
										// for start
											var dd = tmp_d_date_start.getDate();
											var mm = tmp_d_date_start.getMonth()+1; //January is 0!
											var yyyy = tmp_d_date_start.getFullYear();
											if(dd<10){ dd='0'+dd } 
											if(mm<10){ mm='0'+mm } 
											var tmp_d_date_start = dd+'.'+mm+'.'+yyyy;
											$('.start-date #start').text(tmp_d_date_start);
											// console.log(tmp_d_date_start);
										// for end
											var dd = tmp_d_date_end.getDate();
											var mm = tmp_d_date_end.getMonth()+1; //January is 0!
											var yyyy = tmp_d_date_end.getFullYear();
											if(dd<10){ dd='0'+dd } 
											if(mm<10){ mm='0'+mm } 
											var tmp_d_date_end = dd+'.'+mm+'.'+yyyy;
											$('.end-date #end').text(tmp_d_date_end);
											// console.log(tmp_d_date_end);
									}
				$scope.test_plans_other.forEach(function(item){
					if (item.id == $scope.selectedPlan2){
						$scope.selectedPrice2 = item['price'];
						$rootScope.selectedPrice2 = item['price'];
						// console.log($scope.selectedPrice2);
					}
				});
			}
          //  $scope.setEndDate();
        };
        $scope.isSelectedPeriod = function(key){
			// console.log(key);
            return $scope.selectedPeriod === key;
        };

		$scope.selectPlan = function(id){

			if($scope.selectedPeriod == 1) {
				if(id == 1)	$scope.input_range_month = 3;
				if(id == 2)	$scope.input_range_month = 6;
				if(id == 3)	$scope.input_range_month = 9;
				if(id == 4)	$scope.input_range_month = 12;

				$('.month_range_input').val($scope.input_range_month).change();
			}



			console.log(id);
			if($scope.selectedPeriod == 0){
				$scope.selectedPlan0 = id;
				$scope.test_plans_single.forEach(function(item){
					if (item.id == $scope.selectedPlan0){
						$scope.selectedPrice0 = item['price'];
						$rootScope.selectedPrice0 = item['price'];
						// console.log($scope.selectedPrice0);
					}
				});
			}
			if($scope.selectedPeriod == 1){
				$scope.selectedPlan1 = id;
				$scope.test_plans_subscription.forEach(function(item){
					if (item.id == $scope.selectedPlan1){
						$scope.selectedPrice1 = item['price'];
						$rootScope.selectedPrice1 = item['price'];
						// console.log($scope.selectedPrice1);
						$scope.subscription_month = item['month'];
					}
				});
			}
			if($scope.selectedPeriod == 2){
				$scope.selectedPlan2 = id;
				$scope.test_plans_other.forEach(function(item){
					if (item.id == $scope.selectedPlan2){
						$scope.selectedPrice2 = item['price'];
						$rootScope.selectedPrice2 = item['price'];
						// console.log($scope.selectedPrice2);
					}
				});
			}
		};
        $scope.isSelectedPlan = function(id){
		//	console.log(id);
			if($scope.selectedPeriod == 0){ return $scope.selectedPlan0 == id; }     
			if($scope.selectedPeriod == 1){ return $scope.selectedPlan1 == id; }     
			if($scope.selectedPeriod == 2){ return $scope.selectedPlan2 == id; }            
        };

        
        
        
        
        
        
        
        
        /* ---------------- dates ------------------- */
		$scope.changeDatesFields = function(){
			// console.log($scope.showedDatesFields);
			$scope.showedDatesFields = ($scope.showedDatesFields) ? false: true;
		};
		
		$scope.setEndDate = function(){
			// console.log($scope.startDate);
			// console.log($scope.endDate);
			
			
			if (!$scope.startDate) { $scope.endDate = null; return; }
			$scope.endDate = new Date($scope.startDate);
			switch( $scope.selectedPeriod ){
				case 0: $scope.endDate.setDate($scope.startDate.getDate() + 14);
				break;
				case 1: $scope.endDate.setMonth($scope.startDate.getMonth() + 1);
				break;
				case 2: $scope.endDate.setMonth($scope.startDate.getMonth() + 3);
				break;
				default: $scope.endDate = new Date();
				break;
			}
		};
		
		$scope.setStartDate = function(){
			// console.log($scope.startDate);
			// console.log($scope.endDate);
			
			if (!$scope.endDate) { $scope.startDate = null; return; }
			$scope.startDate = new Date($scope.endDate);
			switch( $scope.selectedPeriod ){
				case 0: $scope.startDate.setDate($scope.endDate.getDate() - 14);
				break;
				case 1: $scope.startDate.setMonth($scope.endDate.getMonth() - 1);
				break;
				case 2: $scope.startDate.setMonth($scope.endDate.getMonth() - 3);
				break;
				default: $scope.startDate = new Date();
				break;
			}
		};
		
		$scope.setEndDate();
		
        /*-------------- plans --------------*/
		$http.post('api/plans').success(function(responce){
			console.log('responce');
			$scope.plans = responce;
		}).error(function(error){
			console.log(error);
			console.log('error');
			window.location.reload();
		});
		
		
       
		custom_ui();
		
		
// 		if($rootScope.selectedPeriod == 1){
// 			if(date_s4 == ''){
// 				var $tmp = $('.start-date #start').text().split(".");
// 				date_s4 =  $tmp[2] + '-' + ($tmp[1]-1) + '-' + $tmp[0];
// 				localStorageService.set('s4_time2'		,date_s4);
// 			}
// 			console.log(date_s4);
// 		}
// 		$('#datepicker-blue').datepicker('setDate', new Date(2050, 07, 02));
// 		$('#datepicker').datepicker('setDate', [new Date(2016, 07, 02),new Date(2016, 07, 05)]);
		
		if($scope.selectedPeriod == 0){
		//	console.log('time orange');
			$( ".time.orange" ).trigger( "click" );
		}
		else if($scope.selectedPeriod == 1){
		//	console.log('time blue');
			$( ".time.blue" ).trigger( "click" );
		}
		else if($scope.selectedPeriod == 2){
		//	console.log('time green');
			$( ".time.green" ).trigger( "click" );
		}	

// console.log('*** tmp ***');
		if($scope.time1_start != '' && $scope.time1_end != ''){
			// console.log('time1');
			// console.log($scope.time1_start);
			// console.log($scope.time1_end);
			var $tmp_s = $scope.time1_start.split("-");
			var $tmp_e = $scope.time1_end.split("-");
			var tmp_d_date_start = new Date($tmp_s[0], $tmp_s[1], $tmp_s[2]);
			var tmp_d_date_end = new Date($tmp_e[0], $tmp_e[1], $tmp_e[2]);
			$('#datepicker').datepicker('setDate', [tmp_d_date_start,tmp_d_date_end]);
			// for start
				var dd = tmp_d_date_start.getDate();
				var mm = tmp_d_date_start.getMonth()+1; //January is 0!
				var yyyy = tmp_d_date_start.getFullYear();
				if(dd<10){ dd='0'+dd } 
				if(mm<10){ mm='0'+mm } 
				var tmp_d_date_start = dd+'.'+mm+'.'+yyyy;
				$('.start-date #start').text(tmp_d_date_start);
				// console.log(tmp_d_date_start);
			// for end
				var dd = tmp_d_date_end.getDate();
				var mm = tmp_d_date_end.getMonth()+1; //January is 0!
				var yyyy = tmp_d_date_end.getFullYear();
				if(dd<10){ dd='0'+dd } 
				if(mm<10){ mm='0'+mm } 
				var tmp_d_date_end = dd+'.'+mm+'.'+yyyy;
				$('.end-date #end').text(tmp_d_date_end);
				// console.log(tmp_d_date_end);
		}
		if($scope.time2 != ''){
			// console.log('time2');
			// console.log($scope.time2);
			var $tmp = $scope.time2.split("-");
			var tmp_d_date = new Date($tmp[0], $tmp[1], $tmp[2]);
			$('#datepicker-blue').datepicker('setDate', tmp_d_date);

			var dd = tmp_d_date.getDate();
			var mm = tmp_d_date.getMonth()+1; //January is 0!
			var yyyy = tmp_d_date.getFullYear();
			if(dd<10){ dd='0'+dd } 
			if(mm<10){ mm='0'+mm } 
			var tmp_d_date = dd+'.'+mm+'.'+yyyy;
			$('.start-date #start').text(tmp_d_date);
			// console.log(tmp_d_date);
			
		}
		if($scope.time3_start != '' && $scope.time3_end != ''){
			// console.log('time3');
			// console.log($scope.time3_start);
			// console.log($scope.time3_end);
			var $tmp_s = $scope.time3_start.split("-");
			var $tmp_e = $scope.time3_end.split("-");
			var tmp_d_date_start = new Date($tmp_s[0], $tmp_s[1], $tmp_s[2]);
			var tmp_d_date_end = new Date($tmp_e[0], $tmp_e[1], $tmp_e[2]);
			$('#datepicker').datepicker('setDate', [tmp_d_date_start,tmp_d_date_end]);
			
			// for start
				var dd = tmp_d_date_start.getDate();
				var mm = tmp_d_date_start.getMonth()+1; //January is 0!
				var yyyy = tmp_d_date_start.getFullYear();
				if(dd<10){ dd='0'+dd } 
				if(mm<10){ mm='0'+mm } 
				var tmp_d_date_start = dd+'.'+mm+'.'+yyyy;
				$('.start-date #start').text(tmp_d_date_start);
				// console.log(tmp_d_date_start);
			// for end
				var dd = tmp_d_date_end.getDate();
				var mm = tmp_d_date_end.getMonth()+1; //January is 0!
				var yyyy = tmp_d_date_end.getFullYear();
				if(dd<10){ dd='0'+dd } 
				if(mm<10){ mm='0'+mm } 
				var tmp_d_date_end = dd+'.'+mm+'.'+yyyy;
				$('.end-date #end').text(tmp_d_date_end);
				// console.log(tmp_d_date_end);
		}
// console.log('*** tmp ***');
		
		
		/*--------------- saving to LocalStorage ---------------*/
		$scope.$on('saveData', function(){
			// 	  console.log($scope.selectedPrice);


			localStorageService.set('input_range_month',  $scope.input_range_month);
			localStorageService.set('campaign_period',  $scope.selectedPeriod);

			
			if($scope.selectedPeriod == 0){
				localStorageService.set('campaign_start_date',  $scope.time1_start);
				localStorageService.set('campaign_end_date',  $scope.time1_end);
			}
			else if($scope.selectedPeriod == 1){
				localStorageService.set('campaign_start_date',  $scope.time2);
				localStorageService.set('campaign_end_date',  '');
			}
			else if($scope.selectedPeriod == 2){
				localStorageService.set('campaign_start_date',  $scope.time3_start);
				localStorageService.set('campaign_end_date',  $scope.time3_end);
			}
			
			localStorageService.set('s4_subscription_month',$scope.subscription_month);
			
			localStorageService.set('campaign_plan0', $scope.selectedPlan0);
			localStorageService.set('campaign_plan1', $scope.selectedPlan1);
			localStorageService.set('campaign_plan2', $scope.selectedPlan2);
			
			localStorageService.set('campaign_price0', $scope.selectedPrice0);
			localStorageService.set('campaign_price1', $scope.selectedPrice1);
			localStorageService.set('campaign_price2', $scope.selectedPrice2);
		});



    }])
// STEP 5
	.controller('OverviewController', ['$scope', '$http', 'localStorageService', '$rootScope','$location', function($scope, $http, localStorageService, $rootScope, $location){
		// console.log('OverviewController');
		var periods = ['Single Campaign', 'Subscription Campaigns', 'Other Campaigns'],
			interests = localStorageService.get('campaign_interests') || '',
			jb_target_arr = localStorageService.get('campaign_jb_target_arr') || '',
			keywords = localStorageService.get('campaign_keywords') || '';


		function joinWords(arr) {
			if (arr) {
				return arr.map(function (item) {
					return item.name;
				}).join(', ');
			}
			return arr;
		}

		var tmp_s4_period_date = localStorageService.get('campaign_period');

		if (tmp_s4_period_date == 0) {
			localStorageService.set('campaign_plan', localStorageService.get('campaign_plan0'));
			localStorageService.set('campaign_price', localStorageService.get('campaign_price0'));
			localStorageService.set('campaign_start_date', localStorageService.get('s4_time1_start'))
			localStorageService.set('campaign_end_date', localStorageService.get('s4_time1_end'))
		}
		if (tmp_s4_period_date == 1) {
			localStorageService.set('campaign_plan', localStorageService.get('campaign_plan1'));
			localStorageService.set('campaign_price', localStorageService.get('campaign_price1'));
			localStorageService.set('campaign_start_date', localStorageService.get('s4_time2'))
			localStorageService.set('campaign_end_date', localStorageService.get('s4_time2'))
		}
		if (tmp_s4_period_date == 2) {
			localStorageService.set('campaign_plan', localStorageService.get('campaign_plan2'));
			localStorageService.set('campaign_price', localStorageService.get('campaign_price2'));
			localStorageService.set('campaign_start_date', localStorageService.get('s4_time3_start'))
			localStorageService.set('campaign_end_date', localStorageService.get('s4_time3_start'))
		}

var user_id = localStorageService.get('user_id');
		$scope.user_id = user_id;
		var is_skip = localStorageService.get('is_skip_pay') || '';
		if(user_id == 145 || user_id == 51) {
			if (is_skip == '') {
				$scope.fullName = localStorageService.get('fullName') || '';
				$scope.houseNumber = localStorageService.get('houseNumber') || '';
				$scope.city = localStorageService.get('city') || '';
				$scope.postcode = localStorageService.get('postcode') || '';
				$scope.street = localStorageService.get('street') || '';
				$scope.country = localStorageService.get('country') || '';
				$scope.cardType = localStorageService.get('cardType') || '';
				$scope.expiryDate = localStorageService.get('expiryDate') || '';
				$scope.cardNumber = localStorageService.get('cardNumber') || '';
				$scope.securityCode = localStorageService.get('securityCode') || '';
			} else if (is_skip == 'yes') {
				$scope.fullName = 'Somebody Somewhere'; $('.fullName_skip').prop('disabled', true);
				$scope.houseNumber = 'empty'; 			$('.houseNumber_skip').prop('disabled', true);
				$scope.city = 'empty'; 					$('.city_skip').prop('disabled', true);
				$scope.postcode = 'empty'; 				$('.postcode_skip').prop('disabled', true);
				$scope.street = 'empty'; 				$('.street_skip').prop('disabled', true);
				$scope.country = 'empty'; 				$('.country_skip').prop('disabled', true);
				$scope.cardType = 'Visa'; 				$('.cardType_skip').prop('disabled', true); $('.cardType_skip').css('background-color', '#ebebe4');
				$scope.expiryDate = '12/9999'; 			$('.expiryDate_skip').prop('disabled', true);
				$scope.cardNumber = '0123012301230123'; $('.cardNumber_skip').prop('disabled', true);
				$scope.securityCode = '000'; 			$('.securityCode_skip').prop('disabled', true);
				$scope.terms_cond = true; 				$('.terms_cond_skip').prop('disabled', true);
			}
		}else{
			$scope.fullName = localStorageService.get('fullName') || '';
			$scope.houseNumber = localStorageService.get('houseNumber') || '';
			$scope.city = localStorageService.get('city') || '';
			$scope.postcode = localStorageService.get('postcode') || '';
			$scope.street = localStorageService.get('street') || '';
			$scope.country = localStorageService.get('country') || '';
			$scope.cardType = localStorageService.get('cardType') || '';
			$scope.expiryDate = localStorageService.get('expiryDate') || '';
			$scope.cardNumber = localStorageService.get('cardNumber') || '';
			$scope.securityCode = localStorageService.get('securityCode') || '';
		}
		$scope.fullName_msg = false;
		$scope.houseNumber_msg = false;
		$scope.city_msg = false;
		$scope.street_msg = false;
		$scope.country_msg = false;
		$scope.cardType_msg = false;
		$scope.expiryDate_msg = false;
		$scope.cardNumber_msg = false;
		$scope.securityCode_msg = false;
		$scope.terms_cond_msg = false;
		$scope.pay_error = false;

		$scope.ok_pay_show = false;
		$scope.fail_pay_show = false;


		jQuery('.paymentDate_card').on('input', function () {

			var val = $(this).val();
			if (!isNaN(val)) {
				if (val.length > 1) {
					temp_val = val + "/";
					$(this).val(temp_val);
				}
			}

		});


		$scope.obj = {};
		$scope.get_flow = function () {
			$scope.obj.flow.files = $rootScope.imges_arr;
		};
		$scope.someHandlerMethod = function ($files, $event, $flow) {
		};


		// $rootScope.imges_arr_tmp = [];

		$scope.success_1 = function ($file, $message, $flow) {

			$rootScope.imges_arr = $flow.files;
			angular.forEach($flow.files, function (flowFile, i) {
				$arr = $('.images_array');
				$rootScope.imges_arr_tmp[i] = [];
				$rootScope.imges_arr_tmp[i]['name'] = flowFile.file.name;
				$rootScope.imges_arr_tmp[i]['type'] = flowFile.file.type;
				$rootScope.imges_arr_tmp[i]['src'] = $($arr[i]).attr('src');
			});

			// console.log($rootScope.imges_arr_tmp);

			localStorageService.set('campaign_images_arr', $rootScope.imges_arr_tmp);

		};
		$scope.processFiles_m = function ($files, $event, $flow) {
		};


		$scope.images = [];

		$scope.images_tmp = localStorageService.get('campaign_images_arr') || '';

		// console.log($scope.images_tmp);


		if ($scope.images_tmp != '') {


			$scope.images = [];
			$html = '';
			var len = $scope.images_tmp.length;
			for (var i = 0; i < len; i++) {
				// console.log($scope.images_tmp[i]);


				if ($scope.images_tmp[i].src) {

					$scope.images[i] = $scope.images_tmp[i].src;
					$html = $html + '<div class="thumb col-sm-3" ng-repeat="image in images"><div class="thumbnail"><img src="' + $scope.images[i] + '"/></div></div>';
					// }else{
					// 	$arr = $('.images_array');
					// 	 $scope.images_tmp[i].src = $($arr[i]).attr('src');
					// 	 $scope.images[i].link = $scope.images_tmp[i].src;
				}

			}

			$('.images_arr_res').html($html);
			//console.log($scope.images);


		}


		//images START
		$scope.img_logo_src = localStorageService.get('campaign_logo') || '';
		if ($scope.img_logo_src == '') {
			$('#img_logo_tmp').attr('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
		} else {
			$('#img_logo_tmp').attr('src', $scope.img_logo_src);
		}
		//images STOP
		$scope.jb_target = localStorageService.get('campaign_jb_target') || '';
		$scope.rel_stat = localStorageService.get('campaign_rel_status') || '';

		$scope.rel_stat = ($scope.rel_stat == 'all')? 'All' : $scope.rel_stat;

		// console.log($scope.jt_target);
		// console.log($scope.rel_stat);
		$scope.languages = localStorageService.get('campaign_languages') || '';





		$scope.s4_selectedPeriod = localStorageService.get('campaign_period') || 0;
		$scope.s4_time1_start = localStorageService.get('s4_time1_start') || '';
		$scope.s4_time1_end = localStorageService.get('s4_time1_end') || '';
		$scope.s4_time2 = localStorageService.get('s4_time2') || '';
		$scope.s4_time3_start = localStorageService.get('s4_time3_start') || '';
		$scope.s4_time3_end = localStorageService.get('s4_time3_end') || '';

		var start_time = '';
		var end_time = '';

			if($scope.s4_selectedPeriod == 0){
				if($scope.s4_time1_start != '' && $scope.s4_time1_end != ''){
					var $tmp_s = $scope.s4_time1_start.split("-");
					var $tmp_e = $scope.s4_time1_end.split("-");
					var tmp_d_date_start = new Date($tmp_s[0], $tmp_s[1], $tmp_s[2]);
					var tmp_d_date_end = new Date($tmp_e[0], $tmp_e[1], $tmp_e[2]);
					// for start
					var dd = tmp_d_date_start.getDate();
					var mm = tmp_d_date_start.getMonth()+1; //January is 0!
					var yyyy = tmp_d_date_start.getFullYear();
					if(dd<10){ dd='0'+dd }
					if(mm<10){ mm='0'+mm }
					var tmp_d_date_start = dd+'.'+mm+'.'+yyyy;
					start_time = tmp_d_date_start;
					var dd = tmp_d_date_end.getDate();
					var mm = tmp_d_date_end.getMonth()+1; //January is 0!
					var yyyy = tmp_d_date_end.getFullYear();
					if(dd<10){ dd='0'+dd }
					if(mm<10){ mm='0'+mm }
					var tmp_d_date_end = dd+'.'+mm+'.'+yyyy;
					end_time = tmp_d_date_end;
				}

			}
			if($scope.s4_selectedPeriod == 1){
				if($scope.s4_time2 != ''){
					var $tmp = $scope.s4_time2.split("-");
					var tmp_d_date = new Date($tmp[0], $tmp[1], $tmp[2]);
					var dd = tmp_d_date.getDate();
					var mm = tmp_d_date.getMonth()+1; //January is 0!
					var yyyy = tmp_d_date.getFullYear();
					if(dd<10){ dd='0'+dd }
					if(mm<10){ mm='0'+mm }
					var tmp_d_date = dd+'.'+mm+'.'+yyyy;
					start_time = tmp_d_date;

					var plan_month = [];


					plan_month = parseInt(localStorageService.get('input_range_month')) || 3;
					var plan_n = parseInt(localStorageService.get('campaign_plan'))-1;

					var end_time =  new Date($tmp[0], $tmp[1], $tmp[2]);
					end_time.setMonth(end_time.getMonth()+plan_month);
					var dd = end_time.getDate();
					var mm = end_time.getMonth()+1; //January is 0!
					var yyyy = end_time.getFullYear();
					if(dd<10){ dd='0'+dd }
					if(mm<10){ mm='0'+mm }
					var end_time = dd+'.'+mm+'.'+yyyy;
				}
			}
			if($scope.s4_selectedPeriod == 2){
				if($scope.s4_time3_start != '' && $scope.s4_time3_end != ''){
					var $tmp_s = $scope.s4_time3_start.split("-");
					var $tmp_e = $scope.s4_time3_end.split("-");
					var tmp_d_date_start = new Date($tmp_s[0], $tmp_s[1], $tmp_s[2]);
					var tmp_d_date_end = new Date($tmp_e[0], $tmp_e[1], $tmp_e[2]);
					var dd = tmp_d_date_start.getDate();
					var mm = tmp_d_date_start.getMonth()+1; //January is 0!
					var yyyy = tmp_d_date_start.getFullYear();
					if(dd<10){ dd='0'+dd }
					if(mm<10){ mm='0'+mm }
					var tmp_d_date_start = dd+'.'+mm+'.'+yyyy;
					start_time = tmp_d_date_start;
					var dd = tmp_d_date_end.getDate();
					var mm = tmp_d_date_end.getMonth()+1; //January is 0!
					var yyyy = tmp_d_date_end.getFullYear();
					if(dd<10){ dd='0'+dd }
					if(mm<10){ mm='0'+mm }
					var tmp_d_date_end = dd+'.'+mm+'.'+yyyy;
					end_time = tmp_d_date_end;
				}
			}



		$scope.overview = [{
			title: 'Campaign Name',
			value: localStorageService.get('campaign_name') || '',
			location: '/step/2?tab=1'
		},
			{
				title: 'Campaign cost',
				value: localStorageService.get('campaign_price') || '',
				location: '/step/4'
			},
			{
				title: 'Timeframe',
				value: periods[localStorageService.get('campaign_period')] || '',
				location: '/step/4'
			},
			{
				title: 'Start date',
				value: start_time,
				location: '/step/4'
			},
			{
				title: 'End date',
				value: end_time,
				location: '/step/4'
			},
			{
				title: 'Objective',
				value: localStorageService.get('campaign_objective_name') || '',
				location: '/step/1'
			},
			{
				title: 'Phone number',
				value: localStorageService.get('campaign_phone') || '',
				location: '/step/2?tab=1'
			},
			{
				title: 'Promotion',
				value: localStorageService.get('campaign_promotion') || '',
				location: '/step/3?tab=5'
			}
		];


		$scope.targeting = {
			locations: localStorageService.get('campaign_locations') || '',
			gender: localStorageService.get('campaign_gender') || '',
			age: localStorageService.get('campaign_age') || '',
			jb_target_arr: joinWords(jb_target_arr),
			interests: joinWords(interests),
			keywords: joinWords(keywords),
			websites: localStorageService.get('campaign_websites') || ''
		};


		$scope.$on('Confirm_btn', function () {

			console.log($scope.coupon_code);






			if (!localStorageService.get('campaign_objective') || !localStorageService.get('campaign_objective_name')) {
				$location.path('/step/1');
				$rootScope.active_sub_tab = 3;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;

			}

			if (!localStorageService.get('campaign_name') || !localStorageService.get('campaign_phone') || !localStorageService.get('campaign_age_from') || !localStorageService.get('campaign_age_to') || !localStorageService.get('campaign_gender') || !localStorageService.get('campaign_languages')) {
				$location.path('/step/2');
				$rootScope.active_sub_tab = 1;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}

			if (!localStorageService.get('campaign_locations')) {
				// 		   $location.path('/step/2?tab=2');
				$location.path('/step/2').search({tab: 2});
				$rootScope.active_sub_tab = 2;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;

			}

			if (!localStorageService.get('campaign_interests')) {
				$location.path('/step/2').search({tab: 3});
				$rootScope.active_sub_tab = 3;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}

			if (!localStorageService.get('campaign_keywords')) {
				$location.path('/step/2').search({tab: 4});
				$rootScope.active_sub_tab = 4;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}

			if (!localStorageService.get('campaign_logo')) {
				$location.path('/step/3').search({tab: 3});
				$rootScope.active_sub_tab = 3;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}

			if (!localStorageService.get('campaign_images_arr')) {
				$location.path('/step/3').search({tab: 4});
				$rootScope.active_sub_tab = 4;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}

			if (!localStorageService.get('campaign_promotion')) {
				$location.path('/step/3').search({tab: 5});
				$rootScope.active_sub_tab = 5;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}


			var tmp_s4_period_date = localStorageService.get('campaign_period');

			if (tmp_s4_period_date == 0) {
				localStorageService.set('campaign_plan', localStorageService.get('campaign_plan0'));
				localStorageService.set('campaign_price', localStorageService.get('campaign_price0'));
				localStorageService.set('campaign_start_date', localStorageService.get('s4_time1_start'))
				localStorageService.set('campaign_end_date', localStorageService.get('s4_time1_end'))
			}
			if (tmp_s4_period_date == 1) {
				localStorageService.set('campaign_plan', localStorageService.get('campaign_plan1'));
				localStorageService.set('campaign_price', localStorageService.get('campaign_price1'));
				localStorageService.set('campaign_start_date', localStorageService.get('s4_time2'))
				localStorageService.set('campaign_end_date', localStorageService.get('s4_time2'))
			}
			if (tmp_s4_period_date == 2) {
				localStorageService.set('campaign_plan', localStorageService.get('campaign_plan2'));
				localStorageService.set('campaign_price', localStorageService.get('campaign_price2'));
				localStorageService.set('campaign_start_date', localStorageService.get('s4_time3_start'))
				localStorageService.set('campaign_end_date', localStorageService.get('s4_time3_start'))
			}


			if (!localStorageService.get('campaign_price')) {
				$location.path('/step/4');
				$rootScope.active_sub_tab = 1;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}


			localStorageService.set('fullName', $scope.fullName);
			localStorageService.set('houseNumber', $scope.houseNumber);
			localStorageService.set('city', $scope.city);
			localStorageService.set('postcode', $scope.postcode);
			localStorageService.set('street', $scope.street);
			localStorageService.set('country', $scope.country);
			localStorageService.set('cardType', $scope.cardType);
			localStorageService.set('expiryDate', $scope.expiryDate);
			localStorageService.set('cardNumber', $scope.cardNumber);
			localStorageService.set('securityCode', $scope.securityCode);


			if (!$scope.fullName) {
				$scope.fullName_msg = true;
			} else {
				$scope.fullName_msg = false;
			}
			if (!$scope.houseNumber) {
				$scope.houseNumber_msg = true;
			} else {
				$scope.houseNumber_msg = false;
			}
			if (!$scope.city) {
				$scope.city_msg = true;
			} else {
				$scope.city_msg = false;
			}
			if (!$scope.postcode) {
				$scope.postcode_msg = true;
			} else {
				$scope.postcode_msg = false;
			}
			if (!$scope.street) {
				$scope.street_msg = true;
			} else {
				$scope.street_msg = false;
			}
			if (!$scope.country) {
				$scope.country_msg = true;
			} else {
				$scope.country_msg = false;
			}
			if (!$scope.cardType) {
				$scope.cardType_msg = true;
			} else {
				$scope.cardType_msg = false;
			}
			if (!$scope.expiryDate) {
				$scope.expiryDate_msg = true;
			} else {
				$scope.expiryDate_msg = false;
			}
			if (!$scope.cardNumber) {
				$scope.cardNumber_msg = true;
			} else {
				$scope.cardNumber_msg = false;
			}
			if (!$scope.securityCode) {
				$scope.securityCode_msg = true;
			} else {
				$scope.securityCode_msg = false;
			}
			if (!$scope.terms_cond) {
				$scope.terms_cond_msg = true;
			} else {
				$scope.terms_cond_msg = false;
			}


			if (!$scope.fullName || !$scope.houseNumber || !$scope.city || !$scope.postcode || !$scope.street || !$scope.country || !$scope.cardType || !$scope.expiryDate || !$scope.cardNumber || !$scope.terms_cond || !$scope.securityCode && $rootScope.active_sub_tab != 4) {
				$location.path('/step/5').search({tab: 4});
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}


			if (!$scope.fullName || !$scope.houseNumber || !$scope.city || !$scope.postcode || !$scope.street || !$scope.country || !$scope.cardType || !$scope.expiryDate || !$scope.cardNumber || !$scope.terms_cond || !$scope.securityCode) {
				$scope.pay_error = true;
				$scope.pay_error = true;
				return false;
			} else {
				$scope.pay_error = false;
			}

			if ($scope.pay_error == true) {
				// console.log('error = true');
			}

			if ($scope.pay_error == false) {
				// console.log('error = false');
				$('.confirm-button').text('Wait');




				$http.post('api/check_is_used_coupon', {'test': 'test'}).success(function (responce) {
					console.log('check_is_used_coupon');
					var is_user_use_coupon = responce;
					console.log(is_user_use_coupon);
					var new_price = parseInt(localStorageService.get('campaign_price'));
					var use_coupon = 'no';
					if(localStorageService.get('campaign_period') == 0 && localStorageService.get('campaign_plan0') == 1 && $scope.coupon_code == 'SeeLocal50' && is_user_use_coupon == 'no'){
						new_price = new_price - 50; alert('-50, new price = ' + new_price);
						use_coupon = 'yes';
					}
					if(localStorageService.get('campaign_period') == 1 && localStorageService.get('campaign_plan1') == 1 && $scope.coupon_code == 'SeeLocal100' && is_user_use_coupon == 'no'){
						new_price = new_price - 100; alert('-100, new price = ' + new_price);
						use_coupon = 'yes';
					}
					if(localStorageService.get('campaign_period') == 1 && localStorageService.get('campaign_plan1') == 1 && $scope.coupon_code == 'BlackFriday20' && is_user_use_coupon == 'no'){
						var minus_price = new_price*0.20;
						new_price = new_price - minus_price; alert('-100, new price = ' + new_price);
						use_coupon = 'yes';
					}
					console.log(localStorageService.get('campaign_price'));
					console.log(new_price);



				//	localStorageService.set('input_range_month',  $scope.input_range_month);

					var pay_data = {
						'fullName': $scope.fullName,
						'houseNumber': $scope.houseNumber,
						'city': $scope.city,
						'postcode': $scope.postcode,
						'street': $scope.street,
						'country': $scope.country,
						'cardType': $scope.cardType,
						'expiryDate': $scope.expiryDate,
						'cardNumber': $scope.cardNumber,
						'securityCode': $scope.securityCode,
						'campaign_period': localStorage.getItem('seelocal.campaign_period'),
						'start_date': localStorage.getItem('seelocal.campaign_start_date'),
						'month': localStorage.getItem('seelocal.s4_subscription_month'),
						'price': new_price,
						'input_range_month': localStorageService.get('input_range_month'),
						'coupon_code':$scope.coupon_code
					};

					$http.post('api/pay', pay_data).success(function (responce) {
					console.log(responce);
						console.log('responce');
					if (responce.status == 'Failure') {
						$('.confirm_button_pay_msg').text('Fail: ' + responce.msg).fadeIn(0).delay(10000).fadeOut(0);
						$('.confirm-button').fadeOut(0).delay(10000).fadeIn(0);
						$('.confirm-button').text('Confirm & Pay');
					}
					else if (responce.status == 'Success') {
						$('.confirm_button_pay_msg').text('Success').fadeIn(0).delay(10000).fadeOut(0);
						$('.confirm-button').fadeOut(0).delay(10000).fadeIn(0);
					}

					if (responce.status == 'Success') {
						localStorageService.set('campaign_price', new_price);
						$scope.languages = localStorageService.get('campaign_languages');
						if (typeof $scope.languages.originalObject !== 'undefined') {
							$tmp_lang = $scope.languages.originalObject.name;
						} else {
							$tmp_lang = $scope.languages;
						}


						var tmp_plan_s4 = '';
						var tmp_period_s4 = localStorageService.get('campaign_period');
						if (tmp_period_s4 == 0) {
							tmp_plan_s4 = localStorageService.get('campaign_plan0');
						}
						else if (tmp_period_s4 == 1) {
							tmp_plan_s4 = localStorageService.get('campaign_plan1');
						}
						else if (tmp_period_s4 == 2) {
							tmp_plan_s4 = localStorageService.get('campaign_plan2');
						}


						var save_data = {
							'campaign_objective': localStorageService.get('campaign_objective'),
							'campaign_objective_name': localStorageService.get('campaign_objective_name'),
							'campaign_name': localStorageService.get('campaign_name'),
							'campaign_phone': localStorageService.get('campaign_phone'),
							'campaign_locations': localStorageService.get('campaign_locations'),
							'campaign_age_from': localStorageService.get('campaign_age_from'),
							'campaign_age_to': localStorageService.get('campaign_age_to'),
							'campaign_gender': localStorageService.get('campaign_gender'),
							'campaign_languages': $scope.languages,
							'campaign_rel_status': localStorageService.get('campaign_rel_status'),
							'campaign_jb_target': localStorageService.get('campaign_jb_target_arr'),
							'campaign_interests': localStorageService.get('campaign_interests'),
							'campaign_keywords': localStorageService.get('campaign_keywords'),
							'campaign_websites': localStorageService.get('campaign_websites'),
							'campaign_logo': localStorageService.get('campaign_logo'),
							'campaign_logo_img_name': localStorageService.get('campaign_logo_img_name'),
							'campaign_images': localStorageService.get('campaign_images_arr'),
							'campaign_promotion': localStorageService.get('campaign_promotion'),
							'campaign_period': localStorageService.get('campaign_period'),
							'campaign_start_date': localStorageService.get('campaign_start_date'),
							'campaign_end_date': localStorageService.get('campaign_end_date'),
							'campaign_plan': tmp_plan_s4,
							'campaign_price': localStorageService.get('campaign_price'),
							'fullName': $scope.fullName,
							'houseNumber': $scope.houseNumber,
							'city': $scope.city,
							'postcode': $scope.postcode,
							'street': $scope.street,
							'country': $scope.country,
							'cardType': $scope.cardType,
							'expiryDate': $scope.expiryDate,
							'cardNumber': $scope.cardNumber,
							'securityCode': $scope.securityCode,
							'transaction_id': responce.transaction_id || '0000000',
							'use_coupon': use_coupon,
							'input_range_month': localStorageService.get('input_range_month')
						};


						$http.post('api/save_campaing', save_data).success(function (responce) {
							console.log(responce);
							console.log('responce');

							// if (responce == 'creating_done') {

								localStorageService.clearAll();
								$rootScope.sel_lang = '';
								for (var prop in $rootScope) {
									if (prop.substring(0, 1) !== '$') {
										delete $rootScope[prop];
									}
								}
								$rootScope.imges_arr_tmp = false;
								$rootScope.step_completed_mark = {
									's1': false,
									's2': false,
									's3': false,
									's4': false,
									's5': false
								};

								$location.path('/thank-you');
							// }
							$('.confirm-button').text('Confirm & Pay');
						}).error(function (error) {
							$('.confirm-button').text('Confirm & Pay');

							console.log(error);
							console.log('error');
							// window.location.reload();
						});
					}
				}).error(function (error) {
						console.log(error);
						console.log('error');
						// window.location.reload();
				})

				});







			} else {
				return 'error';
			}
		});


		$scope.skip_pay = function(){
			var is_skip = localStorageService.get('is_skip_pay') || '';
			console.log('skip');
			console.log(is_skip);
			if(is_skip == '') {
				localStorageService.set('is_skip_pay','yes');

				$scope.fullName = 'Somebody Somewhere';
				$('.fullName_skip').prop('disabled', true);

				$scope.houseNumber = 'empty';
				$('.houseNumber_skip').prop('disabled', true);

				$scope.city = 'empty';
				$('.city_skip').prop('disabled', true);

				$scope.postcode = 'empty';
				$('.postcode_skip').prop('disabled', true);

				$scope.street = 'empty';
				$('.street_skip').prop('disabled', true);

				$scope.country = 'empty';
				$('.country_skip').prop('disabled', true);

				$scope.cardType = 'Visa';
				$('.cardType_skip').prop('disabled', true);
				$('.cardType_skip').css('background-color', '#ebebe4');

				$scope.expiryDate = '12/9999';
				$('.expiryDate_skip').prop('disabled', true);

				$scope.cardNumber = '0123012301230123';
				$('.cardNumber_skip').prop('disabled', true);

				$scope.securityCode = '000';
				$('.securityCode_skip').prop('disabled', true);

				$scope.terms_cond = true;
				$('.terms_cond_skip').prop('disabled', true);

			}else if(is_skip == 'yes'){
				localStorageService.set('is_skip_pay','');
				$scope.fullName = localStorageService.get('fullName') || '';
				$scope.houseNumber = localStorageService.get('houseNumber') || '';
				$scope.city = localStorageService.get('city') || '';
				$scope.postcode = localStorageService.get('postcode') || '';
				$scope.street = localStorageService.get('street') || '';
				$scope.country = localStorageService.get('country') || '';
				$scope.cardType = localStorageService.get('cardType') || '';
				$scope.expiryDate = localStorageService.get('expiryDate') || '';
				$scope.cardNumber = localStorageService.get('cardNumber') || '';
				$scope.securityCode = localStorageService.get('securityCode') || '';


				$('.fullName_skip').prop('disabled', false);
				$('.houseNumber_skip').prop('disabled', false);
				$('.city_skip').prop('disabled', false);
				$('.postcode_skip').prop('disabled', false);
				$('.street_skip').prop('disabled', false);
				$('.country_skip').prop('disabled', false);
				$('.cardType_skip').prop('disabled', false);
				$('.cardType_skip').css('background-color', '');
				$('.expiryDate_skip').prop('disabled', false);
				$('.cardNumber_skip').prop('disabled', false);
				$('.securityCode_skip').prop('disabled', false);
				$('.terms_cond_skip').prop('disabled', false);
			}
		};


	}])
	.filter('excerptLimitTo', function(){
		return function(input, limit){
			if (input.length <= limit) return input;
			return input.slice(0, limit) + '...';
		}
	})
	.service('SharedProperties', function(){
             var properties = {
                 selectedTab: 1
             };
             return {
                 getProperty: function(property){
                     return properties[property];
                 },
                 setProperty: function(property, value){
                     properties[property] = value;
                 }
             };
        })
    .service('TabsService', ['$route','$rootScope', 'localStorageService', function($route,$rootScope, localStorageService){
            return {
                selectedTab: '',
                constructSelectedTab: function(){
                    if ($route.current.params.step == 1){
                        this.selectedTab = localStorageService.get('campaign_objective') || 1;
                    }
                    else{
                        this.selectedTab = ($route.current.params.tab) ? +$route.current.params.tab : 1;
                    }
                    return this.selectedTab;
                },
                setSelectedTab: function(value){
                    this.selectedTab = value;
                }
            }
        }])
	.factory("sharedService", function ($rootScope) {
		var mySharedService = {};
		mySharedService.values = {};
		mySharedService.passData = function (newData) {
			mySharedService.values = newData;
			$rootScope.$broadcast('update_logged');
		};
		return mySharedService;
	})
	.factory("Confirm_btn", function ($rootScope) {
		var myConfirm_btn = {};
		myConfirm_btn.values = {};
		myConfirm_btn.passData = function (newData) {
			myConfirm_btn.values = newData;
			$rootScope.$broadcast('Confirm_btn');
		};
		return myConfirm_btn;
	})
	.factory("subtabs", function ($rootScope) {
		var subtabs = {};
		subtabs.values = {};
		subtabs.passData = function (newData) {
			subtabs.values = newData;
			$rootScope.$broadcast('subtabs');
		};
		return subtabs;
	})
	.factory('AuthService', ['$http','$rootScope', 'localStorageService','$location', function($http, $rootScope, localStorageService, $location){

        return {
			checkServerLogin: function(){
				console.log('checkServerLogin');
				$http.post('api/auth/check').success(function(data){
					if (data.remember_token) {
						localStorageService.set('token', data.remember_token);
					}else{
						// 		      console.log('_check_');
						// 		      console.log(localStorageService.get('last_user_email'));
						// 		      console.log(data);
						// 		      console.log('_check_');
						// console.log(user);
						//                         localStorageService.clearAll();
 						localStorageService.clearAll();
 						$rootScope.sel_lang = '';
 						for (var prop in $rootScope) {
 							if (prop.substring(0,1) !== '$') {
 								delete $rootScope[prop];
 							}
 						}
 						$rootScope.imges_arr_tmp = false;
 						$rootScope.step_completed_mark = {
 							's1':false,
 							's2':false,
 							's3':false,
 							's4':false,
 							's5':false
 						};
					}

                    console.log($location.path());
                    console.log($location.url());
                    // console.log($location);
				}).error(function(error){
					console.log(error);
					console.log('error');
                    // console.log($location);
                    console.log($location.path());
                    console.log($location.url());
					if($location.url() != '/admin'){
						window.location.reload();
                    }
				});
			},
			 checkUserLoggedIn: function(){
				 console.log('checkServerLogin');
				 return localStorageService.get('token') ? true : false;
			 },
		  login: function(user, success){
			  console.log('login');
				 return $http.post('api/auth/login', user).success(function(responce){
                                     console.log('****************************');
					 console.log(responce);
					console.log('****************************'); 
					 
					if ( responce == 'false' || responce == 'no user' ) {
						responce = 'false';
						success(responce);
					}else{
				 console.log(responce.user);
  						localStorageService.clearAll();
  						$rootScope.sel_lang = '';
  						for (var prop in $rootScope) {
  							if (prop.substring(0,1) !== '$') {
  								delete $rootScope[prop];
  							}
  						}
  						$rootScope.imges_arr_tmp = false;
  						$rootScope.step_completed_mark = {
  							's1':false,
  							's2':false,
  							's3':false,
  							's4':false,
  							's5':false
  						};
 						localStorageService.set('token', responce.user.remember_token);
 						localStorageService.set('user_id', responce.user.id);
 						/*
 						 * Set storage local from DB
 						*/
 						if ( responce.info != 'no' ) {
 							for ( key in responce.info ) {
 								localStorage.setItem(key, responce.info[key]);
                                                             if(key = 'seelocal.campaign_images_arr'){
//                                                                 console.log(responce.info[key]);
                                                             }
 							}
 						}
						/* end set storage local from db */
						success(responce.user);
					}
				 }).error(function(error){
					 console.log(error);
					 console.log('error');
					 window.location.reload();
				 });
			 },
		  logout: function(success){
			  console.log('logout');
				 return $http.post('api/auth/logout').success(function(responce){
					 localStorageService.remove('token');
					 success(responce);
					 
					 
 					 localStorageService.clearAll();
 					 $rootScope.sel_lang = '';
 					 for (var prop in $rootScope) {
 						 if (prop.substring(0,1) !== '$') {
 							 delete $rootScope[prop];
 						 }
 					 }
 					 $rootScope.imges_arr_tmp = false;
 					 $rootScope.step_completed_mark = {
 						 's1':false,
 						 's2':false,
 						 's3':false,
 						 's4':false,
 						 's5':false
 					 };
					 

				 }).error(function(error){
					 console.log(error);
					 console.log('error');

					 localStorageService.remove('token');


					 localStorageService.clearAll();
					 $rootScope.sel_lang = '';
					 for (var prop in $rootScope) {
						 if (prop.substring(0,1) !== '$') {
							 delete $rootScope[prop];
						 }
					 }
					 $rootScope.imges_arr_tmp = false;
					 $rootScope.step_completed_mark = {
						 's1':false,
						 's2':false,
						 's3':false,
						 's4':false,
						 's5':false
					 };

					 // window.location.reload();

				 });
			 },
		  register: function(user, success){
			  console.log('register');
				 return $http.post('api/auth/register', user).success(function(responce){
					 localStorageService.set('token', responce.remember_token);
					 success(responce);
				 }).error(function(error){
					 console.log(error);
					 console.log('error');
					 window.location.reload();
				 });
			 }
        };
    }])


    .factory('PlacesAutocomplete', ['$http', '$rootScope', 'localStorageService', function($http, $rootScope, localStorageService){
        var autocomplete, index,
            componentForm = {
                locality: 'long_name',
                postal_code: 'short_name'
            };

        return {
            initAutocomplete: function(key){
				console.log('******');
				index = key;
                console.log(key);
                autocomplete = new google.maps.places.Autocomplete(
                   (document.getElementById('location_' + key)),{types: ['geocode']}
				);
				console.log(autocomplete);
                autocomplete.addListener('place_changed', this.fillInAddress);
				console.log(this.fillInAddress);
				console.log('******');
			},
            fillInAddress: function(){
				console.log('*-*-*-*-*-*-*-*-*-*-*');
                var place = autocomplete.getPlace();
console.log(place);
                for (var component in componentForm) {
                    document.getElementById(component + '_' + index).value = '';
                    document.getElementById(component + '_' + index).disabled = false;
                }

                // Get each component of the address from the place details
                // and fill the corresponding field on the form.
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType + '_' + index).value = val;
                    }
                }
                
                console.log('*-*-*-*-*-*-*-*-*-*-*');
            }
        };
    }])
    .factory('SavingToLocalStorageService', ['localStorageService', function(localStorageService){
            return {
                clearArrayFromEmptyObjs: function(arr){
                    return arr.filter(function(obj){
                        for (key in obj){
                            if (obj[key] === '')
                                delete obj[key];
                        }
                        return Object.keys(obj).length > 1;
                    });
                },
                saveToLocalStorage: function(item, data){
                    if (data.toString() !== '')
                        localStorageService.set(item, data);
                    else
                        localStorageService.remove(item);
                }
            };
        }])
    .factory('StepsService', ['$http', '$rootScope', 'localStorageService', function($http, $rootScope, localStorageService){
             return {
                calledStep: '',
                prepForSaveData: function(step){
                    this.calledStep = step;
                     console.log(step);
                     console.log('setps_service');
                    this.saveData();
                },
                saveData: function(){
                    $rootScope.$broadcast('saveData');
                    $rootScope.active_sub_tab = 1;
                }
             }
        }]);
}());

/*
 * New code for N.
*/
jQuery(document).ready(function() {

	/*
	 * in step page
	 * save after click next or prev info in db
	*/
	$(document).on('click','.go_ajax_action_step',function(e) {
		e.preventDefault();
		CSRF_TOKEN = jQuery('meta[name="csrf-token"]').attr('content');
		$.ajax({
			url: "api/save_in_db",
			data: {
				'_token' : CSRF_TOKEN,
				'data'	: localStorage
			},
			type: 'POST',
			success: function(response) {
			}
		});
	});
	/* END */

	/* 
	 * add autocomplete off after focus 
	*/
	$(document).on('focus','#ex1_value',function(e) {
		e.preventDefault();
		if ( $(this).attr('autocomplete') != 'off' ) {
			$(this).attr('autocomplete', 'off');
		}
	});
	/* END */
		
});

/* function for change size textarea in step 3 */
function promo_textarea_change_size() {
	var val = $('.promo_textarea').val();
	var array = val.split("\n");
	var new_height = array.length * 25;
	$('.promo_textarea').height(new_height);
}