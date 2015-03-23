<?php

/* candidature.twig */
class __TwigTemplate_33064c9ea0f9693a6543e6bac53db95e44e27d2c47ff75e0dbe49be1ea6f8c0d extends Twig_Template
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

    // line 4
    public function block_contenu($context, array $blocks = array())
    {
        // line 5
        echo "    ";
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "candidatures", array())) > 0)) {
            // line 6
            echo "        ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "candidatures", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["candidat"]) {
                // line 7
                echo "            
            <p>Projet : <a href=\"projet.php?id=";
                // line 8
                echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "idprojet", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "titre", array()), "html", null, true);
                echo "</a> | état de la candidature : ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["candidat"], "etat_candidature", array()), "html", null, true);
                echo " </p>
            
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['candidat'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 11
            echo "    ";
        } else {
            // line 12
            echo "        <p>Vous n'ête candidat dans aucun projet</p>
    ";
        }
        // line 14
        echo "    ";
        echo twig_var_dump($this->env, $context, (isset($context["data"]) ? $context["data"] : null));
        echo "
";
    }

    public function getTemplateName()
    {
        return "candidature.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 14,  66 => 12,  63 => 11,  50 => 8,  47 => 7,  42 => 6,  39 => 5,  36 => 4,  11 => 2,);
    }
}
