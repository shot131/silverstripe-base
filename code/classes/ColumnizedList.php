<?php
class ColumnizedList extends SS_ListDecorator {

    private $colsNum;

    private $colSize;

    public function __construct(SS_List $list, $colsNum, $threshold = null) {
        parent::__construct($list);
        $this->colsNum = $colsNum;
        if ($threshold) {
            $this->colSize = $threshold;
            $this->colsNum = ceil($this->list->Count() / $this->colSize);
        } else {
            $this->colSize = ceil($this->list->Count() / $this->colsNum);
        }
    }

    public function Columns() {
        $cols = [];
        for ($i=0; $i < $this->colsNum; $i++) { 
            $cols[$i] = new ArrayData([
                'Items' => $this->list->limit($this->colSize, $this->colSize * $i)
            ]);
        }
        return new ArrayList($cols);
    }

    public function getIterator() {
        return new ArrayIterator($this->Columns()->toArray());
    }

}