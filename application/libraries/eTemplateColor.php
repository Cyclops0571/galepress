<?php

class eTemplateColor
{
    private static $imageFolder = 'img/template-chooser/';
    private static $imageGeneratedFolder = 'img/template-generated/';

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
            self::grey => "carmen_red",
            self::grey => "galibarda",
        );
    }

    public static function templateCss($fileName)
    {
        $templateColorCode = basename($fileName, '.css');
        foreach (self::$requiredImageSet as $requiredImageTmp) {
            $requiredImageWithPath = path('public') . self::$imageGeneratedFolder . str_replace('1', $templateColorCode, $requiredImageTmp);
            $origImgWithPath = path('public') . self::$imageFolder . $requiredImageTmp;
            if (!\Laravel\File::exists($requiredImageWithPath)) {
                exec("convert " . $origImgWithPath . ' -fuzz 90% -fill \'#' . $templateColorCode . '\' -opaque blue ' . $requiredImageWithPath);
            }
        }

        $fileContent = File::get(path('app') . "csstemplates/color.css");
        $fileContent = str_replace("#TemplateColor#", $templateColorCode, $fileContent);
        $fileContent = str_replace("#APP_VER#", APP_VER, $fileContent);
        return $fileContent;
    }

}
