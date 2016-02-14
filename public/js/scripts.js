// Empty JS for your own code to be here

    /**
     * 1.0 Common Functions
     */
    var setupNotification = function($scope, $http) {
        $scope.notification = {
            count: parseInt(Math.random() * 30)
        };
    };
    
    var setupLogin = function($scope, $http) {
        $scope.login = function() {
            var urlB4login = '/b4login';
            var postData = {
                b4login: location.href
            }
        
            $http({method: 'post', url: urlB4login, data: $.param(postData)}).finally(
                function (){
                    location.href = '/login';
                }
            );
        }
    }
    
    var setupMessage = function($scope, $http) {
        $scope.message = {
            success: false,
            error: false,
            title: '',
            strong: '',
            body: '',
            linkurl: '',
            linktext: '',
            succeed: function(data) {
            	this.clear();
                if ("string" == typeof data) {
                    this.body     = data;
                } else {
                    this.title    = data.title;
                    this.strong   = data.strong;
                    this.body     = data.body;
                    this.linkurl  = data.linkurl;
                    this.linktext = data.linktext;
                }
                this.success = true;
            },
            fail: function(data) {
                this.clear();
                if ("string" == typeof data) {
                    this.body     = data;
                } else {
                    this.title    = data.title;
                    this.strong   = data.strong;
                    this.body     = data.body;
                    this.linkurl  = data.linkurl;
                    this.linktext = data.linktext;
                }
                this.error = true;
            },
            clear: function() {
            	this.success = false;
            	this.error   = false;
                this.title   = this.strong = this.body = this.linkurl = this.linktext = '';
            },
            assign: function(scopeMessage) {
                this.clear();
                if (typeof scopeMessage.error != 'undefined')
                    this.error = scopeMessage.error;
                if (typeof scopeMessage.success != 'undefined')
                    this.success = scopeMessage.success;
                if (typeof scopeMessage.title != 'undefined')
                    this.title = scopeMessage.title;
                if (typeof scopeMessage.strong != 'undefined')
                    this.strong = scopeMessage.strong;
                if (typeof scopeMessage.body != 'undefined')
                    this.body = scopeMessage.body;
                if (typeof scopeMessage.linkurl != 'undefined')
                    this.linkurl = scopeMessage.linkurl;
                if (typeof scopeMessage.linktext != 'undefined')
                    this.linktext = scopeMessage.linktext;
            }
        };

        if (typeof scopeMessage != 'undefined') {
            $scope.message.assign(scopeMessage);
        }
    }
    
    var setupHeader = function($scope, $http) {
        setupLogin($scope, $http);
        setupNotification($scope, $http);
        setupMessage($scope, $http);
        $scope.str2date = str2date;
    }
    
    var handleResponseError = function(response, $scope) {
        // TODO:
        //alert("ERROR: "+JSON.stringify(response));
    	var strong = '', body = '';
        if (angular.isDefined(response.status))
            strong = response.status;
        if (angular.isDefined(response.data.errMsg))
            body = response.data.errMsg;
        else
            body = "service requested is temporarily unavailable.";
        
        $scope.message.fail({strong: strong, body: body});
    };
    
    var str2date = function(str) {
        return new Date(str);
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
        setupHeader($scope, $http);
        
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
                    params: param,
                }).then(
                    function(response){
                        $.merge($scope.home.newsList, response.data.newsList);
                        $scope.home.page++;
                        $scope.home.ready2scroll = true;
                    },
                    function(response){
                        handleResponseError(response, $scope.home);
                    }
                );
            }
        }
        
        $scope.home.loadmore();
    });
    
    /**
     * 50.2 News Page Controller
     */
    var updateYesPercent = function($scope) {
        var yes = 0;
        for (var idx in $scope.news.comments) {
            if ($scope.news.comments[idx].type == 'agree')
                yes++;
        }
        if ($scope.news.comments.length > 0) {
            $scope.news.yesPercent = yes * 100 / $scope.news.comments.length;
        } else {
        	$scope.news.yesPercent = 50;
        }
    };

    var updateNewsComments = function($scope, data) {
        if (angular.isDefined(data.comments)) {
            $scope.news.comments = data.comments;
            updateYesPercent($scope);
        }
    };

    var loadCommentsByNewsID = function($scope, $http, news_id) {
        var urlComment = "/api/news/"+news_id+'/comments';
        $http({
            method: 'get',
            url: urlComment
        }).success(function(data){
            updateNewsComments($scope, data);
        });
    };
    
    var submitCommentForm = function($scope, $http) {
        if ($scope.commentForm.commentContent.$valid &&
                $scope.news.comment.content.length < 1000) {
                var urlComment = '/api/news/'+news_id+'/comment';
                var postData = {
                    "type": $scope.news.comment.type,
                    "content": $scope.news.comment.content
                };
                $http({
                    'method': 'post',
                    'url': urlComment,
                    'data': $.param(postData)
                }).then(
                    function(response) {
                        if (angular.isDefined(response.data.comments)) {
                            $scope.news.comment.content = '';
                            updateNewsComments($scope, response.data);
                            $("button.close").trigger('click');
                        }
                    },
                    function(response) {
                        handleResponseError(response, $scope.news);
                    }
                );
            }
    };
    
    var deleteCommentByID = function($scope, $http, comment_id) {
        var urlComment = "/api/comment/"+comment_id;
        $http({method: 'delete', url: urlComment}).success(function(data){
        	if (data.success == 'true') {
                for (var idx in $scope.news.comments) {
                    if ($scope.news.comments[idx].id == comment_id)
                        $scope.news.comments.splice(idx, 1);
                }
                updateYesPercent($scope);
            }
        });
    };

    ngApp.controller('NewsController', function($scope, $http){
        setupHeader($scope, $http);
        
        $scope.news = {
            currentUserID: user_id,
            comments:      [],
            yesPercent:    50,
            loadComments:  function() {
                return loadCommentsByNewsID($scope, $http, news_id);
            },
            deleteComment: function(comment_id) {
                return deleteCommentByID($scope, $http, comment_id);
            },
            comment: {
                type: 'agree',
                content: '',
                loadForm: function(type) {
                    if ($scope.news.comment.type != type) {
                        $scope.news.comment.content = '';
                        $scope.news.comment.type = type;
                    }
                },
                submitForm: function() {
                    return submitCommentForm($scope, $http);
                }
            },
        };
        
        $scope.news.loadComments();
    });
    
    /**
     * 50.3 User Profile Page Controller
     */
    var loadUserProfilePage = function($scope, $http) {
        $scope.profile.id     = user.id;
        $scope.profile.name   = user.name;
        $scope.profile.avatar = user.avatar;
    };
    
    var validateProfileForm = function($scope) {
        $("#profileForm").validate({
            rules: {
                name: {required:true, minlength:4, maxlength:100},
                uploadAvatar: {required:false, extension:"jpg|jpeg|png"}
            },
            submitHandler: function(form) {
            	if ($scope.profile.backup == $scope.profile.name && 
                    $('#uploadAvatar').val() == '') {
                	//$scope.message.fail("No change has been made.");
                	$('#cancelEditing').trigger('click');
                    return false;
                }
                $scope.profile.submitting = true;
                form.submit();
            }
        });
    }

    ngApp.controller('UserProfileController', function($scope, $http){
        setupHeader($scope, $http);

        $scope.profile = {
            id:            0,
            name:          '',
            backup:        '',
            avatar:        '',
            editing:       false,
            submitting:    false,
            loadPage:      function() {
                return loadUserProfilePage($scope, $http);
            },
            beginEditing:  function() {
                this.editing = true;
                this.backup  = this.name;
                $scope.message.clear();
            },
            cancelEditing: function() {
                this.editing = false;
                this.name    = this.backup;
                $scope.message.clear();
            },
            validateForm:    function() {
                return validateProfileForm($scope);
            }
        }

        $scope.profile.loadPage();
        $scope.profile.validateForm();
    });