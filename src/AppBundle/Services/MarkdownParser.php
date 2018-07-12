<?php

namespace AppBundle\Services;

class MarkdownParser implements Parser
{
    public function parse(string $content): string
    {
        $parser = new \Parsedown();
        return $parser->parse($content);
    }
}
