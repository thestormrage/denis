<?php

use App\Models\Helper\TestsHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tests', function () {
    $tests_helper = new TestsHelper();
    $tests = $tests_helper->get();
    var_dump($tests);
});

Route::get('/products/{group_id?}', function ($group_id = null) {


    $groups = getGroups();
    $tree = getTree($groups, $group_id);
    $cat_menu = showCat($tree, $group_id);
    echo '<pre>';
    //print_r($tree);

//    $groups = DB::table('groups')
//        ->select('*')
//        ->where('id_parent', '=', 0)
//        ->get();
//
//    foreach ($groups as $group) {
//        $result[$group->id] = $group;
//    }
//
//    if ($group_id) {
//        $child = getChilds($group_id);
//    }
//
//    var_dump($child);

    return view('products', [
        'groups' => $tree,
        'group_id' => $group_id,
        'menu' => $cat_menu,
    ]);
});

function getMenu($group_id)
{
    $menu = DB::table('groups')
        ->select('*')
        ->where('id', '=', $group_id)
        ->get();


}

function getGroups()
{
    $groups = DB::table('groups')
        ->select('*')
        ->get();

    $result = [];

    foreach ($groups as $group) {
        $result[$group->id] = $group;
    }


    return $result;
}

function getTree($dataset, $group_id)
{
    $tree = [];

    foreach ($dataset as $id => $node) {

        if ($node->id_parent === 0) {
            $tree[$id] = $node;
        } elseif($group_id != $dataset[$node->id_parent]->id && $dataset[$node->id_parent]->id_parent != 0) {
            continue;
        }
        else {
            $dataset[$node->id_parent]->childs[$id] = $node;
        }

    }

    return $tree;
}

//function tplMenu($group, $group_id)
//{
//    $menu = '<li>
//        <a href="http://localhost/lichi/denis/tasks/task3/task3/public/products/' . $group->id . '" title="' . $group->name . '">' .
//        $group->name . '</a>';
//    if ($group->id === $group_id) {
//        break;
//    }
//
//    if (isset($group->childs)) {
//        $menu .= '<ul>' . showCat($group->childs, $group_id) . '</ul>';
//    }
//
//    $menu .= '</li>';
//
//    return $menu;
//}

function showCat($data, $group_id)
{
    $string = '';

    foreach ($data as $item) {

        $string .= '<li>
        <a href="http://localhost/lichi/denis/tasks/task3/task3/public/products/' . $item->id . '" title="' . $item->name . '">' .
            $item->name . '</a>';

        if ($group_id && isset($item->childs)) {
            $string .= '<ul>' . showCat($item->childs, $group_id) . '</ul>';
        }

        $string .= '</li>';
    }
    return $string;
}

function RecursiveTree2(&$rs, $parent)
{
    $out = array();
    if (!isset($rs[$parent])) {
        return $out;
    }
    foreach ($rs[$parent] as $row) {
        $chidls = RecursiveTree2($rs, $row['id']);
        if ($chidls) {
            $row['expanded'] = false;
            $row['children'] = $chidls;
        }
        $out[] = $row;
    }
    return $out;
}

