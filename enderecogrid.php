<?php
namespace PHPMaker2020\sistema;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($endereco_grid))
	$endereco_grid = new endereco_grid();

// Run the page
$endereco_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$endereco_grid->Page_Render();
?>
<?php if (!$endereco_grid->isExport()) { ?>
<script>
var fenderecogrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fenderecogrid = new ew.Form("fenderecogrid", "grid");
	fenderecogrid.formKeyCountName = '<?php echo $endereco_grid->FormKeyCountName ?>';

	// Validate form
	fenderecogrid.validate = function() {
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
			<?php if ($endereco_grid->idacademia->Required) { ?>
				elm = this.getElements("x" + infix + "_idacademia");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->idacademia->caption(), $endereco_grid->idacademia->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->idpessoa->Required) { ?>
				elm = this.getElements("x" + infix + "_idpessoa");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->idpessoa->caption(), $endereco_grid->idpessoa->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->CEP->Required) { ?>
				elm = this.getElements("x" + infix + "_CEP");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->CEP->caption(), $endereco_grid->CEP->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->UF->Required) { ?>
				elm = this.getElements("x" + infix + "_UF");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->UF->caption(), $endereco_grid->UF->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->Cidade->Required) { ?>
				elm = this.getElements("x" + infix + "_Cidade");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->Cidade->caption(), $endereco_grid->Cidade->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->Bairro->Required) { ?>
				elm = this.getElements("x" + infix + "_Bairro");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->Bairro->caption(), $endereco_grid->Bairro->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->Rua->Required) { ?>
				elm = this.getElements("x" + infix + "_Rua");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->Rua->caption(), $endereco_grid->Rua->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->Numero->Required) { ?>
				elm = this.getElements("x" + infix + "_Numero");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->Numero->caption(), $endereco_grid->Numero->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_grid->Complemento->Required) { ?>
				elm = this.getElements("x" + infix + "_Complemento");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_grid->Complemento->caption(), $endereco_grid->Complemento->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fenderecogrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idacademia", false)) return false;
		if (ew.valueChanged(fobj, infix, "idpessoa", false)) return false;
		if (ew.valueChanged(fobj, infix, "CEP", false)) return false;
		if (ew.valueChanged(fobj, infix, "UF", false)) return false;
		if (ew.valueChanged(fobj, infix, "Cidade", false)) return false;
		if (ew.valueChanged(fobj, infix, "Bairro", false)) return false;
		if (ew.valueChanged(fobj, infix, "Rua", false)) return false;
		if (ew.valueChanged(fobj, infix, "Numero", false)) return false;
		if (ew.valueChanged(fobj, infix, "Complemento", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fenderecogrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fenderecogrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fenderecogrid.lists["x_idacademia"] = <?php echo $endereco_grid->idacademia->Lookup->toClientList($endereco_grid) ?>;
	fenderecogrid.lists["x_idacademia"].options = <?php echo JsonEncode($endereco_grid->idacademia->lookupOptions()) ?>;
	fenderecogrid.lists["x_idpessoa"] = <?php echo $endereco_grid->idpessoa->Lookup->toClientList($endereco_grid) ?>;
	fenderecogrid.lists["x_idpessoa"].options = <?php echo JsonEncode($endereco_grid->idpessoa->lookupOptions()) ?>;
	loadjs.done("fenderecogrid");
});
</script>
<?php } ?>
<?php
$endereco_grid->renderOtherOptions();
?>
<?php if ($endereco_grid->TotalRecords > 0 || $endereco->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($endereco_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> endereco">
<?php if ($endereco_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $endereco_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fenderecogrid" class="ew-form ew-list-form form-inline">
<div id="gmp_endereco" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_enderecogrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$endereco->RowType = ROWTYPE_HEADER;

// Render list options
$endereco_grid->renderListOptions();

// Render list options (header, left)
$endereco_grid->ListOptions->render("header", "left");
?>
<?php if ($endereco_grid->idacademia->Visible) { // idacademia ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->idacademia) == "") { ?>
		<th data-name="idacademia" class="<?php echo $endereco_grid->idacademia->headerCellClass() ?>"><div id="elh_endereco_idacademia" class="endereco_idacademia"><div class="ew-table-header-caption"><?php echo $endereco_grid->idacademia->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idacademia" class="<?php echo $endereco_grid->idacademia->headerCellClass() ?>"><div><div id="elh_endereco_idacademia" class="endereco_idacademia">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->idacademia->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->idacademia->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->idacademia->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->idpessoa->Visible) { // idpessoa ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->idpessoa) == "") { ?>
		<th data-name="idpessoa" class="<?php echo $endereco_grid->idpessoa->headerCellClass() ?>"><div id="elh_endereco_idpessoa" class="endereco_idpessoa"><div class="ew-table-header-caption"><?php echo $endereco_grid->idpessoa->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpessoa" class="<?php echo $endereco_grid->idpessoa->headerCellClass() ?>"><div><div id="elh_endereco_idpessoa" class="endereco_idpessoa">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->idpessoa->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->idpessoa->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->idpessoa->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->CEP->Visible) { // CEP ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->CEP) == "") { ?>
		<th data-name="CEP" class="<?php echo $endereco_grid->CEP->headerCellClass() ?>"><div id="elh_endereco_CEP" class="endereco_CEP"><div class="ew-table-header-caption"><?php echo $endereco_grid->CEP->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CEP" class="<?php echo $endereco_grid->CEP->headerCellClass() ?>"><div><div id="elh_endereco_CEP" class="endereco_CEP">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->CEP->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->CEP->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->CEP->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->UF->Visible) { // UF ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->UF) == "") { ?>
		<th data-name="UF" class="<?php echo $endereco_grid->UF->headerCellClass() ?>"><div id="elh_endereco_UF" class="endereco_UF"><div class="ew-table-header-caption"><?php echo $endereco_grid->UF->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="UF" class="<?php echo $endereco_grid->UF->headerCellClass() ?>"><div><div id="elh_endereco_UF" class="endereco_UF">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->UF->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->UF->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->UF->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->Cidade->Visible) { // Cidade ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->Cidade) == "") { ?>
		<th data-name="Cidade" class="<?php echo $endereco_grid->Cidade->headerCellClass() ?>"><div id="elh_endereco_Cidade" class="endereco_Cidade"><div class="ew-table-header-caption"><?php echo $endereco_grid->Cidade->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cidade" class="<?php echo $endereco_grid->Cidade->headerCellClass() ?>"><div><div id="elh_endereco_Cidade" class="endereco_Cidade">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->Cidade->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->Cidade->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->Cidade->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->Bairro->Visible) { // Bairro ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->Bairro) == "") { ?>
		<th data-name="Bairro" class="<?php echo $endereco_grid->Bairro->headerCellClass() ?>"><div id="elh_endereco_Bairro" class="endereco_Bairro"><div class="ew-table-header-caption"><?php echo $endereco_grid->Bairro->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bairro" class="<?php echo $endereco_grid->Bairro->headerCellClass() ?>"><div><div id="elh_endereco_Bairro" class="endereco_Bairro">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->Bairro->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->Bairro->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->Bairro->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->Rua->Visible) { // Rua ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->Rua) == "") { ?>
		<th data-name="Rua" class="<?php echo $endereco_grid->Rua->headerCellClass() ?>"><div id="elh_endereco_Rua" class="endereco_Rua"><div class="ew-table-header-caption"><?php echo $endereco_grid->Rua->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rua" class="<?php echo $endereco_grid->Rua->headerCellClass() ?>"><div><div id="elh_endereco_Rua" class="endereco_Rua">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->Rua->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->Rua->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->Rua->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->Numero->Visible) { // Numero ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->Numero) == "") { ?>
		<th data-name="Numero" class="<?php echo $endereco_grid->Numero->headerCellClass() ?>"><div id="elh_endereco_Numero" class="endereco_Numero"><div class="ew-table-header-caption"><?php echo $endereco_grid->Numero->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Numero" class="<?php echo $endereco_grid->Numero->headerCellClass() ?>"><div><div id="elh_endereco_Numero" class="endereco_Numero">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->Numero->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->Numero->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->Numero->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_grid->Complemento->Visible) { // Complemento ?>
	<?php if ($endereco_grid->SortUrl($endereco_grid->Complemento) == "") { ?>
		<th data-name="Complemento" class="<?php echo $endereco_grid->Complemento->headerCellClass() ?>"><div id="elh_endereco_Complemento" class="endereco_Complemento"><div class="ew-table-header-caption"><?php echo $endereco_grid->Complemento->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Complemento" class="<?php echo $endereco_grid->Complemento->headerCellClass() ?>"><div><div id="elh_endereco_Complemento" class="endereco_Complemento">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_grid->Complemento->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_grid->Complemento->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_grid->Complemento->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$endereco_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$endereco_grid->StartRecord = 1;
$endereco_grid->StopRecord = $endereco_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($endereco->isConfirm() || $endereco_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($endereco_grid->FormKeyCountName) && ($endereco_grid->isGridAdd() || $endereco_grid->isGridEdit() || $endereco->isConfirm())) {
		$endereco_grid->KeyCount = $CurrentForm->getValue($endereco_grid->FormKeyCountName);
		$endereco_grid->StopRecord = $endereco_grid->StartRecord + $endereco_grid->KeyCount - 1;
	}
}
$endereco_grid->RecordCount = $endereco_grid->StartRecord - 1;
if ($endereco_grid->Recordset && !$endereco_grid->Recordset->EOF) {
	$endereco_grid->Recordset->moveFirst();
	$selectLimit = $endereco_grid->UseSelectLimit;
	if (!$selectLimit && $endereco_grid->StartRecord > 1)
		$endereco_grid->Recordset->move($endereco_grid->StartRecord - 1);
} elseif (!$endereco->AllowAddDeleteRow && $endereco_grid->StopRecord == 0) {
	$endereco_grid->StopRecord = $endereco->GridAddRowCount;
}

// Initialize aggregate
$endereco->RowType = ROWTYPE_AGGREGATEINIT;
$endereco->resetAttributes();
$endereco_grid->renderRow();
if ($endereco_grid->isGridAdd())
	$endereco_grid->RowIndex = 0;
if ($endereco_grid->isGridEdit())
	$endereco_grid->RowIndex = 0;
while ($endereco_grid->RecordCount < $endereco_grid->StopRecord) {
	$endereco_grid->RecordCount++;
	if ($endereco_grid->RecordCount >= $endereco_grid->StartRecord) {
		$endereco_grid->RowCount++;
		if ($endereco_grid->isGridAdd() || $endereco_grid->isGridEdit() || $endereco->isConfirm()) {
			$endereco_grid->RowIndex++;
			$CurrentForm->Index = $endereco_grid->RowIndex;
			if ($CurrentForm->hasValue($endereco_grid->FormActionName) && ($endereco->isConfirm() || $endereco_grid->EventCancelled))
				$endereco_grid->RowAction = strval($CurrentForm->getValue($endereco_grid->FormActionName));
			elseif ($endereco_grid->isGridAdd())
				$endereco_grid->RowAction = "insert";
			else
				$endereco_grid->RowAction = "";
		}

		// Set up key count
		$endereco_grid->KeyCount = $endereco_grid->RowIndex;

		// Init row class and style
		$endereco->resetAttributes();
		$endereco->CssClass = "";
		if ($endereco_grid->isGridAdd()) {
			if ($endereco->CurrentMode == "copy") {
				$endereco_grid->loadRowValues($endereco_grid->Recordset); // Load row values
				$endereco_grid->setRecordKey($endereco_grid->RowOldKey, $endereco_grid->Recordset); // Set old record key
			} else {
				$endereco_grid->loadRowValues(); // Load default values
				$endereco_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$endereco_grid->loadRowValues($endereco_grid->Recordset); // Load row values
		}
		$endereco->RowType = ROWTYPE_VIEW; // Render view
		if ($endereco_grid->isGridAdd()) // Grid add
			$endereco->RowType = ROWTYPE_ADD; // Render add
		if ($endereco_grid->isGridAdd() && $endereco->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$endereco_grid->restoreCurrentRowFormValues($endereco_grid->RowIndex); // Restore form values
		if ($endereco_grid->isGridEdit()) { // Grid edit
			if ($endereco->EventCancelled)
				$endereco_grid->restoreCurrentRowFormValues($endereco_grid->RowIndex); // Restore form values
			if ($endereco_grid->RowAction == "insert")
				$endereco->RowType = ROWTYPE_ADD; // Render add
			else
				$endereco->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($endereco_grid->isGridEdit() && ($endereco->RowType == ROWTYPE_EDIT || $endereco->RowType == ROWTYPE_ADD) && $endereco->EventCancelled) // Update failed
			$endereco_grid->restoreCurrentRowFormValues($endereco_grid->RowIndex); // Restore form values
		if ($endereco->RowType == ROWTYPE_EDIT) // Edit row
			$endereco_grid->EditRowCount++;
		if ($endereco->isConfirm()) // Confirm row
			$endereco_grid->restoreCurrentRowFormValues($endereco_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$endereco->RowAttrs->merge(["data-rowindex" => $endereco_grid->RowCount, "id" => "r" . $endereco_grid->RowCount . "_endereco", "data-rowtype" => $endereco->RowType]);

		// Render row
		$endereco_grid->renderRow();

		// Render list options
		$endereco_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($endereco_grid->RowAction != "delete" && $endereco_grid->RowAction != "insertdelete" && !($endereco_grid->RowAction == "insert" && $endereco->isConfirm() && $endereco_grid->emptyRow())) {
?>
	<tr <?php echo $endereco->rowAttributes() ?>>
<?php

// Render list options (body, left)
$endereco_grid->ListOptions->render("body", "left", $endereco_grid->RowCount);
?>
	<?php if ($endereco_grid->idacademia->Visible) { // idacademia ?>
		<td data-name="idacademia" <?php echo $endereco_grid->idacademia->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($endereco_grid->idacademia->getSessionValue() != "") { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idacademia" class="form-group">
<span<?php echo $endereco_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idacademia" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="endereco" data-field="x_idacademia" data-value-separator="<?php echo $endereco_grid->idacademia->displayValueSeparatorAttribute() ?>" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia"<?php echo $endereco_grid->idacademia->editAttributes() ?>>
			<?php echo $endereco_grid->idacademia->selectOptionListHtml("x{$endereco_grid->RowIndex}_idacademia") ?>
		</select>
</div>
<?php echo $endereco_grid->idacademia->Lookup->getParamTag($endereco_grid, "p_x" . $endereco_grid->RowIndex . "_idacademia") ?>
</span>
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="o<?php echo $endereco_grid->RowIndex ?>_idacademia" id="o<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($endereco_grid->idacademia->getSessionValue() != "") { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idacademia" class="form-group">
<span<?php echo $endereco_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idacademia" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="endereco" data-field="x_idacademia" data-value-separator="<?php echo $endereco_grid->idacademia->displayValueSeparatorAttribute() ?>" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia"<?php echo $endereco_grid->idacademia->editAttributes() ?>>
			<?php echo $endereco_grid->idacademia->selectOptionListHtml("x{$endereco_grid->RowIndex}_idacademia") ?>
		</select>
</div>
<?php echo $endereco_grid->idacademia->Lookup->getParamTag($endereco_grid, "p_x" . $endereco_grid->RowIndex . "_idacademia") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idacademia">
<span<?php echo $endereco_grid->idacademia->viewAttributes() ?>><?php echo $endereco_grid->idacademia->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="o<?php echo $endereco_grid->RowIndex ?>_idacademia" id="o<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_idacademia" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_idacademia" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="endereco" data-field="x_idendereco" name="x<?php echo $endereco_grid->RowIndex ?>_idendereco" id="x<?php echo $endereco_grid->RowIndex ?>_idendereco" value="<?php echo HtmlEncode($endereco_grid->idendereco->CurrentValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_idendereco" name="o<?php echo $endereco_grid->RowIndex ?>_idendereco" id="o<?php echo $endereco_grid->RowIndex ?>_idendereco" value="<?php echo HtmlEncode($endereco_grid->idendereco->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT || $endereco->CurrentMode == "edit") { ?>
<input type="hidden" data-table="endereco" data-field="x_idendereco" name="x<?php echo $endereco_grid->RowIndex ?>_idendereco" id="x<?php echo $endereco_grid->RowIndex ?>_idendereco" value="<?php echo HtmlEncode($endereco_grid->idendereco->CurrentValue) ?>">
<?php } ?>
	<?php if ($endereco_grid->idpessoa->Visible) { // idpessoa ?>
		<td data-name="idpessoa" <?php echo $endereco_grid->idpessoa->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($endereco_grid->idpessoa->getSessionValue() != "") { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa" class="form-group">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$endereco->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa" class="form-group">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="endereco" data-field="x_idpessoa" data-value-separator="<?php echo $endereco_grid->idpessoa->displayValueSeparatorAttribute() ?>" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa"<?php echo $endereco_grid->idpessoa->editAttributes() ?>>
			<?php echo $endereco_grid->idpessoa->selectOptionListHtml("x{$endereco_grid->RowIndex}_idpessoa") ?>
		</select>
</div>
<?php echo $endereco_grid->idpessoa->Lookup->getParamTag($endereco_grid, "p_x" . $endereco_grid->RowIndex . "_idpessoa") ?>
</span>
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="o<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="o<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($endereco_grid->idpessoa->getSessionValue() != "") { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa" class="form-group">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$endereco->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa" class="form-group">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="endereco" data-field="x_idpessoa" data-value-separator="<?php echo $endereco_grid->idpessoa->displayValueSeparatorAttribute() ?>" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa"<?php echo $endereco_grid->idpessoa->editAttributes() ?>>
			<?php echo $endereco_grid->idpessoa->selectOptionListHtml("x{$endereco_grid->RowIndex}_idpessoa") ?>
		</select>
</div>
<?php echo $endereco_grid->idpessoa->Lookup->getParamTag($endereco_grid, "p_x" . $endereco_grid->RowIndex . "_idpessoa") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_idpessoa">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><?php echo $endereco_grid->idpessoa->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="o<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="o<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->CEP->Visible) { // CEP ?>
		<td data-name="CEP" <?php echo $endereco_grid->CEP->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_CEP" class="form-group">
<input type="text" data-table="endereco" data-field="x_CEP" name="x<?php echo $endereco_grid->RowIndex ?>_CEP" id="x<?php echo $endereco_grid->RowIndex ?>_CEP" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($endereco_grid->CEP->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->CEP->EditValue ?>"<?php echo $endereco_grid->CEP->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_CEP" name="o<?php echo $endereco_grid->RowIndex ?>_CEP" id="o<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_CEP" class="form-group">
<input type="text" data-table="endereco" data-field="x_CEP" name="x<?php echo $endereco_grid->RowIndex ?>_CEP" id="x<?php echo $endereco_grid->RowIndex ?>_CEP" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($endereco_grid->CEP->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->CEP->EditValue ?>"<?php echo $endereco_grid->CEP->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_CEP">
<span<?php echo $endereco_grid->CEP->viewAttributes() ?>><?php echo $endereco_grid->CEP->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_CEP" name="x<?php echo $endereco_grid->RowIndex ?>_CEP" id="x<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_CEP" name="o<?php echo $endereco_grid->RowIndex ?>_CEP" id="o<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_CEP" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_CEP" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_CEP" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_CEP" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->UF->Visible) { // UF ?>
		<td data-name="UF" <?php echo $endereco_grid->UF->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_UF" class="form-group">
<input type="text" data-table="endereco" data-field="x_UF" name="x<?php echo $endereco_grid->RowIndex ?>_UF" id="x<?php echo $endereco_grid->RowIndex ?>_UF" size="30" maxlength="95" placeholder="<?php echo HtmlEncode($endereco_grid->UF->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->UF->EditValue ?>"<?php echo $endereco_grid->UF->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_UF" name="o<?php echo $endereco_grid->RowIndex ?>_UF" id="o<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_UF" class="form-group">
<input type="text" data-table="endereco" data-field="x_UF" name="x<?php echo $endereco_grid->RowIndex ?>_UF" id="x<?php echo $endereco_grid->RowIndex ?>_UF" size="30" maxlength="95" placeholder="<?php echo HtmlEncode($endereco_grid->UF->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->UF->EditValue ?>"<?php echo $endereco_grid->UF->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_UF">
<span<?php echo $endereco_grid->UF->viewAttributes() ?>><?php echo $endereco_grid->UF->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_UF" name="x<?php echo $endereco_grid->RowIndex ?>_UF" id="x<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_UF" name="o<?php echo $endereco_grid->RowIndex ?>_UF" id="o<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_UF" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_UF" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_UF" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_UF" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->Cidade->Visible) { // Cidade ?>
		<td data-name="Cidade" <?php echo $endereco_grid->Cidade->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Cidade" class="form-group">
<input type="text" data-table="endereco" data-field="x_Cidade" name="x<?php echo $endereco_grid->RowIndex ?>_Cidade" id="x<?php echo $endereco_grid->RowIndex ?>_Cidade" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Cidade->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Cidade->EditValue ?>"<?php echo $endereco_grid->Cidade->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="o<?php echo $endereco_grid->RowIndex ?>_Cidade" id="o<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Cidade" class="form-group">
<input type="text" data-table="endereco" data-field="x_Cidade" name="x<?php echo $endereco_grid->RowIndex ?>_Cidade" id="x<?php echo $endereco_grid->RowIndex ?>_Cidade" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Cidade->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Cidade->EditValue ?>"<?php echo $endereco_grid->Cidade->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Cidade">
<span<?php echo $endereco_grid->Cidade->viewAttributes() ?>><?php echo $endereco_grid->Cidade->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="x<?php echo $endereco_grid->RowIndex ?>_Cidade" id="x<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="o<?php echo $endereco_grid->RowIndex ?>_Cidade" id="o<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Cidade" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Cidade" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->Bairro->Visible) { // Bairro ?>
		<td data-name="Bairro" <?php echo $endereco_grid->Bairro->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Bairro" class="form-group">
<input type="text" data-table="endereco" data-field="x_Bairro" name="x<?php echo $endereco_grid->RowIndex ?>_Bairro" id="x<?php echo $endereco_grid->RowIndex ?>_Bairro" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Bairro->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Bairro->EditValue ?>"<?php echo $endereco_grid->Bairro->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="o<?php echo $endereco_grid->RowIndex ?>_Bairro" id="o<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Bairro" class="form-group">
<input type="text" data-table="endereco" data-field="x_Bairro" name="x<?php echo $endereco_grid->RowIndex ?>_Bairro" id="x<?php echo $endereco_grid->RowIndex ?>_Bairro" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Bairro->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Bairro->EditValue ?>"<?php echo $endereco_grid->Bairro->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Bairro">
<span<?php echo $endereco_grid->Bairro->viewAttributes() ?>><?php echo $endereco_grid->Bairro->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="x<?php echo $endereco_grid->RowIndex ?>_Bairro" id="x<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="o<?php echo $endereco_grid->RowIndex ?>_Bairro" id="o<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Bairro" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Bairro" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->Rua->Visible) { // Rua ?>
		<td data-name="Rua" <?php echo $endereco_grid->Rua->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Rua" class="form-group">
<input type="text" data-table="endereco" data-field="x_Rua" name="x<?php echo $endereco_grid->RowIndex ?>_Rua" id="x<?php echo $endereco_grid->RowIndex ?>_Rua" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Rua->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Rua->EditValue ?>"<?php echo $endereco_grid->Rua->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_Rua" name="o<?php echo $endereco_grid->RowIndex ?>_Rua" id="o<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Rua" class="form-group">
<input type="text" data-table="endereco" data-field="x_Rua" name="x<?php echo $endereco_grid->RowIndex ?>_Rua" id="x<?php echo $endereco_grid->RowIndex ?>_Rua" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Rua->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Rua->EditValue ?>"<?php echo $endereco_grid->Rua->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Rua">
<span<?php echo $endereco_grid->Rua->viewAttributes() ?>><?php echo $endereco_grid->Rua->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_Rua" name="x<?php echo $endereco_grid->RowIndex ?>_Rua" id="x<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Rua" name="o<?php echo $endereco_grid->RowIndex ?>_Rua" id="o<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_Rua" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Rua" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Rua" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Rua" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->Numero->Visible) { // Numero ?>
		<td data-name="Numero" <?php echo $endereco_grid->Numero->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Numero" class="form-group">
<input type="text" data-table="endereco" data-field="x_Numero" name="x<?php echo $endereco_grid->RowIndex ?>_Numero" id="x<?php echo $endereco_grid->RowIndex ?>_Numero" size="30" maxlength="25" placeholder="<?php echo HtmlEncode($endereco_grid->Numero->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Numero->EditValue ?>"<?php echo $endereco_grid->Numero->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_Numero" name="o<?php echo $endereco_grid->RowIndex ?>_Numero" id="o<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Numero" class="form-group">
<input type="text" data-table="endereco" data-field="x_Numero" name="x<?php echo $endereco_grid->RowIndex ?>_Numero" id="x<?php echo $endereco_grid->RowIndex ?>_Numero" size="30" maxlength="25" placeholder="<?php echo HtmlEncode($endereco_grid->Numero->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Numero->EditValue ?>"<?php echo $endereco_grid->Numero->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Numero">
<span<?php echo $endereco_grid->Numero->viewAttributes() ?>><?php echo $endereco_grid->Numero->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_Numero" name="x<?php echo $endereco_grid->RowIndex ?>_Numero" id="x<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Numero" name="o<?php echo $endereco_grid->RowIndex ?>_Numero" id="o<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_Numero" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Numero" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Numero" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Numero" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($endereco_grid->Complemento->Visible) { // Complemento ?>
		<td data-name="Complemento" <?php echo $endereco_grid->Complemento->cellAttributes() ?>>
<?php if ($endereco->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Complemento" class="form-group">
<input type="text" data-table="endereco" data-field="x_Complemento" name="x<?php echo $endereco_grid->RowIndex ?>_Complemento" id="x<?php echo $endereco_grid->RowIndex ?>_Complemento" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($endereco_grid->Complemento->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Complemento->EditValue ?>"<?php echo $endereco_grid->Complemento->editAttributes() ?>>
</span>
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="o<?php echo $endereco_grid->RowIndex ?>_Complemento" id="o<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->OldValue) ?>">
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Complemento" class="form-group">
<input type="text" data-table="endereco" data-field="x_Complemento" name="x<?php echo $endereco_grid->RowIndex ?>_Complemento" id="x<?php echo $endereco_grid->RowIndex ?>_Complemento" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($endereco_grid->Complemento->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Complemento->EditValue ?>"<?php echo $endereco_grid->Complemento->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($endereco->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $endereco_grid->RowCount ?>_endereco_Complemento">
<span<?php echo $endereco_grid->Complemento->viewAttributes() ?>><?php echo $endereco_grid->Complemento->getViewValue() ?></span>
</span>
<?php if (!$endereco->isConfirm()) { ?>
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="x<?php echo $endereco_grid->RowIndex ?>_Complemento" id="x<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="o<?php echo $endereco_grid->RowIndex ?>_Complemento" id="o<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Complemento" id="fenderecogrid$x<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->FormValue) ?>">
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Complemento" id="fenderecogrid$o<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$endereco_grid->ListOptions->render("body", "right", $endereco_grid->RowCount);
?>
	</tr>
<?php if ($endereco->RowType == ROWTYPE_ADD || $endereco->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fenderecogrid", "load"], function() {
	fenderecogrid.updateLists(<?php echo $endereco_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$endereco_grid->isGridAdd() || $endereco->CurrentMode == "copy")
		if (!$endereco_grid->Recordset->EOF)
			$endereco_grid->Recordset->moveNext();
}
?>
<?php
	if ($endereco->CurrentMode == "add" || $endereco->CurrentMode == "copy" || $endereco->CurrentMode == "edit") {
		$endereco_grid->RowIndex = '$rowindex$';
		$endereco_grid->loadRowValues();

		// Set row properties
		$endereco->resetAttributes();
		$endereco->RowAttrs->merge(["data-rowindex" => $endereco_grid->RowIndex, "id" => "r0_endereco", "data-rowtype" => ROWTYPE_ADD]);
		$endereco->RowAttrs->appendClass("ew-template");
		$endereco->RowType = ROWTYPE_ADD;

		// Render row
		$endereco_grid->renderRow();

		// Render list options
		$endereco_grid->renderListOptions();
		$endereco_grid->StartRowCount = 0;
?>
	<tr <?php echo $endereco->rowAttributes() ?>>
<?php

// Render list options (body, left)
$endereco_grid->ListOptions->render("body", "left", $endereco_grid->RowIndex);
?>
	<?php if ($endereco_grid->idacademia->Visible) { // idacademia ?>
		<td data-name="idacademia">
<?php if (!$endereco->isConfirm()) { ?>
<?php if ($endereco_grid->idacademia->getSessionValue() != "") { ?>
<span id="el$rowindex$_endereco_idacademia" class="form-group endereco_idacademia">
<span<?php echo $endereco_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_endereco_idacademia" class="form-group endereco_idacademia">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="endereco" data-field="x_idacademia" data-value-separator="<?php echo $endereco_grid->idacademia->displayValueSeparatorAttribute() ?>" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia"<?php echo $endereco_grid->idacademia->editAttributes() ?>>
			<?php echo $endereco_grid->idacademia->selectOptionListHtml("x{$endereco_grid->RowIndex}_idacademia") ?>
		</select>
</div>
<?php echo $endereco_grid->idacademia->Lookup->getParamTag($endereco_grid, "p_x" . $endereco_grid->RowIndex . "_idacademia") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_endereco_idacademia" class="form-group endereco_idacademia">
<span<?php echo $endereco_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="x<?php echo $endereco_grid->RowIndex ?>_idacademia" id="x<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_idacademia" name="o<?php echo $endereco_grid->RowIndex ?>_idacademia" id="o<?php echo $endereco_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($endereco_grid->idacademia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->idpessoa->Visible) { // idpessoa ?>
		<td data-name="idpessoa">
<?php if (!$endereco->isConfirm()) { ?>
<?php if ($endereco_grid->idpessoa->getSessionValue() != "") { ?>
<span id="el$rowindex$_endereco_idpessoa" class="form-group endereco_idpessoa">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$endereco->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_endereco_idpessoa" class="form-group endereco_idpessoa">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_endereco_idpessoa" class="form-group endereco_idpessoa">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="endereco" data-field="x_idpessoa" data-value-separator="<?php echo $endereco_grid->idpessoa->displayValueSeparatorAttribute() ?>" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa"<?php echo $endereco_grid->idpessoa->editAttributes() ?>>
			<?php echo $endereco_grid->idpessoa->selectOptionListHtml("x{$endereco_grid->RowIndex}_idpessoa") ?>
		</select>
</div>
<?php echo $endereco_grid->idpessoa->Lookup->getParamTag($endereco_grid, "p_x" . $endereco_grid->RowIndex . "_idpessoa") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_endereco_idpessoa" class="form-group endereco_idpessoa">
<span<?php echo $endereco_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="x<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_idpessoa" name="o<?php echo $endereco_grid->RowIndex ?>_idpessoa" id="o<?php echo $endereco_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($endereco_grid->idpessoa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->CEP->Visible) { // CEP ?>
		<td data-name="CEP">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_CEP" class="form-group endereco_CEP">
<input type="text" data-table="endereco" data-field="x_CEP" name="x<?php echo $endereco_grid->RowIndex ?>_CEP" id="x<?php echo $endereco_grid->RowIndex ?>_CEP" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($endereco_grid->CEP->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->CEP->EditValue ?>"<?php echo $endereco_grid->CEP->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_CEP" class="form-group endereco_CEP">
<span<?php echo $endereco_grid->CEP->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->CEP->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_CEP" name="x<?php echo $endereco_grid->RowIndex ?>_CEP" id="x<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_CEP" name="o<?php echo $endereco_grid->RowIndex ?>_CEP" id="o<?php echo $endereco_grid->RowIndex ?>_CEP" value="<?php echo HtmlEncode($endereco_grid->CEP->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->UF->Visible) { // UF ?>
		<td data-name="UF">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_UF" class="form-group endereco_UF">
<input type="text" data-table="endereco" data-field="x_UF" name="x<?php echo $endereco_grid->RowIndex ?>_UF" id="x<?php echo $endereco_grid->RowIndex ?>_UF" size="30" maxlength="95" placeholder="<?php echo HtmlEncode($endereco_grid->UF->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->UF->EditValue ?>"<?php echo $endereco_grid->UF->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_UF" class="form-group endereco_UF">
<span<?php echo $endereco_grid->UF->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->UF->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_UF" name="x<?php echo $endereco_grid->RowIndex ?>_UF" id="x<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_UF" name="o<?php echo $endereco_grid->RowIndex ?>_UF" id="o<?php echo $endereco_grid->RowIndex ?>_UF" value="<?php echo HtmlEncode($endereco_grid->UF->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->Cidade->Visible) { // Cidade ?>
		<td data-name="Cidade">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_Cidade" class="form-group endereco_Cidade">
<input type="text" data-table="endereco" data-field="x_Cidade" name="x<?php echo $endereco_grid->RowIndex ?>_Cidade" id="x<?php echo $endereco_grid->RowIndex ?>_Cidade" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Cidade->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Cidade->EditValue ?>"<?php echo $endereco_grid->Cidade->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_Cidade" class="form-group endereco_Cidade">
<span<?php echo $endereco_grid->Cidade->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->Cidade->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="x<?php echo $endereco_grid->RowIndex ?>_Cidade" id="x<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_Cidade" name="o<?php echo $endereco_grid->RowIndex ?>_Cidade" id="o<?php echo $endereco_grid->RowIndex ?>_Cidade" value="<?php echo HtmlEncode($endereco_grid->Cidade->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->Bairro->Visible) { // Bairro ?>
		<td data-name="Bairro">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_Bairro" class="form-group endereco_Bairro">
<input type="text" data-table="endereco" data-field="x_Bairro" name="x<?php echo $endereco_grid->RowIndex ?>_Bairro" id="x<?php echo $endereco_grid->RowIndex ?>_Bairro" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Bairro->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Bairro->EditValue ?>"<?php echo $endereco_grid->Bairro->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_Bairro" class="form-group endereco_Bairro">
<span<?php echo $endereco_grid->Bairro->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->Bairro->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="x<?php echo $endereco_grid->RowIndex ?>_Bairro" id="x<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_Bairro" name="o<?php echo $endereco_grid->RowIndex ?>_Bairro" id="o<?php echo $endereco_grid->RowIndex ?>_Bairro" value="<?php echo HtmlEncode($endereco_grid->Bairro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->Rua->Visible) { // Rua ?>
		<td data-name="Rua">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_Rua" class="form-group endereco_Rua">
<input type="text" data-table="endereco" data-field="x_Rua" name="x<?php echo $endereco_grid->RowIndex ?>_Rua" id="x<?php echo $endereco_grid->RowIndex ?>_Rua" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_grid->Rua->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Rua->EditValue ?>"<?php echo $endereco_grid->Rua->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_Rua" class="form-group endereco_Rua">
<span<?php echo $endereco_grid->Rua->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->Rua->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_Rua" name="x<?php echo $endereco_grid->RowIndex ?>_Rua" id="x<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_Rua" name="o<?php echo $endereco_grid->RowIndex ?>_Rua" id="o<?php echo $endereco_grid->RowIndex ?>_Rua" value="<?php echo HtmlEncode($endereco_grid->Rua->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->Numero->Visible) { // Numero ?>
		<td data-name="Numero">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_Numero" class="form-group endereco_Numero">
<input type="text" data-table="endereco" data-field="x_Numero" name="x<?php echo $endereco_grid->RowIndex ?>_Numero" id="x<?php echo $endereco_grid->RowIndex ?>_Numero" size="30" maxlength="25" placeholder="<?php echo HtmlEncode($endereco_grid->Numero->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Numero->EditValue ?>"<?php echo $endereco_grid->Numero->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_Numero" class="form-group endereco_Numero">
<span<?php echo $endereco_grid->Numero->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->Numero->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_Numero" name="x<?php echo $endereco_grid->RowIndex ?>_Numero" id="x<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_Numero" name="o<?php echo $endereco_grid->RowIndex ?>_Numero" id="o<?php echo $endereco_grid->RowIndex ?>_Numero" value="<?php echo HtmlEncode($endereco_grid->Numero->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($endereco_grid->Complemento->Visible) { // Complemento ?>
		<td data-name="Complemento">
<?php if (!$endereco->isConfirm()) { ?>
<span id="el$rowindex$_endereco_Complemento" class="form-group endereco_Complemento">
<input type="text" data-table="endereco" data-field="x_Complemento" name="x<?php echo $endereco_grid->RowIndex ?>_Complemento" id="x<?php echo $endereco_grid->RowIndex ?>_Complemento" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($endereco_grid->Complemento->getPlaceHolder()) ?>" value="<?php echo $endereco_grid->Complemento->EditValue ?>"<?php echo $endereco_grid->Complemento->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_endereco_Complemento" class="form-group endereco_Complemento">
<span<?php echo $endereco_grid->Complemento->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($endereco_grid->Complemento->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="x<?php echo $endereco_grid->RowIndex ?>_Complemento" id="x<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="endereco" data-field="x_Complemento" name="o<?php echo $endereco_grid->RowIndex ?>_Complemento" id="o<?php echo $endereco_grid->RowIndex ?>_Complemento" value="<?php echo HtmlEncode($endereco_grid->Complemento->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$endereco_grid->ListOptions->render("body", "right", $endereco_grid->RowIndex);
?>
<script>
loadjs.ready(["fenderecogrid", "load"], function() {
	fenderecogrid.updateLists(<?php echo $endereco_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($endereco->CurrentMode == "add" || $endereco->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $endereco_grid->FormKeyCountName ?>" id="<?php echo $endereco_grid->FormKeyCountName ?>" value="<?php echo $endereco_grid->KeyCount ?>">
<?php echo $endereco_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($endereco->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $endereco_grid->FormKeyCountName ?>" id="<?php echo $endereco_grid->FormKeyCountName ?>" value="<?php echo $endereco_grid->KeyCount ?>">
<?php echo $endereco_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($endereco->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fenderecogrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($endereco_grid->Recordset)
	$endereco_grid->Recordset->Close();
?>
<?php if ($endereco_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $endereco_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($endereco_grid->TotalRecords == 0 && !$endereco->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $endereco_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$endereco_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$endereco_grid->terminate();
?>