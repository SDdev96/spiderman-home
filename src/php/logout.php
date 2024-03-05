    <?php
      /* attiva la sessione */
    session_start();
    /* sessione attiva, la distrugge */
    $sname=session_name();
    session_destroy();
    /* ed elimina il cookie corrispondente */ if (isset($_COOKIE[$sname])) {
    setcookie($sname,'', time()-3600,'/');
    }
    echo '<script> alert("Logout effettuato."); window.location.replace("firstPage.php"); </script>';
    ?>
