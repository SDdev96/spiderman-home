<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <?php include_once "./meta.php" ?>

  <meta name="description" content="Pagina di amministrazione del sito di Spiderman Home">
  <meta name="keywords" content="HTML, CSS, JavaScript, PHP, PostgreSQL, Spiderman,">

  <title>Administrator page</title>

  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;

      cursor: default;
    }

    body {
      background-color: rgb(25, 25, 25);
      color: rgb(165, 165, 165);
    }

    header,
    section {
      display: flex;
      margin-inline: 20px;
    }

    header {
      flex-direction: row;
      justify-content: space-between;
    }

    section {
      margin-top: 50px;
      flex-direction: column;
    }

    h1 {
      font-size: 48px;
    }

    h2 {
      font-size: 36px;
    }

    a {
      cursor: pointer;
      font-size: 48px;
      color: hsl(271, 86%, 56%);
    }

    a:active {
      color: rgb(165, 165, 165);
    }

    table {
      border-collapse: collapse;
    }

    table tr * {
      padding-inline: 5px;
      padding-block: 3px;

      text-align: left;
      font-size: 18px;

      border-bottom: 3px solid rgb(25, 25, 25);
    }

    table tr th {
      font-size: 24px;
      background-color: rgb(165, 165, 165);
      color: rgb(25, 25, 25);
    }

    table tr:nth-child(even) {
      background-color: rgba(96, 25, 23, 1);
    }

    table tr:nth-child(odd) {
      background-color: rgba(14, 44, 72, 1);
    }

    [type="submit"] {
      margin-top: 10px;
      margin-left: 20px;
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 18px;

      cursor: pointer;
    }

    [type="submit"]:hover {
      box-shadow: 0px 0px 60px -10px rgba(0, 0, 0, 0.75) inset;
      -webkit-box-shadow: 0px 0px 60px -10px rgba(0, 0, 0, 0.75) inset;
      -moz-box-shadow: 0px 0px 60px -10px rgba(0, 0, 0, 0.75) inset;
    }

    [type="submit"]:active {
      box-shadow: 0px 0px 60px 15px rgba(0, 0, 0, 0.75) inset;
      -webkit-box-shadow: 0px 0px 60px 15px rgba(0, 0, 0, 0.75) inset;
      -moz-box-shadow: 0px 0px 60px 15px rgba(0, 0, 0, 0.75) inset;
    }
  </style>

</head>

<body>
  <header>
    <h1>Pagina riservata agli amministratori</h1>
    <a href="logout.php">Logout</a>
  </header>

  <div align=right>
    <a href="firstPage.php"> Homepage </a>
  </div>

  <section>
    <h2>Tabella utenti registrati al sito
      <?php
      session_start();
      require_once "./logindb.php";

      $sql = "SELECT * FROM utenti";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      if (pg_num_rows($ret) == 1) {
        echo '(' . pg_num_rows($ret) . ' utente)';
      } else {
        echo '(' . pg_num_rows($ret) . ' utenti)';
      }

      ?>

    </h2>

    <table>
      <tr>
        <th>E-mail</th>
      </tr>
      <?php
      $sql = "SELECT * FROM admin WHERE email = '" . $_SESSION['email'] . "';";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      $email = pg_fetch_result($ret, 0, 'email');

      if ($email == false) {   //Utente non trovato
        echo '<script> alert("NON SEI AUTORIZZATO!");
            window.location.replace("../html/login.html");
            </script>';
      }

      //CONNESSIONE AL DB
      $sql = "SELECT email FROM utenti";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      $dim = pg_num_rows($ret);

      for ($i = 0; $i < $dim; $i++) {
        $row = pg_fetch_result($ret, $i, 'email');
        echo '<tr><td>';
        echo $row . '</td></tr>';
      }

      ?>

    </table>
  </section>

  <section>
    <h2>Tabella partecipanti al sorteggio
      <?php
      //CONNESSIONE AL DB
      $sql = "SELECT * FROM sorteggio";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      if (pg_num_rows($ret) == 1) {
        echo '(' . pg_num_rows($ret) . ' utente)';
      } else {
        echo '(' . pg_num_rows($ret) . ' utenti)';
      }

      ?>

    </h2>
    <table>
      <tr>
        <th>E-mail</th>
      </tr>
      <?php
      $dim = pg_num_rows($ret);

      for ($i = 0; $i < $dim; $i++) {

        $row = pg_fetch_result($ret, $i, 'email');

        echo '<tr><td>';
        echo $row . '</td></tr>';

      }
      ?>
    </table>
  </section>

  <section>

    <?php

    $sql = "SELECT * FROM vincitore";
    $ret = pg_query($db, $sql);
    if (!$ret) {
      echo "ERRORE QUERY: " . pg_last_error($db);
      exit;
    }

    if (pg_numrows($ret) == 0) {
      echo '<form action="sorteggio2.php" method="post" align=center> <input type="submit" value="Avvia sorteggio" /> </form>';
    } else {
      $email = pg_fetch_result($ret, 0, 'email');
      echo "Il vincitore del sorteggio è " . $email;
    }

    ?>
  </section>

  <section>

    <h2>Tabella messaggi per gli sviluppatori
      <?php
      //CONNESSIONE AL DB
      $sql = "SELECT * FROM messaggi";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      if (pg_num_rows($ret) == 1) {
        echo '(' . pg_num_rows($ret) . ' messaggio)';
      } else {
        echo '(' . pg_num_rows($ret) . ' messaggi)';
      }
      ?>
    </h2>

    <table>
      <tr>
        <th>Name</th>
        <th>E-mail</th>
        <th>Subject</th>
        <th>Message</th>
      </tr>

      <?php
      $dim = pg_num_rows($ret);

      for ($i = 0; $i < $dim; $i++) {

        $row = pg_fetch_result($ret, $i, 'name');

        echo '<tr><td>';
        echo $row . '</td>';

        $row = pg_fetch_result($ret, $i, 'email');

        echo '<td><a href="mailto:' . $row . '">';
        echo $row . '</td>';

        $row = pg_fetch_result($ret, $i, 'subject');

        echo '<td>';
        echo $row . '</td>';

        $row = pg_fetch_result($ret, $i, 'message');

        echo '<td>';
        echo $row . '</td></tr>';

      }

      ?>
    </table>
  </section>
</body>

</html>