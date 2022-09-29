<?php

namespace PHPMaker2022\school;

// Page object
$FedFilescategoryEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_filescategory: currentTable } });
var currentForm, currentPageID;
var ffed_filescategoryedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_filescategoryedit = new ew.Form("ffed_filescategoryedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffed_filescategoryedit;

    // Add fields
    var fields = currentTable.fields;
    ffed_filescategoryedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["category", [fields.category.visible && fields.category.required ? ew.Validators.required(fields.category.caption) : null], fields.category.isInvalid],
        ["categoryBr", [fields.categoryBr.visible && fields.categoryBr.required ? ew.Validators.required(fields.categoryBr.caption) : null], fields.categoryBr.isInvalid],
        ["categorySp", [fields.categorySp.visible && fields.categorySp.required ? ew.Validators.required(fields.categorySp.caption) : null], fields.categorySp.isInvalid],
        ["_userId", [fields._userId.visible && fields._userId.required ? ew.Validators.required(fields._userId.caption) : null, ew.Validators.integer], fields._userId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_filescategoryedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_filescategoryedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffed_filescategoryedit");
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
<form name="ffed_filescategoryedit" id="ffed_filescategoryedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_filescategory">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fed_filescategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_filescategory_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_filescategory" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->category->Visible) { // category ?>
    <div id="r_category"<?= $Page->category->rowAttributes() ?>>
        <label id="elh_fed_filescategory_category" for="x_category" class="<?= $Page->LeftColumnClass ?>"><?= $Page->category->caption() ?><?= $Page->category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category->cellAttributes() ?>>
<span id="el_fed_filescategory_category">
<input type="<?= $Page->category->getInputTextType() ?>" name="x_category" id="x_category" data-table="fed_filescategory" data-field="x_category" value="<?= $Page->category->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->category->getPlaceHolder()) ?>"<?= $Page->category->editAttributes() ?> aria-describedby="x_category_help">
<?= $Page->category->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->category->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->categoryBr->Visible) { // categoryBr ?>
    <div id="r_categoryBr"<?= $Page->categoryBr->rowAttributes() ?>>
        <label id="elh_fed_filescategory_categoryBr" for="x_categoryBr" class="<?= $Page->LeftColumnClass ?>"><?= $Page->categoryBr->caption() ?><?= $Page->categoryBr->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->categoryBr->cellAttributes() ?>>
<span id="el_fed_filescategory_categoryBr">
<input type="<?= $Page->categoryBr->getInputTextType() ?>" name="x_categoryBr" id="x_categoryBr" data-table="fed_filescategory" data-field="x_categoryBr" value="<?= $Page->categoryBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->categoryBr->getPlaceHolder()) ?>"<?= $Page->categoryBr->editAttributes() ?> aria-describedby="x_categoryBr_help">
<?= $Page->categoryBr->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->categoryBr->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->categorySp->Visible) { // categorySp ?>
    <div id="r_categorySp"<?= $Page->categorySp->rowAttributes() ?>>
        <label id="elh_fed_filescategory_categorySp" for="x_categorySp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->categorySp->caption() ?><?= $Page->categorySp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->categorySp->cellAttributes() ?>>
<span id="el_fed_filescategory_categorySp">
<input type="<?= $Page->categorySp->getInputTextType() ?>" name="x_categorySp" id="x_categorySp" data-table="fed_filescategory" data-field="x_categorySp" value="<?= $Page->categorySp->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->categorySp->getPlaceHolder()) ?>"<?= $Page->categorySp->editAttributes() ?> aria-describedby="x_categorySp_help">
<?= $Page->categorySp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->categorySp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <div id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <label id="elh_fed_filescategory__userId" for="x__userId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_userId->caption() ?><?= $Page->_userId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fed_filescategory__userId">
<input type="<?= $Page->_userId->getInputTextType() ?>" name="x__userId" id="x__userId" data-table="fed_filescategory" data-field="x__userId" value="<?= $Page->_userId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_userId->getPlaceHolder()) ?>"<?= $Page->_userId->editAttributes() ?> aria-describedby="x__userId_help">
<?= $Page->_userId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_userId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_fed_filescategory_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_filescategory_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_filescategory" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_filescategoryedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_filescategoryedit", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
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
    ew.addEventHandlers("fed_filescategory");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
