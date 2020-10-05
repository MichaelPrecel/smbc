<?php

add_action('admin_menu', 'dctit_connection_point_register');

function dctit_connection_point_register()
{
    add_menu_page('CP Allocation', 'CP Allocation', 'manage_options', 'cp-allocation',
     'dctit_connection_point_render','','25');
    add_submenu_page( 'cp-allocation','Level CP', 'Level CP', 'manage_options',
     'cp-allocation','dctit_connection_point_render');
    //add_submenu_page( 'cp-allocation', 'User CP', 'User CP', 'manage_options',
    // 'cp-allocation-user', 'dctit_connection_point_render');
}
function dctit_connection_point_render()
{
    if (isset($_POST['mem_lvl_name'])) {
        $membership_level_name = $_POST['mem_lvl_name'];
        $membership_level_id = $_POST['mem_lvl_id'];
        $membership_level_cp = $_POST['mem_lvl_cp'];
        $suc = dctit_add_or_update($membership_level_name, $membership_level_id, $membership_level_cp);
        if ($suc) { ?>
            <div id="message" class="updated notice notice-success is-dismissible">
                <p>Successfully updated Connection Points Allocation for <?php echo $membership_level_name; ?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php } else { ?>
            <div id="message" class="updated notice notice-error is-dismissible">
                <p>Faild to update Connection Points Allocation for <?php echo $membership_level_name; ?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>

        <?php }
    }

    echo '<div class="wrap">';
    echo "<h1>Connection Points Allocation Control Panel</h1>";

    echo "<p class='description'>Allocate Connection Points for each membership level at once.</p><br/>";

    echo "<div class='form-body-2345'>";

    $levels = pmpro_getAllLevels(false, true);
    dctit_initial_all_level($levels);
    foreach ($levels as $level) {
        echo "<div class='single-form-2345'>";
        ?>
        <form id="cp-allocation-form" method="POST" action="#">
            <div class="form-group row ">
                <label for="membershipTitle" class="col-sm-2 col-form-label">Membership Level: <?php echo $level->name; ?></label>
            </div>
            <div class="form-group row clear">
                <div class="colfifty">
                    <input type="text" class="form-control" id="allocatedcp" name="mem_lvl_cp" placeholder="<?php echo dctit_get_my_level_cp($level->name, $level->id); ?>">
                    <input type="hidden" class="form-control" id="" name="mem_lvl_id" value="<?php echo $level->id; ?>">
                    <input type="hidden" class="form-control" id="" name="mem_lvl_name" value="<?php echo $level->name; ?>">
                </div>
                <div class="colfifty">
                    <button type="submit" class="btn btn-primary mb-2">SET</button>
                </div>
            </div>
        </form>
    <?php
        echo "</div>";
    }

    echo "</div>";
    echo "</div>";

    ?>
    <style>
        .single-form-2345 {
            padding: 20px;
            border: 1px solid;
        }

        .single-form-2345 .form-group {
            font-size: 16px;
            padding: 10px;
        }

        .form-group.row.clear {
            clear: both;
            min-height: 54px;
        }

        .colfifty {
            width: 30%;
            float: left;
            padding: 10px;
        }

        button.btn.btn-primary.mb-2 {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            background: #007bff;
            color: white;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 4px 2px;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            width: 100px;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-top-color: rgb(206, 212, 218);
            border-top-style: solid;
            border-top-width: 1px;
            border-right-color: rgb(206, 212, 218);
            border-right-style: solid;
            border-right-width: 1px;
            border-bottom-color: rgb(206, 212, 218);
            border-bottom-style: solid;
            border-bottom-width: 1px;
            border-left-color: rgb(206, 212, 218);
            border-left-style: solid;
            border-left-width: 1px;
            border-image-source: initial;
            border-image-slice: initial;
            border-image-width: initial;
            border-image-outset: initial;
            border-image-repeat: initial;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition-property: border-color, box-shadow;
            transition-duration: 0.15s, 0.15s;
            transition-timing-function: ease-in-out, ease-in-out;
            transition-delay: 0s, 0s;
        }

        input {
            -webkit-writing-mode: horizontal-tb !important;
            text-rendering: auto;
            color: -internal-light-dark(black, white);
            letter-spacing: normal;
            word-spacing: normal;
            text-transform: none;
            text-indent: 0px;
            text-shadow: none;
            display: inline-block;
            text-align: start;
            appearance: textfield;
            background-color: -internal-light-dark(rgb(255, 255, 255), rgb(59, 59, 59));
            -webkit-rtl-ordering: logical;
            cursor: text;
            margin: 0em;
            font: 400 13.3333px Arial;
            padding: 1px 2px;
            border-width: 2px;
            border-style: inset;
            border-color: -internal-light-dark(rgb(118, 118, 118), rgb(195, 195, 195));
            border-top-color: -internal-light-dark(rgb(118, 118, 118), rgb(195, 195, 195));
            border-right-color: -internal-light-dark(rgb(118, 118, 118), rgb(195, 195, 195));
            border-bottom-color: -internal-light-dark(rgb(118, 118, 118), rgb(195, 195, 195));
            border-left-color: -internal-light-dark(rgb(118, 118, 118), rgb(195, 195, 195));
            border-image: initial;
        }
    </style>
<?php
}
