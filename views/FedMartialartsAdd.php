<?php

namespace PHPMaker2022\school;

// Page object
$FedMartialartsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_martialarts: currentTable } });
var currentForm, currentPageID;
var ffed_martialartsadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_martialartsadd = new ew.Form("ffed_martialartsadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_martialartsadd;

    // Add fields
    var fields = currentTable.fields;
    ffed_martialartsadd.addFields([
        ["martialArts", [fields.martialArts.visible && fields.martialArts.required ? ew.Validators.required(fields.martialArts.caption) : null], fields.martialArts.isInvalid],
        ["federationId", [fields.federationId.visible && fields.federationId.required ? ew.Validators.required(fields.federationId.caption) : null, ew.Validators.integer], fields.federationId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_martialartsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_martialartsadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffed_martialartsadd");
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
<form name="ffed_martialartsadd" id="ffed_martialartsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_martialarts">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->martialArts->Visible) { // martialArts ?>
    <div id="r_martialArts"<?= $Page->martialArts->rowAttributes() ?>>
        <label id="elh_fed_martialarts_martialArts" for="x_martialArts" class="<?= $Page->LeftColumnClass ?>"><?= $Page->martialArts->caption() ?><?= $Page->martialArts->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->martialArts->cellAttributes() ?>>
<span id="el_fed_martialarts_martialArts">
<input type="<?= $Page->martialArts->getInputTextType() ?>" name="x_martialArts" id="x_martialArts" data-table="fed_martialarts" data-field="x_martialArts" value="<?= $Page->martialArts->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->martialArts->getPlaceHolder()) ?>"<?= $Page->martialArts->editAttributes() ?> aria-describedby="x_martialArts_help">
<?= $Page->martialArts->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->martialArts->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <div id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <label id="elh_fed_martialarts_federationId" for="x_federationId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationId->caption() ?><?= $Page->federationId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationId->cellAttributes() ?>>
<span id="el_fed_martialarts_federationId">
<input type="<?= $Page->federationId->getInputTextType() ?>" name="x_federationId" id="x_federationId" data-table="fed_martialarts" data-field="x_federationId" value="<?= $Page->federationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->federationId->getPlaceHolder()) ?>"<?= $Page->federationId->editAttributes() ?> aria-describedby="x_federationId_help">
<?= $Page->federationId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_fed_martialarts_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_martialarts_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_martialarts" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_martialartsadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_martialartsadd", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_fed_martialarts_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_fed_martialarts_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="fed_martialarts" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("fed_rank", explode(",", $Page->getCurrentDetailTable())) && $fed_rank->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fed_rank", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FedRankGrid.php" ?>
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
    ew.addEventHandlers("fed_martialarts");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
