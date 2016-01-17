<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("Maze.php");
$n = new Maze;
if(isset($_GET['num'])) {
  switch($_GET['num']) {
    case 2:
      include('maze1.php');
    break;
    case 3:
      include('maze3.php');
    break;
    case 4:
      include('maze4.php');
    break;
  }
} else {
  include('maze2.php');
}

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Maze</title>
  <meta name="description" content="Solve the maze with PHP">
  <meta name="author" content="Levi Durfee">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0D47A1">

  <link rel="stylesheet" href="/maze/styles.css?v=1.0">

  <!--[if lt IE 9]>
  <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-71696728-1', 'auto');
    ga('send', 'pageview');

  </script>    
</head>

<body>
<div class="maze">
<?php

for($i=1;$i<=count($n->m);$i++) {
  if($i == 1) {
    echo "\t<div class='row'>\n";
  }
  $o = $n->checkIfOpen($n->m[$i]['open']);

  if(isset($n->m[$i]['class'])) {
    $c = $n->m[$i]['class'];
  } else {
    $c = '';
  }

  echo "\t\t<span id='block$i' class='$o $c block'><i>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</i></span>\n";

  if( ($i % 6 == 0) AND ( $i != count($n->m) ) ) {
    echo "\t</div><div class='row'>\n";
  } elseif ($i == count($n->m)) {
    echo "\t</div>\n";
  }
}
?>
</div><!-- /.maze -->
<?php $n->traverseMaze(); ?>
<div class="maze">
<?php

for($i=1;$i<=count($n->m);$i++) {
  if($i == 1) {
    echo "\t<div class='row'>\n";
  }
  $o = $n->checkIfOpen($n->m[$i]['open']);

  if(isset($n->m[$i]['class'])) {
    $c = $n->m[$i]['class'];
  } else {
    $c = '';
  }

  echo "\t\t<span id='block$i' class='$o $c block'><i>" . str_pad($i, 2, "0", STR_PAD_LEFT) . "</i></span>\n";

  if( ($i % 6 == 0) AND ( $i != count($n->m) ) ) {
    echo "\t</div><div class='row'>\n";
  } elseif ($i == count($n->m)) {
    echo "\t</div>\n";
  }
}
?>
</div><!-- /.maze -->
<pre>
  <?php #var_dump($n->m); ?>
</pre>
</body>
</html>