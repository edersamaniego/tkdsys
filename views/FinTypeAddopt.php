<?php

namespace PHPMaker2022\school;

// Page object
$FinTypeAddopt = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_type: currentTable } });
var currentForm, currentPageID;
var ffin_typeaddopt;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_typeaddopt = new ew.Form("ffin_typeaddopt", "addopt");
    currentPageID = ew.PAGE_ID = "addopt";
    currentForm = ffin_typeaddopt;

    // Add fields
    var fields = currentTable.fields;
    ffin_typeaddopt.addFields([
        ["type", [fields.type.visible && fields.type.required ? ew.Validators.required(fields.type.caption) : null], fields.type.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null], fields._userId.isInvalid],
        ["_register", [fields._register.visible && fields._register.required ? ew.Validators.required(fields._register.caption) : null, ew.Validators.datetime(fields._register.clientFormatPattern)], fields._register.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["organization", [fields.organization.visible && fields.organization.required ? ew.Validators.required(fields.organization.caption) : null], fields.organization.isInvalid],
        ["defaultOrganization", [fields.defaultOrganization.visible && fields.defaultOrganization.required ? ew.Validators.required(fields.defaultOrganization.caption) : null], fields.defaultOrganization.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_typeaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_typeaddopt.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_typeaddopt.lists._userId = <?= $Page->_userId->toClientList($Page) ?>;
    ffin_typeaddopt.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    ffin_typeaddopt.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    ffin_typeaddopt.lists.organization = <?= $Page->organization->toClientList($Page) ?>;
    ffin_typeaddopt.lists.defaultOrganization = <?= $Page->defaultOrganization->toClientList($Page) ?>;
    loadjs.done("ffin_typeaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="ffin_typeaddopt" id="ffin_typeaddopt" class="ew-form" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="fin_type">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->type->Visible) { // type ?>
    <div<?= $Page->type->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x_type"><?= $Page->type->caption() ?><?= $Page->type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->type->cellAttributes() ?>>
<input type="<?= $Page->type->getInputTextType() ?>" name="x_type" id="x_type" data-table="fin_type" data-field="x_type" value="<?= $Page->type->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"<?= $Page->type->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->type->getErrorMessage() ?></div>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <input type="hidden" data-table="fin_type" data-field="x__userId" data-hidden="1" name="x__userId" id="x__userId" value="<?= HtmlEncode($Page->_userId->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->_register->Visible) { // register ?>
    <div<?= $Page->_register->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label" for="x__register"><?= $Page->_register->caption() ?><?= $Page->_register->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->_register->cellAttributes() ?>>
<input type="<?= $Page->_register->getInputTextType() ?>" name="x__register" id="x__register" data-table="fin_type" data-field="x__register" value="<?= $Page->_register->EditValue ?>" placeholder="<?= HtmlEncode($Page->_register->getPlaceHolder()) ?>"<?= $Page->_register->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_register->getErrorMessage() ?></div>
<?php if (!$Page->_register->ReadOnly && !$Page->_register->Disabled && !isset($Page->_register->EditAttrs["readonly"]) && !isset($Page->_register->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_typeaddopt", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_typeaddopt", "x__register", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
    <input type="hidden" data-table="fin_type" data-field="x_lastUpdate" data-hidden="1" name="x_lastUpdate" id="x_lastUpdate" value="<?= HtmlEncode($Page->lastUpdate->CurrentValue) ?>">
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
        data-select2-id="ffin_typeaddopt_x_schoolId"
        data-table="fin_type"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("ffin_typeaddopt", function() {
    var options = { name: "x_schoolId", selectId: "ffin_typeaddopt_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_typeaddopt.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "ffin_typeaddopt" };
    } else {
        options.ajax = { id: "x_schoolId", form: "ffin_typeaddopt", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_type.fields.schoolId.selectOptions);
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
<selection-list hidden class="form-control" data-table="fin_type" data-field="x_schoolId" data-input="sv_x_schoolId" data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>" name="x_schoolId" id="x_schoolId" value="<?= HtmlEncode($Page->schoolId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_typeaddopt", function() {
    ffin_typeaddopt.createAutoSuggest(Object.assign({"id":"x_schoolId","forceSelect":false}, ew.vars.tables.fin_type.fields.schoolId.autoSuggestOptions));
});
</script>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <input type="hidden" data-table="fin_type" data-field="x_masterSchoolId" data-hidden="1" name="x_masterSchoolId" id="x_masterSchoolId" value="<?= HtmlEncode($Page->masterSchoolId->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->organization->Visible) { // organization ?>
    <input type="hidden" data-table="fin_type" data-field="x_organization" data-hidden="1" name="x_organization" id="x_organization" value="<?= HtmlEncode($Page->organization->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->defaultOrganization->Visible) { // defaultOrganization ?>
    <div<?= $Page->defaultOrganization->rowAttributes() ?>>
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->defaultOrganization->caption() ?><?= $Page->defaultOrganization->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10"><div<?= $Page->defaultOrganization->cellAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->defaultOrganization->isInvalidClass() ?>" data-table="fin_type" data-field="x_defaultOrganization" name="x_defaultOrganization[]" id="x_defaultOrganization_974172" value="1"<?= ConvertToBool($Page->defaultOrganization->CurrentValue) ? " checked" : "" ?><?= $Page->defaultOrganization->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->defaultOrganization->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fin_type");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
