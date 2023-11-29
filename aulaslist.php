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
$aulas_list = new aulas_list();

// Run the page
$aulas_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$aulas_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$aulas_list->isExport()) { ?>
<script>
var faulaslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	faulaslist = currentForm = new ew.Form("faulaslist", "list");
	faulaslist.formKeyCountName = '<?php echo $aulas_list->FormKeyCountName ?>';

	// Validate form
	faulaslist.validate = function() {
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
			<?php if ($aulas_list->idturnos->Required) { ?>
				elm = this.getElements("x" + infix + "_idturnos");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_list->idturnos->caption(), $aulas_list->idturnos->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_list->idaluno->Required) { ?>
				elm = this.getElements("x" + infix + "_idaluno");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_list->idaluno->caption(), $aulas_list->idaluno->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_list->nome->Required) { ?>
				elm = this.getElements("x" + infix + "_nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_list->nome->caption(), $aulas_list->nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_list->ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_list->ativado->caption(), $aulas_list->ativado->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
			} // End Grid Add checking
		}
		if (gridinsert && addcnt == 0) { // No row added
			ew.alert(ew.language.phrase("NoAddRecord"));
			return false;
		}
		return true;
	}

	// Check empty row
	faulaslist.emptyRow = function(infix) {
		var fobj = this._form;
		if (ew.valueChanged(fobj, infix, "idturnos", false)) return false;
		if (ew.valueChanged(fobj, infix, "idaluno", false)) return false;
		if (ew.valueChanged(fobj, infix, "nome", false)) return false;
		if (ew.valueChanged(fobj, infix, "ativado", false)) return false;
		return true;
	}

	// Form_CustomValidate
	faulaslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	faulaslist.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	faulaslist.lists["x_idturnos"] = <?php echo $aulas_list->idturnos->Lookup->toClientList($aulas_list) ?>;
	faulaslist.lists["x_idturnos"].options = <?php echo JsonEncode($aulas_list->idturnos->lookupOptions()) ?>;
	faulaslist.lists["x_idaluno"] = <?php echo $aulas_list->idaluno->Lookup->toClientList($aulas_list) ?>;
	faulaslist.lists["x_idaluno"].options = <?php echo JsonEncode($aulas_list->idaluno->lookupOptions()) ?>;
	faulaslist.lists["x_nome"] = <?php echo $aulas_list->nome->Lookup->toClientList($aulas_list) ?>;
	faulaslist.lists["x_nome"].options = <?php echo JsonEncode($aulas_list->nome->lookupOptions()) ?>;
	faulaslist.lists["x_ativado"] = <?php echo $aulas_list->ativado->Lookup->toClientList($aulas_list) ?>;
	faulaslist.lists["x_ativado"].options = <?php echo JsonEncode($aulas_list->ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("faulaslist");
});
var faulaslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	faulaslistsrch = currentSearchForm = new ew.Form("faulaslistsrch");

	// Dynamic selection lists
	// Filters

	faulaslistsrch.filterList = <?php echo $aulas_list->getFilterList() ?>;
	loadjs.done("faulaslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$aulas_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($aulas_list->TotalRecords > 0 && $aulas_list->ExportOptions->visible()) { ?>
<?php $aulas_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($aulas_list->ImportOptions->visible()) { ?>
<?php $aulas_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($aulas_list->SearchOptions->visible()) { ?>
<?php $aulas_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($aulas_list->FilterOptions->visible()) { ?>
<?php $aulas_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$aulas_list->isExport() || Config("EXPORT_MASTER_RECORD") && $aulas_list->isExport("print")) { ?>
<?php
if ($aulas_list->DbMasterFilter != "" && $aulas->getCurrentMasterTable() == "turnos") {
	if ($aulas_list->MasterRecordExists) {
		include_once "turnosmaster.php";
	}
}
?>
<?php } ?>
<?php
$aulas_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$aulas_list->isExport() && !$aulas->CurrentAction) { ?>
<form name="faulaslistsrch" id="faulaslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="faulaslistsrch-search-panel" class="<?php echo $aulas_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="aulas">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $aulas_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($aulas_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($aulas_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $aulas_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($aulas_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($aulas_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($aulas_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($aulas_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $aulas_list->showPageHeader(); ?>
<?php
$aulas_list->showMessage();
?>
<?php if ($aulas_list->TotalRecords > 0 || $aulas->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($aulas_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> aulas">
<?php if (!$aulas_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$aulas_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $aulas_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $aulas_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="faulaslist" id="faulaslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="aulas">
<?php if ($aulas->getCurrentMasterTable() == "turnos" && $aulas->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="turnos">
<input type="hidden" name="fk_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_aulas" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($aulas_list->TotalRecords > 0 || $aulas_list->isAdd() || $aulas_list->isCopy() || $aulas_list->isGridEdit()) { ?>
<table id="tbl_aulaslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$aulas->RowType = ROWTYPE_HEADER;

// Render list options
$aulas_list->renderListOptions();

// Render list options (header, left)
$aulas_list->ListOptions->render("header", "left");
?>
<?php if ($aulas_list->idturnos->Visible) { // idturnos ?>
	<?php if ($aulas_list->SortUrl($aulas_list->idturnos) == "") { ?>
		<th data-name="idturnos" class="<?php echo $aulas_list->idturnos->headerCellClass() ?>"><div id="elh_aulas_idturnos" class="aulas_idturnos"><div class="ew-table-header-caption"><?php echo $aulas_list->idturnos->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idturnos" class="<?php echo $aulas_list->idturnos->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $aulas_list->SortUrl($aulas_list->idturnos) ?>', 2);"><div id="elh_aulas_idturnos" class="aulas_idturnos">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_list->idturnos->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_list->idturnos->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_list->idturnos->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($aulas_list->idaluno->Visible) { // idaluno ?>
	<?php if ($aulas_list->SortUrl($aulas_list->idaluno) == "") { ?>
		<th data-name="idaluno" class="<?php echo $aulas_list->idaluno->headerCellClass() ?>"><div id="elh_aulas_idaluno" class="aulas_idaluno"><div class="ew-table-header-caption"><?php echo $aulas_list->idaluno->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idaluno" class="<?php echo $aulas_list->idaluno->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $aulas_list->SortUrl($aulas_list->idaluno) ?>', 2);"><div id="elh_aulas_idaluno" class="aulas_idaluno">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_list->idaluno->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_list->idaluno->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_list->idaluno->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($aulas_list->nome->Visible) { // nome ?>
	<?php if ($aulas_list->SortUrl($aulas_list->nome) == "") { ?>
		<th data-name="nome" class="<?php echo $aulas_list->nome->headerCellClass() ?>"><div id="elh_aulas_nome" class="aulas_nome"><div class="ew-table-header-caption"><?php echo $aulas_list->nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome" class="<?php echo $aulas_list->nome->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $aulas_list->SortUrl($aulas_list->nome) ?>', 2);"><div id="elh_aulas_nome" class="aulas_nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_list->nome->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_list->nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_list->nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($aulas_list->ativado->Visible) { // ativado ?>
	<?php if ($aulas_list->SortUrl($aulas_list->ativado) == "") { ?>
		<th data-name="ativado" class="<?php echo $aulas_list->ativado->headerCellClass() ?>"><div id="elh_aulas_ativado" class="aulas_ativado"><div class="ew-table-header-caption"><?php echo $aulas_list->ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativado" class="<?php echo $aulas_list->ativado->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $aulas_list->SortUrl($aulas_list->ativado) ?>', 2);"><div id="elh_aulas_ativado" class="aulas_ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $aulas_list->ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($aulas_list->ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($aulas_list->ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$aulas_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($aulas_list->isAdd() || $aulas_list->isCopy()) {
		$aulas_list->RowIndex = 0;
		$aulas_list->KeyCount = $aulas_list->RowIndex;
		if ($aulas_list->isAdd())
			$aulas_list->loadRowValues();
		if ($aulas->EventCancelled) // Insert failed
			$aulas_list->restoreFormValues(); // Restore form values

		// Set row properties
		$aulas->resetAttributes();
		$aulas->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_aulas", "data-rowtype" => ROWTYPE_ADD]);
		$aulas->RowType = ROWTYPE_ADD;

		// Render row
		$aulas_list->renderRow();

		// Render list options
		$aulas_list->renderListOptions();
		$aulas_list->StartRowCount = 0;
?>
	<tr <?php echo $aulas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$aulas_list->ListOptions->render("body", "left", $aulas_list->RowCount);
?>
	<?php if ($aulas_list->idturnos->Visible) { // idturnos ?>
		<td data-name="idturnos">
<?php if ($aulas_list->idturnos->getSessionValue() != "") { ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idturnos" class="form-group aulas_idturnos">
<span<?php echo $aulas_list->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_list->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $aulas_list->RowIndex ?>_idturnos" name="x<?php echo $aulas_list->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idturnos" class="form-group aulas_idturnos">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_list->idturnos->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_idturnos" name="x<?php echo $aulas_list->RowIndex ?>_idturnos"<?php echo $aulas_list->idturnos->editAttributes() ?>>
			<?php echo $aulas_list->idturnos->selectOptionListHtml("x{$aulas_list->RowIndex}_idturnos") ?>
		</select>
</div>
<?php echo $aulas_list->idturnos->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_idturnos") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="o<?php echo $aulas_list->RowIndex ?>_idturnos" id="o<?php echo $aulas_list->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_list->idaluno->Visible) { // idaluno ?>
		<td data-name="idaluno">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow($aulas->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idaluno" class="form-group aulas_idaluno">
<span<?php echo $aulas_list->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_list->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_list->RowIndex ?>_idaluno" id="x<?php echo $aulas_list->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_list->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idaluno" class="form-group aulas_idaluno">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_list->idaluno->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_idaluno" name="x<?php echo $aulas_list->RowIndex ?>_idaluno"<?php echo $aulas_list->idaluno->editAttributes() ?>>
			<?php echo $aulas_list->idaluno->selectOptionListHtml("x{$aulas_list->RowIndex}_idaluno") ?>
		</select>
</div>
<?php echo $aulas_list->idaluno->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_idaluno") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="o<?php echo $aulas_list->RowIndex ?>_idaluno" id="o<?php echo $aulas_list->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_list->idaluno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_list->nome->Visible) { // nome ?>
		<td data-name="nome">
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_nome" class="form-group aulas_nome">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_list->nome->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_nome" name="x<?php echo $aulas_list->RowIndex ?>_nome"<?php echo $aulas_list->nome->editAttributes() ?>>
			<?php echo $aulas_list->nome->selectOptionListHtml("x{$aulas_list->RowIndex}_nome") ?>
		</select>
</div>
<?php echo $aulas_list->nome->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_nome") ?>
</span>
<input type="hidden" data-table="aulas" data-field="x_nome" name="o<?php echo $aulas_list->RowIndex ?>_nome" id="o<?php echo $aulas_list->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_list->nome->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_list->ativado->Visible) { // ativado ?>
		<td data-name="ativado">
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_ativado" class="form-group aulas_ativado">
<div id="tp_x<?php echo $aulas_list->RowIndex ?>_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_list->ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $aulas_list->RowIndex ?>_ativado" id="x<?php echo $aulas_list->RowIndex ?>_ativado" value="{value}"<?php echo $aulas_list->ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $aulas_list->RowIndex ?>_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_list->ativado->radioButtonListHtml(FALSE, "x{$aulas_list->RowIndex}_ativado") ?>
</div></div>
</span>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="o<?php echo $aulas_list->RowIndex ?>_ativado" id="o<?php echo $aulas_list->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_list->ativado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$aulas_list->ListOptions->render("body", "right", $aulas_list->RowCount);
?>
<script>
loadjs.ready(["faulaslist", "load"], function() {
	faulaslist.updateLists(<?php echo $aulas_list->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
<?php
if ($aulas_list->ExportAll && $aulas_list->isExport()) {
	$aulas_list->StopRecord = $aulas_list->TotalRecords;
} else {

	// Set the last record to display
	if ($aulas_list->TotalRecords > $aulas_list->StartRecord + $aulas_list->DisplayRecords - 1)
		$aulas_list->StopRecord = $aulas_list->StartRecord + $aulas_list->DisplayRecords - 1;
	else
		$aulas_list->StopRecord = $aulas_list->TotalRecords;
}

// Restore number of post back records
if ($CurrentForm && ($aulas->isConfirm() || $aulas_list->EventCancelled)) {
	$CurrentForm->Index = -1;
	if ($CurrentForm->hasValue($aulas_list->FormKeyCountName) && ($aulas_list->isGridAdd() || $aulas_list->isGridEdit() || $aulas->isConfirm())) {
		$aulas_list->KeyCount = $CurrentForm->getValue($aulas_list->FormKeyCountName);
		$aulas_list->StopRecord = $aulas_list->StartRecord + $aulas_list->KeyCount - 1;
	}
}
$aulas_list->RecordCount = $aulas_list->StartRecord - 1;
if ($aulas_list->Recordset && !$aulas_list->Recordset->EOF) {
	$aulas_list->Recordset->moveFirst();
	$selectLimit = $aulas_list->UseSelectLimit;
	if (!$selectLimit && $aulas_list->StartRecord > 1)
		$aulas_list->Recordset->move($aulas_list->StartRecord - 1);
} elseif (!$aulas->AllowAddDeleteRow && $aulas_list->StopRecord == 0) {
	$aulas_list->StopRecord = $aulas->GridAddRowCount;
}

// Initialize aggregate
$aulas->RowType = ROWTYPE_AGGREGATEINIT;
$aulas->resetAttributes();
$aulas_list->renderRow();
if ($aulas_list->isGridAdd())
	$aulas_list->RowIndex = 0;
while ($aulas_list->RecordCount < $aulas_list->StopRecord) {
	$aulas_list->RecordCount++;
	if ($aulas_list->RecordCount >= $aulas_list->StartRecord) {
		$aulas_list->RowCount++;
		if ($aulas_list->isGridAdd() || $aulas_list->isGridEdit() || $aulas->isConfirm()) {
			$aulas_list->RowIndex++;
			$CurrentForm->Index = $aulas_list->RowIndex;
			if ($CurrentForm->hasValue($aulas_list->FormActionName) && ($aulas->isConfirm() || $aulas_list->EventCancelled))
				$aulas_list->RowAction = strval($CurrentForm->getValue($aulas_list->FormActionName));
			elseif ($aulas_list->isGridAdd())
				$aulas_list->RowAction = "insert";
			else
				$aulas_list->RowAction = "";
		}

		// Set up key count
		$aulas_list->KeyCount = $aulas_list->RowIndex;

		// Init row class and style
		$aulas->resetAttributes();
		$aulas->CssClass = "";
		if ($aulas_list->isGridAdd()) {
			$aulas_list->loadRowValues(); // Load default values
		} else {
			$aulas_list->loadRowValues($aulas_list->Recordset); // Load row values
		}
		$aulas->RowType = ROWTYPE_VIEW; // Render view
		if ($aulas_list->isGridAdd()) // Grid add
			$aulas->RowType = ROWTYPE_ADD; // Render add
		if ($aulas_list->isGridAdd() && $aulas->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) // Insert failed
			$aulas_list->restoreCurrentRowFormValues($aulas_list->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$aulas->RowAttrs->merge(["data-rowindex" => $aulas_list->RowCount, "id" => "r" . $aulas_list->RowCount . "_aulas", "data-rowtype" => $aulas->RowType]);

		// Render row
		$aulas_list->renderRow();

		// Render list options
		$aulas_list->renderListOptions();

		// Skip delete row / empty row for confirm page
		if ($aulas_list->RowAction != "delete" && $aulas_list->RowAction != "insertdelete" && !($aulas_list->RowAction == "insert" && $aulas->isConfirm() && $aulas_list->emptyRow())) {
?>
	<tr <?php echo $aulas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$aulas_list->ListOptions->render("body", "left", $aulas_list->RowCount);
?>
	<?php if ($aulas_list->idturnos->Visible) { // idturnos ?>
		<td data-name="idturnos" <?php echo $aulas_list->idturnos->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($aulas_list->idturnos->getSessionValue() != "") { ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idturnos" class="form-group">
<span<?php echo $aulas_list->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_list->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $aulas_list->RowIndex ?>_idturnos" name="x<?php echo $aulas_list->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idturnos" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_list->idturnos->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_idturnos" name="x<?php echo $aulas_list->RowIndex ?>_idturnos"<?php echo $aulas_list->idturnos->editAttributes() ?>>
			<?php echo $aulas_list->idturnos->selectOptionListHtml("x{$aulas_list->RowIndex}_idturnos") ?>
		</select>
</div>
<?php echo $aulas_list->idturnos->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_idturnos") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="o<?php echo $aulas_list->RowIndex ?>_idturnos" id="o<?php echo $aulas_list->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idturnos">
<span<?php echo $aulas_list->idturnos->viewAttributes() ?>><?php echo $aulas_list->idturnos->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($aulas_list->idaluno->Visible) { // idaluno ?>
		<td data-name="idaluno" <?php echo $aulas_list->idaluno->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow($aulas->CurrentAction)) { // Non system admin ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idaluno" class="form-group">
<span<?php echo $aulas_list->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_list->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_list->RowIndex ?>_idaluno" id="x<?php echo $aulas_list->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_list->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idaluno" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_list->idaluno->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_idaluno" name="x<?php echo $aulas_list->RowIndex ?>_idaluno"<?php echo $aulas_list->idaluno->editAttributes() ?>>
			<?php echo $aulas_list->idaluno->selectOptionListHtml("x{$aulas_list->RowIndex}_idaluno") ?>
		</select>
</div>
<?php echo $aulas_list->idaluno->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_idaluno") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="o<?php echo $aulas_list->RowIndex ?>_idaluno" id="o<?php echo $aulas_list->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_list->idaluno->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_idaluno">
<span<?php echo $aulas_list->idaluno->viewAttributes() ?>><?php echo $aulas_list->idaluno->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($aulas_list->nome->Visible) { // nome ?>
		<td data-name="nome" <?php echo $aulas_list->nome->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_nome" class="form-group">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_list->nome->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_nome" name="x<?php echo $aulas_list->RowIndex ?>_nome"<?php echo $aulas_list->nome->editAttributes() ?>>
			<?php echo $aulas_list->nome->selectOptionListHtml("x{$aulas_list->RowIndex}_nome") ?>
		</select>
</div>
<?php echo $aulas_list->nome->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_nome") ?>
</span>
<input type="hidden" data-table="aulas" data-field="x_nome" name="o<?php echo $aulas_list->RowIndex ?>_nome" id="o<?php echo $aulas_list->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_list->nome->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_nome">
<span<?php echo $aulas_list->nome->viewAttributes() ?>><?php echo $aulas_list->nome->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($aulas_list->ativado->Visible) { // ativado ?>
		<td data-name="ativado" <?php echo $aulas_list->ativado->cellAttributes() ?>>
<?php if ($aulas->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_ativado" class="form-group">
<div id="tp_x<?php echo $aulas_list->RowIndex ?>_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_list->ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $aulas_list->RowIndex ?>_ativado" id="x<?php echo $aulas_list->RowIndex ?>_ativado" value="{value}"<?php echo $aulas_list->ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $aulas_list->RowIndex ?>_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_list->ativado->radioButtonListHtml(FALSE, "x{$aulas_list->RowIndex}_ativado") ?>
</div></div>
</span>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="o<?php echo $aulas_list->RowIndex ?>_ativado" id="o<?php echo $aulas_list->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_list->ativado->OldValue) ?>">
<?php } ?>
<?php if ($aulas->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $aulas_list->RowCount ?>_aulas_ativado">
<span<?php echo $aulas_list->ativado->viewAttributes() ?>><?php echo $aulas_list->ativado->getViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$aulas_list->ListOptions->render("body", "right", $aulas_list->RowCount);
?>
	</tr>
<?php if ($aulas->RowType == ROWTYPE_ADD || $aulas->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["faulaslist", "load"], function() {
	faulaslist.updateLists(<?php echo $aulas_list->RowIndex ?>);
});
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if (!$aulas_list->isGridAdd())
		if (!$aulas_list->Recordset->EOF)
			$aulas_list->Recordset->moveNext();
}
?>
<?php
	if ($aulas_list->isGridAdd() || $aulas_list->isGridEdit()) {
		$aulas_list->RowIndex = '$rowindex$';
		$aulas_list->loadRowValues();

		// Set row properties
		$aulas->resetAttributes();
		$aulas->RowAttrs->merge(["data-rowindex" => $aulas_list->RowIndex, "id" => "r0_aulas", "data-rowtype" => ROWTYPE_ADD]);
		$aulas->RowAttrs->appendClass("ew-template");
		$aulas->RowType = ROWTYPE_ADD;

		// Render row
		$aulas_list->renderRow();

		// Render list options
		$aulas_list->renderListOptions();
		$aulas_list->StartRowCount = 0;
?>
	<tr <?php echo $aulas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$aulas_list->ListOptions->render("body", "left", $aulas_list->RowIndex);
?>
	<?php if ($aulas_list->idturnos->Visible) { // idturnos ?>
		<td data-name="idturnos">
<?php if ($aulas_list->idturnos->getSessionValue() != "") { ?>
<span id="el$rowindex$_aulas_idturnos" class="form-group aulas_idturnos">
<span<?php echo $aulas_list->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_list->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x<?php echo $aulas_list->RowIndex ?>_idturnos" name="x<?php echo $aulas_list->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_aulas_idturnos" class="form-group aulas_idturnos">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_list->idturnos->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_idturnos" name="x<?php echo $aulas_list->RowIndex ?>_idturnos"<?php echo $aulas_list->idturnos->editAttributes() ?>>
			<?php echo $aulas_list->idturnos->selectOptionListHtml("x{$aulas_list->RowIndex}_idturnos") ?>
		</select>
</div>
<?php echo $aulas_list->idturnos->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_idturnos") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idturnos" name="o<?php echo $aulas_list->RowIndex ?>_idturnos" id="o<?php echo $aulas_list->RowIndex ?>_idturnos" value="<?php echo HtmlEncode($aulas_list->idturnos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_list->idaluno->Visible) { // idaluno ?>
		<td data-name="idaluno">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow($aulas->CurrentAction)) { // Non system admin ?>
<span id="el$rowindex$_aulas_idaluno" class="form-group aulas_idaluno">
<span<?php echo $aulas_list->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_list->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x<?php echo $aulas_list->RowIndex ?>_idaluno" id="x<?php echo $aulas_list->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_list->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_aulas_idaluno" class="form-group aulas_idaluno">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_list->idaluno->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_idaluno" name="x<?php echo $aulas_list->RowIndex ?>_idaluno"<?php echo $aulas_list->idaluno->editAttributes() ?>>
			<?php echo $aulas_list->idaluno->selectOptionListHtml("x{$aulas_list->RowIndex}_idaluno") ?>
		</select>
</div>
<?php echo $aulas_list->idaluno->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_idaluno") ?>
</span>
<?php } ?>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="o<?php echo $aulas_list->RowIndex ?>_idaluno" id="o<?php echo $aulas_list->RowIndex ?>_idaluno" value="<?php echo HtmlEncode($aulas_list->idaluno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_list->nome->Visible) { // nome ?>
		<td data-name="nome">
<span id="el$rowindex$_aulas_nome" class="form-group aulas_nome">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_list->nome->displayValueSeparatorAttribute() ?>" id="x<?php echo $aulas_list->RowIndex ?>_nome" name="x<?php echo $aulas_list->RowIndex ?>_nome"<?php echo $aulas_list->nome->editAttributes() ?>>
			<?php echo $aulas_list->nome->selectOptionListHtml("x{$aulas_list->RowIndex}_nome") ?>
		</select>
</div>
<?php echo $aulas_list->nome->Lookup->getParamTag($aulas_list, "p_x" . $aulas_list->RowIndex . "_nome") ?>
</span>
<input type="hidden" data-table="aulas" data-field="x_nome" name="o<?php echo $aulas_list->RowIndex ?>_nome" id="o<?php echo $aulas_list->RowIndex ?>_nome" value="<?php echo HtmlEncode($aulas_list->nome->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($aulas_list->ativado->Visible) { // ativado ?>
		<td data-name="ativado">
<span id="el$rowindex$_aulas_ativado" class="form-group aulas_ativado">
<div id="tp_x<?php echo $aulas_list->RowIndex ?>_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_list->ativado->displayValueSeparatorAttribute() ?>" name="x<?php echo $aulas_list->RowIndex ?>_ativado" id="x<?php echo $aulas_list->RowIndex ?>_ativado" value="{value}"<?php echo $aulas_list->ativado->editAttributes() ?>></div>
<div id="dsl_x<?php echo $aulas_list->RowIndex ?>_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_list->ativado->radioButtonListHtml(FALSE, "x{$aulas_list->RowIndex}_ativado") ?>
</div></div>
</span>
<input type="hidden" data-table="aulas" data-field="x_ativado" name="o<?php echo $aulas_list->RowIndex ?>_ativado" id="o<?php echo $aulas_list->RowIndex ?>_ativado" value="<?php echo HtmlEncode($aulas_list->ativado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$aulas_list->ListOptions->render("body", "right", $aulas_list->RowIndex);
?>
<script>
loadjs.ready(["faulaslist", "load"], function() {
	faulaslist.updateLists(<?php echo $aulas_list->RowIndex ?>);
});
</script>
	</tr>
<?php
	}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($aulas_list->isAdd() || $aulas_list->isCopy()) { ?>
<input type="hidden" name="<?php echo $aulas_list->FormKeyCountName ?>" id="<?php echo $aulas_list->FormKeyCountName ?>" value="<?php echo $aulas_list->KeyCount ?>">
<?php } ?>
<?php if ($aulas_list->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?php echo $aulas_list->FormKeyCountName ?>" id="<?php echo $aulas_list->FormKeyCountName ?>" value="<?php echo $aulas_list->KeyCount ?>">
<?php echo $aulas_list->MultiSelectKey ?>
<?php } ?>
<?php if (!$aulas->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($aulas_list->Recordset)
	$aulas_list->Recordset->Close();
?>
<?php if (!$aulas_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$aulas_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $aulas_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $aulas_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($aulas_list->TotalRecords == 0 && !$aulas->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $aulas_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$aulas_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$aulas_list->isExport()) { ?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php } ?>
<?php include_once "footer.php"; ?>
<?php
$aulas_list->terminate();
?>