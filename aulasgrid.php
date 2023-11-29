<?php
namespace PHPMaker2020\sistema;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($aulas_grid))
	$aulas_grid = new aulas_grid();

// Run the page
$aulas_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$aulas_grid->Page_Render();
?>
<?php if (!$aulas_grid->isExport()) { ?>
<script>
var faulasgrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	faulasgrid = new ew.Form("faulasgrid", "grid");
	faulasgrid.formKeyCountName = '<?php echo $aulas_grid->FormKeyCountName ?>';

	// Validate form
	faulasgrid.validate = function() {
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
			<?php if ($aulas_grid->idturnos->Required) { ?>
				elm = this.getElements("x" + infix + "_idturnos");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_grid->idturnos->caption(), $aulas_grid->idturnos->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_grid->idaluno->Required) { ?>
				elm = this.getElements("x" + infix + "_idaluno");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_grid->idaluno->caption(), $aulas_grid->idaluno->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_grid->nome->Required) { ?>
				elm = this.getElements("x" + infix + "_nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_grid->nome->caption(), $aulas_grid->nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_grid->ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_grid->ativado->caption(), $aulas_grid->ativado->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	faulasgrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idturnos", false)) return false;
		if (ew.valueChanged(fobj, infix, "idaluno", false)) return false;
		if (ew.valueChanged(fobj, infix, "nome", false)) return false;
		if (ew.valueChanged(fobj, infix, "ativado", false)) return false;
		return true;
	}

	// Form_CustomValidate
	faulasgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	faulasgrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	faulasgrid.lists["x_idturnos"] = <?php echo $aulas_grid->idturnos->Lookup->toClientList($aulas_grid) ?>;
	faulasgrid.lists["x_idturnos"].options = <?php echo JsonEncode($aulas_grid->idturnos->lookupOptions()) ?>;
	faulasgrid.lists["x_idaluno"] = <?php echo $aulas_grid->idaluno->Lookup->toClientList($aulas_grid) ?>;
	faulasgrid.lists["x_idaluno"].options = <?php echo JsonEncode($aulas_grid->idaluno->lookupOptions()) ?>;
	faulasgrid.lists["x_nome"] = <?php echo $aulas_grid->nome->Lookup->toClientList($aulas_grid) ?>;
	faulasgrid.lists["x_nome"].options = <?php echo JsonEncode($aulas_grid->nome->lookupOptions()) ?>;
	faulasgrid.lists["x_ativado"] = <?php echo $aulas_grid->ativado->Lookup->toClientList($aulas_grid) ?>;
	faulasgrid.lists["x_ativado"].options = <?php echo JsonEncode($aulas_grid->ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("faulasgrid");
});
</script>
<?php } ?>
<?php
$aulas_grid->renderOtherOptions();
?>
<?php if ($aulas_grid->TotalRecords > 0 || $aulas->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($aulas_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> aulas">
<?php if ($aulas_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $aulas_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="faulasgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_aulas" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_aulasgrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$aulas->RowType = ROWTYPE_HEADER;

// Render list options
$aulas_grid->renderListOptions();

// Render list options (header, left)
$aulas_grid->ListOptions->render("header", "left");
?>
<?php if ($aulas_grid->idturnos->Visible) { // idturnos ?>
	<?php if ($aulas_grid->SortUrl($aulas_grid->idturnos) == "") { ?>
		<th data-name="idturnos" class="<?php echo $aulas_grid->idturnos->headerCellClass() ?>"><div id="elh_aulas_idturnos" class="aulas_idturnos"><div class="ew-table-header-caption"><?php echo $aulas_grid->idturnos->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idturnos" class="<?php echo $aulas_grid->idturnos->headerCellClass() ?>"><div><div id="elh_aulas_idturnos" class="aulas_idturnos">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_grid->idturnos->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_grid->idturnos->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_grid->idturnos->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($aulas_grid->idaluno->Visible) { // idaluno ?>
	<?php if ($aulas_grid->SortUrl($aulas_grid->idaluno) == "") { ?>
		<th data-name="idaluno" class="<?php echo $aulas_grid->idaluno->headerCellClass() ?>"><div id="elh_aulas_idaluno" class="aulas_idaluno"><div class="ew-table-header-caption"><?php echo $aulas_grid->idaluno->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idaluno" class="<?php echo $aulas_grid->idaluno->headerCellClass() ?>"><div><div id="elh_aulas_idaluno" class="aulas_idaluno">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_grid->idaluno->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_grid->idaluno->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_grid->idaluno->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($aulas_grid->nome->Visible) { // nome ?>
	<?php if ($aulas_grid->SortUrl($aulas_grid->nome) == "") { ?>
		<th data-name="nome" class="<?php echo $aulas_grid->nome->headerCellClass() ?>"><div id="elh_aulas_nome" class="aulas_nome"><div class="ew-table-header-caption"><?php echo $aulas_grid->nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome" class="<?php echo $aulas_grid->nome->headerCellClass() ?>"><div><div id="elh_aulas_nome" class="aulas_nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_grid->nome->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_grid->nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_grid->nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($aulas_grid->ativado->Visible) { // ativado ?>
	<?php if ($aulas_grid->SortUrl($aulas_grid->ativado) == "") { ?>
		<th data-name="ativado" class="<?php echo $aulas_grid->ativado->headerCellClass() ?>"><div id="elh_aulas_ativado" class="aulas_ativado"><div class="ew-table-header-caption"><?php echo $aulas_grid->ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativado" class="<?php echo $aulas_grid->ativado->headerCellClass() ?>"><div><div id="elh_aulas_ativado" class="aulas_ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_grid->ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_grid->ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_grid->ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$aulas_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$aulas_grid->StartRecord = 1;
$aulas_grid->StopRecord = $aulas_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($aulas->isConfirm() || $aulas_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($aulas_grid->FormKeyCountName) && ($aulas_grid->isGridAdd() || $aulas_grid->isGridEdit() || $aulas->isConfirm())) {
		$aulas_grid->KeyCount = $CurrentForm->getValue($aulas_grid->FormKeyCountName);
		$aulas_grid->StopRecord = $aulas_grid->StartRecord + $aulas_grid->KeyCount - 1;
	}
}
$aulas_grid->RecordCount = $aulas_grid->StartRecord - 1;
if ($aulas_grid->Recordset && !$aulas_grid->Recordset->EOF) {
	$aulas_grid->Recordset->moveFirst();
	$selectLimit = $aulas_grid->UseSelectLimit;
	if (!$selectLimit && $aulas_grid->StartRecord > 1)
		$aulas_grid->Recordset->move($aulas_grid->StartRecord - 1);
} elseif (!$aulas->AllowAddDeleteRow && $aulas_grid->StopRecord == 0) {
	$aulas_grid->StopRecord = $aulas->GridAddRowCount;
}

// Initialize aggregate
$aulas->RowType = ROWTYPE_AGGREGATEINIT;
$aulas->resetAttributes();
$aulas_grid->renderRow();
if ($aulas_grid->isGridAdd())
	$aulas_grid->RowIndex = 0;
if ($aulas_grid->isGridEdit())
	$aulas_grid->RowIndex = 0;
while ($aulas_grid->RecordCount < $aulas_grid->StopRecord) {
	$aulas_grid->RecordCount++;
	if ($aulas_grid->RecordCount >= $aulas_grid->StartRecord) {
		$aulas_grid->RowCount++;
		if ($aulas_grid->isGridAdd() || $aulas_grid->isGridEdit() || $aulas->isConfirm()) {
			$aulas_grid->RowIndex++;
			$CurrentForm->Index = $aulas_grid->RowIndex;
			if ($CurrentForm->hasValue($aulas_grid->FormActionName) && ($aulas->isConfirm() || $aulas_grid->EventCancelled))
				$aulas_grid->RowAction = strval($CurrentForm->getValue($aulas_grid->FormActionName));
			elseif ($aulas_grid->isGridAdd())
				$aulas_grid->RowAction = "insert";
			else
				$aulas_grid->RowAction = "";
		}

		// Set up key count
		$aulas_grid->KeyCount = $aulas_grid->RowIndex;

		// Init row class and style
		$aulas->resetAttributes();
		$aulas->CssClass = "";
		if ($aulas_grid->isGridAdd()) {
			if ($aulas->CurrentMode == "copy") {
				$aulas_grid->loadRowValues($aulas_grid->Recordset); // Load row values
				$aulas_grid->setRecordKey($aulas_grid->RowOldKey, $aulas_grid->Recordset); // Set old record key
			} else {
				$aulas_grid->loadRowValues(); // Load default values
				$aulas_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$aulas_grid->loadRowValues($aulas_grid->Recordset); // Load row values
		}
		$aulas->RowType = ROWTYPE_VIEW; // Render view
		if ($aulas_grid->isGridAdd()) // Grid add
			$aulas->RowType = ROWTYPE_ADD; // Render add
		if ($aulas_grid->isGridAdd() && $aulas->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$aulas_grid->restoreCurrentRowFormValues($aulas_grid->RowIndex); // Restore form values
		if ($aulas_grid->isGridEdit()) { // Grid edit
			if ($aulas->EventCancelled)
				$aulas_grid->restoreCurrentRowFormValues($aulas_grid->RowIndex); // Restore form values
			if ($aulas_grid->RowAction == "insert")
				$aulas->RowType = ROWTYPE_ADD; // Render add
			else
				$aulas->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($aulas_grid->isGridEdit() && ($aulas->RowType == ROWTYPE_EDIT || $aulas->RowType == ROWTYPE_ADD) && $aulas->EventCancelled) // Update failed
			$aulas_grid->restoreCurrentRowFormValues($aulas_grid->RowIndex); // Restore form values
		if ($aulas->RowType == ROWTYPE_EDIT) // Edit row
			$aulas_grid->EditRowCount++;
		if ($aulas->isConfirm()) // Confirm row
			$aulas_grid->restoreCurrentRowFormValues($aulas_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$aulas->RowAttrs->merge(["data-rowindex" => $aulas_grid->RowCount, "id" => "r" . $aulas_grid->RowCount . "_aulas", "data-rowtype" => $aulas->RowType]);

		// Render row
		$aulas_grid->renderRow();

		// Render list options
		$aulas_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($aulas_grid->RowAction != "delete" && $aulas_grid->RowAction != "insertdelete" && !($aulas_grid->RowAction == "insert" && $aulas->isConfirm() && $aulas_grid->emptyRow())) {
?>
	<tr <?php echo $aulas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$aulas_grid->ListOptions->render("body", "left", $aulas_grid->RowCount);
?>
	<?php if ($aulas_grid->idturnos->Visible) { // idturnos ?>
		<td data-name="idturnos" <?php echo $aulas_grid->idturnos->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($aulas_grid->idturnos->getSessionValue() != "") { ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idturnos" class="form-group">
<span<?php echo $aulas_grid->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idturnos" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_grid->idturnos->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos"<?php echo $aulas_grid->idturnos->editAttributes() ?>>
			<?php echo $aulas_grid->idturnos->selectOptionListHtml("x{$aulas_grid->RowIndex}_idturnos") ?>
		</select>
</div>
<?php echo $aulas_grid->idturnos->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_idturnos") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="o<?php echo $aulas_grid->RowIndex ?>_idturnos" id="o<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($aulas_grid->idturnos->getSessionValue() != "") { ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idturnos" class="form-group">
<span<?php echo $aulas_grid->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idturnos" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_grid->idturnos->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos"<?php echo $aulas_grid->idturnos->editAttributes() ?>>
			<?php echo $aulas_grid->idturnos->selectOptionListHtml("x{$aulas_grid->RowIndex}_idturnos") ?>
		</select>
</div>
<?php echo $aulas_grid->idturnos->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_idturnos") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idturnos">
<span<?php echo $aulas_grid->idturnos->viewAttributes() ?>><?php echo $aulas_grid->idturnos->getViewValue() ?></span>
</span>
<?php if (!$aulas->isConfirm()) { ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="o<?php echo $aulas_grid->RowIndex ?>_idturnos" id="o<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_idturnos" id="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_idturnos" id="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="aulas" data-field="x_idaulas" name="x<?php echo $aulas_grid->RowIndex ?>_idaulas" id="x<?php echo $aulas_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($aulas_grid->idaulas->CurrentValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_idaulas" name="o<?php echo $aulas_grid->RowIndex ?>_idaulas" id="o<?php echo $aulas_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($aulas_grid->idaulas->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_EDIT || $aulas->CurrentMode == "edit") { ?>
<input type="hidden" data-table="aulas" data-field="x_idaulas" name="x<?php echo $aulas_grid->RowIndex ?>_idaulas" id="x<?php echo $aulas_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($aulas_grid->idaulas->CurrentValue) ?>">
<?php } ?>
	<?php if ($aulas_grid->idaluno->Visible) { // idaluno ?>
		<td data-name="idaluno" <?php echo $aulas_grid->idaluno->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idaluno" class="form-group">
<span<?php echo $aulas_grid->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idaluno" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_grid->idaluno->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno"<?php echo $aulas_grid->idaluno->editAttributes() ?>>
			<?php echo $aulas_grid->idaluno->selectOptionListHtml("x{$aulas_grid->RowIndex}_idaluno") ?>
		</select>
</div>
<?php echo $aulas_grid->idaluno->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_idaluno") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="o<?php echo $aulas_grid->RowIndex ?>_idaluno" id="o<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idaluno" class="form-group">
<span<?php echo $aulas_grid->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idaluno" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_grid->idaluno->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno"<?php echo $aulas_grid->idaluno->editAttributes() ?>>
			<?php echo $aulas_grid->idaluno->selectOptionListHtml("x{$aulas_grid->RowIndex}_idaluno") ?>
		</select>
</div>
<?php echo $aulas_grid->idaluno->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_idaluno") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_idaluno">
<span<?php echo $aulas_grid->idaluno->viewAttributes() ?>><?php echo $aulas_grid->idaluno->getViewValue() ?></span>
</span>
<?php if (!$aulas->isConfirm()) { ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="o<?php echo $aulas_grid->RowIndex ?>_idaluno" id="o<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_idaluno" id="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_idaluno" id="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($aulas_grid->nome->Visible) { // nome ?>
		<td data-name="nome" <?php echo $aulas_grid->nome->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_nome" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_grid->nome->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_nome" name="x<?php echo $aulas_grid->RowIndex ?>_nome"<?php echo $aulas_grid->nome->editAttributes() ?>>
			<?php echo $aulas_grid->nome->selectOptionListHtml("x{$aulas_grid->RowIndex}_nome") ?>
		</select>
</div>
<?php echo $aulas_grid->nome->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_nome") ?>
</span>
<input type="hidden" data-table="aulas" data-field="x_nome" name="o<?php echo $aulas_grid->RowIndex ?>_nome" id="o<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_nome" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_grid->nome->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_nome" name="x<?php echo $aulas_grid->RowIndex ?>_nome"<?php echo $aulas_grid->nome->editAttributes() ?>>
			<?php echo $aulas_grid->nome->selectOptionListHtml("x{$aulas_grid->RowIndex}_nome") ?>
		</select>
</div>
<?php echo $aulas_grid->nome->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_nome") ?>
</span>
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_nome">
<span<?php echo $aulas_grid->nome->viewAttributes() ?>><?php echo $aulas_grid->nome->getViewValue() ?></span>
</span>
<?php if (!$aulas->isConfirm()) { ?>
<input type="hidden" data-table="aulas" data-field="x_nome" name="x<?php echo $aulas_grid->RowIndex ?>_nome" id="x<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_nome" name="o<?php echo $aulas_grid->RowIndex ?>_nome" id="o<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="aulas" data-field="x_nome" name="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_nome" id="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_nome" name="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_nome" id="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($aulas_grid->ativado->Visible) { // ativado ?>
		<td data-name="ativado" <?php echo $aulas_grid->ativado->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_ativado" class="form-group">
<div id="tp_x<?php echo $aulas_grid->RowIndex ?>_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_grid->ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $aulas_grid->RowIndex ?>_ativado" id="x<?php echo $aulas_grid->RowIndex ?>_ativado" value="{value}"<?php echo $aulas_grid->ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $aulas_grid->RowIndex ?>_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_grid->ativado->radioButtonListHtml(FALSE, "x{$aulas_grid->RowIndex}_ativado") ?>
</div></div>
</span>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="o<?php echo $aulas_grid->RowIndex ?>_ativado" id="o<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_ativado" class="form-group">
<div id="tp_x<?php echo $aulas_grid->RowIndex ?>_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_grid->ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $aulas_grid->RowIndex ?>_ativado" id="x<?php echo $aulas_grid->RowIndex ?>_ativado" value="{value}"<?php echo $aulas_grid->ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $aulas_grid->RowIndex ?>_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_grid->ativado->radioButtonListHtml(FALSE, "x{$aulas_grid->RowIndex}_ativado") ?>
</div></div>
</span>
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_grid->RowCount ?>_aulas_ativado">
<span<?php echo $aulas_grid->ativado->viewAttributes() ?>><?php echo $aulas_grid->ativado->getViewValue() ?></span>
</span>
<?php if (!$aulas->isConfirm()) { ?>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="x<?php echo $aulas_grid->RowIndex ?>_ativado" id="x<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_ativado" name="o<?php echo $aulas_grid->RowIndex ?>_ativado" id="o<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_ativado" id="faulasgrid$x<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->FormValue) ?>">
<input type="hidden" data-table="aulas" data-field="x_ativado" name="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_ativado" id="faulasgrid$o<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$aulas_grid->ListOptions->render("body", "right", $aulas_grid->RowCount);
?>
	</tr>
<?php if ($aulas->RowType == ROWTYPE_ADD || $aulas->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["faulasgrid", "load"], function() {
	faulasgrid.updateLists(<?php echo $aulas_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$aulas_grid->isGridAdd() || $aulas->CurrentMode == "copy")
		if (!$aulas_grid->Recordset->EOF)
			$aulas_grid->Recordset->moveNext();
}
?>
<?php
	if ($aulas->CurrentMode == "add" || $aulas->CurrentMode == "copy" || $aulas->CurrentMode == "edit") {
		$aulas_grid->RowIndex = '$rowindex$';
		$aulas_grid->loadRowValues();

		// Set row properties
		$aulas->resetAttributes();
		$aulas->RowAttrs->merge(["data-rowindex" => $aulas_grid->RowIndex, "id" => "r0_aulas", "data-rowtype" => ROWTYPE_ADD]);
		$aulas->RowAttrs->appendClass("ew-template");
		$aulas->RowType = ROWTYPE_ADD;

		// Render row
		$aulas_grid->renderRow();

		// Render list options
		$aulas_grid->renderListOptions();
		$aulas_grid->StartRowCount = 0;
?>
	<tr <?php echo $aulas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$aulas_grid->ListOptions->render("body", "left", $aulas_grid->RowIndex);
?>
	<?php if ($aulas_grid->idturnos->Visible) { // idturnos ?>
		<td data-name="idturnos">
<?php if (!$aulas->isConfirm()) { ?>
<?php if ($aulas_grid->idturnos->getSessionValue() != "") { ?>
<span id="el$rowindex$_aulas_idturnos" class="form-group aulas_idturnos">
<span<?php echo $aulas_grid->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_aulas_idturnos" class="form-group aulas_idturnos">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_grid->idturnos->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos"<?php echo $aulas_grid->idturnos->editAttributes() ?>>
			<?php echo $aulas_grid->idturnos->selectOptionListHtml("x{$aulas_grid->RowIndex}_idturnos") ?>
		</select>
</div>
<?php echo $aulas_grid->idturnos->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_idturnos") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_aulas_idturnos" class="form-group aulas_idturnos">
<span<?php echo $aulas_grid->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="x<?php echo $aulas_grid->RowIndex ?>_idturnos" id="x<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="o<?php echo $aulas_grid->RowIndex ?>_idturnos" id="o<?php echo $aulas_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_grid->idturnos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_grid->idaluno->Visible) { // idaluno ?>
		<td data-name="idaluno">
<?php if (!$aulas->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_aulas_idaluno" class="form-group aulas_idaluno">
<span<?php echo $aulas_grid->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_aulas_idaluno" class="form-group aulas_idaluno">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_grid->idaluno->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno"<?php echo $aulas_grid->idaluno->editAttributes() ?>>
			<?php echo $aulas_grid->idaluno->selectOptionListHtml("x{$aulas_grid->RowIndex}_idaluno") ?>
		</select>
</div>
<?php echo $aulas_grid->idaluno->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_idaluno") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_aulas_idaluno" class="form-group aulas_idaluno">
<span<?php echo $aulas_grid->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->idaluno->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_grid->RowIndex ?>_idaluno" id="x<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="o<?php echo $aulas_grid->RowIndex ?>_idaluno" id="o<?php echo $aulas_grid->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_grid->idaluno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_grid->nome->Visible) { // nome ?>
		<td data-name="nome">
<?php if (!$aulas->isConfirm()) { ?>
<span id="el$rowindex$_aulas_nome" class="form-group aulas_nome">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_grid->nome->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_grid->RowIndex ?>_nome" name="x<?php echo $aulas_grid->RowIndex ?>_nome"<?php echo $aulas_grid->nome->editAttributes() ?>>
			<?php echo $aulas_grid->nome->selectOptionListHtml("x{$aulas_grid->RowIndex}_nome") ?>
		</select>
</div>
<?php echo $aulas_grid->nome->Lookup->getParamTag($aulas_grid, "p_x" . $aulas_grid->RowIndex . "_nome") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_aulas_nome" class="form-group aulas_nome">
<span<?php echo $aulas_grid->nome->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->nome->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_nome" name="x<?php echo $aulas_grid->RowIndex ?>_nome" id="x<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_nome" name="o<?php echo $aulas_grid->RowIndex ?>_nome" id="o<?php echo $aulas_grid->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_grid->nome->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_grid->ativado->Visible) { // ativado ?>
		<td data-name="ativado">
<?php if (!$aulas->isConfirm()) { ?>
<span id="el$rowindex$_aulas_ativado" class="form-group aulas_ativado">
<div id="tp_x<?php echo $aulas_grid->RowIndex ?>_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_grid->ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $aulas_grid->RowIndex ?>_ativado" id="x<?php echo $aulas_grid->RowIndex ?>_ativado" value="{value}"<?php echo $aulas_grid->ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $aulas_grid->RowIndex ?>_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_grid->ativado->radioButtonListHtml(FALSE, "x{$aulas_grid->RowIndex}_ativado") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_aulas_ativado" class="form-group aulas_ativado">
<span<?php echo $aulas_grid->ativado->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_grid->ativado->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="x<?php echo $aulas_grid->RowIndex ?>_ativado" id="x<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="o<?php echo $aulas_grid->RowIndex ?>_ativado" id="o<?php echo $aulas_grid->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_grid->ativado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$aulas_grid->ListOptions->render("body", "right", $aulas_grid->RowIndex);
?>
<script>
loadjs.ready(["faulasgrid", "load"], function() {
	faulasgrid.updateLists(<?php echo $aulas_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($aulas->CurrentMode == "add" || $aulas->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $aulas_grid->FormKeyCountName ?>" id="<?php echo $aulas_grid->FormKeyCountName ?>" value="<?php echo $aulas_grid->KeyCount ?>">
<?php echo $aulas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($aulas->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $aulas_grid->FormKeyCountName ?>" id="<?php echo $aulas_grid->FormKeyCountName ?>" value="<?php echo $aulas_grid->KeyCount ?>">
<?php echo $aulas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($aulas->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="faulasgrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($aulas_grid->Recordset)
	$aulas_grid->Recordset->Close();
?>
<?php if ($aulas_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $aulas_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($aulas_grid->TotalRecords == 0 && !$aulas->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $aulas_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$aulas_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$aulas_grid->terminate();
?>