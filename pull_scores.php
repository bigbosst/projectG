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

//loop through all the tables
foreach($dom->getElementsByTagName('table') as $t)
{
	//find the score_title_table
	if( !strcmp($t->getAttribute('class'),'score_title_table') )
	{
		//analize each row of the table
		$rows= $t->getElementsByTagName('tr');
		foreach($rows as $row)
		{
			$cols = $row->getElementsByTagName('td');
			$score = trim($cols->item(0)->nodeValue," \t\n\r\0\x0B" );
			$title = trim($cols->item(1)->nodeValue," \t\n\r\0\x0B" );
			$list[] = array('title' => $title, 'score' => $score);
			//echo $title."\t".$score.PHP_EOL;
			
		}
	}
}

echo json_encode($list);


//$site = get_html($url);
//print $site;

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
