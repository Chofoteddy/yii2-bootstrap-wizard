<?php
/**
 * @link https://github.com/Chofoteddy/yii2-bootstrap-wizard
 * @copyright Copyright (c) 215 Chofoteddy
 * @license https://raw.githubusercontent.com/Chofoteddy/yii2-bootstrap-wizard/master/LICENSE
 */

namespace chofoteddy\wizard;

use Yii;
use yii\helpers\ArrayHelper;

use chofoteddy\WizzardAsset;

/**
* 
*/
class Wizard extends \yii\bootstrap\Widget
{

    public $items = [];
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets()
    {
        $view = $this->getView();
        WizzardAsset::register( $view );
    }
}