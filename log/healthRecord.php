<?php
include '../utils/connect.php';
include '../models/Record.php';

// Health Records Query
$healthQuery = "SELECT * FROM health_record";
$healthResult = pg_query($conn, $healthQuery);
if (!$healthResult) {
  echo "Error retrieving health records: " . pg_error($conn);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Health Records</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjD BrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<h2>Health Records</h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#ID</th>
      <th>Pet ID</th>
      <th>Date</th>
      <th>Time</th>
      <th>Veterinarian</th>
      <th>Med Instruction</th>
      <th>Diet</th>
      <th>Additional instructions</th>
      <th>Cost</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = pg_fetch_assoc($healthResult)) : ?>
      <tr>
        <td><?php echo $row['recordid']; ?></td>
        <td><?php echo $row['petid']; ?></td>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['time']; ?></td>
        <td><?php echo $row['veterinarian']; ?></td>
        <td><?php echo $row['med_instruction']; ?></td>
        <td><?php echo $row['diet_instructions']; ?></td>
        <td><?php echo $row['additional_instructions']; ?></td>
        <td><?php echo $row['cost']; ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
