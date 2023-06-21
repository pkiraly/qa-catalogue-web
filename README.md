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
- [Customization](#customization)
- [Translation](#translation)
- [Contributing](#contributing)
- [Maintainers](#maintainers)

## Installation

In the following:

- `$DATADIR` denotes the base output directory of data analysis with QA Catalogue
- `$CATALOG` denotes the name of a catalogue (such as loc, bl, k10plus...)

Analyse your catalog with [QA Catalogue Backend](https://github.com/pkiraly/qa-catalogue)),
the result will be saved in `$DATADIR/$CATALOG` and in Solr.

### Download

Install this software into a web server with PHP enabled (Apache or Nginx with PHP-FPM).

Create a temporary directory and download the current version to an application
directory served by your webserver (here we use `/var/www/html/$CATALOG`):

```
mkdir tmp
cd tmp
wget https://github.com/pkiraly/qa-catalogue-web/archive/master.zip
unzip master.zip
mv metadata-marc-web-master /var/www/html/$CATALOG
```

or clone the git repository:

```
git clone https://github.com/pkiraly/qa-catalogue-web.git /var/www/html/$CATALOG
cd /var/www/html/$CATALOG

# optionally checkout a tagged release
git checkout v0.7.0
```

Requirements:
```
sudo apt install locales gettext php-sqlite3 php-yaml php-curl composer
sudo locale-gen en_GB.UTF-8
sudo locale-gen de_DE.UTF-8
```

### Setup

Change into the application directory:

```
cd /var/www/html/$CATALOG
```

install PHP dependencies and create required cache directories and permissions:

```
composer install
```

Prepare configuration file:

```
echo "dir=$DATADIR" > configuration.cnf
```

If the application path does not equals `$CATALOG`, add:

```
echo "catalogue=$CATALOG" >> configuration.cnf
```

Configuration parameters:

- `dir`: the base output directory of data analysis with QA Catalogue
- `catalogue`: machine name of a catalogue. Based on this the system will use the relevant catalogue representing class
   in `classes/catalogue` directory. The parameter value should be a small case version of the class name, so e.g. if
   the class name is `Gent` the parameter value should be `gent`.
- `default-tab`: the tab which will be displayed when no tab is selected. This will be the tab which will be opened by 
   the root URL (the landing page). If no default-tab has been set, `completeness` will be used. The possible values are:
   `data`, `completeness` (default), `issues`, `functions`, `classifications`, `authorities`, `serials`, `tt-completeness`,
   `shelf-ready-completeness`, `shacl`, `network`, `terms`, `pareto`, `history`, `timeline`, `settings`, `about`,
   `record-issues`, `histogram`, `functional-analysis-histogram`, `control-fields`, `download`, `collocations`.
- `db`: the machine name of the data directory. By default, it comes from the URL as the path of the application
   (qa-catalogue). With this parameter the administrator can overwrite the path.
- `indexName[<catalogue>]`: name of the Solr index of a particular catalogue, if it is different from the name of the
    catalogue or the URL path. 
- `dirName[<catalogue>]`: name of the data directory of a particular catalogue, if it is different from the name of the
   catalogue or the URL path.
- `version[<catalogue>]`: denotes if there are versions for a catalogue. Possible values: 1 (there are versions), 0 
   (there are no versions)
- `display-network`: show or hide the network tab. Possible values: 1 (to display the tab), or 0 (not to display)
- `display-shacl`: show or hide the network tab. Possible values: 1 (to display the tab), or 0 (not to display)

Example:

```
display-network=0
indexName[bvb]=bayern
dirName[bvb]=bayern
```

setup additional directories and permissions:

```
sudo chgrp www-data -R _smarty cache
ln -s [data directory]/[catalogue]/img images/[catalogue]
```

On Apache webserver add these lines to its configuration (`/etc/apache2/sites-available/000-default.conf`):

```
<Directory /var/www/html/$CATALOG>
  AllowOverride All
  Order allow,deny
  allow from all
</Directory>
```

You can access the application at `http://localhost/$CATALOG`.

## Customization

Some parts of the web interface can be customized with local files in directory
`config` (not existing by default):

- `config/header.en.tpl` and `config/header.de.tpl` shown at bottom of each page
  (right after the `<body>` tag)
- `config/footer.en.tpl` and `config/footer.de.tpl` shown at bottom of each page
  (right before the `</body>` tag)
- `config/about.en.tpl` and `config/about.de.tpl`: Additional information shown
  in the "about" tab.

The name, catalogue link and the record levele catalogue link are different 
per libraries. The tool has prepared for a number of libraries, but there's
high chance, that you would like to apply it for another library. 
You have set these values in a class which extends the `Catalogue` class,
here is an example: 

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

Please create a new file in the directory `classes/catalogue`. You do not have
to do any other registration. The convention is that the name of the class
is the first upper case form of the name property (Gent - gent, Cerl - cerl)
etc. The later should fit the data directory name, the Solr index name, and 
either the application path or the `catalogue` property of the 
`configuration.cnf` file. `$url` contains an URL of the catalogue in the library
website, `$marcVersion` is the abbreviation of MARC version used in the
analyses.

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

