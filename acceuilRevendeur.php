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
include 'inc/navRevendeur.php';
session_start();
if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
    header('location: speciaLogin.php');
}

?>
<div  class="col-md-3" ></div>
<div  class="col-md-6" >
    <form class="logregform" >
        <h3 class="heading text-center"> EMAIL :<?php echo $_SESSION['email']?>  </h3>
        <h3 class="heading text-center"> NOM :<?php echo $_SESSION['nom']?>  </h3>
    </form>
</div>
<div class="clearfix space90"></div>
<div class="clearfix space90"></div>


<?php include 'inc/footer.php'; ?>
