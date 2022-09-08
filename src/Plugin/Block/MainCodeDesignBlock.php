<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Main Code-Design' Block.
 *
 * @Block(
 *   id = "main_code_design_block",
 *   admin_label = @Translation("Main Code-Design Block"),
 *   category = @Translation("Code-Design Block"),
 * )
 */
class MainCodeDesignBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function defaultConfiguration() {
    return array(
      'path' => ''
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['path'] = array(
      '#type' => 'textfield',
      '#title' => t('Path'),
      '#default_value' => $config['path'],
    );

    return $form;
  }

  public function blockValidate($form, FormStateInterface $form_state) {

  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['path'] = $form_state->getValue('path');
  }

  public function build() {
    $config = $this->getConfiguration();

    return [
      '#theme' => 'main_code_design_block_template',
      '#path' => $config['path']
    ];
  }
}
