<?php

/* profil.twig */
class __TwigTemplate_939c457caa89a4a4c1ca87c1de1a3a063e4571a39972688ee5bb8e3ddc93c11d extends Twig_Template
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
        echo "Profils";
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
        // line 18
        echo "<br>
    
    <div class=\"row\">
        <div class=\"col-xs-6\">
        ";
        // line 22
        if ( !(null === (isset($context["profil"]) ? $context["profil"] : null))) {
            // line 23
            echo "                <form method=\"post\" action=\"profil.php\">

                    <input type=\"hidden\" name=\"id\" value=\"";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()), "html", null, true);
            echo "\">
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"pseudo\">Votre pseudonyme</span>
                        <input type=\"text\" name=\"pseudo\" class=\"form-control\" aria-describedby=\"pseudo\" value=\"";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "username", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div>
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"email\">Votre email</span>
                        <input type=\"text\" name=\"email\" class=\"form-control\" aria-describedby=\"email\" value=\"";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "email", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"prenom\">Votre Prenom</span>
                        <input type=\"text\" name=\"prenom\" class=\"form-control\" aria-describedby=\"prenom\" value=\"";
            // line 36
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "prenom", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"nom\">Votre Nom</span>
                        <input type=\"text\" name=\"nom\" class=\"form-control\" aria-describedby=\"nom\" value=\"";
            // line 40
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "nom", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"description\">Description</span>
                        <textarea class=\"form-control\" aria-describedby=\"description\" name=\"description\" placeholder=\"description\" rows=\"4\" style=\"max-width: 460px; min-width: 460px; min-height: 34px;\" ";
            // line 44
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo ">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "description", array()), "html", null, true);
            echo "</textarea> 
                    </div>

                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"telephone\">Numéro de téléphone</span>
                        <input type=\"text\" name=\"telephone\" class=\"form-control\" aria-describedby=\"telephone\" value=\"";
            // line 49
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "telephone", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"adresse\">Adresse</span>
                        <input type=\"text\" name=\"adresse\" class=\"form-control\" aria-describedby=\"adresse\" value=\"";
            // line 53
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "adresse", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"cp\">Code postal</span>
                        <input type=\"text\" name=\"cp\" class=\"form-control \" aria-describedby=\"cp\" value=\"";
            // line 57
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "cp", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 
                    <div class=\"input-group\">
                        <span class=\"input-group-addon\" id=\"pays\">Pays</span>
                        <input type=\"text\" name=\"pays\" class=\"form-control\" aria-describedby=\"pays\" value=\"";
            // line 61
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "pays", array()), "html", null, true);
            echo "\" ";
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) != $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                echo "disabled ";
            }
            echo "/>
                    </div> 

                    ";
            // line 64
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) == $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                // line 65
                echo "                        <input class=\"btn btn-primary btn-lg\" type=\"submit\" value=\"Modifier\">
                    ";
            }
            // line 67
            echo "                </form>
                ";
            // line 68
            echo (isset($context["form"]) ? $context["form"] : null);
            echo " ";
            // line 69
            echo "        </div>
        ";
            // line 70
            if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) == $this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "id", array()))) {
                // line 71
                echo "        <div class=\"col-xs-6\">
            <form method='POST' action='profil.php'>
                ";
                // line 73
                if ( !(null === $this->getAttribute((isset($context["get"]) ? $context["get"] : null), "recup_mdp", array()))) {
                    echo "<input type=\"hidden\" name=\"recup_mdp\" value=\"1\">";
                }
                // line 74
                echo "                <input type='hidden' name='modification_mdp' value='1'>

                     <div class=\"input-group\">
                            <span class=\"input-group-addon\" id=\"password\">Nouveau mot de passe</span>
                            <input type=\"password\" name=\"password\" class=\"form-control\" aria-describedby=\"password\"/>
                        </div>
                        <div class=\"input-group\">
                            <span class=\"input-group-addon\" id=\"password2\">Confirmation mot de passe</span>
                            <input type=\"password\" name=\"password2\" class=\"form-control\" aria-describedby=\"password2\"/>
                        </div>  
                     <input class=\"btn btn-primary btn-lg\" type=\"submit\" value=\"Changer mot de passe\">
                     
            </form>
            ";
                // line 88
                echo "            <br>
            <ul class=\"list-group\">
                ";
                // line 90
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["profil"]) ? $context["profil"] : null), "competences", array()));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["comp"]) {
                    // line 91
                    echo "                <li class=\"list-group-item\">
                    ";
                    // line 92
                    echo twig_escape_filter($this->env, $this->getAttribute($context["comp"], "competence", array()), "html", null, true);
                    echo " &nbsp;
                    <span class=\"badge\">";
                    // line 93
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["comp"], "pivot", array()), "niveau", array()), "html", null, true);
                    echo "</span>
                    <button type=\"button\" class=\"btn btn-primary right\" data-toggle=\"modal\" data-target=\"#modalNiveau";
                    // line 94
                    echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                    echo "\">
                        Modifier niveau
                    </button>
                    <form method='post'>
                        <input type='hidden' value=\"";
                    // line 98
                    echo twig_escape_filter($this->env, $this->getAttribute($context["comp"], "id", array()), "html", null, true);
                    echo "\" name=\"comp_id\">
                        <input type='hidden' value=\"supprimer_comp\" name=\"action\">
                        <input type='submit' value='supprimer' class='btn btn-danger'>
                    </form>
                    <form method=\"post\">
                        <input type=\"hidden\" name=\"action\" value=\"changerNiveauCompetence\">
                        <input type=\"hidden\" name=\"competence_id\" value=\"";
                    // line 104
                    echo twig_escape_filter($this->env, $this->getAttribute($context["comp"], "id", array()), "html", null, true);
                    echo "\">
                        <div class=\"modal fade\" id=\"modalNiveau";
                    // line 105
                    echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
                    echo "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
                          <div class=\"modal-dialog\">
                            <div class=\"modal-content\">
                              <div class=\"modal-header\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                                <h4 class=\"modal-title\" id=\"myModalLabel\">Changez le niveau de votre compétence</h4>
                              </div>
                              <div class=\"modal-body\">
                                  <p> ";
                    // line 113
                    echo twig_escape_filter($this->env, $this->getAttribute($context["comp"], "competence", array()), "html", null, true);
                    echo " </p>
                                  <select name=\"niveau\">
                                      <option value=\"1\" ";
                    // line 115
                    echo ((($this->getAttribute($this->getAttribute($context["comp"], "pivot", array()), "niveau", array()) == 1)) ? ("selected") : (""));
                    echo "> Utilisateur Débutant </option>
                                      <option value=\"2\" ";
                    // line 116
                    echo ((($this->getAttribute($this->getAttribute($context["comp"], "pivot", array()), "niveau", array()) == 2)) ? ("selected") : (""));
                    echo "> Utilisateur Intermédiaire </option>
                                      <option value=\"3\" ";
                    // line 117
                    echo ((($this->getAttribute($this->getAttribute($context["comp"], "pivot", array()), "niveau", array()) == 3)) ? ("selected") : (""));
                    echo "> Utilisateur Confirmé </option>
                                      <option value=\"4\" ";
                    // line 118
                    echo ((($this->getAttribute($this->getAttribute($context["comp"], "pivot", array()), "niveau", array()) == 4)) ? ("selected") : (""));
                    echo "> Utilisateur Avancé </option>
                                      <option value=\"5\" ";
                    // line 119
                    echo ((($this->getAttribute($this->getAttribute($context["comp"], "pivot", array()), "niveau", array()) == 5)) ? ("selected") : (""));
                    echo "> Utilisateur Expert </option>
                                  </select>
                              </div>
                              <div class=\"modal-footer\">
                                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Fermer</button>
                                <button type=\"submit\" class=\"btn btn-primary\">Enregistrer</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                </li>
                <!-- Modal -->
                
                ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comp'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 134
                echo "            </ul>
            <form method=\"POST\" >
