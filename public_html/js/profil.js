/*
 * public_html/js/profil.js
 * Description :Fichier permettant de gérer la recherche de compétence pour la modification de profil
 * @author : Thomas Ricci
*/

$(document).ready(function(){
    var competences = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('competence'),
        minLength:2,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: 'recherche.php?action=competence&ajax&q=%QUERY'
    });
    competences.initialize();
    $(".suggestion-competence").tagsinput({
        itemValue: 'id',
        itemText: 'competence',
        typeaheadjs: {
            conf:{
                hint:true,
                highlight:true,
                minLength:2
            },
            source:{
                name: 'competences',
                displayKey: 'competence',
                source: competences.ttAdapter(),
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        'Nous ne parvenons pas à trouver des filtre adéquat a votre requete',
                        '</div>'
                    ].join('\n'),
                header: '<h4 class="filtre-header">Competences</h4>',
                suggestion: Handlebars.compile('<p><strong>{{competence}}</strong><br><small>{{description}}</small></p>')
                }
            }
        }

    });
});


