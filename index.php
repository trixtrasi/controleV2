<?php
require_once "auth/session/index.php";
require_once "connect.php";
require_once "public/includes/head.php";
require_once "public/includes/navbar.php";
?>

<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="container-fluid bg-light">
        <div class="justify-content-center d-flex min-vh-100 mt-5 row" id="mainContent">
            <?php
             include "public/home/index.php"; 
            ?>
        </div>
    </div>
</div>

<?php
include_once "public/includes/footer.php";
?>
</body>

</html>