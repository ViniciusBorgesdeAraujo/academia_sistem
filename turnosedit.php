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
$turnos_edit = new turnos_edit();

// Run the page
$turnos_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fturnosedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	fturnosedit = currentForm = new ew.Form("fturnosedit", "edit");

	// Validate form
	fturnosedit.validate = function() {
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
			<?php if ($turnos_edit->idacademia->Required) { ?>
				elm = this.getElements("x" + infix + "_idacademia");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $turnos_edit->idacademia->caption(), $turnos_edit->idacademia->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($turnos_edit->turmas->Required) { ?>
				elm = this.getElements("x" + infix + "_turmas");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $turnos_edit->turmas->caption(), $turnos_edit->turmas->RequiredErrorMessage)) ?>");
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
	fturnosedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fturnosedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fturnosedit.lists["x_idacademia"] = <?php echo $turnos_edit->idacademia->Lookup->toClientList($turnos_edit) ?>;
	fturnosedit.lists["x_idacademia"].options = <?php echo JsonEncode($turnos_edit->idacademia->lookupOptions()) ?>;
	fturnosedit.lists["x_turmas"] = <?php echo $turnos_edit->turmas->Lookup->toClientList($turnos_edit) ?>;
	fturnosedit.lists["x_turmas"].options = <?php echo JsonEncode($turnos_edit->turmas->lookupOptions()) ?>;
	loadjs.done("fturnosedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $turnos_edit->showPageHeader(); ?>
<?php
$turnos_edit->showMessage();
?>
<?php if (!$turnos_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $turnos_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fturnosedit" id="fturnosedit" class="<?php echo $turnos_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="turnos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$turnos_edit->IsModal ?>">
<?php if ($turnos->getCurrentMasterTable() == "academia") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="academia">
<input type="hidden" name="fk_idacademia" value="<?php echo HtmlEncode($turnos_edit->idacademia->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($turnos_edit->idacademia->Visible) { // idacademia ?>
	<div id="r_idacademia" class="form-group row">
		<label id="elh_turnos_idacademia" for="x_idacademia" class="<?php echo $turnos_edit->LeftColumnClass ?>"><?php echo $turnos_edit->idacademia->caption() ?><?php echo $turnos_edit->idacademia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $turnos_edit->RightColumnClass ?>"><div <?php echo $turnos_edit->idacademia->cellAttributes() ?>>
<?php if ($turnos_edit->idacademia->getSessionValue() != "") { ?>
<span id="el_turnos_idacademia">
<span<?php echo $turnos_edit->idacademia->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($turnos_edit->idacademia->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idacademia" name="x_idacademia" value="<?php echo HtmlEncode($turnos_edit->idacademia->CurrentValue) ?>">
<?php } else { ?>
<span id="el_turnos_idacademia">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_idacademia" data-value-separator="<?php echo $turnos_edit->idacademia->displayValueSeparatorAttribute() ?>" id="x_idacademia" name="x_idacademia"<?php echo $turnos_edit->idacademia->editAttributes() ?>>
			<?php echo $turnos_edit->idacademia->selectOptionListHtml("x_idacademia") ?>
		</select>
</div>
<?php echo $turnos_edit->idacademia->Lookup->getParamTag($turnos_edit, "p_x_idacademia") ?>
</span>
<?php } ?>
<?php echo $turnos_edit->idacademia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($turnos_edit->turmas->Visible) { // turmas ?>
	<div id="r_turmas" class="form-group row">
		<label id="elh_turnos_turmas" for="x_turmas" class="<?php echo $turnos_edit->LeftColumnClass ?>"><?php echo $turnos_edit->turmas->caption() ?><?php echo $turnos_edit->turmas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $turnos_edit->RightColumnClass ?>"><div <?php echo $turnos_edit->turmas->cellAttributes() ?>>
<span id="el_turnos_turmas">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="turnos" data-field="x_turmas" data-value-separator="<?php echo $turnos_edit->turmas->displayValueSeparatorAttribute() ?>" id="x_turmas" name="x_turmas"<?php echo $turnos_edit->turmas->editAttributes() ?>>
			<?php echo $turnos_edit->turmas->selectOptionListHtml("x_turmas") ?>
		</select>
</div>
<?php echo $turnos_edit->turmas->Lookup->getParamTag($turnos_edit, "p_x_turmas") ?>
</span>
<?php echo $turnos_edit->turmas->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="turnos" data-field="x_idturnos" name="x_idturnos" id="x_idturnos" value="<?php echo HtmlEncode($turnos_edit->idturnos->CurrentValue) ?>">
<?php
	if (in_array("aulas", explode(",", $turnos->getCurrentDetailTable())) && $aulas->DetailEdit) {
?>
<?php if ($turnos->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?php echo $Language->tablePhrase("aulas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "aulasgrid.php" ?>
<?php } ?>
<?php if (!$turnos_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $turnos_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $turnos_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$turnos_edit->IsModal) { ?>
<?php echo $turnos_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$turnos_edit->showPageFooter();
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
$turnos_edit->terminate();
?>