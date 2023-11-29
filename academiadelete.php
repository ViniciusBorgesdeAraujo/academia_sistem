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
$academia_delete = new academia_delete();

// Run the page
$academia_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$academia_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var facademiadelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	facademiadelete = currentForm = new ew.Form("facademiadelete", "delete");
	loadjs.done("facademiadelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $academia_delete->showPageHeader(); ?>
<?php
$academia_delete->showMessage();
?>
<form name="facademiadelete" id="facademiadelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="academia">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($academia_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($academia_delete->nome->Visible) { // nome ?>
		<th class="<?php echo $academia_delete->nome->headerCellClass() ?>"><span id="elh_academia_nome" class="academia_nome"><?php echo $academia_delete->nome->caption() ?></span></th>
<?php } ?>
<?php if ($academia_delete->registro->Visible) { // registro ?>
		<th class="<?php echo $academia_delete->registro->headerCellClass() ?>"><span id="elh_academia_registro" class="academia_registro"><?php echo $academia_delete->registro->caption() ?></span></th>
<?php } ?>
<?php if ($academia_delete->ativado->Visible) { // ativado ?>
		<th class="<?php echo $academia_delete->ativado->headerCellClass() ?>"><span id="elh_academia_ativado" class="academia_ativado"><?php echo $academia_delete->ativado->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$academia_delete->RecordCount = 0;
$i = 0;
while (!$academia_delete->Recordset->EOF) {
	$academia_delete->RecordCount++;
	$academia_delete->RowCount++;

	// Set row properties
	$academia->resetAttributes();
	$academia->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$academia_delete->loadRowValues($academia_delete->Recordset);

	// Render row
	$academia_delete->renderRow();
?>
	<tr <?php echo $academia->rowAttributes() ?>>
<?php if ($academia_delete->nome->Visible) { // nome ?>
		<td <?php echo $academia_delete->nome->cellAttributes() ?>>
<span id="el<?php echo $academia_delete->RowCount ?>_academia_nome" class="academia_nome">
<span<?php echo $academia_delete->nome->viewAttributes() ?>><?php echo $academia_delete->nome->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($academia_delete->registro->Visible) { // registro ?>
		<td <?php echo $academia_delete->registro->cellAttributes() ?>>
<span id="el<?php echo $academia_delete->RowCount ?>_academia_registro" class="academia_registro">
<span<?php echo $academia_delete->registro->viewAttributes() ?>><?php echo $academia_delete->registro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($academia_delete->ativado->Visible) { // ativado ?>
		<td <?php echo $academia_delete->ativado->cellAttributes() ?>>
<span id="el<?php echo $academia_delete->RowCount ?>_academia_ativado" class="academia_ativado">
<span<?php echo $academia_delete->ativado->viewAttributes() ?>><?php echo $academia_delete->ativado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$academia_delete->Recordset->moveNext();
}
$academia_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $academia_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$academia_delete->showPageFooter();
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
$academia_delete->terminate();
?>