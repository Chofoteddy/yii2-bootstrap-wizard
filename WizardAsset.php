<?php
/**
 * @link https://github.com/Chofoteddy/yii2-bootstrap-wizard
 * @copyright Copyright (c) 215 Chofoteddy
 * @license https://raw.githubusercontent.com/Chofoteddy/yii2-bootstrap-wizard/master/LICENSE
 */

namespace chofoteddy\wizard;

use Yii;
use yii\helpers\ArrayHelper;

/**
* @author Chofoteddy
*/
class WizardAsset extends \yii\web\AssetBundle
{
    public $baseUr = '@vendor/chofoteddy/VinceG/twitter-bootstrap-wizard/';
    
    public $css = [];

    public $js = [
        'jquery.bootstrap.wizard.min.js'
    ];

    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
    ];
}