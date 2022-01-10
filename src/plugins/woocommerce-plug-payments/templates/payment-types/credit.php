<div id="plugpayments-credit-form" class="plugpayments-method-form">
    <p id="plugpayments-card-holder-name-field" class="form-row form-row-first">
        <label for="plugpayments-card-holder-name"><?php _e( 'Card Holder Name', 'woocommerce-plugpayments' ); ?> <small>(<?php _e( 'as recorded on the card', 'woocommerce-plugpayments' ); ?>)</small> <span class="required">*</span></label>
        <input id="plugpayments-card-holder-name" name="plugpayments_card_holder_name" class="input-text" type="text" autocomplete="off" style="font-size: 1.5em; padding: 8px;" />
    </p>
    <p id="plugpayments-card-number-field" class="form-row form-row-last">
        <label for="plugpayments-card-number"><?php _e( 'Card Number', 'woocommerce-plugpayments' ); ?> <span class="required">*</span></label>
        <input id="plugpayments-card-number" name="plugpayments_card_number" class="input-text wc-credit-card-form-card-number" type="tel" maxlength="20" autocomplete="off" placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;" style="font-size: 1.5em; padding: 8px;" />
    </p>
    <div class="clear"></div>
    <p id="plugpayments-card-expiry-field" class="form-row form-row-first">
        <label for="plugpayments-card-expiry"><?php _e( 'Expiry (MM/YYYY)', 'woocommerce-plugpayments' ); ?> <span class="required">*</span></label>
        <input id="plugpayments-card-expiry" name="plugpayments_card_expiry" class="input-text wc-credit-card-form-card-expiry" type="tel" autocomplete="off" placeholder="<?php _e( 'MM / YYYY', 'woocommerce-plugpayments' ); ?>" style="font-size: 1.5em; padding: 8px;" />
    </p>
    <p id="plugpayments-card-cvc-field" class="form-row form-row-last">
        <label for="plugpayments-card-cvc"><?php _e( 'Security Code', 'woocommerce-plugpayments' ); ?> <span class="required">*</span></label>
        <input id="plugpayments-card-cvc" name="plugpayments_card_cvv" class="input-text wc-credit-card-form-card-cvv" type="tel" autocomplete="off" placeholder="<?php _e( 'CVV', 'woocommerce-plugpayments' ); ?>" style="font-size: 1.5em; padding: 8px;" />
    </p>
    <div class="clear"></div>
    <p id="plugpayments-card-installments-field" class="form-row form-row-first">
        <label for="plugpayments-card-installments"><?php _e( 'Installments', 'woocommerce-plugpayments' ); ?><span class="required">*</span><br /><small>(<?php echo sprintf(__( 'the minimum value of the installment is %s.', 'woocommerce-plugpayments' ), 'R$ '. $minimum_installment .',00'); ?>)</small></label>
        <?php
            $installments = ceil($cart_total / $minimum_installment);            
        ?>
        <select id="plugpayments-card-installments" name="plugpayments_card_installments" style="font-size: 1.5em; padding: 4px; width: 100%;">
            <?php 
                for ($i = 1; $i <= $installments; $i++) {
                    $installments_amount = $cart_total / $i;
                    echo "<option value='$i'>$i (R$ ".esc_attr( number_format( $installments_amount, 2, ',', '.' )) .")</option>";
                }
            ?>            
        </select>
    </p>
    <div class="clear"></div>
</div>