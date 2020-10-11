<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 02/06/2019
 * Time: 10:27
 */

include 'inc/header.php';
include 'inc/navRevendeur.php';
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
                                <th>IMAGE</th>
                                <th>PRODUIT</th>
                                <th>QUANTITE voulue</th>
                                <th>QUANTITE en  STOCK</th>
                                <th>prix total</th>
                                <th>PRIX UNITAIRE</th>
                                <th>stock</th>



                            </tr>
                            </thead>

                            <tbody>
                            <?php

                            $cartsql = "SELECT s.QTESTOCK as qtestock ,s.PRIXUNITAIRE as prixunitaire, ct.QUANTITE as q ,p.LIBELLE as libelle ,  p.IMAGE as i , IDSTOCKPRODUIT as idstock , ct.PRIX as prix 
 FROM commandeitem ct ,revendeur r,produit p , stockproduit s where ct.REVENDEUR_IDREVENDEUR=r.IDREVENDEUR and p.IDPRODUIT=ct.PRODUIT_IDPRODUIT
 and  s.PRODUIT_IDPRODUIT=p.IDPRODUIT and s.REVENDEUR_IDREVENDEUR=r.IDREVENDEUR and   r.EMAIL='$email'";

                            $commandesItems = loadMultiple($cartsql);

if ($commandesItems!=null){
                                for ($i=0;$i<count($commandesItems);$i++) {
$a=$commandesItems[$i];
                                ?>
                                    <td>
                                        <a href="#"><img src="uploads/<?php echo $a->i ; ?>" alt="not found" height="90" width="90"></a>
                                    </td>
                                    <td>
                                        <span class="amount"><?php echo $a->libelle; ?></span>
                                    </td>
                                    <td>
                                        <span class="amount"><?php echo $a->q; ?></span>
                                    </td>
                                    <td>
                                        <span class="amount"><?php echo $a->qtestock; ?></span>
                                    </td>
                                    <td>
                                        <span class="amount"><?php echo $a->prix; ?></span>
                                    </td>
                                    <td>
                                        <span class="amount"><?php echo $a->prixunitaire; ?></span>
                                    </td>
                                    <td>
                                        <span class="amount"><?php echo $a->idstock; ?></span>
                                    </td>


                                </tr>

                            <?php }} ?>

                            </tbody>
                        </table>
                    </div>




            </div>
        </div>
    </div>
</section>


<div class="clearfix space90"></div>
<div class="clearfix space90"></div>



<?php include 'inc/footer.php'; ?>
