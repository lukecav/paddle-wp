# WordPress Paddle plugin

Import [Paddle](https://paddle.com)'s javascript library, configure vendor settings and easily create checkout buttons.

## Usage, licensing and support

This code is provided as an example plugin to implement the Paddle checkout on a Wordpress site. End users may use or modify the code as required subject to the [license](http://www.apache.org/licenses/LICENSE-2.0.txt) included.

Paddle does not provide technical support or maintenance for this plugin or any derivations of it.

## Instructions

* Upload the plugin as a zipped archive to the WordPress plugins tab
* Activate the plugin
* Set your vendor ID in the Paddle submenu of the Settings menu
* Optionally set a custom selector to specify the element that triggers the checkout on click

## Adding a checkout button to your page

To add a standard Paddle-styled button to your page, use the following code, replacing `12345` with the ID of the product you are selling:
```
<a href="#!" class="paddle_button" data-product="12345">Buy Now!</a>
```
To add an unstyled button to your page, you can use:
```
<a href="#!" class="buy-button" data-product="12345">Buy Now!</a>
```
You may also use a different `class` or `id` attribute and update the value of the custom selector above.

## Specifying checkout properties

For either of the two above examples, you can specify additional checkout properties by adding data attributes to the tag. For example, to set the quantity of the checkout to 5 you can specify `data-quantity="5"`.

See the [Paddle documentation](https://paddle.com/docs/paddlejs-buttons-checkout#checkout-properties) for a full list of the configurable checkout properties.
