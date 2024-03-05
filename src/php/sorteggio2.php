<!DOCTYPE html>
<html>

<head>
  <?php include_once "./meta.php" ?>

  <title>ESTRAZIONE</title>
</head>

<body>
  <!-- SORTEGGIO ESTRAZIONE VINCITORE -->
  <?php
  session_start();

  require_once "./logindb.php";

  if (isset($_SESSION['email'])) {
    $sql = "SELECT email FROM admin WHERE email = '" . $_SESSION['email'] . "';";
    $ret = pg_query($db, $sql);
    if (!$ret) {
      echo "ERRORE QUERY: " . pg_last_error($db);
      exit;
    }

    if (pg_numrows($ret) == 0) {
      echo '<script> alert("NON SEI AUTORIZZATO!"); window.location.replace("../html/login.html"); </script>';
    } else {
      $sql = "SELECT * FROM sorteggio";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }
      $rand = rand(0, pg_num_rows($ret) - 1);

      $emailvincitore = pg_fetch_result($ret, $rand, 'email');

      $sql = "INSERT INTO vincitore VALUES ('" . $emailvincitore . "');";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }
      echo '<script> alert("SORTEGGIO EFFETTUATO CON SUCCESSO!"); window.location.replace("administrator.php"); </script>';
    }
  } else {
    echo '<script> alert("NON SEI AUTORIZZATO!"); window.location.replace("../html/login.html"); </script>';
  }
  ?>
</body>

</html>