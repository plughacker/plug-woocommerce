
## Changelog ##

### 0.1.0 - 2021-10-10 ###
 * Beta version release

### 0.1.1 - 2021-12-13 ###
#### Fixes
 * Show only selected payment types at checkout

### 0.1.2 - 2021-12-14 ###
#### Fixes
 * Fix the merchant id parameter that was not being passed in the request to the production api

### 0.1.3 - 2021-12-15 ###
#### News
 * Adds functionality to copy pix code
 * Adds mobile version of pix screen
#### Fixes
 * Fixes the way documents are retrieved from the form

### 0.1.4 - 2022-01-04 ###

#### News
    * Add the Accept-Language parameter in the request header for the plug's api

### 0.1.5 - 2022-01-10 ###

#### News
    * Improvement in unit tests
    * CI Implementation for Deployment
    * Add Lint and CodeSniffer

### 1.0.0 - 2022-01-11 ###
    * Optimize for publish on wordpress
	
### 1.1.0 - 2022-03-28 ###
    * Added fraudanalysis contract support
    * Added setting to change payment method title
    * Added debugger option to make it easier to trace payloads
	
### 1.2.0 - 2022-03-31 ###
    * Added discount percentage for payment method  

### 1.3.0 - 2022-04-15 ###
    * Added sensitive data filter in debugger
    * Added error translation on failed transaction
    * Fraudanalysis contract fixes
	  * Included the address fields in the consumer object, they are required in BS2

### 1.4.0 - 2022-04-15 ###
    * handling errors
    * Change to Malga
