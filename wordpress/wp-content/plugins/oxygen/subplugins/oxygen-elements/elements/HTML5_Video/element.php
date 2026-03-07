<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "OxygenElements\\Html5Video",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class Html5Video extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'VideoIcon';
    }

    static function tag()
    {
        return 'video';
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
        return 'HTML5 Video';
    }

    static function className()
    {
        return 'oxy-video';
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
        "video_file_url",
        "Video File URL",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'mediaOptions' => ['acceptedFileTypes' => ['video'], 'multiple' => false]],
        false,
        false,
        [],
        ['accepts' => 'string', 'proOnly' => false]
      ), c(
        "loop",
        "Loop",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "autoplay",
        "Autoplay",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "muted",
        "Muted",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "controls",
        "Controls",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "plays_inline",
        "Plays Inline",
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
        return ["type" => "final",   ];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return [['name' => 'src', 'template' => '{% set videourl %}
  {% if content.content.video_file_url.url %}
      {{ content.content.video_file_url.url }}
    {% else %}
{# if they set this dynamically to a string to the url, or they chose "insert from url" in the media library dialog #}
       {{ content.content.video_file_url }}
    {% endif %}
{% endset %}
{{ videourl|trim|default(\'https://breakdance.com/wp-content/uploads/2024/12/oxygen-choose-a-video.mp4\') }}'], ['name' => 'loop', 'template' => '{{ content.content.loop ? \'%%OUTPUTBLANKATTRIBUTE%%\' }}'], ['name' => 'autoplay', 'template' => '{{ content.content.autoplay ? \'%%OUTPUTBLANKATTRIBUTE%%\' }}'], ['name' => 'muted', 'template' => '{{ content.content.muted ? \'%%OUTPUTBLANKATTRIBUTE%%\' }}'], ['name' => 'controls', 'template' => '{{ content.content.controls ? \'%%OUTPUTBLANKATTRIBUTE%%\' }}'], ['name' => 'playsinline', 'template' => '{{ content.content.plays_inline ? \'%%OUTPUTBLANKATTRIBUTE%%\' }}']];
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
