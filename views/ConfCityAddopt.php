<?php

namespace PHPMaker2022\school;

// Page object
$ConfCityAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_city: currentTable } });
var currentForm, currentPageID;
var fconf_cityaddopt;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_cityaddopt = new ew.Form("fconf_cityaddopt", "addopt");
    currentPageID = ew.PAGE_ID = "addopt";
    currentForm = fconf_cityaddopt;

    // Add fields
    var fields = currentTable.fields;
    fconf_cityaddopt.addFields([
        ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null], fields.city.isInvalid],
        ["uf", [fields.uf.visible && fields.uf.required ? ew.Validators.required(fields.uf.caption) : null], fields.uf.isInvalid],
        ["ufId", [fields.ufId.visible && fields.ufId.required ? ew.Validators.required(fields.ufId.caption) : null, ew.Validators.integer], fields.ufId.isInvalid],
        ["county", [fields.county.visible && fields.county.required ? ew.Validators.required(fields.county.caption) : null], fields.county.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null, ew.Validators.float], fields.longitude.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null, ew.Validators.float], fields.latitude.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_cityaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_cityaddopt.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fconf_cityaddopt.lists.uf = <?= $Page->uf->toClientList($Page) ?>;
    fconf_cityaddopt.lists.ufId = <?= $Page->ufId->toClientList($Page) ?>;
    loadjs.done("fconf_cityaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fconf_cityaddopt" id="fconf_cityaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="conf_city">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->city->Visible) { // city ?>
    <div<?= $Page->city->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_city"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->city->cellAttributes() ?>>
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="conf_city" data-field="x_city" value="<?= $Page->city->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>"<?= $Page->city->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <div<?= $Page->uf->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->uf->caption() ?><?= $Page->uf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->uf->cellAttributes() ?>>
<?php
$onchange = $Page->uf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->uf->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->uf->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_uf" class="ew-auto-suggest">
    <input type="<?= $Page->uf->getInputTextType() ?>" class="form-control" name="sv_x_uf" id="sv_x_uf" value="<?= RemoveHtml($Page->uf->EditValue) ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->uf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->uf->getPlaceHolder()) ?>"<?= $Page->uf->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="conf_city" data-field="x_uf" data-input="sv_x_uf" data-value-separator="<?= $Page->uf->displayValueSeparatorAttribute() ?>" name="x_uf" id="x_uf" value="<?= HtmlEncode($Page->uf->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->uf->getErrorMessage() ?></div>
<script>
loadjs.ready("fconf_cityaddopt", function() {
    fconf_cityaddopt.createAutoSuggest(Object.assign({"id":"x_uf","forceSelect":false}, ew.vars.tables.conf_city.fields.uf.autoSuggestOptions));
});
</script>
<?= $Page->uf->Lookup->getParamTag($Page, "p_x_uf") ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ufId->Visible) { // ufId ?>
    <div<?= $Page->ufId->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->ufId->caption() ?><?= $Page->ufId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->ufId->cellAttributes() ?>>
<?php
$onchange = $Page->ufId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->ufId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->ufId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_ufId" class="ew-auto-suggest">
    <input type="<?= $Page->ufId->getInputTextType() ?>" class="form-control" name="sv_x_ufId" id="sv_x_ufId" value="<?= RemoveHtml($Page->ufId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->ufId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->ufId->getPlaceHolder()) ?>"<?= $Page->ufId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="conf_city" data-field="x_ufId" data-input="sv_x_ufId" data-value-separator="<?= $Page->ufId->displayValueSeparatorAttribute() ?>" name="x_ufId" id="x_ufId" value="<?= HtmlEncode($Page->ufId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->ufId->getErrorMessage() ?></div>
<script>
loadjs.ready("fconf_cityaddopt", function() {
    fconf_cityaddopt.createAutoSuggest(Object.assign({"id":"x_ufId","forceSelect":false}, ew.vars.tables.conf_city.fields.ufId.autoSuggestOptions));
});
</script>
<?= $Page->ufId->Lookup->getParamTag($Page, "p_x_ufId") ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->county->Visible) { // county ?>
    <div<?= $Page->county->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_county"><?= $Page->county->caption() ?><?= $Page->county->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->county->cellAttributes() ?>>
<input type="<?= $Page->county->getInputTextType() ?>" name="x_county" id="x_county" data-table="conf_city" data-field="x_county" value="<?= $Page->county->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->county->getPlaceHolder()) ?>"<?= $Page->county->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->county->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <div<?= $Page->longitude->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_longitude"><?= $Page->longitude->caption() ?><?= $Page->longitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->longitude->cellAttributes() ?>>
<input type="<?= $Page->longitude->getInputTextType() ?>" name="x_longitude" id="x_longitude" data-table="conf_city" data-field="x_longitude" value="<?= $Page->longitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->longitude->getPlaceHolder()) ?>"<?= $Page->longitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->longitude->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <div<?= $Page->latitude->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_latitude"><?= $Page->latitude->caption() ?><?= $Page->latitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->latitude->cellAttributes() ?>>
<input type="<?= $Page->latitude->getInputTextType() ?>" name="x_latitude" id="x_latitude" data-table="conf_city" data-field="x_latitude" value="<?= $Page->latitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->latitude->getPlaceHolder()) ?>"<?= $Page->latitude->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->latitude->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("conf_city");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
