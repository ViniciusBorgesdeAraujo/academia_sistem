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
$pessoa_add = new pessoa_add();

// Run the page
$pessoa_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fpessoaadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fpessoaadd = currentForm = new ew.Form("fpessoaadd", "add");

	// Validate form
	fpessoaadd.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "confirm")
			return true;
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			<?php if ($pessoa_add->idaula->Required) { ?>
				elm = this.getElements("x" + infix + "_idaula");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->idaula->caption(), $pessoa_add->idaula->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_add->Nome->Required) { ?>
				elm = this.getElements("x" + infix + "_Nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->Nome->caption(), $pessoa_add->Nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_add->CPF->Required) { ?>
				elm = this.getElements("x" + infix + "_CPF");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->CPF->caption(), $pessoa_add->CPF->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_add->Senha->Required) { ?>
				elm = this.getElements("x" + infix + "_Senha");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->Senha->caption(), $pessoa_add->Senha->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_Senha");
				if (elm && $(elm).hasClass("ew-password-strength") && !$(elm).data("validated"))
					return this.onError(elm, ew.language.phrase("PasswordTooSimple"));
			<?php if ($pessoa_add->Sexo->Required) { ?>
				elm = this.getElements("x" + infix + "_Sexo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->Sexo->caption(), $pessoa_add->Sexo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_add->datanascimento->Required) { ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->datanascimento->caption(), $pessoa_add->datanascimento->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				if (elm && !ew.checkEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_add->datanascimento->errorMessage()) ?>");
			<?php if ($pessoa_add->Funcao->Required) { ?>
				elm = this.getElements("x" + infix + "_Funcao");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->Funcao->caption(), $pessoa_add->Funcao->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_add->_Email->Required) { ?>
				elm = this.getElements("x" + infix + "__Email");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->_Email->caption(), $pessoa_add->_Email->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "__Email");
				if (elm && !ew.checkEmail(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_add->_Email->errorMessage()) ?>");
			<?php if ($pessoa_add->Ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_Ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->Ativado->caption(), $pessoa_add->Ativado->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($pessoa_add->datadecadastro->Required) { ?>
				elm = this.getElements("x" + infix + "_datadecadastro");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_add->datadecadastro->caption(), $pessoa_add->datadecadastro->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}

		// Process detail forms
		var dfs = $fobj.find("input[name='detailpage']").get();
		for (var i = 0; i < dfs.length; i++) {
			var df = dfs[i], val = df.value;
			if (val && ew.forms[val])
				if (!ew.forms[val].validate())
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fpessoaadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fpessoaadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fpessoaadd.lists["x_idaula"] = <?php echo $pessoa_add->idaula->Lookup->toClientList($pessoa_add) ?>;
	fpessoaadd.lists["x_idaula"].options = <?php echo JsonEncode($pessoa_add->idaula->lookupOptions()) ?>;
	fpessoaadd.lists["x_Sexo"] = <?php echo $pessoa_add->Sexo->Lookup->toClientList($pessoa_add) ?>;
	fpessoaadd.lists["x_Sexo"].options = <?php echo JsonEncode($pessoa_add->Sexo->options(FALSE, TRUE)) ?>;
	fpessoaadd.lists["x_Funcao"] = <?php echo $pessoa_add->Funcao->Lookup->toClientList($pessoa_add) ?>;
	fpessoaadd.lists["x_Funcao"].options = <?php echo JsonEncode($pessoa_add->Funcao->lookupOptions()) ?>;
	fpessoaadd.lists["x_Ativado"] = <?php echo $pessoa_add->Ativado->Lookup->toClientList($pessoa_add) ?>;
	fpessoaadd.lists["x_Ativado"].options = <?php echo JsonEncode($pessoa_add->Ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("fpessoaadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $pessoa_add->showPageHeader(); ?>
<?php
$pessoa_add->showMessage();
?>
<form name="fpessoaadd" id="fpessoaadd" class="<?php echo $pessoa_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pessoa">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$pessoa_add->IsModal ?>">
<?php if ($pessoa->getCurrentMasterTable() == "aulas") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="aulas">
<input type="hidden" name="fk_idaulas" value="<?php echo HtmlEncode($pessoa_add->idaula->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($pessoa_add->idaula->Visible) { // idaula ?>
	<div id="r_idaula" class="form-group row">
		<label id="elh_pessoa_idaula" for="x_idaula" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->idaula->caption() ?><?php echo $pessoa_add->idaula->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->idaula->cellAttributes() ?>>
<?php if ($pessoa_add->idaula->getSessionValue() != "") { ?>
<span id="el_pessoa_idaula">
<span<?php echo $pessoa_add->idaula->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_add->idaula->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idaula" name="x_idaula" value="<?php echo HtmlEncode($pessoa_add->idaula->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pessoa_idaula">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_idaula" data-value-separator="<?php echo $pessoa_add->idaula->displayValueSeparatorAttribute() ?>" id="x_idaula" name="x_idaula"<?php echo $pessoa_add->idaula->editAttributes() ?>>
			<?php echo $pessoa_add->idaula->selectOptionListHtml("x_idaula") ?>
		</select>
</div>
<?php echo $pessoa_add->idaula->Lookup->getParamTag($pessoa_add, "p_x_idaula") ?>
</span>
<?php } ?>
<?php echo $pessoa_add->idaula->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->Nome->Visible) { // Nome ?>
	<div id="r_Nome" class="form-group row">
		<label id="elh_pessoa_Nome" for="x_Nome" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->Nome->caption() ?><?php echo $pessoa_add->Nome->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->Nome->cellAttributes() ?>>
<span id="el_pessoa_Nome">
<input type="text" data-table="pessoa" data-field="x_Nome" name="x_Nome" id="x_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_add->Nome->getPlaceHolder()) ?>" value="<?php echo $pessoa_add->Nome->EditValue ?>"<?php echo $pessoa_add->Nome->editAttributes() ?>>
</span>
<?php echo $pessoa_add->Nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->CPF->Visible) { // CPF ?>
	<div id="r_CPF" class="form-group row">
		<label id="elh_pessoa_CPF" for="x_CPF" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->CPF->caption() ?><?php echo $pessoa_add->CPF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->CPF->cellAttributes() ?>>
<span id="el_pessoa_CPF">
<input type="text" data-table="pessoa" data-field="x_CPF" name="x_CPF" id="x_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_add->CPF->getPlaceHolder()) ?>" value="<?php echo $pessoa_add->CPF->EditValue ?>"<?php echo $pessoa_add->CPF->editAttributes() ?>>
</span>
<?php echo $pessoa_add->CPF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->Senha->Visible) { // Senha ?>
	<div id="r_Senha" class="form-group row">
		<label id="elh_pessoa_Senha" for="x_Senha" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->Senha->caption() ?><?php echo $pessoa_add->Senha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->Senha->cellAttributes() ?>>
<span id="el_pessoa_Senha">
<div class="input-group" id="ig_Senha">
<input type="password" autocomplete="new-password" data-password-strength="pst_Senha" data-table="pessoa" data-field="x_Senha" name="x_Senha" id="x_Senha" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_add->Senha->getPlaceHolder()) ?>"<?php echo $pessoa_add->Senha->editAttributes() ?>>
<div class="input-group-append">
	<button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button>
	<button type="button" class="btn btn-default ew-password-generator" title="<?php echo HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x_Senha" data-password-confirm="c_Senha" data-password-strength="pst_Senha"><?php echo $Language->phrase("GeneratePassword") ?></button>
</div>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst_Senha">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $pessoa_add->Senha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->Sexo->Visible) { // Sexo ?>
	<div id="r_Sexo" class="form-group row">
		<label id="elh_pessoa_Sexo" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->Sexo->caption() ?><?php echo $pessoa_add->Sexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->Sexo->cellAttributes() ?>>
<span id="el_pessoa_Sexo">
<div id="tp_x_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-value-separator="<?php echo $pessoa_add->Sexo->displayValueSeparatorAttribute() ?>" name="x_Sexo" id="x_Sexo" value="{value}"<?php echo $pessoa_add->Sexo->editAttributes() ?>></div>
<div id="dsl_x_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_add->Sexo->radioButtonListHtml(FALSE, "x_Sexo") ?>
</div></div>
</span>
<?php echo $pessoa_add->Sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->datanascimento->Visible) { // datanascimento ?>
	<div id="r_datanascimento" class="form-group row">
		<label id="elh_pessoa_datanascimento" for="x_datanascimento" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->datanascimento->caption() ?><?php echo $pessoa_add->datanascimento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->datanascimento->cellAttributes() ?>>
<span id="el_pessoa_datanascimento">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-format="7" name="x_datanascimento" id="x_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_add->datanascimento->getPlaceHolder()) ?>" value="<?php echo $pessoa_add->datanascimento->EditValue ?>"<?php echo $pessoa_add->datanascimento->editAttributes() ?>>
<?php if (!$pessoa_add->datanascimento->ReadOnly && !$pessoa_add->datanascimento->Disabled && !isset($pessoa_add->datanascimento->EditAttrs["readonly"]) && !isset($pessoa_add->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoaadd", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoaadd", "x_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php echo $pessoa_add->datanascimento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->Funcao->Visible) { // Funcao ?>
	<div id="r_Funcao" class="form-group row">
		<label id="elh_pessoa_Funcao" for="x_Funcao" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->Funcao->caption() ?><?php echo $pessoa_add->Funcao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->Funcao->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_pessoa_Funcao">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_add->Funcao->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el_pessoa_Funcao">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_Funcao" data-value-separator="<?php echo $pessoa_add->Funcao->displayValueSeparatorAttribute() ?>" id="x_Funcao" name="x_Funcao"<?php echo $pessoa_add->Funcao->editAttributes() ?>>
			<?php echo $pessoa_add->Funcao->selectOptionListHtml("x_Funcao") ?>
		</select>
</div>
<?php echo $pessoa_add->Funcao->Lookup->getParamTag($pessoa_add, "p_x_Funcao") ?>
</span>
<?php } ?>
<?php echo $pessoa_add->Funcao->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group row">
		<label id="elh_pessoa__Email" for="x__Email" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->_Email->caption() ?><?php echo $pessoa_add->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->_Email->cellAttributes() ?>>
<span id="el_pessoa__Email">
<input type="text" data-table="pessoa" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_add->_Email->getPlaceHolder()) ?>" value="<?php echo $pessoa_add->_Email->EditValue ?>"<?php echo $pessoa_add->_Email->editAttributes() ?>>
</span>
<?php echo $pessoa_add->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_add->Ativado->Visible) { // Ativado ?>
	<div id="r_Ativado" class="form-group row">
		<label id="elh_pessoa_Ativado" class="<?php echo $pessoa_add->LeftColumnClass ?>"><?php echo $pessoa_add->Ativado->caption() ?><?php echo $pessoa_add->Ativado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $pessoa_add->RightColumnClass ?>"><div <?php echo $pessoa_add->Ativado->cellAttributes() ?>>
<span id="el_pessoa_Ativado">
<div id="tp_x_Ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Ativado" data-value-separator="<?php echo $pessoa_add->Ativado->displayValueSeparatorAttribute() ?>" name="x_Ativado" id="x_Ativado" value="{value}"<?php echo $pessoa_add->Ativado->editAttributes() ?>></div>
<div id="dsl_x_Ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_add->Ativado->radioButtonListHtml(FALSE, "x_Ativado") ?>
</div></div>
</span>
<?php echo $pessoa_add->Ativado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if ($pessoa->getCurrentDetailTable() != "") { ?>
<?php
	$pessoa_add->DetailPages->ValidKeys = explode(",", $pessoa->getCurrentDetailTable());
	$firstActiveDetailTable = $pessoa_add->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="pessoa_add_details"><!-- tabs -->
	<ul class="<?php echo $pessoa_add->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("endereco", explode(",", $pessoa->getCurrentDetailTable())) && $endereco->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco") {
			$firstActiveDetailTable = "endereco";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $pessoa_add->DetailPages->pageStyle("endereco") ?>" href="#tab_endereco" data-toggle="tab"><?php echo $Language->tablePhrase("endereco", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("documentos", explode(",", $pessoa->getCurrentDetailTable())) && $documentos->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "documentos") {
			$firstActiveDetailTable = "documentos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $pessoa_add->DetailPages->pageStyle("documentos") ?>" href="#tab_documentos" data-toggle="tab"><?php echo $Language->tablePhrase("documentos", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("endereco", explode(",", $pessoa->getCurrentDetailTable())) && $endereco->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco")
			$firstActiveDetailTable = "endereco";
?>
		<div class="tab-pane <?php echo $pessoa_add->DetailPages->pageStyle("endereco") ?>" id="tab_endereco"><!-- page* -->
<?php include_once "enderecogrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("documentos", explode(",", $pessoa->getCurrentDetailTable())) && $documentos->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "documentos")
			$firstActiveDetailTable = "documentos";
?>
		<div class="tab-pane <?php echo $pessoa_add->DetailPages->pageStyle("documentos") ?>" id="tab_documentos"><!-- page* -->
<?php include_once "documentosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$pessoa_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $pessoa_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pessoa_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$pessoa_add->showPageFooter();
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
$pessoa_add->terminate();
?>