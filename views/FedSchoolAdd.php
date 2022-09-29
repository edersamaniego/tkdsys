<?php

namespace PHPMaker2022\school;

// Page object
$FedSchoolAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_school: currentTable } });
var currentForm, currentPageID;
var ffed_schooladd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_schooladd = new ew.Form("ffed_schooladd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = ffed_schooladd;

    // Add fields
    var fields = currentTable.fields;
    ffed_schooladd.addFields([
        ["federationId", [fields.federationId.visible && fields.federationId.required ? ew.Validators.required(fields.federationId.caption) : null], fields.federationId.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
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
        ["logo", [fields.logo.visible && fields.logo.required ? ew.Validators.required(fields.logo.caption) : null], fields.logo.isInvalid],
        ["openingDate", [fields.openingDate.visible && fields.openingDate.required ? ew.Validators.required(fields.openingDate.caption) : null, ew.Validators.datetime(fields.openingDate.clientFormatPattern)], fields.openingDate.isInvalid],
        ["federationRegister", [fields.federationRegister.visible && fields.federationRegister.required ? ew.Validators.required(fields.federationRegister.caption) : null], fields.federationRegister.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null, ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid],
        ["typeId", [fields.typeId.visible && fields.typeId.required ? ew.Validators.required(fields.typeId.caption) : null, ew.Validators.integer], fields.typeId.isInvalid],
        ["owner", [fields.owner.visible && fields.owner.required ? ew.Validators.required(fields.owner.caption) : null], fields.owner.isInvalid],
        ["identityNumber", [fields.identityNumber.visible && fields.identityNumber.required ? ew.Validators.required(fields.identityNumber.caption) : null], fields.identityNumber.isInvalid],
        ["birthDateOwner", [fields.birthDateOwner.visible && fields.birthDateOwner.required ? ew.Validators.required(fields.birthDateOwner.caption) : null, ew.Validators.datetime(fields.birthDateOwner.clientFormatPattern)], fields.birthDateOwner.isInvalid],
        ["ownerCountryId", [fields.ownerCountryId.visible && fields.ownerCountryId.required ? ew.Validators.required(fields.ownerCountryId.caption) : null, ew.Validators.integer], fields.ownerCountryId.isInvalid],
        ["ownerStateId", [fields.ownerStateId.visible && fields.ownerStateId.required ? ew.Validators.required(fields.ownerStateId.caption) : null, ew.Validators.integer], fields.ownerStateId.isInvalid],
        ["ownCityId", [fields.ownCityId.visible && fields.ownCityId.required ? ew.Validators.required(fields.ownCityId.caption) : null, ew.Validators.integer], fields.ownCityId.isInvalid],
        ["ownerTelephone", [fields.ownerTelephone.visible && fields.ownerTelephone.required ? ew.Validators.required(fields.ownerTelephone.caption) : null], fields.ownerTelephone.isInvalid],
        ["ownerTelephoneWork", [fields.ownerTelephoneWork.visible && fields.ownerTelephoneWork.required ? ew.Validators.required(fields.ownerTelephoneWork.caption) : null], fields.ownerTelephoneWork.isInvalid],
        ["ownerProfession", [fields.ownerProfession.visible && fields.ownerProfession.required ? ew.Validators.required(fields.ownerProfession.caption) : null], fields.ownerProfession.isInvalid],
        ["employer", [fields.employer.visible && fields.employer.required ? ew.Validators.required(fields.employer.caption) : null], fields.employer.isInvalid],
        ["ownerGraduation", [fields.ownerGraduation.visible && fields.ownerGraduation.required ? ew.Validators.required(fields.ownerGraduation.caption) : null, ew.Validators.integer], fields.ownerGraduation.isInvalid],
        ["ownerGraduationLocation", [fields.ownerGraduationLocation.visible && fields.ownerGraduationLocation.required ? ew.Validators.required(fields.ownerGraduationLocation.caption) : null], fields.ownerGraduationLocation.isInvalid],
        ["ownerGraduationObs", [fields.ownerGraduationObs.visible && fields.ownerGraduationObs.required ? ew.Validators.required(fields.ownerGraduationObs.caption) : null], fields.ownerGraduationObs.isInvalid],
        ["ownerMaritalStatus", [fields.ownerMaritalStatus.visible && fields.ownerMaritalStatus.required ? ew.Validators.required(fields.ownerMaritalStatus.caption) : null, ew.Validators.integer], fields.ownerMaritalStatus.isInvalid],
        ["ownerSpouseName", [fields.ownerSpouseName.visible && fields.ownerSpouseName.required ? ew.Validators.required(fields.ownerSpouseName.caption) : null], fields.ownerSpouseName.isInvalid],
        ["ownerSpouseProfession", [fields.ownerSpouseProfession.visible && fields.ownerSpouseProfession.required ? ew.Validators.required(fields.ownerSpouseProfession.caption) : null], fields.ownerSpouseProfession.isInvalid],
        ["propertySituation", [fields.propertySituation.visible && fields.propertySituation.required ? ew.Validators.required(fields.propertySituation.caption) : null, ew.Validators.integer], fields.propertySituation.isInvalid],
        ["numberOfStudentsInBeginnig", [fields.numberOfStudentsInBeginnig.visible && fields.numberOfStudentsInBeginnig.required ? ew.Validators.required(fields.numberOfStudentsInBeginnig.caption) : null, ew.Validators.integer], fields.numberOfStudentsInBeginnig.isInvalid],
        ["ownerAbout", [fields.ownerAbout.visible && fields.ownerAbout.required ? ew.Validators.required(fields.ownerAbout.caption) : null], fields.ownerAbout.isInvalid],
        ["pdfLicense", [fields.pdfLicense.visible && fields.pdfLicense.required ? ew.Validators.required(fields.pdfLicense.caption) : null], fields.pdfLicense.isInvalid],
        ["applicationId", [fields.applicationId.visible && fields.applicationId.required ? ew.Validators.required(fields.applicationId.caption) : null, ew.Validators.integer], fields.applicationId.isInvalid],
        ["isheadquarter", [fields.isheadquarter.visible && fields.isheadquarter.required ? ew.Validators.required(fields.isheadquarter.caption) : null], fields.isheadquarter.isInvalid]
    ]);

    // Form_CustomValidate
    ffed_schooladd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_schooladd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_schooladd.lists.federationId = <?= $Page->federationId->toClientList($Page) ?>;
    ffed_schooladd.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;
    ffed_schooladd.lists.countryId = <?= $Page->countryId->toClientList($Page) ?>;
    ffed_schooladd.lists.UFId = <?= $Page->UFId->toClientList($Page) ?>;
    ffed_schooladd.lists.cityId = <?= $Page->cityId->toClientList($Page) ?>;
    ffed_schooladd.lists.isheadquarter = <?= $Page->isheadquarter->toClientList($Page) ?>;
    loadjs.done("ffed_schooladd");
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
<form name="ffed_schooladd" id="ffed_schooladd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_school">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fed_applicationschool") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_applicationschool">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->applicationId->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->federationId->Visible) { // federationId ?>
    <div id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <label id="elh_fed_school_federationId" for="x_federationId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationId->caption() ?><?= $Page->federationId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationId->cellAttributes() ?>>
<span id="el_fed_school_federationId">
    <select
        id="x_federationId"
        name="x_federationId"
        class="form-select ew-select<?= $Page->federationId->isInvalidClass() ?>"
        data-select2-id="ffed_schooladd_x_federationId"
        data-table="fed_school"
        data-field="x_federationId"
        data-value-separator="<?= $Page->federationId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->federationId->getPlaceHolder()) ?>"
        <?= $Page->federationId->editAttributes() ?>>
        <?= $Page->federationId->selectOptionListHtml("x_federationId") ?>
    </select>
    <?= $Page->federationId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->federationId->getErrorMessage() ?></div>
<?= $Page->federationId->Lookup->getParamTag($Page, "p_x_federationId") ?>
<script>
loadjs.ready("ffed_schooladd", function() {
    var options = { name: "x_federationId", selectId: "ffed_schooladd_x_federationId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schooladd.lists.federationId.lookupOptions.length) {
        options.data = { id: "x_federationId", form: "ffed_schooladd" };
    } else {
        options.ajax = { id: "x_federationId", form: "ffed_schooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.federationId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <div id="r_masterSchoolId"<?= $Page->masterSchoolId->rowAttributes() ?>>
        <label id="elh_fed_school_masterSchoolId" for="x_masterSchoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->masterSchoolId->caption() ?><?= $Page->masterSchoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el_fed_school_masterSchoolId">
<?php $Page->masterSchoolId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_masterSchoolId"
        name="x_masterSchoolId"
        class="form-select ew-select<?= $Page->masterSchoolId->isInvalidClass() ?>"
        data-select2-id="ffed_schooladd_x_masterSchoolId"
        data-table="fed_school"
        data-field="x_masterSchoolId"
        data-value-separator="<?= $Page->masterSchoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->masterSchoolId->getPlaceHolder()) ?>"
        <?= $Page->masterSchoolId->editAttributes() ?>>
        <?= $Page->masterSchoolId->selectOptionListHtml("x_masterSchoolId") ?>
    </select>
    <?= $Page->masterSchoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->masterSchoolId->getErrorMessage() ?></div>
<?= $Page->masterSchoolId->Lookup->getParamTag($Page, "p_x_masterSchoolId") ?>
<script>
loadjs.ready("ffed_schooladd", function() {
    var options = { name: "x_masterSchoolId", selectId: "ffed_schooladd_x_masterSchoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schooladd.lists.masterSchoolId.lookupOptions.length) {
        options.data = { id: "x_masterSchoolId", form: "ffed_schooladd" };
    } else {
        options.ajax = { id: "x_masterSchoolId", form: "ffed_schooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.masterSchoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
    <div id="r_school"<?= $Page->school->rowAttributes() ?>>
        <label id="elh_fed_school_school" for="x_school" class="<?= $Page->LeftColumnClass ?>"><?= $Page->school->caption() ?><?= $Page->school->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->school->cellAttributes() ?>>
<span id="el_fed_school_school">
<input type="<?= $Page->school->getInputTextType() ?>" name="x_school" id="x_school" data-table="fed_school" data-field="x_school" value="<?= $Page->school->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->school->getPlaceHolder()) ?>"<?= $Page->school->editAttributes() ?> aria-describedby="x_school_help">
<?= $Page->school->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->school->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <div id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <label id="elh_fed_school_countryId" for="x_countryId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->countryId->caption() ?><?= $Page->countryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->countryId->cellAttributes() ?>>
<span id="el_fed_school_countryId">
<?php $Page->countryId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_countryId"
        name="x_countryId"
        class="form-select ew-select<?= $Page->countryId->isInvalidClass() ?>"
        data-select2-id="ffed_schooladd_x_countryId"
        data-table="fed_school"
        data-field="x_countryId"
        data-value-separator="<?= $Page->countryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->countryId->getPlaceHolder()) ?>"
        <?= $Page->countryId->editAttributes() ?>>
        <?= $Page->countryId->selectOptionListHtml("x_countryId") ?>
    </select>
    <?= $Page->countryId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->countryId->getErrorMessage() ?></div>
<?= $Page->countryId->Lookup->getParamTag($Page, "p_x_countryId") ?>
<script>
loadjs.ready("ffed_schooladd", function() {
    var options = { name: "x_countryId", selectId: "ffed_schooladd_x_countryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schooladd.lists.countryId.lookupOptions.length) {
        options.data = { id: "x_countryId", form: "ffed_schooladd" };
    } else {
        options.ajax = { id: "x_countryId", form: "ffed_schooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.countryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
    <div id="r_UFId"<?= $Page->UFId->rowAttributes() ?>>
        <label id="elh_fed_school_UFId" for="x_UFId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UFId->caption() ?><?= $Page->UFId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UFId->cellAttributes() ?>>
<span id="el_fed_school_UFId">
<?php $Page->UFId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<div class="input-group flex-nowrap">
    <select
        id="x_UFId"
        name="x_UFId"
        class="form-select ew-select<?= $Page->UFId->isInvalidClass() ?>"
        data-select2-id="ffed_schooladd_x_UFId"
        data-table="fed_school"
        data-field="x_UFId"
        data-value-separator="<?= $Page->UFId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->UFId->getPlaceHolder()) ?>"
        <?= $Page->UFId->editAttributes() ?>>
        <?= $Page->UFId->selectOptionListHtml("x_UFId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_uf") && !$Page->UFId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_UFId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->UFId->caption() ?>" data-title="<?= $Page->UFId->caption() ?>" data-ew-action="add-option" data-el="x_UFId" data-url="<?= GetUrl("ConfUfAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->UFId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->UFId->getErrorMessage() ?></div>
<?= $Page->UFId->Lookup->getParamTag($Page, "p_x_UFId") ?>
<script>
loadjs.ready("ffed_schooladd", function() {
    var options = { name: "x_UFId", selectId: "ffed_schooladd_x_UFId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schooladd.lists.UFId.lookupOptions.length) {
        options.data = { id: "x_UFId", form: "ffed_schooladd" };
    } else {
        options.ajax = { id: "x_UFId", form: "ffed_schooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.UFId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
    <div id="r_cityId"<?= $Page->cityId->rowAttributes() ?>>
        <label id="elh_fed_school_cityId" for="x_cityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cityId->caption() ?><?= $Page->cityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cityId->cellAttributes() ?>>
<span id="el_fed_school_cityId">
<div class="input-group flex-nowrap">
    <select
        id="x_cityId"
        name="x_cityId"
        class="form-select ew-select<?= $Page->cityId->isInvalidClass() ?>"
        data-select2-id="ffed_schooladd_x_cityId"
        data-table="fed_school"
        data-field="x_cityId"
        data-value-separator="<?= $Page->cityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cityId->getPlaceHolder()) ?>"
        <?= $Page->cityId->editAttributes() ?>>
        <?= $Page->cityId->selectOptionListHtml("x_cityId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_city") && !$Page->cityId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_cityId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Page->cityId->caption() ?>" data-title="<?= $Page->cityId->caption() ?>" data-ew-action="add-option" data-el="x_cityId" data-url="<?= GetUrl("ConfCityAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<?= $Page->cityId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cityId->getErrorMessage() ?></div>
<?= $Page->cityId->Lookup->getParamTag($Page, "p_x_cityId") ?>
<script>
loadjs.ready("ffed_schooladd", function() {
    var options = { name: "x_cityId", selectId: "ffed_schooladd_x_cityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schooladd.lists.cityId.lookupOptions.length) {
        options.data = { id: "x_cityId", form: "ffed_schooladd" };
    } else {
        options.ajax = { id: "x_cityId", form: "ffed_schooladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.cityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <div id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <label id="elh_fed_school_neighborhood" for="x_neighborhood" class="<?= $Page->LeftColumnClass ?>"><?= $Page->neighborhood->caption() ?><?= $Page->neighborhood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fed_school_neighborhood">
<input type="<?= $Page->neighborhood->getInputTextType() ?>" name="x_neighborhood" id="x_neighborhood" data-table="fed_school" data-field="x_neighborhood" value="<?= $Page->neighborhood->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->neighborhood->getPlaceHolder()) ?>"<?= $Page->neighborhood->editAttributes() ?> aria-describedby="x_neighborhood_help">
<?= $Page->neighborhood->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->neighborhood->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_fed_school_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_fed_school_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="fed_school" data-field="x_address" value="<?= $Page->address->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
    <div id="r_zipcode"<?= $Page->zipcode->rowAttributes() ?>>
        <label id="elh_fed_school_zipcode" for="x_zipcode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->zipcode->caption() ?><?= $Page->zipcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->zipcode->cellAttributes() ?>>
<span id="el_fed_school_zipcode">
<input type="<?= $Page->zipcode->getInputTextType() ?>" name="x_zipcode" id="x_zipcode" data-table="fed_school" data-field="x_zipcode" value="<?= $Page->zipcode->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->zipcode->getPlaceHolder()) ?>"<?= $Page->zipcode->editAttributes() ?> aria-describedby="x_zipcode_help">
<?= $Page->zipcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->zipcode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website"<?= $Page->website->rowAttributes() ?>>
        <label id="elh_fed_school_website" for="x_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->website->cellAttributes() ?>>
<span id="el_fed_school_website">
<input type="<?= $Page->website->getInputTextType() ?>" name="x_website" id="x_website" data-table="fed_school" data-field="x_website" value="<?= $Page->website->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>"<?= $Page->website->editAttributes() ?> aria-describedby="x_website_help">
<?= $Page->website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_fed_school__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_fed_school__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="fed_school" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <div id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <label id="elh_fed_school_phone" for="x_phone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone->caption() ?><?= $Page->phone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->phone->cellAttributes() ?>>
<span id="el_fed_school_phone">
<input type="<?= $Page->phone->getInputTextType() ?>" name="x_phone" id="x_phone" data-table="fed_school" data-field="x_phone" value="<?= $Page->phone->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->phone->getPlaceHolder()) ?>"<?= $Page->phone->editAttributes() ?> aria-describedby="x_phone_help">
<?= $Page->phone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->celphone->Visible) { // celphone ?>
    <div id="r_celphone"<?= $Page->celphone->rowAttributes() ?>>
        <label id="elh_fed_school_celphone" for="x_celphone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->celphone->caption() ?><?= $Page->celphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->celphone->cellAttributes() ?>>
<span id="el_fed_school_celphone">
<input type="<?= $Page->celphone->getInputTextType() ?>" name="x_celphone" id="x_celphone" data-table="fed_school" data-field="x_celphone" value="<?= $Page->celphone->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->celphone->getPlaceHolder()) ?>"<?= $Page->celphone->editAttributes() ?> aria-describedby="x_celphone_help">
<?= $Page->celphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->celphone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
    <div id="r_logo"<?= $Page->logo->rowAttributes() ?>>
        <label id="elh_fed_school_logo" for="x_logo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->logo->caption() ?><?= $Page->logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->logo->cellAttributes() ?>>
<span id="el_fed_school_logo">
<input type="<?= $Page->logo->getInputTextType() ?>" name="x_logo" id="x_logo" data-table="fed_school" data-field="x_logo" value="<?= $Page->logo->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->logo->getPlaceHolder()) ?>"<?= $Page->logo->editAttributes() ?> aria-describedby="x_logo_help">
<?= $Page->logo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->logo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->openingDate->Visible) { // openingDate ?>
    <div id="r_openingDate"<?= $Page->openingDate->rowAttributes() ?>>
        <label id="elh_fed_school_openingDate" for="x_openingDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->openingDate->caption() ?><?= $Page->openingDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->openingDate->cellAttributes() ?>>
<span id="el_fed_school_openingDate">
<input type="<?= $Page->openingDate->getInputTextType() ?>" name="x_openingDate" id="x_openingDate" data-table="fed_school" data-field="x_openingDate" value="<?= $Page->openingDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->openingDate->getPlaceHolder()) ?>"<?= $Page->openingDate->editAttributes() ?> aria-describedby="x_openingDate_help">
<?= $Page->openingDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->openingDate->getErrorMessage() ?></div>
<?php if (!$Page->openingDate->ReadOnly && !$Page->openingDate->Disabled && !isset($Page->openingDate->EditAttrs["readonly"]) && !isset($Page->openingDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_schooladd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_schooladd", "x_openingDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
    <div id="r_federationRegister"<?= $Page->federationRegister->rowAttributes() ?>>
        <label id="elh_fed_school_federationRegister" for="x_federationRegister" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationRegister->caption() ?><?= $Page->federationRegister->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el_fed_school_federationRegister">
<input type="<?= $Page->federationRegister->getInputTextType() ?>" name="x_federationRegister" id="x_federationRegister" data-table="fed_school" data-field="x_federationRegister" value="<?= $Page->federationRegister->EditValue ?>" size="30" maxlength="6" placeholder="<?= HtmlEncode($Page->federationRegister->getPlaceHolder()) ?>"<?= $Page->federationRegister->editAttributes() ?> aria-describedby="x_federationRegister_help">
<?= $Page->federationRegister->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationRegister->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label id="elh_fed_school_createUserId" for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createUserId->caption() ?><?= $Page->createUserId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_fed_school_createUserId">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="fed_school" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?> aria-describedby="x_createUserId_help">
<?= $Page->createUserId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label id="elh_fed_school_createDate" for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?><?= $Page->createDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_school_createDate">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_school" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?> aria-describedby="x_createDate_help">
<?= $Page->createDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage() ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_schooladd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_schooladd", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
    <div id="r_typeId"<?= $Page->typeId->rowAttributes() ?>>
        <label id="elh_fed_school_typeId" for="x_typeId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->typeId->caption() ?><?= $Page->typeId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->typeId->cellAttributes() ?>>
<span id="el_fed_school_typeId">
<input type="<?= $Page->typeId->getInputTextType() ?>" name="x_typeId" id="x_typeId" data-table="fed_school" data-field="x_typeId" value="<?= $Page->typeId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->typeId->getPlaceHolder()) ?>"<?= $Page->typeId->editAttributes() ?> aria-describedby="x_typeId_help">
<?= $Page->typeId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->typeId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
    <div id="r_owner"<?= $Page->owner->rowAttributes() ?>>
        <label id="elh_fed_school_owner" for="x_owner" class="<?= $Page->LeftColumnClass ?>"><?= $Page->owner->caption() ?><?= $Page->owner->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->owner->cellAttributes() ?>>
<span id="el_fed_school_owner">
<input type="<?= $Page->owner->getInputTextType() ?>" name="x_owner" id="x_owner" data-table="fed_school" data-field="x_owner" value="<?= $Page->owner->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->owner->getPlaceHolder()) ?>"<?= $Page->owner->editAttributes() ?> aria-describedby="x_owner_help">
<?= $Page->owner->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->owner->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->identityNumber->Visible) { // identityNumber ?>
    <div id="r_identityNumber"<?= $Page->identityNumber->rowAttributes() ?>>
        <label id="elh_fed_school_identityNumber" for="x_identityNumber" class="<?= $Page->LeftColumnClass ?>"><?= $Page->identityNumber->caption() ?><?= $Page->identityNumber->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->identityNumber->cellAttributes() ?>>
<span id="el_fed_school_identityNumber">
<input type="<?= $Page->identityNumber->getInputTextType() ?>" name="x_identityNumber" id="x_identityNumber" data-table="fed_school" data-field="x_identityNumber" value="<?= $Page->identityNumber->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->identityNumber->getPlaceHolder()) ?>"<?= $Page->identityNumber->editAttributes() ?> aria-describedby="x_identityNumber_help">
<?= $Page->identityNumber->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->identityNumber->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->birthDateOwner->Visible) { // birthDateOwner ?>
    <div id="r_birthDateOwner"<?= $Page->birthDateOwner->rowAttributes() ?>>
        <label id="elh_fed_school_birthDateOwner" for="x_birthDateOwner" class="<?= $Page->LeftColumnClass ?>"><?= $Page->birthDateOwner->caption() ?><?= $Page->birthDateOwner->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->birthDateOwner->cellAttributes() ?>>
<span id="el_fed_school_birthDateOwner">
<input type="<?= $Page->birthDateOwner->getInputTextType() ?>" name="x_birthDateOwner" id="x_birthDateOwner" data-table="fed_school" data-field="x_birthDateOwner" value="<?= $Page->birthDateOwner->EditValue ?>" placeholder="<?= HtmlEncode($Page->birthDateOwner->getPlaceHolder()) ?>"<?= $Page->birthDateOwner->editAttributes() ?> aria-describedby="x_birthDateOwner_help">
<?= $Page->birthDateOwner->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->birthDateOwner->getErrorMessage() ?></div>
<?php if (!$Page->birthDateOwner->ReadOnly && !$Page->birthDateOwner->Disabled && !isset($Page->birthDateOwner->EditAttrs["readonly"]) && !isset($Page->birthDateOwner->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_schooladd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_schooladd", "x_birthDateOwner", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerCountryId->Visible) { // ownerCountryId ?>
    <div id="r_ownerCountryId"<?= $Page->ownerCountryId->rowAttributes() ?>>
        <label id="elh_fed_school_ownerCountryId" for="x_ownerCountryId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerCountryId->caption() ?><?= $Page->ownerCountryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerCountryId->cellAttributes() ?>>
<span id="el_fed_school_ownerCountryId">
<input type="<?= $Page->ownerCountryId->getInputTextType() ?>" name="x_ownerCountryId" id="x_ownerCountryId" data-table="fed_school" data-field="x_ownerCountryId" value="<?= $Page->ownerCountryId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ownerCountryId->getPlaceHolder()) ?>"<?= $Page->ownerCountryId->editAttributes() ?> aria-describedby="x_ownerCountryId_help">
<?= $Page->ownerCountryId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerCountryId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerStateId->Visible) { // ownerStateId ?>
    <div id="r_ownerStateId"<?= $Page->ownerStateId->rowAttributes() ?>>
        <label id="elh_fed_school_ownerStateId" for="x_ownerStateId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerStateId->caption() ?><?= $Page->ownerStateId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerStateId->cellAttributes() ?>>
<span id="el_fed_school_ownerStateId">
<input type="<?= $Page->ownerStateId->getInputTextType() ?>" name="x_ownerStateId" id="x_ownerStateId" data-table="fed_school" data-field="x_ownerStateId" value="<?= $Page->ownerStateId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ownerStateId->getPlaceHolder()) ?>"<?= $Page->ownerStateId->editAttributes() ?> aria-describedby="x_ownerStateId_help">
<?= $Page->ownerStateId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerStateId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownCityId->Visible) { // ownCityId ?>
    <div id="r_ownCityId"<?= $Page->ownCityId->rowAttributes() ?>>
        <label id="elh_fed_school_ownCityId" for="x_ownCityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownCityId->caption() ?><?= $Page->ownCityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownCityId->cellAttributes() ?>>
<span id="el_fed_school_ownCityId">
<input type="<?= $Page->ownCityId->getInputTextType() ?>" name="x_ownCityId" id="x_ownCityId" data-table="fed_school" data-field="x_ownCityId" value="<?= $Page->ownCityId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ownCityId->getPlaceHolder()) ?>"<?= $Page->ownCityId->editAttributes() ?> aria-describedby="x_ownCityId_help">
<?= $Page->ownCityId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownCityId->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerTelephone->Visible) { // ownerTelephone ?>
    <div id="r_ownerTelephone"<?= $Page->ownerTelephone->rowAttributes() ?>>
        <label id="elh_fed_school_ownerTelephone" for="x_ownerTelephone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerTelephone->caption() ?><?= $Page->ownerTelephone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerTelephone->cellAttributes() ?>>
<span id="el_fed_school_ownerTelephone">
<input type="<?= $Page->ownerTelephone->getInputTextType() ?>" name="x_ownerTelephone" id="x_ownerTelephone" data-table="fed_school" data-field="x_ownerTelephone" value="<?= $Page->ownerTelephone->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerTelephone->getPlaceHolder()) ?>"<?= $Page->ownerTelephone->editAttributes() ?> aria-describedby="x_ownerTelephone_help">
<?= $Page->ownerTelephone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerTelephone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerTelephoneWork->Visible) { // ownerTelephoneWork ?>
    <div id="r_ownerTelephoneWork"<?= $Page->ownerTelephoneWork->rowAttributes() ?>>
        <label id="elh_fed_school_ownerTelephoneWork" for="x_ownerTelephoneWork" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerTelephoneWork->caption() ?><?= $Page->ownerTelephoneWork->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerTelephoneWork->cellAttributes() ?>>
<span id="el_fed_school_ownerTelephoneWork">
<input type="<?= $Page->ownerTelephoneWork->getInputTextType() ?>" name="x_ownerTelephoneWork" id="x_ownerTelephoneWork" data-table="fed_school" data-field="x_ownerTelephoneWork" value="<?= $Page->ownerTelephoneWork->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerTelephoneWork->getPlaceHolder()) ?>"<?= $Page->ownerTelephoneWork->editAttributes() ?> aria-describedby="x_ownerTelephoneWork_help">
<?= $Page->ownerTelephoneWork->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerTelephoneWork->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerProfession->Visible) { // ownerProfession ?>
    <div id="r_ownerProfession"<?= $Page->ownerProfession->rowAttributes() ?>>
        <label id="elh_fed_school_ownerProfession" for="x_ownerProfession" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerProfession->caption() ?><?= $Page->ownerProfession->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerProfession->cellAttributes() ?>>
<span id="el_fed_school_ownerProfession">
<input type="<?= $Page->ownerProfession->getInputTextType() ?>" name="x_ownerProfession" id="x_ownerProfession" data-table="fed_school" data-field="x_ownerProfession" value="<?= $Page->ownerProfession->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerProfession->getPlaceHolder()) ?>"<?= $Page->ownerProfession->editAttributes() ?> aria-describedby="x_ownerProfession_help">
<?= $Page->ownerProfession->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerProfession->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->employer->Visible) { // employer ?>
    <div id="r_employer"<?= $Page->employer->rowAttributes() ?>>
        <label id="elh_fed_school_employer" for="x_employer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->employer->caption() ?><?= $Page->employer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->employer->cellAttributes() ?>>
<span id="el_fed_school_employer">
<input type="<?= $Page->employer->getInputTextType() ?>" name="x_employer" id="x_employer" data-table="fed_school" data-field="x_employer" value="<?= $Page->employer->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->employer->getPlaceHolder()) ?>"<?= $Page->employer->editAttributes() ?> aria-describedby="x_employer_help">
<?= $Page->employer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->employer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerGraduation->Visible) { // ownerGraduation ?>
    <div id="r_ownerGraduation"<?= $Page->ownerGraduation->rowAttributes() ?>>
        <label id="elh_fed_school_ownerGraduation" for="x_ownerGraduation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerGraduation->caption() ?><?= $Page->ownerGraduation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerGraduation->cellAttributes() ?>>
<span id="el_fed_school_ownerGraduation">
<input type="<?= $Page->ownerGraduation->getInputTextType() ?>" name="x_ownerGraduation" id="x_ownerGraduation" data-table="fed_school" data-field="x_ownerGraduation" value="<?= $Page->ownerGraduation->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ownerGraduation->getPlaceHolder()) ?>"<?= $Page->ownerGraduation->editAttributes() ?> aria-describedby="x_ownerGraduation_help">
<?= $Page->ownerGraduation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerGraduation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerGraduationLocation->Visible) { // ownerGraduationLocation ?>
    <div id="r_ownerGraduationLocation"<?= $Page->ownerGraduationLocation->rowAttributes() ?>>
        <label id="elh_fed_school_ownerGraduationLocation" for="x_ownerGraduationLocation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerGraduationLocation->caption() ?><?= $Page->ownerGraduationLocation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerGraduationLocation->cellAttributes() ?>>
<span id="el_fed_school_ownerGraduationLocation">
<input type="<?= $Page->ownerGraduationLocation->getInputTextType() ?>" name="x_ownerGraduationLocation" id="x_ownerGraduationLocation" data-table="fed_school" data-field="x_ownerGraduationLocation" value="<?= $Page->ownerGraduationLocation->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerGraduationLocation->getPlaceHolder()) ?>"<?= $Page->ownerGraduationLocation->editAttributes() ?> aria-describedby="x_ownerGraduationLocation_help">
<?= $Page->ownerGraduationLocation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerGraduationLocation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerGraduationObs->Visible) { // ownerGraduationObs ?>
    <div id="r_ownerGraduationObs"<?= $Page->ownerGraduationObs->rowAttributes() ?>>
        <label id="elh_fed_school_ownerGraduationObs" for="x_ownerGraduationObs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerGraduationObs->caption() ?><?= $Page->ownerGraduationObs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerGraduationObs->cellAttributes() ?>>
<span id="el_fed_school_ownerGraduationObs">
<textarea data-table="fed_school" data-field="x_ownerGraduationObs" name="x_ownerGraduationObs" id="x_ownerGraduationObs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->ownerGraduationObs->getPlaceHolder()) ?>"<?= $Page->ownerGraduationObs->editAttributes() ?> aria-describedby="x_ownerGraduationObs_help"><?= $Page->ownerGraduationObs->EditValue ?></textarea>
<?= $Page->ownerGraduationObs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerGraduationObs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerMaritalStatus->Visible) { // ownerMaritalStatus ?>
    <div id="r_ownerMaritalStatus"<?= $Page->ownerMaritalStatus->rowAttributes() ?>>
        <label id="elh_fed_school_ownerMaritalStatus" for="x_ownerMaritalStatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerMaritalStatus->caption() ?><?= $Page->ownerMaritalStatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerMaritalStatus->cellAttributes() ?>>
<span id="el_fed_school_ownerMaritalStatus">
<input type="<?= $Page->ownerMaritalStatus->getInputTextType() ?>" name="x_ownerMaritalStatus" id="x_ownerMaritalStatus" data-table="fed_school" data-field="x_ownerMaritalStatus" value="<?= $Page->ownerMaritalStatus->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->ownerMaritalStatus->getPlaceHolder()) ?>"<?= $Page->ownerMaritalStatus->editAttributes() ?> aria-describedby="x_ownerMaritalStatus_help">
<?= $Page->ownerMaritalStatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerMaritalStatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerSpouseName->Visible) { // ownerSpouseName ?>
    <div id="r_ownerSpouseName"<?= $Page->ownerSpouseName->rowAttributes() ?>>
        <label id="elh_fed_school_ownerSpouseName" for="x_ownerSpouseName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerSpouseName->caption() ?><?= $Page->ownerSpouseName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerSpouseName->cellAttributes() ?>>
<span id="el_fed_school_ownerSpouseName">
<input type="<?= $Page->ownerSpouseName->getInputTextType() ?>" name="x_ownerSpouseName" id="x_ownerSpouseName" data-table="fed_school" data-field="x_ownerSpouseName" value="<?= $Page->ownerSpouseName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerSpouseName->getPlaceHolder()) ?>"<?= $Page->ownerSpouseName->editAttributes() ?> aria-describedby="x_ownerSpouseName_help">
<?= $Page->ownerSpouseName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerSpouseName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerSpouseProfession->Visible) { // ownerSpouseProfession ?>
    <div id="r_ownerSpouseProfession"<?= $Page->ownerSpouseProfession->rowAttributes() ?>>
        <label id="elh_fed_school_ownerSpouseProfession" for="x_ownerSpouseProfession" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerSpouseProfession->caption() ?><?= $Page->ownerSpouseProfession->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerSpouseProfession->cellAttributes() ?>>
<span id="el_fed_school_ownerSpouseProfession">
<input type="<?= $Page->ownerSpouseProfession->getInputTextType() ?>" name="x_ownerSpouseProfession" id="x_ownerSpouseProfession" data-table="fed_school" data-field="x_ownerSpouseProfession" value="<?= $Page->ownerSpouseProfession->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ownerSpouseProfession->getPlaceHolder()) ?>"<?= $Page->ownerSpouseProfession->editAttributes() ?> aria-describedby="x_ownerSpouseProfession_help">
<?= $Page->ownerSpouseProfession->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerSpouseProfession->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->propertySituation->Visible) { // propertySituation ?>
    <div id="r_propertySituation"<?= $Page->propertySituation->rowAttributes() ?>>
        <label id="elh_fed_school_propertySituation" for="x_propertySituation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->propertySituation->caption() ?><?= $Page->propertySituation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->propertySituation->cellAttributes() ?>>
<span id="el_fed_school_propertySituation">
<input type="<?= $Page->propertySituation->getInputTextType() ?>" name="x_propertySituation" id="x_propertySituation" data-table="fed_school" data-field="x_propertySituation" value="<?= $Page->propertySituation->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->propertySituation->getPlaceHolder()) ?>"<?= $Page->propertySituation->editAttributes() ?> aria-describedby="x_propertySituation_help">
<?= $Page->propertySituation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->propertySituation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->numberOfStudentsInBeginnig->Visible) { // numberOfStudentsInBeginnig ?>
    <div id="r_numberOfStudentsInBeginnig"<?= $Page->numberOfStudentsInBeginnig->rowAttributes() ?>>
        <label id="elh_fed_school_numberOfStudentsInBeginnig" for="x_numberOfStudentsInBeginnig" class="<?= $Page->LeftColumnClass ?>"><?= $Page->numberOfStudentsInBeginnig->caption() ?><?= $Page->numberOfStudentsInBeginnig->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->numberOfStudentsInBeginnig->cellAttributes() ?>>
<span id="el_fed_school_numberOfStudentsInBeginnig">
<input type="<?= $Page->numberOfStudentsInBeginnig->getInputTextType() ?>" name="x_numberOfStudentsInBeginnig" id="x_numberOfStudentsInBeginnig" data-table="fed_school" data-field="x_numberOfStudentsInBeginnig" value="<?= $Page->numberOfStudentsInBeginnig->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->numberOfStudentsInBeginnig->getPlaceHolder()) ?>"<?= $Page->numberOfStudentsInBeginnig->editAttributes() ?> aria-describedby="x_numberOfStudentsInBeginnig_help">
<?= $Page->numberOfStudentsInBeginnig->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->numberOfStudentsInBeginnig->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ownerAbout->Visible) { // ownerAbout ?>
    <div id="r_ownerAbout"<?= $Page->ownerAbout->rowAttributes() ?>>
        <label id="elh_fed_school_ownerAbout" for="x_ownerAbout" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ownerAbout->caption() ?><?= $Page->ownerAbout->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ownerAbout->cellAttributes() ?>>
<span id="el_fed_school_ownerAbout">
<textarea data-table="fed_school" data-field="x_ownerAbout" name="x_ownerAbout" id="x_ownerAbout" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->ownerAbout->getPlaceHolder()) ?>"<?= $Page->ownerAbout->editAttributes() ?> aria-describedby="x_ownerAbout_help"><?= $Page->ownerAbout->EditValue ?></textarea>
<?= $Page->ownerAbout->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ownerAbout->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pdfLicense->Visible) { // pdfLicense ?>
    <div id="r_pdfLicense"<?= $Page->pdfLicense->rowAttributes() ?>>
        <label id="elh_fed_school_pdfLicense" for="x_pdfLicense" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pdfLicense->caption() ?><?= $Page->pdfLicense->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pdfLicense->cellAttributes() ?>>
<span id="el_fed_school_pdfLicense">
<textarea data-table="fed_school" data-field="x_pdfLicense" name="x_pdfLicense" id="x_pdfLicense" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->pdfLicense->getPlaceHolder()) ?>"<?= $Page->pdfLicense->editAttributes() ?> aria-describedby="x_pdfLicense_help"><?= $Page->pdfLicense->EditValue ?></textarea>
<?= $Page->pdfLicense->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pdfLicense->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
    <div id="r_applicationId"<?= $Page->applicationId->rowAttributes() ?>>
        <label id="elh_fed_school_applicationId" for="x_applicationId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->applicationId->caption() ?><?= $Page->applicationId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->applicationId->cellAttributes() ?>>
<?php if ($Page->applicationId->getSessionValue() != "") { ?>
<span<?= $Page->applicationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->applicationId->getDisplayValue($Page->applicationId->ViewValue))) ?>"></span>
<input type="hidden" id="x_applicationId" name="x_applicationId" value="<?= HtmlEncode($Page->applicationId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fed_school_applicationId">
<input type="<?= $Page->applicationId->getInputTextType() ?>" name="x_applicationId" id="x_applicationId" data-table="fed_school" data-field="x_applicationId" value="<?= $Page->applicationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->applicationId->getPlaceHolder()) ?>"<?= $Page->applicationId->editAttributes() ?> aria-describedby="x_applicationId_help">
<?= $Page->applicationId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->applicationId->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
    <div id="r_isheadquarter"<?= $Page->isheadquarter->rowAttributes() ?>>
        <label id="elh_fed_school_isheadquarter" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isheadquarter->caption() ?><?= $Page->isheadquarter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isheadquarter->cellAttributes() ?>>
<span id="el_fed_school_isheadquarter">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->isheadquarter->isInvalidClass() ?>" data-table="fed_school" data-field="x_isheadquarter" name="x_isheadquarter[]" id="x_isheadquarter_237291" value="1"<?= ConvertToBool($Page->isheadquarter->CurrentValue) ? " checked" : "" ?><?= $Page->isheadquarter->editAttributes() ?> aria-describedby="x_isheadquarter_help">
    <div class="invalid-feedback"><?= $Page->isheadquarter->getErrorMessage() ?></div>
</div>
<?= $Page->isheadquarter->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav<?= $Page->DetailPages->containerClasses() ?>" id="details_Page"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navClasses() ?>" role="tablist"><!-- .nav -->
<?php
    if (in_array("school_users", explode(",", $Page->getCurrentDetailTable())) && $school_users->DetailAdd) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("school_users") ?><?= $Page->DetailPages->activeClasses("school_users") ?>" data-bs-target="#tab_school_users" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_users" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("school_users")) ?>"><?= $Language->tablePhrase("school_users", "TblCaption") ?></button></li>
<?php
    }
?>
<?php
    if (in_array("school_member", explode(",", $Page->getCurrentDetailTable())) && $school_member->DetailAdd) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("school_member") ?><?= $Page->DetailPages->activeClasses("school_member") ?>" data-bs-target="#tab_school_member" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_member" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("school_member")) ?>"><?= $Language->tablePhrase("school_member", "TblCaption") ?></button></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="<?= $Page->DetailPages->tabContentClasses() ?>"><!-- .tab-content -->
<?php
    if (in_array("school_users", explode(",", $Page->getCurrentDetailTable())) && $school_users->DetailAdd) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("school_users") ?><?= $Page->DetailPages->activeClasses("school_users") ?>" id="tab_school_users" role="tabpanel"><!-- page* -->
<?php include_once "SchoolUsersGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("school_member", explode(",", $Page->getCurrentDetailTable())) && $school_member->DetailAdd) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("school_member") ?><?= $Page->DetailPages->activeClasses("school_member") ?>" id="tab_school_member" role="tabpanel"><!-- page* -->
<?php include_once "SchoolMemberGrid.php" ?>
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
    ew.addEventHandlers("fed_school");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
