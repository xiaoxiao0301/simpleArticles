<?php
/**
 * 二维数组去重
 */
function arrs_unique($arr2)
{
    foreach ($arr2 as $k => $v) {
        $v = http_build_query($v);
        $temp[] = $v;
    }

    if ($temp) {
        $temp = array_unique($temp);
        foreach ($temp as $k => $v) {
            parse_str($v, $temp[$k]);
        }
        return $temp;
    }
}