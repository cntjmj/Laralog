// Empty JS for your own code to be here

    /**
     * 1.0 Common Functions
     */
    var setupNotification = function($scope, $http) {
        $scope.notification = {
            count: parseInt(Math.random() * 30)
        };
    };
    
    var handleResponseError = function(response, scope) {
        // TODO:
        alert("ERROR: "+JSON.stringify(response));
    };

    /**
     * 50.0 Define The Application And The Config
     */
    var ngApp = angular.module("ngApp", ['ngSanitize', 'infinite-scroll']);

    ngApp.config(function($httpProvider) {
        //Enable cross domain calls
        $httpProvider.defaults.useXDomain = true;
        $httpProvider.defaults.withCredentials = true;
        $httpProvider.defaults.headers.post = {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
          };
    });
    
    /**
     * 50.1 Home/Index Page Controller
     */
    ngApp.controller("HomeController", function($scope, $http){
    	setupNotification($scope, $http);
    	
        $scope.home = {
            ready2scroll : false,
            page         : 0,
            num          : 5,
            newsList     : [],
            loadmore     : function() {
            	$scope.home.ready2scroll = false;

            	var newsUrl;
                if (category_id < 0) {
                    newsUrl  = "/api/news";
                } else {
                    newsUrl = '/api/category/'+category_id+'/news';
                }
                
                var param = {
                    page: $scope.home.page,
                    num : $scope.home.num
                };
                
                $http({
                	method: 'get',
                    url   : newsUrl,
                    data  : param,
                }).then(
                    function(response){
                    	angular.merge($scope.home.newsList, response.data.newsList);
                    },
                    function(response){
                        handleResponseError(response, $scope.home);
                    }
                );
            }
        }
		
		$scope.home.loadmore();
    });