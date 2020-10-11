<?php
session_start();
ob_start();
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
    header('location: login.php');
}

include 'inc/header.php';
include  'inc/nav.php';

$uid = $_SESSION['customerid'];
if(isset($_COOKIE['cart']))
$cart = $_COOKIE['cart'];
$coupon="";
$price=0;

require_once 'util/config1.php';
$query = "SELECT c.NOM, c.PRENOM, c.TEL, a.COMPL, a.AVENUE ,a.VILLE FROM client c JOIN compladresse a  WHERE c.COMPLADRESSE_IDCOMPLADRESSE=a.IDCOMPLADRESSE AND c.IDCLIENT=".$uid;
$r =loadOne($query);
$count=loadOne("SELECT COUNT(`COMPLADRESSE_IDCOMPLADRESSE`) FROM client WHERE IDCLIENT=".$uid)['COUNT(`COMPLADRESSE_IDCOMPLADRESSE`)'];

if (isset($cart)){
    global $orderTotal;
    foreach ($cart as $key => $value) {
        $orderSql = "SELECT * FROM stockproduit WHERE IDSTOCKPRODUIT=".$key;
        $order = loadOne($orderSql);
        if($order['QTESTOCK']<$value){
            header('location: cart.php?msg=-2');
        }
        $orderTotal = $orderTotal + ($order['PRIXUNITAIRE']*$value);
        echo "<script>console.log('1')</script>";
    }
    if(isset($_GET) & !empty($_GET)){
        global $coupon;
        $coupon=$_GET['coupon'];
        if(!empty($coupon)){
            $couponsql="SELECT * FROM `reductioncoupon` WHERE `UTILISE`=0 AND `REFERENCE`='$coupon'";
            echo "<script>console.log({$coupon})</script>";
            $cpn=loadOne($couponsql);
            if($cpn!=null){
                global $price;
                $price=$cpn['MONTANTREDUCTION'];
            }
        }
    }
}

