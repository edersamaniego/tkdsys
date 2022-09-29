<?php

namespace PHPMaker2022\school;

// Page object
$FedSchoolView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_school: currentTable } });
var currentForm, currentPageID;
var ffed_schoolview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_schoolview = new ew.Form("ffed_schoolview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffed_schoolview;
    loadjs.done("ffed_schoolview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<?php } ?>
<form name="ffed_schoolview" id="ffed_schoolview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_school">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_school_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <tr id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_federationId"><?= $Page->federationId->caption() ?></span></td>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el_fed_school_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <tr id="r_masterSchoolId"<?= $Page->masterSchoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_masterSchoolId"><?= $Page->masterSchoolId->caption() ?></span></td>
        <td data-name="masterSchoolId"<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el_fed_school_masterSchoolId">
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
    <tr id="r_school"<?= $Page->school->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_school"><?= $Page->school->caption() ?></span></td>
        <td data-name="school"<?= $Page->school->cellAttributes() ?>>
<span id="el_fed_school_school">
<span<?= $Page->school->viewAttributes() ?>>
<?= $Page->school->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <tr id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_countryId"><?= $Page->countryId->caption() ?></span></td>
        <td data-name="countryId"<?= $Page->countryId->cellAttributes() ?>>
<span id="el_fed_school_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
    <tr id="r_UFId"<?= $Page->UFId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_UFId"><?= $Page->UFId->caption() ?></span></td>
        <td data-name="UFId"<?= $Page->UFId->cellAttributes() ?>>
<span id="el_fed_school_UFId">
<span<?= $Page->UFId->viewAttributes() ?>>
<?= $Page->UFId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
    <tr id="r_cityId"<?= $Page->cityId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_cityId"><?= $Page->cityId->caption() ?></span></td>
        <td data-name="cityId"<?= $Page->cityId->cellAttributes() ?>>
<span id="el_fed_school_cityId">
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <tr id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_neighborhood"><?= $Page->neighborhood->caption() ?></span></td>
        <td data-name="neighborhood"<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_fed_school_neighborhood">
<span<?= $Page->neighborhood->viewAttributes() ?>>
<?= $Page->neighborhood->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <tr id="r_address"<?= $Page->address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_address"><?= $Page->address->caption() ?></span></td>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el_fed_school_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
    <tr id="r_zipcode"<?= $Page->zipcode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_zipcode"><?= $Page->zipcode->caption() ?></span></td>
        <td data-name="zipcode"<?= $Page->zipcode->cellAttributes() ?>>
<span id="el_fed_school_zipcode">
<span<?= $Page->zipcode->viewAttributes() ?>>
<?= $Page->zipcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <tr id="r_website"<?= $Page->website->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_website"><?= $Page->website->caption() ?></span></td>
        <td data-name="website"<?= $Page->website->cellAttributes() ?>>
<span id="el_fed_school_website">
<span<?= $Page->website->viewAttributes() ?>>
<?= $Page->website->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_fed_school__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->phone->Visible) { // phone ?>
    <tr id="r_phone"<?= $Page->phone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_phone"><?= $Page->phone->caption() ?></span></td>
        <td data-name="phone"<?= $Page->phone->cellAttributes() ?>>
<span id="el_fed_school_phone">
<span<?= $Page->phone->viewAttributes() ?>>
<?= $Page->phone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->celphone->Visible) { // celphone ?>
    <tr id="r_celphone"<?= $Page->celphone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_celphone"><?= $Page->celphone->caption() ?></span></td>
        <td data-name="celphone"<?= $Page->celphone->cellAttributes() ?>>
<span id="el_fed_school_celphone">
<span<?= $Page->celphone->viewAttributes() ?>>
<?= $Page->celphone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
    <tr id="r_logo"<?= $Page->logo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_logo"><?= $Page->logo->caption() ?></span></td>
        <td data-name="logo"<?= $Page->logo->cellAttributes() ?>>
<span id="el_fed_school_logo">
<span<?= $Page->logo->viewAttributes() ?>>
<?= $Page->logo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->openingDate->Visible) { // openingDate ?>
    <tr id="r_openingDate"<?= $Page->openingDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_openingDate"><?= $Page->openingDate->caption() ?></span></td>
        <td data-name="openingDate"<?= $Page->openingDate->cellAttributes() ?>>
<span id="el_fed_school_openingDate">
<span<?= $Page->openingDate->viewAttributes() ?>>
<?= $Page->openingDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
    <tr id="r_federationRegister"<?= $Page->federationRegister->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_federationRegister"><?= $Page->federationRegister->caption() ?></span></td>
        <td data-name="federationRegister"<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el_fed_school_federationRegister">
<span<?= $Page->federationRegister->viewAttributes() ?>>
<?= $Page->federationRegister->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <tr id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_createUserId"><?= $Page->createUserId->caption() ?></span></td>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_fed_school_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_school_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
    <tr id="r_typeId"<?= $Page->typeId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_typeId"><?= $Page->typeId->caption() ?></span></td>
        <td data-name="typeId"<?= $Page->typeId->cellAttributes() ?>>
<span id="el_fed_school_typeId">
<span<?= $Page->typeId->viewAttributes() ?>>
<?= $Page->typeId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
    <tr id="r_owner"<?= $Page->owner->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_owner"><?= $Page->owner->caption() ?></span></td>
        <td data-name="owner"<?= $Page->owner->cellAttributes() ?>>
<span id="el_fed_school_owner">
<span<?= $Page->owner->viewAttributes() ?>>
<?= $Page->owner->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->identityNumber->Visible) { // identityNumber ?>
    <tr id="r_identityNumber"<?= $Page->identityNumber->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_identityNumber"><?= $Page->identityNumber->caption() ?></span></td>
        <td data-name="identityNumber"<?= $Page->identityNumber->cellAttributes() ?>>
<span id="el_fed_school_identityNumber">
<span<?= $Page->identityNumber->viewAttributes() ?>>
<?= $Page->identityNumber->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->birthDateOwner->Visible) { // birthDateOwner ?>
    <tr id="r_birthDateOwner"<?= $Page->birthDateOwner->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_birthDateOwner"><?= $Page->birthDateOwner->caption() ?></span></td>
        <td data-name="birthDateOwner"<?= $Page->birthDateOwner->cellAttributes() ?>>
<span id="el_fed_school_birthDateOwner">
<span<?= $Page->birthDateOwner->viewAttributes() ?>>
<?= $Page->birthDateOwner->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerCountryId->Visible) { // ownerCountryId ?>
    <tr id="r_ownerCountryId"<?= $Page->ownerCountryId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerCountryId"><?= $Page->ownerCountryId->caption() ?></span></td>
        <td data-name="ownerCountryId"<?= $Page->ownerCountryId->cellAttributes() ?>>
<span id="el_fed_school_ownerCountryId">
<span<?= $Page->ownerCountryId->viewAttributes() ?>>
<?= $Page->ownerCountryId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerStateId->Visible) { // ownerStateId ?>
    <tr id="r_ownerStateId"<?= $Page->ownerStateId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerStateId"><?= $Page->ownerStateId->caption() ?></span></td>
        <td data-name="ownerStateId"<?= $Page->ownerStateId->cellAttributes() ?>>
<span id="el_fed_school_ownerStateId">
<span<?= $Page->ownerStateId->viewAttributes() ?>>
<?= $Page->ownerStateId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownCityId->Visible) { // ownCityId ?>
    <tr id="r_ownCityId"<?= $Page->ownCityId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownCityId"><?= $Page->ownCityId->caption() ?></span></td>
        <td data-name="ownCityId"<?= $Page->ownCityId->cellAttributes() ?>>
<span id="el_fed_school_ownCityId">
<span<?= $Page->ownCityId->viewAttributes() ?>>
<?= $Page->ownCityId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerTelephone->Visible) { // ownerTelephone ?>
    <tr id="r_ownerTelephone"<?= $Page->ownerTelephone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerTelephone"><?= $Page->ownerTelephone->caption() ?></span></td>
        <td data-name="ownerTelephone"<?= $Page->ownerTelephone->cellAttributes() ?>>
<span id="el_fed_school_ownerTelephone">
<span<?= $Page->ownerTelephone->viewAttributes() ?>>
<?= $Page->ownerTelephone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerTelephoneWork->Visible) { // ownerTelephoneWork ?>
    <tr id="r_ownerTelephoneWork"<?= $Page->ownerTelephoneWork->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerTelephoneWork"><?= $Page->ownerTelephoneWork->caption() ?></span></td>
        <td data-name="ownerTelephoneWork"<?= $Page->ownerTelephoneWork->cellAttributes() ?>>
<span id="el_fed_school_ownerTelephoneWork">
<span<?= $Page->ownerTelephoneWork->viewAttributes() ?>>
<?= $Page->ownerTelephoneWork->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerProfession->Visible) { // ownerProfession ?>
    <tr id="r_ownerProfession"<?= $Page->ownerProfession->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerProfession"><?= $Page->ownerProfession->caption() ?></span></td>
        <td data-name="ownerProfession"<?= $Page->ownerProfession->cellAttributes() ?>>
<span id="el_fed_school_ownerProfession">
<span<?= $Page->ownerProfession->viewAttributes() ?>>
<?= $Page->ownerProfession->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->employer->Visible) { // employer ?>
    <tr id="r_employer"<?= $Page->employer->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_employer"><?= $Page->employer->caption() ?></span></td>
        <td data-name="employer"<?= $Page->employer->cellAttributes() ?>>
<span id="el_fed_school_employer">
<span<?= $Page->employer->viewAttributes() ?>>
<?= $Page->employer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerGraduation->Visible) { // ownerGraduation ?>
    <tr id="r_ownerGraduation"<?= $Page->ownerGraduation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerGraduation"><?= $Page->ownerGraduation->caption() ?></span></td>
        <td data-name="ownerGraduation"<?= $Page->ownerGraduation->cellAttributes() ?>>
<span id="el_fed_school_ownerGraduation">
<span<?= $Page->ownerGraduation->viewAttributes() ?>>
<?= $Page->ownerGraduation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerGraduationLocation->Visible) { // ownerGraduationLocation ?>
    <tr id="r_ownerGraduationLocation"<?= $Page->ownerGraduationLocation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerGraduationLocation"><?= $Page->ownerGraduationLocation->caption() ?></span></td>
        <td data-name="ownerGraduationLocation"<?= $Page->ownerGraduationLocation->cellAttributes() ?>>
<span id="el_fed_school_ownerGraduationLocation">
<span<?= $Page->ownerGraduationLocation->viewAttributes() ?>>
<?= $Page->ownerGraduationLocation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerGraduationObs->Visible) { // ownerGraduationObs ?>
    <tr id="r_ownerGraduationObs"<?= $Page->ownerGraduationObs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerGraduationObs"><?= $Page->ownerGraduationObs->caption() ?></span></td>
        <td data-name="ownerGraduationObs"<?= $Page->ownerGraduationObs->cellAttributes() ?>>
<span id="el_fed_school_ownerGraduationObs">
<span<?= $Page->ownerGraduationObs->viewAttributes() ?>>
<?= $Page->ownerGraduationObs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerMaritalStatus->Visible) { // ownerMaritalStatus ?>
    <tr id="r_ownerMaritalStatus"<?= $Page->ownerMaritalStatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerMaritalStatus"><?= $Page->ownerMaritalStatus->caption() ?></span></td>
        <td data-name="ownerMaritalStatus"<?= $Page->ownerMaritalStatus->cellAttributes() ?>>
<span id="el_fed_school_ownerMaritalStatus">
<span<?= $Page->ownerMaritalStatus->viewAttributes() ?>>
<?= $Page->ownerMaritalStatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerSpouseName->Visible) { // ownerSpouseName ?>
    <tr id="r_ownerSpouseName"<?= $Page->ownerSpouseName->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerSpouseName"><?= $Page->ownerSpouseName->caption() ?></span></td>
        <td data-name="ownerSpouseName"<?= $Page->ownerSpouseName->cellAttributes() ?>>
<span id="el_fed_school_ownerSpouseName">
<span<?= $Page->ownerSpouseName->viewAttributes() ?>>
<?= $Page->ownerSpouseName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerSpouseProfession->Visible) { // ownerSpouseProfession ?>
    <tr id="r_ownerSpouseProfession"<?= $Page->ownerSpouseProfession->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerSpouseProfession"><?= $Page->ownerSpouseProfession->caption() ?></span></td>
        <td data-name="ownerSpouseProfession"<?= $Page->ownerSpouseProfession->cellAttributes() ?>>
<span id="el_fed_school_ownerSpouseProfession">
<span<?= $Page->ownerSpouseProfession->viewAttributes() ?>>
<?= $Page->ownerSpouseProfession->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->propertySituation->Visible) { // propertySituation ?>
    <tr id="r_propertySituation"<?= $Page->propertySituation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_propertySituation"><?= $Page->propertySituation->caption() ?></span></td>
        <td data-name="propertySituation"<?= $Page->propertySituation->cellAttributes() ?>>
<span id="el_fed_school_propertySituation">
<span<?= $Page->propertySituation->viewAttributes() ?>>
<?= $Page->propertySituation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->numberOfStudentsInBeginnig->Visible) { // numberOfStudentsInBeginnig ?>
    <tr id="r_numberOfStudentsInBeginnig"<?= $Page->numberOfStudentsInBeginnig->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_numberOfStudentsInBeginnig"><?= $Page->numberOfStudentsInBeginnig->caption() ?></span></td>
        <td data-name="numberOfStudentsInBeginnig"<?= $Page->numberOfStudentsInBeginnig->cellAttributes() ?>>
<span id="el_fed_school_numberOfStudentsInBeginnig">
<span<?= $Page->numberOfStudentsInBeginnig->viewAttributes() ?>>
<?= $Page->numberOfStudentsInBeginnig->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ownerAbout->Visible) { // ownerAbout ?>
    <tr id="r_ownerAbout"<?= $Page->ownerAbout->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_ownerAbout"><?= $Page->ownerAbout->caption() ?></span></td>
        <td data-name="ownerAbout"<?= $Page->ownerAbout->cellAttributes() ?>>
<span id="el_fed_school_ownerAbout">
<span<?= $Page->ownerAbout->viewAttributes() ?>>
<?= $Page->ownerAbout->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pdfLicense->Visible) { // pdfLicense ?>
    <tr id="r_pdfLicense"<?= $Page->pdfLicense->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_pdfLicense"><?= $Page->pdfLicense->caption() ?></span></td>
        <td data-name="pdfLicense"<?= $Page->pdfLicense->cellAttributes() ?>>
<span id="el_fed_school_pdfLicense">
<span<?= $Page->pdfLicense->viewAttributes() ?>>
<?= $Page->pdfLicense->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
    <tr id="r_applicationId"<?= $Page->applicationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_applicationId"><?= $Page->applicationId->caption() ?></span></td>
        <td data-name="applicationId"<?= $Page->applicationId->cellAttributes() ?>>
<span id="el_fed_school_applicationId">
<span<?= $Page->applicationId->viewAttributes() ?>>
<?= $Page->applicationId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
    <tr id="r_isheadquarter"<?= $Page->isheadquarter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_school_isheadquarter"><?= $Page->isheadquarter->caption() ?></span></td>
        <td data-name="isheadquarter"<?= $Page->isheadquarter->cellAttributes() ?>>
<span id="el_fed_school_isheadquarter">
<span<?= $Page->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isheadquarter->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav<?= $Page->DetailPages->containerClasses() ?>" id="details_Page"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navClasses() ?>" role="tablist"><!-- .nav -->
<?php
    if (in_array("school_users", explode(",", $Page->getCurrentDetailTable())) && $school_users->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("school_users") ?><?= $Page->DetailPages->activeClasses("school_users") ?>" data-bs-target="#tab_school_users" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_users" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("school_users")) ?>"><?= $Language->tablePhrase("school_users", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("school_users")->Count, $Language->phrase("DetailCount")) ?></button></li>
<?php
    }
?>
<?php
    if (in_array("school_member", explode(",", $Page->getCurrentDetailTable())) && $school_member->DetailView) {
?>
        <li class="nav-item"><button class="<?= $Page->DetailPages->navLinkClasses("school_member") ?><?= $Page->DetailPages->activeClasses("school_member") ?>" data-bs-target="#tab_school_member" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_school_member" aria-selected="<?= JsonEncode($Page->DetailPages->isActive("school_member")) ?>"><?= $Language->tablePhrase("school_member", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("school_member")->Count, $Language->phrase("DetailCount")) ?></button></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="<?= $Page->DetailPages->tabContentClasses() ?>"><!-- .tab-content -->
<?php
    if (in_array("school_users", explode(",", $Page->getCurrentDetailTable())) && $school_users->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("school_users") ?><?= $Page->DetailPages->activeClasses("school_users") ?>" id="tab_school_users" role="tabpanel"><!-- page* -->
<?php include_once "SchoolUsersGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("school_member", explode(",", $Page->getCurrentDetailTable())) && $school_member->DetailView) {
?>
        <div class="<?= $Page->DetailPages->tabPaneClasses("school_member") ?><?= $Page->DetailPages->activeClasses("school_member") ?>" id="tab_school_member" role="tabpanel"><!-- page* -->
<?php include_once "SchoolMemberGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
