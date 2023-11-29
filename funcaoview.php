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
$funcao_view = new funcao_view();

// Run the page
$funcao_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$funcao_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$funcao_view->isExport()) { ?>
<script>
var ffuncaoview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	ffuncaoview = currentForm = new ew.Form("ffuncaoview", "view");
	loadjs.done("ffuncaoview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$funcao_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $funcao_view->ExportOptions->render("body") ?>
<?php $funcao_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $funcao_view->showPageHeader(); ?>
<?php
$funcao_view->showMessage();
?>
<form name="ffuncaoview" id="ffuncaoview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="funcao">
<input type="hidden" name="modal" value="<?php echo (int)$funcao_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($funcao_view->idfuncao->Visible) { // idfuncao ?>
	<tr id="r_idfuncao">
		<td class="<?php echo $funcao_view->TableLeftColumnClass ?>"><span id="elh_funcao_idfuncao"><?php echo $funcao_view->idfuncao->caption() ?></span></td>
		<td data-name="idfuncao" <?php echo $funcao_view->idfuncao->cellAttributes() ?>>
<span id="el_funcao_idfuncao">
<span<?php echo $funcao_view->idfuncao->viewAttributes() ?>><?php echo $funcao_view->idfuncao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($funcao_view->funcao->Visible) { // funcao ?>
	<tr id="r_funcao">
		<td class="<?php echo $funcao_view->TableLeftColumnClass ?>"><span id="elh_funcao_funcao"><?php echo $funcao_view->funcao->caption() ?></span></td>
		<td data-name="funcao" <?php echo $funcao_view->funcao->cellAttributes() ?>>
<span id="el_funcao_funcao">
<span<?php echo $funcao_view->funcao->viewAttributes() ?>><?php echo $funcao_view->funcao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$funcao_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$funcao_view->isExport()) { ?>
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
$funcao_view->terminate();
?>