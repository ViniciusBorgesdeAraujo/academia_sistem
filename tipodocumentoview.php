<?php
namespace PHPMaker2020\project1;

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
$tipodocumento_view = new tipodocumento_view();

// Run the page
$tipodocumento_view->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumento_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$tipodocumento_view->isExport()) { ?>
<script>
var ftipodocumentoview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	ftipodocumentoview = currentForm = new ew.Form("ftipodocumentoview", "view");
	loadjs.done("ftipodocumentoview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$tipodocumento_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $tipodocumento_view->ExportOptions->render("body") ?>
<?php $tipodocumento_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tipodocumento_view->showPageHeader(); ?>
<?php
$tipodocumento_view->showMessage();
?>
<form name="ftipodocumentoview" id="ftipodocumentoview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumento">
<input type="hidden" name="modal" value="<?php echo (int)$tipodocumento_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($tipodocumento_view->idtipodocumento->Visible) { // idtipodocumento ?>
	<tr id="r_idtipodocumento">
		<td class="<?php echo $tipodocumento_view->TableLeftColumnClass ?>"><span id="elh_tipodocumento_idtipodocumento"><?php echo $tipodocumento_view->idtipodocumento->caption() ?></span></td>
		<td data-name="idtipodocumento" <?php echo $tipodocumento_view->idtipodocumento->cellAttributes() ?>>
<span id="el_tipodocumento_idtipodocumento">
<span<?php echo $tipodocumento_view->idtipodocumento->viewAttributes() ?>><?php echo $tipodocumento_view->idtipodocumento->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tipodocumento_view->Tipo->Visible) { // Tipo ?>
	<tr id="r_Tipo">
		<td class="<?php echo $tipodocumento_view->TableLeftColumnClass ?>"><span id="elh_tipodocumento_Tipo"><?php echo $tipodocumento_view->Tipo->caption() ?></span></td>
		<td data-name="Tipo" <?php echo $tipodocumento_view->Tipo->cellAttributes() ?>>
<span id="el_tipodocumento_Tipo">
<span<?php echo $tipodocumento_view->Tipo->viewAttributes() ?>><?php echo $tipodocumento_view->Tipo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$tipodocumento_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$tipodocumento_view->isExport()) { ?>
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
$tipodocumento_view->terminate();
?>