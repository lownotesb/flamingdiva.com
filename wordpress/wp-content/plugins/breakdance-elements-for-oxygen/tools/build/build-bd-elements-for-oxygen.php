<?php

if (PHP_SAPI !== 'cli') {
    exit("This script should only be run from the command line");
}

if ($argc < 2) {
    exit("Usage: php build-bd-elements-for-oxygen.php <breakdance_elements_plugin_path>\n");
}

require_once "util.php";


define('BREAKDANCE_PATH', $argv[1] . '/elements');

// THIS WILL BE rm -rf'd !!!!!
$basePath = dirname(__FILE__, 3); // Get the base path of the plugin
define('BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH', $basePath . '/elements');
define('BREAKDANCE_ELEMENTS_MANUAL_FOR_OXYGEN_PATH', $basePath . '/elements-manual');

passthru('rm -rf "' . BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH . '"');
passthru('rm -rf "' . BREAKDANCE_ELEMENTS_MANUAL_FOR_OXYGEN_PATH . '"');
passthru('mkdir "' . BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH . '"');
passthru('mkdir "' . BREAKDANCE_ELEMENTS_MANUAL_FOR_OXYGEN_PATH . '"');

/*
 * Required path segments for safety
 * this ensures calling the script with bad arguments doesn't result in a bunch of string replacements happening elsewhere on your system
 */
$requiredSourcePathSegment = '/wp-content/plugins/breakdance-elements/elements';
$requiredDestinationPathSegment = '/wp-content/plugins/breakdance-elements-for-oxygen/elements';


function copy_breakdance_elements_to_breakdance_elements_for_oxygen_plugin()
{
    $elementsToCopy = get_elements_to_copy();

    $breakdancePath = getRealPathWithValidation(BREAKDANCE_PATH, $GLOBALS['requiredSourcePathSegment']);
    $oxygenPath = getRealPathWithValidation(BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH, $GLOBALS['requiredDestinationPathSegment']);

    if ($elementsToCopy && $breakdancePath && $oxygenPath) {
        foreach ($elementsToCopy as $folder) {
            copyAndReplaceElements($breakdancePath, $oxygenPath, $folder);
        }
    }
}

function getRealPathWithValidation($path, $requiredSegment)
{
    $realPath = realpath($path);
    if ($realPath === false) {
        die("Invalid path provided: $path\n");
    }

    echo "Validating path: $realPath\n";
    if (strpos($realPath, $requiredSegment) === false) {
        die("Path does not contain required segment: $requiredSegment\n");
    }
    return $realPath;
}

function copyAndReplaceElements($breakdancePath, $oxygenPath, $folder)
{
    global $requiredSourcePathSegment, $requiredDestinationPathSegment;

    $sourceDir = $breakdancePath . '/' . $folder;
    $destDir = $oxygenPath . '/' . $folder;

    if (!is_dir($sourceDir)) {
        echo "Source directory is not a directory: '$sourceDir'\n";
    } elseif (strpos(realpath($sourceDir), $requiredSourcePathSegment) === false) {
        echo "Source directory does not contain required segment: $sourceDir\n";
    } elseif (strpos($destDir, $requiredDestinationPathSegment) === false) {
        echo "Destination directory does not contain required segment: $destDir\n";
        echo "\n";
    } else {
        copyDirectory($sourceDir, $destDir);
    }
}

/**
 * Copy a directory recursively.
 */
function copyDirectory($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copyDirectory($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

// Call the main function to execute the process
copy_breakdance_elements_to_breakdance_elements_for_oxygen_plugin();


// copy elements-manual
function copy_elements_manual()
{
    passthru('
    cd "' . BREAKDANCE_PATH . '";
    cd ..;
    cp -r elements-manual "' . BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH . '";
    cd "' . BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH . '";
    mv elements-manual ..
    cd ..
    cd elements-manual
    cd blog-post-elements
    rm post-featured-image.php
    ');
}
copy_elements_manual();


// add availableIn() { return ['oxygen'] } to elements
add_available_in_oxygen_to_elements(BREAKDANCE_ELEMENTS_FOR_OXYGEN_PATH);
add_available_in_oxygen_to_elements(BREAKDANCE_ELEMENTS_MANUAL_FOR_OXYGEN_PATH);

function add_available_in_oxygen_to_elements($folderPath) // written by ChatGPT
{
    if (!is_dir($folderPath)) {
        echo "The specified folder does not exist: $folderPath\n";
        return;
    }

    $phpFiles = array_merge(
        glob($folderPath . '/*.php'),
        glob($folderPath . '/*/*.php'),
        glob($folderPath . '/*/*/*.php'),
        glob($folderPath . '/*/*/*/*.php'),
        glob($folderPath . '/*/*/*/*/*.php')
    );

    foreach ($phpFiles as $elementFilePath) {
        // Check if the file meets either of the inclusion criteria
        $isElementFile = basename($elementFilePath) === 'element.php';
        $isInElementsManual = strpos($elementFilePath, 'elements-manual') !== false;

        if (!$isElementFile && !$isInElementsManual) {
            echo "Skipping file $elementFilePath as it does not meet inclusion criteria.\n";
            continue;
        }

        $fileContents = file_get_contents($elementFilePath);

        if (strpos($fileContents, 'static function availableIn') !== false) {
            $startPos = strpos($fileContents, 'static function availableIn');
            $endPos = strpos($fileContents, '}', $startPos) + 1;

            $fileContents = substr_replace($fileContents, '', $startPos, $endPos - $startPos);
            echo "Removed existing availableIn() function in $elementFilePath\n";
        }

        $fileContents = preg_replace(
            '/}\s*$/',
            "\n    static function availableIn()\n    {\n        return ['oxygen'];\n    }\n}",
            $fileContents
        );


        if (strpos($fileContents, 'static function category') !== false) {
            $startPos = strpos($fileContents, 'static function category');
            $endPos = strpos($fileContents, '}', $startPos) + 1;

            $fileContents = substr_replace($fileContents, '', $startPos, $endPos - $startPos);
            echo "Removed existing category() function in $elementFilePath\n";
        }

        $fileContents = preg_replace(
            '/}\s*$/',
            "\n    static function category()\n    {\n        return 'breakdance-elements-for-oxygen';\n    }\n}",
            $fileContents
        );

        file_put_contents($elementFilePath, $fileContents);
    }
}
