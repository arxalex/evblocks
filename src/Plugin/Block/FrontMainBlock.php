<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Front Main' Block.
 *
 * @Block(
 *   id = "front_main_block",
 *   admin_label = @Translation("Front Main Block"),
 *   category = @Translation("Front Block"),
 * )
 */
class FrontMainBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'header' => '',
      'text' => '',
      'path' => '',
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['header'] = array(
      '#type' => 'textarea',
      '#title' => t('Header'),
      '#default_value' => $config['header'],
    );

    $form['text'] = array(
      '#type' => 'textarea',
      '#title' => t('Text'),
      '#default_value' => $config['text'],
    );
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
    $this->configuration['header'] = $form_state->getValue('header');
    $this->configuration['text'] = $form_state->getValue('text');
    $this->configuration['path'] = $form_state->getValue('path');
  }

  public function build() {
    $config = $this->getConfiguration();
    
    return [
      '#theme' => 'front_main_block_template', 
      '#header' => $config['header'],   
      '#text' => $config['text'],  
      '#path' => $config['path'],  
    ];
  }
}