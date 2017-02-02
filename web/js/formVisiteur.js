/**
 * Created by Bruno on 06/01/2017.
 */

    $(function() {

        //Cache le bouton valider lors du chargement de la page
        $('#gb_louvrebundle_formulaire_Valider').css('display', 'none');

        /*gestion ajax pour les 1000 billets*/
        $("#gb_louvrebundle_formulaire_calendrier").change(function(){
            if($(this).val() != "") //Si champs calendrier différent de vide, pour éviter d'avoir un message d'erreur lors de l'ouverture de la page
            {
                $.ajax({
                    url: 'http://localhost/imbriquer/web/app_dev.php/billetterie/formulaire/ajax/' + $(this).val(),
                    success: function(data) {
                        if(data < 980) //Si nombre place disponible = 0
                        {
                            //Efface la date entrer et message erreur
                            $('#Billets').attr('class','alert alert-danger');
                            $('#Billets').html('Plus aucune place de libre, choisissez une autre date');
                            $('#gb_louvrebundle_formulaire_calendrier').val('');

                            /*--------Désactive le bouton ajout de visiteur________*/
                            $('#add_visiteur').off('click');
                        }
                        else
                        {
                            //Affiche le nombre de place disponible
                            $('#Billets').attr('class','alert alert-success');
                            $('#Billets').html(data+' place(s) disponible(s)');

                            reactive(); //Appelle la fonction reactive
                        }
                        /*-----------------*/
                    },
                    error: function() {
                        alert('Erreur avec la requête Ajax'); }
                });
            }
        });


        // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
        var $container = $('div#gb_louvrebundle_formulaire_visiteurs');

        //Diminution et décalage des inputs
        $container.css('width','50%').css('margin-left', '25%');

        //Décalage du bouton ajouter
        $('#add_visiteur').css('margin-left', '38%');

        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
        var index = $container.find(':input').length;


        /*-----------------------------------Fonction du bouton ajouter------------------------------------------*/
        function reactive()
        {
            // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
            $('#add_visiteur').click(function(e)
            {
                //Faire apparaître le bouton valider apres l'ajout d'un premier visiteur
                $('#gb_louvrebundle_formulaire_Valider').css('display', 'block');

                //Faire apparaître les conditions
                $('#Justificatif').css('display', 'block');

                $compteur = addCategory($container);
                e.preventDefault(); // évite qu'un # apparaisse dans l'URL

                //Relance ajax pour incrémenter le compteur de places
                $.ajax({
                    url: 'http://localhost/imbriquer/web/app_dev.php/billetterie/formulaire/ajax/' + $('#gb_louvrebundle_formulaire_calendrier').val(),
                    success: function(data)
                    {
                        var recupNbreDisponible = data;
                        var calculTempsReelNbrePlace = recupNbreDisponible - index;
                        console.log(calculTempsReelNbrePlace);

                        if(calculTempsReelNbrePlace < 980) //Si nombre place disponible = 0
                        {
                            /*-------------Message d'erreur---------------------------*/
                            $('#Billets').attr('class','alert alert-danger');
                            $('#Billets').html('Plus aucune place de libre, choisissez une autre date');

                            /*------------------Remet la valeur par défaut du champs date------------*/
                            $('#gb_louvrebundle_formulaire_calendrier').val('');

                            $('#add_visiteur').css('margin-left', '42%');
                        }
                        else
                        {
                            //Affiche le nombre de place disponible
                            $('#Billets').attr('class','alert alert-success');
                            $('#Billets').html(calculTempsReelNbrePlace+' place(s) disponible(s)');
                        }
                        /*--------------------------------------------------------------------------------------------*/
                    },
                    error: function()
                    {
                        alert('Erreur avec la requête Ajax');
                    }
                });
                console.log(index);
                /*-------en cours---------------------------------------------------------------------------------------------*/

               /* if($compteur === 1) //Pour éviter une erreur lors du premier clic sur ajouter un visiteur
                {
                    //on ne fait rien

                }
                else
                {

                    $nouveauIndex = $compteur-2; //Pour mettre le compteur à 0, pour correspondre aux premier champs
                    //testPassage($nouveauIndex);

                    $nouveauIndexString = $nouveauIndex.toString(); //Convertir le nouveau Index
                    $texteNom = $('#gb_louvrebundle_formulaire_visiteurs_' +  $nouveauIndexString + '_nom').val(); // Récupère la valeur entré ds l'input nom en cours
                    $textePrenom = $('#gb_louvrebundle_formulaire_visiteurs_' +  $nouveauIndexString + '_prenom').val(); // Récupère la valeur entré ds l'input prénom en cours
                    $longueurNom = $texteNom.length; // Récupère la longueur du nom
                    $longueurPrenom = $textePrenom.length; // Récupéla longueur du prénom

                    if($longueurNom < 2) //Si la longueur du nom < 2
                    {
                        alert('Erreur sur la longueur du nom:' + $longueurNom + 'compteur' + $nouveauIndex);
                        $('#gb_louvrebundle_formulaire_visiteurs_' + $nouveauIndexString + '_nom').css('border-color', 'red');
                        $('#gb_louvrebundle_formulaire_visiteurs_' +  $nouveauIndexString + '_nom').val('');
                        //$('#add_visiteur').unb

                    }

                    if($longueurPrenom < 2)
                    {
                        alert('Erreur sur la longueur du prénom:' + $longueurPrenom  + 'compteur' + $nouveauIndex);
                        $('#gb_louvrebundle_formulaire_visiteurs_' + $nouveauIndexString + '_prenom').css('border-color', 'red');
                        $('#gb_louvrebundle_formulaire_visiteurs_' +  $nouveauIndexString + '_prenom').val('');
                        //e.preventDefault();
                    }
                }

              /*----passe----*/
               /* $('#gb_louvrebundle_formulaire_visiteurs_0_nom').change(function(){

                    alert('click');
                });*/
                /*-----------------------------------------------------------------------------------------------------------*/
                return false;
            });
        }
        /*-------------------------------------------------------------------------------------------------------------*/


        /*-----------------------La fonction qui ajoute un formulaire-------------------------------------------------*/
        function addCategory($container) {
           // var index = 0;
            // Dans le contenu de l'attribut « data-prototype », on remplace :
            // - le texte "__name__label__" qu'il contient par le label du champ
            // - le texte "__name__" qu'il contient par le numéro du champ
            var template = $container.attr('data-prototype')
                    .replace(/__name__label__/g, 'Visiteur n°' + (index+1))
                    .replace(/__name__/g,        index)
                ;

            // On crée un objet jquery qui contient ce template
            var $prototype = $(template);

            // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
            addDeleteLink($prototype);  //voir pour récupérer index du delete

            //Ajout d'un trait + modif taille du trait aprés le premier visiteur ajouté
           /* if(index != 0)
            {
                $container.append('<hr class="testo">');
                $('.testo').css('width', '80%');
            }*/


            // On ajoute le prototype modifié à la fin de la balise <div>
            $container.append($prototype);

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            index++;
            return index;
        }
        /*------------------------------------------------------------------------------------------------------------*/

        /*---------------------La fonction qui ajoute un lien de suppression------------------------------------------*/
        function addDeleteLink($prototype) {
            // Création du lien
            var $deleteLink = $('<a href="#" id="test" class="glyphicon glyphicon-trash btn btn-danger supp"></a>'); //glyphicon glyphicon-remove
            $deleteLink.css('float', 'right');

            // Ajout du lien
            $prototype.append($deleteLink);

            // Ajout du listener sur le clic du lien pour effectivement supprimer le visiteur
            $deleteLink.click(function(e) {
                var str = $('#Billets').html(); //récupére la chaine de place disponible
                var strSplit = str.split(" ", 1); //A partir de la chaine on split pour garder que le nombre
                var NbrePlaceApresSuppression = parseInt(strSplit) + 1; //On convertit la chaine en string et on calcul
                $('#Billets').html(NbrePlaceApresSuppression+' place(s) disponible(s)');
                $prototype.remove();
                e.preventDefault(); // évite qu'un # apparaisse dans l'URL
                index --; //Décrémente l'index;
                console.log("enleve: " + index);
                return false;
            });
        }
        /*------------------------------------------------------------------------------------------------------------*/


        function testPassage($compteurCours)
        {
            alert($compteurCours);
             $('#gb_louvrebundle_formulaire_visiteurs_0_nom').change(function(){

             alert('click');
             });
        }
    });
