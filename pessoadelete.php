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
$pessoa_delete = new pessoa_delete();

// Run the page
$pessoa_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fpessoadelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fpessoadelete = currentForm = new ew.Form("fpessoadelete", "delete");
	loadjs.done("fpessoadelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $pessoa_delete->showPageHeader(); ?>
<?php
$pessoa_delete->showMessage();
?>
<form name="fpessoadelete" id="fpessoadelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pessoa">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($pessoa_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($pessoa_delete->idaula->Visible) { // idaula ?>
		<th class="<?php echo $pessoa_delete->idaula->headerCellClass() ?>"><span id="elh_pessoa_idaula" class="pessoa_idaula"><?php echo $pessoa_delete->idaula->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->Nome->Visible) { // Nome ?>
		<th class="<?php echo $pessoa_delete->Nome->headerCellClass() ?>"><span id="elh_pessoa_Nome" class="pessoa_Nome"><?php echo $pessoa_delete->Nome->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->CPF->Visible) { // CPF ?>
		<th class="<?php echo $pessoa_delete->CPF->headerCellClass() ?>"><span id="elh_pessoa_CPF" class="pessoa_CPF"><?php echo $pessoa_delete->CPF->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->Senha->Visible) { // Senha ?>
		<th class="<?php echo $pessoa_delete->Senha->headerCellClass() ?>"><span id="elh_pessoa_Senha" class="pessoa_Senha"><?php echo $pessoa_delete->Senha->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->Sexo->Visible) { // Sexo ?>
		<th class="<?php echo $pessoa_delete->Sexo->headerCellClass() ?>"><span id="elh_pessoa_Sexo" class="pessoa_Sexo"><?php echo $pessoa_delete->Sexo->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->datanascimento->Visible) { // datanascimento ?>
		<th class="<?php echo $pessoa_delete->datanascimento->headerCellClass() ?>"><span id="elh_pessoa_datanascimento" class="pessoa_datanascimento"><?php echo $pessoa_delete->datanascimento->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->Funcao->Visible) { // Funcao ?>
		<th class="<?php echo $pessoa_delete->Funcao->headerCellClass() ?>"><span id="elh_pessoa_Funcao" class="pessoa_Funcao"><?php echo $pessoa_delete->Funcao->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->_Email->Visible) { // Email ?>
		<th class="<?php echo $pessoa_delete->_Email->headerCellClass() ?>"><span id="elh_pessoa__Email" class="pessoa__Email"><?php echo $pessoa_delete->_Email->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->Ativado->Visible) { // Ativado ?>
		<th class="<?php echo $pessoa_delete->Ativado->headerCellClass() ?>"><span id="elh_pessoa_Ativado" class="pessoa_Ativado"><?php echo $pessoa_delete->Ativado->caption() ?></span></th>
<?php } ?>
<?php if ($pessoa_delete->Idade->Visible) { // Idade ?>
		<th class="<?php echo $pessoa_delete->Idade->headerCellClass() ?>"><span id="elh_pessoa_Idade" class="pessoa_Idade"><?php echo $pessoa_delete->Idade->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pessoa_delete->RecordCount = 0;
$i = 0;
while (!$pessoa_delete->Recordset->EOF) {
	$pessoa_delete->RecordCount++;
	$pessoa_delete->RowCount++;

	// Set row properties
	$pessoa->resetAttributes();
	$pessoa->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$pessoa_delete->loadRowValues($pessoa_delete->Recordset);

	// Render row
	$pessoa_delete->renderRow();
?>
	<tr <?php echo $pessoa->rowAttributes() ?>>
<?php if ($pessoa_delete->idaula->Visible) { // idaula ?>
		<td <?php echo $pessoa_delete->idaula->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_idaula" class="pessoa_idaula">
<span<?php echo $pessoa_delete->idaula->viewAttributes() ?>><?php echo $pessoa_delete->idaula->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->Nome->Visible) { // Nome ?>
		<td <?php echo $pessoa_delete->Nome->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_Nome" class="pessoa_Nome">
<span<?php echo $pessoa_delete->Nome->viewAttributes() ?>><?php echo $pessoa_delete->Nome->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->CPF->Visible) { // CPF ?>
		<td <?php echo $pessoa_delete->CPF->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_CPF" class="pessoa_CPF">
<span<?php echo $pessoa_delete->CPF->viewAttributes() ?>><?php echo $pessoa_delete->CPF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->Senha->Visible) { // Senha ?>
		<td <?php echo $pessoa_delete->Senha->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_Senha" class="pessoa_Senha">
<span<?php echo $pessoa_delete->Senha->viewAttributes() ?>><?php echo $pessoa_delete->Senha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->Sexo->Visible) { // Sexo ?>
		<td <?php echo $pessoa_delete->Sexo->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_Sexo" class="pessoa_Sexo">
<span<?php echo $pessoa_delete->Sexo->viewAttributes() ?>><?php echo $pessoa_delete->Sexo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->datanascimento->Visible) { // datanascimento ?>
		<td <?php echo $pessoa_delete->datanascimento->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_datanascimento" class="pessoa_datanascimento">
<span<?php echo $pessoa_delete->datanascimento->viewAttributes() ?>><?php echo $pessoa_delete->datanascimento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->Funcao->Visible) { // Funcao ?>
		<td <?php echo $pessoa_delete->Funcao->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_Funcao" class="pessoa_Funcao">
<span<?php echo $pessoa_delete->Funcao->viewAttributes() ?>><?php echo $pessoa_delete->Funcao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->_Email->Visible) { // Email ?>
		<td <?php echo $pessoa_delete->_Email->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa__Email" class="pessoa__Email">
<span<?php echo $pessoa_delete->_Email->viewAttributes() ?>><?php echo $pessoa_delete->_Email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->Ativado->Visible) { // Ativado ?>
		<td <?php echo $pessoa_delete->Ativado->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_Ativado" class="pessoa_Ativado">
<span<?php echo $pessoa_delete->Ativado->viewAttributes() ?>><?php echo $pessoa_delete->Ativado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pessoa_delete->Idade->Visible) { // Idade ?>
		<td <?php echo $pessoa_delete->Idade->cellAttributes() ?>>
<span id="el<?php echo $pessoa_delete->RowCount ?>_pessoa_Idade" class="pessoa_Idade">
<span<?php echo $pessoa_delete->Idade->viewAttributes() ?>><?php echo $pessoa_delete->Idade->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pessoa_delete->Recordset->moveNext();
}
$pessoa_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pessoa_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$pessoa_delete->showPageFooter();
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
$pessoa_delete->terminate();
?>