<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditorsAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_creditors: currentTable } });
var currentForm, currentPageID;
var ffin_creditorsaddopt;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditorsaddopt = new ew.Form("ffin_creditorsaddopt", "addopt");
    currentPageID = ew.PAGE_ID = "addopt";
    currentForm = ffin_creditorsaddopt;

    // Add fields
    var fields = currentTable.fields;
    ffin_creditorsaddopt.addFields([
        ["organizationId", [fields.organizationId.visible && fields.organizationId.required ? ew.Validators.required(fields.organizationId.caption) : null, ew.Validators.integer], fields.organizationId.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null, ew.Validators.integer], fields._userId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid],
        ["creditor", [fields.creditor.visible && fields.creditor.required ? ew.Validators.required(fields.creditor.caption) : null], fields.creditor.isInvalid],
        ["uniqueCode", [fields.uniqueCode.visible && fields.uniqueCode.required ? ew.Validators.required(fields.uniqueCode.caption) : null], fields.uniqueCode.isInvalid],
        ["IDcode", [fields.IDcode.visible && fields.IDcode.required ? ew.Validators.required(fields.IDcode.caption) : null], fields.IDcode.isInvalid],
        ["adress", [fields.adress.visible && fields.adress.required ? ew.Validators.required(fields.adress.caption) : null], fields.adress.isInvalid],
        ["number", [fields.number.visible && fields.number.required ? ew.Validators.required(fields.number.caption) : null], fields.number.isInvalid],
        ["neighborhood", [fields.neighborhood.visible && fields.neighborhood.required ? ew.Validators.required(fields.neighborhood.caption) : null], fields.neighborhood.isInvalid],
        ["country", [fields.country.visible && fields.country.required ? ew.Validators.required(fields.country.caption) : null, ew.Validators.integer], fields.country.isInvalid],
        ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null, ew.Validators.integer], fields.state.isInvalid],
        ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null, ew.Validators.integer], fields.city.isInvalid],
        ["telephone1", [fields.telephone1.visible && fields.telephone1.required ? ew.Validators.required(fields.telephone1.caption) : null], fields.telephone1.isInvalid],
        ["telephone2", [fields.telephone2.visible && fields.telephone2.required ? ew.Validators.required(fields.telephone2.caption) : null], fields.telephone2.isInvalid],
        ["website", [fields.website.visible && fields.website.required ? ew.Validators.required(fields.website.caption) : null], fields.website.isInvalid],
        ["email1", [fields.email1.visible && fields.email1.required ? ew.Validators.required(fields.email1.caption) : null], fields.email1.isInvalid],
        ["email2", [fields.email2.visible && fields.email2.required ? ew.Validators.required(fields.email2.caption) : null], fields.email2.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["_register", [fields._register.visible && fields._register.required ? ew.Validators.required(fields._register.caption) : null, ew.Validators.datetime(fields._register.clientFormatPattern)], fields._register.isInvalid],
        ["lastupdate", [fields.lastupdate.visible && fields.lastupdate.required ? ew.Validators.required(fields.lastupdate.caption) : null], fields.lastupdate.isInvalid],
        ["_default", [fields._default.visible && fields._default.required ? ew.Validators.required(fields._default.caption) : null], fields._default.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_creditorsaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_creditorsaddopt.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_creditorsaddopt.lists.organizationId = <?= $Page->organizationId->toClientList($Page) ?>;
    ffin_creditorsaddopt.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    ffin_creditorsaddopt.lists._userId = <?= $Page->_userId->toClientList($Page) ?>;
    ffin_creditorsaddopt.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    ffin_creditorsaddopt.lists._default = <?= $Page->_default->toClientList($Page) ?>;
    loadjs.done("ffin_creditorsaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="ffin_creditorsaddopt" id="ffin_creditorsaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="fin_creditors">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->organizationId->Visible) { // organizationId ?>
    <div<?= $Page->organizationId->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->organizationId->caption() ?><?= $Page->organizationId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->organizationId->cellAttributes() ?>>
<?php
$onchange = $Page->organizationId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->organizationId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->organizationId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_organizationId" class="ew-auto-suggest">
    <input type="<?= $Page->organizationId->getInputTextType() ?>" class="form-control" name="sv_x_organizationId" id="sv_x_organizationId" value="<?= RemoveHtml($Page->organizationId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->organizationId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->organizationId->getPlaceHolder()) ?>"<?= $Page->organizationId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fin_creditors" data-field="x_organizationId" data-input="sv_x_organizationId" data-value-separator="<?= $Page->organizationId->displayValueSeparatorAttribute() ?>" name="x_organizationId" id="x_organizationId" value="<?= HtmlEncode($Page->organizationId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->organizationId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_creditorsaddopt", function() {
    ffin_creditorsaddopt.createAutoSuggest(Object.assign({"id":"x_organizationId","forceSelect":false}, ew.vars.tables.fin_creditors.fields.organizationId.autoSuggestOptions));
});
</script>
<?= $Page->organizationId->Lookup->getParamTag($Page, "p_x_organizationId") ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <input type="hidden" data-table="fin_creditors" data-field="x_masterSchoolId" data-hidden="1" name="x_masterSchoolId" id="x_masterSchoolId" value="<?= HtmlEncode($Page->masterSchoolId->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <div<?= $Page->_userId->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->_userId->caption() ?><?= $Page->_userId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->_userId->cellAttributes() ?>>
<?php
$onchange = $Page->_userId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->_userId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->_userId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x__userId" class="ew-auto-suggest">
    <input type="<?= $Page->_userId->getInputTextType() ?>" class="form-control" name="sv_x__userId" id="sv_x__userId" value="<?= RemoveHtml($Page->_userId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->_userId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->_userId->getPlaceHolder()) ?>"<?= $Page->_userId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fin_creditors" data-field="x__userId" data-input="sv_x__userId" data-value-separator="<?= $Page->_userId->displayValueSeparatorAttribute() ?>" name="x__userId" id="x__userId" value="<?= HtmlEncode($Page->_userId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->_userId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_creditorsaddopt", function() {
    ffin_creditorsaddopt.createAutoSuggest(Object.assign({"id":"x__userId","forceSelect":false}, ew.vars.tables.fin_creditors.fields._userId.autoSuggestOptions));
});
</script>
<?= $Page->_userId->Lookup->getParamTag($Page, "p_x__userId") ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div<?= $Page->schoolId->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("addopt")) { // Non system admin ?>
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="ffin_creditorsaddopt_x_schoolId"
        data-table="fin_creditors"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("ffin_creditorsaddopt", function() {
    var options = { name: "x_schoolId", selectId: "ffin_creditorsaddopt_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_creditorsaddopt.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "ffin_creditorsaddopt" };
    } else {
        options.ajax = { id: "x_schoolId", form: "ffin_creditorsaddopt", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_creditors.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } else { ?>
<?php
$onchange = $Page->schoolId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->schoolId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->schoolId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_schoolId" class="ew-auto-suggest">
    <input type="<?= $Page->schoolId->getInputTextType() ?>" class="form-control" name="sv_x_schoolId" id="sv_x_schoolId" value="<?= RemoveHtml($Page->schoolId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"<?= $Page->schoolId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fin_creditors" data-field="x_schoolId" data-input="sv_x_schoolId" data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>" name="x_schoolId" id="x_schoolId" value="<?= HtmlEncode($Page->schoolId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_creditorsaddopt", function() {
    ffin_creditorsaddopt.createAutoSuggest(Object.assign({"id":"x_schoolId","forceSelect":false}, ew.vars.tables.fin_creditors.fields.schoolId.autoSuggestOptions));
});
</script>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->creditor->Visible) { // creditor ?>
    <div<?= $Page->creditor->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_creditor"><?= $Page->creditor->caption() ?><?= $Page->creditor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->creditor->cellAttributes() ?>>
<input type="<?= $Page->creditor->getInputTextType() ?>" name="x_creditor" id="x_creditor" data-table="fin_creditors" data-field="x_creditor" value="<?= $Page->creditor->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->creditor->getPlaceHolder()) ?>"<?= $Page->creditor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->creditor->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uniqueCode->Visible) { // uniqueCode ?>
    <div<?= $Page->uniqueCode->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_uniqueCode"><?= $Page->uniqueCode->caption() ?><?= $Page->uniqueCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->uniqueCode->cellAttributes() ?>>
<input type="<?= $Page->uniqueCode->getInputTextType() ?>" name="x_uniqueCode" id="x_uniqueCode" data-table="fin_creditors" data-field="x_uniqueCode" value="<?= $Page->uniqueCode->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->uniqueCode->getPlaceHolder()) ?>"<?= $Page->uniqueCode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->uniqueCode->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IDcode->Visible) { // IDcode ?>
    <div<?= $Page->IDcode->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_IDcode"><?= $Page->IDcode->caption() ?><?= $Page->IDcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->IDcode->cellAttributes() ?>>
<input type="<?= $Page->IDcode->getInputTextType() ?>" name="x_IDcode" id="x_IDcode" data-table="fin_creditors" data-field="x_IDcode" value="<?= $Page->IDcode->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->IDcode->getPlaceHolder()) ?>"<?= $Page->IDcode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->IDcode->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->adress->Visible) { // adress ?>
    <div<?= $Page->adress->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_adress"><?= $Page->adress->caption() ?><?= $Page->adress->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->adress->cellAttributes() ?>>
<input type="<?= $Page->adress->getInputTextType() ?>" name="x_adress" id="x_adress" data-table="fin_creditors" data-field="x_adress" value="<?= $Page->adress->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->adress->getPlaceHolder()) ?>"<?= $Page->adress->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->adress->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
    <div<?= $Page->number->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_number"><?= $Page->number->caption() ?><?= $Page->number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->number->cellAttributes() ?>>
<input type="<?= $Page->number->getInputTextType() ?>" name="x_number" id="x_number" data-table="fin_creditors" data-field="x_number" value="<?= $Page->number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>"<?= $Page->number->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->number->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <div<?= $Page->neighborhood->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_neighborhood"><?= $Page->neighborhood->caption() ?><?= $Page->neighborhood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->neighborhood->cellAttributes() ?>>
<input type="<?= $Page->neighborhood->getInputTextType() ?>" name="x_neighborhood" id="x_neighborhood" data-table="fin_creditors" data-field="x_neighborhood" value="<?= $Page->neighborhood->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->neighborhood->getPlaceHolder()) ?>"<?= $Page->neighborhood->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->neighborhood->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <div<?= $Page->country->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_country"><?= $Page->country->caption() ?><?= $Page->country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->country->cellAttributes() ?>>
<input type="<?= $Page->country->getInputTextType() ?>" name="x_country" id="x_country" data-table="fin_creditors" data-field="x_country" value="<?= $Page->country->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->country->getPlaceHolder()) ?>"<?= $Page->country->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->country->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div<?= $Page->state->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_state"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->state->cellAttributes() ?>>
<input type="<?= $Page->state->getInputTextType() ?>" name="x_state" id="x_state" data-table="fin_creditors" data-field="x_state" value="<?= $Page->state->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>"<?= $Page->state->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <div<?= $Page->city->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_city"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->city->cellAttributes() ?>>
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="fin_creditors" data-field="x_city" value="<?= $Page->city->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>"<?= $Page->city->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telephone1->Visible) { // telephone1 ?>
    <div<?= $Page->telephone1->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_telephone1"><?= $Page->telephone1->caption() ?><?= $Page->telephone1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->telephone1->cellAttributes() ?>>
<input type="<?= $Page->telephone1->getInputTextType() ?>" name="x_telephone1" id="x_telephone1" data-table="fin_creditors" data-field="x_telephone1" value="<?= $Page->telephone1->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telephone1->getPlaceHolder()) ?>"<?= $Page->telephone1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telephone1->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telephone2->Visible) { // telephone2 ?>
    <div<?= $Page->telephone2->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_telephone2"><?= $Page->telephone2->caption() ?><?= $Page->telephone2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->telephone2->cellAttributes() ?>>
<input type="<?= $Page->telephone2->getInputTextType() ?>" name="x_telephone2" id="x_telephone2" data-table="fin_creditors" data-field="x_telephone2" value="<?= $Page->telephone2->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telephone2->getPlaceHolder()) ?>"<?= $Page->telephone2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telephone2->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div<?= $Page->website->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_website"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->website->cellAttributes() ?>>
<input type="<?= $Page->website->getInputTextType() ?>" name="x_website" id="x_website" data-table="fin_creditors" data-field="x_website" value="<?= $Page->website->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>"<?= $Page->website->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email1->Visible) { // email1 ?>
    <div<?= $Page->email1->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_email1"><?= $Page->email1->caption() ?><?= $Page->email1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->email1->cellAttributes() ?>>
<input type="<?= $Page->email1->getInputTextType() ?>" name="x_email1" id="x_email1" data-table="fin_creditors" data-field="x_email1" value="<?= $Page->email1->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->email1->getPlaceHolder()) ?>"<?= $Page->email1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->email1->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email2->Visible) { // email2 ?>
    <div<?= $Page->email2->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_email2"><?= $Page->email2->caption() ?><?= $Page->email2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->email2->cellAttributes() ?>>
<input type="<?= $Page->email2->getInputTextType() ?>" name="x_email2" id="x_email2" data-table="fin_creditors" data-field="x_email2" value="<?= $Page->email2->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->email2->getPlaceHolder()) ?>"<?= $Page->email2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->email2->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div<?= $Page->obs->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_obs"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->obs->cellAttributes() ?>>
<textarea data-table="fin_creditors" data-field="x_obs" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?>><?= $Page->obs->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_register->Visible) { // register ?>
    <div<?= $Page->_register->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x__register"><?= $Page->_register->caption() ?><?= $Page->_register->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->_register->cellAttributes() ?>>
<input type="<?= $Page->_register->getInputTextType() ?>" name="x__register" id="x__register" data-table="fin_creditors" data-field="x__register" value="<?= $Page->_register->EditValue ?>" placeholder="<?= HtmlEncode($Page->_register->getPlaceHolder()) ?>"<?= $Page->_register->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_register->getErrorMessage() ?></div>
<?php if (!$Page->_register->ReadOnly && !$Page->_register->Disabled && !isset($Page->_register->EditAttrs["readonly"]) && !isset($Page->_register->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_creditorsaddopt", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ffin_creditorsaddopt", "x__register", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastupdate->Visible) { // lastupdate ?>
    <input type="hidden" data-table="fin_creditors" data-field="x_lastupdate" data-hidden="1" name="x_lastupdate" id="x_lastupdate" value="<?= HtmlEncode($Page->lastupdate->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
    <div<?= $Page->_default->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->_default->caption() ?><?= $Page->_default->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->_default->cellAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->_default->isInvalidClass() ?>" data-table="fin_creditors" data-field="x__default" name="x__default[]" id="x__default_798048" value="1"<?= ConvertToBool($Page->_default->CurrentValue) ? " checked" : "" ?><?= $Page->_default->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->_default->getErrorMessage() ?></div>
</div>
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
    ew.addEventHandlers("fin_creditors");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
