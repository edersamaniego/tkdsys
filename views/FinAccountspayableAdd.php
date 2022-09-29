<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountspayableAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountspayable: currentTable } });
var currentForm, currentPageID;
var ffin_accountspayableadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountspayableadd = new ew.Form("ffin_accountspayableadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_accountspayableadd;

    // Add fields
    var fields = currentTable.fields;
    ffin_accountspayableadd.addFields([
        ["departamentId", [fields.departamentId.visible && fields.departamentId.required ? ew.Validators.required(fields.departamentId.caption) : null], fields.departamentId.isInvalid],
        ["costCenterId", [fields.costCenterId.visible && fields.costCenterId.required ? ew.Validators.required(fields.costCenterId.caption) : null], fields.costCenterId.isInvalid],
        ["historic", [fields.historic.visible && fields.historic.required ? ew.Validators.required(fields.historic.caption) : null], fields.historic.isInvalid],
        ["issue", [fields.issue.visible && fields.issue.required ? ew.Validators.required(fields.issue.caption) : null, ew.Validators.datetime(fields.issue.clientFormatPattern)], fields.issue.isInvalid],
        ["due", [fields.due.visible && fields.due.required ? ew.Validators.required(fields.due.caption) : null, ew.Validators.datetime(fields.due.clientFormatPattern)], fields.due.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["employeeId", [fields.employeeId.visible && fields.employeeId.required ? ew.Validators.required(fields.employeeId.caption) : null, ew.Validators.integer], fields.employeeId.isInvalid],
        ["creditorsId", [fields.creditorsId.visible && fields.creditorsId.required ? ew.Validators.required(fields.creditorsId.caption) : null], fields.creditorsId.isInvalid],
        ["typeId", [fields.typeId.visible && fields.typeId.required ? ew.Validators.required(fields.typeId.caption) : null], fields.typeId.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["invoiceFile", [fields.invoiceFile.visible && fields.invoiceFile.required ? ew.Validators.fileRequired(fields.invoiceFile.caption) : null], fields.invoiceFile.isInvalid],
        ["guaranteeFile", [fields.guaranteeFile.visible && fields.guaranteeFile.required ? ew.Validators.fileRequired(fields.guaranteeFile.caption) : null], fields.guaranteeFile.isInvalid],
        ["attachedFile", [fields.attachedFile.visible && fields.attachedFile.required ? ew.Validators.fileRequired(fields.attachedFile.caption) : null], fields.attachedFile.isInvalid],
        ["lastUserId", [fields.lastUserId.visible && fields.lastUserId.required ? ew.Validators.required(fields.lastUserId.caption) : null], fields.lastUserId.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid],
        ["licenseId", [fields.licenseId.visible && fields.licenseId.required ? ew.Validators.required(fields.licenseId.caption) : null, ew.Validators.integer], fields.licenseId.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_accountspayableadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_accountspayableadd.validateRequired = ew.CLIENT_VALIDATE;

    // Multi-Page
    ffin_accountspayableadd.multiPage = new ew.MultiPage("ffin_accountspayableadd");

    // Dynamic selection lists
    ffin_accountspayableadd.lists.departamentId = <?= $Page->departamentId->toClientList($Page) ?>;
    ffin_accountspayableadd.lists.costCenterId = <?= $Page->costCenterId->toClientList($Page) ?>;
    ffin_accountspayableadd.lists.employeeId = <?= $Page->employeeId->toClientList($Page) ?>;
    ffin_accountspayableadd.lists.creditorsId = <?= $Page->creditorsId->toClientList($Page) ?>;
    ffin_accountspayableadd.lists.typeId = <?= $Page->typeId->toClientList($Page) ?>;
    ffin_accountspayableadd.lists.lastUserId = <?= $Page->lastUserId->toClientList($Page) ?>;
    loadjs.done("ffin_accountspayableadd");
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
<form name="ffin_accountspayableadd" id="ffin_accountspayableadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountspayable">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_FinAccountspayableAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_fin_accountspayable1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fin_accountspayable1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_fin_accountspayable2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fin_accountspayable2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_fin_accountspayable1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->departamentId->Visible) { // departamentId ?>
    <div id="r_departamentId"<?= $Page->departamentId->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_departamentId" for="x_departamentId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamentId->caption() ?><?= $Page->departamentId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamentId->cellAttributes() ?>>
<span id="el_fin_accountspayable_departamentId">
    <select
        id="x_departamentId"
        name="x_departamentId"
        class="form-select ew-select<?= $Page->departamentId->isInvalidClass() ?>"
        data-select2-id="ffin_accountspayableadd_x_departamentId"
        data-table="fin_accountspayable"
        data-field="x_departamentId"
        data-page="1"
        data-value-separator="<?= $Page->departamentId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentId->getPlaceHolder()) ?>"
        <?= $Page->departamentId->editAttributes() ?>>
        <?= $Page->departamentId->selectOptionListHtml("x_departamentId") ?>
    </select>
    <?= $Page->departamentId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->departamentId->getErrorMessage() ?></div>
<?= $Page->departamentId->Lookup->getParamTag($Page, "p_x_departamentId") ?>
<script>
loadjs.ready("ffin_accountspayableadd", function() {
    var options = { name: "x_departamentId", selectId: "ffin_accountspayableadd_x_departamentId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_accountspayableadd.lists.departamentId.lookupOptions.length) {
        options.data = { id: "x_departamentId", form: "ffin_accountspayableadd" };
    } else {
        options.ajax = { id: "x_departamentId", form: "ffin_accountspayableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_accountspayable.fields.departamentId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costCenterId->Visible) { // costCenterId ?>
    <div id="r_costCenterId"<?= $Page->costCenterId->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_costCenterId" for="x_costCenterId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costCenterId->caption() ?><?= $Page->costCenterId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costCenterId->cellAttributes() ?>>
<span id="el_fin_accountspayable_costCenterId">
    <select
        id="x_costCenterId"
        name="x_costCenterId"
        class="form-select ew-select<?= $Page->costCenterId->isInvalidClass() ?>"
        data-select2-id="ffin_accountspayableadd_x_costCenterId"
        data-table="fin_accountspayable"
        data-field="x_costCenterId"
        data-page="1"
        data-value-separator="<?= $Page->costCenterId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->costCenterId->getPlaceHolder()) ?>"
        <?= $Page->costCenterId->editAttributes() ?>>
        <?= $Page->costCenterId->selectOptionListHtml("x_costCenterId") ?>
    </select>
    <?= $Page->costCenterId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->costCenterId->getErrorMessage() ?></div>
<?= $Page->costCenterId->Lookup->getParamTag($Page, "p_x_costCenterId") ?>
<script>
loadjs.ready("ffin_accountspayableadd", function() {
    var options = { name: "x_costCenterId", selectId: "ffin_accountspayableadd_x_costCenterId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_accountspayableadd.lists.costCenterId.lookupOptions.length) {
        options.data = { id: "x_costCenterId", form: "ffin_accountspayableadd" };
    } else {
        options.ajax = { id: "x_costCenterId", form: "ffin_accountspayableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_accountspayable.fields.costCenterId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
    <div id="r_historic"<?= $Page->historic->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_historic" for="x_historic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->historic->caption() ?><?= $Page->historic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->historic->cellAttributes() ?>>
<span id="el_fin_accountspayable_historic">
<input type="<?= $Page->historic->getInputTextType() ?>" name="x_historic" id="x_historic" data-table="fin_accountspayable" data-field="x_historic" value="<?= $Page->historic->EditValue ?>" data-page="1" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->historic->getPlaceHolder()) ?>"<?= $Page->historic->editAttributes() ?> aria-describedby="x_historic_help">
<?= $Page->historic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->historic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
    <div id="r_issue"<?= $Page->issue->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_issue" for="x_issue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->issue->caption() ?><?= $Page->issue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->issue->cellAttributes() ?>>
<span id="el_fin_accountspayable_issue">
<input type="<?= $Page->issue->getInputTextType() ?>" name="x_issue" id="x_issue" data-table="fin_accountspayable" data-field="x_issue" value="<?= $Page->issue->EditValue ?>" data-page="1" placeholder="<?= HtmlEncode($Page->issue->getPlaceHolder()) ?>"<?= $Page->issue->editAttributes() ?> aria-describedby="x_issue_help">
<?= $Page->issue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->issue->getErrorMessage() ?></div>
<?php if (!$Page->issue->ReadOnly && !$Page->issue->Disabled && !isset($Page->issue->EditAttrs["readonly"]) && !isset($Page->issue->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_accountspayableadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountspayableadd", "x_issue", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
    <div id="r_due"<?= $Page->due->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_due" for="x_due" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due->caption() ?><?= $Page->due->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due->cellAttributes() ?>>
<span id="el_fin_accountspayable_due">
<input type="<?= $Page->due->getInputTextType() ?>" name="x_due" id="x_due" data-table="fin_accountspayable" data-field="x_due" value="<?= $Page->due->EditValue ?>" data-page="1" placeholder="<?= HtmlEncode($Page->due->getPlaceHolder()) ?>"<?= $Page->due->editAttributes() ?> aria-describedby="x_due_help">
<?= $Page->due->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due->getErrorMessage() ?></div>
<?php if (!$Page->due->ReadOnly && !$Page->due->Disabled && !isset($Page->due->EditAttrs["readonly"]) && !isset($Page->due->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_accountspayableadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountspayableadd", "x_due", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_accountspayable_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="fin_accountspayable" data-field="x_value" value="<?= $Page->value->EditValue ?>" data-page="1" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->employeeId->Visible) { // employeeId ?>
    <div id="r_employeeId"<?= $Page->employeeId->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_employeeId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->employeeId->caption() ?><?= $Page->employeeId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->employeeId->cellAttributes() ?>>
<span id="el_fin_accountspayable_employeeId">
    <select
        id="x_employeeId"
        name="x_employeeId"
        class="form-control ew-select<?= $Page->employeeId->isInvalidClass() ?>"
        data-select2-id="ffin_accountspayableadd_x_employeeId"
        data-table="fin_accountspayable"
        data-field="x_employeeId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->employeeId->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->employeeId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->employeeId->getPlaceHolder()) ?>"
        <?= $Page->employeeId->editAttributes() ?>>
        <?= $Page->employeeId->selectOptionListHtml("x_employeeId") ?>
    </select>
    <?= $Page->employeeId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->employeeId->getErrorMessage() ?></div>
<?= $Page->employeeId->Lookup->getParamTag($Page, "p_x_employeeId") ?>
<script>
loadjs.ready("ffin_accountspayableadd", function() {
    var options = { name: "x_employeeId", selectId: "ffin_accountspayableadd_x_employeeId" };
    if (ffin_accountspayableadd.lists.employeeId.lookupOptions.length) {
        options.data = { id: "x_employeeId", form: "ffin_accountspayableadd" };
    } else {
        options.ajax = { id: "x_employeeId", form: "ffin_accountspayableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.fin_accountspayable.fields.employeeId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->creditorsId->Visible) { // creditorsId ?>
    <div id="r_creditorsId"<?= $Page->creditorsId->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_creditorsId" for="x_creditorsId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->creditorsId->caption() ?><?= $Page->creditorsId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->creditorsId->cellAttributes() ?>>
<span id="el_fin_accountspayable_creditorsId">
<div class="input-group flex-nowrap">
    <select
        id="x_creditorsId"
        name="x_creditorsId"
        class="form-control ew-select<?= $Page->creditorsId->isInvalidClass() ?>"
        data-select2-id="ffin_accountspayableadd_x_creditorsId"
        data-table="fin_accountspayable"
        data-field="x_creditorsId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->creditorsId->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->creditorsId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->creditorsId->getPlaceHolder()) ?>"
        <?= $Page->creditorsId->editAttributes() ?>>
        <?= $Page->creditorsId->selectOptionListHtml("x_creditorsId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "fin_creditors") && !$Page->creditorsId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_creditorsId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->creditorsId->caption() ?>" data-title="<?= $Page->creditorsId->caption() ?>" data-ew-action="add-option" data-el="x_creditorsId" data-url="<?= GetUrl("FinCreditorsAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->creditorsId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->creditorsId->getErrorMessage() ?></div>
<?= $Page->creditorsId->Lookup->getParamTag($Page, "p_x_creditorsId") ?>
<script>
loadjs.ready("ffin_accountspayableadd", function() {
    var options = { name: "x_creditorsId", selectId: "ffin_accountspayableadd_x_creditorsId" };
    if (ffin_accountspayableadd.lists.creditorsId.lookupOptions.length) {
        options.data = { id: "x_creditorsId", form: "ffin_accountspayableadd" };
    } else {
        options.ajax = { id: "x_creditorsId", form: "ffin_accountspayableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.fin_accountspayable.fields.creditorsId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
    <div id="r_typeId"<?= $Page->typeId->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_typeId" for="x_typeId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->typeId->caption() ?><?= $Page->typeId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->typeId->cellAttributes() ?>>
<span id="el_fin_accountspayable_typeId">
<div class="input-group flex-nowrap">
    <select
        id="x_typeId"
        name="x_typeId"
        class="form-select ew-select<?= $Page->typeId->isInvalidClass() ?>"
        data-select2-id="ffin_accountspayableadd_x_typeId"
        data-table="fin_accountspayable"
        data-field="x_typeId"
        data-page="1"
        data-value-separator="<?= $Page->typeId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->typeId->getPlaceHolder()) ?>"
        <?= $Page->typeId->editAttributes() ?>>
        <?= $Page->typeId->selectOptionListHtml("x_typeId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "fin_type") && !$Page->typeId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_typeId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->typeId->caption() ?>" data-title="<?= $Page->typeId->caption() ?>" data-ew-action="add-option" data-el="x_typeId" data-url="<?= GetUrl("FinTypeAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->typeId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->typeId->getErrorMessage() ?></div>
<?= $Page->typeId->Lookup->getParamTag($Page, "p_x_typeId") ?>
<script>
loadjs.ready("ffin_accountspayableadd", function() {
    var options = { name: "x_typeId", selectId: "ffin_accountspayableadd_x_typeId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_accountspayableadd.lists.typeId.lookupOptions.length) {
        options.data = { id: "x_typeId", form: "ffin_accountspayableadd" };
    } else {
        options.ajax = { id: "x_typeId", form: "ffin_accountspayableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_accountspayable.fields.typeId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_accountspayable_obs">
<textarea data-table="fin_accountspayable" data-field="x_obs" data-page="1" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
    <div id="r_licenseId"<?= $Page->licenseId->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_licenseId" for="x_licenseId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->licenseId->caption() ?><?= $Page->licenseId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->licenseId->cellAttributes() ?>>
<span id="el_fin_accountspayable_licenseId">
<input type="<?= $Page->licenseId->getInputTextType() ?>" name="x_licenseId" id="x_licenseId" data-table="fin_accountspayable" data-field="x_licenseId" value="<?= $Page->licenseId->EditValue ?>" data-page="1" size="30" placeholder="<?= HtmlEncode($Page->licenseId->getPlaceHolder()) ?>"<?= $Page->licenseId->editAttributes() ?> aria-describedby="x_licenseId_help">
<?= $Page->licenseId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->licenseId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_fin_accountspayable2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->invoiceFile->Visible) { // invoiceFile ?>
    <div id="r_invoiceFile"<?= $Page->invoiceFile->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_invoiceFile" class="<?= $Page->LeftColumnClass ?>"><?= $Page->invoiceFile->caption() ?><?= $Page->invoiceFile->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->invoiceFile->cellAttributes() ?>>
<span id="el_fin_accountspayable_invoiceFile">
<div id="fd_x_invoiceFile" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->invoiceFile->title() ?>" data-table="fin_accountspayable" data-field="x_invoiceFile" data-page="2" name="x_invoiceFile" id="x_invoiceFile" lang="<?= CurrentLanguageID() ?>"<?= $Page->invoiceFile->editAttributes() ?> aria-describedby="x_invoiceFile_help"<?= ($Page->invoiceFile->ReadOnly || $Page->invoiceFile->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->invoiceFile->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->invoiceFile->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_invoiceFile" id= "fn_x_invoiceFile" value="<?= $Page->invoiceFile->Upload->FileName ?>">
<input type="hidden" name="fa_x_invoiceFile" id= "fa_x_invoiceFile" value="0">
<input type="hidden" name="fs_x_invoiceFile" id= "fs_x_invoiceFile" value="255">
<input type="hidden" name="fx_x_invoiceFile" id= "fx_x_invoiceFile" value="<?= $Page->invoiceFile->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_invoiceFile" id= "fm_x_invoiceFile" value="<?= $Page->invoiceFile->UploadMaxFileSize ?>">
<table id="ft_x_invoiceFile" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->guaranteeFile->Visible) { // guaranteeFile ?>
    <div id="r_guaranteeFile"<?= $Page->guaranteeFile->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_guaranteeFile" class="<?= $Page->LeftColumnClass ?>"><?= $Page->guaranteeFile->caption() ?><?= $Page->guaranteeFile->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->guaranteeFile->cellAttributes() ?>>
<span id="el_fin_accountspayable_guaranteeFile">
<div id="fd_x_guaranteeFile" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->guaranteeFile->title() ?>" data-table="fin_accountspayable" data-field="x_guaranteeFile" data-page="2" name="x_guaranteeFile" id="x_guaranteeFile" lang="<?= CurrentLanguageID() ?>"<?= $Page->guaranteeFile->editAttributes() ?> aria-describedby="x_guaranteeFile_help"<?= ($Page->guaranteeFile->ReadOnly || $Page->guaranteeFile->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->guaranteeFile->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->guaranteeFile->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_guaranteeFile" id= "fn_x_guaranteeFile" value="<?= $Page->guaranteeFile->Upload->FileName ?>">
<input type="hidden" name="fa_x_guaranteeFile" id= "fa_x_guaranteeFile" value="0">
<input type="hidden" name="fs_x_guaranteeFile" id= "fs_x_guaranteeFile" value="255">
<input type="hidden" name="fx_x_guaranteeFile" id= "fx_x_guaranteeFile" value="<?= $Page->guaranteeFile->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_guaranteeFile" id= "fm_x_guaranteeFile" value="<?= $Page->guaranteeFile->UploadMaxFileSize ?>">
<table id="ft_x_guaranteeFile" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->attachedFile->Visible) { // attachedFile ?>
    <div id="r_attachedFile"<?= $Page->attachedFile->rowAttributes() ?>>
        <label id="elh_fin_accountspayable_attachedFile" class="<?= $Page->LeftColumnClass ?>"><?= $Page->attachedFile->caption() ?><?= $Page->attachedFile->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->attachedFile->cellAttributes() ?>>
<span id="el_fin_accountspayable_attachedFile">
<div id="fd_x_attachedFile" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->attachedFile->title() ?>" data-table="fin_accountspayable" data-field="x_attachedFile" data-page="2" name="x_attachedFile" id="x_attachedFile" lang="<?= CurrentLanguageID() ?>"<?= $Page->attachedFile->editAttributes() ?> aria-describedby="x_attachedFile_help"<?= ($Page->attachedFile->ReadOnly || $Page->attachedFile->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->attachedFile->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->attachedFile->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_attachedFile" id= "fn_x_attachedFile" value="<?= $Page->attachedFile->Upload->FileName ?>">
<input type="hidden" name="fa_x_attachedFile" id= "fa_x_attachedFile" value="0">
<input type="hidden" name="fs_x_attachedFile" id= "fs_x_attachedFile" value="255">
<input type="hidden" name="fx_x_attachedFile" id= "fx_x_attachedFile" value="<?= $Page->attachedFile->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_attachedFile" id= "fm_x_attachedFile" value="<?= $Page->attachedFile->UploadMaxFileSize ?>">
<table id="ft_x_attachedFile" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?php
    if (in_array("fin_debit", explode(",", $Page->getCurrentDetailTable())) && $fin_debit->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_debit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinDebitGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("fin_accountspayable");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
