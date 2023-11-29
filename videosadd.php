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
$videos_add = new videos_add();

// Run the page
$videos_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$videos_add->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fvideosadd, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "add";
	fvideosadd = currentForm = new ew.Form("fvideosadd", "add");

	// Validate form
	fvideosadd.validate = function() {
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
			<?php if ($videos_add->titulo->Required) { ?>
				elm = this.getElements("x" + infix + "_titulo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_add->titulo->caption(), $videos_add->titulo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($videos_add->idaulas->Required) { ?>
				elm = this.getElements("x" + infix + "_idaulas");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_add->idaulas->caption(), $videos_add->idaulas->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($videos_add->urlvideo->Required) { ?>
				elm = this.getElements("x" + infix + "_urlvideo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_add->urlvideo->caption(), $videos_add->urlvideo->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($videos_add->ativo->Required) { ?>
				elm = this.getElements("x" + infix + "_ativo");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $videos_add->ativo->caption(), $videos_add->ativo->RequiredErrorMessage)) ?>");
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
	fvideosadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	fvideosadd.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	fvideosadd.lists["x_idaulas"] = <?php echo $videos_add->idaulas->Lookup->toClientList($videos_add) ?>;
	fvideosadd.lists["x_idaulas"].options = <?php echo JsonEncode($videos_add->idaulas->lookupOptions()) ?>;
	fvideosadd.lists["x_ativo"] = <?php echo $videos_add->ativo->Lookup->toClientList($videos_add) ?>;
	fvideosadd.lists["x_ativo"].options = <?php echo JsonEncode($videos_add->ativo->options(FALSE, TRUE)) ?>;
	loadjs.done("fvideosadd");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $videos_add->showPageHeader(); ?>
<?php
$videos_add->showMessage();
?>
<form name="fvideosadd" id="fvideosadd" class="<?php echo $videos_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="videos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$videos_add->IsModal ?>">
<?php if ($videos->getCurrentMasterTable() == "aulas") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="aulas">
<input type="hidden" name="fk_idaulas" value="<?php echo HtmlEncode($videos_add->idaulas->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($videos_add->titulo->Visible) { // titulo ?>
	<div id="r_titulo" class="form-group row">
		<label id="elh_videos_titulo" for="x_titulo" class="<?php echo $videos_add->LeftColumnClass ?>"><?php echo $videos_add->titulo->caption() ?><?php echo $videos_add->titulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $videos_add->RightColumnClass ?>"><div <?php echo $videos_add->titulo->cellAttributes() ?>>
<span id="el_videos_titulo">
<input type="text" data-table="videos" data-field="x_titulo" name="x_titulo" id="x_titulo" size="30" maxlength="35" placeholder="<?php echo HtmlEncode($videos_add->titulo->getPlaceHolder()) ?>" value="<?php echo $videos_add->titulo->EditValue ?>"<?php echo $videos_add->titulo->editAttributes() ?>>
</span>
<?php echo $videos_add->titulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($videos_add->idaulas->Visible) { // idaulas ?>
	<div id="r_idaulas" class="form-group row">
		<label id="elh_videos_idaulas" for="x_idaulas" class="<?php echo $videos_add->LeftColumnClass ?>"><?php echo $videos_add->idaulas->caption() ?><?php echo $videos_add->idaulas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $videos_add->RightColumnClass ?>"><div <?php echo $videos_add->idaulas->cellAttributes() ?>>
<?php if ($videos_add->idaulas->getSessionValue() != "") { ?>
<span id="el_videos_idaulas">
<span<?php echo $videos_add->idaulas->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($videos_add->idaulas->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idaulas" name="x_idaulas" value="<?php echo HtmlEncode($videos_add->idaulas->CurrentValue) ?>">
<?php } else { ?>
<span id="el_videos_idaulas">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="videos" data-field="x_idaulas" data-value-separator="<?php echo $videos_add->idaulas->displayValueSeparatorAttribute() ?>" id="x_idaulas" name="x_idaulas"<?php echo $videos_add->idaulas->editAttributes() ?>>
			<?php echo $videos_add->idaulas->selectOptionListHtml("x_idaulas") ?>
		</select>
</div>
<?php echo $videos_add->idaulas->Lookup->getParamTag($videos_add, "p_x_idaulas") ?>
</span>
<?php } ?>
<?php echo $videos_add->idaulas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($videos_add->urlvideo->Visible) { // urlvideo ?>
	<div id="r_urlvideo" class="form-group row">
		<label id="elh_videos_urlvideo" for="x_urlvideo" class="<?php echo $videos_add->LeftColumnClass ?>"><?php echo $videos_add->urlvideo->caption() ?><?php echo $videos_add->urlvideo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $videos_add->RightColumnClass ?>"><div <?php echo $videos_add->urlvideo->cellAttributes() ?>>
<span id="el_videos_urlvideo">
<input type="text" data-table="videos" data-field="x_urlvideo" name="x_urlvideo" id="x_urlvideo" size="20" maxlength="20" placeholder="<?php echo HtmlEncode($videos_add->urlvideo->getPlaceHolder()) ?>" value="<?php echo $videos_add->urlvideo->EditValue ?>"<?php echo $videos_add->urlvideo->editAttributes() ?>>
</span>
<?php echo $videos_add->urlvideo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($videos_add->ativo->Visible) { // ativo ?>
	<div id="r_ativo" class="form-group row">
		<label id="elh_videos_ativo" class="<?php echo $videos_add->LeftColumnClass ?>"><?php echo $videos_add->ativo->caption() ?><?php echo $videos_add->ativo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $videos_add->RightColumnClass ?>"><div <?php echo $videos_add->ativo->cellAttributes() ?>>
<span id="el_videos_ativo">
<div id="tp_x_ativo" class="ew-template"><input type="radio" class="custom-control-input" data-table="videos" data-field="x_ativo" data-value-separator="<?php echo $videos_add->ativo->displayValueSeparatorAttribute() ?>" name="x_ativo" id="x_ativo" value="{value}"<?php echo $videos_add->ativo->editAttributes() ?>></div>
<div id="dsl_x_ativo" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $videos_add->ativo->radioButtonListHtml(FALSE, "x_ativo") ?>
</div></div>
</span>
<?php echo $videos_add->ativo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$videos_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $videos_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $videos_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$videos_add->showPageFooter();
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
$videos_add->terminate();
?>