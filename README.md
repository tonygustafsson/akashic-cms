# Akashic CMS

## About

Not for production yet.

Are you stuck with old fashion web hotels too? Stuck delivering php and mysql to old customers who are not interested in being awesome? Me too.

Let's build something that will work for these customers. Where you can code freely and without limits, and still let the customer be in charge, such as language aware content.

What if the customer could edit the data stores, and not eff up the HTML?
What if the HTML would not look like crap just because it were dynamically generated?

I've built so many wordpress and woocommerce sites where I totally lost control over the code and were dependent on plugins, which
where developed by bunglers like me. I've built so many custom made sites in PHP and built myself into a corner because of
changes in plans and customer wantings. I need something that I'm in control of that make development fast.

## Pages

A routing system is included. All landing pages should exist in ./pages
and is accessed through site-url/my-page that would get ./pages/my-page.php
and site-url/sub/sub2 would get ./pages/sub/sub2/index.php.

## Templates

Templates exists in ./templates and can not be accessed directly with an URL.
Instead it's defined on top of a page file as [template: my-template] that would put all
content of the page inside of ./templates/my-template.php. The placement for the
content is defined inside the template as [content].

## Include modules

To include modules you type [module: path/subpath/my-module]
which would include module ./path/subpath/my-module.php.
This can be done recursively.

## Data stores

Define a data store for a page with [data: my-store]
that would get ./data/my-store.json.
Then use ${variable} to get variable from my-store.json.

## Foreach loops

You can access data stores and loop through them with
<ul>
	[foreach ${persons}:
		<li>${name} is ${age} years old.</li>
	]
</ul>

It would then get ./data/persons.json and get the name and age from this file.

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
    