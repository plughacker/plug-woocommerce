# Pagar.me for WooCommerce #
**Contributors:** PlugTeam, geekdoagrest  
**Tags:** woocommerce, plug, gateway, payment  
**Requires at least:** 4.0  
**Tested up to:** 5.6  
**Stable tag:** 2.5.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Receba pagamentos por cartão de crédito e boleto bancário utilizando a [Plug](https://www.plugpagamentos.com/?lang=en).

[![Gif Plug](https://static.wixstatic.com/media/656f2b_07e76b8231da4491880ac7a7981fb0ff~mv2.gif "Gif Plug")](https://www.plugpagamentos.com/ "Gif Plug")

## Description ##

### Compatibilidade ###

Compatível com desde a versão 2.2.x do WooCommerce.

Este plugin funciona integrado com o [WooCommerce Extra Checkout Fields for Brazil](http://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/) para os meios de pagamento brasileiro como PIX e Boleto, desta forma é possível enviar documentos do cliente como "CPF" ou "CNPJ".

### Colaborar ###

Você pode contribuir com código-fonte em nossa página no [GitHub](https://github.com/plughacker/plug-woocommerce).

## Installation ##

### Instalação do plugin: ###

* Envie os arquivos do plugin para a pasta wp-content/plugins, ou instale usando o instalador de plugins do WordPress.
* Ative o plugin.

### Requerimentos: ###

É necessário possuir uma conta na [Plug](https://www.plugpagamentos.com/) e ter instalado o [WooCommerce](http://wordpress.org/plugins/woocommerce/).

### Configurações do Plugin: ###

Com o plugin instalado acesse o admin do WordPress e entre em **"WooCommerce"** > **"Configurações"** > **"Pagamentos"** e configure as opção **"Plug"**:

- Habilite o meio de pagamento que você deseja, preencha as opções de **X-Client-Id**, **X-Api-Key** e **MerchantId** com os dados que você recebeu da plug.
- Configure uma Chave secreta para o seu webhook e logo apois faça o registro do mesmo na api da Plug, se tiver duvidas pode consultar nossa [documentação](https://docs.plugpagamentos.com/#section/Criacao-de-um-webhook)

*Também será necessário utilizar o plugin [WooCommerce Extra Checkout Fields for Brazil](http://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/) para poder enviar campos de CPF e CNPJ.*

Pronto, sua loja já pode receber pagamentos pela [Plug](https://www.plugpagamentos.com/?lang=en).

Mais informações sobre nossa API pode consultar a [documentação](https://docs.plugpagamentos.com/) ou entrar em contato :)

## Testes ##

Para rodar os testes unitários utilize o comando vendor/bin/phpunit dentro do containner do wordpress

## Changelog ##

### 0.1.0 - 2021-10-10 ###
 * Liberação da versão Beta