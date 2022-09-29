<?php

namespace PHPMaker2022\school;

// Page object
$SchoolMemberView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_member: currentTable } });
var currentForm, currentPageID;
var fschool_memberview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_memberview = new ew.Form("fschool_memberview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fschool_memberview;
    loadjs.done("fschool_memberview");
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
<form name="fschool_memberview" id="fschool_memberview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_member">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_school_member_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name"<?= $Page->name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el_school_member_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
    <tr id="r_lastName"<?= $Page->lastName->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_lastName"><?= $Page->lastName->caption() ?></span></td>
        <td data-name="lastName"<?= $Page->lastName->cellAttributes() ?>>
<span id="el_school_member_lastName">
<span<?= $Page->lastName->viewAttributes() ?>>
<?= $Page->lastName->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->birthdate->Visible) { // birthdate ?>
    <tr id="r_birthdate"<?= $Page->birthdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_birthdate"><?= $Page->birthdate->caption() ?></span></td>
        <td data-name="birthdate"<?= $Page->birthdate->cellAttributes() ?>>
<span id="el_school_member_birthdate">
<span<?= $Page->birthdate->viewAttributes() ?>>
<?= $Page->birthdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
    <tr id="r_gender"<?= $Page->gender->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_gender"><?= $Page->gender->caption() ?></span></td>
        <td data-name="gender"<?= $Page->gender->cellAttributes() ?>>
<span id="el_school_member_gender">
<span<?= $Page->gender->viewAttributes() ?>>
<?= $Page->gender->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <tr id="r_address"<?= $Page->address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_address"><?= $Page->address->caption() ?></span></td>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el_school_member_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
    <tr id="r_neighborhood"<?= $Page->neighborhood->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_neighborhood"><?= $Page->neighborhood->caption() ?></span></td>
        <td data-name="neighborhood"<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el_school_member_neighborhood">
<span<?= $Page->neighborhood->viewAttributes() ?>>
<?= $Page->neighborhood->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <tr id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_countryId"><?= $Page->countryId->caption() ?></span></td>
        <td data-name="countryId"<?= $Page->countryId->cellAttributes() ?>>
<span id="el_school_member_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
    <tr id="r_UFId"<?= $Page->UFId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_UFId"><?= $Page->UFId->caption() ?></span></td>
        <td data-name="UFId"<?= $Page->UFId->cellAttributes() ?>>
<span id="el_school_member_UFId">
<span<?= $Page->UFId->viewAttributes() ?>>
<?= $Page->UFId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
    <tr id="r_cityId"<?= $Page->cityId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_cityId"><?= $Page->cityId->caption() ?></span></td>
        <td data-name="cityId"<?= $Page->cityId->cellAttributes() ?>>
<span id="el_school_member_cityId">
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->zip->Visible) { // zip ?>
    <tr id="r_zip"<?= $Page->zip->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_zip"><?= $Page->zip->caption() ?></span></td>
        <td data-name="zip"<?= $Page->zip->cellAttributes() ?>>
<span id="el_school_member_zip">
<span<?= $Page->zip->viewAttributes() ?>>
<?= $Page->zip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->celphone->Visible) { // celphone ?>
    <tr id="r_celphone"<?= $Page->celphone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_celphone"><?= $Page->celphone->caption() ?></span></td>
        <td data-name="celphone"<?= $Page->celphone->cellAttributes() ?>>
<span id="el_school_member_celphone">
<span<?= $Page->celphone->viewAttributes() ?>>
<?= $Page->celphone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_school_member__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->facebook->Visible) { // facebook ?>
    <tr id="r_facebook"<?= $Page->facebook->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_facebook"><?= $Page->facebook->caption() ?></span></td>
        <td data-name="facebook"<?= $Page->facebook->cellAttributes() ?>>
<span id="el_school_member_facebook">
<span<?= $Page->facebook->viewAttributes() ?>>
<?= $Page->facebook->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instagram->Visible) { // instagram ?>
    <tr id="r_instagram"<?= $Page->instagram->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_instagram"><?= $Page->instagram->caption() ?></span></td>
        <td data-name="instagram"<?= $Page->instagram->cellAttributes() ?>>
<span id="el_school_member_instagram">
<span<?= $Page->instagram->viewAttributes() ?>>
<?= $Page->instagram->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->father->Visible) { // father ?>
    <tr id="r_father"<?= $Page->father->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_father"><?= $Page->father->caption() ?></span></td>
        <td data-name="father"<?= $Page->father->cellAttributes() ?>>
<span id="el_school_member_father">
<span<?= $Page->father->viewAttributes() ?>>
<?= $Page->father->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fatherCellphone->Visible) { // fatherCellphone ?>
    <tr id="r_fatherCellphone"<?= $Page->fatherCellphone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_fatherCellphone"><?= $Page->fatherCellphone->caption() ?></span></td>
        <td data-name="fatherCellphone"<?= $Page->fatherCellphone->cellAttributes() ?>>
<span id="el_school_member_fatherCellphone">
<span<?= $Page->fatherCellphone->viewAttributes() ?>>
<?= $Page->fatherCellphone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receiveSmsFather->Visible) { // receiveSmsFather ?>
    <tr id="r_receiveSmsFather"<?= $Page->receiveSmsFather->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_receiveSmsFather"><?= $Page->receiveSmsFather->caption() ?></span></td>
        <td data-name="receiveSmsFather"<?= $Page->receiveSmsFather->cellAttributes() ?>>
<span id="el_school_member_receiveSmsFather">
<span<?= $Page->receiveSmsFather->viewAttributes() ?>>
<?= $Page->receiveSmsFather->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fatherEmail->Visible) { // fatherEmail ?>
    <tr id="r_fatherEmail"<?= $Page->fatherEmail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_fatherEmail"><?= $Page->fatherEmail->caption() ?></span></td>
        <td data-name="fatherEmail"<?= $Page->fatherEmail->cellAttributes() ?>>
<span id="el_school_member_fatherEmail">
<span<?= $Page->fatherEmail->viewAttributes() ?>>
<?= $Page->fatherEmail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receiveEmailFather->Visible) { // receiveEmailFather ?>
    <tr id="r_receiveEmailFather"<?= $Page->receiveEmailFather->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_receiveEmailFather"><?= $Page->receiveEmailFather->caption() ?></span></td>
        <td data-name="receiveEmailFather"<?= $Page->receiveEmailFather->cellAttributes() ?>>
<span id="el_school_member_receiveEmailFather">
<span<?= $Page->receiveEmailFather->viewAttributes() ?>>
<?= $Page->receiveEmailFather->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fatherOccupation->Visible) { // fatherOccupation ?>
    <tr id="r_fatherOccupation"<?= $Page->fatherOccupation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_fatherOccupation"><?= $Page->fatherOccupation->caption() ?></span></td>
        <td data-name="fatherOccupation"<?= $Page->fatherOccupation->cellAttributes() ?>>
<span id="el_school_member_fatherOccupation">
<span<?= $Page->fatherOccupation->viewAttributes() ?>>
<?= $Page->fatherOccupation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fatherBirthdate->Visible) { // fatherBirthdate ?>
    <tr id="r_fatherBirthdate"<?= $Page->fatherBirthdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_fatherBirthdate"><?= $Page->fatherBirthdate->caption() ?></span></td>
        <td data-name="fatherBirthdate"<?= $Page->fatherBirthdate->cellAttributes() ?>>
<span id="el_school_member_fatherBirthdate">
<span<?= $Page->fatherBirthdate->viewAttributes() ?>>
<?= $Page->fatherBirthdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mother->Visible) { // mother ?>
    <tr id="r_mother"<?= $Page->mother->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_mother"><?= $Page->mother->caption() ?></span></td>
        <td data-name="mother"<?= $Page->mother->cellAttributes() ?>>
<span id="el_school_member_mother">
<span<?= $Page->mother->viewAttributes() ?>>
<?= $Page->mother->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motherCellphone->Visible) { // motherCellphone ?>
    <tr id="r_motherCellphone"<?= $Page->motherCellphone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_motherCellphone"><?= $Page->motherCellphone->caption() ?></span></td>
        <td data-name="motherCellphone"<?= $Page->motherCellphone->cellAttributes() ?>>
<span id="el_school_member_motherCellphone">
<span<?= $Page->motherCellphone->viewAttributes() ?>>
<?= $Page->motherCellphone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receiveSmsMother->Visible) { // receiveSmsMother ?>
    <tr id="r_receiveSmsMother"<?= $Page->receiveSmsMother->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_receiveSmsMother"><?= $Page->receiveSmsMother->caption() ?></span></td>
        <td data-name="receiveSmsMother"<?= $Page->receiveSmsMother->cellAttributes() ?>>
<span id="el_school_member_receiveSmsMother">
<span<?= $Page->receiveSmsMother->viewAttributes() ?>>
<?= $Page->receiveSmsMother->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motherEmail->Visible) { // motherEmail ?>
    <tr id="r_motherEmail"<?= $Page->motherEmail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_motherEmail"><?= $Page->motherEmail->caption() ?></span></td>
        <td data-name="motherEmail"<?= $Page->motherEmail->cellAttributes() ?>>
<span id="el_school_member_motherEmail">
<span<?= $Page->motherEmail->viewAttributes() ?>>
<?= $Page->motherEmail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receiveEmailMother->Visible) { // receiveEmailMother ?>
    <tr id="r_receiveEmailMother"<?= $Page->receiveEmailMother->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_receiveEmailMother"><?= $Page->receiveEmailMother->caption() ?></span></td>
        <td data-name="receiveEmailMother"<?= $Page->receiveEmailMother->cellAttributes() ?>>
<span id="el_school_member_receiveEmailMother">
<span<?= $Page->receiveEmailMother->viewAttributes() ?>>
<?= $Page->receiveEmailMother->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motherOccupation->Visible) { // motherOccupation ?>
    <tr id="r_motherOccupation"<?= $Page->motherOccupation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_motherOccupation"><?= $Page->motherOccupation->caption() ?></span></td>
        <td data-name="motherOccupation"<?= $Page->motherOccupation->cellAttributes() ?>>
<span id="el_school_member_motherOccupation">
<span<?= $Page->motherOccupation->viewAttributes() ?>>
<?= $Page->motherOccupation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motherBirthdate->Visible) { // motherBirthdate ?>
    <tr id="r_motherBirthdate"<?= $Page->motherBirthdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_motherBirthdate"><?= $Page->motherBirthdate->caption() ?></span></td>
        <td data-name="motherBirthdate"<?= $Page->motherBirthdate->cellAttributes() ?>>
<span id="el_school_member_motherBirthdate">
<span<?= $Page->motherBirthdate->viewAttributes() ?>>
<?= $Page->motherBirthdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->emergencyContact->Visible) { // emergencyContact ?>
    <tr id="r_emergencyContact"<?= $Page->emergencyContact->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_emergencyContact"><?= $Page->emergencyContact->caption() ?></span></td>
        <td data-name="emergencyContact"<?= $Page->emergencyContact->cellAttributes() ?>>
<span id="el_school_member_emergencyContact">
<span<?= $Page->emergencyContact->viewAttributes() ?>>
<?= $Page->emergencyContact->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->emergencyFone->Visible) { // emergencyFone ?>
    <tr id="r_emergencyFone"<?= $Page->emergencyFone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_emergencyFone"><?= $Page->emergencyFone->caption() ?></span></td>
        <td data-name="emergencyFone"<?= $Page->emergencyFone->cellAttributes() ?>>
<span id="el_school_member_emergencyFone">
<span<?= $Page->emergencyFone->viewAttributes() ?>>
<?= $Page->emergencyFone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_school_member_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
    <tr id="r_modalityId"<?= $Page->modalityId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_modalityId"><?= $Page->modalityId->caption() ?></span></td>
        <td data-name="modalityId"<?= $Page->modalityId->cellAttributes() ?>>
<span id="el_school_member_modalityId">
<span<?= $Page->modalityId->viewAttributes() ?>>
<?= $Page->modalityId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorStatus->Visible) { // instructorStatus ?>
    <tr id="r_instructorStatus"<?= $Page->instructorStatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_instructorStatus"><?= $Page->instructorStatus->caption() ?></span></td>
        <td data-name="instructorStatus"<?= $Page->instructorStatus->cellAttributes() ?>>
<span id="el_school_member_instructorStatus">
<span<?= $Page->instructorStatus->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_instructorStatus_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->instructorStatus->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->instructorStatus->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_instructorStatus_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
    <tr id="r_martialArtId"<?= $Page->martialArtId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_martialArtId"><?= $Page->martialArtId->caption() ?></span></td>
        <td data-name="martialArtId"<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el_school_member_martialArtId">
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
    <tr id="r_rankId"<?= $Page->rankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_rankId"><?= $Page->rankId->caption() ?></span></td>
        <td data-name="rankId"<?= $Page->rankId->cellAttributes() ?>>
<span id="el_school_member_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_school_member_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberStatusId->Visible) { // memberStatusId ?>
    <tr id="r_memberStatusId"<?= $Page->memberStatusId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_memberStatusId"><?= $Page->memberStatusId->caption() ?></span></td>
        <td data-name="memberStatusId"<?= $Page->memberStatusId->cellAttributes() ?>>
<span id="el_school_member_memberStatusId">
<span<?= $Page->memberStatusId->viewAttributes() ?>>
<?= $Page->memberStatusId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <tr id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_photo"><?= $Page->photo->caption() ?></span></td>
        <td data-name="photo"<?= $Page->photo->cellAttributes() ?>>
<span id="el_school_member_photo">
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->beltSize->Visible) { // beltSize ?>
    <tr id="r_beltSize"<?= $Page->beltSize->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_beltSize"><?= $Page->beltSize->caption() ?></span></td>
        <td data-name="beltSize"<?= $Page->beltSize->cellAttributes() ?>>
<span id="el_school_member_beltSize">
<span<?= $Page->beltSize->viewAttributes() ?>>
<?= $Page->beltSize->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dobokSize->Visible) { // dobokSize ?>
    <tr id="r_dobokSize"<?= $Page->dobokSize->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_dobokSize"><?= $Page->dobokSize->caption() ?></span></td>
        <td data-name="dobokSize"<?= $Page->dobokSize->cellAttributes() ?>>
<span id="el_school_member_dobokSize">
<span<?= $Page->dobokSize->viewAttributes() ?>>
<?= $Page->dobokSize->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->programId->Visible) { // programId ?>
    <tr id="r_programId"<?= $Page->programId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_programId"><?= $Page->programId->caption() ?></span></td>
        <td data-name="programId"<?= $Page->programId->cellAttributes() ?>>
<span id="el_school_member_programId">
<span<?= $Page->programId->viewAttributes() ?>>
<?= $Page->programId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->classId->Visible) { // classId ?>
    <tr id="r_classId"<?= $Page->classId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_classId"><?= $Page->classId->caption() ?></span></td>
        <td data-name="classId"<?= $Page->classId->cellAttributes() ?>>
<span id="el_school_member_classId">
<span<?= $Page->classId->viewAttributes() ?>>
<?= $Page->classId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
    <tr id="r_federationRegister"<?= $Page->federationRegister->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_federationRegister"><?= $Page->federationRegister->caption() ?></span></td>
        <td data-name="federationRegister"<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el_school_member_federationRegister">
<span<?= $Page->federationRegister->viewAttributes() ?>>
<?= $Page->federationRegister->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->memberLevelId->Visible) { // memberLevelId ?>
    <tr id="r_memberLevelId"<?= $Page->memberLevelId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_memberLevelId"><?= $Page->memberLevelId->caption() ?></span></td>
        <td data-name="memberLevelId"<?= $Page->memberLevelId->cellAttributes() ?>>
<span id="el_school_member_memberLevelId">
<span<?= $Page->memberLevelId->viewAttributes() ?>>
<?= $Page->memberLevelId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorLevelId->Visible) { // instructorLevelId ?>
    <tr id="r_instructorLevelId"<?= $Page->instructorLevelId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_instructorLevelId"><?= $Page->instructorLevelId->caption() ?></span></td>
        <td data-name="instructorLevelId"<?= $Page->instructorLevelId->cellAttributes() ?>>
<span id="el_school_member_instructorLevelId">
<span<?= $Page->instructorLevelId->viewAttributes() ?>>
<?= $Page->instructorLevelId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->judgeLevelId->Visible) { // judgeLevelId ?>
    <tr id="r_judgeLevelId"<?= $Page->judgeLevelId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_judgeLevelId"><?= $Page->judgeLevelId->caption() ?></span></td>
        <td data-name="judgeLevelId"<?= $Page->judgeLevelId->cellAttributes() ?>>
<span id="el_school_member_judgeLevelId">
<span<?= $Page->judgeLevelId->viewAttributes() ?>>
<?= $Page->judgeLevelId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationRegisterDate->Visible) { // federationRegisterDate ?>
    <tr id="r_federationRegisterDate"<?= $Page->federationRegisterDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_federationRegisterDate"><?= $Page->federationRegisterDate->caption() ?></span></td>
        <td data-name="federationRegisterDate"<?= $Page->federationRegisterDate->cellAttributes() ?>>
<span id="el_school_member_federationRegisterDate">
<span<?= $Page->federationRegisterDate->viewAttributes() ?>>
<?= $Page->federationRegisterDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationStatus->Visible) { // federationStatus ?>
    <tr id="r_federationStatus"<?= $Page->federationStatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_federationStatus"><?= $Page->federationStatus->caption() ?></span></td>
        <td data-name="federationStatus"<?= $Page->federationStatus->cellAttributes() ?>>
<span id="el_school_member_federationStatus">
<span<?= $Page->federationStatus->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_federationStatus_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->federationStatus->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->federationStatus->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_federationStatus_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_school_member_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <tr id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_createUserId"><?= $Page->createUserId->caption() ?></span></td>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_school_member_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
    <tr id="r_lastUpdate"<?= $Page->lastUpdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_lastUpdate"><?= $Page->lastUpdate->caption() ?></span></td>
        <td data-name="lastUpdate"<?= $Page->lastUpdate->cellAttributes() ?>>
<span id="el_school_member_lastUpdate">
<span<?= $Page->lastUpdate->viewAttributes() ?>>
<?= $Page->lastUpdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUserId->Visible) { // lastUserId ?>
    <tr id="r_lastUserId"<?= $Page->lastUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_lastUserId"><?= $Page->lastUserId->caption() ?></span></td>
        <td data-name="lastUserId"<?= $Page->lastUserId->cellAttributes() ?>>
<span id="el_school_member_lastUserId">
<span<?= $Page->lastUserId->viewAttributes() ?>>
<?= $Page->lastUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marketingSourceId->Visible) { // marketingSourceId ?>
    <tr id="r_marketingSourceId"<?= $Page->marketingSourceId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_marketingSourceId"><?= $Page->marketingSourceId->caption() ?></span></td>
        <td data-name="marketingSourceId"<?= $Page->marketingSourceId->cellAttributes() ?>>
<span id="el_school_member_marketingSourceId">
<span<?= $Page->marketingSourceId->viewAttributes() ?>>
<?= $Page->marketingSourceId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marketingSourceDetail->Visible) { // marketingSourceDetail ?>
    <tr id="r_marketingSourceDetail"<?= $Page->marketingSourceDetail->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_marketingSourceDetail"><?= $Page->marketingSourceDetail->caption() ?></span></td>
        <td data-name="marketingSourceDetail"<?= $Page->marketingSourceDetail->cellAttributes() ?>>
<span id="el_school_member_marketingSourceDetail">
<span<?= $Page->marketingSourceDetail->viewAttributes() ?>>
<?= $Page->marketingSourceDetail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->age->Visible) { // age ?>
    <tr id="r_age"<?= $Page->age->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_school_member_age"><?= $Page->age->caption() ?></span></td>
        <td data-name="age"<?= $Page->age->cellAttributes() ?>>
<span id="el_school_member_age">
<span<?= $Page->age->viewAttributes() ?>>
<?= $Page->age->getViewValue() ?></span>
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
