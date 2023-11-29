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
$endereco_delete = new endereco_delete();

// Run the page
$endereco_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$endereco_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fenderecodelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fenderecodelete = currentForm = new ew.Form("fenderecodelete", "delete");
	loadjs.done("fenderecodelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $endereco_delete->showPageHeader(); ?>
<?php
$endereco_delete->showMessage();
?>
<form name="fenderecodelete" id="fenderecodelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="endereco">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($endereco_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($endereco_delete->idacademia->Visible) { // idacademia ?>
		<th class="<?php echo $endereco_delete->idacademia->headerCellClass() ?>"><span id="elh_endereco_idacademia" class="endereco_idacademia"><?php echo $endereco_delete->idacademia->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->idpessoa->Visible) { // idpessoa ?>
		<th class="<?php echo $endereco_delete->idpessoa->headerCellClass() ?>"><span id="elh_endereco_idpessoa" class="endereco_idpessoa"><?php echo $endereco_delete->idpessoa->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->CEP->Visible) { // CEP ?>
		<th class="<?php echo $endereco_delete->CEP->headerCellClass() ?>"><span id="elh_endereco_CEP" class="endereco_CEP"><?php echo $endereco_delete->CEP->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->UF->Visible) { // UF ?>
		<th class="<?php echo $endereco_delete->UF->headerCellClass() ?>"><span id="elh_endereco_UF" class="endereco_UF"><?php echo $endereco_delete->UF->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->Cidade->Visible) { // Cidade ?>
		<th class="<?php echo $endereco_delete->Cidade->headerCellClass() ?>"><span id="elh_endereco_Cidade" class="endereco_Cidade"><?php echo $endereco_delete->Cidade->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->Bairro->Visible) { // Bairro ?>
		<th class="<?php echo $endereco_delete->Bairro->headerCellClass() ?>"><span id="elh_endereco_Bairro" class="endereco_Bairro"><?php echo $endereco_delete->Bairro->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->Rua->Visible) { // Rua ?>
		<th class="<?php echo $endereco_delete->Rua->headerCellClass() ?>"><span id="elh_endereco_Rua" class="endereco_Rua"><?php echo $endereco_delete->Rua->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->Numero->Visible) { // Numero ?>
		<th class="<?php echo $endereco_delete->Numero->headerCellClass() ?>"><span id="elh_endereco_Numero" class="endereco_Numero"><?php echo $endereco_delete->Numero->caption() ?></span></th>
<?php } ?>
<?php if ($endereco_delete->Complemento->Visible) { // Complemento ?>
		<th class="<?php echo $endereco_delete->Complemento->headerCellClass() ?>"><span id="elh_endereco_Complemento" class="endereco_Complemento"><?php echo $endereco_delete->Complemento->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$endereco_delete->RecordCount = 0;
$i = 0;
while (!$endereco_delete->Recordset->EOF) {
	$endereco_delete->RecordCount++;
	$endereco_delete->RowCount++;

	// Set row properties
	$endereco->resetAttributes();
	$endereco->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$endereco_delete->loadRowValues($endereco_delete->Recordset);

	// Render row
	$endereco_delete->renderRow();
?>
	<tr <?php echo $endereco->rowAttributes() ?>>
<?php if ($endereco_delete->idacademia->Visible) { // idacademia ?>
		<td <?php echo $endereco_delete->idacademia->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_idacademia" class="endereco_idacademia">
<span<?php echo $endereco_delete->idacademia->viewAttributes() ?>><?php echo $endereco_delete->idacademia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->idpessoa->Visible) { // idpessoa ?>
		<td <?php echo $endereco_delete->idpessoa->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_idpessoa" class="endereco_idpessoa">
<span<?php echo $endereco_delete->idpessoa->viewAttributes() ?>><?php echo $endereco_delete->idpessoa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->CEP->Visible) { // CEP ?>
		<td <?php echo $endereco_delete->CEP->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_CEP" class="endereco_CEP">
<span<?php echo $endereco_delete->CEP->viewAttributes() ?>><?php echo $endereco_delete->CEP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->UF->Visible) { // UF ?>
		<td <?php echo $endereco_delete->UF->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_UF" class="endereco_UF">
<span<?php echo $endereco_delete->UF->viewAttributes() ?>><?php echo $endereco_delete->UF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->Cidade->Visible) { // Cidade ?>
		<td <?php echo $endereco_delete->Cidade->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_Cidade" class="endereco_Cidade">
<span<?php echo $endereco_delete->Cidade->viewAttributes() ?>><?php echo $endereco_delete->Cidade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->Bairro->Visible) { // Bairro ?>
		<td <?php echo $endereco_delete->Bairro->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_Bairro" class="endereco_Bairro">
<span<?php echo $endereco_delete->Bairro->viewAttributes() ?>><?php echo $endereco_delete->Bairro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->Rua->Visible) { // Rua ?>
		<td <?php echo $endereco_delete->Rua->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_Rua" class="endereco_Rua">
<span<?php echo $endereco_delete->Rua->viewAttributes() ?>><?php echo $endereco_delete->Rua->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->Numero->Visible) { // Numero ?>
		<td <?php echo $endereco_delete->Numero->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_Numero" class="endereco_Numero">
<span<?php echo $endereco_delete->Numero->viewAttributes() ?>><?php echo $endereco_delete->Numero->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($endereco_delete->Complemento->Visible) { // Complemento ?>
		<td <?php echo $endereco_delete->Complemento->cellAttributes() ?>>
<span id="el<?php echo $endereco_delete->RowCount ?>_endereco_Complemento" class="endereco_Complemento">
<span<?php echo $endereco_delete->Complemento->viewAttributes() ?>><?php echo $endereco_delete->Complemento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$endereco_delete->Recordset->moveNext();
}
$endereco_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $endereco_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$endereco_delete->showPageFooter();
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
$endereco_delete->terminate();
?>