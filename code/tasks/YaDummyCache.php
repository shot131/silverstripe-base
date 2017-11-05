<?php

class YaDummyCache extends BuildTask {

    public function run($request) {
        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::title();
            $strings[] = $string;
            echo 'title: '.$string."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/title', serialize($strings));

        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::phrase();
            $strings[] = $string;
            echo 'phrase: '.$string."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/phrase', serialize($strings));

        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::paragraph();
            $strings[] = $string;
            echo 'paragraph: '.$string."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/paragraph', serialize($strings));

        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::paragraphs();
            $strings[] = $string;
            echo 'paragraphs: '.$string."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/paragraphs', serialize($strings));

        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::word();
            $strings[] = $string;
            echo 'word: '.$string."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/word', serialize($strings));

        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::person();
            $strings[] = $string;
            echo 'person: '.json_encode($string)."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/person', serialize($strings));

        $strings = [];
        for ($i = 0; $i < 100; $i++) {
            $string = YaDummy::date();
            $strings[] = $string;
            echo 'date: '.$string."\n";
        }
        file_put_contents(BASE_PATH.'/unicontent/code/helpers/date', serialize($strings));
    }

}