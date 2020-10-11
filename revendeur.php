<?php
include 'inc/header.php';
include 'inc/navAdmin.php';
session_start();
if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
    header('location: speciaLogin.php');
}

?>

<section id="content">
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h1>Revendeur</h1>
                    <!-- <p><?php echo getenv('STORE_TAGLINE'); ?></p> -->
                </div>
                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button type="submit" class="button" onclick="ajouterRevendeur()">Ajouter</button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button type="submit" class="button  " onclick="modifierRevendeur()">Modifier</button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button type="submit" class="button " onclick="supprimerRevendeur()">Supprimer</button>
                    </div>
                </div>

                <div class="clearfix space35"></div>

                <!-- boutton Ajouter -->

                <div id="ajouterRevendeur" class="col-md-6" hidden>
                    <form class="logregform" >
                        <h3 class="heading text-center">Ajouter un nouveau revendeur</h3>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Nom *</label>
                                    <input type="text" name="nom"  id="nom" placeholder="Nom" class="form-control">
                                    <div  id="errN"  class="form-group err" hidden>
                                        Il faut entrer un nom !
                                    </div>
                                </div>
                                <div class="clearfix space20"></div>
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Numéro de téléphone *</label>
                                    <input type="tel" name="tel"  id="tel" placeholder="Numéro de téléphone" class="form-control">
                                    <div  id="errT"  class="form-group err" hidden>
                                        Le numéro de téléphone que vous avez entré est incorrect !
                                    </div>
                                </div>
                                <div class="clearfix space20"></div>
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Email *</label>
                                    <input type="email" name="email"  id="email" placeholder="XXXXXXXX.XXXXXX@XXXX.XX" class="form-control">
                                    <div  id="errE"  class="form-group err" hidden>
                                        L'adresse email que vous avez entré est incorrect !
                                    </div>
                                </div>
                                <div class="clearfix space20"></div>
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Mot de passe *</label>
                                    <input type="password" name="password"  id="password" placeholder="Mot de passe"  class="form-control">
                                    <div  id="errM"  class="form-group err" hidden>
                                        Mot de pass obligatoire!
                                    </div>
                                </div>
                                <div class="clearfix space20"></div>
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Adresse *</label>
                                    <input type="text" name="adresse"  id="adresse" placeholder="Adresse" class="form-control">
                                    <div  id="errA"  class="form-group err" hidden>
                                        Il faut entrer une addresse!
                                    </div>
                                </div>
                                <div class="clearfix space20"></div>
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Déscription du revendeur</label>
                                    <input type="textarea" name="revendeurdescription" id="revendeurdescription" placeholder="Déscription du revendeur" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <button  type="button" class="button btn-md " onclick="addRevendeur()">ajouter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- boutton Modifier -->
                <div class="col-md-3 clearfix space35"></div>

                <div id="modifierRevendeur" class="col-md-6" hidden>
                    <form class="logregform rechercherRevendeur" >
                        <h3 class="heading text-center">Modifier un revendeur</h3>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Nom</label>
                                    <input type="text" name="nom"  id="nom" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <button  type="button" class="button btn-md " onclick="searchRevendeur()">Rechercher</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="logregform modifierRevendeur" hidden>
                        <h3 class="heading text-center">Modifier un revendeur</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <label>&nbsp;&nbsp;&nbsp;Numero de téléphone</label>
                                <input type="tel" name="tel"  id="tel" class="form-control" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
                            </div>
                            <div class="clearfix space20"></div>
                            <div class="col-md-12">
                                <label>&nbsp;&nbsp;&nbsp;Email</label>
                                <input type="email" name="email"  id="email" class="form-control">
                            </div>
                            <div class="clearfix space20"></div>
                            <div class="col-md-12">
                                <label>&nbsp;&nbsp;&nbsp;Mot de passe</label>
                                <input type="password" name="password"  id="password" class="form-control">
                            </div>
                            <div class="clearfix space20"></div>
                            <div class="col-md-12">
                                <label>Adresse</label>
                                <input type="text" name="adresse"  id="adresse" class="form-control">
                            </div>
                            <div class="clearfix space20"></div>
                            <div class="col-md-12">
                                <label>&nbsp;&nbsp;&nbsp;Déscription du revendeur</label>
                                <input type="textarea" name="revendeurdescription" id="revendeurdescription" class="form-control">
                            </div>
                        </div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <button  type="button" class="button btn-md" onclick="modifyRevendeur()">Modifier</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- boutton Supprimer -->
                <div class="col-md-3"></div>

                <div id="supprimerRevendeur" class="col-md-6" hidden>
                    <form class="logregform"  >
                        <h3 class="heading text-center">Supprimer</h3>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>&nbsp;&nbsp;&nbsp;Nom</label>
                                    <input type="text" name="nom"  id="nom" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input id="checkbox" onclick="checkedChanged()" type="checkbox">&nbsp;&nbsp;&nbsp;êtes vous sur de vouloir supprimer cet enregistrement
                                </div>
                                <div class="clearfix space20"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-2 delete"id="delete" style="display:none">
                                    <button  type="button" class="button btn-md" onclick="deleteRevendeur()">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>

<?php include 'inc/footer.php'; ?>


