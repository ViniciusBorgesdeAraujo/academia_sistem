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
$academia_list = new academia_list();

// Run the page
$academia_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$academia_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$academia_list->isExport()) { ?>
<script>
var facademialist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	facademialist = currentForm = new ew.Form("facademialist", "list");
	facademialist.formKeyCountName = '<?php echo $academia_list->FormKeyCountName ?>';
	loadjs.done("facademialist");
});
var facademialistsrch;
loadjs.ready("head", function() {

	// Form object for search
	facademialistsrch = currentSearchForm = new ew.Form("facademialistsrch");

	// Dynamic selection lists
	// Filters

	facademialistsrch.filterList = <?php echo $academia_list->getFilterList() ?>;
	loadjs.done("facademialistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$academia_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($academia_list->TotalRecords > 0 && $academia_list->ExportOptions->visible()) { ?>
<?php $academia_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($academia_list->ImportOptions->visible()) { ?>
<?php $academia_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($academia_list->SearchOptions->visible()) { ?>
<?php $academia_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($academia_list->FilterOptions->visible()) { ?>
<?php $academia_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$academia_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$academia_list->isExport() && !$academia->CurrentAction) { ?>
<form name="facademialistsrch" id="facademialistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="facademialistsrch-search-panel" class="<?php echo $academia_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="academia">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $academia_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($academia_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($academia_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $academia_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($academia_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($academia_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($academia_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($academia_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $academia_list->showPageHeader(); ?>
<?php
$academia_list->showMessage();
?>
<?php if ($academia_list->TotalRecords > 0 || $academia->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($academia_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> academia">
<?php if (!$academia_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$academia_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $academia_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $academia_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="facademialist" id="facademialist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="academia">
<div id="gmp_academia" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($academia_list->TotalRecords > 0 || $academia_list->isGridEdit()) { ?>
<table id="tbl_academialist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$academia->RowType = ROWTYPE_HEADER;

// Render list options
$academia_list->renderListOptions();

// Render list options (header, left)
$academia_list->ListOptions->render("header", "left");
?>
<?php if ($academia_list->nome->Visible) { // nome ?>
	<?php if ($academia_list->SortUrl($academia_list->nome) == "") { ?>
		<th data-name="nome" class="<?php echo $academia_list->nome->headerCellClass() ?>"><div id="elh_academia_nome" class="academia_nome"><div class="ew-table-header-caption"><?php echo $academia_list->nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome" class="<?php echo $academia_list->nome->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $academia_list->SortUrl($academia_list->nome) ?>', 2);"><div id="elh_academia_nome" class="academia_nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $academia_list->nome->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($academia_list->nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($academia_list->nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($academia_list->registro->Visible) { // registro ?>
	<?php if ($academia_list->SortUrl($academia_list->registro) == "") { ?>
		<th data-name="registro" class="<?php echo $academia_list->registro->headerCellClass() ?>"><div id="elh_academia_registro" class="academia_registro"><div class="ew-table-header-caption"><?php echo $academia_list->registro->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="registro" class="<?php echo $academia_list->registro->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $academia_list->SortUrl($academia_list->registro) ?>', 2);"><div id="elh_academia_registro" class="academia_registro">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $academia_list->registro->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($academia_list->registro->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($academia_list->registro->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($academia_list->ativado->Visible) { // ativado ?>
	<?php if ($academia_list->SortUrl($academia_list->ativado) == "") { ?>
		<th data-name="ativado" class="<?php echo $academia_list->ativado->headerCellClass() ?>"><div id="elh_academia_ativado" class="academia_ativado"><div class="ew-table-header-caption"><?php echo $academia_list->ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativado" class="<?php echo $academia_list->ativado->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $academia_list->SortUrl($academia_list->ativado) ?>', 2);"><div id="elh_academia_ativado" class="academia_ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $academia_list->ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($academia_list->ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($academia_list->ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$academia_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($academia_list->ExportAll && $academia_list->isExport()) {
	$academia_list->StopRecord = $academia_list->TotalRecords;
} else {

	// Set the last record to display
	if ($academia_list->TotalRecords > $academia_list->StartRecord + $academia_list->DisplayRecords - 1)
		$academia_list->StopRecord = $academia_list->StartRecord + $academia_list->DisplayRecords - 1;
	else
		$academia_list->StopRecord = $academia_list->TotalRecords;
}
$academia_list->RecordCount = $academia_list->StartRecord - 1;
if ($academia_list->Recordset && !$academia_list->Recordset->EOF) {
	$academia_list->Recordset->moveFirst();
	$selectLimit = $academia_list->UseSelectLimit;
	if (!$selectLimit && $academia_list->StartRecord > 1)
		$academia_list->Recordset->move($academia_list->StartRecord - 1);
} elseif (!$academia->AllowAddDeleteRow && $academia_list->StopRecord == 0) {
	$academia_list->StopRecord = $academia->GridAddRowCount;
}

// Initialize aggregate
$academia->RowType = ROWTYPE_AGGREGATEINIT;
$academia->resetAttributes();
$academia_list->renderRow();
while ($academia_list->RecordCount < $academia_list->StopRecord) {
	$academia_list->RecordCount++;
	if ($academia_list->RecordCount >= $academia_list->StartRecord) {
		$academia_list->RowCount++;

		// Set up key count
		$academia_list->KeyCount = $academia_list->RowIndex;

		// Init row class and style
		$academia->resetAttributes();
		$academia->CssClass = "";
		if ($academia_list->isGridAdd()) {
		} else {
			$academia_list->loadRowValues($academia_list->Recordset); // Load row values
		}
		$academia->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$academia->RowAttrs->merge(["data-rowindex" => $academia_list->RowCount, "id" => "r" . $academia_list->RowCount . "_academia", "data-rowtype" => $academia->RowType]);

		// Render row
		$academia_list->renderRow();

		// Render list options
		$academia_list->renderListOptions();
?>
	<tr <?php echo $academia->rowAttributes() ?>>
<?php

// Render list options (body, left)
$academia_list->ListOptions->render("body", "left", $academia_list->RowCount);
?>
	<?php if ($academia_list->nome->Visible) { // nome ?>
		<td data-name="nome" <?php echo $academia_list->nome->cellAttributes() ?>>
<span id="el<?php echo $academia_list->RowCount ?>_academia_nome">
<span<?php echo $academia_list->nome->viewAttributes() ?>><?php echo $academia_list->nome->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($academia_list->registro->Visible) { // registro ?>
		<td data-name="registro" <?php echo $academia_list->registro->cellAttributes() ?>>
<span id="el<?php echo $academia_list->RowCount ?>_academia_registro">
<span<?php echo $academia_list->registro->viewAttributes() ?>><?php echo $academia_list->registro->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($academia_list->ativado->Visible) { // ativado ?>
		<td data-name="ativado" <?php echo $academia_list->ativado->cellAttributes() ?>>
<span id="el<?php echo $academia_list->RowCount ?>_academia_ativado">
<span<?php echo $academia_list->ativado->viewAttributes() ?>><?php echo $academia_list->ativado->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$academia_list->ListOptions->render("body", "right", $academia_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$academia_list->isGridAdd())
		$academia_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$academia->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($academia_list->Recordset)
	$academia_list->Recordset->Close();
?>
<?php if (!$academia_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$academia_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $academia_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $academia_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($academia_list->TotalRecords == 0 && !$academia->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $academia_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$academia_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$academia_list->isExport()) { ?>
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
$academia_list->terminate();
?>