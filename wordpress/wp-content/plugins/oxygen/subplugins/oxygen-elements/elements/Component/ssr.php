<?php

namespace Breakdance\Components;

/**
 * @var array $propertiesData
 * @var int|null $repeaterItemNodeId
 */

require_once __DIR__ . "/component.php";

$component = $propertiesData['content']['content']['block'] ?? null;
$componentId = $propertiesData['content']['content']['block']['componentId'] ?? null;

if ($component && $componentId) {
    ComponentInputValueHolder::setCurrentComponent($component);
    echo \Breakdance\Render\renderGlobalBlock($componentId, $repeaterItemNodeId);
    ComponentInputValueHolder::resetComponent();
} else {
    if ($_REQUEST['triggeringDocument'] ?? true) {
        echo '<div class="breakdance-empty-ssr-message">Choose a Component from the dropdown.</div>';
    } else {
        echo "<!-- Oxygen error: $componentId not found -->";
    }
}
