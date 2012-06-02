About
=============
Simple PHP library that encapsulates a query against the Google Search API.

tom@0x101.com

Usage
------------
You need a valid Google Search API key.

It can be combined with the library jpgraph, to generate graphs with the results: http://jpgraph.net/download/

	$searchTerm = "Stockholm";
	
	$myG = new GoogleSearchQuery($apiKey);
	$data = array();
	
	for($i=1;$i<=$maxValue;$i++) {
		$req = str_replace("X", $i, $searchTerm);
		//echo PHP_EOL."searching $req...";
		$myG->search($req);
		//echo $myG->getTotalResultsCount();
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
