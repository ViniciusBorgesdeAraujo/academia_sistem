<?php
namespace PHPMaker2020\project1;

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
$tipodocumento_list = new tipodocumento_list();

// Run the page
$tipodocumento_list->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumento_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$tipodocumento_list->isExport()) { ?>
<script>
var ftipodocumentolist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	ftipodocumentolist = currentForm = new ew.Form("ftipodocumentolist", "list");
	ftipodocumentolist.formKeyCountName = '<?php echo $tipodocumento_list->FormKeyCountName ?>';
	loadjs.done("ftipodocumentolist");
});
var ftipodocumentolistsrch;
loadjs.ready("head", function() {

	// Form object for search
	ftipodocumentolistsrch = currentSearchForm = new ew.Form("ftipodocumentolistsrch");

	// Dynamic selection lists
	// Filters

	ftipodocumentolistsrch.filterList = <?php echo $tipodocumento_list->getFilterList() ?>;
	loadjs.done("ftipodocumentolistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$tipodocumento_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($tipodocumento_list->TotalRecords > 0 && $tipodocumento_list->ExportOptions->visible()) { ?>
<?php $tipodocumento_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($tipodocumento_list->ImportOptions->visible()) { ?>
<?php $tipodocumento_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($tipodocumento_list->SearchOptions->visible()) { ?>
<?php $tipodocumento_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($tipodocumento_list->FilterOptions->visible()) { ?>
<?php $tipodocumento_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$tipodocumento_list->renderOtherOptions();
?>
<?php if (!$tipodocumento_list->isExport() && !$tipodocumento->CurrentAction) { ?>
<form name="ftipodocumentolistsrch" id="ftipodocumentolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="ftipodocumentolistsrch-search-panel" class="<?php echo $tipodocumento_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tipodocumento">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $tipodocumento_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($tipodocumento_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($tipodocumento_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $tipodocumento_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($tipodocumento_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($tipodocumento_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($tipodocumento_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($tipodocumento_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $tipodocumento_list->showPageHeader(); ?>
<?php
$tipodocumento_list->showMessage();
?>
<?php if ($tipodocumento_list->TotalRecords > 0 || $tipodocumento->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($tipodocumento_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tipodocumento">
<form name="ftipodocumentolist" id="ftipodocumentolist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumento">
<div id="gmp_tipodocumento" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($tipodocumento_list->TotalRecords > 0 || $tipodocumento_list->isGridEdit()) { ?>
<table id="tbl_tipodocumentolist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$tipodocumento->RowType = ROWTYPE_HEADER;

// Render list options
$tipodocumento_list->renderListOptions();

// Render list options (header, left)
$tipodocumento_list->ListOptions->render("header", "left");
?>
<?php if ($tipodocumento_list->idtipodocumento->Visible) { // idtipodocumento ?>
	<?php if ($tipodocumento_list->SortUrl($tipodocumento_list->idtipodocumento) == "") { ?>
		<th data-name="idtipodocumento" class="<?php echo $tipodocumento_list->idtipodocumento->headerCellClass() ?>"><div id="elh_tipodocumento_idtipodocumento" class="tipodocumento_idtipodocumento"><div class="ew-table-header-caption"><?php echo $tipodocumento_list->idtipodocumento->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipodocumento" class="<?php echo $tipodocumento_list->idtipodocumento->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $tipodocumento_list->SortUrl($tipodocumento_list->idtipodocumento) ?>', 1);"><div id="elh_tipodocumento_idtipodocumento" class="tipodocumento_idtipodocumento">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $tipodocumento_list->idtipodocumento->caption() ?></span><span class="ew-table-header-sort"><?php if ($tipodocumento_list->idtipodocumento->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($tipodocumento_list->idtipodocumento->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tipodocumento_list->Tipo->Visible) { // Tipo ?>
	<?php if ($tipodocumento_list->SortUrl($tipodocumento_list->Tipo) == "") { ?>
		<th data-name="Tipo" class="<?php echo $tipodocumento_list->Tipo->headerCellClass() ?>"><div id="elh_tipodocumento_Tipo" class="tipodocumento_Tipo"><div class="ew-table-header-caption"><?php echo $tipodocumento_list->Tipo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tipo" class="<?php echo $tipodocumento_list->Tipo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $tipodocumento_list->SortUrl($tipodocumento_list->Tipo) ?>', 1);"><div id="elh_tipodocumento_Tipo" class="tipodocumento_Tipo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $tipodocumento_list->Tipo->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($tipodocumento_list->Tipo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($tipodocumento_list->Tipo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tipodocumento_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tipodocumento_list->ExportAll && $tipodocumento_list->isExport()) {
	$tipodocumento_list->StopRecord = $tipodocumento_list->TotalRecords;
} else {

	// Set the last record to display
	if ($tipodocumento_list->TotalRecords > $tipodocumento_list->StartRecord + $tipodocumento_list->DisplayRecords - 1)
		$tipodocumento_list->StopRecord = $tipodocumento_list->StartRecord + $tipodocumento_list->DisplayRecords - 1;
	else
		$tipodocumento_list->StopRecord = $tipodocumento_list->TotalRecords;
}
$tipodocumento_list->RecordCount = $tipodocumento_list->StartRecord - 1;
if ($tipodocumento_list->Recordset && !$tipodocumento_list->Recordset->EOF) {
	$tipodocumento_list->Recordset->moveFirst();
	$selectLimit = $tipodocumento_list->UseSelectLimit;
	if (!$selectLimit && $tipodocumento_list->StartRecord > 1)
		$tipodocumento_list->Recordset->move($tipodocumento_list->StartRecord - 1);
} elseif (!$tipodocumento->AllowAddDeleteRow && $tipodocumento_list->StopRecord == 0) {
	$tipodocumento_list->StopRecord = $tipodocumento->GridAddRowCount;
}

// Initialize aggregate
$tipodocumento->RowType = ROWTYPE_AGGREGATEINIT;
$tipodocumento->resetAttributes();
$tipodocumento_list->renderRow();
while ($tipodocumento_list->RecordCount < $tipodocumento_list->StopRecord) {
	$tipodocumento_list->RecordCount++;
	if ($tipodocumento_list->RecordCount >= $tipodocumento_list->StartRecord) {
		$tipodocumento_list->RowCount++;

		// Set up key count
		$tipodocumento_list->KeyCount = $tipodocumento_list->RowIndex;

		// Init row class and style
		$tipodocumento->resetAttributes();
		$tipodocumento->CssClass = "";
		if ($tipodocumento_list->isGridAdd()) {
		} else {
			$tipodocumento_list->loadRowValues($tipodocumento_list->Recordset); // Load row values
		}
		$tipodocumento->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tipodocumento->RowAttrs->merge(["data-rowindex" => $tipodocumento_list->RowCount, "id" => "r" . $tipodocumento_list->RowCount . "_tipodocumento", "data-rowtype" => $tipodocumento->RowType]);

		// Render row
		$tipodocumento_list->renderRow();

		// Render list options
		$tipodocumento_list->renderListOptions();
?>
	<tr <?php echo $tipodocumento->rowAttributes() ?>>
<?php

// Render list options (body, left)
$tipodocumento_list->ListOptions->render("body", "left", $tipodocumento_list->RowCount);
?>
	<?php if ($tipodocumento_list->idtipodocumento->Visible) { // idtipodocumento ?>
		<td data-name="idtipodocumento" <?php echo $tipodocumento_list->idtipodocumento->cellAttributes() ?>>
<span id="el<?php echo $tipodocumento_list->RowCount ?>_tipodocumento_idtipodocumento">
<span<?php echo $tipodocumento_list->idtipodocumento->viewAttributes() ?>><?php echo $tipodocumento_list->idtipodocumento->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tipodocumento_list->Tipo->Visible) { // Tipo ?>
		<td data-name="Tipo" <?php echo $tipodocumento_list->Tipo->cellAttributes() ?>>
<span id="el<?php echo $tipodocumento_list->RowCount ?>_tipodocumento_Tipo">
<span<?php echo $tipodocumento_list->Tipo->viewAttributes() ?>><?php echo $tipodocumento_list->Tipo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tipodocumento_list->ListOptions->render("body", "right", $tipodocumento_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$tipodocumento_list->isGridAdd())
		$tipodocumento_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$tipodocumento->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($tipodocumento_list->Recordset)
	$tipodocumento_list->Recordset->Close();
?>
<?php if (!$tipodocumento_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$tipodocumento_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $tipodocumento_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $tipodocumento_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($tipodocumento_list->TotalRecords == 0 && !$tipodocumento->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $tipodocumento_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$tipodocumento_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$tipodocumento_list->isExport()) { ?>
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
$tipodocumento_list->terminate();
?>