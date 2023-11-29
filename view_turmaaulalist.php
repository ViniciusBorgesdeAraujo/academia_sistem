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
$view_turmaaula_list = new view_turmaaula_list();

// Run the page
$view_turmaaula_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$view_turmaaula_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$view_turmaaula_list->isExport()) { ?>
<script>
var fview_turmaaulalist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fview_turmaaulalist = currentForm = new ew.Form("fview_turmaaulalist", "list");
	fview_turmaaulalist.formKeyCountName = '<?php echo $view_turmaaula_list->FormKeyCountName ?>';
	loadjs.done("fview_turmaaulalist");
});
var fview_turmaaulalistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fview_turmaaulalistsrch = currentSearchForm = new ew.Form("fview_turmaaulalistsrch");

	// Dynamic selection lists
	// Filters

	fview_turmaaulalistsrch.filterList = <?php echo $view_turmaaula_list->getFilterList() ?>;
	loadjs.done("fview_turmaaulalistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$view_turmaaula_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($view_turmaaula_list->TotalRecords > 0 && $view_turmaaula_list->ExportOptions->visible()) { ?>
<?php $view_turmaaula_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($view_turmaaula_list->ImportOptions->visible()) { ?>
<?php $view_turmaaula_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($view_turmaaula_list->SearchOptions->visible()) { ?>
<?php $view_turmaaula_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($view_turmaaula_list->FilterOptions->visible()) { ?>
<?php $view_turmaaula_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$view_turmaaula_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$view_turmaaula_list->isExport() && !$view_turmaaula->CurrentAction) { ?>
<form name="fview_turmaaulalistsrch" id="fview_turmaaulalistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fview_turmaaulalistsrch-search-panel" class="<?php echo $view_turmaaula_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_turmaaula">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $view_turmaaula_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($view_turmaaula_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($view_turmaaula_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $view_turmaaula_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($view_turmaaula_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($view_turmaaula_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($view_turmaaula_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($view_turmaaula_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $view_turmaaula_list->showPageHeader(); ?>
<?php
$view_turmaaula_list->showMessage();
?>
<?php if ($view_turmaaula_list->TotalRecords > 0 || $view_turmaaula->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($view_turmaaula_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_turmaaula">
<?php if (!$view_turmaaula_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$view_turmaaula_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $view_turmaaula_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $view_turmaaula_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fview_turmaaulalist" id="fview_turmaaulalist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="view_turmaaula">
<div id="gmp_view_turmaaula" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($view_turmaaula_list->TotalRecords > 0 || $view_turmaaula_list->isGridEdit()) { ?>
<table id="tbl_view_turmaaulalist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$view_turmaaula->RowType = ROWTYPE_HEADER;

// Render list options
$view_turmaaula_list->renderListOptions();

// Render list options (header, left)
$view_turmaaula_list->ListOptions->render("header", "left");
?>
<?php if ($view_turmaaula_list->nome->Visible) { // nome ?>
	<?php if ($view_turmaaula_list->SortUrl($view_turmaaula_list->nome) == "") { ?>
		<th data-name="nome" class="<?php echo $view_turmaaula_list->nome->headerCellClass() ?>"><div id="elh_view_turmaaula_nome" class="view_turmaaula_nome"><div class="ew-table-header-caption"><?php echo $view_turmaaula_list->nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome" class="<?php echo $view_turmaaula_list->nome->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $view_turmaaula_list->SortUrl($view_turmaaula_list->nome) ?>', 1);"><div id="elh_view_turmaaula_nome" class="view_turmaaula_nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $view_turmaaula_list->nome->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($view_turmaaula_list->nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($view_turmaaula_list->nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($view_turmaaula_list->turmas->Visible) { // turmas ?>
	<?php if ($view_turmaaula_list->SortUrl($view_turmaaula_list->turmas) == "") { ?>
		<th data-name="turmas" class="<?php echo $view_turmaaula_list->turmas->headerCellClass() ?>"><div id="elh_view_turmaaula_turmas" class="view_turmaaula_turmas"><div class="ew-table-header-caption"><?php echo $view_turmaaula_list->turmas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="turmas" class="<?php echo $view_turmaaula_list->turmas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $view_turmaaula_list->SortUrl($view_turmaaula_list->turmas) ?>', 1);"><div id="elh_view_turmaaula_turmas" class="view_turmaaula_turmas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $view_turmaaula_list->turmas->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($view_turmaaula_list->turmas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($view_turmaaula_list->turmas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($view_turmaaula_list->ativado->Visible) { // ativado ?>
	<?php if ($view_turmaaula_list->SortUrl($view_turmaaula_list->ativado) == "") { ?>
		<th data-name="ativado" class="<?php echo $view_turmaaula_list->ativado->headerCellClass() ?>"><div id="elh_view_turmaaula_ativado" class="view_turmaaula_ativado"><div class="ew-table-header-caption"><?php echo $view_turmaaula_list->ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativado" class="<?php echo $view_turmaaula_list->ativado->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $view_turmaaula_list->SortUrl($view_turmaaula_list->ativado) ?>', 1);"><div id="elh_view_turmaaula_ativado" class="view_turmaaula_ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $view_turmaaula_list->ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($view_turmaaula_list->ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($view_turmaaula_list->ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$view_turmaaula_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($view_turmaaula_list->ExportAll && $view_turmaaula_list->isExport()) {
	$view_turmaaula_list->StopRecord = $view_turmaaula_list->TotalRecords;
} else {

	// Set the last record to display
	if ($view_turmaaula_list->TotalRecords > $view_turmaaula_list->StartRecord + $view_turmaaula_list->DisplayRecords - 1)
		$view_turmaaula_list->StopRecord = $view_turmaaula_list->StartRecord + $view_turmaaula_list->DisplayRecords - 1;
	else
		$view_turmaaula_list->StopRecord = $view_turmaaula_list->TotalRecords;
}
$view_turmaaula_list->RecordCount = $view_turmaaula_list->StartRecord - 1;
if ($view_turmaaula_list->Recordset && !$view_turmaaula_list->Recordset->EOF) {
	$view_turmaaula_list->Recordset->moveFirst();
	$selectLimit = $view_turmaaula_list->UseSelectLimit;
	if (!$selectLimit && $view_turmaaula_list->StartRecord > 1)
		$view_turmaaula_list->Recordset->move($view_turmaaula_list->StartRecord - 1);
} elseif (!$view_turmaaula->AllowAddDeleteRow && $view_turmaaula_list->StopRecord == 0) {
	$view_turmaaula_list->StopRecord = $view_turmaaula->GridAddRowCount;
}

// Initialize aggregate
$view_turmaaula->RowType = ROWTYPE_AGGREGATEINIT;
$view_turmaaula->resetAttributes();
$view_turmaaula_list->renderRow();
while ($view_turmaaula_list->RecordCount < $view_turmaaula_list->StopRecord) {
	$view_turmaaula_list->RecordCount++;
	if ($view_turmaaula_list->RecordCount >= $view_turmaaula_list->StartRecord) {
		$view_turmaaula_list->RowCount++;

		// Set up key count
		$view_turmaaula_list->KeyCount = $view_turmaaula_list->RowIndex;

		// Init row class and style
		$view_turmaaula->resetAttributes();
		$view_turmaaula->CssClass = "";
		if ($view_turmaaula_list->isGridAdd()) {
		} else {
			$view_turmaaula_list->loadRowValues($view_turmaaula_list->Recordset); // Load row values
		}
		$view_turmaaula->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$view_turmaaula->RowAttrs->merge(["data-rowindex" => $view_turmaaula_list->RowCount, "id" => "r" . $view_turmaaula_list->RowCount . "_view_turmaaula", "data-rowtype" => $view_turmaaula->RowType]);

		// Render row
		$view_turmaaula_list->renderRow();

		// Render list options
		$view_turmaaula_list->renderListOptions();
?>
	<tr <?php echo $view_turmaaula->rowAttributes() ?>>
<?php

// Render list options (body, left)
$view_turmaaula_list->ListOptions->render("body", "left", $view_turmaaula_list->RowCount);
?>
	<?php if ($view_turmaaula_list->nome->Visible) { // nome ?>
		<td data-name="nome" <?php echo $view_turmaaula_list->nome->cellAttributes() ?>>
<span id="el<?php echo $view_turmaaula_list->RowCount ?>_view_turmaaula_nome">
<span<?php echo $view_turmaaula_list->nome->viewAttributes() ?>><?php echo $view_turmaaula_list->nome->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_turmaaula_list->turmas->Visible) { // turmas ?>
		<td data-name="turmas" <?php echo $view_turmaaula_list->turmas->cellAttributes() ?>>
<span id="el<?php echo $view_turmaaula_list->RowCount ?>_view_turmaaula_turmas">
<span<?php echo $view_turmaaula_list->turmas->viewAttributes() ?>><?php echo $view_turmaaula_list->turmas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_turmaaula_list->ativado->Visible) { // ativado ?>
		<td data-name="ativado" <?php echo $view_turmaaula_list->ativado->cellAttributes() ?>>
<span id="el<?php echo $view_turmaaula_list->RowCount ?>_view_turmaaula_ativado">
<span<?php echo $view_turmaaula_list->ativado->viewAttributes() ?>><?php echo $view_turmaaula_list->ativado->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$view_turmaaula_list->ListOptions->render("body", "right", $view_turmaaula_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$view_turmaaula_list->isGridAdd())
		$view_turmaaula_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$view_turmaaula->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($view_turmaaula_list->Recordset)
	$view_turmaaula_list->Recordset->Close();
?>
<?php if (!$view_turmaaula_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$view_turmaaula_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $view_turmaaula_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $view_turmaaula_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($view_turmaaula_list->TotalRecords == 0 && !$view_turmaaula->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $view_turmaaula_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$view_turmaaula_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$view_turmaaula_list->isExport()) { ?>
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
$view_turmaaula_list->terminate();
?>