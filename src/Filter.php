<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 10:18
 */

namespace Badtomcat\Filesystem;


class Filter
{
    /**
     * 递归遍历目录,如果回调函数返回FALSE中断遍历,返回TRUE把当前路径PUSH到结果返回
     * 回调只有一个参数,是路径
     * @param $dir
     * @param \Closure $filter
     * @param array $init
     * @return array
     */
    public static function filterRecursive($dir, \Closure $filter, array &$init = [])
    {
        if (!is_dir($dir)) {
            return $init;
        }
        foreach (glob($dir . "/*") as $v) {
            $ret = $filter($v);
            if ($ret === false) break;
            if ($ret === true) $init[] = $v;
            is_dir($v) && self::filterRecursive($v, $filter, $init);
        }
        return $init;
    }

    /**
     * @param $dir
     * @param \Closure $callback 参数一个,PATH
     * @param array $condition mode=>basename/filename(默认filename),
     *                      only=['aaa.txt'],
     *                      except=>[]
     *                      return=>full/basename/filename(默认full),
     * @param bool $recursive
     * @return array
     */
    public static function filterCondition($dir, \Closure $callback, $condition = [], $recursive = false)
    {
        if (array_key_exists("mode", $condition) && $condition['mode'] == "basename") {
            $condition['mode'] = "basename";
        } else {
            $condition['mode'] = "filename";
        }
        if (!isset($condition['return']))
            $condition['return'] = 'full';

        $callback = function ($path) use ($callback, $condition) {
            if ($callback($path)) {
                if ($condition["mode"] == "filename") {
                    $cmp = pathinfo($path, PATHINFO_FILENAME);
                } else {
                    $cmp = pathinfo($path, PATHINFO_BASENAME);;
                }
                if (array_key_exists("only", $condition)) {
                    if (in_array($cmp, $condition["only"]))
                        return true;
                } elseif (array_key_exists("except", $condition)) {
                    if (!in_array($cmp, $condition["except"]))
                        return true;
                } else {
                    return true;
                }
            }
        };

        if ($recursive)
            $ret = Filter::filterRecursive($dir, $callback);
        else
            $ret = Filter::filter($dir, $callback);

        if ($condition['return'] == 'basename') {
            return array_map(function ($value) {
                return pathinfo($value, PATHINFO_BASENAME);
            }, $ret);
        }
        if ($condition['return'] == 'filename') {
            return array_map(function ($value) {
                return pathinfo($value, PATHINFO_FILENAME);
            }, $ret);
        }
        return $ret;
    }

    /**
     * @param $dir
     * @param $ext
     * @param array $condition
     * @param bool $recursive
     * @return array
     */
    public static function filterEndswith($dir, $ext, $condition = [], $recursive = false)
    {
        return self::filterCondition($dir, function ($path) use ($ext) {
            $len = mb_strlen($ext);
            return mb_substr($path, -1 * $len, $len) == $ext;
        }, $condition, $recursive);
    }

    /**
     * @param $dir
     * @param array $condition
     * @param bool $recursive
     * @return array
     */
    public static function getDirectories($dir, $condition = [], $recursive = false)
    {
        return self::filterCondition($dir, function ($path) {
            return is_dir($path);
        }, $condition, $recursive);
    }

    /**
     * @param $dir
     * @param array $condition
     * @param bool $recursive
     * @return array
     */
    public static function getFiles($dir, $condition = [], $recursive = false)
    {
        return self::filterCondition($dir, function ($path) {
            return is_file($path) && !is_dir($path);
        }, $condition, $recursive);
    }

    /**
     * @param $dir
     * @param \Closure $filter
     * @return array
     */
    public static function filter($dir, \Closure $filter)
    {
        $result = [];
        if (!is_dir($dir)) {
            return [];
        }
        foreach (glob($dir . "/*") as $v) {
            $ret = $filter($v);
            if ($ret === false) break;
            if ($ret === true) $result[] = $v;
        }
        return $result;
    }

}