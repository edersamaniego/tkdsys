<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SchoolMemberAdd extends SchoolMember
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'school_member';

    // Page object name
    public $PageObjName = "SchoolMemberAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (school_member)
        if (!isset($GLOBALS["school_member"]) || get_class($GLOBALS["school_member"]) == PROJECT_NAMESPACE . "school_member") {
            $GLOBALS["school_member"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'school_member');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("school_member");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "SchoolMemberView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
		        $this->photo->OldUploadPath = "files/fotos";
		        $this->photo->UploadPath = $this->photo->OldUploadPath;
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;
    public $MultiPages; // Multi pages object

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->name->setVisibility();
        $this->lastName->setVisibility();
        $this->birthdate->setVisibility();
        $this->gender->setVisibility();
        $this->address->setVisibility();
        $this->neighborhood->setVisibility();
        $this->countryId->setVisibility();
        $this->UFId->setVisibility();
        $this->cityId->setVisibility();
        $this->zip->setVisibility();
        $this->celphone->setVisibility();
        $this->_email->setVisibility();
        $this->facebook->setVisibility();
        $this->instagram->setVisibility();
        $this->father->setVisibility();
        $this->fatherCellphone->setVisibility();
        $this->receiveSmsFather->setVisibility();
        $this->fatherEmail->setVisibility();
        $this->receiveEmailFather->setVisibility();
        $this->fatherOccupation->setVisibility();
        $this->fatherBirthdate->setVisibility();
        $this->mother->setVisibility();
        $this->motherCellphone->setVisibility();
        $this->receiveSmsMother->setVisibility();
        $this->motherEmail->setVisibility();
        $this->receiveEmailMother->setVisibility();
        $this->motherOccupation->setVisibility();
        $this->motherBirthdate->setVisibility();
        $this->emergencyContact->setVisibility();
        $this->emergencyFone->setVisibility();
        $this->obs->setVisibility();
        $this->modalityId->setVisibility();
        $this->instructorStatus->setVisibility();
        $this->martialArtId->setVisibility();
        $this->rankId->setVisibility();
        $this->schoolId->setVisibility();
        $this->memberStatusId->setVisibility();
        $this->photo->setVisibility();
        $this->beltSize->setVisibility();
        $this->dobokSize->setVisibility();
        $this->programId->Visible = false;
        $this->classId->Visible = false;
        $this->federationRegister->Visible = false;
        $this->memberLevelId->setVisibility();
        $this->instructorLevelId->setVisibility();
        $this->judgeLevelId->setVisibility();
        $this->federationRegisterDate->setVisibility();
        $this->federationStatus->Visible = false;
        $this->createDate->setVisibility();
        $this->createUserId->setVisibility();
        $this->lastUpdate->setVisibility();
        $this->lastUserId->setVisibility();
        $this->marketingSourceId->setVisibility();
        $this->marketingSourceDetail->setVisibility();
        $this->memberTypeId->Visible = false;
        $this->schoolUserId->Visible = false;
        $this->age->Visible = false;
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up multi page object
        $this->setupMultiPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->gender);
        $this->setupLookupOptions($this->countryId);
        $this->setupLookupOptions($this->UFId);
        $this->setupLookupOptions($this->cityId);
        $this->setupLookupOptions($this->receiveSmsFather);
        $this->setupLookupOptions($this->receiveEmailFather);
        $this->setupLookupOptions($this->receiveSmsMother);
        $this->setupLookupOptions($this->receiveEmailMother);
        $this->setupLookupOptions($this->modalityId);
        $this->setupLookupOptions($this->instructorStatus);
        $this->setupLookupOptions($this->martialArtId);
        $this->setupLookupOptions($this->rankId);
        $this->setupLookupOptions($this->schoolId);
        $this->setupLookupOptions($this->memberStatusId);
        $this->setupLookupOptions($this->programId);
        $this->setupLookupOptions($this->classId);
        $this->setupLookupOptions($this->memberLevelId);
        $this->setupLookupOptions($this->instructorLevelId);
        $this->setupLookupOptions($this->judgeLevelId);
        $this->setupLookupOptions($this->federationStatus);
        $this->setupLookupOptions($this->marketingSourceId);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("SchoolMemberList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "SchoolMemberList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "SchoolMemberView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->photo->Upload->Index = $CurrentForm->Index;
        $this->photo->Upload->uploadFile();
        $this->photo->CurrentValue = $this->photo->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->instructorStatus->DefaultValue = 0;
        $this->instructorStatus->OldValue = $this->instructorStatus->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'lastName' first before field var 'x_lastName'
        $val = $CurrentForm->hasValue("lastName") ? $CurrentForm->getValue("lastName") : $CurrentForm->getValue("x_lastName");
        if (!$this->lastName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastName->Visible = false; // Disable update for API request
            } else {
                $this->lastName->setFormValue($val);
            }
        }

        // Check field name 'birthdate' first before field var 'x_birthdate'
        $val = $CurrentForm->hasValue("birthdate") ? $CurrentForm->getValue("birthdate") : $CurrentForm->getValue("x_birthdate");
        if (!$this->birthdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->birthdate->Visible = false; // Disable update for API request
            } else {
                $this->birthdate->setFormValue($val, true, $validate);
            }
            $this->birthdate->CurrentValue = UnFormatDateTime($this->birthdate->CurrentValue, $this->birthdate->formatPattern());
        }

        // Check field name 'gender' first before field var 'x_gender'
        $val = $CurrentForm->hasValue("gender") ? $CurrentForm->getValue("gender") : $CurrentForm->getValue("x_gender");
        if (!$this->gender->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gender->Visible = false; // Disable update for API request
            } else {
                $this->gender->setFormValue($val);
            }
        }

        // Check field name 'address' first before field var 'x_address'
        $val = $CurrentForm->hasValue("address") ? $CurrentForm->getValue("address") : $CurrentForm->getValue("x_address");
        if (!$this->address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address->Visible = false; // Disable update for API request
            } else {
                $this->address->setFormValue($val);
            }
        }

        // Check field name 'neighborhood' first before field var 'x_neighborhood'
        $val = $CurrentForm->hasValue("neighborhood") ? $CurrentForm->getValue("neighborhood") : $CurrentForm->getValue("x_neighborhood");
        if (!$this->neighborhood->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->neighborhood->Visible = false; // Disable update for API request
            } else {
                $this->neighborhood->setFormValue($val);
            }
        }

        // Check field name 'countryId' first before field var 'x_countryId'
        $val = $CurrentForm->hasValue("countryId") ? $CurrentForm->getValue("countryId") : $CurrentForm->getValue("x_countryId");
        if (!$this->countryId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->countryId->Visible = false; // Disable update for API request
            } else {
                $this->countryId->setFormValue($val);
            }
        }

        // Check field name 'UFId' first before field var 'x_UFId'
        $val = $CurrentForm->hasValue("UFId") ? $CurrentForm->getValue("UFId") : $CurrentForm->getValue("x_UFId");
        if (!$this->UFId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->UFId->Visible = false; // Disable update for API request
            } else {
                $this->UFId->setFormValue($val);
            }
        }

        // Check field name 'cityId' first before field var 'x_cityId'
        $val = $CurrentForm->hasValue("cityId") ? $CurrentForm->getValue("cityId") : $CurrentForm->getValue("x_cityId");
        if (!$this->cityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cityId->Visible = false; // Disable update for API request
            } else {
                $this->cityId->setFormValue($val);
            }
        }

        // Check field name 'zip' first before field var 'x_zip'
        $val = $CurrentForm->hasValue("zip") ? $CurrentForm->getValue("zip") : $CurrentForm->getValue("x_zip");
        if (!$this->zip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->zip->Visible = false; // Disable update for API request
            } else {
                $this->zip->setFormValue($val);
            }
        }

        // Check field name 'celphone' first before field var 'x_celphone'
        $val = $CurrentForm->hasValue("celphone") ? $CurrentForm->getValue("celphone") : $CurrentForm->getValue("x_celphone");
        if (!$this->celphone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->celphone->Visible = false; // Disable update for API request
            } else {
                $this->celphone->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'facebook' first before field var 'x_facebook'
        $val = $CurrentForm->hasValue("facebook") ? $CurrentForm->getValue("facebook") : $CurrentForm->getValue("x_facebook");
        if (!$this->facebook->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->facebook->Visible = false; // Disable update for API request
            } else {
                $this->facebook->setFormValue($val);
            }
        }

        // Check field name 'instagram' first before field var 'x_instagram'
        $val = $CurrentForm->hasValue("instagram") ? $CurrentForm->getValue("instagram") : $CurrentForm->getValue("x_instagram");
        if (!$this->instagram->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instagram->Visible = false; // Disable update for API request
            } else {
                $this->instagram->setFormValue($val);
            }
        }

        // Check field name 'father' first before field var 'x_father'
        $val = $CurrentForm->hasValue("father") ? $CurrentForm->getValue("father") : $CurrentForm->getValue("x_father");
        if (!$this->father->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->father->Visible = false; // Disable update for API request
            } else {
                $this->father->setFormValue($val);
            }
        }

        // Check field name 'fatherCellphone' first before field var 'x_fatherCellphone'
        $val = $CurrentForm->hasValue("fatherCellphone") ? $CurrentForm->getValue("fatherCellphone") : $CurrentForm->getValue("x_fatherCellphone");
        if (!$this->fatherCellphone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fatherCellphone->Visible = false; // Disable update for API request
            } else {
                $this->fatherCellphone->setFormValue($val);
            }
        }

        // Check field name 'receiveSmsFather' first before field var 'x_receiveSmsFather'
        $val = $CurrentForm->hasValue("receiveSmsFather") ? $CurrentForm->getValue("receiveSmsFather") : $CurrentForm->getValue("x_receiveSmsFather");
        if (!$this->receiveSmsFather->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receiveSmsFather->Visible = false; // Disable update for API request
            } else {
                $this->receiveSmsFather->setFormValue($val);
            }
        }

        // Check field name 'fatherEmail' first before field var 'x_fatherEmail'
        $val = $CurrentForm->hasValue("fatherEmail") ? $CurrentForm->getValue("fatherEmail") : $CurrentForm->getValue("x_fatherEmail");
        if (!$this->fatherEmail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fatherEmail->Visible = false; // Disable update for API request
            } else {
                $this->fatherEmail->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'receiveEmailFather' first before field var 'x_receiveEmailFather'
        $val = $CurrentForm->hasValue("receiveEmailFather") ? $CurrentForm->getValue("receiveEmailFather") : $CurrentForm->getValue("x_receiveEmailFather");
        if (!$this->receiveEmailFather->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receiveEmailFather->Visible = false; // Disable update for API request
            } else {
                $this->receiveEmailFather->setFormValue($val);
            }
        }

        // Check field name 'fatherOccupation' first before field var 'x_fatherOccupation'
        $val = $CurrentForm->hasValue("fatherOccupation") ? $CurrentForm->getValue("fatherOccupation") : $CurrentForm->getValue("x_fatherOccupation");
        if (!$this->fatherOccupation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fatherOccupation->Visible = false; // Disable update for API request
            } else {
                $this->fatherOccupation->setFormValue($val);
            }
        }

        // Check field name 'fatherBirthdate' first before field var 'x_fatherBirthdate'
        $val = $CurrentForm->hasValue("fatherBirthdate") ? $CurrentForm->getValue("fatherBirthdate") : $CurrentForm->getValue("x_fatherBirthdate");
        if (!$this->fatherBirthdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fatherBirthdate->Visible = false; // Disable update for API request
            } else {
                $this->fatherBirthdate->setFormValue($val, true, $validate);
            }
            $this->fatherBirthdate->CurrentValue = UnFormatDateTime($this->fatherBirthdate->CurrentValue, $this->fatherBirthdate->formatPattern());
        }

        // Check field name 'mother' first before field var 'x_mother'
        $val = $CurrentForm->hasValue("mother") ? $CurrentForm->getValue("mother") : $CurrentForm->getValue("x_mother");
        if (!$this->mother->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mother->Visible = false; // Disable update for API request
            } else {
                $this->mother->setFormValue($val);
            }
        }

        // Check field name 'motherCellphone' first before field var 'x_motherCellphone'
        $val = $CurrentForm->hasValue("motherCellphone") ? $CurrentForm->getValue("motherCellphone") : $CurrentForm->getValue("x_motherCellphone");
        if (!$this->motherCellphone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motherCellphone->Visible = false; // Disable update for API request
            } else {
                $this->motherCellphone->setFormValue($val);
            }
        }

        // Check field name 'receiveSmsMother' first before field var 'x_receiveSmsMother'
        $val = $CurrentForm->hasValue("receiveSmsMother") ? $CurrentForm->getValue("receiveSmsMother") : $CurrentForm->getValue("x_receiveSmsMother");
        if (!$this->receiveSmsMother->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receiveSmsMother->Visible = false; // Disable update for API request
            } else {
                $this->receiveSmsMother->setFormValue($val);
            }
        }

        // Check field name 'motherEmail' first before field var 'x_motherEmail'
        $val = $CurrentForm->hasValue("motherEmail") ? $CurrentForm->getValue("motherEmail") : $CurrentForm->getValue("x_motherEmail");
        if (!$this->motherEmail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motherEmail->Visible = false; // Disable update for API request
            } else {
                $this->motherEmail->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'receiveEmailMother' first before field var 'x_receiveEmailMother'
        $val = $CurrentForm->hasValue("receiveEmailMother") ? $CurrentForm->getValue("receiveEmailMother") : $CurrentForm->getValue("x_receiveEmailMother");
        if (!$this->receiveEmailMother->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receiveEmailMother->Visible = false; // Disable update for API request
            } else {
                $this->receiveEmailMother->setFormValue($val);
            }
        }

        // Check field name 'motherOccupation' first before field var 'x_motherOccupation'
        $val = $CurrentForm->hasValue("motherOccupation") ? $CurrentForm->getValue("motherOccupation") : $CurrentForm->getValue("x_motherOccupation");
        if (!$this->motherOccupation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motherOccupation->Visible = false; // Disable update for API request
            } else {
                $this->motherOccupation->setFormValue($val);
            }
        }

        // Check field name 'motherBirthdate' first before field var 'x_motherBirthdate'
        $val = $CurrentForm->hasValue("motherBirthdate") ? $CurrentForm->getValue("motherBirthdate") : $CurrentForm->getValue("x_motherBirthdate");
        if (!$this->motherBirthdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motherBirthdate->Visible = false; // Disable update for API request
            } else {
                $this->motherBirthdate->setFormValue($val, true, $validate);
            }
            $this->motherBirthdate->CurrentValue = UnFormatDateTime($this->motherBirthdate->CurrentValue, $this->motherBirthdate->formatPattern());
        }

        // Check field name 'emergencyContact' first before field var 'x_emergencyContact'
        $val = $CurrentForm->hasValue("emergencyContact") ? $CurrentForm->getValue("emergencyContact") : $CurrentForm->getValue("x_emergencyContact");
        if (!$this->emergencyContact->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->emergencyContact->Visible = false; // Disable update for API request
            } else {
                $this->emergencyContact->setFormValue($val);
            }
        }

        // Check field name 'emergencyFone' first before field var 'x_emergencyFone'
        $val = $CurrentForm->hasValue("emergencyFone") ? $CurrentForm->getValue("emergencyFone") : $CurrentForm->getValue("x_emergencyFone");
        if (!$this->emergencyFone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->emergencyFone->Visible = false; // Disable update for API request
            } else {
                $this->emergencyFone->setFormValue($val);
            }
        }

        // Check field name 'obs' first before field var 'x_obs'
        $val = $CurrentForm->hasValue("obs") ? $CurrentForm->getValue("obs") : $CurrentForm->getValue("x_obs");
        if (!$this->obs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->obs->Visible = false; // Disable update for API request
            } else {
                $this->obs->setFormValue($val);
            }
        }

        // Check field name 'modalityId' first before field var 'x_modalityId'
        $val = $CurrentForm->hasValue("modalityId") ? $CurrentForm->getValue("modalityId") : $CurrentForm->getValue("x_modalityId");
        if (!$this->modalityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modalityId->Visible = false; // Disable update for API request
            } else {
                $this->modalityId->setFormValue($val);
            }
        }

        // Check field name 'instructorStatus' first before field var 'x_instructorStatus'
        $val = $CurrentForm->hasValue("instructorStatus") ? $CurrentForm->getValue("instructorStatus") : $CurrentForm->getValue("x_instructorStatus");
        if (!$this->instructorStatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorStatus->Visible = false; // Disable update for API request
            } else {
                $this->instructorStatus->setFormValue($val);
            }
        }

        // Check field name 'martialArtId' first before field var 'x_martialArtId'
        $val = $CurrentForm->hasValue("martialArtId") ? $CurrentForm->getValue("martialArtId") : $CurrentForm->getValue("x_martialArtId");
        if (!$this->martialArtId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->martialArtId->Visible = false; // Disable update for API request
            } else {
                $this->martialArtId->setFormValue($val);
            }
        }

        // Check field name 'rankId' first before field var 'x_rankId'
        $val = $CurrentForm->hasValue("rankId") ? $CurrentForm->getValue("rankId") : $CurrentForm->getValue("x_rankId");
        if (!$this->rankId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rankId->Visible = false; // Disable update for API request
            } else {
                $this->rankId->setFormValue($val);
            }
        }

        // Check field name 'schoolId' first before field var 'x_schoolId'
        $val = $CurrentForm->hasValue("schoolId") ? $CurrentForm->getValue("schoolId") : $CurrentForm->getValue("x_schoolId");
        if (!$this->schoolId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->schoolId->Visible = false; // Disable update for API request
            } else {
                $this->schoolId->setFormValue($val);
            }
        }

        // Check field name 'memberStatusId' first before field var 'x_memberStatusId'
        $val = $CurrentForm->hasValue("memberStatusId") ? $CurrentForm->getValue("memberStatusId") : $CurrentForm->getValue("x_memberStatusId");
        if (!$this->memberStatusId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->memberStatusId->Visible = false; // Disable update for API request
            } else {
                $this->memberStatusId->setFormValue($val);
            }
        }

        // Check field name 'beltSize' first before field var 'x_beltSize'
        $val = $CurrentForm->hasValue("beltSize") ? $CurrentForm->getValue("beltSize") : $CurrentForm->getValue("x_beltSize");
        if (!$this->beltSize->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->beltSize->Visible = false; // Disable update for API request
            } else {
                $this->beltSize->setFormValue($val);
            }
        }

        // Check field name 'dobokSize' first before field var 'x_dobokSize'
        $val = $CurrentForm->hasValue("dobokSize") ? $CurrentForm->getValue("dobokSize") : $CurrentForm->getValue("x_dobokSize");
        if (!$this->dobokSize->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dobokSize->Visible = false; // Disable update for API request
            } else {
                $this->dobokSize->setFormValue($val);
            }
        }

        // Check field name 'memberLevelId' first before field var 'x_memberLevelId'
        $val = $CurrentForm->hasValue("memberLevelId") ? $CurrentForm->getValue("memberLevelId") : $CurrentForm->getValue("x_memberLevelId");
        if (!$this->memberLevelId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->memberLevelId->Visible = false; // Disable update for API request
            } else {
                $this->memberLevelId->setFormValue($val);
            }
        }

        // Check field name 'instructorLevelId' first before field var 'x_instructorLevelId'
        $val = $CurrentForm->hasValue("instructorLevelId") ? $CurrentForm->getValue("instructorLevelId") : $CurrentForm->getValue("x_instructorLevelId");
        if (!$this->instructorLevelId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->instructorLevelId->Visible = false; // Disable update for API request
            } else {
                $this->instructorLevelId->setFormValue($val);
            }
        }

        // Check field name 'judgeLevelId' first before field var 'x_judgeLevelId'
        $val = $CurrentForm->hasValue("judgeLevelId") ? $CurrentForm->getValue("judgeLevelId") : $CurrentForm->getValue("x_judgeLevelId");
        if (!$this->judgeLevelId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->judgeLevelId->Visible = false; // Disable update for API request
            } else {
                $this->judgeLevelId->setFormValue($val);
            }
        }

        // Check field name 'federationRegisterDate' first before field var 'x_federationRegisterDate'
        $val = $CurrentForm->hasValue("federationRegisterDate") ? $CurrentForm->getValue("federationRegisterDate") : $CurrentForm->getValue("x_federationRegisterDate");
        if (!$this->federationRegisterDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->federationRegisterDate->Visible = false; // Disable update for API request
            } else {
                $this->federationRegisterDate->setFormValue($val, true, $validate);
            }
            $this->federationRegisterDate->CurrentValue = UnFormatDateTime($this->federationRegisterDate->CurrentValue, $this->federationRegisterDate->formatPattern());
        }

        // Check field name 'createDate' first before field var 'x_createDate'
        $val = $CurrentForm->hasValue("createDate") ? $CurrentForm->getValue("createDate") : $CurrentForm->getValue("x_createDate");
        if (!$this->createDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createDate->Visible = false; // Disable update for API request
            } else {
                $this->createDate->setFormValue($val);
            }
            $this->createDate->CurrentValue = UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        }

        // Check field name 'createUserId' first before field var 'x_createUserId'
        $val = $CurrentForm->hasValue("createUserId") ? $CurrentForm->getValue("createUserId") : $CurrentForm->getValue("x_createUserId");
        if (!$this->createUserId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createUserId->Visible = false; // Disable update for API request
            } else {
                $this->createUserId->setFormValue($val);
            }
        }

        // Check field name 'lastUpdate' first before field var 'x_lastUpdate'
        $val = $CurrentForm->hasValue("lastUpdate") ? $CurrentForm->getValue("lastUpdate") : $CurrentForm->getValue("x_lastUpdate");
        if (!$this->lastUpdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastUpdate->Visible = false; // Disable update for API request
            } else {
                $this->lastUpdate->setFormValue($val);
            }
            $this->lastUpdate->CurrentValue = UnFormatDateTime($this->lastUpdate->CurrentValue, $this->lastUpdate->formatPattern());
        }

        // Check field name 'lastUserId' first before field var 'x_lastUserId'
        $val = $CurrentForm->hasValue("lastUserId") ? $CurrentForm->getValue("lastUserId") : $CurrentForm->getValue("x_lastUserId");
        if (!$this->lastUserId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastUserId->Visible = false; // Disable update for API request
            } else {
                $this->lastUserId->setFormValue($val);
            }
        }

        // Check field name 'marketingSourceId' first before field var 'x_marketingSourceId'
        $val = $CurrentForm->hasValue("marketingSourceId") ? $CurrentForm->getValue("marketingSourceId") : $CurrentForm->getValue("x_marketingSourceId");
        if (!$this->marketingSourceId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->marketingSourceId->Visible = false; // Disable update for API request
            } else {
                $this->marketingSourceId->setFormValue($val);
            }
        }

        // Check field name 'marketingSourceDetail' first before field var 'x_marketingSourceDetail'
        $val = $CurrentForm->hasValue("marketingSourceDetail") ? $CurrentForm->getValue("marketingSourceDetail") : $CurrentForm->getValue("x_marketingSourceDetail");
        if (!$this->marketingSourceDetail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->marketingSourceDetail->Visible = false; // Disable update for API request
            } else {
                $this->marketingSourceDetail->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
		$this->photo->OldUploadPath = "files/fotos";
		$this->photo->UploadPath = $this->photo->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->lastName->CurrentValue = $this->lastName->FormValue;
        $this->birthdate->CurrentValue = $this->birthdate->FormValue;
        $this->birthdate->CurrentValue = UnFormatDateTime($this->birthdate->CurrentValue, $this->birthdate->formatPattern());
        $this->gender->CurrentValue = $this->gender->FormValue;
        $this->address->CurrentValue = $this->address->FormValue;
        $this->neighborhood->CurrentValue = $this->neighborhood->FormValue;
        $this->countryId->CurrentValue = $this->countryId->FormValue;
        $this->UFId->CurrentValue = $this->UFId->FormValue;
        $this->cityId->CurrentValue = $this->cityId->FormValue;
        $this->zip->CurrentValue = $this->zip->FormValue;
        $this->celphone->CurrentValue = $this->celphone->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->facebook->CurrentValue = $this->facebook->FormValue;
        $this->instagram->CurrentValue = $this->instagram->FormValue;
        $this->father->CurrentValue = $this->father->FormValue;
        $this->fatherCellphone->CurrentValue = $this->fatherCellphone->FormValue;
        $this->receiveSmsFather->CurrentValue = $this->receiveSmsFather->FormValue;
        $this->fatherEmail->CurrentValue = $this->fatherEmail->FormValue;
        $this->receiveEmailFather->CurrentValue = $this->receiveEmailFather->FormValue;
        $this->fatherOccupation->CurrentValue = $this->fatherOccupation->FormValue;
        $this->fatherBirthdate->CurrentValue = $this->fatherBirthdate->FormValue;
        $this->fatherBirthdate->CurrentValue = UnFormatDateTime($this->fatherBirthdate->CurrentValue, $this->fatherBirthdate->formatPattern());
        $this->mother->CurrentValue = $this->mother->FormValue;
        $this->motherCellphone->CurrentValue = $this->motherCellphone->FormValue;
        $this->receiveSmsMother->CurrentValue = $this->receiveSmsMother->FormValue;
        $this->motherEmail->CurrentValue = $this->motherEmail->FormValue;
        $this->receiveEmailMother->CurrentValue = $this->receiveEmailMother->FormValue;
        $this->motherOccupation->CurrentValue = $this->motherOccupation->FormValue;
        $this->motherBirthdate->CurrentValue = $this->motherBirthdate->FormValue;
        $this->motherBirthdate->CurrentValue = UnFormatDateTime($this->motherBirthdate->CurrentValue, $this->motherBirthdate->formatPattern());
        $this->emergencyContact->CurrentValue = $this->emergencyContact->FormValue;
        $this->emergencyFone->CurrentValue = $this->emergencyFone->FormValue;
        $this->obs->CurrentValue = $this->obs->FormValue;
        $this->modalityId->CurrentValue = $this->modalityId->FormValue;
        $this->instructorStatus->CurrentValue = $this->instructorStatus->FormValue;
        $this->martialArtId->CurrentValue = $this->martialArtId->FormValue;
        $this->rankId->CurrentValue = $this->rankId->FormValue;
        $this->schoolId->CurrentValue = $this->schoolId->FormValue;
        $this->memberStatusId->CurrentValue = $this->memberStatusId->FormValue;
        $this->beltSize->CurrentValue = $this->beltSize->FormValue;
        $this->dobokSize->CurrentValue = $this->dobokSize->FormValue;
        $this->memberLevelId->CurrentValue = $this->memberLevelId->FormValue;
        $this->instructorLevelId->CurrentValue = $this->instructorLevelId->FormValue;
        $this->judgeLevelId->CurrentValue = $this->judgeLevelId->FormValue;
        $this->federationRegisterDate->CurrentValue = $this->federationRegisterDate->FormValue;
        $this->federationRegisterDate->CurrentValue = UnFormatDateTime($this->federationRegisterDate->CurrentValue, $this->federationRegisterDate->formatPattern());
        $this->createDate->CurrentValue = $this->createDate->FormValue;
        $this->createDate->CurrentValue = UnFormatDateTime($this->createDate->CurrentValue, $this->createDate->formatPattern());
        $this->createUserId->CurrentValue = $this->createUserId->FormValue;
        $this->lastUpdate->CurrentValue = $this->lastUpdate->FormValue;
        $this->lastUpdate->CurrentValue = UnFormatDateTime($this->lastUpdate->CurrentValue, $this->lastUpdate->formatPattern());
        $this->lastUserId->CurrentValue = $this->lastUserId->FormValue;
        $this->marketingSourceId->CurrentValue = $this->marketingSourceId->FormValue;
        $this->marketingSourceDetail->CurrentValue = $this->marketingSourceDetail->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
        $this->id->setDbValue($row['id']);
        $this->name->setDbValue($row['name']);
        $this->lastName->setDbValue($row['lastName']);
        $this->birthdate->setDbValue($row['birthdate']);
        $this->gender->setDbValue($row['gender']);
        $this->address->setDbValue($row['address']);
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->countryId->setDbValue($row['countryId']);
        if (array_key_exists('EV__countryId', $row)) {
            $this->countryId->VirtualValue = $row['EV__countryId']; // Set up virtual field value
        } else {
            $this->countryId->VirtualValue = ""; // Clear value
        }
        $this->UFId->setDbValue($row['UFId']);
        if (array_key_exists('EV__UFId', $row)) {
            $this->UFId->VirtualValue = $row['EV__UFId']; // Set up virtual field value
        } else {
            $this->UFId->VirtualValue = ""; // Clear value
        }
        $this->cityId->setDbValue($row['cityId']);
        if (array_key_exists('EV__cityId', $row)) {
            $this->cityId->VirtualValue = $row['EV__cityId']; // Set up virtual field value
        } else {
            $this->cityId->VirtualValue = ""; // Clear value
        }
        $this->zip->setDbValue($row['zip']);
        $this->celphone->setDbValue($row['celphone']);
        $this->_email->setDbValue($row['email']);
        $this->facebook->setDbValue($row['facebook']);
        $this->instagram->setDbValue($row['instagram']);
        $this->father->setDbValue($row['father']);
        $this->fatherCellphone->setDbValue($row['fatherCellphone']);
        $this->receiveSmsFather->setDbValue($row['receiveSmsFather']);
        $this->fatherEmail->setDbValue($row['fatherEmail']);
        $this->receiveEmailFather->setDbValue($row['receiveEmailFather']);
        $this->fatherOccupation->setDbValue($row['fatherOccupation']);
        $this->fatherBirthdate->setDbValue($row['fatherBirthdate']);
        $this->mother->setDbValue($row['mother']);
        $this->motherCellphone->setDbValue($row['motherCellphone']);
        $this->receiveSmsMother->setDbValue($row['receiveSmsMother']);
        $this->motherEmail->setDbValue($row['motherEmail']);
        $this->receiveEmailMother->setDbValue($row['receiveEmailMother']);
        $this->motherOccupation->setDbValue($row['motherOccupation']);
        $this->motherBirthdate->setDbValue($row['motherBirthdate']);
        $this->emergencyContact->setDbValue($row['emergencyContact']);
        $this->emergencyFone->setDbValue($row['emergencyFone']);
        $this->obs->setDbValue($row['obs']);
        $this->modalityId->setDbValue($row['modalityId']);
        if (array_key_exists('EV__modalityId', $row)) {
            $this->modalityId->VirtualValue = $row['EV__modalityId']; // Set up virtual field value
        } else {
            $this->modalityId->VirtualValue = ""; // Clear value
        }
        $this->instructorStatus->setDbValue($row['instructorStatus']);
        $this->martialArtId->setDbValue($row['martialArtId']);
        $this->rankId->setDbValue($row['rankId']);
        $this->schoolId->setDbValue($row['schoolId']);
        if (array_key_exists('EV__schoolId', $row)) {
            $this->schoolId->VirtualValue = $row['EV__schoolId']; // Set up virtual field value
        } else {
            $this->schoolId->VirtualValue = ""; // Clear value
        }
        $this->memberStatusId->setDbValue($row['memberStatusId']);
        $this->photo->Upload->DbValue = $row['photo'];
        $this->photo->setDbValue($this->photo->Upload->DbValue);
        $this->beltSize->setDbValue($row['beltSize']);
        $this->dobokSize->setDbValue($row['dobokSize']);
        $this->programId->setDbValue($row['programId']);
        $this->classId->setDbValue($row['classId']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->memberLevelId->setDbValue($row['memberLevelId']);
        $this->instructorLevelId->setDbValue($row['instructorLevelId']);
        $this->judgeLevelId->setDbValue($row['judgeLevelId']);
        $this->federationRegisterDate->setDbValue($row['federationRegisterDate']);
        $this->federationStatus->setDbValue($row['federationStatus']);
        $this->createDate->setDbValue($row['createDate']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->lastUpdate->setDbValue($row['lastUpdate']);
        $this->lastUserId->setDbValue($row['lastUserId']);
        $this->marketingSourceId->setDbValue($row['marketingSourceId']);
        $this->marketingSourceDetail->setDbValue($row['marketingSourceDetail']);
        $this->memberTypeId->setDbValue($row['memberTypeId']);
        $this->schoolUserId->setDbValue($row['schoolUserId']);
        $this->age->setDbValue($row['age']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['lastName'] = $this->lastName->DefaultValue;
        $row['birthdate'] = $this->birthdate->DefaultValue;
        $row['gender'] = $this->gender->DefaultValue;
        $row['address'] = $this->address->DefaultValue;
        $row['neighborhood'] = $this->neighborhood->DefaultValue;
        $row['countryId'] = $this->countryId->DefaultValue;
        $row['UFId'] = $this->UFId->DefaultValue;
        $row['cityId'] = $this->cityId->DefaultValue;
        $row['zip'] = $this->zip->DefaultValue;
        $row['celphone'] = $this->celphone->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['facebook'] = $this->facebook->DefaultValue;
        $row['instagram'] = $this->instagram->DefaultValue;
        $row['father'] = $this->father->DefaultValue;
        $row['fatherCellphone'] = $this->fatherCellphone->DefaultValue;
        $row['receiveSmsFather'] = $this->receiveSmsFather->DefaultValue;
        $row['fatherEmail'] = $this->fatherEmail->DefaultValue;
        $row['receiveEmailFather'] = $this->receiveEmailFather->DefaultValue;
        $row['fatherOccupation'] = $this->fatherOccupation->DefaultValue;
        $row['fatherBirthdate'] = $this->fatherBirthdate->DefaultValue;
        $row['mother'] = $this->mother->DefaultValue;
        $row['motherCellphone'] = $this->motherCellphone->DefaultValue;
        $row['receiveSmsMother'] = $this->receiveSmsMother->DefaultValue;
        $row['motherEmail'] = $this->motherEmail->DefaultValue;
        $row['receiveEmailMother'] = $this->receiveEmailMother->DefaultValue;
        $row['motherOccupation'] = $this->motherOccupation->DefaultValue;
        $row['motherBirthdate'] = $this->motherBirthdate->DefaultValue;
        $row['emergencyContact'] = $this->emergencyContact->DefaultValue;
        $row['emergencyFone'] = $this->emergencyFone->DefaultValue;
        $row['obs'] = $this->obs->DefaultValue;
        $row['modalityId'] = $this->modalityId->DefaultValue;
        $row['instructorStatus'] = $this->instructorStatus->DefaultValue;
        $row['martialArtId'] = $this->martialArtId->DefaultValue;
        $row['rankId'] = $this->rankId->DefaultValue;
        $row['schoolId'] = $this->schoolId->DefaultValue;
        $row['memberStatusId'] = $this->memberStatusId->DefaultValue;
        $row['photo'] = $this->photo->DefaultValue;
        $row['beltSize'] = $this->beltSize->DefaultValue;
        $row['dobokSize'] = $this->dobokSize->DefaultValue;
        $row['programId'] = $this->programId->DefaultValue;
        $row['classId'] = $this->classId->DefaultValue;
        $row['federationRegister'] = $this->federationRegister->DefaultValue;
        $row['memberLevelId'] = $this->memberLevelId->DefaultValue;
        $row['instructorLevelId'] = $this->instructorLevelId->DefaultValue;
        $row['judgeLevelId'] = $this->judgeLevelId->DefaultValue;
        $row['federationRegisterDate'] = $this->federationRegisterDate->DefaultValue;
        $row['federationStatus'] = $this->federationStatus->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['lastUpdate'] = $this->lastUpdate->DefaultValue;
        $row['lastUserId'] = $this->lastUserId->DefaultValue;
        $row['marketingSourceId'] = $this->marketingSourceId->DefaultValue;
        $row['marketingSourceDetail'] = $this->marketingSourceDetail->DefaultValue;
        $row['memberTypeId'] = $this->memberTypeId->DefaultValue;
        $row['schoolUserId'] = $this->schoolUserId->DefaultValue;
        $row['age'] = $this->age->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // name
        $this->name->RowCssClass = "row";

        // lastName
        $this->lastName->RowCssClass = "row";

        // birthdate
        $this->birthdate->RowCssClass = "row";

        // gender
        $this->gender->RowCssClass = "row";

        // address
        $this->address->RowCssClass = "row";

        // neighborhood
        $this->neighborhood->RowCssClass = "row";

        // countryId
        $this->countryId->RowCssClass = "row";

        // UFId
        $this->UFId->RowCssClass = "row";

        // cityId
        $this->cityId->RowCssClass = "row";

        // zip
        $this->zip->RowCssClass = "row";

        // celphone
        $this->celphone->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // facebook
        $this->facebook->RowCssClass = "row";

        // instagram
        $this->instagram->RowCssClass = "row";

        // father
        $this->father->RowCssClass = "row";

        // fatherCellphone
        $this->fatherCellphone->RowCssClass = "row";

        // receiveSmsFather
        $this->receiveSmsFather->RowCssClass = "row";

        // fatherEmail
        $this->fatherEmail->RowCssClass = "row";

        // receiveEmailFather
        $this->receiveEmailFather->RowCssClass = "row";

        // fatherOccupation
        $this->fatherOccupation->RowCssClass = "row";

        // fatherBirthdate
        $this->fatherBirthdate->RowCssClass = "row";

        // mother
        $this->mother->RowCssClass = "row";

        // motherCellphone
        $this->motherCellphone->RowCssClass = "row";

        // receiveSmsMother
        $this->receiveSmsMother->RowCssClass = "row";

        // motherEmail
        $this->motherEmail->RowCssClass = "row";

        // receiveEmailMother
        $this->receiveEmailMother->RowCssClass = "row";

        // motherOccupation
        $this->motherOccupation->RowCssClass = "row";

        // motherBirthdate
        $this->motherBirthdate->RowCssClass = "row";

        // emergencyContact
        $this->emergencyContact->RowCssClass = "row";

        // emergencyFone
        $this->emergencyFone->RowCssClass = "row";

        // obs
        $this->obs->RowCssClass = "row";

        // modalityId
        $this->modalityId->RowCssClass = "row";

        // instructorStatus
        $this->instructorStatus->RowCssClass = "row";

        // martialArtId
        $this->martialArtId->RowCssClass = "row";

        // rankId
        $this->rankId->RowCssClass = "row";

        // schoolId
        $this->schoolId->RowCssClass = "row";

        // memberStatusId
        $this->memberStatusId->RowCssClass = "row";

        // photo
        $this->photo->RowCssClass = "row";

        // beltSize
        $this->beltSize->RowCssClass = "row";

        // dobokSize
        $this->dobokSize->RowCssClass = "row";

        // programId
        $this->programId->RowCssClass = "row";

        // classId
        $this->classId->RowCssClass = "row";

        // federationRegister
        $this->federationRegister->RowCssClass = "row";

        // memberLevelId
        $this->memberLevelId->RowCssClass = "row";

        // instructorLevelId
        $this->instructorLevelId->RowCssClass = "row";

        // judgeLevelId
        $this->judgeLevelId->RowCssClass = "row";

        // federationRegisterDate
        $this->federationRegisterDate->RowCssClass = "row";

        // federationStatus
        $this->federationStatus->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // lastUpdate
        $this->lastUpdate->RowCssClass = "row";

        // lastUserId
        $this->lastUserId->RowCssClass = "row";

        // marketingSourceId
        $this->marketingSourceId->RowCssClass = "row";

        // marketingSourceDetail
        $this->marketingSourceDetail->RowCssClass = "row";

        // memberTypeId
        $this->memberTypeId->RowCssClass = "row";

        // schoolUserId
        $this->schoolUserId->RowCssClass = "row";

        // age
        $this->age->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->ViewCustomAttributes = "";

            // lastName
            $this->lastName->ViewValue = $this->lastName->CurrentValue;
            $this->lastName->ViewCustomAttributes = "";

            // birthdate
            $this->birthdate->ViewValue = $this->birthdate->CurrentValue;
            $this->birthdate->ViewValue = FormatDateTime($this->birthdate->ViewValue, $this->birthdate->formatPattern());
            $this->birthdate->ViewCustomAttributes = "";

            // gender
            if (strval($this->gender->CurrentValue) != "") {
                $this->gender->ViewValue = $this->gender->optionCaption($this->gender->CurrentValue);
            } else {
                $this->gender->ViewValue = null;
            }
            $this->gender->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // neighborhood
            $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
            $this->neighborhood->ViewCustomAttributes = "";

            // countryId
            if ($this->countryId->VirtualValue != "") {
                $this->countryId->ViewValue = $this->countryId->VirtualValue;
            } else {
                $curVal = strval($this->countryId->CurrentValue);
                if ($curVal != "") {
                    $this->countryId->ViewValue = $this->countryId->lookupCacheOption($curVal);
                    if ($this->countryId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->countryId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->countryId->Lookup->renderViewRow($rswrk[0]);
                            $this->countryId->ViewValue = $this->countryId->displayValue($arwrk);
                        } else {
                            $this->countryId->ViewValue = FormatNumber($this->countryId->CurrentValue, $this->countryId->formatPattern());
                        }
                    }
                } else {
                    $this->countryId->ViewValue = null;
                }
            }
            $this->countryId->ViewCustomAttributes = "";

            // UFId
            if ($this->UFId->VirtualValue != "") {
                $this->UFId->ViewValue = $this->UFId->VirtualValue;
            } else {
                $curVal = strval($this->UFId->CurrentValue);
                if ($curVal != "") {
                    $this->UFId->ViewValue = $this->UFId->lookupCacheOption($curVal);
                    if ($this->UFId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->UFId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->UFId->Lookup->renderViewRow($rswrk[0]);
                            $this->UFId->ViewValue = $this->UFId->displayValue($arwrk);
                        } else {
                            $this->UFId->ViewValue = FormatNumber($this->UFId->CurrentValue, $this->UFId->formatPattern());
                        }
                    }
                } else {
                    $this->UFId->ViewValue = null;
                }
            }
            $this->UFId->ViewCustomAttributes = "";

            // cityId
            if ($this->cityId->VirtualValue != "") {
                $this->cityId->ViewValue = $this->cityId->VirtualValue;
            } else {
                $curVal = strval($this->cityId->CurrentValue);
                if ($curVal != "") {
                    $this->cityId->ViewValue = $this->cityId->lookupCacheOption($curVal);
                    if ($this->cityId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->cityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->cityId->Lookup->renderViewRow($rswrk[0]);
                            $this->cityId->ViewValue = $this->cityId->displayValue($arwrk);
                        } else {
                            $this->cityId->ViewValue = FormatNumber($this->cityId->CurrentValue, $this->cityId->formatPattern());
                        }
                    }
                } else {
                    $this->cityId->ViewValue = null;
                }
            }
            $this->cityId->ViewCustomAttributes = "";

            // zip
            $this->zip->ViewValue = $this->zip->CurrentValue;
            $this->zip->ViewCustomAttributes = "";

            // celphone
            $this->celphone->ViewValue = $this->celphone->CurrentValue;
            $this->celphone->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // facebook
            $this->facebook->ViewValue = $this->facebook->CurrentValue;
            $this->facebook->ViewCustomAttributes = "";

            // instagram
            $this->instagram->ViewValue = $this->instagram->CurrentValue;
            $this->instagram->ViewCustomAttributes = "";

            // father
            $this->father->ViewValue = $this->father->CurrentValue;
            $this->father->ViewCustomAttributes = "";

            // fatherCellphone
            $this->fatherCellphone->ViewValue = $this->fatherCellphone->CurrentValue;
            $this->fatherCellphone->ViewCustomAttributes = "";

            // receiveSmsFather
            if (strval($this->receiveSmsFather->CurrentValue) != "") {
                $this->receiveSmsFather->ViewValue = $this->receiveSmsFather->optionCaption($this->receiveSmsFather->CurrentValue);
            } else {
                $this->receiveSmsFather->ViewValue = null;
            }
            $this->receiveSmsFather->ViewCustomAttributes = "";

            // fatherEmail
            $this->fatherEmail->ViewValue = $this->fatherEmail->CurrentValue;
            $this->fatherEmail->ViewCustomAttributes = "";

            // receiveEmailFather
            if (strval($this->receiveEmailFather->CurrentValue) != "") {
                $this->receiveEmailFather->ViewValue = $this->receiveEmailFather->optionCaption($this->receiveEmailFather->CurrentValue);
            } else {
                $this->receiveEmailFather->ViewValue = null;
            }
            $this->receiveEmailFather->ViewCustomAttributes = "";

            // fatherOccupation
            $this->fatherOccupation->ViewValue = $this->fatherOccupation->CurrentValue;
            $this->fatherOccupation->ViewCustomAttributes = "";

            // fatherBirthdate
            $this->fatherBirthdate->ViewValue = $this->fatherBirthdate->CurrentValue;
            $this->fatherBirthdate->ViewValue = FormatDateTime($this->fatherBirthdate->ViewValue, $this->fatherBirthdate->formatPattern());
            $this->fatherBirthdate->ViewCustomAttributes = "";

            // mother
            $this->mother->ViewValue = $this->mother->CurrentValue;
            $this->mother->ViewCustomAttributes = "";

            // motherCellphone
            $this->motherCellphone->ViewValue = $this->motherCellphone->CurrentValue;
            $this->motherCellphone->ViewCustomAttributes = "";

            // receiveSmsMother
            if (strval($this->receiveSmsMother->CurrentValue) != "") {
                $this->receiveSmsMother->ViewValue = $this->receiveSmsMother->optionCaption($this->receiveSmsMother->CurrentValue);
            } else {
                $this->receiveSmsMother->ViewValue = null;
            }
            $this->receiveSmsMother->ViewCustomAttributes = "";

            // motherEmail
            $this->motherEmail->ViewValue = $this->motherEmail->CurrentValue;
            $this->motherEmail->ViewCustomAttributes = "";

            // receiveEmailMother
            if (strval($this->receiveEmailMother->CurrentValue) != "") {
                $this->receiveEmailMother->ViewValue = $this->receiveEmailMother->optionCaption($this->receiveEmailMother->CurrentValue);
            } else {
                $this->receiveEmailMother->ViewValue = null;
            }
            $this->receiveEmailMother->ViewCustomAttributes = "";

            // motherOccupation
            $this->motherOccupation->ViewValue = $this->motherOccupation->CurrentValue;
            $this->motherOccupation->ViewCustomAttributes = "";

            // motherBirthdate
            $this->motherBirthdate->ViewValue = $this->motherBirthdate->CurrentValue;
            $this->motherBirthdate->ViewValue = FormatDateTime($this->motherBirthdate->ViewValue, $this->motherBirthdate->formatPattern());
            $this->motherBirthdate->ViewCustomAttributes = "";

            // emergencyContact
            $this->emergencyContact->ViewValue = $this->emergencyContact->CurrentValue;
            $this->emergencyContact->ViewCustomAttributes = "";

            // emergencyFone
            $this->emergencyFone->ViewValue = $this->emergencyFone->CurrentValue;
            $this->emergencyFone->ViewCustomAttributes = "";

            // obs
            $this->obs->ViewValue = $this->obs->CurrentValue;
            $this->obs->ViewCustomAttributes = "";

            // modalityId
            if ($this->modalityId->VirtualValue != "") {
                $this->modalityId->ViewValue = $this->modalityId->VirtualValue;
            } else {
                $curVal = strval($this->modalityId->CurrentValue);
                if ($curVal != "") {
                    $this->modalityId->ViewValue = $this->modalityId->lookupCacheOption($curVal);
                    if ($this->modalityId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->modalityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->modalityId->Lookup->renderViewRow($rswrk[0]);
                            $this->modalityId->ViewValue = $this->modalityId->displayValue($arwrk);
                        } else {
                            $this->modalityId->ViewValue = FormatNumber($this->modalityId->CurrentValue, $this->modalityId->formatPattern());
                        }
                    }
                } else {
                    $this->modalityId->ViewValue = null;
                }
            }
            $this->modalityId->ViewCustomAttributes = "";

            // instructorStatus
            if (ConvertToBool($this->instructorStatus->CurrentValue)) {
                $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(1) != "" ? $this->instructorStatus->tagCaption(1) : "Yes";
            } else {
                $this->instructorStatus->ViewValue = $this->instructorStatus->tagCaption(2) != "" ? $this->instructorStatus->tagCaption(2) : "No";
            }
            $this->instructorStatus->ViewCustomAttributes = "";

            // martialArtId
            $curVal = strval($this->martialArtId->CurrentValue);
            if ($curVal != "") {
                $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
                if ($this->martialArtId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->martialArtId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->martialArtId->Lookup->renderViewRow($rswrk[0]);
                        $this->martialArtId->ViewValue = $this->martialArtId->displayValue($arwrk);
                    } else {
                        $this->martialArtId->ViewValue = FormatNumber($this->martialArtId->CurrentValue, $this->martialArtId->formatPattern());
                    }
                }
            } else {
                $this->martialArtId->ViewValue = null;
            }
            $this->martialArtId->ViewCustomAttributes = "";

            // rankId
            $curVal = strval($this->rankId->CurrentValue);
            if ($curVal != "") {
                $this->rankId->ViewValue = $this->rankId->lookupCacheOption($curVal);
                if ($this->rankId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->rankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->rankId->Lookup->renderViewRow($rswrk[0]);
                        $this->rankId->ViewValue = $this->rankId->displayValue($arwrk);
                    } else {
                        $this->rankId->ViewValue = FormatNumber($this->rankId->CurrentValue, $this->rankId->formatPattern());
                    }
                }
            } else {
                $this->rankId->ViewValue = null;
            }
            $this->rankId->ViewCustomAttributes = "";

            // schoolId
            if ($this->schoolId->VirtualValue != "") {
                $this->schoolId->ViewValue = $this->schoolId->VirtualValue;
            } else {
                $curVal = strval($this->schoolId->CurrentValue);
                if ($curVal != "") {
                    $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
                    if ($this->schoolId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->schoolId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->schoolId->Lookup->renderViewRow($rswrk[0]);
                            $this->schoolId->ViewValue = $this->schoolId->displayValue($arwrk);
                        } else {
                            $this->schoolId->ViewValue = FormatNumber($this->schoolId->CurrentValue, $this->schoolId->formatPattern());
                        }
                    }
                } else {
                    $this->schoolId->ViewValue = null;
                }
            }
            $this->schoolId->ViewCustomAttributes = "";

            // memberStatusId
            $curVal = strval($this->memberStatusId->CurrentValue);
            if ($curVal != "") {
                $this->memberStatusId->ViewValue = $this->memberStatusId->lookupCacheOption($curVal);
                if ($this->memberStatusId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberStatusId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberStatusId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberStatusId->ViewValue = $this->memberStatusId->displayValue($arwrk);
                    } else {
                        $this->memberStatusId->ViewValue = FormatNumber($this->memberStatusId->CurrentValue, $this->memberStatusId->formatPattern());
                    }
                }
            } else {
                $this->memberStatusId->ViewValue = null;
            }
            $this->memberStatusId->ViewCustomAttributes = "";

            // photo
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->ImageWidth = 80;
                $this->photo->ImageHeight = 90;
                $this->photo->ImageAlt = $this->photo->alt();
                $this->photo->ImageCssClass = "ew-image";
                $this->photo->ViewValue = $this->photo->Upload->DbValue;
            } else {
                $this->photo->ViewValue = "";
            }
            $this->photo->ViewCustomAttributes = "";

            // beltSize
            $this->beltSize->ViewValue = $this->beltSize->CurrentValue;
            $this->beltSize->ViewCustomAttributes = "";

            // dobokSize
            $this->dobokSize->ViewValue = $this->dobokSize->CurrentValue;
            $this->dobokSize->ViewCustomAttributes = "";

            // programId
            $curVal = strval($this->programId->CurrentValue);
            if ($curVal != "") {
                $this->programId->ViewValue = $this->programId->lookupCacheOption($curVal);
                if ($this->programId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->programId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->programId->Lookup->renderViewRow($rswrk[0]);
                        $this->programId->ViewValue = $this->programId->displayValue($arwrk);
                    } else {
                        $this->programId->ViewValue = FormatNumber($this->programId->CurrentValue, $this->programId->formatPattern());
                    }
                }
            } else {
                $this->programId->ViewValue = null;
            }
            $this->programId->ViewCustomAttributes = "";

            // classId
            $curVal = strval($this->classId->CurrentValue);
            if ($curVal != "") {
                $this->classId->ViewValue = $this->classId->lookupCacheOption($curVal);
                if ($this->classId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->classId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->classId->Lookup->renderViewRow($rswrk[0]);
                        $this->classId->ViewValue = $this->classId->displayValue($arwrk);
                    } else {
                        $this->classId->ViewValue = FormatNumber($this->classId->CurrentValue, $this->classId->formatPattern());
                    }
                }
            } else {
                $this->classId->ViewValue = null;
            }
            $this->classId->ViewCustomAttributes = "";

            // federationRegister
            $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
            $this->federationRegister->ViewCustomAttributes = "";

            // memberLevelId
            $curVal = strval($this->memberLevelId->CurrentValue);
            if ($curVal != "") {
                $this->memberLevelId->ViewValue = $this->memberLevelId->lookupCacheOption($curVal);
                if ($this->memberLevelId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->memberLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->memberLevelId->Lookup->renderViewRow($rswrk[0]);
                        $this->memberLevelId->ViewValue = $this->memberLevelId->displayValue($arwrk);
                    } else {
                        $this->memberLevelId->ViewValue = FormatNumber($this->memberLevelId->CurrentValue, $this->memberLevelId->formatPattern());
                    }
                }
            } else {
                $this->memberLevelId->ViewValue = null;
            }
            $this->memberLevelId->ViewCustomAttributes = "";

            // instructorLevelId
            $curVal = strval($this->instructorLevelId->CurrentValue);
            if ($curVal != "") {
                $this->instructorLevelId->ViewValue = $this->instructorLevelId->lookupCacheOption($curVal);
                if ($this->instructorLevelId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->instructorLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->instructorLevelId->Lookup->renderViewRow($rswrk[0]);
                        $this->instructorLevelId->ViewValue = $this->instructorLevelId->displayValue($arwrk);
                    } else {
                        $this->instructorLevelId->ViewValue = FormatNumber($this->instructorLevelId->CurrentValue, $this->instructorLevelId->formatPattern());
                    }
                }
            } else {
                $this->instructorLevelId->ViewValue = null;
            }
            $this->instructorLevelId->ViewCustomAttributes = "";

            // judgeLevelId
            $curVal = strval($this->judgeLevelId->CurrentValue);
            if ($curVal != "") {
                $this->judgeLevelId->ViewValue = $this->judgeLevelId->lookupCacheOption($curVal);
                if ($this->judgeLevelId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->judgeLevelId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->judgeLevelId->Lookup->renderViewRow($rswrk[0]);
                        $this->judgeLevelId->ViewValue = $this->judgeLevelId->displayValue($arwrk);
                    } else {
                        $this->judgeLevelId->ViewValue = FormatNumber($this->judgeLevelId->CurrentValue, $this->judgeLevelId->formatPattern());
                    }
                }
            } else {
                $this->judgeLevelId->ViewValue = null;
            }
            $this->judgeLevelId->ViewCustomAttributes = "";

            // federationRegisterDate
            $this->federationRegisterDate->ViewValue = $this->federationRegisterDate->CurrentValue;
            $this->federationRegisterDate->ViewValue = FormatDateTime($this->federationRegisterDate->ViewValue, $this->federationRegisterDate->formatPattern());
            $this->federationRegisterDate->ViewCustomAttributes = "";

            // federationStatus
            if (ConvertToBool($this->federationStatus->CurrentValue)) {
                $this->federationStatus->ViewValue = $this->federationStatus->tagCaption(1) != "" ? $this->federationStatus->tagCaption(1) : "Yes";
            } else {
                $this->federationStatus->ViewValue = $this->federationStatus->tagCaption(2) != "" ? $this->federationStatus->tagCaption(2) : "No";
            }
            $this->federationStatus->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
            $this->createUserId->ViewCustomAttributes = "";

            // lastUpdate
            $this->lastUpdate->ViewValue = $this->lastUpdate->CurrentValue;
            $this->lastUpdate->ViewValue = FormatDateTime($this->lastUpdate->ViewValue, $this->lastUpdate->formatPattern());
            $this->lastUpdate->ViewCustomAttributes = "";

            // lastUserId
            $this->lastUserId->ViewValue = $this->lastUserId->CurrentValue;
            $this->lastUserId->ViewValue = FormatNumber($this->lastUserId->ViewValue, $this->lastUserId->formatPattern());
            $this->lastUserId->ViewCustomAttributes = "";

            // marketingSourceId
            $curVal = strval($this->marketingSourceId->CurrentValue);
            if ($curVal != "") {
                $this->marketingSourceId->ViewValue = $this->marketingSourceId->lookupCacheOption($curVal);
                if ($this->marketingSourceId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->marketingSourceId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->marketingSourceId->Lookup->renderViewRow($rswrk[0]);
                        $this->marketingSourceId->ViewValue = $this->marketingSourceId->displayValue($arwrk);
                    } else {
                        $this->marketingSourceId->ViewValue = FormatNumber($this->marketingSourceId->CurrentValue, $this->marketingSourceId->formatPattern());
                    }
                }
            } else {
                $this->marketingSourceId->ViewValue = null;
            }
            $this->marketingSourceId->ViewCustomAttributes = "";

            // marketingSourceDetail
            $this->marketingSourceDetail->ViewValue = $this->marketingSourceDetail->CurrentValue;
            $this->marketingSourceDetail->ViewCustomAttributes = "";

            // memberTypeId
            $this->memberTypeId->ViewValue = $this->memberTypeId->CurrentValue;
            $this->memberTypeId->ViewValue = FormatNumber($this->memberTypeId->ViewValue, $this->memberTypeId->formatPattern());
            $this->memberTypeId->ViewCustomAttributes = "";

            // schoolUserId
            $this->schoolUserId->ViewValue = $this->schoolUserId->CurrentValue;
            $this->schoolUserId->ViewValue = FormatNumber($this->schoolUserId->ViewValue, $this->schoolUserId->formatPattern());
            $this->schoolUserId->ViewCustomAttributes = "";

            // age
            $this->age->ViewValue = $this->age->CurrentValue;
            $this->age->ViewValue = FormatNumber($this->age->ViewValue, $this->age->formatPattern());
            $this->age->ViewCustomAttributes = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // lastName
            $this->lastName->LinkCustomAttributes = "";
            $this->lastName->HrefValue = "";

            // birthdate
            $this->birthdate->LinkCustomAttributes = "";
            $this->birthdate->HrefValue = "";

            // gender
            $this->gender->LinkCustomAttributes = "";
            $this->gender->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // zip
            $this->zip->LinkCustomAttributes = "";
            $this->zip->HrefValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // facebook
            $this->facebook->LinkCustomAttributes = "";
            $this->facebook->HrefValue = "";

            // instagram
            $this->instagram->LinkCustomAttributes = "";
            $this->instagram->HrefValue = "";

            // father
            $this->father->LinkCustomAttributes = "";
            $this->father->HrefValue = "";

            // fatherCellphone
            $this->fatherCellphone->LinkCustomAttributes = "";
            $this->fatherCellphone->HrefValue = "";

            // receiveSmsFather
            $this->receiveSmsFather->LinkCustomAttributes = "";
            $this->receiveSmsFather->HrefValue = "";

            // fatherEmail
            $this->fatherEmail->LinkCustomAttributes = "";
            $this->fatherEmail->HrefValue = "";

            // receiveEmailFather
            $this->receiveEmailFather->LinkCustomAttributes = "";
            $this->receiveEmailFather->HrefValue = "";

            // fatherOccupation
            $this->fatherOccupation->LinkCustomAttributes = "";
            $this->fatherOccupation->HrefValue = "";

            // fatherBirthdate
            $this->fatherBirthdate->LinkCustomAttributes = "";
            $this->fatherBirthdate->HrefValue = "";

            // mother
            $this->mother->LinkCustomAttributes = "";
            $this->mother->HrefValue = "";

            // motherCellphone
            $this->motherCellphone->LinkCustomAttributes = "";
            $this->motherCellphone->HrefValue = "";

            // receiveSmsMother
            $this->receiveSmsMother->LinkCustomAttributes = "";
            $this->receiveSmsMother->HrefValue = "";

            // motherEmail
            $this->motherEmail->LinkCustomAttributes = "";
            $this->motherEmail->HrefValue = "";

            // receiveEmailMother
            $this->receiveEmailMother->LinkCustomAttributes = "";
            $this->receiveEmailMother->HrefValue = "";

            // motherOccupation
            $this->motherOccupation->LinkCustomAttributes = "";
            $this->motherOccupation->HrefValue = "";

            // motherBirthdate
            $this->motherBirthdate->LinkCustomAttributes = "";
            $this->motherBirthdate->HrefValue = "";

            // emergencyContact
            $this->emergencyContact->LinkCustomAttributes = "";
            $this->emergencyContact->HrefValue = "";

            // emergencyFone
            $this->emergencyFone->LinkCustomAttributes = "";
            $this->emergencyFone->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // modalityId
            $this->modalityId->LinkCustomAttributes = "";
            $this->modalityId->HrefValue = "";

            // instructorStatus
            $this->instructorStatus->LinkCustomAttributes = "";
            $this->instructorStatus->HrefValue = "";

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // memberStatusId
            $this->memberStatusId->LinkCustomAttributes = "";
            $this->memberStatusId->HrefValue = "";

            // photo
            $this->photo->LinkCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->HrefValue = GetFileUploadUrl($this->photo, $this->photo->htmlDecode($this->photo->Upload->DbValue)); // Add prefix/suffix
                $this->photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->photo->HrefValue = FullUrl($this->photo->HrefValue, "href");
                }
            } else {
                $this->photo->HrefValue = "";
            }
            $this->photo->ExportHrefValue = $this->photo->UploadPath . $this->photo->Upload->DbValue;

            // beltSize
            $this->beltSize->LinkCustomAttributes = "";
            $this->beltSize->HrefValue = "";

            // dobokSize
            $this->dobokSize->LinkCustomAttributes = "";
            $this->dobokSize->HrefValue = "";

            // memberLevelId
            $this->memberLevelId->LinkCustomAttributes = "";
            $this->memberLevelId->HrefValue = "";

            // instructorLevelId
            $this->instructorLevelId->LinkCustomAttributes = "";
            $this->instructorLevelId->HrefValue = "";

            // judgeLevelId
            $this->judgeLevelId->LinkCustomAttributes = "";
            $this->judgeLevelId->HrefValue = "";

            // federationRegisterDate
            $this->federationRegisterDate->LinkCustomAttributes = "";
            $this->federationRegisterDate->HrefValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // lastUserId
            $this->lastUserId->LinkCustomAttributes = "";
            $this->lastUserId->HrefValue = "";

            // marketingSourceId
            $this->marketingSourceId->LinkCustomAttributes = "";
            $this->marketingSourceId->HrefValue = "";

            // marketingSourceDetail
            $this->marketingSourceDetail->LinkCustomAttributes = "";
            $this->marketingSourceDetail->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // name
            $this->name->setupEditAttributes();
            $this->name->EditCustomAttributes = "";
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // lastName
            $this->lastName->setupEditAttributes();
            $this->lastName->EditCustomAttributes = "";
            if (!$this->lastName->Raw) {
                $this->lastName->CurrentValue = HtmlDecode($this->lastName->CurrentValue);
            }
            $this->lastName->EditValue = HtmlEncode($this->lastName->CurrentValue);
            $this->lastName->PlaceHolder = RemoveHtml($this->lastName->caption());

            // birthdate
            $this->birthdate->setupEditAttributes();
            $this->birthdate->EditCustomAttributes = "";
            $this->birthdate->EditValue = HtmlEncode(FormatDateTime($this->birthdate->CurrentValue, $this->birthdate->formatPattern()));
            $this->birthdate->PlaceHolder = RemoveHtml($this->birthdate->caption());

            // gender
            $this->gender->EditCustomAttributes = "";
            $this->gender->EditValue = $this->gender->options(false);
            $this->gender->PlaceHolder = RemoveHtml($this->gender->caption());

            // address
            $this->address->setupEditAttributes();
            $this->address->EditCustomAttributes = "";
            if (!$this->address->Raw) {
                $this->address->CurrentValue = HtmlDecode($this->address->CurrentValue);
            }
            $this->address->EditValue = HtmlEncode($this->address->CurrentValue);
            $this->address->PlaceHolder = RemoveHtml($this->address->caption());

            // neighborhood
            $this->neighborhood->setupEditAttributes();
            $this->neighborhood->EditCustomAttributes = "";
            if (!$this->neighborhood->Raw) {
                $this->neighborhood->CurrentValue = HtmlDecode($this->neighborhood->CurrentValue);
            }
            $this->neighborhood->EditValue = HtmlEncode($this->neighborhood->CurrentValue);
            $this->neighborhood->PlaceHolder = RemoveHtml($this->neighborhood->caption());

            // countryId
            $this->countryId->setupEditAttributes();
            $this->countryId->EditCustomAttributes = "";
            $curVal = trim(strval($this->countryId->CurrentValue));
            if ($curVal != "") {
                $this->countryId->ViewValue = $this->countryId->lookupCacheOption($curVal);
            } else {
                $this->countryId->ViewValue = $this->countryId->Lookup !== null && is_array($this->countryId->lookupOptions()) ? $curVal : null;
            }
            if ($this->countryId->ViewValue !== null) { // Load from cache
                $this->countryId->EditValue = array_values($this->countryId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->countryId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->countryId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->countryId->EditValue = $arwrk;
            }
            $this->countryId->PlaceHolder = RemoveHtml($this->countryId->caption());

            // UFId
            $this->UFId->setupEditAttributes();
            $this->UFId->EditCustomAttributes = "";
            $curVal = trim(strval($this->UFId->CurrentValue));
            if ($curVal != "") {
                $this->UFId->ViewValue = $this->UFId->lookupCacheOption($curVal);
            } else {
                $this->UFId->ViewValue = $this->UFId->Lookup !== null && is_array($this->UFId->lookupOptions()) ? $curVal : null;
            }
            if ($this->UFId->ViewValue !== null) { // Load from cache
                $this->UFId->EditValue = array_values($this->UFId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->UFId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->UFId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->UFId->EditValue = $arwrk;
            }
            $this->UFId->PlaceHolder = RemoveHtml($this->UFId->caption());

            // cityId
            $this->cityId->setupEditAttributes();
            $this->cityId->EditCustomAttributes = "";
            $curVal = trim(strval($this->cityId->CurrentValue));
            if ($curVal != "") {
                $this->cityId->ViewValue = $this->cityId->lookupCacheOption($curVal);
            } else {
                $this->cityId->ViewValue = $this->cityId->Lookup !== null && is_array($this->cityId->lookupOptions()) ? $curVal : null;
            }
            if ($this->cityId->ViewValue !== null) { // Load from cache
                $this->cityId->EditValue = array_values($this->cityId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->cityId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->cityId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->cityId->EditValue = $arwrk;
            }
            $this->cityId->PlaceHolder = RemoveHtml($this->cityId->caption());

            // zip
            $this->zip->setupEditAttributes();
            $this->zip->EditCustomAttributes = "";
            if (!$this->zip->Raw) {
                $this->zip->CurrentValue = HtmlDecode($this->zip->CurrentValue);
            }
            $this->zip->EditValue = HtmlEncode($this->zip->CurrentValue);
            $this->zip->PlaceHolder = RemoveHtml($this->zip->caption());

            // celphone
            $this->celphone->setupEditAttributes();
            $this->celphone->EditCustomAttributes = "";
            if (!$this->celphone->Raw) {
                $this->celphone->CurrentValue = HtmlDecode($this->celphone->CurrentValue);
            }
            $this->celphone->EditValue = HtmlEncode($this->celphone->CurrentValue);
            $this->celphone->PlaceHolder = RemoveHtml($this->celphone->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // facebook
            $this->facebook->setupEditAttributes();
            $this->facebook->EditCustomAttributes = "";
            if (!$this->facebook->Raw) {
                $this->facebook->CurrentValue = HtmlDecode($this->facebook->CurrentValue);
            }
            $this->facebook->EditValue = HtmlEncode($this->facebook->CurrentValue);
            $this->facebook->PlaceHolder = RemoveHtml($this->facebook->caption());

            // instagram
            $this->instagram->setupEditAttributes();
            $this->instagram->EditCustomAttributes = "";
            if (!$this->instagram->Raw) {
                $this->instagram->CurrentValue = HtmlDecode($this->instagram->CurrentValue);
            }
            $this->instagram->EditValue = HtmlEncode($this->instagram->CurrentValue);
            $this->instagram->PlaceHolder = RemoveHtml($this->instagram->caption());

            // father
            $this->father->setupEditAttributes();
            $this->father->EditCustomAttributes = "";
            if (!$this->father->Raw) {
                $this->father->CurrentValue = HtmlDecode($this->father->CurrentValue);
            }
            $this->father->EditValue = HtmlEncode($this->father->CurrentValue);
            $this->father->PlaceHolder = RemoveHtml($this->father->caption());

            // fatherCellphone
            $this->fatherCellphone->setupEditAttributes();
            $this->fatherCellphone->EditCustomAttributes = "";
            if (!$this->fatherCellphone->Raw) {
                $this->fatherCellphone->CurrentValue = HtmlDecode($this->fatherCellphone->CurrentValue);
            }
            $this->fatherCellphone->EditValue = HtmlEncode($this->fatherCellphone->CurrentValue);
            $this->fatherCellphone->PlaceHolder = RemoveHtml($this->fatherCellphone->caption());

            // receiveSmsFather
            $this->receiveSmsFather->EditCustomAttributes = "";
            $this->receiveSmsFather->EditValue = $this->receiveSmsFather->options(false);
            $this->receiveSmsFather->PlaceHolder = RemoveHtml($this->receiveSmsFather->caption());

            // fatherEmail
            $this->fatherEmail->setupEditAttributes();
            $this->fatherEmail->EditCustomAttributes = "";
            if (!$this->fatherEmail->Raw) {
                $this->fatherEmail->CurrentValue = HtmlDecode($this->fatherEmail->CurrentValue);
            }
            $this->fatherEmail->EditValue = HtmlEncode($this->fatherEmail->CurrentValue);
            $this->fatherEmail->PlaceHolder = RemoveHtml($this->fatherEmail->caption());

            // receiveEmailFather
            $this->receiveEmailFather->EditCustomAttributes = "";
            $this->receiveEmailFather->EditValue = $this->receiveEmailFather->options(false);
            $this->receiveEmailFather->PlaceHolder = RemoveHtml($this->receiveEmailFather->caption());

            // fatherOccupation
            $this->fatherOccupation->setupEditAttributes();
            $this->fatherOccupation->EditCustomAttributes = "";
            if (!$this->fatherOccupation->Raw) {
                $this->fatherOccupation->CurrentValue = HtmlDecode($this->fatherOccupation->CurrentValue);
            }
            $this->fatherOccupation->EditValue = HtmlEncode($this->fatherOccupation->CurrentValue);
            $this->fatherOccupation->PlaceHolder = RemoveHtml($this->fatherOccupation->caption());

            // fatherBirthdate
            $this->fatherBirthdate->setupEditAttributes();
            $this->fatherBirthdate->EditCustomAttributes = "";
            $this->fatherBirthdate->EditValue = HtmlEncode(FormatDateTime($this->fatherBirthdate->CurrentValue, $this->fatherBirthdate->formatPattern()));
            $this->fatherBirthdate->PlaceHolder = RemoveHtml($this->fatherBirthdate->caption());

            // mother
            $this->mother->setupEditAttributes();
            $this->mother->EditCustomAttributes = "";
            if (!$this->mother->Raw) {
                $this->mother->CurrentValue = HtmlDecode($this->mother->CurrentValue);
            }
            $this->mother->EditValue = HtmlEncode($this->mother->CurrentValue);
            $this->mother->PlaceHolder = RemoveHtml($this->mother->caption());

            // motherCellphone
            $this->motherCellphone->setupEditAttributes();
            $this->motherCellphone->EditCustomAttributes = "";
            if (!$this->motherCellphone->Raw) {
                $this->motherCellphone->CurrentValue = HtmlDecode($this->motherCellphone->CurrentValue);
            }
            $this->motherCellphone->EditValue = HtmlEncode($this->motherCellphone->CurrentValue);
            $this->motherCellphone->PlaceHolder = RemoveHtml($this->motherCellphone->caption());

            // receiveSmsMother
            $this->receiveSmsMother->EditCustomAttributes = "";
            $this->receiveSmsMother->EditValue = $this->receiveSmsMother->options(false);
            $this->receiveSmsMother->PlaceHolder = RemoveHtml($this->receiveSmsMother->caption());

            // motherEmail
            $this->motherEmail->setupEditAttributes();
            $this->motherEmail->EditCustomAttributes = "";
            if (!$this->motherEmail->Raw) {
                $this->motherEmail->CurrentValue = HtmlDecode($this->motherEmail->CurrentValue);
            }
            $this->motherEmail->EditValue = HtmlEncode($this->motherEmail->CurrentValue);
            $this->motherEmail->PlaceHolder = RemoveHtml($this->motherEmail->caption());

            // receiveEmailMother
            $this->receiveEmailMother->EditCustomAttributes = "";
            $this->receiveEmailMother->EditValue = $this->receiveEmailMother->options(false);
            $this->receiveEmailMother->PlaceHolder = RemoveHtml($this->receiveEmailMother->caption());

            // motherOccupation
            $this->motherOccupation->setupEditAttributes();
            $this->motherOccupation->EditCustomAttributes = "";
            if (!$this->motherOccupation->Raw) {
                $this->motherOccupation->CurrentValue = HtmlDecode($this->motherOccupation->CurrentValue);
            }
            $this->motherOccupation->EditValue = HtmlEncode($this->motherOccupation->CurrentValue);
            $this->motherOccupation->PlaceHolder = RemoveHtml($this->motherOccupation->caption());

            // motherBirthdate
            $this->motherBirthdate->setupEditAttributes();
            $this->motherBirthdate->EditCustomAttributes = "";
            $this->motherBirthdate->EditValue = HtmlEncode(FormatDateTime($this->motherBirthdate->CurrentValue, $this->motherBirthdate->formatPattern()));
            $this->motherBirthdate->PlaceHolder = RemoveHtml($this->motherBirthdate->caption());

            // emergencyContact
            $this->emergencyContact->setupEditAttributes();
            $this->emergencyContact->EditCustomAttributes = "";
            if (!$this->emergencyContact->Raw) {
                $this->emergencyContact->CurrentValue = HtmlDecode($this->emergencyContact->CurrentValue);
            }
            $this->emergencyContact->EditValue = HtmlEncode($this->emergencyContact->CurrentValue);
            $this->emergencyContact->PlaceHolder = RemoveHtml($this->emergencyContact->caption());

            // emergencyFone
            $this->emergencyFone->setupEditAttributes();
            $this->emergencyFone->EditCustomAttributes = "";
            if (!$this->emergencyFone->Raw) {
                $this->emergencyFone->CurrentValue = HtmlDecode($this->emergencyFone->CurrentValue);
            }
            $this->emergencyFone->EditValue = HtmlEncode($this->emergencyFone->CurrentValue);
            $this->emergencyFone->PlaceHolder = RemoveHtml($this->emergencyFone->caption());

            // obs
            $this->obs->setupEditAttributes();
            $this->obs->EditCustomAttributes = "";
            $this->obs->EditValue = HtmlEncode($this->obs->CurrentValue);
            $this->obs->PlaceHolder = RemoveHtml($this->obs->caption());

            // modalityId
            $this->modalityId->setupEditAttributes();
            $this->modalityId->EditCustomAttributes = "";
            $curVal = trim(strval($this->modalityId->CurrentValue));
            if ($curVal != "") {
                $this->modalityId->ViewValue = $this->modalityId->lookupCacheOption($curVal);
            } else {
                $this->modalityId->ViewValue = $this->modalityId->Lookup !== null && is_array($this->modalityId->lookupOptions()) ? $curVal : null;
            }
            if ($this->modalityId->ViewValue !== null) { // Load from cache
                $this->modalityId->EditValue = array_values($this->modalityId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->modalityId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->modalityId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->modalityId->EditValue = $arwrk;
            }
            $this->modalityId->PlaceHolder = RemoveHtml($this->modalityId->caption());

            // instructorStatus
            $this->instructorStatus->EditCustomAttributes = "";
            $this->instructorStatus->EditValue = $this->instructorStatus->options(false);
            $this->instructorStatus->PlaceHolder = RemoveHtml($this->instructorStatus->caption());

            // martialArtId
            $this->martialArtId->setupEditAttributes();
            $this->martialArtId->EditCustomAttributes = "";
            $curVal = trim(strval($this->martialArtId->CurrentValue));
            if ($curVal != "") {
                $this->martialArtId->ViewValue = $this->martialArtId->lookupCacheOption($curVal);
            } else {
                $this->martialArtId->ViewValue = $this->martialArtId->Lookup !== null && is_array($this->martialArtId->lookupOptions()) ? $curVal : null;
            }
            if ($this->martialArtId->ViewValue !== null) { // Load from cache
                $this->martialArtId->EditValue = array_values($this->martialArtId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->martialArtId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->martialArtId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->martialArtId->EditValue = $arwrk;
            }
            $this->martialArtId->PlaceHolder = RemoveHtml($this->martialArtId->caption());

            // rankId
            $this->rankId->setupEditAttributes();
            $this->rankId->EditCustomAttributes = "";
            $curVal = trim(strval($this->rankId->CurrentValue));
            if ($curVal != "") {
                $this->rankId->ViewValue = $this->rankId->lookupCacheOption($curVal);
            } else {
                $this->rankId->ViewValue = $this->rankId->Lookup !== null && is_array($this->rankId->lookupOptions()) ? $curVal : null;
            }
            if ($this->rankId->ViewValue !== null) { // Load from cache
                $this->rankId->EditValue = array_values($this->rankId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->rankId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->rankId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->rankId->EditValue = $arwrk;
            }
            $this->rankId->PlaceHolder = RemoveHtml($this->rankId->caption());

            // schoolId
            $this->schoolId->EditCustomAttributes = "";
            if ($this->schoolId->getSessionValue() != "") {
                $this->schoolId->CurrentValue = GetForeignKeyValue($this->schoolId->getSessionValue());
                if ($this->schoolId->VirtualValue != "") {
                    $this->schoolId->ViewValue = $this->schoolId->VirtualValue;
                } else {
                    $curVal = strval($this->schoolId->CurrentValue);
                    if ($curVal != "") {
                        $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
                        if ($this->schoolId->ViewValue === null) { // Lookup from database
                            $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                            $sqlWrk = $this->schoolId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                            $conn = Conn();
                            $config = $conn->getConfiguration();
                            $config->setResultCacheImpl($this->Cache);
                            $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                            $ari = count($rswrk);
                            if ($ari > 0) { // Lookup values found
                                $arwrk = $this->schoolId->Lookup->renderViewRow($rswrk[0]);
                                $this->schoolId->ViewValue = $this->schoolId->displayValue($arwrk);
                            } else {
                                $this->schoolId->ViewValue = FormatNumber($this->schoolId->CurrentValue, $this->schoolId->formatPattern());
                            }
                        }
                    } else {
                        $this->schoolId->ViewValue = null;
                    }
                }
                $this->schoolId->ViewCustomAttributes = "";
            } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("add")) { // Non system admin
                if (trim(strval($this->schoolId->CurrentValue)) == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->schoolId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->schoolId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll();
                $arwrk = $rswrk;
                $this->schoolId->EditValue = $arwrk;
            } else {
                $curVal = trim(strval($this->schoolId->CurrentValue));
                if ($curVal != "") {
                    $this->schoolId->ViewValue = $this->schoolId->lookupCacheOption($curVal);
                } else {
                    $this->schoolId->ViewValue = $this->schoolId->Lookup !== null && is_array($this->schoolId->lookupOptions()) ? $curVal : null;
                }
                if ($this->schoolId->ViewValue !== null) { // Load from cache
                    $this->schoolId->EditValue = array_values($this->schoolId->lookupOptions());
                    if ($this->schoolId->ViewValue == "") {
                        $this->schoolId->ViewValue = $Language->phrase("PleaseSelect");
                    }
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->schoolId->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->schoolId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->schoolId->Lookup->renderViewRow($rswrk[0]);
                        $this->schoolId->ViewValue = $this->schoolId->displayValue($arwrk);
                    } else {
                        $this->schoolId->ViewValue = $Language->phrase("PleaseSelect");
                    }
                    $arwrk = $rswrk;
                    $this->schoolId->EditValue = $arwrk;
                }
                $this->schoolId->PlaceHolder = RemoveHtml($this->schoolId->caption());
            }

            // memberStatusId
            $this->memberStatusId->EditCustomAttributes = "";
            $curVal = trim(strval($this->memberStatusId->CurrentValue));
            if ($curVal != "") {
                $this->memberStatusId->ViewValue = $this->memberStatusId->lookupCacheOption($curVal);
            } else {
                $this->memberStatusId->ViewValue = $this->memberStatusId->Lookup !== null && is_array($this->memberStatusId->lookupOptions()) ? $curVal : null;
            }
            if ($this->memberStatusId->ViewValue !== null) { // Load from cache
                $this->memberStatusId->EditValue = array_values($this->memberStatusId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->memberStatusId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->memberStatusId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->memberStatusId->EditValue = $arwrk;
            }
            $this->memberStatusId->PlaceHolder = RemoveHtml($this->memberStatusId->caption());

            // photo
            $this->photo->setupEditAttributes();
            $this->photo->EditCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->ImageWidth = 80;
                $this->photo->ImageHeight = 90;
                $this->photo->ImageAlt = $this->photo->alt();
                $this->photo->ImageCssClass = "ew-image";
                $this->photo->EditValue = $this->photo->Upload->DbValue;
            } else {
                $this->photo->EditValue = "";
            }
            if (!EmptyValue($this->photo->CurrentValue)) {
                $this->photo->Upload->FileName = $this->photo->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->photo);
            }

            // beltSize
            $this->beltSize->setupEditAttributes();
            $this->beltSize->EditCustomAttributes = "";
            if (!$this->beltSize->Raw) {
                $this->beltSize->CurrentValue = HtmlDecode($this->beltSize->CurrentValue);
            }
            $this->beltSize->EditValue = HtmlEncode($this->beltSize->CurrentValue);
            $this->beltSize->PlaceHolder = RemoveHtml($this->beltSize->caption());

            // dobokSize
            $this->dobokSize->setupEditAttributes();
            $this->dobokSize->EditCustomAttributes = "";
            if (!$this->dobokSize->Raw) {
                $this->dobokSize->CurrentValue = HtmlDecode($this->dobokSize->CurrentValue);
            }
            $this->dobokSize->EditValue = HtmlEncode($this->dobokSize->CurrentValue);
            $this->dobokSize->PlaceHolder = RemoveHtml($this->dobokSize->caption());

            // memberLevelId
            $this->memberLevelId->setupEditAttributes();
            $this->memberLevelId->EditCustomAttributes = "";
            $curVal = trim(strval($this->memberLevelId->CurrentValue));
            if ($curVal != "") {
                $this->memberLevelId->ViewValue = $this->memberLevelId->lookupCacheOption($curVal);
            } else {
                $this->memberLevelId->ViewValue = $this->memberLevelId->Lookup !== null && is_array($this->memberLevelId->lookupOptions()) ? $curVal : null;
            }
            if ($this->memberLevelId->ViewValue !== null) { // Load from cache
                $this->memberLevelId->EditValue = array_values($this->memberLevelId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->memberLevelId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->memberLevelId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->memberLevelId->EditValue = $arwrk;
            }
            $this->memberLevelId->PlaceHolder = RemoveHtml($this->memberLevelId->caption());

            // instructorLevelId
            $this->instructorLevelId->setupEditAttributes();
            $this->instructorLevelId->EditCustomAttributes = "";
            $curVal = trim(strval($this->instructorLevelId->CurrentValue));
            if ($curVal != "") {
                $this->instructorLevelId->ViewValue = $this->instructorLevelId->lookupCacheOption($curVal);
            } else {
                $this->instructorLevelId->ViewValue = $this->instructorLevelId->Lookup !== null && is_array($this->instructorLevelId->lookupOptions()) ? $curVal : null;
            }
            if ($this->instructorLevelId->ViewValue !== null) { // Load from cache
                $this->instructorLevelId->EditValue = array_values($this->instructorLevelId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->instructorLevelId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->instructorLevelId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->instructorLevelId->EditValue = $arwrk;
            }
            $this->instructorLevelId->PlaceHolder = RemoveHtml($this->instructorLevelId->caption());

            // judgeLevelId
            $this->judgeLevelId->setupEditAttributes();
            $this->judgeLevelId->EditCustomAttributes = "";
            $curVal = trim(strval($this->judgeLevelId->CurrentValue));
            if ($curVal != "") {
                $this->judgeLevelId->ViewValue = $this->judgeLevelId->lookupCacheOption($curVal);
            } else {
                $this->judgeLevelId->ViewValue = $this->judgeLevelId->Lookup !== null && is_array($this->judgeLevelId->lookupOptions()) ? $curVal : null;
            }
            if ($this->judgeLevelId->ViewValue !== null) { // Load from cache
                $this->judgeLevelId->EditValue = array_values($this->judgeLevelId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->judgeLevelId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->judgeLevelId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->judgeLevelId->EditValue = $arwrk;
            }
            $this->judgeLevelId->PlaceHolder = RemoveHtml($this->judgeLevelId->caption());

            // federationRegisterDate
            $this->federationRegisterDate->setupEditAttributes();
            $this->federationRegisterDate->EditCustomAttributes = "";
            $this->federationRegisterDate->EditValue = HtmlEncode(FormatDateTime($this->federationRegisterDate->CurrentValue, $this->federationRegisterDate->formatPattern()));
            $this->federationRegisterDate->PlaceHolder = RemoveHtml($this->federationRegisterDate->caption());

            // createDate

            // createUserId

            // lastUpdate

            // lastUserId

            // marketingSourceId
            $this->marketingSourceId->setupEditAttributes();
            $this->marketingSourceId->EditCustomAttributes = "";
            $curVal = trim(strval($this->marketingSourceId->CurrentValue));
            if ($curVal != "") {
                $this->marketingSourceId->ViewValue = $this->marketingSourceId->lookupCacheOption($curVal);
            } else {
                $this->marketingSourceId->ViewValue = $this->marketingSourceId->Lookup !== null && is_array($this->marketingSourceId->lookupOptions()) ? $curVal : null;
            }
            if ($this->marketingSourceId->ViewValue !== null) { // Load from cache
                $this->marketingSourceId->EditValue = array_values($this->marketingSourceId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->marketingSourceId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->marketingSourceId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->marketingSourceId->EditValue = $arwrk;
            }
            $this->marketingSourceId->PlaceHolder = RemoveHtml($this->marketingSourceId->caption());

            // marketingSourceDetail
            $this->marketingSourceDetail->setupEditAttributes();
            $this->marketingSourceDetail->EditCustomAttributes = "";
            if (!$this->marketingSourceDetail->Raw) {
                $this->marketingSourceDetail->CurrentValue = HtmlDecode($this->marketingSourceDetail->CurrentValue);
            }
            $this->marketingSourceDetail->EditValue = HtmlEncode($this->marketingSourceDetail->CurrentValue);
            $this->marketingSourceDetail->PlaceHolder = RemoveHtml($this->marketingSourceDetail->caption());

            // Add refer script

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // lastName
            $this->lastName->LinkCustomAttributes = "";
            $this->lastName->HrefValue = "";

            // birthdate
            $this->birthdate->LinkCustomAttributes = "";
            $this->birthdate->HrefValue = "";

            // gender
            $this->gender->LinkCustomAttributes = "";
            $this->gender->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // zip
            $this->zip->LinkCustomAttributes = "";
            $this->zip->HrefValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // facebook
            $this->facebook->LinkCustomAttributes = "";
            $this->facebook->HrefValue = "";

            // instagram
            $this->instagram->LinkCustomAttributes = "";
            $this->instagram->HrefValue = "";

            // father
            $this->father->LinkCustomAttributes = "";
            $this->father->HrefValue = "";

            // fatherCellphone
            $this->fatherCellphone->LinkCustomAttributes = "";
            $this->fatherCellphone->HrefValue = "";

            // receiveSmsFather
            $this->receiveSmsFather->LinkCustomAttributes = "";
            $this->receiveSmsFather->HrefValue = "";

            // fatherEmail
            $this->fatherEmail->LinkCustomAttributes = "";
            $this->fatherEmail->HrefValue = "";

            // receiveEmailFather
            $this->receiveEmailFather->LinkCustomAttributes = "";
            $this->receiveEmailFather->HrefValue = "";

            // fatherOccupation
            $this->fatherOccupation->LinkCustomAttributes = "";
            $this->fatherOccupation->HrefValue = "";

            // fatherBirthdate
            $this->fatherBirthdate->LinkCustomAttributes = "";
            $this->fatherBirthdate->HrefValue = "";

            // mother
            $this->mother->LinkCustomAttributes = "";
            $this->mother->HrefValue = "";

            // motherCellphone
            $this->motherCellphone->LinkCustomAttributes = "";
            $this->motherCellphone->HrefValue = "";

            // receiveSmsMother
            $this->receiveSmsMother->LinkCustomAttributes = "";
            $this->receiveSmsMother->HrefValue = "";

            // motherEmail
            $this->motherEmail->LinkCustomAttributes = "";
            $this->motherEmail->HrefValue = "";

            // receiveEmailMother
            $this->receiveEmailMother->LinkCustomAttributes = "";
            $this->receiveEmailMother->HrefValue = "";

            // motherOccupation
            $this->motherOccupation->LinkCustomAttributes = "";
            $this->motherOccupation->HrefValue = "";

            // motherBirthdate
            $this->motherBirthdate->LinkCustomAttributes = "";
            $this->motherBirthdate->HrefValue = "";

            // emergencyContact
            $this->emergencyContact->LinkCustomAttributes = "";
            $this->emergencyContact->HrefValue = "";

            // emergencyFone
            $this->emergencyFone->LinkCustomAttributes = "";
            $this->emergencyFone->HrefValue = "";

            // obs
            $this->obs->LinkCustomAttributes = "";
            $this->obs->HrefValue = "";

            // modalityId
            $this->modalityId->LinkCustomAttributes = "";
            $this->modalityId->HrefValue = "";

            // instructorStatus
            $this->instructorStatus->LinkCustomAttributes = "";
            $this->instructorStatus->HrefValue = "";

            // martialArtId
            $this->martialArtId->LinkCustomAttributes = "";
            $this->martialArtId->HrefValue = "";

            // rankId
            $this->rankId->LinkCustomAttributes = "";
            $this->rankId->HrefValue = "";

            // schoolId
            $this->schoolId->LinkCustomAttributes = "";
            $this->schoolId->HrefValue = "";

            // memberStatusId
            $this->memberStatusId->LinkCustomAttributes = "";
            $this->memberStatusId->HrefValue = "";

            // photo
            $this->photo->LinkCustomAttributes = "";
            $this->photo->UploadPath = "files/fotos";
            if (!EmptyValue($this->photo->Upload->DbValue)) {
                $this->photo->HrefValue = GetFileUploadUrl($this->photo, $this->photo->htmlDecode($this->photo->Upload->DbValue)); // Add prefix/suffix
                $this->photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->photo->HrefValue = FullUrl($this->photo->HrefValue, "href");
                }
            } else {
                $this->photo->HrefValue = "";
            }
            $this->photo->ExportHrefValue = $this->photo->UploadPath . $this->photo->Upload->DbValue;

            // beltSize
            $this->beltSize->LinkCustomAttributes = "";
            $this->beltSize->HrefValue = "";

            // dobokSize
            $this->dobokSize->LinkCustomAttributes = "";
            $this->dobokSize->HrefValue = "";

            // memberLevelId
            $this->memberLevelId->LinkCustomAttributes = "";
            $this->memberLevelId->HrefValue = "";

            // instructorLevelId
            $this->instructorLevelId->LinkCustomAttributes = "";
            $this->instructorLevelId->HrefValue = "";

            // judgeLevelId
            $this->judgeLevelId->LinkCustomAttributes = "";
            $this->judgeLevelId->HrefValue = "";

            // federationRegisterDate
            $this->federationRegisterDate->LinkCustomAttributes = "";
            $this->federationRegisterDate->HrefValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // lastUpdate
            $this->lastUpdate->LinkCustomAttributes = "";
            $this->lastUpdate->HrefValue = "";

            // lastUserId
            $this->lastUserId->LinkCustomAttributes = "";
            $this->lastUserId->HrefValue = "";

            // marketingSourceId
            $this->marketingSourceId->LinkCustomAttributes = "";
            $this->marketingSourceId->HrefValue = "";

            // marketingSourceDetail
            $this->marketingSourceDetail->LinkCustomAttributes = "";
            $this->marketingSourceDetail->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->lastName->Required) {
            if (!$this->lastName->IsDetailKey && EmptyValue($this->lastName->FormValue)) {
                $this->lastName->addErrorMessage(str_replace("%s", $this->lastName->caption(), $this->lastName->RequiredErrorMessage));
            }
        }
        if ($this->birthdate->Required) {
            if (!$this->birthdate->IsDetailKey && EmptyValue($this->birthdate->FormValue)) {
                $this->birthdate->addErrorMessage(str_replace("%s", $this->birthdate->caption(), $this->birthdate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->birthdate->FormValue, $this->birthdate->formatPattern())) {
            $this->birthdate->addErrorMessage($this->birthdate->getErrorMessage(false));
        }
        if ($this->gender->Required) {
            if ($this->gender->FormValue == "") {
                $this->gender->addErrorMessage(str_replace("%s", $this->gender->caption(), $this->gender->RequiredErrorMessage));
            }
        }
        if ($this->address->Required) {
            if (!$this->address->IsDetailKey && EmptyValue($this->address->FormValue)) {
                $this->address->addErrorMessage(str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
            }
        }
        if ($this->neighborhood->Required) {
            if (!$this->neighborhood->IsDetailKey && EmptyValue($this->neighborhood->FormValue)) {
                $this->neighborhood->addErrorMessage(str_replace("%s", $this->neighborhood->caption(), $this->neighborhood->RequiredErrorMessage));
            }
        }
        if ($this->countryId->Required) {
            if (!$this->countryId->IsDetailKey && EmptyValue($this->countryId->FormValue)) {
                $this->countryId->addErrorMessage(str_replace("%s", $this->countryId->caption(), $this->countryId->RequiredErrorMessage));
            }
        }
        if ($this->UFId->Required) {
            if (!$this->UFId->IsDetailKey && EmptyValue($this->UFId->FormValue)) {
                $this->UFId->addErrorMessage(str_replace("%s", $this->UFId->caption(), $this->UFId->RequiredErrorMessage));
            }
        }
        if ($this->cityId->Required) {
            if (!$this->cityId->IsDetailKey && EmptyValue($this->cityId->FormValue)) {
                $this->cityId->addErrorMessage(str_replace("%s", $this->cityId->caption(), $this->cityId->RequiredErrorMessage));
            }
        }
        if ($this->zip->Required) {
            if (!$this->zip->IsDetailKey && EmptyValue($this->zip->FormValue)) {
                $this->zip->addErrorMessage(str_replace("%s", $this->zip->caption(), $this->zip->RequiredErrorMessage));
            }
        }
        if ($this->celphone->Required) {
            if (!$this->celphone->IsDetailKey && EmptyValue($this->celphone->FormValue)) {
                $this->celphone->addErrorMessage(str_replace("%s", $this->celphone->caption(), $this->celphone->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_email->FormValue)) {
            $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
        }
        if ($this->facebook->Required) {
            if (!$this->facebook->IsDetailKey && EmptyValue($this->facebook->FormValue)) {
                $this->facebook->addErrorMessage(str_replace("%s", $this->facebook->caption(), $this->facebook->RequiredErrorMessage));
            }
        }
        if ($this->instagram->Required) {
            if (!$this->instagram->IsDetailKey && EmptyValue($this->instagram->FormValue)) {
                $this->instagram->addErrorMessage(str_replace("%s", $this->instagram->caption(), $this->instagram->RequiredErrorMessage));
            }
        }
        if ($this->father->Required) {
            if (!$this->father->IsDetailKey && EmptyValue($this->father->FormValue)) {
                $this->father->addErrorMessage(str_replace("%s", $this->father->caption(), $this->father->RequiredErrorMessage));
            }
        }
        if ($this->fatherCellphone->Required) {
            if (!$this->fatherCellphone->IsDetailKey && EmptyValue($this->fatherCellphone->FormValue)) {
                $this->fatherCellphone->addErrorMessage(str_replace("%s", $this->fatherCellphone->caption(), $this->fatherCellphone->RequiredErrorMessage));
            }
        }
        if ($this->receiveSmsFather->Required) {
            if ($this->receiveSmsFather->FormValue == "") {
                $this->receiveSmsFather->addErrorMessage(str_replace("%s", $this->receiveSmsFather->caption(), $this->receiveSmsFather->RequiredErrorMessage));
            }
        }
        if ($this->fatherEmail->Required) {
            if (!$this->fatherEmail->IsDetailKey && EmptyValue($this->fatherEmail->FormValue)) {
                $this->fatherEmail->addErrorMessage(str_replace("%s", $this->fatherEmail->caption(), $this->fatherEmail->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->fatherEmail->FormValue)) {
            $this->fatherEmail->addErrorMessage($this->fatherEmail->getErrorMessage(false));
        }
        if ($this->receiveEmailFather->Required) {
            if ($this->receiveEmailFather->FormValue == "") {
                $this->receiveEmailFather->addErrorMessage(str_replace("%s", $this->receiveEmailFather->caption(), $this->receiveEmailFather->RequiredErrorMessage));
            }
        }
        if ($this->fatherOccupation->Required) {
            if (!$this->fatherOccupation->IsDetailKey && EmptyValue($this->fatherOccupation->FormValue)) {
                $this->fatherOccupation->addErrorMessage(str_replace("%s", $this->fatherOccupation->caption(), $this->fatherOccupation->RequiredErrorMessage));
            }
        }
        if ($this->fatherBirthdate->Required) {
            if (!$this->fatherBirthdate->IsDetailKey && EmptyValue($this->fatherBirthdate->FormValue)) {
                $this->fatherBirthdate->addErrorMessage(str_replace("%s", $this->fatherBirthdate->caption(), $this->fatherBirthdate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fatherBirthdate->FormValue, $this->fatherBirthdate->formatPattern())) {
            $this->fatherBirthdate->addErrorMessage($this->fatherBirthdate->getErrorMessage(false));
        }
        if ($this->mother->Required) {
            if (!$this->mother->IsDetailKey && EmptyValue($this->mother->FormValue)) {
                $this->mother->addErrorMessage(str_replace("%s", $this->mother->caption(), $this->mother->RequiredErrorMessage));
            }
        }
        if ($this->motherCellphone->Required) {
            if (!$this->motherCellphone->IsDetailKey && EmptyValue($this->motherCellphone->FormValue)) {
                $this->motherCellphone->addErrorMessage(str_replace("%s", $this->motherCellphone->caption(), $this->motherCellphone->RequiredErrorMessage));
            }
        }
        if ($this->receiveSmsMother->Required) {
            if ($this->receiveSmsMother->FormValue == "") {
                $this->receiveSmsMother->addErrorMessage(str_replace("%s", $this->receiveSmsMother->caption(), $this->receiveSmsMother->RequiredErrorMessage));
            }
        }
        if ($this->motherEmail->Required) {
            if (!$this->motherEmail->IsDetailKey && EmptyValue($this->motherEmail->FormValue)) {
                $this->motherEmail->addErrorMessage(str_replace("%s", $this->motherEmail->caption(), $this->motherEmail->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->motherEmail->FormValue)) {
            $this->motherEmail->addErrorMessage($this->motherEmail->getErrorMessage(false));
        }
        if ($this->receiveEmailMother->Required) {
            if ($this->receiveEmailMother->FormValue == "") {
                $this->receiveEmailMother->addErrorMessage(str_replace("%s", $this->receiveEmailMother->caption(), $this->receiveEmailMother->RequiredErrorMessage));
            }
        }
        if ($this->motherOccupation->Required) {
            if (!$this->motherOccupation->IsDetailKey && EmptyValue($this->motherOccupation->FormValue)) {
                $this->motherOccupation->addErrorMessage(str_replace("%s", $this->motherOccupation->caption(), $this->motherOccupation->RequiredErrorMessage));
            }
        }
        if ($this->motherBirthdate->Required) {
            if (!$this->motherBirthdate->IsDetailKey && EmptyValue($this->motherBirthdate->FormValue)) {
                $this->motherBirthdate->addErrorMessage(str_replace("%s", $this->motherBirthdate->caption(), $this->motherBirthdate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->motherBirthdate->FormValue, $this->motherBirthdate->formatPattern())) {
            $this->motherBirthdate->addErrorMessage($this->motherBirthdate->getErrorMessage(false));
        }
        if ($this->emergencyContact->Required) {
            if (!$this->emergencyContact->IsDetailKey && EmptyValue($this->emergencyContact->FormValue)) {
                $this->emergencyContact->addErrorMessage(str_replace("%s", $this->emergencyContact->caption(), $this->emergencyContact->RequiredErrorMessage));
            }
        }
        if ($this->emergencyFone->Required) {
            if (!$this->emergencyFone->IsDetailKey && EmptyValue($this->emergencyFone->FormValue)) {
                $this->emergencyFone->addErrorMessage(str_replace("%s", $this->emergencyFone->caption(), $this->emergencyFone->RequiredErrorMessage));
            }
        }
        if ($this->obs->Required) {
            if (!$this->obs->IsDetailKey && EmptyValue($this->obs->FormValue)) {
                $this->obs->addErrorMessage(str_replace("%s", $this->obs->caption(), $this->obs->RequiredErrorMessage));
            }
        }
        if ($this->modalityId->Required) {
            if (!$this->modalityId->IsDetailKey && EmptyValue($this->modalityId->FormValue)) {
                $this->modalityId->addErrorMessage(str_replace("%s", $this->modalityId->caption(), $this->modalityId->RequiredErrorMessage));
            }
        }
        if ($this->instructorStatus->Required) {
            if ($this->instructorStatus->FormValue == "") {
                $this->instructorStatus->addErrorMessage(str_replace("%s", $this->instructorStatus->caption(), $this->instructorStatus->RequiredErrorMessage));
            }
        }
        if ($this->martialArtId->Required) {
            if (!$this->martialArtId->IsDetailKey && EmptyValue($this->martialArtId->FormValue)) {
                $this->martialArtId->addErrorMessage(str_replace("%s", $this->martialArtId->caption(), $this->martialArtId->RequiredErrorMessage));
            }
        }
        if ($this->rankId->Required) {
            if (!$this->rankId->IsDetailKey && EmptyValue($this->rankId->FormValue)) {
                $this->rankId->addErrorMessage(str_replace("%s", $this->rankId->caption(), $this->rankId->RequiredErrorMessage));
            }
        }
        if ($this->schoolId->Required) {
            if (!$this->schoolId->IsDetailKey && EmptyValue($this->schoolId->FormValue)) {
                $this->schoolId->addErrorMessage(str_replace("%s", $this->schoolId->caption(), $this->schoolId->RequiredErrorMessage));
            }
        }
        if ($this->memberStatusId->Required) {
            if ($this->memberStatusId->FormValue == "") {
                $this->memberStatusId->addErrorMessage(str_replace("%s", $this->memberStatusId->caption(), $this->memberStatusId->RequiredErrorMessage));
            }
        }
        if ($this->photo->Required) {
            if ($this->photo->Upload->FileName == "" && !$this->photo->Upload->KeepFile) {
                $this->photo->addErrorMessage(str_replace("%s", $this->photo->caption(), $this->photo->RequiredErrorMessage));
            }
        }
        if ($this->beltSize->Required) {
            if (!$this->beltSize->IsDetailKey && EmptyValue($this->beltSize->FormValue)) {
                $this->beltSize->addErrorMessage(str_replace("%s", $this->beltSize->caption(), $this->beltSize->RequiredErrorMessage));
            }
        }
        if ($this->dobokSize->Required) {
            if (!$this->dobokSize->IsDetailKey && EmptyValue($this->dobokSize->FormValue)) {
                $this->dobokSize->addErrorMessage(str_replace("%s", $this->dobokSize->caption(), $this->dobokSize->RequiredErrorMessage));
            }
        }
        if ($this->memberLevelId->Required) {
            if (!$this->memberLevelId->IsDetailKey && EmptyValue($this->memberLevelId->FormValue)) {
                $this->memberLevelId->addErrorMessage(str_replace("%s", $this->memberLevelId->caption(), $this->memberLevelId->RequiredErrorMessage));
            }
        }
        if ($this->instructorLevelId->Required) {
            if (!$this->instructorLevelId->IsDetailKey && EmptyValue($this->instructorLevelId->FormValue)) {
                $this->instructorLevelId->addErrorMessage(str_replace("%s", $this->instructorLevelId->caption(), $this->instructorLevelId->RequiredErrorMessage));
            }
        }
        if ($this->judgeLevelId->Required) {
            if (!$this->judgeLevelId->IsDetailKey && EmptyValue($this->judgeLevelId->FormValue)) {
                $this->judgeLevelId->addErrorMessage(str_replace("%s", $this->judgeLevelId->caption(), $this->judgeLevelId->RequiredErrorMessage));
            }
        }
        if ($this->federationRegisterDate->Required) {
            if (!$this->federationRegisterDate->IsDetailKey && EmptyValue($this->federationRegisterDate->FormValue)) {
                $this->federationRegisterDate->addErrorMessage(str_replace("%s", $this->federationRegisterDate->caption(), $this->federationRegisterDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->federationRegisterDate->FormValue, $this->federationRegisterDate->formatPattern())) {
            $this->federationRegisterDate->addErrorMessage($this->federationRegisterDate->getErrorMessage(false));
        }
        if ($this->createDate->Required) {
            if (!$this->createDate->IsDetailKey && EmptyValue($this->createDate->FormValue)) {
                $this->createDate->addErrorMessage(str_replace("%s", $this->createDate->caption(), $this->createDate->RequiredErrorMessage));
            }
        }
        if ($this->createUserId->Required) {
            if (!$this->createUserId->IsDetailKey && EmptyValue($this->createUserId->FormValue)) {
                $this->createUserId->addErrorMessage(str_replace("%s", $this->createUserId->caption(), $this->createUserId->RequiredErrorMessage));
            }
        }
        if ($this->lastUpdate->Required) {
            if (!$this->lastUpdate->IsDetailKey && EmptyValue($this->lastUpdate->FormValue)) {
                $this->lastUpdate->addErrorMessage(str_replace("%s", $this->lastUpdate->caption(), $this->lastUpdate->RequiredErrorMessage));
            }
        }
        if ($this->lastUserId->Required) {
            if (!$this->lastUserId->IsDetailKey && EmptyValue($this->lastUserId->FormValue)) {
                $this->lastUserId->addErrorMessage(str_replace("%s", $this->lastUserId->caption(), $this->lastUserId->RequiredErrorMessage));
            }
        }
        if ($this->marketingSourceId->Required) {
            if (!$this->marketingSourceId->IsDetailKey && EmptyValue($this->marketingSourceId->FormValue)) {
                $this->marketingSourceId->addErrorMessage(str_replace("%s", $this->marketingSourceId->caption(), $this->marketingSourceId->RequiredErrorMessage));
            }
        }
        if ($this->marketingSourceDetail->Required) {
            if (!$this->marketingSourceDetail->IsDetailKey && EmptyValue($this->marketingSourceDetail->FormValue)) {
                $this->marketingSourceDetail->addErrorMessage(str_replace("%s", $this->marketingSourceDetail->caption(), $this->marketingSourceDetail->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set new row
        $rsnew = [];

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, null, false);

        // lastName
        $this->lastName->setDbValueDef($rsnew, $this->lastName->CurrentValue, null, false);

        // birthdate
        $this->birthdate->setDbValueDef($rsnew, UnFormatDateTime($this->birthdate->CurrentValue, $this->birthdate->formatPattern()), null, false);

        // gender
        $this->gender->setDbValueDef($rsnew, $this->gender->CurrentValue, null, false);

        // address
        $this->address->setDbValueDef($rsnew, $this->address->CurrentValue, null, false);

        // neighborhood
        $this->neighborhood->setDbValueDef($rsnew, $this->neighborhood->CurrentValue, null, false);

        // countryId
        $this->countryId->setDbValueDef($rsnew, $this->countryId->CurrentValue, null, false);

        // UFId
        $this->UFId->setDbValueDef($rsnew, $this->UFId->CurrentValue, null, false);

        // cityId
        $this->cityId->setDbValueDef($rsnew, $this->cityId->CurrentValue, null, false);

        // zip
        $this->zip->setDbValueDef($rsnew, $this->zip->CurrentValue, null, false);

        // celphone
        $this->celphone->setDbValueDef($rsnew, $this->celphone->CurrentValue, null, false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // facebook
        $this->facebook->setDbValueDef($rsnew, $this->facebook->CurrentValue, null, false);

        // instagram
        $this->instagram->setDbValueDef($rsnew, $this->instagram->CurrentValue, null, false);

        // father
        $this->father->setDbValueDef($rsnew, $this->father->CurrentValue, null, false);

        // fatherCellphone
        $this->fatherCellphone->setDbValueDef($rsnew, $this->fatherCellphone->CurrentValue, null, false);

        // receiveSmsFather
        $this->receiveSmsFather->setDbValueDef($rsnew, $this->receiveSmsFather->CurrentValue, null, false);

        // fatherEmail
        $this->fatherEmail->setDbValueDef($rsnew, $this->fatherEmail->CurrentValue, null, false);

        // receiveEmailFather
        $this->receiveEmailFather->setDbValueDef($rsnew, $this->receiveEmailFather->CurrentValue, null, false);

        // fatherOccupation
        $this->fatherOccupation->setDbValueDef($rsnew, $this->fatherOccupation->CurrentValue, null, false);

        // fatherBirthdate
        $this->fatherBirthdate->setDbValueDef($rsnew, UnFormatDateTime($this->fatherBirthdate->CurrentValue, $this->fatherBirthdate->formatPattern()), null, false);

        // mother
        $this->mother->setDbValueDef($rsnew, $this->mother->CurrentValue, null, false);

        // motherCellphone
        $this->motherCellphone->setDbValueDef($rsnew, $this->motherCellphone->CurrentValue, null, false);

        // receiveSmsMother
        $this->receiveSmsMother->setDbValueDef($rsnew, $this->receiveSmsMother->CurrentValue, null, false);

        // motherEmail
        $this->motherEmail->setDbValueDef($rsnew, $this->motherEmail->CurrentValue, null, false);

        // receiveEmailMother
        $this->receiveEmailMother->setDbValueDef($rsnew, $this->receiveEmailMother->CurrentValue, null, false);

        // motherOccupation
        $this->motherOccupation->setDbValueDef($rsnew, $this->motherOccupation->CurrentValue, null, false);

        // motherBirthdate
        $this->motherBirthdate->setDbValueDef($rsnew, UnFormatDateTime($this->motherBirthdate->CurrentValue, $this->motherBirthdate->formatPattern()), null, false);

        // emergencyContact
        $this->emergencyContact->setDbValueDef($rsnew, $this->emergencyContact->CurrentValue, null, false);

        // emergencyFone
        $this->emergencyFone->setDbValueDef($rsnew, $this->emergencyFone->CurrentValue, null, false);

        // obs
        $this->obs->setDbValueDef($rsnew, $this->obs->CurrentValue, null, false);

        // modalityId
        $this->modalityId->setDbValueDef($rsnew, $this->modalityId->CurrentValue, null, false);

        // instructorStatus
        $tmpBool = $this->instructorStatus->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->instructorStatus->setDbValueDef($rsnew, $tmpBool, null, false);

        // martialArtId
        $this->martialArtId->setDbValueDef($rsnew, $this->martialArtId->CurrentValue, null, false);

        // rankId
        $this->rankId->setDbValueDef($rsnew, $this->rankId->CurrentValue, null, false);

        // schoolId
        $this->schoolId->setDbValueDef($rsnew, $this->schoolId->CurrentValue, 0, false);

        // memberStatusId
        $this->memberStatusId->setDbValueDef($rsnew, $this->memberStatusId->CurrentValue, 0, false);

        // photo
        if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
            $this->photo->Upload->DbValue = ""; // No need to delete old file
            if ($this->photo->Upload->FileName == "") {
                $rsnew['photo'] = null;
            } else {
                $rsnew['photo'] = $this->photo->Upload->FileName;
            }
            $this->photo->ImageWidth = 300; // Resize width
            $this->photo->ImageHeight = 0; // Resize height
        }

        // beltSize
        $this->beltSize->setDbValueDef($rsnew, $this->beltSize->CurrentValue, null, false);

        // dobokSize
        $this->dobokSize->setDbValueDef($rsnew, $this->dobokSize->CurrentValue, null, false);

        // memberLevelId
        $this->memberLevelId->setDbValueDef($rsnew, $this->memberLevelId->CurrentValue, 0, false);

        // instructorLevelId
        $this->instructorLevelId->setDbValueDef($rsnew, $this->instructorLevelId->CurrentValue, null, false);

        // judgeLevelId
        $this->judgeLevelId->setDbValueDef($rsnew, $this->judgeLevelId->CurrentValue, null, false);

        // federationRegisterDate
        $this->federationRegisterDate->setDbValueDef($rsnew, UnFormatDateTime($this->federationRegisterDate->CurrentValue, $this->federationRegisterDate->formatPattern()), null, false);

        // createDate
        $this->createDate->CurrentValue = CurrentDate();
        $this->createDate->setDbValueDef($rsnew, $this->createDate->CurrentValue, null);

        // createUserId
        $this->createUserId->CurrentValue = GetLoggedUserID();
        $this->createUserId->setDbValueDef($rsnew, $this->createUserId->CurrentValue, null);

        // lastUpdate
        $this->lastUpdate->CurrentValue = CurrentDate();
        $this->lastUpdate->setDbValueDef($rsnew, $this->lastUpdate->CurrentValue, null);

        // lastUserId
        $this->lastUserId->CurrentValue = GetLoggedUserID();
        $this->lastUserId->setDbValueDef($rsnew, $this->lastUserId->CurrentValue, null);

        // marketingSourceId
        $this->marketingSourceId->setDbValueDef($rsnew, $this->marketingSourceId->CurrentValue, null, false);

        // marketingSourceDetail
        $this->marketingSourceDetail->setDbValueDef($rsnew, $this->marketingSourceDetail->CurrentValue, null, false);
        if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
            $this->photo->UploadPath = "files/fotos";
            $oldFiles = EmptyValue($this->photo->Upload->DbValue) ? [] : [$this->photo->htmlDecode($this->photo->Upload->DbValue)];
            if (!EmptyValue($this->photo->Upload->FileName)) {
                $newFiles = [$this->photo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->photo, $this->photo->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->photo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->photo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->photo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->photo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->photo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->photo->setDbValueDef($rsnew, $this->photo->Upload->FileName, null, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->schoolId->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->schoolId->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->schoolId->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $detailKeys = [];
            $detailKeys["schoolId"] = $this->schoolId->CurrentValue;
            $masterTable = Container("fed_school");
            $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
            if (!EmptyValue($masterFilter)) {
                $validMasterKey = true;
                if ($rsmaster = $masterTable->loadRs($masterFilter)->fetchAssociative()) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['id']);
                } elseif ($this->getCurrentMasterTable() == "fed_school") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);
        $this->photo->OldUploadPath = "files/fotos";
        $this->photo->UploadPath = $this->photo->OldUploadPath;

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->photo->Visible && !$this->photo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->photo->Upload->DbValue) ? [] : [$this->photo->htmlDecode($this->photo->Upload->DbValue)];
                    if (!EmptyValue($this->photo->Upload->FileName)) {
                        $newFiles = [$this->photo->Upload->FileName];
                        $newFiles2 = [$this->photo->htmlDecode($rsnew['photo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->photo, $this->photo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->photo->Upload->ResizeAndSaveToFile($this->photo->ImageWidth, $this->photo->ImageHeight, 100, $newFiles[$i], true, $i)) {
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->photo->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // photo
            CleanUploadTempPath($this->photo, $this->photo->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->schoolId->CurrentValue);
        }
        return true;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "fed_school") {
                $validMaster = true;
                $masterTbl = Container("fed_school");
                if (($parm = Get("fk_id", Get("schoolId"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->schoolId->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->schoolId->setSessionValue($this->schoolId->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "fed_school") {
                $validMaster = true;
                $masterTbl = Container("fed_school");
                if (($parm = Post("fk_id", Post("schoolId"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->schoolId->setFormValue($masterTbl->id->FormValue);
                    $this->schoolId->setSessionValue($this->schoolId->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "fed_school") {
                if ($this->schoolId->CurrentValue == "") {
                    $this->schoolId->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SchoolMemberList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $pages->add(3);
        $pages->add(4);
        $this->MultiPages = $pages;
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_gender":
                    break;
                case "x_countryId":
                    break;
                case "x_UFId":
                    break;
                case "x_cityId":
                    break;
                case "x_receiveSmsFather":
                    break;
                case "x_receiveEmailFather":
                    break;
                case "x_receiveSmsMother":
                    break;
                case "x_receiveEmailMother":
                    break;
                case "x_modalityId":
                    break;
                case "x_instructorStatus":
                    break;
                case "x_martialArtId":
                    break;
                case "x_rankId":
                    break;
                case "x_schoolId":
                    break;
                case "x_memberStatusId":
                    break;
                case "x_programId":
                    break;
                case "x_classId":
                    break;
                case "x_memberLevelId":
                    break;
                case "x_instructorLevelId":
                    break;
                case "x_judgeLevelId":
                    break;
                case "x_federationStatus":
                    break;
                case "x_marketingSourceId":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
