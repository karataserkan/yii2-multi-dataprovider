# yii2-multi-dataprovider
gets data from multiple dataproviders

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
    'dataProviders' => $dataProviders,
    'modelCallback' => function ($model) {
        return new YourModel(['data' => $model]);
    },
]);
```
