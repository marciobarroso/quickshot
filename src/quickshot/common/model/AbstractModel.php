<?php

namespace QuickShot\Common\Model;

abstract class AbstractModel {

	public function __toString() {
		$reflect = new \ReflectionClass($this);
		$result = get_class($this) . " [" ;
		$first = true;
		foreach( $reflect->getProperties() as $property ) {
			if( !$first ) {
				$result .= "," ;
			}

			$field = $property->getName();
				
			if( $property->isPublic() ) {
				if( $field === "password" && !empty($this->$field) ) {
					$value = "xxxxxx";
				} else {
					$value = $this->$field;
					if( !isset($value) ) {
						$value = null;
					} else if( is_string($value) ) {
						$value = "'" . $value . "'";
					}
				}
				$result .= $field . ": " . $value ;
			} else {
				if( $field === "password" ) {
					$value = "xxxxxx";
				} else {
					$method = "get" . ucfirst($field);
					$method = $reflect->getMethod($method);
					$value = $method->invoke($this);	
				}

				if( !isset($value) ) {
					$value = null;
				} else if( is_string($value) ) {
					$value = "'" . $value . "'";
				}
				$result .= $field . ": " . $value ;
			}
			$first = false;
		}

		$result .= "]";
		return $result;
	}
}