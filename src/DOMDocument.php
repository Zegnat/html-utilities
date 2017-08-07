<?php

declare(strict_types=1);

namespace Zegnat\Html;

class DOMDocument extends \DOMDocument
{
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
