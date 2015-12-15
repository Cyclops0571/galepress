<?php

/**
 * Class LaravelLang
 * @property string LaravelLangID
 * @property string de
 * @property string en
 * @property string tr
 * @property string usa
 */
class LaravelLang extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'LaravelLang';
    public static $key = 'LaravelLangID';
    public static $exportFolder = 'exportedlangs/';
    public static $langFiles = array(
        'clients',
        'common',
        'content',
        'error',
        'interactivity',
        'javascriptlang',
        'notification',
        'pagination',
        'route',
        'validation',
        'website',
    );
    public static $langs = array(
        'en', 'tr', 'de', 'usa'
    );


    public static function writeToDB()
    {
        set_time_limit(0);

        foreach (self::$langFiles as $langFile) {
            foreach (self::$langs as $lang) {
                Laravel\Lang::load('application', $lang, $langFile);
            }
        }

        foreach (Laravel\Lang::$lines as $bundle => $languages) {
            foreach ($languages as $language => $files) {
                foreach ($files as $file => $words) {
//                    echo $file, PHP_EOL;
                    foreach ($words as $wordKey => $translation) {

                        $laravelLang = LaravelLang::find($file . "." . $wordKey);
                        if (!$laravelLang) {
                            $laravelLang = new LaravelLang();
                        }
                        $laravelLang->LaravelLangID = $file . "." . $wordKey;
                        $laravelLang->$language = LaravelLang::_arrayStringfy($translation);
                        $laravelLang->save();
                    }
                }
            }
        }
    }

    private static function _arrayStringfy($subject)
    {
        if (is_array($subject)) {
            $result = 'array(';
            if ((bool)count(array_filter(array_keys($subject), 'is_string'))) {
                //associative array
                foreach ($subject as $key => $value) {
                    $result .= "\n\t\t'" . $key . "' => " . DB::escape($value) . ",";
                }
                $result .= "\n\t)";

            } else {
                foreach ($subject as $value) {
                    $result .= DB::escape($value) . ',';
                }
                $result .= ")";
            }

        } else {
            $result = DB::escape($subject);
        }
        return $result;
    }

    public static function Export()
    {
        $starter = "<?php \n return array(";
        $ender = "\n);";
        $path = path('public');
        File::cleandir($path . self::$exportFolder);
        foreach (self::$langs as $lang) {
            File::mkdir($path . self::$exportFolder . $lang);
            foreach (self::$langFiles as $langFile) {
                File::put($path . self::$exportFolder . $lang . "/" . $langFile . ".php", $starter);

            }
        }

        /** @var LaravelLang[] $laravelLangs */
        $laravelLangs = LaravelLang::get();
        foreach ($laravelLangs as $laravelLang) {
            $exp = explode('.', $laravelLang->LaravelLangID);

            $fileName = $exp[0] . ".php";
            $key = $exp[1];

            foreach (self::$langs as $lang) {
                $filePath = $path . self::$exportFolder . $lang . "/" . $fileName;
                $laravelLang->addComment($filePath);
                $value = empty($laravelLang->$lang) ? "\t'',\n" : "\t'" . $key . "' => " . $laravelLang->$lang . ",\n";
                File::append($filePath, $value);
            }
        }

        foreach (self::$langs as $lang) {
            foreach (self::$langFiles as $langFile) {
                File::append($path . self::$exportFolder . $lang . "/" . $langFile . ".php", $ender);

            }
        }
    }

    private function addComment($filePath)
    {
        switch ($this->LaravelLangID) {
            case 'validation.custom':
                $comment = <<<EOF

    /*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

EOF;

                File::append($filePath, $comment);
                break;
            case 'validation.attributes':
                $comment = <<<EOF

    /*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

EOF;
                File::append($filePath, $comment);
                break;
        }
    }
}