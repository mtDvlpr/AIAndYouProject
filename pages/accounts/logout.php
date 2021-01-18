<?php session_start();if(isset($_SESSION["login"])){unset($_SESSION["login"]);}else{header ('Location: /'); exit();} ?>
<script>
  function goBack() {
    window.history.back();
  }
  goBack();
</script>