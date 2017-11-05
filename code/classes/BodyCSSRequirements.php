<?php
class CustomRequirements_Backend extends Requirements_Backend {

    protected $bodyCSS;

    public function includeInHTML($templateFile, $content) {
        $requirements = '';
        foreach($this->bodyCSS as $file => $params) {
            $path = Convert::raw2xml($this->path_for_file($file));
            if($path) {
                $media = (isset($params['media']) && !empty($params['media']))
                    ? " media=\"{$params['media']}\"" : "";
                $requirements .= "<link rel=\"stylesheet\" type=\"text/css\"{$media} href=\"$path\" />\n";
            }
        }
        $content = preg_replace("/(<\/body[^>]*>)/i", $requirements . "\\1", $content);
        return parent::includeInHTML($templateFile, $content);
    }

    public function bodyCSS($file, $media = null) {
        $this->bodyCSS[$file] = array(
            "media" => $media
        );
    }

}