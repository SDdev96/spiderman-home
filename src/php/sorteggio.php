<!DOCTYPE html>
<html>

<head>
  <?php include_once "./meta.php" ?>
  
  <title>Iscrizione al sorteggio</title>
</head>

<body>
  <!-- ISCRIZIONE AL SORTEGGIO -->
  <?php
  require_once "./logindb.php";

  session_start();

  $sql = "SELECT * FROM sorteggio";
  $ret = pg_query($db, $sql);
  if (!$ret) {
    echo "ERRORE QUERY: " . pg_last_error($db);
    exit;
  }

  if (!isset($_SESSION['email'])) {
    echo '<script> alert("ERRORE!"); window.location.replace("secondPage.php"); </script>';
  } else {
    $email = $_SESSION['email'];

    $sql = "INSERT INTO sorteggio (email) VALUES ('$email')";
    $ret = pg_query($db, $sql);
    if (!$ret) {
      echo "ERRORE QUERY: " . pg_last_error($db);
      exit;
    }
    $_SESSION['sond'] = true;
    echo '<script> alert("UTENTE ISCRITTO AL SORTEGGIO CON SUCCESSO!"); window.location.replace("secondPage.php"); </script>';
  }
  ?>

</body>

</html>