# Plugin example

A [Cecil](https://cecil.app) plugin example, to start creating your own extensions: a [plugin](https://cecil.app/documentation/developers/extend/#plugins) registering a pages generator, a Twig extension, an output post-processor, a build events subscriber, an event listener and default options.

It is packaged as a _component theme_: install it as a theme, and the plugin is enabled with no other configuration.

## Requirements

Cecil 9.25 or later (plugins support).

## Installation

Allow the theme installer plugin in the `composer.json` file of your Cecil project (required since Composer 2.2), then require the package:

```bash
composer config allow-plugins.cecil/theme-installer true
composer require cecil/plugin-example
```

> Or [download the latest archive](https://github.com/Cecilapp/plugin-example/releases/latest/) and uncompress its content in `themes/plugin-example`.

## Usage

Add `plugin-example` in the `theme` section of your configuration file (`cecil.yml`), after your main theme:

```yaml
theme:
  - <your-theme>
  - plugin-example
```

### Without installing it as a theme

The extensions can also be used directly in a site: copy the `extensions/PluginExample/` directory in the `extensions/` directory of your site, then declare the plugin in your configuration file:

```yaml
extensions:
  plugins:
    PluginExample: PluginExample\Plugin
```

## What's inside

| Class                                       | Type                                                                                              | Description                                                                     |
|---------------------------------------------|---------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------|
| `PluginExample\Plugin`                      | [Plugin](https://cecil.app/documentation/developers/extend/#plugins)                              | Registers the extensions below, an event listener and the default options       |
| `PluginExample\Generator\HelloPage`         | [Pages generator](https://cecil.app/documentation/developers/extend/#page-generators)             | Generates a `/hello/` page listing the sections of the site                     |
| `PluginExample\Twig\Extension`              | [Twig extension](https://cecil.app/documentation/developers/extend/#twig-extension)               | `example_hello(name)` function and `example_initials` filter                    |
| `PluginExample\PostProcessor\ExternalLinks` | [Output post-processor](https://cecil.app/documentation/developers/extend/#output-post-processors) | Adds `rel="noopener"` to links opened in a new tab                              |
| `PluginExample\Subscriber\BuildReport`      | [Build events subscriber](https://cecil.app/documentation/developers/extend/#build-events)        | Counts the saved files and optionally writes a `plugin-example-report.json` file |

Classes live in `extensions/PluginExample/`: the file path matches the namespace (`PluginExample\Generator\HelloPage` → `extensions/PluginExample/Generator/HelloPage.php`). Use your own namespace, not `Cecil\` (reserved).

In templates:

```twig
<p>{{ example_hello('Arnaud') }}</p>
<p>{{ site.author.name|example_initials }}</p>
```

## Configuration

Default options, registered by the plugin:

```yaml
plugin_example:
  hello:
    path: hello  # path of the generated page (empty to disable it)
    title: Hello # title of the generated page
  report: false  # writes `plugin-example-report.json` in the output directory
```

The extensions registered by the plugin can be disabled or moved by their name in your configuration:

```yaml
pages:
  generators:
    HelloPage: false                 # disables the generator
output:
  postprocessors:
    ExternalLinks: { priority: 200 } # moves the post-processor
```

## Create your own plugin

```bash
php cecil.phar new:extension --type=plugin --name=Plugin --namespace=MyPlugin
```

See the [Extend Cecil](https://cecil.app/documentation/developers/extend/) documentation.

## License

_Plugin example_ is a free software distributed under the terms of the MIT license.
