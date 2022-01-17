
<h2>Boleto disponível para pagamento!</h2>
<div class="order_details" style="padding: 20px;position: relative;">
    <img src="<?php echo esc_attr($payment_data['paymentMethod']['barcodeImageUrl']); ?>" alt="Código de barras" style="float:left;margin-right:20px;"/>
    <strong style="cursor: pointer;"><?php echo esc_attr($payment_data['paymentMethod']['barcodeData']); ?></strong><br />
    <span style="position: absolute;bottom: 20px;">Escaneie ou use o código para pagar no aplicativo do seu banco.</span>
    <br style="clear: both;"/>
</div>