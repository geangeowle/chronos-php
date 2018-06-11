<?php

namespace Chronos\Pagination\Contracts;

interface PaginationInterface
{
    /**
     * Constructor.
     *
     * @param Chronos\Pagination\Contracts\PaginationInterface $engine
     */
    public function __construct(PaginationEngineInterface $engine);

    /**
     * Defines the page query string used by the pagination links.
     * e.g.: http://www.myapplication.com/home/?pagina=4.
     *
     * @param string $pageQueryString
     *
     * @return Chronos\Pagination\Pagination
     */
    public function setPageQueryString($pageQueryString);

    /**
     * Contains the total records the pagination will generates the links for.
     *
     * @param int $totalRecords
     *
     * @return Chronos\Pagination\Pagination
     */
    public function setTotalRecords($totalRecords);

    /**
     * Stores into the pagination object the records found corresponding
     * the current page number.
     *
     * @param array $records
     *
     * @return Chronos\Pagination\Pagination
     */
    public function setRecords(array $records);

    /**
     * Returns the current recrods corresponding to the current page number.
     *
     * @return array
     */
    public function getRecords();

    /**
     * Total of records that will generate pagination.
     *
     * @return int
     */
    public function getTotalRecords();

    /**
     * Set the current page we are in.
     *
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage);

    /**
     * Set how many records we want to display per page.
     *
     * @param int $perPage
     */
    public function setPerPage(int $perPage);

    /**
     * Get how many records should be displayed per page.
     *
     * @return int
     */
    public function getLimit();

    /**
     * Get the records offset used to make the sql and get the records
     * corresponding the correct pagination.
     *
     * @return int
     */
    public function getOffset();

    /**
     * Get the number of records according to the current pagination.
     *
     * @return int
     */
    public function currentNumRecords();

    /**
     * Defines how many numbers should be displayed LEFT and RIGHT of the
     * current page number in the pagination links.
     *
     * @param int $pgNumToShow
     */
    public function setPgNumToShow(int $pgNumToShow);

    /**
     * The number of pages that should be displayed. This number is based on the
     * number of records to be shown per page and the total records found.
     *
     * @return int
     */
    public function getTotalPages();

    /**
     * The current page the end user is in.
     *
     * @return int
     */
    public function getCurrentPage();

    /**
     * Get an array containing the page numbers to be displayed.
     *
     * @return array
     */
    public function getNumbers();

    /**
     * Load a layout to be used for generating the view part of the pagination.
     *
     * @param string $file
     * @param array  $viewVars
     */
    public function loadLayout(string $file, array $viewVars = []);

    /**
     * Returns the current engine object that is being used for generating
     * the pagination view part.
     *
     * @return Chronos\Pagination\Contracts\PaginationEngineInterface
     */
    public function engine();
}
