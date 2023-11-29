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
$aulas_delete = new aulas_delete();

// Run the page
$aulas_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$aulas_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var faulasdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	faulasdelete = currentForm = new ew.Form("faulasdelete", "delete");
	loadjs.done("faulasdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $aulas_delete->showPageHeader(); ?>
<?php
$aulas_delete->showMessage();
?>
<form name="faulasdelete" id="faulasdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="aulas">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($aulas_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($aulas_delete->idturnos->Visible) { // idturnos ?>
		<th class="<?php echo $aulas_delete->idturnos->headerCellClass() ?>"><span id="elh_aulas_idturnos" class="aulas_idturnos"><?php echo $aulas_delete->idturnos->caption() ?></span></th>
<?php } ?>
<?php if ($aulas_delete->idaluno->Visible) { // idaluno ?>
		<th class="<?php echo $aulas_delete->idaluno->headerCellClass() ?>"><span id="elh_aulas_idaluno" class="aulas_idaluno"><?php echo $aulas_delete->idaluno->caption() ?></span></th>
<?php } ?>
<?php if ($aulas_delete->nome->Visible) { // nome ?>
		<th class="<?php echo $aulas_delete->nome->headerCellClass() ?>"><span id="elh_aulas_nome" class="aulas_nome"><?php echo $aulas_delete->nome->caption() ?></span></th>
<?php } ?>
<?php if ($aulas_delete->ativado->Visible) { // ativado ?>
		<th class="<?php echo $aulas_delete->ativado->headerCellClass() ?>"><span id="elh_aulas_ativado" class="aulas_ativado"><?php echo $aulas_delete->ativado->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$aulas_delete->RecordCount = 0;
$i = 0;
while (!$aulas_delete->Recordset->EOF) {
	$aulas_delete->RecordCount++;
	$aulas_delete->RowCount++;

	// Set row properties
	$aulas->resetAttributes();
	$aulas->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$aulas_delete->loadRowValues($aulas_delete->Recordset);

	// Render row
	$aulas_delete->renderRow();
?>
	<tr <?php echo $aulas->rowAttributes() ?>>
<?php if ($aulas_delete->idturnos->Visible) { // idturnos ?>
		<td <?php echo $aulas_delete->idturnos->cellAttributes() ?>>
<span id="el<?php echo $aulas_delete->RowCount ?>_aulas_idturnos" class="aulas_idturnos">
<span<?php echo $aulas_delete->idturnos->viewAttributes() ?>><?php echo $aulas_delete->idturnos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($aulas_delete->idaluno->Visible) { // idaluno ?>
		<td <?php echo $aulas_delete->idaluno->cellAttributes() ?>>
<span id="el<?php echo $aulas_delete->RowCount ?>_aulas_idaluno" class="aulas_idaluno">
<span<?php echo $aulas_delete->idaluno->viewAttributes() ?>><?php echo $aulas_delete->idaluno->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($aulas_delete->nome->Visible) { // nome ?>
		<td <?php echo $aulas_delete->nome->cellAttributes() ?>>
<span id="el<?php echo $aulas_delete->RowCount ?>_aulas_nome" class="aulas_nome">
<span<?php echo $aulas_delete->nome->viewAttributes() ?>><?php echo $aulas_delete->nome->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($aulas_delete->ativado->Visible) { // ativado ?>
		<td <?php echo $aulas_delete->ativado->cellAttributes() ?>>
<span id="el<?php echo $aulas_delete->RowCount ?>_aulas_ativado" class="aulas_ativado">
<span<?php echo $aulas_delete->ativado->viewAttributes() ?>><?php echo $aulas_delete->ativado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$aulas_delete->Recordset->moveNext();
}
$aulas_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $aulas_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$aulas_delete->showPageFooter();
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
$aulas_delete->terminate();
?>