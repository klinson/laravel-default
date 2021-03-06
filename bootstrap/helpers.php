<?php
/*
|--------------------------------------------------------------------------
| 自定义助手辅助函数
|--------------------------------------------------------------------------
*/


function list_to_tree($array, $root = 0, $id = 'id', $pid = 'pid', $child = 'child')
{
    $tree = [];
    foreach ($array as $k => $v) {
        if ($v[$pid] == $root) {
            $v[$child] = list_to_tree($array, $v[$id], $id, $pid, $child);
            $tree[] = $v;
            unset($array[$k]);
        }
    }
    return $tree;
}

function tree_to_list($tree, $id = 'id', $child = 'child')
{
    $array = array();
    foreach ($tree as $k => $val) {
        $array[] = $val;
        if (isset($val[$child])) {
            $children = tree_to_list($val[$child], $id, $child);
            if ($children) {
                $array = array_merge($array, $children);
            }
        }
    }
    foreach ($array as $key => $item) {
        unset($array[$key][$child]);
    }
    return $array;
}

/**
 * 后台自动上传的文件获取url
 * @param $path
 * @param string $server
 * @return mixed
 */
function get_admin_file_url($path, $server = '', $default = '')
{
    if (is_null($path) || $path === '') {
        return $default;
    }
    if (url()->isValidUrl($path)) {
        $src = $path;
    } elseif ($server) {
        $src = $server.$path;
    } else {
        $src = \Illuminate\Support\Facades\Storage::disk(config('admin.upload.disk'))->url($path);
    }
    return $src;
}

/**
 * 自动判断数组还是单个，获取url
 * @param $paths
 * @param string $server
 * @author klinson <klinson@163.com>
 * @return array|mixed
 */
function get_admin_file_urls($paths, $server = '')
{
    if (is_array($paths)) {
        $return = [];
        foreach ($paths as $path) {
            $return[] = get_admin_file_url($path, $server);
        }
        return $return;
    } else {
        return get_admin_file_url($paths, $server);
    }
}


function show_images($show, $column, $label = '', $server = '', $width = 200, $height = 200)
{
    $show->$column($label)->as(function ($paths) use ($server, $width, $height) {
        $urls = get_admin_file_urls($paths, $server);
        if (empty($urls)) {
            return '';
        }
        return implode("&nbsp;", array_map(function ($url) use ($width, $height) {
            return "<img src='$url' style='max-width:{$width}px;max-height:{$height}px' class='img img-thumbnail' />";
        }, $urls));
    });
}