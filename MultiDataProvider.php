<?php

namespace karataserkan\yii2MultiDataProvider;

use yii\data\ArrayDataProvider;

class MultiDataProvider extends ArrayDataProvider implements \Iterator
{
    public $dataProviders = [];
    public $modelCallback = false;
    private $page = 0;

    public function rewind()
    {
        $this->page = 0;
    }

    public function current()
    {
        ob_start();
        if (!$this->allModels) {
            $this->updatePagination();
        }
        $all = $this->allModels;
        $this->allModels = [];

        return $all;
    }

    public function key()
    {
        return $this->page;
    }

    public function updatePagination()
    {
        $pagination = $this->getPagination();
        $pagination->setPage($this->page);
        $this->setPagination($pagination);
        $this->prepareDataProviders();
    }

    public function next()
    {
        ++$this->page;
        $this->updatePagination();

        return $this->page;
    }

    public function valid()
    {
        $pagination = $this->getPagination();

        return $this->page <= $pagination->getPageCount();
    }

    protected function prepareDataProviders()
    {
        $pagination = $this->getPagination();
        $pagination->totalCount = $this->getTotalCount();
        $page = $pagination->getPage();
        $inSpanDataproviders = [];

        $offset = $pagination->offset;
        $pageSize = $pagination->pageSize;
        $remaining = $pageSize;
        $low = $offset;
        $high = $low + $pageSize;
        $current = $pageSize;
        $collective = 0;
        foreach ($this->dataProviders as $key => $dataProvider) {
            $dptc = $dataProvider->totalCount;
            $collective += $dptc;
            $lastRemaining = $remaining;
            if ($a = ($collective >= $low)) {
                $current = $collective - $low;

                if ($lastRemaining > 0) {
                    $remaining -= $current;
                    $dpoffset = $dptc - ($collective - $offset);

                    if ($remaining < 0) {
                        $remaining = 0;
                    }
                    if ($dpoffset < 0) {
                        $dpoffset = 0;
                    }
                    $a = true;
                    $inSpanDataproviders[] = $dataProvider;
                    $dataProvider->setPagination(new PaginationWithOffset([
                        'offset' => $dpoffset,
                        'pageSize' => $lastRemaining,
                        ]));
                } else {
                    $a = false;
                }
            }

            $lastRemaining = $remaining;
            $dataProvider->prepareModels();
        }

        $models = [];
        foreach ($inSpanDataproviders as $key => $dataProvider) {
            $dataProvider->prepare(true);
            $models = array_merge($models, $dataProvider->getModels());
        }

        $this->allModels = [];
        if ($this->modelCallback && is_callable($this->modelCallback)) {
            foreach ($models as $key => $model) {
                $this->allModels[] = call_user_func($this->modelCallback, $model);
            }
        } else {
            $this->allModels = $models;
        }
    }

    protected function prepareModels()
    {
        $this->prepareDataProviders();

        return $this->allModels;
    }

    protected function prepareTotalCount()
    {
        $count = 0;

        foreach ($this->dataProviders as $key => $dataProvider) {
            $count += $dataProvider->totalCount;
        }

        return $count;
    }
}
