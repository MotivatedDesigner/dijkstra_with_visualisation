<?php
class Dijkstra
{

  protected $graph;
  protected $start;
  protected $target;

  // array of visited nodes
  protected $visited = array();
  // array of best distance from the start node to other nodes
  public $dist = array();
  // array of previeus vertex for each node
  public $prev = array();
  // queue of all unoptimized nodes
  public $priorityQ;
  // setting the queue to return both key & value whene using extract method

  public function __construct(array $graph, $start)
  {
    $this->graph = $graph;
    $this->start = $start;
    $this->priorityQ =  new SplPriorityQueue();
    $this->priorityQ->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
    foreach ($this->graph as $node => $adjs) {
      $this->visited[$node] = false; // mark all nodes as not visited
      $this->dist[$node] = INF; // set initial distance to "infinity"
      $this->prev[$node] = null; // no known previeus node yet
    }

    // choosing node A as starting node (only for test, this will be choosed by the user later)
    $this->dist[$this->start] = 0;
    $this->priorityQ->insert($this->start, 0);

  }

  function nextStep()
  {

    // if (!$this->priorityQ->isEmpty()) {
      // extract the node with min distance from the start node
      $minEntry = $this->priorityQ->extract();
      print_r(($minEntry));
      // mark the node as visited
      $this->visited[$minEntry['data']] = true;
      // check if the distance of the node is less than the one from the queue
      // if ((-$minEntry['priority']) <= $this->dist[$minEntry['data']]){

        // loop through adjacent nodes
        foreach ($this->graph[$minEntry['data']] as $adjs => $weight) {
          // if the node is alredy visited skip this round of iteration
          // if ($this->visited[$adjs]){
          // calculate the new dist (subtracting is used because the weight is negative)
          $newDist = $this->dist[$minEntry['data']] - $weight;
          // check if the new dist is less than the current distance
          if ($newDist < $this->dist[$adjs]) {
            $this->dist[$adjs] = $newDist;
            $this->prev[$adjs] = $minEntry['data'];
            $this->priorityQ->insert($adjs, -$newDist);
            echo 'd';
          }
        // }
      // }
    }
  }
}
// graph representation the (-) is only to solve splPriorityQueue to get the lower priority element first
$graph = array(
  'A' => array('B' => -3, 'D' => -3, 'F' => -6),
  'B' => array('A' => -3, 'D' => -1, 'E' => -3),
  'C' => array('E' => -2, 'F' => -3),
  'D' => array('A' => -3, 'B' => -1, 'E' => -1, 'F' => -2),
  'E' => array('B' => -3, 'C' => -2, 'D' => -1, 'F' => -5),
  'F' => array('A' => -6, 'C' => -3, 'D' => -2, 'E' => -5),
);

// visite all node with while loop
$dijkstra = new Dijkstra($graph,'A','C');





// print_r($dijkstra->prev);
// $pointer = 'C';
// $stack = new SplStack();

// while (true) {
//   $stack->push($pointer);
//   $pointer = $dijkstra->prev[$pointer];
//   if ($pointer == '') break;
// }
// echo '<br>';

// while (!$stack->isEmpty()) {
//   echo ' => ';
//   echo $stack->pop();
// }
$i = 1;


if (isset($_POST['test'])) {
  $dijkstra->nextStep();
  print_r($dijkstra->dist);
  echo '<br>';
  print_r($dijkstra->priorityQ);
  echo '<br>';
  echo $i;
  echo '<br>';
  $i+=1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="index.php" method="POST">
    <button name="test" value="test">test</button>
  </form>
</body>
</html>