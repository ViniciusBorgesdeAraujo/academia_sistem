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
$pessoa_view = new pessoa_view();

// Run the page
$pessoa_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_view->Page_Render();
?>
<?php include_once "header.php"; ?>
<?php if (!$pessoa_view->isExport()) { ?>
<script>
var fpessoaview, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "view";
	fpessoaview = currentForm = new ew.Form("fpessoaview", "view");
	loadjs.done("fpessoaview");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php } ?>
<?php if (!$pessoa_view->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $pessoa_view->ExportOptions->render("body") ?>
<?php $pessoa_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pessoa_view->showPageHeader(); ?>
<?php
$pessoa_view->showMessage();
?>
<form name="fpessoaview" id="fpessoaview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pessoa">
<input type="hidden" name="modal" value="<?php echo (int)$pessoa_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($pessoa_view->idpessoa->Visible) { // idpessoa ?>
	<tr id="r_idpessoa">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_idpessoa"><?php echo $pessoa_view->idpessoa->caption() ?></span></td>
		<td data-name="idpessoa" <?php echo $pessoa_view->idpessoa->cellAttributes() ?>>
<span id="el_pessoa_idpessoa">
<span<?php echo $pessoa_view->idpessoa->viewAttributes() ?>><?php echo $pessoa_view->idpessoa->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->idaula->Visible) { // idaula ?>
	<tr id="r_idaula">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_idaula"><?php echo $pessoa_view->idaula->caption() ?></span></td>
		<td data-name="idaula" <?php echo $pessoa_view->idaula->cellAttributes() ?>>
<span id="el_pessoa_idaula">
<span<?php echo $pessoa_view->idaula->viewAttributes() ?>><?php echo $pessoa_view->idaula->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Nome->Visible) { // Nome ?>
	<tr id="r_Nome">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Nome"><?php echo $pessoa_view->Nome->caption() ?></span></td>
		<td data-name="Nome" <?php echo $pessoa_view->Nome->cellAttributes() ?>>
<span id="el_pessoa_Nome">
<span<?php echo $pessoa_view->Nome->viewAttributes() ?>><?php echo $pessoa_view->Nome->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->CPF->Visible) { // CPF ?>
	<tr id="r_CPF">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_CPF"><?php echo $pessoa_view->CPF->caption() ?></span></td>
		<td data-name="CPF" <?php echo $pessoa_view->CPF->cellAttributes() ?>>
<span id="el_pessoa_CPF">
<span<?php echo $pessoa_view->CPF->viewAttributes() ?>><?php echo $pessoa_view->CPF->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Senha->Visible) { // Senha ?>
	<tr id="r_Senha">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Senha"><?php echo $pessoa_view->Senha->caption() ?></span></td>
		<td data-name="Senha" <?php echo $pessoa_view->Senha->cellAttributes() ?>>
<span id="el_pessoa_Senha">
<span<?php echo $pessoa_view->Senha->viewAttributes() ?>><?php echo $pessoa_view->Senha->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Sexo->Visible) { // Sexo ?>
	<tr id="r_Sexo">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Sexo"><?php echo $pessoa_view->Sexo->caption() ?></span></td>
		<td data-name="Sexo" <?php echo $pessoa_view->Sexo->cellAttributes() ?>>
<span id="el_pessoa_Sexo">
<span<?php echo $pessoa_view->Sexo->viewAttributes() ?>><?php echo $pessoa_view->Sexo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->datanascimento->Visible) { // datanascimento ?>
	<tr id="r_datanascimento">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_datanascimento"><?php echo $pessoa_view->datanascimento->caption() ?></span></td>
		<td data-name="datanascimento" <?php echo $pessoa_view->datanascimento->cellAttributes() ?>>
<span id="el_pessoa_datanascimento">
<span<?php echo $pessoa_view->datanascimento->viewAttributes() ?>><?php echo $pessoa_view->datanascimento->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Funcao->Visible) { // Funcao ?>
	<tr id="r_Funcao">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Funcao"><?php echo $pessoa_view->Funcao->caption() ?></span></td>
		<td data-name="Funcao" <?php echo $pessoa_view->Funcao->cellAttributes() ?>>
<span id="el_pessoa_Funcao">
<span<?php echo $pessoa_view->Funcao->viewAttributes() ?>><?php echo $pessoa_view->Funcao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Sessao->Visible) { // Sessao ?>
	<tr id="r_Sessao">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Sessao"><?php echo $pessoa_view->Sessao->caption() ?></span></td>
		<td data-name="Sessao" <?php echo $pessoa_view->Sessao->cellAttributes() ?>>
<span id="el_pessoa_Sessao">
<span<?php echo $pessoa_view->Sessao->viewAttributes() ?>><?php echo $pessoa_view->Sessao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->_Email->Visible) { // Email ?>
	<tr id="r__Email">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa__Email"><?php echo $pessoa_view->_Email->caption() ?></span></td>
		<td data-name="_Email" <?php echo $pessoa_view->_Email->cellAttributes() ?>>
<span id="el_pessoa__Email">
<span<?php echo $pessoa_view->_Email->viewAttributes() ?>><?php echo $pessoa_view->_Email->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Ativado->Visible) { // Ativado ?>
	<tr id="r_Ativado">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Ativado"><?php echo $pessoa_view->Ativado->caption() ?></span></td>
		<td data-name="Ativado" <?php echo $pessoa_view->Ativado->cellAttributes() ?>>
<span id="el_pessoa_Ativado">
<span<?php echo $pessoa_view->Ativado->viewAttributes() ?>><?php echo $pessoa_view->Ativado->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->datadecadastro->Visible) { // datadecadastro ?>
	<tr id="r_datadecadastro">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_datadecadastro"><?php echo $pessoa_view->datadecadastro->caption() ?></span></td>
		<td data-name="datadecadastro" <?php echo $pessoa_view->datadecadastro->cellAttributes() ?>>
<span id="el_pessoa_datadecadastro">
<span<?php echo $pessoa_view->datadecadastro->viewAttributes() ?>><?php echo $pessoa_view->datadecadastro->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pessoa_view->Idade->Visible) { // Idade ?>
	<tr id="r_Idade">
		<td class="<?php echo $pessoa_view->TableLeftColumnClass ?>"><span id="elh_pessoa_Idade"><?php echo $pessoa_view->Idade->caption() ?></span></td>
		<td data-name="Idade" <?php echo $pessoa_view->Idade->cellAttributes() ?>>
<span id="el_pessoa_Idade">
<span<?php echo $pessoa_view->Idade->viewAttributes() ?>><?php echo $pessoa_view->Idade->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($pessoa->getCurrentDetailTable() != "") { ?>
<?php
	$pessoa_view->DetailPages->ValidKeys = explode(",", $pessoa->getCurrentDetailTable());
	$firstActiveDetailTable = $pessoa_view->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="pessoa_view_details"><!-- tabs -->
	<ul class="<?php echo $pessoa_view->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("endereco", explode(",", $pessoa->getCurrentDetailTable())) && $endereco->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco") {
			$firstActiveDetailTable = "endereco";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $pessoa_view->DetailPages->pageStyle("endereco") ?>" href="#tab_endereco" data-toggle="tab"><?php echo $Language->tablePhrase("endereco", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $pessoa_view->endereco_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
<?php
	if (in_array("documentos", explode(",", $pessoa->getCurrentDetailTable())) && $documentos->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "documentos") {
			$firstActiveDetailTable = "documentos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $pessoa_view->DetailPages->pageStyle("documentos") ?>" href="#tab_documentos" data-toggle="tab"><?php echo $Language->tablePhrase("documentos", "TblCaption") ?>&nbsp;<?php echo str_replace("%c", $pessoa_view->documentos_Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("endereco", explode(",", $pessoa->getCurrentDetailTable())) && $endereco->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco")
			$firstActiveDetailTable = "endereco";
?>
		<div class="tab-pane <?php echo $pessoa_view->DetailPages->pageStyle("endereco") ?>" id="tab_endereco"><!-- page* -->
<?php include_once "enderecogrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("documentos", explode(",", $pessoa->getCurrentDetailTable())) && $documentos->DetailView) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "documentos")
			$firstActiveDetailTable = "documentos";
?>
		<div class="tab-pane <?php echo $pessoa_view->DetailPages->pageStyle("documentos") ?>" id="tab_documentos"><!-- page* -->
<?php include_once "documentosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<?php
$pessoa_view->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<?php if (!$pessoa_view->isExport()) { ?>
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
$pessoa_view->terminate();
?>