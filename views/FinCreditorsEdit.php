<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditorsEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_creditors: currentTable } });
var currentForm, currentPageID;
var ffin_creditorsedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditorsedit = new ew.Form("ffin_creditorsedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = ffin_creditorsedit;

    // Add fields
    var fields = currentTable.fields;
    ffin_creditorsedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["creditor", [fields.creditor.visible && fields.creditor.required ? ew.Validators.required(fields.creditor.caption) : null], fields.creditor.isInvalid],
        ["uniqueCode", [fields.uniqueCode.visible && fields.uniqueCode.required ? ew.Validators.required(fields.uniqueCode.caption) : null], fields.uniqueCode.isInvalid],
        ["IDcode", [fields.IDcode.visible && fields.IDcode.required ? ew.Validators.required(fields.IDcode.caption) : null], fields.IDcode.isInvalid],
        ["adress", [fields.adress.visible && fields.adress.required ? ew.Validators.required(fields.adress.caption) : null], fields.adress.isInvalid],
        ["number", [fields.number.visible && fields.number.required ? ew.Validators.required(fields.number.caption) : null], fields.number.isInvalid],
        ["neighborhood", [fields.neighborhood.visible && fields.neighborhood.required ? ew.Validators.required(fields.neighborhood.caption) : null], fields.neighborhood.isInvalid],
        ["country", [fields.country.visible && fields.country.required ? ew.Validators.required(fields.country.caption) : null, ew.Validators.integer], fields.country.isInvalid],
        ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null, ew.Validators.integer], fields.state.isInvalid],
        ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null, ew.Validators.integer], fields.city.isInvalid],
        ["telephone1", [fields.telephone1.visible && fields.telephone1.required ? ew.Validators.required(fields.telephone1.caption) : null], fields.telephone1.isInvalid],
        ["telephone2", [fields.telephone2.visible && fields.telephone2.required ? ew.Validators.required(fields.telephone2.caption) : null], fields.telephone2.isInvalid],
        ["website", [fields.website.visible && fields.website.required ? ew.Validators.required(fields.website.caption) : null], fields.website.isInvalid],
        ["email1", [fields.email1.visible && fields.email1.required ? ew.Validators.required(fields.email1.caption) : null], fields.email1.isInvalid],
        ["email2", [fields.email2.visible && fields.email2.required ? ew.Validators.required(fields.email2.caption) : null], fields.email2.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["lastupdate", [fields.lastupdate.visible && fields.lastupdate.required ? ew.Validators.required(fields.lastupdate.caption) : null], fields.lastupdate.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_creditorsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_creditorsedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_creditorsedit.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    loadjs.done("ffin_creditorsedit");
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
<form name="ffin_creditorsedit" id="ffin_creditorsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_creditors">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_fin_creditors_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_creditors_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_creditors" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->creditor->Visible) { // creditor ?>
    <div id="r_creditor"<?= $Page->creditor->rowAttributes() ?>>
        <label id="elh_fin_creditors_creditor" for="x_creditor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->creditor->caption() ?><?= $Page->creditor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->creditor->cellAttributes() ?>>
<span id="el_fin_creditors_creditor">
<input type="<?= $Page->creditor->getInputTextType() ?>" name="x_creditor" id="x_creditor" data-table="fin_creditors" data-field="x_creditor" value="<?= $Page->creditor->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->creditor->getPlaceHolder()) ?>"<?= $Page->creditor->editAttributes() ?> aria-describedby="x_creditor_help">
<?= $Page->creditor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->creditor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->uniqueCode->Visible) { // uniqueCode ?>
    <div id="r_uniqueCode"<?= $Page->uniqueCode->rowAttributes() ?>>
        <label id="elh_fin_creditors_uniqueCode" for="x_uniqueCode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uniqueCode->caption() ?><?= $Page->uniqueCode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uniqueCode->cellAttributes() ?>>
<span id="el_fin_creditors_uniqueCode">
<input type="<?= $Page->uniqueCode->getInputTextType() ?>" name="x_uniqueCode" id="x_uniqueCode" data-table="fin_creditors" data-field="x_uniqueCode" value="<?= $Page->uniqueCode->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->uniqueCode->getPlaceHolder()) ?>"<?= $Page->uniqueCode->editAttributes() ?> aria-describedby="x_uniqueCode_help">
<?= $Page->uniqueCode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uniqueCode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->IDcode->Visible) { // IDcode ?>
    <div id="r_IDcode"<?= $Page->IDcode->rowAttributes() ?>>
        <label id="elh_fin_creditors_IDcode" for="x_IDcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IDcode->caption() ?><?= $Page->IDcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->IDcode->cellAttributes() ?>>
<span id="el_fin_creditors_IDcode">
<input type="<?= $Page->IDcode->getInputTextType() ?>" name="x_IDcode" id="x_IDcode" data-table="fin_creditors" data-field="x_IDcode" value="<?= $Page->IDcode->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->IDcode->getPlaceHolder()) ?>"<?= $Page->IDcode->editAttributes() ?> aria-describedby="x_IDcode_help">
<?= $Page->IDcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IDcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->adress->Visible) { // adress ?>
    <div id="r_adress"<?= $Page->adress->rowAttributes() ?>>
        <label id="elh_fin_creditors_adress" for="x_adress" class="<?= $Page->LeftColumnClass ?>"><?= $Page->adress->caption() ?><?= $Page->adress->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->adress->cellAttributes() ?>>
<span id="el_fin_creditors_adress">
<input type="<?= $Page->adress->getInputTextType() ?>" name="x_adress" id="x_adress" data-table="fin_creditors" data-field="x_adress" value="<?= $Page->adress->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->adress->getPlaceHolder()) ?>"<?= $Page->adress->editAttributes() ?> aria-describedby="x_adress_help">
<?= $Page->adress->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->adress->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->number->Visible) { // number ?>
    <div id="r_number"<?= $Page->number->rowAttributes() ?>>
        <label id="elh_fin_creditors_number" for="x_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->number->caption() ?><?= $Page->number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->number->cellAttributes() ?>>
<span id="el_fin_creditors_number">
<input type="<?= $Page->number->getInputTextType() ?>" name="x_number" id="x_number" data-table="fin_creditors" data-field="x_number" value="<?= $Page->number->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->number->getPlaceHolder()) ?>"<?= $Page->number->editAttributes() ?> aria-describedby="x_number_help">
<?= $Page->number->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->number->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <div id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <label id="elh_fin_creditors_neighborhood" for="x_neighborhood" class="<?= $Page->LeftColumnClass ?>"><?= $Page->neighborhood->caption() ?><?= $Page->neighborhood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fin_creditors_neighborhood">
<input type="<?= $Page->neighborhood->getInputTextType() ?>" name="x_neighborhood" id="x_neighborhood" data-table="fin_creditors" data-field="x_neighborhood" value="<?= $Page->neighborhood->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->neighborhood->getPlaceHolder()) ?>"<?= $Page->neighborhood->editAttributes() ?> aria-describedby="x_neighborhood_help">
<?= $Page->neighborhood->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->neighborhood->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <div id="r_country"<?= $Page->country->rowAttributes() ?>>
        <label id="elh_fin_creditors_country" for="x_country" class="<?= $Page->LeftColumnClass ?>"><?= $Page->country->caption() ?><?= $Page->country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->country->cellAttributes() ?>>
<span id="el_fin_creditors_country">
<input type="<?= $Page->country->getInputTextType() ?>" name="x_country" id="x_country" data-table="fin_creditors" data-field="x_country" value="<?= $Page->country->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->country->getPlaceHolder()) ?>"<?= $Page->country->editAttributes() ?> aria-describedby="x_country_help">
<?= $Page->country->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->country->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div id="r_state"<?= $Page->state->rowAttributes() ?>>
        <label id="elh_fin_creditors_state" for="x_state" class="<?= $Page->LeftColumnClass ?>"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->state->cellAttributes() ?>>
<span id="el_fin_creditors_state">
<input type="<?= $Page->state->getInputTextType() ?>" name="x_state" id="x_state" data-table="fin_creditors" data-field="x_state" value="<?= $Page->state->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>"<?= $Page->state->editAttributes() ?> aria-describedby="x_state_help">
<?= $Page->state->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <div id="r_city"<?= $Page->city->rowAttributes() ?>>
        <label id="elh_fin_creditors_city" for="x_city" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city->cellAttributes() ?>>
<span id="el_fin_creditors_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="fin_creditors" data-field="x_city" value="<?= $Page->city->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>"<?= $Page->city->editAttributes() ?> aria-describedby="x_city_help">
<?= $Page->city->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telephone1->Visible) { // telephone1 ?>
    <div id="r_telephone1"<?= $Page->telephone1->rowAttributes() ?>>
        <label id="elh_fin_creditors_telephone1" for="x_telephone1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telephone1->caption() ?><?= $Page->telephone1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telephone1->cellAttributes() ?>>
<span id="el_fin_creditors_telephone1">
<input type="<?= $Page->telephone1->getInputTextType() ?>" name="x_telephone1" id="x_telephone1" data-table="fin_creditors" data-field="x_telephone1" value="<?= $Page->telephone1->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telephone1->getPlaceHolder()) ?>"<?= $Page->telephone1->editAttributes() ?> aria-describedby="x_telephone1_help">
<?= $Page->telephone1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telephone1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telephone2->Visible) { // telephone2 ?>
    <div id="r_telephone2"<?= $Page->telephone2->rowAttributes() ?>>
        <label id="elh_fin_creditors_telephone2" for="x_telephone2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telephone2->caption() ?><?= $Page->telephone2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telephone2->cellAttributes() ?>>
<span id="el_fin_creditors_telephone2">
<input type="<?= $Page->telephone2->getInputTextType() ?>" name="x_telephone2" id="x_telephone2" data-table="fin_creditors" data-field="x_telephone2" value="<?= $Page->telephone2->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telephone2->getPlaceHolder()) ?>"<?= $Page->telephone2->editAttributes() ?> aria-describedby="x_telephone2_help">
<?= $Page->telephone2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telephone2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website"<?= $Page->website->rowAttributes() ?>>
        <label id="elh_fin_creditors_website" for="x_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->website->cellAttributes() ?>>
<span id="el_fin_creditors_website">
<input type="<?= $Page->website->getInputTextType() ?>" name="x_website" id="x_website" data-table="fin_creditors" data-field="x_website" value="<?= $Page->website->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>"<?= $Page->website->editAttributes() ?> aria-describedby="x_website_help">
<?= $Page->website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email1->Visible) { // email1 ?>
    <div id="r_email1"<?= $Page->email1->rowAttributes() ?>>
        <label id="elh_fin_creditors_email1" for="x_email1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email1->caption() ?><?= $Page->email1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email1->cellAttributes() ?>>
<span id="el_fin_creditors_email1">
<input type="<?= $Page->email1->getInputTextType() ?>" name="x_email1" id="x_email1" data-table="fin_creditors" data-field="x_email1" value="<?= $Page->email1->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->email1->getPlaceHolder()) ?>"<?= $Page->email1->editAttributes() ?> aria-describedby="x_email1_help">
<?= $Page->email1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email2->Visible) { // email2 ?>
    <div id="r_email2"<?= $Page->email2->rowAttributes() ?>>
        <label id="elh_fin_creditors_email2" for="x_email2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email2->caption() ?><?= $Page->email2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email2->cellAttributes() ?>>
<span id="el_fin_creditors_email2">
<input type="<?= $Page->email2->getInputTextType() ?>" name="x_email2" id="x_email2" data-table="fin_creditors" data-field="x_email2" value="<?= $Page->email2->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->email2->getPlaceHolder()) ?>"<?= $Page->email2->editAttributes() ?> aria-describedby="x_email2_help">
<?= $Page->email2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_fin_creditors_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_creditors_obs">
<textarea data-table="fin_creditors" data-field="x_obs" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
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
    ew.addEventHandlers("fin_creditors");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
