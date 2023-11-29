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
$endereco_view = new endereco_view();

// Run the page
$endereco_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$endereco_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$endereco_view->isExport()) { ?>
<script>
var fenderecoview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fenderecoview = currentForm = new ew.Form("fenderecoview", "view");
	loadjs.done("fenderecoview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$endereco_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $endereco_view->ExportOptions->render("body") ?>
<?php $endereco_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $endereco_view->showPageHeader(); ?>
<?php
$endereco_view->showMessage();
?>
<form name="fenderecoview" id="fenderecoview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="endereco">
<input type="hidden" name="modal" value="<?php echo (int)$endereco_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($endereco_view->idendereco->Visible) { // idendereco ?>
	<tr id="r_idendereco">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_idendereco"><?php echo $endereco_view->idendereco->caption() ?></span></td>
		<td data-name="idendereco" <?php echo $endereco_view->idendereco->cellAttributes() ?>>
<span id="el_endereco_idendereco">
<span<?php echo $endereco_view->idendereco->viewAttributes() ?>><?php echo $endereco_view->idendereco->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->idacademia->Visible) { // idacademia ?>
	<tr id="r_idacademia">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_idacademia"><?php echo $endereco_view->idacademia->caption() ?></span></td>
		<td data-name="idacademia" <?php echo $endereco_view->idacademia->cellAttributes() ?>>
<span id="el_endereco_idacademia">
<span<?php echo $endereco_view->idacademia->viewAttributes() ?>><?php echo $endereco_view->idacademia->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->idpessoa->Visible) { // idpessoa ?>
	<tr id="r_idpessoa">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_idpessoa"><?php echo $endereco_view->idpessoa->caption() ?></span></td>
		<td data-name="idpessoa" <?php echo $endereco_view->idpessoa->cellAttributes() ?>>
<span id="el_endereco_idpessoa">
<span<?php echo $endereco_view->idpessoa->viewAttributes() ?>><?php echo $endereco_view->idpessoa->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->CEP->Visible) { // CEP ?>
	<tr id="r_CEP">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_CEP"><?php echo $endereco_view->CEP->caption() ?></span></td>
		<td data-name="CEP" <?php echo $endereco_view->CEP->cellAttributes() ?>>
<span id="el_endereco_CEP">
<span<?php echo $endereco_view->CEP->viewAttributes() ?>><?php echo $endereco_view->CEP->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->UF->Visible) { // UF ?>
	<tr id="r_UF">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_UF"><?php echo $endereco_view->UF->caption() ?></span></td>
		<td data-name="UF" <?php echo $endereco_view->UF->cellAttributes() ?>>
<span id="el_endereco_UF">
<span<?php echo $endereco_view->UF->viewAttributes() ?>><?php echo $endereco_view->UF->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->Cidade->Visible) { // Cidade ?>
	<tr id="r_Cidade">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_Cidade"><?php echo $endereco_view->Cidade->caption() ?></span></td>
		<td data-name="Cidade" <?php echo $endereco_view->Cidade->cellAttributes() ?>>
<span id="el_endereco_Cidade">
<span<?php echo $endereco_view->Cidade->viewAttributes() ?>><?php echo $endereco_view->Cidade->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->Bairro->Visible) { // Bairro ?>
	<tr id="r_Bairro">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_Bairro"><?php echo $endereco_view->Bairro->caption() ?></span></td>
		<td data-name="Bairro" <?php echo $endereco_view->Bairro->cellAttributes() ?>>
<span id="el_endereco_Bairro">
<span<?php echo $endereco_view->Bairro->viewAttributes() ?>><?php echo $endereco_view->Bairro->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->Rua->Visible) { // Rua ?>
	<tr id="r_Rua">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_Rua"><?php echo $endereco_view->Rua->caption() ?></span></td>
		<td data-name="Rua" <?php echo $endereco_view->Rua->cellAttributes() ?>>
<span id="el_endereco_Rua">
<span<?php echo $endereco_view->Rua->viewAttributes() ?>><?php echo $endereco_view->Rua->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->Numero->Visible) { // Numero ?>
	<tr id="r_Numero">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_Numero"><?php echo $endereco_view->Numero->caption() ?></span></td>
		<td data-name="Numero" <?php echo $endereco_view->Numero->cellAttributes() ?>>
<span id="el_endereco_Numero">
<span<?php echo $endereco_view->Numero->viewAttributes() ?>><?php echo $endereco_view->Numero->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($endereco_view->Complemento->Visible) { // Complemento ?>
	<tr id="r_Complemento">
		<td class="<?php echo $endereco_view->TableLeftColumnClass ?>"><span id="elh_endereco_Complemento"><?php echo $endereco_view->Complemento->caption() ?></span></td>
		<td data-name="Complemento" <?php echo $endereco_view->Complemento->cellAttributes() ?>>
<span id="el_endereco_Complemento">
<span<?php echo $endereco_view->Complemento->viewAttributes() ?>><?php echo $endereco_view->Complemento->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$endereco_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$endereco_view->isExport()) { ?>
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
$endereco_view->terminate();
?>