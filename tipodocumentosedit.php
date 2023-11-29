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
$tipodocumentos_edit = new tipodocumentos_edit();

// Run the page
$tipodocumentos_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipodocumentos_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ftipodocumentosedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	ftipodocumentosedit = currentForm = new ew.Form("ftipodocumentosedit", "edit");

	// Validate form
	ftipodocumentosedit.validate = function() {
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
			<?php if ($tipodocumentos_edit->Tipo->Required) { ?>
				elm = this.getElements("x" + infix + "_Tipo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $tipodocumentos_edit->Tipo->caption(), $tipodocumentos_edit->Tipo->RequiredErrorMessage)) ?>");
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
	ftipodocumentosedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ftipodocumentosedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("ftipodocumentosedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $tipodocumentos_edit->showPageHeader(); ?>
<?php
$tipodocumentos_edit->showMessage();
?>
<form name="ftipodocumentosedit" id="ftipodocumentosedit" class="<?php echo $tipodocumentos_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipodocumentos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$tipodocumentos_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($tipodocumentos_edit->Tipo->Visible) { // Tipo ?>
	<div id="r_Tipo" class="form-group row">
		<label id="elh_tipodocumentos_Tipo" for="x_Tipo" class="<?php echo $tipodocumentos_edit->LeftColumnClass ?>"><?php echo $tipodocumentos_edit->Tipo->caption() ?><?php echo $tipodocumentos_edit->Tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $tipodocumentos_edit->RightColumnClass ?>"><div <?php echo $tipodocumentos_edit->Tipo->cellAttributes() ?>>
<span id="el_tipodocumentos_Tipo">
<input type="text" data-table="tipodocumentos" data-field="x_Tipo" name="x_Tipo" id="x_Tipo" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($tipodocumentos_edit->Tipo->getPlaceHolder()) ?>" value="<?php echo $tipodocumentos_edit->Tipo->EditValue ?>"<?php echo $tipodocumentos_edit->Tipo->editAttributes() ?>>
</span>
<?php echo $tipodocumentos_edit->Tipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="tipodocumentos" data-field="x_idtipodocumentos" name="x_idtipodocumentos" id="x_idtipodocumentos" value="<?php echo HtmlEncode($tipodocumentos_edit->idtipodocumentos->CurrentValue) ?>">
<?php if (!$tipodocumentos_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $tipodocumentos_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $tipodocumentos_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$tipodocumentos_edit->showPageFooter();
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
$tipodocumentos_edit->terminate();
?>