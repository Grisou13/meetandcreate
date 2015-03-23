/*
 * public_html/js/
 * Description :Fichier permettant de gérer
 * @author : Thomas Ricci
*/

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * http://sliptree.github.io/bootstrap-tokenfield/
 * docs pour typeahead-tokenizer
 * @param {type} param
 */

$(document).ready(function() {

    var profils = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('username')/*,function(d) {
             console.log(d);
             return Bloodhound.tokenizers.whitespace(d.id);
             }*/,
            minLength:2,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: 'recherche.php?action=profil&ajax=true&q=%QUERY'
        });
    var projets = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('titre')/*,function(d) {
             console.log(d);
             return Bloodhound.tokenizers.whitespace(d.id);
             }*/,
            minLength:2,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: 'recherche.php?action=projet&ajax=true&q=%QUERY'
        }); 
    profils.initialize();
    projets.initialize();
    
    $('#main-recherche').typeahead(
            {
                hint:true,
                highlight:true,
                minLength:2
            },{
                name:'profils',
                displayKey:'competence',
                source:profils.ttAdapter(),
                templates: {
                    empty: [
                    '<div class="empty-message">',
                    'Nous ne parvenons pas à trouver des filtre adéquat a votre requete',
                    '</div>'
                    ].join('\n'),
                    header: '<p class="filtre-header">-----Profils------</p>',
                    suggestion: Handlebars.compile('<a href="profil.php?id={{id}}"><p><strong>{{username}}</strong> <small>{{prenom}} {{nom}}</small><br><small>{{description}}</small></p></a>')
                }
            },{
                name:'projets',
                displayKey:'nom',
                source:projets.ttAdapter(),
                templates: { /*repris de: https://twitter.github.io/typeahead.js/examples/ */
                    empty: [
                    '<div class="empty-message">',
                    'Nous ne parvenons pas à trouver des projets à votre requete',
                    '</div>'
                    ].join('\n'),
                    header: '<p class="filtre-header">-----Projets------</p>',
                    suggestion: Handlebars.compile('<a href="projet.php?id={{id}}"><p><strong>{{titre}}</strong><br><small>{{description}}</small></p></a>')
                } 
            }
        );
    
});

