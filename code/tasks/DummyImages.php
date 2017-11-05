<?php
class DummyImages extends BuildTask {

    protected $title = 'Dummy Images';

    protected $enabled = true;

    function run($request) {
        $base = Director::baseFolder();
        $folder = $request->requestVar('folder');
        $count = $request->requestVar('count');
        $name_length = $request->requestVar('name_length');
        $fixed_width = $request->requestVar('width');
        $fixed_height = $request->requestVar('height');
        for ($i = 0; $i < $count; $i++) {
            $width = isset($fixed_width) ? $fixed_width : mt_rand(320, 1280);
            $ratio = mt_rand(9,20)/10;
            $bgcolor = str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $textcolor = Helpers::getContrastYIQ($bgcolor);
            $height = isset($fixed_height) ? $fixed_height : round($width / $ratio);
            if (isset($name_length)) $name = sprintf("%0{$name_length}d.jpg", $i);
            else $name = "{$width}x{$height}.{$bgcolor}.jpg";
            if (!file_exists("{$base}/{$folder}")) mkdir("{$base}/{$folder}");
            file_put_contents("{$base}/{$folder}/{$name}", fopen("http://placehold.it/{$width}x{$height}/{$bgcolor}/{$textcolor}.jpg", 'r'));
            echo $name.PHP_EOL;
        }
    }

}