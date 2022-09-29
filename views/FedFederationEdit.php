<?php

namespace PHPMaker2022\school;

// Page object
$FedFederationEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_federation: currentTable } });
var currentForm, currentPageID;
var ffed_federationedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_federationedit = new ew.Form("ffed_federationedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffed_federationedit;

    // Add fields
    var fields = currentTable.fields;
    ffed_federationedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["federation", [fields.federation.visible && fields.federation.required ? ew.Validators.required(fields.federation.caption) : null], fields.federation.isInvalid],
        ["ceo", [fields.ceo.visible && fields.ceo.required ? ew.Validators.required(fields.ceo.caption) : null], fields.ceo.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid],
        ["federationMasterId", [fields.federationMasterId.visible && fields.federationMasterId.required ? ew.Validators.required(fields.federationMasterId.caption) : null, ew.Validators.integer], fields.federationMasterId.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_federationedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_federationedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffed_federationedit");
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
<form name="ffed_federationedit" id="ffed_federationedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_federation">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fed_federation_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_federation_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_federation" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federation->Visible) { // federation ?>
    <div id="r_federation"<?= $Page->federation->rowAttributes() ?>>
        <label id="elh_fed_federation_federation" for="x_federation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federation->caption() ?><?= $Page->federation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federation->cellAttributes() ?>>
<span id="el_fed_federation_federation">
<input type="<?= $Page->federation->getInputTextType() ?>" name="x_federation" id="x_federation" data-table="fed_federation" data-field="x_federation" value="<?= $Page->federation->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->federation->getPlaceHolder()) ?>"<?= $Page->federation->editAttributes() ?> aria-describedby="x_federation_help">
<?= $Page->federation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ceo->Visible) { // ceo ?>
    <div id="r_ceo"<?= $Page->ceo->rowAttributes() ?>>
        <label id="elh_fed_federation_ceo" for="x_ceo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ceo->caption() ?><?= $Page->ceo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ceo->cellAttributes() ?>>
<span id="el_fed_federation_ceo">
<input type="<?= $Page->ceo->getInputTextType() ?>" name="x_ceo" id="x_ceo" data-table="fed_federation" data-field="x_ceo" value="<?= $Page->ceo->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ceo->getPlaceHolder()) ?>"<?= $Page->ceo->editAttributes() ?> aria-describedby="x_ceo_help">
<?= $Page->ceo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ceo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_fed_federation_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_fed_federation_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="fed_federation" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_fed_federation_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_federation_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_federation" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_federationedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_federationedit", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federationMasterId->Visible) { // federationMasterId ?>
    <div id="r_federationMasterId"<?= $Page->federationMasterId->rowAttributes() ?>>
        <label id="elh_fed_federation_federationMasterId" for="x_federationMasterId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationMasterId->caption() ?><?= $Page->federationMasterId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationMasterId->cellAttributes() ?>>
<span id="el_fed_federation_federationMasterId">
<input type="<?= $Page->federationMasterId->getInputTextType() ?>" name="x_federationMasterId" id="x_federationMasterId" data-table="fed_federation" data-field="x_federationMasterId" value="<?= $Page->federationMasterId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->federationMasterId->getPlaceHolder()) ?>"<?= $Page->federationMasterId->editAttributes() ?> aria-describedby="x_federationMasterId_help">
<?= $Page->federationMasterId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationMasterId->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fed_federation");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
