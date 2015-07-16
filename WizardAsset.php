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
 * Bower asset for the Twitter Bootstrap Wizard
 * @author Chofoteddy
 * @author Faryshta <angeldelcaos@gmail.com>
 */
class WizardAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/twitter-bootstrap-wizard/';
    
    /**
     * @inheritdoc
     */
    public $css = [];

    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.bootstrap.wizard.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
       'yii\web\YiiAsset',
       'yii\bootstrap\BootstrapAsset',
    ];
}
