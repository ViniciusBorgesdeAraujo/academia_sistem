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
$academia_view = new academia_view();

// Run the page
$academia_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$academia_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$academia_view->isExport()) { ?>
<script>
var facademiaview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	facademiaview = currentForm = new ew.Form("facademiaview", "view");
	loadjs.done("facademiaview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$academia_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $academia_view->ExportOptions->render("body") ?>
<?php $academia_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $academia_view->showPageHeader(); ?>
<?php
$academia_view->showMessage();
?>
<form name="facademiaview" id="facademiaview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="academia">
<input type="hidden" name="modal" value="<?php echo (int)$academia_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($academia_view->idacademia->Visible) { // idacademia ?>
	<tr id="r_idacademia">
		<td class="<?php echo $academia_view->TableLeftColumnClass ?>"><span id="elh_academia_idacademia"><?php echo $academia_view->idacademia->caption() ?></span></td>
		<td data-name="idacademia" <?php echo $academia_view->idacademia->cellAttributes() ?>>
<span id="el_academia_idacademia">
<span<?php echo $academia_view->idacademia->viewAttributes() ?>><?php echo $academia_view->idacademia->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($academia_view->nome->Visible) { // nome ?>
	<tr id="r_nome">
		<td class="<?php echo $academia_view->TableLeftColumnClass ?>"><span id="elh_academia_nome"><?php echo $academia_view->nome->caption() ?></span></td>
		<td data-name="nome" <?php echo $academia_view->nome->cellAttributes() ?>>
<span id="el_academia_nome">
<span<?php echo $academia_view->nome->viewAttributes() ?>><?php echo $academia_view->nome->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($academia_view->registro->Visible) { // registro ?>
	<tr id="r_registro">
		<td class="<?php echo $academia_view->TableLeftColumnClass ?>"><span id="elh_academia_registro"><?php echo $academia_view->registro->caption() ?></span></td>
		<td data-name="registro" <?php echo $academia_view->registro->cellAttributes() ?>>
<span id="el_academia_registro">
<span<?php echo $academia_view->registro->viewAttributes() ?>><?php echo $academia_view->registro->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($academia_view->ativado->Visible) { // ativado ?>
	<tr id="r_ativado">
		<td class="<?php echo $academia_view->TableLeftColumnClass ?>"><span id="elh_academia_ativado"><?php echo $academia_view->ativado->caption() ?></span></td>
		<td data-name="ativado" <?php echo $academia_view->ativado->cellAttributes() ?>>
<span id="el_academia_ativado">
<span<?php echo $academia_view->ativado->viewAttributes() ?>><?php echo $academia_view->ativado->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($academia_view->idaluno->Visible) { // idaluno ?>
	<tr id="r_idaluno">
		<td class="<?php echo $academia_view->TableLeftColumnClass ?>"><span id="elh_academia_idaluno"><?php echo $academia_view->idaluno->caption() ?></span></td>
		<td data-name="idaluno" <?php echo $academia_view->idaluno->cellAttributes() ?>>
<span id="el_academia_idaluno">
<span<?php echo $academia_view->idaluno->viewAttributes() ?>><?php echo $academia_view->idaluno->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($academia->getCurrentDetailTable() != "") { ?>
<?php
	$academia_view->DetailPages->ValidKeys = explode(",", $academia->getCurrentDetailTable());
	$firstActiveDetailTable = $academia_view->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="academia_view_details"><!-- tabs -->
	<ul class="<?php echo $academia_view->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("turnos", explode(",", $academia->getCurrentDetailTable())) && $turnos->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "turnos") {
			$firstActiveDetailTable = "turnos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $academia_view->DetailPages->pageStyle("turnos") ?>" href="#tab_turnos" data-toggle="tab"><?php echo $Language->tablePhrase("turnos", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $academia_view->turnos_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
<?php
	if (in_array("endereco", explode(",", $academia->getCurrentDetailTable())) && $endereco->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco") {
			$firstActiveDetailTable = "endereco";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $academia_view->DetailPages->pageStyle("endereco") ?>" href="#tab_endereco" data-toggle="tab"><?php echo $Language->tablePhrase("endereco", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $academia_view->endereco_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("turnos", explode(",", $academia->getCurrentDetailTable())) && $turnos->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "turnos")
			$firstActiveDetailTable = "turnos";
?>
		<div class="tab-pane <?php echo $academia_view->DetailPages->pageStyle("turnos") ?>" id="tab_turnos"><!-- page* -->
<?php include_once "turnosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("endereco", explode(",", $academia->getCurrentDetailTable())) && $endereco->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco")
			$firstActiveDetailTable = "endereco";
?>
		<div class="tab-pane <?php echo $academia_view->DetailPages->pageStyle("endereco") ?>" id="tab_endereco"><!-- page* -->
<?php include_once "enderecogrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<?php
$academia_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$academia_view->isExport()) { ?>
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
$academia_view->terminate();
?>