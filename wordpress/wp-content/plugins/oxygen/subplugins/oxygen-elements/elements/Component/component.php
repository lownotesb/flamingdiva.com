<?php

namespace Breakdance\Components;

class ComponentInputValueHolder
{
    use \Breakdance\Singleton;

    private static $componentStack = [];

    public static function setCurrentComponent($component) {
        self::$componentStack[] = $component;
        add_filter('breakdance_before_render_node', '\Breakdance\Components\replaceNodePropertiesWithEditedPropertiesFromComponent');
    }

    public static function resetComponent() {
        array_pop(self::$componentStack);

        if (empty(self::$componentStack)) {
            remove_filter('breakdance_before_render_node', '\Breakdance\Components\replaceNodePropertiesWithEditedPropertiesFromComponent');
        }
    }

    public static function getCurrentComponent() {
        return self::$componentStack[array_key_last(self::$componentStack)];
    }
}

function getTargetsForNode($nodeId)
{
    $component = ComponentInputValueHolder::getCurrentComponent();

    $targets = $component['targets'] ?? [];

    return array_filter($targets, function ($target) use ($nodeId) {
        return $target['nodeId'] === $nodeId;
    });
}

function replaceNodePropertiesWithEditedPropertiesFromComponent($node)
{
    $targetPropertiesForNode = getTargetsForNode($node['id']);

    $component = ComponentInputValueHolder::getCurrentComponent();
    $properties = $component['properties'] ?? [];

    foreach ($targetPropertiesForNode as $target) {
        $propertyValueInComponent = $properties[$target['propertyKey']] ?? null;
        /** use of isset - explanation is https://github.com/soflyy/breakdance/issues/6707 */
        if (isset($propertyValueInComponent)) {
            assignArrayByPath($node['data']['properties'], $target['controlPath'], $propertyValueInComponent);
        }
    }
    return $node;
}
