<?php
include 'inc/header.php';
?>
    <div class="clearfix space40"></div> <div class="clearfix space40"></div>
    <section id="content">
        <div class="content-blog">
            <div class="container">
                <div class="row">
                    <div class="page_header text-center">
                        <h2>Connexion</h2>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <button type="button" class="button" onclick="rev()">Revendeur </button>
                        </div>

                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <button type="button" class="button" onclick="admin()">Admin </button>
                        </div>
                    </div>
                    <div  class="clearfix space90"></div>
                    <?php if (isset($_GET['message'])) {
                        if ($_GET['message'] == 1) {
                            ?><div class="alert alert-danger" role="alert"><?php echo "Desolé, On n'a pas pu vous connecté avec cette combinaison d'email et mot de passe."; ?> </div>
                            <?php
                        } else if ($_GET['message'] == 3) {
                            ?><div class="alert alert-danger" role="alert"><?php echo "cet email, n'est pas enregistrer dans notre système."; ?></div>
                            <?php
                        }
                    } ?>
                    <div id="platforme"  hidden class="col-md-12">
                        <div class="row shop-login">
                            <div class="col-md-3"> </div>
                            <div class="col-md-6">
                                <div class="box-content">
                                    <h3 id="title" class="heading text-center"></h3>
                                    <div class="clearfix space40"></div>


                                    <form class="logregform" method="post" action="speciaLoginprocess.php">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Adresse E-mail</label>
                                                    <input type="email" name="email" value="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix space20"></div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Mot de passe</label>
                                                    <input type="password" name="password" value="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix space20"></div>
                                        <div class="row">


                                            <input id="type" hidden type="text"  name="type" value="" >
                                            <div class="col-md-6">
                                                <button type="submit" class="button btn-md pull-right">se connecter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix space90"></div>

    <div class="clearfix space90"></div>
<?php include 'inc/footer.php'; ?>