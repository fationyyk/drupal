<?php

/**
 * @file
 * Contains \Drupal\Core\Config\Schema\Sequence.
 */

namespace Drupal\Core\Config\Schema;

use Drupal\Core\TypedData\ListInterface;

/**
 * Defines a configuration element of type Sequence.
 */
class Sequence extends ArrayElement implements ListInterface {

  /**
   * Overrides ArrayElement::parse()
   */
  protected function parse() {
    $definition = $this->getItemDefinition();
    $elements = array();
    foreach ($this->value as $key => $value) {
      $elements[$key] = $this->parseElement($key, $value, $definition);
    }
    return $elements;
  }

  /**
   * Implements Drupal\Core\TypedData\ListInterface::isEmpty().
   */
  public function isEmpty() {
    return empty($this->value);
  }

  /**
   * Implements Drupal\Core\TypedData\ListInterface::getItemDefinition().
   */
  public function getItemDefinition() {
    return $this->definition['sequence'][0];
  }

  /**
   * Implements \Drupal\Core\TypedData\ListInterface::onChange().
   */
  public function onChange($delta) {
    // Notify the parent of changes.
    if (isset($this->parent)) {
      $this->parent->onChange($this->name);
    }
  }

  /**
   * Gets a typed configuration element from the sequence.
   *
   * @param string $key
   *   The key of the sequence to get.
   *
   * @return \Drupal\Core\Config\Schema\Element
   *   Typed configuration element.
   */
  public function get($key) {
    $elements = $this->getElements();
    return $elements[$key];
  }

}
