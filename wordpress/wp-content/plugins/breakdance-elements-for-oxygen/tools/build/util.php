<?php

// @psalm-ignore-file

function get_elements_to_copy()
{

    $copy = readBuildConfig2(dirname(__FILE__) . '/elements-to-copy.json');
    $toCopy = $copy['elementsToCopy'];

    return $toCopy;
}





function readBuildConfig2($configFile)
{
    if (!file_exists($configFile)) {
        die("Build config file not found: $configFile\n");
    }

    $configContent = file_get_contents($configFile);
    return json_decode($configContent, true);
}
