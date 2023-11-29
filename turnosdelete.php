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
$turnos_delete = new turnos_delete();

// Run the page
$turnos_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fturnosdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fturnosdelete = currentForm = new ew.Form("fturnosdelete", "delete");
	loadjs.done("fturnosdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $turnos_delete->showPageHeader(); ?>
<?php
$turnos_delete->showMessage();
?>
<form name="fturnosdelete" id="fturnosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="turnos">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($turnos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($turnos_delete->idacademia->Visible) { // idacademia ?>
		<th class="<?php echo $turnos_delete->idacademia->headerCellClass() ?>"><span id="elh_turnos_idacademia" class="turnos_idacademia"><?php echo $turnos_delete->idacademia->caption() ?></span></th>
<?php } ?>
<?php if ($turnos_delete->turmas->Visible) { // turmas ?>
		<th class="<?php echo $turnos_delete->turmas->headerCellClass() ?>"><span id="elh_turnos_turmas" class="turnos_turmas"><?php echo $turnos_delete->turmas->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$turnos_delete->RecordCount = 0;
$i = 0;
while (!$turnos_delete->Recordset->EOF) {
	$turnos_delete->RecordCount++;
	$turnos_delete->RowCount++;

	// Set row properties
	$turnos->resetAttributes();
	$turnos->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$turnos_delete->loadRowValues($turnos_delete->Recordset);

	// Render row
	$turnos_delete->renderRow();
?>
	<tr <?php echo $turnos->rowAttributes() ?>>
<?php if ($turnos_delete->idacademia->Visible) { // idacademia ?>
		<td <?php echo $turnos_delete->idacademia->cellAttributes() ?>>
<span id="el<?php echo $turnos_delete->RowCount ?>_turnos_idacademia" class="turnos_idacademia">
<span<?php echo $turnos_delete->idacademia->viewAttributes() ?>><?php echo $turnos_delete->idacademia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($turnos_delete->turmas->Visible) { // turmas ?>
		<td <?php echo $turnos_delete->turmas->cellAttributes() ?>>
<span id="el<?php echo $turnos_delete->RowCount ?>_turnos_turmas" class="turnos_turmas">
<span<?php echo $turnos_delete->turmas->viewAttributes() ?>><?php echo $turnos_delete->turmas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$turnos_delete->Recordset->moveNext();
}
$turnos_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $turnos_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$turnos_delete->showPageFooter();
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
$turnos_delete->terminate();
?>