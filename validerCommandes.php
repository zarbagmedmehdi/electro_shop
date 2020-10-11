<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 02/06/2019
 * Time: 10:27
 */

include 'inc/header.php';
include 'inc/navAdmin.php';
include 'util/config.php';
session_start();
if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
    header('location: speciaLogin.php');
}
$email=$_SESSION['email'];

?>


<section id="content">
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h3>Mes commandes reçues</h3>
                </div>

                <div class="col-md-12">
                    <table class="cart-table table table-bordered">
                        <thead>
                        <tr>
                            <th>date commande</th>
                            <th>prix total</th>
                            <th>nom</th>
                            <th>  email </th>

                            <th>telephone</th>
                            <th> statut</th>
                            <th>operation</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php

                        $cartsql = "select  c.IDCOMMANDE as id , c.DATECOMMANDE as dc ,c.PRIXTOTAL as pt ,c.STATUT s ,cl.EMAIL e ,cl.NOM as n ,cl.TEL as t from client cl ,commande c where c.IDCLIENT=cl.IDCLIENT";


                        $commandesItems = loadMultiple($cartsql);

                        if ($commandesItems!=null){
                            for ($i=0;$i<count($commandesItems);$i++) {
                                $a=$commandesItems[$i];
                                ?>
                                <td>
                                    <span class="amount"><?php echo  $a->dc ; ?></span>
                                </td>
                                <td>
                                    <span class="amount"><?php echo $a->pt; ?></span>
                                </td>
                                <td>
                                    <span class="amount"><?php echo $a->n; ?></span>
                                </td>
                                <td>
                                    <span class="amount"><?php echo $a->e; ?></span>
                                </td>
                                <td>
                                    <span class="amount"><?php echo $a->t; ?></span>
                                </td>
                                <td>
                                    <span class="amount"><?php echo $a->s; ?></span>
                                </td>
                                <td>
                                    <a href="service/ValiderService.php?id=<?php echo $a->id; ?>"><input type="button" value="valider" class="button btn-md"   style="color:white;"/> </a>

                                </td>

                                </tr>

                            <?php }} ?>

                        </tbody>
                    </table>
                </div>
                <div class="cart_totals">
                    <div class="col-md-6 push-md-6 no-padding">


                    </div>
                </div>



            </div>
        </div>
    </div>
</section>


<div class="clearfix space90"></div>
<div class="clearfix space90"></div>



<?php include 'inc/footer.php'; ?>
