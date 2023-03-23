# QA Catalogue Web

> A data quality dashboard for library catalogues

![Output sample](https://github.com/pkiraly/metadata-qa-marc-web/raw/gh-pages/img/issues-v1.gif)

This web application provides a web interface to results of
[QA Catalogue](https://github.com/pkiraly/metadata-qa-marc)
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

Analyse your catalog with [QA Catalogue Backend](https://github.com/pkiraly/metadata-qa-marc)),
the result will be saved in `$DATADIR/$CATALOG` and in Solr.

### Download

Install this software into a web server with PHP enabled (Apache or Nginx with PHP-FPM).

Create a temporary directory and download the software to an application
directory served by your webserver (here we use `/var/www/html/$CATALOG`):

```
mkdir tmp
cd tmp
wget https://github.com/pkiraly/metadata-qa-marc-web/archive/master.zip
unzip master.zip
mv metadata-marc-web-master /var/www/html/$CATALOG
```

or clone the git repository:


```
git clone https://github.com/pkiraly/metadata-qa-marc-web.git /var/www/html/$CATALOG
```

### Setup

Change into the application directory:

```
cd /var/www/html/$CATALOG
```

Prepare configuration file:

```
echo "dir=$DATADIR" > configuration.cnf
```

If the application path does not equals `$CATALOG`, add:

```
echo "catalogue=$CATALOG" >> configuration.cnf
```

Other configuration parameters:

- `display-network`: to show or hide the network tab. 
  Possible values: 1 (to display the tab), or 0 (not to display)
- `indexName[<catalogue>]`: name of the Solr index, it it is different than the name of the catalogue. 
- `dirName[<catalogue>]`: name of the data directory, it it is different than the name of the catalogue.

Example:

```
display-network=0
indexName[bvb]=bayern
dirName[bvb]=bayern
```

Setup directories and permissions and download the Smarty templating library.

```
mkdir cache
echo [] > cache/selected-facets.js
sudo chown www-data:www-data -R cache
chmod g+w -R cache
mkdir libs
mkdir images

ln -s $DATADIR/$CATALOG/img images/$CATALOG

## download Smarty templating library
export SMARTY_VERSION=3.1.44
cd libs/
curl -s -L https://github.com/smarty-php/smarty/archive/v${SMARTY_VERSION}.zip --output v$SMARTY_VERSION.zip
unzip -q v${SMARTY_VERSION}.zip
rm v${SMARTY_VERSION}.zip
mkdir -p _smarty/templates_c
chmod a+w -R _smarty/templates_c/
cd ..
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

- `config/footer.en.tpl` and `config/footer.de.tpl` shown at bottom of each page
- `config/about.en.tpl` and `config/about.de.tpl` shown at the "about" page

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

Of course the message identifier could be different, and dense but now
I think that it is more understandable (so translatable) this way. When
you add a translation please add a comment to denote which page the original
text appears, such as 

```
## completeness
msgid "by document types"
msgstr "nach Dokumenttypen"
```

Once you have done, you should generate the `.mo` files from the `.po` files with the following commands:

```bash
msgfmt locale/de_DE/LC_MESSAGES/messages.po -o locale/de_DE/LC_MESSAGES/messages.mo
msgfmt locale/en_GB/LC_MESSAGES/messages.po -o locale/en_GB/LC_MESSAGES/messages.mo
```

If translations have been changed, Webserver or FastCGI respectively may need to be restarted to clear the translation cache.

Please let me know if you would like to see more languages supported.

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

QA Catalogue Web is developed by Péter Király.

Please notify me if you would like to use it. Happy searching!

## Contributing

QA Catalogue Web is managed in a public git repository at <https://github.com/pkiraly/metadata-qa-marc-web>.
Contributions are welcome!

## License

GNU General Public License

