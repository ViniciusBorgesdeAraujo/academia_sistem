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
$documentos_delete = new documentos_delete();

// Run the page
$documentos_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documentos_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdocumentosdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fdocumentosdelete = currentForm = new ew.Form("fdocumentosdelete", "delete");
	loadjs.done("fdocumentosdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $documentos_delete->showPageHeader(); ?>
<?php
$documentos_delete->showMessage();
?>
<form name="fdocumentosdelete" id="fdocumentosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documentos">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($documentos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($documentos_delete->idpessoa->Visible) { // idpessoa ?>
		<th class="<?php echo $documentos_delete->idpessoa->headerCellClass() ?>"><span id="elh_documentos_idpessoa" class="documentos_idpessoa"><?php echo $documentos_delete->idpessoa->caption() ?></span></th>
<?php } ?>
<?php if ($documentos_delete->tipo->Visible) { // tipo ?>
		<th class="<?php echo $documentos_delete->tipo->headerCellClass() ?>"><span id="elh_documentos_tipo" class="documentos_tipo"><?php echo $documentos_delete->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($documentos_delete->numero->Visible) { // numero ?>
		<th class="<?php echo $documentos_delete->numero->headerCellClass() ?>"><span id="elh_documentos_numero" class="documentos_numero"><?php echo $documentos_delete->numero->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$documentos_delete->RecordCount = 0;
$i = 0;
while (!$documentos_delete->Recordset->EOF) {
	$documentos_delete->RecordCount++;
	$documentos_delete->RowCount++;

	// Set row properties
	$documentos->resetAttributes();
	$documentos->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$documentos_delete->loadRowValues($documentos_delete->Recordset);

	// Render row
	$documentos_delete->renderRow();
?>
	<tr <?php echo $documentos->rowAttributes() ?>>
<?php if ($documentos_delete->idpessoa->Visible) { // idpessoa ?>
		<td <?php echo $documentos_delete->idpessoa->cellAttributes() ?>>
<span id="el<?php echo $documentos_delete->RowCount ?>_documentos_idpessoa" class="documentos_idpessoa">
<span<?php echo $documentos_delete->idpessoa->viewAttributes() ?>><?php echo $documentos_delete->idpessoa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($documentos_delete->tipo->Visible) { // tipo ?>
		<td <?php echo $documentos_delete->tipo->cellAttributes() ?>>
<span id="el<?php echo $documentos_delete->RowCount ?>_documentos_tipo" class="documentos_tipo">
<span<?php echo $documentos_delete->tipo->viewAttributes() ?>><?php echo $documentos_delete->tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($documentos_delete->numero->Visible) { // numero ?>
		<td <?php echo $documentos_delete->numero->cellAttributes() ?>>
<span id="el<?php echo $documentos_delete->RowCount ?>_documentos_numero" class="documentos_numero">
<span<?php echo $documentos_delete->numero->viewAttributes() ?>><?php echo $documentos_delete->numero->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$documentos_delete->Recordset->moveNext();
}
$documentos_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $documentos_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$documentos_delete->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$documentos_delete->terminate();
?>