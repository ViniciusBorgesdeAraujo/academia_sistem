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
$turnos_view = new turnos_view();

// Run the page
$turnos_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$turnos_view->isExport()) { ?>
<script>
var fturnosview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fturnosview = currentForm = new ew.Form("fturnosview", "view");
	loadjs.done("fturnosview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$turnos_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $turnos_view->ExportOptions->render("body") ?>
<?php $turnos_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $turnos_view->showPageHeader(); ?>
<?php
$turnos_view->showMessage();
?>
<form name="fturnosview" id="fturnosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="turnos">
<input type="hidden" name="modal" value="<?php echo (int)$turnos_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($turnos_view->idturnos->Visible) { // idturnos ?>
	<tr id="r_idturnos">
		<td class="<?php echo $turnos_view->TableLeftColumnClass ?>"><span id="elh_turnos_idturnos"><?php echo $turnos_view->idturnos->caption() ?></span></td>
		<td data-name="idturnos" <?php echo $turnos_view->idturnos->cellAttributes() ?>>
<span id="el_turnos_idturnos">
<span<?php echo $turnos_view->idturnos->viewAttributes() ?>><?php echo $turnos_view->idturnos->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($turnos_view->idacademia->Visible) { // idacademia ?>
	<tr id="r_idacademia">
		<td class="<?php echo $turnos_view->TableLeftColumnClass ?>"><span id="elh_turnos_idacademia"><?php echo $turnos_view->idacademia->caption() ?></span></td>
		<td data-name="idacademia" <?php echo $turnos_view->idacademia->cellAttributes() ?>>
<span id="el_turnos_idacademia">
<span<?php echo $turnos_view->idacademia->viewAttributes() ?>><?php echo $turnos_view->idacademia->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($turnos_view->turmas->Visible) { // turmas ?>
	<tr id="r_turmas">
		<td class="<?php echo $turnos_view->TableLeftColumnClass ?>"><span id="elh_turnos_turmas"><?php echo $turnos_view->turmas->caption() ?></span></td>
		<td data-name="turmas" <?php echo $turnos_view->turmas->cellAttributes() ?>>
<span id="el_turnos_turmas">
<span<?php echo $turnos_view->turmas->viewAttributes() ?>><?php echo $turnos_view->turmas->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("aulas", explode(",", $turnos->getCurrentDetailTable())) && $aulas->DetailView) {
?>
<?php if ($turnos->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->tablePhrase("aulas", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $turnos_view->aulas_Count, $Language->phrase("DetailCount")) ?></h4>
<?php } ?>
<?php include_once "aulasgrid.php" ?>
<?php } ?>
</form>
<?php
$turnos_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$turnos_view->isExport()) { ?>
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
$turnos_view->terminate();
?>