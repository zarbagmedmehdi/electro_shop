<?php
session_start();
require_once 'util/config1.php';
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
    header('location: login.php');
}

include 'inc/header.php';
include 'inc/nav.php';

$uid = $_SESSION['customerid'];
if(isset($_SESSION['cart']))
    $cart = $_SESSION['cart'];
?>
<!-- SHOP CONTENT -->
<section id="content">
    <div class="content-blog content-account">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h2>Mon compte</h2>
                </div>
                <div class="col-md-12">
                    <h3>Commandes recentes</h3>
                    <br>
                    <table class="cart-table account-table table table-bordered">
                        <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Date</th>
                            <th>mode de paiement</th>
                            <th>statut</th>
                            <th>Total</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                        <tbody>

                       <?php
                        $ordres =loadMultiple("SELECT * FROM commande WHERE IDCLIENT =".$uid);
                        if ($ordres!=null){
                        foreach ($ordres As $ordr){
                            ?>
                            <tr>
                                <td>
                                    <?php echo $ordr['IDCOMMANDE']; ?>
                                </td>
                                <td>
                                    <?php echo $ordr['DATECOMMANDE']; ?>
                                </td>
                                <td>
                                    <?php echo $ordr['MODEPAIEMENT'];?>
                                </td>
                                <td>
                                    <?php echo $ordr['STATUT'];?>
                                </td>
                                <td>
                                    <?php echo $ordr['PRIXTOTAL'];?>
                                </td>
                                <td>

                                    <a href="view-order.php?id=<?php echo $ordr['IDCOMMANDE'];?>">Voir</a>
                                    <?php if ($ordr['STATUT'] != 'annule') {?>
                                         <a href="cancel-order.php?id=<?php echo $ordr['IDCOMMANDE']; ?>">Annuler</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php
                        }}?>
                        </tbody>
                    </table>

                    <br>
                    <br>
                    <br>

                    <div class="ma-address">
                        <h3>Mon adresse</h3>
                        <p>cette adresse sera utilisée pour l'enregistrement.</p>

                        <div class="row">
                            <div class="col-md-6">
                                <h4>Mon adresse <a href="edit-address.php">Edit</a></h4>
                                <?php
                                $query = "SELECT c.NOM, c.PRENOM, c.TEL, a.COMPL, a.AVENUE ,a.VILLE FROM client c JOIN compladresse a  WHERE c.COMPLADRESSE_IDCOMPLADRESSE=a.IDCOMPLADRESSE AND c.IDCLIENT=".$uid;
                                $cr =loadOne($query);
                                    echo "<p>".$cr['NOM'] ." ". $cr['PRENOM'] ."</p>";
                                    echo "<p>".$cr['TEL'] ."</p>";
                                    echo "<p>".$cr['COMPL'] ."</p>";
                                    echo "<p>".$cr['AVENUE'] ."</p>";
                                    echo "<p>".$cr['VILLE'] ."</p>";
                                    ?>
                            </div>

                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>