\t\t\t\t<input class=\"btn btn-primary btn-lg\" type=\"submit\" value=\"Ajouter une compétence\">
\t\t\t   <input type=\"hidden\"     name=\"action\"       value=\"ajout_competence\"                     >   
\t\t\t   <select name=\"competence_id[]\" multiple   value=\"propositions\"  class=\"typeahead suggestion-competence\" placeholder=\"Recherche compétence\">
\t\t\t   </select>
\t\t\t  </form>
 
           

        </div> 
        ";
            }
            // line 146
            echo "        ";
        } else {
            // line 147
            echo "            <p>Le profil que vous avez demandé à visionné ne peut pas être vu, ou n'existe pas</p>
        ";
        }
        // line 149
        echo "        </div>           
        <br>

    <script src=\"js/tagsinput.min.js\" ></script>
    <script src=\"js/handlebars.js\"></script>
    <script src=\"js/typeahead.js\"></script>
    <script src=\"js/profil.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "profil.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  349 => 149,  345 => 147,  342 => 146,  328 => 134,  299 => 119,  295 => 118,  291 => 117,  287 => 116,  283 => 115,  278 => 113,  267 => 105,  263 => 104,  254 => 98,  247 => 94,  243 => 93,  239 => 92,  236 => 91,  219 => 90,  215 => 88,  200 => 74,  196 => 73,  192 => 71,  190 => 70,  187 => 69,  184 => 68,  181 => 67,  177 => 65,  175 => 64,  165 => 61,  154 => 57,  143 => 53,  132 => 49,  120 => 44,  109 => 40,  98 => 36,  87 => 32,  76 => 28,  70 => 25,  66 => 23,  64 => 22,  58 => 18,  55 => 10,  47 => 5,  44 => 4,  38 => 3,  11 => 2,);
    }
}
