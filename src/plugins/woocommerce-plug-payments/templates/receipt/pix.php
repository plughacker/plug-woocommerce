 <style>
    .container {
        display: flex;
    }
    .copy_container {
        display: flex;
    }
    @media only screen and (max-width: 600px) {
        #plug_qr_data {
            display: none;
        }
        .container {
            flex-direction: column;
            align-items: center;
        }
        .copy_container {
            flex-direction: column;
        }
        .copy_container > span {
            margin-top: 16px;
        }
    }
</style>

<h2>PIX disponível para pagamento!</h2>
<div class="order_details container" style="padding: 20px;position: relative;">
    <div class="plug_pix_qr_code">
        <img src="<?php echo $payment_data['paymentMethod']['qrCodeImageUrl']?>" width="800px" alt="QRCode"/>
    </div>

    <div style="display: flex; height:inherit; justify-content: space-between; flex-direction: column; margin-left: 20px">
        <strong id="plug_qr_data"><?=$payment_data['paymentMethod']['qrCodeData']?></strong> </br>
        <input type="hidden" value="<?=$payment_data['paymentMethod']['qrCodeData']?>" /><br />
        <div class="copy_container">    
            <button id="plug_copy_pix">Copiar</button>
            <span style="bottom: 20px; margin-left: 16px;">Escaneie ou use o código para pagar no aplicativo do seu banco.</span>
        </div>
    </div>

    <br style="clear: both;"/>
</div>

<script>
    var copyButton = document.querySelector("#plug_copy_pix");
    function copy() {
        const cb = navigator.clipboard;
        var copyText = document.querySelector("#plug_qr_data").innerText;
        cb.writeText(copyText.value).then(() => copyButton.innerHTML = "Copiado!");

    }
    copyButton.addEventListener("click", copy);
</script>