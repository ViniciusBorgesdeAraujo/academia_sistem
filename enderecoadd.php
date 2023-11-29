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
$endereco_add = new endereco_add();

// Run the page
$endereco_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$endereco_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fenderecoadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fenderecoadd = currentForm = new ew.Form("fenderecoadd", "add");

	// Validate form
	fenderecoadd.validate = function() {
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
			<?php if ($endereco_add->CEP->Required) { ?>
				elm = this.getElements("x" + infix + "_CEP");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->CEP->caption(), $endereco_add->CEP->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_add->UF->Required) { ?>
				elm = this.getElements("x" + infix + "_UF");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->UF->caption(), $endereco_add->UF->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_add->Cidade->Required) { ?>
				elm = this.getElements("x" + infix + "_Cidade");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->Cidade->caption(), $endereco_add->Cidade->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_add->Bairro->Required) { ?>
				elm = this.getElements("x" + infix + "_Bairro");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->Bairro->caption(), $endereco_add->Bairro->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_add->Rua->Required) { ?>
				elm = this.getElements("x" + infix + "_Rua");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->Rua->caption(), $endereco_add->Rua->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_add->Numero->Required) { ?>
				elm = this.getElements("x" + infix + "_Numero");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->Numero->caption(), $endereco_add->Numero->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($endereco_add->Complemento->Required) { ?>
				elm = this.getElements("x" + infix + "_Complemento");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $endereco_add->Complemento->caption(), $endereco_add->Complemento->RequiredErrorMessage)) ?>");
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
	fenderecoadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fenderecoadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("fenderecoadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $endereco_add->showPageHeader(); ?>
<?php
$endereco_add->showMessage();
?>
<form name="fenderecoadd" id="fenderecoadd" class="<?php echo $endereco_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="endereco">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$endereco_add->IsModal ?>">
<?php if ($endereco->getCurrentMasterTable() == "academia") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="academia">
<input type="hidden" name="fk_idacademia" value="<?php echo HtmlEncode($endereco_add->idacademia->getSessionValue()) ?>">
<?php } ?>
<?php if ($endereco->getCurrentMasterTable() == "pessoa") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="pessoa">
<input type="hidden" name="fk_idpessoa" value="<?php echo HtmlEncode($endereco_add->idpessoa->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($endereco_add->CEP->Visible) { // CEP ?>
	<div id="r_CEP" class="form-group row">
		<label id="elh_endereco_CEP" for="x_CEP" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->CEP->caption() ?><?php echo $endereco_add->CEP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->CEP->cellAttributes() ?>>
<span id="el_endereco_CEP">
<input type="text" data-table="endereco" data-field="x_CEP" name="x_CEP" id="x_CEP" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($endereco_add->CEP->getPlaceHolder()) ?>" value="<?php echo $endereco_add->CEP->EditValue ?>"<?php echo $endereco_add->CEP->editAttributes() ?>>
</span>
<?php echo $endereco_add->CEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_add->UF->Visible) { // UF ?>
	<div id="r_UF" class="form-group row">
		<label id="elh_endereco_UF" for="x_UF" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->UF->caption() ?><?php echo $endereco_add->UF->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->UF->cellAttributes() ?>>
<span id="el_endereco_UF">
<input type="text" data-table="endereco" data-field="x_UF" name="x_UF" id="x_UF" size="30" maxlength="95" placeholder="<?php echo HtmlEncode($endereco_add->UF->getPlaceHolder()) ?>" value="<?php echo $endereco_add->UF->EditValue ?>"<?php echo $endereco_add->UF->editAttributes() ?>>
</span>
<?php echo $endereco_add->UF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_add->Cidade->Visible) { // Cidade ?>
	<div id="r_Cidade" class="form-group row">
		<label id="elh_endereco_Cidade" for="x_Cidade" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->Cidade->caption() ?><?php echo $endereco_add->Cidade->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->Cidade->cellAttributes() ?>>
<span id="el_endereco_Cidade">
<input type="text" data-table="endereco" data-field="x_Cidade" name="x_Cidade" id="x_Cidade" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_add->Cidade->getPlaceHolder()) ?>" value="<?php echo $endereco_add->Cidade->EditValue ?>"<?php echo $endereco_add->Cidade->editAttributes() ?>>
</span>
<?php echo $endereco_add->Cidade->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_add->Bairro->Visible) { // Bairro ?>
	<div id="r_Bairro" class="form-group row">
		<label id="elh_endereco_Bairro" for="x_Bairro" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->Bairro->caption() ?><?php echo $endereco_add->Bairro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->Bairro->cellAttributes() ?>>
<span id="el_endereco_Bairro">
<input type="text" data-table="endereco" data-field="x_Bairro" name="x_Bairro" id="x_Bairro" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_add->Bairro->getPlaceHolder()) ?>" value="<?php echo $endereco_add->Bairro->EditValue ?>"<?php echo $endereco_add->Bairro->editAttributes() ?>>
</span>
<?php echo $endereco_add->Bairro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_add->Rua->Visible) { // Rua ?>
	<div id="r_Rua" class="form-group row">
		<label id="elh_endereco_Rua" for="x_Rua" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->Rua->caption() ?><?php echo $endereco_add->Rua->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->Rua->cellAttributes() ?>>
<span id="el_endereco_Rua">
<input type="text" data-table="endereco" data-field="x_Rua" name="x_Rua" id="x_Rua" size="30" maxlength="85" placeholder="<?php echo HtmlEncode($endereco_add->Rua->getPlaceHolder()) ?>" value="<?php echo $endereco_add->Rua->EditValue ?>"<?php echo $endereco_add->Rua->editAttributes() ?>>
</span>
<?php echo $endereco_add->Rua->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_add->Numero->Visible) { // Numero ?>
	<div id="r_Numero" class="form-group row">
		<label id="elh_endereco_Numero" for="x_Numero" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->Numero->caption() ?><?php echo $endereco_add->Numero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->Numero->cellAttributes() ?>>
<span id="el_endereco_Numero">
<input type="text" data-table="endereco" data-field="x_Numero" name="x_Numero" id="x_Numero" size="30" maxlength="25" placeholder="<?php echo HtmlEncode($endereco_add->Numero->getPlaceHolder()) ?>" value="<?php echo $endereco_add->Numero->EditValue ?>"<?php echo $endereco_add->Numero->editAttributes() ?>>
</span>
<?php echo $endereco_add->Numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($endereco_add->Complemento->Visible) { // Complemento ?>
	<div id="r_Complemento" class="form-group row">
		<label id="elh_endereco_Complemento" for="x_Complemento" class="<?php echo $endereco_add->LeftColumnClass ?>"><?php echo $endereco_add->Complemento->caption() ?><?php echo $endereco_add->Complemento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $endereco_add->RightColumnClass ?>"><div <?php echo $endereco_add->Complemento->cellAttributes() ?>>
<span id="el_endereco_Complemento">
<input type="text" data-table="endereco" data-field="x_Complemento" name="x_Complemento" id="x_Complemento" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($endereco_add->Complemento->getPlaceHolder()) ?>" value="<?php echo $endereco_add->Complemento->EditValue ?>"<?php echo $endereco_add->Complemento->editAttributes() ?>>
</span>
<?php echo $endereco_add->Complemento->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<?php if (strval($endereco_add->idacademia->getSessionValue()) != "") { ?>
	<input type="hidden" name="x_idacademia" id="x_idacademia" value="<?php echo HtmlEncode(strval($endereco_add->idacademia->getSessionValue())) ?>">
	<?php } ?>
	<?php if (strval($endereco_add->idpessoa->getSessionValue()) != "") { ?>
	<input type="hidden" name="x_idpessoa" id="x_idpessoa" value="<?php echo HtmlEncode(strval($endereco_add->idpessoa->getSessionValue())) ?>">
	<?php } ?>
<?php if (!$endereco_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $endereco_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $endereco_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$endereco_add->showPageFooter();
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
$endereco_add->terminate();
?>