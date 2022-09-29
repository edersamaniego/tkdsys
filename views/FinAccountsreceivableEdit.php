<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountsreceivableEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountsreceivable: currentTable } });
var currentForm, currentPageID;
var ffin_accountsreceivableedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountsreceivableedit = new ew.Form("ffin_accountsreceivableedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffin_accountsreceivableedit;

    // Add fields
    var fields = currentTable.fields;
    ffin_accountsreceivableedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["issue", [fields.issue.visible && fields.issue.required ? ew.Validators.required(fields.issue.caption) : null, ew.Validators.datetime(fields.issue.clientFormatPattern)], fields.issue.isInvalid],
        ["due", [fields.due.visible && fields.due.required ? ew.Validators.required(fields.due.caption) : null, ew.Validators.datetime(fields.due.clientFormatPattern)], fields.due.isInvalid],
        ["historic", [fields.historic.visible && fields.historic.required ? ew.Validators.required(fields.historic.caption) : null], fields.historic.isInvalid],
        ["income", [fields.income.visible && fields.income.required ? ew.Validators.required(fields.income.caption) : null], fields.income.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["balance", [fields.balance.visible && fields.balance.required ? ew.Validators.required(fields.balance.caption) : null], fields.balance.isInvalid],
        ["debtorId", [fields.debtorId.visible && fields.debtorId.required ? ew.Validators.required(fields.debtorId.caption) : null, ew.Validators.integer], fields.debtorId.isInvalid],
        ["lastUserId", [fields.lastUserId.visible && fields.lastUserId.required ? ew.Validators.required(fields.lastUserId.caption) : null], fields.lastUserId.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid],
        ["licenseId", [fields.licenseId.visible && fields.licenseId.required ? ew.Validators.required(fields.licenseId.caption) : null, ew.Validators.integer], fields.licenseId.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_accountsreceivableedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_accountsreceivableedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_accountsreceivableedit.lists.income = <?= $Page->income->toClientList($Page) ?>;
    ffin_accountsreceivableedit.lists.debtorId = <?= $Page->debtorId->toClientList($Page) ?>;
    ffin_accountsreceivableedit.lists.lastUserId = <?= $Page->lastUserId->toClientList($Page) ?>;
    loadjs.done("ffin_accountsreceivableedit");
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
<?php if (!$Page->IsModal) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<form name="ffin_accountsreceivableedit" id="ffin_accountsreceivableedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountsreceivable">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_accountsreceivable" data-field="x_id" data-hidden="1" data-page="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
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
loadjs.ready(["ffin_accountsreceivableedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountsreceivableedit", "x_issue", ew.deepAssign({"useCurrent":false}, options));
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
loadjs.ready(["ffin_accountsreceivableedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountsreceivableedit", "x_due", ew.deepAssign({"useCurrent":false}, options));
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
        data-select2-id="ffin_accountsreceivableedit_x_income"
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
loadjs.ready("ffin_accountsreceivableedit", function() {
    var options = { name: "x_income", selectId: "ffin_accountsreceivableedit_x_income" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_accountsreceivableedit.lists.income.lookupOptions.length) {
        options.data = { id: "x_income", form: "ffin_accountsreceivableedit" };
    } else {
        options.ajax = { id: "x_income", form: "ffin_accountsreceivableedit", limit: ew.LOOKUP_PAGE_SIZE };
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
<?php if ($Page->balance->Visible) { // balance ?>
    <div id="r_balance"<?= $Page->balance->rowAttributes() ?>>
        <label id="elh_fin_accountsreceivable_balance" for="x_balance" class="<?= $Page->LeftColumnClass ?>"><?= $Page->balance->caption() ?><?= $Page->balance->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->balance->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_balance">
<span<?= $Page->balance->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->balance->getDisplayValue($Page->balance->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_accountsreceivable" data-field="x_balance" data-hidden="1" data-page="1" name="x_balance" id="x_balance" value="<?= HtmlEncode($Page->balance->CurrentValue) ?>">
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
        data-select2-id="ffin_accountsreceivableedit_x_debtorId"
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
loadjs.ready("ffin_accountsreceivableedit", function() {
    var options = { name: "x_debtorId", selectId: "ffin_accountsreceivableedit_x_debtorId" };
    if (ffin_accountsreceivableedit.lists.debtorId.lookupOptions.length) {
        options.data = { id: "x_debtorId", form: "ffin_accountsreceivableedit" };
    } else {
        options.ajax = { id: "x_debtorId", form: "ffin_accountsreceivableedit", limit: ew.LOOKUP_PAGE_SIZE };
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
    if (in_array("fin_credit", explode(",", $Page->getCurrentDetailTable())) && $fin_credit->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_credit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinCreditGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
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
