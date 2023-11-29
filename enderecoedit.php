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
$endereco_edit = new endereco_edit();

// Run the page
$endereco_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$endereco_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fenderecoedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fenderecoedit = currentForm = new ew.Form("fenderecoedit", "edit");

	// Validate form
	fenderecoedit.validate = function() {
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
			<?php if ($endereco_edit->CEP->Required) { ?>
				elm = this.getElements("x" + infix + "_CEP");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->CEP->caption(), $endereco_edit->CEP->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_edit->UF->Required) { ?>
				elm = this.getElements("x" + infix + "_UF");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->UF->caption(), $endereco_edit->UF->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_edit->Cidade->Required) { ?>
				elm = this.getElements("x" + infix + "_Cidade");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->Cidade->caption(), $endereco_edit->Cidade->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_edit->Bairro->Required) { ?>
				elm = this.getElements("x" + infix + "_Bairro");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->Bairro->caption(), $endereco_edit->Bairro->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_edit->Rua->Required) { ?>
				elm = this.getElements("x" + infix + "_Rua");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->Rua->caption(), $endereco_edit->Rua->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_edit->Numero->Required) { ?>
				elm = this.getElements("x" + infix + "_Numero");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->Numero->caption(), $endereco_edit->Numero->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_edit->Complemento->Required) { ?>
				elm = this.getElements("x" + infix + "_Complemento");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_edit->Complemento->caption(), $endereco_edit->Complemento->RequiredErrorMessage)) ?>");
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
	fenderecoedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fenderecoedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fenderecoedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $endereco_edit->showPageHeader(); ?>
<?php
$endereco_edit->showMessage();
?>
<?php if (!$endereco_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $endereco_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fenderecoedit" id="fenderecoedit" class="<?php echo $endereco_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="endereco">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$endereco_edit->IsModal ?>">
<?php if ($endereco->getCurrentMasterTable() == "academia") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="academia">
<input type="hidden" name="fk_idacademia" value="<?php echo HtmlEncode($endereco_edit->idacademia->getSessionValue()) ?>">
<?php } ?>
<?php if ($endereco->getCurrentMasterTable() == "pessoa") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="pessoa">
<input type="hidden" name="fk_idpessoa" value="<?php echo HtmlEncode($endereco_edit->idpessoa->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($endereco_edit->CEP->Visible) { // CEP ?>
	<div id="r_CEP" class="form-group row">
		<label id="elh_endereco_CEP" for="x_CEP" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->CEP->caption() ?><?php echo $endereco_edit->CEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->CEP->cellAttributes() ?>>
<span id="el_endereco_CEP">
<input type="text" data-table="endereco" data-field="x_CEP" name="x_CEP" id="x_CEP" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($endereco_edit->CEP->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->CEP->EditValue ?>"<?php echo $endereco_edit->CEP->editAttributes() ?>>
</span>
<?php echo $endereco_edit->CEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_edit->UF->Visible) { // UF ?>
	<div id="r_UF" class="form-group row">
		<label id="elh_endereco_UF" for="x_UF" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->UF->caption() ?><?php echo $endereco_edit->UF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->UF->cellAttributes() ?>>
<span id="el_endereco_UF">
<input type="text" data-table="endereco" data-field="x_UF" name="x_UF" id="x_UF" size="30" maxlength="95" placeholder="<?php echo HtmlEncode($endereco_edit->UF->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->UF->EditValue ?>"<?php echo $endereco_edit->UF->editAttributes() ?>>
</span>
<?php echo $endereco_edit->UF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_edit->Cidade->Visible) { // Cidade ?>
	<div id="r_Cidade" class="form-group row">
		<label id="elh_endereco_Cidade" for="x_Cidade" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->Cidade->caption() ?><?php echo $endereco_edit->Cidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->Cidade->cellAttributes() ?>>
<span id="el_endereco_Cidade">
<input type="text" data-table="endereco" data-field="x_Cidade" name="x_Cidade" id="x_Cidade" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_edit->Cidade->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->Cidade->EditValue ?>"<?php echo $endereco_edit->Cidade->editAttributes() ?>>
</span>
<?php echo $endereco_edit->Cidade->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_edit->Bairro->Visible) { // Bairro ?>
	<div id="r_Bairro" class="form-group row">
		<label id="elh_endereco_Bairro" for="x_Bairro" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->Bairro->caption() ?><?php echo $endereco_edit->Bairro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->Bairro->cellAttributes() ?>>
<span id="el_endereco_Bairro">
<input type="text" data-table="endereco" data-field="x_Bairro" name="x_Bairro" id="x_Bairro" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_edit->Bairro->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->Bairro->EditValue ?>"<?php echo $endereco_edit->Bairro->editAttributes() ?>>
</span>
<?php echo $endereco_edit->Bairro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_edit->Rua->Visible) { // Rua ?>
	<div id="r_Rua" class="form-group row">
		<label id="elh_endereco_Rua" for="x_Rua" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->Rua->caption() ?><?php echo $endereco_edit->Rua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->Rua->cellAttributes() ?>>
<span id="el_endereco_Rua">
<input type="text" data-table="endereco" data-field="x_Rua" name="x_Rua" id="x_Rua" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_edit->Rua->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->Rua->EditValue ?>"<?php echo $endereco_edit->Rua->editAttributes() ?>>
</span>
<?php echo $endereco_edit->Rua->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_edit->Numero->Visible) { // Numero ?>
	<div id="r_Numero" class="form-group row">
		<label id="elh_endereco_Numero" for="x_Numero" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->Numero->caption() ?><?php echo $endereco_edit->Numero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->Numero->cellAttributes() ?>>
<span id="el_endereco_Numero">
<input type="text" data-table="endereco" data-field="x_Numero" name="x_Numero" id="x_Numero" size="30" maxlength="25" placeholder="<?php echo HtmlEncode($endereco_edit->Numero->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->Numero->EditValue ?>"<?php echo $endereco_edit->Numero->editAttributes() ?>>
</span>
<?php echo $endereco_edit->Numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_edit->Complemento->Visible) { // Complemento ?>
	<div id="r_Complemento" class="form-group row">
		<label id="elh_endereco_Complemento" for="x_Complemento" class="<?php echo $endereco_edit->LeftColumnClass ?>"><?php echo $endereco_edit->Complemento->caption() ?><?php echo $endereco_edit->Complemento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_edit->RightColumnClass ?>"><div <?php echo $endereco_edit->Complemento->cellAttributes() ?>>
<span id="el_endereco_Complemento">
<input type="text" data-table="endereco" data-field="x_Complemento" name="x_Complemento" id="x_Complemento" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($endereco_edit->Complemento->getPlaceHolder()) ?>" value="<?php echo $endereco_edit->Complemento->EditValue ?>"<?php echo $endereco_edit->Complemento->editAttributes() ?>>
</span>
<?php echo $endereco_edit->Complemento->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="endereco" data-field="x_idendereco" name="x_idendereco" id="x_idendereco" value="<?php echo HtmlEncode($endereco_edit->idendereco->CurrentValue) ?>">
<?php if (!$endereco_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $endereco_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $endereco_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$endereco_edit->IsModal) { ?>
<?php echo $endereco_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$endereco_edit->showPageFooter();
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
$endereco_edit->terminate();
?>