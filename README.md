# Currency Converter

Craft plugin to convert currency using API & local storage

### IMPORTANT

---

### Installation

Open your terminal and go to your Craft project:

```bash
cd /path/to/project
```

Then tell Composer to load the plugin:

```bash
composer require leowebguy/craft-currency-converter
```

In the Control Panel, go to Settings → Plugins and click the “Install” button for Currency Converter.

Go to [rapidapi.com/natkapral/api/currency-converter5](https://rapidapi.com/natkapral/api/currency-converter5/) → Get your Free API Key

In the Control Panel, go to Settings → Currency Converter → Paste and Save your API Key

You can also put it in your ENV file i.e. `$CC_KEY` and set it over here.

```dotenv
CC_KEY=aaa123bbb234
```

![screenshot1](resources/screenshot1.jpg)

&nbsp;

---

### Usage

The plugin exposes a Currency Converter's methods:

```twig
{%  set amount = craft.entries.section('my-section').one().numberfield %}
{{ craft.currency.conversion('USD', 'EUR', amount) }}
```

Also passing number as string:

```twig
{{ craft.currency.conversion('USD', 'EUR', 23) }}
```
