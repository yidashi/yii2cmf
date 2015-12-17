<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013 - 2015
 * @package yii2-helpers
 * @version 1.3.5
 */

namespace kartik\helpers;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Provides implementation for various bootstrap HTML helper functions
 *
 * @see http://getbootstrap.com/css
 * @see http://getbootstrap.com/components
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0
 */
class Html extends \yii\helpers\Html
{

    /**
     * Bootstrap CSS helpers
     */
    const FLOAT_LEFT = 'pull-left';
    const FLOAT_RIGHT = 'pull-right';
    const FLOAT_CENTER = 'center-block';
    const NAVBAR_FLOAT_LEFT = 'navbar-left';
    const NAVBAR_FLOAT_RIGHT = 'navbar-right';
    const CLEAR_FLOAT = 'clearfix';
    const SHOW = 'show';
    const HIDDEN = 'hidden';
    const INVISIBLE = 'invisible';
    const SCREEN_READER = 'sr-only';
    const IMAGE_REPLACER = 'text-hide';

    /**
     * Bootstrap size modifier suffixes
     */
    const SIZE_TINY = 'xs';
    const SIZE_SMALL = 'sm';
    const SIZE_MEDIUM = 'md';
    const SIZE_LARGE = 'lg';

    /**
     * Bootstrap color modifier classes
     */
    const TYPE_DEFAULT = 'default';
    const TYPE_PRIMARY = 'primary';
    const TYPE_SUCCESS = 'success';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';

    /**
     * Generates a bootstrap icon markup.
     *
     * @see http://getbootstrap.com/components/#glyphicons
     *
     * @param string $icon the bootstrap icon name without prefix (e.g. 'plus', 'pencil', 'trash')
     * @param array  $options HTML attributes / options for the icon container
     * @param string $prefix the css class prefix - defaults to 'glyphicon glyphicon-'
     * @param string $tag the icon container tag (usually 'span' or 'i') - defaults to 'span'
     *
     * Example(s):
     * ~~~
     * echo Html::icon('pencil');
     * echo Html::icon('trash', ['style' => 'color: red; font-size: 2em']);
     * echo Html::icon('plus', ['class' => 'text-success']);
     * ~~~
     *
     * @return string
     */
    public static function icon($icon, $options = [], $prefix = 'glyphicon glyphicon-', $tag = 'span')
    {
        $class = isset($options['class']) ? ' ' . $options['class'] : '';
        $options['class'] = $prefix . $icon . $class;
        return static::tag($tag, '', $options);
    }

    /**
     * Generates a bootstrap label markup.
     *
     * @see http://getbootstrap.com/components/#labels
     *
     * @param string $content the label content
     * @param string $type the bootstrap label type. Defaults to 'default'. Should be one of the bootstrap contextual
     *     colors: 'default, 'primary', 'success', 'info', 'danger', 'warning'.
     * @param array  $options HTML attributes / options for the label container
     * @param string $prefix the CSS class prefix. Defaults to 'label label-'.
     * @param string $tag the label container tag. Defaults to 'span'.
     *
     * @return string
     */
    public static function bsLabel($content, $type = 'default', $options = [], $prefix = 'label label-', $tag = 'span')
    {
        if (Enum::isEmpty($type)) {
            $type = self::TYPE_DEFAULT;
        }
        $class = isset($options['class']) ? ' ' . $options['class'] : '';
        $options['class'] = $prefix . $type . $class;
        return static::tag($tag, $content, $options);
    }

    /**
     * Generates a badge.
     *
     * @see http://getbootstrap.com/components/#badges
     *
     * @param string $content the badge content
     * @param array  $options HTML attributes / options for the label container
     * @param string $tag the label container tag. Defaults to 'span'.
     *
     * @return string
     */
    public static function badge($content, $options = [], $tag = 'span')
    {
        static::addCssClass($options, 'badge');
        return static::tag($tag, $content, $options);
    }

