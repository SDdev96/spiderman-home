<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <?php include_once "./meta.php" ?>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <link rel="stylesheet" href="../css/default.css" />
  <link rel="stylesheet" href="../css/logReg.css" />
  <link rel="stylesheet" href="../css/shakeAnimation.css">

  <title>Register</title>

  <script src="../js/logReg.js" defer></script>

  <style></style>
</head>

<body>
  <div class="container"></div>
  <header>
    <div class="logo">
      <img src="../media/img/logo/unisa_icons/favicon-32x32.png" alt="img1" />
      <span class="material-symbols-outlined">close </span>
      <img src="../media/img/logo/spiderman_icons/favicon-32x32.png" alt="img2" />
    </div>
  </header>

  <?php

  if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
    $email = strtolower($_POST['email']);
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
  } else {
    $email = "";
    $pass = "";
    $pass2 = "";
  }

  ?>

  <section class="form">
    <h2>Registrati</h2>
    <form onsubmit="return validaModulo(this);" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
      autocomplete="off">
      <div>
        <input type="email" id="email" name="email" title="Inserisci l'email" value="<?php echo $email ?>"
          placeholder="" />
        <span class="material-symbols-outlined">email</span>
      </div>

      <div>
        <input type="password" id="password" name="pass" title="Inserisci la password" value="<?php echo $pass ?>"
          placeholder="" />
        <span class="material-symbols-outlined">lock</span>
        <button type="button" class="button-visibility">
          <span class="material-symbols-outlined">visibility_off</span>
        </button>
      </div>

      <div>
        <input type="password" id="passwordConfirm" name="pass2" title="Conferma la password"
          value="<?php echo $pass2 ?>" placeholder="" />
        <span class="material-symbols-outlined">lock</span>
        <button type="button" class="button-visibility">
          <span class="material-symbols-outlined">visibility_off</span>
        </button>
      </div>

      <input type="submit" value="Registrati" />
      <script>

      </script>
    </form>
    <p>
      Sei già registrato? <em><a href="../html/login.html">Accedi</a></em>
    </p>
  </section>

  <?php
  if ($email != '') {
    require_once "./logindb.php";

    $sql = "SELECT * FROM utenti WHERE email = '" . $email . "';";
    $ret = pg_query($db, $sql);
    if (!$ret) {
      echo "ERRORE QUERY: " . pg_last_error($db);
      exit;
    }

    if (pg_numrows($ret) != 0) {
      $check = pg_fetch_result($ret, 0, 'email');

      echo '<script>alert("INDIRIZZO EMAIL GIÀ ESISTENTE!");</script>';
    } else {
      $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

      $sql = "INSERT INTO utenti (email, pass) VALUES ('$email', '$pass')";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      session_start();
      $_SESSION['email'] = $email;

      echo '<script>
            alert("UTENTE REGISTRATO CON SUCCESSO!");
            window.location.replace("./firstPage.php");
          </script>';
    }
  }
  ?>

  <script language="javascript" type="text/javascript">
    function validaModulo(elementoModulo) {
      if (elementoModulo.email.value == "") {
        alert("Devi inserire un'email");
        elementoModulo.email.style.borderBottom = "solid 3px red";
        elementoModulo.email.classList.add("shake-animation");
        elementoModulo.email.focus();
        return false;
      }
      else {
        elementoModulo.email.style.borderBottom = "solid 3px transparent";

        elementoModulo.email.addEventListener("focus", function () {
          elementoModulo.email.style.borderBottom = "solid 3px white";
        });
        elementoModulo.email.addEventListener("blur", function () {
          elementoModulo.email.style.borderBottom = "solid 3px transparent";
        });

        elementoModulo.email.classList.remove("shake-animation");
      }

      if (elementoModulo.pass.value == "") {
        alert("Devi inserire una password e confermarla!");

        elementoModulo.pass.style.borderBottom = "solid 3px red";
        elementoModulo.pass.classList.add("shake-animation");

        elementoModulo.pass2.style.borderBottom = "solid 3px red";
        elementoModulo.pass2.classList.add("shake-animation");


        elementoModulo.pass.focus();
        return false;
      }
      else {
        elementoModulo.pass.style.borderBottom = "solid 3px transparent";

        elementoModulo.pass.addEventListener("focus", function () {
          elementoModulo.pass.style.borderBottom = "solid 3px white";
        });
        elementoModulo.pass.addEventListener("blur", function () {
          elementoModulo.pass.style.borderBottom = "solid 3px transparent";
        });

        elementoModulo.pass.classList.remove("shake-animation");
      }

      if (elementoModulo.pass.value != elementoModulo.pass2.value) {
        console.log("Le password devono coincidere!");
        alert("Le password devono coincidere!");

        elementoModulo.pass.style.borderBottom = "solid 3px red";
        elementoModulo.pass.classList.add("shake-animation");

        elementoModulo.pass2.style.borderBottom = "solid 3px red";
        elementoModulo.pass2.classList.add("shake-animation");

        elementoModulo.pass2.focus();
        return false;
      }
      else {
        elementoModulo.pass.style.borderBottom = "solid 3px transparent";

        elementoModulo.pass.addEventListener("focus", function () {
          elementoModulo.pass.style.borderBottom = "solid 3px white";
        });
        elementoModulo.pass.addEventListener("blur", function () {
          elementoModulo.pass.style.borderBottom = "solid 3px transparent";
        });

        elementoModulo.pass.classList.remove("shake-animation");
      }

      return true;

    }
  </script>

</body>

</html>