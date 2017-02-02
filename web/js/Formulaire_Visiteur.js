/**
 * Created by Bruno on 03/01/2017.
 */
$(function () {
    var $container = $('div#gb_louvrebundle_formulaire_visiteurs');
    var index = $container.find(':input').length;

   $('#add_visiteur').click(function(){
       AjoutVisiteur($container);
       e.preventDefault();
       return false;
   }) ;

    if (index == 1) {
        AjoutVisiteur($container);
    } else
    {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }


    function AjoutVisiteur($container)
    {
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Nom visiteur n°' + (index+1))
            .replace(/__name__/g, index);
        var $prototype = $(template);

        $container.append($prototype);

        index++;
    }
});
