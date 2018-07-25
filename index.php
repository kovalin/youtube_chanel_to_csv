<?php
$API_key    = '{YOU_YOUTUBE_API}';
$channelID  = 'UC29ju8bIPH5as8OGnQzwJyA';
$maxResults = 50;
$maxVideo = 1000;
$step = 0;
$nextPageToken = '';
$output = '';


do {
  $nextPage = ($step > 0) ? '&pageToken='.$nextPageToken : '';
  $videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date'.$nextPage.'&part=snippet&channelId=' . $channelID . '&maxResults=' . $maxResults . '&key=' . $API_key . ''));

  foreach ($videoList->items as $item) {
      $output .= $item->snippet->publishedAt . ";https://www.youtube.com/watch?v=" . $item->id->videoId . ";" . $item->snippet->title . ";\r\n";
  }

  $step += $maxResults;
  $nextPageToken = $videoList->nextPageToken;
} while($step<$maxVideo);

file_put_contents('base.csv', $output);
