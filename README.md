# Akashic CMS

## About

Not for production yet.

## Pages

A routing system is included. All landing pages should exist in ./pages
and is accessed through site-url/page that would get ./pages/page.php
and site-url/sub/sub2 would get ./pages/sub/sub2/index.php.

## Templates

Templates exists in ./templates and can not be accessed directly with an URL.
Instead it's defined on top of a page file as @{my-template} that would put all
content of the page inside of ./templates/my-template.php. The placement for the
content is defined inside the template as ${content}.

## Include modules

To include modules, recursevly:
[[path/subpath/module]]
would include module ./path/subpath/module.php.

## Data stores

Define a data store for a page with ##datastore##
that would get ./data/datastore.json.
Then use ${variable} to get variable from datastore.json.

## Settings

Edit global settings in ./settings.php.

## The future

My thought is to have data objects that handles generic objects
that the customer can change without effing up the site.

They could control translation, sort order, titles, descriptions.

### Future structure

* Data Stores
    * Movies

* Data fields (1-1 to data stores)
	* Movies-Name
		* Name: Name
		* Type: String
		* FormType: TextInput / Select
		* LanguageDependant: true/false

* Movies
	* Goonies
		* ID: 100
		* Name: The Goonies
		* SortOrder: 10
		* Genre: Comedy
		* Minute: 124
		
* Languages
	* Swedish
		* SE
		* SV

* Pages
    * Book list page
        * Template
        * Content / Includes
		
* Templates
	* HTML files with variables, ie $name that matches data store
	* Ability to import other templates
    