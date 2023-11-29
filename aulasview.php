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
$aulas_view = new aulas_view();

// Run the page
$aulas_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$aulas_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$aulas_view->isExport()) { ?>
<script>
var faulasview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	faulasview = currentForm = new ew.Form("faulasview", "view");
	loadjs.done("faulasview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$aulas_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $aulas_view->ExportOptions->render("body") ?>
<?php $aulas_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $aulas_view->showPageHeader(); ?>
<?php
$aulas_view->showMessage();
?>
<form name="faulasview" id="faulasview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="aulas">
<input type="hidden" name="modal" value="<?php echo (int)$aulas_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($aulas_view->idaulas->Visible) { // idaulas ?>
	<tr id="r_idaulas">
		<td class="<?php echo $aulas_view->TableLeftColumnClass ?>"><span id="elh_aulas_idaulas"><?php echo $aulas_view->idaulas->caption() ?></span></td>
		<td data-name="idaulas" <?php echo $aulas_view->idaulas->cellAttributes() ?>>
<span id="el_aulas_idaulas">
<span<?php echo $aulas_view->idaulas->viewAttributes() ?>><?php echo $aulas_view->idaulas->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($aulas_view->idturnos->Visible) { // idturnos ?>
	<tr id="r_idturnos">
		<td class="<?php echo $aulas_view->TableLeftColumnClass ?>"><span id="elh_aulas_idturnos"><?php echo $aulas_view->idturnos->caption() ?></span></td>
		<td data-name="idturnos" <?php echo $aulas_view->idturnos->cellAttributes() ?>>
<span id="el_aulas_idturnos">
<span<?php echo $aulas_view->idturnos->viewAttributes() ?>><?php echo $aulas_view->idturnos->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($aulas_view->idaluno->Visible) { // idaluno ?>
	<tr id="r_idaluno">
		<td class="<?php echo $aulas_view->TableLeftColumnClass ?>"><span id="elh_aulas_idaluno"><?php echo $aulas_view->idaluno->caption() ?></span></td>
		<td data-name="idaluno" <?php echo $aulas_view->idaluno->cellAttributes() ?>>
<span id="el_aulas_idaluno">
<span<?php echo $aulas_view->idaluno->viewAttributes() ?>><?php echo $aulas_view->idaluno->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($aulas_view->nome->Visible) { // nome ?>
	<tr id="r_nome">
		<td class="<?php echo $aulas_view->TableLeftColumnClass ?>"><span id="elh_aulas_nome"><?php echo $aulas_view->nome->caption() ?></span></td>
		<td data-name="nome" <?php echo $aulas_view->nome->cellAttributes() ?>>
<span id="el_aulas_nome">
<span<?php echo $aulas_view->nome->viewAttributes() ?>><?php echo $aulas_view->nome->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($aulas_view->ativado->Visible) { // ativado ?>
	<tr id="r_ativado">
		<td class="<?php echo $aulas_view->TableLeftColumnClass ?>"><span id="elh_aulas_ativado"><?php echo $aulas_view->ativado->caption() ?></span></td>
		<td data-name="ativado" <?php echo $aulas_view->ativado->cellAttributes() ?>>
<span id="el_aulas_ativado">
<span<?php echo $aulas_view->ativado->viewAttributes() ?>><?php echo $aulas_view->ativado->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($aulas->getCurrentDetailTable() != "") { ?>
<?php
	$aulas_view->DetailPages->ValidKeys = explode(",", $aulas->getCurrentDetailTable());
	$firstActiveDetailTable = $aulas_view->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="aulas_view_details"><!-- tabs -->
	<ul class="<?php echo $aulas_view->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("pessoa", explode(",", $aulas->getCurrentDetailTable())) && $pessoa->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "pessoa") {
			$firstActiveDetailTable = "pessoa";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $aulas_view->DetailPages->pageStyle("pessoa") ?>" href="#tab_pessoa" data-toggle="tab"><?php echo $Language->tablePhrase("pessoa", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $aulas_view->pessoa_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
<?php
	if (in_array("videos", explode(",", $aulas->getCurrentDetailTable())) && $videos->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "videos") {
			$firstActiveDetailTable = "videos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $aulas_view->DetailPages->pageStyle("videos") ?>" href="#tab_videos" data-toggle="tab"><?php echo $Language->tablePhrase("videos", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $aulas_view->videos_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("pessoa", explode(",", $aulas->getCurrentDetailTable())) && $pessoa->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "pessoa")
			$firstActiveDetailTable = "pessoa";
?>
		<div class="tab-pane <?php echo $aulas_view->DetailPages->pageStyle("pessoa") ?>" id="tab_pessoa"><!-- page* -->
<?php include_once "pessoagrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("videos", explode(",", $aulas->getCurrentDetailTable())) && $videos->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "videos")
			$firstActiveDetailTable = "videos";
?>
		<div class="tab-pane <?php echo $aulas_view->DetailPages->pageStyle("videos") ?>" id="tab_videos"><!-- page* -->
<?php include_once "videosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<?php
$aulas_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$aulas_view->isExport()) { ?>
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
$aulas_view->terminate();
?>