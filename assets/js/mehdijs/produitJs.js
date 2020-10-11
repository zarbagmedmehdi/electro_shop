var addProp=0;

function ajouterProduit(){
$("#ajouterProduit").show();
    $("#modifierProduit").hide();
    $("#produitStock").hide();


}
function updateProduit(){
    var oldlib=$("#oldlibelle2").val();
    var olddesc=$("#olddescription2").val();
    var newlib=$("#libelle2").val();
    var newdesc=$("#description2").val();
    var produit=$( "#produit2 option:selected" ).val();
    if(produit==null){
        alert("choisi un produit");
    }
    else if
    ( newlib=="" && newdesc==""){
        alert(" formulaire vide");
    }
   else if(oldlib==newlib || newdesc==olddesc){
       alert("valeurs  similatire");
   }


   else {

       $.ajax({
           url: '/electro/controller/ProduitController.php', // La ressource ciblée
           type: 'POST', // Le type de la requête HTTP.
           data: {
               method: 'updateproduit', DESCRIPTION: newdesc, LIBELLE: newlib,
                id: produit,
           },

           success: function (data) {
               var res = data;

               if (res > 0) {
                  alert("modifcation validé");
                   $('#modifierform').trigger("reset");
               } else
                   alert("modifcation non validé ");
           },
           error: function (data) {
               alert("error");
               console.log("error");
           }
       });

   }
}


function createproduit(){

    var idprod=0;
    var idprop=1;
   var lib=$("#libelle1").val();
     var desc=$("#description1").val();
    var marque=$( "#marque1 option:selected" ).val();
   var categorie=$( "#categorie1 option:selected" ).val();
    $.ajax({
        url: '/electro/controller/ProduitController.php', // La ressource ciblée
        type: 'POST', // Le type de la requête HTTP.
        data: {method: 'createproduit', DESCRIPTION: desc, LIBELLE: lib,
            CATEGORIE_IDCATEGORIE: categorie, MARQUE_IDMARQUE: marque },

        success: function (data) {
            idprod=data;
if (idprod>0) {
    uploadPhoto();
    createProps(idprop,addProp,idprod);
    $('#ajouterform').trigger("reset");
    alert("produit enregistré");
}
else
            alert("produit non enregistré ");
        },
        error: function (data) {
            alert("error");
            console.log("error");
        }
    });
}
function uploadPhoto(){
    var name = document.getElementById("file").files[0].name;
    var form_data = new FormData();
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
    {
        alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("file").files[0]);
    var f = document.getElementById("file").files[0];
    var fsize = f.size||f.fileSize;
    if(fsize > 2000000)
    {
        alert("Image File Size is very big");
    }
    else
    {
        form_data.append("file", document.getElementById('file').files[0]);
        $.ajax({
            url:"/electro/service/upload.php",
            method:"POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(){
                $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
            },
            success:function(data)
            {
                $('#uploaded_image').html(data);
            }
        });
    }

}

function createProps(idprop,addProp,idprod){
    console.log('idprod>0');
    var i=1;
    while (i<=addProp && idprop>0 ){
        console.log('ha lprop'+i);

        libelleProp=$('#libelleProp'+i).val();
        typeProp=$("#typeProp"+i).val();
        valeurProp=$("#valeurProp"+i).val();
        console.log(libelleProp+" "+typeProp+""+valeurProp);
        $.ajax({
            async :false,
            url: '/electro/controller/ProduitController.php', // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: {method: 'createPropriete', LIBELLE:libelleProp, TYPEPROPRIETE:typeProp, VALEURPROPRIETE:valeurProp, PRODUIT_IDPRODUIT:idprod},

            success: function (data) {
                console.log("success createprop ");
                idprop=data;
                if (idprop==0) {
                    console.log('daz' + libelleProp);
                    alert("les proprieté non pas ete enregistré  ");
                }
                else      console.log('daz'+libelleProp);

            },
            error: function (data) {
                alert("error");
                console.log("error");
            }
        });
i++;
    }

}

function check1(){

    var idProduit=$( "#produit3 option:selected" ).val();
    var idRevendeur=$( "#revendeur3 option:selected" ).val();
        $.ajax({
            url: '/electro/controller/ProduitController.php', // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: {method: 'check1', PRODUIT_IDPRODUIT: idProduit, REVENDEUR_IDREVENDEUR: idRevendeur},

            success: function (data) {
                $("#btnProduitStock").text(data);

            },
            error: function (data) {
                alert("error");
                console.log("error");
            }
        });
   // }
    //else console.log("dzzti");
}

