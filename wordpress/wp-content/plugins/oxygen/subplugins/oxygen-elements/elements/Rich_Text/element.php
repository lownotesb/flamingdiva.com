<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\RichText",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class RichText extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return '<svg viewBox="0 0 500 500" fill="currentColor">   <path d="M31 0C13.893 0 0 13.89 0 31s13.892 31 31 31h438c17.11 0 31.001-13.89 31.001-31s-13.891-31-31-31H31ZM15 141.5c-8.278 0-15 6.721-15 15s6.722 15 15 15h470c8.28 0 15.001-6.721 15.001-15s-6.722-15-15-15H15ZM15 251c-8.279 0-15 6.721-15 15s6.721 15 15 15h199c8.279 0 15-6.721 15-15s-6.721-15-15-15H15ZM286 250c-8.279 0-15 6.721-15 15s6.721 15 15 15h199c8.279 0 15-6.721 15-15s-6.721-15-15-15H286ZM15 360.5c-8.278 0-15 6.721-15 15s6.722 15 15 15h470c8.28 0 15.001-6.721 15.001-15s-6.722-15-15-15H15ZM15 470c-8.279 0-15 6.721-15 15s6.721 15 15 15h199c8.279 0 15-6.721 15-15s-6.721-15-15-15H15Z"/> </svg>';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['details', 'summary', 'article', 'main', 'aside', 'section'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Rich Text';
    }

    static function className()
    {
        return 'oxy-rich-text';
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
        return ['content' => ['content' => ['text' => '<h2>Rich Text</h2><p>This is my rich text.</p><h3>I am a subheading</h3><p>This is <strong>more</strong> rich text.</p><ul><li><p>I am a list</p></li><li><p>Lists are cool</p></li></ul>']]];
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
                ['type' => 'richtext', 'layout' => 'vertical'],
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
        return [];
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
        return 60;
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
