<?php
require_once 'util/config1.php';
if (isset($_COOKIE['cart'])) {
    $cart = $_COOKIE['cart'];
    $count = count($cart);
} else {
    $count = 0;
}
$cartTotal = 0;
?>
<div class="menu-wrap">
    <div id="mobnav-btn">Menu <i class="fa fa-bars"></i></div>
    <ul class="sf-menu">
        <li>
            <a href="/electro/index.php">ACCEUIL</a>
        </li>
        <li>
            <a href="#">CATEGORIES</a>
            <div class="mobnav-subarrow"><i class="fa fa-plus"></i></div>
            <ul>
                <?php
                $catres =loadMultiple("SELECT * FROM categorie");
                foreach ($catres as $catr) {
                    ?>
                    <li><a href="/electro/index.php?id=<?php echo $catr['IDCATEGORIE']; ?>"><?php echo $catr['CATLIBELLE']; ?></a></li>
                    <?php
                } ?>
            </ul>
        </li>
        <li>
            <a href="#">MON COMPTE</a>
            <div class="mobnav-subarrow"><i class="fa fa-plus"></i></div>
            <ul>
                <li><a href="/electro/my-account.php">Mes Commandes</a></li>
                <li><a href="/electro/edit-address.php">Modifier l'adresse</a></li>
                <?php if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) : ?>
                    <li><a href="/electro/login.php">S'authentifier</a></li>
                <?php else : ?>
                    <li><a href="/electro/logout.php">Deconnexion</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <li>
            <a href="/electro/contact.php">Contact</a>
        </li>
    </ul>
    <div class="header-xtra">
        <div class="s-cart">
            <div class="sc-ico"><i class="fa fa-shopping-cart"></i><?php
                if ($count !== 0) {
                    echo "<em>" . count($cart) . "</em>";
                } ?></div>
            <div class="cart-info">
                <small><?php
                    if ($count !== 0 && $count !== 1) {
                        echo 'Vous avez <em class="highlight">'.$count.' elements</em> dans votre panier.';
                    } else if ($count === 1) {
                        echo 'Vous avez <em class="highlight">1 element</em> dans votre panier.';
                    } else {
                        echo 'votre panier est vide.pourquoi ne pas ajouter quelque produit?';
                    } ?>
                </small>
                <br>
                <br>


                <?php
                if ($count != 0) {
                    foreach ($cart as $key => $value) {
                        $cartsql = "SELECT p.IMAGE,p.LIBELLE,s.PRIXUNITAIRE,s.IDSTOCKPRODUIT FROM produit p, stockproduit s  WHERE p.IDPRODUIT=s.PRODUIT_IDPRODUIT AND IDSTOCKPRODUIT=$key";
                        $navcartr= loadOne($cartsql);
                        ?>
                        <div class="ci-item">
                            <img src="uploads/<?php echo $navcartr['IMAGE']; ?>" width="70" alt=""/>
                            <div class="ci-item-info">
                                <h5>
                                    <a href="single.php?id=<?php echo $navcartr['IDSTOCKPRODUIT']; ?>"><?php echo substr($navcartr['LIBELLE'], 0, 20); ?></a>
                                </h5>
                                <p><?php echo $value . ' x ' .$navcartr['PRIXUNITAIRE']; ?></p>
                                <div class="ci-edit">
                                    <a href="delcart.php?id=<?php echo $key; ?>" class="edit fa fa-trash"></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        global $cartTotal;
                        $cartTotal = $cartTotal + ($navcartr['PRIXUNITAIRE']*$value);
                    }}
                ?>





                <div class="ci-total">total: <?php $cartTotal; ?></div>
                <div class="cart-btn">
                    <a href="cart.php">Voir Chariot</a>
                    <a href="checkout.php">Checkout</a>
                </div>
            </div>
        </div>
        <div class="s-search">
            <div class="ss-ico"><i class="fa fa-search"></i></div>
            <div class="search-block">
                <div class="ssc-inner">
                    <form>
                        <input type="text" placeholder="Entrer un texte...">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</header>