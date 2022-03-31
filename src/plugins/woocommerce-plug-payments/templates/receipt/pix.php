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
        <img src="<?php echo esc_attr($payment_data['paymentMethod']['qrCodeImageUrl']); ?>" style="min-width: 200px;" alt="QRCode"/>
    </div>

    <div style="display: flex; height:inherit; justify-content: space-between; flex-direction: column; margin-left: 20px">
        <strong id="plug_qr_data" style="font-size: 70%;"><?php echo esc_attr($payment_data['paymentMethod']['qrCodeData']); ?></strong> </br>
        <input type="hidden" value="<?php echo esc_attr($payment_data['paymentMethod']['qrCodeData']); ?>" />
        <div class="copy_container">    
            <button id="plug_copy_pix">Copiar</button>
            <span style="bottom: 20px; margin-left: 16px;">Escaneie ou use o código para pagar no aplicativo do seu banco.</span>
        </div>
    </div>

    <br style="clear: both;"/>
</div>

<script>

    var copyButton = document.querySelector("#plug_copy_pix");

    function wrapperToCopy() {
        const cb = navigator.clipboard;
        var copyText = document.querySelector("#plug_qr_data").textContent;
        if (copyToClipboard(copyText)) {
            copyButton.textContent = "Copiado!";
            setTimeout(() => {
                copyButton.textContent = "Copiar";
            }, 2000);
        } else {
            alert("Não foi possível copiar o código QR!");
        }

    }
    copyButton.addEventListener("click", wrapperToCopy);

    function copyToClipboard(string) {
        let textarea;
        let result;

        try {
            textarea = document.createElement('textarea');
            textarea.setAttribute('readonly', true);
            textarea.setAttribute('contenteditable', true);
            textarea.style.position = 'fixed'; // prevent scroll from jumping to the bottom when focus is set.
            textarea.value = string;

            document.body.appendChild(textarea);

            textarea.focus();
            textarea.select();

            const range = document.createRange();
            range.selectNodeContents(textarea);

            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);

            textarea.setSelectionRange(0, textarea.value.length);
            result = document.execCommand('copy');
        } catch (err) {
            console.error(err);
            result = null;
        } finally {
            document.body.removeChild(textarea);
        }

        // manual copy fallback using prompt
        if (!result) {
            const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
            const copyHotkey = isMac ? '⌘C' : 'CTRL+C';
            result = prompt(`Press ${copyHotkey}`, string); // eslint-disable-line no-alert
            if (!result) {
                return false;
            }
        }
        return true;
    }
 
</script>