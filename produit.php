<?php
/**
 * Advanced PHP 7 eCommerce Website (https://22digital.agency)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 *
 * @copyright Copyright (c) 22 Digital (https://22digital.agency)
 * @copyright Copyright (c) Justin Hartman (https://justinhartman.blog)
 * @author    Justin Hartman <justin@hartman.me> (https://justinhartman.blog)
 * @link      https://github.com/justinhartman/complete-php7-ecom-website GitHub Project
 * @since     0.1.0
 * @license   https://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 */

/**
 * Load the bootstrap file.
 */
//require '/electro/config/bootstrap.php';

/**
 * Load the template files.
 */
include 'inc/header.php';
include 'inc/navAdmin.php';
session_start();
if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
    header('location: speciaLogin.php');
}

?>

<!-- SHOP CONTENT -->
<section id="content" >
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h1>Produit</h1>
                   <!-- <p><?php echo getenv('STORE_TAGLINE'); ?></p> -->
                </div>
                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button type="submit" class="button" onclick="ajouterProduit()">ajouter </button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button type="submit" class="button " onclick="produitStock()">stock/produit </button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button type="submit" class="button  " onclick="modifierProduit()">modifier </button>
                    </div>
                </div>
                <div id="ajouterProduit" class="col-md-12" hidden>

                                <form  id="ajouterform"class="logregform" >

                                    <h3 class="heading text-center">Ajouter un nouveau produit</h3>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>libellé</label>
                                                <input type="text" name="libelle1"  id="libelle1" value="" class="form-control">
                                            </div>
                                                <div class="col-md-6">
                                                    <label>description</label>
                                                    <input type="text" name="description1" id="description1" value="" class="form-control">
                                                </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Marque</label>
                                                <select  name="marque1" id="marque1" class="form-control" >
                                                    <
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                    <label>categorie</label>
                                                    <select  id="categorie1" name="categorie1"  class="form-control" >

                                                    </select>
                                            </div>
                                            </div>
                                            </div>
                                    <div class="clearfix space20"></div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-2"> </div>
                                            <div class="col-md-3"> les proprietés :</div>
                                            <div class="col-md-1">
                                                <button type="button"  class="button btn-md " onclick="addPropLigne()">+ </button>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button"  class="button btn-md " onclick="minusPropLigne()">- </button>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group" id="propriete"> </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                        <div class="col-md-push-6"></div>
                                        <div class="col-md-push-6 ">
                                            <label>choisir Image</label>
                                            <input type="file" name="file" id="file"  />
                                            <br />
                                            <span id="uploaded_image"></span>
                                            <button  type="button" class="button" onclick="createproduit()">ajouter </button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    </div>
                                </form>


                </div>

                <div id="modifierProduit" class="col-md-12" hidden>


                    <form  id="modifierform" class="logregform"  >
                        <h3 class="heading text-center">choisir le produit</h3>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label>Marque</label>
                                    <select  id="marque2"   onchange="updateListProduit(2)"  class="form-control">

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>categorie</label>
                                    <select    id="categorie2"  onchange="updateListProduit(2)"   class="form-control">

                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>produit</label>
                                    <select  id="produit2"  onchange="showProduct()" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix space20"></div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3">
                                <button onclick="mod1()"  type="button" class="button">modifier le produit </button>
                                <div class="space20"></div>
                            </div>
                            <div class="col-md-3">
                                <button onclick="mod2()" type="button"class="button">modifier ses props </button>
                                <div class="space20"></div>
                            </div>
                            <div class="col-md-3">

                            </div>


                        </div>
                        <div class="clearfix space20"></div>
                        <div class="clearfix space20"></div>
                        <div class="clearfix space20"></div>
<div id="div1" hidden>
                        <h3 class="heading text-center">modifier un produit</h3>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>ancien libellé</label>
                                    <input type="text"  disabled id="oldlibelle2" value="" class="form-control">
                                    <label> aniceienncedescription</label>
                                    <input type="text" disabled id="olddescription2" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label> nouveau libellé</label>
                                    <input type="text"  id="libelle2" value="" class="form-control">
                                    <label>  nouvelle description</label>
                                    <input type="text" id="description2" value="" class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="clearfix space20"></div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <button type="button" onclick="updateProduit()" class="button btn-md ">valider la modification  </button>
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                        </div>
</div>
                        <div class="clearfix space30"></div>
                        <div id="div2" hidden>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                      <link> <h2 class="heading text-center">modifier ses proprietés</h2></link>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>

                            <div id="propPlace" ></div>

                        </div>

                    </form>


                </div>


                <div id="produitStock" class="col-md-12" hidden>


                    <form id="produitStockform" class="logregform"  >
                        <h3 class="heading text-center">produit stock</h3>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label>Marque</label>
                                    <select  id="marque3"  onchange="updateListProduit(3)"   value="" class="form-control">

                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>categorie </label>
                                    <select  id="categorie3"  onchange="updateListProduit(3)" value="" class="form-control">

                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>produit</label>
                                    <select  id="produit3" onchange="check1()" value="" class="form-control">

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label>revendeur</label>
                                    <select  id="revendeur3" onchange="check1()" value="" class="form-control">

                                    </select>
                                </div>
                                    <div class="col-md-4">
                                        <label>nombre de quantité stock</label>
                                        <input type="number" name="quantite"  id="quantite"value="" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label>prix unitaire</label>
                                        <input type="number" name="prix" id="prix" value="" class="form-control">
                                    </div>
                                </div>

                            </div>
                        <div class="clearfix space20"></div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <button id="btnProduitStock"   type="button" class="button btn-md " onclick="produitStockBtn()" hidden>remplir les données  </button>
                                </div>
                                <div class="col-md-5"></div>
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
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>

<div class="clearfix space90"></div>

<?php include 'inc/footer.php'; ?>


