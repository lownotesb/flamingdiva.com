<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\HtmlCode",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class HtmlCode extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'CodeIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['section', 'span', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'footer', 'header', 'nav', 'aside', 'figure', 'ul', 'ol', 'li', 'article', 'main', 'details', 'a', 'summary'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'HTML Code';
    }

    static function className()
    {
        return 'oxy-html-code';
    }

    static function category()
    {
        return 'other';
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
        return false;
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
                "html_code",
                "HTML Code",
                [],
                ['type' => 'code', 'layout' => 'vertical', 'codeOptions' => ['language' => 'html']],
                false,
                false,
                [],
                ['accepts' => 'string', 'proOnly' => false]
            ), c(
                "disable_builder_label",
                "Disable Builder Label",
                [],
                ['type' => 'toggle', 'layout' => 'inline'],
                false,
                false,
                [],

            ), c(
                "builder_label",
                "Builder Label",
                [],
                ['type' => 'text', 'layout' => 'inline', 'condition' => [[['path' => 'content.content.disable_builder_label', 'operand' => 'is not set', 'value' => '']]]],
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
        return ["type" => "final",];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return false;
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
        return [];
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
