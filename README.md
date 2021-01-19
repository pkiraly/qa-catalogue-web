# QA Catalogue
## A data quality dashboard for MARC catalogues

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

```
cd /var/www/html/[catalogue]
```

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

setup directories and permissions, download the Smarty templating library.

```
mkdir cache
touch selected-facets.js
sudo chown www-data:www-data -R cache
chmod g+w -R cache
mkdir libs
mkdir images

ln -s [data directory]/[catalogue]/img images/[catalogue]

# download Smarty templating library
export SMARTY_VERSION=3.1.33
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
`configuration.cnf` file.

You can also share the code with me, and then I will incorporate it into the 
code base. 

Please notify me if you would like to use it. Happy searching!

-- Péter