if (isset($_POST) & !empty($_POST)) {
    echo "<script>console.log('2')</script>";
    if ($_POST['agree'] == true) {
        echo "<script>console.log('3')</script>";
        $firstName = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
        $surname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
        $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
        $avenue = filter_var($_POST['avenue'], FILTER_SANITIZE_STRING);
        $payment= filter_var($_POST['avenue'], FILTER_SANITIZE_STRING);
        $sqlStatement="";
        $sqlStatement1="";
        if (!empty($firstName) && !empty($surname) && !empty($address1) && !empty($city) && !empty($avenue) && !empty($phone) ) {
            //echo "<script>console.log('4')</script>";
            if ($count == 1) {
                //echo "<script>console.log('5')</script>";
                $sqlStatement="UPDATE client c,compladresse a SET  a.VILLE='$city',a.AVENUE='$avenue',a.COMPL='$address1',c.PRENOM='$firstName',c.NOM='$surname',c.TEL='$phone' WHERE c.COMPLADRESSE_IDCOMPLADRESSE=a.IDCOMPLADRESSE AND c.IDCLIENT =$uid";
            } elseif ($count == 0) {
                //echo "<script>console.log('6')</script>";
                $newID=generateMax('COMPLADRESSE','IDCOMPLADRESSE');
                $sqlStatement = "INSERT INTO compladresse VALUES ($newID,'$avenue', '$city','$address1')";
                $sqlStatement1="UPDATE client SET TEL='$phone', PRENOM='$firstName', NOM='$surname',PASSWORD=md5('$password') WHERE IDCLIENT=$uid";
            }

            if($sqlStatement!=""){
                //echo "<script>console.log('7.1')</script>";
                $rs =execRequest($sqlStatement);
            }
            if($sqlStatement1!=""){
                //echo "<script>console.log('7.2')</script>";
                $rss =execRequest($sqlStatement1);
            }


            if (isset($_POST['payment'])) {
                //echo "<script>console.log('8')</script>";
                $newID=generateMax('COMMANDE','IDCOMMANDE');
                $orderInsert = "INSERT INTO commande VALUES ($newID,sysdate(),'$payment','commande envoye',$orderTotal+100-$price,null,$uid)";
                $insertResult = execRequest($orderInsert);
                $couponUpdate="UPDATE reductioncoupon set UTILISE=1 WHERE REFERENCE='$coupon'";
                 execRequest($couponUpdate);
                // Insert the Order to the orders table.
                if ($insertResult == TRUE) {
                    //echo "<script>console.log('9')</script>";
                    foreach ($cart as $key => $value) {
                        //echo "<script>console.log('10')</script>";
                        $itemSql = "SELECT p.IDPRODUIT,s.PRIXUNITAIRE,s.IDSTOCKPRODUIT,s.QTESTOCK,s.REVENDEUR_IDREVENDEUR 
                        FROM produit p, stockproduit s  WHERE p.IDPRODUIT=s.PRODUIT_IDPRODUIT AND IDSTOCKPRODUIT=$key";
                        $item = loadOne($itemSql);
                        $productId = $item['IDPRODUIT'];
                        $productPrice = $item['PRIXUNITAIRE'];
                        $productQuant = $value;
                        $sellerId=$item['REVENDEUR_IDREVENDEUR'];
                        echo "<script>console.log({$newID})</script>";
                        $orderItemSql = "INSERT INTO commandeitem(`PRIX`, `QUANTITE`, `PRODUIT_IDPRODUIT`, `REVENDEUR_IDREVENDEUR`, `IDCOMMANDE`) VALUES ($productPrice,$productQuant,$productId,$sellerId,$newID)";
                        $orderItemsResult = execRequest($orderItemSql);
                        echo "<script>console.log({$orderItemsResult->rowCount()})</script>";
                        if ($orderItemsResult->rowCount() ===0) {
                            echo "<script>console.log('11')</script>";
                            echo "Erreur d'insertion de commande";
                        }
                    }
                    if ($orderItemsResult->rowCount() ===1) {
                        echo "<script>console.log('12')</script>";
                        foreach ($cart as $id=>$value){
                            setcookie("cart[$id]","");
                            unset($_COOKIE["cart"][$id]);
                        }
                        header("location: view-order.php?id=$newID");
                    }
                }
            }
        }
    }
}
ob_flush();
?>
<section id="content">
    <div class="content-blog">
        <div class="page_header text-center">
            <h2>Commander</h2>
        </div>
    <?php if (!empty($cart)) { ?>
        <form method="post">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="billing-details">
                            <h3 class="uppercase">Détails de livraison</h3>
                            <br>
                            <p>Les champs marqués par <i style="color:tomato;">*</i> sont obligatoire et vous devez
                                les remplir avant de modifier vos informations personnelles.</p>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">Ville <i style="color:tomato;">*</i></label>
                                    <select name="city" class="form-control" required>
                                        <?php
                                        if (!empty($r['VILLE'])) {
                                            echo '<option value="' . $r['VILLE'] . '">' . $r['VILLE'] . '</option>';
                                        } else {
                                            echo '<option value="">Choisir la ville</option>' . "\n";
                                        } ?>
                                        <option value="Marrakech">Marrakech</option>
                                        <option value="Rabat">Rabat</option>
                                        <option value="Fes">Fes</option>
                                        <option value="Kenitra">Kenitra</option>
                                        <option value="Tanger">Tanger</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Avenue <i style="color:tomato;">*</i></label>
                                    <input name="avenue" class="form-control" placeholder="Avenue..."
                                           value="<?php if (!empty($r['AVENUE'])) {
                                               echo $r['AVENUE'];
                                           } elseif (isset($avenue)) {
                                               echo $avenue;
                                           } ?>" type="text" required>
                                    <div class="clearfix space20"></div>
                                </div>
                            </div>
                            <div class="clearfix space20"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Prenom <i style="color:tomato;">*</i></label>
                                    <input name="fname" class="form-control" placeholder=""
                                           value="<?php if (!empty($r['PRENOM'])) {
                                               echo $r['PRENOM'];
                                           } elseif (isset($firstName)) {
                                               echo $firstName;
                                           } ?>" type="text" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Nom <i style="color:tomato;">*</i></label>
                                    <input name="lname" class="form-control" placeholder=""
                                           value="<?php if (!empty($r['NOM'])) {
                                               echo $r['NOM'];
                                           } elseif (isset($surname)) {
                                               echo $surname;
                                           } ?>" type="text" required>
                                </div>
                            </div>
                            <div class="clearfix space20"></div>
                            <label>Addresse <i style="color:tomato;">*</i></label>
                            <input name="address1" class="form-control"
                                   placeholder="rue, appt, Immeuble, quartier,..."
                                   value="<?php if (!empty($r['COMPL'])) {
                                       echo $r['COMPL'];
                                   } elseif (isset($address1)) {
                                       echo $address1;
                                   } ?>" type="text" required>
                            <div class="clearfix space20"></div>
                            <label>Téléphone <i style="color:tomato;">*</i></label>
                            <input name="phone" class="form-control" id="billing_phone" placeholder=""
                                   value="<?php if (!empty($r['TEL'])) {
                                       echo $r['TEL'];
                                   } elseif (isset($phone)) {
                                       echo $phone;
                                   } ?>" type="text" required>
                        </div>
                    </div>
                </div>
                <div class="space30"></div>
                <h4 class="heading">Votre commande</h4>
                <div class="row">
                    <?php if ($price>0) : ?>
                        <div class="col-sm-12">
                            <div class="alert alert-success text-center" role="alert">
                                <?php echo "coupon valide"; ?>
                            </div>
                        </div>
                    <?php elseif ($price==0) : ?>
                        <div class="col-sm-12">
                            <br>
                            <div class="alert alert-warning text-center" role="alert">
                                <?php echo "coupon invalide ou pas de coupon"; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <table class="table table-bordered extra-padding">
                    <tbody>
                        <tr>
                            <th>Cart Subtotal</th>
                            <td><span class="amount"><?php echo $orderTotal; ?></span></td>
                        </tr>
                        <tr>
                            <th>tarif de livraison</th>
                            <td>
                                100dh
                            </td>
                        </tr>
                        <tr>
                            <th>Order Total</th>
                            <td><strong><span class="amount"><?php echo $orderTotal+100-$price; ?></span></strong> </td>
                        </tr>
                    </tbody>
                </table>

                <div class="clearfix space30"></div>
                <h4 class="heading">Mode de paiement</h4>
                <div class="clearfix space20"></div>

                <div class="payment-method">
                    <div class="row">

                        <div class="col-md-4">
                            <input name="payment" id="radio1" class="css-checkbox" type="radio" value="espece" checked ><span>Espece à la livraison</span>
                            <div class="space20"></div>
                        </div>
                        <div class="col-md-4">
                            <input name="payment" id="radio2" class="css-checkbox" type="radio"><span value="cheque">Par Chèque</span>
                            <div class="space20"></div>
                            <p>envoyer le cheque à la l'une des agences de BMCE (N° Compte: 0121 56445 54334 45554 98700)</p>
                        </div>
                        <div class="col-md-4">
                            <input name="payment" id="radio3" class="css-checkbox" type="radio"><span value="paypal">Paypal</span>
                            <div class="space20"></div>
                            <p> via PayPal; si vous n'avez pas de compte paypal, vous pouvez payés par votre carte bancaire.</p>
                        </div>

                    </div>
                    <div class="space30"></div>

                    <input name="agree" id="checkboxG2" class="css-checkbox" type="checkbox" value="true" required><span>j'ai lu et accepter les termes<a href="#">terms &amp; conditions</a></span>

                    <div class="space30"></div>
                    <input type="submit" class="button btn-lg" value="Payer maintenant">
                </div>
            </div>
        </form>
    <?php } elseif (empty($cart)) { ?>
        <!-- There is nothing in the cart to checkout so we display this message. -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2>Vous n'avez rien dans votre panier</h2>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</section>

<?php include 'inc/footer.php'; ?>
