<?php

namespace PHPMaker2022\school;

// Page object
$FinEmployeeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_employee: currentTable } });
var currentForm, currentPageID;
var ffin_employeeadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_employeeadd = new ew.Form("ffin_employeeadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffin_employeeadd;

    // Add fields
    var fields = currentTable.fields;
    ffin_employeeadd.addFields([
        ["uniqueId", [fields.uniqueId.visible && fields.uniqueId.required ? ew.Validators.required(fields.uniqueId.caption) : null], fields.uniqueId.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["middlename", [fields.middlename.visible && fields.middlename.required ? ew.Validators.required(fields.middlename.caption) : null], fields.middlename.isInvalid],
        ["lastname", [fields.lastname.visible && fields.lastname.required ? ew.Validators.required(fields.lastname.caption) : null], fields.lastname.isInvalid],
        ["country", [fields.country.visible && fields.country.required ? ew.Validators.required(fields.country.caption) : null], fields.country.isInvalid],
        ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null], fields.state.isInvalid],
        ["city", [fields.city.visible && fields.city.required ? ew.Validators.required(fields.city.caption) : null], fields.city.isInvalid],
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["neighborhood", [fields.neighborhood.visible && fields.neighborhood.required ? ew.Validators.required(fields.neighborhood.caption) : null], fields.neighborhood.isInvalid],
        ["zipcode", [fields.zipcode.visible && fields.zipcode.required ? ew.Validators.required(fields.zipcode.caption) : null], fields.zipcode.isInvalid]
    ]);

    // Form_CustomValidate
    ffin_employeeadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_employeeadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("ffin_employeeadd");
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
<form name="ffin_employeeadd" id="ffin_employeeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_employee">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->uniqueId->Visible) { // uniqueId ?>
    <div id="r_uniqueId"<?= $Page->uniqueId->rowAttributes() ?>>
        <label id="elh_fin_employee_uniqueId" for="x_uniqueId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->uniqueId->caption() ?><?= $Page->uniqueId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->uniqueId->cellAttributes() ?>>
<span id="el_fin_employee_uniqueId">
<input type="<?= $Page->uniqueId->getInputTextType() ?>" name="x_uniqueId" id="x_uniqueId" data-table="fin_employee" data-field="x_uniqueId" value="<?= $Page->uniqueId->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->uniqueId->getPlaceHolder()) ?>"<?= $Page->uniqueId->editAttributes() ?> aria-describedby="x_uniqueId_help">
<?= $Page->uniqueId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->uniqueId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_fin_employee_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_fin_employee_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="fin_employee" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
    <div id="r_middlename"<?= $Page->middlename->rowAttributes() ?>>
        <label id="elh_fin_employee_middlename" for="x_middlename" class="<?= $Page->LeftColumnClass ?>"><?= $Page->middlename->caption() ?><?= $Page->middlename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->middlename->cellAttributes() ?>>
<span id="el_fin_employee_middlename">
<input type="<?= $Page->middlename->getInputTextType() ?>" name="x_middlename" id="x_middlename" data-table="fin_employee" data-field="x_middlename" value="<?= $Page->middlename->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->middlename->getPlaceHolder()) ?>"<?= $Page->middlename->editAttributes() ?> aria-describedby="x_middlename_help">
<?= $Page->middlename->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->middlename->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <div id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <label id="elh_fin_employee_lastname" for="x_lastname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastname->caption() ?><?= $Page->lastname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastname->cellAttributes() ?>>
<span id="el_fin_employee_lastname">
<input type="<?= $Page->lastname->getInputTextType() ?>" name="x_lastname" id="x_lastname" data-table="fin_employee" data-field="x_lastname" value="<?= $Page->lastname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lastname->getPlaceHolder()) ?>"<?= $Page->lastname->editAttributes() ?> aria-describedby="x_lastname_help">
<?= $Page->lastname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
    <div id="r_country"<?= $Page->country->rowAttributes() ?>>
        <label id="elh_fin_employee_country" for="x_country" class="<?= $Page->LeftColumnClass ?>"><?= $Page->country->caption() ?><?= $Page->country->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->country->cellAttributes() ?>>
<span id="el_fin_employee_country">
<input type="<?= $Page->country->getInputTextType() ?>" name="x_country" id="x_country" data-table="fin_employee" data-field="x_country" value="<?= $Page->country->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->country->getPlaceHolder()) ?>"<?= $Page->country->editAttributes() ?> aria-describedby="x_country_help">
<?= $Page->country->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->country->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div id="r_state"<?= $Page->state->rowAttributes() ?>>
        <label id="elh_fin_employee_state" for="x_state" class="<?= $Page->LeftColumnClass ?>"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->state->cellAttributes() ?>>
<span id="el_fin_employee_state">
<input type="<?= $Page->state->getInputTextType() ?>" name="x_state" id="x_state" data-table="fin_employee" data-field="x_state" value="<?= $Page->state->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>"<?= $Page->state->editAttributes() ?> aria-describedby="x_state_help">
<?= $Page->state->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <div id="r_city"<?= $Page->city->rowAttributes() ?>>
        <label id="elh_fin_employee_city" for="x_city" class="<?= $Page->LeftColumnClass ?>"><?= $Page->city->caption() ?><?= $Page->city->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->city->cellAttributes() ?>>
<span id="el_fin_employee_city">
<input type="<?= $Page->city->getInputTextType() ?>" name="x_city" id="x_city" data-table="fin_employee" data-field="x_city" value="<?= $Page->city->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->city->getPlaceHolder()) ?>"<?= $Page->city->editAttributes() ?> aria-describedby="x_city_help">
<?= $Page->city->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->city->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_fin_employee_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_fin_employee_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="fin_employee" data-field="x_address" value="<?= $Page->address->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <div id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <label id="elh_fin_employee_neighborhood" for="x_neighborhood" class="<?= $Page->LeftColumnClass ?>"><?= $Page->neighborhood->caption() ?><?= $Page->neighborhood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fin_employee_neighborhood">
<input type="<?= $Page->neighborhood->getInputTextType() ?>" name="x_neighborhood" id="x_neighborhood" data-table="fin_employee" data-field="x_neighborhood" value="<?= $Page->neighborhood->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->neighborhood->getPlaceHolder()) ?>"<?= $Page->neighborhood->editAttributes() ?> aria-describedby="x_neighborhood_help">
<?= $Page->neighborhood->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->neighborhood->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
    <div id="r_zipcode"<?= $Page->zipcode->rowAttributes() ?>>
        <label id="elh_fin_employee_zipcode" for="x_zipcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->zipcode->caption() ?><?= $Page->zipcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->zipcode->cellAttributes() ?>>
<span id="el_fin_employee_zipcode">
<input type="<?= $Page->zipcode->getInputTextType() ?>" name="x_zipcode" id="x_zipcode" data-table="fin_employee" data-field="x_zipcode" value="<?= $Page->zipcode->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->zipcode->getPlaceHolder()) ?>"<?= $Page->zipcode->editAttributes() ?> aria-describedby="x_zipcode_help">
<?= $Page->zipcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->zipcode->getErrorMessage() ?></div>
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
    ew.addEventHandlers("fin_employee");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
