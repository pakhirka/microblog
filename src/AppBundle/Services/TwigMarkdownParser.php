<?php

namespace AppBundle\Services;

class TwigMarkdownParser extends \Twig_Extension implements Parser
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', [$this, 'parse'], ['is_safe' => ['html']])
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('markdown_parse', [$this, 'parse'], ['is_safe' => ['html']])
        ];
    }

    public function parse(string $content): string
    {
        return $this->parser->parse($content);
    }
}
