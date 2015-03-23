/*
 * public_html/js/message.js
 * Description :Fichier permettant de gérer la recherche des profil pour la page des messages
 * @author : Thomas Ricci
*/
$(document).ready(function(){
    var profiles = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('username')/*,function(d) {
         console.log(d);
         return Bloodhound.tokenizers.whitespace(d.id);
         }*/,
        minLength:2,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: 'recherche.php?action=profil&ajax=true&q=%QUERY'
    });
    profiles.initialize();
    $(".suggestion-recherche").tagsinput({
            itemValue: 'id',
            itemText: function(item) {
                return item.prenom+' - '+item.nom;
            },
            typeaheadjs: {
                conf:{
                    hint:true,
                    highlight:true,
                    minLength:2
                },
                source:{
                    name: 'profils',
                    displayKey: 'nom',
                    source: profiles.ttAdapter(),
                    templates: {
                        empty: [
                            '<div class="empty-message">',
                            'Nous ne parvenons pas à trouver des profiles adéquat a votre requete',
                            '</div>'
                        ].join('\n'),
                        header: '<h4 class="filtre-header">Profils</h4>',
                        suggestion: Handlebars.compile('<p><strong>{{prenom}}-{{nom}}</strong> - <small>{{username}}</small><br><small>{{description}}</small></p>')
                    }
                }
            }
        });

});

