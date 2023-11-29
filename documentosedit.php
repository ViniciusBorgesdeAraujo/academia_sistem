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
$documentos_edit = new documentos_edit();

// Run the page
$documentos_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documentos_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fdocumentosedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fdocumentosedit = currentForm = new ew.Form("fdocumentosedit", "edit");

	// Validate form
	fdocumentosedit.validate = function() {
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
			<?php if ($documentos_edit->idpessoa->Required) { ?>
				elm = this.getElements("x" + infix + "_idpessoa");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_edit->idpessoa->caption(), $documentos_edit->idpessoa->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($documentos_edit->tipo->Required) { ?>
				elm = this.getElements("x" + infix + "_tipo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_edit->tipo->caption(), $documentos_edit->tipo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($documentos_edit->numero->Required) { ?>
				elm = this.getElements("x" + infix + "_numero");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $documentos_edit->numero->caption(), $documentos_edit->numero->RequiredErrorMessage)) ?>");
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
	fdocumentosedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fdocumentosedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fdocumentosedit.lists["x_idpessoa"] = <?php echo $documentos_edit->idpessoa->Lookup->toClientList($documentos_edit) ?>;
	fdocumentosedit.lists["x_idpessoa"].options = <?php echo JsonEncode($documentos_edit->idpessoa->lookupOptions()) ?>;
	fdocumentosedit.lists["x_tipo"] = <?php echo $documentos_edit->tipo->Lookup->toClientList($documentos_edit) ?>;
	fdocumentosedit.lists["x_tipo"].options = <?php echo JsonEncode($documentos_edit->tipo->lookupOptions()) ?>;
	loadjs.done("fdocumentosedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $documentos_edit->showPageHeader(); ?>
<?php
$documentos_edit->showMessage();
?>
<?php if (!$documentos_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $documentos_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fdocumentosedit" id="fdocumentosedit" class="<?php echo $documentos_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documentos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$documentos_edit->IsModal ?>">
<?php if ($documentos->getCurrentMasterTable() == "pessoa") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="pessoa">
<input type="hidden" name="fk_idpessoa" value="<?php echo HtmlEncode($documentos_edit->idpessoa->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($documentos_edit->idpessoa->Visible) { // idpessoa ?>
	<div id="r_idpessoa" class="form-group row">
		<label id="elh_documentos_idpessoa" for="x_idpessoa" class="<?php echo $documentos_edit->LeftColumnClass ?>"><?php echo $documentos_edit->idpessoa->caption() ?><?php echo $documentos_edit->idpessoa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $documentos_edit->RightColumnClass ?>"><div <?php echo $documentos_edit->idpessoa->cellAttributes() ?>>
<?php if ($documentos_edit->idpessoa->getSessionValue() != "") { ?>
<span id="el_documentos_idpessoa">
<span<?php echo $documentos_edit->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_edit->idpessoa->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idpessoa" name="x_idpessoa" value="<?php echo HtmlEncode($documentos_edit->idpessoa->CurrentValue) ?>">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$documentos->userIDAllow("edit")) { // Non system admin ?>
<span id="el_documentos_idpessoa">
<span<?php echo $documentos_edit->idpessoa->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($documentos_edit->idpessoa->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="documentos" data-field="x_idpessoa" name="x_idpessoa" id="x_idpessoa" value="<?php echo HtmlEncode($documentos_edit->idpessoa->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documentos_idpessoa">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_idpessoa" data-value-separator="<?php echo $documentos_edit->idpessoa->displayValueSeparatorAttribute() ?>" id="x_idpessoa" name="x_idpessoa"<?php echo $documentos_edit->idpessoa->editAttributes() ?>>
			<?php echo $documentos_edit->idpessoa->selectOptionListHtml("x_idpessoa") ?>
		</select>
</div>
<?php echo $documentos_edit->idpessoa->Lookup->getParamTag($documentos_edit, "p_x_idpessoa") ?>
</span>
<?php } ?>
<?php echo $documentos_edit->idpessoa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documentos_edit->tipo->Visible) { // tipo ?>
	<div id="r_tipo" class="form-group row">
		<label id="elh_documentos_tipo" for="x_tipo" class="<?php echo $documentos_edit->LeftColumnClass ?>"><?php echo $documentos_edit->tipo->caption() ?><?php echo $documentos_edit->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $documentos_edit->RightColumnClass ?>"><div <?php echo $documentos_edit->tipo->cellAttributes() ?>>
<span id="el_documentos_tipo">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="documentos" data-field="x_tipo" data-value-separator="<?php echo $documentos_edit->tipo->displayValueSeparatorAttribute() ?>" id="x_tipo" name="x_tipo"<?php echo $documentos_edit->tipo->editAttributes() ?>>
			<?php echo $documentos_edit->tipo->selectOptionListHtml("x_tipo") ?>
		</select>
</div>
<?php echo $documentos_edit->tipo->Lookup->getParamTag($documentos_edit, "p_x_tipo") ?>
</span>
<?php echo $documentos_edit->tipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documentos_edit->numero->Visible) { // numero ?>
	<div id="r_numero" class="form-group row">
		<label id="elh_documentos_numero" for="x_numero" class="<?php echo $documentos_edit->LeftColumnClass ?>"><?php echo $documentos_edit->numero->caption() ?><?php echo $documentos_edit->numero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $documentos_edit->RightColumnClass ?>"><div <?php echo $documentos_edit->numero->cellAttributes() ?>>
<span id="el_documentos_numero">
<input type="text" data-table="documentos" data-field="x_numero" name="x_numero" id="x_numero" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($documentos_edit->numero->getPlaceHolder()) ?>" value="<?php echo $documentos_edit->numero->EditValue ?>"<?php echo $documentos_edit->numero->editAttributes() ?>>
</span>
<?php echo $documentos_edit->numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="documentos" data-field="x_iddocumentos" name="x_iddocumentos" id="x_iddocumentos" value="<?php echo HtmlEncode($documentos_edit->iddocumentos->CurrentValue) ?>">
<?php if (!$documentos_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $documentos_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $documentos_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$documentos_edit->IsModal) { ?>
<?php echo $documentos_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$documentos_edit->showPageFooter();
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
$documentos_edit->terminate();
?>