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
$tipodocumentos_view = new tipodocumentos_view();

// Run the page
$tipodocumentos_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumentos_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$tipodocumentos_view->isExport()) { ?>
<script>
var ftipodocumentosview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	ftipodocumentosview = currentForm = new ew.Form("ftipodocumentosview", "view");
	loadjs.done("ftipodocumentosview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$tipodocumentos_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $tipodocumentos_view->ExportOptions->render("body") ?>
<?php $tipodocumentos_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $tipodocumentos_view->showPageHeader(); ?>
<?php
$tipodocumentos_view->showMessage();
?>
<?php if (!$tipodocumentos_view->IsModal) { ?>
<?php if (!$tipodocumentos_view->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $tipodocumentos_view->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="ftipodocumentosview" id="ftipodocumentosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumentos">
<input type="hidden" name="modal" value="<?php echo (int)$tipodocumentos_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($tipodocumentos_view->idtipodocumentos->Visible) { // idtipodocumentos ?>
	<tr id="r_idtipodocumentos">
		<td class="<?php echo $tipodocumentos_view->TableLeftColumnClass ?>"><span id="elh_tipodocumentos_idtipodocumentos"><?php echo $tipodocumentos_view->idtipodocumentos->caption() ?></span></td>
		<td data-name="idtipodocumentos" <?php echo $tipodocumentos_view->idtipodocumentos->cellAttributes() ?>>
<span id="el_tipodocumentos_idtipodocumentos">
<span<?php echo $tipodocumentos_view->idtipodocumentos->viewAttributes() ?>><?php echo $tipodocumentos_view->idtipodocumentos->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tipodocumentos_view->Tipo->Visible) { // Tipo ?>
	<tr id="r_Tipo">
		<td class="<?php echo $tipodocumentos_view->TableLeftColumnClass ?>"><span id="elh_tipodocumentos_Tipo"><?php echo $tipodocumentos_view->Tipo->caption() ?></span></td>
		<td data-name="Tipo" <?php echo $tipodocumentos_view->Tipo->cellAttributes() ?>>
<span id="el_tipodocumentos_Tipo">
<span<?php echo $tipodocumentos_view->Tipo->viewAttributes() ?>><?php echo $tipodocumentos_view->Tipo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$tipodocumentos_view->IsModal) { ?>
<?php if (!$tipodocumentos_view->isExport()) { ?>
<?php echo $tipodocumentos_view->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$tipodocumentos_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$tipodocumentos_view->isExport()) { ?>
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
$tipodocumentos_view->terminate();
?>