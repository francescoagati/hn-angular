
// Adds filters to app
module = angular.module('hn', ['filters']);



module.directive('veespobutton', function($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {

            var params = scope.$eval(attrs.params);


            $timeout(function() {

                  params.callback = function(response) {
                    scope.$apply(function() {
                             params.response = response;
                    });
                  };


                  window._veespo_push = window._veespo_push || [];
                  window._veespo_push.push(['widget.button-modal',element[0],params]);


            },0);

        }
    };
});

var tokenInfo = {
  partner: '<!-- your partnerd local_id -->',
  category: '<!-- your category local_id -->',
  uid: '<!-- user id -->'
}; 

// Controller for displaying top 30 HN Posts

function TopListCtrl($scope, $http) {
  $http.jsonp('http://api.ihackernews.com/page?format=jsonp&callback=JSON_CALLBACK').success(function(data) {

    data.items.forEach(function(news) {

      var id = news.id;
	  var target_info = {
          local_id: id,
          desc1:  news.title,
          desc2:  news.title,
          lang:   'it'
      };

	  
	  if (window.token) {
		// with token
		news.widgetParams =  {
		  title: news.title,
		  target_info: target_info,
		  lang:"it",
		  enviroment:"sandbox",
		  token: token
		};
	  } else {
		// with token info
		news.widgetParams =  {
		  title: news.title,
		  target_info: target_info,
		  lang:"it",
		  enviroment:"sandbox",
		  token_info: tokenInfo
		};
		
	  }
	  

    });

    $scope.posts = data;

    debugger;

  });
}



// This filters module takes a URL and splits it up into its hostname

angular.module('filters', []).
    filter('shortURL', function () {
        return function (text, length, end) {

        	var getLocation = function(href) {
			    var l = document.createElement("a");
			    l.href = href;
			    return l;
			};

        	var url = getLocation(text);

            return url.hostname

        };
    });