<?php

/* projet.twig */
class __TwigTemplate_6c3d9b898acf709ce9fe74f2178edcf6c9ba2d44afb0448d872f9e3db1e9bfcb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        try {
            $this->parent = $this->env->loadTemplate("template/main.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(2);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
            'contenu' => array($this, 'block_contenu'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "template/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Projets";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "    <link rel=\"stylesheet\" href=\"css/recherche.css\">
    <link rel=\"stylesheet\" href=\"css/bootstrap-tokenfield.min.css\">
    <link rel=\"stylesheet\" href=\"css/bootstrap-tagsinput.css\">
    <link rel=\"stylesheet\" href=\"css/tokenfield-typeahead.min.css\">
";
    }

    // line 10
    public function block_contenu($context, array $blocks = array())
    {
        // line 11
        echo "    <div role=\"tabpanel\">
        <ul class=\"nav nav-tabs\" role=\"tablist\">
            <li role=\"presentation\" class=\"active\"><a href=\"#projets\" aria-controls=\"all\" role=\"tab\" data-toggle=\"tab\">Mes projets  <span class=\"badge\">";
        // line 13
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "user_project", array())), "html", null, true);
        echo "</span></a></li>
            <li role=\"presentation\" class=\"\"><a href=\"#candidature\" aria-controls=\"candidature\" role=\"tab\" data-toggle=\"tab\">Candidatures en attente  <span class=\"badge\">";
        // line 14
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "candidatures", array())), "html", null, true);
        echo "</span></a></li>
            <li role=\"presentation\" class=\"\"><a href=\"#candidatureRefuser\" aria-controls=\"candidature\" role=\"tab\" data-toggle=\"tab\">Candidatures refusées <span class=\"badge\">";
        // line 15
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "candidaturesRefuser", array())), "html", null, true);
        echo "</span></a></li>
            <li role=\"presentation\" class=\"\"><a href=\"#inscrit\" aria-controls=\"membre\" role=\"tab\" data-toggle=\"tab\">Membre dans  <span class=\"badge\">";
        // line 16
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "membres", array())), "html", null, true);
        echo "</span></a></li>
            <li role=\"presentation\" class=\"\"><a href=\"#suggestion\" aria-controls=\"membre\" role=\"tab\" data-toggle=\"tab\">Suggestion de projets <span class=\"badge\">";
        // line 17
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "suggestions", array())), "html", null, true);
        echo "</span> </a></li>
        </ul>

      <!-- Tab panes -->
    <div class=\"tab-content\">
        ";
        // line 23
        echo "        <div role=\"tabpanel\" class=\"tab-pane active\" id=\"projets\">
            <div class=\"jumbotron\">
                <div class=\"row\">
                    <div class=\"col-md-6 col-md-offset-3\">
                        <form method=\"POST\" >
                            <input type=\"hidden\"     name=\"action\"       value=\"ajout\">   
                            <input class=\"btn btn-success btn-lg btn-block\" type=\"submit\"     name=\"submit\"       value=\"ajouter\">
                        </form>
                    </div>
                </div>
            </div>
            ";
        // line 34
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "user_project", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["projet"]) {
            // line 35
            echo "                <div class=\"jumbotron\">
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <h1>";
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "titre", array()), "html", null, true);
            echo " </h1>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <h3>";
            // line 43
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "description", array()), "html", null, true);
            echo "</h3>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                             <p>
                                <table class=\"table table-condensed\">
                                    <caption>Liste des membres</caption>
                                    <thead>
                                        <tr>
                                            <th>Pseudo</th><th>Nom</th><th>Prénom</th><th>E-Mail</th><th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    ";
            // line 57
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["projet"], "membres", array()));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["membre"]) {
                // line 58
                echo "                                        <tr>
                                            <td><a href=\"profil.php?id=";
                // line 59
                echo twig_escape_filter($this->env, $this->getAttribute($context["membre"], "id", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["membre"], "username", array()), "html", null, true);
                echo "</a></td>
                                            <td>";
                // line 60
                echo twig_escape_filter($this->env, $this->getAttribute($context["membre"], "nom", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 61
                echo twig_escape_filter($this->env, $this->getAttribute($context["membre"], "prenom", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 62
                echo twig_escape_filter($this->env, $this->getAttribute($context["membre"], "email", array()), "html", null, true);
                echo "</td>
                                            <td>";
                // line 63
                echo twig_escape_filter($this->env, $this->getAttribute($context["membre"], "description", array()), "html", null, true);
                echo "</td>
                                        </tr>
                                    ";
                $context['_iterated'] = true;
            }
            if (!$context['_iterated']) {
                // line 66
                echo "                                        <tr>
                                            <td colspan=\"5\">Aucun membre n'est inscrit au projet</td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['membre'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 70
            echo "                                    </tbody>
                                </table>
                            </p>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <form method=\"POST\" >
                                <input type=\"hidden\"     name=\"action\"       value=\"proposition\">   
                                <select name=\"profil_id[]\" multiple   value=\"propositions\"  class=\"typeahead suggestion-recherche\" placeholder=\"rechercher un profil\"></select>
                                <input type=\"hidden\"     name=\"projet_id\"    value=\"";
            // line 80
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
            echo "\">
                                <input class=\"btn btn-primary btn-lg\" type=\"submit\"     name=\"submit\"       value=\"proposer\">
                            </form>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-1 col-md-offset-4\">
                            <form method=\"GET\" action=\"projet.php\"> 
                                <input type=\"hidden\"     name=\"id\"    value=\"";
            // line 88
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
            echo "\">
                                <input class=\"btn btn-default\" type=\"submit\"       value=\"afficher\">
                            </form>
                        </div>
                        <div class=\"col-md-1\">
                            <form method=\"POST\" >
                                ";
            // line 94
            if (($this->getAttribute($context["projet"], "publier", array()) == "0")) {
                // line 95
                echo "                                    <input type=\"hidden\"     name=\"action\"       value=\"publication\">   
                                    <input type=\"hidden\"     name=\"projet_id\"    value=\"";
                // line 96
                echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
                echo "\">
                                    <input class=\"btn btn-primary\" type=\"submit\"     name=\"submit\"       value=\"publier\">
                                ";
            } elseif (($this->getAttribute($context["projet"], "publier", array()) == "1")) {
                // line 99
                echo "                                    <input type=\"hidden\"     name=\"action\"       value=\"dépublication\">   
                                    <input type=\"hidden\"     name=\"projet_id\"    value=\"";
                // line 100
                echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
                echo "\">
                                    <input class=\"btn btn-primary\" type=\"submit\"     name=\"submit\"       value=\"dépublier\">
                                ";
            }
            // line 103
            echo "                            </form>
                        </div>
                        <div class=\"col-md-1\">
                            <form method=\"POST\" >
                                <input type=\"hidden\"     name=\"action\"       value=\"modification\">   
                                <input type=\"hidden\"     name=\"projet_id\"    value=\"";
            // line 108
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
            echo "\">
                                <input type=\"hidden\"     name=\"createur_id\"    value=\"";
            // line 109
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "createur_id", array()), "html", null, true);
            echo "\">
                                <input class=\"btn btn-primary\" type=\"submit\"     name=\"submit\"       value=\"modifier\">
                            </form>
                        </div>
                        <div class=\"col-md-1\">
                            <form method=\"POST\" >
                                <input type=\"hidden\"     name=\"action\"       value=\"suppression\">   
                                <input type=\"hidden\"     name=\"projet_id\"    value=\"";
            // line 116
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
            echo "\">
                                <input class=\"btn btn-danger\" type=\"submit\"     name=\"submit\"       value=\"supprimer\">
                            </form>
                        </div>
                    </div> 
                </div>
            ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 123
            echo "                <p>Vous n'avez aucun projet</p>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['projet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 125
        echo "        </div>
        <div role=\"tabpanel\" class=\"tab-pane\" id=\"candidature\"> 
            
                ";
        // line 128
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "candidatures", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["candidat"]) {
            // line 129
            echo "                    <p>Projet : <a href=\"projet.php?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "idprojet", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "titre", array()), "html", null, true);
            echo "</a> </p>
                ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 131
            echo "                    <p>Vous n'êtes candidat dans aucun projet</p>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['candidat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 133
        echo "        </div>
        <div role=\"tabpanel\" class=\"tab-pane\" id=\"inscrit\"> 
            
                ";
        // line 136
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "membres", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["projet"]) {
            // line 137
            echo "                    <p>Projet : <a href=\"projet.php?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "idprojet", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "titre", array()), "html", null, true);
            echo "</a> </p>
                ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 139
            echo "                    <p>Vous n'êtes membre dans aucun projet</p>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['projet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 141
        echo "            
            
        </div>
        <div role=\"tabpanel\" class=\"tab-pane\" id=\"suggestion\"> 

                ";
        // line 146
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "suggestions", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["suggestion"]) {
            // line 147
            echo "                    <p>Projet : <a href=\"projet.php?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["suggestion"], "idprojet", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["suggestion"], "titre", array()), "html", null, true);
            echo "</a> </p>
                    <form method=\"POST\" >
                        <input type=\"submit\"     name=\"etat\"     value=\"accepter\"      class=\"btn btn-primary\"                  >
                        <input type=\"submit\"     name=\"etat\"      value=\"refuser\"       class=\"btn btn-danger\"                  > 
                        <input type=\"hidden\"     name=\"action\"       value=\"validation_proposition\"                      >
                        <input type=\"hidden\"     name=\"candidat_id\"     value=\"";
            // line 152
            echo twig_escape_filter($this->env, $this->getAttribute($context["suggestion"], "id", array()), "html", null, true);
            echo "\"                 >
                   </form>
                ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 155
            echo "                    <p>Vous n'êtes proposer dans aucun projet dans aucun projet</p>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['suggestion'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 157
        echo "            

        </div>
        <div role=\"tabpanel\" class=\"tab-pane\" id=\"candidatureRefuser\"> 

                ";
        // line 162
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "candidaturesRefuser", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["candidat"]) {
            // line 163
            echo "                    <p>Projet : <a href=\"projet.php?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "idprojet", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "titre", array()), "html", null, true);
            echo "</a> </p>
                ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 165
            echo "                    <p>Vous n'avez été refuser dans aucun projet, Félicitations ! ;)</p>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['candidat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 167
        echo "            

        </div>
    </div>
        
    <script src=\"js/tagsinput.min.js\" ></script>
    <script src=\"js/handlebars.js\"></script>
    <script src=\"js/typeahead.js\"></script>
    <script src=\"js/projet.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "projet.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  390 => 167,  383 => 165,  373 => 163,  368 => 162,  361 => 157,  354 => 155,  346 => 152,  335 => 147,  330 => 146,  323 => 141,  316 => 139,  306 => 137,  301 => 136,  296 => 133,  289 => 131,  279 => 129,  274 => 128,  269 => 125,  262 => 123,  250 => 116,  240 => 109,  236 => 108,  229 => 103,  223 => 100,  220 => 99,  214 => 96,  211 => 95,  209 => 94,  200 => 88,  189 => 80,  177 => 70,  168 => 66,  160 => 63,  156 => 62,  152 => 61,  148 => 60,  142 => 59,  139 => 58,  134 => 57,  117 => 43,  109 => 38,  104 => 35,  99 => 34,  86 => 23,  78 => 17,  74 => 16,  70 => 15,  66 => 14,  62 => 13,  58 => 11,  55 => 10,  47 => 5,  44 => 4,  38 => 3,  11 => 2,);
    }
}