    /**
     * Generates a list group. Flexible and powerful component for displaying not only simple lists of elements, but
     * complex ones with custom content.
     *
     * @see http://getbootstrap.com/components/#list-group
     *
     * @param array  $items the list group items. The following array key properties can be setup:
     *      - `content`: mixed, the list item content. When passed as a string, it will display this directly as a raw
     *          content. When passed as an array, it requires these keys
     *          - `heading`: string, the content heading (optional).
     *          - `headingOptions`: array, the HTML attributes / options for heading container (optional).
     *          - `body`: string, the content body (optional).
     *          - `bodyOptions`: array, the HTML attributes / options for body container (optional).
     *      - `url`: , the url for linking the list item content (optional).
     *      - `badge`: string, any badge content to be displayed for this list item (optional)
     *      - `badgeOptions`: array, the HTML attributes / options for badge container (optional).
     *      - `active`: bool, to highlight the item as active (applicable only if $url is passed). Defaults to `false`.
     *      - `options`: array, HTML attributes / options for the list group item container (optional).
     * @param array  $options HTML attributes / options for the list group container
     * @param string $tag the list group container tag. Defaults to 'div'.
     * @param string $itemTag the list item container tag. Defaults to 'div'.
     *
     * Example(s):
     * ~~~
     * echo Html::listGroup([
     *    [
     *      'content' => 'Cras justo odio',
     *      'url' => '#',
     *      'badge' => '14',
     *      'active' => true
     *    ],
     *    [
     *      'content' => 'Dapibus ac facilisis in',
     *      'url' => '#',
     *      'badge' => '2'
     *    ],
     *    [
     *      'content' => 'Morbi leo risus',
     *      'url' => '#',
     *      'badge' => '1'
     *    ],
     * ]);
     *
     * echo Html::listGroup([
     *    [
     *      'content' => ['heading' => 'Heading 1', 'body' => 'Cras justo odio'],
     *      'url' => '#',
     *      'badge' => '14',
     *      'active' => true
     *    ],
     *    [
     *      'content' => ['heading' => 'Heading 2', 'body' => 'Dapibus ac facilisis in'],
     *      'url' => '#',
     *      'badge' => '2'
     *    ],
     *    [
     *      'content' => ['heading' => 'Heading 2', 'body' => 'Morbi leo risus'],
     *      'url' => '#',
     *      'badge' => '1'
     *    ],
     * ]);
     * ~~~
     *
     * @return string
     */
    public static function listGroup($items = [], $options = [], $tag = 'div', $itemTag = 'div')
    {
        static::addCssClass($options, 'list-group');
        $content = '';
        foreach ($items as $item) {
            $content .= static::getListGroupItem($item, $itemTag) . "\n";
        }
        return static::tag($tag, $content, $options);
    }

    /**
     * Processes and generates each list group item
     *
     * @param array  $item the list item configuration.  The following array key properties can be setup:
     *      - `content`: mixed, the list item content. When passed as a string, it will display this directly as a raw
     *          content. When passed as an array, it requires these keys
     *          - `heading`: string, the content heading (optional).
     *          - `body`: string, the content body (optional).
     *          - `headingOptions`: array, the HTML attributes / options for heading container (optional).
     *          - `bodyOptions`: array, the HTML attributes / options for body container (optional).
     *      - `url`: string|array, the url for linking the list item content (optional).
     *      - `badge`: string, any badge content to be displayed for this list item (optional)
     *      - `badgeOptions`: array, the HTML attributes / options for badge container (optional).
     *      - `active`: bool, to highlight the item as active (applicable only if $url is passed). Defaults to `false`.
     *      - `options`: array, HTML attributes / options for the list group item container (optional).
     * @param string $tag the list item container tag (applied if it is not a link)
     *
     * @return string
     */
    protected static function getListGroupItem($item, $tag)
    {
        static::addCssClass($item['options'], 'list-group-item');
        $heading = $body = $badge = $content = $url = $active = '';
        $options = $headingOptions = $bodyOptions = $badgeOptions = [];
        extract($item);
        if (is_array($content)) {
            extract($content);
            if (!Enum::isEmpty($heading)) {
                static::addCssClass($headingOptions, 'list-group-item-heading');
                $heading = static::tag('h4', $heading, $headingOptions);
            }
            if (!Enum::isEmpty($body)) {
                static::addCssClass($bodyOptions, 'list-group-item-text');
                $body = static::tag('p', $body, $bodyOptions);
            }
            $content = $heading . "\n" . $body;
        }
        if (!Enum::isEmpty($badge)) {
            $content = static::badge($badge, $badgeOptions) . $content;
        }
        if (!Enum::isEmpty($url)) {
            if ($active) {
                static::addCssClass($options, 'active');
            }
            return static::a($content, $url, $options);
        } else {
            return static::tag($tag, $content, $options);
        }
    }