function produitStockBtn(){
    var idProduit=$( "#produit3 option:selected" ).val();
    var idRevendeur=$( "#revendeur3 option:selected" ).val();
    var prix=$( "#prix" ).val();
    var quantite=$("#quantite").val();
    $.ajax({
        url : '/electro/controller/ProduitController.php', // La ressource ciblée
        type : 'POST', // Le type de la requête HTTP.
        data: {method: 'prodstockcheck', PRIXUNITAIRE: prix, QTESTOCK:quantite,PRODUIT_IDPRODUIT:idProduit,REVENDEUR_IDREVENDEUR:idRevendeur},

        success:function(data){
            alert(data);
            $( "#prix" ).val("");
            $("#quantite").val("");
            $("#produit3").empty();
            $("#btnProduitStock").text("remplir les donnée");
            console.log("suc");
            $('#produitStockform').trigger("reset");

        },
        error:function(data){
            alert("error");
            console.log("error");
        }
    });
}
function updateListProduit(val){
    //var idcat=$( "#produit"+val).value;
    //  var idMarque=$( "#marque"+val).value;
   var idcat=$( "#categorie"+val).find(":checked").val();
    var idMarque=$( "#marque"+val).find(":checked").val();
    $.ajax({
        url : '/electro/controller/ProduitController.php', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data: {method: 'findByCriteriaProduit', MARQUE_IDMARQUE: idMarque, CATEGORIE_IDCATEGORIE:idcat},

        success:function(data){
            createOptionProduits(data,"produit"+val);
            if (val==2) {

            }
            console.log("suc");
        },
        error:function(data){
            alert(data);
            console.log("error");
        }
    });
}
$( "#content" ).ready(function() {

    $.ajax({
        url : '/electro/controller/ProduitController.php', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data :  {"method":"findAllMarque"},

        success:function(data){

            createOptionMarques(data,"marque1");
            createOptionMarques(data,"marque2");
            createOptionMarques(data,"marque3");
            console.log("suc");
        },
        error:function(data){
            alert(data);
            console.log("error");
        }
    });
    $.ajax({
        url : '/electro/controller/ProduitController.php', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data :  {"method":"findAllCategorie"},

        success:function(data){

           createOptionCategories(data,"categorie1");
            createOptionCategories(data,"categorie2");
            createOptionCategories(data,"categorie3");

        },
        error:function(data){
            alert(data);
            console.log("error");
        }
    });
    $.ajax({
        url : '/electro/controller/ProduitController.php', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data :  {"method":"findAllRevendeur"},

        success:function(data){
createOptionRevendeur(data,"revendeur3");
        },
        error:function(data){
            alert(data);
            console.log("error");
        }
    });




});

function showProduct(){
    var id=$( "#produit2").find(":checked").val();

    $.ajax({
        url : '/electro/controller/ProduitController.php', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data :  {"method":"findProduit","id":id},

        success:function(data){

            var obj = jQuery.parseJSON(data);

            var produit = obj['produit'];
            console.log(obj['produit']);
            $("#olddescription2").val(obj['produit'].DESCRIPTION);
            $("#oldlibelle2").val(obj['produit'].LIBELLE);
            $("#description2").val("");
            $("#libelle2").val("");
            console.log("9bel");
            getProps(obj['produit'].IDPRODUIT);

        },
        error:function(data){
            alert(data);
            $("#olddescription2").val("");
            $("#oldlibelle2").val("");
            console.log("error");
        }
    });
}
function modifierProduit(){
    $("#modifierProduit").show();
    $("#ajouterProduit").hide();
    $("#produitStock").hide();
}
function produitStock(){
    $("#produitStock").show();
    $("#modifierProduit").hide();
    $("#ajouterProduit").hide();
}
function minusPropLigne(){
    $("#prop"+addProp ).remove();
    addProp--;
}
function addPropLigne(){
    addProp++;

    var d="<div  id='prop"+addProp +"' class=\"row\">\n" + "<label>   proprieté N :"+addProp+" </label>"+
        "<div   class=\"form-group\">\n" +

        "<div class=\"col-md-3\">\n" +

        "<label>libelle proprieté</label>\n" +
        "<input type='text' id='libelleProp"+addProp +"' class='form-control'>" +
        "</div>\n" +
        "<div class=\"col-md-3\">\n" +
        "<label>type Proprieté</label>\n" +
        "<input type='text' id='typeProp"+addProp+"' class=\"form-control\">\n" +
        "                                </div>\n" +
        "                                <div class=\"col-md-3\">\n" +
        "                                    <label>valeur proprieté</label>\n" +
        "                                    <input type='text' id='valeurProp"+addProp+"' class=\"form-control\">\n" +
        "                                </div>\n" +

        "                            </div>\n" +
        "                        </div>"
$("#propriete").append(d);
}


 function getProps(id){
     console.log("getProps");
     $.ajax({

         url : '/electro/controller/ProduitController.php', // La ressource ciblée
         type : 'GET', // Le type de la requête HTTP.
         data :  {"method":"findPropsOfProduit","PRODUIT_IDPRODUIT":id},

         success:function(data){
             var objs = JSON.parse(data);

             if (objs.props!=null) {
                 $("#propPlace").empty();

                 createPropLigne(data);
             }
             else {
                 $("#propPlace").empty();
                 $("#propPlace").append("<p> pas de proprieté pour ce produit</p>");
             }

         },
         error:function(data){
             alert(data);

             console.log("error get Props");
         }
     });
 }
 function btnupdate(id){
    var val=$("#newvaleurProp"+id).val();
     console.log("getProps");
     $.ajax({

         url : '/electro/controller/ProduitController.php', // La ressource ciblée
         type : 'POST', // Le type de la requête HTTP.
         data :  {"method":"updatepropriete","IDPROPRIETE":id,"VALEURPROPRIETE":val},

         success:function(data){
            if(data==1){
                alert("propriété modifié");
                $("#newvaleurProp"+id).val(" ");
                $("#valeurProp"+id).val(val);
            }

             else {
                alert(data);
             }

         },
         error:function(data){
             alert(data);

             console.log("error get Props");
         }
     });

 }
