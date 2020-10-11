<?php
require_once 'util/config1.php';
session_start();
ob_start();
if (isset($_GET['id']) & !empty($_GET['id'])) {
    $id = $_GET['id'];
        $query = "SELECT s.* FROM stockproduit s where s.IDSTOCKPRODUIT=$id";
    $stock=loadOne($query);
        $query="SELECT  p.* FROM produit p WHERE p.IDPRODUIT=".$stock['PRODUIT_IDPRODUIT'];
    $product=loadOne($query);
        $query="SELECT p.* FROM propriete p WHERE p.PRODUIT_IDPRODUIT=".$stock['PRODUIT_IDPRODUIT'];
    $properties=loadMultiple($query);
        $query="SELECT r.* FROM revendeur r where r.IDREVENDEUR=".$stock['REVENDEUR_IDREVENDEUR'];
    $seller=loadOne($query);
        $query="SELECT  r.* FROM review r WHERE r.PRODUIT_IDPRODUIT=".$stock['PRODUIT_IDPRODUIT'];

} else if(isset($_GET['msg'])) {
    }
else{
    header('location: index.php');
}

ob_flush();

$uid = $_SESSION['customerid'];
if (isset($_POST) & !empty($_POST)) {
    $review = filter_var($_POST['review'], FILTER_SANITIZE_STRING);
    $idProd=$product['IDPRODUIT'];

    $revsql = "INSERT INTO review(CONTENU,DATERATING,PRODUIT_IDPRODUIT,USER_IDCLIENT) VALUE ('$review',current_date,$idProd,$uid)";
    $revres=execRequest($revsql);
    if ($revres) {
        $smsg = "Review enregistré";
    } else {
        $fmsg = "echec d'enregistrement du review";
    }
}

include 'inc/header.php';
include 'inc/nav.php';
?>

