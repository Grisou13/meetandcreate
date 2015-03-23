<?php require_once '../vendor/autoload.php'; ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-tokenfield.min.css">
    <link rel="stylesheet" href="css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="css/tokenfield-typeahead.min.css">
    <link rel="stylesheet" href="css/recherche.css">
        <title>Page de test</title>
    </head>
    <body>
  <form action="test.php" method="POST" >
   <input type="submit"     name="submit"       value="proposer"                      >
   <input type="hidden"     name="action"       value="proposition"                     >
   
   <select name="profil_id[]" multiple   value="propositions"  class="typeahead suggestion-recherche" placeholder="rechercher un profil">
   </select>
   <input type="hidden"     name="projet_id"    value="1"                   >
  </form>
        
        <?php

        $a=['12','23','1234','531'];
        $b=  array_filter($a, 'is_numeric'); echo 'asd';
        //var_dump($b==$a);
        //var_dump(is_numeric('1','2'));
        
       //var_dump(is_numeric(['12','1','234']));
        //var_dump(MAC\Models\Profil::find([0=>'1',2,3])->toArray());
        var_dump(MAC\Models\Profil::find(1)->competences->contains("17"));
       //var_dump(MAC\Models\Profil::find(1)->propositionProjet()->get()->toArray());
       //var_dump(MAC\Models\Profil::where('username','root')->orWhere('email','dfgrehtg')->get()->count());
       //var_dump(Illuminate\Support\Str::random(8));
       /*MAC\Models\Profil::create([
           'username'=>'root',
           'email'=>'test'
       ]);
       /*$user->password="";
       $user->password_temp=Illuminate\Support\Str::random(8);*/
//       $mail = new PHPMailer;
//
//        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
//
//        $mail->isSMTP();                                      // Set mailer to use SMTP
//        $mail->Host = 'sicmi3a01.cpnv-es.ch';  // Specify main and backup SMTP servers
//        $mail->SMTPAuth = true;                               // Enable SMTP authentication
//        $mail->Username = 'sicmi3a01';                 // SMTP username
//        $mail->Password = 'EBATRIGLR';                           // SMTP password
//        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//        $mail->Port = 587;                                    // TCP port to connect to
//
//        $mail->From = 'no-reply@sicmi3a01.cpnv-sc.ch';
//        $mail->FromName = 'Nous';
//        $mail->addAddress('grisou13@hotmail.fr', 'thomas ricci');     // Add a recipient
//        $mail->addReplyTo('info@example.com', 'Information');
//
//        $mail->isHTML(true);                                  // Set email format to HTML
//
//        $mail->Subject = 'Here is the subject';
//        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        /*if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }*/
    
        ?>
    <script src="js/tagsinput.min.js" ></script>
    <script src="js/handlebars.js"></script>
    <script src="js/typeahead.js"></script>
    <script>
        var profiles = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('username'),
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
                    name: 'projets',
                    displayKey: 'nom',
                    source: profiles.ttAdapter(),
                    templates: {
                        empty: [
                            '<div class="empty-message">',
                            'Nous ne parvenons pas à trouver des filtre adéquat a votre requete',
                            '</div>'
                        ].join('\n'),
                        header: '<h4 class="filtre-header">Tags des projets</h4>',
                        suggestion: Handlebars.compile('<p><strong>{{prenom}}-{{nom}}</strong> - <small>{{username}}</small><br><small>{{description}}</small></p>')
                    }
                }
            });
    </script>
    </body>
</html>
