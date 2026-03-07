<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\ContainerLink",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class ContainerLink extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'LinkIcon';
    }

    static function tag()
    {
        return 'a';
    }

    static function tagOptions()
    {
        return [];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Container Link';
    }

    static function className()
    {
        return 'oxy-container-link';
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
        return ['content' => ['content' => ['link' => ['type' => 'url', 'url' => 'https://oxygenbuilder.com/'], 'text' => 'Click Here']]];
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
                "url",
                "URL",
                [],
                ['type' => 'url', 'layout' => 'vertical'],
                false,
                false,
                [],
                ['accepts' => 'string', 'proOnly' => false]
            ), c(
                "open_in_new_tab",
                "Open In New Tab",
                [],
                ['type' => 'toggle', 'layout' => 'inline'],
                false,
                false,
                [],

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
        return ["type" => "container-link",];
    }

    static function spacingBars()
    {
        return [];
    }

    static function attributes()
    {
        return [['name' => 'href', 'template' => '{{ content.content.url }}'], ['name' => 'target', 'template' => '{{ content.content.open_in_new_tab ? \'_blank\' : \'_self\' }}']];
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
        return 70;
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
        return ['looksGood' => 'yes', 'optionsGood' => 'yes', 'optionsWork' => 'yes'];
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
