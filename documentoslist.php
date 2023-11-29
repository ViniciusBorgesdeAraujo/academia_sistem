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
$documentos_list = new documentos_list();

// Run the page
$documentos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documentos_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$documentos_list->isExport()) { ?>
<script>
var fdocumentoslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fdocumentoslist = currentForm = new ew.Form("fdocumentoslist", "list");
	fdocumentoslist.formKeyCountName = '<?php echo $documentos_list->FormKeyCountName ?>';
	loadjs.done("fdocumentoslist");
});
var fdocumentoslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fdocumentoslistsrch = currentSearchForm = new ew.Form("fdocumentoslistsrch");

	// Dynamic selection lists
	// Filters

	fdocumentoslistsrch.filterList = <?php echo $documentos_list->getFilterList() ?>;
	loadjs.done("fdocumentoslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$documentos_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($documentos_list->TotalRecords > 0 && $documentos_list->ExportOptions->visible()) { ?>
<?php $documentos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($documentos_list->ImportOptions->visible()) { ?>
<?php $documentos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($documentos_list->SearchOptions->visible()) { ?>
<?php $documentos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($documentos_list->FilterOptions->visible()) { ?>
<?php $documentos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$documentos_list->isExport() || Config("EXPORT_MASTER_RECORD") && $documentos_list->isExport("print")) { ?>
<?php
if ($documentos_list->DbMasterFilter != "" && $documentos->getCurrentMasterTable() == "pessoa") {
	if ($documentos_list->MasterRecordExists) {
		include_once "pessoamaster.php";
	}
}
?>
<?php } ?>
<?php
$documentos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$documentos_list->isExport() && !$documentos->CurrentAction) { ?>
<form name="fdocumentoslistsrch" id="fdocumentoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fdocumentoslistsrch-search-panel" class="<?php echo $documentos_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="documentos">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $documentos_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($documentos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($documentos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $documentos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($documentos_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($documentos_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($documentos_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($documentos_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $documentos_list->showPageHeader(); ?>
<?php
$documentos_list->showMessage();
?>
<?php if ($documentos_list->TotalRecords > 0 || $documentos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($documentos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> documentos">
<?php if (!$documentos_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$documentos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $documentos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $documentos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fdocumentoslist" id="fdocumentoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documentos">
<?php if ($documentos->getCurrentMasterTable() == "pessoa" && $documentos->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="pessoa">
<input type="hidden" name="fk_idpessoa" value="<?php echo HtmlEncode($documentos_list->idpessoa->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_documentos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($documentos_list->TotalRecords > 0 || $documentos_list->isGridEdit()) { ?>
<table id="tbl_documentoslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$documentos->RowType = ROWTYPE_HEADER;

// Render list options
$documentos_list->renderListOptions();

// Render list options (header, left)
$documentos_list->ListOptions->render("header", "left");
?>
<?php if ($documentos_list->idpessoa->Visible) { // idpessoa ?>
	<?php if ($documentos_list->SortUrl($documentos_list->idpessoa) == "") { ?>
		<th data-name="idpessoa" class="<?php echo $documentos_list->idpessoa->headerCellClass() ?>"><div id="elh_documentos_idpessoa" class="documentos_idpessoa"><div class="ew-table-header-caption"><?php echo $documentos_list->idpessoa->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpessoa" class="<?php echo $documentos_list->idpessoa->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $documentos_list->SortUrl($documentos_list->idpessoa) ?>', 2);"><div id="elh_documentos_idpessoa" class="documentos_idpessoa">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $documentos_list->idpessoa->caption() ?></span><span class="ew-table-header-sort"><?php if ($documentos_list->idpessoa->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($documentos_list->idpessoa->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($documentos_list->tipo->Visible) { // tipo ?>
	<?php if ($documentos_list->SortUrl($documentos_list->tipo) == "") { ?>
		<th data-name="tipo" class="<?php echo $documentos_list->tipo->headerCellClass() ?>"><div id="elh_documentos_tipo" class="documentos_tipo"><div class="ew-table-header-caption"><?php echo $documentos_list->tipo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo" class="<?php echo $documentos_list->tipo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $documentos_list->SortUrl($documentos_list->tipo) ?>', 2);"><div id="elh_documentos_tipo" class="documentos_tipo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $documentos_list->tipo->caption() ?></span><span class="ew-table-header-sort"><?php if ($documentos_list->tipo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($documentos_list->tipo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($documentos_list->numero->Visible) { // numero ?>
	<?php if ($documentos_list->SortUrl($documentos_list->numero) == "") { ?>
		<th data-name="numero" class="<?php echo $documentos_list->numero->headerCellClass() ?>"><div id="elh_documentos_numero" class="documentos_numero"><div class="ew-table-header-caption"><?php echo $documentos_list->numero->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero" class="<?php echo $documentos_list->numero->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $documentos_list->SortUrl($documentos_list->numero) ?>', 2);"><div id="elh_documentos_numero" class="documentos_numero">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $documentos_list->numero->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($documentos_list->numero->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($documentos_list->numero->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$documentos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($documentos_list->ExportAll && $documentos_list->isExport()) {
	$documentos_list->StopRecord = $documentos_list->TotalRecords;
} else {

	// Set the last record to display
	if ($documentos_list->TotalRecords > $documentos_list->StartRecord + $documentos_list->DisplayRecords - 1)
		$documentos_list->StopRecord = $documentos_list->StartRecord + $documentos_list->DisplayRecords - 1;
	else
		$documentos_list->StopRecord = $documentos_list->TotalRecords;
}
$documentos_list->RecordCount = $documentos_list->StartRecord - 1;
if ($documentos_list->Recordset && !$documentos_list->Recordset->EOF) {
	$documentos_list->Recordset->moveFirst();
	$selectLimit = $documentos_list->UseSelectLimit;
	if (!$selectLimit && $documentos_list->StartRecord > 1)
		$documentos_list->Recordset->move($documentos_list->StartRecord - 1);
} elseif (!$documentos->AllowAddDeleteRow && $documentos_list->StopRecord == 0) {
	$documentos_list->StopRecord = $documentos->GridAddRowCount;
}

// Initialize aggregate
$documentos->RowType = ROWTYPE_AGGREGATEINIT;
$documentos->resetAttributes();
$documentos_list->renderRow();
while ($documentos_list->RecordCount < $documentos_list->StopRecord) {
	$documentos_list->RecordCount++;
	if ($documentos_list->RecordCount >= $documentos_list->StartRecord) {
		$documentos_list->RowCount++;

		// Set up key count
		$documentos_list->KeyCount = $documentos_list->RowIndex;

		// Init row class and style
		$documentos->resetAttributes();
		$documentos->CssClass = "";
		if ($documentos_list->isGridAdd()) {
		} else {
			$documentos_list->loadRowValues($documentos_list->Recordset); // Load row values
		}
		$documentos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$documentos->RowAttrs->merge(["data-rowindex" => $documentos_list->RowCount, "id" => "r" . $documentos_list->RowCount . "_documentos", "data-rowtype" => $documentos->RowType]);

		// Render row
		$documentos_list->renderRow();

		// Render list options
		$documentos_list->renderListOptions();
?>
	<tr <?php echo $documentos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$documentos_list->ListOptions->render("body", "left", $documentos_list->RowCount);
?>
	<?php if ($documentos_list->idpessoa->Visible) { // idpessoa ?>
		<td data-name="idpessoa" <?php echo $documentos_list->idpessoa->cellAttributes() ?>>
<span id="el<?php echo $documentos_list->RowCount ?>_documentos_idpessoa">
<span<?php echo $documentos_list->idpessoa->viewAttributes() ?>><?php echo $documentos_list->idpessoa->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($documentos_list->tipo->Visible) { // tipo ?>
		<td data-name="tipo" <?php echo $documentos_list->tipo->cellAttributes() ?>>
<span id="el<?php echo $documentos_list->RowCount ?>_documentos_tipo">
<span<?php echo $documentos_list->tipo->viewAttributes() ?>><?php echo $documentos_list->tipo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($documentos_list->numero->Visible) { // numero ?>
		<td data-name="numero" <?php echo $documentos_list->numero->cellAttributes() ?>>
<span id="el<?php echo $documentos_list->RowCount ?>_documentos_numero">
<span<?php echo $documentos_list->numero->viewAttributes() ?>><?php echo $documentos_list->numero->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documentos_list->ListOptions->render("body", "right", $documentos_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$documentos_list->isGridAdd())
		$documentos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$documentos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($documentos_list->Recordset)
	$documentos_list->Recordset->Close();
?>
<?php if (!$documentos_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$documentos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $documentos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $documentos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($documentos_list->TotalRecords == 0 && !$documentos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $documentos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$documentos_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$documentos_list->isExport()) { ?>
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
$documentos_list->terminate();
?>