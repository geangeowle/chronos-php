<?php

namespace Chronos\Http;

use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

final class Router
{
    public static function parse($url, $parseNamespace = true)
    {
        $dsNamespaceDefault = 'chronos';
        $dsNamespaceAllow = Configure::read('Default.NamespaceAllow');

        if (!empty(Configure::read('Default.Namespace'))) {
            $dsNamespaceDefault = Configure::read('Default.Namespace');
            $dsNamespaceAllow[] = $dsNamespaceDefault;
        }

        $returnDefault = [
            'url' => [
                'path' => 'controller',
                'namespace' => $dsNamespaceDefault,
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
            // pr($url);
            $list = explode('/', $url);
            unset($list[0]);
            // pr($list);

            if (empty($list[2])) {
                $list[2] = $returnDefault['url']['controller'];
            }

            if (!isset($list[3])) {
                $list[3] = '';
            }

            $dsNamespace = $list[1];
            $dsController = $list[2];
            $dsMethod = $list[3];
            $dsParams = [];

            if ($parseNamespace && !in_array(Inflector::camelize($dsNamespace), $dsNamespaceAllow, true)) {
                $dsNamespace = $dsNamespaceDefault;
                $dsController = $list[1];
                $dsMethod = $list[2];
                unset($list[1], $list[2]);
            } else {
                unset($list[1], $list[2], $list[3]);
            }

            $dsParams = array_merge($list);

            $returnDefault['url']['path'] = Inflector::underscore($dsNamespace);
            $returnDefault['url']['namespace'] = $dsNamespace;
            $returnDefault['url']['controller'] = $dsController;

            if (!empty($dsMethod)) {
                $returnDefault['url']['action'] = $dsMethod;
            }

            foreach ($dsParams as $key => $vl) {
                if (!empty($vl)) {
                    $returnDefault['url']['params'][] = $vl;
                }
            }
        }

        // pr($returnDefault); die();
        return $returnDefault;
    }
}
