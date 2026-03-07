<?php

namespace OxygenElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
  "OxygenElements\\Image",
  \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class Image extends \Breakdance\Elements\Element
{
  static function uiIcon()
  {
    return 'ImageIcon';
  }

  static function tag()
  {
    return 'img';
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
    return 'Image';
  }

  static function className()
  {
    return 'oxy-image';
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
    return ['content' => ['image' => ['from' => 'media_library', 'lazy_load' => true, 'alt' => 'from_media_library']]];
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
      "image",
      "Image",
      [c(
        "from",
        "From",
        [],
        ['type' => 'button_bar', 'layout' => 'inline', 'items' => [['value' => 'media_library', 'text' => 'Media Library'], ['text' => 'URL', 'value' => 'url']]],
        false,
        false,
        [],

      ), c(
        "media",
        "Media",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical', 'mediaOptions' => ['acceptedFileTypes' => ['image'], 'multiple' => false], 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'media_library']]]],
        false,
        false,
        [],
        ['accepts' => 'image_url']
      ), c(
        "url",
        "URL",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => false], 'textOptions' => ['multiline' => true], 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'url']]]],
        false,
        false,
        [],

      ), c(
        "size",
        "Size",
        [],
        ['type' => 'media_size_dropdown', 'layout' => 'vertical', 'mediaSizeOptions' => ['imagePropertyPath' => 'content.image.media'], 'condition' => [[['path' => 'content.image.media', 'operand' => 'is set', 'value' => ''], ['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'media_library']]]],
        false,
        false,
        [],

      ), c(
        "alt",
        "Alt",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['value' => 'from_media_library', 'text' => 'Media Library'], ['text' => 'Custom', 'value' => 'custom'], ['text' => 'Decorative', 'value' => 'decorative']], 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'media_library']]]],
        false,
        false,
        [],

      ), c(
        "custom_alt",
        "Custom Alt",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'textOptions' => ['multiline' => true], 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'media_library'], ['path' => 'content.image.alt', 'operand' => 'equals', 'value' => 'custom']]]],
        false,
        false,
        [],
        ['accepts' => 'string', 'proOnly' => false]
      ), c(
        "alt_when_from_url",
        "Alt",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['text' => 'Custom', 'value' => 'custom'], ['text' => 'Decorative', 'value' => 'decorative']], 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'url']]]],
        false,
        false,
        [],

      ), c(
        "custom_alt_when_from_url",
        "Custom Alt",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'textOptions' => ['multiline' => true], 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'url'], ['path' => 'content.image.alt_when_from_url', 'operand' => 'equals', 'value' => 'custom']]]],
        false,
        false,
        [],

      ), c(
        "lazy_load",
        "Lazy Load",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => [[['path' => 'content.image.from', 'operand' => 'is set', 'value' => '']]]],
        false,
        false,
        [],

      ), c(
        "disable_srcset_sizes",
        "Disable Srcset & Sizes",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => [[['path' => 'content.image.from', 'operand' => 'equals', 'value' => 'media_library']]]],
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
    return [['name' => 'src', 'template' => '{% set fallbackimage %}{% endset %}
{% set imageurl %}
  {% if content.image.from == \'media_library\' %}
    {% if content.image.size %}
      {{ content.image.media.sizes[content.image.size].url }}
    {% else %}
      {{ content.image.media.url }}
    {% endif %}
  {% elseif content.image.from == \'url\' %}
    {{ content.image.url }}
  {% endif %}
{% endset %}
{{ imageurl|spaceless|default("data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'540\' height=\'540\' viewBox=\'0 0 140 140\'%3e%3cpath d=\'M0 0h140v140H0z\' fill=\'%23e5e7eb\'/%3e%3cpath d=\'M88 82.46H51.8v-4.52l6.74-6.74a1.13 1.13 0 011.6 0l5.23 5.23 12.76-12.77a1.13 1.13 0 011.6 0L88 71.91z\' fill=\'%23e5e7eb\'/%3e%3cpath d=\'M89.48 52.32H50.29a4.52 4.52 0 00-4.52 4.52V84a4.53 4.53 0 004.52 4.52h39.19A4.52 4.52 0 0094 84V56.84a4.52 4.52 0 00-4.52-4.52zm-33.16 5.27a5.28 5.28 0 11-5.27 5.28 5.27 5.27 0 015.27-5.28zM88 82.46H51.8v-4.52l6.74-6.74a1.13 1.13 0 011.6 0l5.23 5.23 12.76-12.77a1.13 1.13 0 011.6 0L88 71.91z\' fill=\'%23d1d5db\'/%3e%3c/svg%3e") }}
'], ['name' => 'alt', 'template' => '{% if content.image.from == \'media_library\' %}
  {% if content.image.alt == \'from_media_library\' %}
    {{ get_attachment_alt(content.image.media.id) }}
  {% elseif content.image.alt == \'decorative\' %}
    %%OUTPUTBLANKATTRIBUTE%%
  {% elseif content.image.alt == \'custom\' %}
    {{ content.image.custom_alt }}
  {% endif %}
{% endif %}
{% if content.image.from == \'url\' %}
  {% if content.image.alt_when_from_url == \'decorative\' %}
    %%OUTPUTBLANKATTRIBUTE%%
  {% elseif content.image.alt == \'custom\' %}
    {{ content.image.custom_alt_when_from_url }}
  {% endif %}
{% endif %}'], ['name' => 'loading', 'template' => '{% if content.image.lazy_load %}lazy{% endif %}'], ['name' => 'srcset', 'template' => '{% if not content.image.disable_srcset_sizes and content.image.from == \'media_library\' %}
  {{ content.image.media.attributes.srcset }}
{% endif %}'], ['name' => 'sizes', 'template' => '{% if not content.image.disable_srcset_sizes and content.image.from == \'media_library\' %}
  {{ content.image.media.attributes.sizes }}
{% endif %}']];
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
