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
// setting the queue to return both key & value whene using extract method
$Q->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

foreach ($graph as $node => $adjs) {
  $visited[$node] = false; // mark all nodes as not visited
  $dist[$node] = INF; // set initial distance to "infinity"
  $prev[$node] = null; // no known previeus node yet
}

// choosing node A as starting node (only for test, this will be choosed by the user later)
$dist['A'] = 0;
$Q->insert('A',0);

// visite all node with while loop
while ( !$Q->isEmpty() ) 
{
    // extract the node with min distance from the start node
    $minEntry = $Q->extract();
    // mark the node as visited
    $visited[$minEntry['data']] = true;
    // check if the distance of the node is less than the one from the queue
    if ( ( - $minEntry['priority'] ) > $dist[$minEntry['data']]) continue;
    // loop through adjacent nodes
    foreach ($graph[$minEntry['data']] as $adjs => $weight) 
    {
      // if the node is alredy visited skip this round of iteration
      if ($visited[$adjs]) continue;
      // calculate the new dist (subtracting is used because the weight is negative)
      $newDist = $dist[$minEntry['data']] - $weight;
      // check if the new dist is less than the current distance
      if ($newDist < $dist[$adjs]) 
      {
        $dist[$adjs] = $newDist;
        $prev[$adjs] = $minEntry['data'];
        $Q->insert($adjs,-$newDist);
      }
    }
}

print_r($dist);
echo '<br>';
print_r($prev);
$pointer = 'C';
$stack = new SplStack();

while (true) {
  $stack->push($pointer);
  $pointer = $prev[$pointer];
  if ($pointer == '') break;
}
echo '<br>';

while (!$stack->isEmpty()) {
  echo ' => ';
  echo $stack->pop();
}

?>