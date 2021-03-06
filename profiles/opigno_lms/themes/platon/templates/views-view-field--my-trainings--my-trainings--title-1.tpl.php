<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
 $node = node_load($row->node_og_membership_nid);
 if ($node->certificate['node_settings']['manual']['manual'] == '-1') {
   $certificate = 'inactive';
 } elseif (opigno_quiz_app_course_class_passed($node->nid)) {
   $certificate = 'download';
 } else {
   $certificate = 'active';
 }
?>
<div class="content-top">
  <div class="title">
    <?php print $output; ?>
  </div>
  <div class="content-more default-visible">
    <a href="#"><?php print t('view') ?></a>
  </div>
  <div class="default-hidden">
    <?php
      $body = $view->render_field('body', $view->row_index);
      $body = str_replace('<br>', ' ', $body);
      $body = strip_tags($body);
    ?>
    <?php print views_trim_text(array('max_length' => 75,'ellipsis' => true,'word_boundary' => true,'html' => true), $body) ?>
  </div>
  <div class="default-hidden">
    <a href="#" class="close-btn"></a>
  </div>
</div>

<div class="content-bottom">
  <div class="progression">
    <span class="background" style="width:<?php print $view->render_field('course_class_progress', $view->row_index) ?>%;"></span>
    <span class="text">
      <?php print t('progress:') ?> <?php print $view->render_field('course_class_progress', $view->row_index) ?>%
    </span>
  </div>
  <div class="pictogram">
    <?php if ($view->render_field('course_class_progress', $view->row_index) != 100): ?>
      <?php if ($view->render_field('course_class_progress', $view->row_index)): ?>
        <a href="<?php print url('node/'.$row->node_og_membership_nid.'/resume') ?>" class="link-button take"><?php print t('Continue') ?></a>
      <?php else: ?>
        <a href="<?php print url('node/'.$row->node_og_membership_nid.'/resume') ?>" class="link-button take"><?php print t('Start') ?></a>
      <?php endif; ?>
    <?php elseif ($certificate == 'inactive'): ?>
      <span class="link-button inactive-certificate"></span>
    <?php elseif ($certificate == 'active'): ?>
      <span class="link-button active-certificate"></span>
    <?php else: ?>
      <a href="<?php print url('node/'.$row->node_og_membership_nid.'/certificate') ?>" class="link-button download-certificate"></a>
    <?php endif; ?>
  </div>
</div>
