<?php
error_reporting(0);
//include auth_session.php file on all user panel pages
include("auth_session.php");
$apiKey = 'AIzaSyDqY8AMZIgyqw2foMAbZoOJXtMks8vk7ls';
#$channelId = '';
#$channelId_coding = 'UC8butISFwT-Wl7EV0hUK0BQ';
#$chanelId_sports = 'UC9pFBPZTY0hE9LAMIg9b4Xw';
$resultsNumber = 10;
#$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&part=snippet,id&maxResults=0&order=date';
if($_POST['select'] == 1) {
	$channelId = 'UC8butISFwT-Wl7EV0hUK0BQ';
	$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
}
elseif($_POST['select'] == 2) {
	$channelId = 'UCqZQlzSHbVJrwrn5XvzrzcA';
	$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
}

elseif($_POST['select'] == 3) {
	$channelId = 'UC52X5wxOL_s5yw0dQk7NtgA';
	$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
}

elseif($_POST['select'] == 4) {
	$channelId = 'UCKy1dAqELo0zrOtPkf0eTMw';
	$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
}

elseif($_POST['select'] == 5) {
	$channelId = 'UC4a-Gbdw7vOaccHmFo40b9g';
	$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
}
elseif($_POST['select'] == 6) {
	$channelId = 'UC5nc_ZtjKW1htCVZVRxlQAQ';
	$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
	<form action="dashboard.php" method="post">
		<div class="form">
			<p>Hey, <?php echo $_SESSION['username']; ?>!</p>
			<p>You are in user dashboard page.</p>
			Select a category/channel :  
			<select class = "form-control" id="select" name="select">  
			  <option value="0">Select</option>  
			  <option value="1">Coding/freeCodeCamp.org</option>  
			  <option value="2">Sports/NBC Sports</option>  
			  <option value="3">News/Associated Press</option>  
			  <option value="4">Gaming/IGN</option>  
			  <option value="5">Learning/Khan Academy</option>  
			  <option value="6">Music/MrSuicideSheep</option>  
			</select>   
			<div class="col-sm-2">
			<input type="submit" value="Click To Search" class="btn btn-primary" id="sub" name="submit">
			</div>
			<?php
				// Try file_get_contents first
				if( function_exists( file_get_contents ) ) {
					$response = file_get_contents( $requestUrl );
					$json_response = json_decode( $response, TRUE );
					 
				} else {
					// No file_get_contents? Use curl then
					if( function_exists( 'curl_version' ) ) {
						$curl = curl_init();
						curl_setopt( $curl, CURLOPT_URL, $requestUrl );
						curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
						curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, TRUE );
						$response = curl_exec( $curl );
						curl_close( $curl );
						$json_response = json_decode( $response, TRUE );
						 
					} else {
						// Unable to get response if both file_get_contents and curl fail
						$json_response = NULL;
					}
				}
				 
				// If there's a JSON response
				if( $json_response ) {
					$i = 1;
					echo '<div class="youtube-channel-videos">';
					foreach( $json_response['items'] as $item ) {
						$videoTitle = $item['snippet']['title'];
						$videoID = $item['id']['videoId'];
						//$videoThumbnail = $item['snippet']['thumbnails']['high']['url'];
				 
						if( $videoTitle && $videoID ) {
							echo '<div class="youtube-channel-video-embed vid-' . $videoID . ' video-' . $i++ . '"><iframe width="500" height="300" src="https://www.youtube.com/embed/' . $videoID . '" frameborder="0" allowfullscreen>' . $videoTitle . '</iframe></div>';
						}
					}
					echo '</div><!-- .youtube-channel-videos -->';
				 
				// If there's no response   
				} else {
					// Display error message
					echo '<div class="youtube-channel-videos error"><p>No videos are available at this time from the channel specified!</p></div>';
					}

			?>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>