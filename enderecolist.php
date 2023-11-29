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
$endereco_list = new endereco_list();

// Run the page
$endereco_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$endereco_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$endereco_list->isExport()) { ?>
<script>
var fenderecolist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fenderecolist = currentForm = new ew.Form("fenderecolist", "list");
	fenderecolist.formKeyCountName = '<?php echo $endereco_list->FormKeyCountName ?>';
	loadjs.done("fenderecolist");
});
var fenderecolistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fenderecolistsrch = currentSearchForm = new ew.Form("fenderecolistsrch");

	// Dynamic selection lists
	// Filters

	fenderecolistsrch.filterList = <?php echo $endereco_list->getFilterList() ?>;
	loadjs.done("fenderecolistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$endereco_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($endereco_list->TotalRecords > 0 && $endereco_list->ExportOptions->visible()) { ?>
<?php $endereco_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($endereco_list->ImportOptions->visible()) { ?>
<?php $endereco_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($endereco_list->SearchOptions->visible()) { ?>
<?php $endereco_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($endereco_list->FilterOptions->visible()) { ?>
<?php $endereco_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$endereco_list->isExport() || Config("EXPORT_MASTER_RECORD") && $endereco_list->isExport("print")) { ?>
<?php
if ($endereco_list->DbMasterFilter != "" && $endereco->getCurrentMasterTable() == "academia") {
	if ($endereco_list->MasterRecordExists) {
		include_once "academiamaster.php";
	}
}
?>
<?php
if ($endereco_list->DbMasterFilter != "" && $endereco->getCurrentMasterTable() == "pessoa") {
	if ($endereco_list->MasterRecordExists) {
		include_once "pessoamaster.php";
	}
}
?>
<?php } ?>
<?php
$endereco_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$endereco_list->isExport() && !$endereco->CurrentAction) { ?>
<form name="fenderecolistsrch" id="fenderecolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fenderecolistsrch-search-panel" class="<?php echo $endereco_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="endereco">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $endereco_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($endereco_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($endereco_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $endereco_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($endereco_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($endereco_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($endereco_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($endereco_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $endereco_list->showPageHeader(); ?>
<?php
$endereco_list->showMessage();
?>
<?php if ($endereco_list->TotalRecords > 0 || $endereco->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($endereco_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> endereco">
<?php if (!$endereco_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$endereco_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $endereco_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $endereco_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fenderecolist" id="fenderecolist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="endereco">
<?php if ($endereco->getCurrentMasterTable() == "academia" && $endereco->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="academia">
<input type="hidden" name="fk_idacademia" value="<?php echo HtmlEncode($endereco_list->idacademia->getSessionValue()) ?>">
<?php } ?>
<?php if ($endereco->getCurrentMasterTable() == "pessoa" && $endereco->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="pessoa">
<input type="hidden" name="fk_idpessoa" value="<?php echo HtmlEncode($endereco_list->idpessoa->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_endereco" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($endereco_list->TotalRecords > 0 || $endereco_list->isGridEdit()) { ?>
<table id="tbl_enderecolist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$endereco->RowType = ROWTYPE_HEADER;

// Render list options
$endereco_list->renderListOptions();

// Render list options (header, left)
$endereco_list->ListOptions->render("header", "left");
?>
<?php if ($endereco_list->idacademia->Visible) { // idacademia ?>
	<?php if ($endereco_list->SortUrl($endereco_list->idacademia) == "") { ?>
		<th data-name="idacademia" class="<?php echo $endereco_list->idacademia->headerCellClass() ?>"><div id="elh_endereco_idacademia" class="endereco_idacademia"><div class="ew-table-header-caption"><?php echo $endereco_list->idacademia->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idacademia" class="<?php echo $endereco_list->idacademia->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->idacademia) ?>', 2);"><div id="elh_endereco_idacademia" class="endereco_idacademia">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->idacademia->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->idacademia->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->idacademia->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->idpessoa->Visible) { // idpessoa ?>
	<?php if ($endereco_list->SortUrl($endereco_list->idpessoa) == "") { ?>
		<th data-name="idpessoa" class="<?php echo $endereco_list->idpessoa->headerCellClass() ?>"><div id="elh_endereco_idpessoa" class="endereco_idpessoa"><div class="ew-table-header-caption"><?php echo $endereco_list->idpessoa->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpessoa" class="<?php echo $endereco_list->idpessoa->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->idpessoa) ?>', 2);"><div id="elh_endereco_idpessoa" class="endereco_idpessoa">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->idpessoa->caption() ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->idpessoa->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->idpessoa->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->CEP->Visible) { // CEP ?>
	<?php if ($endereco_list->SortUrl($endereco_list->CEP) == "") { ?>
		<th data-name="CEP" class="<?php echo $endereco_list->CEP->headerCellClass() ?>"><div id="elh_endereco_CEP" class="endereco_CEP"><div class="ew-table-header-caption"><?php echo $endereco_list->CEP->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CEP" class="<?php echo $endereco_list->CEP->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->CEP) ?>', 2);"><div id="elh_endereco_CEP" class="endereco_CEP">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->CEP->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->CEP->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->CEP->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->UF->Visible) { // UF ?>
	<?php if ($endereco_list->SortUrl($endereco_list->UF) == "") { ?>
		<th data-name="UF" class="<?php echo $endereco_list->UF->headerCellClass() ?>"><div id="elh_endereco_UF" class="endereco_UF"><div class="ew-table-header-caption"><?php echo $endereco_list->UF->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="UF" class="<?php echo $endereco_list->UF->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->UF) ?>', 2);"><div id="elh_endereco_UF" class="endereco_UF">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->UF->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->UF->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->UF->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->Cidade->Visible) { // Cidade ?>
	<?php if ($endereco_list->SortUrl($endereco_list->Cidade) == "") { ?>
		<th data-name="Cidade" class="<?php echo $endereco_list->Cidade->headerCellClass() ?>"><div id="elh_endereco_Cidade" class="endereco_Cidade"><div class="ew-table-header-caption"><?php echo $endereco_list->Cidade->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cidade" class="<?php echo $endereco_list->Cidade->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->Cidade) ?>', 2);"><div id="elh_endereco_Cidade" class="endereco_Cidade">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->Cidade->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->Cidade->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->Cidade->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->Bairro->Visible) { // Bairro ?>
	<?php if ($endereco_list->SortUrl($endereco_list->Bairro) == "") { ?>
		<th data-name="Bairro" class="<?php echo $endereco_list->Bairro->headerCellClass() ?>"><div id="elh_endereco_Bairro" class="endereco_Bairro"><div class="ew-table-header-caption"><?php echo $endereco_list->Bairro->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bairro" class="<?php echo $endereco_list->Bairro->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->Bairro) ?>', 2);"><div id="elh_endereco_Bairro" class="endereco_Bairro">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->Bairro->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->Bairro->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->Bairro->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->Rua->Visible) { // Rua ?>
	<?php if ($endereco_list->SortUrl($endereco_list->Rua) == "") { ?>
		<th data-name="Rua" class="<?php echo $endereco_list->Rua->headerCellClass() ?>"><div id="elh_endereco_Rua" class="endereco_Rua"><div class="ew-table-header-caption"><?php echo $endereco_list->Rua->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rua" class="<?php echo $endereco_list->Rua->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->Rua) ?>', 2);"><div id="elh_endereco_Rua" class="endereco_Rua">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->Rua->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->Rua->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->Rua->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->Numero->Visible) { // Numero ?>
	<?php if ($endereco_list->SortUrl($endereco_list->Numero) == "") { ?>
		<th data-name="Numero" class="<?php echo $endereco_list->Numero->headerCellClass() ?>"><div id="elh_endereco_Numero" class="endereco_Numero"><div class="ew-table-header-caption"><?php echo $endereco_list->Numero->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Numero" class="<?php echo $endereco_list->Numero->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->Numero) ?>', 2);"><div id="elh_endereco_Numero" class="endereco_Numero">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->Numero->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->Numero->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->Numero->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($endereco_list->Complemento->Visible) { // Complemento ?>
	<?php if ($endereco_list->SortUrl($endereco_list->Complemento) == "") { ?>
		<th data-name="Complemento" class="<?php echo $endereco_list->Complemento->headerCellClass() ?>"><div id="elh_endereco_Complemento" class="endereco_Complemento"><div class="ew-table-header-caption"><?php echo $endereco_list->Complemento->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Complemento" class="<?php echo $endereco_list->Complemento->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $endereco_list->SortUrl($endereco_list->Complemento) ?>', 2);"><div id="elh_endereco_Complemento" class="endereco_Complemento">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $endereco_list->Complemento->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($endereco_list->Complemento->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($endereco_list->Complemento->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$endereco_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($endereco_list->ExportAll && $endereco_list->isExport()) {
	$endereco_list->StopRecord = $endereco_list->TotalRecords;
} else {

	// Set the last record to display
	if ($endereco_list->TotalRecords > $endereco_list->StartRecord + $endereco_list->DisplayRecords - 1)
		$endereco_list->StopRecord = $endereco_list->StartRecord + $endereco_list->DisplayRecords - 1;
	else
		$endereco_list->StopRecord = $endereco_list->TotalRecords;
}
$endereco_list->RecordCount = $endereco_list->StartRecord - 1;
if ($endereco_list->Recordset && !$endereco_list->Recordset->EOF) {
	$endereco_list->Recordset->moveFirst();
	$selectLimit = $endereco_list->UseSelectLimit;
	if (!$selectLimit && $endereco_list->StartRecord > 1)
		$endereco_list->Recordset->move($endereco_list->StartRecord - 1);
} elseif (!$endereco->AllowAddDeleteRow && $endereco_list->StopRecord == 0) {
	$endereco_list->StopRecord = $endereco->GridAddRowCount;
}

// Initialize aggregate
$endereco->RowType = ROWTYPE_AGGREGATEINIT;
$endereco->resetAttributes();
$endereco_list->renderRow();
while ($endereco_list->RecordCount < $endereco_list->StopRecord) {
	$endereco_list->RecordCount++;
	if ($endereco_list->RecordCount >= $endereco_list->StartRecord) {
		$endereco_list->RowCount++;

		// Set up key count
		$endereco_list->KeyCount = $endereco_list->RowIndex;

		// Init row class and style
		$endereco->resetAttributes();
		$endereco->CssClass = "";
		if ($endereco_list->isGridAdd()) {
		} else {
			$endereco_list->loadRowValues($endereco_list->Recordset); // Load row values
		}
		$endereco->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$endereco->RowAttrs->merge(["data-rowindex" => $endereco_list->RowCount, "id" => "r" . $endereco_list->RowCount . "_endereco", "data-rowtype" => $endereco->RowType]);

		// Render row
		$endereco_list->renderRow();

		// Render list options
		$endereco_list->renderListOptions();
?>
	<tr <?php echo $endereco->rowAttributes() ?>>
<?php

// Render list options (body, left)
$endereco_list->ListOptions->render("body", "left", $endereco_list->RowCount);
?>
	<?php if ($endereco_list->idacademia->Visible) { // idacademia ?>
		<td data-name="idacademia" <?php echo $endereco_list->idacademia->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_idacademia">
<span<?php echo $endereco_list->idacademia->viewAttributes() ?>><?php echo $endereco_list->idacademia->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->idpessoa->Visible) { // idpessoa ?>
		<td data-name="idpessoa" <?php echo $endereco_list->idpessoa->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_idpessoa">
<span<?php echo $endereco_list->idpessoa->viewAttributes() ?>><?php echo $endereco_list->idpessoa->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->CEP->Visible) { // CEP ?>
		<td data-name="CEP" <?php echo $endereco_list->CEP->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_CEP">
<span<?php echo $endereco_list->CEP->viewAttributes() ?>><?php echo $endereco_list->CEP->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->UF->Visible) { // UF ?>
		<td data-name="UF" <?php echo $endereco_list->UF->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_UF">
<span<?php echo $endereco_list->UF->viewAttributes() ?>><?php echo $endereco_list->UF->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->Cidade->Visible) { // Cidade ?>
		<td data-name="Cidade" <?php echo $endereco_list->Cidade->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_Cidade">
<span<?php echo $endereco_list->Cidade->viewAttributes() ?>><?php echo $endereco_list->Cidade->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->Bairro->Visible) { // Bairro ?>
		<td data-name="Bairro" <?php echo $endereco_list->Bairro->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_Bairro">
<span<?php echo $endereco_list->Bairro->viewAttributes() ?>><?php echo $endereco_list->Bairro->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->Rua->Visible) { // Rua ?>
		<td data-name="Rua" <?php echo $endereco_list->Rua->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_Rua">
<span<?php echo $endereco_list->Rua->viewAttributes() ?>><?php echo $endereco_list->Rua->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->Numero->Visible) { // Numero ?>
		<td data-name="Numero" <?php echo $endereco_list->Numero->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_Numero">
<span<?php echo $endereco_list->Numero->viewAttributes() ?>><?php echo $endereco_list->Numero->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($endereco_list->Complemento->Visible) { // Complemento ?>
		<td data-name="Complemento" <?php echo $endereco_list->Complemento->cellAttributes() ?>>
<span id="el<?php echo $endereco_list->RowCount ?>_endereco_Complemento">
<span<?php echo $endereco_list->Complemento->viewAttributes() ?>><?php echo $endereco_list->Complemento->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$endereco_list->ListOptions->render("body", "right", $endereco_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$endereco_list->isGridAdd())
		$endereco_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$endereco->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($endereco_list->Recordset)
	$endereco_list->Recordset->Close();
?>
<?php if (!$endereco_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$endereco_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $endereco_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $endereco_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($endereco_list->TotalRecords == 0 && !$endereco->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $endereco_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$endereco_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$endereco_list->isExport()) { ?>
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
$endereco_list->terminate();
?>