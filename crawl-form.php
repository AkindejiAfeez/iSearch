<!DOCTYPE html>
<html>
<head>
    <title>Crawl Website - Spider Search</title>
    <meta name="description" content="Crawl and index websites">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="headerContent">
                <div class="logoContainer">
                    <a href="index.php">
                        <img src="assets/images/logo.png">
                    </a>
                </div>
            </div>
        </div>

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

            <div class="crawlContainer">
                <h2 class="crawlTitle">Enter URL to Crawl</h2>
                
                <form action="crawl.php" method="POST" class="crawlForm">
                    <div class="inputContainer">
                        <input type="url" name="url" 
                               placeholder="https://example.com" 
                               required 
                               class="crawlInput">
                        <button type="submit" class="crawlButton">
                            Start Crawling
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>