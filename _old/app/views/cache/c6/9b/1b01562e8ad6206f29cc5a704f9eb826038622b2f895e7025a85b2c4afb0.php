<?php

/* affichage_projet.twig */
class __TwigTemplate_c69b1b01562e8ad6206f29cc5a704f9eb826038622b2f895e7025a85b2c4afb0 extends Twig_Template
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
    public function block_contenu($context, array $blocks = array())
    {
        // line 5
        echo "    <div class=\"jumbotron\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <h1>";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projet", array()), "titre", array()), "html", null, true);
        echo " </h1>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-12\">
                <h3>";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projet", array()), "description", array()), "html", null, true);
        echo "</h3>
            </div>
        </div>
        ";
        // line 16
        if (($this->getAttribute((isset($context["session"]) ? $context["session"] : null), "userid", array()) == $this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projet", array()), "createur_id", array()))) {
            // line 17
            echo "            <div class=\"row\">
                <div class=\"col-md-2 col-md-offset-5\">
                    <form method=\"POST\" >
                        <input type=\"hidden\"     name=\"action\"       value=\"modification\">   
                        <input type=\"hidden\"     name=\"projet_id\"    value=\"";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["projet"]) ? $context["projet"] : null), "id", array()), "html", null, true);
            echo "\">
                        <input type=\"hidden\"     name=\"createur_id\"    value=\"";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["projet"]) ? $context["projet"] : null), "createur_id", array()), "html", null, true);
            echo "\">
                        <input class=\"btn btn-primary\" type=\"submit\"     name=\"submit\"       value=\"modifier\">
                    </form>
                </div>
            </div>
        ";
        }
        // line 28
        echo "    </div>
";
    }

    public function getTemplateName()
    {
        return "affichage_projet.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 28,  77 => 22,  73 => 21,  67 => 17,  65 => 16,  59 => 13,  51 => 8,  46 => 5,  43 => 4,  37 => 3,  11 => 2,);
    }
}
