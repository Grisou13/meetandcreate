<?php

/* recherche.twig */
class __TwigTemplate_09b57c0199da9cc0d22c71a4865751b9963204dae74aca3b2eb4d9a7f87bc70e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("template/main.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

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

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo "Recherche";
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    <link rel=\"stylesheet\" href=\"css/recherche.css\">
    <link rel=\"stylesheet\" href=\"css/bootstrap-tokenfield.min.css\">
    <link rel=\"stylesheet\" href=\"css/bootstrap-tagsinput.css\">
    <link rel=\"stylesheet\" href=\"css/tokenfield-typeahead.min.css\">
";
    }

    // line 9
    public function block_contenu($context, array $blocks = array())
    {
        // line 10
        echo "    <!--<script>
        \$(document).ready(function(){
            \$(\".test\").popover();
        });
    </script>
    <a id=\"tooltip\" href=\"#\" tabindex=\"0\" class=\"btn btn-lg btn-danger test\" role=\"button\" data-toggle=\"popover\" data-trigger=\"hover\" title=\"Dismissible popover\" data-content=\"And here's some amazing content. It's very engaging. Right?\">Dismissible popover</a>
     -->       
        
    <form action=\"recherche.php\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <input type=\"text\" name=\"q\" id=\"recherche\" placeholder=\"recherche\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, (( !(null === $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "query", array()))) ? ($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "query", array())) : ("")), "html", null, true);
        echo "\">
                <input type=\"submit\" class=\"btn btn-primary\" value=\"Rechercher!\">
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-6\">
                <select type=\"text\" name=\"competence[]\" id=\"filtrecompetence\" placeholder=\"Filtrer les compétences des profiles\" multiple></select>
            </div>
            <div class=\"col-md-6\">
                <select type=\"text\" name=\"tag[]\" id=\"filtretag\" placeholder=\"Filtrer les tags des projets\" multiple></select>
            </div>
        </div>

    </form>

    <!-- Tab panes selector -->
    <div role=\"tabpanel\">
        <ul class=\"nav nav-tabs\" role=\"tablist\">
        <li role=\"presentation\" class=\"active\"><a href=\"#all\" aria-controls=\"all\" role=\"tab\" data-toggle=\"tab\">Tout</a></li>
        <li role=\"presentation\" class=\"\"><a href=\"#profil\" aria-controls=\"profil\" role=\"tab\" data-toggle=\"tab\">Profil</a></li>
        <li role=\"presentation\" class=\"\"><a href=\"#projet\" aria-controls=\"projet\" role=\"tab\" data-toggle=\"tab\">Projet</a></li>
      </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
        ";
        // line 47
        echo "        <div role=\"tabpanel\" class=\"tab-pane active\" id=\"all\">
            ";
        // line 48
        echo "            
                <div class=\"row\">
                    <div class=\"col-md-6\">                    
                        ";
        // line 51
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "profiles", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["profile"]) {
            // line 52
            echo "                            <p><a href=\"profil.php?id=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["profile"], "id", array()), "html", null, true);
            echo "\" >";
            echo twig_escape_filter($this->env, $this->getAttribute($context["profile"], "username", array()), "html", null, true);
            echo "</a> <br/>
                                <small>
                                ";
            // line 54
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["profile"], "competences", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["comp"]) {
                echo " 
                                    <button class=\"btn btn-default btn-xs\">";
                // line 55
                echo twig_escape_filter($this->env, $this->getAttribute($context["comp"], "competence", array()), "html", null, true);
                echo " </button>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comp'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 57
            echo "                                </small>
                            </p>
                        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 60
            echo "                            <p>Il n'y a aucun profile qui correspond à votre recherche</p>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['profile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        echo "                  
                    </div>
                    <div class=\"col-md-6\">
                    
                        ";
        // line 65
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projets", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["projet"]) {
            // line 66
            echo "                            <p class=\"projet\"><strong>";
            echo twig_escape_filter($this->env, twig_title_string_filter($this->env, $this->getAttribute($context["projet"], "titre", array())), "html", null, true);
            echo "</strong> <br> ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "description", array()), "html", null, true);
            echo " <br>
                                <small>
                                ";
            // line 68
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["projet"], "tags", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                echo " 
                                    ";
                // line 69
                echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "nom", array()), "html", null, true);
                echo "  
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 71
            echo "                                </small>
                            </p>
                        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 74
            echo "                            Il n'y a aucun projet qui correspond à votre recherche <br/>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['projet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 76
        echo "                    </div>
                </div>
        </div>
        ";
        // line 80
        echo "        <div role=\"tabpanel\" class=\"tab-pane\" id=\"profil\">      
            ";
        // line 82
        echo "            <div class=\"row\">
                <div class=\"col-md-12\">
                    ";
        // line 84
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "profiles", array())) > 0)) {
            // line 85
            echo "                        ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "profiles", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["profile"]) {
                // line 86
                echo "                            <p>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["profile"], "prenom", array()), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["profile"], "nom", array()), "html", null, true);
                echo "<p>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['profile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 88
            echo "                    ";
        } else {
            // line 89
            echo "                        Il n'y a aucun profile qui correspond à votre recherche <br/>
                    ";
        }
        // line 91
        echo "                </div>
            </div>
        </div>
        ";
        // line 95
        echo "        <div role=\"tabpanel\" class=\"tab-pane\" id=\"projet\">
            ";
        // line 97
        echo "            <div class=\"row\">                
                <div class=\"col-md-12\">
                    ";
        // line 99
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projets", array()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["projet"]) {
            // line 100
            echo "                        <p><strong>";
            echo twig_escape_filter($this->env, twig_title_string_filter($this->env, $this->getAttribute($context["projet"], "titre", array())), "html", null, true);
            echo "</strong> <br> ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "description", array()), "html", null, true);
            echo "<br/>
                            <small>
                            ";
            // line 102
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["projet"], "tags", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                echo " 
                                ";
                // line 103
                echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "nom", array()), "html", null, true);
                echo " | ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "id", array()), "html", null, true);
                echo "
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            echo "                            </small>
                        </p>
                    ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 108
            echo "                        Il n'y a aucun projet qui correspond à votre recherche <br/>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['projet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 110
        echo "                </div>
            </div>
        </div>
      </div>
    </div>
                ";
        // line 115
        echo twig_var_dump($this->env, $context, (isset($context["data"]) ? $context["data"] : null));
        echo "
    <script src=\"js/tagsinput.min.js\" ></script>
    <script src=\"js/handlebars.js\"></script>
    <script src=\"js/typeahead.js\"></script>
    <script src=\"js/recherche.js\"></script>
    ";
        // line 121
        echo "    <script>
        \$(document).ready(function(){
            ";
        // line 123
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "filtre", array()), "tags", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 124
            echo "                \$(\"#filtretag\").tagsinput('add', { \"id\": ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "id", array()), "html", null, true);
            echo " , \"nom\": \"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "nom", array()), "html", null, true);
            echo "\"   });
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 126
        echo "
            ";
        // line 127
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "filtre", array()), "competences", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 128
            echo "                \$(\"#filtrecompetence\").tagsinput('add', { \"id\": ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "id", array()), "html", null, true);
            echo " , \"competence\": \"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "competence", array()), "html", null, true);
            echo "\"   });
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 130
        echo "        });
    </script>
";
    }

    public function getTemplateName()
    {
        return "recherche.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  339 => 130,  328 => 128,  324 => 127,  321 => 126,  310 => 124,  306 => 123,  302 => 121,  294 => 115,  287 => 110,  280 => 108,  273 => 105,  263 => 103,  257 => 102,  249 => 100,  244 => 99,  240 => 97,  237 => 95,  232 => 91,  228 => 89,  225 => 88,  214 => 86,  209 => 85,  207 => 84,  203 => 82,  200 => 80,  195 => 76,  188 => 74,  181 => 71,  173 => 69,  167 => 68,  159 => 66,  154 => 65,  148 => 61,  141 => 60,  134 => 57,  126 => 55,  120 => 54,  112 => 52,  107 => 51,  102 => 48,  99 => 47,  71 => 21,  58 => 10,  55 => 9,  47 => 4,  44 => 3,  38 => 2,  11 => 1,);
    }
}
