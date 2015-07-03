<?php
/**
 * @link https://github.com/Chofoteddy/yii2-bootstrap-wizard
 * @copyright Copyright (c) 2015 Chofoteddy
 * @license https://raw.githubusercontent.com/Chofoteddy/yii2-bootstrap-wizard/master/LICENSE
 */

namespace chofoteddy\wizard;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Wizard renders a wizard bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Wizard::widget([
 *     'items' => [
 *         // equivalent to the above
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             // open its content by default
 *             'contentOptions' => ['class' => 'in']
 *         ],
 *         // another wizard step
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             'contentOptions' => [...],
 *             'options' => [...],
 *         ],
 *         // short cut to label => content
 *         'Finished' => 'Thanks for filling your information'
 *     ]
 * ]);
 * ```
 *
 * @see http://vadimg.com/twitter-bootstrap-wizard-example/
 * @author Christopher Castaneida <chofoteddy@gmail.com>
 * @author Angel Guevara <angeldelcaos@gmail.com>
 */
class Wizard extends \yii\bootstrap\Widget
{
    /**
     * @var array|Nav configuration for the Nav header or the Nav Object
     */
    private $_nav = ['class' => 'yii\bootstrap\Nav'];

    public function setNavClass($class)
    {
        if (is_object($this->_nav)) {
            throw new InvalidConfigException(
                'The object has already being created.'
            );
        }

        $class = (string) $class;
        if (!is_subclass_of($class, Nav::className())) {
            throw new InvalidConfigException(
                "$class must extend " . Nav::className()
            );
        }

        $this->_nav['class'] = $class;
    }

    public function getNavClass()
    {
        if (is_object($this->_nav)) {
            return get_class($this->_nav);
        } else {
            return $this->_nav['class'];
        }
    }

    public function setNavObject($object)
    {
        if ($object instanceof Nav) {
            $this->_nav = $object;
        } else {
            throw new InvalidConfigException(
                'The object must be an instance of ' . Nav::className()
            );
        }
    }

    public function getNavObject($object)
    {
        $this->ensureNav();
        return $this->_nav;
    }

    public function setNavOptions(array $options)
    {
        if (is_object($this->_nav)) {
            $this->_nav->options = $options;
        } else {
            $this->_nav['options'] = $options;
        }
    }

    public function getNavOptions()
    {
        return ArrayHelper::getValue($this->_nav, 'options'); 
    }

    public function setNav($nav) {
         if (is_string($nav) {
             return $this->setNavClass($nav);
         } elseif (is_object($nav)) {
             return $this->setNavObject($nav);
         } elseif (is_array($nav)) {
             if ($class = ArrayHelper::remove($nav, 'class');
                 $this->setNavClass($class);
             }

             $this->_nav = array_merge($this->_nav, $nav);
         } else {
            throw new InvalidConfigException(
                'Expecting class string, configuration array or `Nav` object'
            );
         }
    }

    public function getNav()
    {
        $this->ensureNav();
        return $this->_nav;
    }

    public function ensureNav()
    {
        if (is_object($this->_nav)) {
            return;
        }

        $this->_nav = Yii::createObject($this->_nav);
    }

    public function navWidget()
    {
        $class = $this->getNavClass();
        return $class::widget($this->_nav);
    }

    /**
     * @var array list of groups in the wizard widget. Each array element
     * represents a single group with the following structure:
     *
     * - label: string, required, the group header label.
     * - url: string|array, optional, an external URL. When this is specified,
     *   clicking on this tab will bring
     * - encode: boolean, optional, whether this label should be HTML-encoded.
     *   This param will override global `$this->encodeLabels` param.
     * - content: array|string|object, required, the content (HTML) of the group
     * - options: array, optional, the HTML attributes of the group
     * - contentOptions: optional, the HTML attributes of the group's content
     * - visible: boolean, optional, whether the item should be visible or not.
     *   Defaults to true.
     */
    public $items = [];

    /**
     * @var array list of HTML attributes for the item container tags. This will be overwritten
     * by the "options" set in individual [[items]]. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the tag name of the item container tags.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $contentOptions = [];

    /**
     * @var array list of HTML attributes for the item container tags. This will be overwritten
     * by the "options" set in individual [[items]]. The following special options are recognized:
     *
     * - tag: string, defaults to "li", the tag name of the item container tags.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $labelOptions = [];

    /**
     * @var array list of HTML attributes for the tab header link tags. This will be overwritten
     * by the "linkOptions" set in individual [[items]].
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];

    /**
     * @var array list of HTML attributes for the header container tags.
     * The following special options are recognized:
     *
     * - tag: string, defaults to "ul", the tag name of the item container tags.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];

    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->itemOptions, ['widget' => 'tab-pane']);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        WizardAsset::register($this->view);
        $this->registerPlugin('bootstrapWizard');
        return implode("\n", [
            Html::beginTag('div', $this->options),
            $this->renderItems(),
            Html::endTag('div')
        ]);

    }

    /**
     * Renders wizard items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    public function renderItems()
    {
        $labels = [];
        $contents = [];
        $n = 0;

        foreach ($this->items as $key => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!is_string($key) && !array_key_exists('label', $item)) {
                throw new InvalidConfigException(
                    "The 'label' option is required."
                );
            }
            if (is_string($item)) {
                $item = ['content' => $item];
            }

            $label = is_string($key) ? $key : $item['label'];
            $encodeLabel = isset($item['encode'])
                ? $item['encode']
                : $this->encodeLabels;
            $label = $encodeLabel
                ? Html::encode($label)
                : $label;

            $itemOptions = array_merge(
                $this->itemOptions,
                ArrayHelper::getValue($item, 'options', [])
            );

            $labelOptions = array_merge(
                $this->labelOptions,
                ArrayHelper::getValue($item, 'labelOptions', [])
            );

            $linkOptions = array_merge(
                $this->linkOptions,
                ArrayHelper::getValue($item, 'linkOptions', [])
            );

            $itemOptions['id'] = ArrayHelper::getValue(
                $itemOptions,
                'id',
                $this->options['id'] . '-wizard' . $n
            );
            if (isset($item['url'])) {
                $labels[] = [
                    'label' => $label,
                    'url' => $item['url'],
                    'linkOptions' => $linkOptions,
                    'options' => $labelOptions,
               ];
            } else {
                $linkOptions['data-toggle'] = 'tab';
                $labels[] = [
                    'label' => $label,
                    'url' => '#' . $itemOptions['id'],
                    'linkOptions' => $linkOptions,
                    'options' => $labelOptions,
                ];
            }

            $contents[] = Html::tag(
                ArrayHelper::getValue($itemOptions, 'tag', 'div'),
                ArrayHelper::getValue($item, 'content', ''),
                $itemOptions
            );

            $n++;
        }

        $this->setNav(['items' => $labels]);

        return $this->navWidget() . Html::tag(
                'div',
                implode("\n", $contents),
                ['class' => 'tab-content']
            );
    }
}
