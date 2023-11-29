<?php
namespace PHPMaker2020\sistema;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($turnos_grid))
	$turnos_grid = new turnos_grid();

// Run the page
$turnos_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_grid->Page_Render();
?>
<?php if (!$turnos_grid->isExport()) { ?>
<script>
var fturnosgrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fturnosgrid = new ew.Form("fturnosgrid", "grid");
	fturnosgrid.formKeyCountName = '<?php echo $turnos_grid->FormKeyCountName ?>';

	// Validate form
	fturnosgrid.validate = function() {
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
			<?php if ($turnos_grid->idacademia->Required) { ?>
				elm = this.getElements("x" + infix + "_idacademia");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $turnos_grid->idacademia->caption(), $turnos_grid->idacademia->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($turnos_grid->turmas->Required) { ?>
				elm = this.getElements("x" + infix + "_turmas");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $turnos_grid->turmas->caption(), $turnos_grid->turmas->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fturnosgrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idacademia", false)) return false;
		if (ew.valueChanged(fobj, infix, "turmas", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fturnosgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fturnosgrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fturnosgrid.lists["x_idacademia"] = <?php echo $turnos_grid->idacademia->Lookup->toClientList($turnos_grid) ?>;
	fturnosgrid.lists["x_idacademia"].options = <?php echo JsonEncode($turnos_grid->idacademia->lookupOptions()) ?>;
	fturnosgrid.lists["x_turmas"] = <?php echo $turnos_grid->turmas->Lookup->toClientList($turnos_grid) ?>;
	fturnosgrid.lists["x_turmas"].options = <?php echo JsonEncode($turnos_grid->turmas->lookupOptions()) ?>;
	loadjs.done("fturnosgrid");
});
</script>
<?php } ?>
<?php
$turnos_grid->renderOtherOptions();
?>
<?php if ($turnos_grid->TotalRecords > 0 || $turnos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($turnos_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> turnos">
<?php if ($turnos_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $turnos_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fturnosgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_turnos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_turnosgrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$turnos->RowType = ROWTYPE_HEADER;

// Render list options
$turnos_grid->renderListOptions();

// Render list options (header, left)
$turnos_grid->ListOptions->render("header", "left");
?>
<?php if ($turnos_grid->idacademia->Visible) { // idacademia ?>
	<?php if ($turnos_grid->SortUrl($turnos_grid->idacademia) == "") { ?>
		<th data-name="idacademia" class="<?php echo $turnos_grid->idacademia->headerCellClass() ?>"><div id="elh_turnos_idacademia" class="turnos_idacademia"><div class="ew-table-header-caption"><?php echo $turnos_grid->idacademia->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idacademia" class="<?php echo $turnos_grid->idacademia->headerCellClass() ?>"><div><div id="elh_turnos_idacademia" class="turnos_idacademia">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $turnos_grid->idacademia->caption() ?></span><span class="ew-table-header-sort"><?php if ($turnos_grid->idacademia->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($turnos_grid->idacademia->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($turnos_grid->turmas->Visible) { // turmas ?>
	<?php if ($turnos_grid->SortUrl($turnos_grid->turmas) == "") { ?>
		<th data-name="turmas" class="<?php echo $turnos_grid->turmas->headerCellClass() ?>"><div id="elh_turnos_turmas" class="turnos_turmas"><div class="ew-table-header-caption"><?php echo $turnos_grid->turmas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="turmas" class="<?php echo $turnos_grid->turmas->headerCellClass() ?>"><div><div id="elh_turnos_turmas" class="turnos_turmas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $turnos_grid->turmas->caption() ?></span><span class="ew-table-header-sort"><?php if ($turnos_grid->turmas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($turnos_grid->turmas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$turnos_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$turnos_grid->StartRecord = 1;
$turnos_grid->StopRecord = $turnos_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($turnos->isConfirm() || $turnos_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($turnos_grid->FormKeyCountName) && ($turnos_grid->isGridAdd() || $turnos_grid->isGridEdit() || $turnos->isConfirm())) {
		$turnos_grid->KeyCount = $CurrentForm->getValue($turnos_grid->FormKeyCountName);
		$turnos_grid->StopRecord = $turnos_grid->StartRecord + $turnos_grid->KeyCount - 1;
	}
}
$turnos_grid->RecordCount = $turnos_grid->StartRecord - 1;
if ($turnos_grid->Recordset && !$turnos_grid->Recordset->EOF) {
	$turnos_grid->Recordset->moveFirst();
	$selectLimit = $turnos_grid->UseSelectLimit;
	if (!$selectLimit && $turnos_grid->StartRecord > 1)
		$turnos_grid->Recordset->move($turnos_grid->StartRecord - 1);
} elseif (!$turnos->AllowAddDeleteRow && $turnos_grid->StopRecord == 0) {
	$turnos_grid->StopRecord = $turnos->GridAddRowCount;
}

// Initialize aggregate
$turnos->RowType = ROWTYPE_AGGREGATEINIT;
$turnos->resetAttributes();
$turnos_grid->renderRow();
if ($turnos_grid->isGridAdd())
	$turnos_grid->RowIndex = 0;
if ($turnos_grid->isGridEdit())
	$turnos_grid->RowIndex = 0;
while ($turnos_grid->RecordCount < $turnos_grid->StopRecord) {
	$turnos_grid->RecordCount++;
	if ($turnos_grid->RecordCount >= $turnos_grid->StartRecord) {
		$turnos_grid->RowCount++;
		if ($turnos_grid->isGridAdd() || $turnos_grid->isGridEdit() || $turnos->isConfirm()) {
			$turnos_grid->RowIndex++;
			$CurrentForm->Index = $turnos_grid->RowIndex;
			if ($CurrentForm->hasValue($turnos_grid->FormActionName) && ($turnos->isConfirm() || $turnos_grid->EventCancelled))
				$turnos_grid->RowAction = strval($CurrentForm->getValue($turnos_grid->FormActionName));
			elseif ($turnos_grid->isGridAdd())
				$turnos_grid->RowAction = "insert";
			else
				$turnos_grid->RowAction = "";
		}

		// Set up key count
		$turnos_grid->KeyCount = $turnos_grid->RowIndex;

		// Init row class and style
		$turnos->resetAttributes();
		$turnos->CssClass = "";
		if ($turnos_grid->isGridAdd()) {
			if ($turnos->CurrentMode == "copy") {
				$turnos_grid->loadRowValues($turnos_grid->Recordset); // Load row values
				$turnos_grid->setRecordKey($turnos_grid->RowOldKey, $turnos_grid->Recordset); // Set old record key
			} else {
				$turnos_grid->loadRowValues(); // Load default values
				$turnos_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$turnos_grid->loadRowValues($turnos_grid->Recordset); // Load row values
		}
		$turnos->RowType = ROWTYPE_VIEW; // Render view
		if ($turnos_grid->isGridAdd()) // Grid add
			$turnos->RowType = ROWTYPE_ADD; // Render add
		if ($turnos_grid->isGridAdd() && $turnos->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$turnos_grid->restoreCurrentRowFormValues($turnos_grid->RowIndex); // Restore form values
		if ($turnos_grid->isGridEdit()) { // Grid edit
			if ($turnos->EventCancelled)
				$turnos_grid->restoreCurrentRowFormValues($turnos_grid->RowIndex); // Restore form values
			if ($turnos_grid->RowAction == "insert")
				$turnos->RowType = ROWTYPE_ADD; // Render add
			else
				$turnos->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($turnos_grid->isGridEdit() && ($turnos->RowType == ROWTYPE_EDIT || $turnos->RowType == ROWTYPE_ADD) && $turnos->EventCancelled) // Update failed
			$turnos_grid->restoreCurrentRowFormValues($turnos_grid->RowIndex); // Restore form values
		if ($turnos->RowType == ROWTYPE_EDIT) // Edit row
			$turnos_grid->EditRowCount++;
		if ($turnos->isConfirm()) // Confirm row
			$turnos_grid->restoreCurrentRowFormValues($turnos_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$turnos->RowAttrs->merge(["data-rowindex" => $turnos_grid->RowCount, "id" => "r" . $turnos_grid->RowCount . "_turnos", "data-rowtype" => $turnos->RowType]);

		// Render row
		$turnos_grid->renderRow();

		// Render list options
		$turnos_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($turnos_grid->RowAction != "delete" && $turnos_grid->RowAction != "insertdelete" && !($turnos_grid->RowAction == "insert" && $turnos->isConfirm() && $turnos_grid->emptyRow())) {
?>
	<tr <?php echo $turnos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$turnos_grid->ListOptions->render("body", "left", $turnos_grid->RowCount);
?>
	<?php if ($turnos_grid->idacademia->Visible) { // idacademia ?>
		<td data-name="idacademia" <?php echo $turnos_grid->idacademia->cellAttributes() ?>>
<?php if ($turnos->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($turnos_grid->idacademia->getSessionValue() != "") { ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_idacademia" class="form-group">
<span<?php echo $turnos_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_idacademia" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_idacademia" data-value-separator="<?php echo $turnos_grid->idacademia->displayValueSeparatorAttribute() ?>" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia"<?php echo $turnos_grid->idacademia->editAttributes() ?>>
			<?php echo $turnos_grid->idacademia->selectOptionListHtml("x{$turnos_grid->RowIndex}_idacademia") ?>
		</select>
</div>
<?php echo $turnos_grid->idacademia->Lookup->getParamTag($turnos_grid, "p_x" . $turnos_grid->RowIndex . "_idacademia") ?>
</span>
<?php } ?>
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="o<?php echo $turnos_grid->RowIndex ?>_idacademia" id="o<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->OldValue) ?>">
<?php } ?>
<?php if ($turnos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($turnos_grid->idacademia->getSessionValue() != "") { ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_idacademia" class="form-group">
<span<?php echo $turnos_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_idacademia" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_idacademia" data-value-separator="<?php echo $turnos_grid->idacademia->displayValueSeparatorAttribute() ?>" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia"<?php echo $turnos_grid->idacademia->editAttributes() ?>>
			<?php echo $turnos_grid->idacademia->selectOptionListHtml("x{$turnos_grid->RowIndex}_idacademia") ?>
		</select>
</div>
<?php echo $turnos_grid->idacademia->Lookup->getParamTag($turnos_grid, "p_x" . $turnos_grid->RowIndex . "_idacademia") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($turnos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_idacademia">
<span<?php echo $turnos_grid->idacademia->viewAttributes() ?>><?php echo $turnos_grid->idacademia->getViewValue() ?></span>
</span>
<?php if (!$turnos->isConfirm()) { ?>
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->FormValue) ?>">
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="o<?php echo $turnos_grid->RowIndex ?>_idacademia" id="o<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="fturnosgrid$x<?php echo $turnos_grid->RowIndex ?>_idacademia" id="fturnosgrid$x<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->FormValue) ?>">
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="fturnosgrid$o<?php echo $turnos_grid->RowIndex ?>_idacademia" id="fturnosgrid$o<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($turnos->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="turnos" data-field="x_idturnos" name="x<?php echo $turnos_grid->RowIndex ?>_idturnos" id="x<?php echo $turnos_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($turnos_grid->idturnos->CurrentValue) ?>">
<input type="hidden" data-table="turnos" data-field="x_idturnos" name="o<?php echo $turnos_grid->RowIndex ?>_idturnos" id="o<?php echo $turnos_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($turnos_grid->idturnos->OldValue) ?>">
<?php } ?>
<?php if ($turnos->RowType == ROWTYPE_EDIT || $turnos->CurrentMode == "edit") { ?>
<input type="hidden" data-table="turnos" data-field="x_idturnos" name="x<?php echo $turnos_grid->RowIndex ?>_idturnos" id="x<?php echo $turnos_grid->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($turnos_grid->idturnos->CurrentValue) ?>">
<?php } ?>
	<?php if ($turnos_grid->turmas->Visible) { // turmas ?>
		<td data-name="turmas" <?php echo $turnos_grid->turmas->cellAttributes() ?>>
<?php if ($turnos->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_turmas" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_turmas" data-value-separator="<?php echo $turnos_grid->turmas->displayValueSeparatorAttribute() ?>" id="x<?php echo $turnos_grid->RowIndex ?>_turmas" name="x<?php echo $turnos_grid->RowIndex ?>_turmas"<?php echo $turnos_grid->turmas->editAttributes() ?>>
			<?php echo $turnos_grid->turmas->selectOptionListHtml("x{$turnos_grid->RowIndex}_turmas") ?>
		</select>
</div>
<?php echo $turnos_grid->turmas->Lookup->getParamTag($turnos_grid, "p_x" . $turnos_grid->RowIndex . "_turmas") ?>
</span>
<input type="hidden" data-table="turnos" data-field="x_turmas" name="o<?php echo $turnos_grid->RowIndex ?>_turmas" id="o<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->OldValue) ?>">
<?php } ?>
<?php if ($turnos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_turmas" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_turmas" data-value-separator="<?php echo $turnos_grid->turmas->displayValueSeparatorAttribute() ?>" id="x<?php echo $turnos_grid->RowIndex ?>_turmas" name="x<?php echo $turnos_grid->RowIndex ?>_turmas"<?php echo $turnos_grid->turmas->editAttributes() ?>>
			<?php echo $turnos_grid->turmas->selectOptionListHtml("x{$turnos_grid->RowIndex}_turmas") ?>
		</select>
</div>
<?php echo $turnos_grid->turmas->Lookup->getParamTag($turnos_grid, "p_x" . $turnos_grid->RowIndex . "_turmas") ?>
</span>
<?php } ?>
<?php if ($turnos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $turnos_grid->RowCount ?>_turnos_turmas">
<span<?php echo $turnos_grid->turmas->viewAttributes() ?>><?php echo $turnos_grid->turmas->getViewValue() ?></span>
</span>
<?php if (!$turnos->isConfirm()) { ?>
<input type="hidden" data-table="turnos" data-field="x_turmas" name="x<?php echo $turnos_grid->RowIndex ?>_turmas" id="x<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->FormValue) ?>">
<input type="hidden" data-table="turnos" data-field="x_turmas" name="o<?php echo $turnos_grid->RowIndex ?>_turmas" id="o<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="turnos" data-field="x_turmas" name="fturnosgrid$x<?php echo $turnos_grid->RowIndex ?>_turmas" id="fturnosgrid$x<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->FormValue) ?>">
<input type="hidden" data-table="turnos" data-field="x_turmas" name="fturnosgrid$o<?php echo $turnos_grid->RowIndex ?>_turmas" id="fturnosgrid$o<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$turnos_grid->ListOptions->render("body", "right", $turnos_grid->RowCount);
?>
	</tr>
<?php if ($turnos->RowType == ROWTYPE_ADD || $turnos->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fturnosgrid", "load"], function() {
	fturnosgrid.updateLists(<?php echo $turnos_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$turnos_grid->isGridAdd() || $turnos->CurrentMode == "copy")
		if (!$turnos_grid->Recordset->EOF)
			$turnos_grid->Recordset->moveNext();
}
?>
<?php
	if ($turnos->CurrentMode == "add" || $turnos->CurrentMode == "copy" || $turnos->CurrentMode == "edit") {
		$turnos_grid->RowIndex = '$rowindex$';
		$turnos_grid->loadRowValues();

		// Set row properties
		$turnos->resetAttributes();
		$turnos->RowAttrs->merge(["data-rowindex" => $turnos_grid->RowIndex, "id" => "r0_turnos", "data-rowtype" => ROWTYPE_ADD]);
		$turnos->RowAttrs->appendClass("ew-template");
		$turnos->RowType = ROWTYPE_ADD;

		// Render row
		$turnos_grid->renderRow();

		// Render list options
		$turnos_grid->renderListOptions();
		$turnos_grid->StartRowCount = 0;
?>
	<tr <?php echo $turnos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$turnos_grid->ListOptions->render("body", "left", $turnos_grid->RowIndex);
?>
	<?php if ($turnos_grid->idacademia->Visible) { // idacademia ?>
		<td data-name="idacademia">
<?php if (!$turnos->isConfirm()) { ?>
<?php if ($turnos_grid->idacademia->getSessionValue() != "") { ?>
<span id="el$rowindex$_turnos_idacademia" class="form-group turnos_idacademia">
<span<?php echo $turnos_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_turnos_idacademia" class="form-group turnos_idacademia">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_idacademia" data-value-separator="<?php echo $turnos_grid->idacademia->displayValueSeparatorAttribute() ?>" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia"<?php echo $turnos_grid->idacademia->editAttributes() ?>>
			<?php echo $turnos_grid->idacademia->selectOptionListHtml("x{$turnos_grid->RowIndex}_idacademia") ?>
		</select>
</div>
<?php echo $turnos_grid->idacademia->Lookup->getParamTag($turnos_grid, "p_x" . $turnos_grid->RowIndex . "_idacademia") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_turnos_idacademia" class="form-group turnos_idacademia">
<span<?php echo $turnos_grid->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_grid->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="x<?php echo $turnos_grid->RowIndex ?>_idacademia" id="x<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="turnos" data-field="x_idacademia" name="o<?php echo $turnos_grid->RowIndex ?>_idacademia" id="o<?php echo $turnos_grid->RowIndex ?>_idacademia" value="<?php echo HtmlEncode($turnos_grid->idacademia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($turnos_grid->turmas->Visible) { // turmas ?>
		<td data-name="turmas">
<?php if (!$turnos->isConfirm()) { ?>
<span id="el$rowindex$_turnos_turmas" class="form-group turnos_turmas">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_turmas" data-value-separator="<?php echo $turnos_grid->turmas->displayValueSeparatorAttribute() ?>" id="x<?php echo $turnos_grid->RowIndex ?>_turmas" name="x<?php echo $turnos_grid->RowIndex ?>_turmas"<?php echo $turnos_grid->turmas->editAttributes() ?>>
			<?php echo $turnos_grid->turmas->selectOptionListHtml("x{$turnos_grid->RowIndex}_turmas") ?>
		</select>
</div>
<?php echo $turnos_grid->turmas->Lookup->getParamTag($turnos_grid, "p_x" . $turnos_grid->RowIndex . "_turmas") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_turnos_turmas" class="form-group turnos_turmas">
<span<?php echo $turnos_grid->turmas->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_grid->turmas->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="turnos" data-field="x_turmas" name="x<?php echo $turnos_grid->RowIndex ?>_turmas" id="x<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="turnos" data-field="x_turmas" name="o<?php echo $turnos_grid->RowIndex ?>_turmas" id="o<?php echo $turnos_grid->RowIndex ?>_turmas" value="<?php echo HtmlEncode($turnos_grid->turmas->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$turnos_grid->ListOptions->render("body", "right", $turnos_grid->RowIndex);
?>
<script>
loadjs.ready(["fturnosgrid", "load"], function() {
	fturnosgrid.updateLists(<?php echo $turnos_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($turnos->CurrentMode == "add" || $turnos->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $turnos_grid->FormKeyCountName ?>" id="<?php echo $turnos_grid->FormKeyCountName ?>" value="<?php echo $turnos_grid->KeyCount ?>">
<?php echo $turnos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($turnos->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $turnos_grid->FormKeyCountName ?>" id="<?php echo $turnos_grid->FormKeyCountName ?>" value="<?php echo $turnos_grid->KeyCount ?>">
<?php echo $turnos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($turnos->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fturnosgrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($turnos_grid->Recordset)
	$turnos_grid->Recordset->Close();
?>
<?php if ($turnos_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $turnos_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($turnos_grid->TotalRecords == 0 && !$turnos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $turnos_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$turnos_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$turnos_grid->terminate();
?>