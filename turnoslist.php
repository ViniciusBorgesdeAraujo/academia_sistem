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
$turnos_list = new turnos_list();

// Run the page
$turnos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$turnos_list->isExport()) { ?>
<script>
var fturnoslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fturnoslist = currentForm = new ew.Form("fturnoslist", "list");
	fturnoslist.formKeyCountName = '<?php echo $turnos_list->FormKeyCountName ?>';
	loadjs.done("fturnoslist");
});
var fturnoslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fturnoslistsrch = currentSearchForm = new ew.Form("fturnoslistsrch");

	// Dynamic selection lists
	// Filters

	fturnoslistsrch.filterList = <?php echo $turnos_list->getFilterList() ?>;
	loadjs.done("fturnoslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$turnos_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($turnos_list->TotalRecords > 0 && $turnos_list->ExportOptions->visible()) { ?>
<?php $turnos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($turnos_list->ImportOptions->visible()) { ?>
<?php $turnos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($turnos_list->SearchOptions->visible()) { ?>
<?php $turnos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($turnos_list->FilterOptions->visible()) { ?>
<?php $turnos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$turnos_list->isExport() || Config("EXPORT_MASTER_RECORD") && $turnos_list->isExport("print")) { ?>
<?php
if ($turnos_list->DbMasterFilter != "" && $turnos->getCurrentMasterTable() == "academia") {
	if ($turnos_list->MasterRecordExists) {
		include_once "academiamaster.php";
	}
}
?>
<?php } ?>
<?php
$turnos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$turnos_list->isExport() && !$turnos->CurrentAction) { ?>
<form name="fturnoslistsrch" id="fturnoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fturnoslistsrch-search-panel" class="<?php echo $turnos_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="turnos">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $turnos_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($turnos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($turnos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $turnos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($turnos_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($turnos_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($turnos_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($turnos_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $turnos_list->showPageHeader(); ?>
<?php
$turnos_list->showMessage();
?>
<?php if ($turnos_list->TotalRecords > 0 || $turnos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($turnos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> turnos">
<?php if (!$turnos_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$turnos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $turnos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $turnos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fturnoslist" id="fturnoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="turnos">
<?php if ($turnos->getCurrentMasterTable() == "academia" && $turnos->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="academia">
<input type="hidden" name="fk_idacademia" value="<?php echo HtmlEncode($turnos_list->idacademia->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_turnos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($turnos_list->TotalRecords > 0 || $turnos_list->isGridEdit()) { ?>
<table id="tbl_turnoslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$turnos->RowType = ROWTYPE_HEADER;

// Render list options
$turnos_list->renderListOptions();

// Render list options (header, left)
$turnos_list->ListOptions->render("header", "left");
?>
<?php if ($turnos_list->idacademia->Visible) { // idacademia ?>
	<?php if ($turnos_list->SortUrl($turnos_list->idacademia) == "") { ?>
		<th data-name="idacademia" class="<?php echo $turnos_list->idacademia->headerCellClass() ?>"><div id="elh_turnos_idacademia" class="turnos_idacademia"><div class="ew-table-header-caption"><?php echo $turnos_list->idacademia->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idacademia" class="<?php echo $turnos_list->idacademia->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $turnos_list->SortUrl($turnos_list->idacademia) ?>', 2);"><div id="elh_turnos_idacademia" class="turnos_idacademia">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $turnos_list->idacademia->caption() ?></span><span class="ew-table-header-sort"><?php if ($turnos_list->idacademia->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($turnos_list->idacademia->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($turnos_list->turmas->Visible) { // turmas ?>
	<?php if ($turnos_list->SortUrl($turnos_list->turmas) == "") { ?>
		<th data-name="turmas" class="<?php echo $turnos_list->turmas->headerCellClass() ?>"><div id="elh_turnos_turmas" class="turnos_turmas"><div class="ew-table-header-caption"><?php echo $turnos_list->turmas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="turmas" class="<?php echo $turnos_list->turmas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $turnos_list->SortUrl($turnos_list->turmas) ?>', 2);"><div id="elh_turnos_turmas" class="turnos_turmas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $turnos_list->turmas->caption() ?></span><span class="ew-table-header-sort"><?php if ($turnos_list->turmas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($turnos_list->turmas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$turnos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($turnos_list->ExportAll && $turnos_list->isExport()) {
	$turnos_list->StopRecord = $turnos_list->TotalRecords;
} else {

	// Set the last record to display
	if ($turnos_list->TotalRecords > $turnos_list->StartRecord + $turnos_list->DisplayRecords - 1)
		$turnos_list->StopRecord = $turnos_list->StartRecord + $turnos_list->DisplayRecords - 1;
	else
		$turnos_list->StopRecord = $turnos_list->TotalRecords;
}
$turnos_list->RecordCount = $turnos_list->StartRecord - 1;
if ($turnos_list->Recordset && !$turnos_list->Recordset->EOF) {
	$turnos_list->Recordset->moveFirst();
	$selectLimit = $turnos_list->UseSelectLimit;
	if (!$selectLimit && $turnos_list->StartRecord > 1)
		$turnos_list->Recordset->move($turnos_list->StartRecord - 1);
} elseif (!$turnos->AllowAddDeleteRow && $turnos_list->StopRecord == 0) {
	$turnos_list->StopRecord = $turnos->GridAddRowCount;
}

// Initialize aggregate
$turnos->RowType = ROWTYPE_AGGREGATEINIT;
$turnos->resetAttributes();
$turnos_list->renderRow();
while ($turnos_list->RecordCount < $turnos_list->StopRecord) {
	$turnos_list->RecordCount++;
	if ($turnos_list->RecordCount >= $turnos_list->StartRecord) {
		$turnos_list->RowCount++;

		// Set up key count
		$turnos_list->KeyCount = $turnos_list->RowIndex;

		// Init row class and style
		$turnos->resetAttributes();
		$turnos->CssClass = "";
		if ($turnos_list->isGridAdd()) {
		} else {
			$turnos_list->loadRowValues($turnos_list->Recordset); // Load row values
		}
		$turnos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$turnos->RowAttrs->merge(["data-rowindex" => $turnos_list->RowCount, "id" => "r" . $turnos_list->RowCount . "_turnos", "data-rowtype" => $turnos->RowType]);

		// Render row
		$turnos_list->renderRow();

		// Render list options
		$turnos_list->renderListOptions();
?>
	<tr <?php echo $turnos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$turnos_list->ListOptions->render("body", "left", $turnos_list->RowCount);
?>
	<?php if ($turnos_list->idacademia->Visible) { // idacademia ?>
		<td data-name="idacademia" <?php echo $turnos_list->idacademia->cellAttributes() ?>>
<span id="el<?php echo $turnos_list->RowCount ?>_turnos_idacademia">
<span<?php echo $turnos_list->idacademia->viewAttributes() ?>><?php echo $turnos_list->idacademia->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($turnos_list->turmas->Visible) { // turmas ?>
		<td data-name="turmas" <?php echo $turnos_list->turmas->cellAttributes() ?>>
<span id="el<?php echo $turnos_list->RowCount ?>_turnos_turmas">
<span<?php echo $turnos_list->turmas->viewAttributes() ?>><?php echo $turnos_list->turmas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$turnos_list->ListOptions->render("body", "right", $turnos_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$turnos_list->isGridAdd())
		$turnos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$turnos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($turnos_list->Recordset)
	$turnos_list->Recordset->Close();
?>
<?php if (!$turnos_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$turnos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $turnos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $turnos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($turnos_list->TotalRecords == 0 && !$turnos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $turnos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$turnos_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$turnos_list->isExport()) { ?>
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
$turnos_list->terminate();
?>