<?php

class eTemplateColor
{

    const blue = 1;
    const green = 2;
    const yellow = 3;
    const red = 4;
    const orange = 5;
    const grey = 6;

    /**
     * Returns Key(int) => Colorname(string)
     * @return array
     */
    public static function colorSet()
    {
        return array(
            self::blue => "blue",
            self::green => "green",
            self::yellow => "yellow",
            self::red => "red",
            self::orange => "orange",
            self::grey => "grey",
        );
    }

    public static function colorName($colorKey)
    {
//	'template_chooser_frontcolor1' => 'Yeşil',
//	'template_chooser_frontcolor2' => 'Sarı',
//	'template_chooser_frontcolor3' => 'Mavi',
//	'template_chooser_frontcolor4' => 'Kırmızı',
//	'template_chooser_frontcolor5' => 'Turuncu',
        switch ($colorKey) {
            case self::blue:
                return __('common.template_chooser_frontcolor3');
            case self::green:
                return __('common.template_chooser_frontcolor1');
            case self::yellow:
                return __('common.template_chooser_frontcolor2');
            case self::red:
                return __('common.template_chooser_frontcolor4');
            case self::orange:
                return __('common.template_chooser_frontcolor5');
            case self::grey:
                return __('common.template_chooser_frontcolor6');
        }
    }

    public static function templateCss($fileName)
    {
        $colorKey = basename($fileName, '.css');
        $templateColorCode = self::colorCode($colorKey);
        $templateImageSrc = self::imageSource($colorKey);
        $fileContent = File::get(path('app') . "csstemplates/color.css");
        $fileContent = str_replace("#TemplateColor#", $templateColorCode, $fileContent);
        $fileContent = str_replace("#TemplateImage#", $templateImageSrc, $fileContent);
        $fileContent = str_replace("#ColorKey#", $colorKey, $fileContent);
        $fileContent = str_replace("#APP_VER#", APP_VER, $fileContent);
        return $fileContent;
    }

    public static function colorCode($colorKey)
    {
        switch ($colorKey) {
            case self::blue:
                return \Laravel\Config::get('custom.api_color_blue');
            case self::green:
                return \Laravel\Config::get('custom.api_color_green');
            case self::yellow:
                return \Laravel\Config::get('custom.api_color_yellow');
            case self::red:
                return \Laravel\Config::get('custom.api_color_red');
            case self::orange:
                return \Laravel\Config::get('custom.api_color_orange');
            case self::grey:
                return \Laravel\Config::get('custom.api_color_grey');
        }
    }

    public static function imageSource($colorKey)
    {
        switch ($colorKey) {
            case self::blue:
                return '/img/template-chooser/color-picker-blue.png';
            case self::green:
                return '/img/template-chooser/color-picker-blue.png';
            case self::yellow:
                return '/img/template-chooser/color-picker-blue.png';
            case self::red:
                return '/img/template-chooser/color-picker-blue.png';
            case self::orange:
                return '/img/template-chooser/color-picker-blue.png';
            case self::grey:
                return '/img/template-chooser/color-picker-blue.png';
        }
    }

}
