<?php

namespace uk\org\brentso\concertmanagement\admin;

use ReflectionClass;

abstract class AbstractAutodisplayMetaBox extends AbstractMetaBox
{

    protected function getStyleUrl()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_URL');
        $underscored_class_name = $this->convertFromCamelCaseToDashes($this->getUnqualifiedClassName());
        return $concert_plugin_path . 'admin/css/' . $underscored_class_name . '.css';
    }

    protected function getStyleTag()
    {
        return $this->convertFromCamelCaseToDashes($this->getUnqualifiedClassName()) . '-style';
    }

    protected function getTag()
    {
        return $this->convertFromCamelCaseToDashes($this->getUnqualifiedClassName());
    }

    protected function getUnqualifiedClassName()
    {
        $reflect = new ReflectionClass($this);
        return $reflect->getShortName();
    }

    protected function getScriptUrl()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_URL');
        $underscored_class_name = $this->convertFromCamelCaseToDashes($this->getUnqualifiedClassName());
        return $concert_plugin_path . 'admin/js/' . $underscored_class_name . '.js';
    }

    protected function getScriptTag()
    {
        return $this->convertFromCamelCaseToDashes($this->getUnqualifiedClassName());
    }

    protected function getNonceName()
    {
        return $this->convertFromCamelCaseToDashes($this->getUnqualifiedClassName()) . '-nonce';
    }

    protected function getDisplayFilePath()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_PATH');
        return $concert_plugin_path . 'admin/partials/' . $this->convertFromCamelCaseToDashes(
            $this->getUnqualifiedClassName()
        ) . '-display.php';
    }

    private static function convertFromCamelCaseToDashes( $input )
    {
        return self::convertFromCamelCaseToPadding($input, '-');
    }

    private static function convertFromCamelCaseToPadding( $input, $pad )
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ( $ret as &$match ) {
            $match = strtoupper($match) ? strtolower($match) : lcfirst($match) == $match;
        }
        return implode($pad, $ret);
    }
}
