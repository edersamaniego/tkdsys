<?php

namespace PHPMaker2022\school;

// Page object
$SchoolMemberAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_member: currentTable } });
var currentForm, currentPageID;
var fschool_memberadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_memberadd = new ew.Form("fschool_memberadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fschool_memberadd;

    // Add fields
    var fields = currentTable.fields;
    fschool_memberadd.addFields([
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["lastName", [fields.lastName.visible && fields.lastName.required ? ew.Validators.required(fields.lastName.caption) : null], fields.lastName.isInvalid],
        ["birthdate", [fields.birthdate.visible && fields.birthdate.required ? ew.Validators.required(fields.birthdate.caption) : null, ew.Validators.datetime(fields.birthdate.clientFormatPattern)], fields.birthdate.isInvalid],
        ["gender", [fields.gender.visible && fields.gender.required ? ew.Validators.required(fields.gender.caption) : null], fields.gender.isInvalid],
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["neighborhood", [fields.neighborhood.visible && fields.neighborhood.required ? ew.Validators.required(fields.neighborhood.caption) : null], fields.neighborhood.isInvalid],
        ["countryId", [fields.countryId.visible && fields.countryId.required ? ew.Validators.required(fields.countryId.caption) : null], fields.countryId.isInvalid],
        ["UFId", [fields.UFId.visible && fields.UFId.required ? ew.Validators.required(fields.UFId.caption) : null], fields.UFId.isInvalid],
        ["cityId", [fields.cityId.visible && fields.cityId.required ? ew.Validators.required(fields.cityId.caption) : null], fields.cityId.isInvalid],
        ["zip", [fields.zip.visible && fields.zip.required ? ew.Validators.required(fields.zip.caption) : null], fields.zip.isInvalid],
        ["celphone", [fields.celphone.visible && fields.celphone.required ? ew.Validators.required(fields.celphone.caption) : null], fields.celphone.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["facebook", [fields.facebook.visible && fields.facebook.required ? ew.Validators.required(fields.facebook.caption) : null], fields.facebook.isInvalid],
        ["instagram", [fields.instagram.visible && fields.instagram.required ? ew.Validators.required(fields.instagram.caption) : null], fields.instagram.isInvalid],
        ["father", [fields.father.visible && fields.father.required ? ew.Validators.required(fields.father.caption) : null], fields.father.isInvalid],
        ["fatherCellphone", [fields.fatherCellphone.visible && fields.fatherCellphone.required ? ew.Validators.required(fields.fatherCellphone.caption) : null], fields.fatherCellphone.isInvalid],
        ["receiveSmsFather", [fields.receiveSmsFather.visible && fields.receiveSmsFather.required ? ew.Validators.required(fields.receiveSmsFather.caption) : null], fields.receiveSmsFather.isInvalid],
        ["fatherEmail", [fields.fatherEmail.visible && fields.fatherEmail.required ? ew.Validators.required(fields.fatherEmail.caption) : null, ew.Validators.email], fields.fatherEmail.isInvalid],
        ["receiveEmailFather", [fields.receiveEmailFather.visible && fields.receiveEmailFather.required ? ew.Validators.required(fields.receiveEmailFather.caption) : null], fields.receiveEmailFather.isInvalid],
        ["fatherOccupation", [fields.fatherOccupation.visible && fields.fatherOccupation.required ? ew.Validators.required(fields.fatherOccupation.caption) : null], fields.fatherOccupation.isInvalid],
        ["fatherBirthdate", [fields.fatherBirthdate.visible && fields.fatherBirthdate.required ? ew.Validators.required(fields.fatherBirthdate.caption) : null, ew.Validators.datetime(fields.fatherBirthdate.clientFormatPattern)], fields.fatherBirthdate.isInvalid],
        ["mother", [fields.mother.visible && fields.mother.required ? ew.Validators.required(fields.mother.caption) : null], fields.mother.isInvalid],
        ["motherCellphone", [fields.motherCellphone.visible && fields.motherCellphone.required ? ew.Validators.required(fields.motherCellphone.caption) : null], fields.motherCellphone.isInvalid],
        ["receiveSmsMother", [fields.receiveSmsMother.visible && fields.receiveSmsMother.required ? ew.Validators.required(fields.receiveSmsMother.caption) : null], fields.receiveSmsMother.isInvalid],
        ["motherEmail", [fields.motherEmail.visible && fields.motherEmail.required ? ew.Validators.required(fields.motherEmail.caption) : null, ew.Validators.email], fields.motherEmail.isInvalid],
        ["receiveEmailMother", [fields.receiveEmailMother.visible && fields.receiveEmailMother.required ? ew.Validators.required(fields.receiveEmailMother.caption) : null], fields.receiveEmailMother.isInvalid],
        ["motherOccupation", [fields.motherOccupation.visible && fields.motherOccupation.required ? ew.Validators.required(fields.motherOccupation.caption) : null], fields.motherOccupation.isInvalid],
        ["motherBirthdate", [fields.motherBirthdate.visible && fields.motherBirthdate.required ? ew.Validators.required(fields.motherBirthdate.caption) : null, ew.Validators.datetime(fields.motherBirthdate.clientFormatPattern)], fields.motherBirthdate.isInvalid],
        ["emergencyContact", [fields.emergencyContact.visible && fields.emergencyContact.required ? ew.Validators.required(fields.emergencyContact.caption) : null], fields.emergencyContact.isInvalid],
        ["emergencyFone", [fields.emergencyFone.visible && fields.emergencyFone.required ? ew.Validators.required(fields.emergencyFone.caption) : null], fields.emergencyFone.isInvalid],
        ["obs", [fields.obs.visible && fields.obs.required ? ew.Validators.required(fields.obs.caption) : null], fields.obs.isInvalid],
        ["modalityId", [fields.modalityId.visible && fields.modalityId.required ? ew.Validators.required(fields.modalityId.caption) : null], fields.modalityId.isInvalid],
        ["instructorStatus", [fields.instructorStatus.visible && fields.instructorStatus.required ? ew.Validators.required(fields.instructorStatus.caption) : null], fields.instructorStatus.isInvalid],
        ["martialArtId", [fields.martialArtId.visible && fields.martialArtId.required ? ew.Validators.required(fields.martialArtId.caption) : null], fields.martialArtId.isInvalid],
        ["rankId", [fields.rankId.visible && fields.rankId.required ? ew.Validators.required(fields.rankId.caption) : null], fields.rankId.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["memberStatusId", [fields.memberStatusId.visible && fields.memberStatusId.required ? ew.Validators.required(fields.memberStatusId.caption) : null], fields.memberStatusId.isInvalid],
        ["photo", [fields.photo.visible && fields.photo.required ? ew.Validators.fileRequired(fields.photo.caption) : null], fields.photo.isInvalid],
        ["beltSize", [fields.beltSize.visible && fields.beltSize.required ? ew.Validators.required(fields.beltSize.caption) : null], fields.beltSize.isInvalid],
        ["dobokSize", [fields.dobokSize.visible && fields.dobokSize.required ? ew.Validators.required(fields.dobokSize.caption) : null], fields.dobokSize.isInvalid],
        ["memberLevelId", [fields.memberLevelId.visible && fields.memberLevelId.required ? ew.Validators.required(fields.memberLevelId.caption) : null], fields.memberLevelId.isInvalid],
        ["instructorLevelId", [fields.instructorLevelId.visible && fields.instructorLevelId.required ? ew.Validators.required(fields.instructorLevelId.caption) : null], fields.instructorLevelId.isInvalid],
        ["judgeLevelId", [fields.judgeLevelId.visible && fields.judgeLevelId.required ? ew.Validators.required(fields.judgeLevelId.caption) : null], fields.judgeLevelId.isInvalid],
        ["federationRegisterDate", [fields.federationRegisterDate.visible && fields.federationRegisterDate.required ? ew.Validators.required(fields.federationRegisterDate.caption) : null, ew.Validators.datetime(fields.federationRegisterDate.clientFormatPattern)], fields.federationRegisterDate.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null], fields.createDate.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null], fields.createUserId.isInvalid],
        ["lastUpdate", [fields.lastUpdate.visible && fields.lastUpdate.required ? ew.Validators.required(fields.lastUpdate.caption) : null], fields.lastUpdate.isInvalid],
        ["lastUserId", [fields.lastUserId.visible && fields.lastUserId.required ? ew.Validators.required(fields.lastUserId.caption) : null], fields.lastUserId.isInvalid],
        ["marketingSourceId", [fields.marketingSourceId.visible && fields.marketingSourceId.required ? ew.Validators.required(fields.marketingSourceId.caption) : null], fields.marketingSourceId.isInvalid],
        ["marketingSourceDetail", [fields.marketingSourceDetail.visible && fields.marketingSourceDetail.required ? ew.Validators.required(fields.marketingSourceDetail.caption) : null], fields.marketingSourceDetail.isInvalid]
    ]);

    // Form_CustomValidate
    fschool_memberadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_memberadd.validateRequired = ew.CLIENT_VALIDATE;

    // Multi-Page
    fschool_memberadd.multiPage = new ew.MultiPage("fschool_memberadd");

    // Dynamic selection lists
    fschool_memberadd.lists.gender = <?= $Page->gender->toClientList($Page) ?>;
    fschool_memberadd.lists.countryId = <?= $Page->countryId->toClientList($Page) ?>;
    fschool_memberadd.lists.UFId = <?= $Page->UFId->toClientList($Page) ?>;
    fschool_memberadd.lists.cityId = <?= $Page->cityId->toClientList($Page) ?>;
    fschool_memberadd.lists.receiveSmsFather = <?= $Page->receiveSmsFather->toClientList($Page) ?>;
    fschool_memberadd.lists.receiveEmailFather = <?= $Page->receiveEmailFather->toClientList($Page) ?>;
    fschool_memberadd.lists.receiveSmsMother = <?= $Page->receiveSmsMother->toClientList($Page) ?>;
    fschool_memberadd.lists.receiveEmailMother = <?= $Page->receiveEmailMother->toClientList($Page) ?>;
    fschool_memberadd.lists.modalityId = <?= $Page->modalityId->toClientList($Page) ?>;
    fschool_memberadd.lists.instructorStatus = <?= $Page->instructorStatus->toClientList($Page) ?>;
    fschool_memberadd.lists.martialArtId = <?= $Page->martialArtId->toClientList($Page) ?>;
    fschool_memberadd.lists.rankId = <?= $Page->rankId->toClientList($Page) ?>;
    fschool_memberadd.lists.schoolId = <?= $Page->schoolId->toClientList($Page) ?>;
    fschool_memberadd.lists.memberStatusId = <?= $Page->memberStatusId->toClientList($Page) ?>;
    fschool_memberadd.lists.memberLevelId = <?= $Page->memberLevelId->toClientList($Page) ?>;
    fschool_memberadd.lists.instructorLevelId = <?= $Page->instructorLevelId->toClientList($Page) ?>;
    fschool_memberadd.lists.judgeLevelId = <?= $Page->judgeLevelId->toClientList($Page) ?>;
    fschool_memberadd.lists.marketingSourceId = <?= $Page->marketingSourceId->toClientList($Page) ?>;
    loadjs.done("fschool_memberadd");
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
<form name="fschool_memberadd" id="fschool_memberadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_member">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "fed_school") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_school">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->schoolId->getSessionValue()) ?>">
<?php } ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_SchoolMemberAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_school_member1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_member1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_school_member2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_member2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_school_member3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_member3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_school_member4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_member4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_school_member1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_school_member_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_school_member_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="school_member" data-field="x_name" value="<?= $Page->name->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
    <div id="r_lastName"<?= $Page->lastName->rowAttributes() ?>>
        <label id="elh_school_member_lastName" for="x_lastName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastName->caption() ?><?= $Page->lastName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastName->cellAttributes() ?>>