    /**
     * Generates a jumbotron - a lightweight, flexible component that can optionally extend the entire viewport to
     * showcase key content on your site.
     *
     * @see http://getbootstrap.com/components/#jumbotron
     *
     * @param mixed $content the list item content. When passed as a string, it will display this directly as a raw
     *     content. When passed as an array, it requires these keys
     *      - `heading`: string, the jumbotron heading title
     *      - `body`: string, the jumbotron content body
     *      - `buttons`: array, the configuration for jumbotron buttons. The following properties can be set:
     *              - `label`: string, the button label
     *              - `icon`: string, the icon to place before the label
     *              - `url`: mixed, the button url
     *              - `type`: string, one of the bootstrap color modifier constants. Defaults to `Html::TYPE_DEFAULT`.
     *              - `size`: string, one of the size modifier constants
     *              - `options`: array, the HTML attributes / options for the button.
     * @param bool  $fullWidth whether this is a full width jumbotron without any corners. Defaults to `false`.
     * @param array $options HTML attributes / options for the jumbotron container
     *
     * Example(s):
     * ~~~
     * echo Html::jumbotron(
     *      '<h1>Hello, world</h1><p>This is a simple jumbotron-style component for calling extra attention to featured
     *     content or information.</p>'
     * );
     * echo Html::jumbotron(
     *  [
     *      'heading' => 'Hello, world!',
     *      'body' => 'This is a simple jumbotron-style component for calling extra attention to featured content or
     *     information.'
     *    ]
     * );
     * echo Html::jumbotron([
     *      'heading' => 'Hello, world!',
     *      'body' => 'This is a simple jumbotron-style component for calling extra attention to featured content or
     *     information.',
     *      'buttons' => [
     *          [
     *              'label' => 'Learn More',
     *              'icon' => 'book',
     *              'url' => '#',
     *              'type' => Html::TYPE_PRIMARY,
     *              'size' => Html::LARGE
     *          ],
     *          [
     *              'label' => 'Contact Us',
     *              'icon' => 'phone',
     *              'url' => '#',
     *              'type' => Html::TYPE_DANGER,
     *              'size' => Html::LARGE
     *          ]
     *      ]
     * ]);
     * ~~~
     *
     * @return string
     */
    public static function jumbotron($content = [], $fullWidth = false, $options = [])
    {
        static::addCssClass($options, 'jumbotron');
        if (is_string($content)) {
            $html = $content;
        } else {
            $html = isset($content['heading']) ? "<h1>" . $content['heading'] . "</h1>\n" : '';
            $body = isset($content['body']) ? $content['body'] . "\n" : '';
            if (substr(preg_replace('/\s+/', '', $body), 0, 3) != '<p>') {
                $body = static::tag('p', $body);
            }
            $html .= $body;
            $buttons = '';
            if (isset($content['buttons'])) {
                foreach ($content['buttons'] as $btn) {
                    $label = (isset($btn['icon']) ? Html::icon($btn['icon']) . ' ' : '') . (isset($btn['label']) ? $btn['label'] : '');
                    $url = isset($btn['url']) ? $btn['url'] : '#';
                    $btnOptions = isset($btn['options']) ? $btn['options'] : [];
                    $class = 'btn' . (isset($btn['type']) ? ' btn-' . $btn['type'] : ' btn-' . self::TYPE_DEFAULT);
                    $class .= isset($btn['size']) ? ' btn-' . $btn['size'] : '';
                    static::addCssClass($btnOptions, $class);
                    $buttons .= Html::a($label, $url, $btnOptions) . " ";
                }
            }
            $html .= Html::tag('p', $buttons);
        }

        if ($fullWidth) {
            return static::tag('div', static::tag('div', $html, ['class' => 'container']), $options);
        } else {
            return static::tag('div', $html, $options);
        }
    }

    /**
     * Generates a panel for boxing content.
     *
     * @see http://getbootstrap.com/components/#panels
     *
     * @param array  $content the panel content configuration. The following properties can be setup:
     *    - `preHeading`: string, raw content that will be placed before `heading` (optional).
     *    - `heading`: string, the panel box heading (optional).
     *    - `preBody`: string, raw content that will be placed before $body (optional).
     *    - `body`: string, the panel body content - this will be wrapped in a "panel-body" container (optional).
     *    - `postBody`: string, raw content that will be placed after $body (optional).
     *    - `footer`: string, the panel box footer (optional).
     *    - `postFooter`: string, raw content that will be placed after $footer (optional).
     *    - `headingTitle`: bool, whether to pre-style heading content with a '.panel-title' class. Defaults to
     *     `false`.
     *    - `footerTitle`: bool, whether to pre-style footer content with a '.panel-title' class. Defaults to `false`.
     * @param string $type the panel type which can be one of the bootstrap color modifier constants. Defaults to
     *     `default`.
     *    - `Html::TYPE_DEFAULT` or `default`
     *    - `Html::TYPE_PRIMARY` or `primary`
     *    - `Html::TYPE_SUCCESS` or `success`
     *    - `Html::TYPE_INFO` or `info`
     *    - `Html::TYPE_WARNING` or `warning`
     *    - `Html::TYPE_DANGER` or `danger`
     * @param array  $options HTML attributes / options for the panel container
     * @param string $prefix the CSS prefix for panel type. Defaults to `panel panel-`.
     *
     * @return string
     */
    public static function panel($content = [], $type = 'default', $options = [], $prefix = 'panel panel-')
    {
        if (!is_array($content)) {
            return '';
        } else {
            static::addCssClass($options, $prefix . $type);
            $panel = static::getPanelContent($content, 'preHeading') .
                static::getPanelTitle($content, 'heading') .
                static::getPanelContent($content, 'preBody') .
                static::getPanelContent($content, 'body') .
                static::getPanelContent($content, 'postBody') .
                static::getPanelTitle($content, 'footer') .
                static::getPanelContent($content, 'postFooter');
            return static::tag('div', $panel, $options);
        }
    }

