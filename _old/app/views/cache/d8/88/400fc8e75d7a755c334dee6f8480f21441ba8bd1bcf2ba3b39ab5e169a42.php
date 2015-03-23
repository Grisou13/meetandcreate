<?php

/* modif_projet.twig */
class __TwigTemplate_d888400fc8e75d7a755c334dee6f8480f21441ba8bd1bcf2ba3b39ab5e169a42 extends Twig_Template
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
                Titre: <input type=\"hidden\"     name=\"createur_id\"    value=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projet", array()), "titre", array()), "html", null, true);
        echo "\">
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-12\">
                Description: <input type=\"hidden\"     name=\"createur_id\"    value=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "projet", array()), "description", array()), "html", null, true);
        echo "\">
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "modif_projet.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 13,  51 => 8,  46 => 5,  43 => 4,  37 => 3,  11 => 2,);
    }
}
