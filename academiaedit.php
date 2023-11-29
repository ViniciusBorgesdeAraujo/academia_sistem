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
$academia_edit = new academia_edit();

// Run the page
$academia_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$academia_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var facademiaedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	facademiaedit = currentForm = new ew.Form("facademiaedit", "edit");

	// Validate form
	facademiaedit.validate = function() {
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
			<?php if ($academia_edit->nome->Required) { ?>
				elm = this.getElements("x" + infix + "_nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_edit->nome->caption(), $academia_edit->nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($academia_edit->registro->Required) { ?>
				elm = this.getElements("x" + infix + "_registro");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_edit->registro->caption(), $academia_edit->registro->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($academia_edit->ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_edit->ativado->caption(), $academia_edit->ativado->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($academia_edit->idaluno->Required) { ?>
				elm = this.getElements("x" + infix + "_idaluno");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $academia_edit->idaluno->caption(), $academia_edit->idaluno->RequiredErrorMessage)) ?>");
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
	facademiaedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	facademiaedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	facademiaedit.lists["x_ativado"] = <?php echo $academia_edit->ativado->Lookup->toClientList($academia_edit) ?>;
	facademiaedit.lists["x_ativado"].options = <?php echo JsonEncode($academia_edit->ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("facademiaedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $academia_edit->showPageHeader(); ?>
<?php
$academia_edit->showMessage();
?>
<?php if (!$academia_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $academia_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="facademiaedit" id="facademiaedit" class="<?php echo $academia_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="academia">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$academia_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($academia_edit->nome->Visible) { // nome ?>
	<div id="r_nome" class="form-group row">
		<label id="elh_academia_nome" for="x_nome" class="<?php echo $academia_edit->LeftColumnClass ?>"><?php echo $academia_edit->nome->caption() ?><?php echo $academia_edit->nome->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_edit->RightColumnClass ?>"><div <?php echo $academia_edit->nome->cellAttributes() ?>>
<span id="el_academia_nome">
<input type="text" data-table="academia" data-field="x_nome" name="x_nome" id="x_nome" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($academia_edit->nome->getPlaceHolder()) ?>" value="<?php echo $academia_edit->nome->EditValue ?>"<?php echo $academia_edit->nome->editAttributes() ?>>
</span>
<?php echo $academia_edit->nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($academia_edit->registro->Visible) { // registro ?>
	<div id="r_registro" class="form-group row">
		<label id="elh_academia_registro" for="x_registro" class="<?php echo $academia_edit->LeftColumnClass ?>"><?php echo $academia_edit->registro->caption() ?><?php echo $academia_edit->registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_edit->RightColumnClass ?>"><div <?php echo $academia_edit->registro->cellAttributes() ?>>
<span id="el_academia_registro">
<input type="text" data-table="academia" data-field="x_registro" name="x_registro" id="x_registro" size="30" maxlength="45" placeholder="<?php echo HtmlEncode($academia_edit->registro->getPlaceHolder()) ?>" value="<?php echo $academia_edit->registro->EditValue ?>"<?php echo $academia_edit->registro->editAttributes() ?>>
</span>
<?php echo $academia_edit->registro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($academia_edit->ativado->Visible) { // ativado ?>
	<div id="r_ativado" class="form-group row">
		<label id="elh_academia_ativado" class="<?php echo $academia_edit->LeftColumnClass ?>"><?php echo $academia_edit->ativado->caption() ?><?php echo $academia_edit->ativado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_edit->RightColumnClass ?>"><div <?php echo $academia_edit->ativado->cellAttributes() ?>>
<span id="el_academia_ativado">
<div id="tp_x_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="academia" data-field="x_ativado" data-value-separator="<?php echo $academia_edit->ativado->displayValueSeparatorAttribute() ?>" name="x_ativado" id="x_ativado" value="{value}"<?php echo $academia_edit->ativado->editAttributes() ?>></div>
<div id="dsl_x_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $academia_edit->ativado->radioButtonListHtml(FALSE, "x_ativado") ?>
</div></div>
</span>
<?php echo $academia_edit->ativado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($academia_edit->idaluno->Visible) { // idaluno ?>
	<div id="r_idaluno" class="form-group row">
		<label id="elh_academia_idaluno" for="x_idaluno" class="<?php echo $academia_edit->LeftColumnClass ?>"><?php echo $academia_edit->idaluno->caption() ?><?php echo $academia_edit->idaluno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $academia_edit->RightColumnClass ?>"><div <?php echo $academia_edit->idaluno->cellAttributes() ?>>
<span id="el_academia_idaluno">
<span<?php echo $academia_edit->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($academia_edit->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="academia" data-field="x_idaluno" name="x_idaluno" id="x_idaluno" value="<?php echo HtmlEncode($academia_edit->idaluno->CurrentValue) ?>">
<?php echo $academia_edit->idaluno->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="academia" data-field="x_idacademia" name="x_idacademia" id="x_idacademia" value="<?php echo HtmlEncode($academia_edit->idacademia->CurrentValue) ?>">
<?php if ($academia->getCurrentDetailTable() != "") { ?>
<?php
	$academia_edit->DetailPages->ValidKeys = explode(",", $academia->getCurrentDetailTable());
	$firstActiveDetailTable = $academia_edit->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="academia_edit_details"><!-- tabs -->
	<ul class="<?php echo $academia_edit->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("turnos", explode(",", $academia->getCurrentDetailTable())) && $turnos->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "turnos") {
			$firstActiveDetailTable = "turnos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $academia_edit->DetailPages->pageStyle("turnos") ?>" href="#tab_turnos" data-toggle="tab"><?php echo $Language->tablePhrase("turnos", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("endereco", explode(",", $academia->getCurrentDetailTable())) && $endereco->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco") {
			$firstActiveDetailTable = "endereco";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $academia_edit->DetailPages->pageStyle("endereco") ?>" href="#tab_endereco" data-toggle="tab"><?php echo $Language->tablePhrase("endereco", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("turnos", explode(",", $academia->getCurrentDetailTable())) && $turnos->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "turnos")
			$firstActiveDetailTable = "turnos";
?>
		<div class="tab-pane <?php echo $academia_edit->DetailPages->pageStyle("turnos") ?>" id="tab_turnos"><!-- page* -->
<?php include_once "turnosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("endereco", explode(",", $academia->getCurrentDetailTable())) && $endereco->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "endereco")
			$firstActiveDetailTable = "endereco";
?>
		<div class="tab-pane <?php echo $academia_edit->DetailPages->pageStyle("endereco") ?>" id="tab_endereco"><!-- page* -->
<?php include_once "enderecogrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$academia_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $academia_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $academia_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$academia_edit->IsModal) { ?>
<?php echo $academia_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$academia_edit->showPageFooter();
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
$academia_edit->terminate();
?>