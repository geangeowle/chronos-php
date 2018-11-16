<?php

namespace Chronos\Pagination;

use Chronos\Pagination\Contracts\PaginationEngineInterface;
use Chronos\Pagination\Contracts\PaginationInterface;

/**
 * Helper class used for generating pagination.
 */
class Pagination implements PaginationInterface
{
    /** {@inheritdoc} */
    const DS = DIRECTORY_SEPARATOR;

    /** {@inheritdoc} */
    private $engine;

    /** {@inheritdoc} */
    private $totalRecords = 0;

    /** {@inheritdoc} */
    private $records = [];

    /** {@inheritdoc} */
    private $currentPage = 1;

    /** {@inheritdoc} */
    private $perPage = 10;

    /** {@inheritdoc} */
    private $pgNumToShow = 6;

    /** {@inheritdoc} */
    private $pageQueryString = 'page';

    /** {@inheritdoc} */
    public function __construct(PaginationEngineInterface $engine)
    {
        $this->engine = $engine;

        // Pass this object to the engine
        $this->engine->setPagination($this);
    }

    /** {@inheritdoc} */
    public function setPageQueryString($pageQueryString)
    {
        $this->pageQueryString = $pageQueryString;

        return $this;
    }

    /** {@inheritdoc} */
    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;

        return $this;
    }

    /** {@inheritdoc} */
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    /** {@inheritdoc} */
    public function setRecords(array $records)
    {
        $this->records = $records;

        return $this;
    }

    /** {@inheritdoc} */
    public function getRecords()
    {
        return $this->records;
    }

    /** {@inheritdoc} */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /** {@inheritdoc} */
    public function getCurrentPage()
    {
        return (int) $this->currentPage;
    }

    /** {@inheritdoc} */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /** {@inheritdoc} */
    public function getLimit()
    {
        return $this->perPage;
    }

    /** {@inheritdoc} */
    public function getOffset()
    {
        $page = $this->getCurrentPage();
        $limit = $this->getLimit();

        // (current page * per page) = (total - per page)
        return ($page * $limit) - $limit;
    }

    /** {@inheritdoc} */
    public function currentNumRecords()
    {
        $page = $this->getCurrentPage();
        $limit = $this->getLimit();

        return ($page * $limit);
    }

    /** {@inheritdoc} */
    public function setPgNumToShow($pgNumToShow)
    {
        $this->pgNumToShow = $pgNumToShow;
    }

    /** {@inheritdoc} */
    public function getTotalPages()
    {
        $total = $this->getTotalRecords();
        $limit = $this->getLimit();
        $pages = ceil($total / $limit);

        return $pages;
    }

    /** {@inheritdoc} */
    public function getNumbers()
    {
        // Variables for generating pagination
        $pages = $this->getTotalPages();
        $page = $this->getCurrentPage();
        $numbers = [];
        $currentUrl = $this->getCurrentUri();
        $pgNumToShow = $this->pgNumToShow;

        // Algorthmo for finding how many pages on
        // each side of pagination should be
        // created and displayed.
        $pagesLeft = ($page - $pgNumToShow);
        $pagesLeft = $pagesLeft > 0 ? $pagesLeft : 1;
        $pagesRight = ($page + $pgNumToShow);
        $pagesRight = $pagesRight < $pages ? $pagesRight : $pages;

        // From current page - 4
        for ($pageNum = $pagesLeft; $pageNum < $page; ++$pageNum) {
            $this->definePaginationNumbers($numbers, $currentUrl, $pageNum, $page);
        }

        // Current page
        $this->definePaginationNumbers($numbers, $currentUrl, $page, $page);

        // From current page + 4
        for ($pageNum = ($page + 1); $pageNum <= $pagesRight; ++$pageNum) {
            $this->definePaginationNumbers($numbers, $currentUrl, $pageNum, $page);
        }

        // return the pagination if it was created successfully
        return count($numbers) > 1 ? $numbers : [];
    }

    public function getFirstLinkUrl()
    {
        return $this->changeQueryString($this->getCurrentUri(), [
            $this->pageQueryString => 1
        ]);
    }

    public function getLastLinkUrl()
    {
        return $this->changeQueryString($this->getCurrentUri(), [
            $this->pageQueryString => $this->getTotalPages()
        ]);
    }

    /** {@inheritdoc} */
    public function loadLayout($file, array $viewVars = [])
    {
        $path = __DIR__.self::DS.'Layouts'.self::DS;
        $layout = $path.$file;
        $contents = '';

        if (file_exists($layout) && !is_dir($layout)) {
            extract($viewVars, EXTR_SKIP);
            ob_start();
            require_once $layout;
            $contents = ob_get_contents();
            ob_end_clean();
        }

        return $contents;
    }

    /** {@inheritdoc} */
    public function engine()
    {
        return $this->engine;
    }

    /** {@inheritdoc} */
    private function definePaginationNumbers(&$numbers, $currentUrl, $pageNum, $currentPage)
    {
        $newUrl = $this->changeQueryString($currentUrl, [$this->pageQueryString => $pageNum]);

        $numbers[] = [
            'link' => $newUrl,
            'text' => $pageNum,
            'active' => ($currentPage === $pageNum),
        ];
    }

    /** {@inheritdoc} */
    private function changeQueryString($url, $changeTo = [])
    {
        // Transforma a url em array
        $parseUrl = parse_url($url);
        // Pega a parte da url relativa a query string
        $queryStr = !empty($parseUrl['query']) ? $parseUrl['query'] : '';
        // Transforma a query string em array
        parse_str($queryStr, $result);
        // Modifica a query string
        $changeTo = array_merge($result, $changeTo);
        // Remove a parte da query string da url
        $newUrl = $this->removeQueryString($url);
        // Coloca o que foi modificado na url novamente
        if (!empty($changeTo)) {
            $newUrl .= '?'.http_build_query($changeTo);
        }
        // retorna a nova url
        return $newUrl;
    }

    /** {@inheritdoc} */
    private function removeQueryString($url)
    {
        $url = parse_url($url);
        $newUrl = '';

        $url = array_map(function ($item) {
            return trim($item, '/');
        }, $url);

        if (!empty($url['scheme'])) {
            $newUrl = "{$url['scheme']}://";
        }

        if (!empty($url['host']) && !empty($url['port'])) {
            $newUrl .= "{$url['host']}:{$url['port']}/";
        } elseif (!empty($url['host'])) {
            $newUrl .= "{$url['host']}/";
        }

        if (!empty($url['path'])) {
            $newUrl .= "{$url['path']}/";
        }

        return $newUrl;
    }

    /** {@inheritdoc} */
    private function getCurrentUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $host = $_SERVER['HTTP_HOST'];
        $protocol = 'http://';

        if ((!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS'])) {
            $protocol = 'https://';
        } elseif (443 === $_SERVER['SERVER_PORT']) {
            $protocol = 'https://';
        }

        return $protocol.$host.$uri;
    }
}
