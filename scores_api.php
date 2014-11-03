<?PHP
/*
	scores_api.php

	A Simple API to return JSON formated output for metacritc scores
	If nothing is passed it will return a full list of Scores
	If a string is passed it will return the score for that title
	If no listing is found for that title it will return 404 and no data
	Part of ProjectG
	Written by Troy Germain (troy.germain@gmail.com)

*/

header("Content-Type:application/json");

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		rest_get();  
		break;
	case 'HEAD':
		deliver_response(200,"title found",NULL);
		break;
	default:
		deliver_response(404,"Method Unsupported",NULL);
		break;
}

function rest_get()
{
	if (isset($_GET['title']))
	{
		$find=$_GET['title'];
	}
	else
	{
		$find=NULL;
	}
	$game=get_game($find);
	
	if(empty($game))
	{
		//not found
		deliver_response(404,"title not found",NULL);
	}
	else
	{
		//return price
		deliver_response(200,"title found",$game);
	}
}

/*
	Takes as input the String $find
	Will Return JSON formatted match of find
	Unless: find is empty -> Return full Listing
		no match is found -> Return Null
	
*/
function get_game($find)
{
	//isolate the output of pull_scores.php and assign it to a variable
	ob_start();
	include 'pull_scores.php';
	$jsonlist =  ob_get_contents(); 
	ob_end_clean();

	if(empty($find))
	{
		//return full list
		return $jsonlist;
	}
	else
	{
		//echo $find, PHP_EOL;
		$list=json_decode($jsonlist);
		//search for title
		foreach($list as $game)
		{
			//echo json_encode($game), PHP_EOL;
			if( strcasecmp($game->title,$find) == 0 )
			{
				return json_encode($game);
				break;
			}
		}
		
		return NULL;
	}
}

/*
	Takes as input the Strings $status, $status_message, and $data
	Will send headers and responce back to the user session
*/
function deliver_response($status,$status_message,$data)
{
	header("HTTP/1.1 $status $status_message");
	
	echo $data;
}

?>

