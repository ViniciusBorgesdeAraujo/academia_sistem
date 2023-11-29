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
$documentos_view = new documentos_view();

// Run the page
$documentos_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documentos_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$documentos_view->isExport()) { ?>
<script>
var fdocumentosview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fdocumentosview = currentForm = new ew.Form("fdocumentosview", "view");
	loadjs.done("fdocumentosview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$documentos_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $documentos_view->ExportOptions->render("body") ?>
<?php $documentos_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $documentos_view->showPageHeader(); ?>
<?php
$documentos_view->showMessage();
?>
<form name="fdocumentosview" id="fdocumentosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documentos">
<input type="hidden" name="modal" value="<?php echo (int)$documentos_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($documentos_view->iddocumentos->Visible) { // iddocumentos ?>
	<tr id="r_iddocumentos">
		<td class="<?php echo $documentos_view->TableLeftColumnClass ?>"><span id="elh_documentos_iddocumentos"><?php echo $documentos_view->iddocumentos->caption() ?></span></td>
		<td data-name="iddocumentos" <?php echo $documentos_view->iddocumentos->cellAttributes() ?>>
<span id="el_documentos_iddocumentos">
<span<?php echo $documentos_view->iddocumentos->viewAttributes() ?>><?php echo $documentos_view->iddocumentos->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documentos_view->idpessoa->Visible) { // idpessoa ?>
	<tr id="r_idpessoa">
		<td class="<?php echo $documentos_view->TableLeftColumnClass ?>"><span id="elh_documentos_idpessoa"><?php echo $documentos_view->idpessoa->caption() ?></span></td>
		<td data-name="idpessoa" <?php echo $documentos_view->idpessoa->cellAttributes() ?>>
<span id="el_documentos_idpessoa">
<span<?php echo $documentos_view->idpessoa->viewAttributes() ?>><?php echo $documentos_view->idpessoa->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documentos_view->tipo->Visible) { // tipo ?>
	<tr id="r_tipo">
		<td class="<?php echo $documentos_view->TableLeftColumnClass ?>"><span id="elh_documentos_tipo"><?php echo $documentos_view->tipo->caption() ?></span></td>
		<td data-name="tipo" <?php echo $documentos_view->tipo->cellAttributes() ?>>
<span id="el_documentos_tipo">
<span<?php echo $documentos_view->tipo->viewAttributes() ?>><?php echo $documentos_view->tipo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documentos_view->numero->Visible) { // numero ?>
	<tr id="r_numero">
		<td class="<?php echo $documentos_view->TableLeftColumnClass ?>"><span id="elh_documentos_numero"><?php echo $documentos_view->numero->caption() ?></span></td>
		<td data-name="numero" <?php echo $documentos_view->numero->cellAttributes() ?>>
<span id="el_documentos_numero">
<span<?php echo $documentos_view->numero->viewAttributes() ?>><?php echo $documentos_view->numero->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$documentos_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$documentos_view->isExport()) { ?>
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
$documentos_view->terminate();
?>