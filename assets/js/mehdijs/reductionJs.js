function create(){

    var montant=$( "#reduction1 option:selected" ).val();
    var nb=$( "#nb" ).val();
    if (nb==""){
        alert("ajoutez le nombre de coupons voulues");
    }
    else {
        $.ajax({
            url: '/electro/controller/ReductionController.php', // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: {method: 'createCoupon', nb: nb, MONTANTREDUCTION: montant},

            success: function (data) {
if(data>0) {
    alert("creation validée");
    $("#nb").val(" ");
}
else {
    alert("creation non  validée");}
            },
            error: function (data) {
                alert("error");
                console.log("error");
            }
        });
    }
    // }
    //else console.log("dzzti");
}
function find(){

    var montant=$( "#reduction2 option:selected" ).val();
    var nb=$("input[name='utilise']:checked").val();


        $.ajax({
            url: '/electro/controller/ReductionController.php', // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: {method: 'findReductions',  MONTANTREDUCTION: montant,UTILISE:nb},

            success: function (data) {

                createReductions(data)
            },
            error: function (data) {
                alert("error");
                console.log("error");
            }
        });

    // }
    //else console.log("dzzti");
}
function createReductions(data){
    $("#reductionTable").html(" ");

    var objs = JSON.parse(data);
    if(objs.reductions!=0){
    for (var i = 0; i < objs.reductions.length; i++) {
       reference=objs.reductions[i].REFERENCE;
       montant=objs.reductions[i].MONTANTREDUCTION;
       utilise=objs.reductions[i].UTILISE;
       var st="";
       if (utilise==1) st="utilisé";
       else st="non utilisé" ;
        var d = "<tr>\n" +
            "<th>"+reference+"</th>\n" +
            "<th>"+montant+"</th>\n" +
            "<th>"+st+"</th>\n" +
            "\n" +
            "</tr>";
 $("#reductionTable").append(d);
    }
}
    else {
        $("#reductionTable").append("pas de coupon avec ce recherche");

    }
}