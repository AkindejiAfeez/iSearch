<?php
include("config.php");
include("classes/DomDocumentParser.php");

if(!isset($_POST['url'])) {
    header("Location: crawl-form.php");
    exit;
}

$startUrl = $_POST['url'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crawling Results - Spider Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
            <div class="crawlResultsContainer">
                <h2 class="crawlTitle">Crawling Results</h2>
                <div class="crawlStatus">
                    <p>Started crawling: <?php echo htmlspecialchars($startUrl); ?></p>
                </div>
                <div class="resultsOutput">
                    <?php
                    $alreadyCrawled = array();
                    $crawling = array();
                    $alreadyFoundImages = array();

                    function linkExists($url) {
                        global $con;
                        $query = $con->prepare("SELECT * FROM sites WHERE url = :url");
                        $query->bindParam(":url", $url);
                        $query->execute();
                        return $query->rowCount() != 0;
                    }

                    function insertLink($url, $title, $description, $keywords) {
                        global $con;
                        $query = $con->prepare("INSERT INTO sites(url, title, description, keywords)
                                              VALUES(:url, :title, :description, :keywords)");
                        $query->bindParam(":url", $url);
                        $query->bindParam(":title", $title);
                        $query->bindParam(":description", $description);
                        $query->bindParam(":keywords", $keywords);
                        return $query->execute();
                    }

                    function insertImage($url, $src, $alt, $title) {
                        global $con;
                        $query = $con->prepare("INSERT INTO images(siteUrl, imageUrl, alt, title)
                                              VALUES(:siteUrl, :imageUrl, :alt, :title)");
                        $query->bindParam(":siteUrl", $url);
                        $query->bindParam(":imageUrl", $src);
                        $query->bindParam(":alt", $alt);
                        $query->bindParam(":title", $title);
                        return $query->execute();
                    }

                    function createLink($src, $url) {
                        $scheme = parse_url($url)["scheme"];
                        $host = parse_url($url)["host"];
                        
                        if(substr($src, 0, 2) == "//") {
                            $src =  $scheme . ":" . $src;
                        }
                        else if(substr($src, 0, 1) == "/") {
                            $src = $scheme . "://" . $host . $src;
                        }
                        else if(substr($src, 0, 2) == "./") {
                            $src = $scheme . "://" . $host . dirname(parse_url($url)["path"]) . substr($src, 1);
                        }
                        else if(substr($src, 0, 3) == "../") {
                            $src = $scheme . "://" . $host . "/" . $src;
                        }
                        else if(substr($src, 0, 5) != "https" && substr($src, 0, 4) != "http") {
                            $src = $scheme . "://" . $host . "/" . $src;
                        }
                        return $src;
                    }

                    function getDetails($url) {
                        global $alreadyFoundImages;
                        $parser = new DomDocumentParser($url);
                        $titleArray = $parser->getTitleTags();

                        if(sizeof($titleArray) == 0 || $titleArray->item(0) == NULL) {
                            return;
                        }

                        $title = $titleArray->item(0)->nodeValue;
                        $title = str_replace("\n", "", $title);

                        if($title == "") {
                            return;
                        }

                        $description = "";
                        $keywords = "";
                        $metasArray = $parser->getMetatags();

                        foreach($metasArray as $meta) {
                            if($meta->getAttribute("name") == "description") {
                                $description = $meta->getAttribute("content");
                            }
                            if($meta->getAttribute("name") == "keywords") {
                                $keywords = $meta->getAttribute("content");
                            }
                        }

                        $description = str_replace("\n", "", $description);
                        $keywords = str_replace("\n", "", $keywords);

                        echo "<div class='crawlResult'>";
                        if(linkExists($url)) {
                            echo "<p class='exists'>$url already exists</p>";
                        }
                        else if(insertLink($url, $title, $description, $keywords)) {
                            echo "<p class='success'>SUCCESS: $url</p>";
                        }
                        else {
                            echo "<p class='error'>ERROR: Failed to insert $url</p>";
                        }
                        echo "</div>";

                        $imageArray = $parser->getImages();
                        foreach($imageArray as $image) {
                            $src = $image->getAttribute("src");
                            $alt = $image->getAttribute("alt");
                            $title = $image->getAttribute("title");

                            if(!$title && !$alt) {
                                continue;
                            }

                            $src = createLink($src, $url);

                            if(!in_array($src, $alreadyFoundImages)) {
                                $alreadyFoundImages[] = $src;
                                insertImage($url, $src, $alt, $title);
                            }
                        }
                    }

                    function followLinks($url) {
                        global $alreadyCrawled;
                        global $crawling;

                        $parser = new DomDocumentParser($url);
                        $linkList = $parser->getLinks();

                        foreach($linkList as $link) {
                            $href = $link->getAttribute("href");

                            if(strpos($href, "#") !== false) {
                                continue;
                            }
                            else if(substr($href, 0, 11) == "javascript:") {
                                continue;
                            }

                            $href = createLink($href, $url);

                            if(!in_array($href, $alreadyCrawled)) {
                                $alreadyCrawled[] = $href;
                                $crawling[] = $href;
                                getDetails($href);
                            }
                        }

                        array_shift($crawling);

                        foreach($crawling as $site) {
                            followLinks($site);
                        }
                    }

                    // Start the crawling process
                    followLinks($startUrl);
                    ?>
                </div>
                <div class="crawlActions">
                    <a href="crawl-form.php" class="backButton">Crawl Another URL</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