function createPropLigne(data) {
    var objs = JSON.parse(data);
    for (var i = 0; i < objs.props.length; i++) {
        j=i+1;
var id=objs.props[i].IDPROPRIETE;
var libelle=objs.props[i].LIBELLE ;
var type=objs.props[i].TYPEPROPRIETE ;
var valeur=objs.props[i].VALEURPROPRIETE ;


        var d = "<div  id='prop" + id + "' class=\"row\">\n" + "<label>   proprieté N :" + j + " </label>" +
            "<div   class=\"form-group\">\n" +

            "<div class=\"col-md-2\">\n" +

            "<label>libelle proprieté</label>\n" +
            "<input type='text' disabled id='libelleProp" + id + "' value='"+libelle+"' class='form-control'>" +
            "</div>\n" +
            "<div class=\"col-md-2\">\n" +
            "<label>type Proprieté </label>\n" +
            "<input type='text' disabled id='typeProp" + id + "'  value='"+type+"' class=\"form-control\">\n" +
            "</div>\n" +
            "<div class=\"col-md-2\">\n" +
            "<label>valeur proprieté</label>\n" +
            "<input type='text' disabled id='valeurProp" + id + "' value='"+valeur+"' class=\"form-control\">\n" +
            "</div>\n" +
            "<div class=\"col-md-2\">\n" +
            "<label>valeur proprieté</label>\n" +
            "<input type='text'  id='newvaleurProp" + id + "'  class=\"form-control\">\n" +
            "</div>\n" +
            "<div class=\"col-md-3\">\n" +
            "                                    <button  type='button' onclick='btnupdate(" + id + ")' id='btn" + id + "'  class=\"button  \">modifier la proprieté </button>\n" +
            "                                </div>"+

            "</div>\n" +
            "</div>"
        $("#propPlace").append(d);
    }
}


function createOptionMarques(data,selector){
    var objs=JSON.parse(data);
    $("#"+selector).append("<option  ></option>");
    for(var i=0;i<objs.marques.length;i++){
      var str=  "<option    value="+objs.marques[i].IDMARQUE+">"+objs.marques[i].LIBELLE+ "</option>";
$("#"+selector).append(str);
    }}

    function createOptionCategories(data,selector){
        var objs=JSON.parse(data);
        $("#"+selector).append("<option  ></option>");

        for(var i=0;i<objs.categories.length;i++){
            var str=  "<option    value="+objs.categories[i].IDCATEGORIE+">"+objs.categories[i].CATLIBELLE+ "</option>";
            $("#"+selector).append(str);
        }}

        function createOptionRevendeur(data,selector) {
            var objs = JSON.parse(data);
            $("#"+selector).append("<option  ></option>");

            for (var i = 0; i < objs.revendeurs.length; i++) {
                var str = "<option    value=" + objs.revendeurs[i].IDREVENDEUR + ">" + objs.revendeurs[i].NOM + "</option>";
                $("#" + selector).append(str);
            }
        }
function createOptionProduits(data,selector) {
    var objs = JSON.parse(data);
    $("#" + selector).empty();
  //  $("#" + selector).val("");

    if (objs.produits!=null) {
    for (var i = 0; i < objs.produits.length; i++) {
        var str = "<option    value=" + objs.produits[i].IDPRODUIT + ">" + objs.produits[i].LIBELLE + "</option>";
        $("#" + selector).append(str);
    }
}
}
function mod1(){
    $("#div1").toggle();
    $("#div2").hide();
}
function mod2(){
    $("#div2").toggle();
    $("#div1").hide();
}