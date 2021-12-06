<?php 

namespace lray138\GAS\Tree;

function createBranch(&$parents, $children) {
    $tree = array();
    foreach ($children as $child) {
        if (isset($parents[$child['id']])) {
            $child['children'] =
                createBranch($parents, $parents[$child['id']]);
        }
        $tree[] = $child;
    } 
    return $tree;
}

function create($flat, $root = null) {
    $parents = array();
    foreach ($flat as $a) {
        $parents[$a['parent_id']][] = $a;
    }
    return createBranch($parents, $parents[$root]);
}