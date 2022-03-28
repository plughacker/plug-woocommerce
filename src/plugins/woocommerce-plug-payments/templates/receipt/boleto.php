
<h2>Boleto disponível para pagamento!</h2>
<div class="order_details" style="padding: 20px;position: relative;">
    <a href="<?php echo esc_attr($payment_data['paymentMethod']['barcodeImageUrl']); ?>" style="float: right;font-size: 200%;" target="_blank">Acessar o boleto!</a>
    Código de barras: <strong><?php echo esc_attr($payment_data['paymentMethod']['barcodeData']); ?></strong><br />
    <span style="position: absolute;bottom: 20px;">Escaneie ou use o código para pagar no aplicativo do seu banco.</span>
    <br style="clear: both;"/>
</div>