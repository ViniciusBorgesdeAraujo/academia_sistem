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
$turnos_search = new turnos_search();

// Run the page
$turnos_search->run();

// Setup login status
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$turnos_search->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fturnossearch, currentPageID;
loadjs.ready("head", function() {

	// Form object for search
	<?php if ($turnos_search->IsModal) { ?>
	fturnossearch = currentAdvancedSearchForm = new ew.Form("fturnossearch", "search");
	<?php } else { ?>
	fturnossearch = currentForm = new ew.Form("fturnossearch", "search");
	<?php } ?>
	currentPageID = ew.PAGE_ID = "search";

	// Validate function for search
	fturnossearch.validate = function(fobj) {
		if (!this.validateRequired)
			return true; // Ignore validation
		fobj = fobj || this._form;
		var infix = "";
		elm = this.getElements("x" + infix + "_idturnos");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($turnos_search->idturnos->errorMessage()) ?>");
		elm = this.getElements("x" + infix + "_idacademia");
		if (elm && !ew.checkInteger(elm.value))
			return this.onError(elm, "<?php echo JsEncode($turnos_search->idacademia->errorMessage()) ?>");

		// Call Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		return true;
	}

	// Form_CustomValidate
	fturnossearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fturnossearch.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fturnossearch.lists["x_idacademia"] = <?php echo $turnos_search->idacademia->Lookup->toClientList($turnos_search) ?>;
	fturnossearch.lists["x_idacademia"].options = <?php echo JsonEncode($turnos_search->idacademia->lookupOptions()) ?>;
	fturnossearch.autoSuggests["x_idacademia"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
	loadjs.done("fturnossearch");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $turnos_search->showPageHeader(); ?>
<?php
$turnos_search->showMessage();
?>
<form name="fturnossearch" id="fturnossearch" class="<?php echo $turnos_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="turnos">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$turnos_search->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($turnos_search->idturnos->Visible) { // idturnos ?>
	<div id="r_idturnos" class="form-group row">
		<label for="x_idturnos" class="<?php echo $turnos_search->LeftColumnClass ?>"><span id="elh_turnos_idturnos"><?php echo $turnos_search->idturnos->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idturnos" id="z_idturnos" value="=">
</span>
		</label>
		<div class="<?php echo $turnos_search->RightColumnClass ?>"><div <?php echo $turnos_search->idturnos->cellAttributes() ?>>
			<span id="el_turnos_idturnos" class="ew-search-field">
<input type="text" data-table="turnos" data-field="x_idturnos" name="x_idturnos" id="x_idturnos" maxlength="11" placeholder="<?php echo HtmlEncode($turnos_search->idturnos->getPlaceHolder()) ?>" value="<?php echo $turnos_search->idturnos->EditValue ?>"<?php echo $turnos_search->idturnos->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($turnos_search->idacademia->Visible) { // idacademia ?>
	<div id="r_idacademia" class="form-group row">
		<label class="<?php echo $turnos_search->LeftColumnClass ?>"><span id="elh_turnos_idacademia"><?php echo $turnos_search->idacademia->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("=") ?>
<input type="hidden" name="z_idacademia" id="z_idacademia" value="=">
</span>
		</label>
		<div class="<?php echo $turnos_search->RightColumnClass ?>"><div <?php echo $turnos_search->idacademia->cellAttributes() ?>>
			<span id="el_turnos_idacademia" class="ew-search-field">
<?php
$onchange = $turnos_search->idacademia->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$turnos_search->idacademia->EditAttrs["onchange"] = "";
?>
<span id="as_x_idacademia">
	<input type="text" class="form-control" name="sv_x_idacademia" id="sv_x_idacademia" value="<?php echo RemoveHtml($turnos_search->idacademia->EditValue) ?>" size="30" maxlength="11" placeholder="<?php echo HtmlEncode($turnos_search->idacademia->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($turnos_search->idacademia->getPlaceHolder()) ?>"<?php echo $turnos_search->idacademia->editAttributes() ?>>
</span>
<input type="hidden" data-table="turnos" data-field="x_idacademia" data-value-separator="<?php echo $turnos_search->idacademia->displayValueSeparatorAttribute() ?>" name="x_idacademia" id="x_idacademia" value="<?php echo HtmlEncode($turnos_search->idacademia->AdvancedSearch->SearchValue) ?>"<?php echo $onchange ?>>
<script>
loadjs.ready(["fturnossearch"], function() {
	fturnossearch.createAutoSuggest({"id":"x_idacademia","forceSelect":false});
});
</script>
<?php echo $turnos_search->idacademia->Lookup->getParamTag($turnos_search, "p_x_idacademia") ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($turnos_search->turmas->Visible) { // turmas ?>
	<div id="r_turmas" class="form-group row">
		<label for="x_turmas" class="<?php echo $turnos_search->LeftColumnClass ?>"><span id="elh_turnos_turmas"><?php echo $turnos_search->turmas->caption() ?></span>
		<span class="ew-search-operator">
<?php echo $Language->phrase("LIKE") ?>
<input type="hidden" name="z_turmas" id="z_turmas" value="LIKE">
</span>
		</label>
		<div class="<?php echo $turnos_search->RightColumnClass ?>"><div <?php echo $turnos_search->turmas->cellAttributes() ?>>
			<span id="el_turnos_turmas" class="ew-search-field">
<input type="text" data-table="turnos" data-field="x_turmas" name="x_turmas" id="x_turmas" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($turnos_search->turmas->getPlaceHolder()) ?>" value="<?php echo $turnos_search->turmas->EditValue ?>"<?php echo $turnos_search->turmas->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$turnos_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $turnos_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$turnos_search->showPageFooter();
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
$turnos_search->terminate();
?>