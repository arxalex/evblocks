<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Main Code-Design' Block.
 *
 * @Block(
 *   id = "main_about_block",
 *   admin_label = @Translation("Main About Block"),
 *   category = @Translation("About Block"),
 * )
 */
class MainAboutBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {
    return [
      '#theme' => 'main_about_block_template'
    ];
  }
}
