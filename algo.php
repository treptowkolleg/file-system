<?php

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Themes\UniversalTheme;

require_once "vendor/autoload.php";


$numbers = [];

for ($k = 0; $k < 10; $k++) {
    $numbers[] = $d = 5 - 5/6 + 10 * $k;
    //echo "bei $d Tagen" . PHP_EOL;
}

$data = [
    ['name' => 'A', 'x' => 5, 'y' => 9, 'z' => 6],
    ['name' => 'B', 'x' => 4, 'y' => 6, 'z' => 6],
    ['name' => 'C', 'x' => 4, 'y' => 5, 'z' => 6],
    ['name' => 'D', 'x' => 2, 'y' => 1, 'z' => 6],
    ['name' => 'E', 'x' => 1, 'y' => 8, 'z' => 6],
    ['name' => 'F', 'x' => 9, 'y' => 3, 'z' => 6],
    ['name' => 'G', 'x' => 4, 'y' => 4, 'z' => 6],
    ['name' => 'H', 'x' => 1, 'y' => 5, 'z' => 6],
];

$newArr1 = array_slice($numbers, 1);
$newArr2 = array_slice($numbers, 0,-1);
$df = array_intersect($newArr1, $newArr2);

$names = array_column($data, 'name');
$xValues = array_column($data, 'x');
$yValues = array_column($data, 'y');
$zValues = array_column($data, 'z');


// Create the Pie Graph.
$graph = new Graph(1200, 600, "auto");
$graph->SetScale("textlin");

$theme_class = new \Amenadiel\JpGraph\Themes\SoftyTheme();
$graph->SetTheme($theme_class);
$graph->SetMargin(40,20,46,80);
$graph->SetBox(false);

$graph->xaxis->setTickLabels($names);
$graph->ygrid->SetFill(false);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);


$b2plot = new BarPlot($yValues);
$b2plot->SetLegend("y-Werte");
$b3plot = new BarPlot($xValues);
$b4plot = new BarPlot($zValues);
$b3plot->SetLegend("x-Werte");;
$b4plot->SetLegend("z-Werte");;
// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b3plot,$b2plot, $b4plot));
// ...and add it to the graPH
$graph->Add($gbplot);

$graph->legend->SetFrameWeight(1);
$graph->legend->SetColumns(6);
$graph->legend->SetColor('#4E4E4E','#00A78A');
$graph->title->Set("Bar Plots");

// Display the graph
$graph->Stroke();

