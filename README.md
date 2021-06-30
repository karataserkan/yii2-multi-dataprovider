
# yii2 Multi DataProvider
gets data from multiple dataproviders

[![Latest Stable Version](http://poser.pugx.org/karataserkan/yii2-multi-dataprovider/v)](https://packagist.org/packages/karataserkan/yii2-multi-dataprovider) [![Total Downloads](http://poser.pugx.org/karataserkan/yii2-multi-dataprovider/downloads)](https://packagist.org/packages/karataserkan/yii2-multi-dataprovider) [![Monthly Downloads](http://poser.pugx.org/karataserkan/yii2-multi-dataprovider/d/monthly)](https://packagist.org/packages/karataserkan/yii2-multi-dataprovider) [![License](http://poser.pugx.org/karataserkan/yii2-multi-dataprovider/license)](https://packagist.org/packages/karataserkan/yii2-multi-dataprovider)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require karataserkan/yii2-multi-dataprovider
```

or add

```
"karataserkan/yii2-multi-dataprovider": "*"
```

to the `require` section of your `composer.json` file.

## Usage

```php
use karataserkan\yii2MultiDataProvider\MultiDataProvider;

$data1 = new ActiveDataProvider([
    'query' => $query,
]);

$data2 = new ArrayDataProvider([
    'allModels' => [...],
]);

$dataProvider = new MultiDataProvider([
    'dataProviders' => [$data1,$data2],
]);
```

```php
$dataProvider = new MultiDataProvider([
    'dataProviders' => [$data1,$data2],
    'modelCallback' => function ($model) {
        return new YourModel(['data' => $model]);
    },
]);
```
## Contributing

1. Fork it ( https://github.com/karataserkan/yii2-multi-dataprovider/fork )
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create a new Pull Request

## Credits

- [Erkan Karataş](https://github.com/karataserkan)


