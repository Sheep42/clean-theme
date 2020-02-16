

# WordPress Clean Theme

**TL;DR:** This is a stripped down WordPress theme created for custom theme developers to use as a starting point. This is the theme I use for my own side projects. I've tried to take a minimalist approach while including some convenience functions and libraries that I like to use. [Getting Started](#getting-started) should give you enough of an overview to get going if you don't want to read all of the details.

# What This is Not

- No pre-defined custom fields! No custom post types! No post formats! No content builders! 100% Freedom to build whatever you need!

- This theme will **not** suit your existing WordPress website with no coding and no custom development, unless you are going for the [Stallman](https://stallman.org/) approach, and even then you'll need to do *some* styling. :)

- This theme comes with very little markup, the bare minimum in class names (mostly based on WP default themes) and almost no pre-defined styles. This is by design, so you can build on top of the skeleton that exists.

- You'll find very little convention forced upon you, outside of the build system, and I have set that up to be isolated, so you can throw it away and use something else if you'd like.

# Why Is It Useful?
- Saves setup time if you are working on many projects and find yourself frequently duplicating existing themes or stripping down WP TwentyX

- Offers a (hopefully) clean starting point to be expanded in any way needed while offering an existing template structure, asset build system, and some convenience functions.

- Includes a [JS slider and the Bootstrap library](#included-technologies) for you to use or discard at your own discretion.

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

# Included Technologies

### Bootstrap
	
##### Version: 4.3.1
[Bootstrap Documentation](https://getbootstrap.com/docs/)

The Bootstrap scss is included in this theme for you to use and modify. By default, the theme does not import any of the bootstrap css. This is by design, it's up to you to import the stylesheets that you want or need from the bootstrap library. See the Sass & CSS section for more details.

The minified bootstrap JS is also included in this theme. The bootstrap JS is loaded by default, to learn more about how vendor JS is imported into the theme, take a look at the JS section.

### Slick Slider 

##### Version: 1.8.1
[Slick Slider Documentation](https://kenwheeler.github.io/slick/)

The minified slick slider JS is included in this theme. Slick is loaded by default and ready to use. To learn more about how vendor JS is imported into the theme, take a look at the JS section.


# Build System
### Gulp
The theme uses [gulp 4](https://gulpjs.com/) as the core build system, because gulp is what I am familiar with and what I like to use. I've tried to keep the system as simple and non-pervasive as possible, so you are free to replace it with your own preferred system if you are unfamiliar or prefer not to use gulp.

#### Browser-Sync
Browser-sync is included and enabled by default. If you are unaware, browser-sync is a tool which will watch specified files and automatically reload your browser when changes are made. To make it work, you'll need to open up the theme's `gulpfile.js` and modify the `watch` task.

Inside of the `browserSync.init()` options, you'll need to modify the line that reads `proxy: "clean-theme.local"` to reflect your local environment's url. You'll also want to update the line that reads `files: ['template-parts/**/*.php', '*.php']`  to include any additional file paths that you would like to watch for changes.

#### I don't want to use browser-sync

If you do not have a local environment, or prefer not to use browser-sync you can comment or remove the entire browser-sync init call from `gulpfile.js`:

    browserSync.init({
        files: ['template-parts/**/*.php', '*.php'],
        proxy: "clean-theme.local",
        snippetOptions: {
          whitelist: ['/wp-admin/admin-ajax.php'],
          blacklist: ['/wp-admin/**']
        }
    });
You should also remove any calls to `browserSync.reload`.

#### Sass
This theme exclusively uses [Sass](https://sass-lang.com/) for styling and comes with . However, you can deviate from the file structure if it doesn't suit your needs.

Imports are set up inside of  `_style.scss`. The Bootstrap library is included, but the import is commented out by default. If you want to use all of Bootstrap, you can simply uncomment the line and get going, but you can also import only the specific parts that you would like to use.

The basic sass structure is as follows:

    ├── base
    │   ├── _base.scss ─ Non-content base styles 
    │   ├── _forms.scss ─ Form base styles
    │   └── _general.scss ─ General base styles (h1-h6, p, table, lists, etc)
    ├── content
    │   ├── _page.scss ─ Default page template content styles
    │   └── _front-page.scss ─ Front page template content styles
    ├── global                     
    │   ├── _footer.scss ─ Footer content styles
    │   ├── _header.scss ─ Header content styles
    │   ├── _navigation.scss ─ Navigation content styles
    │   └── _sidebar.scss ─ Sidebar content styles
    ├── utility                
    │   ├── _classes.scss ─ Commonly used classes
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
	
#### JS


# Convenience Functions

### Google Font Loading


### Simple Post Type Creation


### Virtual Page Creation


### Page Template Admin Body Class


