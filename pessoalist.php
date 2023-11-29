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
$pessoa_list = new pessoa_list();

// Run the page
$pessoa_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_list->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$pessoa_list->isExport()) { ?>
<script>
var fpessoalist, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "list";
	fpessoalist = currentForm = new ew.Form("fpessoalist", "list");
	fpessoalist.formKeyCountName = '<?php echo $pessoa_list->FormKeyCountName ?>';
	loadjs.done("fpessoalist");
});
var fpessoalistsrch;
loadjs.ready("head", function() {

	// Form object for search
	fpessoalistsrch = currentSearchForm = new ew.Form("fpessoalistsrch");

	// Dynamic selection lists
	// Filters

	fpessoalistsrch.filterList = <?php echo $pessoa_list->getFilterList() ?>;
	loadjs.done("fpessoalistsrch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$pessoa_list->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($pessoa_list->TotalRecords > 0 && $pessoa_list->ExportOptions->visible()) { ?>
<?php $pessoa_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($pessoa_list->ImportOptions->visible()) { ?>
<?php $pessoa_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($pessoa_list->SearchOptions->visible()) { ?>
<?php $pessoa_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($pessoa_list->FilterOptions->visible()) { ?>
<?php $pessoa_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$pessoa_list->isExport() || Config("EXPORT_MASTER_RECORD") && $pessoa_list->isExport("print")) { ?>
<?php
if ($pessoa_list->DbMasterFilter != "" && $pessoa->getCurrentMasterTable() == "aulas") {
	if ($pessoa_list->MasterRecordExists) {
		include_once "aulasmaster.php";
	}
}
?>
<?php } ?>
<?php
$pessoa_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$pessoa_list->isExport() && !$pessoa->CurrentAction) { ?>
<form name="fpessoalistsrch" id="fpessoalistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<div id="fpessoalistsrch-search-panel" class="<?php echo $pessoa_list->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pessoa">
	<div class="ew-extended-search">
<div id="xsr_<?php echo $pessoa_list->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo Config("TABLE_BASIC_SEARCH") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?php echo HtmlEncode($pessoa_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?php echo Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?php echo HtmlEncode($pessoa_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $pessoa_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($pessoa_list->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($pessoa_list->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($pessoa_list->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($pessoa_list->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $pessoa_list->showPageHeader(); ?>
<?php
$pessoa_list->showMessage();
?>
<?php if ($pessoa_list->TotalRecords > 0 || $pessoa->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($pessoa_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pessoa">
<?php if (!$pessoa_list->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$pessoa_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $pessoa_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $pessoa_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpessoalist" id="fpessoalist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pessoa">
<?php if ($pessoa->getCurrentMasterTable() == "aulas" && $pessoa->CurrentAction) { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="aulas">
<input type="hidden" name="fk_idaulas" value="<?php echo HtmlEncode($pessoa_list->idaula->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_pessoa" class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($pessoa_list->TotalRecords > 0 || $pessoa_list->isGridEdit()) { ?>
<table id="tbl_pessoalist" class="table ew-table"><!-- .ew-table -->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$pessoa->RowType = ROWTYPE_HEADER;

// Render list options
$pessoa_list->renderListOptions();

// Render list options (header, left)
$pessoa_list->ListOptions->render("header", "left");
?>
<?php if ($pessoa_list->idaula->Visible) { // idaula ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->idaula) == "") { ?>
		<th data-name="idaula" class="<?php echo $pessoa_list->idaula->headerCellClass() ?>"><div id="elh_pessoa_idaula" class="pessoa_idaula"><div class="ew-table-header-caption"><?php echo $pessoa_list->idaula->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idaula" class="<?php echo $pessoa_list->idaula->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->idaula) ?>', 2);"><div id="elh_pessoa_idaula" class="pessoa_idaula">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->idaula->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->idaula->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->idaula->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->Nome->Visible) { // Nome ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->Nome) == "") { ?>
		<th data-name="Nome" class="<?php echo $pessoa_list->Nome->headerCellClass() ?>"><div id="elh_pessoa_Nome" class="pessoa_Nome"><div class="ew-table-header-caption"><?php echo $pessoa_list->Nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nome" class="<?php echo $pessoa_list->Nome->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->Nome) ?>', 2);"><div id="elh_pessoa_Nome" class="pessoa_Nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->Nome->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->Nome->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->Nome->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->CPF->Visible) { // CPF ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->CPF) == "") { ?>
		<th data-name="CPF" class="<?php echo $pessoa_list->CPF->headerCellClass() ?>"><div id="elh_pessoa_CPF" class="pessoa_CPF"><div class="ew-table-header-caption"><?php echo $pessoa_list->CPF->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CPF" class="<?php echo $pessoa_list->CPF->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->CPF) ?>', 2);"><div id="elh_pessoa_CPF" class="pessoa_CPF">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->CPF->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->CPF->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->CPF->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->Senha->Visible) { // Senha ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->Senha) == "") { ?>
		<th data-name="Senha" class="<?php echo $pessoa_list->Senha->headerCellClass() ?>"><div id="elh_pessoa_Senha" class="pessoa_Senha"><div class="ew-table-header-caption"><?php echo $pessoa_list->Senha->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Senha" class="<?php echo $pessoa_list->Senha->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->Senha) ?>', 2);"><div id="elh_pessoa_Senha" class="pessoa_Senha">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->Senha->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->Senha->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->Senha->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->Sexo->Visible) { // Sexo ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->Sexo) == "") { ?>
		<th data-name="Sexo" class="<?php echo $pessoa_list->Sexo->headerCellClass() ?>"><div id="elh_pessoa_Sexo" class="pessoa_Sexo"><div class="ew-table-header-caption"><?php echo $pessoa_list->Sexo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sexo" class="<?php echo $pessoa_list->Sexo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->Sexo) ?>', 2);"><div id="elh_pessoa_Sexo" class="pessoa_Sexo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->Sexo->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->Sexo->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->Sexo->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->datanascimento->Visible) { // datanascimento ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->datanascimento) == "") { ?>
		<th data-name="datanascimento" class="<?php echo $pessoa_list->datanascimento->headerCellClass() ?>"><div id="elh_pessoa_datanascimento" class="pessoa_datanascimento"><div class="ew-table-header-caption"><?php echo $pessoa_list->datanascimento->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="datanascimento" class="<?php echo $pessoa_list->datanascimento->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->datanascimento) ?>', 2);"><div id="elh_pessoa_datanascimento" class="pessoa_datanascimento">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->datanascimento->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->datanascimento->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->datanascimento->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->Funcao->Visible) { // Funcao ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->Funcao) == "") { ?>
		<th data-name="Funcao" class="<?php echo $pessoa_list->Funcao->headerCellClass() ?>"><div id="elh_pessoa_Funcao" class="pessoa_Funcao"><div class="ew-table-header-caption"><?php echo $pessoa_list->Funcao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Funcao" class="<?php echo $pessoa_list->Funcao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->Funcao) ?>', 2);"><div id="elh_pessoa_Funcao" class="pessoa_Funcao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->Funcao->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->Funcao->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->Funcao->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->_Email->Visible) { // Email ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->_Email) == "") { ?>
		<th data-name="_Email" class="<?php echo $pessoa_list->_Email->headerCellClass() ?>"><div id="elh_pessoa__Email" class="pessoa__Email"><div class="ew-table-header-caption"><?php echo $pessoa_list->_Email->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_Email" class="<?php echo $pessoa_list->_Email->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->_Email) ?>', 2);"><div id="elh_pessoa__Email" class="pessoa__Email">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->_Email->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->_Email->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->_Email->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->Ativado->Visible) { // Ativado ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->Ativado) == "") { ?>
		<th data-name="Ativado" class="<?php echo $pessoa_list->Ativado->headerCellClass() ?>"><div id="elh_pessoa_Ativado" class="pessoa_Ativado"><div class="ew-table-header-caption"><?php echo $pessoa_list->Ativado->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Ativado" class="<?php echo $pessoa_list->Ativado->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->Ativado) ?>', 2);"><div id="elh_pessoa_Ativado" class="pessoa_Ativado">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->Ativado->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->Ativado->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->Ativado->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($pessoa_list->Idade->Visible) { // Idade ?>
	<?php if ($pessoa_list->SortUrl($pessoa_list->Idade) == "") { ?>
		<th data-name="Idade" class="<?php echo $pessoa_list->Idade->headerCellClass() ?>"><div id="elh_pessoa_Idade" class="pessoa_Idade"><div class="ew-table-header-caption"><?php echo $pessoa_list->Idade->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Idade" class="<?php echo $pessoa_list->Idade->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event, '<?php echo $pessoa_list->SortUrl($pessoa_list->Idade) ?>', 2);"><div id="elh_pessoa_Idade" class="pessoa_Idade">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $pessoa_list->Idade->caption() ?></span><span class="ew-table-header-sort"><?php if ($pessoa_list->Idade->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($pessoa_list->Idade->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$pessoa_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pessoa_list->ExportAll && $pessoa_list->isExport()) {
	$pessoa_list->StopRecord = $pessoa_list->TotalRecords;
} else {

	// Set the last record to display
	if ($pessoa_list->TotalRecords > $pessoa_list->StartRecord + $pessoa_list->DisplayRecords - 1)
		$pessoa_list->StopRecord = $pessoa_list->StartRecord + $pessoa_list->DisplayRecords - 1;
	else
		$pessoa_list->StopRecord = $pessoa_list->TotalRecords;
}
$pessoa_list->RecordCount = $pessoa_list->StartRecord - 1;
if ($pessoa_list->Recordset && !$pessoa_list->Recordset->EOF) {
	$pessoa_list->Recordset->moveFirst();
	$selectLimit = $pessoa_list->UseSelectLimit;
	if (!$selectLimit && $pessoa_list->StartRecord > 1)
		$pessoa_list->Recordset->move($pessoa_list->StartRecord - 1);
} elseif (!$pessoa->AllowAddDeleteRow && $pessoa_list->StopRecord == 0) {
	$pessoa_list->StopRecord = $pessoa->GridAddRowCount;
}

// Initialize aggregate
$pessoa->RowType = ROWTYPE_AGGREGATEINIT;
$pessoa->resetAttributes();
$pessoa_list->renderRow();
while ($pessoa_list->RecordCount < $pessoa_list->StopRecord) {
	$pessoa_list->RecordCount++;
	if ($pessoa_list->RecordCount >= $pessoa_list->StartRecord) {
		$pessoa_list->RowCount++;

		// Set up key count
		$pessoa_list->KeyCount = $pessoa_list->RowIndex;

		// Init row class and style
		$pessoa->resetAttributes();
		$pessoa->CssClass = "";
		if ($pessoa_list->isGridAdd()) {
		} else {
			$pessoa_list->loadRowValues($pessoa_list->Recordset); // Load row values
		}
		$pessoa->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pessoa->RowAttrs->merge(["data-rowindex" => $pessoa_list->RowCount, "id" => "r" . $pessoa_list->RowCount . "_pessoa", "data-rowtype" => $pessoa->RowType]);

		// Render row
		$pessoa_list->renderRow();

		// Render list options
		$pessoa_list->renderListOptions();
?>
	<tr <?php echo $pessoa->rowAttributes() ?>>
<?php

// Render list options (body, left)
$pessoa_list->ListOptions->render("body", "left", $pessoa_list->RowCount);
?>
	<?php if ($pessoa_list->idaula->Visible) { // idaula ?>
		<td data-name="idaula" <?php echo $pessoa_list->idaula->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_idaula">
<span<?php echo $pessoa_list->idaula->viewAttributes() ?>><?php echo $pessoa_list->idaula->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->Nome->Visible) { // Nome ?>
		<td data-name="Nome" <?php echo $pessoa_list->Nome->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_Nome">
<span<?php echo $pessoa_list->Nome->viewAttributes() ?>><?php echo $pessoa_list->Nome->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->CPF->Visible) { // CPF ?>
		<td data-name="CPF" <?php echo $pessoa_list->CPF->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_CPF">
<span<?php echo $pessoa_list->CPF->viewAttributes() ?>><?php echo $pessoa_list->CPF->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->Senha->Visible) { // Senha ?>
		<td data-name="Senha" <?php echo $pessoa_list->Senha->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_Senha">
<span<?php echo $pessoa_list->Senha->viewAttributes() ?>><?php echo $pessoa_list->Senha->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->Sexo->Visible) { // Sexo ?>
		<td data-name="Sexo" <?php echo $pessoa_list->Sexo->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_Sexo">
<span<?php echo $pessoa_list->Sexo->viewAttributes() ?>><?php echo $pessoa_list->Sexo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->datanascimento->Visible) { // datanascimento ?>
		<td data-name="datanascimento" <?php echo $pessoa_list->datanascimento->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_datanascimento">
<span<?php echo $pessoa_list->datanascimento->viewAttributes() ?>><?php echo $pessoa_list->datanascimento->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->Funcao->Visible) { // Funcao ?>
		<td data-name="Funcao" <?php echo $pessoa_list->Funcao->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_Funcao">
<span<?php echo $pessoa_list->Funcao->viewAttributes() ?>><?php echo $pessoa_list->Funcao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->_Email->Visible) { // Email ?>
		<td data-name="_Email" <?php echo $pessoa_list->_Email->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa__Email">
<span<?php echo $pessoa_list->_Email->viewAttributes() ?>><?php echo $pessoa_list->_Email->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->Ativado->Visible) { // Ativado ?>
		<td data-name="Ativado" <?php echo $pessoa_list->Ativado->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_Ativado">
<span<?php echo $pessoa_list->Ativado->viewAttributes() ?>><?php echo $pessoa_list->Ativado->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pessoa_list->Idade->Visible) { // Idade ?>
		<td data-name="Idade" <?php echo $pessoa_list->Idade->cellAttributes() ?>>
<span id="el<?php echo $pessoa_list->RowCount ?>_pessoa_Idade">
<span<?php echo $pessoa_list->Idade->viewAttributes() ?>><?php echo $pessoa_list->Idade->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pessoa_list->ListOptions->render("body", "right", $pessoa_list->RowCount);
?>
	</tr>
<?php
	}
	if (!$pessoa_list->isGridAdd())
		$pessoa_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$pessoa->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($pessoa_list->Recordset)
	$pessoa_list->Recordset->Close();
?>
<?php if (!$pessoa_list->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$pessoa_list->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $pessoa_list->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $pessoa_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($pessoa_list->TotalRecords == 0 && !$pessoa->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $pessoa_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$pessoa_list->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$pessoa_list->isExport()) { ?>
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
$pessoa_list->terminate();
?>