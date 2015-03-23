/*
 * public_html/js/
 * Description :Fichier permettant de gérer
 * @author : Thomas Ricci
*/

/* 
 * Script de recherhce avancé
 */
$(document).ready(function(){
    var tag_profile = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('competence') /*function(d) {
         return Bloodhound.tokenizers.whitespace(d.id);
         }*/,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: 'recherche.php?action=competence&ajax=true&q=%QUERY'
    });
    var tag_projets = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nom')/*,function(d) {
         console.log(d);
         return Bloodhound.tokenizers.whitespace(d.id);
         }*/,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: 'recherche.php?action=tag&ajax=true&q=%QUERY'
    });
    tag_projets.initialize();
    tag_profile.initialize();
    /*élément de la recherche avancé*/
    // http://timschlechter.github.io/bootstrap-tagsinput/examples/ docs pour boostrap tags input
    $('#filtrecompetence').tagsinput({
        itemValue: 'id',
        itemText: 'competence',
        typeaheadjs: {
            conf:{
                hint:true,
                highlight:true,
                minLength:2
            },
            source:{
                name: 'profiles',
                displayKey: 'competence',
                source: tag_profile.ttAdapter(),
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        'Nous ne parvenons pas à trouver des filtre adéquat a votre requete',
                        '</div>'
                    ].join('\n'),
                    header: '<h4 class="filtre-header">Competences des profiles</h4>',
                    suggestion: Handlebars.compile('<p><strong>{{competence}}</strong><br><small>{{description}}</small></p>')
                }
            }
        }

    });
    $('#filtretag')
        .tagsinput({
            itemValue: 'id',
            itemText: 'nom',
            typeaheadjs: {
                conf:{
                    hint:true,
                    highlight:true,
                    minLength:2
                },
                source:{
                    name: 'projets',
                    displayKey: 'nom',
                    source: tag_projets.ttAdapter(),
                    templates: {
                        empty: [
                            '<div class="empty-message">',
                            'Nous ne parvenons pas à trouver des filtre adéquat a votre requete',
                            '</div>'
                        ].join('\n'),
                        header: '<h4 class="filtre-header">Tags des projets</h4>',
                        suggestion: Handlebars.compile('<p><strong>{{nom}}</strong><br><small>{{description}}</small></p>')
                    }
                }
            }

        });
});

