<?php

namespace karataserkan\yii2MultiDataProvider;

class PaginationWithOffset extends \yii\data\Pagination
{
    public $offset;
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
    public function getOffset()
    {
        return $this->offset;
    }
}
