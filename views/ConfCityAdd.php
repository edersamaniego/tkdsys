<?php

namespace PHPMaker2022\school;

// Page object
$ConfCityAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_city: currentTable } });
var currentForm, currentPageID;
var fconf_cityadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_cityadd = new ew.Form("fconf_cityadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_cityadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_cityadd.addFields([
        ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null], fields.city.isInvalid],
        ["uf", [fields.uf.visible && fields.uf.required ? ew.Validators.required(fields.uf.caption) : null], fields.uf.isInvalid],
        ["ufId", [fields.ufId.visible && fields.ufId.required ? ew.Validators.required(fields.ufId.caption) : null, ew.Validators.integer], fields.ufId.isInvalid],
        ["county", [fields.county.visible && fields.county.required ? ew.Validators.required(fields.county.caption) : null], fields.county.isInvalid],
        ["longitude", [fields.longitude.visible && fields.longitude.required ? ew.Validators.required(fields.longitude.caption) : null, ew.Validators.float], fields.longitude.isInvalid],
        ["latitude", [fields.latitude.visible && fields.latitude.required ? ew.Validators.required(fields.latitude.caption) : null, ew.Validators.float], fields.latitude.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_cityadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_cityadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fconf_cityadd.lists.uf = <?= $Page->uf->toClientList($Page) ?>;
    fconf_cityadd.lists.ufId = <?= $Page->ufId->toClientList($Page) ?>;
    loadjs.done("fconf_cityadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fconf_cityadd" id="fconf_cityadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_city">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->city->Visible) { // city ?>
    <div id="r_city"<?= $Page->city->rowAttributes() ?>>
        <label id="elh_conf_city_city" for="x_city" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city->cellAttributes() ?>>
<span id="el_conf_city_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="conf_city" data-field="x_city" value="<?= $Page->city->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>"<?= $Page->city->editAttributes() ?> aria-describedby="x_city_help">
<?= $Page->city->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <div id="r_uf"<?= $Page->uf->rowAttributes() ?>>
        <label id="elh_conf_city_uf" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uf->caption() ?><?= $Page->uf->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uf->cellAttributes() ?>>
<span id="el_conf_city_uf">
<?php
$onchange = $Page->uf->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->uf->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->uf->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_uf" class="ew-auto-suggest">
    <input type="<?= $Page->uf->getInputTextType() ?>" class="form-control" name="sv_x_uf" id="sv_x_uf" value="<?= RemoveHtml($Page->uf->EditValue) ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->uf->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->uf->getPlaceHolder()) ?>"<?= $Page->uf->editAttributes() ?> aria-describedby="x_uf_help">
</span>
<selection-list hidden class="form-control" data-table="conf_city" data-field="x_uf" data-input="sv_x_uf" data-value-separator="<?= $Page->uf->displayValueSeparatorAttribute() ?>" name="x_uf" id="x_uf" value="<?= HtmlEncode($Page->uf->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->uf->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uf->getErrorMessage() ?></div>
<script>
loadjs.ready("fconf_cityadd", function() {
    fconf_cityadd.createAutoSuggest(Object.assign({"id":"x_uf","forceSelect":false}, ew.vars.tables.conf_city.fields.uf.autoSuggestOptions));
});
</script>
<?= $Page->uf->Lookup->getParamTag($Page, "p_x_uf") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ufId->Visible) { // ufId ?>
    <div id="r_ufId"<?= $Page->ufId->rowAttributes() ?>>
        <label id="elh_conf_city_ufId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ufId->caption() ?><?= $Page->ufId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ufId->cellAttributes() ?>>
<span id="el_conf_city_ufId">
<?php
$onchange = $Page->ufId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->ufId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->ufId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_ufId" class="ew-auto-suggest">
    <input type="<?= $Page->ufId->getInputTextType() ?>" class="form-control" name="sv_x_ufId" id="sv_x_ufId" value="<?= RemoveHtml($Page->ufId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->ufId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->ufId->getPlaceHolder()) ?>"<?= $Page->ufId->editAttributes() ?> aria-describedby="x_ufId_help">
</span>
<selection-list hidden class="form-control" data-table="conf_city" data-field="x_ufId" data-input="sv_x_ufId" data-value-separator="<?= $Page->ufId->displayValueSeparatorAttribute() ?>" name="x_ufId" id="x_ufId" value="<?= HtmlEncode($Page->ufId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->ufId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ufId->getErrorMessage() ?></div>
<script>
loadjs.ready("fconf_cityadd", function() {
    fconf_cityadd.createAutoSuggest(Object.assign({"id":"x_ufId","forceSelect":false}, ew.vars.tables.conf_city.fields.ufId.autoSuggestOptions));
});
</script>
<?= $Page->ufId->Lookup->getParamTag($Page, "p_x_ufId") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->county->Visible) { // county ?>
    <div id="r_county"<?= $Page->county->rowAttributes() ?>>
        <label id="elh_conf_city_county" for="x_county" class="<?= $Page->LeftColumnClass ?>"><?= $Page->county->caption() ?><?= $Page->county->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->county->cellAttributes() ?>>
<span id="el_conf_city_county">
<input type="<?= $Page->county->getInputTextType() ?>" name="x_county" id="x_county" data-table="conf_city" data-field="x_county" value="<?= $Page->county->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->county->getPlaceHolder()) ?>"<?= $Page->county->editAttributes() ?> aria-describedby="x_county_help">
<?= $Page->county->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->county->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <div id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <label id="elh_conf_city_longitude" for="x_longitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->longitude->caption() ?><?= $Page->longitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->longitude->cellAttributes() ?>>
<span id="el_conf_city_longitude">
<input type="<?= $Page->longitude->getInputTextType() ?>" name="x_longitude" id="x_longitude" data-table="conf_city" data-field="x_longitude" value="<?= $Page->longitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->longitude->getPlaceHolder()) ?>"<?= $Page->longitude->editAttributes() ?> aria-describedby="x_longitude_help">
<?= $Page->longitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->longitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <div id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <label id="elh_conf_city_latitude" for="x_latitude" class="<?= $Page->LeftColumnClass ?>"><?= $Page->latitude->caption() ?><?= $Page->latitude->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->latitude->cellAttributes() ?>>
<span id="el_conf_city_latitude">
<input type="<?= $Page->latitude->getInputTextType() ?>" name="x_latitude" id="x_latitude" data-table="conf_city" data-field="x_latitude" value="<?= $Page->latitude->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->latitude->getPlaceHolder()) ?>"<?= $Page->latitude->editAttributes() ?> aria-describedby="x_latitude_help">
<?= $Page->latitude->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->latitude->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
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