    /**
     * Generates panel content
     *
     * @param array  $content the panel content components.
     * @param string $type one of the content settings
     *
     * @return string
     */
    protected static function getPanelContent($content, $type)
    {
        $out = ArrayHelper::getValue($content, $type, '');
        return !Enum::isEmpty($out) ? $out . "\n" : '';
    }

    /**
     * Generates panel title for heading and footer.
     *
     * @param array  $content the panel content settings.
     * @param string $type whether `heading` or `footer`
     *
     * @return string
     */
    protected static function getPanelTitle($content, $type)
    {
        $title = ArrayHelper::getValue($content, $type, '');
        if (!Enum::isEmpty($title)) {
            if (ArrayHelper::getValue($content, "{$type}Title", true) === true) {
                $title = static::tag("h3", $title, ["class" => "panel-title"]);
            }
            return static::tag("div", $title, ["class" => "panel-{$type}"]) . "\n";
        } else {
            return '';
        }
    }

    /**
     * Generates a page header.
     *
     * @see http://getbootstrap.com/components/#page-header
     *
     * @param string $title the title to be shown
     * @param string $subTitle the subtitle to be shown as subtext within the title
     * @param array  $options HTML attributes/ options for the page header
     *
     * Example(s):
     * ~~~
     * echo Html::pageHeader(
     *    'Example page header',
     *    'Subtext for header'
     * );
     * ~~~
     *
     * @return string
     */
    public static function pageHeader($title, $subTitle = '', $options = [])
    {
        static::addCssClass($options, 'page-header');
        if (!Enum::isEmpty($subTitle)) {
            $title = "<h1>{$title} <small>{$subTitle}</small></h1>";
        } else {
            $title = "<h1>{$title}</h1>";
        }
        return static::tag('div', $title, $options);
    }

    /**
     * Generates a well container.
     *
     * @see http://getbootstrap.com/components/#wells
     *
     * @param string $content the content
     * @param string $size the well size. Should be one of the bootstrap size modifiers:
     *      - `Html::SIZE_TINY` or `xs`
     *      - `Html::SIZE_SMALL` or `sm`
     *      - `Html::SIZE_MEDIUM` or `md`
     *      - `Html::SIZE_LARGE` or `lg`
     * @param array  $options HTML attributes / options for the well container.
     *
     * @return string
     */
    public static function well($content, $size = '', $options = [])
    {
        static::addCssClass($options, 'well');
        if (!Enum::isEmpty($size)) {
            static::addCssClass($options, 'well-' . $size);
        }
        return static::tag('div', $content, $options);
    }

    /**
     * Generates a bootstrap media object. Abstract object styles for building various types of components (like blog
     * comments, Tweets, etc) that feature a left-aligned or right-aligned  image alongside textual content.
     *
     * @see http://getbootstrap.com/components/#media
     *
     * @param string $heading the media heading.
     * @param string $body the media content.
     * @param mixed  $src URL for the media article source.
     * @param mixed  $img URL for the media image source.
     * @param array  $srcOptions html options for the media article link.
     * @param array  $imgOptions html options for the media image.
     * @param array  $headingOptions HTML attributes / options for the media object heading container.
     * @param array  $bodyOptions HTML attributes / options for the media object body container.
     * @param array  $options HTML attributes / options for the media object container.
     * @param string $tag the media container tag. Defaults to 'div'.
     *
     * Example(s):
     * ~~~
     * echo Html::media(
     *    'Media heading 1',
     *    'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.',
     *    '#',
     *    'http://placehold.it/64x64'
     * );
     * ~~~
     *
     * @return string
     */
    public static function media(
        $heading = '',
        $body = '',
        $src = '',
        $img = '',
        $srcOptions = [],
        $imgOptions = [],
        $headingOptions = [],
        $bodyOptions = [],
        $options = [],
        $tag = 'div'
    ) {
        static::addCssClass($options, 'media');
        if (!isset($srcOptions['class'])) {
            static::addCssClass($srcOptions, 'pull-left');
        }
        static::addCssClass($imgOptions, 'media-object');
        static::addCssClass($headingOptions, 'media-heading');
        static::addCssClass($bodyOptions, 'media-body');
        $source = static::a(static::img($img, $imgOptions), $src, $srcOptions);
        $heading = !Enum::isEmpty($heading) ? static::tag('h4', $heading, $headingOptions) : '';
        $content = !Enum::isEmpty($body) ? static::tag('div', $heading . "\n" . $body, $bodyOptions) : $heading;
        return static::tag($tag, $source . "\n" . $content, $options);
    }

