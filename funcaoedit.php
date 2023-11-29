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
$funcao_edit = new funcao_edit();

// Run the page
$funcao_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$funcao_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var ffuncaoedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	ffuncaoedit = currentForm = new ew.Form("ffuncaoedit", "edit");

	// Validate form
	ffuncaoedit.validate = function() {
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
			<?php if ($funcao_edit->funcao->Required) { ?>
				elm = this.getElements("x" + infix + "_funcao");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $funcao_edit->funcao->caption(), $funcao_edit->funcao->RequiredErrorMessage)) ?>");
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
	ffuncaoedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	ffuncaoedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	loadjs.done("ffuncaoedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $funcao_edit->showPageHeader(); ?>
<?php
$funcao_edit->showMessage();
?>
<form name="ffuncaoedit" id="ffuncaoedit" class="<?php echo $funcao_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="funcao">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$funcao_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($funcao_edit->funcao->Visible) { // funcao ?>
	<div id="r_funcao" class="form-group row">
		<label id="elh_funcao_funcao" for="x_funcao" class="<?php echo $funcao_edit->LeftColumnClass ?>"><?php echo $funcao_edit->funcao->caption() ?><?php echo $funcao_edit->funcao->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $funcao_edit->RightColumnClass ?>"><div <?php echo $funcao_edit->funcao->cellAttributes() ?>>
<span id="el_funcao_funcao">
<input type="text" data-table="funcao" data-field="x_funcao" name="x_funcao" id="x_funcao" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($funcao_edit->funcao->getPlaceHolder()) ?>" value="<?php echo $funcao_edit->funcao->EditValue ?>"<?php echo $funcao_edit->funcao->editAttributes() ?>>
</span>
<?php echo $funcao_edit->funcao->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="funcao" data-field="x_idfuncao" name="x_idfuncao" id="x_idfuncao" value="<?php echo HtmlEncode($funcao_edit->idfuncao->CurrentValue) ?>">
<?php if (!$funcao_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $funcao_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $funcao_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$funcao_edit->showPageFooter();
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
$funcao_edit->terminate();
?>