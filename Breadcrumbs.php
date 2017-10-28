<?php
/**
 * @link http://nivans.pro/
 * @copyright Copyright (c) 2017 Nivans
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 */

namespace nivans\Bs4Breadcrumbs;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Breadcrumbs
 * @package nivans\Bs4Breadcrumbs
 */
class Breadcrumbs extends Widget
{
    /**
     * @var array of the HTML atts which will be rendered on breadcrumbs container
     */
    public $options = [];
    /**
     * @var bool whether to HTML-encode the link labels.
     */
    public $encodeLabels = true;

    /**
     * @var first item for the breadcrumbs
     * If it needs to change home item in the breadcrumbs
     * that it possible to be installed by this option
     */
    public $homeLink;

    /**
     * @var array links path for the breadcrumb
     */
    public $links = [];

    /**
     * @var string template of an inactive breadcrumb list element
     */
    protected $itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";

    /**
     * @var string template of an active breadcrumb list element
     */
    protected $activeItemTemplate = "<li class=\"breadcrumb-item active\">{link}</li>\n";


    /**
     * Renders the widget.
     */
    public function run()
    {
        if ( empty($this->links) )
            return;

        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link))
                $link = ['label' => $link];

            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        $options = array_merge($this->options, ['aria-label' => 'breadcrumb', 'role' => 'navigation']);
        $list = Html::tag("ol", implode('', $links), ['class' => 'breadcrumb']);
        echo Html::tag("nav", $list, $options);
    }

    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }
        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }
        return strtr($template, ['{link}' => $link]);
    }
}
