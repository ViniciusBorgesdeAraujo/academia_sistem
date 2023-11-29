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
$tipodocumentos_list = new tipodocumentos_list();

// Run the page
$tipodocumentos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumentos_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$tipodocumentos_list->isExport()) { ?>
<script>
var ftipodocumentoslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	ftipodocumentoslist = currentForm = new ew.Form("ftipodocumentoslist", "list");
	ftipodocumentoslist.formKeyCountName = '<?php echo $tipodocumentos_list->FormKeyCountName ?>';
	loadjs.done("ftipodocumentoslist");
});
var ftipodocumentoslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	ftipodocumentoslistsrch = currentSearchForm = new ew.Form("ftipodocumentoslistsrch");

	// Dynamic selection lists
	// Filters

	ftipodocumentoslistsrch.filterList = <?php echo $tipodocumentos_list->getFilterList() ?>;
	loadjs.done("ftipodocumentoslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$tipodocumentos_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($tipodocumentos_list->TotalRecords > 0 && $tipodocumentos_list->ExportOptions->visible()) { ?>
<?php $tipodocumentos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($tipodocumentos_list->ImportOptions->visible()) { ?>
<?php $tipodocumentos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($tipodocumentos_list->SearchOptions->visible()) { ?>
<?php $tipodocumentos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($tipodocumentos_list->FilterOptions->visible()) { ?>
<?php $tipodocumentos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$tipodocumentos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$tipodocumentos_list->isExport() && !$tipodocumentos->CurrentAction) { ?>
<form name="ftipodocumentoslistsrch" id="ftipodocumentoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="ftipodocumentoslistsrch-search-panel" class="<?php echo $tipodocumentos_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tipodocumentos">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $tipodocumentos_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($tipodocumentos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($tipodocumentos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $tipodocumentos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($tipodocumentos_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($tipodocumentos_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($tipodocumentos_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($tipodocumentos_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $tipodocumentos_list->showPageHeader(); ?>
<?php
$tipodocumentos_list->showMessage();
?>
<?php if ($tipodocumentos_list->TotalRecords > 0 || $tipodocumentos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($tipodocumentos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tipodocumentos">
<?php if (!$tipodocumentos_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$tipodocumentos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $tipodocumentos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $tipodocumentos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftipodocumentoslist" id="ftipodocumentoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumentos">
<div id="gmp_tipodocumentos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($tipodocumentos_list->TotalRecords > 0 || $tipodocumentos_list->isGridEdit()) { ?>
<table id="tbl_tipodocumentoslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$tipodocumentos->RowType = ROWTYPE_HEADER;

// Render list options
$tipodocumentos_list->renderListOptions();

// Render list options (header, left)
$tipodocumentos_list->ListOptions->render("header", "left");
?>
<?php if ($tipodocumentos_list->idtipodocumentos->Visible) { // idtipodocumentos ?>
	<?php if ($tipodocumentos_list->SortUrl($tipodocumentos_list->idtipodocumentos) == "") { ?>
		<th data-name="idtipodocumentos" class="<?php echo $tipodocumentos_list->idtipodocumentos->headerCellClass() ?>"><div id="elh_tipodocumentos_idtipodocumentos" class="tipodocumentos_idtipodocumentos"><div class="ew-table-header-caption"><?php echo $tipodocumentos_list->idtipodocumentos->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipodocumentos" class="<?php echo $tipodocumentos_list->idtipodocumentos->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $tipodocumentos_list->SortUrl($tipodocumentos_list->idtipodocumentos) ?>', 1);"><div id="elh_tipodocumentos_idtipodocumentos" class="tipodocumentos_idtipodocumentos">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $tipodocumentos_list->idtipodocumentos->caption() ?></span><span class="ew-table-header-sort"><?php if ($tipodocumentos_list->idtipodocumentos->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($tipodocumentos_list->idtipodocumentos->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tipodocumentos_list->Tipo->Visible) { // Tipo ?>
	<?php if ($tipodocumentos_list->SortUrl($tipodocumentos_list->Tipo) == "") { ?>
		<th data-name="Tipo" class="<?php echo $tipodocumentos_list->Tipo->headerCellClass() ?>"><div id="elh_tipodocumentos_Tipo" class="tipodocumentos_Tipo"><div class="ew-table-header-caption"><?php echo $tipodocumentos_list->Tipo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tipo" class="<?php echo $tipodocumentos_list->Tipo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $tipodocumentos_list->SortUrl($tipodocumentos_list->Tipo) ?>', 1);"><div id="elh_tipodocumentos_Tipo" class="tipodocumentos_Tipo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $tipodocumentos_list->Tipo->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($tipodocumentos_list->Tipo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($tipodocumentos_list->Tipo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tipodocumentos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tipodocumentos_list->ExportAll && $tipodocumentos_list->isExport()) {
	$tipodocumentos_list->StopRecord = $tipodocumentos_list->TotalRecords;
} else {

	// Set the last record to display
	if ($tipodocumentos_list->TotalRecords > $tipodocumentos_list->StartRecord + $tipodocumentos_list->DisplayRecords - 1)
		$tipodocumentos_list->StopRecord = $tipodocumentos_list->StartRecord + $tipodocumentos_list->DisplayRecords - 1;
	else
		$tipodocumentos_list->StopRecord = $tipodocumentos_list->TotalRecords;
}
$tipodocumentos_list->RecordCount = $tipodocumentos_list->StartRecord - 1;
if ($tipodocumentos_list->Recordset && !$tipodocumentos_list->Recordset->EOF) {
	$tipodocumentos_list->Recordset->moveFirst();
	$selectLimit = $tipodocumentos_list->UseSelectLimit;
	if (!$selectLimit && $tipodocumentos_list->StartRecord > 1)
		$tipodocumentos_list->Recordset->move($tipodocumentos_list->StartRecord - 1);
} elseif (!$tipodocumentos->AllowAddDeleteRow && $tipodocumentos_list->StopRecord == 0) {
	$tipodocumentos_list->StopRecord = $tipodocumentos->GridAddRowCount;
}

// Initialize aggregate
$tipodocumentos->RowType = ROWTYPE_AGGREGATEINIT;
$tipodocumentos->resetAttributes();
$tipodocumentos_list->renderRow();
while ($tipodocumentos_list->RecordCount < $tipodocumentos_list->StopRecord) {
	$tipodocumentos_list->RecordCount++;
	if ($tipodocumentos_list->RecordCount >= $tipodocumentos_list->StartRecord) {
		$tipodocumentos_list->RowCount++;

		// Set up key count
		$tipodocumentos_list->KeyCount = $tipodocumentos_list->RowIndex;

		// Init row class and style
		$tipodocumentos->resetAttributes();
		$tipodocumentos->CssClass = "";
		if ($tipodocumentos_list->isGridAdd()) {
		} else {
			$tipodocumentos_list->loadRowValues($tipodocumentos_list->Recordset); // Load row values
		}
		$tipodocumentos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tipodocumentos->RowAttrs->merge(["data-rowindex" => $tipodocumentos_list->RowCount, "id" => "r" . $tipodocumentos_list->RowCount . "_tipodocumentos", "data-rowtype" => $tipodocumentos->RowType]);

		// Render row
		$tipodocumentos_list->renderRow();

		// Render list options
		$tipodocumentos_list->renderListOptions();
?>
	<tr <?php echo $tipodocumentos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$tipodocumentos_list->ListOptions->render("body", "left", $tipodocumentos_list->RowCount);
?>
	<?php if ($tipodocumentos_list->idtipodocumentos->Visible) { // idtipodocumentos ?>
		<td data-name="idtipodocumentos" <?php echo $tipodocumentos_list->idtipodocumentos->cellAttributes() ?>>
<span id="el<?php echo $tipodocumentos_list->RowCount ?>_tipodocumentos_idtipodocumentos">
<span<?php echo $tipodocumentos_list->idtipodocumentos->viewAttributes() ?>><?php echo $tipodocumentos_list->idtipodocumentos->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tipodocumentos_list->Tipo->Visible) { // Tipo ?>
		<td data-name="Tipo" <?php echo $tipodocumentos_list->Tipo->cellAttributes() ?>>
<span id="el<?php echo $tipodocumentos_list->RowCount ?>_tipodocumentos_Tipo">
<span<?php echo $tipodocumentos_list->Tipo->viewAttributes() ?>><?php echo $tipodocumentos_list->Tipo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tipodocumentos_list->ListOptions->render("body", "right", $tipodocumentos_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$tipodocumentos_list->isGridAdd())
		$tipodocumentos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$tipodocumentos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($tipodocumentos_list->Recordset)
	$tipodocumentos_list->Recordset->Close();
?>
<?php if (!$tipodocumentos_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$tipodocumentos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $tipodocumentos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $tipodocumentos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($tipodocumentos_list->TotalRecords == 0 && !$tipodocumentos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $tipodocumentos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$tipodocumentos_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$tipodocumentos_list->isExport()) { ?>
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
$tipodocumentos_list->terminate();
?>