=== Malga ===

Contributors: plugpayments
Tags: woocommerce, malga, gateway, payment  
Requires at least: 5.6
Tested up to: 5.9
Stable tag: 1.4.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

*Sua última integração de pagamentos*
Trabalhe com os melhores provedor para o seu negócio desde a primeira transação.

== Description ==

Receba pagamentos por cartão de crédito, boleto bancário e pix utilizando a [Malga](https://www.malga.io/).

== Colaborar ==

Você pode contribuir com código-fonte em nossa página no [GitHub](https://github.com/plughacker/plug-woocommerce).

== Installation ==

* Envie os arquivos do plugin para a pasta wp-content/plugins, ou instale usando o instalador de plugins do WordPress.
* Ative o plugin.

Com o plugin instalado acesse o admin do WordPress e entre em **"WooCommerce"** > **"Configurações"** > **"Pagamentos"** e configure as opção **"Plug"**:

- Habilite o meio de pagamento que você deseja, preencha as opções de **X-Client-Id**, **X-Api-Key** e **MerchantId** com os dados que você recebeu da plug.
- Configure uma Chave secreta para o seu webhook e logo apois faça o registro do mesmo na api da Plug, se tiver duvidas pode consultar nossa [documentação](https://docs.plugpagamentos.com/#section/Criacao-de-um-webhook)

*Também será necessário utilizar o plugin [WooCommerce Extra Checkout Fields for Brazil](http://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/) para poder enviar campos de CPF e CNPJ.*

Pronto, sua loja já pode receber pagamentos pela [Plug](https://www.malga.io).

Mais informações sobre nossa API pode consultar a [documentação](https://docs.malga.io/) ou entrar em contato :)

= Minimum Requirements =

* PHP 7.2 or greater is recommended
* MySQL 5.6 or greater is recommended

== Frequently Asked Questions ==

= Como criar uma conta na Plug? =

Para criar uma conta na plug é só entrar em contato [aqui](https://www.malga.io/contato?lang=en)