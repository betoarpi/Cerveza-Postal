<?php 
add_action('init', 'cptui_register_my_cpt_slider');
function cptui_register_my_cpt_slider() {
register_post_type('slider', array(
'label' => 'Slides',
'description' => '',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => false,
'rewrite' => array('slug' => 'slides', 'with_front' => 1),
'query_var' => true,
'menu_position' => 25,
'supports' => array('title','editor','excerpt','custom-fields','revisions'),
'labels' => array (
  'name' => 'Slides',
  'singular_name' => 'Slide',
  'menu_name' => 'Slider Postal',
  'add_new' => 'Nuevo Slide',
  'add_new_item' => 'Añadir Nuevo Slide',
  'edit' => 'Editar',
  'edit_item' => 'Editar Slide',
  'new_item' => 'Nuevo Slide',
  'view' => 'Ver Slide',
  'view_item' => 'Ver Slide',
  'search_items' => 'Buscar Slides',
  'not_found' => 'No se encontraron Slides',
  'not_found_in_trash' => 'No se encontraron Slides en la Papelera',
  'parent' => 'Parent Slide',
)
) ); }
?>