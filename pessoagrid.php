<?php
namespace PHPMaker2020\sistema;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($pessoa_grid))
	$pessoa_grid = new pessoa_grid();

// Run the page
$pessoa_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_grid->Page_Render();
?>
<?php if (!$pessoa_grid->isExport()) { ?>
<script>
var fpessoagrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fpessoagrid = new ew.Form("fpessoagrid", "grid");
	fpessoagrid.formKeyCountName = '<?php echo $pessoa_grid->FormKeyCountName ?>';

	// Validate form
	fpessoagrid.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "confirm")
			return true;
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			var checkrow = (gridinsert) ? !this.emptyRow(infix) : true;
			if (checkrow) {
				addcnt++;
			<?php if ($pessoa_grid->idaula->Required) { ?>
				elm = this.getElements("x" + infix + "_idaula");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->idaula->caption(), $pessoa_grid->idaula->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_grid->Nome->Required) { ?>
				elm = this.getElements("x" + infix + "_Nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->Nome->caption(), $pessoa_grid->Nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_grid->CPF->Required) { ?>
				elm = this.getElements("x" + infix + "_CPF");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->CPF->caption(), $pessoa_grid->CPF->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_grid->Senha->Required) { ?>
				elm = this.getElements("x" + infix + "_Senha");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->Senha->caption(), $pessoa_grid->Senha->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_Senha");
				if (elm && $(elm).hasClass("ew-password-strength") && !$(elm).data("validated"))
					return this.onError(elm, ew.language.phrase("PasswordTooSimple"));
			<?php if ($pessoa_grid->Sexo->Required) { ?>
				elm = this.getElements("x" + infix + "_Sexo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->Sexo->caption(), $pessoa_grid->Sexo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_grid->datanascimento->Required) { ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->datanascimento->caption(), $pessoa_grid->datanascimento->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				if (elm && !ew.checkEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_grid->datanascimento->errorMessage()) ?>");
			<?php if ($pessoa_grid->Funcao->Required) { ?>
				elm = this.getElements("x" + infix + "_Funcao");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->Funcao->caption(), $pessoa_grid->Funcao->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_grid->_Email->Required) { ?>
				elm = this.getElements("x" + infix + "__Email");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->_Email->caption(), $pessoa_grid->_Email->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "__Email");
				if (elm && !ew.checkEmail(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_grid->_Email->errorMessage()) ?>");
			<?php if ($pessoa_grid->Ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_Ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->Ativado->caption(), $pessoa_grid->Ativado->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_grid->Idade->Required) { ?>
				elm = this.getElements("x" + infix + "_Idade");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_grid->Idade->caption(), $pessoa_grid->Idade->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_Idade");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_grid->Idade->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fpessoagrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idaula", false)) return false;
		if (ew.valueChanged(fobj, infix, "Nome", false)) return false;
		if (ew.valueChanged(fobj, infix, "CPF", false)) return false;
		if (ew.valueChanged(fobj, infix, "Senha", false)) return false;
		if (ew.valueChanged(fobj, infix, "Sexo", false)) return false;
		if (ew.valueChanged(fobj, infix, "datanascimento", false)) return false;
		if (ew.valueChanged(fobj, infix, "Funcao", false)) return false;
		if (ew.valueChanged(fobj, infix, "_Email", false)) return false;
		if (ew.valueChanged(fobj, infix, "Ativado", false)) return false;
		if (ew.valueChanged(fobj, infix, "Idade", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fpessoagrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fpessoagrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fpessoagrid.lists["x_idaula"] = <?php echo $pessoa_grid->idaula->Lookup->toClientList($pessoa_grid) ?>;
	fpessoagrid.lists["x_idaula"].options = <?php echo JsonEncode($pessoa_grid->idaula->lookupOptions()) ?>;
	fpessoagrid.lists["x_Sexo"] = <?php echo $pessoa_grid->Sexo->Lookup->toClientList($pessoa_grid) ?>;
	fpessoagrid.lists["x_Sexo"].options = <?php echo JsonEncode($pessoa_grid->Sexo->options(FALSE, TRUE)) ?>;
	fpessoagrid.lists["x_Funcao"] = <?php echo $pessoa_grid->Funcao->Lookup->toClientList($pessoa_grid) ?>;
	fpessoagrid.lists["x_Funcao"].options = <?php echo JsonEncode($pessoa_grid->Funcao->lookupOptions()) ?>;
	fpessoagrid.lists["x_Ativado"] = <?php echo $pessoa_grid->Ativado->Lookup->toClientList($pessoa_grid) ?>;
	fpessoagrid.lists["x_Ativado"].options = <?php echo JsonEncode($pessoa_grid->Ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("fpessoagrid");
});
</script>
<?php } ?>
<?php
$pessoa_grid->renderOtherOptions();
?>
<?php if ($pessoa_grid->TotalRecords > 0 || $pessoa->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($pessoa_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pessoa">
<?php if ($pessoa_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $pessoa_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fpessoagrid" class="ew-form ew-list-form form-inline">
<div id="gmp_pessoa" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_pessoagrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$pessoa->RowType = ROWTYPE_HEADER;

// Render list options
$pessoa_grid->renderListOptions();

// Render list options (header, left)
$pessoa_grid->ListOptions->render("header", "left");
?>
<?php if ($pessoa_grid->idaula->Visible) { // idaula ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->idaula) == "") { ?>
		<th data-name="idaula" class="<?php echo $pessoa_grid->idaula->headerCellClass() ?>"><div id="elh_pessoa_idaula" class="pessoa_idaula"><div class="ew-table-header-caption"><?php echo $pessoa_grid->idaula->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idaula" class="<?php echo $pessoa_grid->idaula->headerCellClass() ?>"><div><div id="elh_pessoa_idaula" class="pessoa_idaula">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->idaula->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->idaula->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->idaula->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->Nome->Visible) { // Nome ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->Nome) == "") { ?>
		<th data-name="Nome" class="<?php echo $pessoa_grid->Nome->headerCellClass() ?>"><div id="elh_pessoa_Nome" class="pessoa_Nome"><div class="ew-table-header-caption"><?php echo $pessoa_grid->Nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nome" class="<?php echo $pessoa_grid->Nome->headerCellClass() ?>"><div><div id="elh_pessoa_Nome" class="pessoa_Nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->Nome->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->Nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->Nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->CPF->Visible) { // CPF ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->CPF) == "") { ?>
		<th data-name="CPF" class="<?php echo $pessoa_grid->CPF->headerCellClass() ?>"><div id="elh_pessoa_CPF" class="pessoa_CPF"><div class="ew-table-header-caption"><?php echo $pessoa_grid->CPF->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CPF" class="<?php echo $pessoa_grid->CPF->headerCellClass() ?>"><div><div id="elh_pessoa_CPF" class="pessoa_CPF">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->CPF->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->CPF->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->CPF->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->Senha->Visible) { // Senha ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->Senha) == "") { ?>
		<th data-name="Senha" class="<?php echo $pessoa_grid->Senha->headerCellClass() ?>"><div id="elh_pessoa_Senha" class="pessoa_Senha"><div class="ew-table-header-caption"><?php echo $pessoa_grid->Senha->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Senha" class="<?php echo $pessoa_grid->Senha->headerCellClass() ?>"><div><div id="elh_pessoa_Senha" class="pessoa_Senha">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->Senha->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->Senha->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->Senha->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->Sexo->Visible) { // Sexo ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->Sexo) == "") { ?>
		<th data-name="Sexo" class="<?php echo $pessoa_grid->Sexo->headerCellClass() ?>"><div id="elh_pessoa_Sexo" class="pessoa_Sexo"><div class="ew-table-header-caption"><?php echo $pessoa_grid->Sexo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sexo" class="<?php echo $pessoa_grid->Sexo->headerCellClass() ?>"><div><div id="elh_pessoa_Sexo" class="pessoa_Sexo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->Sexo->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->Sexo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->Sexo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->datanascimento->Visible) { // datanascimento ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->datanascimento) == "") { ?>
		<th data-name="datanascimento" class="<?php echo $pessoa_grid->datanascimento->headerCellClass() ?>"><div id="elh_pessoa_datanascimento" class="pessoa_datanascimento"><div class="ew-table-header-caption"><?php echo $pessoa_grid->datanascimento->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="datanascimento" class="<?php echo $pessoa_grid->datanascimento->headerCellClass() ?>"><div><div id="elh_pessoa_datanascimento" class="pessoa_datanascimento">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->datanascimento->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->datanascimento->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->datanascimento->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->Funcao->Visible) { // Funcao ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->Funcao) == "") { ?>
		<th data-name="Funcao" class="<?php echo $pessoa_grid->Funcao->headerCellClass() ?>"><div id="elh_pessoa_Funcao" class="pessoa_Funcao"><div class="ew-table-header-caption"><?php echo $pessoa_grid->Funcao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Funcao" class="<?php echo $pessoa_grid->Funcao->headerCellClass() ?>"><div><div id="elh_pessoa_Funcao" class="pessoa_Funcao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->Funcao->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->Funcao->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->Funcao->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->_Email->Visible) { // Email ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->_Email) == "") { ?>
		<th data-name="_Email" class="<?php echo $pessoa_grid->_Email->headerCellClass() ?>"><div id="elh_pessoa__Email" class="pessoa__Email"><div class="ew-table-header-caption"><?php echo $pessoa_grid->_Email->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_Email" class="<?php echo $pessoa_grid->_Email->headerCellClass() ?>"><div><div id="elh_pessoa__Email" class="pessoa__Email">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->_Email->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->_Email->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->_Email->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->Ativado->Visible) { // Ativado ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->Ativado) == "") { ?>
		<th data-name="Ativado" class="<?php echo $pessoa_grid->Ativado->headerCellClass() ?>"><div id="elh_pessoa_Ativado" class="pessoa_Ativado"><div class="ew-table-header-caption"><?php echo $pessoa_grid->Ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Ativado" class="<?php echo $pessoa_grid->Ativado->headerCellClass() ?>"><div><div id="elh_pessoa_Ativado" class="pessoa_Ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->Ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->Ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->Ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_grid->Idade->Visible) { // Idade ?>
	<?php if ($pessoa_grid->SortUrl($pessoa_grid->Idade) == "") { ?>
		<th data-name="Idade" class="<?php echo $pessoa_grid->Idade->headerCellClass() ?>"><div id="elh_pessoa_Idade" class="pessoa_Idade"><div class="ew-table-header-caption"><?php echo $pessoa_grid->Idade->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Idade" class="<?php echo $pessoa_grid->Idade->headerCellClass() ?>"><div><div id="elh_pessoa_Idade" class="pessoa_Idade">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_grid->Idade->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_grid->Idade->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_grid->Idade->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pessoa_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$pessoa_grid->StartRecord = 1;
$pessoa_grid->StopRecord = $pessoa_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($pessoa->isConfirm() || $pessoa_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($pessoa_grid->FormKeyCountName) && ($pessoa_grid->isGridAdd() || $pessoa_grid->isGridEdit() || $pessoa->isConfirm())) {
		$pessoa_grid->KeyCount = $CurrentForm->getValue($pessoa_grid->FormKeyCountName);
		$pessoa_grid->StopRecord = $pessoa_grid->StartRecord + $pessoa_grid->KeyCount - 1;
	}
}
$pessoa_grid->RecordCount = $pessoa_grid->StartRecord - 1;
if ($pessoa_grid->Recordset && !$pessoa_grid->Recordset->EOF) {
	$pessoa_grid->Recordset->moveFirst();
	$selectLimit = $pessoa_grid->UseSelectLimit;
	if (!$selectLimit && $pessoa_grid->StartRecord > 1)
		$pessoa_grid->Recordset->move($pessoa_grid->StartRecord - 1);
} elseif (!$pessoa->AllowAddDeleteRow && $pessoa_grid->StopRecord == 0) {
	$pessoa_grid->StopRecord = $pessoa->GridAddRowCount;
}

// Initialize aggregate
$pessoa->RowType = ROWTYPE_AGGREGATEINIT;
$pessoa->resetAttributes();
$pessoa_grid->renderRow();
if ($pessoa_grid->isGridAdd())
	$pessoa_grid->RowIndex = 0;
if ($pessoa_grid->isGridEdit())
	$pessoa_grid->RowIndex = 0;
while ($pessoa_grid->RecordCount < $pessoa_grid->StopRecord) {
	$pessoa_grid->RecordCount++;
	if ($pessoa_grid->RecordCount >= $pessoa_grid->StartRecord) {
		$pessoa_grid->RowCount++;
		if ($pessoa_grid->isGridAdd() || $pessoa_grid->isGridEdit() || $pessoa->isConfirm()) {
			$pessoa_grid->RowIndex++;
			$CurrentForm->Index = $pessoa_grid->RowIndex;
			if ($CurrentForm->hasValue($pessoa_grid->FormActionName) && ($pessoa->isConfirm() || $pessoa_grid->EventCancelled))
				$pessoa_grid->RowAction = strval($CurrentForm->getValue($pessoa_grid->FormActionName));
			elseif ($pessoa_grid->isGridAdd())
				$pessoa_grid->RowAction = "insert";
			else
				$pessoa_grid->RowAction = "";
		}

		// Set up key count
		$pessoa_grid->KeyCount = $pessoa_grid->RowIndex;

		// Init row class and style
		$pessoa->resetAttributes();
		$pessoa->CssClass = "";
		if ($pessoa_grid->isGridAdd()) {
			if ($pessoa->CurrentMode == "copy") {
				$pessoa_grid->loadRowValues($pessoa_grid->Recordset); // Load row values
				$pessoa_grid->setRecordKey($pessoa_grid->RowOldKey, $pessoa_grid->Recordset); // Set old record key
			} else {
				$pessoa_grid->loadRowValues(); // Load default values
				$pessoa_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$pessoa_grid->loadRowValues($pessoa_grid->Recordset); // Load row values
		}
		$pessoa->RowType = ROWTYPE_VIEW; // Render view
		if ($pessoa_grid->isGridAdd()) // Grid add
			$pessoa->RowType = ROWTYPE_ADD; // Render add
		if ($pessoa_grid->isGridAdd() && $pessoa->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$pessoa_grid->restoreCurrentRowFormValues($pessoa_grid->RowIndex); // Restore form values
		if ($pessoa_grid->isGridEdit()) { // Grid edit
			if ($pessoa->EventCancelled)
				$pessoa_grid->restoreCurrentRowFormValues($pessoa_grid->RowIndex); // Restore form values
			if ($pessoa_grid->RowAction == "insert")
				$pessoa->RowType = ROWTYPE_ADD; // Render add
			else
				$pessoa->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($pessoa_grid->isGridEdit() && ($pessoa->RowType == ROWTYPE_EDIT || $pessoa->RowType == ROWTYPE_ADD) && $pessoa->EventCancelled) // Update failed
			$pessoa_grid->restoreCurrentRowFormValues($pessoa_grid->RowIndex); // Restore form values
		if ($pessoa->RowType == ROWTYPE_EDIT) // Edit row
			$pessoa_grid->EditRowCount++;
		if ($pessoa->isConfirm()) // Confirm row
			$pessoa_grid->restoreCurrentRowFormValues($pessoa_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$pessoa->RowAttrs->merge(["data-rowindex" => $pessoa_grid->RowCount, "id" => "r" . $pessoa_grid->RowCount . "_pessoa", "data-rowtype" => $pessoa->RowType]);

		// Render row
		$pessoa_grid->renderRow();

		// Render list options
		$pessoa_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pessoa_grid->RowAction != "delete" && $pessoa_grid->RowAction != "insertdelete" && !($pessoa_grid->RowAction == "insert" && $pessoa->isConfirm() && $pessoa_grid->emptyRow())) {
?>
	<tr <?php echo $pessoa->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pessoa_grid->ListOptions->render("body", "left", $pessoa_grid->RowCount);
?>
	<?php if ($pessoa_grid->idaula->Visible) { // idaula ?>
		<td data-name="idaula" <?php echo $pessoa_grid->idaula->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($pessoa_grid->idaula->getSessionValue() != "") { ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_idaula" class="form-group">
<span<?php echo $pessoa_grid->idaula->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->idaula->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_idaula" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_idaula" data-value-separator="<?php echo $pessoa_grid->idaula->displayValueSeparatorAttribute() ?>" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula"<?php echo $pessoa_grid->idaula->editAttributes() ?>>
			<?php echo $pessoa_grid->idaula->selectOptionListHtml("x{$pessoa_grid->RowIndex}_idaula") ?>
		</select>
</div>
<?php echo $pessoa_grid->idaula->Lookup->getParamTag($pessoa_grid, "p_x" . $pessoa_grid->RowIndex . "_idaula") ?>
</span>
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="o<?php echo $pessoa_grid->RowIndex ?>_idaula" id="o<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($pessoa_grid->idaula->getSessionValue() != "") { ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_idaula" class="form-group">
<span<?php echo $pessoa_grid->idaula->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->idaula->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_idaula" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_idaula" data-value-separator="<?php echo $pessoa_grid->idaula->displayValueSeparatorAttribute() ?>" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula"<?php echo $pessoa_grid->idaula->editAttributes() ?>>
			<?php echo $pessoa_grid->idaula->selectOptionListHtml("x{$pessoa_grid->RowIndex}_idaula") ?>
		</select>
</div>
<?php echo $pessoa_grid->idaula->Lookup->getParamTag($pessoa_grid, "p_x" . $pessoa_grid->RowIndex . "_idaula") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_idaula">
<span<?php echo $pessoa_grid->idaula->viewAttributes() ?>><?php echo $pessoa_grid->idaula->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="o<?php echo $pessoa_grid->RowIndex ?>_idaula" id="o<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_idaula" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_idaula" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<?php $pessoa_grid->idpessoa->OldValue = CurrentUserID(); $pessoa_grid->idpessoa->CurrentValue = CurrentUserID(); ?>
<input type="hidden" data-table="pessoa" data-field="x_idpessoa" name="x<?php echo $pessoa_grid->RowIndex ?>_idpessoa" id="x<?php echo $pessoa_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($pessoa_grid->idpessoa->CurrentValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_idpessoa" name="o<?php echo $pessoa_grid->RowIndex ?>_idpessoa" id="o<?php echo $pessoa_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($pessoa_grid->idpessoa->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT || $pessoa->CurrentMode == "edit") { ?>
<?php $pessoa_grid->idpessoa->CurrentValue = CurrentUserID(); ?>
<input type="hidden" data-table="pessoa" data-field="x_idpessoa" name="x<?php echo $pessoa_grid->RowIndex ?>_idpessoa" id="x<?php echo $pessoa_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($pessoa_grid->idpessoa->CurrentValue) ?>">
<?php } ?>
	<?php if ($pessoa_grid->Nome->Visible) { // Nome ?>
		<td data-name="Nome" <?php echo $pessoa_grid->Nome->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Nome" class="form-group">
<input type="text" data-table="pessoa" data-field="x_Nome" name="x<?php echo $pessoa_grid->RowIndex ?>_Nome" id="x<?php echo $pessoa_grid->RowIndex ?>_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->Nome->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->Nome->EditValue ?>"<?php echo $pessoa_grid->Nome->editAttributes() ?>>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="o<?php echo $pessoa_grid->RowIndex ?>_Nome" id="o<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Nome" class="form-group">
<input type="text" data-table="pessoa" data-field="x_Nome" name="x<?php echo $pessoa_grid->RowIndex ?>_Nome" id="x<?php echo $pessoa_grid->RowIndex ?>_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->Nome->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->Nome->EditValue ?>"<?php echo $pessoa_grid->Nome->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Nome">
<span<?php echo $pessoa_grid->Nome->viewAttributes() ?>><?php echo $pessoa_grid->Nome->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="x<?php echo $pessoa_grid->RowIndex ?>_Nome" id="x<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="o<?php echo $pessoa_grid->RowIndex ?>_Nome" id="o<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Nome" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Nome" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->CPF->Visible) { // CPF ?>
		<td data-name="CPF" <?php echo $pessoa_grid->CPF->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_CPF" class="form-group">
<input type="text" data-table="pessoa" data-field="x_CPF" name="x<?php echo $pessoa_grid->RowIndex ?>_CPF" id="x<?php echo $pessoa_grid->RowIndex ?>_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->CPF->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->CPF->EditValue ?>"<?php echo $pessoa_grid->CPF->editAttributes() ?>>
</span>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="o<?php echo $pessoa_grid->RowIndex ?>_CPF" id="o<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_CPF" class="form-group">
<input type="text" data-table="pessoa" data-field="x_CPF" name="x<?php echo $pessoa_grid->RowIndex ?>_CPF" id="x<?php echo $pessoa_grid->RowIndex ?>_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->CPF->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->CPF->EditValue ?>"<?php echo $pessoa_grid->CPF->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_CPF">
<span<?php echo $pessoa_grid->CPF->viewAttributes() ?>><?php echo $pessoa_grid->CPF->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="x<?php echo $pessoa_grid->RowIndex ?>_CPF" id="x<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="o<?php echo $pessoa_grid->RowIndex ?>_CPF" id="o<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_CPF" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_CPF" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Senha->Visible) { // Senha ?>
		<td data-name="Senha" <?php echo $pessoa_grid->Senha->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Senha" class="form-group">
<div class="input-group" id="ig<?php echo $pessoa_grid->RowIndex ?>_Senha">
<input type="password" autocomplete="new-password" data-password-strength="pst<?php echo $pessoa_grid->RowIndex ?>_Senha" data-table="pessoa" data-field="x_Senha" name="x<?php echo $pessoa_grid->RowIndex ?>_Senha" id="x<?php echo $pessoa_grid->RowIndex ?>_Senha" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->Senha->getPlaceHolder()) ?>"<?php echo $pessoa_grid->Senha->editAttributes() ?>>
<div class="input-group-append">
	<button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button>
	<button type="button" class="btn btn-default ew-password-generator" title="<?php echo HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x<?php echo $pessoa_grid->RowIndex ?>_Senha" data-password-confirm="c<?php echo $pessoa_grid->RowIndex ?>_Senha" data-password-strength="pst<?php echo $pessoa_grid->RowIndex ?>_Senha"><?php echo $Language->phrase("GeneratePassword") ?></button>
</div>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst<?php echo $pessoa_grid->RowIndex ?>_Senha">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="o<?php echo $pessoa_grid->RowIndex ?>_Senha" id="o<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Senha" class="form-group">
<div class="input-group" id="ig<?php echo $pessoa_grid->RowIndex ?>_Senha">
<input type="password" autocomplete="new-password" data-password-strength="pst<?php echo $pessoa_grid->RowIndex ?>_Senha" data-table="pessoa" data-field="x_Senha" name="x<?php echo $pessoa_grid->RowIndex ?>_Senha" id="x<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo $pessoa_grid->Senha->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->Senha->getPlaceHolder()) ?>"<?php echo $pessoa_grid->Senha->editAttributes() ?>>
<div class="input-group-append">
	<button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button>
	<button type="button" class="btn btn-default ew-password-generator" title="<?php echo HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x<?php echo $pessoa_grid->RowIndex ?>_Senha" data-password-confirm="c<?php echo $pessoa_grid->RowIndex ?>_Senha" data-password-strength="pst<?php echo $pessoa_grid->RowIndex ?>_Senha"><?php echo $Language->phrase("GeneratePassword") ?></button>
</div>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst<?php echo $pessoa_grid->RowIndex ?>_Senha">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Senha">
<span<?php echo $pessoa_grid->Senha->viewAttributes() ?>><?php echo $pessoa_grid->Senha->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="x<?php echo $pessoa_grid->RowIndex ?>_Senha" id="x<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="o<?php echo $pessoa_grid->RowIndex ?>_Senha" id="o<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Senha" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Senha" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Sexo->Visible) { // Sexo ?>
		<td data-name="Sexo" <?php echo $pessoa_grid->Sexo->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Sexo" class="form-group">
<div id="tp_x<?php echo $pessoa_grid->RowIndex ?>_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-value-separator="<?php echo $pessoa_grid->Sexo->displayValueSeparatorAttribute() ?>" name="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="{value}"<?php echo $pessoa_grid->Sexo->editAttributes() ?>></div>
<div id="dsl_x<?php echo $pessoa_grid->RowIndex ?>_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_grid->Sexo->radioButtonListHtml(FALSE, "x{$pessoa_grid->RowIndex}_Sexo") ?>
</div></div>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="o<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="o<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Sexo" class="form-group">
<div id="tp_x<?php echo $pessoa_grid->RowIndex ?>_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-value-separator="<?php echo $pessoa_grid->Sexo->displayValueSeparatorAttribute() ?>" name="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="{value}"<?php echo $pessoa_grid->Sexo->editAttributes() ?>></div>
<div id="dsl_x<?php echo $pessoa_grid->RowIndex ?>_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_grid->Sexo->radioButtonListHtml(FALSE, "x{$pessoa_grid->RowIndex}_Sexo") ?>
</div></div>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Sexo">
<span<?php echo $pessoa_grid->Sexo->viewAttributes() ?>><?php echo $pessoa_grid->Sexo->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="o<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="o<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->datanascimento->Visible) { // datanascimento ?>
		<td data-name="datanascimento" <?php echo $pessoa_grid->datanascimento->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_datanascimento" class="form-group">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-format="7" name="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_grid->datanascimento->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->datanascimento->EditValue ?>"<?php echo $pessoa_grid->datanascimento->editAttributes() ?>>
<?php if (!$pessoa_grid->datanascimento->ReadOnly && !$pessoa_grid->datanascimento->Disabled && !isset($pessoa_grid->datanascimento->EditAttrs["readonly"]) && !isset($pessoa_grid->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoagrid", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoagrid", "x<?php echo $pessoa_grid->RowIndex ?>_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_datanascimento" class="form-group">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-format="7" name="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_grid->datanascimento->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->datanascimento->EditValue ?>"<?php echo $pessoa_grid->datanascimento->editAttributes() ?>>
<?php if (!$pessoa_grid->datanascimento->ReadOnly && !$pessoa_grid->datanascimento->Disabled && !isset($pessoa_grid->datanascimento->EditAttrs["readonly"]) && !isset($pessoa_grid->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoagrid", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoagrid", "x<?php echo $pessoa_grid->RowIndex ?>_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_datanascimento">
<span<?php echo $pessoa_grid->datanascimento->viewAttributes() ?>><?php echo $pessoa_grid->datanascimento->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Funcao->Visible) { // Funcao ?>
		<td data-name="Funcao" <?php echo $pessoa_grid->Funcao->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Funcao" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Funcao->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Funcao" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_Funcao" data-value-separator="<?php echo $pessoa_grid->Funcao->displayValueSeparatorAttribute() ?>" id="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" name="x<?php echo $pessoa_grid->RowIndex ?>_Funcao"<?php echo $pessoa_grid->Funcao->editAttributes() ?>>
			<?php echo $pessoa_grid->Funcao->selectOptionListHtml("x{$pessoa_grid->RowIndex}_Funcao") ?>
		</select>
</div>
<?php echo $pessoa_grid->Funcao->Lookup->getParamTag($pessoa_grid, "p_x" . $pessoa_grid->RowIndex . "_Funcao") ?>
</span>
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="o<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="o<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Funcao" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Funcao->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Funcao" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_Funcao" data-value-separator="<?php echo $pessoa_grid->Funcao->displayValueSeparatorAttribute() ?>" id="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" name="x<?php echo $pessoa_grid->RowIndex ?>_Funcao"<?php echo $pessoa_grid->Funcao->editAttributes() ?>>
			<?php echo $pessoa_grid->Funcao->selectOptionListHtml("x{$pessoa_grid->RowIndex}_Funcao") ?>
		</select>
</div>
<?php echo $pessoa_grid->Funcao->Lookup->getParamTag($pessoa_grid, "p_x" . $pessoa_grid->RowIndex . "_Funcao") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Funcao">
<span<?php echo $pessoa_grid->Funcao->viewAttributes() ?>><?php echo $pessoa_grid->Funcao->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="o<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="o<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->_Email->Visible) { // Email ?>
		<td data-name="_Email" <?php echo $pessoa_grid->_Email->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa__Email" class="form-group">
<input type="text" data-table="pessoa" data-field="x__Email" name="x<?php echo $pessoa_grid->RowIndex ?>__Email" id="x<?php echo $pessoa_grid->RowIndex ?>__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->_Email->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->_Email->EditValue ?>"<?php echo $pessoa_grid->_Email->editAttributes() ?>>
</span>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="o<?php echo $pessoa_grid->RowIndex ?>__Email" id="o<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa__Email" class="form-group">
<input type="text" data-table="pessoa" data-field="x__Email" name="x<?php echo $pessoa_grid->RowIndex ?>__Email" id="x<?php echo $pessoa_grid->RowIndex ?>__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->_Email->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->_Email->EditValue ?>"<?php echo $pessoa_grid->_Email->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa__Email">
<span<?php echo $pessoa_grid->_Email->viewAttributes() ?>><?php echo $pessoa_grid->_Email->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="x<?php echo $pessoa_grid->RowIndex ?>__Email" id="x<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x__Email" name="o<?php echo $pessoa_grid->RowIndex ?>__Email" id="o<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>__Email" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x__Email" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>__Email" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Ativado->Visible) { // Ativado ?>
		<td data-name="Ativado" <?php echo $pessoa_grid->Ativado->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Ativado" class="form-group">
<div id="tp_x<?php echo $pessoa_grid->RowIndex ?>_Ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Ativado" data-value-separator="<?php echo $pessoa_grid->Ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="{value}"<?php echo $pessoa_grid->Ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $pessoa_grid->RowIndex ?>_Ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_grid->Ativado->radioButtonListHtml(FALSE, "x{$pessoa_grid->RowIndex}_Ativado") ?>
</div></div>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="o<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="o<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Ativado" class="form-group">
<div id="tp_x<?php echo $pessoa_grid->RowIndex ?>_Ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Ativado" data-value-separator="<?php echo $pessoa_grid->Ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="{value}"<?php echo $pessoa_grid->Ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $pessoa_grid->RowIndex ?>_Ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_grid->Ativado->radioButtonListHtml(FALSE, "x{$pessoa_grid->RowIndex}_Ativado") ?>
</div></div>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Ativado">
<span<?php echo $pessoa_grid->Ativado->viewAttributes() ?>><?php echo $pessoa_grid->Ativado->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="o<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="o<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Idade->Visible) { // Idade ?>
		<td data-name="Idade" <?php echo $pessoa_grid->Idade->cellAttributes() ?>>
<?php if ($pessoa->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Idade" class="form-group">
<input type="text" data-table="pessoa" data-field="x_Idade" name="x<?php echo $pessoa_grid->RowIndex ?>_Idade" id="x<?php echo $pessoa_grid->RowIndex ?>_Idade" size="30" maxlength="5" placeholder="<?php echo HtmlEncode($pessoa_grid->Idade->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->Idade->EditValue ?>"<?php echo $pessoa_grid->Idade->editAttributes() ?>>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="o<?php echo $pessoa_grid->RowIndex ?>_Idade" id="o<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->OldValue) ?>">
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Idade" class="form-group">
<input type="text" data-table="pessoa" data-field="x_Idade" name="x<?php echo $pessoa_grid->RowIndex ?>_Idade" id="x<?php echo $pessoa_grid->RowIndex ?>_Idade" size="30" maxlength="5" placeholder="<?php echo HtmlEncode($pessoa_grid->Idade->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->Idade->EditValue ?>"<?php echo $pessoa_grid->Idade->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($pessoa->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $pessoa_grid->RowCount ?>_pessoa_Idade">
<span<?php echo $pessoa_grid->Idade->viewAttributes() ?>><?php echo $pessoa_grid->Idade->getViewValue() ?></span>
</span>
<?php if (!$pessoa->isConfirm()) { ?>
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="x<?php echo $pessoa_grid->RowIndex ?>_Idade" id="x<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="o<?php echo $pessoa_grid->RowIndex ?>_Idade" id="o<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Idade" id="fpessoagrid$x<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->FormValue) ?>">
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Idade" id="fpessoagrid$o<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pessoa_grid->ListOptions->render("body", "right", $pessoa_grid->RowCount);
?>
	</tr>
<?php if ($pessoa->RowType == ROWTYPE_ADD || $pessoa->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fpessoagrid", "load"], function() {
	fpessoagrid.updateLists(<?php echo $pessoa_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$pessoa_grid->isGridAdd() || $pessoa->CurrentMode == "copy")
		if (!$pessoa_grid->Recordset->EOF)
			$pessoa_grid->Recordset->moveNext();
}
?>
<?php
	if ($pessoa->CurrentMode == "add" || $pessoa->CurrentMode == "copy" || $pessoa->CurrentMode == "edit") {
		$pessoa_grid->RowIndex = '$rowindex$';
		$pessoa_grid->loadRowValues();

		// Set row properties
		$pessoa->resetAttributes();
		$pessoa->RowAttrs->merge(["data-rowindex" => $pessoa_grid->RowIndex, "id" => "r0_pessoa", "data-rowtype" => ROWTYPE_ADD]);
		$pessoa->RowAttrs->appendClass("ew-template");
		$pessoa->RowType = ROWTYPE_ADD;

		// Render row
		$pessoa_grid->renderRow();

		// Render list options
		$pessoa_grid->renderListOptions();
		$pessoa_grid->StartRowCount = 0;
?>
	<tr <?php echo $pessoa->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pessoa_grid->ListOptions->render("body", "left", $pessoa_grid->RowIndex);
?>
	<?php if ($pessoa_grid->idaula->Visible) { // idaula ?>
		<td data-name="idaula">
<?php if (!$pessoa->isConfirm()) { ?>
<?php if ($pessoa_grid->idaula->getSessionValue() != "") { ?>
<span id="el$rowindex$_pessoa_idaula" class="form-group pessoa_idaula">
<span<?php echo $pessoa_grid->idaula->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->idaula->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_pessoa_idaula" class="form-group pessoa_idaula">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_idaula" data-value-separator="<?php echo $pessoa_grid->idaula->displayValueSeparatorAttribute() ?>" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula"<?php echo $pessoa_grid->idaula->editAttributes() ?>>
			<?php echo $pessoa_grid->idaula->selectOptionListHtml("x{$pessoa_grid->RowIndex}_idaula") ?>
		</select>
</div>
<?php echo $pessoa_grid->idaula->Lookup->getParamTag($pessoa_grid, "p_x" . $pessoa_grid->RowIndex . "_idaula") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pessoa_idaula" class="form-group pessoa_idaula">
<span<?php echo $pessoa_grid->idaula->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->idaula->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="x<?php echo $pessoa_grid->RowIndex ?>_idaula" id="x<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="o<?php echo $pessoa_grid->RowIndex ?>_idaula" id="o<?php echo $pessoa_grid->RowIndex ?>_idaula" value="<?php echo HtmlEncode($pessoa_grid->idaula->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Nome->Visible) { // Nome ?>
		<td data-name="Nome">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_Nome" class="form-group pessoa_Nome">
<input type="text" data-table="pessoa" data-field="x_Nome" name="x<?php echo $pessoa_grid->RowIndex ?>_Nome" id="x<?php echo $pessoa_grid->RowIndex ?>_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->Nome->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->Nome->EditValue ?>"<?php echo $pessoa_grid->Nome->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Nome" class="form-group pessoa_Nome">
<span<?php echo $pessoa_grid->Nome->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Nome->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="x<?php echo $pessoa_grid->RowIndex ?>_Nome" id="x<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="o<?php echo $pessoa_grid->RowIndex ?>_Nome" id="o<?php echo $pessoa_grid->RowIndex ?>_Nome" value="<?php echo HtmlEncode($pessoa_grid->Nome->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->CPF->Visible) { // CPF ?>
		<td data-name="CPF">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_CPF" class="form-group pessoa_CPF">
<input type="text" data-table="pessoa" data-field="x_CPF" name="x<?php echo $pessoa_grid->RowIndex ?>_CPF" id="x<?php echo $pessoa_grid->RowIndex ?>_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->CPF->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->CPF->EditValue ?>"<?php echo $pessoa_grid->CPF->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_CPF" class="form-group pessoa_CPF">
<span<?php echo $pessoa_grid->CPF->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->CPF->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="x<?php echo $pessoa_grid->RowIndex ?>_CPF" id="x<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="o<?php echo $pessoa_grid->RowIndex ?>_CPF" id="o<?php echo $pessoa_grid->RowIndex ?>_CPF" value="<?php echo HtmlEncode($pessoa_grid->CPF->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Senha->Visible) { // Senha ?>
		<td data-name="Senha">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_Senha" class="form-group pessoa_Senha">
<div class="input-group" id="ig<?php echo $pessoa_grid->RowIndex ?>_Senha">
<input type="password" autocomplete="new-password" data-password-strength="pst<?php echo $pessoa_grid->RowIndex ?>_Senha" data-table="pessoa" data-field="x_Senha" name="x<?php echo $pessoa_grid->RowIndex ?>_Senha" id="x<?php echo $pessoa_grid->RowIndex ?>_Senha" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->Senha->getPlaceHolder()) ?>"<?php echo $pessoa_grid->Senha->editAttributes() ?>>
<div class="input-group-append">
	<button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button>
	<button type="button" class="btn btn-default ew-password-generator" title="<?php echo HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x<?php echo $pessoa_grid->RowIndex ?>_Senha" data-password-confirm="c<?php echo $pessoa_grid->RowIndex ?>_Senha" data-password-strength="pst<?php echo $pessoa_grid->RowIndex ?>_Senha"><?php echo $Language->phrase("GeneratePassword") ?></button>
</div>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst<?php echo $pessoa_grid->RowIndex ?>_Senha">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Senha" class="form-group pessoa_Senha">
<span<?php echo $pessoa_grid->Senha->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Senha->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="x<?php echo $pessoa_grid->RowIndex ?>_Senha" id="x<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="o<?php echo $pessoa_grid->RowIndex ?>_Senha" id="o<?php echo $pessoa_grid->RowIndex ?>_Senha" value="<?php echo HtmlEncode($pessoa_grid->Senha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Sexo->Visible) { // Sexo ?>
		<td data-name="Sexo">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_Sexo" class="form-group pessoa_Sexo">
<div id="tp_x<?php echo $pessoa_grid->RowIndex ?>_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-value-separator="<?php echo $pessoa_grid->Sexo->displayValueSeparatorAttribute() ?>" name="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="{value}"<?php echo $pessoa_grid->Sexo->editAttributes() ?>></div>
<div id="dsl_x<?php echo $pessoa_grid->RowIndex ?>_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_grid->Sexo->radioButtonListHtml(FALSE, "x{$pessoa_grid->RowIndex}_Sexo") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Sexo" class="form-group pessoa_Sexo">
<span<?php echo $pessoa_grid->Sexo->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Sexo->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="x<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="o<?php echo $pessoa_grid->RowIndex ?>_Sexo" id="o<?php echo $pessoa_grid->RowIndex ?>_Sexo" value="<?php echo HtmlEncode($pessoa_grid->Sexo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->datanascimento->Visible) { // datanascimento ?>
		<td data-name="datanascimento">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_datanascimento" class="form-group pessoa_datanascimento">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-format="7" name="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_grid->datanascimento->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->datanascimento->EditValue ?>"<?php echo $pessoa_grid->datanascimento->editAttributes() ?>>
<?php if (!$pessoa_grid->datanascimento->ReadOnly && !$pessoa_grid->datanascimento->Disabled && !isset($pessoa_grid->datanascimento->EditAttrs["readonly"]) && !isset($pessoa_grid->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoagrid", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoagrid", "x<?php echo $pessoa_grid->RowIndex ?>_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_datanascimento" class="form-group pessoa_datanascimento">
<span<?php echo $pessoa_grid->datanascimento->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->datanascimento->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="x<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" id="o<?php echo $pessoa_grid->RowIndex ?>_datanascimento" value="<?php echo HtmlEncode($pessoa_grid->datanascimento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Funcao->Visible) { // Funcao ?>
		<td data-name="Funcao">
<?php if (!$pessoa->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_pessoa_Funcao" class="form-group pessoa_Funcao">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Funcao->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Funcao" class="form-group pessoa_Funcao">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_Funcao" data-value-separator="<?php echo $pessoa_grid->Funcao->displayValueSeparatorAttribute() ?>" id="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" name="x<?php echo $pessoa_grid->RowIndex ?>_Funcao"<?php echo $pessoa_grid->Funcao->editAttributes() ?>>
			<?php echo $pessoa_grid->Funcao->selectOptionListHtml("x{$pessoa_grid->RowIndex}_Funcao") ?>
		</select>
</div>
<?php echo $pessoa_grid->Funcao->Lookup->getParamTag($pessoa_grid, "p_x" . $pessoa_grid->RowIndex . "_Funcao") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Funcao" class="form-group pessoa_Funcao">
<span<?php echo $pessoa_grid->Funcao->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Funcao->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="x<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="o<?php echo $pessoa_grid->RowIndex ?>_Funcao" id="o<?php echo $pessoa_grid->RowIndex ?>_Funcao" value="<?php echo HtmlEncode($pessoa_grid->Funcao->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->_Email->Visible) { // Email ?>
		<td data-name="_Email">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa__Email" class="form-group pessoa__Email">
<input type="text" data-table="pessoa" data-field="x__Email" name="x<?php echo $pessoa_grid->RowIndex ?>__Email" id="x<?php echo $pessoa_grid->RowIndex ?>__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_grid->_Email->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->_Email->EditValue ?>"<?php echo $pessoa_grid->_Email->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa__Email" class="form-group pessoa__Email">
<span<?php echo $pessoa_grid->_Email->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->_Email->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="x<?php echo $pessoa_grid->RowIndex ?>__Email" id="x<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="o<?php echo $pessoa_grid->RowIndex ?>__Email" id="o<?php echo $pessoa_grid->RowIndex ?>__Email" value="<?php echo HtmlEncode($pessoa_grid->_Email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Ativado->Visible) { // Ativado ?>
		<td data-name="Ativado">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_Ativado" class="form-group pessoa_Ativado">
<div id="tp_x<?php echo $pessoa_grid->RowIndex ?>_Ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Ativado" data-value-separator="<?php echo $pessoa_grid->Ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="{value}"<?php echo $pessoa_grid->Ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $pessoa_grid->RowIndex ?>_Ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_grid->Ativado->radioButtonListHtml(FALSE, "x{$pessoa_grid->RowIndex}_Ativado") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Ativado" class="form-group pessoa_Ativado">
<span<?php echo $pessoa_grid->Ativado->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Ativado->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="x<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="o<?php echo $pessoa_grid->RowIndex ?>_Ativado" id="o<?php echo $pessoa_grid->RowIndex ?>_Ativado" value="<?php echo HtmlEncode($pessoa_grid->Ativado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pessoa_grid->Idade->Visible) { // Idade ?>
		<td data-name="Idade">
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el$rowindex$_pessoa_Idade" class="form-group pessoa_Idade">
<input type="text" data-table="pessoa" data-field="x_Idade" name="x<?php echo $pessoa_grid->RowIndex ?>_Idade" id="x<?php echo $pessoa_grid->RowIndex ?>_Idade" size="30" maxlength="5" placeholder="<?php echo HtmlEncode($pessoa_grid->Idade->getPlaceHolder()) ?>" value="<?php echo $pessoa_grid->Idade->EditValue ?>"<?php echo $pessoa_grid->Idade->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_pessoa_Idade" class="form-group pessoa_Idade">
<span<?php echo $pessoa_grid->Idade->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_grid->Idade->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="x<?php echo $pessoa_grid->RowIndex ?>_Idade" id="x<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="o<?php echo $pessoa_grid->RowIndex ?>_Idade" id="o<?php echo $pessoa_grid->RowIndex ?>_Idade" value="<?php echo HtmlEncode($pessoa_grid->Idade->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pessoa_grid->ListOptions->render("body", "right", $pessoa_grid->RowIndex);
?>
<script>
loadjs.ready(["fpessoagrid", "load"], function() {
	fpessoagrid.updateLists(<?php echo $pessoa_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($pessoa->CurrentMode == "add" || $pessoa->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $pessoa_grid->FormKeyCountName ?>" id="<?php echo $pessoa_grid->FormKeyCountName ?>" value="<?php echo $pessoa_grid->KeyCount ?>">
<?php echo $pessoa_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pessoa->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $pessoa_grid->FormKeyCountName ?>" id="<?php echo $pessoa_grid->FormKeyCountName ?>" value="<?php echo $pessoa_grid->KeyCount ?>">
<?php echo $pessoa_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pessoa->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpessoagrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pessoa_grid->Recordset)
	$pessoa_grid->Recordset->Close();
?>
<?php if ($pessoa_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $pessoa_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($pessoa_grid->TotalRecords == 0 && !$pessoa->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $pessoa_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$pessoa_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$pessoa_grid->terminate();
?>