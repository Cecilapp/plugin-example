<?php

namespace PluginExample\Subscriber;

use Cecil\Event\AbstractSubscriber;
use Cecil\Event\BuildEvent;
use Cecil\Event\BuildEvents;
use Cecil\Event\PageSavedEvent;

/**
 * Build events subscriber example: counts the saved files by format and,
 * if the `plugin_example.report` option is enabled, writes a `plugin-example-report.json` file in the output directory.
 */
class BuildReport extends AbstractSubscriber
{
    /** @var array<string, int> */
    private array $formats = [];

    public static function getSubscribedEvents(): array
    {
        return [
            BuildEvents::BUILD_START    => 'onBuildStart',
            BuildEvents::PAGE_SAVED     => 'onPageSaved',
            BuildEvents::BUILD_FINISHED => 'onBuildFinished',
        ];
    }

    public function onBuildStart(BuildEvent $event): void
    {
        $this->formats = [];
    }

    public function onPageSaved(PageSavedEvent $event): void
    {
        $this->formats[$event->getFormat()] = ($this->formats[$event->getFormat()] ?? 0) + 1;
    }

    public function onBuildFinished(BuildEvent $event): void
    {
        $this->builder->getLogger()->info(\sprintf('Plugin example: %s file(s) saved', array_sum($this->formats)));
        if (!$this->config->get('plugin_example.report') || ($event->getOptions()['dry-run'] ?? false)) {
            return;
        }
        file_put_contents(
            $this->config->getOutputPath() . '/plugin-example-report.json',
            json_encode(['date' => date(DATE_ATOM), 'formats' => $this->formats], JSON_PRETTY_PRINT)
        );
    }
}
