<button id="mono_checkout_<?= $path ?>" <?php if ($size_w || $size_h) { ?> style="width: <?= $size_w; ?>px; height: <?= $size_h; ?>px" <?php } ?> class="mono_checkout__button mono_checkout__button--<?= $buttonType ?>">
<span><?= $button_text ?></span>
<img src="catalog/view/theme/default/image/mono_checkout/monocheckout_logo_<?= $logo_color ?>.svg" alt="button_logo">
</button>