    /**
     * Generates bootstrap list of media (useful for comment threads or articles lists).
     *
     * @see http://getbootstrap.com/components/#media
     *
     * @param array $items the configuration of media items. The following properties can be set as array keys:
     *  - `items`: array, the sub media items (similar in configuration to items) (optional)
     *  - `heading`: string, the media heading
     *  - `body`: string, the media content
     *  - `src`: mixed, URL for the media article source
     *  - `img`: mixed, URL for the media image source
     *  - `srcOptions`: array, HTML attributes / options for the media article link (optional)
     *  - `imgOptions`: array, HTML attributes / options for the media image (optional)
     *  - `headingOptions`: array, HTML attributes / options for the media heading (optional)
     *  - `bodyOptions`: array, HTML attributes / options for the media body (optional)
     *  - `options`: array, HTML attributes / options for each media item (optional)
     * @param array $options HTML attributes / options for the media list container
     *
     * Example(s):
     * ~~~
     * echo Html::mediaList([
     *    [
     *      'heading' => 'Media heading 1',
     *      'body' => 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin
     *     commodo. '.
     *          'Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.',
     *      'src' => '#',
     *      'img' => 'http://placehold.it/64x64',
     *      'items' => [
     *          [
     *              'heading' => 'Media heading 1.1',
     *              'body' => 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
     *     sollicitudin commodo. ' .
     *                  'Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.',
     *              'src' => '#',
     *              'img' => 'http://placehold.it/64x64'
     *          ],
     *          [
     *              'heading' => 'Media heading 1.2',
     *              'body' => 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
     *     sollicitudin commodo. ' .
     *                  'Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.',
     *              'src' => '#',
     *              'img' => 'http://placehold.it/64x64'
     *          ],
     *      ]
     *    ],
     *  [
     *      'heading' => 'Media heading 2',
     *      'body' => 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin
     *     commodo. '.
     *          'Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.',
     *      'src' => '#',
     *      'img' => 'http://placehold.it/64x64'
     *    ],
     * ]);
     * ~~~
     *
     * @return string
     */
    public static function mediaList($items = [], $options = [])
    {
        static::addCssClass($options, 'media-list');
        $content = static::getMediaList($items);
        return static::tag('ul', $content, $options);
    }

    /**
     * Processes media items array to generate a recursive list.
     *
     * @param array   $items the media items
     * @param boolean $top whether item is the topmost parent
     *
     * @return string
     */
    protected static function getMediaList($items, $top = true)
    {
        $content = '';
        foreach ($items as $item) {
            $tag = $top ? 'li' : 'div';
            if (isset($item['items'])) {
                $item['body'] .= static::getMediaList($item['items'], false);
            }
            $content .= static::getMediaItem($item, $tag) . "\n";
        }
        return $content;
    }

    /**
     * Processes and generates each media item
     *
     * @param array  $item the media item configuration
     * @param string $tag the media item container tag
     *
     * @return string
     */
    protected static function getMediaItem($item = [], $tag = 'div')
    {
        $heading = $body = $img = '';
        $src = '#';
        $srcOptions = $imgOptions = $options = $headingOptions = $bodyOptions = [];
        extract($item);
        return static::media(
            $heading,
            $body,
            $src,
            $img,
            $srcOptions,
            $imgOptions,
            $headingOptions,
            $bodyOptions,
            $options,
            $tag
        );
    }

    /**
     * Generates a generic bootstrap close icon button for dismissing content like modals and alerts.
     *
     * @see http://getbootstrap.com/css/#helper-classes-close
     *
     * @param string $label the close icon label. Defaults to `&times;`.
     * @param array  $options HTML attributes / options for the close icon button.
     * @param string $tag the HTML tag for rendering the close icon. Defaults to `button`.
     *
     * Example(s):
     * ~~~
     * echo Html::closeButton();
     * echo Html::closeButton(Html::icon('remove-sign');
     * ~~~
     *
     * @return string
     */
    public static function closeButton($label = '&times;', $options = [], $tag = 'button')
    {
        static::addCssClass($options, 'close');
        if ($tag == 'button') {
            $options['type'] = 'button';
        }
        $options['aria-hidden'] = 'true';
        return static::tag($tag, $label, $options);
    }

