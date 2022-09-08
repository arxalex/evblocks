<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Language' Block.
 *
 * @Block(
 *   id = "language_switcher_block",
 *   admin_label = @Translation("Language Block"),
 *   category = @Translation("Language Block"),
 * )
 */
class LanguageBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'lg' => [],
      'text' => '',
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
    $node = \Drupal::routeMatch()->getParameter('node');
    $trans = [];
    $i = 0;
    $current = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $lans = array_keys(\Drupal::languageManager()->getLanguages());
    if($node){
      foreach($lans as $lan){
        if($current != $lan){
          if($node->hasTranslation($lan)){
            $trans[$i++] = [
              'text' => $lan,
              'href' => \Drupal::request()->getSchemeAndHttpHost() . '/' . $lan . \Drupal::service('path.current')->getPath(),
            ];
          } else {
            $trans[$i++] = [
              'text' => $lan,
              'href' => \Drupal::request()->getSchemeAndHttpHost() . '/' . $lan,
            ];
          }
        }
      }
    } else {
      foreach($lans as $lan){
        if($current != $lan){
          $trans[$i++] = [
            'text' => $lan,
            'href' => \Drupal::request()->getSchemeAndHttpHost() . '/' . $lan . \Drupal::service('path.current')->getPath(),
          ];
        }
      }
    }

    return [
      '#theme' => 'language_block_template',   
      '#lg' => $trans,
      '#current' => $current,
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }
}