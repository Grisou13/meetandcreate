/*
 * public_hmtl/js/global.js
 * Description :Fichier permettant de gérer le scroll, ce fichier est inclut dans toute les page 
 * et permettrait de gérer des script essentiel pour toute les pages
 * @author : Thomas Ricci
*/
//scroll to top repri de : http://jsfiddle.net/Panman8201/MKZrm/10/
$(document).ready(function(){
    if ( ($(window).height() + 100) < $(document).height() ) {
        $('#top-link-block').toggleClass('hidden').affix({
            // how far to scroll down before link "slides" into view
            offset: {top:100}
        });
    }
    $('#top-link-block').on('click',function(e){      
        $('#top-link-block').affix({
            // how far to scroll down before link "slides" into view
            offset: {top:100}
        });
        $('html,body').animate({scrollTop:0},'slow');
        
        return false;
    });
}); 

