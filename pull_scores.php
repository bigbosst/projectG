<?PHP
$url='http://www.metacritic.com/game/playstation-3';

//get html code for the website
$site = get_html($url);

//Create a DOM parser object and parse the site
$dom = new DOMDocument();
@$dom->loadHTML($site);
$dom->preserveWhiteSpace = false;
// Loop thre all the tr tags
//foreach($dom->getElementsByTagName('a') as $e)
//{
//	if( !strcmp($e->getAttribute('class'),'metascore_anchor') )
//	{
//		var_dump($e->nodeValue);
//	}
//}

	//echo $t->getAttribute('class'), PHP_EOL;

foreach($dom->getElementsByTagName('table') as $t)
{
	if( !strcmp($t->getAttribute('class'),'score_title_table') )
	{
		$rows= $t->getElementsByTagName('tr');
		foreach($rows as $row)
		{
			//echo $row->nodeValue,PHP_EOL;	
			$cols = $row->getElementsByTagName('td');
			echo trim($cols->item(0)->nodeValue," \t\n\r\0\x0B" );
			echo "\t";
			echo trim($cols->item(1)->nodeValue," \t\n\r\0\x0B" ),PHP_EOL;
			
		}
	}
}




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
