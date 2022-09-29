<?php

namespace PHPMaker2022\school;

// Page object
$FedApplicationschoolAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_applicationschool: currentTable } });
var currentForm, currentPageID;
var ffed_applicationschooladd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_applicationschooladd = new ew.Form("ffed_applicationschooladd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_applicationschooladd;

    // Add fields
    var fields = currentTable.fields;
    ffed_applicationschooladd.addFields([
        ["school", [fields.school.visible && fields.school.required ? ew.Validators.required(fields.school.caption) : null], fields.school.isInvalid],
        ["countryId", [fields.countryId.visible && fields.countryId.required ? ew.Validators.required(fields.countryId.caption) : null], fields.countryId.isInvalid],
        ["UFId", [fields.UFId.visible && fields.UFId.required ? ew.Validators.required(fields.UFId.caption) : null], fields.UFId.isInvalid],
        ["cityId", [fields.cityId.visible && fields.cityId.required ? ew.Validators.required(fields.cityId.caption) : null], fields.cityId.isInvalid],
        ["neighborhood", [fields.neighborhood.visible && fields.neighborhood.required ? ew.Validators.required(fields.neighborhood.caption) : null], fields.neighborhood.isInvalid],
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["zipcode", [fields.zipcode.visible && fields.zipcode.required ? ew.Validators.required(fields.zipcode.caption) : null], fields.zipcode.isInvalid],
        ["website", [fields.website.visible && fields.website.required ? ew.Validators.required(fields.website.caption) : null], fields.website.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["phone", [fields.phone.visible && fields.phone.required ? ew.Validators.required(fields.phone.caption) : null], fields.phone.isInvalid],
        ["celphone", [fields.celphone.visible && fields.celphone.required ? ew.Validators.required(fields.celphone.caption) : null], fields.celphone.isInvalid],
        ["logo", [fields.logo.visible && fields.logo.required ? ew.Validators.fileRequired(fields.logo.caption) : null], fields.logo.isInvalid],
        ["openingDate", [fields.openingDate.visible && fields.openingDate.required ? ew.Validators.required(fields.openingDate.caption) : null, ew.Validators.datetime(fields.openingDate.clientFormatPattern)], fields.openingDate.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null], fields.createUserId.isInvalid],
        ["owner", [fields.owner.visible && fields.owner.required ? ew.Validators.required(fields.owner.caption) : null], fields.owner.isInvalid],
        ["identityNumber", [fields.identityNumber.visible && fields.identityNumber.required ? ew.Validators.required(fields.identityNumber.caption) : null], fields.identityNumber.isInvalid],
        ["birthDateOwner", [fields.birthDateOwner.visible && fields.birthDateOwner.required ? ew.Validators.required(fields.birthDateOwner.caption) : null, ew.Validators.datetime(fields.birthDateOwner.clientFormatPattern)], fields.birthDateOwner.isInvalid],
        ["ownerCountryId", [fields.ownerCountryId.visible && fields.ownerCountryId.required ? ew.Validators.required(fields.ownerCountryId.caption) : null], fields.ownerCountryId.isInvalid],
        ["ownerStateId", [fields.ownerStateId.visible && fields.ownerStateId.required ? ew.Validators.required(fields.ownerStateId.caption) : null], fields.ownerStateId.isInvalid],
        ["ownCityId", [fields.ownCityId.visible && fields.ownCityId.required ? ew.Validators.required(fields.ownCityId.caption) : null], fields.ownCityId.isInvalid],
        ["ownerTelephone", [fields.ownerTelephone.visible && fields.ownerTelephone.required ? ew.Validators.required(fields.ownerTelephone.caption) : null], fields.ownerTelephone.isInvalid],
        ["ownerTelephoneWork", [fields.ownerTelephoneWork.visible && fields.ownerTelephoneWork.required ? ew.Validators.required(fields.ownerTelephoneWork.caption) : null], fields.ownerTelephoneWork.isInvalid],
        ["ownerProfession", [fields.ownerProfession.visible && fields.ownerProfession.required ? ew.Validators.required(fields.ownerProfession.caption) : null], fields.ownerProfession.isInvalid],
        ["employer", [fields.employer.visible && fields.employer.required ? ew.Validators.required(fields.employer.caption) : null], fields.employer.isInvalid],
        ["ownerGraduation", [fields.ownerGraduation.visible && fields.ownerGraduation.required ? ew.Validators.required(fields.ownerGraduation.caption) : null], fields.ownerGraduation.isInvalid],
        ["ownerGraduationLocation", [fields.ownerGraduationLocation.visible && fields.ownerGraduationLocation.required ? ew.Validators.required(fields.ownerGraduationLocation.caption) : null], fields.ownerGraduationLocation.isInvalid],
        ["ownerGraduationObs", [fields.ownerGraduationObs.visible && fields.ownerGraduationObs.required ? ew.Validators.required(fields.ownerGraduationObs.caption) : null], fields.ownerGraduationObs.isInvalid],
        ["ownerMaritalStatus", [fields.ownerMaritalStatus.visible && fields.ownerMaritalStatus.required ? ew.Validators.required(fields.ownerMaritalStatus.caption) : null], fields.ownerMaritalStatus.isInvalid],
        ["ownerSpouseName", [fields.ownerSpouseName.visible && fields.ownerSpouseName.required ? ew.Validators.required(fields.ownerSpouseName.caption) : null], fields.ownerSpouseName.isInvalid],
        ["ownerSpouseProfession", [fields.ownerSpouseProfession.visible && fields.ownerSpouseProfession.required ? ew.Validators.required(fields.ownerSpouseProfession.caption) : null], fields.ownerSpouseProfession.isInvalid],
        ["propertySituation", [fields.propertySituation.visible && fields.propertySituation.required ? ew.Validators.required(fields.propertySituation.caption) : null], fields.propertySituation.isInvalid],
        ["numberOfStudentsInBeginnig", [fields.numberOfStudentsInBeginnig.visible && fields.numberOfStudentsInBeginnig.required ? ew.Validators.required(fields.numberOfStudentsInBeginnig.caption) : null, ew.Validators.integer], fields.numberOfStudentsInBeginnig.isInvalid],
        ["ownerAbout", [fields.ownerAbout.visible && fields.ownerAbout.required ? ew.Validators.required(fields.ownerAbout.caption) : null], fields.ownerAbout.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_applicationschooladd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_applicationschooladd.validateRequired = ew.CLIENT_VALIDATE;

    // Multi-Page
    ffed_applicationschooladd.multiPage = new ew.MultiPage("ffed_applicationschooladd");

    // Dynamic selection lists
    ffed_applicationschooladd.lists.countryId = <?= $Page->countryId->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.UFId = <?= $Page->UFId->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.cityId = <?= $Page->cityId->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.ownerCountryId = <?= $Page->ownerCountryId->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.ownerStateId = <?= $Page->ownerStateId->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.ownCityId = <?= $Page->ownCityId->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.ownerGraduation = <?= $Page->ownerGraduation->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.ownerMaritalStatus = <?= $Page->ownerMaritalStatus->toClientList($Page) ?>;
    ffed_applicationschooladd.lists.propertySituation = <?= $Page->propertySituation->toClientList($Page) ?>;
    loadjs.done("ffed_applicationschooladd");
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
<form name="ffed_applicationschooladd" id="ffed_applicationschooladd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_applicationschool">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_FedApplicationschoolAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_fed_applicationschool1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fed_applicationschool1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_fed_applicationschool2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fed_applicationschool2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_fed_applicationschool1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->school->Visible) { // school ?>
    <div id="r_school"<?= $Page->school->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_school" for="x_school" class="<?= $Page->LeftColumnClass ?>"><?= $Page->school->caption() ?><?= $Page->school->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->school->cellAttributes() ?>>
<span id="el_fed_applicationschool_school">
<input type="<?= $Page->school->getInputTextType() ?>" name="x_school" id="x_school" data-table="fed_applicationschool" data-field="x_school" value="<?= $Page->school->EditValue ?>" data-page="1" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->school->getPlaceHolder()) ?>"<?= $Page->school->editAttributes() ?> aria-describedby="x_school_help">
<?= $Page->school->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->school->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <div id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_countryId" for="x_countryId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->countryId->caption() ?><?= $Page->countryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->countryId->cellAttributes() ?>>
<span id="el_fed_applicationschool_countryId">
<?php $Page->countryId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<div class="input-group flex-nowrap">
    <select
        id="x_countryId"
        name="x_countryId"
        class="form-select ew-select<?= $Page->countryId->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_countryId"
        data-table="fed_applicationschool"
        data-field="x_countryId"
        data-page="1"
        data-value-separator="<?= $Page->countryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->countryId->getPlaceHolder()) ?>"
        <?= $Page->countryId->editAttributes() ?>>
        <?= $Page->countryId->selectOptionListHtml("x_countryId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_country") && !$Page->countryId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_countryId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->countryId->caption() ?>" data-title="<?= $Page->countryId->caption() ?>" data-ew-action="add-option" data-el="x_countryId" data-url="<?= GetUrl("ConfCountryAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->countryId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->countryId->getErrorMessage() ?></div>
<?= $Page->countryId->Lookup->getParamTag($Page, "p_x_countryId") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_countryId", selectId: "ffed_applicationschooladd_x_countryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.countryId.lookupOptions.length) {
        options.data = { id: "x_countryId", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_countryId", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.countryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
    <div id="r_UFId"<?= $Page->UFId->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_UFId" for="x_UFId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UFId->caption() ?><?= $Page->UFId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UFId->cellAttributes() ?>>
<span id="el_fed_applicationschool_UFId">
<?php $Page->UFId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_UFId"
        name="x_UFId"
        class="form-select ew-select<?= $Page->UFId->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_UFId"
        data-table="fed_applicationschool"
        data-field="x_UFId"
        data-page="1"
        data-value-separator="<?= $Page->UFId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->UFId->getPlaceHolder()) ?>"
        <?= $Page->UFId->editAttributes() ?>>
        <?= $Page->UFId->selectOptionListHtml("x_UFId") ?>
    </select>
    <?= $Page->UFId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->UFId->getErrorMessage() ?></div>
<?= $Page->UFId->Lookup->getParamTag($Page, "p_x_UFId") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_UFId", selectId: "ffed_applicationschooladd_x_UFId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.UFId.lookupOptions.length) {
        options.data = { id: "x_UFId", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_UFId", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.UFId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
    <div id="r_cityId"<?= $Page->cityId->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_cityId" for="x_cityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cityId->caption() ?><?= $Page->cityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cityId->cellAttributes() ?>>
<span id="el_fed_applicationschool_cityId">
    <select
        id="x_cityId"
        name="x_cityId"
        class="form-select ew-select<?= $Page->cityId->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_cityId"
        data-table="fed_applicationschool"
        data-field="x_cityId"
        data-page="1"
        data-value-separator="<?= $Page->cityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cityId->getPlaceHolder()) ?>"
        <?= $Page->cityId->editAttributes() ?>>
        <?= $Page->cityId->selectOptionListHtml("x_cityId") ?>
    </select>
    <?= $Page->cityId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cityId->getErrorMessage() ?></div>
<?= $Page->cityId->Lookup->getParamTag($Page, "p_x_cityId") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_cityId", selectId: "ffed_applicationschooladd_x_cityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.cityId.lookupOptions.length) {
        options.data = { id: "x_cityId", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_cityId", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.cityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <div id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_neighborhood" for="x_neighborhood" class="<?= $Page->LeftColumnClass ?>"><?= $Page->neighborhood->caption() ?><?= $Page->neighborhood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fed_applicationschool_neighborhood">
<input type="<?= $Page->neighborhood->getInputTextType() ?>" name="x_neighborhood" id="x_neighborhood" data-table="fed_applicationschool" data-field="x_neighborhood" value="<?= $Page->neighborhood->EditValue ?>" data-page="1" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->neighborhood->getPlaceHolder()) ?>"<?= $Page->neighborhood->editAttributes() ?> aria-describedby="x_neighborhood_help">
<?= $Page->neighborhood->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->neighborhood->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_fed_applicationschool_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="fed_applicationschool" data-field="x_address" value="<?= $Page->address->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
    <div id="r_zipcode"<?= $Page->zipcode->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_zipcode" for="x_zipcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->zipcode->caption() ?><?= $Page->zipcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->zipcode->cellAttributes() ?>>
<span id="el_fed_applicationschool_zipcode">
<input type="<?= $Page->zipcode->getInputTextType() ?>" name="x_zipcode" id="x_zipcode" data-table="fed_applicationschool" data-field="x_zipcode" value="<?= $Page->zipcode->EditValue ?>" data-page="1" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->zipcode->getPlaceHolder()) ?>"<?= $Page->zipcode->editAttributes() ?> aria-describedby="x_zipcode_help">
<?= $Page->zipcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->zipcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website"<?= $Page->website->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_website" for="x_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->website->cellAttributes() ?>>
<span id="el_fed_applicationschool_website">
<input type="<?= $Page->website->getInputTextType() ?>" name="x_website" id="x_website" data-table="fed_applicationschool" data-field="x_website" value="<?= $Page->website->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>"<?= $Page->website->editAttributes() ?> aria-describedby="x_website_help">
<?= $Page->website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_fed_applicationschool__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_fed_applicationschool__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="fed_applicationschool" data-field="x__email" value="<?= $Page->_email->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<span id="el_fed_applicationschool_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="fed_applicationschool" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" data-page="1" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>"<?= $Page->phone->editAttributes() ?> aria-describedby="x_phone_help">
<?= $Page->phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->celphone->Visible) { // celphone ?>
    <div id="r_celphone"<?= $Page->celphone->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_celphone" for="x_celphone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->celphone->caption() ?><?= $Page->celphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->celphone->cellAttributes() ?>>
<span id="el_fed_applicationschool_celphone">
<input type="<?= $Page->celphone->getInputTextType() ?>" name="x_celphone" id="x_celphone" data-table="fed_applicationschool" data-field="x_celphone" value="<?= $Page->celphone->EditValue ?>" data-page="1" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->celphone->getPlaceHolder()) ?>"<?= $Page->celphone->editAttributes() ?> aria-describedby="x_celphone_help">
<?= $Page->celphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->celphone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
    <div id="r_logo"<?= $Page->logo->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_logo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->logo->caption() ?><?= $Page->logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->logo->cellAttributes() ?>>
<span id="el_fed_applicationschool_logo">
<div id="fd_x_logo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->logo->title() ?>" data-table="fed_applicationschool" data-field="x_logo" data-page="1" name="x_logo" id="x_logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->logo->editAttributes() ?> aria-describedby="x_logo_help"<?= ($Page->logo->ReadOnly || $Page->logo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->logo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_logo" id= "fn_x_logo" value="<?= $Page->logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_logo" id= "fa_x_logo" value="0">
<input type="hidden" name="fs_x_logo" id= "fs_x_logo" value="45">
<input type="hidden" name="fx_x_logo" id= "fx_x_logo" value="<?= $Page->logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_logo" id= "fm_x_logo" value="<?= $Page->logo->UploadMaxFileSize ?>">
<table id="ft_x_logo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->openingDate->Visible) { // openingDate ?>
    <div id="r_openingDate"<?= $Page->openingDate->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_openingDate" for="x_openingDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->openingDate->caption() ?><?= $Page->openingDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->openingDate->cellAttributes() ?>>
<span id="el_fed_applicationschool_openingDate">
<input type="<?= $Page->openingDate->getInputTextType() ?>" name="x_openingDate" id="x_openingDate" data-table="fed_applicationschool" data-field="x_openingDate" value="<?= $Page->openingDate->EditValue ?>" data-page="1" placeholder="<?= HtmlEncode($Page->openingDate->getPlaceHolder()) ?>"<?= $Page->openingDate->editAttributes() ?> aria-describedby="x_openingDate_help">
<?= $Page->openingDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->openingDate->getErrorMessage() ?></div>
<?php if (!$Page->openingDate->ReadOnly && !$Page->openingDate->Disabled && !isset($Page->openingDate->EditAttrs["readonly"]) && !isset($Page->openingDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_applicationschooladd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_applicationschooladd", "x_openingDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_fed_applicationschool2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->owner->Visible) { // owner ?>
    <div id="r_owner"<?= $Page->owner->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_owner" for="x_owner" class="<?= $Page->LeftColumnClass ?>"><?= $Page->owner->caption() ?><?= $Page->owner->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->owner->cellAttributes() ?>>
<span id="el_fed_applicationschool_owner">
<input type="<?= $Page->owner->getInputTextType() ?>" name="x_owner" id="x_owner" data-table="fed_applicationschool" data-field="x_owner" value="<?= $Page->owner->EditValue ?>" data-page="2" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->owner->getPlaceHolder()) ?>"<?= $Page->owner->editAttributes() ?> aria-describedby="x_owner_help">
<?= $Page->owner->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->owner->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->identityNumber->Visible) { // identityNumber ?>
    <div id="r_identityNumber"<?= $Page->identityNumber->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_identityNumber" for="x_identityNumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->identityNumber->caption() ?><?= $Page->identityNumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->identityNumber->cellAttributes() ?>>
<span id="el_fed_applicationschool_identityNumber">
<input type="<?= $Page->identityNumber->getInputTextType() ?>" name="x_identityNumber" id="x_identityNumber" data-table="fed_applicationschool" data-field="x_identityNumber" value="<?= $Page->identityNumber->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->identityNumber->getPlaceHolder()) ?>"<?= $Page->identityNumber->editAttributes() ?> aria-describedby="x_identityNumber_help">
<?= $Page->identityNumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->identityNumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->birthDateOwner->Visible) { // birthDateOwner ?>
    <div id="r_birthDateOwner"<?= $Page->birthDateOwner->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_birthDateOwner" for="x_birthDateOwner" class="<?= $Page->LeftColumnClass ?>"><?= $Page->birthDateOwner->caption() ?><?= $Page->birthDateOwner->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->birthDateOwner->cellAttributes() ?>>
<span id="el_fed_applicationschool_birthDateOwner">
<input type="<?= $Page->birthDateOwner->getInputTextType() ?>" name="x_birthDateOwner" id="x_birthDateOwner" data-table="fed_applicationschool" data-field="x_birthDateOwner" value="<?= $Page->birthDateOwner->EditValue ?>" data-page="2" placeholder="<?= HtmlEncode($Page->birthDateOwner->getPlaceHolder()) ?>"<?= $Page->birthDateOwner->editAttributes() ?> aria-describedby="x_birthDateOwner_help">
<?= $Page->birthDateOwner->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->birthDateOwner->getErrorMessage() ?></div>
<?php if (!$Page->birthDateOwner->ReadOnly && !$Page->birthDateOwner->Disabled && !isset($Page->birthDateOwner->EditAttrs["readonly"]) && !isset($Page->birthDateOwner->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_applicationschooladd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_applicationschooladd", "x_birthDateOwner", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerCountryId->Visible) { // ownerCountryId ?>
    <div id="r_ownerCountryId"<?= $Page->ownerCountryId->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerCountryId" for="x_ownerCountryId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerCountryId->caption() ?><?= $Page->ownerCountryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerCountryId->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerCountryId">
<?php $Page->ownerCountryId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<div class="input-group flex-nowrap">
    <select
        id="x_ownerCountryId"
        name="x_ownerCountryId"
        class="form-select ew-select<?= $Page->ownerCountryId->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_ownerCountryId"
        data-table="fed_applicationschool"
        data-field="x_ownerCountryId"
        data-page="2"
        data-value-separator="<?= $Page->ownerCountryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ownerCountryId->getPlaceHolder()) ?>"
        <?= $Page->ownerCountryId->editAttributes() ?>>
        <?= $Page->ownerCountryId->selectOptionListHtml("x_ownerCountryId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_country") && !$Page->ownerCountryId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_ownerCountryId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->ownerCountryId->caption() ?>" data-title="<?= $Page->ownerCountryId->caption() ?>" data-ew-action="add-option" data-el="x_ownerCountryId" data-url="<?= GetUrl("ConfCountryAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->ownerCountryId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerCountryId->getErrorMessage() ?></div>
<?= $Page->ownerCountryId->Lookup->getParamTag($Page, "p_x_ownerCountryId") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_ownerCountryId", selectId: "ffed_applicationschooladd_x_ownerCountryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.ownerCountryId.lookupOptions.length) {
        options.data = { id: "x_ownerCountryId", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_ownerCountryId", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.ownerCountryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerStateId->Visible) { // ownerStateId ?>
    <div id="r_ownerStateId"<?= $Page->ownerStateId->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerStateId" for="x_ownerStateId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerStateId->caption() ?><?= $Page->ownerStateId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerStateId->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerStateId">
<?php $Page->ownerStateId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<div class="input-group flex-nowrap">
    <select
        id="x_ownerStateId"
        name="x_ownerStateId"
        class="form-select ew-select<?= $Page->ownerStateId->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_ownerStateId"
        data-table="fed_applicationschool"
        data-field="x_ownerStateId"
        data-page="2"
        data-value-separator="<?= $Page->ownerStateId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ownerStateId->getPlaceHolder()) ?>"
        <?= $Page->ownerStateId->editAttributes() ?>>
        <?= $Page->ownerStateId->selectOptionListHtml("x_ownerStateId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_uf") && !$Page->ownerStateId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_ownerStateId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->ownerStateId->caption() ?>" data-title="<?= $Page->ownerStateId->caption() ?>" data-ew-action="add-option" data-el="x_ownerStateId" data-url="<?= GetUrl("ConfUfAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->ownerStateId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerStateId->getErrorMessage() ?></div>
<?= $Page->ownerStateId->Lookup->getParamTag($Page, "p_x_ownerStateId") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_ownerStateId", selectId: "ffed_applicationschooladd_x_ownerStateId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.ownerStateId.lookupOptions.length) {
        options.data = { id: "x_ownerStateId", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_ownerStateId", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.ownerStateId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownCityId->Visible) { // ownCityId ?>
    <div id="r_ownCityId"<?= $Page->ownCityId->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownCityId" for="x_ownCityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownCityId->caption() ?><?= $Page->ownCityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownCityId->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownCityId">
<div class="input-group flex-nowrap">
    <select
        id="x_ownCityId"
        name="x_ownCityId"
        class="form-select ew-select<?= $Page->ownCityId->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_ownCityId"
        data-table="fed_applicationschool"
        data-field="x_ownCityId"
        data-page="2"
        data-value-separator="<?= $Page->ownCityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ownCityId->getPlaceHolder()) ?>"
        <?= $Page->ownCityId->editAttributes() ?>>
        <?= $Page->ownCityId->selectOptionListHtml("x_ownCityId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_city") && !$Page->ownCityId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_ownCityId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->ownCityId->caption() ?>" data-title="<?= $Page->ownCityId->caption() ?>" data-ew-action="add-option" data-el="x_ownCityId" data-url="<?= GetUrl("ConfCityAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->ownCityId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownCityId->getErrorMessage() ?></div>
<?= $Page->ownCityId->Lookup->getParamTag($Page, "p_x_ownCityId") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_ownCityId", selectId: "ffed_applicationschooladd_x_ownCityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.ownCityId.lookupOptions.length) {
        options.data = { id: "x_ownCityId", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_ownCityId", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.ownCityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerTelephone->Visible) { // ownerTelephone ?>
    <div id="r_ownerTelephone"<?= $Page->ownerTelephone->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerTelephone" for="x_ownerTelephone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerTelephone->caption() ?><?= $Page->ownerTelephone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerTelephone->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerTelephone">
<input type="<?= $Page->ownerTelephone->getInputTextType() ?>" name="x_ownerTelephone" id="x_ownerTelephone" data-table="fed_applicationschool" data-field="x_ownerTelephone" value="<?= $Page->ownerTelephone->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerTelephone->getPlaceHolder()) ?>"<?= $Page->ownerTelephone->editAttributes() ?> aria-describedby="x_ownerTelephone_help">
<?= $Page->ownerTelephone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerTelephone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerTelephoneWork->Visible) { // ownerTelephoneWork ?>
    <div id="r_ownerTelephoneWork"<?= $Page->ownerTelephoneWork->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerTelephoneWork" for="x_ownerTelephoneWork" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerTelephoneWork->caption() ?><?= $Page->ownerTelephoneWork->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerTelephoneWork->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerTelephoneWork">
<input type="<?= $Page->ownerTelephoneWork->getInputTextType() ?>" name="x_ownerTelephoneWork" id="x_ownerTelephoneWork" data-table="fed_applicationschool" data-field="x_ownerTelephoneWork" value="<?= $Page->ownerTelephoneWork->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerTelephoneWork->getPlaceHolder()) ?>"<?= $Page->ownerTelephoneWork->editAttributes() ?> aria-describedby="x_ownerTelephoneWork_help">
<?= $Page->ownerTelephoneWork->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerTelephoneWork->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerProfession->Visible) { // ownerProfession ?>
    <div id="r_ownerProfession"<?= $Page->ownerProfession->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerProfession" for="x_ownerProfession" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerProfession->caption() ?><?= $Page->ownerProfession->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerProfession->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerProfession">
<input type="<?= $Page->ownerProfession->getInputTextType() ?>" name="x_ownerProfession" id="x_ownerProfession" data-table="fed_applicationschool" data-field="x_ownerProfession" value="<?= $Page->ownerProfession->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerProfession->getPlaceHolder()) ?>"<?= $Page->ownerProfession->editAttributes() ?> aria-describedby="x_ownerProfession_help">
<?= $Page->ownerProfession->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerProfession->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->employer->Visible) { // employer ?>
    <div id="r_employer"<?= $Page->employer->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_employer" for="x_employer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->employer->caption() ?><?= $Page->employer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->employer->cellAttributes() ?>>
<span id="el_fed_applicationschool_employer">
<input type="<?= $Page->employer->getInputTextType() ?>" name="x_employer" id="x_employer" data-table="fed_applicationschool" data-field="x_employer" value="<?= $Page->employer->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->employer->getPlaceHolder()) ?>"<?= $Page->employer->editAttributes() ?> aria-describedby="x_employer_help">
<?= $Page->employer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->employer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerGraduation->Visible) { // ownerGraduation ?>
    <div id="r_ownerGraduation"<?= $Page->ownerGraduation->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerGraduation" for="x_ownerGraduation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerGraduation->caption() ?><?= $Page->ownerGraduation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerGraduation->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerGraduation">
    <select
        id="x_ownerGraduation"
        name="x_ownerGraduation"
        class="form-select ew-select<?= $Page->ownerGraduation->isInvalidClass() ?>"
        data-select2-id="ffed_applicationschooladd_x_ownerGraduation"
        data-table="fed_applicationschool"
        data-field="x_ownerGraduation"
        data-page="2"
        data-value-separator="<?= $Page->ownerGraduation->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ownerGraduation->getPlaceHolder()) ?>"
        <?= $Page->ownerGraduation->editAttributes() ?>>
        <?= $Page->ownerGraduation->selectOptionListHtml("x_ownerGraduation") ?>
    </select>
    <?= $Page->ownerGraduation->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ownerGraduation->getErrorMessage() ?></div>
<?= $Page->ownerGraduation->Lookup->getParamTag($Page, "p_x_ownerGraduation") ?>
<script>
loadjs.ready("ffed_applicationschooladd", function() {
    var options = { name: "x_ownerGraduation", selectId: "ffed_applicationschooladd_x_ownerGraduation" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_applicationschooladd.lists.ownerGraduation.lookupOptions.length) {
        options.data = { id: "x_ownerGraduation", form: "ffed_applicationschooladd" };
    } else {
        options.ajax = { id: "x_ownerGraduation", form: "ffed_applicationschooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_applicationschool.fields.ownerGraduation.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerGraduationLocation->Visible) { // ownerGraduationLocation ?>
    <div id="r_ownerGraduationLocation"<?= $Page->ownerGraduationLocation->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerGraduationLocation" for="x_ownerGraduationLocation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerGraduationLocation->caption() ?><?= $Page->ownerGraduationLocation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerGraduationLocation->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerGraduationLocation">
<input type="<?= $Page->ownerGraduationLocation->getInputTextType() ?>" name="x_ownerGraduationLocation" id="x_ownerGraduationLocation" data-table="fed_applicationschool" data-field="x_ownerGraduationLocation" value="<?= $Page->ownerGraduationLocation->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerGraduationLocation->getPlaceHolder()) ?>"<?= $Page->ownerGraduationLocation->editAttributes() ?> aria-describedby="x_ownerGraduationLocation_help">
<?= $Page->ownerGraduationLocation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerGraduationLocation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerGraduationObs->Visible) { // ownerGraduationObs ?>
    <div id="r_ownerGraduationObs"<?= $Page->ownerGraduationObs->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerGraduationObs" for="x_ownerGraduationObs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerGraduationObs->caption() ?><?= $Page->ownerGraduationObs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerGraduationObs->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerGraduationObs">
<textarea data-table="fed_applicationschool" data-field="x_ownerGraduationObs" data-page="2" name="x_ownerGraduationObs" id="x_ownerGraduationObs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->ownerGraduationObs->getPlaceHolder()) ?>"<?= $Page->ownerGraduationObs->editAttributes() ?> aria-describedby="x_ownerGraduationObs_help"><?= $Page->ownerGraduationObs->EditValue ?></textarea>
<?= $Page->ownerGraduationObs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerGraduationObs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerMaritalStatus->Visible) { // ownerMaritalStatus ?>
    <div id="r_ownerMaritalStatus"<?= $Page->ownerMaritalStatus->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerMaritalStatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerMaritalStatus->caption() ?><?= $Page->ownerMaritalStatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerMaritalStatus->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerMaritalStatus">
<template id="tp_x_ownerMaritalStatus">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_applicationschool" data-field="x_ownerMaritalStatus" name="x_ownerMaritalStatus" id="x_ownerMaritalStatus"<?= $Page->ownerMaritalStatus->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_ownerMaritalStatus" class="ew-item-list"></div>
<selection-list hidden
    id="x_ownerMaritalStatus"
    name="x_ownerMaritalStatus"
    value="<?= HtmlEncode($Page->ownerMaritalStatus->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ownerMaritalStatus"
    data-bs-target="dsl_x_ownerMaritalStatus"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ownerMaritalStatus->isInvalidClass() ?>"
    data-table="fed_applicationschool"
    data-field="x_ownerMaritalStatus"
    data-page="2"
    data-value-separator="<?= $Page->ownerMaritalStatus->displayValueSeparatorAttribute() ?>"
    <?= $Page->ownerMaritalStatus->editAttributes() ?>></selection-list>
<?= $Page->ownerMaritalStatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerMaritalStatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerSpouseName->Visible) { // ownerSpouseName ?>
    <div id="r_ownerSpouseName"<?= $Page->ownerSpouseName->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerSpouseName" for="x_ownerSpouseName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerSpouseName->caption() ?><?= $Page->ownerSpouseName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerSpouseName->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerSpouseName">
<input type="<?= $Page->ownerSpouseName->getInputTextType() ?>" name="x_ownerSpouseName" id="x_ownerSpouseName" data-table="fed_applicationschool" data-field="x_ownerSpouseName" value="<?= $Page->ownerSpouseName->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerSpouseName->getPlaceHolder()) ?>"<?= $Page->ownerSpouseName->editAttributes() ?> aria-describedby="x_ownerSpouseName_help">
<?= $Page->ownerSpouseName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerSpouseName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerSpouseProfession->Visible) { // ownerSpouseProfession ?>
    <div id="r_ownerSpouseProfession"<?= $Page->ownerSpouseProfession->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerSpouseProfession" for="x_ownerSpouseProfession" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerSpouseProfession->caption() ?><?= $Page->ownerSpouseProfession->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerSpouseProfession->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerSpouseProfession">
<input type="<?= $Page->ownerSpouseProfession->getInputTextType() ?>" name="x_ownerSpouseProfession" id="x_ownerSpouseProfession" data-table="fed_applicationschool" data-field="x_ownerSpouseProfession" value="<?= $Page->ownerSpouseProfession->EditValue ?>" data-page="2" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerSpouseProfession->getPlaceHolder()) ?>"<?= $Page->ownerSpouseProfession->editAttributes() ?> aria-describedby="x_ownerSpouseProfession_help">
<?= $Page->ownerSpouseProfession->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerSpouseProfession->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->propertySituation->Visible) { // propertySituation ?>
    <div id="r_propertySituation"<?= $Page->propertySituation->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_propertySituation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->propertySituation->caption() ?><?= $Page->propertySituation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->propertySituation->cellAttributes() ?>>
<span id="el_fed_applicationschool_propertySituation">
<template id="tp_x_propertySituation">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_applicationschool" data-field="x_propertySituation" name="x_propertySituation" id="x_propertySituation"<?= $Page->propertySituation->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_propertySituation" class="ew-item-list"></div>
<selection-list hidden
    id="x_propertySituation"
    name="x_propertySituation"
    value="<?= HtmlEncode($Page->propertySituation->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_propertySituation"
    data-bs-target="dsl_x_propertySituation"
    data-repeatcolumn="5"
    class="form-control<?= $Page->propertySituation->isInvalidClass() ?>"
    data-table="fed_applicationschool"
    data-field="x_propertySituation"
    data-page="2"
    data-value-separator="<?= $Page->propertySituation->displayValueSeparatorAttribute() ?>"
    <?= $Page->propertySituation->editAttributes() ?>></selection-list>
<?= $Page->propertySituation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->propertySituation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->numberOfStudentsInBeginnig->Visible) { // numberOfStudentsInBeginnig ?>
    <div id="r_numberOfStudentsInBeginnig"<?= $Page->numberOfStudentsInBeginnig->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_numberOfStudentsInBeginnig" for="x_numberOfStudentsInBeginnig" class="<?= $Page->LeftColumnClass ?>"><?= $Page->numberOfStudentsInBeginnig->caption() ?><?= $Page->numberOfStudentsInBeginnig->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->numberOfStudentsInBeginnig->cellAttributes() ?>>
<span id="el_fed_applicationschool_numberOfStudentsInBeginnig">
<input type="<?= $Page->numberOfStudentsInBeginnig->getInputTextType() ?>" name="x_numberOfStudentsInBeginnig" id="x_numberOfStudentsInBeginnig" data-table="fed_applicationschool" data-field="x_numberOfStudentsInBeginnig" value="<?= $Page->numberOfStudentsInBeginnig->EditValue ?>" data-page="2" size="30" placeholder="<?= HtmlEncode($Page->numberOfStudentsInBeginnig->getPlaceHolder()) ?>"<?= $Page->numberOfStudentsInBeginnig->editAttributes() ?> aria-describedby="x_numberOfStudentsInBeginnig_help">
<?= $Page->numberOfStudentsInBeginnig->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->numberOfStudentsInBeginnig->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerAbout->Visible) { // ownerAbout ?>
    <div id="r_ownerAbout"<?= $Page->ownerAbout->rowAttributes() ?>>
        <label id="elh_fed_applicationschool_ownerAbout" for="x_ownerAbout" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerAbout->caption() ?><?= $Page->ownerAbout->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerAbout->cellAttributes() ?>>
<span id="el_fed_applicationschool_ownerAbout">
<textarea data-table="fed_applicationschool" data-field="x_ownerAbout" data-page="2" name="x_ownerAbout" id="x_ownerAbout" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->ownerAbout->getPlaceHolder()) ?>"<?= $Page->ownerAbout->editAttributes() ?> aria-describedby="x_ownerAbout_help"><?= $Page->ownerAbout->EditValue ?></textarea>
<?= $Page->ownerAbout->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerAbout->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav<?= $Page->DetailPages->containerClasses() ?>" id="details_Page"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navClasses() ?>" role="tablist"><!-- .nav -->
<?php
    if (in_array("fed_school", explode(",", $Page->getCurrentDetailTable())) && $fed_school->DetailAdd) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("fed_school") ?><?= $Page->DetailPages->activeClasses("fed_school") ?>" data-bs-target="#tab_fed_school" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fed_school" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("fed_school")) ?>"><?= $Language->tablePhrase("fed_school", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("fed_licenseschool", explode(",", $Page->getCurrentDetailTable())) && $fed_licenseschool->DetailAdd) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("fed_licenseschool") ?><?= $Page->DetailPages->activeClasses("fed_licenseschool") ?>" data-bs-target="#tab_fed_licenseschool" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_fed_licenseschool" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("fed_licenseschool")) ?>"><?= $Language->tablePhrase("fed_licenseschool", "TblCaption") ?></button></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="<?= $Page->DetailPages->tabContentClasses() ?>"><!-- .tab-content -->
<?php
    if (in_array("fed_school", explode(",", $Page->getCurrentDetailTable())) && $fed_school->DetailAdd) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("fed_school") ?><?= $Page->DetailPages->activeClasses("fed_school") ?>" id="tab_fed_school" role="tabpanel"><!-- page* -->
<?php include_once "FedSchoolGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("fed_licenseschool", explode(",", $Page->getCurrentDetailTable())) && $fed_licenseschool->DetailAdd) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("fed_licenseschool") ?><?= $Page->DetailPages->activeClasses("fed_licenseschool") ?>" id="tab_fed_licenseschool" role="tabpanel"><!-- page* -->
<?php include_once "FedLicenseschoolGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
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
    ew.addEventHandlers("fed_applicationschool");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
