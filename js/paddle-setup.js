var selector = '.buy-button';
if (paddle_settings_data.selector) {
  selector = paddle_settings_data.selector;
}
Paddle.Setup({
  vendor: parseInt(paddle_settings_data.vendor_id)
});
jQuery( selector ).click(function (event) {
  event.preventDefault();
  Paddle.Checkout.open(jQuery(this).data());
});