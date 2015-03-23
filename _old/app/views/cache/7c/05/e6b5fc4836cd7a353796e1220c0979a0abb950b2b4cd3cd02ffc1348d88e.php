<?php

/* recuperation_mdp.twig */
class __TwigTemplate_7c05e6b5fc4836cd7a353796e1220c0979a0abb950b2b4cd3cd02ffc1348d88e extends Twig_Template
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
        echo "Récuperation de mot de passe";
    }

    // line 4
    public function block_contenu($context, array $blocks = array())
    {
        // line 5
        echo "<form method=\"post\">
    <div class=\"row\">
        <div class=\"col-xs-6 col-xs-offset-3\">
            <div class=\"input-group\">
                <span class=\"input-group-addon\" id=\"email_recup\">Votre email</span>
                <input type=\"text\" name=\"email_recup\" class=\"form-control\" aria-describedby=\"email_recup\"/>
            </div>
            <input class=\"btn btn-primary\" type=\"submit\" value=\"Recevoir un nouveau mot de passe provisoire\">
        </div>
    </div>
   
</form>   
";
    }

    public function getTemplateName()
    {
        return "recuperation_mdp.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 5,  43 => 4,  37 => 3,  11 => 2,);
    }
}
