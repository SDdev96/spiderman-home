<!DOCTYPE html>
<html>

<head>
  <?php include_once "./meta.php" ?>
  
  <title>Messaggio</title>
</head>

<body>
  <?php
  require_once "./logindb.php";

  if ((!isset($_POST['fullname'])) || (!isset($_POST['email'])) || ((!isset($_POST['subject'])))) {
    echo '<script> alert("ERRORE!"); window.location.replace("secondPage.php"); </script>';
  } else {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messaggi (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    $ret = pg_query($db, $sql);
    if (!$ret) {
      echo "ERRORE QUERY: " . pg_last_error($db);
      exit;
    }
  }
  ?>
  <script>
    alert("MESSAGGIO INVIATO CON SUCCESSO!");
    window.location.replace("firstPage.php");
  </script>
</body>

</html>