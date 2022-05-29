<?php
//$content = htmlentities(file_get_contents("test.xml"));
include('ScanResults.php');
header("Content-Type: text/plain");
$content = new ScanResults("junk_example1");
echo($content->get_results());
