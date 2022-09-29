<?php

namespace PHPMaker2022\school;

// Page object
$ConfTestestatusAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_testestatus: currentTable } });
var currentForm, currentPageID;
var fconf_testestatusadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_testestatusadd = new ew.Form("fconf_testestatusadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_testestatusadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_testestatusadd.addFields([
        ["testStatus", [fields.testStatus.visible && fields.testStatus.required ? ew.Validators.required(fields.testStatus.caption) : null], fields.testStatus.isInvalid],
        ["statusEN", [fields.statusEN.visible && fields.statusEN.required ? ew.Validators.required(fields.statusEN.caption) : null], fields.statusEN.isInvalid],
        ["statusES", [fields.statusES.visible && fields.statusES.required ? ew.Validators.required(fields.statusES.caption) : null], fields.statusES.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_testestatusadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_testestatusadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_testestatusadd");
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
<form name="fconf_testestatusadd" id="fconf_testestatusadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_testestatus">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->testStatus->Visible) { // testStatus ?>
    <div id="r_testStatus"<?= $Page->testStatus->rowAttributes() ?>>
        <label id="elh_conf_testestatus_testStatus" for="x_testStatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->testStatus->caption() ?><?= $Page->testStatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->testStatus->cellAttributes() ?>>
<span id="el_conf_testestatus_testStatus">
<input type="<?= $Page->testStatus->getInputTextType() ?>" name="x_testStatus" id="x_testStatus" data-table="conf_testestatus" data-field="x_testStatus" value="<?= $Page->testStatus->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->testStatus->getPlaceHolder()) ?>"<?= $Page->testStatus->editAttributes() ?> aria-describedby="x_testStatus_help">
<?= $Page->testStatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->testStatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusEN->Visible) { // statusEN ?>
    <div id="r_statusEN"<?= $Page->statusEN->rowAttributes() ?>>
        <label id="elh_conf_testestatus_statusEN" for="x_statusEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusEN->caption() ?><?= $Page->statusEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->statusEN->cellAttributes() ?>>
<span id="el_conf_testestatus_statusEN">
<input type="<?= $Page->statusEN->getInputTextType() ?>" name="x_statusEN" id="x_statusEN" data-table="conf_testestatus" data-field="x_statusEN" value="<?= $Page->statusEN->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statusEN->getPlaceHolder()) ?>"<?= $Page->statusEN->editAttributes() ?> aria-describedby="x_statusEN_help">
<?= $Page->statusEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusES->Visible) { // statusES ?>
    <div id="r_statusES"<?= $Page->statusES->rowAttributes() ?>>
        <label id="elh_conf_testestatus_statusES" for="x_statusES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusES->caption() ?><?= $Page->statusES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->statusES->cellAttributes() ?>>
<span id="el_conf_testestatus_statusES">
<input type="<?= $Page->statusES->getInputTextType() ?>" name="x_statusES" id="x_statusES" data-table="conf_testestatus" data-field="x_statusES" value="<?= $Page->statusES->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statusES->getPlaceHolder()) ?>"<?= $Page->statusES->editAttributes() ?> aria-describedby="x_statusES_help">
<?= $Page->statusES->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusES->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_conf_testestatus_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_conf_testestatus_obs">
<textarea data-table="conf_testestatus" data-field="x_obs" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_conf_testestatus_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_conf_testestatus_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="conf_testestatus" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_conf_testestatus_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_conf_testestatus_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="conf_testestatus" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fconf_testestatusadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fconf_testestatusadd", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
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
    ew.addEventHandlers("conf_testestatus");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
