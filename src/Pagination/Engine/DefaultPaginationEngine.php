<?php

namespace Chronos\Pagination\Engine;

use Chronos\Pagination\Contracts\PaginationEngineInterface;
use Chronos\Pagination\Contracts\PaginationInterface;

/**
 * This class generates the pagination html to shown to the end user.
 */
class DefaultPaginationEngine implements PaginationEngineInterface
{
    /**
     * Object containing the class responsable for serving the logic for
     * creating pagination links.
     *
     * @var Chronos\Pagination\Contracts\PaginationInterface
     */
    private $pagination;

    /**
     * Defines the pagination class used to obtain the logic for generating
     * the pagination links.
     *
     * @param Chronos\Pagination\Contracts\PaginationInterface $pagination
     */
    public function setPagination(PaginationInterface $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * Generates the links to be displayed on the view.
     *
     * @return string
     */
    public function getLinks()
    {
        return $this->pagination->loadLayout('default-pagination.php', [
            'numbers' => $this->pagination->getNumbers(),
            'currentNumRecords' => $this->pagination->currentNumRecords(),
            'currentPage' => $this->pagination->getCurrentPage(),
            'totalPages' => $this->pagination->getTotalPages(),
            'totalRecords' => $this->pagination->getTotalRecords(),
            'firstPageLink' => $this->pagination->getFirstLinkUrl(),
            'lastPageLink' => $this->pagination->getLastLinkUrl(),
        ]);
    }
}
