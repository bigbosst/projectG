<?PHP
/*
	pull_scores.php

	A Simple HTML Parcer with JSON output for metacritc scores
	Part of ProjectG
	Written by Troy Germain (troy.germain@gmail.com)

*/
//variable to set website to retrieve game/score data from
$url='http://www.metacritic.com/game/playstation-3';

$list = array();

//get html code for the website
$site = get_html($url);

//Create a DOM parser object and parse the site
$dom = new DOMDocument();
@$dom->loadHTML($site);
$dom->preserveWhiteSpace = false;
$xpath = new DOMXpath($dom);
$games = $xpath->query('//div[@class="main_stats"]');


foreach($games as $game)
{
	$links = $game->getElementsByTagName("a");
	$array = iterator_to_array($links);
	$title = trim($array[0]->nodeValue," \t\n\r\0\x08" );
	$score = trim($array[1]->nodeValue," \t\n\r\0\x08" );
	$list[] = array('title' => $title, 'score' => $score);
}

//outputs the array of JSON as described
echo json_encode($list);

// gets the html from given URL
function get_html($url)
{
	$timeout = 5;
	$useragent='Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$html = curl_exec($ch);
	curl_close($ch);
	return $html;
}
?>
