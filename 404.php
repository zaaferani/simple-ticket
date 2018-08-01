<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/31/2018
 * Time: 9:14 AM
 */

require_once 'header.php';

?>

<div class="row">
    <div class="bg-warning col-md-6 col-md-offset-3 text-center">
        <h1>404</h1>
        <h3>Requested Url not found</h3>
        <?php
        if (isset($_SESSION['e404']))
            echo "<pre class='text-left'>$_SESSION[e404]}</pre>";
        ?>
    </div>
</div>

<?php
require_once 'footer.php';
?>