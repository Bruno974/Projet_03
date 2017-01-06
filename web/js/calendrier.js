$(function() {

    $('.js-datepicker').datepicker({
        todayBtn: "linked",
        language: "fr",
        daysOfWeekDisabled: "2",
        todayHighlight: true,
        autoclose: true,
        beforeShowDay: dateDesactive
    });

   /* $('.js-datepicker').css('font-size','1.3em').css('padding-left', '150px');*/

    function dateDesactive(date)
    {
        var jour = new Date().getDate(); //Récupère le jour en cours
        var mois = (new Date().getMonth()) + 1; //Récupère le mois en cours (+1 car Janvier = 0, donc de 0 à 11)
        var annee = (new Date().getYear() - 100) + 2000; ////Récupère l'année en cours, valeur 116, donc il faut calculer pour avoir le format  année

        if((date.getDate() == 25) && (date.getMonth() == 11)) //jour férié 25/12
        {
            return false;
        }

        if((date.getDate() == 1) && (date.getMonth() == 10)) //jour férié 01/11
        {
            return false;
        }

        if((date.getDate() == 1) && (date.getMonth() == 4)) ////jour férié 01/05
        {
            return false;
        }

        if ((date.getMonth() == (new Date()).getMonth()) && (date.getYear() == (new Date()).getYear())) // Désactive les jours inférieur a la date aujourd'hui et ds le mois
        {
            for(var i=date.getDate(); i<jour; i++)
            {
                return false;
            }
        }
        else if((date.getMonth() < (new Date()).getMonth()) && (date.getYear() == (new Date().getYear()))) // Désactive les jours des mois précédent la date aujourd'hui, mais pas les mois suivants
        {
            return false;
        }
    }

    /*-----------------------Récupère la date pour afficher ds le récapitulatif----------------------*/
  $('#gb_testbundle_visite_dateVisite').change(function () {
      var valDate = $('#gb_testbundle_visite_dateVisite').val();
      $('.modifDate').html(valDate);



      /*---Récupére l'heure courante---*/
      var now = new Date();
      var heure = now.getHours();

      /*---Créer la date du jour--------*/
      var annee = now.getFullYear();
      var mois    = ('0'+now.getMonth()+1).slice(-2);
      var jour    = ('0'+now.getDate()   ).slice(-2);

      var valDate = $('#gb_testbundle_visite_dateVisite').val();
      var date = jour + '.'  + mois + '.' + annee;

      if(valDate === date)
      {
          if(heure >= 14)// Si heure supérieur à 14h00
          {
              /*---Désactive le bouton journée---*/
              $('#gb_testbundle_visite_momentVisite_0').attr('checked', false);//Empêche de cocher la case
              $('#gb_testbundle_visite_momentVisite_0').attr('disabled', 'disabled'); //désactiver le bouton

              /*---Coche le bouton Demi-journée---*/
              $('#gb_testbundle_visite_momentVisite_1').attr('checked', true);
              $('.modifMoment').html('Demi-Journée');

              /*---Affiche l'erreur---*/
              $('#erreur').css('display', 'block');
          }
      }
      else
      {
          $('#gb_testbundle_visite_momentVisite_0').attr('checked', true);
          $('#gb_testbundle_visite_momentVisite_0').attr('disabled', false); //permet de réafficher le bouton ds le cas d'un retour sur la date
          $('#gb_testbundle_visite_momentVisite_1').attr('checked', false);
          //$('.modifMoment').html('Journée');//Affiche journée ds le récapitulatif
          $('#erreur').css('display', 'none');
      }

  });
    /*--------------------------------------------------------------------------------------*/

    /*-----------------------Récupère le moment pour afficher ds le récapitulatif----------------------*/
    $('#gb_testbundle_visite_momentVisite_0').click(function(){


        $('.modifMoment').html('Journée');
       /* alert (date);

        if(heure >= 14)// Si heure supérieur à 14h00
        {
            $('#gb_testbundle_visite_momentVisite_0').attr('checked', false);//Empêche de cocher la case
            $('#gb_testbundle_visite_momentVisite_0').attr('disabled', 'disabled'); //désactiver le bouton
            $('#erreur').css('display', 'block');
        }
        else
        {
            $('.modifMoment').html('Journée');//Affiche journée ds le récapitulatif
        }*/

    });

    $('#gb_testbundle_visite_momentVisite_1').click(function(){
        $('.modifMoment').html('Demi-Journée');
        $('#erreur').css('display', 'none');
    });

    /*-----------------------Récupère le nbre visiteur pour afficher ds le récapitulatif----------------------*/
    $('#gb_testbundle_visite_nbreVisiteur').change(function(){
        $('.modifNbreVisiteur').html( $('#gb_testbundle_visite_nbreVisiteur').val());
    });
});
