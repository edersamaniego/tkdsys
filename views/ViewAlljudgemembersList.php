<?php

namespace PHPMaker2022\school;

// Page object
$ViewAlljudgemembersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_alljudgemembers: currentTable } });
var currentForm, currentPageID;
var fview_alljudgememberslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fview_alljudgememberslist = new ew.Form("fview_alljudgememberslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fview_alljudgememberslist;
    fview_alljudgememberslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fview_alljudgememberslist");
});
var fview_alljudgememberssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fview_alljudgememberssrch = new ew.Form("fview_alljudgememberssrch", "list");
    currentSearchForm = fview_alljudgememberssrch;

    // Dynamic selection lists

    // Filters
    fview_alljudgememberssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_alljudgememberssrch");
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.ready("head", ew.PATH_BASE + "js/preview.min.js", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fview_alljudgememberssrch" id="fview_alljudgememberssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_alljudgememberssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_alljudgemembers">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_alljudgememberssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_alljudgememberssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_alljudgememberssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_alljudgememberssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_alljudgemembers">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="fview_alljudgememberslist" id="fview_alljudgememberslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_alljudgemembers">
<div id="gmp_view_alljudgemembers" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_alljudgememberslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_view_alljudgemembers_id" class="view_alljudgemembers_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_view_alljudgemembers_name" class="view_alljudgemembers_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <th data-name="lastName" class="<?= $Page->lastName->headerCellClass() ?>"><div id="elh_view_alljudgemembers_lastName" class="view_alljudgemembers_lastName"><?= $Page->renderFieldHeader($Page->lastName) ?></div></th>
<?php } ?>
<?php if ($Page->instructorStatus->Visible) { // instructorStatus ?>
        <th data-name="instructorStatus" class="<?= $Page->instructorStatus->headerCellClass() ?>"><div id="elh_view_alljudgemembers_instructorStatus" class="view_alljudgemembers_instructorStatus"><?= $Page->renderFieldHeader($Page->instructorStatus) ?></div></th>
<?php } ?>
<?php if ($Page->birthdate->Visible) { // birthdate ?>
        <th data-name="birthdate" class="<?= $Page->birthdate->headerCellClass() ?>"><div id="elh_view_alljudgemembers_birthdate" class="view_alljudgemembers_birthdate"><?= $Page->renderFieldHeader($Page->birthdate) ?></div></th>
<?php } ?>
<?php if ($Page->gender->Visible) { // gender ?>
        <th data-name="gender" class="<?= $Page->gender->headerCellClass() ?>"><div id="elh_view_alljudgemembers_gender" class="view_alljudgemembers_gender"><?= $Page->renderFieldHeader($Page->gender) ?></div></th>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <th data-name="address" class="<?= $Page->address->headerCellClass() ?>"><div id="elh_view_alljudgemembers_address" class="view_alljudgemembers_address"><?= $Page->renderFieldHeader($Page->address) ?></div></th>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
        <th data-name="neighborhood" class="<?= $Page->neighborhood->headerCellClass() ?>"><div id="elh_view_alljudgemembers_neighborhood" class="view_alljudgemembers_neighborhood"><?= $Page->renderFieldHeader($Page->neighborhood) ?></div></th>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <th data-name="countryId" class="<?= $Page->countryId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_countryId" class="view_alljudgemembers_countryId"><?= $Page->renderFieldHeader($Page->countryId) ?></div></th>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
        <th data-name="UFId" class="<?= $Page->UFId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_UFId" class="view_alljudgemembers_UFId"><?= $Page->renderFieldHeader($Page->UFId) ?></div></th>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <th data-name="cityId" class="<?= $Page->cityId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_cityId" class="view_alljudgemembers_cityId"><?= $Page->renderFieldHeader($Page->cityId) ?></div></th>
<?php } ?>
<?php if ($Page->zip->Visible) { // zip ?>
        <th data-name="zip" class="<?= $Page->zip->headerCellClass() ?>"><div id="elh_view_alljudgemembers_zip" class="view_alljudgemembers_zip"><?= $Page->renderFieldHeader($Page->zip) ?></div></th>
<?php } ?>
<?php if ($Page->celphone->Visible) { // celphone ?>
        <th data-name="celphone" class="<?= $Page->celphone->headerCellClass() ?>"><div id="elh_view_alljudgemembers_celphone" class="view_alljudgemembers_celphone"><?= $Page->renderFieldHeader($Page->celphone) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_view_alljudgemembers__email" class="view_alljudgemembers__email"><?= $Page->renderFieldHeader($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->facebook->Visible) { // facebook ?>
        <th data-name="facebook" class="<?= $Page->facebook->headerCellClass() ?>"><div id="elh_view_alljudgemembers_facebook" class="view_alljudgemembers_facebook"><?= $Page->renderFieldHeader($Page->facebook) ?></div></th>
<?php } ?>
<?php if ($Page->instagram->Visible) { // instagram ?>
        <th data-name="instagram" class="<?= $Page->instagram->headerCellClass() ?>"><div id="elh_view_alljudgemembers_instagram" class="view_alljudgemembers_instagram"><?= $Page->renderFieldHeader($Page->instagram) ?></div></th>
<?php } ?>
<?php if ($Page->father->Visible) { // father ?>
        <th data-name="father" class="<?= $Page->father->headerCellClass() ?>"><div id="elh_view_alljudgemembers_father" class="view_alljudgemembers_father"><?= $Page->renderFieldHeader($Page->father) ?></div></th>
<?php } ?>
<?php if ($Page->fatherCellphone->Visible) { // fatherCellphone ?>
        <th data-name="fatherCellphone" class="<?= $Page->fatherCellphone->headerCellClass() ?>"><div id="elh_view_alljudgemembers_fatherCellphone" class="view_alljudgemembers_fatherCellphone"><?= $Page->renderFieldHeader($Page->fatherCellphone) ?></div></th>
<?php } ?>
<?php if ($Page->receiveSmsFather->Visible) { // receiveSmsFather ?>
        <th data-name="receiveSmsFather" class="<?= $Page->receiveSmsFather->headerCellClass() ?>"><div id="elh_view_alljudgemembers_receiveSmsFather" class="view_alljudgemembers_receiveSmsFather"><?= $Page->renderFieldHeader($Page->receiveSmsFather) ?></div></th>
<?php } ?>
<?php if ($Page->fatherEmail->Visible) { // fatherEmail ?>
        <th data-name="fatherEmail" class="<?= $Page->fatherEmail->headerCellClass() ?>"><div id="elh_view_alljudgemembers_fatherEmail" class="view_alljudgemembers_fatherEmail"><?= $Page->renderFieldHeader($Page->fatherEmail) ?></div></th>
<?php } ?>
<?php if ($Page->receiveEmailFather->Visible) { // receiveEmailFather ?>
        <th data-name="receiveEmailFather" class="<?= $Page->receiveEmailFather->headerCellClass() ?>"><div id="elh_view_alljudgemembers_receiveEmailFather" class="view_alljudgemembers_receiveEmailFather"><?= $Page->renderFieldHeader($Page->receiveEmailFather) ?></div></th>
<?php } ?>
<?php if ($Page->fatherOccupation->Visible) { // fatherOccupation ?>
        <th data-name="fatherOccupation" class="<?= $Page->fatherOccupation->headerCellClass() ?>"><div id="elh_view_alljudgemembers_fatherOccupation" class="view_alljudgemembers_fatherOccupation"><?= $Page->renderFieldHeader($Page->fatherOccupation) ?></div></th>
<?php } ?>
<?php if ($Page->fatherBirthdate->Visible) { // fatherBirthdate ?>
        <th data-name="fatherBirthdate" class="<?= $Page->fatherBirthdate->headerCellClass() ?>"><div id="elh_view_alljudgemembers_fatherBirthdate" class="view_alljudgemembers_fatherBirthdate"><?= $Page->renderFieldHeader($Page->fatherBirthdate) ?></div></th>
<?php } ?>
<?php if ($Page->mother->Visible) { // mother ?>
        <th data-name="mother" class="<?= $Page->mother->headerCellClass() ?>"><div id="elh_view_alljudgemembers_mother" class="view_alljudgemembers_mother"><?= $Page->renderFieldHeader($Page->mother) ?></div></th>
<?php } ?>
<?php if ($Page->motherCellphone->Visible) { // motherCellphone ?>
        <th data-name="motherCellphone" class="<?= $Page->motherCellphone->headerCellClass() ?>"><div id="elh_view_alljudgemembers_motherCellphone" class="view_alljudgemembers_motherCellphone"><?= $Page->renderFieldHeader($Page->motherCellphone) ?></div></th>
<?php } ?>
<?php if ($Page->receiveSmsMother->Visible) { // receiveSmsMother ?>
        <th data-name="receiveSmsMother" class="<?= $Page->receiveSmsMother->headerCellClass() ?>"><div id="elh_view_alljudgemembers_receiveSmsMother" class="view_alljudgemembers_receiveSmsMother"><?= $Page->renderFieldHeader($Page->receiveSmsMother) ?></div></th>
<?php } ?>
<?php if ($Page->motherEmail->Visible) { // motherEmail ?>
        <th data-name="motherEmail" class="<?= $Page->motherEmail->headerCellClass() ?>"><div id="elh_view_alljudgemembers_motherEmail" class="view_alljudgemembers_motherEmail"><?= $Page->renderFieldHeader($Page->motherEmail) ?></div></th>
<?php } ?>
<?php if ($Page->receiveEmailMother->Visible) { // receiveEmailMother ?>
        <th data-name="receiveEmailMother" class="<?= $Page->receiveEmailMother->headerCellClass() ?>"><div id="elh_view_alljudgemembers_receiveEmailMother" class="view_alljudgemembers_receiveEmailMother"><?= $Page->renderFieldHeader($Page->receiveEmailMother) ?></div></th>
<?php } ?>
<?php if ($Page->motherOccupation->Visible) { // motherOccupation ?>
        <th data-name="motherOccupation" class="<?= $Page->motherOccupation->headerCellClass() ?>"><div id="elh_view_alljudgemembers_motherOccupation" class="view_alljudgemembers_motherOccupation"><?= $Page->renderFieldHeader($Page->motherOccupation) ?></div></th>
<?php } ?>
<?php if ($Page->motherBirthdate->Visible) { // motherBirthdate ?>
        <th data-name="motherBirthdate" class="<?= $Page->motherBirthdate->headerCellClass() ?>"><div id="elh_view_alljudgemembers_motherBirthdate" class="view_alljudgemembers_motherBirthdate"><?= $Page->renderFieldHeader($Page->motherBirthdate) ?></div></th>
<?php } ?>
<?php if ($Page->emergencyContact->Visible) { // emergencyContact ?>
        <th data-name="emergencyContact" class="<?= $Page->emergencyContact->headerCellClass() ?>"><div id="elh_view_alljudgemembers_emergencyContact" class="view_alljudgemembers_emergencyContact"><?= $Page->renderFieldHeader($Page->emergencyContact) ?></div></th>
<?php } ?>
<?php if ($Page->emergencyFone->Visible) { // emergencyFone ?>
        <th data-name="emergencyFone" class="<?= $Page->emergencyFone->headerCellClass() ?>"><div id="elh_view_alljudgemembers_emergencyFone" class="view_alljudgemembers_emergencyFone"><?= $Page->renderFieldHeader($Page->emergencyFone) ?></div></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th data-name="schoolId" class="<?= $Page->schoolId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_schoolId" class="view_alljudgemembers_schoolId"><?= $Page->renderFieldHeader($Page->schoolId) ?></div></th>
<?php } ?>
<?php if ($Page->memberStatusId->Visible) { // memberStatusId ?>
        <th data-name="memberStatusId" class="<?= $Page->memberStatusId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_memberStatusId" class="view_alljudgemembers_memberStatusId"><?= $Page->renderFieldHeader($Page->memberStatusId) ?></div></th>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <th data-name="photo" class="<?= $Page->photo->headerCellClass() ?>"><div id="elh_view_alljudgemembers_photo" class="view_alljudgemembers_photo"><?= $Page->renderFieldHeader($Page->photo) ?></div></th>
<?php } ?>
<?php if ($Page->beltSize->Visible) { // beltSize ?>
        <th data-name="beltSize" class="<?= $Page->beltSize->headerCellClass() ?>"><div id="elh_view_alljudgemembers_beltSize" class="view_alljudgemembers_beltSize"><?= $Page->renderFieldHeader($Page->beltSize) ?></div></th>
<?php } ?>
<?php if ($Page->dobokSize->Visible) { // dobokSize ?>
        <th data-name="dobokSize" class="<?= $Page->dobokSize->headerCellClass() ?>"><div id="elh_view_alljudgemembers_dobokSize" class="view_alljudgemembers_dobokSize"><?= $Page->renderFieldHeader($Page->dobokSize) ?></div></th>
<?php } ?>
<?php if ($Page->programId->Visible) { // programId ?>
        <th data-name="programId" class="<?= $Page->programId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_programId" class="view_alljudgemembers_programId"><?= $Page->renderFieldHeader($Page->programId) ?></div></th>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <th data-name="martialArtId" class="<?= $Page->martialArtId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_martialArtId" class="view_alljudgemembers_martialArtId"><?= $Page->renderFieldHeader($Page->martialArtId) ?></div></th>
<?php } ?>
<?php if ($Page->modalityId->Visible) { // modalityId ?>
        <th data-name="modalityId" class="<?= $Page->modalityId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_modalityId" class="view_alljudgemembers_modalityId"><?= $Page->renderFieldHeader($Page->modalityId) ?></div></th>
<?php } ?>
<?php if ($Page->classId->Visible) { // classId ?>
        <th data-name="classId" class="<?= $Page->classId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_classId" class="view_alljudgemembers_classId"><?= $Page->renderFieldHeader($Page->classId) ?></div></th>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
        <th data-name="federationRegister" class="<?= $Page->federationRegister->headerCellClass() ?>"><div id="elh_view_alljudgemembers_federationRegister" class="view_alljudgemembers_federationRegister"><?= $Page->renderFieldHeader($Page->federationRegister) ?></div></th>
<?php } ?>
<?php if ($Page->memberLevelId->Visible) { // memberLevelId ?>
        <th data-name="memberLevelId" class="<?= $Page->memberLevelId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_memberLevelId" class="view_alljudgemembers_memberLevelId"><?= $Page->renderFieldHeader($Page->memberLevelId) ?></div></th>
<?php } ?>
<?php if ($Page->instructorLevelId->Visible) { // instructorLevelId ?>
        <th data-name="instructorLevelId" class="<?= $Page->instructorLevelId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_instructorLevelId" class="view_alljudgemembers_instructorLevelId"><?= $Page->renderFieldHeader($Page->instructorLevelId) ?></div></th>
<?php } ?>
<?php if ($Page->judgeLevelId->Visible) { // judgeLevelId ?>
        <th data-name="judgeLevelId" class="<?= $Page->judgeLevelId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_judgeLevelId" class="view_alljudgemembers_judgeLevelId"><?= $Page->renderFieldHeader($Page->judgeLevelId) ?></div></th>
<?php } ?>
<?php if ($Page->federationRegisterDate->Visible) { // federationRegisterDate ?>
        <th data-name="federationRegisterDate" class="<?= $Page->federationRegisterDate->headerCellClass() ?>"><div id="elh_view_alljudgemembers_federationRegisterDate" class="view_alljudgemembers_federationRegisterDate"><?= $Page->renderFieldHeader($Page->federationRegisterDate) ?></div></th>
<?php } ?>
<?php if ($Page->federationStatus->Visible) { // federationStatus ?>
        <th data-name="federationStatus" class="<?= $Page->federationStatus->headerCellClass() ?>"><div id="elh_view_alljudgemembers_federationStatus" class="view_alljudgemembers_federationStatus"><?= $Page->renderFieldHeader($Page->federationStatus) ?></div></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th data-name="createDate" class="<?= $Page->createDate->headerCellClass() ?>"><div id="elh_view_alljudgemembers_createDate" class="view_alljudgemembers_createDate"><?= $Page->renderFieldHeader($Page->createDate) ?></div></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th data-name="createUserId" class="<?= $Page->createUserId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_createUserId" class="view_alljudgemembers_createUserId"><?= $Page->renderFieldHeader($Page->createUserId) ?></div></th>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
        <th data-name="lastUpdate" class="<?= $Page->lastUpdate->headerCellClass() ?>"><div id="elh_view_alljudgemembers_lastUpdate" class="view_alljudgemembers_lastUpdate"><?= $Page->renderFieldHeader($Page->lastUpdate) ?></div></th>
<?php } ?>
<?php if ($Page->lastUserId->Visible) { // lastUserId ?>
        <th data-name="lastUserId" class="<?= $Page->lastUserId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_lastUserId" class="view_alljudgemembers_lastUserId"><?= $Page->renderFieldHeader($Page->lastUserId) ?></div></th>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <th data-name="rankId" class="<?= $Page->rankId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_rankId" class="view_alljudgemembers_rankId"><?= $Page->renderFieldHeader($Page->rankId) ?></div></th>
<?php } ?>
<?php if ($Page->marketingSourceId->Visible) { // marketingSourceId ?>
        <th data-name="marketingSourceId" class="<?= $Page->marketingSourceId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_marketingSourceId" class="view_alljudgemembers_marketingSourceId"><?= $Page->renderFieldHeader($Page->marketingSourceId) ?></div></th>
<?php } ?>
<?php if ($Page->marketingSourceDetail->Visible) { // marketingSourceDetail ?>
        <th data-name="marketingSourceDetail" class="<?= $Page->marketingSourceDetail->headerCellClass() ?>"><div id="elh_view_alljudgemembers_marketingSourceDetail" class="view_alljudgemembers_marketingSourceDetail"><?= $Page->renderFieldHeader($Page->marketingSourceDetail) ?></div></th>
<?php } ?>
<?php if ($Page->memberTypeId->Visible) { // memberTypeId ?>
        <th data-name="memberTypeId" class="<?= $Page->memberTypeId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_memberTypeId" class="view_alljudgemembers_memberTypeId"><?= $Page->renderFieldHeader($Page->memberTypeId) ?></div></th>
<?php } ?>
<?php if ($Page->schoolUserId->Visible) { // schoolUserId ?>
        <th data-name="schoolUserId" class="<?= $Page->schoolUserId->headerCellClass() ?>"><div id="elh_view_alljudgemembers_schoolUserId" class="view_alljudgemembers_schoolUserId"><?= $Page->renderFieldHeader($Page->schoolUserId) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_view_alljudgemembers",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_id" class="el_view_alljudgemembers_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_name" class="el_view_alljudgemembers_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lastName->Visible) { // lastName ?>
        <td data-name="lastName"<?= $Page->lastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_lastName" class="el_view_alljudgemembers_lastName">
<span<?= $Page->lastName->viewAttributes() ?>>
<?= $Page->lastName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instructorStatus->Visible) { // instructorStatus ?>
        <td data-name="instructorStatus"<?= $Page->instructorStatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_instructorStatus" class="el_view_alljudgemembers_instructorStatus">
<span<?= $Page->instructorStatus->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_instructorStatus_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->instructorStatus->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->instructorStatus->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_instructorStatus_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->birthdate->Visible) { // birthdate ?>
        <td data-name="birthdate"<?= $Page->birthdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_birthdate" class="el_view_alljudgemembers_birthdate">
<span<?= $Page->birthdate->viewAttributes() ?>>
<?= $Page->birthdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gender->Visible) { // gender ?>
        <td data-name="gender"<?= $Page->gender->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_gender" class="el_view_alljudgemembers_gender">
<span<?= $Page->gender->viewAttributes() ?>>
<?= $Page->gender->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->address->Visible) { // address ?>
        <td data-name="address"<?= $Page->address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_address" class="el_view_alljudgemembers_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->neighborhood->Visible) { // neighborhood ?>
        <td data-name="neighborhood"<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_neighborhood" class="el_view_alljudgemembers_neighborhood">
<span<?= $Page->neighborhood->viewAttributes() ?>>
<?= $Page->neighborhood->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->countryId->Visible) { // countryId ?>
        <td data-name="countryId"<?= $Page->countryId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_countryId" class="el_view_alljudgemembers_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->UFId->Visible) { // UFId ?>
        <td data-name="UFId"<?= $Page->UFId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_UFId" class="el_view_alljudgemembers_UFId">
<span<?= $Page->UFId->viewAttributes() ?>>
<?= $Page->UFId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cityId->Visible) { // cityId ?>
        <td data-name="cityId"<?= $Page->cityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_cityId" class="el_view_alljudgemembers_cityId">
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->zip->Visible) { // zip ?>
        <td data-name="zip"<?= $Page->zip->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_zip" class="el_view_alljudgemembers_zip">
<span<?= $Page->zip->viewAttributes() ?>>
<?= $Page->zip->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->celphone->Visible) { // celphone ?>
        <td data-name="celphone"<?= $Page->celphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_celphone" class="el_view_alljudgemembers_celphone">
<span<?= $Page->celphone->viewAttributes() ?>>
<?= $Page->celphone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers__email" class="el_view_alljudgemembers__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->facebook->Visible) { // facebook ?>
        <td data-name="facebook"<?= $Page->facebook->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_facebook" class="el_view_alljudgemembers_facebook">
<span<?= $Page->facebook->viewAttributes() ?>>
<?= $Page->facebook->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instagram->Visible) { // instagram ?>
        <td data-name="instagram"<?= $Page->instagram->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_instagram" class="el_view_alljudgemembers_instagram">
<span<?= $Page->instagram->viewAttributes() ?>>
<?= $Page->instagram->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->father->Visible) { // father ?>
        <td data-name="father"<?= $Page->father->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_father" class="el_view_alljudgemembers_father">
<span<?= $Page->father->viewAttributes() ?>>
<?= $Page->father->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fatherCellphone->Visible) { // fatherCellphone ?>
        <td data-name="fatherCellphone"<?= $Page->fatherCellphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_fatherCellphone" class="el_view_alljudgemembers_fatherCellphone">
<span<?= $Page->fatherCellphone->viewAttributes() ?>>
<?= $Page->fatherCellphone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiveSmsFather->Visible) { // receiveSmsFather ?>
        <td data-name="receiveSmsFather"<?= $Page->receiveSmsFather->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_receiveSmsFather" class="el_view_alljudgemembers_receiveSmsFather">
<span<?= $Page->receiveSmsFather->viewAttributes() ?>>
<?= $Page->receiveSmsFather->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fatherEmail->Visible) { // fatherEmail ?>
        <td data-name="fatherEmail"<?= $Page->fatherEmail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_fatherEmail" class="el_view_alljudgemembers_fatherEmail">
<span<?= $Page->fatherEmail->viewAttributes() ?>>
<?= $Page->fatherEmail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiveEmailFather->Visible) { // receiveEmailFather ?>
        <td data-name="receiveEmailFather"<?= $Page->receiveEmailFather->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_receiveEmailFather" class="el_view_alljudgemembers_receiveEmailFather">
<span<?= $Page->receiveEmailFather->viewAttributes() ?>>
<?= $Page->receiveEmailFather->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fatherOccupation->Visible) { // fatherOccupation ?>
        <td data-name="fatherOccupation"<?= $Page->fatherOccupation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_fatherOccupation" class="el_view_alljudgemembers_fatherOccupation">
<span<?= $Page->fatherOccupation->viewAttributes() ?>>
<?= $Page->fatherOccupation->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fatherBirthdate->Visible) { // fatherBirthdate ?>
        <td data-name="fatherBirthdate"<?= $Page->fatherBirthdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_fatherBirthdate" class="el_view_alljudgemembers_fatherBirthdate">
<span<?= $Page->fatherBirthdate->viewAttributes() ?>>
<?= $Page->fatherBirthdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mother->Visible) { // mother ?>
        <td data-name="mother"<?= $Page->mother->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_mother" class="el_view_alljudgemembers_mother">
<span<?= $Page->mother->viewAttributes() ?>>
<?= $Page->mother->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->motherCellphone->Visible) { // motherCellphone ?>
        <td data-name="motherCellphone"<?= $Page->motherCellphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_motherCellphone" class="el_view_alljudgemembers_motherCellphone">
<span<?= $Page->motherCellphone->viewAttributes() ?>>
<?= $Page->motherCellphone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiveSmsMother->Visible) { // receiveSmsMother ?>
        <td data-name="receiveSmsMother"<?= $Page->receiveSmsMother->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_receiveSmsMother" class="el_view_alljudgemembers_receiveSmsMother">
<span<?= $Page->receiveSmsMother->viewAttributes() ?>>
<?= $Page->receiveSmsMother->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->motherEmail->Visible) { // motherEmail ?>
        <td data-name="motherEmail"<?= $Page->motherEmail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_motherEmail" class="el_view_alljudgemembers_motherEmail">
<span<?= $Page->motherEmail->viewAttributes() ?>>
<?= $Page->motherEmail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiveEmailMother->Visible) { // receiveEmailMother ?>
        <td data-name="receiveEmailMother"<?= $Page->receiveEmailMother->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_receiveEmailMother" class="el_view_alljudgemembers_receiveEmailMother">
<span<?= $Page->receiveEmailMother->viewAttributes() ?>>
<?= $Page->receiveEmailMother->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->motherOccupation->Visible) { // motherOccupation ?>
        <td data-name="motherOccupation"<?= $Page->motherOccupation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_motherOccupation" class="el_view_alljudgemembers_motherOccupation">
<span<?= $Page->motherOccupation->viewAttributes() ?>>
<?= $Page->motherOccupation->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->motherBirthdate->Visible) { // motherBirthdate ?>
        <td data-name="motherBirthdate"<?= $Page->motherBirthdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_motherBirthdate" class="el_view_alljudgemembers_motherBirthdate">
<span<?= $Page->motherBirthdate->viewAttributes() ?>>
<?= $Page->motherBirthdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->emergencyContact->Visible) { // emergencyContact ?>
        <td data-name="emergencyContact"<?= $Page->emergencyContact->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_emergencyContact" class="el_view_alljudgemembers_emergencyContact">
<span<?= $Page->emergencyContact->viewAttributes() ?>>
<?= $Page->emergencyContact->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->emergencyFone->Visible) { // emergencyFone ?>
        <td data-name="emergencyFone"<?= $Page->emergencyFone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_emergencyFone" class="el_view_alljudgemembers_emergencyFone">
<span<?= $Page->emergencyFone->viewAttributes() ?>>
<?= $Page->emergencyFone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_schoolId" class="el_view_alljudgemembers_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberStatusId->Visible) { // memberStatusId ?>
        <td data-name="memberStatusId"<?= $Page->memberStatusId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_memberStatusId" class="el_view_alljudgemembers_memberStatusId">
<span<?= $Page->memberStatusId->viewAttributes() ?>>
<?= $Page->memberStatusId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->photo->Visible) { // photo ?>
        <td data-name="photo"<?= $Page->photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_photo" class="el_view_alljudgemembers_photo">
<span<?= $Page->photo->viewAttributes() ?>>
<?= $Page->photo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->beltSize->Visible) { // beltSize ?>
        <td data-name="beltSize"<?= $Page->beltSize->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_beltSize" class="el_view_alljudgemembers_beltSize">
<span<?= $Page->beltSize->viewAttributes() ?>>
<?= $Page->beltSize->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dobokSize->Visible) { // dobokSize ?>
        <td data-name="dobokSize"<?= $Page->dobokSize->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_dobokSize" class="el_view_alljudgemembers_dobokSize">
<span<?= $Page->dobokSize->viewAttributes() ?>>
<?= $Page->dobokSize->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->programId->Visible) { // programId ?>
        <td data-name="programId"<?= $Page->programId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_programId" class="el_view_alljudgemembers_programId">
<span<?= $Page->programId->viewAttributes() ?>>
<?= $Page->programId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <td data-name="martialArtId"<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_martialArtId" class="el_view_alljudgemembers_martialArtId">
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modalityId->Visible) { // modalityId ?>
        <td data-name="modalityId"<?= $Page->modalityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_modalityId" class="el_view_alljudgemembers_modalityId">
<span<?= $Page->modalityId->viewAttributes() ?>>
<?= $Page->modalityId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->classId->Visible) { // classId ?>
        <td data-name="classId"<?= $Page->classId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_classId" class="el_view_alljudgemembers_classId">
<span<?= $Page->classId->viewAttributes() ?>>
<?= $Page->classId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->federationRegister->Visible) { // federationRegister ?>
        <td data-name="federationRegister"<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_federationRegister" class="el_view_alljudgemembers_federationRegister">
<span<?= $Page->federationRegister->viewAttributes() ?>>
<?= $Page->federationRegister->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberLevelId->Visible) { // memberLevelId ?>
        <td data-name="memberLevelId"<?= $Page->memberLevelId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_memberLevelId" class="el_view_alljudgemembers_memberLevelId">
<span<?= $Page->memberLevelId->viewAttributes() ?>>
<?= $Page->memberLevelId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instructorLevelId->Visible) { // instructorLevelId ?>
        <td data-name="instructorLevelId"<?= $Page->instructorLevelId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_instructorLevelId" class="el_view_alljudgemembers_instructorLevelId">
<span<?= $Page->instructorLevelId->viewAttributes() ?>>
<?= $Page->instructorLevelId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->judgeLevelId->Visible) { // judgeLevelId ?>
        <td data-name="judgeLevelId"<?= $Page->judgeLevelId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_judgeLevelId" class="el_view_alljudgemembers_judgeLevelId">
<span<?= $Page->judgeLevelId->viewAttributes() ?>>
<?= $Page->judgeLevelId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->federationRegisterDate->Visible) { // federationRegisterDate ?>
        <td data-name="federationRegisterDate"<?= $Page->federationRegisterDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_federationRegisterDate" class="el_view_alljudgemembers_federationRegisterDate">
<span<?= $Page->federationRegisterDate->viewAttributes() ?>>
<?= $Page->federationRegisterDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->federationStatus->Visible) { // federationStatus ?>
        <td data-name="federationStatus"<?= $Page->federationStatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_federationStatus" class="el_view_alljudgemembers_federationStatus">
<span<?= $Page->federationStatus->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_federationStatus_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->federationStatus->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->federationStatus->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_federationStatus_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createDate->Visible) { // createDate ?>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_createDate" class="el_view_alljudgemembers_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_createUserId" class="el_view_alljudgemembers_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
        <td data-name="lastUpdate"<?= $Page->lastUpdate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_lastUpdate" class="el_view_alljudgemembers_lastUpdate">
<span<?= $Page->lastUpdate->viewAttributes() ?>>
<?= $Page->lastUpdate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lastUserId->Visible) { // lastUserId ?>
        <td data-name="lastUserId"<?= $Page->lastUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_lastUserId" class="el_view_alljudgemembers_lastUserId">
<span<?= $Page->lastUserId->viewAttributes() ?>>
<?= $Page->lastUserId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rankId->Visible) { // rankId ?>
        <td data-name="rankId"<?= $Page->rankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_rankId" class="el_view_alljudgemembers_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->marketingSourceId->Visible) { // marketingSourceId ?>
        <td data-name="marketingSourceId"<?= $Page->marketingSourceId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_marketingSourceId" class="el_view_alljudgemembers_marketingSourceId">
<span<?= $Page->marketingSourceId->viewAttributes() ?>>
<?= $Page->marketingSourceId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->marketingSourceDetail->Visible) { // marketingSourceDetail ?>
        <td data-name="marketingSourceDetail"<?= $Page->marketingSourceDetail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_marketingSourceDetail" class="el_view_alljudgemembers_marketingSourceDetail">
<span<?= $Page->marketingSourceDetail->viewAttributes() ?>>
<?= $Page->marketingSourceDetail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberTypeId->Visible) { // memberTypeId ?>
        <td data-name="memberTypeId"<?= $Page->memberTypeId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_memberTypeId" class="el_view_alljudgemembers_memberTypeId">
<span<?= $Page->memberTypeId->viewAttributes() ?>>
<?= $Page->memberTypeId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schoolUserId->Visible) { // schoolUserId ?>
        <td data-name="schoolUserId"<?= $Page->schoolUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_alljudgemembers_schoolUserId" class="el_view_alljudgemembers_schoolUserId">
<span<?= $Page->schoolUserId->viewAttributes() ?>>
<?= $Page->schoolUserId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("view_alljudgemembers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
