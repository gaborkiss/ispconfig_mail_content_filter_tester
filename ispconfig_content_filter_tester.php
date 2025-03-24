<?php

if($argc <> 2) {
    echo "\nFirst parameter have to the text file\n\n";
    exit(1);
}

$server = "localhost";
$db = "dbispconfig";
$dbuser = "your db username";
$dbpsw = "your db password";

$fname = $argv[1];


echo "\nOpen file: " . $fname . "\n";
$file = fopen($fname, "r") or die("Unable to open file!");
$data = fread($file,filesize($fname));
echo "File size: " . filesize($fname) . "\n\n";
fclose($file);


$conn = mysqli_connect($server, $dbuser, $dbpsw, $db);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT pattern FROM mail_content_filter";
$result = mysqli_query($conn, $sql);
$cnt = 1;

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
	echo sprintf('%05d', $cnt) . " | " . preg_match($row["pattern"], $data) . " | " . $row["pattern"] . "\n";
	$cnt++;
    }
} else {
    echo "No entries in content filter table?\n";
}

mysqli_close($conn);

?>
