<?
session_start();


function getToken($api,$apiKey,$category,$user) {
  if(!isset($_SESSION["veespo_token_$category"])) {
	$url =  "http://".$api."/v1/auth/category/".$category."/user-token?api_key=".$apiKey."&user=".$user;
	$_SESSION["veespo_token_$category"] = json_decode(file_get_contents($url))->data->token;
  }
  return $_SESSION["veespo_token_$category"];
}


$token = getToken("<-- api domain -->",'<-- apikey -->','<-- category -->','<-- user -->');

?>
<!doctype html>
<html lang="en" ng-app="hn">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- Mobile Viewport -->
    <meta name="viewport" content="width=device-width">

	<title>Hacker News</title>

	<!-- Stylesheets -->
	<link href="assets/css/typography.css" rel="stylesheet">
	<link href="assets/css/styles.css" rel="stylesheet">

   <script>
     //brutal hack for token. better to put inside a cookie or localstorage
     window.token = "<?= $token; ?>";
   </script>


  	<!-- Meta Tags for Displaying full screen on iPhone -->
  	<meta name="apple-mobile-web-app-capable" content="yes" />
  	<meta name="apple-mobile-web-app-status-bar-style" content="black" />

  	<!-- Icons for iOS -->
  	<link rel="apple-touch-icon-precomposed" href="assets/img/HN/icons/icon.png"/>
  	<link rel="apple-touch-startup-image" href="assets/img/HN/icons/splash.png" />

</head>


<body ng-controller="TopListCtrl">

<header>
	<div class="container">
		<h1 class="logo">Hacker News</h1>
	</div>
</header>


<div class="container content">

	<ol class="posts">
		<li ng-repeat="post in posts.items">



			<a href="{{ post.url }}">{{ post.title }}</a>
			<span class="url">{{ post.url | shortURL }}</span>
			<small> {{ post.points + " points"}} by {{ post.postedBy }} {{ post.postedAgo }}
				| {{ post.commentCount + " comments" }}</small>
			<span class="pull-center" veespobutton params="post.widgetParams"></span>
		</li>
	</ol>

</div>


    <script>
      var jsUrl = 'http://cdn.veespo.com/wdg/v3/3/wrapper/javascripts/widget.js';
      var s = document.createElement('script');
      s.async = true; s.src = jsUrl;
      document.body.appendChild(s);
    </script>
        <!-- Angular JS Files -->
        <script type="text/javascript" src="assets/js/angular.js"></script>
        <script type="text/javascript" src="assets/js/controllers.js"></script>


</body>
</html>
