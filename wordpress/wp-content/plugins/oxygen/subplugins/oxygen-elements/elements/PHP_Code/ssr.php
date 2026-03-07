<?php

/**
 * @var array $propertiesData
 */

$code = "?>" . ($propertiesData['content']['content']['php_code'] ?? '');

try {
    eval($code);
} catch (\ParseError $e) {
    echo 'An error occurred inside the PHP Code Block element: <br />';
    echo 'Caught exception: ' . $e->getMessage() . "\n";
    echo 'Line: ';
    echo $e->getLine();
    echo "<br />";
}
