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
$videos_list = new videos_list();

// Run the page
$videos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$videos_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$videos_list->isExport()) { ?>
<script>
var fvideoslist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fvideoslist = currentForm = new ew.Form("fvideoslist", "list");
	fvideoslist.formKeyCountName = '<?php echo $videos_list->FormKeyCountName ?>';
	loadjs.done("fvideoslist");
});
var fvideoslistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fvideoslistsrch = currentSearchForm = new ew.Form("fvideoslistsrch");

	// Dynamic selection lists
	// Filters

	fvideoslistsrch.filterList = <?php echo $videos_list->getFilterList() ?>;
	loadjs.done("fvideoslistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$videos_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($videos_list->TotalRecords > 0 && $videos_list->ExportOptions->visible()) { ?>
<?php $videos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($videos_list->ImportOptions->visible()) { ?>
<?php $videos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($videos_list->SearchOptions->visible()) { ?>
<?php $videos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($videos_list->FilterOptions->visible()) { ?>
<?php $videos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$videos_list->isExport() || Config("EXPORT_MASTER_RECORD") && $videos_list->isExport("print")) { ?>
<?php
if ($videos_list->DbMasterFilter != "" && $videos->getCurrentMasterTable() == "aulas") {
	if ($videos_list->MasterRecordExists) {
		include_once "aulasmaster.php";
	}
}
?>
<?php } ?>
<?php
$videos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$videos_list->isExport() && !$videos->CurrentAction) { ?>
<form name="fvideoslistsrch" id="fvideoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fvideoslistsrch-search-panel" class="<?php echo $videos_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="videos">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $videos_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($videos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($videos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $videos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($videos_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($videos_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($videos_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($videos_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $videos_list->showPageHeader(); ?>
<?php
$videos_list->showMessage();
?>
<?php if ($videos_list->TotalRecords > 0 || $videos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($videos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> videos">
<?php if (!$videos_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$videos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $videos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $videos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fvideoslist" id="fvideoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="videos">
<?php if ($videos->getCurrentMasterTable() == "aulas" && $videos->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="aulas">
<input type="hidden" name="fk_idaulas" value="<?php echo HtmlEncode($videos_list->idaulas->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_videos" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($videos_list->TotalRecords > 0 || $videos_list->isGridEdit()) { ?>
<table id="tbl_videoslist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$videos->RowType = ROWTYPE_HEADER;

// Render list options
$videos_list->renderListOptions();

// Render list options (header, left)
$videos_list->ListOptions->render("header", "left");
?>
<?php if ($videos_list->titulo->Visible) { // titulo ?>
	<?php if ($videos_list->SortUrl($videos_list->titulo) == "") { ?>
		<th data-name="titulo" class="<?php echo $videos_list->titulo->headerCellClass() ?>"><div id="elh_videos_titulo" class="videos_titulo"><div class="ew-table-header-caption"><?php echo $videos_list->titulo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="titulo" class="<?php echo $videos_list->titulo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $videos_list->SortUrl($videos_list->titulo) ?>', 2);"><div id="elh_videos_titulo" class="videos_titulo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_list->titulo->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($videos_list->titulo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_list->titulo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($videos_list->idaulas->Visible) { // idaulas ?>
	<?php if ($videos_list->SortUrl($videos_list->idaulas) == "") { ?>
		<th data-name="idaulas" class="<?php echo $videos_list->idaulas->headerCellClass() ?>"><div id="elh_videos_idaulas" class="videos_idaulas"><div class="ew-table-header-caption"><?php echo $videos_list->idaulas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idaulas" class="<?php echo $videos_list->idaulas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $videos_list->SortUrl($videos_list->idaulas) ?>', 2);"><div id="elh_videos_idaulas" class="videos_idaulas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_list->idaulas->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_list->idaulas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_list->idaulas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($videos_list->ativo->Visible) { // ativo ?>
	<?php if ($videos_list->SortUrl($videos_list->ativo) == "") { ?>
		<th data-name="ativo" class="<?php echo $videos_list->ativo->headerCellClass() ?>"><div id="elh_videos_ativo" class="videos_ativo"><div class="ew-table-header-caption"><?php echo $videos_list->ativo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ativo" class="<?php echo $videos_list->ativo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $videos_list->SortUrl($videos_list->ativo) ?>', 2);"><div id="elh_videos_ativo" class="videos_ativo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_list->ativo->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_list->ativo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_list->ativo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($videos_list->views->Visible) { // views ?>
	<?php if ($videos_list->SortUrl($videos_list->views) == "") { ?>
		<th data-name="views" class="<?php echo $videos_list->views->headerCellClass() ?>"><div id="elh_videos_views" class="videos_views"><div class="ew-table-header-caption"><?php echo $videos_list->views->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="views" class="<?php echo $videos_list->views->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $videos_list->SortUrl($videos_list->views) ?>', 2);"><div id="elh_videos_views" class="videos_views">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $videos_list->views->caption() ?></span><span class="ew-table-header-sort"><?php if ($videos_list->views->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($videos_list->views->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$videos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($videos_list->ExportAll && $videos_list->isExport()) {
	$videos_list->StopRecord = $videos_list->TotalRecords;
} else {

	// Set the last record to display
	if ($videos_list->TotalRecords > $videos_list->StartRecord + $videos_list->DisplayRecords - 1)
		$videos_list->StopRecord = $videos_list->StartRecord + $videos_list->DisplayRecords - 1;
	else
		$videos_list->StopRecord = $videos_list->TotalRecords;
}
$videos_list->RecordCount = $videos_list->StartRecord - 1;
if ($videos_list->Recordset && !$videos_list->Recordset->EOF) {
	$videos_list->Recordset->moveFirst();
	$selectLimit = $videos_list->UseSelectLimit;
	if (!$selectLimit && $videos_list->StartRecord > 1)
		$videos_list->Recordset->move($videos_list->StartRecord - 1);
} elseif (!$videos->AllowAddDeleteRow && $videos_list->StopRecord == 0) {
	$videos_list->StopRecord = $videos->GridAddRowCount;
}

// Initialize aggregate
$videos->RowType = ROWTYPE_AGGREGATEINIT;
$videos->resetAttributes();
$videos_list->renderRow();
while ($videos_list->RecordCount < $videos_list->StopRecord) {
	$videos_list->RecordCount++;
	if ($videos_list->RecordCount >= $videos_list->StartRecord) {
		$videos_list->RowCount++;

		// Set up key count
		$videos_list->KeyCount = $videos_list->RowIndex;

		// Init row class and style
		$videos->resetAttributes();
		$videos->CssClass = "";
		if ($videos_list->isGridAdd()) {
		} else {
			$videos_list->loadRowValues($videos_list->Recordset); // Load row values
		}
		$videos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$videos->RowAttrs->merge(["data-rowindex" => $videos_list->RowCount, "id" => "r" . $videos_list->RowCount . "_videos", "data-rowtype" => $videos->RowType]);

		// Render row
		$videos_list->renderRow();

		// Render list options
		$videos_list->renderListOptions();
?>
	<tr <?php echo $videos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$videos_list->ListOptions->render("body", "left", $videos_list->RowCount);
?>
	<?php if ($videos_list->titulo->Visible) { // titulo ?>
		<td data-name="titulo" <?php echo $videos_list->titulo->cellAttributes() ?>>
<span id="el<?php echo $videos_list->RowCount ?>_videos_titulo">
<span<?php echo $videos_list->titulo->viewAttributes() ?>><?php if (!EmptyString($videos_list->titulo->getViewValue()) && $videos_list->titulo->linkAttributes() != "") { ?>
<a<?php echo $videos_list->titulo->linkAttributes() ?>><?php echo $videos_list->titulo->getViewValue() ?></a>
<?php } else { ?>
<?php echo $videos_list->titulo->getViewValue() ?>
<?php } ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($videos_list->idaulas->Visible) { // idaulas ?>
		<td data-name="idaulas" <?php echo $videos_list->idaulas->cellAttributes() ?>>
<span id="el<?php echo $videos_list->RowCount ?>_videos_idaulas">
<span<?php echo $videos_list->idaulas->viewAttributes() ?>><?php echo $videos_list->idaulas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($videos_list->ativo->Visible) { // ativo ?>
		<td data-name="ativo" <?php echo $videos_list->ativo->cellAttributes() ?>>
<span id="el<?php echo $videos_list->RowCount ?>_videos_ativo">
<span<?php echo $videos_list->ativo->viewAttributes() ?>><?php echo $videos_list->ativo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($videos_list->views->Visible) { // views ?>
		<td data-name="views" <?php echo $videos_list->views->cellAttributes() ?>>
<span id="el<?php echo $videos_list->RowCount ?>_videos_views">
<span<?php echo $videos_list->views->viewAttributes() ?>><?php echo $videos_list->views->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$videos_list->ListOptions->render("body", "right", $videos_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$videos_list->isGridAdd())
		$videos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$videos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($videos_list->Recordset)
	$videos_list->Recordset->Close();
?>
<?php if (!$videos_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$videos_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $videos_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $videos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($videos_list->TotalRecords == 0 && !$videos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $videos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$videos_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$videos_list->isExport()) { ?>
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
$videos_list->terminate();
?>