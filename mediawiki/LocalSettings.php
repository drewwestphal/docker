<?php
# This file was automatically generated by the MediaWiki 1.30.0
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if(!defined('MEDIAWIKI')) {
    exit;
}

/**
 * DW ADDITIONS
 * DW ADDITIONS
 * DW ADDITIONS
 * DW ADDITIONS
 *
 * This file modified for use with env variables from a file
 * that was created using the auto installer from the stock
 * library/mediawiki container
 */

// FIRST: check for required env vars
$requiredAll = [
    'MEDIAWIKI_MYSQL_DB_URL',
    'MEDIAWIKI_FULLY_QUALIFIED_URL',
    'MEDIAWIKI_SITE_NAME',
    'MEDIAWIKI_SITE_NAMESPACE_INVARIANT',
    'MEDIAWIKI_LOGO_IMAGE_RELPATH',
    'MEDIAWIKI_EMAIL_FROM_ADDRESS',
    'MEDIAWIKI_SECRET_KEY_64_CHAR',
    'MEDIAWIKI_SECRET_UPGRADE_KEY_64_CHAR',
    'MEDIAWIKI_PRIVACY_SETTING',
];
foreach($requiredAll as $requiredVar) {
    if(!getenv($requiredVar)) {
        echo "required:";
        print_r($requiredAll);
        die("Environment Variable $requiredVar is not set");
    }
}
$database_url = getenv('MEDIAWIKI_MYSQL_DB_URL');

if(getenv('MEDIAWIKI_DEBUG')) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}
/**
 *
 * // END DW ADDITIONS
 *
 */

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = getenv('MEDIAWIKI_SITE_NAME');
$wgMetaNamespace = getenv('MEDIAWIKI_SITE_NAMESPACE_INVARIANT');

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";

## The protocol and server name to use in fully-qualified URLs
$wgServer = getenv('MEDIAWIKI_FULLY_QUALIFIED_URL');

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = getenv('MEDIAWIKI_LOGO_IMAGE_RELPATH');

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = getenv('MEDIAWIKI_EMAIL_FROM_ADDRESS');
$wgPasswordSender = getenv('MEDIAWIKI_EMAIL_FROM_ADDRESS');

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = parse_url($database_url, PHP_URL_SCHEME);
$wgDBserver = parse_url($database_url, PHP_URL_HOST);
$wgDBname = explode('/', parse_url($database_url, PHP_URL_PATH))[1];
$wgDBuser = parse_url($database_url, PHP_URL_USER);
$wgDBpassword = parse_url($database_url, PHP_URL_PASS);

# MySQL specific settings
$wgDBprefix = getenv('MEDIAWIKI_TABLE_PREFIX');

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = false;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";

$wgSecretKey = getenv('MEDIAWIKI_SECRET_KEY_64_CHAR');

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = getenv('MEDIAWIKI_SECRET_UPGRADE_KEY_64_CHAR');

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer

switch(getenv('MEDIAWIKI_PRIVACY_SETTING')) {
    case 'PRIVATE':
    default:
        $wgGroupPermissions['*']['createaccount'] = false;
        $wgGroupPermissions['*']['edit'] = false;
        $wgGroupPermissions['*']['read'] = false;
        break;
}

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin('CologneBlue');
wfLoadSkin('Modern');
wfLoadSkin('MonoBook');
wfLoadSkin('Vector');


# End of automatically generated settings.
# Add more configuration options below.

