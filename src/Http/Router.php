<?php

namespace Chronos\Http;

final class Router
{
    public static function parse($url)
    {
        $returnDefault = [
            'url' => [
                'path' => 'controller',
                'namespace' => 'app',
                'controller' => 'page',
                'action' => 'index',
                'params' => [],
            ],
        ];

        if ($url && 0 !== strpos($url, '/')) {
            $url = '/'.$url;
        }
        if (false !== strpos($url, '?')) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        if (!empty($url)) {
            $list = explode('/', $url);

            //$returnDefault['url']['namespace'] = $list[1];
            $returnDefault['url']['controller'] = $list[1];
            $returnDefault['url']['path'] = 'app';
            unset($list[0], $list[1]);

            if (isset($list[2]) && !empty($list[2])) {
                $returnDefault['url']['action'] = $list[2];
                unset($list[2]);
            }

            foreach ($list as $key => $vl) {
                if (!empty($vl)) {
                    $returnDefault['url']['params'][] = $vl;
                }
            }
        }

        return $returnDefault;
    }
}
