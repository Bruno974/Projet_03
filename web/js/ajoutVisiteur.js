/**
 * Created by Bruno on 04/01/2017.
 */
/**
 * Created by Bruno on 03/01/2017.
 */
$(function () {
    var $container = $('div#gb_testbundle_visite_visiteurs');
    var index = $container.find(':input').length;
    var compteur = 0;

    $('#add_formulaire').click(function(e){
        addName($container);
        e.preventDefault();

        compteur ++;
        $('#gb_testbundle_visite_nbreVisiteur').val(compteur);

        alert($('#gb_testbundle_visite_nbreVisiteur').val());



        return false;
    }) ;

    if (index == 1) {
        addName($container);
    } else
    {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }


    function addName($container)
    {
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Nom visiteur n°' + (index+1))
            .replace(/__name__/g, index);
        var $prototype = $(template);

        $container.append($prototype);

        index++;
    }
});

