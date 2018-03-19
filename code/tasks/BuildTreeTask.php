<?php

class BuildTreeTask extends BuildTask {

    private $sort = 1;

    private $dry = false;

    private static $reserved = ['class','children'];

    private static $allowed_fields = ['URLSegment','Template','Content','Introtext','Title'];

    private function createPage($name, $data = [], $parentID, $parentClass) {
        $class = !empty($data['class']) ? $data['class'] : $parentClass;
        if (!Page::get()->filter('MenuTitle', $name)->exists()) {
            /** @var Page $page */
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
                        if (in_array($key, self::$allowed_fields)) {
                            $page->setField($key, $value);
                        } else {
                            throw new Exception("field $key not allowed");
                        }
                    }
                }
            }
            if (!$this->dry) {
                echo $page->Title."\n";
                $page->write();
                $page->publish("Stage", "Live");
            }
            if (isset($data['children']) and count($data['children'])) {
                foreach ($data['children'] as $name => $data) {
                    $this->createPage($name, $data, $page->ID, $class);
                }
            }
        }
    }

    public function run($request) {
        if (!$request->getVar('src')) return;
        $tree = yaml_parse_file($request->getVar('src'));
        $parentID = $request->getVar('parent') ?: 0;
        if ($request->getVar('dry')) $this->dry = $request->getVar('dry');
        foreach ($tree as $name => $data) {
            $this->createPage($name, $data, $parentID, 'Page');
        }
    }

}