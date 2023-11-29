<?php
namespace PHPMaker2020\sistema;

// Write header
WriteHeader(FALSE);

// Create page object
if (!isset($videos_grid))
	$videos_grid = new videos_grid();

// Run the page
$videos_grid->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$videos_grid->Page_Render();
?>
<?php if (!$videos_grid->isExport()) { ?>
<script>
var fvideosgrid, currentPageID;
loadjs.ready("head", function() {

	// Form object
	fvideosgrid = new ew.Form("fvideosgrid", "grid");
	fvideosgrid.formKeyCountName = '<?php echo $videos_grid->FormKeyCountName ?>';

	// Validate form
	fvideosgrid.validate = function() {
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
			<?php if ($videos_grid->titulo->Required) { ?>
				elm = this.getElements("x" + infix + "_titulo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_grid->titulo->caption(), $videos_grid->titulo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($videos_grid->idaulas->Required) { ?>
				elm = this.getElements("x" + infix + "_idaulas");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_grid->idaulas->caption(), $videos_grid->idaulas->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($videos_grid->ativo->Required) { ?>
				elm = this.getElements("x" + infix + "_ativo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_grid->ativo->caption(), $videos_grid->ativo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($videos_grid->views->Required) { ?>
				elm = this.getElements("x" + infix + "_views");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_grid->views->caption(), $videos_grid->views->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_views");
				if (elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($videos_grid->views->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		return true;
	}

	// Check empty row
	fvideosgrid.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "titulo", false)) return false;
		if (ew.valueChanged(fobj, infix, "idaulas", false)) return false;
		if (ew.valueChanged(fobj, infix, "ativo", false)) return false;
		if (ew.valueChanged(fobj, infix, "views", false)) return false;
		return true;
	}

	// Form_CustomValidate
	fvideosgrid.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fvideosgrid.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fvideosgrid.lists["x_idaulas"] = <?php echo $videos_grid->idaulas->Lookup->toClientList($videos_grid) ?>;
	fvideosgrid.lists["x_idaulas"].options = <?php echo JsonEncode($videos_grid->idaulas->lookupOptions()) ?>;
	fvideosgrid.lists["x_ativo"] = <?php echo $videos_grid->ativo->Lookup->toClientList($videos_grid) ?>;
	fvideosgrid.lists["x_ativo"].options = <?php echo JsonEncode($videos_grid->ativo->options(FALSE, TRUE)) ?>;
	loadjs.done("fvideosgrid");
});
</script>
<?php } ?>
<?php
$videos_grid->renderOtherOptions();
?>
<?php if ($videos_grid->TotalRecords > 0 || $videos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($videos_grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> videos">
<?php if ($videos_grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $videos_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fvideosgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_videos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_videosgrid" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$videos->RowType = ROWTYPE_HEADER;

// Render list options
$videos_grid->renderListOptions();

// Render list options (header, left)
$videos_grid->ListOptions->render("header", "left");
?>
<?php if ($videos_grid->titulo->Visible) { // titulo ?>
	<?php if ($videos_grid->SortUrl($videos_grid->titulo) == "") { ?>
		<th data-name="titulo" class="<?php echo $videos_grid->titulo->headerCellClass() ?>"><div id="elh_videos_titulo" class="videos_titulo"><div class="ew-table-header-caption"><?php echo $videos_grid->titulo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="titulo" class="<?php echo $videos_grid->titulo->headerCellClass() ?>"><div><div id="elh_videos_titulo" class="videos_titulo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_grid->titulo->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_grid->titulo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_grid->titulo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($videos_grid->idaulas->Visible) { // idaulas ?>
	<?php if ($videos_grid->SortUrl($videos_grid->idaulas) == "") { ?>
		<th data-name="idaulas" class="<?php echo $videos_grid->idaulas->headerCellClass() ?>"><div id="elh_videos_idaulas" class="videos_idaulas"><div class="ew-table-header-caption"><?php echo $videos_grid->idaulas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idaulas" class="<?php echo $videos_grid->idaulas->headerCellClass() ?>"><div><div id="elh_videos_idaulas" class="videos_idaulas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_grid->idaulas->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_grid->idaulas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_grid->idaulas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($videos_grid->ativo->Visible) { // ativo ?>
	<?php if ($videos_grid->SortUrl($videos_grid->ativo) == "") { ?>
		<th data-name="ativo" class="<?php echo $videos_grid->ativo->headerCellClass() ?>"><div id="elh_videos_ativo" class="videos_ativo"><div class="ew-table-header-caption"><?php echo $videos_grid->ativo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativo" class="<?php echo $videos_grid->ativo->headerCellClass() ?>"><div><div id="elh_videos_ativo" class="videos_ativo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_grid->ativo->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_grid->ativo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_grid->ativo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($videos_grid->views->Visible) { // views ?>
	<?php if ($videos_grid->SortUrl($videos_grid->views) == "") { ?>
		<th data-name="views" class="<?php echo $videos_grid->views->headerCellClass() ?>"><div id="elh_videos_views" class="videos_views"><div class="ew-table-header-caption"><?php echo $videos_grid->views->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="views" class="<?php echo $videos_grid->views->headerCellClass() ?>"><div><div id="elh_videos_views" class="videos_views">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_grid->views->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_grid->views->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_grid->views->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$videos_grid->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$videos_grid->StartRecord = 1;
$videos_grid->StopRecord = $videos_grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($videos->isConfirm() || $videos_grid->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($videos_grid->FormKeyCountName) && ($videos_grid->isGridAdd() || $videos_grid->isGridEdit() || $videos->isConfirm())) {
		$videos_grid->KeyCount = $CurrentForm->getValue($videos_grid->FormKeyCountName);
		$videos_grid->StopRecord = $videos_grid->StartRecord + $videos_grid->KeyCount - 1;
	}
}
$videos_grid->RecordCount = $videos_grid->StartRecord - 1;
if ($videos_grid->Recordset && !$videos_grid->Recordset->EOF) {
	$videos_grid->Recordset->moveFirst();
	$selectLimit = $videos_grid->UseSelectLimit;
	if (!$selectLimit && $videos_grid->StartRecord > 1)
		$videos_grid->Recordset->move($videos_grid->StartRecord - 1);
} elseif (!$videos->AllowAddDeleteRow && $videos_grid->StopRecord == 0) {
	$videos_grid->StopRecord = $videos->GridAddRowCount;
}

// Initialize aggregate
$videos->RowType = ROWTYPE_AGGREGATEINIT;
$videos->resetAttributes();
$videos_grid->renderRow();
if ($videos_grid->isGridAdd())
	$videos_grid->RowIndex = 0;
if ($videos_grid->isGridEdit())
	$videos_grid->RowIndex = 0;
while ($videos_grid->RecordCount < $videos_grid->StopRecord) {
	$videos_grid->RecordCount++;
	if ($videos_grid->RecordCount >= $videos_grid->StartRecord) {
		$videos_grid->RowCount++;
		if ($videos_grid->isGridAdd() || $videos_grid->isGridEdit() || $videos->isConfirm()) {
			$videos_grid->RowIndex++;
			$CurrentForm->Index = $videos_grid->RowIndex;
			if ($CurrentForm->hasValue($videos_grid->FormActionName) && ($videos->isConfirm() || $videos_grid->EventCancelled))
				$videos_grid->RowAction = strval($CurrentForm->getValue($videos_grid->FormActionName));
			elseif ($videos_grid->isGridAdd())
				$videos_grid->RowAction = "insert";
			else
				$videos_grid->RowAction = "";
		}

		// Set up key count
		$videos_grid->KeyCount = $videos_grid->RowIndex;

		// Init row class and style
		$videos->resetAttributes();
		$videos->CssClass = "";
		if ($videos_grid->isGridAdd()) {
			if ($videos->CurrentMode == "copy") {
				$videos_grid->loadRowValues($videos_grid->Recordset); // Load row values
				$videos_grid->setRecordKey($videos_grid->RowOldKey, $videos_grid->Recordset); // Set old record key
			} else {
				$videos_grid->loadRowValues(); // Load default values
				$videos_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$videos_grid->loadRowValues($videos_grid->Recordset); // Load row values
		}
		$videos->RowType = ROWTYPE_VIEW; // Render view
		if ($videos_grid->isGridAdd()) // Grid add
			$videos->RowType = ROWTYPE_ADD; // Render add
		if ($videos_grid->isGridAdd() && $videos->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$videos_grid->restoreCurrentRowFormValues($videos_grid->RowIndex); // Restore form values
		if ($videos_grid->isGridEdit()) { // Grid edit
			if ($videos->EventCancelled)
				$videos_grid->restoreCurrentRowFormValues($videos_grid->RowIndex); // Restore form values
			if ($videos_grid->RowAction == "insert")
				$videos->RowType = ROWTYPE_ADD; // Render add
			else
				$videos->RowType = ROWTYPE_EDIT; // Render edit
		}
		if ($videos_grid->isGridEdit() && ($videos->RowType == ROWTYPE_EDIT || $videos->RowType == ROWTYPE_ADD) && $videos->EventCancelled) // Update failed
			$videos_grid->restoreCurrentRowFormValues($videos_grid->RowIndex); // Restore form values
		if ($videos->RowType == ROWTYPE_EDIT) // Edit row
			$videos_grid->EditRowCount++;
		if ($videos->isConfirm()) // Confirm row
			$videos_grid->restoreCurrentRowFormValues($videos_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$videos->RowAttrs->merge(["data-rowindex" => $videos_grid->RowCount, "id" => "r" . $videos_grid->RowCount . "_videos", "data-rowtype" => $videos->RowType]);

		// Render row
		$videos_grid->renderRow();

		// Render list options
		$videos_grid->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($videos_grid->RowAction != "delete" && $videos_grid->RowAction != "insertdelete" && !($videos_grid->RowAction == "insert" && $videos->isConfirm() && $videos_grid->emptyRow())) {
?>
	<tr <?php echo $videos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$videos_grid->ListOptions->render("body", "left", $videos_grid->RowCount);
?>
	<?php if ($videos_grid->titulo->Visible) { // titulo ?>
		<td data-name="titulo" <?php echo $videos_grid->titulo->cellAttributes() ?>>
<?php if ($videos->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_titulo" class="form-group">
<input type="text" data-table="videos" data-field="x_titulo" name="x<?php echo $videos_grid->RowIndex ?>_titulo" id="x<?php echo $videos_grid->RowIndex ?>_titulo" size="30" maxlength="35" placeholder="<?php echo HtmlEncode($videos_grid->titulo->getPlaceHolder()) ?>" value="<?php echo $videos_grid->titulo->EditValue ?>"<?php echo $videos_grid->titulo->editAttributes() ?>>
</span>
<input type="hidden" data-table="videos" data-field="x_titulo" name="o<?php echo $videos_grid->RowIndex ?>_titulo" id="o<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->OldValue) ?>">
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_titulo" class="form-group">
<input type="text" data-table="videos" data-field="x_titulo" name="x<?php echo $videos_grid->RowIndex ?>_titulo" id="x<?php echo $videos_grid->RowIndex ?>_titulo" size="30" maxlength="35" placeholder="<?php echo HtmlEncode($videos_grid->titulo->getPlaceHolder()) ?>" value="<?php echo $videos_grid->titulo->EditValue ?>"<?php echo $videos_grid->titulo->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_titulo">
<span<?php echo $videos_grid->titulo->viewAttributes() ?>><?php if (!EmptyString($videos_grid->titulo->getViewValue()) && $videos_grid->titulo->linkAttributes() != "") { ?>
<a<?php echo $videos_grid->titulo->linkAttributes() ?>><?php echo $videos_grid->titulo->getViewValue() ?></a>
<?php } else { ?>
<?php echo $videos_grid->titulo->getViewValue() ?>
<?php } ?></span>
</span>
<?php if (!$videos->isConfirm()) { ?>
<input type="hidden" data-table="videos" data-field="x_titulo" name="x<?php echo $videos_grid->RowIndex ?>_titulo" id="x<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_titulo" name="o<?php echo $videos_grid->RowIndex ?>_titulo" id="o<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="videos" data-field="x_titulo" name="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_titulo" id="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_titulo" name="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_titulo" id="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($videos->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="videos" data-field="x_idvideos" name="x<?php echo $videos_grid->RowIndex ?>_idvideos" id="x<?php echo $videos_grid->RowIndex ?>_idvideos" value="<?php echo HtmlEncode($videos_grid->idvideos->CurrentValue) ?>">
<input type="hidden" data-table="videos" data-field="x_idvideos" name="o<?php echo $videos_grid->RowIndex ?>_idvideos" id="o<?php echo $videos_grid->RowIndex ?>_idvideos" value="<?php echo HtmlEncode($videos_grid->idvideos->OldValue) ?>">
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_EDIT || $videos->CurrentMode == "edit") { ?>
<input type="hidden" data-table="videos" data-field="x_idvideos" name="x<?php echo $videos_grid->RowIndex ?>_idvideos" id="x<?php echo $videos_grid->RowIndex ?>_idvideos" value="<?php echo HtmlEncode($videos_grid->idvideos->CurrentValue) ?>">
<?php } ?>
	<?php if ($videos_grid->idaulas->Visible) { // idaulas ?>
		<td data-name="idaulas" <?php echo $videos_grid->idaulas->cellAttributes() ?>>
<?php if ($videos->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($videos_grid->idaulas->getSessionValue() != "") { ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_idaulas" class="form-group">
<span<?php echo $videos_grid->idaulas->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->idaulas->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_idaulas" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="videos" data-field="x_idaulas" data-value-separator="<?php echo $videos_grid->idaulas->displayValueSeparatorAttribute() ?>" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas"<?php echo $videos_grid->idaulas->editAttributes() ?>>
			<?php echo $videos_grid->idaulas->selectOptionListHtml("x{$videos_grid->RowIndex}_idaulas") ?>
		</select>
</div>
<?php echo $videos_grid->idaulas->Lookup->getParamTag($videos_grid, "p_x" . $videos_grid->RowIndex . "_idaulas") ?>
</span>
<?php } ?>
<input type="hidden" data-table="videos" data-field="x_idaulas" name="o<?php echo $videos_grid->RowIndex ?>_idaulas" id="o<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->OldValue) ?>">
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($videos_grid->idaulas->getSessionValue() != "") { ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_idaulas" class="form-group">
<span<?php echo $videos_grid->idaulas->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->idaulas->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_idaulas" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="videos" data-field="x_idaulas" data-value-separator="<?php echo $videos_grid->idaulas->displayValueSeparatorAttribute() ?>" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas"<?php echo $videos_grid->idaulas->editAttributes() ?>>
			<?php echo $videos_grid->idaulas->selectOptionListHtml("x{$videos_grid->RowIndex}_idaulas") ?>
		</select>
</div>
<?php echo $videos_grid->idaulas->Lookup->getParamTag($videos_grid, "p_x" . $videos_grid->RowIndex . "_idaulas") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_idaulas">
<span<?php echo $videos_grid->idaulas->viewAttributes() ?>><?php echo $videos_grid->idaulas->getViewValue() ?></span>
</span>
<?php if (!$videos->isConfirm()) { ?>
<input type="hidden" data-table="videos" data-field="x_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_idaulas" name="o<?php echo $videos_grid->RowIndex ?>_idaulas" id="o<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="videos" data-field="x_idaulas" name="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_idaulas" id="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_idaulas" name="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_idaulas" id="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($videos_grid->ativo->Visible) { // ativo ?>
		<td data-name="ativo" <?php echo $videos_grid->ativo->cellAttributes() ?>>
<?php if ($videos->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_ativo" class="form-group">
<div id="tp_x<?php echo $videos_grid->RowIndex ?>_ativo" class="ew-template"><input type="radio" class="custom-control-input" data-table="videos" data-field="x_ativo" data-value-separator="<?php echo $videos_grid->ativo->displayValueSeparatorAttribute() ?>" name="x<?php echo $videos_grid->RowIndex ?>_ativo" id="x<?php echo $videos_grid->RowIndex ?>_ativo" value="{value}"<?php echo $videos_grid->ativo->editAttributes() ?>></div>
<div id="dsl_x<?php echo $videos_grid->RowIndex ?>_ativo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $videos_grid->ativo->radioButtonListHtml(FALSE, "x{$videos_grid->RowIndex}_ativo") ?>
</div></div>
</span>
<input type="hidden" data-table="videos" data-field="x_ativo" name="o<?php echo $videos_grid->RowIndex ?>_ativo" id="o<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->OldValue) ?>">
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_ativo" class="form-group">
<div id="tp_x<?php echo $videos_grid->RowIndex ?>_ativo" class="ew-template"><input type="radio" class="custom-control-input" data-table="videos" data-field="x_ativo" data-value-separator="<?php echo $videos_grid->ativo->displayValueSeparatorAttribute() ?>" name="x<?php echo $videos_grid->RowIndex ?>_ativo" id="x<?php echo $videos_grid->RowIndex ?>_ativo" value="{value}"<?php echo $videos_grid->ativo->editAttributes() ?>></div>
<div id="dsl_x<?php echo $videos_grid->RowIndex ?>_ativo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $videos_grid->ativo->radioButtonListHtml(FALSE, "x{$videos_grid->RowIndex}_ativo") ?>
</div></div>
</span>
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_ativo">
<span<?php echo $videos_grid->ativo->viewAttributes() ?>><?php echo $videos_grid->ativo->getViewValue() ?></span>
</span>
<?php if (!$videos->isConfirm()) { ?>
<input type="hidden" data-table="videos" data-field="x_ativo" name="x<?php echo $videos_grid->RowIndex ?>_ativo" id="x<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_ativo" name="o<?php echo $videos_grid->RowIndex ?>_ativo" id="o<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="videos" data-field="x_ativo" name="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_ativo" id="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_ativo" name="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_ativo" id="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($videos_grid->views->Visible) { // views ?>
		<td data-name="views" <?php echo $videos_grid->views->cellAttributes() ?>>
<?php if ($videos->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_views" class="form-group">
<input type="text" data-table="videos" data-field="x_views" name="x<?php echo $videos_grid->RowIndex ?>_views" id="x<?php echo $videos_grid->RowIndex ?>_views" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($videos_grid->views->getPlaceHolder()) ?>" value="<?php echo $videos_grid->views->EditValue ?>"<?php echo $videos_grid->views->editAttributes() ?>>
</span>
<input type="hidden" data-table="videos" data-field="x_views" name="o<?php echo $videos_grid->RowIndex ?>_views" id="o<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->OldValue) ?>">
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_views" class="form-group">
<input type="text" data-table="videos" data-field="x_views" name="x<?php echo $videos_grid->RowIndex ?>_views" id="x<?php echo $videos_grid->RowIndex ?>_views" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($videos_grid->views->getPlaceHolder()) ?>" value="<?php echo $videos_grid->views->EditValue ?>"<?php echo $videos_grid->views->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($videos->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $videos_grid->RowCount ?>_videos_views">
<span<?php echo $videos_grid->views->viewAttributes() ?>><?php echo $videos_grid->views->getViewValue() ?></span>
</span>
<?php if (!$videos->isConfirm()) { ?>
<input type="hidden" data-table="videos" data-field="x_views" name="x<?php echo $videos_grid->RowIndex ?>_views" id="x<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_views" name="o<?php echo $videos_grid->RowIndex ?>_views" id="o<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="videos" data-field="x_views" name="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_views" id="fvideosgrid$x<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->FormValue) ?>">
<input type="hidden" data-table="videos" data-field="x_views" name="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_views" id="fvideosgrid$o<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$videos_grid->ListOptions->render("body", "right", $videos_grid->RowCount);
?>
	</tr>
<?php if ($videos->RowType == ROWTYPE_ADD || $videos->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fvideosgrid", "load"], function() {
	fvideosgrid.updateLists(<?php echo $videos_grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$videos_grid->isGridAdd() || $videos->CurrentMode == "copy")
		if (!$videos_grid->Recordset->EOF)
			$videos_grid->Recordset->moveNext();
}
?>
<?php
	if ($videos->CurrentMode == "add" || $videos->CurrentMode == "copy" || $videos->CurrentMode == "edit") {
		$videos_grid->RowIndex = '$rowindex$';
		$videos_grid->loadRowValues();

		// Set row properties
		$videos->resetAttributes();
		$videos->RowAttrs->merge(["data-rowindex" => $videos_grid->RowIndex, "id" => "r0_videos", "data-rowtype" => ROWTYPE_ADD]);
		$videos->RowAttrs->appendClass("ew-template");
		$videos->RowType = ROWTYPE_ADD;

		// Render row
		$videos_grid->renderRow();

		// Render list options
		$videos_grid->renderListOptions();
		$videos_grid->StartRowCount = 0;
?>
	<tr <?php echo $videos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$videos_grid->ListOptions->render("body", "left", $videos_grid->RowIndex);
?>
	<?php if ($videos_grid->titulo->Visible) { // titulo ?>
		<td data-name="titulo">
<?php if (!$videos->isConfirm()) { ?>
<span id="el$rowindex$_videos_titulo" class="form-group videos_titulo">
<input type="text" data-table="videos" data-field="x_titulo" name="x<?php echo $videos_grid->RowIndex ?>_titulo" id="x<?php echo $videos_grid->RowIndex ?>_titulo" size="30" maxlength="35" placeholder="<?php echo HtmlEncode($videos_grid->titulo->getPlaceHolder()) ?>" value="<?php echo $videos_grid->titulo->EditValue ?>"<?php echo $videos_grid->titulo->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_videos_titulo" class="form-group videos_titulo">
<span<?php echo $videos_grid->titulo->viewAttributes() ?>><?php if (!EmptyString($videos_grid->titulo->ViewValue) && $videos_grid->titulo->linkAttributes() != "") { ?>
<a<?php echo $videos_grid->titulo->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->titulo->ViewValue)) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->titulo->ViewValue)) ?>">
<?php } ?></span>
</span>
<input type="hidden" data-table="videos" data-field="x_titulo" name="x<?php echo $videos_grid->RowIndex ?>_titulo" id="x<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="videos" data-field="x_titulo" name="o<?php echo $videos_grid->RowIndex ?>_titulo" id="o<?php echo $videos_grid->RowIndex ?>_titulo" value="<?php echo HtmlEncode($videos_grid->titulo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($videos_grid->idaulas->Visible) { // idaulas ?>
		<td data-name="idaulas">
<?php if (!$videos->isConfirm()) { ?>
<?php if ($videos_grid->idaulas->getSessionValue() != "") { ?>
<span id="el$rowindex$_videos_idaulas" class="form-group videos_idaulas">
<span<?php echo $videos_grid->idaulas->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->idaulas->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_videos_idaulas" class="form-group videos_idaulas">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="videos" data-field="x_idaulas" data-value-separator="<?php echo $videos_grid->idaulas->displayValueSeparatorAttribute() ?>" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas"<?php echo $videos_grid->idaulas->editAttributes() ?>>
			<?php echo $videos_grid->idaulas->selectOptionListHtml("x{$videos_grid->RowIndex}_idaulas") ?>
		</select>
</div>
<?php echo $videos_grid->idaulas->Lookup->getParamTag($videos_grid, "p_x" . $videos_grid->RowIndex . "_idaulas") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_videos_idaulas" class="form-group videos_idaulas">
<span<?php echo $videos_grid->idaulas->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->idaulas->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="videos" data-field="x_idaulas" name="x<?php echo $videos_grid->RowIndex ?>_idaulas" id="x<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="videos" data-field="x_idaulas" name="o<?php echo $videos_grid->RowIndex ?>_idaulas" id="o<?php echo $videos_grid->RowIndex ?>_idaulas" value="<?php echo HtmlEncode($videos_grid->idaulas->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($videos_grid->ativo->Visible) { // ativo ?>
		<td data-name="ativo">
<?php if (!$videos->isConfirm()) { ?>
<span id="el$rowindex$_videos_ativo" class="form-group videos_ativo">
<div id="tp_x<?php echo $videos_grid->RowIndex ?>_ativo" class="ew-template"><input type="radio" class="custom-control-input" data-table="videos" data-field="x_ativo" data-value-separator="<?php echo $videos_grid->ativo->displayValueSeparatorAttribute() ?>" name="x<?php echo $videos_grid->RowIndex ?>_ativo" id="x<?php echo $videos_grid->RowIndex ?>_ativo" value="{value}"<?php echo $videos_grid->ativo->editAttributes() ?>></div>
<div id="dsl_x<?php echo $videos_grid->RowIndex ?>_ativo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $videos_grid->ativo->radioButtonListHtml(FALSE, "x{$videos_grid->RowIndex}_ativo") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_videos_ativo" class="form-group videos_ativo">
<span<?php echo $videos_grid->ativo->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->ativo->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="videos" data-field="x_ativo" name="x<?php echo $videos_grid->RowIndex ?>_ativo" id="x<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="videos" data-field="x_ativo" name="o<?php echo $videos_grid->RowIndex ?>_ativo" id="o<?php echo $videos_grid->RowIndex ?>_ativo" value="<?php echo HtmlEncode($videos_grid->ativo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($videos_grid->views->Visible) { // views ?>
		<td data-name="views">
<?php if (!$videos->isConfirm()) { ?>
<span id="el$rowindex$_videos_views" class="form-group videos_views">
<input type="text" data-table="videos" data-field="x_views" name="x<?php echo $videos_grid->RowIndex ?>_views" id="x<?php echo $videos_grid->RowIndex ?>_views" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($videos_grid->views->getPlaceHolder()) ?>" value="<?php echo $videos_grid->views->EditValue ?>"<?php echo $videos_grid->views->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_videos_views" class="form-group videos_views">
<span<?php echo $videos_grid->views->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_grid->views->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="videos" data-field="x_views" name="x<?php echo $videos_grid->RowIndex ?>_views" id="x<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="videos" data-field="x_views" name="o<?php echo $videos_grid->RowIndex ?>_views" id="o<?php echo $videos_grid->RowIndex ?>_views" value="<?php echo HtmlEncode($videos_grid->views->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$videos_grid->ListOptions->render("body", "right", $videos_grid->RowIndex);
?>
<script>
loadjs.ready(["fvideosgrid", "load"], function() {
	fvideosgrid.updateLists(<?php echo $videos_grid->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($videos->CurrentMode == "add" || $videos->CurrentMode == "copy") { ?>
<input type="hidden" name="<?php echo $videos_grid->FormKeyCountName ?>" id="<?php echo $videos_grid->FormKeyCountName ?>" value="<?php echo $videos_grid->KeyCount ?>">
<?php echo $videos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($videos->CurrentMode == "edit") { ?>
<input type="hidden" name="<?php echo $videos_grid->FormKeyCountName ?>" id="<?php echo $videos_grid->FormKeyCountName ?>" value="<?php echo $videos_grid->KeyCount ?>">
<?php echo $videos_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($videos->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvideosgrid">
</div><!-- /.ew-list-form -->
<?php

// Close recordset
if ($videos_grid->Recordset)
	$videos_grid->Recordset->Close();
?>
<?php if ($videos_grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $videos_grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($videos_grid->TotalRecords == 0 && !$videos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $videos_grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$videos_grid->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php
$videos_grid->terminate();
?>