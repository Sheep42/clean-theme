# WordPress Clean Theme

**TL;DR:** This is a stripped down WordPress theme created for custom theme developers to use as a starting point. This is the theme I use for my own side projects. I've tried to take a minimalist approach while including some [convenience functions](#convenience--utility) and [libraries](#included-technologies) that I like to use. [Getting Started](#getting-started) should give you enough of an overview to get going if you don't want to read all of the details.

# What This is Not
- No pre-defined custom fields! No custom post types! No post formats! No content builders! 100% Freedom to build whatever you need!

- This theme will **not** suit your existing WordPress website with no coding and no custom development, unless you are going for the [Stallman](https://stallman.org/) approach, and even then you'll need to do *some* styling. :)

- This theme comes with very little markup, the bare minimum in class names (mostly based on WP default themes) and almost no pre-defined styles. This is by design, so you can build on top of the skeleton that exists.

- This is not meant to be an accessibility or internationalization starter. There are some cases where I have left in textdomains and / or aria tags, it's up to you to build out the theme to suit your needs.

- You'll find very little convention forced upon you, outside of the build system, and I have set that up to be relatively isolated, so you can throw it away and use something else if you'd like.

# Why Is It Useful?
- Saves setup time if you are working on many projects and find yourself frequently duplicating existing themes or stripping down WP TwentyX

- Offers a simple starting point to be expanded in any way needed with an existing template structure, asset build system, and some convenience functions.

- Includes a [JS slider and the Bootstrap library](#included-technologies) for you to use or discard at your own discretion.

- Easy to read, use, and build upon. 

- Free and open source

# Getting Started

The goal of this theme is to provide an easy to understand and easy to use boilerplate theme for any custom WordPress project. 

### Requirements

**PHP**: 7.2+ Recommended

**NodeJS**: 12.16.0+

**WordPress**: 5.3.2

### Installing
Start by cloning the theme into your local WordPress instance under `wp-content/themes/clean-theme`

If you do not have nodejs installed, you will need to install it. You can find the latest stable version of node here: [https://nodejs.org/en/download/](https://nodejs.org/en/download/)

Once you have cloned the theme and installed nodejs, use the command line to run `npm install && npm start` from the theme directory. This will install the build system dependencies and run gulp. If you would like to use browser-sync, read the [section](#browser-sync) below.

### Using The Theme
I have tried to keep this theme as simple as possible, but I have added in some convenience functions and pulled in some concepts from the WP default themes. I have also defined a default template structure, which you may deviate from if it hinders you. Personally, I like to set up my projects this way, so that's why it is the way that it is.

#### Template Partials & Directory Structure
The first thing worth noting is the template parts directory. Here's what you get with the theme:
	
	template-parts
	├── footer ─ Footer template partials
	│   ├── footer-widgets.php 
	│   └── site-info.php
	├── navigation ─ Navigation template partials
	│   ├── navigation-social.php
	│   └── navigation-top.php 
	├── page ─ Page template partials
	│   ├── content-front-page.php
	│   └── content-page.php
	└── post ─ Post type template partials
	    ├── content-archive.php
	    ├── content-none.php
	    └── content-single.php

The idea here is pretty straightforward: 
- Footer partials are all footer related content

- Navigation partials correspond to a particular navigation menu
	- navigation-top is the main navigation
	- navigation-social is the default social buttons menu

- Page partials correspond to a particular page template
	- If you have particularly complex page templates, with re-usable components, you may want to consider breaking components out into their own partials or even their own directory.

- Post type partials should have a directory corresponding to a particular post type with a content-archive, content-none, and content-single for each post type.

##### Example Custom Post Type Template Parts
When  following this convention, single.php and archive.php will automatically load your post type content. This is useful for general content when archive pages don't need a lot of custom functionality. 

	template-parts
	├── ...
	└── book
	    ├── content-archive.php ─ Archive page content for a single 'book'
	    ├── content-none.php ─ Not found content for the 'book' post type
	    └── content-single.php ─ Single page content for a 'book'

### Assets
Source js files are located in `assets/js/src/`
Source scss files are located in `assets/css/scss/`
Images for css use should be placed in `assets/images/`
Sass imports are all set up in `assets/css/scss/style.scss`


Jump to more info on [JS](#js)

Jump to more info on [Sass](#sass)

# Included Technologies

### Bootstrap
	
##### Version: 4.4.1
[Bootstrap Documentation](https://getbootstrap.com/docs/)

The Bootstrap scss is included in this theme for you to use and modify. By default, the theme does not import any of the bootstrap css. This is by design, it's up to you to import the stylesheets that you want or need from the bootstrap library. See the [Sass section](#sass) for more details.

The minified bootstrap JS is also included in this theme. The bootstrap JS is loaded by default, to learn more about how vendor JS is imported into the theme, take a look at the JS section.

### Slick Slider 

##### Version: 1.8.1
[Slick Slider Documentation](https://kenwheeler.github.io/slick/)

The minified slick slider JS is included in this theme. Slick is loaded by default and ready to use. To learn more about how vendor JS is imported into the theme, take a look at the JS section.


# Build System

### Gulp
The theme uses [gulp 4](https://gulpjs.com/) as the core build system, because gulp is what I am familiar with and what I like to use. I've tried to keep the system as simple and non-pervasive as possible, so you are free to replace it with your own preferred system if you are unfamiliar or prefer not to use gulp.

##### Gulp Commands

    default: 'gulp'
	    Builds assets in dev mode (generates sourcemaps)
	    Generates asset caching manifest
	    Initializes browser sync
	    Watches JS and Scss files
		    Recompiles, rebuilds manifest, 
		    and reloads browser on change
	    Watches php files
		    Reloads browser on change
		    
    build: 'gulp build'
	    Builds assets in dev mode (generates sourcemaps)
	    Generates asset caching manifest
	    
    build_manifest: 'gulp build_manifest'
	    Generates asset caching manifest from 
	    existing build files

##### Gulp Options
	--production: 'gulp build --production'
		Ensures sourcemaps are not generated 
		or enabled for build files

		Default: False
		Type: Boolean

	--browser-sync: 
		'gulp --browser-sync'
			Initializes and runs browser-sync when watching files. 
			Same as running 'gulp' with no options

		'gulp --no-browser-sync'
			Disables browser-sync, and just watches / builds js & scss files

		Default: True
		Type: Boolean

### npm scripts
	npm start: Runs 'gulp' - default above
	npm run build: Runs 'gulp build --production'
	npm run build-dev: Runs 'gulp build'
	npm run no-browser-sync: Runs 'gulp --no-browser-sync'  

#### Browser-Sync
Browser-sync is included and enabled by default. If you are unaware, browser-sync is a tool which will watch specified files and automatically reload your browser when changes are made. To make it work, you'll need to open up the theme's `gulpfile.js` and modify the `watch` task.

Inside of the `browserSync.init()` options, you'll need to modify the line that reads `proxy: "clean-theme.local"` to reflect your local environment's url. You'll also want to update the line that reads `files: ['template-parts/**/*.php', '*.php']`  to include any additional file paths that you would like to watch for changes.

#### I don't want to use browser-sync

If you do not have a local environment, or prefer not to use browser-sync, then you don't have to!

You can use `npm run no-browser-sync` or `gulp --no-browser-sync` and the system will function as outlined, but without browser-sync. 

If you plan to never use browser-sync, you can modify `package.json` in the theme root so that the `npm start` script runs gulp with the no-browser-sync flag. 

#### Sass
This theme exclusively uses [Sass](https://sass-lang.com/) for styling and comes with a predefined file structure. However, you can deviate from the file structure if it doesn't suit your needs.

Imports are set up inside of  `_style.scss`. The Bootstrap library is included, but the import is commented out by default. If you want to use all of Bootstrap, you can simply uncomment the line and get going, but you can also import only the specific parts that you would like to use.

The basic sass structure is as follows:

    ├── base
    │   ├── _base.scss ─ Non-content base styles 
    │   ├── _forms.scss ─ Form base styles
    │   └── _general.scss ─ General base styles (h1-h6, p, table, lists, etc)
    ├── content
    │   ├── _archive.scss ─ General archive styles
    │   ├── _single.scss ─ General single styles
    │   ├── _page.scss ─ Default page template content styles
    │   └── _front-page.scss ─ Front page template content styles
    ├── global                     
    │   ├── _footer.scss ─ Footer content styles
    │   ├── _header.scss ─ Header content styles
    │   ├── _navigation.scss ─ Navigation content styles
    │   └── _sidebar.scss ─ Sidebar content styles
    ├── utility                
    │   ├── _classes.scss ─ Commonly used classes
    │   ├── _extends.scss ─ General purpose extends
    │   └── _mixins.scss ─ Mixins for commonly used style patterns
    ├── variables              
    │   ├── _breakpoints.scss ─ Breakpoint variables      
    │   ├── _colors.scss ─ Color variables
    │   ├── _fonts.scss ─ Font variables
    │   └── _images.scss ─ Image variables
    ├── vendor 
    │   ├── bootstrap ─ bootstrap's full scss library
    │   │   ├── ... ─ bootstrap's full scss library
    │   └── _reset.scss ─ Eric Meyer reset.css
    └── style.scss ─ Imports, this is the file which is eventually compiled and minified

Additional page template & post type scss files can be added under the `content` directory, and the `vendor` directory can be used to import additional 3rd party sass libraries.
	
#### JS
In general `.js` files will be minified and transpiled. 
Babel and minify are configured to skip `.min.js` files. 

JavaScript files in this theme are broken out into 3 main directories. 

##### admin
This directory contains scripts intended to run only in the WordPress admin dashboard. Files in this directory will be passed through babel and minify, and then concatenated and output into `assets/js/build/admin/admin.min.js` 
This file is included via an admin_enqueue_scripts hook.

##### theme
This directory contains scripts intended to run only on the front-end. Files in this directory will be passed through babel and minify, and then concatenated and output into `assets/js/build/theme/build.min.js` 
This file is included via a wp_enqueue_scripts hook.

##### vendor 
This directory is intended for 3rd party scripts that you would like to include in your project. Files placed here should always be pre-minified and should follow the naming convention `*.min.js`. Scripts placed in this directory will be concatenated with the theme scripts and output into main.min.js.
Included by default are Slick Slider and Bootstrap. To remove either, simply delete the desired file and rebuild the assets.

Here is what the default directory structure looks like:

		├── src 
		    ├── admin 
		    │   └── admin.js
		    ├── theme
		    │   └── main.js
		    └── vendor
		        ├── bootstrap.min.js
		        └── slick.min.js

#### Sourcemaps
The build system is configured to generate sourcemaps for both CSS and JS. 
CSS sourcemaps are output to `assets/css/maps/`
JS sourcemaps are output to `assets/js/build/maps/`

You can disable sourcemaps by running `gulp --production`, `gulp build --production`, `npm build`, or by removing the sourcemaps calls from gulpfile.js.

#### Asset Caching
This theme takes advantage of WordPress' asset caching with some help from the build system.

The build system generates a file called `asset_cache_manifest.json` in the theme root. This file contains json mapping final built asset files to a sha256 value created by hashing the file contents.

You can retrieve the value from this file in the theme by calling `_cleantheme_get_cache_version( $filename )` where `$filename` is the name of the file you need to get a caching value for.

An example of this system in use ships with the theme to enqueue style.css and main.min.js:

	// Theme base stylesheet.
	wp_enqueue_style( 'cleantheme-style', get_stylesheet_uri(), array(), _cleantheme_get_cache_version( 'style.css' ) );

	// enqueue main.min.js
	wp_enqueue_script( 'cleantheme-main-scripts', get_theme_file_uri( '/assets/js/build/theme/main.min.js' ), array( 'jquery' ), _cleantheme_get_cache_version( 'main.min.js' ), true ); 

**When WP_DEBUG is set to true, asset caching will always be busted.**

It's worth noting that `_cleantheme_get_cache_version` uses wp_cache_set / wp_cache_get to avoid reading the manifest file multiple times in a row within the same page load. 

# Convenience & Utility 

### functions.php

I've left in a small handful of helpful default WordPress theme functions including, but not limited to DNS prefetching and Google font loading. I'll briefly describe each.

##### DNS Prefetch
**function:** `cleantheme_resource_hints()`

This function hooks wp_resource_hints to speed up the loading of external resources by resolving the DNS before the request is made.

Out of the box, this is only prefetching Google fonts. You can utilize this for your other external resources, though by following the same pattern already used.

##### Google Font Loading
**function:** `cleantheme_google_fonts_url()`

This function builds out the google fonts url for use in enqueuing the stylesheet. 

Out of the box, this includes Open Sans in the theme. Adding additional font strings to the $font_families array will include those in your project as well. 

##### Simple Post Type Creation
**function:** `cleantheme_register_post_type()`

This is an abstraction to simplify the creation of simple post types. The idea is that if you need to create a post type quickly without too much customization, this will take care of building the labels and setting the options for you. 

This is **not** meant to be a replacement for `register_post_type()`. Simply a faster process when that level of granular control is not required.

See the documentation inside of functions.php for usage information.

### admin.js
##### Page Template Admin Body Class
The only JavaScript included in admin.js out of the box is a small snippet of jQuery which will append a body class of `template-template-slug.php` when adding / editing a page. The body class will update when the dropdown is changed.

This can be useful if you need to target admin elements for styling based on specific page templates. 
