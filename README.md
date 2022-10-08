# Horsera
This repository will be developed alongside its pre-installed modules.

## How to build a module??
For a module package you will need the "icon.png" and the "index.php" files.
The recommended icon size is 16x16. In the index.php file, you put whatever code you want to be run when the module is opened.

## Add-ons
 Add-ons are not modules, but PHP files that can be put in the "addons" directory. They will be always included in any service.

## Multiple pages in a module
Unfortunately, the URL parameters for a service may be different between installations. You will need to use POST requests wth forms to open other pages.

## The Horsera standards
To make a flexible module, you will need to follow these standards.

  * Avoid using GET requests
  * Avoid modifying the theme or using custom CSS styles
  * Make sure your data location doesn't conflict with another module that might exist by using your module name in the folder.
  * Store your data in the "db" folder.
  * If possible use other modules' features, such as Followlists, Profile pictures (coming soon) or Biographies
  * Keep your code as optimized and secure as possible
  * If your module accessess paths based on user input, make sure you block the ".." symbol.

## Tips for users

  * Make sure you protect the "db" folder with you server configuration (.htaccess) but make sure the PHP files can access it.
  * Avoid downloading services or addons from untrusted sources.
  * Install an anti-ddos extension on your HTTP server. (request limit)
