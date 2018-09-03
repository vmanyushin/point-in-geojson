<?php
/**
 * Created by PhpStorm.
 * User: swop
 * Date: 03.09.2018
 * Time: 0:48
 */

use PHPUnit\Framework\TestCase;

class PolygonTest extends TestCase
{
    public static $polygon1 = [
        [55.75781672738523, 37.61970635449207],
        [55.8019318207992, 37.567521295898324],
        [55.92241156864831, 37.50023003613268],
        [56.00713981525737, 37.49611016308581],
        [56.05250824089788, 37.54142876660144],
        [55.85758448607408, 38.1127178291014],
        [55.78568472668209, 38.107224665038906],
        [55.75781672738523, 37.61970635449207]
    ];

    public function testPointInsidePolygon()
    {
        $poly = new \vman\geojson\PointInGeoJSON();
        $this->assertTrue($poly->pointInPolygon([55.8838, 37.6726], PolygonTest::$polygon1, false));
    }

    public function testPointOnEdge()
    {
        $poly = new \vman\geojson\PointInGeoJSON();
        $this->assertTrue($poly->pointInPolygon([55.75781672738523, 37.61970635449207], PolygonTest::$polygon1));
    }

    public function testPointOutside()
    {
        $poly = new \vman\geojson\PointInGeoJSON();
        $this->assertFalse($poly->pointInPolygon([55.7462 ,37.6177], PolygonTest::$polygon1));
    }
}