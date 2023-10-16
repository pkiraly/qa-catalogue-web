# Release 0.8.0 (2023-xx-xx)

#126 display the number of data elements at the completeness tab. The "Field groups" table has two new
columns: 1) fields, 2) positions/indicators/subfields - for the number of distinct data elements used
in the records, and a new row: "total" that display the number of total data elements.

# Release 0.7.0 (2023-07-18)

## The major features of this release

### Improved PICA handling
PICA is an alternative bibliographic metadata schema used in Germany, The Netherlands and France. The development of
PICA related features were done in cooperation with K10Plus, the largest union catalogue of Germany. Now the analyses
of PICA records covers completeness, validation, subject heading and authority name analyses plus searching and
displaying individual records.

### Handling union catalogues
Union catalogues covers the collections of multiple libraries. Now QA catalogue could display the results of
completeness, validation, searching and term list for both the whole catalogue and for any individual library.

### Translation
The main parts of the user interface are translatable and the code contains German and Brazilian Portuguese
translations thanks to Jakob Voß (VZG) and Tiago Murakami (Universidade de São Paulo).

### SHACL4bib
Shape Expression Constraints Language (SHACL) has been adapted to MARC and PICA records. It provides a customized
analysis for a library, so it can write a configuration file to check records against their own customs and ruleset
which are not part of the core standard. This feature was party developed by Jean Michel Nzi Mba as part of his
Bachelor thesis.

### Other features
QA catalogue makes use of a Composer based setup to manage dependencies. It also has improved downloading
functionalities, so the user can download all IDs that bound to any particular issue, or fit to search terms.
The menu system has been improved. In term lists the user can type MARC/PICA codes and substrib or their labels
instead of Solr field name (as previously).

## Contributors
In the creation of this release Jakob Voß, Tiago Murakami and Jean Michel Nzi Mba provided important contributions.

## Detailed list of changes

Improved PICA handling
#247: Uniqueness of PICA field ranges reported wrongly
#44: Make a link to documentation of a field in the raw data view
#45: Do not display link to documentation if it is an undefined field
#50: PICA: replace all references from MARC21 into PICA
#53: PICA: show pica3 identifier as well: completeness, issues, authorities, classifications
#55: Filter data by library: using autocomplete
#55: PICA: Filter data by library v1
#81: The PICA subfield labels are not shown in subject and name authorities tabs

Handling union catalogues
#59: Group results in completeness: use database for groupped results
#59: issue #59: Group results in completeness
#59: issue #59: Refactor readGroups() for completeness
#60: issue #60: Completeness: sorting the dropdown list of libraries
#65: Group results in issues
#66: Group results in terms
#72: Filter data in data tab
#71: Remove submit button in selection of grouping

Translation
#40: Make user interface translatable
 * Make user interface translatable: issues tab
 * Add translation in download tab
 * Add translations
 * Adjust German translation
 * Adjust layout and translation of issues tab
 * Extend German translation
 * Extend translation
 * README: Add note about translation cache
 * Translate opac link

#56: Add translatable intro sentence for about tab
#56: Add translatable intro sentence for collocations tab
#56: Add translatable intro sentence for download tab
#56: Add translatable intro sentence for each tab
#56: Add translatable intro sentence for history tab
#56: Add translatable intro sentence for settings tab
#56: Add translatable intro sentence for terms tab
#90: Translate validation error message

Composer related improvements
#94: adjust composer process
 * Introduce PHP composer
 * Add composer script to translate .po files
 * Extend composer.json

Other improvements
#25: Link to favicon.ico
#43: Make term lists downloadable: download all terms, not only the top 100
#69: Add download link in search result
#51: The user should see the MARC/PICA expressions in the list on the Terms page (instead the Solr fields)
#61: Write the number of terms into the top of the term list
#62: Explain what the numbers in the term list mean
#63: Create a class for Zentralbibliothek Zürich
#70: Change record view to all tabs
#73: Adjust about page to allow for customization
 * Add configurable header
 * Support customization of footer

#80: Conflicting forms in terms tab
#82: Use the field selector in collocations tab
#83: Use the field selector in settings tab
#84: Link to downloadable Avram schema
#85: Questions on histograms
#87: Some fields are duplicated in completeness tab
#88: authority tab crashes
#89: Provide record ids in raw download form
Add generic catalogue class
Adding KB class
Adjust completeness tab
Adjust CSS
Adjust h4 CSS
Adjust PICA record view
Adjust search/data tab
Avoid errors in Collocation
Change title and subtitle
CSS: introduce variables
Debug slowness
Don't die if count.csv contains no proper number
Extend documentation
Fix initial creation of selected-facets.js
Fix record's problems tab in data tab
Fixing ShelfReadyCompleteness tab
Fixing tt-completeness template link
header: reverse order of count and update
Improve resolveSolrField() function - handle indicators
Link facets tab from search
Measure completeness speed
Optionally include file in about tab
Remove hiddenTypes (PICA only)
Rename and link settings tab as "facets"
Show message if history is missing
simplify table in completeness tab
