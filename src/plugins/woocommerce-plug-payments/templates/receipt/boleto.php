
<h2>Boleto disponível para pagamento!</h2>
<div class="order_details" style="padding: 20px;position: relative;">
    <img src="<?php echo $payment_data['paymentMethod']['qrCodeImageUrl']?>" alt="QRCode" style="float:left;margin-right:20px;"/>
    <strong style="cursor: pointer;"><?php echo $payment_data['paymentMethod']['qrCodeData']?></strong><br />
    <span style="position: absolute;bottom: 20px;">Escaneie ou use o código para pagar no aplicativo do seu banco.</span>
    <br style="clear: both;"/>
</div>