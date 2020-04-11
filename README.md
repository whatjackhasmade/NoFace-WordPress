# noface.co.uk

NoFace Agency website built in Wordpress with [Bedrock](https://roots.io/bedrock/).

Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

## Requirements

- PHP >= 7.1
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- Node - [Install](https://nodejs.org/en/download/)

## Installation

1. Clone this repository to your local PHP environment:

```sh
$ git@github.com:whatjackhasmade/noface-wordpress.git
```

or using HTTP (requires Github login):

```sh
$ git https://github.com:whatjackhasmade/noface-wordpress.git
```

2. Create [environment variables](#user-content-example-env) in a `.env` file in the root of your project.
3. Set the document root on your webserver to Bedrock's `web` folder: `/path/to/noface.co.uk/web/`
4. Run the install command from your root directory:

```sh
$ composer install
```

5. Access WordPress admin at [https://noface.local/wp/wp-admin/](https://noface.local/wp/wp-admin/)

- You will need to go through the Wordpress install process at this point
- If you have am XML file of content to import, along with media, replace the `web/app/uploads` folder with your version, and then import the XML file using the [built-in importer](https://wordpress.org/support/article/importing-content/)

6. Update the Permalink settings (`Settings > Permalinks`) to use `Post name`
7. Update the `Your homepage displays` setting (`Settings > Reading`) to use a static page, and select the `Home` page for the `Homepage` dropdown
8. To develop with the site, you will need to install Gulp and it's required packages to process SCSS/CSS/JS files. To do so, run `$ npm install` in a terminal from the root directory of the project.
9. To run Gulp, run the command `$ npm run develop` in a terminal from the root directory of the project.
10. After a few seconds, gulp should automatically open [http://localhost:3000](http://localhost:3000) in your browser. This URL mirrors the local domain [https://noface.local](https://noface.local) for hot-reloading. If you have a different domain setup locally, swap this out in your gulpfile.js but don't commit the changed URL.

## Example .env

```
DB_NAME='local'
DB_USER='root'
DB_PASSWORD='root'

WP_ENV='development'
WP_HOME='https://noface.local'
WP_SITEURL="${WP_HOME}/wp"

# Generate your keys here: https://roots.io/salts.html
AUTH_KEY='(pd=z_sp2xQ7w!rK!uhv$s_N^JU1wLDI?LGF47X/}>G)B/-8n0IiYArLD=Mqc!+Z'
SECURE_AUTH_KEY='j&|zsBLJ)BRD0.KIN@!DxS30:?VmOi:?6Wa>h88{YXahEEjgh&!cRUz`Q_mf^F]!'
LOGGED_IN_KEY='UCX4gLBPRjl3q59/[@Ex1>RZ5/Qz+<>=Y%fFY}qQ^pbXTwzXpi/:RgwK;3d#(NKj'
NONCE_KEY='QYf}{3Cc{RY=;W3|a/cbV.C[U4ou0B;};L)giV?N.c{}@^DV]|4Dlvustv0z$s]p'
AUTH_SALT='SM^+,0-nN;x14oswk1<K|zh/a7RWrlT&g_8@x}rwnUeT*E$Bjr]H-Qm92=4;xWh^'
SECURE_AUTH_SALT='dr+MB|eM/E(W+&Ec{}S7//iw4iT94UEpgl)we{u7lrC0HKa#V-x2*;y5p$z0`?>i'
LOGGED_IN_SALT=':e,vdA4x>e/{-|_Bak]D-kHtMJFs-xkhlZO&68NBtJHvgvt6Z&uMCbx>W^IW}oVC'
NONCE_SALT='Z(x?[,-v&sNK.s7tq@%niVnyt>JC|^1)@Hr^0axzTWHR$-fw?B@mVX1p{bnPN[;!'

ACF_PRO_KEY='INSERT_KEY_HERE'
GOOGLE_API_KEY='INSERT_KEY_HERE'
```
