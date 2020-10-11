//fonctions de verification
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validate() {
    //alert("hello");
    var sEmail = $('#email').val();
    if ($.trim(sEmail).length == 0 || !validateEmail(sEmail)) {
        $("#errE").show();
    } else {
        $("#errE").hide();
    }

    if ($('#mdp').val() === "") {
        $("#errM").show();
    } else {
        $("#errM").hide();
    }
}


//fonctions des bouttons d'affichage des formulaires
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ajouterRevendeur() {
    $("#ajouterRevendeur").show();
    $("#modifierRevendeur").hide();
    $("#supprimerRevendeur").hide();
}

function modifierRevendeur() {
    $("#modifierRevendeur").show();
    $("#ajouterRevendeur").hide();
    $("#supprimerRevendeur").hide();
    $(".rechercherRevendeur").show();
    alert("HEllO");
    $(".modifierRevendeur").hide();
}

function supprimerRevendeur() {
    $("#supprimerRevendeur").show();
    $("#modifierRevendeur").hide();
    $("#ajouterRevendeur").hide();
    $('#checkbox').attr('checked', false);
}

//fonctions de modif, ajout, recherche et suppression
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function addRevendeur() {
    var nom = $('#ajouterRevendeur #nom').val();
    var tel = $('#ajouterRevendeur #tel').val();
    var email = $('#ajouterRevendeur #email').val();
    var password = $('#ajouterRevendeur #password').val();
    var adresse = $('#ajouterRevendeur #adresse').val();
    var revendeurdescription = $('#ajouterRevendeur #revendeurdescription').val();

    $.ajax({
        url: '/electro/service/revendeurService.php', // La ressource ciblée
        type: 'Post', // Le type de la requête HTTP.
        data: { "method": "addRevendeur", "nom": nom, "tel": tel, "email": email, "password": password, "adresse": adresse, "revendeurdescription": revendeurdescription },

        success: function(data) {
            $('#ajouterRevendeur #nom').val("");
            $('#ajouterRevendeur #tel').val("");
            $('#ajouterRevendeur #email').val("");
            $('#ajouterRevendeur #password').val("");
            $('#ajouterRevendeur #adresse').val("");
            $('#ajouterRevendeur #revendeurdescription').val("");
        },
        error: function(data) {
            alert(data);
            console.log("error");
        }
    });
}

function searchRevendeur() {
    var nom = $('#modifierRevendeur #nom').val();
    $.ajax({
        url: '/electro/service/revendeurService.php', // La ressource ciblée
        type: 'Post', // Le type de la requête HTTP.
        data: { "method": "searchRevendeur", "nom": nom },

        success: function(data) {

            var obj = jQuery.parseJSON(data);
            var revendeur = obj['revendeur'];
            //console.log(obj['revendeur'].a);

            $('#modifierRevendeur #tel').val(revendeur.t);
            $('#modifierRevendeur #email').val(revendeur.e);
            $('#modifierRevendeur #password').val(revendeur.p);
            $('#modifierRevendeur #adresse').val(revendeur.a);
            $('#modifierRevendeur #revendeurdescription').val(revendeur.rd);

            $(".modifierRevendeur").show();
            $(".rechercherRevendeur").hide();
        },
        error: function(data) {
            $(".modifierRevendeur").hide();
            $(".rechercherRevendeur").show();
        }
    });
}


function modifyRevendeur() {

    var nom = $('#modifierRevendeur #nom').val();
    var tel = $('#modifierRevendeur #tel').val();
    var email = $('#modifierRevendeur #email').val();
    var password = $('#modifierRevendeur #password').val();
    var adresse = $('#modifierRevendeur #adresse').val();
    var revendeurdescription = $('#modifierRevendeur #revendeurdescription').val();

    $.ajax({
        url: '/electro/service/revendeurService.php', // La ressource ciblée
        type: 'Post', // Le type de la requête HTTP.
        data: { "method": "modifyRevendeur", "nom": nom, "tel": tel, "email": email, "password": password, "adresse": adresse, "revendeurdescription": revendeurdescription },

        success: function(data) {
            $(".modifierRevendeur").hide();
            $(".rechercherRevendeur").show();
            $('#modifierRevendeur #nom').val("");
        },
        error: function(data) {
            $(".modifierRevendeur").show();
            $(".rechercherRevendeur").hide();
        }
    });
}


function checkedChanged() {
    // ($(".checkbox").is(':checked')) ? $(".delete").hide(): $(".delete").show();
    var checkbox = document.getElementById('checkbox');
    var div = document.getElementById('delete');
    if (checkbox.checked = true) {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
}


function deleteRevendeur() {
    var nom = $('#supprimerRevendeur #nom').val();
    $('#checkbox').attr('checked', false);
    $.ajax({
        url: '/electro/service/revendeurService.php', // La ressource ciblée
        type: 'Post', // Le type de la requête HTTP.
        data: { "method": "deleteRevendeur", "nom": nom },

        success: function(data) {
            $('#supprimerRevendeur #nom').val("");
        },
        error: function(data) {
            alert(data);
            console.log("error");
        }
    });
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////