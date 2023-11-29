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
$funcao_delete = new funcao_delete();

// Run the page
$funcao_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$funcao_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffuncaodelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	ffuncaodelete = currentForm = new ew.Form("ffuncaodelete", "delete");
	loadjs.done("ffuncaodelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $funcao_delete->showPageHeader(); ?>
<?php
$funcao_delete->showMessage();
?>
<form name="ffuncaodelete" id="ffuncaodelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="funcao">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($funcao_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($funcao_delete->funcao->Visible) { // funcao ?>
		<th class="<?php echo $funcao_delete->funcao->headerCellClass() ?>"><span id="elh_funcao_funcao" class="funcao_funcao"><?php echo $funcao_delete->funcao->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$funcao_delete->RecordCount = 0;
$i = 0;
while (!$funcao_delete->Recordset->EOF) {
	$funcao_delete->RecordCount++;
	$funcao_delete->RowCount++;

	// Set row properties
	$funcao->resetAttributes();
	$funcao->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$funcao_delete->loadRowValues($funcao_delete->Recordset);

	// Render row
	$funcao_delete->renderRow();
?>
	<tr <?php echo $funcao->rowAttributes() ?>>
<?php if ($funcao_delete->funcao->Visible) { // funcao ?>
		<td <?php echo $funcao_delete->funcao->cellAttributes() ?>>
<span id="el<?php echo $funcao_delete->RowCount ?>_funcao_funcao" class="funcao_funcao">
<span<?php echo $funcao_delete->funcao->viewAttributes() ?>><?php echo $funcao_delete->funcao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$funcao_delete->Recordset->moveNext();
}
$funcao_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $funcao_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$funcao_delete->showPageFooter();
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
$funcao_delete->terminate();
?>