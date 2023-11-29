<?php namespace PHPMaker2020\sistema; ?>
<?php if (!CanTrackCookie()) { ?>
<div id="cookie-consent" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
	<div class="<?php echo Config("COOKIE_CONSENT_CLASS") ?>">
		<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<div class="mr-3 mb-3"><?php echo $Language->phrase("CookieConsentSummary") ?></div>
		<div class="text-nowrap">
			<button type="button" class="<?php echo Config("COOKIE_CONSENT_BUTTON_CLASS") ?>" data-action="privacy.php"><?php echo $Language->phrase("LearnMore") ?></button>
			<button type="button" class="<?php echo Config("COOKIE_CONSENT_BUTTON_CLASS") ?>" data-cookie-string="<?php echo HtmlEncode(CreateConsentCookie()) ?>"><?php echo $Language->phrase("Accept") ?></button>
		</div>
	</div>
</div>
<script>
loadjs.ready("load", function() {
	var $ = jQuery, $toast = $("#cookie-consent");

	// Accept button
	$("#cookie-consent button[data-cookie-string]").on("click", function(e){
		document.cookie = $(e.target).data("cookie-string");
		$("#cookie-consent").hide();
	});

	// Learn more button
	$("#cookie-consent button[data-action]").on("click", function(e) {
		window.location = ew.RELATIVE_PATH + $(e.target).data("action");
	});
	if (!$("#toast-container")[0])
		$("body").append('<div id="toast-container" style="position: absolute; top: 0; right: 0;"></div>');
	var $container = $("#toast-container").append($toast);
	$toast.toast({ autohide: false, delay: 0 }).toast("show").on("hidden.bs.toast", function() {
		if ($container[0] && !$container.find(".toast.show")[0])
			$container.remove();
	});
});
</script>
<?php } ?>