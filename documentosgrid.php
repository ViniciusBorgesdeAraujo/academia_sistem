<?php
namespace PHPMaker2020\sistema;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($documentos_grid))
	$documentos_grid = new documentos_grid();

// Run the page
$documentos_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documentos_grid->Page_Render();
?>
<?php if (!$documentos_grid->isExport()) { ?>
<script>
var fdocumentosgrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fdocumentosgrid = new ew.Form("fdocumentosgrid", "grid");
	fdocumentosgrid.formKeyCountName = '<?php echo $documentos_grid->FormKeyCountName ?>';

	// Validate form
	fdocumentosgrid.validate = function() {
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
			<?php if ($documentos_grid->idpessoa->Required) { ?>
				elm = this.getElements("x" + infix + "_idpessoa");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_grid->idpessoa->caption(), $documentos_grid->idpessoa->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($documentos_grid->tipo->Required) { ?>
				elm = this.getElements("x" + infix + "_tipo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_grid->tipo->caption(), $documentos_grid->tipo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($documentos_grid->numero->Required) { ?>
				elm = this.getElements("x" + infix + "_numero");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_grid->numero->caption(), $documentos_grid->numero->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fdocumentosgrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idpessoa", false)) return false;
		if (ew.valueChanged(fobj, infix, "tipo", false)) return false;
		if (ew.valueChanged(fobj, infix, "numero", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fdocumentosgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdocumentosgrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdocumentosgrid.lists["x_idpessoa"] = <?php echo $documentos_grid->idpessoa->Lookup->toClientList($documentos_grid) ?>;
	fdocumentosgrid.lists["x_idpessoa"].options = <?php echo JsonEncode($documentos_grid->idpessoa->lookupOptions()) ?>;
	fdocumentosgrid.lists["x_tipo"] = <?php echo $documentos_grid->tipo->Lookup->toClientList($documentos_grid) ?>;
	fdocumentosgrid.lists["x_tipo"].options = <?php echo JsonEncode($documentos_grid->tipo->lookupOptions()) ?>;
	loadjs.done("fdocumentosgrid");
});
</script>
<?php } ?>
<?php
$documentos_grid->renderOtherOptions();
?>
<?php if ($documentos_grid->TotalRecords > 0 || $documentos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($documentos_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> documentos">
<?php if ($documentos_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $documentos_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fdocumentosgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_documentos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_documentosgrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$documentos->RowType = ROWTYPE_HEADER;

// Render list options
$documentos_grid->renderListOptions();

// Render list options (header, left)
$documentos_grid->ListOptions->render("header", "left");
?>
<?php if ($documentos_grid->idpessoa->Visible) { // idpessoa ?>
	<?php if ($documentos_grid->SortUrl($documentos_grid->idpessoa) == "") { ?>
		<th data-name="idpessoa" class="<?php echo $documentos_grid->idpessoa->headerCellClass() ?>"><div id="elh_documentos_idpessoa" class="documentos_idpessoa"><div class="ew-table-header-caption"><?php echo $documentos_grid->idpessoa->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpessoa" class="<?php echo $documentos_grid->idpessoa->headerCellClass() ?>"><div><div id="elh_documentos_idpessoa" class="documentos_idpessoa">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $documentos_grid->idpessoa->caption() ?></span><span class="ew-table-header-sort"><?php if ($documentos_grid->idpessoa->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($documentos_grid->idpessoa->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($documentos_grid->tipo->Visible) { // tipo ?>
	<?php if ($documentos_grid->SortUrl($documentos_grid->tipo) == "") { ?>
		<th data-name="tipo" class="<?php echo $documentos_grid->tipo->headerCellClass() ?>"><div id="elh_documentos_tipo" class="documentos_tipo"><div class="ew-table-header-caption"><?php echo $documentos_grid->tipo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo" class="<?php echo $documentos_grid->tipo->headerCellClass() ?>"><div><div id="elh_documentos_tipo" class="documentos_tipo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $documentos_grid->tipo->caption() ?></span><span class="ew-table-header-sort"><?php if ($documentos_grid->tipo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($documentos_grid->tipo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($documentos_grid->numero->Visible) { // numero ?>
	<?php if ($documentos_grid->SortUrl($documentos_grid->numero) == "") { ?>
		<th data-name="numero" class="<?php echo $documentos_grid->numero->headerCellClass() ?>"><div id="elh_documentos_numero" class="documentos_numero"><div class="ew-table-header-caption"><?php echo $documentos_grid->numero->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero" class="<?php echo $documentos_grid->numero->headerCellClass() ?>"><div><div id="elh_documentos_numero" class="documentos_numero">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $documentos_grid->numero->caption() ?></span><span class="ew-table-header-sort"><?php if ($documentos_grid->numero->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($documentos_grid->numero->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$documentos_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$documentos_grid->StartRecord = 1;
$documentos_grid->StopRecord = $documentos_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($documentos->isConfirm() || $documentos_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($documentos_grid->FormKeyCountName) && ($documentos_grid->isGridAdd() || $documentos_grid->isGridEdit() || $documentos->isConfirm())) {
		$documentos_grid->KeyCount = $CurrentForm->getValue($documentos_grid->FormKeyCountName);
		$documentos_grid->StopRecord = $documentos_grid->StartRecord + $documentos_grid->KeyCount - 1;
	}
}
$documentos_grid->RecordCount = $documentos_grid->StartRecord - 1;
if ($documentos_grid->Recordset && !$documentos_grid->Recordset->EOF) {
	$documentos_grid->Recordset->moveFirst();
	$selectLimit = $documentos_grid->UseSelectLimit;
	if (!$selectLimit && $documentos_grid->StartRecord > 1)
		$documentos_grid->Recordset->move($documentos_grid->StartRecord - 1);
} elseif (!$documentos->AllowAddDeleteRow && $documentos_grid->StopRecord == 0) {
	$documentos_grid->StopRecord = $documentos->GridAddRowCount;
}

// Initialize aggregate
$documentos->RowType = ROWTYPE_AGGREGATEINIT;
$documentos->resetAttributes();
$documentos_grid->renderRow();
if ($documentos_grid->isGridAdd())
	$documentos_grid->RowIndex = 0;
if ($documentos_grid->isGridEdit())
	$documentos_grid->RowIndex = 0;
while ($documentos_grid->RecordCount < $documentos_grid->StopRecord) {
	$documentos_grid->RecordCount++;
	if ($documentos_grid->RecordCount >= $documentos_grid->StartRecord) {
		$documentos_grid->RowCount++;
		if ($documentos_grid->isGridAdd() || $documentos_grid->isGridEdit() || $documentos->isConfirm()) {
			$documentos_grid->RowIndex++;
			$CurrentForm->Index = $documentos_grid->RowIndex;
			if ($CurrentForm->hasValue($documentos_grid->FormActionName) && ($documentos->isConfirm() || $documentos_grid->EventCancelled))
				$documentos_grid->RowAction = strval($CurrentForm->getValue($documentos_grid->FormActionName));
			elseif ($documentos_grid->isGridAdd())
				$documentos_grid->RowAction = "insert";
			else
				$documentos_grid->RowAction = "";
		}

		// Set up key count
		$documentos_grid->KeyCount = $documentos_grid->RowIndex;

		// Init row class and style
		$documentos->resetAttributes();
		$documentos->CssClass = "";
		if ($documentos_grid->isGridAdd()) {
			if ($documentos->CurrentMode == "copy") {
				$documentos_grid->loadRowValues($documentos_grid->Recordset); // Load row values
				$documentos_grid->setRecordKey($documentos_grid->RowOldKey, $documentos_grid->Recordset); // Set old record key
			} else {
				$documentos_grid->loadRowValues(); // Load default values
				$documentos_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$documentos_grid->loadRowValues($documentos_grid->Recordset); // Load row values
		}
		$documentos->RowType = ROWTYPE_VIEW; // Render view
		if ($documentos_grid->isGridAdd()) // Grid add
			$documentos->RowType = ROWTYPE_ADD; // Render add
		if ($documentos_grid->isGridAdd() && $documentos->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$documentos_grid->restoreCurrentRowFormValues($documentos_grid->RowIndex); // Restore form values
		if ($documentos_grid->isGridEdit()) { // Grid edit
			if ($documentos->EventCancelled)
				$documentos_grid->restoreCurrentRowFormValues($documentos_grid->RowIndex); // Restore form values
			if ($documentos_grid->RowAction == "insert")
				$documentos->RowType = ROWTYPE_ADD; // Render add
			else
				$documentos->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($documentos_grid->isGridEdit() && ($documentos->RowType == ROWTYPE_EDIT || $documentos->RowType == ROWTYPE_ADD) && $documentos->EventCancelled) // Update failed
			$documentos_grid->restoreCurrentRowFormValues($documentos_grid->RowIndex); // Restore form values
		if ($documentos->RowType == ROWTYPE_EDIT) // Edit row
			$documentos_grid->EditRowCount++;
		if ($documentos->isConfirm()) // Confirm row
			$documentos_grid->restoreCurrentRowFormValues($documentos_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$documentos->RowAttrs->merge(["data-rowindex" => $documentos_grid->RowCount, "id" => "r" . $documentos_grid->RowCount . "_documentos", "data-rowtype" => $documentos->RowType]);

		// Render row
		$documentos_grid->renderRow();

		// Render list options
		$documentos_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($documentos_grid->RowAction != "delete" && $documentos_grid->RowAction != "insertdelete" && !($documentos_grid->RowAction == "insert" && $documentos->isConfirm() && $documentos_grid->emptyRow())) {
?>
	<tr <?php echo $documentos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$documentos_grid->ListOptions->render("body", "left", $documentos_grid->RowCount);
?>
	<?php if ($documentos_grid->idpessoa->Visible) { // idpessoa ?>
		<td data-name="idpessoa" <?php echo $documentos_grid->idpessoa->cellAttributes() ?>>
<?php if ($documentos->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($documentos_grid->idpessoa->getSessionValue() != "") { ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa" class="form-group">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$documentos->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa" class="form-group">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_idpessoa" data-value-separator="<?php echo $documentos_grid->idpessoa->displayValueSeparatorAttribute() ?>" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa"<?php echo $documentos_grid->idpessoa->editAttributes() ?>>
			<?php echo $documentos_grid->idpessoa->selectOptionListHtml("x{$documentos_grid->RowIndex}_idpessoa") ?>
		</select>
</div>
<?php echo $documentos_grid->idpessoa->Lookup->getParamTag($documentos_grid, "p_x" . $documentos_grid->RowIndex . "_idpessoa") ?>
</span>
<?php } ?>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="o<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="o<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->OldValue) ?>">
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($documentos_grid->idpessoa->getSessionValue() != "") { ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa" class="form-group">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$documentos->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa" class="form-group">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_idpessoa" data-value-separator="<?php echo $documentos_grid->idpessoa->displayValueSeparatorAttribute() ?>" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa"<?php echo $documentos_grid->idpessoa->editAttributes() ?>>
			<?php echo $documentos_grid->idpessoa->selectOptionListHtml("x{$documentos_grid->RowIndex}_idpessoa") ?>
		</select>
</div>
<?php echo $documentos_grid->idpessoa->Lookup->getParamTag($documentos_grid, "p_x" . $documentos_grid->RowIndex . "_idpessoa") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_idpessoa">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><?php echo $documentos_grid->idpessoa->getViewValue() ?></span>
</span>
<?php if (!$documentos->isConfirm()) { ?>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->FormValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="o<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="o<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="fdocumentosgrid$x<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="fdocumentosgrid$x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->FormValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="fdocumentosgrid$o<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="fdocumentosgrid$o<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="documentos" data-field="x_iddocumentos" name="x<?php echo $documentos_grid->RowIndex ?>_iddocumentos" id="x<?php echo $documentos_grid->RowIndex ?>_iddocumentos" value="<?php echo HtmlEncode($documentos_grid->iddocumentos->CurrentValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_iddocumentos" name="o<?php echo $documentos_grid->RowIndex ?>_iddocumentos" id="o<?php echo $documentos_grid->RowIndex ?>_iddocumentos" value="<?php echo HtmlEncode($documentos_grid->iddocumentos->OldValue) ?>">
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_EDIT || $documentos->CurrentMode == "edit") { ?>
<input type="hidden" data-table="documentos" data-field="x_iddocumentos" name="x<?php echo $documentos_grid->RowIndex ?>_iddocumentos" id="x<?php echo $documentos_grid->RowIndex ?>_iddocumentos" value="<?php echo HtmlEncode($documentos_grid->iddocumentos->CurrentValue) ?>">
<?php } ?>
	<?php if ($documentos_grid->tipo->Visible) { // tipo ?>
		<td data-name="tipo" <?php echo $documentos_grid->tipo->cellAttributes() ?>>
<?php if ($documentos->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_tipo" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_tipo" data-value-separator="<?php echo $documentos_grid->tipo->displayValueSeparatorAttribute() ?>" id="x<?php echo $documentos_grid->RowIndex ?>_tipo" name="x<?php echo $documentos_grid->RowIndex ?>_tipo"<?php echo $documentos_grid->tipo->editAttributes() ?>>
			<?php echo $documentos_grid->tipo->selectOptionListHtml("x{$documentos_grid->RowIndex}_tipo") ?>
		</select>
</div>
<?php echo $documentos_grid->tipo->Lookup->getParamTag($documentos_grid, "p_x" . $documentos_grid->RowIndex . "_tipo") ?>
</span>
<input type="hidden" data-table="documentos" data-field="x_tipo" name="o<?php echo $documentos_grid->RowIndex ?>_tipo" id="o<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->OldValue) ?>">
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_tipo" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_tipo" data-value-separator="<?php echo $documentos_grid->tipo->displayValueSeparatorAttribute() ?>" id="x<?php echo $documentos_grid->RowIndex ?>_tipo" name="x<?php echo $documentos_grid->RowIndex ?>_tipo"<?php echo $documentos_grid->tipo->editAttributes() ?>>
			<?php echo $documentos_grid->tipo->selectOptionListHtml("x{$documentos_grid->RowIndex}_tipo") ?>
		</select>
</div>
<?php echo $documentos_grid->tipo->Lookup->getParamTag($documentos_grid, "p_x" . $documentos_grid->RowIndex . "_tipo") ?>
</span>
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_tipo">
<span<?php echo $documentos_grid->tipo->viewAttributes() ?>><?php echo $documentos_grid->tipo->getViewValue() ?></span>
</span>
<?php if (!$documentos->isConfirm()) { ?>
<input type="hidden" data-table="documentos" data-field="x_tipo" name="x<?php echo $documentos_grid->RowIndex ?>_tipo" id="x<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->FormValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_tipo" name="o<?php echo $documentos_grid->RowIndex ?>_tipo" id="o<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="documentos" data-field="x_tipo" name="fdocumentosgrid$x<?php echo $documentos_grid->RowIndex ?>_tipo" id="fdocumentosgrid$x<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->FormValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_tipo" name="fdocumentosgrid$o<?php echo $documentos_grid->RowIndex ?>_tipo" id="fdocumentosgrid$o<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documentos_grid->numero->Visible) { // numero ?>
		<td data-name="numero" <?php echo $documentos_grid->numero->cellAttributes() ?>>
<?php if ($documentos->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_numero" class="form-group">
<input type="text" data-table="documentos" data-field="x_numero" name="x<?php echo $documentos_grid->RowIndex ?>_numero" id="x<?php echo $documentos_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($documentos_grid->numero->getPlaceHolder()) ?>" value="<?php echo $documentos_grid->numero->EditValue ?>"<?php echo $documentos_grid->numero->editAttributes() ?>>
</span>
<input type="hidden" data-table="documentos" data-field="x_numero" name="o<?php echo $documentos_grid->RowIndex ?>_numero" id="o<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->OldValue) ?>">
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_numero" class="form-group">
<input type="text" data-table="documentos" data-field="x_numero" name="x<?php echo $documentos_grid->RowIndex ?>_numero" id="x<?php echo $documentos_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($documentos_grid->numero->getPlaceHolder()) ?>" value="<?php echo $documentos_grid->numero->EditValue ?>"<?php echo $documentos_grid->numero->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($documentos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documentos_grid->RowCount ?>_documentos_numero">
<span<?php echo $documentos_grid->numero->viewAttributes() ?>><?php echo $documentos_grid->numero->getViewValue() ?></span>
</span>
<?php if (!$documentos->isConfirm()) { ?>
<input type="hidden" data-table="documentos" data-field="x_numero" name="x<?php echo $documentos_grid->RowIndex ?>_numero" id="x<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->FormValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_numero" name="o<?php echo $documentos_grid->RowIndex ?>_numero" id="o<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="documentos" data-field="x_numero" name="fdocumentosgrid$x<?php echo $documentos_grid->RowIndex ?>_numero" id="fdocumentosgrid$x<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->FormValue) ?>">
<input type="hidden" data-table="documentos" data-field="x_numero" name="fdocumentosgrid$o<?php echo $documentos_grid->RowIndex ?>_numero" id="fdocumentosgrid$o<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documentos_grid->ListOptions->render("body", "right", $documentos_grid->RowCount);
?>
	</tr>
<?php if ($documentos->RowType == ROWTYPE_ADD || $documentos->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fdocumentosgrid", "load"], function() {
	fdocumentosgrid.updateLists(<?php echo $documentos_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$documentos_grid->isGridAdd() || $documentos->CurrentMode == "copy")
		if (!$documentos_grid->Recordset->EOF)
			$documentos_grid->Recordset->moveNext();
}
?>
<?php
	if ($documentos->CurrentMode == "add" || $documentos->CurrentMode == "copy" || $documentos->CurrentMode == "edit") {
		$documentos_grid->RowIndex = '$rowindex$';
		$documentos_grid->loadRowValues();

		// Set row properties
		$documentos->resetAttributes();
		$documentos->RowAttrs->merge(["data-rowindex" => $documentos_grid->RowIndex, "id" => "r0_documentos", "data-rowtype" => ROWTYPE_ADD]);
		$documentos->RowAttrs->appendClass("ew-template");
		$documentos->RowType = ROWTYPE_ADD;

		// Render row
		$documentos_grid->renderRow();

		// Render list options
		$documentos_grid->renderListOptions();
		$documentos_grid->StartRowCount = 0;
?>
	<tr <?php echo $documentos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$documentos_grid->ListOptions->render("body", "left", $documentos_grid->RowIndex);
?>
	<?php if ($documentos_grid->idpessoa->Visible) { // idpessoa ?>
		<td data-name="idpessoa">
<?php if (!$documentos->isConfirm()) { ?>
<?php if ($documentos_grid->idpessoa->getSessionValue() != "") { ?>
<span id="el$rowindex$_documentos_idpessoa" class="form-group documentos_idpessoa">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$documentos->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_documentos_idpessoa" class="form-group documentos_idpessoa">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_documentos_idpessoa" class="form-group documentos_idpessoa">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_idpessoa" data-value-separator="<?php echo $documentos_grid->idpessoa->displayValueSeparatorAttribute() ?>" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa"<?php echo $documentos_grid->idpessoa->editAttributes() ?>>
			<?php echo $documentos_grid->idpessoa->selectOptionListHtml("x{$documentos_grid->RowIndex}_idpessoa") ?>
		</select>
</div>
<?php echo $documentos_grid->idpessoa->Lookup->getParamTag($documentos_grid, "p_x" . $documentos_grid->RowIndex . "_idpessoa") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_documentos_idpessoa" class="form-group documentos_idpessoa">
<span<?php echo $documentos_grid->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="x<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="o<?php echo $documentos_grid->RowIndex ?>_idpessoa" id="o<?php echo $documentos_grid->RowIndex ?>_idpessoa" value="<?php echo HtmlEncode($documentos_grid->idpessoa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documentos_grid->tipo->Visible) { // tipo ?>
		<td data-name="tipo">
<?php if (!$documentos->isConfirm()) { ?>
<span id="el$rowindex$_documentos_tipo" class="form-group documentos_tipo">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_tipo" data-value-separator="<?php echo $documentos_grid->tipo->displayValueSeparatorAttribute() ?>" id="x<?php echo $documentos_grid->RowIndex ?>_tipo" name="x<?php echo $documentos_grid->RowIndex ?>_tipo"<?php echo $documentos_grid->tipo->editAttributes() ?>>
			<?php echo $documentos_grid->tipo->selectOptionListHtml("x{$documentos_grid->RowIndex}_tipo") ?>
		</select>
</div>
<?php echo $documentos_grid->tipo->Lookup->getParamTag($documentos_grid, "p_x" . $documentos_grid->RowIndex . "_tipo") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_documentos_tipo" class="form-group documentos_tipo">
<span<?php echo $documentos_grid->tipo->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->tipo->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_tipo" name="x<?php echo $documentos_grid->RowIndex ?>_tipo" id="x<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documentos" data-field="x_tipo" name="o<?php echo $documentos_grid->RowIndex ?>_tipo" id="o<?php echo $documentos_grid->RowIndex ?>_tipo" value="<?php echo HtmlEncode($documentos_grid->tipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documentos_grid->numero->Visible) { // numero ?>
		<td data-name="numero">
<?php if (!$documentos->isConfirm()) { ?>
<span id="el$rowindex$_documentos_numero" class="form-group documentos_numero">
<input type="text" data-table="documentos" data-field="x_numero" name="x<?php echo $documentos_grid->RowIndex ?>_numero" id="x<?php echo $documentos_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($documentos_grid->numero->getPlaceHolder()) ?>" value="<?php echo $documentos_grid->numero->EditValue ?>"<?php echo $documentos_grid->numero->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documentos_numero" class="form-group documentos_numero">
<span<?php echo $documentos_grid->numero->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_grid->numero->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_numero" name="x<?php echo $documentos_grid->RowIndex ?>_numero" id="x<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documentos" data-field="x_numero" name="o<?php echo $documentos_grid->RowIndex ?>_numero" id="o<?php echo $documentos_grid->RowIndex ?>_numero" value="<?php echo HtmlEncode($documentos_grid->numero->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documentos_grid->ListOptions->render("body", "right", $documentos_grid->RowIndex);
?>
<script>
loadjs.ready(["fdocumentosgrid", "load"], function() {
	fdocumentosgrid.updateLists(<?php echo $documentos_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($documentos->CurrentMode == "add" || $documentos->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $documentos_grid->FormKeyCountName ?>" id="<?php echo $documentos_grid->FormKeyCountName ?>" value="<?php echo $documentos_grid->KeyCount ?>">
<?php echo $documentos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documentos->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $documentos_grid->FormKeyCountName ?>" id="<?php echo $documentos_grid->FormKeyCountName ?>" value="<?php echo $documentos_grid->KeyCount ?>">
<?php echo $documentos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documentos->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdocumentosgrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($documentos_grid->Recordset)
	$documentos_grid->Recordset->Close();
?>
<?php if ($documentos_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $documentos_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($documentos_grid->TotalRecords == 0 && !$documentos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $documentos_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$documentos_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$documentos_grid->terminate();
?>