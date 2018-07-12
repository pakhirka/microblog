<?php

namespace AppBundle\Services;

interface Parser
{
    public function parse(string $content): string;
}