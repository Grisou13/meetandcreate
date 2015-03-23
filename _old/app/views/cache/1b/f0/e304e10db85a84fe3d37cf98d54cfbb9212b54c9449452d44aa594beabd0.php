<?php

/* proposition.twig */
class __TwigTemplate_1bf0e304e10db85a84fe3d37cf98d54cfbb9212b54c9449452d44aa594beabd0 extends Twig_Template
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
    public function block_contenu($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "propositions", array())) > 0)) {
            // line 5
            echo "        ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "propositions", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["prop"]) {
                // line 6
                echo "            <p>Projet : <a href=\"projet.php?id=";
                echo twig_escape_filter($this->env, $this->getAttribute($context["prop"], "idprojet", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["prop"], "titre", array()), "html", null, true);
                echo "</a> </p>
            <form action=\"candidature.php\" method=\"POST\" >
                <input type=\"submit\"     name=\"etat\"     value=\"accepter\"      class=\"btn btn-primary \"                 >
                <input type=\"submit\"     name=\"etat\"      value=\"refuser\"       class=\"btn btn-danger\"                  > 

                <input type=\"hidden\"     name=\"action\"       value=\"validation_proposition\"                      >
                <input type=\"hidden\"     name=\"candidat_id\"     value=\"";
                // line 12
                echo twig_escape_filter($this->env, $this->getAttribute($context["prop"], "id", array()), "html", null, true);
                echo "\"                 >
           </form>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prop'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "    ";
        } else {
            // line 16
            echo "        <p>Vous n'ête proposé dans aucun projet</p>
    ";
        }
        // line 18
        echo "    
";
    }

    public function getTemplateName()
    {
        return "proposition.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 18,  71 => 16,  68 => 15,  59 => 12,  47 => 6,  42 => 5,  39 => 4,  36 => 3,  11 => 2,);
    }
}
