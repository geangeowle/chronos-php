<?php

namespace Chronos\Pagination\Contracts;

interface PaginationEngineInterface
{
    /**
     * Defines the pagination class used to obtain the logic for generating
     * the pagination links.
     *
     * @param Chronos\Pagination\Contracts\PaginationInterface $pagination
     */
    public function setPagination(PaginationInterface $pagination);

    /**
     * Generates the links to be displayed on the view.
     *
     * @return string
     */
    public function getLinks();
}
