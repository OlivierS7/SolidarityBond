<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SubjectsSearch {

    /**
     * @var ArrayCollection
     */
    private $searchType;

    public function __construct()
    {
        $this->searchType = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSearchType(): ArrayCollection
    {
        return $this->searchType;
    }

    /**
     * @param ArrayCollection $searchType
     * @return SubjectsSearch
     */
    public function setSearchType(ArrayCollection $searchType): SubjectsSearch
    {
        $this->searchType = $searchType;
        return $this;
    }
}