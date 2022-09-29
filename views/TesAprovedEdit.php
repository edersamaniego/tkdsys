<?php

namespace PHPMaker2022\school;

// Page object
$TesAprovedEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_aproved: currentTable } });
var currentForm, currentPageID;
var ftes_aprovededit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_aprovededit = new ew.Form("ftes_aprovededit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ftes_aprovededit;

    // Add fields
    var fields = currentTable.fields;
    ftes_aprovededit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["resultAmountId", [fields.resultAmountId.visible && fields.resultAmountId.required ? ew.Validators.required(fields.resultAmountId.caption) : null, ew.Validators.integer], fields.resultAmountId.isInvalid],
        ["federationId", [fields.federationId.visible && fields.federationId.required ? ew.Validators.required(fields.federationId.caption) : null, ew.Validators.integer], fields.federationId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid],
        ["testId", [fields.testId.visible && fields.testId.required ? ew.Validators.required(fields.testId.caption) : null, ew.Validators.integer], fields.testId.isInvalid],
        ["memberId", [fields.memberId.visible && fields.memberId.required ? ew.Validators.required(fields.memberId.caption) : null, ew.Validators.integer], fields.memberId.isInvalid],
        ["memberName", [fields.memberName.visible && fields.memberName.required ? ew.Validators.required(fields.memberName.caption) : null], fields.memberName.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid],
        ["newRankId", [fields.newRankId.visible && fields.newRankId.required ? ew.Validators.required(fields.newRankId.caption) : null, ew.Validators.integer], fields.newRankId.isInvalid],
        ["oldRankId", [fields.oldRankId.visible && fields.oldRankId.required ? ew.Validators.required(fields.oldRankId.caption) : null, ew.Validators.integer], fields.oldRankId.isInvalid]
    ]);

    // Form_CustomValidate
    ftes_aprovededit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_aprovededit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ftes_aprovededit");
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
<form name="ftes_aprovededit" id="ftes_aprovededit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_aproved">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_tes_aproved_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_aproved_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="tes_aproved" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->resultAmountId->Visible) { // resultAmountId ?>
    <div id="r_resultAmountId"<?= $Page->resultAmountId->rowAttributes() ?>>
        <label id="elh_tes_aproved_resultAmountId" for="x_resultAmountId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->resultAmountId->caption() ?><?= $Page->resultAmountId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->resultAmountId->cellAttributes() ?>>
<span id="el_tes_aproved_resultAmountId">
<input type="<?= $Page->resultAmountId->getInputTextType() ?>" name="x_resultAmountId" id="x_resultAmountId" data-table="tes_aproved" data-field="x_resultAmountId" value="<?= $Page->resultAmountId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->resultAmountId->getPlaceHolder()) ?>"<?= $Page->resultAmountId->editAttributes() ?> aria-describedby="x_resultAmountId_help">
<?= $Page->resultAmountId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->resultAmountId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <div id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <label id="elh_tes_aproved_federationId" for="x_federationId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationId->caption() ?><?= $Page->federationId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationId->cellAttributes() ?>>
<span id="el_tes_aproved_federationId">
<input type="<?= $Page->federationId->getInputTextType() ?>" name="x_federationId" id="x_federationId" data-table="tes_aproved" data-field="x_federationId" value="<?= $Page->federationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->federationId->getPlaceHolder()) ?>"<?= $Page->federationId->editAttributes() ?> aria-describedby="x_federationId_help">
<?= $Page->federationId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_tes_aproved_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("edit")) { // Non system admin ?>
<span id="el_tes_aproved_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-select ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="ftes_aprovededit_x_schoolId"
        data-table="tes_aproved"
        data-field="x_schoolId"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_aprovededit", function() {
    var options = { name: "x_schoolId", selectId: "ftes_aprovededit_x_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_aprovededit.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "ftes_aprovededit" };
    } else {
        options.ajax = { id: "x_schoolId", form: "ftes_aprovededit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_aproved.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_tes_aproved_schoolId">
<input type="<?= $Page->schoolId->getInputTextType() ?>" name="x_schoolId" id="x_schoolId" data-table="tes_aproved" data-field="x_schoolId" value="<?= $Page->schoolId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"<?= $Page->schoolId->editAttributes() ?> aria-describedby="x_schoolId_help">
<?= $Page->schoolId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <div id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <label id="elh_tes_aproved_testId" for="x_testId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testId->caption() ?><?= $Page->testId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_aproved_testId">
<input type="<?= $Page->testId->getInputTextType() ?>" name="x_testId" id="x_testId" data-table="tes_aproved" data-field="x_testId" value="<?= $Page->testId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->testId->getPlaceHolder()) ?>"<?= $Page->testId->editAttributes() ?> aria-describedby="x_testId_help">
<?= $Page->testId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
    <div id="r_memberId"<?= $Page->memberId->rowAttributes() ?>>
        <label id="elh_tes_aproved_memberId" for="x_memberId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->memberId->caption() ?><?= $Page->memberId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->memberId->cellAttributes() ?>>
<span id="el_tes_aproved_memberId">
<input type="<?= $Page->memberId->getInputTextType() ?>" name="x_memberId" id="x_memberId" data-table="tes_aproved" data-field="x_memberId" value="<?= $Page->memberId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>"<?= $Page->memberId->editAttributes() ?> aria-describedby="x_memberId_help">
<?= $Page->memberId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->memberName->Visible) { // memberName ?>
    <div id="r_memberName"<?= $Page->memberName->rowAttributes() ?>>
        <label id="elh_tes_aproved_memberName" for="x_memberName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->memberName->caption() ?><?= $Page->memberName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->memberName->cellAttributes() ?>>
<span id="el_tes_aproved_memberName">
<input type="<?= $Page->memberName->getInputTextType() ?>" name="x_memberName" id="x_memberName" data-table="tes_aproved" data-field="x_memberName" value="<?= $Page->memberName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->memberName->getPlaceHolder()) ?>"<?= $Page->memberName->editAttributes() ?> aria-describedby="x_memberName_help">
<?= $Page->memberName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->memberName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_tes_aproved_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_tes_aproved_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="tes_aproved" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_tes_aproved_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_tes_aproved_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="tes_aproved" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_aprovededit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ftes_aprovededit", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->newRankId->Visible) { // newRankId ?>
    <div id="r_newRankId"<?= $Page->newRankId->rowAttributes() ?>>
        <label id="elh_tes_aproved_newRankId" for="x_newRankId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->newRankId->caption() ?><?= $Page->newRankId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->newRankId->cellAttributes() ?>>
<span id="el_tes_aproved_newRankId">
<input type="<?= $Page->newRankId->getInputTextType() ?>" name="x_newRankId" id="x_newRankId" data-table="tes_aproved" data-field="x_newRankId" value="<?= $Page->newRankId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->newRankId->getPlaceHolder()) ?>"<?= $Page->newRankId->editAttributes() ?> aria-describedby="x_newRankId_help">
<?= $Page->newRankId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->newRankId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->oldRankId->Visible) { // oldRankId ?>
    <div id="r_oldRankId"<?= $Page->oldRankId->rowAttributes() ?>>
        <label id="elh_tes_aproved_oldRankId" for="x_oldRankId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->oldRankId->caption() ?><?= $Page->oldRankId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->oldRankId->cellAttributes() ?>>
<span id="el_tes_aproved_oldRankId">
<input type="<?= $Page->oldRankId->getInputTextType() ?>" name="x_oldRankId" id="x_oldRankId" data-table="tes_aproved" data-field="x_oldRankId" value="<?= $Page->oldRankId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->oldRankId->getPlaceHolder()) ?>"<?= $Page->oldRankId->editAttributes() ?> aria-describedby="x_oldRankId_help">
<?= $Page->oldRankId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->oldRankId->getErrorMessage() ?></div>
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
    ew.addEventHandlers("tes_aproved");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
