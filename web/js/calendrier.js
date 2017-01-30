$(function() {
    $('.datePicker').datepicker({
        todayBtn: "linked",
        language: "fr",
        daysOfWeekDisabled: "0,2",
        todayHighlight: true,
        autoclose: true,
        beforeShowDay: dateDesactive
    });

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

        if((date.getDate() == 1) && (date.getMonth() == 4)) //jour férié 01/05
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
    $('#gb_louvrebundle_formulaire_calendrier').change(function () {

        /*---Récupére l'heure courante---*/
        var now = new Date();
        var heure = now.getHours();

        /*---Créer la date du jour--------*/
        var annee = now.getFullYear();
        var mois    = ('0'+now.getMonth()+1).slice(-2);
        var jour    = ('0'+now.getDate()   ).slice(-2);

        var valDate = $('#gb_louvrebundle_formulaire_calendrier').val();//Récupère la valeur de la date.
        var date = jour + '.'  + mois + '.' + annee;//Mets au format la date du jour

        if((valDate === date) && (heure >= 08) )//Compare la date sélectionner et la date du jour et si heure supérieur à 14h00
        {
            $('#gb_louvrebundle_formulaire_duree_0').attr('disabled', 'disabled'); //Désactiver le radio Journée
            $('#gb_louvrebundle_formulaire_duree_0').attr('checked', false); //Decoche la case Journée
            $('#gb_louvrebundle_formulaire_duree_1').attr('checked', true); //Coche la case Demi-journée

            /*---Affiche le message d'information---*/
            $('#erreur').css('display', 'block');

        }
        else
        {
            $('#gb_louvrebundle_formulaire_duree_0').attr('disabled', false); //permet de réactiver le bouton ds le cas d'un nouveau changement sur la date
            $('#gb_louvrebundle_formulaire_duree_1').attr('checked', false); //Décoche la case Demi-Journée
            $('#gb_louvrebundle_formulaire_duree_0').attr('checked', true); //Coche la case Journée

            $('#erreur').css('display', 'none'); //désactive l'erreur
        }

    });

});
