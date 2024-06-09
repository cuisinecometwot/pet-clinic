<?php

include '../utils/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
  if (isset($_POST['petSelect'], $_POST['dateSelect'], $_POST['timeSelect'])) 
  {
    $petId = (int) $_POST['petSelect']; // Cast to integer for security
    $date = $_POST['dateSelect'];

    // Validate date to ensure it's not the day before
    $today = new DateTime();
    $selectedDate = new DateTime($date);
    $interval = $today->diff($selectedDate);

    if ($interval->days > 0) 
    { // Check if selected date is after today
      $time = $_POST['timeSelect'];

      // Save appointment to database logic (replace with your actual logic)
      $sql = "INSERT INTO appointments (pet_id, appointment_date, appointment_time) VALUES ($1, $2, $3)";
      $result = pg_prepare($conn, "insert_appointment", $sql);
      $result = pg_execute($conn, "insert_appointment", [$petId, $date, $time]);

      if ($result) 
      {
        echo "<script>alert('Appointment saved successfully!');</script>"; // Success message (replace with proper UI feedback)
      } 
      else 
      {
        echo "<script>alert('Error saving appointment!');</script>"; // Error message (replace with proper UI feedback)
      }
    } 
    else 
    {
      echo "<script>alert('Please select a date after today.');</script>"; // Message for invalid date
    }
  }
}
