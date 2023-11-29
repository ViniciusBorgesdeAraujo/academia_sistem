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
$documentos_add = new documentos_add();

// Run the page
$documentos_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documentos_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdocumentosadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fdocumentosadd = currentForm = new ew.Form("fdocumentosadd", "add");

	// Validate form
	fdocumentosadd.validate = function() {
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
			<?php if ($documentos_add->idpessoa->Required) { ?>
				elm = this.getElements("x" + infix + "_idpessoa");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_add->idpessoa->caption(), $documentos_add->idpessoa->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($documentos_add->tipo->Required) { ?>
				elm = this.getElements("x" + infix + "_tipo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_add->tipo->caption(), $documentos_add->tipo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($documentos_add->numero->Required) { ?>
				elm = this.getElements("x" + infix + "_numero");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_add->numero->caption(), $documentos_add->numero->RequiredErrorMessage)) ?>");
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
	fdocumentosadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdocumentosadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdocumentosadd.lists["x_idpessoa"] = <?php echo $documentos_add->idpessoa->Lookup->toClientList($documentos_add) ?>;
	fdocumentosadd.lists["x_idpessoa"].options = <?php echo JsonEncode($documentos_add->idpessoa->lookupOptions()) ?>;
	fdocumentosadd.lists["x_tipo"] = <?php echo $documentos_add->tipo->Lookup->toClientList($documentos_add) ?>;
	fdocumentosadd.lists["x_tipo"].options = <?php echo JsonEncode($documentos_add->tipo->lookupOptions()) ?>;
	loadjs.done("fdocumentosadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $documentos_add->showPageHeader(); ?>
<?php
$documentos_add->showMessage();
?>
<form name="fdocumentosadd" id="fdocumentosadd" class="<?php echo $documentos_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documentos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$documentos_add->IsModal ?>">
<?php if ($documentos->getCurrentMasterTable() == "pessoa") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="pessoa">
<input type="hidden" name="fk_idpessoa" value="<?php echo HtmlEncode($documentos_add->idpessoa->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($documentos_add->idpessoa->Visible) { // idpessoa ?>
	<div id="r_idpessoa" class="form-group row">
		<label id="elh_documentos_idpessoa" for="x_idpessoa" class="<?php echo $documentos_add->LeftColumnClass ?>"><?php echo $documentos_add->idpessoa->caption() ?><?php echo $documentos_add->idpessoa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $documentos_add->RightColumnClass ?>"><div <?php echo $documentos_add->idpessoa->cellAttributes() ?>>
<?php if ($documentos_add->idpessoa->getSessionValue() != "") { ?>
<span id="el_documentos_idpessoa">
<span<?php echo $documentos_add->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_add->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idpessoa" name="x_idpessoa" value="<?php echo HtmlEncode($documentos_add->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$documentos->userIDAllow("add")) { // Non system admin ?>
<span id="el_documentos_idpessoa">
<span<?php echo $documentos_add->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_add->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x_idpessoa" id="x_idpessoa" value="<?php echo HtmlEncode($documentos_add->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documentos_idpessoa">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_idpessoa" data-value-separator="<?php echo $documentos_add->idpessoa->displayValueSeparatorAttribute() ?>" id="x_idpessoa" name="x_idpessoa"<?php echo $documentos_add->idpessoa->editAttributes() ?>>
			<?php echo $documentos_add->idpessoa->selectOptionListHtml("x_idpessoa") ?>
		</select>
</div>
<?php echo $documentos_add->idpessoa->Lookup->getParamTag($documentos_add, "p_x_idpessoa") ?>
</span>
<?php } ?>
<?php echo $documentos_add->idpessoa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documentos_add->tipo->Visible) { // tipo ?>
	<div id="r_tipo" class="form-group row">
		<label id="elh_documentos_tipo" for="x_tipo" class="<?php echo $documentos_add->LeftColumnClass ?>"><?php echo $documentos_add->tipo->caption() ?><?php echo $documentos_add->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $documentos_add->RightColumnClass ?>"><div <?php echo $documentos_add->tipo->cellAttributes() ?>>
<span id="el_documentos_tipo">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_tipo" data-value-separator="<?php echo $documentos_add->tipo->displayValueSeparatorAttribute() ?>" id="x_tipo" name="x_tipo"<?php echo $documentos_add->tipo->editAttributes() ?>>
			<?php echo $documentos_add->tipo->selectOptionListHtml("x_tipo") ?>
		</select>
</div>
<?php echo $documentos_add->tipo->Lookup->getParamTag($documentos_add, "p_x_tipo") ?>
</span>
<?php echo $documentos_add->tipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documentos_add->numero->Visible) { // numero ?>
	<div id="r_numero" class="form-group row">
		<label id="elh_documentos_numero" for="x_numero" class="<?php echo $documentos_add->LeftColumnClass ?>"><?php echo $documentos_add->numero->caption() ?><?php echo $documentos_add->numero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $documentos_add->RightColumnClass ?>"><div <?php echo $documentos_add->numero->cellAttributes() ?>>
<span id="el_documentos_numero">
<input type="text" data-table="documentos" data-field="x_numero" name="x_numero" id="x_numero" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($documentos_add->numero->getPlaceHolder()) ?>" value="<?php echo $documentos_add->numero->EditValue ?>"<?php echo $documentos_add->numero->editAttributes() ?>>
</span>
<?php echo $documentos_add->numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$documentos_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $documentos_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $documentos_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$documentos_add->showPageFooter();
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
$documentos_add->terminate();
?>