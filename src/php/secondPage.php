<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <?php include_once "./meta.php" ?>
  
  <title>SecondPage</title>

  <!-- STYLE -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <link rel="stylesheet" href="../css/default.css" />
  <link rel="stylesheet" href="../css/secondPage.css" />

  <!-- SCRIPT -->
  <script defer src="../js/secondPage.js"></script>
</head>

<body>

  <div align=right class="logreg">
    <?php
    session_start();
    // if (!isset($_SESSION['email'])) {
    //   echo '<a href="../html/login.html">login</a><span style="color: white">/</span><a href="../html/register.html">registrati</a>';
    // } else {
    //   echo "Benvenuto " . $_SESSION['email'] . '<br> <a href="firstPage.php">Homepage</a> <br> <a href="logout.php"> Logout </a>';
    // }
    ?>
  </div>

  <div class="container">
    <!-- CAROUSEL -->
    <section class="carousel">
      <!-- PREV/NEXT BUTTONS -->
      <div data-carousel>
        <button data-carousel-btn="prev">&#10094;</button>
        <button data-carousel-btn="next">&#10095;</button>

        <!-- SLIDER -->
        <ul data-carousel-slides>
          <li class="slide" data-carousel-slide data-active>
            <img src="../media/img/spiderman_img/gallery/ps5xSpiderman2.jpg" alt="image-1" />

          </li>
          <li class="slide" data-carousel-slide>
            <img src="../media/img/spiderman_img/gallery/funkopop_milesmorales.jpg" alt="image-2" />

          </li>
          <li class="slide" data-carousel-slide>
            <img src="../media/img/spiderman_img/gallery/spiderman2PS5.jpg" alt="image-3" />

          </li>
        </ul>

        <!-- DOTS -->
        <ul data-carousel-dots>
          <li data-carousel-dot data-active></li>
          <li data-carousel-dot></li>
          <li data-carousel-dot></li>
          <!-- aggiungerne altri qui -->
        </ul>
      </div>
    </section>

    <section style="text-align:center">
    <?php
    if (!isset($_SESSION['email'])) {
      echo '<a href="../html/login.html">login</a><span style="color: white">/</span><a href="../html/register.html">registrati</a>';
    } else {
      echo "<p>Benvenuto " . $_SESSION['email'] . '</p> <br><a href="firstPage.php" style="font-size:24px">Homepage</a><br><a href="logout.php" style="font-size:24px"> Logout </a>';
    }
    ?>
    </section>

    <!-- FORM -->
    <section class="form">
      <p data-text>
        Vuoi avere la possibilità di vincere un bundle di prodotti in tema
        Spiderman?
      </p>

      <?php
      require_once "./logindb.php";

      if (isset($_SESSION['email'])) {
        $sql = "SELECT email FROM sorteggio WHERE email = '" . $_SESSION['email'] . "';";
        $ret = pg_query($db, $sql);
        if (!$ret) {
          echo "ERRORE QUERY: " . pg_last_error($db);
          exit;
        }

        if (pg_numrows($ret) == 0) {
          $_SESSION['sond'] = false;   //Iscrizione al sorteggio ancora non effettuata
        } else {
          $_SESSION['sond'] = true;    //Iscrizione al sorteggio già effettuata
        }
      }

      $sql = "SELECT * FROM vincitore";
      $ret = pg_query($db, $sql);
      if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        exit;
      }

      //$emailvincitore = pg_fetch_result($ret, 0, 'email');
      
      if (isset($_SESSION['email'])) {

        if (pg_numrows($ret) != 0) {
          $emailvincitore = pg_fetch_result($ret, 0, 'email');

          if ($_SESSION['email'] == $emailvincitore) {   //Utente vincitore
            echo "<p>Sei il vincitore!</p>";
          } else {
            //if($_SESSION['email']!=$emailvincitore){
      
            //if($emailvincitore==''){   //Sorteggio non ancora effettuato
            //  echo '<p> Sei già registrato al sorteggio! </p>';
            //}  //Utente non vincitore
            echo '<p> Non sei il vincitore!';
          }
        } else {
          echo '<p> Sei già registrato al sorteggio! </p>';
        }

      } else {
        if (!isset($_SESSION['email'])) {   //Se $_SESSION['email'] è vuota, l'utente non ha effettuato l'accesso
          echo '<p>Pagina riservata agli utenti registrati. <br/> Effettua il <a href="../html/login.html">Login</a> oppure <a href="./register.php">Registrati</a> per continuare</p>';
        } else {
          if (pg_numrows($ret) != 0) {

            //if(isset($emailvincitore)){
            echo 'Il sorteggio è stato già effettuato!';
          } else {
            $username = $_SESSION['email'];
            echo '<form action="sorteggio.php">

                  <input type="submit" onclick="myfunction()" />
                </form>';
          }

        }
      }


      ?>

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
            <a href=""><img src="../media/img/social/rd_icons/favicon-32x32.png" alt="rd" /></a>
          </li>
          <li>
            <a href=""><img src="../media/img/social/tg_icons/favicon-32x32.png" alt="tg" /></a>
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
  </div>
</body>

</html>