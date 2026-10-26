<?php

namespace PluginExample\PostProcessor;

use Cecil\Collection\Page\Page;
use Cecil\Renderer\PostProcessor\AbstractPostProcessor;

/**
 * Output post-processor example: adds `rel="noopener"` to links opened in a new tab.
 */
class ExternalLinks extends AbstractPostProcessor
{
    public function process(Page $page, string $output, string $format): string
    {
        if ($format !== 'html') {
            return $output;
        }

        return preg_replace_callback('/<a\s[^>]*target="_blank"[^>]*>/i', function (array $matches): string {
            if (preg_match('/\srel="/i', $matches[0])) {
                return $matches[0];
            }

            return substr($matches[0], 0, -1) . ' rel="noopener">';
        }, $output) ?? $output;
    }
}
