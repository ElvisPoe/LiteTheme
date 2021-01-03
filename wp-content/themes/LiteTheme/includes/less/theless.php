<?php

if(strpos($_SERVER['REQUEST_URI'], 'theless')){

    require get_template_directory() . '/includes/less/lessc.inc.php';

    $inputFile =  get_template_directory() . '/css/styles/style.less';
    $outputFile =  get_template_directory() . '/css/styles/style_less.css';

    $less = new lessc;

    try {
        $less->compileFile($inputFile, $outputFile);

        $html = "<div>";
        $html .= "<h4>Less compilation succeed</h4>";
        $html .= "</div>";
        echo $html;

        exit();

    } catch (exception $e) {
        echo "Error: " . $e->getMessage();
    }

    function minimizeCSSsimple($css){
        $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
        $css = preg_replace('/\s{2,}/', ' ', $css);
        $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
        $css = preg_replace('/;}/', '}', $css);
        $css = str_replace("\n", "", $css);

        return $css;
    }
}

/*
 * To play less in WP all you need is
 * 1. This file in root folder for easy access
 * 2. The lessc.inc.php file to include
 * 3. And the less files in /styles
 *
 * To compile.. just run www.site.com/theless.php in your browser
 *
 */