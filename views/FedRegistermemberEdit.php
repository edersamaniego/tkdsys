<?php

namespace PHPMaker2022\school;

// Page object
$FedRegistermemberEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_registermember: currentTable } });
var currentForm, currentPageID;
var ffed_registermemberedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_registermemberedit = new ew.Form("ffed_registermemberedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffed_registermemberedit;

    // Add fields
    var fields = currentTable.fields;
    ffed_registermemberedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["memberId", [fields.memberId.visible && fields.memberId.required ? ew.Validators.required(fields.memberId.caption) : null, ew.Validators.integer], fields.memberId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null, ew.Validators.integer], fields.schoolId.isInvalid],
        ["testId", [fields.testId.visible && fields.testId.required ? ew.Validators.required(fields.testId.caption) : null, ew.Validators.integer], fields.testId.isInvalid],
        ["currentRankId", [fields.currentRankId.visible && fields.currentRankId.required ? ew.Validators.required(fields.currentRankId.caption) : null, ew.Validators.integer], fields.currentRankId.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["registerType", [fields.registerType.visible && fields.registerType.required ? ew.Validators.required(fields.registerType.caption) : null, ew.Validators.integer], fields.registerType.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_registermemberedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_registermemberedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffed_registermemberedit");
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
<form name="ffed_registermemberedit" id="ffed_registermemberedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_registermember">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fed_registermember_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_registermember_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_registermember" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
    <div id="r_memberId"<?= $Page->memberId->rowAttributes() ?>>
        <label id="elh_fed_registermember_memberId" for="x_memberId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->memberId->caption() ?><?= $Page->memberId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->memberId->cellAttributes() ?>>
<span id="el_fed_registermember_memberId">
<input type="<?= $Page->memberId->getInputTextType() ?>" name="x_memberId" id="x_memberId" data-table="fed_registermember" data-field="x_memberId" value="<?= $Page->memberId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>"<?= $Page->memberId->editAttributes() ?> aria-describedby="x_memberId_help">
<?= $Page->memberId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_fed_registermember_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_fed_registermember_schoolId">
<input type="<?= $Page->schoolId->getInputTextType() ?>" name="x_schoolId" id="x_schoolId" data-table="fed_registermember" data-field="x_schoolId" value="<?= $Page->schoolId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"<?= $Page->schoolId->editAttributes() ?> aria-describedby="x_schoolId_help">
<?= $Page->schoolId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <div id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <label id="elh_fed_registermember_testId" for="x_testId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testId->caption() ?><?= $Page->testId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testId->cellAttributes() ?>>
<span id="el_fed_registermember_testId">
<input type="<?= $Page->testId->getInputTextType() ?>" name="x_testId" id="x_testId" data-table="fed_registermember" data-field="x_testId" value="<?= $Page->testId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->testId->getPlaceHolder()) ?>"<?= $Page->testId->editAttributes() ?> aria-describedby="x_testId_help">
<?= $Page->testId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->currentRankId->Visible) { // currentRankId ?>
    <div id="r_currentRankId"<?= $Page->currentRankId->rowAttributes() ?>>
        <label id="elh_fed_registermember_currentRankId" for="x_currentRankId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->currentRankId->caption() ?><?= $Page->currentRankId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->currentRankId->cellAttributes() ?>>
<span id="el_fed_registermember_currentRankId">
<input type="<?= $Page->currentRankId->getInputTextType() ?>" name="x_currentRankId" id="x_currentRankId" data-table="fed_registermember" data-field="x_currentRankId" value="<?= $Page->currentRankId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->currentRankId->getPlaceHolder()) ?>"<?= $Page->currentRankId->editAttributes() ?> aria-describedby="x_currentRankId_help">
<?= $Page->currentRankId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->currentRankId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_fed_registermember_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_fed_registermember_obs">
<textarea data-table="fed_registermember" data-field="x_obs" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->registerType->Visible) { // registerType ?>
    <div id="r_registerType"<?= $Page->registerType->rowAttributes() ?>>
        <label id="elh_fed_registermember_registerType" for="x_registerType" class="<?= $Page->LeftColumnClass ?>"><?= $Page->registerType->caption() ?><?= $Page->registerType->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->registerType->cellAttributes() ?>>
<span id="el_fed_registermember_registerType">
<input type="<?= $Page->registerType->getInputTextType() ?>" name="x_registerType" id="x_registerType" data-table="fed_registermember" data-field="x_registerType" value="<?= $Page->registerType->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->registerType->getPlaceHolder()) ?>"<?= $Page->registerType->editAttributes() ?> aria-describedby="x_registerType_help">
<?= $Page->registerType->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->registerType->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_fed_registermember_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_fed_registermember_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="fed_registermember" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_fed_registermember_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_registermember_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_registermember" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_registermemberedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_registermemberedit", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
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
    ew.addEventHandlers("fed_registermember");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
