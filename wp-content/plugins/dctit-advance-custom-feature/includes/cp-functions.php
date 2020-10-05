<?php

function dctit_add_or_update($name, $id, $value)
{
    $l_name = strtolower($name);
    $l_id = $id;
    $l_key = str_replace(' ', '_', $l_name) . $l_id;
    $intcp = intval($value);
    $success = add_option($l_key, $intcp, '', 'no');

    if (!$success) {
        $success = update_option($l_key, $intcp);
    }

    return $success;
}

function dctit_initial_all_level($levels)
{
    foreach ($levels as $level) {
        $l_name = strtolower($level->name);
        $l_id = $level->id;
        $l_key = str_replace(' ', '_', $l_name) . $l_id;
        $initialized = get_option($l_key);
        if (empty($initialized)) {
            add_option($l_key, 0, '', 'no');
        }
    }
}

function dctit_get_my_level_cp($l_name, $l_id)
{
    $l_name = strtolower($l_name);
    $l_key = str_replace(' ', '_', $l_name) . $l_id;
    $cp = get_option($l_key);
    return $cp;
}


add_action('show_user_profile', 'dctit_custom_user_profile_fields');
add_action('edit_user_profile', 'dctit_custom_user_profile_fields');

function dctit_custom_user_profile_fields($profileuser)
{
?>
    <table class="form-table">
        <tr>
            <th>
                <label for="user_cp_dct"><?php _e('Connection Point'); ?></label>
            </th>
            <td>
                <input type="text" name="user_cp_dct" id="user_cp_dct" <?php if(!current_user_can( 'administrator' )){ echo "disabled"; } ?> value="<?php echo esc_attr(get_user_meta($profileuser->ID, 'user_cp_dct', true)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Available Connection Point.', 'text-domain'); ?></span>
            </td>
        </tr>
    </table>
<?php
}

add_action( 'personal_options_update', 'dctit_save_cp_info_level' );
add_action( 'edit_user_profile_update', 'dctit_save_cp_info_level' );

function dctit_save_cp_info_level( $user_id ) {

    if ( !current_user_can( 'administrator' ) ) {
        return false;
    }
    /* Copy and paste this line for additional fields. Make sure to change 'paypal_account' to the field ID. */
    update_user_meta( $user_id, 'user_cp_dct', $_POST['user_cp_dct'] );
}


