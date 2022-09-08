<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Text' Block.
 *
 * @Block(
 *   id = "text_block",
 *   admin_label = @Translation("Text Block"),
 *   category = @Translation("Text Blocks"),
 * )
 */
class TextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'header' => '',
      'text' => '',
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['header'] = array(
      '#type' => 'textfield',
      '#title' => t('Header'),
      '#default_value' => $config['header'],
    );

    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => t('Text'),
      '#default_value' => $config['text'],
    );

    return $form;
  }

  public function blockValidate($form, FormStateInterface $form_state) {

  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['header'] = $form_state->getValue('header');
    $this->configuration['text'] = $form_state->getValue('text');
  }

  public function build() {
    $config = $this->getConfiguration();

    return [
      '#theme' => 'text_block_template', 
      '#header' => $config['header'],   
      '#text' => $config['text'],  
    ];
  }
}