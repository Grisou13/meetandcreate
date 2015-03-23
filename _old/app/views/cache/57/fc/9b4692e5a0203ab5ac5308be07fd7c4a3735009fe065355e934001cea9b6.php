<?php

/* index.twig */
class __TwigTemplate_57fc9b4692e5a0203ab5ac5308be07fd7c4a3735009fe065355e934001cea9b6 extends Twig_Template
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

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo "Acceuil";
    }

    // line 5
    public function block_contenu($context, array $blocks = array())
    {
        echo " 
    <!--<img src=\"http://lorempixel.com/g/800/600\" alt=\"img\">-->
    <div id=\"carousel-projets\" class=\"carousel slide row\" data-ride=\"carousel\" data-interval=\"3000\" data-pause=\"hover\">
    <!-- Indicators -->
        <ol class=\"carousel-indicators\">
            ";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["projets"]) ? $context["projets"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["projet"]) {
            // line 11
            echo "                <li data-target=\"#carousel-projets\" data-slide-to=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index0", array()), "html", null, true);
            echo "\" class=\"";
            echo ((($this->getAttribute($context["loop"], "index", array()) == 1)) ? ("active") : (""));
            echo "\"></li>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['projet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "        </ol>

        <!-- Wrapper for slides -->
        <div class=\"carousel-inner\" role=\"listbox\">
            ";
        // line 17
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["projets"]) ? $context["projets"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["projet"]) {
            // line 18
            echo "                <div class=\"item ";
            echo ((($this->getAttribute($context["loop"], "index", array()) == 1)) ? ("active") : (""));
            echo "\">
                    <!--<img src=\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxkZWZzLz48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzY2NiIvPjxnPjx0ZXh0IHg9IjM0MC45NzQ5OTg0NzQxMjExIiB5PSIyNTAiIHN0eWxlPSJmaWxsOiM2NjY7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6NDJwdDtkb21pbmFudC1iYXNlbGluZTpjZW50cmFsIj45MDB4NTAwPC90ZXh0PjwvZz48L3N2Zz4=\" alt=\"img\">-->
                    <img src=\"http://lorempixel.com/1800/600/\" >
                    <div class=\"carousel-caption\">
                        <h3><a href=\"projet.php?id=";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "titre", array()), "html", null, true);
            echo "</a></h3>
                        <p>";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute($context["projet"], "description", array()), "html", null, true);
            echo "</p>
                    </div>
                </div>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['projet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "        </div>
        <!-- Controls -->
        <a class=\"left carousel-control\" href=\"#carousel-projets\" role=\"button\" data-slide=\"prev\">
            <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>
            <span class=\"sr-only\">Previous</span>
        </a>
        <a class=\"right carousel-control\" href=\"#carousel-projets\" role=\"button\" data-slide=\"next\">
          <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>
          <span class=\"sr-only\">Next</span>
        </a>

  </div>
    
";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 27,  125 => 23,  119 => 22,  111 => 18,  94 => 17,  88 => 13,  69 => 11,  52 => 10,  43 => 5,  37 => 4,  11 => 2,);
    }
}
