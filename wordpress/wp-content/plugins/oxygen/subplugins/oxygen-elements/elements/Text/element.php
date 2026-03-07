<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\Text",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class Text extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'TextIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['span', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'li', 'blockquote'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Text';
    }

    static function className()
    {
        return 'oxy-text';
    }

    static function category()
    {
        return 'basic';
    }

    static function badge()
    {
        return false;
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function template()
    {
        return file_get_contents(__DIR__ . '/html.twig');
    }

    static function defaultCss()
    {
        return file_get_contents(__DIR__ . '/default.css');
    }

    static function defaultProperties()
    {
        return ['content' => ['content' => ['text' => 'Enter your text. <strong>HTML</strong> is supported.']]];
    }

    static function defaultChildren()
    {
        return false;
    }

    static function cssTemplate()
    {
        $template = file_get_contents(__DIR__ . '/css.twig');
        return $template;
    }

    static function designControls()
    {
        return [];
    }

    static function contentControls()
    {
        return [c(
            "content",
            "Content",
            [c(
                "text",
                "Text",
                [],
                ['type' => 'text', 'layout' => 'vertical', 'textOptions' => ['multiline' => true]],
                false,
                false,
                [],
                ['accepts' => 'string']
            )],
            ['type' => 'section', 'layout' => 'vertical'],
            false,
            false,
            [],

        )];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return false;
    }

    static function settings()
    {
        return false;
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return false;
    }

    static function nestingRule()
    {
        return ["type" => "final",];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return [['template' => 'content.content.text', 'name' => 'data-content-editable-property-path']];
    }

    static function experimental()
    {
        return false;
    }

    static function availableIn()
    {
        return ['oxygen'];
    }


    static function order()
    {
        return 0;
    }

    static function dynamicPropertyPaths()
    {
        return false;
    }

    static function additionalClasses()
    {
        return false;
    }

    static function projectManagement()
    {
        return false;
    }

    static function propertyPathsToWhitelistInFlatProps()
    {
        return false;
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
