# A single page web interface for searching MARC records

This web interface is created mainly for research purposes. It uses JavaScript, HTML and CSS, the backend is a Solr index, which is created by the [metadata-qa-marc](https://github.com/pkiraly/metadata-qa-marc) project. Solr contains not pure MARC21 fields, but the so called [Self-descriptive MARC21 codes](http://pkiraly.github.io/2017/09/24/mapping/).

# WARNING

This project is not intended to be used in publicly available sites.

# Installation

1. Index your catalog with [metadata-qa-marc](https://github.com/pkiraly/metadata-qa-marc)

```
./solr-index --solrUrl [Solr URL] --solrFieldType "mixed" [marc file(s)]
```

2. Edit configuration file

```
cp configuration.js.template configuration.js
```

Edit the file:
```
// your host name
var host = window.location.hostname;
// specify Solr's port, path, method
var baseUrl = 'http://' + host + ':8983/solr/select/';
```


3. Create selected-facets.js

```
touch selected-facets.js
chown o+w selected-facets.js
˙``


Please notify me if you would like to use it. Happy searching!
