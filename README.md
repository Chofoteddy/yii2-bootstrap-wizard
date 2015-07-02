# yii2-bootstrap-wizard
Wizard form based on twitter bootstrap plugin (@VinceG)

## Install via Composer

The first step is to install the library manager for bower

```
composer.phar global require "fxp/composer-asset-plugin:~1.0.0"
```

We now proceed to install the widget

```
composer.phar require chofoteddy/yii2-bootstrap-wizard "*"
```


## Usage

```
<?php
use chofoteddy\wizard\Wizard;

/* @var $this yii\web\View */
?>

<?= Wizard::widget([
    'items' => [
        // wizard step
        [
            'label' => 'Collapsible Group Item #1',
            'content' => 'Anim pariatur cliche...',
        ],
        // another wizard step
        [
            'label' => 'Collapsible Group Item #1',
            'content' => 'Anim pariatur cliche...',
            'options' => [...],
        ],
    ]
]); ?>
```

## Documentation

Wizard renders a wizard bootstrap javascript component.

### Public properties

| Property        | Type    | Description                                                   |
|-----------------|---------|---------------------------------------------------------------|
| $items          | array   | list of groups in the wizard widget.                          |
| $itemOptions    | array   | list of HTML attributes for the item container tags.          |
| $labelOptions   | array   | list of HTML attributes for the item container tags.          |
| $linkOptions    | array   | list of HTML attributes for the tab header link tags.         |
| $headerOptions  | array   | list of HTML attributes for the header container tags.        |
| $navOptions     | array   | options to get passed to the \yii\bootstrap\Nav widget.       |
| $encodeLabels   | boolean | whether the labels for header items should be HTML-encoded.   |

### Methods

| Method          | Description                                         |
|-----------------|-----------------------------------------------------|
| init()          | Initializes the widget.                             |
| run()           | Executes the widget.                                |
| renderItems()   | Renders wizard items as specified on [[items]].     |
