<!DOCTYPE html>
<html lang="en">

<head>
  <!-- META -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <?php include_once "./meta.php" ?>

  <title>First Page</title>

  <!-- STYLE -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <link rel="stylesheet" href="../css/default.css" />
  <link rel="stylesheet" href="../css/firstPage.css" />

  <!-- SCRIPT FUNCTIONS JS-->
  <script></script>
</head>

<body>

  <?php
  session_start();
  require_once "./logindb.php";

  if (isset($_POST['email'])) {
    //CONNESSIONE AL DB
    $sql = "SELECT * FROM utenti WHERE email = '" . strtolower($_POST['email']) . "';";
    $ret = pg_query($db, $sql);
    if (!$ret) {
      echo "ERRORE QUERY: " . pg_last_error($db);
      exit;
    }

    if (pg_numrows($ret) == 0) {   //Utente non trovato
      echo '<script> alert("AUTENTICAZIONE NON RIUSCITA!");
          window.location.replace("../html/login.html");
          </script>';
    } else {   //Utente trovato
  
      $email = pg_fetch_result($ret, 0, 'email');

      $password_check = pg_fetch_result($ret, 0, 'pass');   //Modificare password salvate il chiaro nel database
  
      if (password_verify($_POST['pass'], $password_check) == 0) {
        echo '<script> alert("PASSWORD ERRATA!");
            window.location.replace("../html/login.html");
            </script>';
      } else {
        $_SESSION['email'] = $email;

        $sql = "SELECT email FROM admin WHERE email = '" . $_SESSION['email'] . "';";
        $ret = pg_query($db, $sql);
        if (!$ret) {
          echo "ERRORE QUERY: " . pg_last_error($db);
          exit;
        }

        if (pg_numrows($ret) != 0) {
          $email = pg_fetch_result($ret, 0, 'email');
          echo $email;

          if ($email != false) {
            echo '<script>window.location.replace("administrator.php"); </script>';

          }
        }

      }

    }

  }

  ?>

  <!-- CONTAINER -->
  <div class="container">
    <!-- HEADER -->
    <header>
      <div class="logo">
        <img src="../media/img/logo/unisa_icons/favicon-32x32.png" alt="img1" />
        <span class="material-symbols-outlined">close</span>
        <img src="../media/img/logo/spiderman_icons/favicon-32x32.png" alt="img2" />
      </div>
      <div class="logreg">

        <?php
        if (!isset($_SESSION['email'])) {
          echo '<a href="../html/login.html">login</a><span style="color: white">/</span><a href="./register.php">registrati</a>';
        } else {
          echo "<p>Benvenuto " . $_SESSION['email'] . '</p> <br><a href="logout.php"> Logout </a>';

          //CONNESSIONE AL DB
          $sql = "SELECT * FROM admin WHERE email = '" . $_SESSION['email'] . "';";
          $ret = pg_query($db, $sql);
          if (!$ret) {
            echo "ERRORE QUERY: " . pg_last_error($db);
            exit;
          }

          if (pg_numrows($ret) != 0) {
            $admin = pg_fetch_result($ret, 0, 'email');

            echo '<br/><a href="administrator.php">PAGINA ADMIN </a>';
          }
        }
        ?>

      </div>
    </header>

    <!-- HERO -->
    <section class="hero">
      <h1>spiderman home</h1>
      <video src="../media/video/spiderman_videos/THIS IS 4K MARVEL (Spider-Man).mp4" autoplay muted loop
        poster=""></video>
    </section>

    <!-- GALLERY -->
    <!-- Galleria con sole immagini, cercare di implementare una galleria con le card,
         cioè dei div con immagine di sfondo, titolo, descrizione e close button.
         Di default descrizione e il pulsante sono disabilitati.
         Quando si clicca sull'immagine si espande , mostrando l'immagine più grande,
         il titolo, la descrizione e il close button in alto a destra.
         CLiccando sul pulsante si ritorna alla griglia di immagini. (gallery.html)-->
    <section class="gallery">
      <img class="gallery-item1" src="" alt="" />
      <img class="gallery-item2" src="" alt="" />
      <img class="gallery-item3" src="" alt="" />
      <img class="gallery-item4" src="" alt="" />
      <img class="gallery-item5" src="" alt="" />
      <img class="gallery-item6" src="" alt="" />
      <img class="gallery-item7" src="" alt="" />
      <img class="gallery-item8" src="" alt="" />
      <img class="gallery-item9" src="" alt="" />
      <img class="gallery-item10" src="" alt="" />
    </section>

    <?php
    if (isset($_SESSION['email'])) {
      echo '<section id="" align=center> <p style="font-size:48px;">Vuoi partecipare al sorteggio che ti permetterà di vincere un premio?</p> <form action="secondPage.php" name=""> <br> <button class="button"> Clicca qui! </button> </form></section>';
    }
    ?>

    <!-- CONTACT -->
    <section class="contacts">
      <!-- <a id="contacts" class="anchors"></a> -->
      <div class="contacts-about">
        <h2>about us</h2>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam
          voluptatum obcaecati voluptatibus vero excepturi praesentium ea
          libero facere sint alias.Lorem ipsum dolor sit amet consectetur
          adipisicing elit. Quisquam voluptatum obcaecati voluptatibus vero
          excepturi praesentium ea libero facere sint alias.
        </p>
        <p>
          Puoi contattarci direttamente tramite email oppure utilizzare un
          form.
          <i>Il messaggio verrà letto appena possibile</i>
        </p>

        <!-- EMAILS -->
        <div class="emails">
          <ul>
            <li>
              <a href="mailto:s.dambrosio26@studenti.unisa.it">s.dambrosio26@studenti.unisa.it</a>
            </li>
            <li>
              <a href="mailto:carlo.andrea01@gmail.com">carlo.andrea01@gmail.com</a>
            </li>
            <li>
              <a href="mailto:angelo_angione@email.com">angelo_angione@email.com</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="contacts-form">
        <form action="messaggio.php" method="post" onSubmit="return validaModulo(this);" name="contacts">
          <label for="fullname" class="input-label">full name</label>
          <input type="text" name="fullname" id="fullname" class="input-field" placeholder="Nome Cognome" required />

          <label for="email" class="input-label">e-mail</label>
          <?php
          if (!isset($_SESSION['email'])) {
            echo '<input type="email" name="email" id="email" class="input-field" placeholder="Email" required/>';
          } else {
            echo '<input type="email" name="email" id="email" class="input-field" placeholder="Email" value="' . $_SESSION['email'] . '" readonly/>';
          }
          ?>
          <!--<input type="email" name="email" id="email" class="input-field" placeholder="Email" required/>-->

          <label for="subject" class="input-label">oggetto</label>
          <input type="text" name="subject" id="subject" class="input-field" placeholder="Oggetto" required />

          <label for="message" class="input-label">Message <span>Opzionale (max 500 caratteri)</span></label>
          <textarea name="message" id="message" class="input-field input-textarea" placeholder="Scrivi qui"
            maxlength="500"></textarea>

          <input type="submit" value="Invia" class="button" />

        </form>
      </div>
    </section>

    <!-- FOOTER -->
    <footer>
      <!-- SOCIAL -->
      <div class="social">
        <ul>
          <li>
            <a href=""><img src="../media/img/social/tw_icons/favicon-32x32.png" alt="tw" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/fb_icons/favicon-32x32.png" alt="fb" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/ig_icons/favicon-32x32.png" alt="ig" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/yt_icons/favicon-32x32.png" alt="yt" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/tg_icons/favicon-32x32.png" alt="tg" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/rd_icons/favicon-32x32.png" alt="rd" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/in_icons/favicon-32x32.png" alt="in" /></a>
          </li>
        </ul>
      </div>

      <!-- COPYRIGHT -->
      <div class="copyright">
        <div class="logo">
          <img src="../media/img/logo/unisa_icons/favicon-32x32.png" alt="img1" />
          <span class="material-symbols-outlined">close</span>
          <img src="../media/img/logo/spiderman_icons/favicon-32x32.png" alt="img2" />
        </div>
        <p>™ & © 2024 Tutti i diritti riservati.</p>
      </div>
    </footer>

    <!-- BACK-TO-TOP BUTTON-->
    <div id="backBtn" class="back-to-top"></div>

    <script>
      function validaModulo(elementoMod) {
        const pattern = /[A-Z]\s[A-Z]/i;

        if (pattern.test(elementoMod.fullname.value)) {
          return true;
        }
        else {
          elementoMod.fullname.style.borderBottom = "solid 3px red";
          alert("Devi inserire il tuo nome completo!\nFORMATO: NOME COGNOME");

          return false;
        }
      }
    </script>

    <script language="javascript" type="text/javascript" src="../js/firstPage.js"></script>

  </div>
</body>

</html>