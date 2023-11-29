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
$register = new register();

// Run the page
$register->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$register->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fregister, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "register";
	fregister = currentForm = new ew.Form("fregister", "register");

	// Validate form
	fregister.validate = function() {
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
			<?php if ($register->Nome->Required) { ?>
				elm = this.getElements("x" + infix + "_Nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, ew.language.phrase("EnterUserName"));
			<?php } ?>
			<?php if ($register->CPF->Required) { ?>
				elm = this.getElements("x" + infix + "_CPF");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $register->CPF->caption(), $register->CPF->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($register->Senha->Required) { ?>
				elm = this.getElements("x" + infix + "_Senha");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, ew.language.phrase("EnterPassword"));
			<?php } ?>
				elm = this.getElements("x" + infix + "_Senha");
				if (elm && $(elm).hasClass("ew-password-strength") && !$(elm).data("validated"))
					return this.onError(elm, ew.language.phrase("PasswordTooSimple"));
				if (fobj.c_Senha.value != fobj.x_Senha.value)
					return this.onError(fobj.c_Senha, ew.language.phrase("MismatchPassword"));
			<?php if ($register->Sexo->Required) { ?>
				elm = this.getElements("x" + infix + "_Sexo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $register->Sexo->caption(), $register->Sexo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($register->datanascimento->Required) { ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $register->datanascimento->caption(), $register->datanascimento->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "_datanascimento");
				if (elm && !ew.checkEuroDate(elm.value))
					return this.onError(elm, "<?php echo JsEncode($register->datanascimento->errorMessage()) ?>");
			<?php if ($register->_Email->Required) { ?>
				elm = this.getElements("x" + infix + "__Email");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $register->_Email->caption(), $register->_Email->RequiredErrorMessage)) ?>");
			<?php } ?>
				elm = this.getElements("x" + infix + "__Email");
				if (elm && !ew.checkEmail(elm.value))
					return this.onError(elm, "<?php echo JsEncode($register->_Email->errorMessage()) ?>");

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fregister.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fregister.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fregister.lists["x_Sexo"] = <?php echo $register->Sexo->Lookup->toClientList($register) ?>;
	fregister.lists["x_Sexo"].options = <?php echo JsonEncode($register->Sexo->options(FALSE, TRUE)) ?>;
	loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $register->showPageHeader(); ?>
<?php
$register->showMessage();
?>
<form name="fregister" id="fregister" class="<?php echo $register->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo (int)$register->IsModal ?>">
<input type="hidden" name="t" value="pessoa">
<?php if ($pessoa->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<div class="ew-register-div"><!-- page* -->
<?php if ($register->Nome->Visible) { // Nome ?>
	<div id="r_Nome" class="form-group row">
		<label id="elh_pessoa_Nome" for="x_Nome" class="<?php echo $register->LeftColumnClass ?>"><?php echo $register->Nome->caption() ?><?php echo $register->Nome->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->Nome->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Nome">
<input type="text" data-table="pessoa" data-field="x_Nome" name="x_Nome" id="x_Nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($register->Nome->getPlaceHolder()) ?>" value="<?php echo $register->Nome->EditValue ?>"<?php echo $register->Nome->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa_Nome">
<span<?php echo $register->Nome->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->Nome->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Nome" name="x_Nome" id="x_Nome" value="<?php echo HtmlEncode($register->Nome->FormValue) ?>">
<?php } ?>
<?php echo $register->Nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($register->CPF->Visible) { // CPF ?>
	<div id="r_CPF" class="form-group row">
		<label id="elh_pessoa_CPF" for="x_CPF" class="<?php echo $register->LeftColumnClass ?>"><?php echo $register->CPF->caption() ?><?php echo $register->CPF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->CPF->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_CPF">
<input type="text" data-table="pessoa" data-field="x_CPF" name="x_CPF" id="x_CPF" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($register->CPF->getPlaceHolder()) ?>" value="<?php echo $register->CPF->EditValue ?>"<?php echo $register->CPF->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa_CPF">
<span<?php echo $register->CPF->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->CPF->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_CPF" name="x_CPF" id="x_CPF" value="<?php echo HtmlEncode($register->CPF->FormValue) ?>">
<?php } ?>
<?php echo $register->CPF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($register->Senha->Visible) { // Senha ?>
	<div id="r_Senha" class="form-group row">
		<label id="elh_pessoa_Senha" for="x_Senha" class="<?php echo $register->LeftColumnClass ?>"><?php echo $register->Senha->caption() ?><?php echo $register->Senha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->Senha->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Senha">
<div class="input-group" id="ig_Senha">
<input type="password" autocomplete="new-password" data-password-strength="pst_Senha" data-table="pessoa" data-field="x_Senha" name="x_Senha" id="x_Senha" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($register->Senha->getPlaceHolder()) ?>"<?php echo $register->Senha->editAttributes() ?>>
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
<span<?php echo $register->Senha->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->Senha->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="x_Senha" id="x_Senha" value="<?php echo HtmlEncode($register->Senha->FormValue) ?>">
<?php } ?>
<?php echo $register->Senha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($register->Senha->Visible) { // Senha ?>
	<div id="r_c_Senha" class="form-group row">
		<label id="elh_c_pessoa_Senha" for="c_Senha" class="<?php echo $register->LeftColumnClass ?>"><?php echo $Language->phrase("Confirm") ?> <?php echo $register->Senha->caption() ?><?php echo $register->Senha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->Senha->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_c_pessoa_Senha">
<div class="input-group"><input type="password" name="c_Senha" id="c_Senha" autocomplete="new-password" data-field="x_Senha" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($register->Senha->getPlaceHolder()) ?>"<?php echo $register->Senha->editAttributes() ?>><div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div></div>
</span>
<?php } else { ?>
<span id="el_c_pessoa_Senha">
<span<?php echo $register->Senha->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->Senha->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Senha" name="c_Senha" id="c_Senha" value="<?php echo HtmlEncode($register->Senha->FormValue) ?>">
<?php } ?>
</div></div>
	</div>
<?php } ?>
<?php if ($register->Sexo->Visible) { // Sexo ?>
	<div id="r_Sexo" class="form-group row">
		<label id="elh_pessoa_Sexo" class="<?php echo $register->LeftColumnClass ?>"><?php echo $register->Sexo->caption() ?><?php echo $register->Sexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->Sexo->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_Sexo">
<div id="tp_x_Sexo" class="ew-template"><input type="radio" class="custom-control-input" data-table="pessoa" data-field="x_Sexo" data-value-separator="<?php echo $register->Sexo->displayValueSeparatorAttribute() ?>" name="x_Sexo" id="x_Sexo" value="{value}"<?php echo $register->Sexo->editAttributes() ?>></div>
<div id="dsl_x_Sexo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $register->Sexo->radioButtonListHtml(FALSE, "x_Sexo") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_pessoa_Sexo">
<span<?php echo $register->Sexo->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->Sexo->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_Sexo" name="x_Sexo" id="x_Sexo" value="<?php echo HtmlEncode($register->Sexo->FormValue) ?>">
<?php } ?>
<?php echo $register->Sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($register->datanascimento->Visible) { // datanascimento ?>
	<div id="r_datanascimento" class="form-group row">
		<label id="elh_pessoa_datanascimento" for="x_datanascimento" class="<?php echo $register->LeftColumnClass ?>"><?php echo $register->datanascimento->caption() ?><?php echo $register->datanascimento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->datanascimento->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa_datanascimento">
<input type="text" data-table="pessoa" data-field="x_datanascimento" data-format="7" name="x_datanascimento" id="x_datanascimento" maxlength="10" placeholder="<?php echo HtmlEncode($register->datanascimento->getPlaceHolder()) ?>" value="<?php echo $register->datanascimento->EditValue ?>"<?php echo $register->datanascimento->editAttributes() ?>>
<?php if (!$register->datanascimento->ReadOnly && !$register->datanascimento->Disabled && !isset($register->datanascimento->EditAttrs["readonly"]) && !isset($register->datanascimento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fregister", "datetimepicker"], function() {
	ew.createDateTimePicker("fregister", "x_datanascimento", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_pessoa_datanascimento">
<span<?php echo $register->datanascimento->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->datanascimento->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x_datanascimento" name="x_datanascimento" id="x_datanascimento" value="<?php echo HtmlEncode($register->datanascimento->FormValue) ?>">
<?php } ?>
<?php echo $register->datanascimento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($register->_Email->Visible) { // Email ?>
	<div id="r__Email" class="form-group row">
		<label id="elh_pessoa__Email" for="x__Email" class="<?php echo $register->LeftColumnClass ?>"><?php echo $register->_Email->caption() ?><?php echo $register->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div <?php echo $register->_Email->cellAttributes() ?>>
<?php if (!$pessoa->isConfirm()) { ?>
<span id="el_pessoa__Email">
<input type="text" data-table="pessoa" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($register->_Email->getPlaceHolder()) ?>" value="<?php echo $register->_Email->EditValue ?>"<?php echo $register->_Email->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_pessoa__Email">
<span<?php echo $register->_Email->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($register->_Email->ViewValue)) ?>"></span>
</span>
<input type="hidden" data-table="pessoa" data-field="x__Email" name="x__Email" id="x__Email" value="<?php echo HtmlEncode($register->_Email->FormValue) ?>">
<?php } ?>
<?php echo $register->_Email->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$register->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $register->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$pessoa->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?php echo $Language->phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?php echo $Language->phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$register->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$register->terminate();
?>