<?php

declare(strict_types=1);

namespace Zegnat\Html;

class DOMDocument extends \DOMDocument
{
    public function loadHTML($string, $options = 0): bool
    {
        $previousHandling = libxml_use_internal_errors(true);
        $string = mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF-8');
        $return = parent::loadHTML($string, $options);
        libxml_use_internal_errors($previousHandling);
        return $return;
    }

    public function saveHTML(DOMNode $node = null): string
    {
        $tidy = new \Tidy();
        $tidy->parseString(
            parent::saveHTML($node),
            [
                'indent' => 2, // 2 = 'auto'
                'wrap' => 0, // 0 = no wrapping
            ]
        );
        $tidy->cleanRepair();
        return strval($tidy);
    }
}
