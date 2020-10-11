<?php
session_start();
ob_start();
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
    header('location: login.php');
} else {
    $uid = $_SESSION['customerid'];
}
$uid = $_SESSION['customerid'];

include 'inc/header.php';
include 'inc/nav.php';

require_once 'util/config1.php';
$query = "SELECT c.NOM, c.PRENOM, c.TEL, a.COMPL, a.AVENUE ,a.VILLE FROM client c JOIN compladresse a  WHERE c.COMPLADRESSE_IDCOMPLADRESSE=a.IDCOMPLADRESSE AND c.IDCLIENT=" . $uid;
$r = loadOne($query);
$nb = loadOne("SELECT COUNT(`COMPLADRESSE_IDCOMPLADRESSE`) FROM client WHERE IDCLIENT=" . $uid)['COUNT(`COMPLADRESSE_IDCOMPLADRESSE`)'];

if (isset($_POST) & !empty($_POST)) {
    $firstName = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    $surname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
    $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
    $avenue = filter_var($_POST['avenue'], FILTER_SANITIZE_STRING);

    $sqlStatement = "";
    $sqlStatement1 = "";
    $msg = 0;
    if ($nb == 1) {
        $sqlStatement = "UPDATE client c,compladresse a SET  a.VILLE='$city',a.AVENUE='$avenue',a.COMPL='$address1',c.TEL='$phone', c.PRENOM='$firstName', c.NOM='$surname'WHERE c.COMPLADRESSE_IDCOMPLADRESSE=a.IDCOMPLADRESSE 
            AND a.IDCOMPLADRESSE AND c.IDCLIENT =$uid";
    } else {
        echo "<script>console.log('dd')</script>";
        $newID = generateMax('COMPLADRESSE', 'IDCOMPLADRESSE');
        $sqlStatement = "INSERT INTO compladresse VALUES ($newID,'$avenue', '$city','$address1')";
        $sqlStatement1 = "UPDATE client SET TEL='$phone', PRENOM='$firstName', NOM='$surname',COMPLADRESSE_IDCOMPLADRESSE=$newID WHERE IDCLIENT=$uid";
    }

    $queryResult = connect()->query($sqlStatement);
    if ($queryResult1 != "") {
        $queryResult1 = connect()->query($sqlStatement1);
    }
    if ($msg == 1) {
        header("location: edit-address.php?message=warning");

    }

    // Check that all the required details have been completed in the form.
    if (!empty($firstName) && !empty($surname) && !empty($address1) && !empty($city) && !empty($phone)) {
        // Update or Insert the Address details by saving the data to MySQL.
        if ($queryResult == TRUE) {
            header("location: edit-address.php?message=success");
        } else {
            header("location: edit-address.php?message=error");
        }
    } else {
        // echo "<script>alert('des erreurs ont été detectés lors de la modification,veuillez remplir tous les champs ci-dessous et essayer une autre fois')</script>";
        header("location: edit-address.php?message=warning");
    }
}
ob_flush();
?>
<section id="content">
    <div class="content-blog">
        <div class="page_header text-center">
            <p><?php echo getenv('STORE_TAGLINE'); ?></p>
        </div>
        <form method="post" action="edit-address.php">
            <div class="container">
                <?php if (isset($_GET['message'])) : ?>
                    <div class="row">
                        <?php if ($_GET['message'] == 'success') : ?>
                            <div class="col-sm-12">
                                <h3 class="uppercase text-center">Info</h3>
                                <br>
                                <div class="alert alert-success text-center" role="alert">
                                    <?php echo "félicitations, on a réussi à modifier vos informations."; ?>
                                </div>
                            </div>
                        <?php elseif ($_GET['message'] == 'error') : ?>
                            <div class="col-sm-12">
                                <h3 class="uppercase text-center">erreur</h3>
                                <br>
                                <div class="alert alert-danger text-center" role="alert">
                                    <?php echo "erreur lors de la modification"; ?>
                                </div>
                            </div>
                        <?php elseif ($_GET['message'] == 'warning') : ?>
                            <div class="col-sm-12">
                                <br>
                                <div class="alert alert-warning text-center" role="alert">
                                    <?php echo "informations modifiés, mot de passe erroné"; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="billing-details">
                            <h3 class="uppercase">Modifier mes informations personnelles</h3>
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
                            <div class="clearfix space20"></div>
                            <div class="space30"></div>
                            <input type="submit" class="button btn-md" value="Modifier">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="clearfix space20"></div>

        <form method="post" action="edit-password.php">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="billing-details">
                        <h3 class="uppercase">Modifier mon mot de passe</h3>
                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <label>Mot de passe <i style="color:tomato;">*</i></label>
                                <input name="passwd" class="form-control" placeholder="" value="" type="password" required>
                            </div>
                            <div class="col-md-5">
                                <label>Confirmer mot de passe <i style="color:tomato;">*</i></label>
                                <input name="cpasswd" class="form-control" placeholder="" value="" type="password" required>
                            </div>
                            <div class="col-md-2">
                                <label>.</label>
                                <input type="submit" class="button btn-md" value="changer mdp" >
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php include 'inc/footer.php'; ?>
