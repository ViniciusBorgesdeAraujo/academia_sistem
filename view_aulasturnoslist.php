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
$view_aulasturnos_list = new view_aulasturnos_list();

// Run the page
$view_aulasturnos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$view_aulasturnos_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$view_aulasturnos_list->isExport()) { ?>
<script>
var fview_aulasturnoslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fview_aulasturnoslist = currentForm = new ew.Form("fview_aulasturnoslist", "list");
	fview_aulasturnoslist.formKeyCountName = '<?php echo $view_aulasturnos_list->FormKeyCountName ?>';
	loadjs.done("fview_aulasturnoslist");
});
var fview_aulasturnoslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fview_aulasturnoslistsrch = currentSearchForm = new ew.Form("fview_aulasturnoslistsrch");

	// Dynamic selection lists
	// Filters

	fview_aulasturnoslistsrch.filterList = <?php echo $view_aulasturnos_list->getFilterList() ?>;
	loadjs.done("fview_aulasturnoslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$view_aulasturnos_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($view_aulasturnos_list->TotalRecords > 0 && $view_aulasturnos_list->ExportOptions->visible()) { ?>
<?php $view_aulasturnos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($view_aulasturnos_list->ImportOptions->visible()) { ?>
<?php $view_aulasturnos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($view_aulasturnos_list->SearchOptions->visible()) { ?>
<?php $view_aulasturnos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($view_aulasturnos_list->FilterOptions->visible()) { ?>
<?php $view_aulasturnos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$view_aulasturnos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$view_aulasturnos_list->isExport() && !$view_aulasturnos->CurrentAction) { ?>
<form name="fview_aulasturnoslistsrch" id="fview_aulasturnoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fview_aulasturnoslistsrch-search-panel" class="<?php echo $view_aulasturnos_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_aulasturnos">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $view_aulasturnos_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($view_aulasturnos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($view_aulasturnos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $view_aulasturnos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($view_aulasturnos_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($view_aulasturnos_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($view_aulasturnos_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($view_aulasturnos_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $view_aulasturnos_list->showPageHeader(); ?>
<?php
$view_aulasturnos_list->showMessage();
?>
<?php if ($view_aulasturnos_list->TotalRecords > 0 || $view_aulasturnos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($view_aulasturnos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_aulasturnos">
<?php if (!$view_aulasturnos_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$view_aulasturnos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $view_aulasturnos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $view_aulasturnos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fview_aulasturnoslist" id="fview_aulasturnoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="view_aulasturnos">
<div id="gmp_view_aulasturnos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($view_aulasturnos_list->TotalRecords > 0 || $view_aulasturnos_list->isGridEdit()) { ?>
<table id="tbl_view_aulasturnoslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$view_aulasturnos->RowType = ROWTYPE_HEADER;

// Render list options
$view_aulasturnos_list->renderListOptions();

// Render list options (header, left)
$view_aulasturnos_list->ListOptions->render("header", "left");
?>
<?php if ($view_aulasturnos_list->nome->Visible) { // nome ?>
	<?php if ($view_aulasturnos_list->SortUrl($view_aulasturnos_list->nome) == "") { ?>
		<th data-name="nome" class="<?php echo $view_aulasturnos_list->nome->headerCellClass() ?>"><div id="elh_view_aulasturnos_nome" class="view_aulasturnos_nome"><div class="ew-table-header-caption"><?php echo $view_aulasturnos_list->nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome" class="<?php echo $view_aulasturnos_list->nome->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $view_aulasturnos_list->SortUrl($view_aulasturnos_list->nome) ?>', 2);"><div id="elh_view_aulasturnos_nome" class="view_aulasturnos_nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $view_aulasturnos_list->nome->caption() ?></span><span class="ew-table-header-sort"><?php if ($view_aulasturnos_list->nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($view_aulasturnos_list->nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($view_aulasturnos_list->turmas->Visible) { // turmas ?>
	<?php if ($view_aulasturnos_list->SortUrl($view_aulasturnos_list->turmas) == "") { ?>
		<th data-name="turmas" class="<?php echo $view_aulasturnos_list->turmas->headerCellClass() ?>"><div id="elh_view_aulasturnos_turmas" class="view_aulasturnos_turmas"><div class="ew-table-header-caption"><?php echo $view_aulasturnos_list->turmas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="turmas" class="<?php echo $view_aulasturnos_list->turmas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $view_aulasturnos_list->SortUrl($view_aulasturnos_list->turmas) ?>', 2);"><div id="elh_view_aulasturnos_turmas" class="view_aulasturnos_turmas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $view_aulasturnos_list->turmas->caption() ?></span><span class="ew-table-header-sort"><?php if ($view_aulasturnos_list->turmas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($view_aulasturnos_list->turmas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($view_aulasturnos_list->ativado->Visible) { // ativado ?>
	<?php if ($view_aulasturnos_list->SortUrl($view_aulasturnos_list->ativado) == "") { ?>
		<th data-name="ativado" class="<?php echo $view_aulasturnos_list->ativado->headerCellClass() ?>"><div id="elh_view_aulasturnos_ativado" class="view_aulasturnos_ativado"><div class="ew-table-header-caption"><?php echo $view_aulasturnos_list->ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativado" class="<?php echo $view_aulasturnos_list->ativado->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $view_aulasturnos_list->SortUrl($view_aulasturnos_list->ativado) ?>', 2);"><div id="elh_view_aulasturnos_ativado" class="view_aulasturnos_ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $view_aulasturnos_list->ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($view_aulasturnos_list->ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($view_aulasturnos_list->ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$view_aulasturnos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($view_aulasturnos_list->ExportAll && $view_aulasturnos_list->isExport()) {
	$view_aulasturnos_list->StopRecord = $view_aulasturnos_list->TotalRecords;
} else {

	// Set the last record to display
	if ($view_aulasturnos_list->TotalRecords > $view_aulasturnos_list->StartRecord + $view_aulasturnos_list->DisplayRecords - 1)
		$view_aulasturnos_list->StopRecord = $view_aulasturnos_list->StartRecord + $view_aulasturnos_list->DisplayRecords - 1;
	else
		$view_aulasturnos_list->StopRecord = $view_aulasturnos_list->TotalRecords;
}
$view_aulasturnos_list->RecordCount = $view_aulasturnos_list->StartRecord - 1;
if ($view_aulasturnos_list->Recordset && !$view_aulasturnos_list->Recordset->EOF) {
	$view_aulasturnos_list->Recordset->moveFirst();
	$selectLimit = $view_aulasturnos_list->UseSelectLimit;
	if (!$selectLimit && $view_aulasturnos_list->StartRecord > 1)
		$view_aulasturnos_list->Recordset->move($view_aulasturnos_list->StartRecord - 1);
} elseif (!$view_aulasturnos->AllowAddDeleteRow && $view_aulasturnos_list->StopRecord == 0) {
	$view_aulasturnos_list->StopRecord = $view_aulasturnos->GridAddRowCount;
}

// Initialize aggregate
$view_aulasturnos->RowType = ROWTYPE_AGGREGATEINIT;
$view_aulasturnos->resetAttributes();
$view_aulasturnos_list->renderRow();
while ($view_aulasturnos_list->RecordCount < $view_aulasturnos_list->StopRecord) {
	$view_aulasturnos_list->RecordCount++;
	if ($view_aulasturnos_list->RecordCount >= $view_aulasturnos_list->StartRecord) {
		$view_aulasturnos_list->RowCount++;

		// Set up key count
		$view_aulasturnos_list->KeyCount = $view_aulasturnos_list->RowIndex;

		// Init row class and style
		$view_aulasturnos->resetAttributes();
		$view_aulasturnos->CssClass = "";
		if ($view_aulasturnos_list->isGridAdd()) {
		} else {
			$view_aulasturnos_list->loadRowValues($view_aulasturnos_list->Recordset); // Load row values
		}
		$view_aulasturnos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$view_aulasturnos->RowAttrs->merge(["data-rowindex" => $view_aulasturnos_list->RowCount, "id" => "r" . $view_aulasturnos_list->RowCount . "_view_aulasturnos", "data-rowtype" => $view_aulasturnos->RowType]);

		// Render row
		$view_aulasturnos_list->renderRow();

		// Render list options
		$view_aulasturnos_list->renderListOptions();
?>
	<tr <?php echo $view_aulasturnos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$view_aulasturnos_list->ListOptions->render("body", "left", $view_aulasturnos_list->RowCount);
?>
	<?php if ($view_aulasturnos_list->nome->Visible) { // nome ?>
		<td data-name="nome" <?php echo $view_aulasturnos_list->nome->cellAttributes() ?>>
<span id="el<?php echo $view_aulasturnos_list->RowCount ?>_view_aulasturnos_nome">
<span<?php echo $view_aulasturnos_list->nome->viewAttributes() ?>><?php echo $view_aulasturnos_list->nome->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_aulasturnos_list->turmas->Visible) { // turmas ?>
		<td data-name="turmas" <?php echo $view_aulasturnos_list->turmas->cellAttributes() ?>>
<span id="el<?php echo $view_aulasturnos_list->RowCount ?>_view_aulasturnos_turmas">
<span<?php echo $view_aulasturnos_list->turmas->viewAttributes() ?>><?php echo $view_aulasturnos_list->turmas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($view_aulasturnos_list->ativado->Visible) { // ativado ?>
		<td data-name="ativado" <?php echo $view_aulasturnos_list->ativado->cellAttributes() ?>>
<span id="el<?php echo $view_aulasturnos_list->RowCount ?>_view_aulasturnos_ativado">
<span<?php echo $view_aulasturnos_list->ativado->viewAttributes() ?>><?php echo $view_aulasturnos_list->ativado->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$view_aulasturnos_list->ListOptions->render("body", "right", $view_aulasturnos_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$view_aulasturnos_list->isGridAdd())
		$view_aulasturnos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$view_aulasturnos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($view_aulasturnos_list->Recordset)
	$view_aulasturnos_list->Recordset->Close();
?>
<?php if (!$view_aulasturnos_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$view_aulasturnos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $view_aulasturnos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $view_aulasturnos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($view_aulasturnos_list->TotalRecords == 0 && !$view_aulasturnos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $view_aulasturnos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$view_aulasturnos_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$view_aulasturnos_list->isExport()) { ?>
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
$view_aulasturnos_list->terminate();
?>