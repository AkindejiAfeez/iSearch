<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Spider Search</title>

	<meta name="description" content="Search the web for sites and images.">
	<meta name="keywords" content="Search engine, Spider Crawl, websites">
	<meta name="author" content="Akindeji Afeez">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body>
	<div class="wrapper indexPage">
		<div class="mainSection">
			<!-- Lottie Animation -->
			<div class="animationContainer">
				<lottie-player
					src="assets/animations/spider.json"
					background="transparent"
					speed="1"
					style="width: 150px; height: 150px;"
					loop
					autoplay>
				</lottie-player>
			</div>

			<div class="logoContainer">
				<img src="assets\images\logo.png" title="Logo of the site" alt="Site logo">
			</div>

			<div class="searchContainer">
				<form action="search.php" method="GET">
					<input class="searchBox" type="text" name="term" placeholder="Search the web....">
					<input class="searchButton" type="submit" value="Search">
				</form>
			</div>
		</div>
	</div>
</body>
</html>