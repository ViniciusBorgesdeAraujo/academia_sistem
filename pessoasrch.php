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
$pessoa_search = new pessoa_search();

// Run the page
$pessoa_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fpessoasearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($pessoa_search->IsModal) { ?>
	fpessoasearch = currentAdvancedSearchForm = new ew.Form("fpessoasearch", "search");
	<?php } else { ?>
	fpessoasearch = currentForm = new ew.Form("fpessoasearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fpessoasearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idpessoa");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($pessoa_search->idpessoa->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_idaula");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($pessoa_search->idaula->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_datanascimento");
		if (elm && !ew.checkEuroDate(elm.value))
			return this.onError(elm, "<?php echo JsEncode($pessoa_search->datanascimento->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_datadecadastro");
		if (elm && !ew.checkDateDef(elm.value))
			return this.onError(elm, "<?php echo JsEncode($pessoa_search->datadecadastro->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_Idade");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($pessoa_search->Idade->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fpessoasearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fpessoasearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fpessoasearch.lists["x_idaula"] = <?php echo $pessoa_search->idaula->Lookup->toClientList($pessoa_search) ?>;
	fpessoasearch.lists["x_idaula"].options = <?php echo JsonEncode($pessoa_search->idaula->lookupOptions()) ?>;
	fpessoasearch.autoSuggests["x_idaula"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	fpessoasearch.lists["x_Sexo"] = <?php echo $pessoa_search->Sexo->Lookup->toClientList($pessoa_search) ?>;
	fpessoasearch.lists["x_Sexo"].options = <?php echo JsonEncode($pessoa_search->Sexo->options(FALSE, TRUE)) ?>;
	fpessoasearch.lists["x_Funcao"] = <?php echo $pessoa_search->Funcao->Lookup->toClientList($pessoa_search) ?>;
	fpessoasearch.lists["x_Funcao"].options = <?php echo JsonEncode($pessoa_search->Funcao->lookupOptions()) ?>;
	fpessoasearch.lists["x_Ativado"] = <?php echo $pessoa_search->Ativado->Lookup->toClientList($pessoa_search) ?>;
	fpessoasearch.lists["x_Ativado"].options = <?php echo JsonEncode($pessoa_search->Ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("fpessoasearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $pessoa_search->showPageHeader(); ?>
<?php
$pessoa_search->showMessage();
?>
<form name="fpessoasearch" id="fpessoasearch" class="<?php echo $pessoa_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pessoa">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$pessoa_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($pessoa_search->idpessoa->Visible) { // idpessoa ?>
	<div id="r_idpessoa" class="form-group row">
		<label for="x_idpessoa" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_idpessoa"><?php echo $pessoa_search->idpessoa->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idpessoa" id="z_idpessoa" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->idpessoa->cellAttributes() ?>>
			<span id="el_pessoa_idpessoa" class="ew-search-field">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$pessoa->userIDAllow("search")) { // Non system admin ?>
<span<?php echo $pessoa_search->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_search->idpessoa->EditValue)) ?>"></span>
<input type="hidden" data-table="pessoa" data-field="x_idpessoa" data-page="1" name="x_idpessoa" id="x_idpessoa" value="<?php echo HtmlEncode($pessoa_search->idpessoa->AdvancedSearch->SearchValue) ?>">
<?php } else { ?>
<input type="text" data-table="pessoa" data-field="x_idpessoa" data-page="1" name="x_idpessoa" id="x_idpessoa" maxlength="11" placeholder="<?php echo HtmlEncode($pessoa_search->idpessoa->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->idpessoa->EditValue ?>"<?php echo $pessoa_search->idpessoa->editAttributes() ?>>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->idaula->Visible) { // idaula ?>
	<div id="r_idaula" class="form-group row">
		<label class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_idaula"><?php echo $pessoa_search->idaula->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idaula" id="z_idaula" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->idaula->cellAttributes() ?>>
			<span id="el_pessoa_idaula" class="ew-search-field">
<?php
$onchange = $pessoa_search->idaula->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$pessoa_search->idaula->EditAttrs["onchange"] = "";
?>
<span id="as_x_idaula">
	<input type="text" class="form-control" name="sv_x_idaula" id="sv_x_idaula" value="<?php echo RemoveHtml($pessoa_search->idaula->EditValue) ?>" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($pessoa_search->idaula->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pessoa_search->idaula->getPlaceHolder()) ?>"<?php echo $pessoa_search->idaula->editAttributes() ?>>
</span>
<input type="hidden" data-table="pessoa" data-field="x_idaula" data-page="1" data-value-separator="<?php echo $pessoa_search->idaula->displayValueSeparatorAttribute() ?>" name="x_idaula" id="x_idaula" value="<?php echo HtmlEncode($pessoa_search->idaula->AdvancedSearch->SearchValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["fpessoasearch"], function() {
	fpessoasearch.createAutoSuggest({"id":"x_idaula","forceSelect":false});
});
</script>
<?php echo $pessoa_search->idaula->Lookup->getParamTag($pessoa_search, "p_x_idaula") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Nome->Visible) { // Nome ?>
	<div id="r_Nome" class="form-group row">
		<label for="x_Nome" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Nome"><?php echo $pessoa_search->Nome->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Nome" id="z_Nome" value="LIKE">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Nome->cellAttributes() ?>>
			<span id="el_pessoa_Nome" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_Nome" data-page="1" name="x_Nome" id="x_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_search->Nome->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->Nome->EditValue ?>"<?php echo $pessoa_search->Nome->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->CPF->Visible) { // CPF ?>
	<div id="r_CPF" class="form-group row">
		<label for="x_CPF" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_CPF"><?php echo $pessoa_search->CPF->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_CPF" id="z_CPF" value="LIKE">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->CPF->cellAttributes() ?>>
			<span id="el_pessoa_CPF" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_CPF" data-page="1" name="x_CPF" id="x_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_search->CPF->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->CPF->EditValue ?>"<?php echo $pessoa_search->CPF->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Senha->Visible) { // Senha ?>
	<div id="r_Senha" class="form-group row">
		<label for="x_Senha" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Senha"><?php echo $pessoa_search->Senha->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Senha" id="z_Senha" value="LIKE">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Senha->cellAttributes() ?>>
			<span id="el_pessoa_Senha" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_Senha" data-page="1" name="x_Senha" id="x_Senha" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_search->Senha->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->Senha->EditValue ?>"<?php echo $pessoa_search->Senha->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Sexo->Visible) { // Sexo ?>
	<div id="r_Sexo" class="form-group row">
		<label class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Sexo"><?php echo $pessoa_search->Sexo->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_Sexo" id="z_Sexo" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Sexo->cellAttributes() ?>>
			<span id="el_pessoa_Sexo" class="ew-search-field">
<div id="tp_x_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-page="1" data-value-separator="<?php echo $pessoa_search->Sexo->displayValueSeparatorAttribute() ?>" name="x_Sexo" id="x_Sexo" value="{value}"<?php echo $pessoa_search->Sexo->editAttributes() ?>></div>
<div id="dsl_x_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_search->Sexo->radioButtonListHtml(FALSE, "x_Sexo", 1) ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->datanascimento->Visible) { // datanascimento ?>
	<div id="r_datanascimento" class="form-group row">
		<label for="x_datanascimento" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_datanascimento"><?php echo $pessoa_search->datanascimento->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_datanascimento" id="z_datanascimento" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->datanascimento->cellAttributes() ?>>
			<span id="el_pessoa_datanascimento" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-page="1" data-format="7" name="x_datanascimento" id="x_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_search->datanascimento->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->datanascimento->EditValue ?>"<?php echo $pessoa_search->datanascimento->editAttributes() ?>>
<?php if (!$pessoa_search->datanascimento->ReadOnly && !$pessoa_search->datanascimento->Disabled && !isset($pessoa_search->datanascimento->EditAttrs["readonly"]) && !isset($pessoa_search->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoasearch", "x_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Funcao->Visible) { // Funcao ?>
	<div id="r_Funcao" class="form-group row">
		<label for="x_Funcao" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Funcao"><?php echo $pessoa_search->Funcao->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_Funcao" id="z_Funcao" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Funcao->cellAttributes() ?>>
			<span id="el_pessoa_Funcao" class="ew-search-field">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_search->Funcao->EditValue)) ?>">
<?php } else { ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_Funcao" data-page="1" data-value-separator="<?php echo $pessoa_search->Funcao->displayValueSeparatorAttribute() ?>" id="x_Funcao" name="x_Funcao"<?php echo $pessoa_search->Funcao->editAttributes() ?>>
			<?php echo $pessoa_search->Funcao->selectOptionListHtml("x_Funcao") ?>
		</select>
</div>
<?php echo $pessoa_search->Funcao->Lookup->getParamTag($pessoa_search, "p_x_Funcao") ?>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Sessao->Visible) { // Sessao ?>
	<div id="r_Sessao" class="form-group row">
		<label for="x_Sessao" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Sessao"><?php echo $pessoa_search->Sessao->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Sessao" id="z_Sessao" value="LIKE">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Sessao->cellAttributes() ?>>
			<span id="el_pessoa_Sessao" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_Sessao" data-page="1" name="x_Sessao" id="x_Sessao" size="35" maxlength="65535" placeholder="<?php echo HtmlEncode($pessoa_search->Sessao->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->Sessao->EditValue ?>"<?php echo $pessoa_search->Sessao->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group row">
		<label for="x__Email" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa__Email"><?php echo $pessoa_search->_Email->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z__Email" id="z__Email" value="LIKE">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->_Email->cellAttributes() ?>>
			<span id="el_pessoa__Email" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x__Email" data-page="1" name="x__Email" id="x__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_search->_Email->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->_Email->EditValue ?>"<?php echo $pessoa_search->_Email->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Ativado->Visible) { // Ativado ?>
	<div id="r_Ativado" class="form-group row">
		<label class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Ativado"><?php echo $pessoa_search->Ativado->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_Ativado" id="z_Ativado" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Ativado->cellAttributes() ?>>
			<span id="el_pessoa_Ativado" class="ew-search-field">
<div id="tp_x_Ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Ativado" data-page="1" data-value-separator="<?php echo $pessoa_search->Ativado->displayValueSeparatorAttribute() ?>" name="x_Ativado" id="x_Ativado" value="{value}"<?php echo $pessoa_search->Ativado->editAttributes() ?>></div>
<div id="dsl_x_Ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_search->Ativado->radioButtonListHtml(FALSE, "x_Ativado", 1) ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->datadecadastro->Visible) { // datadecadastro ?>
	<div id="r_datadecadastro" class="form-group row">
		<label for="x_datadecadastro" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_datadecadastro"><?php echo $pessoa_search->datadecadastro->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_datadecadastro" id="z_datadecadastro" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->datadecadastro->cellAttributes() ?>>
			<span id="el_pessoa_datadecadastro" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_datadecadastro" data-page="1" name="x_datadecadastro" id="x_datadecadastro" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_search->datadecadastro->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->datadecadastro->EditValue ?>"<?php echo $pessoa_search->datadecadastro->editAttributes() ?>>
<?php if (!$pessoa_search->datadecadastro->ReadOnly && !$pessoa_search->datadecadastro->Disabled && !isset($pessoa_search->datadecadastro->EditAttrs["readonly"]) && !isset($pessoa_search->datadecadastro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoasearch", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoasearch", "x_datadecadastro", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($pessoa_search->Idade->Visible) { // Idade ?>
	<div id="r_Idade" class="form-group row">
		<label for="x_Idade" class="<?php echo $pessoa_search->LeftColumnClass ?>"><span id="elh_pessoa_Idade"><?php echo $pessoa_search->Idade->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_Idade" id="z_Idade" value="=">
</span>
		</label>
		<div class="<?php echo $pessoa_search->RightColumnClass ?>"><div <?php echo $pessoa_search->Idade->cellAttributes() ?>>
			<span id="el_pessoa_Idade" class="ew-search-field">
<input type="text" data-table="pessoa" data-field="x_Idade" data-page="1" name="x_Idade" id="x_Idade" size="30" maxlength="5" placeholder="<?php echo HtmlEncode($pessoa_search->Idade->getPlaceHolder()) ?>" value="<?php echo $pessoa_search->Idade->EditValue ?>"<?php echo $pessoa_search->Idade->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$pessoa_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pessoa_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$pessoa_search->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$pessoa_search->terminate();
?>