<section id="content">
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h2>Magasin</h2>
                </div>
                <div class="col-md-10 col-md-offset-1">
                    <?php if (isset($fmsg)) {
                        ?>
                        <div class="row">
                            <div class="alert alert-danger" role="alert"><?php echo $fmsg; ?></div>
                        </div>
                        <?php
                    } ?>
                    <?php if (isset($_GET['msg']) && $_GET['msg']==-1 ) {
                        ?>
                        <div class="row">
                            <div class="alert alert-danger" role="alert">quantitié non disponible</div>
                        </div>
                        <?php
                    } ?>
                    <?php if (isset($smsg)) {
                        ?>
                    <div class="row">
                        <div class="alert alert-success" role="alert"><?php echo $smsg; ?></div>
                    </div>
                    <?php
                    } ?>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="gal-wrap">
                                <div id="gal-slider" class="flexslider">
                                    <ul class="slides">
                                        <li><img src="uploads/<?php echo $product['IMAGE']; ?>" class="img-responsive" alt=""/></li>
                                    </ul>
                                </div>
                                <ul class="gal-nav">
                                    <li>
                                        <div>
                                            <<img src="uploads/<?php echo $product['IMAGE']; ?>" class="img-responsive" alt=""/>
                                        </div>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-7 product-single">
                            <h2 class="product-single-title no-margin"><?php echo $product['LIBELLE']; ?>
                            <br/>
                                <?php echo $product['DESCRIPTION']; ?>
                            <br/>
                                <?php echo "Revendeur : ".$seller['NOM']; ?>
                            </h2>
                            <div class="space10"></div>
                            <div class="p-price"><?php echo $stock['PRIXUNITAIRE']; ?> DH</div>
                            <?php
                            if($properties!=null){
                            foreach ($properties as $property){
                                ?>
                                <p><?php echo $property['LIBELLE']." : ".$property['VALEURPROPRIETE']." : ".$property['TYPEPROPRIETE']; ?></p>
                            <?php
                            }} ?>

                            <form method="get" action="addtocart.php">
                                <div class="product-quantity">
                                    <span>Quantité:</span>
                                    <input type="hidden" name="id" value="<?php echo $stock['IDSTOCKPRODUIT']; ?>">
                                    <input type="text" name="quant" placeholder="1" required>
                                </div>
                                <div class="shop-btn-wrap">
                                    <input type="submit" class="button btn-small space20" value="Ajouter au panier">
                                </div>
                            </form>
                            <div class="product-meta">
                                <span>Categorie:
                                    <?php
                                    $prodcatsql = "SELECT * FROM categorie WHERE IDCATEGORIE=".$product['CATEGORIE_IDCATEGORIE'];
                                    $prodcatr=loadOne($prodcatsql);
                                    ?>
                                    <a href="index.php?id=<?php echo $prodcatr['IDCATEGORIE']; ?>"><?php echo $prodcatr['CATLIBELLE']; ?></a>
                                </span><br>
                            </div>
                        </div>
                    </div>
                        <div class="clearfix space30"></div>
                        <div class="tab-style3">
                            <!-- Nav Tabs -->
                            <div class="align-center mb-40 mb-xs-30">
                                <ul class="nav nav-tabs tpl-minimal-tabs animate">
                                    <li class="active col-md-6">
                                        <a aria-expanded="true" href="#mini-one" data-toggle="tab">Description</a>
                                    </li>
                                    <!-- <li class="col-md-4">
                                        <a aria-expanded="false" href="#mini-two" data-toggle="tab">Product Info</a>
                                    </li> -->
                                    <li class="col-md-6">
                                        <a aria-expanded="false" href="#mini-three" data-toggle="tab">Apreciations</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Nav Tabs -->
                        <!-- Tab panes -->
                        <div style="height: auto;" class="tab-content tpl-minimal-tabs-cont align-center section-text">
                            <div style="" class="tab-pane fade active in" id="mini-one">
                                <p>T<?php echo $product['DESCRIPTION']; ?></p>
                            </div>
                            <div style="" class="tab-pane fade" id="mini-three">
                                <div class="col-md-12">
                                    <?php
                                    $revcountsql = "SELECT count(*) AS count FROM review r WHERE r.PRODUIT_IDPRODUIT=".$stock['PRODUIT_IDPRODUIT'];
                                    $revcountr = loadOne($revcountsql);
                                    ?>
                                    <h4 class="uppercase space35"><?php echo $revcountr['count']; ?> Appréciation(s) pour <?php echo $product['LIBELLE']; ?></h4>
                                    <ul class="comment-list">
                                        <?php
                                        $selrevsql = "select r.CONTENU,r.DATERATING,c.NOM,c.PRENOM FROM review r , client c WHERE r.USER_IDCLIENT=c.IDCLIENT AND r.PRODUIT_IDPRODUIT=".$stock['PRODUIT_IDPRODUIT'];
                                        $selrevres =loadMultiple($selrevsql);
                                        if($selrevres!=null){
                                        foreach ($selrevres as $selrevr) {
                                            ?>
                                            <li>
                                                <div class="comment-meta">
                                                    <a href="#"><?php echo $selrevr['NOM']." ". $selrevr['PRENOM']; ?></a>
                                                    <span>
                                                        <em><?php echo $selrevr['DATERATING']; ?></em>
                                                    </span>
                                                </div>
                                                <p>
                                                    <?php echo $selrevr['CONTENU']; ?>
                                                </p>
                                            </li>
                                            <?php
                                        }} ?>
                                    </ul>
                                    <?php
                                    $chkrevsql = "SELECT count(*) as reviewcount FROM review r WHERE r.USER_IDCLIENT=$uid AND r.PRODUIT_IDPRODUIT=".$product['IDPRODUIT'];
                                    $chkrevr = loadOne($chkrevsql);
                                    if ($chkrevr['reviewcount'] >= 1) {
                                        echo "<h4 class='uppercase space20'>Vous avez déjà apprecier ce produit...</h4>";
                                    } else {
                                    ?>
                                        <h4 class="uppercase space20">Ajouter une appreciation</h4>
                                        <form id="form" class="review-form" method="post">
                                            <?php
                                            $usersql = "SELECT u.EMAIL,u.NOM,u.PRENOM FROM client u  WHERE u.IDCLIENT=$uid";
                                            $userr = loadOne($usersql) ?>
                                            <div class="row">
                                                <div class="col-md-6 space20">
                                                    <input name="name" class="input-md form-control" placeholder="Nom *" maxlength="100" required="" type="text" value="<?php echo $userr['PRENOM'] . " " . $userr['NOM']; ?>" disabled>
                                                </div>
                                                <div class="col-md-6 space20">
                                                    <input name="email" class="input-md form-control" placeholder="Email *" maxlength="100" required="" type="email" value="<?php echo $userr['EMAIL']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="space20">
                                                <textarea name="review" id="text" class="input-md form-control" rows="6" placeholder="Ajouter une appréciation.." maxlength="400"></textarea>
                                            </div>
                                            <button type="submit" class="button btn-small">
                                                envoyer
                                            </button>
                                        </form>
                                    <?php
                                    } ?>
                                </div>
                                <div class="clearfix space30"></div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="space30"></div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
