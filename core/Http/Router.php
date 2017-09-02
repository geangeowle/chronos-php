<?php

namespace Chronos\Http;

final class Router
{

  public static function parse($url){
    $returnDefault = array(
        'params' => array(
            'path' => 'controller',
            'controller' => 'Page',
            'action' => 'index',
            'params' => array()
        )
    );

    if ($url && strpos($url, '/') !== 0) {
        $url = '/' . $url;
    }
    if (strpos($url, '?') !== false) {
        $url = substr($url, 0, strpos($url, '?'));
    }
    if (! empty($url)) {
        $list = explode('/', $url);

        $returnDefault['params']['controller'] = $list[1];
        $returnDefault['params']['path'] = 'app';
        unset($list[0]);
        unset($list[1]);
        if (isset($list[2]) && ! empty($list[2])) {
            $returnDefault['params']['action'] = $list[2];
            unset($list[2]);
        }
        foreach ($list as $key => $vl) {
            if (! empty($vl)) {
                $returnDefault['params']['params'][] = $vl;
            }
        }
    }

    return $returnDefault;
  }

}
