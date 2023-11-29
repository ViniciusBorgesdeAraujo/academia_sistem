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
$funcao_list = new funcao_list();

// Run the page
$funcao_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$funcao_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$funcao_list->isExport()) { ?>
<script>
var ffuncaolist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	ffuncaolist = currentForm = new ew.Form("ffuncaolist", "list");
	ffuncaolist.formKeyCountName = '<?php echo $funcao_list->FormKeyCountName ?>';
	loadjs.done("ffuncaolist");
});
var ffuncaolistsrch;
loadjs.ready("head", function() {

	// Form object for search
	ffuncaolistsrch = currentSearchForm = new ew.Form("ffuncaolistsrch");

	// Dynamic selection lists
	// Filters

	ffuncaolistsrch.filterList = <?php echo $funcao_list->getFilterList() ?>;
	loadjs.done("ffuncaolistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$funcao_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($funcao_list->TotalRecords > 0 && $funcao_list->ExportOptions->visible()) { ?>
<?php $funcao_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($funcao_list->ImportOptions->visible()) { ?>
<?php $funcao_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($funcao_list->SearchOptions->visible()) { ?>
<?php $funcao_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($funcao_list->FilterOptions->visible()) { ?>
<?php $funcao_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$funcao_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$funcao_list->isExport() && !$funcao->CurrentAction) { ?>
<form name="ffuncaolistsrch" id="ffuncaolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="ffuncaolistsrch-search-panel" class="<?php echo $funcao_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="funcao">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $funcao_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($funcao_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($funcao_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $funcao_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($funcao_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($funcao_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($funcao_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($funcao_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $funcao_list->showPageHeader(); ?>
<?php
$funcao_list->showMessage();
?>
<?php if ($funcao_list->TotalRecords > 0 || $funcao->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($funcao_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> funcao">
<?php if (!$funcao_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$funcao_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $funcao_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $funcao_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ffuncaolist" id="ffuncaolist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="funcao">
<div id="gmp_funcao" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($funcao_list->TotalRecords > 0 || $funcao_list->isGridEdit()) { ?>
<table id="tbl_funcaolist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$funcao->RowType = ROWTYPE_HEADER;

// Render list options
$funcao_list->renderListOptions();

// Render list options (header, left)
$funcao_list->ListOptions->render("header", "left");
?>
<?php if ($funcao_list->funcao->Visible) { // funcao ?>
	<?php if ($funcao_list->SortUrl($funcao_list->funcao) == "") { ?>
		<th data-name="funcao" class="<?php echo $funcao_list->funcao->headerCellClass() ?>"><div id="elh_funcao_funcao" class="funcao_funcao"><div class="ew-table-header-caption"><?php echo $funcao_list->funcao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="funcao" class="<?php echo $funcao_list->funcao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $funcao_list->SortUrl($funcao_list->funcao) ?>', 1);"><div id="elh_funcao_funcao" class="funcao_funcao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $funcao_list->funcao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($funcao_list->funcao->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($funcao_list->funcao->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$funcao_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($funcao_list->ExportAll && $funcao_list->isExport()) {
	$funcao_list->StopRecord = $funcao_list->TotalRecords;
} else {

	// Set the last record to display
	if ($funcao_list->TotalRecords > $funcao_list->StartRecord + $funcao_list->DisplayRecords - 1)
		$funcao_list->StopRecord = $funcao_list->StartRecord + $funcao_list->DisplayRecords - 1;
	else
		$funcao_list->StopRecord = $funcao_list->TotalRecords;
}
$funcao_list->RecordCount = $funcao_list->StartRecord - 1;
if ($funcao_list->Recordset && !$funcao_list->Recordset->EOF) {
	$funcao_list->Recordset->moveFirst();
	$selectLimit = $funcao_list->UseSelectLimit;
	if (!$selectLimit && $funcao_list->StartRecord > 1)
		$funcao_list->Recordset->move($funcao_list->StartRecord - 1);
} elseif (!$funcao->AllowAddDeleteRow && $funcao_list->StopRecord == 0) {
	$funcao_list->StopRecord = $funcao->GridAddRowCount;
}

// Initialize aggregate
$funcao->RowType = ROWTYPE_AGGREGATEINIT;
$funcao->resetAttributes();
$funcao_list->renderRow();
while ($funcao_list->RecordCount < $funcao_list->StopRecord) {
	$funcao_list->RecordCount++;
	if ($funcao_list->RecordCount >= $funcao_list->StartRecord) {
		$funcao_list->RowCount++;

		// Set up key count
		$funcao_list->KeyCount = $funcao_list->RowIndex;

		// Init row class and style
		$funcao->resetAttributes();
		$funcao->CssClass = "";
		if ($funcao_list->isGridAdd()) {
		} else {
			$funcao_list->loadRowValues($funcao_list->Recordset); // Load row values
		}
		$funcao->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$funcao->RowAttrs->merge(["data-rowindex" => $funcao_list->RowCount, "id" => "r" . $funcao_list->RowCount . "_funcao", "data-rowtype" => $funcao->RowType]);

		// Render row
		$funcao_list->renderRow();

		// Render list options
		$funcao_list->renderListOptions();
?>
	<tr <?php echo $funcao->rowAttributes() ?>>
<?php

// Render list options (body, left)
$funcao_list->ListOptions->render("body", "left", $funcao_list->RowCount);
?>
	<?php if ($funcao_list->funcao->Visible) { // funcao ?>
		<td data-name="funcao" <?php echo $funcao_list->funcao->cellAttributes() ?>>
<span id="el<?php echo $funcao_list->RowCount ?>_funcao_funcao">
<span<?php echo $funcao_list->funcao->viewAttributes() ?>><?php echo $funcao_list->funcao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$funcao_list->ListOptions->render("body", "right", $funcao_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$funcao_list->isGridAdd())
		$funcao_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$funcao->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($funcao_list->Recordset)
	$funcao_list->Recordset->Close();
?>
<?php if (!$funcao_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$funcao_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $funcao_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $funcao_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($funcao_list->TotalRecords == 0 && !$funcao->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $funcao_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$funcao_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$funcao_list->isExport()) { ?>
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
$funcao_list->terminate();
?>