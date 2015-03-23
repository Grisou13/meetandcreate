<?php

/* inscription.twig */
class __TwigTemplate_da33b4442df9c5cd9dae8a280d35d6877ccb1b68f6e3943d04560ce06e643120 extends Twig_Template
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
        echo "Inscription";
    }

    // line 5
    public function block_contenu($context, array $blocks = array())
    {
        // line 6
        echo "    <style>
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
                <span class=\"input-group-addon\" id=\"pseudo\">Votre pseudonyme</span>
                <input type=\"text\" name=\"pseudo\" class=\"form-control\" aria-describedby=\"pseudo\"/>
            </div>
            <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"email\">Votre email</span>
                <input type=\"text\" name=\"email\" class=\"form-control\" aria-describedby=\"email\"/>
            </div>
            <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"password\">Votre mot de passe</span>
                <input type=\"password\" name=\"password\" class=\"form-control\" aria-describedby=\"password\"/>
            </div>
            <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"password2\">Confirmation mot de passe</span>
                <input type=\"password\" name=\"password2\" class=\"form-control\" aria-describedby=\"password2\"/>
            </div>  
            <input class=\"btn btn-primary\" type=\"submit\" value=\"submit\">
        </div>
    </div>
   
</form>
";
    }

    public function getTemplateName()
    {
        return "inscription.twig";
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