<span id="el_school_member_lastName">
<input type="<?= $Page->lastName->getInputTextType() ?>" name="x_lastName" id="x_lastName" data-table="school_member" data-field="x_lastName" value="<?= $Page->lastName->EditValue ?>" data-page="1" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lastName->getPlaceHolder()) ?>"<?= $Page->lastName->editAttributes() ?> aria-describedby="x_lastName_help">
<?= $Page->lastName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->birthdate->Visible) { // birthdate ?>
    <div id="r_birthdate"<?= $Page->birthdate->rowAttributes() ?>>
        <label id="elh_school_member_birthdate" for="x_birthdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->birthdate->caption() ?><?= $Page->birthdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->birthdate->cellAttributes() ?>>
<span id="el_school_member_birthdate">
<input type="<?= $Page->birthdate->getInputTextType() ?>" name="x_birthdate" id="x_birthdate" data-table="school_member" data-field="x_birthdate" value="<?= $Page->birthdate->EditValue ?>" data-page="1" placeholder="<?= HtmlEncode($Page->birthdate->getPlaceHolder()) ?>"<?= $Page->birthdate->editAttributes() ?> aria-describedby="x_birthdate_help">
<?= $Page->birthdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->birthdate->getErrorMessage() ?></div>
<?php if (!$Page->birthdate->ReadOnly && !$Page->birthdate->Disabled && !isset($Page->birthdate->EditAttrs["readonly"]) && !isset($Page->birthdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fschool_memberadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fschool_memberadd", "x_birthdate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
    <div id="r_gender"<?= $Page->gender->rowAttributes() ?>>
        <label id="elh_school_member_gender" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gender->caption() ?><?= $Page->gender->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->gender->cellAttributes() ?>>
<span id="el_school_member_gender">
<template id="tp_x_gender">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="school_member" data-field="x_gender" name="x_gender" id="x_gender"<?= $Page->gender->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_gender" class="ew-item-list"></div>
<selection-list hidden
    id="x_gender"
    name="x_gender"
    value="<?= HtmlEncode($Page->gender->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_gender"
    data-bs-target="dsl_x_gender"
    data-repeatcolumn="5"
    class="form-control<?= $Page->gender->isInvalidClass() ?>"
    data-table="school_member"
    data-field="x_gender"
    data-page="1"
    data-value-separator="<?= $Page->gender->displayValueSeparatorAttribute() ?>"
    <?= $Page->gender->editAttributes() ?>></selection-list>
<?= $Page->gender->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gender->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_school_member_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_school_member_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="school_member" data-field="x_address" value="<?= $Page->address->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <div id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <label id="elh_school_member_neighborhood" for="x_neighborhood" class="<?= $Page->LeftColumnClass ?>"><?= $Page->neighborhood->caption() ?><?= $Page->neighborhood->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_school_member_neighborhood">
<input type="<?= $Page->neighborhood->getInputTextType() ?>" name="x_neighborhood" id="x_neighborhood" data-table="school_member" data-field="x_neighborhood" value="<?= $Page->neighborhood->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->neighborhood->getPlaceHolder()) ?>"<?= $Page->neighborhood->editAttributes() ?> aria-describedby="x_neighborhood_help">
<?= $Page->neighborhood->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->neighborhood->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <div id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <label id="elh_school_member_countryId" for="x_countryId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->countryId->caption() ?><?= $Page->countryId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->countryId->cellAttributes() ?>>
<span id="el_school_member_countryId">
<?php $Page->countryId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_countryId"
        name="x_countryId"
        class="form-select ew-select<?= $Page->countryId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_countryId"
        data-table="school_member"
        data-field="x_countryId"
        data-page="1"
        data-value-separator="<?= $Page->countryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->countryId->getPlaceHolder()) ?>"
        <?= $Page->countryId->editAttributes() ?>>
        <?= $Page->countryId->selectOptionListHtml("x_countryId") ?>
    </select>
    <?= $Page->countryId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->countryId->getErrorMessage() ?></div>
<?= $Page->countryId->Lookup->getParamTag($Page, "p_x_countryId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_countryId", selectId: "fschool_memberadd_x_countryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.countryId.lookupOptions.length) {
        options.data = { id: "x_countryId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_countryId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.countryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
    <div id="r_UFId"<?= $Page->UFId->rowAttributes() ?>>
        <label id="elh_school_member_UFId" for="x_UFId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->UFId->caption() ?><?= $Page->UFId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->UFId->cellAttributes() ?>>
<span id="el_school_member_UFId">
<?php $Page->UFId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_UFId"
        name="x_UFId"
        class="form-select ew-select<?= $Page->UFId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_UFId"
        data-table="school_member"
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
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_UFId", selectId: "fschool_memberadd_x_UFId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.UFId.lookupOptions.length) {
        options.data = { id: "x_UFId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_UFId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.UFId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
    <div id="r_cityId"<?= $Page->cityId->rowAttributes() ?>>
        <label id="elh_school_member_cityId" for="x_cityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cityId->caption() ?><?= $Page->cityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cityId->cellAttributes() ?>>
<span id="el_school_member_cityId">
    <select
        id="x_cityId"
        name="x_cityId"
        class="form-select ew-select<?= $Page->cityId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_cityId"
        data-table="school_member"
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
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_cityId", selectId: "fschool_memberadd_x_cityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.cityId.lookupOptions.length) {
        options.data = { id: "x_cityId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_cityId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.cityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->zip->Visible) { // zip ?>
    <div id="r_zip"<?= $Page->zip->rowAttributes() ?>>
        <label id="elh_school_member_zip" for="x_zip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->zip->caption() ?><?= $Page->zip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->zip->cellAttributes() ?>>
<span id="el_school_member_zip">
<input type="<?= $Page->zip->getInputTextType() ?>" name="x_zip" id="x_zip" data-table="school_member" data-field="x_zip" value="<?= $Page->zip->EditValue ?>" data-page="1" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->zip->getPlaceHolder()) ?>"<?= $Page->zip->editAttributes() ?> aria-describedby="x_zip_help">
<?= $Page->zip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->zip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->celphone->Visible) { // celphone ?>
    <div id="r_celphone"<?= $Page->celphone->rowAttributes() ?>>
        <label id="elh_school_member_celphone" for="x_celphone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->celphone->caption() ?><?= $Page->celphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->celphone->cellAttributes() ?>>
<span id="el_school_member_celphone">
<input type="<?= $Page->celphone->getInputTextType() ?>" name="x_celphone" id="x_celphone" data-table="school_member" data-field="x_celphone" value="<?= $Page->celphone->EditValue ?>" data-page="1" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->celphone->getPlaceHolder()) ?>"<?= $Page->celphone->editAttributes() ?> aria-describedby="x_celphone_help">
<?= $Page->celphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->celphone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_school_member__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_school_member__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="school_member" data-field="x__email" value="<?= $Page->_email->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->facebook->Visible) { // facebook ?>
    <div id="r_facebook"<?= $Page->facebook->rowAttributes() ?>>
        <label id="elh_school_member_facebook" for="x_facebook" class="<?= $Page->LeftColumnClass ?>"><?= $Page->facebook->caption() ?><?= $Page->facebook->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->facebook->cellAttributes() ?>>
<span id="el_school_member_facebook">
<input type="<?= $Page->facebook->getInputTextType() ?>" name="x_facebook" id="x_facebook" data-table="school_member" data-field="x_facebook" value="<?= $Page->facebook->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->facebook->getPlaceHolder()) ?>"<?= $Page->facebook->editAttributes() ?> aria-describedby="x_facebook_help">
<?= $Page->facebook->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->facebook->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instagram->Visible) { // instagram ?>
    <div id="r_instagram"<?= $Page->instagram->rowAttributes() ?>>
        <label id="elh_school_member_instagram" for="x_instagram" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instagram->caption() ?><?= $Page->instagram->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instagram->cellAttributes() ?>>
<span id="el_school_member_instagram">
<input type="<?= $Page->instagram->getInputTextType() ?>" name="x_instagram" id="x_instagram" data-table="school_member" data-field="x_instagram" value="<?= $Page->instagram->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->instagram->getPlaceHolder()) ?>"<?= $Page->instagram->editAttributes() ?> aria-describedby="x_instagram_help">
<?= $Page->instagram->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->instagram->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <div id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <label id="elh_school_member_photo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->photo->caption() ?><?= $Page->photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->photo->cellAttributes() ?>>
<span id="el_school_member_photo">
<div id="fd_x_photo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->photo->title() ?>" data-table="school_member" data-field="x_photo" data-page="1" name="x_photo" id="x_photo" lang="<?= CurrentLanguageID() ?>"<?= $Page->photo->editAttributes() ?> aria-describedby="x_photo_help"<?= ($Page->photo->ReadOnly || $Page->photo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_photo" id= "fn_x_photo" value="<?= $Page->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_photo" id= "fa_x_photo" value="0">
<input type="hidden" name="fs_x_photo" id= "fs_x_photo" value="45">
<input type="hidden" name="fx_x_photo" id= "fx_x_photo" value="<?= $Page->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_photo" id= "fm_x_photo" value="<?= $Page->photo->UploadMaxFileSize ?>">
<table id="ft_x_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_school_member2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->father->Visible) { // father ?>
    <div id="r_father"<?= $Page->father->rowAttributes() ?>>
        <label id="elh_school_member_father" for="x_father" class="<?= $Page->LeftColumnClass ?>"><?= $Page->father->caption() ?><?= $Page->father->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->father->cellAttributes() ?>>
<span id="el_school_member_father">
<input type="<?= $Page->father->getInputTextType() ?>" name="x_father" id="x_father" data-table="school_member" data-field="x_father" value="<?= $Page->father->EditValue ?>" data-page="2" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->father->getPlaceHolder()) ?>"<?= $Page->father->editAttributes() ?> aria-describedby="x_father_help">
<?= $Page->father->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->father->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fatherCellphone->Visible) { // fatherCellphone ?>
    <div id="r_fatherCellphone"<?= $Page->fatherCellphone->rowAttributes() ?>>
        <label id="elh_school_member_fatherCellphone" for="x_fatherCellphone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fatherCellphone->caption() ?><?= $Page->fatherCellphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fatherCellphone->cellAttributes() ?>>
<span id="el_school_member_fatherCellphone">
<input type="<?= $Page->fatherCellphone->getInputTextType() ?>" name="x_fatherCellphone" id="x_fatherCellphone" data-table="school_member" data-field="x_fatherCellphone" value="<?= $Page->fatherCellphone->EditValue ?>" data-page="2" size="15" maxlength="100" placeholder="<?= HtmlEncode($Page->fatherCellphone->getPlaceHolder()) ?>"<?= $Page->fatherCellphone->editAttributes() ?> aria-describedby="x_fatherCellphone_help">
<?= $Page->fatherCellphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fatherCellphone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receiveSmsFather->Visible) { // receiveSmsFather ?>
    <div id="r_receiveSmsFather"<?= $Page->receiveSmsFather->rowAttributes() ?>>
        <label id="elh_school_member_receiveSmsFather" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiveSmsFather->caption() ?><?= $Page->receiveSmsFather->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiveSmsFather->cellAttributes() ?>>
<span id="el_school_member_receiveSmsFather">
<template id="tp_x_receiveSmsFather">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="school_member" data-field="x_receiveSmsFather" name="x_receiveSmsFather" id="x_receiveSmsFather"<?= $Page->receiveSmsFather->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_receiveSmsFather" class="ew-item-list"></div>
<selection-list hidden
    id="x_receiveSmsFather"
    name="x_receiveSmsFather"
    value="<?= HtmlEncode($Page->receiveSmsFather->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_receiveSmsFather"
    data-bs-target="dsl_x_receiveSmsFather"
    data-repeatcolumn="5"
    class="form-control<?= $Page->receiveSmsFather->isInvalidClass() ?>"
    data-table="school_member"
    data-field="x_receiveSmsFather"
    data-page="2"
    data-value-separator="<?= $Page->receiveSmsFather->displayValueSeparatorAttribute() ?>"
    <?= $Page->receiveSmsFather->editAttributes() ?>></selection-list>
<?= $Page->receiveSmsFather->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receiveSmsFather->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fatherEmail->Visible) { // fatherEmail ?>
    <div id="r_fatherEmail"<?= $Page->fatherEmail->rowAttributes() ?>>
        <label id="elh_school_member_fatherEmail" for="x_fatherEmail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fatherEmail->caption() ?><?= $Page->fatherEmail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fatherEmail->cellAttributes() ?>>
<span id="el_school_member_fatherEmail">
<input type="<?= $Page->fatherEmail->getInputTextType() ?>" name="x_fatherEmail" id="x_fatherEmail" data-table="school_member" data-field="x_fatherEmail" value="<?= $Page->fatherEmail->EditValue ?>" data-page="2" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->fatherEmail->getPlaceHolder()) ?>"<?= $Page->fatherEmail->editAttributes() ?> aria-describedby="x_fatherEmail_help">
<?= $Page->fatherEmail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fatherEmail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receiveEmailFather->Visible) { // receiveEmailFather ?>
    <div id="r_receiveEmailFather"<?= $Page->receiveEmailFather->rowAttributes() ?>>
        <label id="elh_school_member_receiveEmailFather" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiveEmailFather->caption() ?><?= $Page->receiveEmailFather->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiveEmailFather->cellAttributes() ?>>
<span id="el_school_member_receiveEmailFather">
<template id="tp_x_receiveEmailFather">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="school_member" data-field="x_receiveEmailFather" name="x_receiveEmailFather" id="x_receiveEmailFather"<?= $Page->receiveEmailFather->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_receiveEmailFather" class="ew-item-list"></div>
<selection-list hidden
    id="x_receiveEmailFather"
    name="x_receiveEmailFather"
    value="<?= HtmlEncode($Page->receiveEmailFather->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_receiveEmailFather"
    data-bs-target="dsl_x_receiveEmailFather"
    data-repeatcolumn="5"
    class="form-control<?= $Page->receiveEmailFather->isInvalidClass() ?>"
    data-table="school_member"
    data-field="x_receiveEmailFather"
    data-page="2"
    data-value-separator="<?= $Page->receiveEmailFather->displayValueSeparatorAttribute() ?>"
    <?= $Page->receiveEmailFather->editAttributes() ?>></selection-list>
<?= $Page->receiveEmailFather->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receiveEmailFather->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fatherOccupation->Visible) { // fatherOccupation ?>
    <div id="r_fatherOccupation"<?= $Page->fatherOccupation->rowAttributes() ?>>
        <label id="elh_school_member_fatherOccupation" for="x_fatherOccupation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fatherOccupation->caption() ?><?= $Page->fatherOccupation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fatherOccupation->cellAttributes() ?>>
<span id="el_school_member_fatherOccupation">
<input type="<?= $Page->fatherOccupation->getInputTextType() ?>" name="x_fatherOccupation" id="x_fatherOccupation" data-table="school_member" data-field="x_fatherOccupation" value="<?= $Page->fatherOccupation->EditValue ?>" data-page="2" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->fatherOccupation->getPlaceHolder()) ?>"<?= $Page->fatherOccupation->editAttributes() ?> aria-describedby="x_fatherOccupation_help">
<?= $Page->fatherOccupation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fatherOccupation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fatherBirthdate->Visible) { // fatherBirthdate ?>
    <div id="r_fatherBirthdate"<?= $Page->fatherBirthdate->rowAttributes() ?>>
        <label id="elh_school_member_fatherBirthdate" for="x_fatherBirthdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fatherBirthdate->caption() ?><?= $Page->fatherBirthdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fatherBirthdate->cellAttributes() ?>>
<span id="el_school_member_fatherBirthdate">
<input type="<?= $Page->fatherBirthdate->getInputTextType() ?>" name="x_fatherBirthdate" id="x_fatherBirthdate" data-table="school_member" data-field="x_fatherBirthdate" value="<?= $Page->fatherBirthdate->EditValue ?>" data-page="2" placeholder="<?= HtmlEncode($Page->fatherBirthdate->getPlaceHolder()) ?>"<?= $Page->fatherBirthdate->editAttributes() ?> aria-describedby="x_fatherBirthdate_help">
<?= $Page->fatherBirthdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fatherBirthdate->getErrorMessage() ?></div>
<?php if (!$Page->fatherBirthdate->ReadOnly && !$Page->fatherBirthdate->Disabled && !isset($Page->fatherBirthdate->EditAttrs["readonly"]) && !isset($Page->fatherBirthdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fschool_memberadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fschool_memberadd", "x_fatherBirthdate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mother->Visible) { // mother ?>
    <div id="r_mother"<?= $Page->mother->rowAttributes() ?>>
        <label id="elh_school_member_mother" for="x_mother" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mother->caption() ?><?= $Page->mother->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mother->cellAttributes() ?>>
<span id="el_school_member_mother">
<input type="<?= $Page->mother->getInputTextType() ?>" name="x_mother" id="x_mother" data-table="school_member" data-field="x_mother" value="<?= $Page->mother->EditValue ?>" data-page="2" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->mother->getPlaceHolder()) ?>"<?= $Page->mother->editAttributes() ?> aria-describedby="x_mother_help">
<?= $Page->mother->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mother->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motherCellphone->Visible) { // motherCellphone ?>
    <div id="r_motherCellphone"<?= $Page->motherCellphone->rowAttributes() ?>>
        <label id="elh_school_member_motherCellphone" for="x_motherCellphone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motherCellphone->caption() ?><?= $Page->motherCellphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motherCellphone->cellAttributes() ?>>
<span id="el_school_member_motherCellphone">
<input type="<?= $Page->motherCellphone->getInputTextType() ?>" name="x_motherCellphone" id="x_motherCellphone" data-table="school_member" data-field="x_motherCellphone" value="<?= $Page->motherCellphone->EditValue ?>" data-page="2" size="15" maxlength="100" placeholder="<?= HtmlEncode($Page->motherCellphone->getPlaceHolder()) ?>"<?= $Page->motherCellphone->editAttributes() ?> aria-describedby="x_motherCellphone_help">
<?= $Page->motherCellphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->motherCellphone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receiveSmsMother->Visible) { // receiveSmsMother ?>
    <div id="r_receiveSmsMother"<?= $Page->receiveSmsMother->rowAttributes() ?>>
        <label id="elh_school_member_receiveSmsMother" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiveSmsMother->caption() ?><?= $Page->receiveSmsMother->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiveSmsMother->cellAttributes() ?>>
<span id="el_school_member_receiveSmsMother">
<template id="tp_x_receiveSmsMother">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="school_member" data-field="x_receiveSmsMother" name="x_receiveSmsMother" id="x_receiveSmsMother"<?= $Page->receiveSmsMother->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_receiveSmsMother" class="ew-item-list"></div>
<selection-list hidden
    id="x_receiveSmsMother"
    name="x_receiveSmsMother"
    value="<?= HtmlEncode($Page->receiveSmsMother->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_receiveSmsMother"
    data-bs-target="dsl_x_receiveSmsMother"
    data-repeatcolumn="5"
    class="form-control<?= $Page->receiveSmsMother->isInvalidClass() ?>"
    data-table="school_member"
    data-field="x_receiveSmsMother"
    data-page="2"
    data-value-separator="<?= $Page->receiveSmsMother->displayValueSeparatorAttribute() ?>"
    <?= $Page->receiveSmsMother->editAttributes() ?>></selection-list>
<?= $Page->receiveSmsMother->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receiveSmsMother->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motherEmail->Visible) { // motherEmail ?>
    <div id="r_motherEmail"<?= $Page->motherEmail->rowAttributes() ?>>
        <label id="elh_school_member_motherEmail" for="x_motherEmail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motherEmail->caption() ?><?= $Page->motherEmail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motherEmail->cellAttributes() ?>>
<span id="el_school_member_motherEmail">
<input type="<?= $Page->motherEmail->getInputTextType() ?>" name="x_motherEmail" id="x_motherEmail" data-table="school_member" data-field="x_motherEmail" value="<?= $Page->motherEmail->EditValue ?>" data-page="2" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->motherEmail->getPlaceHolder()) ?>"<?= $Page->motherEmail->editAttributes() ?> aria-describedby="x_motherEmail_help">
<?= $Page->motherEmail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->motherEmail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receiveEmailMother->Visible) { // receiveEmailMother ?>
    <div id="r_receiveEmailMother"<?= $Page->receiveEmailMother->rowAttributes() ?>>
        <label id="elh_school_member_receiveEmailMother" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receiveEmailMother->caption() ?><?= $Page->receiveEmailMother->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->receiveEmailMother->cellAttributes() ?>>
<span id="el_school_member_receiveEmailMother">
<template id="tp_x_receiveEmailMother">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="school_member" data-field="x_receiveEmailMother" name="x_receiveEmailMother" id="x_receiveEmailMother"<?= $Page->receiveEmailMother->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_receiveEmailMother" class="ew-item-list"></div>
<selection-list hidden
    id="x_receiveEmailMother"
    name="x_receiveEmailMother"
    value="<?= HtmlEncode($Page->receiveEmailMother->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_receiveEmailMother"
    data-bs-target="dsl_x_receiveEmailMother"
    data-repeatcolumn="5"
    class="form-control<?= $Page->receiveEmailMother->isInvalidClass() ?>"
    data-table="school_member"
    data-field="x_receiveEmailMother"
    data-page="2"
    data-value-separator="<?= $Page->receiveEmailMother->displayValueSeparatorAttribute() ?>"
    <?= $Page->receiveEmailMother->editAttributes() ?>></selection-list>
<?= $Page->receiveEmailMother->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receiveEmailMother->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motherOccupation->Visible) { // motherOccupation ?>
    <div id="r_motherOccupation"<?= $Page->motherOccupation->rowAttributes() ?>>
        <label id="elh_school_member_motherOccupation" for="x_motherOccupation" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motherOccupation->caption() ?><?= $Page->motherOccupation->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motherOccupation->cellAttributes() ?>>
<span id="el_school_member_motherOccupation">
<input type="<?= $Page->motherOccupation->getInputTextType() ?>" name="x_motherOccupation" id="x_motherOccupation" data-table="school_member" data-field="x_motherOccupation" value="<?= $Page->motherOccupation->EditValue ?>" data-page="2" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->motherOccupation->getPlaceHolder()) ?>"<?= $Page->motherOccupation->editAttributes() ?> aria-describedby="x_motherOccupation_help">
<?= $Page->motherOccupation->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->motherOccupation->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motherBirthdate->Visible) { // motherBirthdate ?>
    <div id="r_motherBirthdate"<?= $Page->motherBirthdate->rowAttributes() ?>>
        <label id="elh_school_member_motherBirthdate" for="x_motherBirthdate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motherBirthdate->caption() ?><?= $Page->motherBirthdate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motherBirthdate->cellAttributes() ?>>
<span id="el_school_member_motherBirthdate">
<input type="<?= $Page->motherBirthdate->getInputTextType() ?>" name="x_motherBirthdate" id="x_motherBirthdate" data-table="school_member" data-field="x_motherBirthdate" value="<?= $Page->motherBirthdate->EditValue ?>" data-page="2" placeholder="<?= HtmlEncode($Page->motherBirthdate->getPlaceHolder()) ?>"<?= $Page->motherBirthdate->editAttributes() ?> aria-describedby="x_motherBirthdate_help">
<?= $Page->motherBirthdate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->motherBirthdate->getErrorMessage() ?></div>
<?php if (!$Page->motherBirthdate->ReadOnly && !$Page->motherBirthdate->Disabled && !isset($Page->motherBirthdate->EditAttrs["readonly"]) && !isset($Page->motherBirthdate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fschool_memberadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fschool_memberadd", "x_motherBirthdate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_school_member3" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->emergencyContact->Visible) { // emergencyContact ?>
    <div id="r_emergencyContact"<?= $Page->emergencyContact->rowAttributes() ?>>
        <label id="elh_school_member_emergencyContact" for="x_emergencyContact" class="<?= $Page->LeftColumnClass ?>"><?= $Page->emergencyContact->caption() ?><?= $Page->emergencyContact->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->emergencyContact->cellAttributes() ?>>
<span id="el_school_member_emergencyContact">
<input type="<?= $Page->emergencyContact->getInputTextType() ?>" name="x_emergencyContact" id="x_emergencyContact" data-table="school_member" data-field="x_emergencyContact" value="<?= $Page->emergencyContact->EditValue ?>" data-page="3" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->emergencyContact->getPlaceHolder()) ?>"<?= $Page->emergencyContact->editAttributes() ?> aria-describedby="x_emergencyContact_help">
<?= $Page->emergencyContact->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->emergencyContact->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->emergencyFone->Visible) { // emergencyFone ?>
    <div id="r_emergencyFone"<?= $Page->emergencyFone->rowAttributes() ?>>
        <label id="elh_school_member_emergencyFone" for="x_emergencyFone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->emergencyFone->caption() ?><?= $Page->emergencyFone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->emergencyFone->cellAttributes() ?>>
<span id="el_school_member_emergencyFone">
<input type="<?= $Page->emergencyFone->getInputTextType() ?>" name="x_emergencyFone" id="x_emergencyFone" data-table="school_member" data-field="x_emergencyFone" value="<?= $Page->emergencyFone->EditValue ?>" data-page="3" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->emergencyFone->getPlaceHolder()) ?>"<?= $Page->emergencyFone->editAttributes() ?> aria-describedby="x_emergencyFone_help">
<?= $Page->emergencyFone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->emergencyFone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <div id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <label id="elh_school_member_obs" for="x_obs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obs->caption() ?><?= $Page->obs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obs->cellAttributes() ?>>
<span id="el_school_member_obs">
<textarea data-table="school_member" data-field="x_obs" data-page="3" name="x_obs" id="x_obs" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->obs->getPlaceHolder()) ?>"<?= $Page->obs->editAttributes() ?> aria-describedby="x_obs_help"><?= $Page->obs->EditValue ?></textarea>
<?= $Page->obs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->obs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_school_member4" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->modalityId->Visible) { // modalityId ?>
    <div id="r_modalityId"<?= $Page->modalityId->rowAttributes() ?>>
        <label id="elh_school_member_modalityId" for="x_modalityId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modalityId->caption() ?><?= $Page->modalityId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modalityId->cellAttributes() ?>>
<span id="el_school_member_modalityId">
    <select
        id="x_modalityId"
        name="x_modalityId"
        class="form-select ew-select<?= $Page->modalityId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_modalityId"
        data-table="school_member"
        data-field="x_modalityId"
        data-page="4"
        data-value-separator="<?= $Page->modalityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->modalityId->getPlaceHolder()) ?>"
        <?= $Page->modalityId->editAttributes() ?>>
        <?= $Page->modalityId->selectOptionListHtml("x_modalityId") ?>
    </select>
    <?= $Page->modalityId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->modalityId->getErrorMessage() ?></div>
<?= $Page->modalityId->Lookup->getParamTag($Page, "p_x_modalityId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_modalityId", selectId: "fschool_memberadd_x_modalityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.modalityId.lookupOptions.length) {
        options.data = { id: "x_modalityId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_modalityId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.modalityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorStatus->Visible) { // instructorStatus ?>
    <div id="r_instructorStatus"<?= $Page->instructorStatus->rowAttributes() ?>>
        <label id="elh_school_member_instructorStatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorStatus->caption() ?><?= $Page->instructorStatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorStatus->cellAttributes() ?>>
<span id="el_school_member_instructorStatus">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->instructorStatus->isInvalidClass() ?>" data-table="school_member" data-field="x_instructorStatus" data-page="4" name="x_instructorStatus[]" id="x_instructorStatus_460561" value="1"<?= ConvertToBool($Page->instructorStatus->CurrentValue) ? " checked" : "" ?><?= $Page->instructorStatus->editAttributes() ?> aria-describedby="x_instructorStatus_help">
    <div class="invalid-feedback"><?= $Page->instructorStatus->getErrorMessage() ?></div>
</div>
<?= $Page->instructorStatus->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
    <div id="r_martialArtId"<?= $Page->martialArtId->rowAttributes() ?>>
        <label id="elh_school_member_martialArtId" for="x_martialArtId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->martialArtId->caption() ?><?= $Page->martialArtId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el_school_member_martialArtId">
<?php $Page->martialArtId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_martialArtId"
        name="x_martialArtId"
        class="form-select ew-select<?= $Page->martialArtId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_martialArtId"
        data-table="school_member"
        data-field="x_martialArtId"
        data-page="4"
        data-value-separator="<?= $Page->martialArtId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->martialArtId->getPlaceHolder()) ?>"
        <?= $Page->martialArtId->editAttributes() ?>>
        <?= $Page->martialArtId->selectOptionListHtml("x_martialArtId") ?>
    </select>
    <?= $Page->martialArtId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->martialArtId->getErrorMessage() ?></div>
<?= $Page->martialArtId->Lookup->getParamTag($Page, "p_x_martialArtId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_martialArtId", selectId: "fschool_memberadd_x_martialArtId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.martialArtId.lookupOptions.length) {
        options.data = { id: "x_martialArtId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_martialArtId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.martialArtId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
    <div id="r_rankId"<?= $Page->rankId->rowAttributes() ?>>
        <label id="elh_school_member_rankId" for="x_rankId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rankId->caption() ?><?= $Page->rankId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rankId->cellAttributes() ?>>
<span id="el_school_member_rankId">
    <select
        id="x_rankId"
        name="x_rankId"
        class="form-select ew-select<?= $Page->rankId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_rankId"
        data-table="school_member"
        data-field="x_rankId"
        data-page="4"
        data-value-separator="<?= $Page->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rankId->getPlaceHolder()) ?>"
        <?= $Page->rankId->editAttributes() ?>>
        <?= $Page->rankId->selectOptionListHtml("x_rankId") ?>
    </select>
    <?= $Page->rankId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->rankId->getErrorMessage() ?></div>
<?= $Page->rankId->Lookup->getParamTag($Page, "p_x_rankId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_rankId", selectId: "fschool_memberadd_x_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.rankId.lookupOptions.length) {
        options.data = { id: "x_rankId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_rankId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <div id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <label id="elh_school_member_schoolId" for="x_schoolId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->schoolId->caption() ?><?= $Page->schoolId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->schoolId->cellAttributes() ?>>
<?php if ($Page->schoolId->getSessionValue() != "") { ?>
<span<?= $Page->schoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->schoolId->getDisplayValue($Page->schoolId->ViewValue) ?></span></span>
<input type="hidden" id="x_schoolId" name="x_schoolId" value="<?= HtmlEncode($Page->schoolId->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("add")) { // Non system admin ?>
<span id="el_school_member_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-control ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_schoolId"
        data-table="school_member"
        data-field="x_schoolId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->schoolId->caption())) ?>"
        data-modal-lookup="true"
        data-page="4"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_schoolId", selectId: "fschool_memberadd_x_schoolId" };
    if (fschool_memberadd.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_schoolId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.school_member.fields.schoolId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_school_member_schoolId">
    <select
        id="x_schoolId"
        name="x_schoolId"
        class="form-control ew-select<?= $Page->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_schoolId"
        data-table="school_member"
        data-field="x_schoolId"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->schoolId->caption())) ?>"
        data-modal-lookup="true"
        data-page="4"
        data-value-separator="<?= $Page->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->schoolId->getPlaceHolder()) ?>"
        <?= $Page->schoolId->editAttributes() ?>>
        <?= $Page->schoolId->selectOptionListHtml("x_schoolId") ?>
    </select>
    <?= $Page->schoolId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->schoolId->getErrorMessage() ?></div>
<?= $Page->schoolId->Lookup->getParamTag($Page, "p_x_schoolId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_schoolId", selectId: "fschool_memberadd_x_schoolId" };
    if (fschool_memberadd.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x_schoolId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_schoolId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.school_member.fields.schoolId.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->memberStatusId->Visible) { // memberStatusId ?>
    <div id="r_memberStatusId"<?= $Page->memberStatusId->rowAttributes() ?>>
        <label id="elh_school_member_memberStatusId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->memberStatusId->caption() ?><?= $Page->memberStatusId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->memberStatusId->cellAttributes() ?>>
<span id="el_school_member_memberStatusId">
<template id="tp_x_memberStatusId">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="school_member" data-field="x_memberStatusId" name="x_memberStatusId" id="x_memberStatusId"<?= $Page->memberStatusId->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_memberStatusId" class="ew-item-list"></div>
<selection-list hidden
    id="x_memberStatusId"
    name="x_memberStatusId"
    value="<?= HtmlEncode($Page->memberStatusId->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_memberStatusId"
    data-bs-target="dsl_x_memberStatusId"
    data-repeatcolumn="5"
    class="form-control<?= $Page->memberStatusId->isInvalidClass() ?>"
    data-table="school_member"
    data-field="x_memberStatusId"
    data-page="4"
    data-value-separator="<?= $Page->memberStatusId->displayValueSeparatorAttribute() ?>"
    <?= $Page->memberStatusId->editAttributes() ?>></selection-list>
<?= $Page->memberStatusId->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->memberStatusId->getErrorMessage() ?></div>
<?= $Page->memberStatusId->Lookup->getParamTag($Page, "p_x_memberStatusId") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->beltSize->Visible) { // beltSize ?>
    <div id="r_beltSize"<?= $Page->beltSize->rowAttributes() ?>>
        <label id="elh_school_member_beltSize" for="x_beltSize" class="<?= $Page->LeftColumnClass ?>"><?= $Page->beltSize->caption() ?><?= $Page->beltSize->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->beltSize->cellAttributes() ?>>
<span id="el_school_member_beltSize">
<input type="<?= $Page->beltSize->getInputTextType() ?>" name="x_beltSize" id="x_beltSize" data-table="school_member" data-field="x_beltSize" value="<?= $Page->beltSize->EditValue ?>" data-page="4" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->beltSize->getPlaceHolder()) ?>"<?= $Page->beltSize->editAttributes() ?> aria-describedby="x_beltSize_help">
<?= $Page->beltSize->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->beltSize->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dobokSize->Visible) { // dobokSize ?>
    <div id="r_dobokSize"<?= $Page->dobokSize->rowAttributes() ?>>
        <label id="elh_school_member_dobokSize" for="x_dobokSize" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dobokSize->caption() ?><?= $Page->dobokSize->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dobokSize->cellAttributes() ?>>
<span id="el_school_member_dobokSize">
<input type="<?= $Page->dobokSize->getInputTextType() ?>" name="x_dobokSize" id="x_dobokSize" data-table="school_member" data-field="x_dobokSize" value="<?= $Page->dobokSize->EditValue ?>" data-page="4" size="30" maxlength="6" placeholder="<?= HtmlEncode($Page->dobokSize->getPlaceHolder()) ?>"<?= $Page->dobokSize->editAttributes() ?> aria-describedby="x_dobokSize_help">
<?= $Page->dobokSize->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dobokSize->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->memberLevelId->Visible) { // memberLevelId ?>
    <div id="r_memberLevelId"<?= $Page->memberLevelId->rowAttributes() ?>>
        <label id="elh_school_member_memberLevelId" for="x_memberLevelId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->memberLevelId->caption() ?><?= $Page->memberLevelId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->memberLevelId->cellAttributes() ?>>
<span id="el_school_member_memberLevelId">
    <select
        id="x_memberLevelId"
        name="x_memberLevelId"
        class="form-select ew-select<?= $Page->memberLevelId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_memberLevelId"
        data-table="school_member"
        data-field="x_memberLevelId"
        data-page="4"
        data-value-separator="<?= $Page->memberLevelId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->memberLevelId->getPlaceHolder()) ?>"
        <?= $Page->memberLevelId->editAttributes() ?>>
        <?= $Page->memberLevelId->selectOptionListHtml("x_memberLevelId") ?>
    </select>
    <?= $Page->memberLevelId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->memberLevelId->getErrorMessage() ?></div>
<?= $Page->memberLevelId->Lookup->getParamTag($Page, "p_x_memberLevelId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_memberLevelId", selectId: "fschool_memberadd_x_memberLevelId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.memberLevelId.lookupOptions.length) {
        options.data = { id: "x_memberLevelId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_memberLevelId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.memberLevelId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->instructorLevelId->Visible) { // instructorLevelId ?>
    <div id="r_instructorLevelId"<?= $Page->instructorLevelId->rowAttributes() ?>>
        <label id="elh_school_member_instructorLevelId" for="x_instructorLevelId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->instructorLevelId->caption() ?><?= $Page->instructorLevelId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->instructorLevelId->cellAttributes() ?>>
<span id="el_school_member_instructorLevelId">
    <select
        id="x_instructorLevelId"
        name="x_instructorLevelId"
        class="form-select ew-select<?= $Page->instructorLevelId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_instructorLevelId"
        data-table="school_member"
        data-field="x_instructorLevelId"
        data-page="4"
        data-value-separator="<?= $Page->instructorLevelId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->instructorLevelId->getPlaceHolder()) ?>"
        <?= $Page->instructorLevelId->editAttributes() ?>>
        <?= $Page->instructorLevelId->selectOptionListHtml("x_instructorLevelId") ?>
    </select>
    <?= $Page->instructorLevelId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->instructorLevelId->getErrorMessage() ?></div>
<?= $Page->instructorLevelId->Lookup->getParamTag($Page, "p_x_instructorLevelId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_instructorLevelId", selectId: "fschool_memberadd_x_instructorLevelId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.instructorLevelId.lookupOptions.length) {
        options.data = { id: "x_instructorLevelId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_instructorLevelId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.instructorLevelId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->judgeLevelId->Visible) { // judgeLevelId ?>
    <div id="r_judgeLevelId"<?= $Page->judgeLevelId->rowAttributes() ?>>
        <label id="elh_school_member_judgeLevelId" for="x_judgeLevelId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->judgeLevelId->caption() ?><?= $Page->judgeLevelId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->judgeLevelId->cellAttributes() ?>>
<span id="el_school_member_judgeLevelId">
    <select
        id="x_judgeLevelId"
        name="x_judgeLevelId"
        class="form-select ew-select<?= $Page->judgeLevelId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_judgeLevelId"
        data-table="school_member"
        data-field="x_judgeLevelId"
        data-page="4"
        data-value-separator="<?= $Page->judgeLevelId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->judgeLevelId->getPlaceHolder()) ?>"
        <?= $Page->judgeLevelId->editAttributes() ?>>
        <?= $Page->judgeLevelId->selectOptionListHtml("x_judgeLevelId") ?>
    </select>
    <?= $Page->judgeLevelId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->judgeLevelId->getErrorMessage() ?></div>
<?= $Page->judgeLevelId->Lookup->getParamTag($Page, "p_x_judgeLevelId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_judgeLevelId", selectId: "fschool_memberadd_x_judgeLevelId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.judgeLevelId.lookupOptions.length) {
        options.data = { id: "x_judgeLevelId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_judgeLevelId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.judgeLevelId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->federationRegisterDate->Visible) { // federationRegisterDate ?>
    <div id="r_federationRegisterDate"<?= $Page->federationRegisterDate->rowAttributes() ?>>
        <label id="elh_school_member_federationRegisterDate" for="x_federationRegisterDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->federationRegisterDate->caption() ?><?= $Page->federationRegisterDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->federationRegisterDate->cellAttributes() ?>>
<span id="el_school_member_federationRegisterDate">
<input type="<?= $Page->federationRegisterDate->getInputTextType() ?>" name="x_federationRegisterDate" id="x_federationRegisterDate" data-table="school_member" data-field="x_federationRegisterDate" value="<?= $Page->federationRegisterDate->EditValue ?>" data-page="4" placeholder="<?= HtmlEncode($Page->federationRegisterDate->getPlaceHolder()) ?>"<?= $Page->federationRegisterDate->editAttributes() ?> aria-describedby="x_federationRegisterDate_help">
<?= $Page->federationRegisterDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->federationRegisterDate->getErrorMessage() ?></div>
<?php if (!$Page->federationRegisterDate->ReadOnly && !$Page->federationRegisterDate->Disabled && !isset($Page->federationRegisterDate->EditAttrs["readonly"]) && !isset($Page->federationRegisterDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fschool_memberadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fschool_memberadd", "x_federationRegisterDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marketingSourceId->Visible) { // marketingSourceId ?>
    <div id="r_marketingSourceId"<?= $Page->marketingSourceId->rowAttributes() ?>>
        <label id="elh_school_member_marketingSourceId" for="x_marketingSourceId" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marketingSourceId->caption() ?><?= $Page->marketingSourceId->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marketingSourceId->cellAttributes() ?>>
<span id="el_school_member_marketingSourceId">
    <select
        id="x_marketingSourceId"
        name="x_marketingSourceId"
        class="form-select ew-select<?= $Page->marketingSourceId->isInvalidClass() ?>"
        data-select2-id="fschool_memberadd_x_marketingSourceId"
        data-table="school_member"
        data-field="x_marketingSourceId"
        data-page="4"
        data-value-separator="<?= $Page->marketingSourceId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->marketingSourceId->getPlaceHolder()) ?>"
        <?= $Page->marketingSourceId->editAttributes() ?>>
        <?= $Page->marketingSourceId->selectOptionListHtml("x_marketingSourceId") ?>
    </select>
    <?= $Page->marketingSourceId->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->marketingSourceId->getErrorMessage() ?></div>
<?= $Page->marketingSourceId->Lookup->getParamTag($Page, "p_x_marketingSourceId") ?>
<script>
loadjs.ready("fschool_memberadd", function() {
    var options = { name: "x_marketingSourceId", selectId: "fschool_memberadd_x_marketingSourceId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_memberadd.lists.marketingSourceId.lookupOptions.length) {
        options.data = { id: "x_marketingSourceId", form: "fschool_memberadd" };
    } else {
        options.ajax = { id: "x_marketingSourceId", form: "fschool_memberadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.marketingSourceId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marketingSourceDetail->Visible) { // marketingSourceDetail ?>
    <div id="r_marketingSourceDetail"<?= $Page->marketingSourceDetail->rowAttributes() ?>>
        <label id="elh_school_member_marketingSourceDetail" for="x_marketingSourceDetail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marketingSourceDetail->caption() ?><?= $Page->marketingSourceDetail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marketingSourceDetail->cellAttributes() ?>>
<span id="el_school_member_marketingSourceDetail">
<input type="<?= $Page->marketingSourceDetail->getInputTextType() ?>" name="x_marketingSourceDetail" id="x_marketingSourceDetail" data-table="school_member" data-field="x_marketingSourceDetail" value="<?= $Page->marketingSourceDetail->EditValue ?>" data-page="4" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->marketingSourceDetail->getPlaceHolder()) ?>"<?= $Page->marketingSourceDetail->editAttributes() ?> aria-describedby="x_marketingSourceDetail_help">
<?= $Page->marketingSourceDetail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->marketingSourceDetail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
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
    ew.addEventHandlers("school_member");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
