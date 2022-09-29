<?php

namespace PHPMaker2022\school;

// Page object
$ConfNewsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_news: currentTable } });
var currentForm, currentPageID;
var fconf_newsadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_newsadd = new ew.Form("fconf_newsadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fconf_newsadd;

    // Add fields
    var fields = currentTable.fields;
    fconf_newsadd.addFields([
        ["date", [fields.date.visible && fields.date.required ? ew.Validators.required(fields.date.caption) : null, ew.Validators.datetime(fields.date.clientFormatPattern)], fields.date.isInvalid],
        ["descriptionEN", [fields.descriptionEN.visible && fields.descriptionEN.required ? ew.Validators.required(fields.descriptionEN.caption) : null], fields.descriptionEN.isInvalid],
        ["link", [fields.link.visible && fields.link.required ? ew.Validators.required(fields.link.caption) : null], fields.link.isInvalid],
        ["descriptionBR", [fields.descriptionBR.visible && fields.descriptionBR.required ? ew.Validators.required(fields.descriptionBR.caption) : null], fields.descriptionBR.isInvalid],
        ["descriptionSP", [fields.descriptionSP.visible && fields.descriptionSP.required ? ew.Validators.required(fields.descriptionSP.caption) : null], fields.descriptionSP.isInvalid]
    ]);

    // Form_CustomValidate
    fconf_newsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fconf_newsadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fconf_newsadd");
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
<form name="fconf_newsadd" id="fconf_newsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_news">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->date->Visible) { // date ?>
    <div id="r_date"<?= $Page->date->rowAttributes() ?>>
        <label id="elh_conf_news_date" for="x_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?><?= $Page->date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date->cellAttributes() ?>>
<span id="el_conf_news_date">
<input type="<?= $Page->date->getInputTextType() ?>" name="x_date" id="x_date" data-table="conf_news" data-field="x_date" value="<?= $Page->date->EditValue ?>" placeholder="<?= HtmlEncode($Page->date->getPlaceHolder()) ?>"<?= $Page->date->editAttributes() ?> aria-describedby="x_date_help">
<?= $Page->date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->date->getErrorMessage() ?></div>
<?php if (!$Page->date->ReadOnly && !$Page->date->Disabled && !isset($Page->date->EditAttrs["readonly"]) && !isset($Page->date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fconf_newsadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fconf_newsadd", "x_date", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descriptionEN->Visible) { // descriptionEN ?>
    <div id="r_descriptionEN"<?= $Page->descriptionEN->rowAttributes() ?>>
        <label id="elh_conf_news_descriptionEN" for="x_descriptionEN" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descriptionEN->caption() ?><?= $Page->descriptionEN->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descriptionEN->cellAttributes() ?>>
<span id="el_conf_news_descriptionEN">
<input type="<?= $Page->descriptionEN->getInputTextType() ?>" name="x_descriptionEN" id="x_descriptionEN" data-table="conf_news" data-field="x_descriptionEN" value="<?= $Page->descriptionEN->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->descriptionEN->getPlaceHolder()) ?>"<?= $Page->descriptionEN->editAttributes() ?> aria-describedby="x_descriptionEN_help">
<?= $Page->descriptionEN->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descriptionEN->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
    <div id="r_link"<?= $Page->link->rowAttributes() ?>>
        <label id="elh_conf_news_link" for="x_link" class="<?= $Page->LeftColumnClass ?>"><?= $Page->link->caption() ?><?= $Page->link->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->link->cellAttributes() ?>>
<span id="el_conf_news_link">
<input type="<?= $Page->link->getInputTextType() ?>" name="x_link" id="x_link" data-table="conf_news" data-field="x_link" value="<?= $Page->link->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->link->getPlaceHolder()) ?>"<?= $Page->link->editAttributes() ?> aria-describedby="x_link_help">
<?= $Page->link->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->link->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descriptionBR->Visible) { // descriptionBR ?>
    <div id="r_descriptionBR"<?= $Page->descriptionBR->rowAttributes() ?>>
        <label id="elh_conf_news_descriptionBR" for="x_descriptionBR" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descriptionBR->caption() ?><?= $Page->descriptionBR->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descriptionBR->cellAttributes() ?>>
<span id="el_conf_news_descriptionBR">
<input type="<?= $Page->descriptionBR->getInputTextType() ?>" name="x_descriptionBR" id="x_descriptionBR" data-table="conf_news" data-field="x_descriptionBR" value="<?= $Page->descriptionBR->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->descriptionBR->getPlaceHolder()) ?>"<?= $Page->descriptionBR->editAttributes() ?> aria-describedby="x_descriptionBR_help">
<?= $Page->descriptionBR->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descriptionBR->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descriptionSP->Visible) { // descriptionSP ?>
    <div id="r_descriptionSP"<?= $Page->descriptionSP->rowAttributes() ?>>
        <label id="elh_conf_news_descriptionSP" for="x_descriptionSP" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descriptionSP->caption() ?><?= $Page->descriptionSP->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descriptionSP->cellAttributes() ?>>
<span id="el_conf_news_descriptionSP">
<input type="<?= $Page->descriptionSP->getInputTextType() ?>" name="x_descriptionSP" id="x_descriptionSP" data-table="conf_news" data-field="x_descriptionSP" value="<?= $Page->descriptionSP->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->descriptionSP->getPlaceHolder()) ?>"<?= $Page->descriptionSP->editAttributes() ?> aria-describedby="x_descriptionSP_help">
<?= $Page->descriptionSP->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descriptionSP->getErrorMessage() ?></div>
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
    ew.addEventHandlers("conf_news");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
