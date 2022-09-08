<?php

namespace Drupal\evblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Main Slide' Block.
 *
 * @Block(
 *   id = "main_slide_block",
 *   admin_label = @Translation("Main Slide Block"),
 *   category = @Translation("Slide Block"),
 * )
 */
class MainSlideBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'text' => '',
      'slides' => [],
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
    
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'project')
      ->condition('status', 1)
      ->condition('promote', 1)
      ->sort('changed' , 'DESC'); 

    $nids = $query->execute();

    $slides = [];
    $i = 0;
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $language_manager = \Drupal::service('language_manager');
    $language = $language_manager->getLanguage($langcode);
    $language_manager->setConfigOverrideLanguage($language);
    foreach($nids as $nid){
      $nodent = $node_storage->load($nid);
      if($nodent->hasTranslation($langcode)){
        $node = $nodent->getTranslation($langcode);

        $entityType = 'node';
        $bundle = 'project';
        $fieldName = 'field_type';
        
        $type = \Drupal::entityTypeManager()
          ->getStorage('field_config')
          ->load("$entityType.$bundle.$fieldName")
          ->getSetting('allowed_values');

        $fieldName = 'field_industry';
        
        $industry = \Drupal::entityTypeManager()
          ->getStorage('field_config')
          ->load("$entityType.$bundle.$fieldName")
          ->getSetting('allowed_values');
        if($node->get('field_video_preview')->target_id){
          $slides[$i++] = [
            'current' => '0'.$i,
            'header' => $node->title->value,
            'desc1' => $type[$node->field_type->value],
            'desc2' => $industry[$node->field_industry->value],
            'video' => file_create_url($node->field_video_preview->entity->getFileUri()),
            'bg' => str_replace(',', '.', $node->field_bg_brightness->value),
            'href' => $node->toUrl()->toString(),
            'image' => NULL,
          ];
        } elseif($node->get('field_image')->target_id) {
          $slides[$i++] = [
            'current' => '0'.$i,
            'header' => $node->title->value,
            'desc1' => $type[$node->field_type->value],
            'desc2' => $industry[$node->field_industry->value],
            'video' => NULL,
            'bg' => str_replace(',', '.', $node->field_bg_brightness->value),
            'href' => $node->toUrl()->toString(),
            'image' => file_create_url($node->field_image->entity->getFileUri()),
          ];
        }
      }
    }

    return [
      '#theme' => 'main_slide_block_template',   
      '#text' => $config['text'],  
      '#slides' => $slides,
      '#total' => '0'. $i,
    ];
  }
  public function getCacheMaxAge() {
    return 600;
  }
}
