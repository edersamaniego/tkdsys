<?php

namespace PHPMaker2022\school;

// Page object
$ConfMemberstatusAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_memberstatus: currentTable } });
var currentForm, currentPageID;
var fconf_memberstatusadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_memberstatusadd = new ew.Form("fconf_memberstatusadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_memberstatusadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_memberstatusadd.addFields([
        ["statusES", [fields.statusES.visible && fields.statusES.required ? ew.Validators.required(fields.statusES.caption) : null], fields.statusES.isInvalid],
        ["statusEN", [fields.statusEN.visible && fields.statusEN.required ? ew.Validators.required(fields.statusEN.caption) : null], fields.statusEN.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_memberstatusadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_memberstatusadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_memberstatusadd");
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
<form name="fconf_memberstatusadd" id="fconf_memberstatusadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_memberstatus">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->statusES->Visible) { // statusES ?>
    <div id="r_statusES"<?= $Page->statusES->rowAttributes() ?>>
        <label id="elh_conf_memberstatus_statusES" for="x_statusES" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusES->caption() ?><?= $Page->statusES->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->statusES->cellAttributes() ?>>
<span id="el_conf_memberstatus_statusES">
<input type="<?= $Page->statusES->getInputTextType() ?>" name="x_statusES" id="x_statusES" data-table="conf_memberstatus" data-field="x_statusES" value="<?= $Page->statusES->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statusES->getPlaceHolder()) ?>"<?= $Page->statusES->editAttributes() ?> aria-describedby="x_statusES_help">
<?= $Page->statusES->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusES->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusEN->Visible) { // statusEN ?>
    <div id="r_statusEN"<?= $Page->statusEN->rowAttributes() ?>>
        <label id="elh_conf_memberstatus_statusEN" for="x_statusEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusEN->caption() ?><?= $Page->statusEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->statusEN->cellAttributes() ?>>
<span id="el_conf_memberstatus_statusEN">
<input type="<?= $Page->statusEN->getInputTextType() ?>" name="x_statusEN" id="x_statusEN" data-table="conf_memberstatus" data-field="x_statusEN" value="<?= $Page->statusEN->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->statusEN->getPlaceHolder()) ?>"<?= $Page->statusEN->editAttributes() ?> aria-describedby="x_statusEN_help">
<?= $Page->statusEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_conf_memberstatus_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_conf_memberstatus_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="conf_memberstatus" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_conf_memberstatus_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_conf_memberstatus_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="conf_memberstatus" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_conf_memberstatus_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_conf_memberstatus_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="conf_memberstatus" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fconf_memberstatusadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fconf_memberstatusadd", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
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
    ew.addEventHandlers("conf_memberstatus");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
