<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\WpWidget", 
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class WpWidget extends \Breakdance\Elements\Element
{
    static function uiIcon() 
    {
        return 'WordPressIcon';
    }

    static function availableIn()
    {
        return ['breakdance', 'oxygen'];
    }
    
    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['section', 'footer', 'header', 'nav', 'aside', 'figure', 'article', 'main', 'details', 'summary'];
    }
    
    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Widget';
    }
    
    static function className()
    {
        return 'oxy-widget';
    }

    static function category()
    {
        return 'dynamic';
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
        return [getPresetSection(
      "EssentialElements\\wp_widget",
      "Content", 
      "content", 
       ['type' => 'popout']
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

    static function order()
    {
        return 10000;
    }
    
    static function dynamicPropertyPaths()
    {
        return ['0' => ['accepts' => 'string', 'path' => 'content.content.wp_text.title'], '1' => ['accepts' => 'string', 'path' => 'content.content.wp_archives.title'], '2' => ['accepts' => 'string', 'path' => 'content.content.wp_categories.title'], '3' => ['accepts' => 'string', 'path' => 'content.content.wp_calendar.title'], '4' => ['accepts' => 'string', 'path' => 'content.content.wp_recent_comments.title'], '5' => ['accepts' => 'string', 'path' => 'content.content.wp_tag_cloud.title'], '6' => ['accepts' => 'string', 'path' => 'content.content.wp_rss.title'], '7' => ['accepts' => 'string', 'path' => 'content.content.wp_recent_posts.title'], '8' => ['accepts' => 'string', 'path' => 'content.content.wp_pages.title']];
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
        return ['content.content'];
    }
}
