# QA Catalogue
## A data quality dashboard for MARC catalogues

![Output sample](https://github.com/pkiraly/metadata-qa-marc-web/raw/gh-pages/img/issues-v1.gif)

This web interface is created mainly for research purposes. 
It is a lightweight web allication (PHP, JavaScript, HTML and CSS). The data
are stored in CSV files and in an optional Solr index, which is created 
by the [metadata-qa-marc](https://github.com/pkiraly/metadata-qa-marc) 
project. Solr contains not pure MARC21 fields, but the so called
[Self-descriptive MARC21 codes](http://pkiraly.github.io/2017/09/24/mapping/).

# Installation

Notes: 
* `[catalogue]` denotes the name of a catalogue (such as loc, bl, gnd, etc.) in this document.
* `[data directory]` denotes the path into which you save the result into the data analyses.

1. Analyse your catalog with [metadata-qa-marc](https://github.com/pkiraly/metadata-qa-marc) tool

The data will be saved to `[data directory]/[catalogue]`

2. Install this software into Apache web server (it might work with other web servers)

create a temporary directory
```
mkdir temp
cd temp
```

download the software
```
wget https://github.com/pkiraly/metadata-qa-marc-web/archive/master.zip
unzip master.zip
mv metadata-marc-web-master /var/www/html/[catalogue]
```

or clone thw git repository
```
git clone https://github.com/pkiraly/metadata-qa-marc-web.git
mv metadata-marc-web /var/www/html/[catalogue]
```

3. Setup

prepare configuration file:
```
cd /var/www/html/[catalogue]
```
 You can also add the [catalogue] infor the configuration if the 
 application path does not equals to the [catalogue]:

prepare configuration file:
```
echo "dir=[data directory]" > configuration.cnf
```
 You can also add the [catalogue] infor the configuration if the 
 application path does not equals to the [catalogue]:

```
echo "catalogue=[catalogue]" >> configuration.cnf
```

other configuration parameters:

* `display-network`: to show or hide the network tab. 
  Possible values: 1 (to display the tab), or 0 (not to display)
* `indexName[<catalogue>]`: the name of the Solr index, it it is different than the name of the catalogue. 
* `dirName[<catalogue>]`: the name of the data directory, it it is different than the name of the catalogue.

example:

```
display-network=0
indexName[bvb]=bayern
dirName[bvb]=bayern
```

setup directories and permissions, download the Smarty templating library.

```
mkdir cache
echo [] > cache/selected-facets.js
sudo chown www-data:www-data -R cache
chmod g+w -R cache
mkdir libs
mkdir images

ln -s [data directory]/[catalogue]/img images/[catalogue]

# download Smarty templating library
export SMARTY_VERSION=3.1.44
cd libs/
curl -s -L https://github.com/smarty-php/smarty/archive/v${SMARTY_VERSION}.zip --output v$SMARTY_VERSION.zip
unzip -q v${SMARTY_VERSION}.zip
rm v${SMARTY_VERSION}.zip
mkdir -p _smarty/templates_c
chmod a+w -R _smarty/templates_c/
cd ..
```

Add these lines to Apache configuration (`/etc/apache2/sites-available/000-default.conf`)

```
<Directory /var/www/html/[catalogue]>
  AllowOverride All
  Order allow,deny
  allow from all
</Directory>
```

You can access the site at `http://localhost/[catalogue]`

If this is the only application on the site, you can redirect
all requests to QA Catalogue by adding the following line to 
the same file (before the `<Directory/>` element):

```
RedirectMatch ^/$ /metadata-qa/
```

# Translation

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
# completeness
msgid "by document types"
msgstr "nach Dokumenttypen"
```

Once you have done, you should generate the `.mo` files from the `.po` files with the following commands:

```bash
msgfmt locale/de_DE/LC_MESSAGES/messages.po -o locale/de_DE/LC_MESSAGES/messages.mo
msgfmt locale/en_GB/LC_MESSAGES/messages.po -o locale/en_GB/LC_MESSAGES/messages.mo
```

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

# Customization

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

You can also share the code with me, and then I will incorporate it into the 
code base. 

Please notify me if you would like to use it. Happy searching!

-- Péter
