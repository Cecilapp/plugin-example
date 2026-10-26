<?php

namespace PluginExample\Twig;

use Cecil\Builder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Twig extension example.
 *
 * - `example_hello(name)` function: returns a greeting with the site title
 * - `example_initials` filter: returns the initials of a string (e.g.: "Arnaud Ligny" → "AL")
 */
class Extension extends AbstractExtension
{
    public function __construct(protected Builder $builder)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('example_hello', [$this, 'hello']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('example_initials', [$this, 'initials']),
        ];
    }

    public function hello(string $name = 'world'): string
    {
        return \sprintf('Hello %s, from %s!', $name, (string) $this->builder->getConfig()->get('title'));
    }

    public function initials(string $value): string
    {
        $initials = '';
        foreach (preg_split('/\s+/u', trim($value)) ?: [] as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }

        return $initials;
    }
}
