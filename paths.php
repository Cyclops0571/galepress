<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @version  3.2.13
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 * @link     http://laravel.com
 */
/*
|----------------------------------------------------------------
| Application Environments
|----------------------------------------------------------------
|
| Laravel takes a dead simple approach to environments, and we
| think you'll love it. Just specify which URLs belong to a
| given environment, and when you access your application
| from a URL matching that pattern, we'll be sure to
| merge in that environment's configuration files.
|
*/

$environments = array(

    'local' => array('http://localhost*', '*.dev', '*vagrant*', '*mygalepress.*', '*.old'),
    'test' => array('*.galetest.com*'),
    'live' => array('*.galepress.com*')

);

// --------------------------------------------------------------
// The path to the application directory.
// --------------------------------------------------------------
$paths['app'] = 'application';

// --------------------------------------------------------------
// The path to the Laravel directory.
// --------------------------------------------------------------
$paths['sys'] = 'laravel';

// --------------------------------------------------------------
// The path to the bundles directory.
// --------------------------------------------------------------
$paths['bundle'] = 'bundles';

// --------------------------------------------------------------
// The path to the storage directory.
// --------------------------------------------------------------
$paths['storage'] = 'storage';

// --------------------------------------------------------------
// The path to the public directory.
// --------------------------------------------------------------
$paths['public'] = 'public';

// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
// END OF USER CONFIGURATION. HERE BE DRAGONS!
// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
/*
                                                  .~))>>
                                                 .~)>>
                                               .~))))>>>
                                             .~))>>             ___
                                           .~))>>)))>>      .-~))>>
                                         .~)))))>>       .-~))>>)>
                                       .~)))>>))))>>  .-~)>>)>
                   )                 .~))>>))))>>  .-~)))))>>)>
                ( )@@*)             //)>))))))  .-~))))>>)>
              ).@(@@               //))>>))) .-~))>>)))))>>)>
            (( @.@).              //))))) .-~)>>)))))>>)>
          ))  )@@*.@@ )          //)>))) //))))))>>))))>>)>
       ((  ((@@@.@@             |/))))) //)))))>>)))>>)>
      )) @@*. )@@ )   (\_(\-\b  |))>)) //)))>>)))))))>>)>
    (( @@@(.@(@ .    _/`-`  ~|b |>))) //)>>)))))))>>)>
     )* @@@ )@*     (@)  (@) /\b|))) //))))))>>))))>>
   (( @. )@( @ .   _/  /    /  \b)) //))>>)))))>>>_._
    )@@ (@@*)@@.  (6///6)- / ^  \b)//))))))>>)))>>   ~~-.
 ( @jgs@@. @@@.*@_ VvvvvV//  ^  \b/)>>))))>>      _.     `bb
  ((@@ @@@*.(@@ . - | o |' \ (  ^   \b)))>>        .'       b`,
   ((@@).*@@ )@ )   \^^^/  ((   ^  ~)_        \  /           b `,
     (@@. (@@ ).     `-'   (((   ^    `\ \ \ \ \|             b  `.
       (*.@*              / ((((        \| | |  \       .       b `.
                         / / (((((  \    \ /  _.-~\     Y,      b  ;
                        / / / (((((( \    \.-~   _.`" _.-~`,    b  ;
                       /   /   `(((((()    )    (((((~      `,  b  ;
                     _/  _/      `"""/   /'                  ; b   ;
                 _.-~_.-~           /  /'                _.'~bb _.'
               ((((~~              / /'              _.'~bb.--~
                                  ((((          __.-~bb.-~
                                              .'  b .~~
                                              :bb ,' 
                                              ~~~~
*/

// --------------------------------------------------------------
// Change to the current working directory.
// --------------------------------------------------------------
chdir(__DIR__);

// --------------------------------------------------------------
// Define the directory separator for the environment.
// --------------------------------------------------------------
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// --------------------------------------------------------------
// Define the path to the base directory.
// --------------------------------------------------------------
$GLOBALS['laravel_paths']['base'] = __DIR__ . DS;

// --------------------------------------------------------------
// Define each constant if it hasn't been defined.
// --------------------------------------------------------------
foreach ($paths as $name => $path) {
    if (!isset($GLOBALS['laravel_paths'][$name])) {
        $GLOBALS['laravel_paths'][$name] = realpath($path) . DS;
    }
}

/**
 * A global path helper function.
 *
 * <code>
 *     $storage = path('storage');
 * </code>
 *
 * @param  string $path
 * @return string
 */
function path($path)
{
    return $GLOBALS['laravel_paths'][$path];
}

/**
 * A global path setter function.
 *
 * @param  string $path
 * @param  string $value
 * @return void
 */
function set_path($path, $value)
{
    $GLOBALS['laravel_paths'][$path] = $value;
}


define("ENV_TEST", "test");
define("ENV_LOCAL", "local");
define("ENV_LIVE", "live");
define("APP_VER", 96);
define("IMAGE_CROPPED_NAME", "cropped_image");
define("IMAGE_CROPPED_2048", "cropped_image_1536x2048.jpg");
define("IMAGE_ORJ_EXTENSION", "_org.jpg");
define("IMAGE_ORIGINAL", "original");
define("IMAGE_EXTENSION", ".jpg");
define("CATEGORY_GENEL_ID", 1);
define("SHOW_IMAGE_CROP", "showImageCrop");
define("PATH_TEMP_FILE", "files/temp");
define("TAB_COUNT", 2);
define("GO_BACK_TO_SHOP", 'gobacktoshop');