    /**
     * Generates a bootstrap caret.
     *
     * @see http://getbootstrap.com/css/#helper-classes-carets
     *
     * @param string  $direction whether to display as 'up' or 'down' direction. Defaults to `down`.
     * @param boolean $disabled if the caret is to be displayed as disabled. Defaults to `false`.
     * @param array   $options html options for the caret container.
     * @param string  $tag the html tag for rendering the caret. Defaults to `span`.
     *
     * Example(s):
     * ~~~
     * echo 'Down Caret ' . Html::caret();
     * echo 'Up Caret ' . Html::caret('up');
     * echo 'Disabled Caret ' . Html::caret('down', true);
     * ~~~
     *
     * @return string
     */
    public static function caret($direction = 'down', $disabled = false, $options = [], $tag = 'span')
    {
        static::addCssClass($options, 'caret');

        if (!isset($options['style'])) {
            $options['style'] = 'margin-bottom: 3px;';
        }

        if ($disabled) {
            $options['style'] = $options['style'] . ';  border-top-color: #bbb; border-bottom-color: #bbb;';
        }

        if ($direction == 'up') {
            return static::tag($tag, static::tag($tag, '', $options), ['class' => 'dropup']);
        } else {
            return static::tag($tag, '', $options);
        }
    }

    /**
     * Generates a bootstrap abbreviation.
     *
     * @see http://getbootstrap.com/css/#type-abbreviations
     *
     * @param string  $content the abbreviation content
     * @param string  $title the abbreviation title
     * @param boolean $initialism if set to true, will display a slightly smaller font-size.
     * @param array   $options html options for the abbreviation
     *
     * Example(s):
     * ~~~
     * echo Html::abbr('HTML', 'HyperText Markup Language')  . ' is the best thing since sliced bread';
     * echo Html::abbr('HTML', 'HyperText Markup Language', true);
     * ~~~
     *
     * @return string
     */
    public static function abbr($content, $title, $initialism = false, $options = [])
    {
        $options['title'] = $title;
        if ($initialism) {
            static::addCssClass($options, 'initialism');
        }
        return static::tag('abbr', $content, $options);
    }

    /**
     * Generates a bootstrap blockquote.
     *
     * @see http://getbootstrap.com/css/#type-blockquotes
     *
     * @param string $content the blockquote content
     * @param string $citeContent the content of the citation (optional) - this should typically include the tag
     *     '{source}' to embed the cite source
     * @param string $citeTitle the cite source title (optional)
     * @param string $citeSource the cite source (optional)
     * @param array  $options html options for the blockquote
     *
     * Example(s):
     * ~~~
     * echo Html::blockquote(
     *      'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.',
     *      'Someone famous in {source}',
     *      'International Premier League',
     *      'IPL'
     * );
     * ~~~
     *
     * @return string
     */
    public static function blockquote($content, $citeContent = '', $citeTitle = '', $citeSource = '', $options = [])
    {
        $content = static::tag('p', $content);
        if (!Enum::isEmpty($citeContent)) {
            $source = static::tag('cite', $citeSource, ['title' => $citeTitle]);
            $content .= "\n<small>" . str_replace('{source}', $source, $citeContent) . "</small>";
        }
        return static::tag('blockquote', $content, $options);
    }

    /**
     * Generates a bootstrap address block.
     *
     * @see http://getbootstrap.com/css/#type-addresses
     *
     * @param string $name the addressee name
     * @param array  $lines the lines of address information
     * @param array  $phone the list of phone numbers - passed as $key => $value, where:
     *    - `$key`: string, is the phone type could be 'Res', 'Off', 'Cell', 'Fax'
     *    - `$value`: string, is the phone number
     * @param array  $email the list of email addresses - passed as $key => $value, where:
     *    - `$key`: string, is the email type could be 'Res', 'Off'
     *    - `$value`: string, is the email address
     * @param array  $options html options for the address
     * @param string $phoneLabel the prefix label for each phone - defaults to '(P)'
     * @param string $emailLabel the prefix label for each email - defaults to '(E)'
     *
     * Example(s):
     * ~~~
     * echo Html::address(
     *      'Twitter, Inc.',
     *      ['795 Folsom Ave, Suite 600', 'San Francisco, CA 94107'],
     *      ['Res' => '(123) 456-7890', 'Off'=> '(456) 789-0123'],
     *      ['Res' => 'first.last@example.com', 'Off' => 'last.first@example.com']
     * );
     * $address = Html::address(
     *      'Twitter, Inc.',
     *      ['795 Folsom Ave, Suite 600', 'San Francisco, CA 94107'],
     *      ['Res' => '(123) 456-7890', 'Off'=> '(456) 789-0123'],
     *      ['Res' => 'first.last@example.com', 'Off' => 'last.first@example.com'],
     *      Html::icon('phone'),
     *      Html::icon('envelope')
     * );
     * echo Html::well($address, Html::SIZE_TINY);
     * ~~~
     *
     * @return string
     */
    public static function address(
        $name,
        $lines = [],
        $phone = [],
        $email = [],
        $options = [],
        $phoneLabel = '(P)',
        $emailLabel = '(E)'
    ) {
        Enum::initI18N();
        $addresses = '';
        if (!Enum::isEmpty($lines)) {
            $addresses = implode('<br>', $lines) . "<br>\n";
        }

        $phones = '';
        foreach ($phone as $type => $number) {
            if (is_numeric($type)) { // no keys were passed to the phone array
                $type = static::tag('abbr', $phoneLabel, ['title' => Yii::t('kvenum', 'Phone')]) . ': ';
            } else {
                $type = static::tag('abbr', $phoneLabel . ' ' . $type, ['title' => Yii::t('kvenum', 'Phone')]) . ': ';
            }
            $phones .= "{$type}{$number}<br>\n";
        }

        $emails = '';
        foreach ($email as $type => $addr) {
            if (is_numeric($type)) { // no keys were passed to the email array
                $type = Html::tag('abbr', $emailLabel, ['title' => Yii::t('kvenum', 'Email')]) . ': ';
            } else {
                $type = Html::tag('abbr', $emailLabel . ' ' . $type, ['title' => Yii::t('kvenum', 'Email')]) . ': ';
            }
            $emails .= $type . static::mailto($addr, $addr) . "<br>\n";
        }
        return static::tag('address', "<strong>{$name}</strong><br>\n" . $addresses . $phones . $emails, $options);
    }

