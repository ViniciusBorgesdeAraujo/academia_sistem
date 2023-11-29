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
$tipodocumentos_delete = new tipodocumentos_delete();

// Run the page
$tipodocumentos_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumentos_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ftipodocumentosdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	ftipodocumentosdelete = currentForm = new ew.Form("ftipodocumentosdelete", "delete");
	loadjs.done("ftipodocumentosdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $tipodocumentos_delete->showPageHeader(); ?>
<?php
$tipodocumentos_delete->showMessage();
?>
<form name="ftipodocumentosdelete" id="ftipodocumentosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumentos">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($tipodocumentos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($tipodocumentos_delete->idtipodocumentos->Visible) { // idtipodocumentos ?>
		<th class="<?php echo $tipodocumentos_delete->idtipodocumentos->headerCellClass() ?>"><span id="elh_tipodocumentos_idtipodocumentos" class="tipodocumentos_idtipodocumentos"><?php echo $tipodocumentos_delete->idtipodocumentos->caption() ?></span></th>
<?php } ?>
<?php if ($tipodocumentos_delete->Tipo->Visible) { // Tipo ?>
		<th class="<?php echo $tipodocumentos_delete->Tipo->headerCellClass() ?>"><span id="elh_tipodocumentos_Tipo" class="tipodocumentos_Tipo"><?php echo $tipodocumentos_delete->Tipo->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tipodocumentos_delete->RecordCount = 0;
$i = 0;
while (!$tipodocumentos_delete->Recordset->EOF) {
	$tipodocumentos_delete->RecordCount++;
	$tipodocumentos_delete->RowCount++;

	// Set row properties
	$tipodocumentos->resetAttributes();
	$tipodocumentos->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$tipodocumentos_delete->loadRowValues($tipodocumentos_delete->Recordset);

	// Render row
	$tipodocumentos_delete->renderRow();
?>
	<tr <?php echo $tipodocumentos->rowAttributes() ?>>
<?php if ($tipodocumentos_delete->idtipodocumentos->Visible) { // idtipodocumentos ?>
		<td <?php echo $tipodocumentos_delete->idtipodocumentos->cellAttributes() ?>>
<span id="el<?php echo $tipodocumentos_delete->RowCount ?>_tipodocumentos_idtipodocumentos" class="tipodocumentos_idtipodocumentos">
<span<?php echo $tipodocumentos_delete->idtipodocumentos->viewAttributes() ?>><?php echo $tipodocumentos_delete->idtipodocumentos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tipodocumentos_delete->Tipo->Visible) { // Tipo ?>
		<td <?php echo $tipodocumentos_delete->Tipo->cellAttributes() ?>>
<span id="el<?php echo $tipodocumentos_delete->RowCount ?>_tipodocumentos_Tipo" class="tipodocumentos_Tipo">
<span<?php echo $tipodocumentos_delete->Tipo->viewAttributes() ?>><?php echo $tipodocumentos_delete->Tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tipodocumentos_delete->Recordset->moveNext();
}
$tipodocumentos_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $tipodocumentos_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$tipodocumentos_delete->showPageFooter();
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
$tipodocumentos_delete->terminate();
?>