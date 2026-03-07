<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\oEmbed",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class oEmbed extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'SquareIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['section', 'footer', 'nav', 'header', 'aside', 'figure', 'article', 'main'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'OEmbed';
    }

    static function className()
    {
        return 'oxy-oembed';
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
        return ['content' => ['oembed' => ['content_url' => 'https://www.youtube.com/watch?v=winw0Fz-ojU']], 'design' => ['oembed' => ['force_iframe_aspect_ratio' => true, 'width' => 16, 'height' => 9]]];
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
        return [c(
        "oembed",
        "oEmbed",
        [c(
        "force_iframe_aspect_ratio",
        "Force Iframe Aspect Ratio",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "width",
        "Width",
        [],
        ['type' => 'number', 'layout' => 'inline', 'condition' => [[['path' => 'design.oembed.force_iframe_aspect_ratio', 'operand' => 'is set', 'value' => '']]]],
        false,
        false,
        [],
        
      ), c(
        "height",
        "Height",
        [],
        ['type' => 'number', 'layout' => 'inline', 'condition' => [[['path' => 'design.oembed.force_iframe_aspect_ratio', 'operand' => 'is set', 'value' => '']]]],
        false,
        false,
        [],
        
      )],
        ['type' => 'section'],
        false,
        false,
        [],
        
      )];
    }

    static function contentControls()
    {
        return [c(
        "oembed",
        "oEmbed",
        [c(
        "content_url",
        "Content URL",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'textOptions' => ['multiline' => true]],
        false,
        false,
        [],
        ['accepts' => 'video', 'proOnly' => false]
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
        return ['bypassPointerEvents' => true, 'dependsOnGlobalScripts' => true];
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
        return ["type" => "final",   ];
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
        return false;
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
