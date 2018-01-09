<?php


class Paginate
{

    protected $currentPage;
    protected $picsPerPage;
    protected $totalCount;

    public function __construct($page = 1, $picsPerPage = 4, $count)
    {
        $this->currentPage = $page;
        $this->picsPerPage = $picsPerPage;
        $this->totalCount = $count;
    }

    public function allowPrevious()
    {
        return $this->previous() >= 1 ? true : false;
    }

    public function previous()
    {
        return $this->currentPage - 1;
    }

    public function allowNext()
    {
        return $this->next() <= $this->totalPages() ? true : false;
    }

    public function next()
    {
        return $this->currentPage + 1;
    }

    public function totalPages()
    {
        return ceil($this->totalCount / $this->picsPerPage);
    }

    public function dbQuery()
    {
        $sql = "SELECT * FROM photos";
        $sql .= " LIMIT {$this->picsPerPage}";
        $sql .= " OFFSET {$this->offset()}";

        return $sql;
    }

    public function offset()
    {
        return ($this->currentPage - 1) * $this->picsPerPage;
    }

    //region Getters and Setters

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->currentPage;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getPicsPerPage()
    {
        return $this->picsPerPage;
    }

    /**
     * @param mixed $picsPerPage
     */
    public function setPicsPerPage($picsPerPage)
    {
        $this->picsPerPage = $picsPerPage;
    }

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param mixed $totalCount
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }


    //endregion
}