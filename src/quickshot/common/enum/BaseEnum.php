<?php

namespace QuickShot\Common\Enum;

abstract class BaseEnum {

	private static $cache = null;

	private static function getConstants() {
		if( self::$cache === null ) {
			self::$cache = [];
		}

		$calledClass = get_called_class();
		if (!array_key_exists($calledClass, self::$cache)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$cache[$calledClass] = $reflect->getConstants();
        }
        return self::$cache[$calledClass];
	}

	public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    public static function values() {
        return array_values(self::getConstants());
    }

    public static function keys() {
        return array_keys(self::getConstants());
    }

    public static function all() {
        return self::getConstants();
    }
}