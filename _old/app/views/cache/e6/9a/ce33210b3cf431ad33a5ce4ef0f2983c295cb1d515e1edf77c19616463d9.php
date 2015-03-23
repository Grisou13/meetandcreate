<?php

/* connexion.twig */
class __TwigTemplate_e69ace33210b3cf431ad33a5ce4ef0f2983c295cb1d515e1edf77c19616463d9 extends Twig_Template
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
        echo "Connexion";
    }

    // line 5
    public function block_contenu($context, array $blocks = array())
    {
        // line 6
        echo "    <p>Le login pour le site web est :<br/>
            root@sicmi3a01.cpnv-es.ch<br/>
            toor</p>
    <style>
        .input-group-addon
        {
            min-width: 200px;
            text-align: left;
        }
    </style>
<form method=\"post\">
    <div class=\"row\">
        <div class=\"col-xs-6 col-xs-offset-3\">
            <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"email\">Votre email</span>
                <input type=\"text\" name=\"email\" class=\"form-control\" aria-describedby=\"email\"/>
            </div>
            <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"password\">Votre mot de passe</span>
                <input type=\"password\" name=\"password\" class=\"form-control\" aria-describedby=\"password\"/>
            </div>

            <input class=\"btn btn-primary\" type=\"submit\" value=\"submit\">
        </div>
    </div>
   
</form>

<a href=\"recuperation_mdp.php\">Mot de passe oublié ?</a>
";
    }

    public function getTemplateName()
    {
        return "connexion.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 6,  43 => 5,  37 => 3,  11 => 2,);
    }
}
