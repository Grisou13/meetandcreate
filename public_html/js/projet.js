/*
 * public_html/js/projet.js
 * Description :Fichier permettant de gérer la recherche de tag ainsi que de profil dans les pages offrant la gestion des projets
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
    var tags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('competence'),
        minLength:2,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: 'recherche.php?action=tag&ajax&q=%QUERY'
    });
    profiles.initialize();    
    tags.initialize();
    $(".suggestion-tag")        
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
                    name: 'tags',
                    displayKey: 'nom',
                    source: tags.ttAdapter(),
                    templates: {
                        empty: [
                            '<div class="empty-message">',
                            'Nous ne parvenons pas à trouver de tag adéquat a votre requete',
                            '</div>'
                        ].join('\n'),
                    header: '<h4 class="filtre-header">Tags</h4>',
                    suggestion: Handlebars.compile('<p><strong>{{nom}}</strong><br><small>{{description}}</small></p>')
                    }
                }
            }

        });
            
    $(".suggestion-recherche")
        .on('typeahead:selected', function(event, selection) {
                alert(selection.value);
        })
        .tagsinput({
            itemValue: 'id',
            itemText: function(item) {
                return item.prenom+' - '+item.nom;
            },
            typeaheadjs: {
                conf:{
                    hint:true,
                    highlight:true,
                    minLength:2,
                    autoselect: true
                },
                source:{
                    name: 'profils',
                    displayKey: 'nom',
                    source: profiles.ttAdapter(),
                    templates: {
                        empty: [
                            '<div class="empty-message">',
                            'Nous ne parvenons pas à trouver des profils adéquat a votre requete',
                            '</div>'
                        ].join('\n'),
                        header: '<h4 class="filtre-header">Profils</h4>',
                        suggestion: Handlebars.compile('<p><strong>{{prenom}}-{{nom}}</strong> - <small>{{username}}</small><br><small>{{description}}</small></p>')
                    }
                }
            }
        });
});

