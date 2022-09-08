<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Social' Block.
 *
 * @Block(
 *   id = "social_block",
 *   admin_label = @Translation("Social Block"),
 *   category = @Translation("Social Block"),
 * )
 */
class SocialBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'text' => '',
      'socials' => [],
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $form['text'] = array(
      '#type' => 'textarea',
      '#title' => t('Text'),
      '#default_value' => $config['text'],
    );

    return $form;
  }

  public function blockValidate($form, FormStateInterface $form_state) {

  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['text'] = $form_state->getValue('text');
  }

  public function build() {
    $config = $this->getConfiguration();
    
    return [
      '#theme' => 'social_block_template',   
      '#text' => $config['text'],  
      '#socials' => [
        0 => [
          'icon' => 'fa-brands fa-facebook-f',
          'href' => 'https://facebook.com/arxa1ex',
        ],
        1 => [
          'icon' => 'fa-brands fa-instagram',
          'href' => 'https://instagram.com/arxalex',
        ],
        2 => [
          'icon' => 'fa-brands fa-behance',
          'href' => 'https://behance.net/arxalex',
        ],
        3 => [
          'icon' => 'fa-brands fa-500px',
          'href' => 'https://500px.com/arxalex',
        ],
      ],
    ];
  }
}