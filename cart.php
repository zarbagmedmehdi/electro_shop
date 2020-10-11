<?php
session_start();
require_once 'util/config1.php';
include 'inc/header.php';
include 'inc/nav.php';

if(isset($_COOKIE['cart'])){
    $cart=$_COOKIE['cart'];
    $count= count($cart);
}
$total=0;

?>

<section id="content">
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h2>Panier</h2>
                    <p>voir les elements dans votre panier ou bien supprimer les produits du panier.</p>
                </div>
            <?php if ($count !== 0) { ?>
                <div class="col-md-12">
                    <table class="cart-table table table-bordered">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Image</th>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                foreach ($cart as $key => $value) {
                                    $cartsql = "SELECT p.IMAGE,p.LIBELLE,s.PRIXUNITAIRE,s.IDSTOCKPRODUIT FROM produit p, stockproduit s  WHERE p.IDPRODUIT=s.PRODUIT_IDPRODUIT AND IDSTOCKPRODUIT=$key";
                                    $cartr = loadOne($cartsql);
                            ?>
                            <tr>
                                <td>
                                    <a class="remove" href="delcart.php?id=<?php echo $key; ?>"><i class="fa fa-times"></i></a>
                                </td>
                                <td>
                                    <a href="#"><img src="uploads/<?php echo $cartr['IMAGE']; ?>" alt="" height="90" width="90"></a>
                                </td>
                                <td>
                                    <a href="single.php?id=<?php echo $cartr['IDSTOCKPRODUIT']; ?>"><?php echo $cartr['LIBELLE']; ?></a>
                                </td>
                                <td>
                                    <span class="amount"><?php echo $cartr['PRIXUNITAIRE']; ?></span>
                                </td>
                                <td>
                                    <div class="quantity"><?php echo $value; ?></div>
                                </td>
                                <td>
                                    <span class="amount"><?php echo ($cartr['PRIXUNITAIRE']*$value); ?></span>
                                </td>
                            </tr>
                            <?php
                                    global $total;
                                    $total = $total + ($cartr['PRIXUNITAIRE']*$value);
                                }
                            ?>
                            <tr>
                                <form method="get" action="checkout.php">
                                <td colspan="6" class="actions">
                                    <div class="col-md-6">
                                        <div class="coupon">
                                            <label>Coupon:</label><br>
                                            <input placeholder="Code coupon" name="coupon" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="cart-btn">
                                            <input type="submit" value="Commander" class="button btn-md" style="color:white;"/>
                                        </div>
                                    </div>
                                </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cart_totals">
                    <div class="col-md-6 push-md-6 no-padding">
                        <h4 class="heading">Total panier</h4>
                        <table class="table table-bordered col-md-6">
                            <tbody>
                                <tr>
                                    <th>Montant total</th>
                                    <td><span class="amount"><?php echo $total; ?></span></td>
                                </tr>
                                <tr>
                                    <th>Livraison</th>
                                    <td>40 dh</td>
                                </tr>
                                <tr>
                                    <th>Order Total</th>
                                    <td><strong><span class="amount"><?php echo $total+40; ?></span></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-6 col-md-offset-3">
                    <h2>Vottre panier est vide, pourquoi ne pas ajouter quelque produits?</h2>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
