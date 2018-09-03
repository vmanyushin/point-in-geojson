<?php
/**
 * Created by PhpStorm.
 * User: swop
 * Date: 03.09.2018
 * Time: 0:42
 */

namespace vman\geojson;

class PointInGeoJSON
{
    var $pointOnVertex = true;

    function pointInPolygon($point, $polygon, $pointOnVertex = true)
    {
        $this->pointOnVertex = $pointOnVertex;

        $point    = $this->pointStringToCoordinates($point);
        $vertices = [];

        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }

        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return true;
        }

        $intersections  = 0;
        $vertices_count = count($vertices);

        for ($i = 1; $i < $vertices_count; $i++) {
            $v1 = $vertices[ $i - 1 ];
            $v2 = $vertices[ $i ];

            if ($v1['y'] == $v2['y'] and $v1['y'] == $point['y'] and $point['x'] > min($v1['x'], $v2['x']) and $point['x'] < max($v1['x'], $v2['x'])
            ) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }

            if ($point['y'] > min($v1['y'], $v2['y']) and $point['y'] <= max($v1['y'], $v2['y']) and $point['x'] <= max($v1['x'], $v2['x']) and $v1['y'] != $v2['y']) {

                $xinters = ($point['y'] - $v1['y']) * ($v2['x'] - $v1['x']) / ($v2['y'] - $v1['y']) + $v1['x'];

                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($v1['x'] == $v2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }

        if ($intersections % 2 != 0) {
            return true;
        } else {
            return false;
        }
    }

    private function pointOnVertex($point, $vertices)
    {
        foreach ($vertices as $v) {
            if ($point == $v) {
                return true;
            }
        }

    }

    private function pointStringToCoordinates($pointString)
    {
        return ["x" => $this->round2($pointString[0]), "y" => $this->round2($pointString[1])];
    }

    private function round2($number)
    {
        $precision = 4;
        $pos       = strrpos($number, '.');
        if ($pos !== false) {
            $number = substr($number, 0, $pos + 1 + $precision);
        }
        return $number * 10000;
    }

}