<?php

/**
 * 
 * INSTRUCTIONS
 * 
 * to write all the elements in Breakdance Elements that should be copied to the elements-to-copy.json file
 * put the following code in get_elements_for_builder function, just above the `$allElements = array_map... `line
 * 
 *  require_once(WP_PLUGIN_DIR . '/breakdance-elements-for-oxygen/tools/build/generate-json-of-all-breakdance-elements.php');
 *  getAllElementsToCopyAndWriteToJson(get_element_classnames());
 * 
 */

function getAllElementsToCopyAndWriteToJson($classNames)
{
    $elements = getAllElementsToCopy($classNames);

    writeToJson($elements);
}

function getAllElementsToCopy($classNames)
{

    $elementsToExclude = getElementsIncludedInOxygenElementsPlugin();

    $elementsToCopy =
        array_values(
            array_filter(
                array_map(
                    function ($elementClassName) use ($elementsToExclude) {
                        $element = new $elementClassName();

                        $isExperimental = $element::experimental();

                        $reflectionClass = new \ReflectionClass($elementClassName);
                        $filename = $reflectionClass->getFileName();

                        $directory = basename(dirname($filename));

                        $alwaysHide = $element::addPanelRules()['alwaysHide'] ?? false;

                        $elementsManual = strpos($filename, "elements-manual") !== false;

                        $isAlreadyInOxygen = in_array($directory, $elementsToExclude);

                        return [
                            'directory' => $directory,
                            'experimental' => $isExperimental,
                            'alwaysHide' => $alwaysHide,
                            'elementsManual' => $elementsManual,
                            'isAlreadyInOxygen' => $isAlreadyInOxygen
                        ];
                    },
                    $classNames
                ),
                function ($element) {
                    return (
                        !$element['experimental'] &&
                        !$element['alwaysHide'] &&
                        !$element['elementsManual'] &&
                        !$element['isAlreadyInOxygen']
                    );
                }
            )
        );

    return $elementsToCopy;
}

function getElementsIncludedInOxygenElementsPlugin()
{
    require_once WP_PLUGIN_DIR . "/oxygen-elements/tools/sync/util.php";

    $oxygenElements = get_elements_to_sync();
    return $oxygenElements;
}



function writeToJson($elements)
{

    $elementsToCopy = array_map(
        function ($element) {
            return $element["directory"];
        },
        $elements
    );

    $jsonOutput = json_encode(
        [
            "elementsToCopy" => $elementsToCopy
        ],
        JSON_PRETTY_PRINT
    );

    ray($jsonOutput);

    file_put_contents(WP_PLUGIN_DIR . '/breakdance-elements-for-oxygen/tools/build/elements-to-copy.json', $jsonOutput);
}
