<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\JavaScriptCode",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class JavaScriptCode extends \Breakdance\Elements\Element
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
        return ['div'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'JavaScript Code';
    }

    static function className()
    {
        return 'oxy-javascript-code';
    }

    static function category()
    {
        return 'advanced';
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
        return ['content' => ['content' => ['javascript_code' => 'alert(\'JavaScript code\');']]];
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
        "javascript_code",
        "JavaScript Code",
        [],
        ['type' => 'code', 'layout' => 'vertical', 'codeOptions' => ['language' => 'javascript']],
        false,
        false,
        [],
        
      ), c(
        "info",
        "Info",
        [],
        ['type' => 'alert_box', 'layout' => 'vertical', 'alertBoxOptions' => ['style' => 'default', 'content' => '<p>The JavaScript code will be enclosed in a callback function that fires on <em>DOMContentLoaded</em>. The <em>&lt;script&gt;</em> tag will be placed before the closing <em>&lt;/body&gt;</em> tag.</p>']],
        false,
        false,
        [],
        
      ), c(
        "execute_javascript",
        "Execute JavaScript",
        [],
        ['type' => 'trigger_action_button', 'layout' => 'inline', 'items' => [['value' => 'true', 'text' => 'Execute', 'icon' => 'CodeIcon']], 'triggerActionsButtonOptions' => ['text' => 'Execute']],
        false,
        false,
        [],
        
      ), c(
        "disable_builder_label",
        "Disable Builder Label",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'items' => [['value' => 'hidden', 'text' => 'hidden', 'icon' => 'EyeSlashSolidIcon'], ['text' => 'visible', 'value' => 'visible', 'icon' => 'EyeSolidIcon']]],
        false,
        false,
        [],
        
      ), c(
        "builder_label",
        "Builder Label",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'placeholder' => '', 'condition' => ['path' => 'content.content.disable_builder_label', 'operand' => 'is not set', 'value' => '']],
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
        return ['0' =>  ['inlineScripts' => ['{{ content.content.javascript_code }}'],'builderCondition' => 'return false;','frontendCondition' => 'return true;','title' => 'Frontend only dependencies',],];
    }

    static function settings()
    {
        return ['builderOnly' => true];
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return [

'onPropertyChange' => [['script' => '{{ content.content.javascript_code }}
','dependencies' => ['content.content.execute_javascript'],
],],];
    }

    static function nestingRule()
    {
        return ["type" => "final",   ];
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
        return 10;
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