    /**
     * Generates a bootstrap toggle button group (checkbox or radio type)
     *
     * @see http://getbootstrap.com/javascript/#buttons-checkbox-radio
     *
     * @param string       $type whether checkbox or radio.
     * @param string       $name the name attribute of each checkbox.
     * @param string|array $selection the selected value(s).
     * @param array        $items the data item used to generate the checkboxes/radios. The array keys are the
     *     checkbox/radio values, while the array values are the corresponding labels.
     * @param array        $options options (name => config) for the checkbox/radio list container tag. The following
     *     options are specially handled:
     * - tag: string, the tag name of the container element.
     * - unselect: string, the value that should be submitted when none of the checkboxes/radios is selected. By
     *     setting this option, a hidden input will be generated.
     * - encode: boolean, whether to HTML-encode the checkbox/radio labels. Defaults to `true`. This option is ignored
     *     if `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the checkbox/radio tag using [[checkbox/radio()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code corresponding to a
     *     single item in $items. The signature of this callback must be:
     *
     *   ~~~
     *   function ($index, $label, $name, $checked, $value)
     *   ~~~
     *
     *   where $index is the zero-based index of the checkbox/radio in the whole list; $label is the label for the
     *     checkbox/radio; and $name, $value and $checked represent the name, value and the checked status of the
     *     checkbox/radio input, respectively.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated toggle button group
     */
    public static function getButtonGroup($type, $name, $selection = null, $items = [], $options = [])
    {
        $class = $type . 'List';
        static::addCssClass($options, 'btn-group');
        $options['data-toggle'] = 'buttons';
        $options['inline'] = true;
        if (!isset($options['itemOptions']['labelOptions']['class'])) {
            $options['itemOptions']['labelOptions']['class'] = 'btn btn-default';
        }
        /** @noinspection PhpUnusedParameterInspection */
        /**
         * @param string $index
         * @param string $label
         * @param string $name
         * @param bool   $checked
         * @param string $value
         */
        $options['item'] = function ($index, $label, $name, $checked, $value) use ($type, $options) {
            $opts = isset($options['itemOptions']) ? $options['itemOptions'] : [];
            $encode = !isset($options['encode']) || $options['encode'];
            if (!isset($opts['labelOptions'])) {
                $opts['labelOptions'] = ArrayHelper::getValue($options, 'itemOptions.labelOptions', []);
            }
            if ($checked) {
                Html::addCssClass($opts['labelOptions'], 'active');
            }
            return static::$type($name, $checked, array_merge($opts, [
                'value' => $value,
                'label' => $encode ? static::encode($label) : $label,
            ]));
        };
        return static::$class($name, $selection, $items, $options);
    }

    /**
     * Generates a bootstrap checkbox button group. A checkbox button group allows multiple selection,
     * like [[listBox()]]. As a result, the corresponding submitted value is an array.
     *
     * @see http://getbootstrap.com/javascript/#buttons-checkbox-radio
     *
     * @param string $name the name attribute of each checkbox.
     * @param mixed  $selection the selected value(s).
     * @param array  $items the data item used to generate the checkboxes. The array keys are the checkbox values,
     *     while the array values are the corresponding labels.
     * @param array  $options options (name => config) for the checkbox list container tag. The following options are
     *     specially handled:
     * - tag: string, the tag name of the container element.
     * - unselect: string, the value that should be submitted when none of the checkboxes is selected.
     *   By setting this option, a hidden input will be generated.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to true.
     *   This option is ignored if `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the checkbox tag using [[checkbox()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code
     *   corresponding to a single item in $items. The signature of this callback must be:
     *
     *   ~~~
     *   function ($index, $label, $name, $checked, $value)
     *   ~~~
     *
     *   where $index is the zero-based index of the checkbox in the whole list; $label is the label for the checkbox;
     *     and $name, $value and $checked represent the name, value and the checked status of the checkbox input,
     *     respectively.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated checkbox button group
     */
    public static function checkboxButtonGroup($name, $selection = null, $items = [], $options = [])
    {
        return static::getButtonGroup('checkbox', $name, $selection, $items, $options);
    }

