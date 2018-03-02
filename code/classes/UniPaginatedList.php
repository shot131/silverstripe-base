<?php
class UniPaginatedList extends PaginatedList {

    protected $getVar = 'page';

    public function getPageStart() {
        $request = $this->getRequest();
        if ($this->pageStart === null) {
            if(
                $request
                && isset($request[$this->getPaginationGetVar()])
                && $request[$this->getPaginationGetVar()] > 1
            ) {
                $this->pageStart = ((int)$request[$this->getPaginationGetVar()] - 1) * $this->getPageLength();
            } else {
                $this->pageStart = 0;
            }
        }

        return $this->pageStart;
    }

    public function Pages($max = null) {
        $result = new ArrayList();

        if ($max) {
            $start = ($this->CurrentPage() - floor($max / 2)) - 1;
            $end   = $this->CurrentPage() + floor($max / 2);

            if ($start < 0) {
                $start = 0;
                $end   = $max;
            }

            if ($end > $this->TotalPages()) {
                $end   = $this->TotalPages();
                $start = max(0, $end - $max);
            }
        } else {
            $start = 0;
            $end   = $this->TotalPages();
        }

        for ($i = $start; $i < $end; $i++) {
            $result->push(new ArrayData(array(
                'PageNum'     => $i + 1,
                'Link'        => $this->setGetVar($i + 1),
                'CurrentBool' => $this->CurrentPage() == ($i + 1)
            )));
        }

        return $result;
    }

    public function FirstLink() {
        return $this->setGetVar(1);
    }

    public function LastLink() {
        return $this->setGetVar($this->TotalPages());
    }

    public function NextLink() {
        if ($this->NotLastPage()) {
            return $this->setGetVar($this->CurrentPage() + 1);
        }
    }

    public function PrevLink() {
        if ($this->NotFirstPage()) {
            return $this->setGetVar($this->CurrentPage() - 1);
        }
    }

    private function setGetVar($pageNum) {
        if ($pageNum > 1)
            return HTTP::setGetVar($this->getPaginationGetVar(), $pageNum);
        else
            return preg_replace('/\?$/', '', HTTP::setGetVar($this->getPaginationGetVar(), null));
    }

    public function TotalCount() {
        return $this->getTotalItems();
    }

    public function TotalCountUnit($f0, $f1, $f2) {
        return Helpers::plural($this->getTotalItems(), $f0, $f1, $f2);
    }

}