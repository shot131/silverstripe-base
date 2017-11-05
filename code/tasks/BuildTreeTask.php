<?php

class BuildTreeTask extends BuildTask {

    private $sort = 1;

    private $defaultClass = 'Page';

    private $dry = false;

    private static $reserved = ['class','children'];

    private function createPage($name, $data = [], $parentID) {
        $class = isset($data['class']) ? $data['class'] : $this->defaultClass;
        $page = $class::create([
            'Title' => $name,
            'MenuTitle' => $name,
            'ParentID' => $parentID,
            'URLSegment' => isset($data['URLSegment']) ? $data['URLSegment'] : Helpers::translit($name),
            'Sort' => $this->sort++
        ]);
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, self::$reserved)) {
                    $page->setField($key, $value);
                    //echo $key . ': ' . $page->getField($key) . "\n";
                }
            }
        }
        foreach($page->toMap() as $field => $value) {
            if (gettype($value) !== 'object')
                echo "$field: $value\n";
        }
        echo "\n";
        if (!$this->dry) {
            $page->write();
            $page->publish("Stage", "Live");
        }
        if (isset($data['children']) and count($data['children'])) {
            foreach ($data['children'] as $name => $data) {
                $this->createPage($name, $data, $page->ID);
            }
        }
    }

    public function run($request) {
        if (!$request->getVar('src')) return;
        $tree = yaml_parse_file(__DIR__.'/'.$request->getVar('src').'.yml');
        $parentID = $request->getVar('parent') ?: 0;
        if ($request->getVar('class')) $this->defaultClass = $request->getVar('class');
        if ($request->getVar('dry')) $this->dry = $request->getVar('dry');
        foreach ($tree as $name => $data) {
            $this->createPage($name, $data, $parentID);
        }
    }

}