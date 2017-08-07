<?php

declare(strict_types=1);

namespace Zegnat\Html;

class DOMDocumentFragment extends \DOMDocumentFragment
{
    public function appendHTML(string $data): bool
    {
        $previousHandling = libxml_use_internal_errors(true);
        if (parent::appendXML($data) === true) {
            return true;
        }
        libxml_use_internal_errors($previousHandling);
        $dom = new \DOMDocument();
        do {
            $id = uniqid('id_');
        } while (strpos($data, $id) !== false);
        if ($dom->loadHTML('<div id="' . $id . '">' . $data . '</div>') === false) {
            return false;
        }
        $nodes = $dom->getElementById($id)->childNodes;
        foreach ($nodes as $node) {
            $node = $this->ownerDocument->importNode($node, true);
            $this->appendChild($node);
        }
        return true;
    }
}
