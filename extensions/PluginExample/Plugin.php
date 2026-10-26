<?php

namespace PluginExample;

use Cecil\Event\BuildEvents;
use Cecil\Plugin\AbstractPlugin;
use Cecil\Plugin\Registry;

/**
 * Plugin example: the single entry point registering the extensions of the plugin.
 */
class Plugin extends AbstractPlugin
{
    public function register(Registry $registry): void
    {
        $registry
            // default options (can be overridden by the site configuration)
            ->config([
                'plugin_example' => [
                    'hello' => [
                        'path'  => 'hello',
                        'title' => 'Hello',
                    ],
                    'report' => false,
                ],
            ])
            // a pages generator, after sections (priority 40) to be able to list their pages
            ->generator(Generator\HelloPage::class, priority: 45)
            // a Twig extension: `example_hello()` function and `example_initials` filter
            ->twigExtension(Twig\Extension::class, name: 'PluginExample')
            // an output post-processor
            ->postProcessor(PostProcessor\ExternalLinks::class)
            // a build events subscriber
            ->subscriber(Subscriber\BuildReport::class)
            // a single event listener
            ->listen(BuildEvents::BUILD_START, fn () => $this->builder->getLogger()->info('Plugin example: build started'));
    }
}
