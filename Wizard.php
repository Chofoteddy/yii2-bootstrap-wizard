<?php
/**
 * @link https://github.com/Chofoteddy/yii2-bootstrap-wizard
 * @copyright Copyright (c) 215 Chofoteddy
 * @license https://raw.githubusercontent.com/Chofoteddy/yii2-bootstrap-wizard/master/LICENSE
 */

namespace chofoteddy\wizard;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use chofoteddy\wizard\WizardAsset;

/**
* 
*/
class Wizard extends \yii\bootstrap\Widget
{
    /*private $_labels = [];
    private $_contents = [];*/
    public $items = [];
    
    public function init()
    {
        parent::init();
        //$this->registerAssets();
        //"<li><a href='#tab1' data-toggle='tab'>Prueba 1</a></li>",
    }
    public function run() {
        $id=$this->id;
        $this->registerAssets(); 
        return implode("\n", [
            Html::beginTag('div', ['id'=>$id]),
                Html::beginTag('div', ['class'=>'navbar']),
                    Html::beginTag('div', ['class'=>'nav-inner']),
                        $this->renderItems(),
                    Html::endTag('div'),
                Html::endTag('div'),
                $this->renderContents(),
            Html::endTag('div')

            ]) . "\n" ;
        
    }

    public function registerAssets()
    {
        $id=$this->id;
        $view = $this->getView();
        WizardAsset::register($view);
        $view->registerJs('$("#'.$id.'").bootstrapWizard()');  
      
    }

    public function renderItems()
    {
        $items=[];
        
        $i=0;
        foreach ($this->items as $key => $value) {
            $items[] = $this->renderItem($key, $i);
            # code...
            $i++;
        }

        //return Html::tag('div',Html::ul($this->items),['class'=>'container']);
        return Html::tag('div',Html::tag('ul', implode("\n", $items)), ['class' => 'container']);
    }

    public function renderItem($item, $index)
    {
        return
        
                 Html::tag(
                'li',
                    Html::a($item,'#tab'.$index,['data-toggle'=>'tab'])
                );
         
    }
    
    public function renderContents()
    {
        $contents=[];    


        $i=0;
        foreach ($this->items as $key => $value) {
            $contents[] = $this->renderContent($value, $i);
            # code...
            $i++;
        }

        //return Html::tag('div',Html::ul($this->items),['class'=>'container']);
        return Html::tag('div',implode("\n", $contents), ['class' => 'tab-content']);
    }
    public function renderContent($content, $index)
    {
        return
        
                 Html::tag(
                'div',
                       $content
                    ,['class'=>'tab-pane','id'=>'tab'.$index]
                );
         
    }

}