    /**
     * Generates a bootstrap radio button group. A radio button group is like a checkbox button group, except that it
     * only allows single selection.
     *
     * @see http://getbootstrap.com/javascript/#buttons-checkbox-radio
     *
     * @param string $name the name attribute of each radio.
     * @param mixed  $selection the selected value(s).
     * @param array  $items the data item used to generate the radios. The array keys are the radio values, while the
     *     array values are the corresponding labels.
     * @param array  $options options (name => config) for the radio list container tag. The following options are
     *     specially handled:
     *
     * - tag: string, the tag name of the container element.
     * - unselect: string, the value that should be submitted when none of the radios is selected. By setting this
     *     option, a hidden input will be generated.
     * - encode: boolean, whether to HTML-encode the radio labels. Defaults to `true`. This option is ignored if `item`
     *     option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the radio tag using [[radio()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code corresponding to a
     *     single item in $items. The signature of this callback must be:
     *
     *   ~~~
     *   function ($index, $label, $name, $checked, $value)
     *   ~~~
     *
     *   where $index is the zero-based index of the radio in the whole list; $label is the label for the radio; and
     *     $name, $value and $checked represent the name, value and the checked status of the radio input,
     *     respectively.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated radio button group
     */
    public static function radioButtonGroup($name, $selection = null, $items = [], $options = [])
    {
        return static::getButtonGroup('radio', $name, $selection, $items, $options);
    }

    /**
     * Generates an active bootstrap checkbox button group. A checkbox button group allows multiple selection, like
     * [[listBox()]]. As a result, the corresponding submitted value is an array. The selection of the checkbox button
     * group is taken from the value of the model attribute.
     *
     * @see http://getbootstrap.com/javascript/#buttons-checkbox-radio
     *
     * @param Model  $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format about
     *     attribute expression.
     * @param array  $items the data item used to generate the checkboxes. The array keys are the checkbox values, and
     *     the array values are the corresponding labels. Note that the labels will NOT be HTML-encoded, while the
     *     values will.
     * @param array  $options options (name => config) for the checkbox list container tag. The following options are
     *     specially handled:
     *
     * - tag: string, the tag name of the container element.
     * - unselect: string, the value that should be submitted when none of the checkboxes is selected. You may set this
     *     option to be null to prevent default value submission. If this option is not set, an empty string will be
     *     submitted.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to `true`. This option is ignored if
     *     `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the checkbox tag using [[checkbox()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code corresponding to a
     *     single item in $items. The signature of this callback must be:
     *
     *   ~~~
     *   function ($index, $label, $name, $checked, $value)
     *   ~~~
     *
     *   where $index is the zero-based index of the checkbox in the whole list; $label is the label for the checkbox;
     *     and $name, $value and $checked represent the name, value and the checked status of the checkbox input.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated bootstrap checkbox button group
     */
    public static function activeCheckboxButtonGroup($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('checkboxButtonGroup', $model, $attribute, $items, $options);
    }

    /**
     * Generates an active bootstrap radio button group. A radio button group is like a checkbox button group, except
     * that it only allows single selection. The selection of the radio buttons is taken from the value of the model
     * attribute.
     *
     * @see http://getbootstrap.com/javascript/#buttons-checkbox-radio
     *
     * @param Model  $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format about
     *     attribute expression.
     * @param array  $items the data item used to generate the radio buttons. The array keys are the radio values, and
     *     the array values are the corresponding labels. Note that the labels will NOT be HTML-encoded, while the
     *     values will.
     * @param array  $options options (name => config) for the radio button list container tag.
     * The following options are specially handled:
     *
     * - tag: string, the tag name of the container element.
     * - unselect: string, the value that should be submitted when none of the radio buttons is selected. You may set
     *     this option to be null to prevent default value submission. If this option is not set, an empty string will
     *     be submitted.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to `true`. This option is ignored if
     *     `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the radio button tag using [[radio()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code corresponding to a
     *     single item in $items. The signature of this callback must be:
     *
     *   ~~~
     *   function ($index, $label, $name, $checked, $value)
     *   ~~~
     *
     *   where $index is the zero-based index of the radio button in the whole list; $label is the label for the radio
     *     button; and $name, $value and $checked represent the name, value and the checked status of the radio button
     *     input.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated bootstrap radio button group
     */
    public static function activeRadioButtonGroup($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('radioButtonGroup', $model, $attribute, $items, $options);
    }
}
