<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedApplicationschoolAdd extends FedApplicationschool
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_applicationschool';

    // Page object name
    public $PageObjName = "FedApplicationschoolAdd";

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

        // Table object (fed_applicationschool)
        if (!isset($GLOBALS["fed_applicationschool"]) || get_class($GLOBALS["fed_applicationschool"]) == PROJECT_NAMESPACE . "fed_applicationschool") {
            $GLOBALS["fed_applicationschool"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fed_applicationschool');
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
                $tbl = Container("fed_applicationschool");
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
                    if ($pageName == "FedApplicationschoolView") {
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
    public $DetailPages; // Detail pages object

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
        $this->federationId->Visible = false;
        $this->masterSchoolId->Visible = false;
        $this->school->setVisibility();
        $this->countryId->setVisibility();
        $this->UFId->setVisibility();
        $this->cityId->setVisibility();
        $this->neighborhood->setVisibility();
        $this->address->setVisibility();
        $this->zipcode->setVisibility();
        $this->website->setVisibility();
        $this->_email->setVisibility();
        $this->phone->setVisibility();
        $this->celphone->setVisibility();
        $this->logo->setVisibility();
        $this->openingDate->setVisibility();
        $this->federationRegister->Visible = false;
        $this->createUserId->setVisibility();
        $this->createDate->Visible = false;
        $this->typeId->Visible = false;
        $this->owner->setVisibility();
        $this->identityNumber->setVisibility();
        $this->birthDateOwner->setVisibility();
        $this->ownerCountryId->setVisibility();
        $this->ownerStateId->setVisibility();
        $this->ownCityId->setVisibility();
        $this->ownerTelephone->setVisibility();
        $this->ownerTelephoneWork->setVisibility();
        $this->ownerProfession->setVisibility();
        $this->employer->setVisibility();
        $this->ownerGraduation->setVisibility();
        $this->ownerGraduationLocation->setVisibility();
        $this->ownerGraduationObs->setVisibility();
        $this->ownerMaritalStatus->setVisibility();
        $this->ownerSpouseName->setVisibility();
        $this->ownerSpouseProfession->setVisibility();
        $this->propertySituation->setVisibility();
        $this->numberOfStudentsInBeginnig->setVisibility();
        $this->ownerAbout->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up multi page object
        $this->setupMultiPages();

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->federationId);
        $this->setupLookupOptions($this->masterSchoolId);
        $this->setupLookupOptions($this->countryId);
        $this->setupLookupOptions($this->UFId);
        $this->setupLookupOptions($this->cityId);
        $this->setupLookupOptions($this->typeId);
        $this->setupLookupOptions($this->ownerCountryId);
        $this->setupLookupOptions($this->ownerStateId);
        $this->setupLookupOptions($this->ownCityId);
        $this->setupLookupOptions($this->ownerGraduation);
        $this->setupLookupOptions($this->ownerMaritalStatus);
        $this->setupLookupOptions($this->propertySituation);

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

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("FedApplicationschoolList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "FedApplicationschoolList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "FedApplicationschoolView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->logo->Upload->Index = $CurrentForm->Index;
        $this->logo->Upload->uploadFile();
        $this->logo->CurrentValue = $this->logo->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->federationId->DefaultValue = 1;
        $this->federationId->OldValue = $this->federationId->DefaultValue;
        $this->typeId->DefaultValue = 5;
        $this->typeId->OldValue = $this->typeId->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'school' first before field var 'x_school'
        $val = $CurrentForm->hasValue("school") ? $CurrentForm->getValue("school") : $CurrentForm->getValue("x_school");
        if (!$this->school->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->school->Visible = false; // Disable update for API request
            } else {
                $this->school->setFormValue($val);
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

        // Check field name 'neighborhood' first before field var 'x_neighborhood'
        $val = $CurrentForm->hasValue("neighborhood") ? $CurrentForm->getValue("neighborhood") : $CurrentForm->getValue("x_neighborhood");
        if (!$this->neighborhood->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->neighborhood->Visible = false; // Disable update for API request
            } else {
                $this->neighborhood->setFormValue($val);
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

        // Check field name 'zipcode' first before field var 'x_zipcode'
        $val = $CurrentForm->hasValue("zipcode") ? $CurrentForm->getValue("zipcode") : $CurrentForm->getValue("x_zipcode");
        if (!$this->zipcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->zipcode->Visible = false; // Disable update for API request
            } else {
                $this->zipcode->setFormValue($val);
            }
        }

        // Check field name 'website' first before field var 'x_website'
        $val = $CurrentForm->hasValue("website") ? $CurrentForm->getValue("website") : $CurrentForm->getValue("x_website");
        if (!$this->website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->website->Visible = false; // Disable update for API request
            } else {
                $this->website->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'phone' first before field var 'x_phone'
        $val = $CurrentForm->hasValue("phone") ? $CurrentForm->getValue("phone") : $CurrentForm->getValue("x_phone");
        if (!$this->phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone->Visible = false; // Disable update for API request
            } else {
                $this->phone->setFormValue($val);
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

        // Check field name 'openingDate' first before field var 'x_openingDate'
        $val = $CurrentForm->hasValue("openingDate") ? $CurrentForm->getValue("openingDate") : $CurrentForm->getValue("x_openingDate");
        if (!$this->openingDate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->openingDate->Visible = false; // Disable update for API request
            } else {
                $this->openingDate->setFormValue($val, true, $validate);
            }
            $this->openingDate->CurrentValue = UnFormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern());
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

        // Check field name 'owner' first before field var 'x_owner'
        $val = $CurrentForm->hasValue("owner") ? $CurrentForm->getValue("owner") : $CurrentForm->getValue("x_owner");
        if (!$this->owner->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->owner->Visible = false; // Disable update for API request
            } else {
                $this->owner->setFormValue($val);
            }
        }

        // Check field name 'identityNumber' first before field var 'x_identityNumber'
        $val = $CurrentForm->hasValue("identityNumber") ? $CurrentForm->getValue("identityNumber") : $CurrentForm->getValue("x_identityNumber");
        if (!$this->identityNumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->identityNumber->Visible = false; // Disable update for API request
            } else {
                $this->identityNumber->setFormValue($val);
            }
        }

        // Check field name 'birthDateOwner' first before field var 'x_birthDateOwner'
        $val = $CurrentForm->hasValue("birthDateOwner") ? $CurrentForm->getValue("birthDateOwner") : $CurrentForm->getValue("x_birthDateOwner");
        if (!$this->birthDateOwner->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->birthDateOwner->Visible = false; // Disable update for API request
            } else {
                $this->birthDateOwner->setFormValue($val, true, $validate);
            }
            $this->birthDateOwner->CurrentValue = UnFormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern());
        }

        // Check field name 'ownerCountryId' first before field var 'x_ownerCountryId'
        $val = $CurrentForm->hasValue("ownerCountryId") ? $CurrentForm->getValue("ownerCountryId") : $CurrentForm->getValue("x_ownerCountryId");
        if (!$this->ownerCountryId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerCountryId->Visible = false; // Disable update for API request
            } else {
                $this->ownerCountryId->setFormValue($val);
            }
        }

        // Check field name 'ownerStateId' first before field var 'x_ownerStateId'
        $val = $CurrentForm->hasValue("ownerStateId") ? $CurrentForm->getValue("ownerStateId") : $CurrentForm->getValue("x_ownerStateId");
        if (!$this->ownerStateId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerStateId->Visible = false; // Disable update for API request
            } else {
                $this->ownerStateId->setFormValue($val);
            }
        }

        // Check field name 'ownCityId' first before field var 'x_ownCityId'
        $val = $CurrentForm->hasValue("ownCityId") ? $CurrentForm->getValue("ownCityId") : $CurrentForm->getValue("x_ownCityId");
        if (!$this->ownCityId->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownCityId->Visible = false; // Disable update for API request
            } else {
                $this->ownCityId->setFormValue($val);
            }
        }

        // Check field name 'ownerTelephone' first before field var 'x_ownerTelephone'
        $val = $CurrentForm->hasValue("ownerTelephone") ? $CurrentForm->getValue("ownerTelephone") : $CurrentForm->getValue("x_ownerTelephone");
        if (!$this->ownerTelephone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerTelephone->Visible = false; // Disable update for API request
            } else {
                $this->ownerTelephone->setFormValue($val);
            }
        }

        // Check field name 'ownerTelephoneWork' first before field var 'x_ownerTelephoneWork'
        $val = $CurrentForm->hasValue("ownerTelephoneWork") ? $CurrentForm->getValue("ownerTelephoneWork") : $CurrentForm->getValue("x_ownerTelephoneWork");
        if (!$this->ownerTelephoneWork->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerTelephoneWork->Visible = false; // Disable update for API request
            } else {
                $this->ownerTelephoneWork->setFormValue($val);
            }
        }

        // Check field name 'ownerProfession' first before field var 'x_ownerProfession'
        $val = $CurrentForm->hasValue("ownerProfession") ? $CurrentForm->getValue("ownerProfession") : $CurrentForm->getValue("x_ownerProfession");
        if (!$this->ownerProfession->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerProfession->Visible = false; // Disable update for API request
            } else {
                $this->ownerProfession->setFormValue($val);
            }
        }

        // Check field name 'employer' first before field var 'x_employer'
        $val = $CurrentForm->hasValue("employer") ? $CurrentForm->getValue("employer") : $CurrentForm->getValue("x_employer");
        if (!$this->employer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->employer->Visible = false; // Disable update for API request
            } else {
                $this->employer->setFormValue($val);
            }
        }

        // Check field name 'ownerGraduation' first before field var 'x_ownerGraduation'
        $val = $CurrentForm->hasValue("ownerGraduation") ? $CurrentForm->getValue("ownerGraduation") : $CurrentForm->getValue("x_ownerGraduation");
        if (!$this->ownerGraduation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerGraduation->Visible = false; // Disable update for API request
            } else {
                $this->ownerGraduation->setFormValue($val);
            }
        }

        // Check field name 'ownerGraduationLocation' first before field var 'x_ownerGraduationLocation'
        $val = $CurrentForm->hasValue("ownerGraduationLocation") ? $CurrentForm->getValue("ownerGraduationLocation") : $CurrentForm->getValue("x_ownerGraduationLocation");
        if (!$this->ownerGraduationLocation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerGraduationLocation->Visible = false; // Disable update for API request
            } else {
                $this->ownerGraduationLocation->setFormValue($val);
            }
        }

        // Check field name 'ownerGraduationObs' first before field var 'x_ownerGraduationObs'
        $val = $CurrentForm->hasValue("ownerGraduationObs") ? $CurrentForm->getValue("ownerGraduationObs") : $CurrentForm->getValue("x_ownerGraduationObs");
        if (!$this->ownerGraduationObs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerGraduationObs->Visible = false; // Disable update for API request
            } else {
                $this->ownerGraduationObs->setFormValue($val);
            }
        }

        // Check field name 'ownerMaritalStatus' first before field var 'x_ownerMaritalStatus'
        $val = $CurrentForm->hasValue("ownerMaritalStatus") ? $CurrentForm->getValue("ownerMaritalStatus") : $CurrentForm->getValue("x_ownerMaritalStatus");
        if (!$this->ownerMaritalStatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerMaritalStatus->Visible = false; // Disable update for API request
            } else {
                $this->ownerMaritalStatus->setFormValue($val);
            }
        }

        // Check field name 'ownerSpouseName' first before field var 'x_ownerSpouseName'
        $val = $CurrentForm->hasValue("ownerSpouseName") ? $CurrentForm->getValue("ownerSpouseName") : $CurrentForm->getValue("x_ownerSpouseName");
        if (!$this->ownerSpouseName->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerSpouseName->Visible = false; // Disable update for API request
            } else {
                $this->ownerSpouseName->setFormValue($val);
            }
        }

        // Check field name 'ownerSpouseProfession' first before field var 'x_ownerSpouseProfession'
        $val = $CurrentForm->hasValue("ownerSpouseProfession") ? $CurrentForm->getValue("ownerSpouseProfession") : $CurrentForm->getValue("x_ownerSpouseProfession");
        if (!$this->ownerSpouseProfession->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerSpouseProfession->Visible = false; // Disable update for API request
            } else {
                $this->ownerSpouseProfession->setFormValue($val);
            }
        }

        // Check field name 'propertySituation' first before field var 'x_propertySituation'
        $val = $CurrentForm->hasValue("propertySituation") ? $CurrentForm->getValue("propertySituation") : $CurrentForm->getValue("x_propertySituation");
        if (!$this->propertySituation->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->propertySituation->Visible = false; // Disable update for API request
            } else {
                $this->propertySituation->setFormValue($val);
            }
        }

        // Check field name 'numberOfStudentsInBeginnig' first before field var 'x_numberOfStudentsInBeginnig'
        $val = $CurrentForm->hasValue("numberOfStudentsInBeginnig") ? $CurrentForm->getValue("numberOfStudentsInBeginnig") : $CurrentForm->getValue("x_numberOfStudentsInBeginnig");
        if (!$this->numberOfStudentsInBeginnig->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->numberOfStudentsInBeginnig->Visible = false; // Disable update for API request
            } else {
                $this->numberOfStudentsInBeginnig->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ownerAbout' first before field var 'x_ownerAbout'
        $val = $CurrentForm->hasValue("ownerAbout") ? $CurrentForm->getValue("ownerAbout") : $CurrentForm->getValue("x_ownerAbout");
        if (!$this->ownerAbout->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ownerAbout->Visible = false; // Disable update for API request
            } else {
                $this->ownerAbout->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->school->CurrentValue = $this->school->FormValue;
        $this->countryId->CurrentValue = $this->countryId->FormValue;
        $this->UFId->CurrentValue = $this->UFId->FormValue;
        $this->cityId->CurrentValue = $this->cityId->FormValue;
        $this->neighborhood->CurrentValue = $this->neighborhood->FormValue;
        $this->address->CurrentValue = $this->address->FormValue;
        $this->zipcode->CurrentValue = $this->zipcode->FormValue;
        $this->website->CurrentValue = $this->website->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->celphone->CurrentValue = $this->celphone->FormValue;
        $this->openingDate->CurrentValue = $this->openingDate->FormValue;
        $this->openingDate->CurrentValue = UnFormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern());
        $this->createUserId->CurrentValue = $this->createUserId->FormValue;
        $this->owner->CurrentValue = $this->owner->FormValue;
        $this->identityNumber->CurrentValue = $this->identityNumber->FormValue;
        $this->birthDateOwner->CurrentValue = $this->birthDateOwner->FormValue;
        $this->birthDateOwner->CurrentValue = UnFormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern());
        $this->ownerCountryId->CurrentValue = $this->ownerCountryId->FormValue;
        $this->ownerStateId->CurrentValue = $this->ownerStateId->FormValue;
        $this->ownCityId->CurrentValue = $this->ownCityId->FormValue;
        $this->ownerTelephone->CurrentValue = $this->ownerTelephone->FormValue;
        $this->ownerTelephoneWork->CurrentValue = $this->ownerTelephoneWork->FormValue;
        $this->ownerProfession->CurrentValue = $this->ownerProfession->FormValue;
        $this->employer->CurrentValue = $this->employer->FormValue;
        $this->ownerGraduation->CurrentValue = $this->ownerGraduation->FormValue;
        $this->ownerGraduationLocation->CurrentValue = $this->ownerGraduationLocation->FormValue;
        $this->ownerGraduationObs->CurrentValue = $this->ownerGraduationObs->FormValue;
        $this->ownerMaritalStatus->CurrentValue = $this->ownerMaritalStatus->FormValue;
        $this->ownerSpouseName->CurrentValue = $this->ownerSpouseName->FormValue;
        $this->ownerSpouseProfession->CurrentValue = $this->ownerSpouseProfession->FormValue;
        $this->propertySituation->CurrentValue = $this->propertySituation->FormValue;
        $this->numberOfStudentsInBeginnig->CurrentValue = $this->numberOfStudentsInBeginnig->FormValue;
        $this->ownerAbout->CurrentValue = $this->ownerAbout->FormValue;
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
        $this->federationId->setDbValue($row['federationId']);
        if (array_key_exists('EV__federationId', $row)) {
            $this->federationId->VirtualValue = $row['EV__federationId']; // Set up virtual field value
        } else {
            $this->federationId->VirtualValue = ""; // Clear value
        }
        $this->masterSchoolId->setDbValue($row['masterSchoolId']);
        if (array_key_exists('EV__masterSchoolId', $row)) {
            $this->masterSchoolId->VirtualValue = $row['EV__masterSchoolId']; // Set up virtual field value
        } else {
            $this->masterSchoolId->VirtualValue = ""; // Clear value
        }
        $this->school->setDbValue($row['school']);
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
        $this->neighborhood->setDbValue($row['neighborhood']);
        $this->address->setDbValue($row['address']);
        $this->zipcode->setDbValue($row['zipcode']);
        $this->website->setDbValue($row['website']);
        $this->_email->setDbValue($row['email']);
        $this->phone->setDbValue($row['phone']);
        $this->celphone->setDbValue($row['celphone']);
        $this->logo->Upload->DbValue = $row['logo'];
        $this->logo->setDbValue($this->logo->Upload->DbValue);
        $this->openingDate->setDbValue($row['openingDate']);
        $this->federationRegister->setDbValue($row['federationRegister']);
        $this->createUserId->setDbValue($row['createUserId']);
        $this->createDate->setDbValue($row['createDate']);
        $this->typeId->setDbValue($row['typeId']);
        $this->owner->setDbValue($row['owner']);
        $this->identityNumber->setDbValue($row['identityNumber']);
        $this->birthDateOwner->setDbValue($row['birthDateOwner']);
        $this->ownerCountryId->setDbValue($row['ownerCountryId']);
        if (array_key_exists('EV__ownerCountryId', $row)) {
            $this->ownerCountryId->VirtualValue = $row['EV__ownerCountryId']; // Set up virtual field value
        } else {
            $this->ownerCountryId->VirtualValue = ""; // Clear value
        }
        $this->ownerStateId->setDbValue($row['ownerStateId']);
        if (array_key_exists('EV__ownerStateId', $row)) {
            $this->ownerStateId->VirtualValue = $row['EV__ownerStateId']; // Set up virtual field value
        } else {
            $this->ownerStateId->VirtualValue = ""; // Clear value
        }
        $this->ownCityId->setDbValue($row['ownCityId']);
        if (array_key_exists('EV__ownCityId', $row)) {
            $this->ownCityId->VirtualValue = $row['EV__ownCityId']; // Set up virtual field value
        } else {
            $this->ownCityId->VirtualValue = ""; // Clear value
        }
        $this->ownerTelephone->setDbValue($row['ownerTelephone']);
        $this->ownerTelephoneWork->setDbValue($row['ownerTelephoneWork']);
        $this->ownerProfession->setDbValue($row['ownerProfession']);
        $this->employer->setDbValue($row['employer']);
        $this->ownerGraduation->setDbValue($row['ownerGraduation']);
        $this->ownerGraduationLocation->setDbValue($row['ownerGraduationLocation']);
        $this->ownerGraduationObs->setDbValue($row['ownerGraduationObs']);
        $this->ownerMaritalStatus->setDbValue($row['ownerMaritalStatus']);
        $this->ownerSpouseName->setDbValue($row['ownerSpouseName']);
        $this->ownerSpouseProfession->setDbValue($row['ownerSpouseProfession']);
        $this->propertySituation->setDbValue($row['propertySituation']);
        $this->numberOfStudentsInBeginnig->setDbValue($row['numberOfStudentsInBeginnig']);
        $this->ownerAbout->setDbValue($row['ownerAbout']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['federationId'] = $this->federationId->DefaultValue;
        $row['masterSchoolId'] = $this->masterSchoolId->DefaultValue;
        $row['school'] = $this->school->DefaultValue;
        $row['countryId'] = $this->countryId->DefaultValue;
        $row['UFId'] = $this->UFId->DefaultValue;
        $row['cityId'] = $this->cityId->DefaultValue;
        $row['neighborhood'] = $this->neighborhood->DefaultValue;
        $row['address'] = $this->address->DefaultValue;
        $row['zipcode'] = $this->zipcode->DefaultValue;
        $row['website'] = $this->website->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['phone'] = $this->phone->DefaultValue;
        $row['celphone'] = $this->celphone->DefaultValue;
        $row['logo'] = $this->logo->DefaultValue;
        $row['openingDate'] = $this->openingDate->DefaultValue;
        $row['federationRegister'] = $this->federationRegister->DefaultValue;
        $row['createUserId'] = $this->createUserId->DefaultValue;
        $row['createDate'] = $this->createDate->DefaultValue;
        $row['typeId'] = $this->typeId->DefaultValue;
        $row['owner'] = $this->owner->DefaultValue;
        $row['identityNumber'] = $this->identityNumber->DefaultValue;
        $row['birthDateOwner'] = $this->birthDateOwner->DefaultValue;
        $row['ownerCountryId'] = $this->ownerCountryId->DefaultValue;
        $row['ownerStateId'] = $this->ownerStateId->DefaultValue;
        $row['ownCityId'] = $this->ownCityId->DefaultValue;
        $row['ownerTelephone'] = $this->ownerTelephone->DefaultValue;
        $row['ownerTelephoneWork'] = $this->ownerTelephoneWork->DefaultValue;
        $row['ownerProfession'] = $this->ownerProfession->DefaultValue;
        $row['employer'] = $this->employer->DefaultValue;
        $row['ownerGraduation'] = $this->ownerGraduation->DefaultValue;
        $row['ownerGraduationLocation'] = $this->ownerGraduationLocation->DefaultValue;
        $row['ownerGraduationObs'] = $this->ownerGraduationObs->DefaultValue;
        $row['ownerMaritalStatus'] = $this->ownerMaritalStatus->DefaultValue;
        $row['ownerSpouseName'] = $this->ownerSpouseName->DefaultValue;
        $row['ownerSpouseProfession'] = $this->ownerSpouseProfession->DefaultValue;
        $row['propertySituation'] = $this->propertySituation->DefaultValue;
        $row['numberOfStudentsInBeginnig'] = $this->numberOfStudentsInBeginnig->DefaultValue;
        $row['ownerAbout'] = $this->ownerAbout->DefaultValue;
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

        // federationId
        $this->federationId->RowCssClass = "row";

        // masterSchoolId
        $this->masterSchoolId->RowCssClass = "row";

        // school
        $this->school->RowCssClass = "row";

        // countryId
        $this->countryId->RowCssClass = "row";

        // UFId
        $this->UFId->RowCssClass = "row";

        // cityId
        $this->cityId->RowCssClass = "row";

        // neighborhood
        $this->neighborhood->RowCssClass = "row";

        // address
        $this->address->RowCssClass = "row";

        // zipcode
        $this->zipcode->RowCssClass = "row";

        // website
        $this->website->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // celphone
        $this->celphone->RowCssClass = "row";

        // logo
        $this->logo->RowCssClass = "row";

        // openingDate
        $this->openingDate->RowCssClass = "row";

        // federationRegister
        $this->federationRegister->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // typeId
        $this->typeId->RowCssClass = "row";

        // owner
        $this->owner->RowCssClass = "row";

        // identityNumber
        $this->identityNumber->RowCssClass = "row";

        // birthDateOwner
        $this->birthDateOwner->RowCssClass = "row";

        // ownerCountryId
        $this->ownerCountryId->RowCssClass = "row";

        // ownerStateId
        $this->ownerStateId->RowCssClass = "row";

        // ownCityId
        $this->ownCityId->RowCssClass = "row";

        // ownerTelephone
        $this->ownerTelephone->RowCssClass = "row";

        // ownerTelephoneWork
        $this->ownerTelephoneWork->RowCssClass = "row";

        // ownerProfession
        $this->ownerProfession->RowCssClass = "row";

        // employer
        $this->employer->RowCssClass = "row";

        // ownerGraduation
        $this->ownerGraduation->RowCssClass = "row";

        // ownerGraduationLocation
        $this->ownerGraduationLocation->RowCssClass = "row";

        // ownerGraduationObs
        $this->ownerGraduationObs->RowCssClass = "row";

        // ownerMaritalStatus
        $this->ownerMaritalStatus->RowCssClass = "row";

        // ownerSpouseName
        $this->ownerSpouseName->RowCssClass = "row";

        // ownerSpouseProfession
        $this->ownerSpouseProfession->RowCssClass = "row";

        // propertySituation
        $this->propertySituation->RowCssClass = "row";

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->RowCssClass = "row";

        // ownerAbout
        $this->ownerAbout->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // federationId
            if ($this->federationId->VirtualValue != "") {
                $this->federationId->ViewValue = $this->federationId->VirtualValue;
            } else {
                $this->federationId->ViewValue = $this->federationId->CurrentValue;
                $curVal = strval($this->federationId->CurrentValue);
                if ($curVal != "") {
                    $this->federationId->ViewValue = $this->federationId->lookupCacheOption($curVal);
                    if ($this->federationId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->federationId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->federationId->Lookup->renderViewRow($rswrk[0]);
                            $this->federationId->ViewValue = $this->federationId->displayValue($arwrk);
                        } else {
                            $this->federationId->ViewValue = FormatNumber($this->federationId->CurrentValue, $this->federationId->formatPattern());
                        }
                    }
                } else {
                    $this->federationId->ViewValue = null;
                }
            }
            $this->federationId->ViewCustomAttributes = "";

            // masterSchoolId
            if ($this->masterSchoolId->VirtualValue != "") {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->VirtualValue;
            } else {
                $this->masterSchoolId->ViewValue = $this->masterSchoolId->CurrentValue;
                $curVal = strval($this->masterSchoolId->CurrentValue);
                if ($curVal != "") {
                    $this->masterSchoolId->ViewValue = $this->masterSchoolId->lookupCacheOption($curVal);
                    if ($this->masterSchoolId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`masterSchoolId`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->masterSchoolId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->masterSchoolId->Lookup->renderViewRow($rswrk[0]);
                            $this->masterSchoolId->ViewValue = $this->masterSchoolId->displayValue($arwrk);
                        } else {
                            $this->masterSchoolId->ViewValue = FormatNumber($this->masterSchoolId->CurrentValue, $this->masterSchoolId->formatPattern());
                        }
                    }
                } else {
                    $this->masterSchoolId->ViewValue = null;
                }
            }
            $this->masterSchoolId->ViewCustomAttributes = "";

            // school
            $this->school->ViewValue = $this->school->CurrentValue;
            $this->school->ViewCustomAttributes = "";

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

            // neighborhood
            $this->neighborhood->ViewValue = $this->neighborhood->CurrentValue;
            $this->neighborhood->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // zipcode
            $this->zipcode->ViewValue = $this->zipcode->CurrentValue;
            $this->zipcode->ViewCustomAttributes = "";

            // website
            $this->website->ViewValue = $this->website->CurrentValue;
            $this->website->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;
            $this->phone->ViewCustomAttributes = "";

            // celphone
            $this->celphone->ViewValue = $this->celphone->CurrentValue;
            $this->celphone->ViewCustomAttributes = "";

            // logo
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->ImageWidth = 120;
                $this->logo->ImageHeight = 120;
                $this->logo->ImageAlt = $this->logo->alt();
                $this->logo->ImageCssClass = "ew-image";
                $this->logo->ViewValue = $this->logo->Upload->DbValue;
            } else {
                $this->logo->ViewValue = "";
            }
            $this->logo->ViewCustomAttributes = "";

            // openingDate
            $this->openingDate->ViewValue = $this->openingDate->CurrentValue;
            $this->openingDate->ViewValue = FormatDateTime($this->openingDate->ViewValue, $this->openingDate->formatPattern());
            $this->openingDate->ViewCustomAttributes = "";

            // federationRegister
            $this->federationRegister->ViewValue = $this->federationRegister->CurrentValue;
            $this->federationRegister->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
            $this->createUserId->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // typeId
            $curVal = strval($this->typeId->CurrentValue);
            if ($curVal != "") {
                $this->typeId->ViewValue = $this->typeId->lookupCacheOption($curVal);
                if ($this->typeId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`id` = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->typeId->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->typeId->Lookup->renderViewRow($rswrk[0]);
                        $this->typeId->ViewValue = $this->typeId->displayValue($arwrk);
                    } else {
                        $this->typeId->ViewValue = FormatNumber($this->typeId->CurrentValue, $this->typeId->formatPattern());
                    }
                }
            } else {
                $this->typeId->ViewValue = null;
            }
            $this->typeId->ViewCustomAttributes = "";

            // owner
            $this->owner->ViewValue = $this->owner->CurrentValue;
            $this->owner->ViewCustomAttributes = "";

            // identityNumber
            $this->identityNumber->ViewValue = $this->identityNumber->CurrentValue;
            $this->identityNumber->ViewCustomAttributes = "";

            // birthDateOwner
            $this->birthDateOwner->ViewValue = $this->birthDateOwner->CurrentValue;
            $this->birthDateOwner->ViewValue = FormatDateTime($this->birthDateOwner->ViewValue, $this->birthDateOwner->formatPattern());
            $this->birthDateOwner->ViewCustomAttributes = "";

            // ownerCountryId
            if ($this->ownerCountryId->VirtualValue != "") {
                $this->ownerCountryId->ViewValue = $this->ownerCountryId->VirtualValue;
            } else {
                $curVal = strval($this->ownerCountryId->CurrentValue);
                if ($curVal != "") {
                    $this->ownerCountryId->ViewValue = $this->ownerCountryId->lookupCacheOption($curVal);
                    if ($this->ownerCountryId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->ownerCountryId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->ownerCountryId->Lookup->renderViewRow($rswrk[0]);
                            $this->ownerCountryId->ViewValue = $this->ownerCountryId->displayValue($arwrk);
                        } else {
                            $this->ownerCountryId->ViewValue = FormatNumber($this->ownerCountryId->CurrentValue, $this->ownerCountryId->formatPattern());
                        }
                    }
                } else {
                    $this->ownerCountryId->ViewValue = null;
                }
            }
            $this->ownerCountryId->ViewCustomAttributes = "";

            // ownerStateId
            if ($this->ownerStateId->VirtualValue != "") {
                $this->ownerStateId->ViewValue = $this->ownerStateId->VirtualValue;
            } else {
                $curVal = strval($this->ownerStateId->CurrentValue);
                if ($curVal != "") {
                    $this->ownerStateId->ViewValue = $this->ownerStateId->lookupCacheOption($curVal);
                    if ($this->ownerStateId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->ownerStateId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->ownerStateId->Lookup->renderViewRow($rswrk[0]);
                            $this->ownerStateId->ViewValue = $this->ownerStateId->displayValue($arwrk);
                        } else {
                            $this->ownerStateId->ViewValue = FormatNumber($this->ownerStateId->CurrentValue, $this->ownerStateId->formatPattern());
                        }
                    }
                } else {
                    $this->ownerStateId->ViewValue = null;
                }
            }
            $this->ownerStateId->ViewCustomAttributes = "";

            // ownCityId
            if ($this->ownCityId->VirtualValue != "") {
                $this->ownCityId->ViewValue = $this->ownCityId->VirtualValue;
            } else {
                $curVal = strval($this->ownCityId->CurrentValue);
                if ($curVal != "") {
                    $this->ownCityId->ViewValue = $this->ownCityId->lookupCacheOption($curVal);
                    if ($this->ownCityId->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->ownCityId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->ownCityId->Lookup->renderViewRow($rswrk[0]);
                            $this->ownCityId->ViewValue = $this->ownCityId->displayValue($arwrk);
                        } else {
                            $this->ownCityId->ViewValue = FormatNumber($this->ownCityId->CurrentValue, $this->ownCityId->formatPattern());
                        }
                    }
                } else {
                    $this->ownCityId->ViewValue = null;
                }
            }
            $this->ownCityId->ViewCustomAttributes = "";

            // ownerTelephone
            $this->ownerTelephone->ViewValue = $this->ownerTelephone->CurrentValue;
            $this->ownerTelephone->ViewCustomAttributes = "";

            // ownerTelephoneWork
            $this->ownerTelephoneWork->ViewValue = $this->ownerTelephoneWork->CurrentValue;
            $this->ownerTelephoneWork->ViewCustomAttributes = "";

            // ownerProfession
            $this->ownerProfession->ViewValue = $this->ownerProfession->CurrentValue;
            $this->ownerProfession->ViewCustomAttributes = "";

            // employer
            $this->employer->ViewValue = $this->employer->CurrentValue;
            $this->employer->ViewCustomAttributes = "";

            // ownerGraduation
            $curVal = strval($this->ownerGraduation->CurrentValue);
            if ($curVal != "") {
                $this->ownerGraduation->ViewValue = $this->ownerGraduation->lookupCacheOption($curVal);
                if ($this->ownerGraduation->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->ownerGraduation->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ownerGraduation->Lookup->renderViewRow($rswrk[0]);
                        $this->ownerGraduation->ViewValue = $this->ownerGraduation->displayValue($arwrk);
                    } else {
                        $this->ownerGraduation->ViewValue = FormatNumber($this->ownerGraduation->CurrentValue, $this->ownerGraduation->formatPattern());
                    }
                }
            } else {
                $this->ownerGraduation->ViewValue = null;
            }
            $this->ownerGraduation->ViewCustomAttributes = "";

            // ownerGraduationLocation
            $this->ownerGraduationLocation->ViewValue = $this->ownerGraduationLocation->CurrentValue;
            $this->ownerGraduationLocation->ViewCustomAttributes = "";

            // ownerGraduationObs
            $this->ownerGraduationObs->ViewValue = $this->ownerGraduationObs->CurrentValue;
            $this->ownerGraduationObs->ViewCustomAttributes = "";

            // ownerMaritalStatus
            if (strval($this->ownerMaritalStatus->CurrentValue) != "") {
                $this->ownerMaritalStatus->ViewValue = $this->ownerMaritalStatus->optionCaption($this->ownerMaritalStatus->CurrentValue);
            } else {
                $this->ownerMaritalStatus->ViewValue = null;
            }
            $this->ownerMaritalStatus->ViewCustomAttributes = "";

            // ownerSpouseName
            $this->ownerSpouseName->ViewValue = $this->ownerSpouseName->CurrentValue;
            $this->ownerSpouseName->ViewCustomAttributes = "";

            // ownerSpouseProfession
            $this->ownerSpouseProfession->ViewValue = $this->ownerSpouseProfession->CurrentValue;
            $this->ownerSpouseProfession->ViewCustomAttributes = "";

            // propertySituation
            if (strval($this->propertySituation->CurrentValue) != "") {
                $this->propertySituation->ViewValue = $this->propertySituation->optionCaption($this->propertySituation->CurrentValue);
            } else {
                $this->propertySituation->ViewValue = null;
            }
            $this->propertySituation->ViewCustomAttributes = "";

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->ViewValue = $this->numberOfStudentsInBeginnig->CurrentValue;
            $this->numberOfStudentsInBeginnig->ViewValue = FormatNumber($this->numberOfStudentsInBeginnig->ViewValue, $this->numberOfStudentsInBeginnig->formatPattern());
            $this->numberOfStudentsInBeginnig->ViewCustomAttributes = "";

            // ownerAbout
            $this->ownerAbout->ViewValue = $this->ownerAbout->CurrentValue;
            $this->ownerAbout->ViewCustomAttributes = "";

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // zipcode
            $this->zipcode->LinkCustomAttributes = "";
            $this->zipcode->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";

            // logo
            $this->logo->LinkCustomAttributes = "";
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->HrefValue = GetFileUploadUrl($this->logo, $this->logo->htmlDecode($this->logo->Upload->DbValue)); // Add prefix/suffix
                $this->logo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->logo->HrefValue = FullUrl($this->logo->HrefValue, "href");
                }
            } else {
                $this->logo->HrefValue = "";
            }
            $this->logo->ExportHrefValue = $this->logo->UploadPath . $this->logo->Upload->DbValue;

            // openingDate
            $this->openingDate->LinkCustomAttributes = "";
            $this->openingDate->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";

            // identityNumber
            $this->identityNumber->LinkCustomAttributes = "";
            $this->identityNumber->HrefValue = "";

            // birthDateOwner
            $this->birthDateOwner->LinkCustomAttributes = "";
            $this->birthDateOwner->HrefValue = "";

            // ownerCountryId
            $this->ownerCountryId->LinkCustomAttributes = "";
            $this->ownerCountryId->HrefValue = "";

            // ownerStateId
            $this->ownerStateId->LinkCustomAttributes = "";
            $this->ownerStateId->HrefValue = "";

            // ownCityId
            $this->ownCityId->LinkCustomAttributes = "";
            $this->ownCityId->HrefValue = "";

            // ownerTelephone
            $this->ownerTelephone->LinkCustomAttributes = "";
            $this->ownerTelephone->HrefValue = "";

            // ownerTelephoneWork
            $this->ownerTelephoneWork->LinkCustomAttributes = "";
            $this->ownerTelephoneWork->HrefValue = "";

            // ownerProfession
            $this->ownerProfession->LinkCustomAttributes = "";
            $this->ownerProfession->HrefValue = "";

            // employer
            $this->employer->LinkCustomAttributes = "";
            $this->employer->HrefValue = "";

            // ownerGraduation
            $this->ownerGraduation->LinkCustomAttributes = "";
            $this->ownerGraduation->HrefValue = "";

            // ownerGraduationLocation
            $this->ownerGraduationLocation->LinkCustomAttributes = "";
            $this->ownerGraduationLocation->HrefValue = "";

            // ownerGraduationObs
            $this->ownerGraduationObs->LinkCustomAttributes = "";
            $this->ownerGraduationObs->HrefValue = "";

            // ownerMaritalStatus
            $this->ownerMaritalStatus->LinkCustomAttributes = "";
            $this->ownerMaritalStatus->HrefValue = "";

            // ownerSpouseName
            $this->ownerSpouseName->LinkCustomAttributes = "";
            $this->ownerSpouseName->HrefValue = "";

            // ownerSpouseProfession
            $this->ownerSpouseProfession->LinkCustomAttributes = "";
            $this->ownerSpouseProfession->HrefValue = "";

            // propertySituation
            $this->propertySituation->LinkCustomAttributes = "";
            $this->propertySituation->HrefValue = "";

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->LinkCustomAttributes = "";
            $this->numberOfStudentsInBeginnig->HrefValue = "";

            // ownerAbout
            $this->ownerAbout->LinkCustomAttributes = "";
            $this->ownerAbout->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // school
            $this->school->setupEditAttributes();
            $this->school->EditCustomAttributes = "";
            if (!$this->school->Raw) {
                $this->school->CurrentValue = HtmlDecode($this->school->CurrentValue);
            }
            $this->school->EditValue = HtmlEncode($this->school->CurrentValue);
            $this->school->PlaceHolder = RemoveHtml($this->school->caption());

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

            // neighborhood
            $this->neighborhood->setupEditAttributes();
            $this->neighborhood->EditCustomAttributes = "";
            if (!$this->neighborhood->Raw) {
                $this->neighborhood->CurrentValue = HtmlDecode($this->neighborhood->CurrentValue);
            }
            $this->neighborhood->EditValue = HtmlEncode($this->neighborhood->CurrentValue);
            $this->neighborhood->PlaceHolder = RemoveHtml($this->neighborhood->caption());

            // address
            $this->address->setupEditAttributes();
            $this->address->EditCustomAttributes = "";
            if (!$this->address->Raw) {
                $this->address->CurrentValue = HtmlDecode($this->address->CurrentValue);
            }
            $this->address->EditValue = HtmlEncode($this->address->CurrentValue);
            $this->address->PlaceHolder = RemoveHtml($this->address->caption());

            // zipcode
            $this->zipcode->setupEditAttributes();
            $this->zipcode->EditCustomAttributes = "";
            if (!$this->zipcode->Raw) {
                $this->zipcode->CurrentValue = HtmlDecode($this->zipcode->CurrentValue);
            }
            $this->zipcode->EditValue = HtmlEncode($this->zipcode->CurrentValue);
            $this->zipcode->PlaceHolder = RemoveHtml($this->zipcode->caption());

            // website
            $this->website->setupEditAttributes();
            $this->website->EditCustomAttributes = "";
            if (!$this->website->Raw) {
                $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->CurrentValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // email
            $this->_email->setupEditAttributes();
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // phone
            $this->phone->setupEditAttributes();
            $this->phone->EditCustomAttributes = "";
            if (!$this->phone->Raw) {
                $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->CurrentValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // celphone
            $this->celphone->setupEditAttributes();
            $this->celphone->EditCustomAttributes = "";
            if (!$this->celphone->Raw) {
                $this->celphone->CurrentValue = HtmlDecode($this->celphone->CurrentValue);
            }
            $this->celphone->EditValue = HtmlEncode($this->celphone->CurrentValue);
            $this->celphone->PlaceHolder = RemoveHtml($this->celphone->caption());

            // logo
            $this->logo->setupEditAttributes();
            $this->logo->EditCustomAttributes = "";
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->ImageWidth = 120;
                $this->logo->ImageHeight = 120;
                $this->logo->ImageAlt = $this->logo->alt();
                $this->logo->ImageCssClass = "ew-image";
                $this->logo->EditValue = $this->logo->Upload->DbValue;
            } else {
                $this->logo->EditValue = "";
            }
            if (!EmptyValue($this->logo->CurrentValue)) {
                $this->logo->Upload->FileName = $this->logo->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->logo);
            }

            // openingDate
            $this->openingDate->setupEditAttributes();
            $this->openingDate->EditCustomAttributes = "";
            $this->openingDate->EditValue = HtmlEncode(FormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern()));
            $this->openingDate->PlaceHolder = RemoveHtml($this->openingDate->caption());

            // createUserId

            // owner
            $this->owner->setupEditAttributes();
            $this->owner->EditCustomAttributes = "";
            if (!$this->owner->Raw) {
                $this->owner->CurrentValue = HtmlDecode($this->owner->CurrentValue);
            }
            $this->owner->EditValue = HtmlEncode($this->owner->CurrentValue);
            $this->owner->PlaceHolder = RemoveHtml($this->owner->caption());

            // identityNumber
            $this->identityNumber->setupEditAttributes();
            $this->identityNumber->EditCustomAttributes = "";
            if (!$this->identityNumber->Raw) {
                $this->identityNumber->CurrentValue = HtmlDecode($this->identityNumber->CurrentValue);
            }
            $this->identityNumber->EditValue = HtmlEncode($this->identityNumber->CurrentValue);
            $this->identityNumber->PlaceHolder = RemoveHtml($this->identityNumber->caption());

            // birthDateOwner
            $this->birthDateOwner->setupEditAttributes();
            $this->birthDateOwner->EditCustomAttributes = "";
            $this->birthDateOwner->EditValue = HtmlEncode(FormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern()));
            $this->birthDateOwner->PlaceHolder = RemoveHtml($this->birthDateOwner->caption());

            // ownerCountryId
            $this->ownerCountryId->setupEditAttributes();
            $this->ownerCountryId->EditCustomAttributes = "";
            $curVal = trim(strval($this->ownerCountryId->CurrentValue));
            if ($curVal != "") {
                $this->ownerCountryId->ViewValue = $this->ownerCountryId->lookupCacheOption($curVal);
            } else {
                $this->ownerCountryId->ViewValue = $this->ownerCountryId->Lookup !== null && is_array($this->ownerCountryId->lookupOptions()) ? $curVal : null;
            }
            if ($this->ownerCountryId->ViewValue !== null) { // Load from cache
                $this->ownerCountryId->EditValue = array_values($this->ownerCountryId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->ownerCountryId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ownerCountryId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ownerCountryId->EditValue = $arwrk;
            }
            $this->ownerCountryId->PlaceHolder = RemoveHtml($this->ownerCountryId->caption());

            // ownerStateId
            $this->ownerStateId->setupEditAttributes();
            $this->ownerStateId->EditCustomAttributes = "";
            $curVal = trim(strval($this->ownerStateId->CurrentValue));
            if ($curVal != "") {
                $this->ownerStateId->ViewValue = $this->ownerStateId->lookupCacheOption($curVal);
            } else {
                $this->ownerStateId->ViewValue = $this->ownerStateId->Lookup !== null && is_array($this->ownerStateId->lookupOptions()) ? $curVal : null;
            }
            if ($this->ownerStateId->ViewValue !== null) { // Load from cache
                $this->ownerStateId->EditValue = array_values($this->ownerStateId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->ownerStateId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ownerStateId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ownerStateId->EditValue = $arwrk;
            }
            $this->ownerStateId->PlaceHolder = RemoveHtml($this->ownerStateId->caption());

            // ownCityId
            $this->ownCityId->setupEditAttributes();
            $this->ownCityId->EditCustomAttributes = "";
            $curVal = trim(strval($this->ownCityId->CurrentValue));
            if ($curVal != "") {
                $this->ownCityId->ViewValue = $this->ownCityId->lookupCacheOption($curVal);
            } else {
                $this->ownCityId->ViewValue = $this->ownCityId->Lookup !== null && is_array($this->ownCityId->lookupOptions()) ? $curVal : null;
            }
            if ($this->ownCityId->ViewValue !== null) { // Load from cache
                $this->ownCityId->EditValue = array_values($this->ownCityId->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->ownCityId->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ownCityId->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ownCityId->EditValue = $arwrk;
            }
            $this->ownCityId->PlaceHolder = RemoveHtml($this->ownCityId->caption());

            // ownerTelephone
            $this->ownerTelephone->setupEditAttributes();
            $this->ownerTelephone->EditCustomAttributes = "";
            if (!$this->ownerTelephone->Raw) {
                $this->ownerTelephone->CurrentValue = HtmlDecode($this->ownerTelephone->CurrentValue);
            }
            $this->ownerTelephone->EditValue = HtmlEncode($this->ownerTelephone->CurrentValue);
            $this->ownerTelephone->PlaceHolder = RemoveHtml($this->ownerTelephone->caption());

            // ownerTelephoneWork
            $this->ownerTelephoneWork->setupEditAttributes();
            $this->ownerTelephoneWork->EditCustomAttributes = "";
            if (!$this->ownerTelephoneWork->Raw) {
                $this->ownerTelephoneWork->CurrentValue = HtmlDecode($this->ownerTelephoneWork->CurrentValue);
            }
            $this->ownerTelephoneWork->EditValue = HtmlEncode($this->ownerTelephoneWork->CurrentValue);
            $this->ownerTelephoneWork->PlaceHolder = RemoveHtml($this->ownerTelephoneWork->caption());

            // ownerProfession
            $this->ownerProfession->setupEditAttributes();
            $this->ownerProfession->EditCustomAttributes = "";
            if (!$this->ownerProfession->Raw) {
                $this->ownerProfession->CurrentValue = HtmlDecode($this->ownerProfession->CurrentValue);
            }
            $this->ownerProfession->EditValue = HtmlEncode($this->ownerProfession->CurrentValue);
            $this->ownerProfession->PlaceHolder = RemoveHtml($this->ownerProfession->caption());

            // employer
            $this->employer->setupEditAttributes();
            $this->employer->EditCustomAttributes = "";
            if (!$this->employer->Raw) {
                $this->employer->CurrentValue = HtmlDecode($this->employer->CurrentValue);
            }
            $this->employer->EditValue = HtmlEncode($this->employer->CurrentValue);
            $this->employer->PlaceHolder = RemoveHtml($this->employer->caption());

            // ownerGraduation
            $this->ownerGraduation->setupEditAttributes();
            $this->ownerGraduation->EditCustomAttributes = "";
            $curVal = trim(strval($this->ownerGraduation->CurrentValue));
            if ($curVal != "") {
                $this->ownerGraduation->ViewValue = $this->ownerGraduation->lookupCacheOption($curVal);
            } else {
                $this->ownerGraduation->ViewValue = $this->ownerGraduation->Lookup !== null && is_array($this->ownerGraduation->lookupOptions()) ? $curVal : null;
            }
            if ($this->ownerGraduation->ViewValue !== null) { // Load from cache
                $this->ownerGraduation->EditValue = array_values($this->ownerGraduation->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->ownerGraduation->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->ownerGraduation->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->ownerGraduation->EditValue = $arwrk;
            }
            $this->ownerGraduation->PlaceHolder = RemoveHtml($this->ownerGraduation->caption());

            // ownerGraduationLocation
            $this->ownerGraduationLocation->setupEditAttributes();
            $this->ownerGraduationLocation->EditCustomAttributes = "";
            if (!$this->ownerGraduationLocation->Raw) {
                $this->ownerGraduationLocation->CurrentValue = HtmlDecode($this->ownerGraduationLocation->CurrentValue);
            }
            $this->ownerGraduationLocation->EditValue = HtmlEncode($this->ownerGraduationLocation->CurrentValue);
            $this->ownerGraduationLocation->PlaceHolder = RemoveHtml($this->ownerGraduationLocation->caption());

            // ownerGraduationObs
            $this->ownerGraduationObs->setupEditAttributes();
            $this->ownerGraduationObs->EditCustomAttributes = "";
            $this->ownerGraduationObs->EditValue = HtmlEncode($this->ownerGraduationObs->CurrentValue);
            $this->ownerGraduationObs->PlaceHolder = RemoveHtml($this->ownerGraduationObs->caption());

            // ownerMaritalStatus
            $this->ownerMaritalStatus->EditCustomAttributes = "";
            $this->ownerMaritalStatus->EditValue = $this->ownerMaritalStatus->options(false);
            $this->ownerMaritalStatus->PlaceHolder = RemoveHtml($this->ownerMaritalStatus->caption());

            // ownerSpouseName
            $this->ownerSpouseName->setupEditAttributes();
            $this->ownerSpouseName->EditCustomAttributes = "";
            if (!$this->ownerSpouseName->Raw) {
                $this->ownerSpouseName->CurrentValue = HtmlDecode($this->ownerSpouseName->CurrentValue);
            }
            $this->ownerSpouseName->EditValue = HtmlEncode($this->ownerSpouseName->CurrentValue);
            $this->ownerSpouseName->PlaceHolder = RemoveHtml($this->ownerSpouseName->caption());

            // ownerSpouseProfession
            $this->ownerSpouseProfession->setupEditAttributes();
            $this->ownerSpouseProfession->EditCustomAttributes = "";
            if (!$this->ownerSpouseProfession->Raw) {
                $this->ownerSpouseProfession->CurrentValue = HtmlDecode($this->ownerSpouseProfession->CurrentValue);
            }
            $this->ownerSpouseProfession->EditValue = HtmlEncode($this->ownerSpouseProfession->CurrentValue);
            $this->ownerSpouseProfession->PlaceHolder = RemoveHtml($this->ownerSpouseProfession->caption());

            // propertySituation
            $this->propertySituation->EditCustomAttributes = "";
            $this->propertySituation->EditValue = $this->propertySituation->options(false);
            $this->propertySituation->PlaceHolder = RemoveHtml($this->propertySituation->caption());

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->setupEditAttributes();
            $this->numberOfStudentsInBeginnig->EditCustomAttributes = "";
            $this->numberOfStudentsInBeginnig->EditValue = HtmlEncode($this->numberOfStudentsInBeginnig->CurrentValue);
            $this->numberOfStudentsInBeginnig->PlaceHolder = RemoveHtml($this->numberOfStudentsInBeginnig->caption());
            if (strval($this->numberOfStudentsInBeginnig->EditValue) != "" && is_numeric($this->numberOfStudentsInBeginnig->EditValue)) {
                $this->numberOfStudentsInBeginnig->EditValue = FormatNumber($this->numberOfStudentsInBeginnig->EditValue, null);
            }

            // ownerAbout
            $this->ownerAbout->setupEditAttributes();
            $this->ownerAbout->EditCustomAttributes = "";
            $this->ownerAbout->EditValue = HtmlEncode($this->ownerAbout->CurrentValue);
            $this->ownerAbout->PlaceHolder = RemoveHtml($this->ownerAbout->caption());

            // Add refer script

            // school
            $this->school->LinkCustomAttributes = "";
            $this->school->HrefValue = "";

            // countryId
            $this->countryId->LinkCustomAttributes = "";
            $this->countryId->HrefValue = "";

            // UFId
            $this->UFId->LinkCustomAttributes = "";
            $this->UFId->HrefValue = "";

            // cityId
            $this->cityId->LinkCustomAttributes = "";
            $this->cityId->HrefValue = "";

            // neighborhood
            $this->neighborhood->LinkCustomAttributes = "";
            $this->neighborhood->HrefValue = "";

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // zipcode
            $this->zipcode->LinkCustomAttributes = "";
            $this->zipcode->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // phone
            $this->phone->LinkCustomAttributes = "";
            $this->phone->HrefValue = "";

            // celphone
            $this->celphone->LinkCustomAttributes = "";
            $this->celphone->HrefValue = "";

            // logo
            $this->logo->LinkCustomAttributes = "";
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->HrefValue = GetFileUploadUrl($this->logo, $this->logo->htmlDecode($this->logo->Upload->DbValue)); // Add prefix/suffix
                $this->logo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->logo->HrefValue = FullUrl($this->logo->HrefValue, "href");
                }
            } else {
                $this->logo->HrefValue = "";
            }
            $this->logo->ExportHrefValue = $this->logo->UploadPath . $this->logo->Upload->DbValue;

            // openingDate
            $this->openingDate->LinkCustomAttributes = "";
            $this->openingDate->HrefValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";

            // owner
            $this->owner->LinkCustomAttributes = "";
            $this->owner->HrefValue = "";

            // identityNumber
            $this->identityNumber->LinkCustomAttributes = "";
            $this->identityNumber->HrefValue = "";

            // birthDateOwner
            $this->birthDateOwner->LinkCustomAttributes = "";
            $this->birthDateOwner->HrefValue = "";

            // ownerCountryId
            $this->ownerCountryId->LinkCustomAttributes = "";
            $this->ownerCountryId->HrefValue = "";

            // ownerStateId
            $this->ownerStateId->LinkCustomAttributes = "";
            $this->ownerStateId->HrefValue = "";

            // ownCityId
            $this->ownCityId->LinkCustomAttributes = "";
            $this->ownCityId->HrefValue = "";

            // ownerTelephone
            $this->ownerTelephone->LinkCustomAttributes = "";
            $this->ownerTelephone->HrefValue = "";

            // ownerTelephoneWork
            $this->ownerTelephoneWork->LinkCustomAttributes = "";
            $this->ownerTelephoneWork->HrefValue = "";

            // ownerProfession
            $this->ownerProfession->LinkCustomAttributes = "";
            $this->ownerProfession->HrefValue = "";

            // employer
            $this->employer->LinkCustomAttributes = "";
            $this->employer->HrefValue = "";

            // ownerGraduation
            $this->ownerGraduation->LinkCustomAttributes = "";
            $this->ownerGraduation->HrefValue = "";

            // ownerGraduationLocation
            $this->ownerGraduationLocation->LinkCustomAttributes = "";
            $this->ownerGraduationLocation->HrefValue = "";

            // ownerGraduationObs
            $this->ownerGraduationObs->LinkCustomAttributes = "";
            $this->ownerGraduationObs->HrefValue = "";

            // ownerMaritalStatus
            $this->ownerMaritalStatus->LinkCustomAttributes = "";
            $this->ownerMaritalStatus->HrefValue = "";

            // ownerSpouseName
            $this->ownerSpouseName->LinkCustomAttributes = "";
            $this->ownerSpouseName->HrefValue = "";

            // ownerSpouseProfession
            $this->ownerSpouseProfession->LinkCustomAttributes = "";
            $this->ownerSpouseProfession->HrefValue = "";

            // propertySituation
            $this->propertySituation->LinkCustomAttributes = "";
            $this->propertySituation->HrefValue = "";

            // numberOfStudentsInBeginnig
            $this->numberOfStudentsInBeginnig->LinkCustomAttributes = "";
            $this->numberOfStudentsInBeginnig->HrefValue = "";

            // ownerAbout
            $this->ownerAbout->LinkCustomAttributes = "";
            $this->ownerAbout->HrefValue = "";
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
        if ($this->school->Required) {
            if (!$this->school->IsDetailKey && EmptyValue($this->school->FormValue)) {
                $this->school->addErrorMessage(str_replace("%s", $this->school->caption(), $this->school->RequiredErrorMessage));
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
        if ($this->neighborhood->Required) {
            if (!$this->neighborhood->IsDetailKey && EmptyValue($this->neighborhood->FormValue)) {
                $this->neighborhood->addErrorMessage(str_replace("%s", $this->neighborhood->caption(), $this->neighborhood->RequiredErrorMessage));
            }
        }
        if ($this->address->Required) {
            if (!$this->address->IsDetailKey && EmptyValue($this->address->FormValue)) {
                $this->address->addErrorMessage(str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
            }
        }
        if ($this->zipcode->Required) {
            if (!$this->zipcode->IsDetailKey && EmptyValue($this->zipcode->FormValue)) {
                $this->zipcode->addErrorMessage(str_replace("%s", $this->zipcode->caption(), $this->zipcode->RequiredErrorMessage));
            }
        }
        if ($this->website->Required) {
            if (!$this->website->IsDetailKey && EmptyValue($this->website->FormValue)) {
                $this->website->addErrorMessage(str_replace("%s", $this->website->caption(), $this->website->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->phone->Required) {
            if (!$this->phone->IsDetailKey && EmptyValue($this->phone->FormValue)) {
                $this->phone->addErrorMessage(str_replace("%s", $this->phone->caption(), $this->phone->RequiredErrorMessage));
            }
        }
        if ($this->celphone->Required) {
            if (!$this->celphone->IsDetailKey && EmptyValue($this->celphone->FormValue)) {
                $this->celphone->addErrorMessage(str_replace("%s", $this->celphone->caption(), $this->celphone->RequiredErrorMessage));
            }
        }
        if ($this->logo->Required) {
            if ($this->logo->Upload->FileName == "" && !$this->logo->Upload->KeepFile) {
                $this->logo->addErrorMessage(str_replace("%s", $this->logo->caption(), $this->logo->RequiredErrorMessage));
            }
        }
        if ($this->openingDate->Required) {
            if (!$this->openingDate->IsDetailKey && EmptyValue($this->openingDate->FormValue)) {
                $this->openingDate->addErrorMessage(str_replace("%s", $this->openingDate->caption(), $this->openingDate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->openingDate->FormValue, $this->openingDate->formatPattern())) {
            $this->openingDate->addErrorMessage($this->openingDate->getErrorMessage(false));
        }
        if ($this->createUserId->Required) {
            if (!$this->createUserId->IsDetailKey && EmptyValue($this->createUserId->FormValue)) {
                $this->createUserId->addErrorMessage(str_replace("%s", $this->createUserId->caption(), $this->createUserId->RequiredErrorMessage));
            }
        }
        if ($this->owner->Required) {
            if (!$this->owner->IsDetailKey && EmptyValue($this->owner->FormValue)) {
                $this->owner->addErrorMessage(str_replace("%s", $this->owner->caption(), $this->owner->RequiredErrorMessage));
            }
        }
        if ($this->identityNumber->Required) {
            if (!$this->identityNumber->IsDetailKey && EmptyValue($this->identityNumber->FormValue)) {
                $this->identityNumber->addErrorMessage(str_replace("%s", $this->identityNumber->caption(), $this->identityNumber->RequiredErrorMessage));
            }
        }
        if ($this->birthDateOwner->Required) {
            if (!$this->birthDateOwner->IsDetailKey && EmptyValue($this->birthDateOwner->FormValue)) {
                $this->birthDateOwner->addErrorMessage(str_replace("%s", $this->birthDateOwner->caption(), $this->birthDateOwner->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->birthDateOwner->FormValue, $this->birthDateOwner->formatPattern())) {
            $this->birthDateOwner->addErrorMessage($this->birthDateOwner->getErrorMessage(false));
        }
        if ($this->ownerCountryId->Required) {
            if (!$this->ownerCountryId->IsDetailKey && EmptyValue($this->ownerCountryId->FormValue)) {
                $this->ownerCountryId->addErrorMessage(str_replace("%s", $this->ownerCountryId->caption(), $this->ownerCountryId->RequiredErrorMessage));
            }
        }
        if ($this->ownerStateId->Required) {
            if (!$this->ownerStateId->IsDetailKey && EmptyValue($this->ownerStateId->FormValue)) {
                $this->ownerStateId->addErrorMessage(str_replace("%s", $this->ownerStateId->caption(), $this->ownerStateId->RequiredErrorMessage));
            }
        }
        if ($this->ownCityId->Required) {
            if (!$this->ownCityId->IsDetailKey && EmptyValue($this->ownCityId->FormValue)) {
                $this->ownCityId->addErrorMessage(str_replace("%s", $this->ownCityId->caption(), $this->ownCityId->RequiredErrorMessage));
            }
        }
        if ($this->ownerTelephone->Required) {
            if (!$this->ownerTelephone->IsDetailKey && EmptyValue($this->ownerTelephone->FormValue)) {
                $this->ownerTelephone->addErrorMessage(str_replace("%s", $this->ownerTelephone->caption(), $this->ownerTelephone->RequiredErrorMessage));
            }
        }
        if ($this->ownerTelephoneWork->Required) {
            if (!$this->ownerTelephoneWork->IsDetailKey && EmptyValue($this->ownerTelephoneWork->FormValue)) {
                $this->ownerTelephoneWork->addErrorMessage(str_replace("%s", $this->ownerTelephoneWork->caption(), $this->ownerTelephoneWork->RequiredErrorMessage));
            }
        }
        if ($this->ownerProfession->Required) {
            if (!$this->ownerProfession->IsDetailKey && EmptyValue($this->ownerProfession->FormValue)) {
                $this->ownerProfession->addErrorMessage(str_replace("%s", $this->ownerProfession->caption(), $this->ownerProfession->RequiredErrorMessage));
            }
        }
        if ($this->employer->Required) {
            if (!$this->employer->IsDetailKey && EmptyValue($this->employer->FormValue)) {
                $this->employer->addErrorMessage(str_replace("%s", $this->employer->caption(), $this->employer->RequiredErrorMessage));
            }
        }
        if ($this->ownerGraduation->Required) {
            if (!$this->ownerGraduation->IsDetailKey && EmptyValue($this->ownerGraduation->FormValue)) {
                $this->ownerGraduation->addErrorMessage(str_replace("%s", $this->ownerGraduation->caption(), $this->ownerGraduation->RequiredErrorMessage));
            }
        }
        if ($this->ownerGraduationLocation->Required) {
            if (!$this->ownerGraduationLocation->IsDetailKey && EmptyValue($this->ownerGraduationLocation->FormValue)) {
                $this->ownerGraduationLocation->addErrorMessage(str_replace("%s", $this->ownerGraduationLocation->caption(), $this->ownerGraduationLocation->RequiredErrorMessage));
            }
        }
        if ($this->ownerGraduationObs->Required) {
            if (!$this->ownerGraduationObs->IsDetailKey && EmptyValue($this->ownerGraduationObs->FormValue)) {
                $this->ownerGraduationObs->addErrorMessage(str_replace("%s", $this->ownerGraduationObs->caption(), $this->ownerGraduationObs->RequiredErrorMessage));
            }
        }
        if ($this->ownerMaritalStatus->Required) {
            if ($this->ownerMaritalStatus->FormValue == "") {
                $this->ownerMaritalStatus->addErrorMessage(str_replace("%s", $this->ownerMaritalStatus->caption(), $this->ownerMaritalStatus->RequiredErrorMessage));
            }
        }
        if ($this->ownerSpouseName->Required) {
            if (!$this->ownerSpouseName->IsDetailKey && EmptyValue($this->ownerSpouseName->FormValue)) {
                $this->ownerSpouseName->addErrorMessage(str_replace("%s", $this->ownerSpouseName->caption(), $this->ownerSpouseName->RequiredErrorMessage));
            }
        }
        if ($this->ownerSpouseProfession->Required) {
            if (!$this->ownerSpouseProfession->IsDetailKey && EmptyValue($this->ownerSpouseProfession->FormValue)) {
                $this->ownerSpouseProfession->addErrorMessage(str_replace("%s", $this->ownerSpouseProfession->caption(), $this->ownerSpouseProfession->RequiredErrorMessage));
            }
        }
        if ($this->propertySituation->Required) {
            if ($this->propertySituation->FormValue == "") {
                $this->propertySituation->addErrorMessage(str_replace("%s", $this->propertySituation->caption(), $this->propertySituation->RequiredErrorMessage));
            }
        }
        if ($this->numberOfStudentsInBeginnig->Required) {
            if (!$this->numberOfStudentsInBeginnig->IsDetailKey && EmptyValue($this->numberOfStudentsInBeginnig->FormValue)) {
                $this->numberOfStudentsInBeginnig->addErrorMessage(str_replace("%s", $this->numberOfStudentsInBeginnig->caption(), $this->numberOfStudentsInBeginnig->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->numberOfStudentsInBeginnig->FormValue)) {
            $this->numberOfStudentsInBeginnig->addErrorMessage($this->numberOfStudentsInBeginnig->getErrorMessage(false));
        }
        if ($this->ownerAbout->Required) {
            if (!$this->ownerAbout->IsDetailKey && EmptyValue($this->ownerAbout->FormValue)) {
                $this->ownerAbout->addErrorMessage(str_replace("%s", $this->ownerAbout->caption(), $this->ownerAbout->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("FedSchoolGrid");
        if (in_array("fed_school", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("FedLicenseschoolGrid");
        if (in_array("fed_licenseschool", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // school
        $this->school->setDbValueDef($rsnew, $this->school->CurrentValue, null, false);

        // countryId
        $this->countryId->setDbValueDef($rsnew, $this->countryId->CurrentValue, null, false);

        // UFId
        $this->UFId->setDbValueDef($rsnew, $this->UFId->CurrentValue, null, false);

        // cityId
        $this->cityId->setDbValueDef($rsnew, $this->cityId->CurrentValue, null, false);

        // neighborhood
        $this->neighborhood->setDbValueDef($rsnew, $this->neighborhood->CurrentValue, null, false);

        // address
        $this->address->setDbValueDef($rsnew, $this->address->CurrentValue, null, false);

        // zipcode
        $this->zipcode->setDbValueDef($rsnew, $this->zipcode->CurrentValue, null, false);

        // website
        $this->website->setDbValueDef($rsnew, $this->website->CurrentValue, null, false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // phone
        $this->phone->setDbValueDef($rsnew, $this->phone->CurrentValue, null, false);

        // celphone
        $this->celphone->setDbValueDef($rsnew, $this->celphone->CurrentValue, null, false);

        // logo
        if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
            $this->logo->Upload->DbValue = ""; // No need to delete old file
            if ($this->logo->Upload->FileName == "") {
                $rsnew['logo'] = null;
            } else {
                $rsnew['logo'] = $this->logo->Upload->FileName;
            }
        }

        // openingDate
        $this->openingDate->setDbValueDef($rsnew, UnFormatDateTime($this->openingDate->CurrentValue, $this->openingDate->formatPattern()), null, false);

        // createUserId
        $this->createUserId->CurrentValue = GetLoggedUserID();
        $this->createUserId->setDbValueDef($rsnew, $this->createUserId->CurrentValue, null);

        // owner
        $this->owner->setDbValueDef($rsnew, $this->owner->CurrentValue, null, false);

        // identityNumber
        $this->identityNumber->setDbValueDef($rsnew, $this->identityNumber->CurrentValue, null, false);

        // birthDateOwner
        $this->birthDateOwner->setDbValueDef($rsnew, UnFormatDateTime($this->birthDateOwner->CurrentValue, $this->birthDateOwner->formatPattern()), null, false);

        // ownerCountryId
        $this->ownerCountryId->setDbValueDef($rsnew, $this->ownerCountryId->CurrentValue, null, false);

        // ownerStateId
        $this->ownerStateId->setDbValueDef($rsnew, $this->ownerStateId->CurrentValue, null, false);

        // ownCityId
        $this->ownCityId->setDbValueDef($rsnew, $this->ownCityId->CurrentValue, null, false);

        // ownerTelephone
        $this->ownerTelephone->setDbValueDef($rsnew, $this->ownerTelephone->CurrentValue, null, false);

        // ownerTelephoneWork
        $this->ownerTelephoneWork->setDbValueDef($rsnew, $this->ownerTelephoneWork->CurrentValue, null, false);

        // ownerProfession
        $this->ownerProfession->setDbValueDef($rsnew, $this->ownerProfession->CurrentValue, null, false);

        // employer
        $this->employer->setDbValueDef($rsnew, $this->employer->CurrentValue, null, false);

        // ownerGraduation
        $this->ownerGraduation->setDbValueDef($rsnew, $this->ownerGraduation->CurrentValue, null, false);

        // ownerGraduationLocation
        $this->ownerGraduationLocation->setDbValueDef($rsnew, $this->ownerGraduationLocation->CurrentValue, null, false);

        // ownerGraduationObs
        $this->ownerGraduationObs->setDbValueDef($rsnew, $this->ownerGraduationObs->CurrentValue, null, false);

        // ownerMaritalStatus
        $this->ownerMaritalStatus->setDbValueDef($rsnew, $this->ownerMaritalStatus->CurrentValue, null, false);

        // ownerSpouseName
        $this->ownerSpouseName->setDbValueDef($rsnew, $this->ownerSpouseName->CurrentValue, null, false);

        // ownerSpouseProfession
        $this->ownerSpouseProfession->setDbValueDef($rsnew, $this->ownerSpouseProfession->CurrentValue, null, false);

        // propertySituation
        $this->propertySituation->setDbValueDef($rsnew, $this->propertySituation->CurrentValue, null, false);

        // numberOfStudentsInBeginnig
        $this->numberOfStudentsInBeginnig->setDbValueDef($rsnew, $this->numberOfStudentsInBeginnig->CurrentValue, null, false);

        // ownerAbout
        $this->ownerAbout->setDbValueDef($rsnew, $this->ownerAbout->CurrentValue, null, false);
        if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->logo->Upload->DbValue) ? [] : [$this->logo->htmlDecode($this->logo->Upload->DbValue)];
            if (!EmptyValue($this->logo->Upload->FileName)) {
                $newFiles = [$this->logo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->logo, $this->logo->Upload->Index);
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
                            $file1 = UniqueFilename($this->logo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->logo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->logo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->logo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->logo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->logo->setDbValueDef($rsnew, $this->logo->Upload->FileName, null, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->logo->Upload->DbValue) ? [] : [$this->logo->htmlDecode($this->logo->Upload->DbValue)];
                    if (!EmptyValue($this->logo->Upload->FileName)) {
                        $newFiles = [$this->logo->Upload->FileName];
                        $newFiles2 = [$this->logo->htmlDecode($rsnew['logo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->logo, $this->logo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->logo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->logo->oldPhysicalUploadPath() . $oldFile);
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("FedSchoolGrid");
            if (in_array("fed_school", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->applicationId->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "fed_school"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->applicationId->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("FedLicenseschoolGrid");
            if (in_array("fed_licenseschool", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->application->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "fed_licenseschool"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->application->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    $conn->commit();
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    $conn->rollback();
                }
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // logo
            CleanUploadTempPath($this->logo, $this->logo->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("fed_school", $detailTblVar)) {
                $detailPageObj = Container("FedSchoolGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->applicationId->IsDetailKey = true;
                    $detailPageObj->applicationId->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->applicationId->setSessionValue($detailPageObj->applicationId->CurrentValue);
                }
            }
            if (in_array("fed_licenseschool", $detailTblVar)) {
                $detailPageObj = Container("FedLicenseschoolGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->application->IsDetailKey = true;
                    $detailPageObj->application->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->application->setSessionValue($detailPageObj->application->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FedApplicationschoolList"), "", $this->TableVar, true);
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
        $this->MultiPages = $pages;
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('fed_school');
        $pages->add('fed_licenseschool');
        $this->DetailPages = $pages;
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
                case "x_federationId":
                    break;
                case "x_masterSchoolId":
                    break;
                case "x_countryId":
                    break;
                case "x_UFId":
                    break;
                case "x_cityId":
                    break;
                case "x_typeId":
                    $lookupFilter = function () {
                        return "`id` = 5";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_ownerCountryId":
                    break;
                case "x_ownerStateId":
                    break;
                case "x_ownCityId":
                    break;
                case "x_ownerGraduation":
                    break;
                case "x_ownerMaritalStatus":
                    break;
                case "x_propertySituation":
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
