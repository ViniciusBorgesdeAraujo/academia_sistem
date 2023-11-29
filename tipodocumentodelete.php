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
$tipodocumento_delete = new tipodocumento_delete();

// Run the page
$tipodocumento_delete->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumento_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ftipodocumentodelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	ftipodocumentodelete = currentForm = new ew.Form("ftipodocumentodelete", "delete");
	loadjs.done("ftipodocumentodelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $tipodocumento_delete->showPageHeader(); ?>
<?php
$tipodocumento_delete->showMessage();
?>
<form name="ftipodocumentodelete" id="ftipodocumentodelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumento">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($tipodocumento_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($tipodocumento_delete->idtipodocumento->Visible) { // idtipodocumento ?>
		<th class="<?php echo $tipodocumento_delete->idtipodocumento->headerCellClass() ?>"><span id="elh_tipodocumento_idtipodocumento" class="tipodocumento_idtipodocumento"><?php echo $tipodocumento_delete->idtipodocumento->caption() ?></span></th>
<?php } ?>
<?php if ($tipodocumento_delete->Tipo->Visible) { // Tipo ?>
		<th class="<?php echo $tipodocumento_delete->Tipo->headerCellClass() ?>"><span id="elh_tipodocumento_Tipo" class="tipodocumento_Tipo"><?php echo $tipodocumento_delete->Tipo->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tipodocumento_delete->RecordCount = 0;
$i = 0;
while (!$tipodocumento_delete->Recordset->EOF) {
	$tipodocumento_delete->RecordCount++;
	$tipodocumento_delete->RowCount++;

	// Set row properties
	$tipodocumento->resetAttributes();
	$tipodocumento->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$tipodocumento_delete->loadRowValues($tipodocumento_delete->Recordset);

	// Render row
	$tipodocumento_delete->renderRow();
?>
	<tr <?php echo $tipodocumento->rowAttributes() ?>>
<?php if ($tipodocumento_delete->idtipodocumento->Visible) { // idtipodocumento ?>
		<td <?php echo $tipodocumento_delete->idtipodocumento->cellAttributes() ?>>
<span id="el<?php echo $tipodocumento_delete->RowCount ?>_tipodocumento_idtipodocumento" class="tipodocumento_idtipodocumento">
<span<?php echo $tipodocumento_delete->idtipodocumento->viewAttributes() ?>><?php echo $tipodocumento_delete->idtipodocumento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tipodocumento_delete->Tipo->Visible) { // Tipo ?>
		<td <?php echo $tipodocumento_delete->Tipo->cellAttributes() ?>>
<span id="el<?php echo $tipodocumento_delete->RowCount ?>_tipodocumento_Tipo" class="tipodocumento_Tipo">
<span<?php echo $tipodocumento_delete->Tipo->viewAttributes() ?>><?php echo $tipodocumento_delete->Tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tipodocumento_delete->Recordset->moveNext();
}
$tipodocumento_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $tipodocumento_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$tipodocumento_delete->showPageFooter();
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
$tipodocumento_delete->terminate();
?>