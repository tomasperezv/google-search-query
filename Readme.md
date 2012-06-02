About
=============
Simple PHP library that encapsulates a query against the Google Search API.

The original purpose of this library was to do queries similar to the queries represented
in the following xkcd: http://xkcd.com/715/

tom@0x101.com

Usage
------------
You need a valid Google Search API key.

In order to generate graphs like http://xkcd.com/715/ the following example can be used. 
It needs the library jpgraph: http://jpgraph.net/download/

	$maxValue = 500;
	$searchTerm = "I got X problems";
	
	$myG = new GoogleSearchQuery($apiKey);
	$data = array();
	
	for($i=1;$i<=$maxValue;$i++) {
		$req = str_replace("X", $i, $searchTerm);
		echo PHP_EOL."searching $req...";
		$myG->search($req);
		echo $myG->getTotalResultsCount();
		$data[] = $myG->getTotalResultsCount();
	}
	
	// Create a graph with the results of the search:
	$graph = new Graph(800, 600, "auto");
	$graph->SetScale("textlin");
	$graph->title->Set("google search $searchTerm");

	$graph->xaxis->title->Set("X axis");
	$graph->yaxis->title->Set("Y axis");

	$lineplot = new LinePlot($data);
	$lineplot->SetColor("green");
	$lineplot->SetWeight(2);

	$graph->Add($lineplot);
	$graph->Stroke($argv[3]);
