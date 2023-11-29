<?php
namespace PHPMaker2020\sistema;

// Autoload
include_once "autoload.php";

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	\Delight\Cookie\Session::start(Config("COOKIE_SAMESITE")); // Init session data

// Output buffering
ob_start();
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$videos_view = new videos_view();

// Run the page
$videos_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$videos_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$videos_view->isExport()) { ?>
<script>
var fvideosview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fvideosview = currentForm = new ew.Form("fvideosview", "view");
	loadjs.done("fvideosview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$videos_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $videos_view->ExportOptions->render("body") ?>
<?php $videos_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $videos_view->showPageHeader(); ?>
<?php
$videos_view->showMessage();
?>
<form name="fvideosview" id="fvideosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="videos">
<input type="hidden" name="modal" value="<?php echo (int)$videos_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($videos_view->idvideos->Visible) { // idvideos ?>
	<tr id="r_idvideos">
		<td class="<?php echo $videos_view->TableLeftColumnClass ?>"><span id="elh_videos_idvideos"><?php echo $videos_view->idvideos->caption() ?></span></td>
		<td data-name="idvideos" <?php echo $videos_view->idvideos->cellAttributes() ?>>
<span id="el_videos_idvideos">
<span<?php echo $videos_view->idvideos->viewAttributes() ?>><?php echo $videos_view->idvideos->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($videos_view->titulo->Visible) { // titulo ?>
	<tr id="r_titulo">
		<td class="<?php echo $videos_view->TableLeftColumnClass ?>"><span id="elh_videos_titulo"><?php echo $videos_view->titulo->caption() ?></span></td>
		<td data-name="titulo" <?php echo $videos_view->titulo->cellAttributes() ?>>
<span id="el_videos_titulo">
<span<?php echo $videos_view->titulo->viewAttributes() ?>><?php if (!EmptyString($videos_view->titulo->getViewValue()) && $videos_view->titulo->linkAttributes() != "") { ?>
<a<?php echo $videos_view->titulo->linkAttributes() ?>><?php echo $videos_view->titulo->getViewValue() ?></a>
<?php } else { ?>
<?php echo $videos_view->titulo->getViewValue() ?>
<?php } ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($videos_view->idaulas->Visible) { // idaulas ?>
	<tr id="r_idaulas">
		<td class="<?php echo $videos_view->TableLeftColumnClass ?>"><span id="elh_videos_idaulas"><?php echo $videos_view->idaulas->caption() ?></span></td>
		<td data-name="idaulas" <?php echo $videos_view->idaulas->cellAttributes() ?>>
<span id="el_videos_idaulas">
<span<?php echo $videos_view->idaulas->viewAttributes() ?>><?php echo $videos_view->idaulas->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($videos_view->urlvideo->Visible) { // urlvideo ?>
	<tr id="r_urlvideo">
		<td class="<?php echo $videos_view->TableLeftColumnClass ?>"><span id="elh_videos_urlvideo"><?php echo $videos_view->urlvideo->caption() ?></span></td>
		<td data-name="urlvideo" <?php echo $videos_view->urlvideo->cellAttributes() ?>>
<script id="orig_videos_urlvideo" type="text/html">
<?php echo $videos_view->urlvideo->getViewValue() ?>
</script>
<span id="el_videos_urlvideo">
<span<?php echo $videos_view->urlvideo->viewAttributes() ?>><div id="utvd_x_urlvideo" class="ew-youtube-video"></div><script>
loadjs.ready("youtubevideos", function() {
	ew.youTubeVideos.push(jQuery.extend({"id":"utvd_x_urlvideo","width":300,"height":100,"videoid":null,"autoplay":true}, {
		videoid: <?php echo JsonEncode($videos_view->urlvideo->CurrentValue, "string") ?>

	}));
});
</script></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($videos_view->ativo->Visible) { // ativo ?>
	<tr id="r_ativo">
		<td class="<?php echo $videos_view->TableLeftColumnClass ?>"><span id="elh_videos_ativo"><?php echo $videos_view->ativo->caption() ?></span></td>
		<td data-name="ativo" <?php echo $videos_view->ativo->cellAttributes() ?>>
<span id="el_videos_ativo">
<span<?php echo $videos_view->ativo->viewAttributes() ?>><?php echo $videos_view->ativo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$videos_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$videos_view->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php include_once "footer.php"; ?>
<?php
$videos_view->terminate();
?>