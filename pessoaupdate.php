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
$pessoa_update = new pessoa_update();

// Run the page
$pessoa_update->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pessoa_update->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fpessoaupdate, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "update";
	fpessoaupdate = currentForm = new ew.Form("fpessoaupdate", "update");

	// Validate form
	fpessoaupdate.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "confirm")
			return true;
		if (!ew.updateSelected(fobj)) {
			ew.alert(ew.language.phrase("NoFieldSelected"));
			return false;
		}
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			<?php if ($pessoa_update->idaula->Required) { ?>
				elm = this.getElements("x" + infix + "_idaula");
				uelm = this.getElements("u" + infix + "_idaula");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->idaula->caption(), $pessoa_update->idaula->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
				elm = this.getElements("x" + infix + "_idaula");
				uelm = this.getElements("u" + infix + "_idaula");
				if (uelm && uelm.checked && elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_update->idaula->errorMessage()) ?>");
			<?php if ($pessoa_update->Nome->Required) { ?>
				elm = this.getElements("x" + infix + "_Nome");
				uelm = this.getElements("u" + infix + "_Nome");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Nome->caption(), $pessoa_update->Nome->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->CPF->Required) { ?>
				elm = this.getElements("x" + infix + "_CPF");
				uelm = this.getElements("u" + infix + "_CPF");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->CPF->caption(), $pessoa_update->CPF->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->Senha->Required) { ?>
				elm = this.getElements("x" + infix + "_Senha");
				uelm = this.getElements("u" + infix + "_Senha");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Senha->caption(), $pessoa_update->Senha->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
				elm = this.getElements("x" + infix + "_Senha");
				uelm = this.getElements("u" + infix + "_Senha");
				if ($.isArray(uelm) && uelm[0] && uelm[0].checked && elm && $(elm).hasClass("ew-password-strength") && !$(elm).data("validated"))
					return this.onError(elm, ew.language.phrase("PasswordTooSimple"));
			<?php if ($pessoa_update->Sexo->Required) { ?>
				elm = this.getElements("x" + infix + "_Sexo");
				uelm = this.getElements("u" + infix + "_Sexo");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Sexo->caption(), $pessoa_update->Sexo->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->datanascimento->Required) { ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				uelm = this.getElements("u" + infix + "_datanascimento");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->datanascimento->caption(), $pessoa_update->datanascimento->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				uelm = this.getElements("u" + infix + "_datanascimento");
				if (uelm && uelm.checked && elm && !ew.checkEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_update->datanascimento->errorMessage()) ?>");
			<?php if ($pessoa_update->Funcao->Required) { ?>
				elm = this.getElements("x" + infix + "_Funcao");
				uelm = this.getElements("u" + infix + "_Funcao");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Funcao->caption(), $pessoa_update->Funcao->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->Sessao->Required) { ?>
				elm = this.getElements("x" + infix + "_Sessao");
				uelm = this.getElements("u" + infix + "_Sessao");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Sessao->caption(), $pessoa_update->Sessao->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->_Email->Required) { ?>
				elm = this.getElements("x" + infix + "__Email");
				uelm = this.getElements("u" + infix + "__Email");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->_Email->caption(), $pessoa_update->_Email->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
				elm = this.getElements("x" + infix + "__Email");
				uelm = this.getElements("u" + infix + "__Email");
				if (uelm && uelm.checked && elm && !ew.checkEmail(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_update->_Email->errorMessage()) ?>");
			<?php if ($pessoa_update->Ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_Ativado");
				uelm = this.getElements("u" + infix + "_Ativado");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Ativado->caption(), $pessoa_update->Ativado->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->datadecadastro->Required) { ?>
				elm = this.getElements("x" + infix + "_datadecadastro");
				uelm = this.getElements("u" + infix + "_datadecadastro");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->datadecadastro->caption(), $pessoa_update->datadecadastro->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
			<?php if ($pessoa_update->Idade->Required) { ?>
				elm = this.getElements("x" + infix + "_Idade");
				uelm = this.getElements("u" + infix + "_Idade");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $pessoa_update->Idade->caption(), $pessoa_update->Idade->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
				elm = this.getElements("x" + infix + "_Idade");
				uelm = this.getElements("u" + infix + "_Idade");
				if (uelm && uelm.checked && elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($pessoa_update->Idade->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fpessoaupdate.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fpessoaupdate.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fpessoaupdate.lists["x_idaula"] = <?php echo $pessoa_update->idaula->Lookup->toClientList($pessoa_update) ?>;
	fpessoaupdate.lists["x_idaula"].options = <?php echo JsonEncode($pessoa_update->idaula->lookupOptions()) ?>;
	fpessoaupdate.autoSuggests["x_idaula"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	fpessoaupdate.lists["x_Sexo"] = <?php echo $pessoa_update->Sexo->Lookup->toClientList($pessoa_update) ?>;
	fpessoaupdate.lists["x_Sexo"].options = <?php echo JsonEncode($pessoa_update->Sexo->options(FALSE, TRUE)) ?>;
	fpessoaupdate.lists["x_Funcao"] = <?php echo $pessoa_update->Funcao->Lookup->toClientList($pessoa_update) ?>;
	fpessoaupdate.lists["x_Funcao"].options = <?php echo JsonEncode($pessoa_update->Funcao->lookupOptions()) ?>;
	fpessoaupdate.lists["x_Ativado"] = <?php echo $pessoa_update->Ativado->Lookup->toClientList($pessoa_update) ?>;
	fpessoaupdate.lists["x_Ativado"].options = <?php echo JsonEncode($pessoa_update->Ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("fpessoaupdate");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $pessoa_update->showPageHeader(); ?>
<?php
$pessoa_update->showMessage();
?>
<form name="fpessoaupdate" id="fpessoaupdate" class="<?php echo $pessoa_update->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pessoa">
<?php if ($pessoa->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo (int)$pessoa_update->IsModal ?>">
<?php foreach ($pessoa_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_pessoaupdate" class="ew-update-div"><!-- page -->
	<div class="custom-control custom-checkbox">
		<input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"<?php echo $pessoa_update->Disabled ?>><label class="custom-control-label" for="u"><?php echo $Language->phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($pessoa_update->idaula->Visible) { // idaula ?>
	<div id="r_idaula" class="form-group row">
		<label class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_idaula" id="u_idaula" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->idaula->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_idaula" id="u_idaula" value="<?php echo $pessoa_update->idaula->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->idaula->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_idaula"><?php echo $pessoa_update->idaula->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->idaula->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_idaula">
<?php
$onchange = $pessoa_update->idaula->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$pessoa_update->idaula->EditAttrs["onchange"] = "";
?>
<span id="as_x_idaula">
	<input type="text" class="form-control" name="sv_x_idaula" id="sv_x_idaula" value="<?php echo RemoveHtml($pessoa_update->idaula->EditValue) ?>" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($pessoa_update->idaula->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($pessoa_update->idaula->getPlaceHolder()) ?>"<?php echo $pessoa_update->idaula->editAttributes() ?>>
</span>
<input type="hidden" data-table="pessoa" data-field="x_idaula" data-value-separator="<?php echo $pessoa_update->idaula->displayValueSeparatorAttribute() ?>" name="x_idaula" id="x_idaula" value="<?php echo HtmlEncode($pessoa_update->idaula->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["fpessoaupdate"], function() {
	fpessoaupdate.createAutoSuggest({"id":"x_idaula","forceSelect":false});
});
</script>
<?php echo $pessoa_update->idaula->Lookup->getParamTag($pessoa_update, "p_x_idaula") ?>
</span>
<?php } else { ?>
<span id="el_pessoa_idaula">
<span<?php echo $pessoa_update->idaula->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->idaula->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_idaula" name="x_idaula" id="x_idaula" value="<?php echo HtmlEncode($pessoa_update->idaula->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->idaula->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Nome->Visible) { // Nome ?>
	<div id="r_Nome" class="form-group row">
		<label for="x_Nome" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Nome" id="u_Nome" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Nome->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Nome" id="u_Nome" value="<?php echo $pessoa_update->Nome->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Nome->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Nome"><?php echo $pessoa_update->Nome->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Nome->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Nome">
<input type="text" data-table="pessoa" data-field="x_Nome" name="x_Nome" id="x_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_update->Nome->getPlaceHolder()) ?>" value="<?php echo $pessoa_update->Nome->EditValue ?>"<?php echo $pessoa_update->Nome->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa_Nome">
<span<?php echo $pessoa_update->Nome->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Nome->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="x_Nome" id="x_Nome" value="<?php echo HtmlEncode($pessoa_update->Nome->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->CPF->Visible) { // CPF ?>
	<div id="r_CPF" class="form-group row">
		<label for="x_CPF" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_CPF" id="u_CPF" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->CPF->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_CPF" id="u_CPF" value="<?php echo $pessoa_update->CPF->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->CPF->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_CPF"><?php echo $pessoa_update->CPF->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->CPF->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_CPF">
<input type="text" data-table="pessoa" data-field="x_CPF" name="x_CPF" id="x_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_update->CPF->getPlaceHolder()) ?>" value="<?php echo $pessoa_update->CPF->EditValue ?>"<?php echo $pessoa_update->CPF->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa_CPF">
<span<?php echo $pessoa_update->CPF->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->CPF->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="x_CPF" id="x_CPF" value="<?php echo HtmlEncode($pessoa_update->CPF->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->CPF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Senha->Visible) { // Senha ?>
	<div id="r_Senha" class="form-group row">
		<label for="x_Senha" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Senha" id="u_Senha" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Senha->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Senha" id="u_Senha" value="<?php echo $pessoa_update->Senha->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Senha->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Senha"><?php echo $pessoa_update->Senha->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Senha->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Senha">
<div class="input-group" id="ig_Senha">
<input type="password" autocomplete="new-password" data-password-strength="pst_Senha" data-table="pessoa" data-field="x_Senha" name="x_Senha" id="x_Senha" value="<?php echo $pessoa_update->Senha->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_update->Senha->getPlaceHolder()) ?>"<?php echo $pessoa_update->Senha->editAttributes() ?>>
<div class="input-group-append">
	<button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button>
	<button type="button" class="btn btn-default ew-password-generator" title="<?php echo HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x_Senha" data-password-confirm="c_Senha" data-password-strength="pst_Senha"><?php echo $Language->phrase("GeneratePassword") ?></button>
</div>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst_Senha">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php } else { ?>
<span id="el_pessoa_Senha">
<span<?php echo $pessoa_update->Senha->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Senha->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="x_Senha" id="x_Senha" value="<?php echo HtmlEncode($pessoa_update->Senha->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Senha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Sexo->Visible) { // Sexo ?>
	<div id="r_Sexo" class="form-group row">
		<label class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Sexo" id="u_Sexo" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Sexo->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Sexo" id="u_Sexo" value="<?php echo $pessoa_update->Sexo->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Sexo->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Sexo"><?php echo $pessoa_update->Sexo->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Sexo->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Sexo">
<div id="tp_x_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-value-separator="<?php echo $pessoa_update->Sexo->displayValueSeparatorAttribute() ?>" name="x_Sexo" id="x_Sexo" value="{value}"<?php echo $pessoa_update->Sexo->editAttributes() ?>></div>
<div id="dsl_x_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_update->Sexo->radioButtonListHtml(FALSE, "x_Sexo") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_pessoa_Sexo">
<span<?php echo $pessoa_update->Sexo->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Sexo->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="x_Sexo" id="x_Sexo" value="<?php echo HtmlEncode($pessoa_update->Sexo->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->datanascimento->Visible) { // datanascimento ?>
	<div id="r_datanascimento" class="form-group row">
		<label for="x_datanascimento" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_datanascimento" id="u_datanascimento" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->datanascimento->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_datanascimento" id="u_datanascimento" value="<?php echo $pessoa_update->datanascimento->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->datanascimento->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_datanascimento"><?php echo $pessoa_update->datanascimento->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->datanascimento->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_datanascimento">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-format="7" name="x_datanascimento" id="x_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($pessoa_update->datanascimento->getPlaceHolder()) ?>" value="<?php echo $pessoa_update->datanascimento->EditValue ?>"<?php echo $pessoa_update->datanascimento->editAttributes() ?>>
<?php if (!$pessoa_update->datanascimento->ReadOnly && !$pessoa_update->datanascimento->Disabled && !isset($pessoa_update->datanascimento->EditAttrs["readonly"]) && !isset($pessoa_update->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpessoaupdate", "datetimepicker"], function() {
	ew.createDateTimePicker("fpessoaupdate", "x_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_pessoa_datanascimento">
<span<?php echo $pessoa_update->datanascimento->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->datanascimento->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="x_datanascimento" id="x_datanascimento" value="<?php echo HtmlEncode($pessoa_update->datanascimento->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->datanascimento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Funcao->Visible) { // Funcao ?>
	<div id="r_Funcao" class="form-group row">
		<label for="x_Funcao" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Funcao" id="u_Funcao" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Funcao->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Funcao" id="u_Funcao" value="<?php echo $pessoa_update->Funcao->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Funcao->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Funcao"><?php echo $pessoa_update->Funcao->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Funcao->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_pessoa_Funcao">
<input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Funcao->EditValue)) ?>">
</span>
<?php } else { ?>
<span id="el_pessoa_Funcao">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="pessoa" data-field="x_Funcao" data-value-separator="<?php echo $pessoa_update->Funcao->displayValueSeparatorAttribute() ?>" id="x_Funcao" name="x_Funcao"<?php echo $pessoa_update->Funcao->editAttributes() ?>>
			<?php echo $pessoa_update->Funcao->selectOptionListHtml("x_Funcao") ?>
		</select>
</div>
<?php echo $pessoa_update->Funcao->Lookup->getParamTag($pessoa_update, "p_x_Funcao") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_pessoa_Funcao">
<span<?php echo $pessoa_update->Funcao->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Funcao->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Funcao" name="x_Funcao" id="x_Funcao" value="<?php echo HtmlEncode($pessoa_update->Funcao->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Funcao->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Sessao->Visible) { // Sessao ?>
	<div id="r_Sessao" class="form-group row">
		<label for="x_Sessao" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Sessao" id="u_Sessao" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Sessao->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Sessao" id="u_Sessao" value="<?php echo $pessoa_update->Sessao->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Sessao->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Sessao"><?php echo $pessoa_update->Sessao->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Sessao->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Sessao">
<textarea data-table="pessoa" data-field="x_Sessao" name="x_Sessao" id="x_Sessao" cols="35" rows="4" placeholder="<?php echo HtmlEncode($pessoa_update->Sessao->getPlaceHolder()) ?>"<?php echo $pessoa_update->Sessao->editAttributes() ?>><?php echo $pessoa_update->Sessao->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_pessoa_Sessao">
<span<?php echo $pessoa_update->Sessao->viewAttributes() ?>><?php echo $pessoa_update->Sessao->ViewValue ?></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Sessao" name="x_Sessao" id="x_Sessao" value="<?php echo HtmlEncode($pessoa_update->Sessao->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Sessao->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group row">
		<label for="x__Email" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u__Email" id="u__Email" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->_Email->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u__Email" id="u__Email" value="<?php echo $pessoa_update->_Email->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->_Email->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u__Email"><?php echo $pessoa_update->_Email->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->_Email->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa__Email">
<input type="text" data-table="pessoa" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($pessoa_update->_Email->getPlaceHolder()) ?>" value="<?php echo $pessoa_update->_Email->EditValue ?>"<?php echo $pessoa_update->_Email->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa__Email">
<span<?php echo $pessoa_update->_Email->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->_Email->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="x__Email" id="x__Email" value="<?php echo HtmlEncode($pessoa_update->_Email->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Ativado->Visible) { // Ativado ?>
	<div id="r_Ativado" class="form-group row">
		<label class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Ativado" id="u_Ativado" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Ativado->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Ativado" id="u_Ativado" value="<?php echo $pessoa_update->Ativado->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Ativado->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Ativado"><?php echo $pessoa_update->Ativado->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Ativado->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Ativado">
<div id="tp_x_Ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Ativado" data-value-separator="<?php echo $pessoa_update->Ativado->displayValueSeparatorAttribute() ?>" name="x_Ativado" id="x_Ativado" value="{value}"<?php echo $pessoa_update->Ativado->editAttributes() ?>></div>
<div id="dsl_x_Ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $pessoa_update->Ativado->radioButtonListHtml(FALSE, "x_Ativado") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_pessoa_Ativado">
<span<?php echo $pessoa_update->Ativado->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Ativado->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Ativado" name="x_Ativado" id="x_Ativado" value="<?php echo HtmlEncode($pessoa_update->Ativado->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Ativado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->datadecadastro->Visible) { // datadecadastro ?>
	<div id="r_datadecadastro" class="form-group row">
		<label for="x_datadecadastro" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_datadecadastro" id="u_datadecadastro" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->datadecadastro->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_datadecadastro" id="u_datadecadastro" value="<?php echo $pessoa_update->datadecadastro->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->datadecadastro->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_datadecadastro"><?php echo $pessoa_update->datadecadastro->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->datadecadastro->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<?php } else { ?>
<span id="el_pessoa_datadecadastro">
<span<?php echo $pessoa_update->datadecadastro->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->datadecadastro->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_datadecadastro" name="x_datadecadastro" id="x_datadecadastro" value="<?php echo HtmlEncode($pessoa_update->datadecadastro->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->datadecadastro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pessoa_update->Idade->Visible) { // Idade ?>
	<div id="r_Idade" class="form-group row">
		<label for="x_Idade" class="<?php echo $pessoa_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<?php if (!$pessoa->isConfirm()) { ?>
<input type="checkbox" name="u_Idade" id="u_Idade" class="custom-control-input ew-multi-select" value="1"<?php echo $pessoa_update->Idade->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } else { ?>
<input type="hidden" name="u_Idade" id="u_Idade" value="<?php echo $pessoa_update->Idade->MultiUpdate ?>">
<input type="checkbox" class="custom-control-input" disabled<?php echo $pessoa_update->Idade->MultiUpdate == "1" ? " checked" : "" ?>>
<?php } ?>
<label class="custom-control-label" for="u_Idade"><?php echo $pessoa_update->Idade->caption() ?></label></div></label>
		<div class="<?php echo $pessoa_update->RightColumnClass ?>"><div <?php echo $pessoa_update->Idade->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Idade">
<input type="text" data-table="pessoa" data-field="x_Idade" name="x_Idade" id="x_Idade" size="30" maxlength="5" placeholder="<?php echo HtmlEncode($pessoa_update->Idade->getPlaceHolder()) ?>" value="<?php echo $pessoa_update->Idade->EditValue ?>"<?php echo $pessoa_update->Idade->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa_Idade">
<span<?php echo $pessoa_update->Idade->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($pessoa_update->Idade->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Idade" name="x_Idade" id="x_Idade" value="<?php echo HtmlEncode($pessoa_update->Idade->FormValue) ?>">
<?php } ?>
<?php echo $pessoa_update->Idade->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page -->
<?php if (!$pessoa_update->IsModal) { ?>
	<div class="form-group row"><!-- buttons .form-group -->
		<div class="<?php echo $pessoa_update->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$pessoa->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?php echo $Language->phrase("UpdateBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $pessoa_update->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
		</div><!-- /buttons offset -->
	</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$pessoa_update->showPageFooter();
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
$pessoa_update->terminate();
?>