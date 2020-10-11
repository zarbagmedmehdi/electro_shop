<?php
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
<section id="content">
    <div class="content-blog">
        <div class="container">
            <div class="row">
                <div class="page_header text-center">
                    <h1>Reduction coupon</h1>

                </div>

                    <div class="row shop-login">
                        <div class="col-md-12">
                            <div class="box-content">
                                <div class="clearfix space40"></div>

                                <form class="logregform"  >
                                    <h3 class="heading text-center">creation coupons</h3>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label>montant reduction</label>
                                                <select  name="reduction1" id="reduction1" class="form-control">
                                                    <option value="100">100DH</option>
                                                    <option value="150">150DH</option>
                                                    <option value="200">200DH</option>
                                                    <option value="300">300DH</option>
                                                    <option value="500">500DH</option>

                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label>nombre de coupons</label>
                                                <input type="number" id="nb"  name="nombre" value="" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" onclick="create()" class="button btn-md ">creer les coupons</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix space20"></div>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="box-content">
                                <div class="clearfix space40"></div>

                                <form class="logregform" method="post" action="speciaLoginprocess.php">
                                    <h3 class="heading text-center">recherche coupons</h3>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label>montant reduction</label>
                                                <select  id="reduction2" name="reduction2" value="" class="form-control">
                                                    <option value="100">100DH</option>
                                                    <option value="150">150DH</option>
                                                    <option value="200">200DH</option>
                                                    <option value="300">300DH</option>
                                                    <option value="500">500DH</option>

                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>utilié</label>
                                                <input  name="utilise" type="radio" id="valide" value="1" class="radio-inline" />
                                            </div>
                                            <div class="col-md-2">
                                                <label>non utilisé</label>
                                                <input  name="utilise"  type="radio" id="nonvalide" value="0" class="radio-inline" />
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" onclick="find()" class="button btn-md ">chercher les coupons</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix space20"></div>

                                </form>


                                    </div>
                                </div>
                                <table   class="cart-table account-table table table-bordered" >
                                    <thead class="thead-inverse">
                                    <tr>
                                        <th>reference</th>
                                        <th>montant</th>
                                        <th>utilisé/non utilisé</th>

                                    </tr>

                                    </thead>
                                   <tbody id ="reductionTable"></tbody>

                                </table>
                                </table>
                            </div>
                        </div>

                    </div>
    </div>

</section>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>

<?php include 'inc/footer.php'; ?>
