<?php

class eTemplateColor
{
    private static $imageFolder = 'img/template-chooser/';
    private static $imageGeneratedFolder = 'img/template-generated/';

    private static $requiredImageSet = array(
        'menu1.png',
        'home_selected1.png',
        'library_selected1.png',
        'download_selected1.png',
        'info_selected1.png',
        'left_menu_category_icon1.png',
        'left_menu_down1.png',
        'left_menu_link1.png',
        'reader_menu1.png',
        'reader_share1.png',
    );

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
