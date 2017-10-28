# Yii 2 Breadcrumbs for Bootstrap 4
Widget to create breadcrumbs using Bootstrap 4 markup

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nivans/yii2-bs4-breadcrumbs "*"
```

or add

```
"nivans/yii2-bs4-breadcrumbs": "*"
```

to the require section of your `composer.json` file.


## Usage

It uses by the same way as native Yii2 breadcrumbs widget.

```PHP
echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
```

## License

The GPL3 License (GPL3).
