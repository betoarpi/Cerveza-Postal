<?php
//Se agregan las acciones o funciones de php para los nuevos campos
add_action('register_form', 'agregar_campos_registro' );
add_filter('registration_errors', 'validar_campos_registro', 10, 3);
add_action('user_register', 'guardar_campos_registro');
 //Se declaran las funciones en el archivo de php.functions para no ser afectados por las actualizaciones
function agregar_campos_registro() {
  $user_edad = ( isset( $_POST['user_edad'] ) ) ? $_POST['user_edad']: '';
?>

  <p>
      <label for="user_edad">Fecha de Nacimiento<br />
      <input type="date" name="user_edad" id="user_edad" class="input" value="<?php echo esc_attr(stripslashes($user_edad)); ?>" size="20" /></label>
  </p>


<?php
}
 
function validar_campos_registro ($errors, $sanitized_user_login, $user_email) {
    if ( empty( $_POST['user_edad'] ) )
        $errors->add( 'user_edad_error', __('<strong>ERROR</strong>: Por favor, introduce una Fecha valida y real.') );
    return $errors;
    $edad = $_POST["edad"];
    $sections= explode("/", $edad);
    $yearAge1 =$sections[2];
    $today = getdate();  
    $sections2= explode("/", $today);
    $yearAge2 =$sections2[2];
    $olderKnow =  $yearAge2 - $yearAge1;
    $olderDays = 18;
    echo $olderDays;
    if ($olderKnow < $olderDays) 
      { 
        echo '<script language="javascript">alert("No eres mayor de edad y esto tendrá como conseciencia que tarde o temprano seas dado de baja en el sistema");</script>'; 
      } 
  }
 
function guardar_campos_registro ($user_id) {
  if ( isset($_POST['user_edad'])){
    update_user_meta($user_id, 'user_edad', $_POST['user_edad']);
  }
}
 

 
add_action( 'show_user_profile', 'agregar_campos_perfil' );
add_action( 'edit_user_profile', 'agregar_campos_perfil' );
add_action( 'personal_options_update', 'guardar_campos_perfil' );
add_action( 'edit_user_profile_update', 'guardar_campos_perfil' );
 
function agregar_campos_perfil( $user ) {
  $user_edad = esc_attr( get_the_author_meta( 'user_edad', $user->ID ) );
  
?>
 
  <h3>Campo adicional para validar la edad del  usuario</h3>
   
  <table class="form-table">
    <tr>
      <th><label for="direccion">Edad</label></th>
      <td>
        <input type="date" name="user_edad" id="user_edad" class="input" value="<?php echo $user_edad; ?>" size="20" />
        <span class="description">Inserta tu edad... real</span>
      </td>
    </tr>
  </table>
 
<?php }
 
function guardar_campos_perfil ($user_id) {
  if ( isset($_POST['user_edad']) ){
    update_user_meta($user_id, 'user_edad', $_POST['user_edad']);
  }
}
?>