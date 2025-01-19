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
                    style="width: 200px; height: 200px;"
                    loop
                    autoplay>
                </lottie-player>
            </div>

            <div class="logoContainer">
                <img src="assets/images/logo.png" title="Logo of the site" alt="Site logo">
            </div>

            <h1 class="welcomeText">Welcome To Spider Search</h1>

            <div class="navigationContainer">
                <a href="index.php" class="navButton">Search</a>
                <a href="crawl-form.php" class="navButton">Crawl</a>
            </div>
        </div>
    </div>
</body>
</html>