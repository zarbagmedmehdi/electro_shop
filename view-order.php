<?php
session_start();
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
    header('location: login.php');
}

include  'inc/header.php';
include  'inc/nav.php';

$uid = $_SESSION['customerid'];

if (isset($_GET['id']) & !empty($_GET['id'])) {
    $oid = $_GET['id'];
} else {
    header('location: my-account.php');
}
?>

<section id="content">
    <div class="content-blog content-account">
        <div class="container">
            <div class="row">
            <?php

				$orditmresql = "SELECT p.LIBELLE,i.QUANTITE,i.PRIX,c.PRIXTOTAL FROM commande c,produit p,commandeitem i WHERE c.IDCOMMANDE=i.IDCOMMANDE AND i.PRODUIT_IDPRODUIT=p.IDPRODUIT AND c.IDCLIENT=$uid AND c.IDCOMMANDE=$oid";
				$orditmres = loadMultiple($orditmresql);
                $ordrsql="SELECT c.PRIXTOTAL,c.STATUT,c.DATECOMMANDE FROM commande c WHERE c.IDCOMMANDE=$oid";
                $ordr=loadOne($ordrsql);
				if ($orditmres!=null && $ordr!=null) {
			?>
                <div class="page_header text-center">
                    <h2>Commande #<?php echo $oid; ?></h2>
                </div>
                <div class="col-md-12">
                    <h3>Commande récentes</h3>
                    <br>
                    <table class="cart-table account-table table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom du produit</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Prix Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($orditmres as $orditmr) { ?>
                            <tr>
                                <td>
                                     <?php echo substr($orditmr['LIBELLE'], 0, 25); ?>
                                </td>
                                <td>
                                    <?php echo $orditmr['QUANTITE']; ?>
                                </td>
                                <td>
                                    <?php echo $orditmr['PRIX']; ?>
                                </td>
                                <td>
                                    <?php echo $orditmr['PRIX']*$orditmr['QUANTITE']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <td colspan="3">
                                    <b>Total du commande</b>
                                </td>
                                <td>
                                    <?php echo $ordr['PRIXTOTAL']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" >
                                    <b>Statut</b>
                                </td>
                                <td>
                                    <?php echo $ordr['STATUT']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <b>date de commande</b>
                                </td>
                                <td>
                                    <?php echo $ordr['DATECOMMANDE']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            <?php } else { ?>
                <div class="page_header text-center">
                    <h2>Accès limité</h2>
                </div>
                <div class="col-md-12">
                    <h3>Vous n'avez pas le droit d'accéder aux details de cette commande. svp contacter le service clientèle</h3>
                </div>
                <div class="clearfix"></div>
            <?php } ?>
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

<?php include'inc/footer.php'; ?>
