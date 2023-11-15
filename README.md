# QA Catalogue Web

> A data quality dashboard for library catalogues

![Output sample](https://github.com/pkiraly/qa-catalogue-web/raw/gh-pages/img/issues-v1.gif)

This web application provides a web interface to results of
[QA Catalogue](https://github.com/pkiraly/qa-catalogue)
for quality analysis and statistics of metadata from library catalogues.

The results in form of CSV files, JSON files, a SQLite database, images and
a Solr index are made browseable on the Web with PHP and JavaScript.

## Table of Contents

- [Installation](#installation)
  - [Download](#download)
  - [Setup](#setup)
  - [Configuration](#configuration)
- [Customization](#customization)
  - [Templates](#templates)
  - [Catalogue class](#catalogue-class)
- [Translation](#translation)
- [Maintainers](#maintainers)
- [Contributing](#contributing)
- [License](#license)

## Installation

In the following:

- `$DATADIR` denotes the base output directory of data analysis with QA Catalogue
- `$APPDIR` denotes the directory where QA Catalogue Web is installed
- `$CATALOG` denotes the [catalogue class] (such as loc, bl, k10plus...)

Analyse your catalog with [QA Catalogue Backend](https://github.com/pkiraly/qa-catalogue)),
the result will be saved in a subdirectory of `$DATADIR` and in Solr.

### Download

Install this software into a web server with PHP enabled (Apache or Nginx with PHP-FPM).

Create a temporary directory and download the current version to an application
directory served by your webserver (here we use `/var/www/html/$APPDIR`):

```
mkdir tmp
cd tmp
wget https://github.com/pkiraly/qa-catalogue-web/archive/master.zip
unzip master.zip
mv metadata-marc-web-master /var/www/html/$APPDIR
```

or clone the git repository:

```
git clone https://github.com/pkiraly/qa-catalogue-web.git /var/www/html/$APPDIR
cd /var/www/html/$APPDIR

# optionally checkout a tagged release
git checkout v0.7.0
```

Requirements:
```
sudo apt install locales gettext php-sqlite3 php-yaml php-curl composer
sudo locale-gen en_GB.UTF-8
sudo locale-gen de_DE.UTF-8
sudo locale-gen pt_BR.UTF-8
```

### Setup

Change into the application directory:

```
cd /var/www/html/$APPDIR
```

install PHP dependencies and create required cache directories and permissions:

```
composer install
```

### Configuration

[configuration]: #configuration

Prepare configuration file:

```
echo "dir=$DATADIR" > configuration.cnf
```

The [catalogue class] should explicitly be specified:

```
echo "catalogue=$CATALOG" >> configuration.cnf
```

Additional configuration parameters are supported:

- `id`: (string) the machine name of the data directory. By default, it comes from the URL as the path of the application
   (qa-catalogue). With this parameter the administrator can overwrite the path. Note: this parameter was called `db`
   previously. For compatibility reason we will support `db` as well for some time. 
- `multitenant`: (bool) flag to denote if the site is in multi-tenant mode, i.e. it hosts the evaluation of multiple
   catalogues. If it is set you can specify general and catalogue-specific settings, e.g. `version=false` is a 
   general setting, while `version[loc]=false` is a library specific settings, which override the previous one.
   \[Available from v0.8.0\]
- `dir`, `dir[<id>]`: (string) the base output directory of data analysis with QA Catalogue
- `catalogue`, `cataloguer[<id>]`: (string) the [catalogue class] given in lowercase. 
   The value `catalogue` can be used for generic catalogue.
- `default-tab`, `default-tab[<id>]`: (string) the tab which will be displayed when no tab is selected. This
   will be the tab which will be opened by the root URL (the landing page). If no default-tab has been set,
   `start` will be used. The possible values are: `start` (default), `data`, `completeness`, `issues`, `functions`,
   `classifications`, `authorities`, `serials`, `tt-completeness`, `shelf-ready-completeness`, `shacl`, `network`,
   `terms`, `pareto`, `history`, `timeline`, `settings`, `about`, `record-issues`, `histogram`,
   `functional-analysis-histogram`, `control-fields`, `download`, `collocations`.
- `indexName`, `indexName[<id>]`: (string) name of the Solr index of a particular catalogue, if it is different from
   the name of the catalogue or the URL path.
- `dirName`, `dirName[<id>]`: (string) name of the data directory of a particular catalogue, if it is different from
   the name of the catalogue or the URL path.
- `version`, `version[<id>]`: (string) denotes if there are versions for a catalogue. Possible values: 1 (there are
   versions), 0 (there are no versions)
- `display-network`, `display-network[<id>]`: (bool) show or hide the network tab. Possible values: 1 (to display
   the tab), or 0 (not to display)
- `display-shacl`, `display-shacl[<id>]`: (bool) show or hide the network tab. Possible values: 1 (to display the tab),
   or 0 (not to display)
- `templates`, `templates[<id>]`: (string) directory with additional, custom Smarty templates for
   [customization](#customization). Default value is `config`.
- `mainSolrEndpoint`, `mainSolrEndpoint[<id>]`: (string) the URL of the main Solr endpoint. Default value: 
  `http://localhost:8983/solr/`. In multi-tenant mode you can specify it for a particular catalogue with
  `mainSolrEndpoint[<id>]`. \[Available from v0.8.0\]
- `solrForScoresUrl`, `solrForScoresUrl[<id>]`: (string) the URL of the Solr core that is 
   used for storing the results of validation. Usually this index is merged to the main core, so this property is needed
   on the special case when the validation is not merged. Default value: `http://localhost:8983/solr/`. 
   In multi-tenant mode you can specify it for a particular catalogue with `mainSolrEndpoint[<id>]`. (Its previous
   name was `solrEndpoint4ValidationResults`.) \[Available from v0.8.0\]
- `logFile`, `logFile[id]`: (string) a path of the log file. Default value: `logs/qa-catalogue.log`.  \[Available 
   from v0.8.0\]
- `logLevel`, `logLevel[id]`: (string) the minimal logging level. Possible values are: `DEBUG`, `INFO`, `NOTICE`, 
   `WARNING`, `ERROR`, `CRITICAL`, `ALERT`, `EMERGENCY`. If you set `WARNING` you will not receive `DEBUG`, `INFO`, 
   and `NOTICE` messages. Default: `WARNING`.

The following configuration parameters only have effect for generic catalogs ([catalogue class] `catalogue`):

- `label`, `label[<id>]`: (string) name of the library catalogue
- `url`, `url[<id>]`: (string) link to library catalogue homepage
- `schema`, `schema[<id>]`: (string) metadata schema type (`MARC21` as default or `PICA`)
- `linkTemplate`, `linkTemplate[<id>]`: (string) URL template to link into the library catalogue (`{id}` will be
   replaced by record identifier)
- `language`, `language[<id>]`: (string) default language of the user interface

Example:

```
id=bvb
display-network=0
indexName[bvb]=bayern
dirName[bvb]=bayern
```

setup additional directories and permissions:

```
sudo chgrp www-data -R _smarty cache
ln -s $DATADIR/[catalogue]/img images/[catalogue]
```

On Apache webserver add these lines to its configuration (`/etc/apache2/sites-available/000-default.conf`):

```
<Directory /var/www/html/$APPDIR>
  AllowOverride All
  Order allow,deny
  allow from all
</Directory>
```

You can access the application at `http://localhost/$APPDIR`.

## Customization

### Templates

Some parts of the web interface can be customized with local files in directory
`config` (not existing by default) or another directory configured with
parameter `templates`:

- `config/header.en.tpl` and `config/header.de.tpl` shown at bottom of each page
  (right after the `<body>` tag)
- `config/footer.en.tpl` and `config/footer.de.tpl` shown at bottom of each page
  (right before the `</body>` tag)
- `config/about.en.tpl` and `config/about.de.tpl`: Additional information shown
  in the "about" tab.

### Catalogue class

[catalogue class]: #catalogue-class

Basic properties and default [configuration](#configuration) settings are defined
in a catalogue class which extends the generic class `Catalogue`. The application
includes catalogue classes for known libraries, but you may want to define additional
changes that go beyond simple configuration settings.

Here is an example of a custom catalogue class: 

```PHP
class Gent extends Catalogue {

  protected $name = 'gent';
  protected $label = 'Universiteitsbibliotheek Gent';
  protected $url = 'https://lib.ugent.be/';
  protected $marcVersion = 'GENT';

  function getOpacLink($id, $record) {
    return 'https://lib.ugent.be/catalog/rug01:' . trim($id);
  }
}
```

`$url` contains an URL of the catalogue in the library website, `$marcVersion`
is the abbreviation of MARC version used in the analyses.

Please create a new file in the directory `classes/catalogue`. You do not have
to do any other registration. The convention is to uppercase the first letter of
the class name. In [configuration] this name is given in lowercase (`Gent` => `gent`).

## Translation

Now the user interface is translatable via gettext methods. We provide
two language files (German and English). In `.tpl` files you can add translatable text as

```
{_('translatable text')}
```
`_` is a built-in alias for the PHP function `gettext`. If there are variables in the 
translated string, in the `.tpl` file you should use the `_t` function, defined by the project,
like this:

```
{_t('number of records: %d', $number_of_records)}
```

You should add the translations into `locale/de_DE/LC_MESSAGES/messages.po` as


```
msgid "translatable text"
msgstr "übersetzbarer Text"
```

and into `locale/en_GB/LC_MESSAGES/messages.po` as

```
msgid "translatable text"
msgstr "translatable text"
```

If the message string contain variables, use sprintf compatible placeholders,
such as '%d' for integers, '%s' for strings, '%f' for floating point numbers etc.

```
msgid "Found <span id=\"numFound\">%s</span> records"
msgstr "Found <span id=\"numFound\">%s</span> records"
```

Of course the message identifier could be different, and dense but now
I think that it is more understandable (so translatable) this way. When
you add a translation please add a comment to denote which page the original
text appears, such as 

```
# completeness
msgid "by document types"
msgstr "nach Dokumenttypen"
```

Once you have done, you should generate the `.mo` files from the `.po` files with the following command:

```bash
composer run translate
```

If translations have been changed, Webserver or FastCGI respectively may need to be restarted to clear the translation cache, e.g.

```bash
sudo service apache2 restart
```

Please let us know if you would like to see more languages supported.

Troubleshouting: if the translation would not work you can check if a given 
language (locale) is available in your system. In Linux you can check it with

```bash
locale -a
```

If the locale (e.g. 'de_DE.UTF-8') is not available, you can install it with

```bash
locale-gen de_DE.UTF-8
```

Note: translation is in a very early phase.

## Maintainers

QA Catalogue Web is developed by Péter Király and Jakob Voß.

Please notify us if you would like to use it. Happy searching!

## Contributing

QA Catalogue Web is managed in a public git repository at [pkiraly/qa-catalogue-web](https://github.com/pkiraly/qa-catalogue-web).
Contributions are welcome!

## License

GNU General Public License

