<?php

/* content.twig */
class __TwigTemplate_008822b76e77c01265da383348cdec2869abf74fa79d666a8028541ffac69730 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<section id=\"api-User\">
    <h1>";
        // line 2
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, (isset($context["getService"]) ? $context["getService"] : null)), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["methods"]) ? $context["methods"] : null), "get", array(), "array"), 0, array(), "array")), "html", null, true);
        echo "</h1>
    <div id=\"api-User-GetUser\">

        <article id=\"api-User-GetUser-0.3.0\" data-group=\"User\" data-name=\"GetUser\" data-version=\"0.3.0\">
            <div class=\"pull-left\">
                <h1>";
        // line 7
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["methods"]) ? $context["methods"] : null), "get", array(), "array"), 0, array(), "array")), "html", null, true);
        echo " - Description</h1>
            </div>
            <div class=\"pull-right\">
                <div class=\"btn-group\">
                    <button class=\"version btn dropdown-toggle\" data-toggle=\"dropdown\">
                        <strong>";
        // line 12
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["methods"]) ? $context["methods"] : null), "get", array(), "array"), 0, array(), "array")), "html", null, true);
        echo "</strong> <span class=\"caret\"></span>
                    </button>
                    <!--<ul class=\"versions dropdown-menu open-left\">
                        <li class=\"disabled\"><a href=\"http://apidocjs.com/example/#\">compare changes to:</a></li>
                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.3.0</a></li>
                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.2.0</a></li>
                        <li class=\"version\"><a href=\"http://apidocjs.com/example/#\">0.1.0</a></li>
                    </ul>-->
                </div>
            </div>
            <div class=\"clearfix\"></div>

            <p></p><p>Description</p> <p></p>

            <pre class=\"prettyprint language-html prettyprinted\" data-type=\"get\"><code><span class=\"pln\">/user/:id</span></code></pre>



            <ul class=\"nav nav-tabs nav-tabs-examples\">
                <li class=\"active\">
                    <a href=\"http://apidocjs.com/example/#examples-User-GetUser-0_3_0-0\">Example usage:</a>
                </li>
            </ul>

            <div class=\"tab-content\">
                <div class=\"tab-pane active\" id=\"examples-User-GetUser-0_3_0-0\">
                    <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">curl </span><span class=\"pun\">-</span><span class=\"pln\">i http</span><span class=\"pun\">://</span><span class=\"pln\">localhost</span><span class=\"pun\">/</span><span class=\"pln\">user</span><span class=\"pun\">/</span><span class=\"lit\">4711</span></code></pre>
                </div>
            </div>




            <h2>Parameter</h2>
            <table>
                <thead>
                <tr>
                    <th style=\"width: 30%\">Field</th>
                    <th style=\"width: 10%\">Type</th>
                    <th style=\"width: 70%\">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class=\"code\">id</td>
                    <td>
                        String
                    </td>
                    <td>
                        <p>The Users-ID.</p>


                    </td>
                </tr>
                </tbody>
            </table>




            <h2>Success 200</h2>
            <table>
                <thead>
                <tr>
                    <th style=\"width: 30%\">Field</th>
                    <th style=\"width: 10%\">Type</th>
                    <th style=\"width: 70%\">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class=\"code\">id</td>
                    <td>
                        String
                    </td>
                    <td>
                        <p>The Users-ID.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">registered</td>
                    <td>
                        Date
                    </td>
                    <td>
                        <p>Registration Date.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">name</td>
                    <td>
                        Date
                    </td>
                    <td>
                        <p>Fullname of the User.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">nicknames</td>
                    <td>
                        String[]
                    </td>
                    <td>
                        <p>List of Users nicknames (Array of Strings).</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">profile</td>
                    <td>
                        Object
                    </td>
                    <td>
                        <p>Profile data (example for an Object)</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">&nbsp;&nbsp;age</td>
                    <td>
                        Number
                    </td>
                    <td>
                        <p>Users age.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">&nbsp;&nbsp;image</td>
                    <td>
                        String
                    </td>
                    <td>
                        <p>Avatar-Image.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">options</td>
                    <td>
                        Object[]
                    </td>
                    <td>
                        <p>List of Users options (Array of Objects).</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">&nbsp;&nbsp;name</td>
                    <td>
                        String
                    </td>
                    <td>
                        <p>Option Name.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">&nbsp;&nbsp;value</td>
                    <td>
                        String
                    </td>
                    <td>
                        <p>Option Value.</p>


                    </td>
                </tr>
                </tbody>
            </table>




            <h2>Error 4xx</h2>
            <table>
                <thead>
                <tr>
                    <th style=\"width: 30%\">Field</th>

                    <th style=\"width: 70%\">Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class=\"code\">NoAccessRight</td>
                    <td>
                        <p>Only authenticated Admins can access the data.</p>


                    </td>
                </tr>
                <tr>
                    <td class=\"code\">UserNotFound</td>
                    <td>
                        <p>The <code>id</code> of the User was not found.</p>


                    </td>
                </tr>
                </tbody>
            </table>

            <ul class=\"nav nav-tabs nav-tabs-examples\">
                <li class=\"active\">
                    <a href=\"http://apidocjs.com/example/#error-examples-User-GetUser-0_3_0-0\">Response (example):</a>
                </li>
            </ul>

            <div class=\"tab-content\">
                <div class=\"tab-pane active\" id=\"error-examples-User-GetUser-0_3_0-0\">
        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code><span class=\"pln\">    HTTP</span><span class=\"pun\">/</span><span class=\"lit\">1.1</span><span class=\"pln\"> </span><span class=\"lit\">401</span><span class=\"pln\"> </span><span class=\"typ\">Not</span><span class=\"pln\"> </span><span class=\"typ\">Authenticated</span><span class=\"pln\">
    </span><span class=\"pun\">{</span><span class=\"pln\">
      </span><span class=\"str\">\"error\"</span><span class=\"pun\">:</span><span class=\"pln\"> </span><span class=\"str\">\"NoAccessRight\"</span><span class=\"pln\">
    </span><span class=\"pun\">}</span></code></pre>
                </div>
            </div>




            <h2>Send a Sample Request</h2>
            <form class=\"form-horizontal\">
                <fieldset>
                    <div class=\"control-group\">
                        <div class=\"controls\">
                            <div class=\"input-prepend\">&gt;
                                <span class=\"add-on\">url</span>
                                <input type=\"text\" class=\"input-xxlarge sample-request-url\" value=\"http://apidocjs.com/example/api_project.json\">
                            </div>
                        </div>
                    </div>


                    <h3>Parameters</h3>
                    <h4><input type=\"radio\" data-sample-request-param-group-id=\"sample-request-param-0\" name=\"User-GetUser-0_3_0-sample-request-param\" value=\"0\" class=\"sample-request-param sample-request-switch\" checked=\"\"> Parameter</h4>
                    <div class=\"User-GetUser-0_3_0-sample-request-param-fields\">
                        <div class=\"control-group\">
                            <label class=\"control-label\" for=\"sample-request-param-field-id\">id</label>
                            <div class=\"controls\">
                                <div class=\"input-append\">&gt;
                                    <input type=\"text\" placeholder=\"id\" class=\"input-xxlarge sample-request-param\" data-sample-request-param-name=\"id\" data-sample-request-param-group=\"sample-request-param-0\">
                                    <span class=\"add-on\">String</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"control-group\">
                        <div class=\"controls\">
                            <button class=\"btn btn-default sample-request-send\" data-sample-request-type=\"get\">Send</button>
                        </div>
                    </div>

                    <div class=\"sample-request-response\" style=\"display: none;\">
                        <h3>
                            Response
                            <button class=\"btn btn-small btn-default pull-right sample-request-clear\">X</button>
                        </h3>
                        <pre class=\"prettyprint language-json prettyprinted\" data-type=\"json\"><code class=\"sample-request-response-json\"></code></pre>
                    </div>

                </fieldset>
            </form>


        </article>

    </div>

</section>";
    }

    public function getTemplateName()
    {
        return "content.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 12,  32 => 7,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "content.twig", "/var/www/public/apix/src/store/declarations/twigTemplate/content.twig");
    }
}
