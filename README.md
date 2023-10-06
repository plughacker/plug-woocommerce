# Malga Pagamentos for WooCommerce #
**Contributors:** PlugTeam
**Tags:** woocommerce, plug, gateway, payment  
**Requires at least:** 5.6  
**Tested up to:** 5.8.3  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

## Description ##

Receba pagamentos por cartão de crédito, boleto bancário e pix utilizando a [Malga](https://www.malga.io).


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

É necessário possuir uma conta na [Malga](https://www.malga.io) e ter instalado o [WooCommerce](http://wordpress.org/plugins/woocommerce/).

### Configurações do Plugin: ###

Com o plugin instalado acesse o admin do WordPress e entre em **"WooCommerce"** > **"Configurações"** > **"Pagamentos"** e configure as opção **"Malga"**:

- Habilite o meio de pagamento que você deseja, preencha as opções de **X-Client-Id**, **X-Api-Key** e **MerchantId** com os dados que você recebeu da plug.
- Configure uma Chave secreta para o seu webhook e logo apois faça o registro do mesmo na api da Malga, se tiver duvidas pode consultar nossa [documentação](https://docs.plugpagamentos.com/#section/Criacao-de-um-webhook)

*Também será necessário utilizar o plugin [WooCommerce Extra Checkout Fields for Brazil](http://wordpress.org/plugins/woocommerce-extra-checkout-fields-for-brazil/) para poder enviar campos de CPF e CNPJ.*

Pronto, sua loja já pode receber pagamentos pela [Plug](https://www.plugpagamentos.com/?lang=en).

Mais informações sobre nossa API pode consultar a [documentação](https://docs.plugpagamentos.com/) ou entrar em contato :)

### Caso tenha que enviar um metadata ao PaymentFlow
No fluxo  de pagamentos temos a opção de enviar dados adicionais para o orquestrador, o mesmo pode ser feito utilizando o filter malga_payment_flow como no exemplo a baixo:

```
function example_metadata( $metadata, $order, $post  ) {
    foreach ( $order->get_items() as $item_id => $item ) { 
		if($item->get_name() == 'test'){
			$metadata['cnpj'] = '123';
		}
	}
    return $metadata;
}
add_filter( 'malga_payment_flow', 'example_metadata', 10, 3 );
```

## Testes ##

Para rodar os testes unitários utilize o comando: php vendor/bin/phpunit dentro do containner do wordpress

## Lint ##

Para rodar o Lint utilize o comando: php vendor/bin/phplint dentro do containner do wordpress

## PHP_CodeSniffer ##

Para rodar o CodeSniffer utilize o comando: ./vendor/bin/phpcs wp-content/plugins/woocommerce-plug-payments dentro do containner do wordpress