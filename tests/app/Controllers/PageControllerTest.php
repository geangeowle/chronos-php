<?php

namespace Tests\App\Controllers;

use App\Controllers\PageController;
use Chronos\TestSuite\ChronosTestCase;

/**
 * @coversNothing
 */
class PageControllerTest extends ChronosTestCase
{
    public function testDemo()
    {
        $n = new PageController(APP_CONFIG);
        $this->assertSame(1, $n->getX());
    }
}
