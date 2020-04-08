<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/devwael
 * @since      1.0.0
 *
 * @package    Wcfc
 * @subpackage Wcfc/admin/partials
 */

/**
 * all checkout fields (including custom ones)
 */
$wc_fields = WC()->checkout()->get_checkout_fields();
$a         = $b = $c = $d = $e = $f = 1; //iterators to change id in html
?>
<h1>

</h1>
<form action="<?php admin_url( 'admin-post.php' ); ?>" method="post">
	<?php wp_nonce_field( 'customize_checkout', 'nonce' ); ?>
    <input type="hidden" name="action" value="customize_checkout">
    <table class="wp-list-table widefat fixed striped">
        <thead>
        <tr>
            <th>نوع العملية</th>
            <th>حقول الفاتورة</th>
            <th>حقول الشحن</th>
        </tr>
        </thead>
        <tr>
            <td>
                حقول إجبارية
            </td>
            <td>
				<?php foreach ( $wc_fields['billing'] as $field_key => $field_val ) { ?>
                    <div>
                        <input type="checkbox" name="required_billing_fields[]"
                               id="required_billing_fields-<?php echo $a ?>">
                        <label for="required_billing_fields-<?php echo $a ?>">
							<?php echo $field_val['label'] ?>
                        </label>
                    </div>
					<?php $a ++;
				} ?>
            </td>
            <td>
				<?php foreach ( $wc_fields['shipping'] as $field_key => $field_val ) { ?>
                    <div>
                        <input type="checkbox" name="required_shipping_fields[]"
                               id="required_shipping_fields-<?php echo $b ?>">
                        <label for="required_shipping_fields-<?php echo $b ?>">
							<?php echo $field_val['label'] ?>
                        </label>
                    </div>
					<?php $b ++;
				} ?>
            </td>
        </tr>

        <tr>
            <td>
                حقول إختيارية
            </td>
            <td>
				<?php foreach ( $wc_fields['billing'] as $field_key => $field_val ) { ?>
                    <div>
                        <input type="checkbox" name="not_required_billing_fields[]"
                               id="not_required_billing_fields-<?php echo $c ?>">
                        <label for="not_required_billing_fields-<?php echo $c ?>">
							<?php echo $field_val['label'] ?>
                        </label>
                    </div>
					<?php $c ++;
				} ?>
            </td>
            <td>
				<?php foreach ( $wc_fields['shipping'] as $field_key => $field_val ) { ?>
                    <div>
                        <input type="checkbox" name="not_required_shipping_fields[]"
                               id="not_required_shipping_fields-<?php echo $d ?>">
                        <label for="not_required_shipping_fields-<?php echo $d ?>">
							<?php echo $field_val['label'] ?>
                        </label>
                    </div>
					<?php $d ++;
				} ?>
            </td>
        </tr>

        <tr>
            <td>
                إخفاء الحقول
            </td>
            <td>
				<?php foreach ( $wc_fields['billing'] as $field_key => $field_val ) { ?>
                    <div>
                        <input type="checkbox" name="hidden_billing_fields[]"
                               id="hidden_billing_fields-<?php echo $e ?>">
                        <label for="hidden_billing_fields-<?php echo $e ?>">
							<?php echo $field_val['label'] ?>
                        </label>
                    </div>
					<?php $e ++;
				} ?>
            </td>
            <td>
				<?php foreach ( $wc_fields['shipping'] as $field_key => $field_val ) { ?>
                    <div>
                        <input type="checkbox" name="hidden_shipping_fields[]"
                               id="hidden_shipping_fields-<?php echo $f ?>">
                        <label for="hidden_shipping_fields-<?php echo $f ?>">
							<?php echo $field_val['label'] ?>
                        </label>
                    </div>
					<?php $f ++;
				} ?>
            </td>
        </tr>

        <tfoot>
        <tr>
            <th>نوع العملية</th>
            <th>حقول الفاتورة</th>
            <th>حقول الشحن</th>
        </tr>
        </tfoot>
    </table>
    <br>
    <button class="button button-primary" type="submit">Save</button>
</form>


