<?php
namespace Cecil\Renderer\Extension;

class MyExtension extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('md5', 'md5'),
        ];
    }
}
