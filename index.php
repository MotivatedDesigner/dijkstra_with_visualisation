<?php

// graph representation the (-) is only to solve splPriorityQueue to get the lower priority element first
$graph = array(
  'A' => array('B' => -3, 'D' => -3, 'F' => -6),
  'B' => array('A' => -3, 'D' => -1, 'E' => -3),
  'C' => array('E' => -2, 'F' => -3),
  'D' => array('A' => -3, 'B' => -1, 'E' => -1, 'F' => -2),
  'E' => array('B' => -3, 'C' => -2, 'D' => -1, 'F' => -5),
  'F' => array('A' => -6, 'C' => -3, 'D' => -2, 'E' => -5),
);

// array of visited nodes
$visited = array();
// array of best distance from the start node to other nodes
$dist = array();
// array of previeus vertex for each node
$prev = array();
// queue of all unoptimized nodes
$Q = new SplPriorityQueue();

foreach ($graph as $node => $adjs) {
  $visited[$node] = false; // mark all nodes as not visited
  $dist[$node] = INF; // set initial distance to "infinity"
  $prev[$node] = null; // no known previeus node yet
}

?>