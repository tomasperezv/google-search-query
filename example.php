<?php

    /*
     * Example for generating graphs like: http://xkcd.com/715/
     * It requires the library jpgraph.
     *
     * @author tom@0x101.com
     */
    include_once("googleTrends.php");
    include("jpgraph/jpgraph.php");
    include("jpgraph/jpgraph_bar.php");
    include("jpgraph/jpgraph_line.php");

    if(count($argv) < 4 ) {
            echo "Usage php example.php \"variable X\" MAX_X filename.png".PHP_EOL;
            die();
    }

    $urlBase = "http://www.google.com/#hl=en&source=hp&q=";
    $extraParams = "&aq=f&aqi=&aql=&oq=&gs_rfai=";
    $searchTerm = $argv[1];
    $maxValue = $argv[2];
    echo "searching \"$searchTerm\", max value=$maxValue".PHP_EOL;

	// Replace by a valid API Key
    $myG = new GoogleSearchQuery("");

    $data = array();

    for($i=1;$i<=$maxValue;$i++) {
            $req = str_replace("X", $i, $searchTerm);
            //echo PHP_EOL."searching $req...";
            $myG->search($req);
            //echo $myG->getTotalResultsCount();
            $data[] = $myG->getTotalResultsCount();
    }

    // Rendering
    $grafico = new Graph(800, 600, "auto");
    $grafico->SetScale("textlin");
    $grafico->title->Set("google search $searchTerm");
    $grafico->xaxis->title->Set("Eje X");
    $grafico->yaxis->title->Set("Eje Y");
    $lineplot = new LinePlot($data);
    $lineplot->SetColor("green");
    $lineplot->SetWeight(2);
    $grafico->Add($lineplot);
    $grafico->Stroke($argv[3]);

    echo PHP_EOL;
