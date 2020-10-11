<?php
session_start();
include 'inc/header.php';
include 'inc/nav.php';
include_once 'util/config1.php';
?>

<!-- SHOP CONTENT -->
<section id="content">
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h2>Shop</h2>
                    <p>Naviguer dans notre collection de produits pour trouver ce que vous souhaitez.</p>
                </div>
                <div class="col-md-12">
                    <div id="shop-mason" class="shop-mason-3col">
                        <div class="row">
                           <?php
                           // Get a list of all the products; either for the home page or the
                            // individual category pages.
                            $sql = "SELECT p.*,s.PRIXUNITAIRE,s.QTESTOCK,s.IDSTOCKPRODUIT FROM produit p,stockproduit s
                                    WHERE p.IDPRODUIT=s.PRODUIT_IDPRODUIT";
                            if (isset($_GET['id']) & !empty($_GET['id'])) {
                                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                                $sql .= " AND p.CATEGORIE_IDCATEGORIE=$id";
                            }
                            $products = loadMultiple($sql);
                            foreach ($products as $r):
                                $count++;
                                if ($count % 4 == 0) {
                                    echo '<div class=""></div>';
                            }
                                ?>
                                <div class="shop-item">
                                    <div class="product">
                                        <div class="product-thumb">
                                            <img src="uploads/<?php echo $r['IMAGE']; ?>" class="img-responsive" width="250px" alt="">
                                            <div class="product-overlay">
                                                <span>
                                                    <a href="single.php?id=<?php echo $r['IDSTOCKPRODUIT']; ?>" class="fa fa-link"></a>
                                                    <a href="addtocart.php?id=<?php echo $r['IDSTOCKPRODUIT']; ?>" class="fa fa-shopping-cart"></a>
                                                </span>
                                            </div>
                                        </div>
                                        <h2 class="product-title"><a href="single.php?id=<?php echo $r['IDPRODUIT']; ?>"><?php echo $r['LIBELLE']; ?></a></h2>
                                        <div class="product-price"><?php echo  $r['PRIXUNITAIRE']; ?> DH<span></span></div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="page_nav">
                        <a href=""><i class="fa fa-angle-left"></i></a>
                        <a href="" class="active">1</a>
                        <a href="">2</a>
                        <a href="">3</a>
                        <a class="no-active">...</a>
                        <a href="">9</a>
                        <a href=""><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'inc/footer.php'; ?>