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
echo "dir=[data directory]" > configuration.cnf
touch selected-facets.js
chmod a+w selected-facets.js
mkdir cache
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

## WARNING

This project is not intended to be used in publicly available sites.

Please notify me if you would like to use it. Happy searching!

-- Péter