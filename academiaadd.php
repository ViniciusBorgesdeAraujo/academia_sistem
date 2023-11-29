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
$academia_add = new academia_add();

// Run the page
$academia_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$academia_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var facademiaadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	facademiaadd = currentForm = new ew.Form("facademiaadd", "add");

	// Validate form
	facademiaadd.validate = function() {
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
			<?php if ($academia_add->nome->Required) { ?>
				elm = this.getElements("x" + infix + "_nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_add->nome->caption(), $academia_add->nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($academia_add->registro->Required) { ?>
				elm = this.getElements("x" + infix + "_registro");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_add->registro->caption(), $academia_add->registro->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($academia_add->ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_add->ativado->caption(), $academia_add->ativado->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($academia_add->idaluno->Required) { ?>
				elm = this.getElements("x" + infix + "_idaluno");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_add->idaluno->caption(), $academia_add->idaluno->RequiredErrorMessage)) ?>");
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
	facademiaadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	facademiaadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	facademiaadd.lists["x_ativado"] = <?php echo $academia_add->ativado->Lookup->toClientList($academia_add) ?>;
	facademiaadd.lists["x_ativado"].options = <?php echo JsonEncode($academia_add->ativado->options(FALSE, TRUE)) ?>;
	facademiaadd.lists["x_idaluno"] = <?php echo $academia_add->idaluno->Lookup->toClientList($academia_add) ?>;
	facademiaadd.lists["x_idaluno"].options = <?php echo JsonEncode($academia_add->idaluno->lookupOptions()) ?>;
	loadjs.done("facademiaadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $academia_add->showPageHeader(); ?>
<?php
$academia_add->showMessage();
?>
<form name="facademiaadd" id="facademiaadd" class="<?php echo $academia_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="academia">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$academia_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($academia_add->nome->Visible) { // nome ?>
	<div id="r_nome" class="form-group row">
		<label id="elh_academia_nome" for="x_nome" class="<?php echo $academia_add->LeftColumnClass ?>"><?php echo $academia_add->nome->caption() ?><?php echo $academia_add->nome->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_add->RightColumnClass ?>"><div <?php echo $academia_add->nome->cellAttributes() ?>>
<span id="el_academia_nome">
<input type="text" data-table="academia" data-field="x_nome" name="x_nome" id="x_nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($academia_add->nome->getPlaceHolder()) ?>" value="<?php echo $academia_add->nome->EditValue ?>"<?php echo $academia_add->nome->editAttributes() ?>>
</span>
<?php echo $academia_add->nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($academia_add->registro->Visible) { // registro ?>
	<div id="r_registro" class="form-group row">
		<label id="elh_academia_registro" for="x_registro" class="<?php echo $academia_add->LeftColumnClass ?>"><?php echo $academia_add->registro->caption() ?><?php echo $academia_add->registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_add->RightColumnClass ?>"><div <?php echo $academia_add->registro->cellAttributes() ?>>
<span id="el_academia_registro">
<input type="text" data-table="academia" data-field="x_registro" name="x_registro" id="x_registro" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($academia_add->registro->getPlaceHolder()) ?>" value="<?php echo $academia_add->registro->EditValue ?>"<?php echo $academia_add->registro->editAttributes() ?>>
</span>
<?php echo $academia_add->registro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($academia_add->ativado->Visible) { // ativado ?>
	<div id="r_ativado" class="form-group row">
		<label id="elh_academia_ativado" class="<?php echo $academia_add->LeftColumnClass ?>"><?php echo $academia_add->ativado->caption() ?><?php echo $academia_add->ativado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_add->RightColumnClass ?>"><div <?php echo $academia_add->ativado->cellAttributes() ?>>
<span id="el_academia_ativado">
<div id="tp_x_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="academia" data-field="x_ativado" data-value-separator="<?php echo $academia_add->ativado->displayValueSeparatorAttribute() ?>" name="x_ativado" id="x_ativado" value="{value}"<?php echo $academia_add->ativado->editAttributes() ?>></div>
<div id="dsl_x_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $academia_add->ativado->radioButtonListHtml(FALSE, "x_ativado") ?>
</div></div>
</span>
<?php echo $academia_add->ativado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($academia_add->idaluno->Visible) { // idaluno ?>
	<div id="r_idaluno" class="form-group row">
		<label id="elh_academia_idaluno" for="x_idaluno" class="<?php echo $academia_add->LeftColumnClass ?>"><?php echo $academia_add->idaluno->caption() ?><?php echo $academia_add->idaluno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_add->RightColumnClass ?>"><div <?php echo $academia_add->idaluno->cellAttributes() ?>>
<span id="el_academia_idaluno">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="academia" data-field="x_idaluno" data-value-separator="<?php echo $academia_add->idaluno->displayValueSeparatorAttribute() ?>" id="x_idaluno" name="x_idaluno"<?php echo $academia_add->idaluno->editAttributes() ?>>
			<?php echo $academia_add->idaluno->selectOptionListHtml("x_idaluno") ?>
		</select>
</div>
<?php echo $academia_add->idaluno->Lookup->getParamTag($academia_add, "p_x_idaluno") ?>
</span>
<?php echo $academia_add->idaluno->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if ($academia->getCurrentDetailTable() != "") { ?>
<?php
	$academia_add->DetailPages->ValidKeys = explode(",", $academia->getCurrentDetailTable());
	$firstActiveDetailTable = $academia_add->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="academia_add_details"><!-- tabs -->
	<ul class="<?php echo $academia_add->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("turnos", explode(",", $academia->getCurrentDetailTable())) && $turnos->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "turnos") {
			$firstActiveDetailTable = "turnos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $academia_add->DetailPages->pageStyle("turnos") ?>" href="#tab_turnos" data-toggle="tab"><?php echo $Language->tablePhrase("turnos", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("endereco", explode(",", $academia->getCurrentDetailTable())) && $endereco->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco") {
			$firstActiveDetailTable = "endereco";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $academia_add->DetailPages->pageStyle("endereco") ?>" href="#tab_endereco" data-toggle="tab"><?php echo $Language->tablePhrase("endereco", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("turnos", explode(",", $academia->getCurrentDetailTable())) && $turnos->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "turnos")
			$firstActiveDetailTable = "turnos";
?>
		<div class="tab-pane <?php echo $academia_add->DetailPages->pageStyle("turnos") ?>" id="tab_turnos"><!-- page* -->
<?php include_once "turnosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("endereco", explode(",", $academia->getCurrentDetailTable())) && $endereco->DetailAdd) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco")
			$firstActiveDetailTable = "endereco";
?>
		<div class="tab-pane <?php echo $academia_add->DetailPages->pageStyle("endereco") ?>" id="tab_endereco"><!-- page* -->
<?php include_once "enderecogrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$academia_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $academia_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $academia_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$academia_add->showPageFooter();
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
$academia_add->terminate();
?>