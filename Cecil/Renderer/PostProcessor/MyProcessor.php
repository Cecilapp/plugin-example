<?php
namespace Cecil\Renderer\PostProcessor;

use Cecil\Collection\Page\Page;

class MyProcessor extends AbstractPostProcessor
{
    public function process(Page $page, string $output, string $format): string
    {
        // handle $output here

        return $output;
    }
}
