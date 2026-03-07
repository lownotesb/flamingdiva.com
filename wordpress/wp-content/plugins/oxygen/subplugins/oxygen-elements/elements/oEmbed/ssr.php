<?php

$content_url_dynamic = $propertiesData['content']['oembed']['content_url_dynamic_meta'] ?? false;
$dynamic_shortcode = $content_url_dynamic['shortcode'] ?? false;

$content_url = $propertiesData['content']['oembed']['content_url'] ?? false;
$oembed = null;

if (is_array($content_url) && isset($content_url['url'])) {
    // Front-end: The shortcode is processed and the oEmbed is retrieved on the front-end
    $oembed = $content_url;
} elseif (\Breakdance\DynamicData\isDynamicShortcode($content_url)) {
    // Builder-only: When SSRed, the dynamic shortcode is not processed
    $oembed = \Breakdance\DynamicData\breakdanceDoShortcode($content_url);
} else {
    // Otherwise, retrieve the oEmbed
    $oembed = \Breakdance\OEmbed\retrieveOEmbed($content_url);
}

if (is_array($oembed) && isset($oembed['error'])) {
    echo $oembed['error'];
} else if (is_array($oembed) && isset($oembed['html'])) {
    echo $oembed['html'];
} else {
    echo 'No oEmbed provider found for the provided URL.';
}