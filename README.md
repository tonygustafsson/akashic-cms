# Akashic CMS

## About

Not for production yet.

## Include

To include files, recursevly:
[[path/subpath/file]]
would include ./path/subpath/file.php.

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
    