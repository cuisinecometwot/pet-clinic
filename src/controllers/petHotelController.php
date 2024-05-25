<?php
include '../utils/connect.php';
$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'";
$result = pg_query($conn, $sql);

if (!$result) {
  echo "Error retrieving tables: " . pg_last_error($conn);
  exit;
}

echo "Tables in the database:\n";
while ($row = pg_fetch_assoc($result)) {
  $tableName = $row['table_name'];
  echo "[]$tableName<br>";
}

$sql = "SELECT * from owner";
$result = pg_query($sql);
echo pg_num_rows($result);

echo "\n";
?>