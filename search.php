<?php
include("config.php");
include("classes/SiteResultsProvider.php");
include("classes/ImageResultsProvider.php");

if(isset($_GET["term"])) {
	$term = $_GET["term"];
}
else {
	exit("You must enter a search term");
}

$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;


	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Spider Search</title>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
	integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
	crossorigin="anonymous"></script>

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

				<div class="searchContainer">

					<form action="search.php" method="GET">

						<div class="searchBarContainer">
						<input type="hidden" name="type" value="<?php echo $type; ?>">
							<input class="searchBox" type="text" name="term" value="<?php echo $term; ?>">
							<button class="searchButton">
								<img src="assets/images/icons/search.png">
							</button>
						</div>

					</form>

				</div>

			</div>


			<div class="tabsContainer">

				<ul class="tabList">

					<li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
						<a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
							Sites
						</a>
					</li>

					<li class="<?php echo $type == 'images' ? 'active' : '' ?>">
						<a href='<?php echo "search.php?term=$term&type=images"; ?>'>
							Images
						</a>
					</li>

				</ul>


			</div>
		</div>










		<div class="mainResultsSection">

			<?php
			if($type == "sites") {
				$resultsProvider = new SiteResultsProvider($con);
				$pageSize = 20;
			}
			else {
				$resultsProvider = new ImageResultsProvider($con);
				$pageSize = 30;
			}

			$numResults = $resultsProvider->getNumResults($term);

			echo "<p class='resultsCount'>$numResults results found</p>";



			echo $resultsProvider->getResultsHtml($page, $pageSize, $term);
			?>


		</div>



		<div class="paginationContainer">

			<div class="pageButtons">



				

				<?php

				$pagesToShow = 10;
				$numPages = ceil($numResults / $pageSize);
				$pagesLeft = min($pagesToShow, $numPages);

				$currentPage = $page - floor($pagesToShow / 2);

				if($currentPage < 1) {
					$currentPage = 1;
				}

				if($currentPage + $pagesLeft > $numPages + 1) {
					$currentPage = $numPages + 1 - $pagesLeft;
				}

				while($pagesLeft != 0 && $currentPage <= $numPages) {

					if($currentPage == $page) {
						echo "<div class='pageNumberContainer'>
								<img src='assets\images\pageSelected.png'>
								<span class='pageNumber'>$currentPage</span>
							</div>";
					}
					else {
						echo "<div class='pageNumberContainer'>
								<a href='search.php?term=$term&type=$type&page=$currentPage'>
									<img src='assets\images\page.png'>
									<span class='pageNumber'>$currentPage</span>
								</a>
						</div>";
					}


					$currentPage++;
					$pagesLeft--;

				}





				?>

				



			</div>




		</div>







	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>

</body>
</html>