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
$turnos_update = new turnos_update();

// Run the page
$turnos_update->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_update->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fturnosupdate, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "update";
	fturnosupdate = currentForm = new ew.Form("fturnosupdate", "update");

	// Validate form
	fturnosupdate.validate = function() {
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
			<?php if ($turnos_update->idacademia->Required) { ?>
				elm = this.getElements("x" + infix + "_idacademia");
				uelm = this.getElements("u" + infix + "_idacademia");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $turnos_update->idacademia->caption(), $turnos_update->idacademia->RequiredErrorMessage)) ?>");
				}
			<?php } ?>
				elm = this.getElements("x" + infix + "_idacademia");
				uelm = this.getElements("u" + infix + "_idacademia");
				if (uelm && uelm.checked && elm && !ew.checkInteger(elm.value))
					return this.onError(elm, "<?php echo JsEncode($turnos_update->idacademia->errorMessage()) ?>");
			<?php if ($turnos_update->turmas->Required) { ?>
				elm = this.getElements("x" + infix + "_turmas");
				uelm = this.getElements("u" + infix + "_turmas");
				if (uelm && uelm.checked) {
					if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
						return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $turnos_update->turmas->caption(), $turnos_update->turmas->RequiredErrorMessage)) ?>");
				}
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	fturnosupdate.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fturnosupdate.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fturnosupdate.lists["x_idacademia"] = <?php echo $turnos_update->idacademia->Lookup->toClientList($turnos_update) ?>;
	fturnosupdate.lists["x_idacademia"].options = <?php echo JsonEncode($turnos_update->idacademia->lookupOptions()) ?>;
	fturnosupdate.autoSuggests["x_idacademia"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	loadjs.done("fturnosupdate");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $turnos_update->showPageHeader(); ?>
<?php
$turnos_update->showMessage();
?>
<form name="fturnosupdate" id="fturnosupdate" class="<?php echo $turnos_update->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="turnos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$turnos_update->IsModal ?>">
<?php foreach ($turnos_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_turnosupdate" class="ew-update-div"><!-- page -->
	<div class="custom-control custom-checkbox">
		<input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"><label class="custom-control-label" for="u"><?php echo $Language->phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($turnos_update->idacademia->Visible) { // idacademia ?>
	<div id="r_idacademia" class="form-group row">
		<label class="<?php echo $turnos_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<input type="checkbox" name="u_idacademia" id="u_idacademia" class="custom-control-input ew-multi-select" value="1"<?php echo $turnos_update->idacademia->MultiUpdate == "1" ? " checked" : "" ?>>
<label class="custom-control-label" for="u_idacademia"><?php echo $turnos_update->idacademia->caption() ?></label></div></label>
		<div class="<?php echo $turnos_update->RightColumnClass ?>"><div <?php echo $turnos_update->idacademia->cellAttributes() ?>>
<?php if ($turnos_update->idacademia->getSessionValue() != "") { ?>
<span id="el_turnos_idacademia">
<span<?php echo $turnos_update->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_update->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idacademia" name="x_idacademia" value="<?php echo HtmlEncode($turnos_update->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el_turnos_idacademia">
<?php
$onchange = $turnos_update->idacademia->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$turnos_update->idacademia->EditAttrs["onchange"] = "";
?>
<span id="as_x_idacademia">
	<input type="text" class="form-control" name="sv_x_idacademia" id="sv_x_idacademia" value="<?php echo RemoveHtml($turnos_update->idacademia->EditValue) ?>" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($turnos_update->idacademia->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($turnos_update->idacademia->getPlaceHolder()) ?>"<?php echo $turnos_update->idacademia->editAttributes() ?>>
</span>
<input type="hidden" data-table="turnos" data-field="x_idacademia" data-value-separator="<?php echo $turnos_update->idacademia->displayValueSeparatorAttribute() ?>" name="x_idacademia" id="x_idacademia" value="<?php echo HtmlEncode($turnos_update->idacademia->CurrentValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["fturnosupdate"], function() {
	fturnosupdate.createAutoSuggest({"id":"x_idacademia","forceSelect":false});
});
</script>
<?php echo $turnos_update->idacademia->Lookup->getParamTag($turnos_update, "p_x_idacademia") ?>
</span>
<?php } ?>
<?php echo $turnos_update->idacademia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($turnos_update->turmas->Visible) { // turmas ?>
	<div id="r_turmas" class="form-group row">
		<label for="x_turmas" class="<?php echo $turnos_update->LeftColumnClass ?>"><div class="custom-control custom-checkbox">
<input type="checkbox" name="u_turmas" id="u_turmas" class="custom-control-input ew-multi-select" value="1"<?php echo $turnos_update->turmas->MultiUpdate == "1" ? " checked" : "" ?>>
<label class="custom-control-label" for="u_turmas"><?php echo $turnos_update->turmas->caption() ?></label></div></label>
		<div class="<?php echo $turnos_update->RightColumnClass ?>"><div <?php echo $turnos_update->turmas->cellAttributes() ?>>
<span id="el_turnos_turmas">
<input type="text" data-table="turnos" data-field="x_turmas" name="x_turmas" id="x_turmas" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($turnos_update->turmas->getPlaceHolder()) ?>" value="<?php echo $turnos_update->turmas->EditValue ?>"<?php echo $turnos_update->turmas->editAttributes() ?>>
</span>
<?php echo $turnos_update->turmas->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page -->
<?php if (!$turnos_update->IsModal) { ?>
	<div class="form-group row"><!-- buttons .form-group -->
		<div class="<?php echo $turnos_update->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("UpdateBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $turnos_update->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
		</div><!-- /buttons offset -->
	</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$turnos_update->showPageFooter();
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
$turnos_update->terminate();
?>