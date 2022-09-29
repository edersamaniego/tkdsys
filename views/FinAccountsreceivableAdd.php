<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountsreceivableAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountsreceivable: currentTable } });
var currentForm, currentPageID;
var ffin_accountsreceivableadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountsreceivableadd = new ew.Form("ffin_accountsreceivableadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_accountsreceivableadd;

    // Add fields
    var fields = currentTable.fields;
    ffin_accountsreceivableadd.addFields([
        ["issue", [fields.issue.visible && fields.issue.required ? ew.Validators.required(fields.issue.caption) : null, ew.Validators.datetime(fields.issue.clientFormatPattern)], fields.issue.isInvalid],
        ["due", [fields.due.visible && fields.due.required ? ew.Validators.required(fields.due.caption) : null, ew.Validators.datetime(fields.due.clientFormatPattern)], fields.due.isInvalid],
        ["historic", [fields.historic.visible && fields.historic.required ? ew.Validators.required(fields.historic.caption) : null], fields.historic.isInvalid],
        ["income", [fields.income.visible && fields.income.required ? ew.Validators.required(fields.income.caption) : null], fields.income.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["orderId", [fields.orderId.visible && fields.orderId.required ? ew.Validators.required(fields.orderId.caption) : null, ew.Validators.integer], fields.orderId.isInvalid],
        ["debtorId", [fields.debtorId.visible && fields.debtorId.required ? ew.Validators.required(fields.debtorId.caption) : null, ew.Validators.integer], fields.debtorId.isInvalid],
        ["lastUserId", [fields.lastUserId.visible && fields.lastUserId.required ? ew.Validators.required(fields.lastUserId.caption) : null], fields.lastUserId.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid],
        ["licenseId", [fields.licenseId.visible && fields.licenseId.required ? ew.Validators.required(fields.licenseId.caption) : null, ew.Validators.integer], fields.licenseId.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_accountsreceivableadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_accountsreceivableadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_accountsreceivableadd.lists.income = <?= $Page->income->toClientList($Page) ?>;
    ffin_accountsreceivableadd.lists.orderId = <?= $Page->orderId->toClientList($Page) ?>;
    ffin_accountsreceivableadd.lists.debtorId = <?= $Page->debtorId->toClientList($Page) ?>;
    ffin_accountsreceivableadd.lists.lastUserId = <?= $Page->lastUserId->toClientList($Page) ?>;
    loadjs.done("ffin_accountsreceivableadd");
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
<form name="ffin_accountsreceivableadd" id="ffin_accountsreceivableadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountsreceivable">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->issue->Visible) { // issue ?>
    <div id="r_issue"<?= $Page->issue->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_issue" for="x_issue" class="<?= $Page->LeftColumnClass ?>"><?= $Page->issue->caption() ?><?= $Page->issue->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->issue->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_issue">
<input type="<?= $Page->issue->getInputTextType() ?>" name="x_issue" id="x_issue" data-table="fin_accountsreceivable" data-field="x_issue" value="<?= $Page->issue->EditValue ?>" data-page="1" placeholder="<?= HtmlEncode($Page->issue->getPlaceHolder()) ?>"<?= $Page->issue->editAttributes() ?> aria-describedby="x_issue_help">
<?= $Page->issue->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->issue->getErrorMessage() ?></div>
<?php if (!$Page->issue->ReadOnly && !$Page->issue->Disabled && !isset($Page->issue->EditAttrs["readonly"]) && !isset($Page->issue->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_accountsreceivableadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountsreceivableadd", "x_issue", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
    <div id="r_due"<?= $Page->due->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_due" for="x_due" class="<?= $Page->LeftColumnClass ?>"><?= $Page->due->caption() ?><?= $Page->due->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->due->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_due">
<input type="<?= $Page->due->getInputTextType() ?>" name="x_due" id="x_due" data-table="fin_accountsreceivable" data-field="x_due" value="<?= $Page->due->EditValue ?>" data-page="1" placeholder="<?= HtmlEncode($Page->due->getPlaceHolder()) ?>"<?= $Page->due->editAttributes() ?> aria-describedby="x_due_help">
<?= $Page->due->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->due->getErrorMessage() ?></div>
<?php if (!$Page->due->ReadOnly && !$Page->due->Disabled && !isset($Page->due->EditAttrs["readonly"]) && !isset($Page->due->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_accountsreceivableadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountsreceivableadd", "x_due", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
    <div id="r_historic"<?= $Page->historic->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_historic" for="x_historic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->historic->caption() ?><?= $Page->historic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->historic->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_historic">
<input type="<?= $Page->historic->getInputTextType() ?>" name="x_historic" id="x_historic" data-table="fin_accountsreceivable" data-field="x_historic" value="<?= $Page->historic->EditValue ?>" data-page="1" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->historic->getPlaceHolder()) ?>"<?= $Page->historic->editAttributes() ?> aria-describedby="x_historic_help">
<?= $Page->historic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->historic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
    <div id="r_income"<?= $Page->income->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_income" for="x_income" class="<?= $Page->LeftColumnClass ?>"><?= $Page->income->caption() ?><?= $Page->income->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->income->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_income">
    <select
        id="x_income"
        name="x_income"
        class="form-select ew-select<?= $Page->income->isInvalidClass() ?>"
        data-select2-id="ffin_accountsreceivableadd_x_income"
        data-table="fin_accountsreceivable"
        data-field="x_income"
        data-page="1"
        data-value-separator="<?= $Page->income->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->income->getPlaceHolder()) ?>"
        <?= $Page->income->editAttributes() ?>>
        <?= $Page->income->selectOptionListHtml("x_income") ?>
    </select>
    <?= $Page->income->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->income->getErrorMessage() ?></div>
<?= $Page->income->Lookup->getParamTag($Page, "p_x_income") ?>
<script>
loadjs.ready("ffin_accountsreceivableadd", function() {
    var options = { name: "x_income", selectId: "ffin_accountsreceivableadd_x_income" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_accountsreceivableadd.lists.income.lookupOptions.length) {
        options.data = { id: "x_income", form: "ffin_accountsreceivableadd" };
    } else {
        options.ajax = { id: "x_income", form: "ffin_accountsreceivableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_accountsreceivable.fields.income.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_obs">
<textarea data-table="fin_accountsreceivable" data-field="x_obs" data-page="1" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="fin_accountsreceivable" data-field="x_value" value="<?= $Page->value->EditValue ?>" data-page="1" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderId->Visible) { // orderId ?>
    <div id="r_orderId"<?= $Page->orderId->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_orderId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderId->caption() ?><?= $Page->orderId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->orderId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_orderId">
    <select
        id="x_orderId"
        name="x_orderId"
        class="form-control ew-select<?= $Page->orderId->isInvalidClass() ?>"
        data-select2-id="ffin_accountsreceivableadd_x_orderId"
        data-table="fin_accountsreceivable"
        data-field="x_orderId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->orderId->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->orderId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->orderId->getPlaceHolder()) ?>"
        <?= $Page->orderId->editAttributes() ?>>
        <?= $Page->orderId->selectOptionListHtml("x_orderId") ?>
    </select>
    <?= $Page->orderId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->orderId->getErrorMessage() ?></div>
<?= $Page->orderId->Lookup->getParamTag($Page, "p_x_orderId") ?>
<script>
loadjs.ready("ffin_accountsreceivableadd", function() {
    var options = { name: "x_orderId", selectId: "ffin_accountsreceivableadd_x_orderId" };
    if (ffin_accountsreceivableadd.lists.orderId.lookupOptions.length) {
        options.data = { id: "x_orderId", form: "ffin_accountsreceivableadd" };
    } else {
        options.ajax = { id: "x_orderId", form: "ffin_accountsreceivableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.fin_accountsreceivable.fields.orderId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->debtorId->Visible) { // debtorId ?>
    <div id="r_debtorId"<?= $Page->debtorId->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_debtorId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->debtorId->caption() ?><?= $Page->debtorId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->debtorId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_debtorId">
    <select
        id="x_debtorId"
        name="x_debtorId"
        class="form-control ew-select<?= $Page->debtorId->isInvalidClass() ?>"
        data-select2-id="ffin_accountsreceivableadd_x_debtorId"
        data-table="fin_accountsreceivable"
        data-field="x_debtorId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->debtorId->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->debtorId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->debtorId->getPlaceHolder()) ?>"
        <?= $Page->debtorId->editAttributes() ?>>
        <?= $Page->debtorId->selectOptionListHtml("x_debtorId") ?>
    </select>
    <?= $Page->debtorId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->debtorId->getErrorMessage() ?></div>
<?= $Page->debtorId->Lookup->getParamTag($Page, "p_x_debtorId") ?>
<script>
loadjs.ready("ffin_accountsreceivableadd", function() {
    var options = { name: "x_debtorId", selectId: "ffin_accountsreceivableadd_x_debtorId" };
    if (ffin_accountsreceivableadd.lists.debtorId.lookupOptions.length) {
        options.data = { id: "x_debtorId", form: "ffin_accountsreceivableadd" };
    } else {
        options.ajax = { id: "x_debtorId", form: "ffin_accountsreceivableadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.fin_accountsreceivable.fields.debtorId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
    <div id="r_licenseId"<?= $Page->licenseId->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_licenseId" for="x_licenseId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->licenseId->caption() ?><?= $Page->licenseId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->licenseId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_licenseId">
<input type="<?= $Page->licenseId->getInputTextType() ?>" name="x_licenseId" id="x_licenseId" data-table="fin_accountsreceivable" data-field="x_licenseId" value="<?= $Page->licenseId->EditValue ?>" data-page="1" size="30" placeholder="<?= HtmlEncode($Page->licenseId->getPlaceHolder()) ?>"<?= $Page->licenseId->editAttributes() ?> aria-describedby="x_licenseId_help">
<?= $Page->licenseId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->licenseId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("fin_credit", explode(",", $Page->getCurrentDetailTable())) && $fin_credit->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_credit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinCreditGrid.php" ?>
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
    ew.addEventHandlers("fin_accountsreceivable");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
