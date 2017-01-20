/**
 * Created by Bruno on 06/01/2017.
 */

    $(function() {
        // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
        var $container = $('div#gb_louvrebundle_formulaire_visiteurs');

        //Diminution et décalage des inputs
        $container.css('width','50%').css('margin-left', '25%');

        //Décalage du bouton ajouter
        $('#add_visiteur').css('margin-left', '42%');

        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
        var index = $container.find(':input').length;

        // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
        $('#add_visiteur').click(function(e)
        {
            addCategory($container);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        // On ajoute un premier visiteur automatiquement.
        if (index == 0) {
            addCategory($container);
        } else {
            // On ajoute un lien de suppression pour chacune d'entre elles
            $container.children('div').each(function() {
                addDeleteLink($(this));
            });
        }

        // La fonction qui ajoute un formulaire
        function addCategory($container) {
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
            addDeleteLink($prototype);

            //Ajout d'un trait + modif taille du trait aprés le premier visiteur ajouté
            if(index != 0)
            {
                $container.append('<hr class="testo">');
                $('.testo').css('width', '70%');
            }


            // On ajoute le prototype modifié à la fin de la balise <div>
            $container.append($prototype);

            // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
            index++;
        }

        // La fonction qui ajoute un lien de suppression
        function addDeleteLink($prototype) {
            // Création du lien
            var $deleteLink = $('<a href="#" class="glyphicon glyphicon-trash btn btn-danger"></a>'); //glyphicon glyphicon-remove
            $deleteLink.css('float', 'right');//.css('color', 'red').css('font-size', '25px').css('top', '70%');

            // Ajout du lien
            $prototype.append($deleteLink);

            // Ajout du listener sur le clic du lien pour effectivement supprimer le visiteur
            $deleteLink.click(function(e) {
                $prototype.remove();

                e.preventDefault(); // évite qu'un # apparaisse dans l'URL
                return false;
            });
        }

        //$('#gb_louvrebundle_formulaire_visiteurs_0_tarifReduit').css('font-weight', 'bold');

        /*gestion ajax pour les 1000 billets*/
        $("#gb_louvrebundle_formulaire_calendrier").change(function(){
            $.ajax({
                url: 'http://localhost/imbriquer/web/app_dev.php/billetterie/formulaire/ajax/' + $(this).val(),
                //data: 'day='+($('#calendrierJS').val()),
                success: function(data) {
                    $('#Billets').html(data+' place(s) disponible(s)');
                    /*----test-----*/
                if(data < 980)
                {
                    $('#Billets').attr('class','alert alert-danger');
                    $('#Billets').html('Plus aucune place de libre, choisissez une autre date');
                    $('#gb_louvrebundle_formulaire_calendrier').val('');
                }
                else
                {
                    $('#Billets').attr('class','alert alert-success');
                    $('#Billets').html(data+' place(s) disponible(s)');
                }
                /*-----------------*/
                },
                error: function() {
                    alert('Erreur avec la requête Ajax'); }
            });
        });

    });
