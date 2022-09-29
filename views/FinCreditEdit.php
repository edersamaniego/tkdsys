<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_credit: currentTable } });
var currentForm, currentPageID;
var ffin_creditedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditedit = new ew.Form("ffin_creditedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffin_creditedit;

    // Add fields
    var fields = currentTable.fields;
    ffin_creditedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["accountId", [fields.accountId.visible && fields.accountId.required ? ew.Validators.required(fields.accountId.caption) : null, ew.Validators.integer], fields.accountId.isInvalid],
        ["dueDate", [fields.dueDate.visible && fields.dueDate.required ? ew.Validators.required(fields.dueDate.caption) : null, ew.Validators.datetime(fields.dueDate.clientFormatPattern)], fields.dueDate.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["paymentMethod", [fields.paymentMethod.visible && fields.paymentMethod.required ? ew.Validators.required(fields.paymentMethod.caption) : null], fields.paymentMethod.isInvalid],
        ["checkingAccountId", [fields.checkingAccountId.visible && fields.checkingAccountId.required ? ew.Validators.required(fields.checkingAccountId.caption) : null], fields.checkingAccountId.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid],
        ["lastUser", [fields.lastUser.visible && fields.lastUser.required ? ew.Validators.required(fields.lastUser.caption) : null], fields.lastUser.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_creditedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_creditedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_creditedit.lists.accountId = <?= $Page->accountId->toClientList($Page) ?>;
    ffin_creditedit.lists.paymentMethod = <?= $Page->paymentMethod->toClientList($Page) ?>;
    ffin_creditedit.lists.checkingAccountId = <?= $Page->checkingAccountId->toClientList($Page) ?>;
    ffin_creditedit.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    loadjs.done("ffin_creditedit");
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
<form name="ffin_creditedit" id="ffin_creditedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_credit">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fin_accountsreceivable") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fin_accountsreceivable">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->accountId->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "fin_checkingaccount") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fin_checkingaccount">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->accountId->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fin_credit_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_credit_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_credit" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->accountId->Visible) { // accountId ?>
    <div id="r_accountId"<?= $Page->accountId->rowAttributes() ?>>
        <label id="elh_fin_credit_accountId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->accountId->caption() ?><?= $Page->accountId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->accountId->cellAttributes() ?>>
<?php if ($Page->accountId->getSessionValue() != "") { ?>
<span<?= $Page->accountId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->accountId->getDisplayValue($Page->accountId->ViewValue) ?></span></span>
<input type="hidden" id="x_accountId" name="x_accountId" value="<?= HtmlEncode($Page->accountId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fin_credit_accountId">
<?php
$onchange = $Page->accountId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->accountId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->accountId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_accountId" class="ew-auto-suggest">
    <input type="<?= $Page->accountId->getInputTextType() ?>" class="form-control" name="sv_x_accountId" id="sv_x_accountId" value="<?= RemoveHtml($Page->accountId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->accountId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->accountId->getPlaceHolder()) ?>"<?= $Page->accountId->editAttributes() ?> aria-describedby="x_accountId_help">
</span>
<selection-list hidden class="form-control" data-table="fin_credit" data-field="x_accountId" data-input="sv_x_accountId" data-value-separator="<?= $Page->accountId->displayValueSeparatorAttribute() ?>" name="x_accountId" id="x_accountId" value="<?= HtmlEncode($Page->accountId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->accountId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->accountId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_creditedit", function() {
    ffin_creditedit.createAutoSuggest(Object.assign({"id":"x_accountId","forceSelect":false}, ew.vars.tables.fin_credit.fields.accountId.autoSuggestOptions));
});
</script>
<?= $Page->accountId->Lookup->getParamTag($Page, "p_x_accountId") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
    <div id="r_dueDate"<?= $Page->dueDate->rowAttributes() ?>>
        <label id="elh_fin_credit_dueDate" for="x_dueDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dueDate->caption() ?><?= $Page->dueDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dueDate->cellAttributes() ?>>
<span id="el_fin_credit_dueDate">
<input type="<?= $Page->dueDate->getInputTextType() ?>" name="x_dueDate" id="x_dueDate" data-table="fin_credit" data-field="x_dueDate" value="<?= $Page->dueDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->dueDate->getPlaceHolder()) ?>"<?= $Page->dueDate->editAttributes() ?> aria-describedby="x_dueDate_help">
<?= $Page->dueDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dueDate->getErrorMessage() ?></div>
<?php if (!$Page->dueDate->ReadOnly && !$Page->dueDate->Disabled && !isset($Page->dueDate->EditAttrs["readonly"]) && !isset($Page->dueDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_creditedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_creditedit", "x_dueDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_fin_credit_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_credit_value">
<input type="<?= $Page->value->getInputTextType() ?>" name="x_value" id="x_value" data-table="fin_credit" data-field="x_value" value="<?= $Page->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
    <div id="r_paymentMethod"<?= $Page->paymentMethod->rowAttributes() ?>>
        <label id="elh_fin_credit_paymentMethod" for="x_paymentMethod" class="<?= $Page->LeftColumnClass ?>"><?= $Page->paymentMethod->caption() ?><?= $Page->paymentMethod->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->paymentMethod->cellAttributes() ?>>
<span id="el_fin_credit_paymentMethod">
    <select
        id="x_paymentMethod"
        name="x_paymentMethod"
        class="form-select ew-select<?= $Page->paymentMethod->isInvalidClass() ?>"
        data-select2-id="ffin_creditedit_x_paymentMethod"
        data-table="fin_credit"
        data-field="x_paymentMethod"
        data-value-separator="<?= $Page->paymentMethod->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->paymentMethod->getPlaceHolder()) ?>"
        <?= $Page->paymentMethod->editAttributes() ?>>
        <?= $Page->paymentMethod->selectOptionListHtml("x_paymentMethod") ?>
    </select>
    <?= $Page->paymentMethod->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->paymentMethod->getErrorMessage() ?></div>
<?= $Page->paymentMethod->Lookup->getParamTag($Page, "p_x_paymentMethod") ?>
<script>
loadjs.ready("ffin_creditedit", function() {
    var options = { name: "x_paymentMethod", selectId: "ffin_creditedit_x_paymentMethod" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_creditedit.lists.paymentMethod.lookupOptions.length) {
        options.data = { id: "x_paymentMethod", form: "ffin_creditedit" };
    } else {
        options.ajax = { id: "x_paymentMethod", form: "ffin_creditedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_credit.fields.paymentMethod.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
    <div id="r_checkingAccountId"<?= $Page->checkingAccountId->rowAttributes() ?>>
        <label id="elh_fin_credit_checkingAccountId" for="x_checkingAccountId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->checkingAccountId->caption() ?><?= $Page->checkingAccountId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->checkingAccountId->cellAttributes() ?>>
<span id="el_fin_credit_checkingAccountId">
    <select
        id="x_checkingAccountId"
        name="x_checkingAccountId"
        class="form-select ew-select<?= $Page->checkingAccountId->isInvalidClass() ?>"
        data-select2-id="ffin_creditedit_x_checkingAccountId"
        data-table="fin_credit"
        data-field="x_checkingAccountId"
        data-value-separator="<?= $Page->checkingAccountId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->checkingAccountId->getPlaceHolder()) ?>"
        <?= $Page->checkingAccountId->editAttributes() ?>>
        <?= $Page->checkingAccountId->selectOptionListHtml("x_checkingAccountId") ?>
    </select>
    <?= $Page->checkingAccountId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->checkingAccountId->getErrorMessage() ?></div>
<?= $Page->checkingAccountId->Lookup->getParamTag($Page, "p_x_checkingAccountId") ?>
<script>
loadjs.ready("ffin_creditedit", function() {
    var options = { name: "x_checkingAccountId", selectId: "ffin_creditedit_x_checkingAccountId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_creditedit.lists.checkingAccountId.lookupOptions.length) {
        options.data = { id: "x_checkingAccountId", form: "ffin_creditedit" };
    } else {
        options.ajax = { id: "x_checkingAccountId", form: "ffin_creditedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_credit.fields.checkingAccountId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_fin_credit_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_credit_obs">
<textarea data-table="fin_credit" data-field="x_obs" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("fin_credit");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
