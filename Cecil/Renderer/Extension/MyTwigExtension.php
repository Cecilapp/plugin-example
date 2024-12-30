<?php
namespace Cecil\Renderer\Extension;

class MyTwigExtension extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        // add a new filter named 'md5'
        return [
            new \Twig\TwigFilter('md5', 'md5'),
        ];
    }
}
