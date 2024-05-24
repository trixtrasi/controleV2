  <?php
  include "../../auth/session/index.php";
  include "../../connect.php";

  $sql = "SELECT * FROM `visitantes__visitas` WHERE `visitas__status` = '1'";
  $query = mysqli_query($conn, $sql);
  $qtd_no_local = mysqli_num_rows($query);

if ($qtd_no_local > 0){
   echo "VISITAS NO LOCAL <span class=\"position-absolute translate-middle badge rounded-pill bg-danger\">" . $qtd_no_local . "</span>";
}else{
    echo "VISITAS NO LOCAL";
}