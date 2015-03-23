<?php

/* main.twig */
class __TwigTemplate_57f522a602474b585d5338ccdbae930c27a14d17e9fed41aacc2cf0004d4805f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <script src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css\">
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js\"></script>
    <title>";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        echo " - My Webpage</title>    
</head>
<body>
    <div class=\"navbar navbar-inverse \" role=\"navigation\" id='main-navigation-container'>
        <div class=\"container-fluid\">
            <div class=\"navbar-header\">
                    <!-- Bouton pour faire déplier la navigation si l'écran est trop petit -->
                    <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#main-navigation-collapse\">
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
             </button>
             <a class=\"navbar-brand\" href=\"\">Porte ouverte CPNV 2014</a>
            </div>
            <div class=\"collapse navbar-collapse\" id='main-navigation-collapse'>
                <ul class=\"nav navbar-nav\">
                    <li class=\"\"><a href=\"\">Acceuil</a></li>

                    <!--<li class=\"dropdown\">
                            <a href=\"\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Visiteur <span class=\"caret\"></span></a>
                            <ul class=\"dropdown-menu\" role=\"menu\">
                                    <li><a href=\"\">Jeu</a></li>
                                    <li><a href=\"\">Tableau des scores</a></li>
                            </ul>
                    </li><!-- ./ dropdown Visiteur -->

                    <!--<li class=\"dropdown\">
                            <a href=\"\"  class=\"dropdown-toggle\" data-toggle=\"dropdown\">Administration <span class=\"caret\"></span></a>
                            <ul class=\"dropdown-menu\" role=\"menu\">
                                    <li><a href=\"\">Tableau de bord</a></li>
                                    <li><a href=\"\">Gestion des visiteurs</a></li>
                                    <li><a href=\"\">Gestion des comptes</a></li>
                                    <li><a href=\"\">Données de debug</a></li>
                            </ul>
                    </li><!-- ./ dropdown Admin -->
                </ul>
            </div>
        </div>\t\t\t
    </div>
\t\t
    
    <div class=\"alert alert-warning alert-dismissible\">\t\t\t
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button> 
    </div>



    <div class=\"alert alert-info alert-dismissible\">\t\t\t
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button> 
    </div>
\t\t

    <div class=\"container-fluid\" id='content'>\t\t\t
        hello
    </div>

    <div id=\"footer\">
        <div class=\"container\">
            <p class=\"text-muted\">Copyright © 2014 CPNV.</p>
        </div>
    </div>

    <ul class=\"nav pull-right scroll-top\" data-spy=\"affix\" data-offset-top=\"10\" id='top-scroll'>
        <li><a href=\"#\" title=\"Scroll to top\"><i class=\"glyphicon glyphicon-chevron-up\"></i></a></li>
    </ul>
\t\t
</body>
</html>";
    }

    public function block_title($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "main.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 9,  20 => 1,);
    }
}
