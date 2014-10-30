projectG
========

This is a quick personal project

Part One will pull the Top PlayStation 3 Games from MediaCritic and output them as an array of JSON elements.
[
  {
    "title": "XCOM: Enemy Within",
    “score”: 88
  },
  {
    "title": "Assasin’s Creed IV: Black Flag",
    “score”: 88
  }
... etc ...
]

Part Two will expose a simple Rest API with 2 methods:
● A HTTP “GET” request a “/games” returns all top PS3 games on metacritic page
● A HTTP “GET” request at “/games/TITLE_OF_GAME_GOES_HERE” returns JSON for a specific game that matches the corresponding game title. For example, an HTTP GET at projectG/games/Gran%20Turismo%206 should return an individual JSON object for Gran Turismo 6 like so:
{
"title": "Gran Turismo 6",
“score”: 81
}
