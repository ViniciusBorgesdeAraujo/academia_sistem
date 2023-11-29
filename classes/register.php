<?php
namespace PHPMaker2020\sistema;

/**
 * Page class
 */
class register extends pessoa
{

	// Page ID
	public $PageID = "register";

	// Project ID
	public $ProjectID = "{448C0B4B-C32A-40EF-8151-41E96F03E813}";

	// Page object name
	public $PageObjName = "register";

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken;

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading != "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading != "")
			return $this->Subheading;
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		return $url;
	}

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = TRUE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message != "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fas fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage != "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fas fa-exclamation"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage != "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fas fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage != "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fas fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = [];

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message != "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage != "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage != "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage != "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header != "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer != "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(Config("TOKEN_NAME")) === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn(Post(Config("TOKEN_NAME")), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = Config("CREATE_TOKEN_FUNC"); // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $DashboardReport;
		global $UserTable;

		// Check token
		$this->CheckToken = Config("CHECK_TOKEN");

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (pessoa)
		if (!isset($GLOBALS["pessoa"]) || get_class($GLOBALS["pessoa"]) == PROJECT_NAMESPACE . "pessoa") {
			$GLOBALS["pessoa"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pessoa"];
		}
		if (!isset($GLOBALS["pessoa"]))
			$GLOBALS["pessoa"] = new pessoa();

		// Table object (aulas)
		if (!isset($GLOBALS['aulas']))
			$GLOBALS['aulas'] = new aulas();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'register');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = $this->getConnection();

		// User table object (pessoa)
		$UserTable = $UserTable ?: new pessoa();
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url != "") {
			if (!Config("DEBUG") && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url];
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = [];
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
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
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									Config("API_FIELD_NAME") . "=" . $fld->Param . "&" .
									Config("API_KEY_NAME") . "=" . rawurlencode($this->getRecordKeyValue($ar)))); //*** need to add this? API may not be in the same folder
								$row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									"fn=" . Encrypt($fld->physicalUploadPath() . $val)));
								$row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
							} else { // Multiple files
								$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
								$ar = [];
								foreach ($files as $file) {
									$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
										Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
										"fn=" . Encrypt($fld->physicalUploadPath() . $file)));
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
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
			$key .= @$ar['idpessoa'];
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
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->idpessoa->Visible = FALSE;
	}

	// Lookup data
	public function lookup()
	{
		global $Language, $Security;
		if (!isset($Language))
			$Language = new Language(Config("LANGUAGE_FOLDER"), Post("language", ""));

		// Set up API request
		if (!ValidApiRequest())
			return FALSE;
		$this->setupApiSecurity();

		// Get lookup object
		$fieldName = Post("field");
		if (!array_key_exists($fieldName, $this->fields))
			return FALSE;
		$lookupField = $this->fields[$fieldName];
		$lookup = $lookupField->Lookup;
		if ($lookup === NULL)
			return FALSE;
		$tbl = $lookup->getTable();
		if (!$Security->allowLookup(Config("PROJECT_ID") . $tbl->TableName)) // Lookup permission
			return FALSE;

		// Get lookup parameters
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Param("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
			$lookup->FilterFields = []; // Skip parent fields if any
			$lookup->FilterValues[] = $keys; // Lookup values
			$pageSize = -1; // Show all records
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect != "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter != "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy != "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson($this); // Use settings from current page
	}

	// Set up API security
	public function setupApiSecurity()
	{
		global $Security;

		// Setup security for API request
		if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
		$Security->loadCurrentUserLevel(Config("PROJECT_ID") . $this->TableName);
		if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
		$Security->UserID_Loading();
		$Security->loadUserID();
		$Security->UserID_Loaded();
	}
	public $FormClassName = "ew-horizontal ew-form ew-register-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$UserTable, $CurrentLanguage, $FormError, $Breadcrumb, $SkipHeaderFooter;

		// Is modal
		$this->IsModal = (Param("modal") == "1");

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (ValidApiRequest()) { // API request
			$this->setupApiSecurity(); // Set up API Security
		} else {
			$Security = new AdvancedSecurity();
		}

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-register-form ew-horizontal";

		// Set up Breadcrumb
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb = new Breadcrumb();
		$Breadcrumb->add("register", "RegisterPage", $url, "", "", TRUE);
		$this->Heading = $Language->phrase("RegisterPage");
		$userExists = FALSE;
		$this->loadRowValues(); // Load default values

		// Get action
		$action = "";
		if (IsApi())
			$action = "insert";
		elseif (Post("action") != "")
			$action = Post("action");

		// Check action
		if ($action != "") {

			// Get action
			$this->CurrentAction = $action;
			$this->loadFormValues(); // Get form values

			// Validate form
			if (!$this->validateForm()) {
				$this->setFailureMessage($FormError);
				if (IsApi()) {
					$this->terminate();
					return;
				} else {
					$this->CurrentAction = "show"; // Form error, reset action
				}
			}
		} else {
			$this->CurrentAction = "show"; // Display blank record
		}

		// Handle email activation
		if (Get("action") != "") {
			$action = Get("action");
			$userName = Get("user");
			$code = Get("activatetoken");
			@list($emailAddress, $approvalCode, $pwd) = explode(",", $code, 3);
			$emailAddress = Decrypt($emailAddress);
			$approvalCode = Decrypt($approvalCode);
			$pwd = Decrypt($pwd);
			if ($userName == $approvalCode) {
				if (SameText($action, "confirm")) { // Email activation
					if ($this->activateUser($userName)) { // Activate this user
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->phrase("ActivateAccount")); // Set up message acount activated
						if ($Security->validateUser($userName, $pwd, TRUE)) {
							$this->terminate("index.php"); // Go to return page
						} else {
							$this->setFailureMessage($Language->phrase("AutoLoginFailed")); // Set auto login failed message
							$this->terminate("login.php"); // Go to login page
						}
					}
				}
			}
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("ActivateFailed")); // Set activate failed message
			$this->terminate("login.php"); // Go to login page
		}

		// Insert record
		if ($this->isInsert()) {

			// Check for duplicate User ID
			$filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $this->Nome->CurrentValue);

			// Set up filter (WHERE Clause)
			$this->CurrentFilter = $filter;
			$userSql = $this->getCurrentSql();
			if ($rs = Conn($UserTable->Dbid)->execute($userSql)) {
				if (!$rs->EOF) {
					$userExists = TRUE;
					$this->restoreFormValues(); // Restore form values
					$this->setFailureMessage($Language->phrase("UserExists")); // Set user exist message
				}
				$rs->Close();
			}
			if (!$userExists) {
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->addRow()) { // Add record
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("RegisterSuccessActivate")); // Activate success
					if (IsApi()) { // Return to caller
						$this->terminate(TRUE);
						return;
					} else {
						$this->terminate("index.php"); // Return
					}
				} elseif (IsApi()) { // API request, return
					$this->terminate();
					return;
				} else {
					$this->restoreFormValues(); // Restore form values
				}
			} elseif (IsApi()) { // API request, return
				$this->terminate();
				return;
			}
		}

		// Render row
		if ($this->isConfirm()) { // Confirm page
			$this->RowType = ROWTYPE_VIEW; // Render view
		} else {
			$this->RowType = ROWTYPE_ADD; // Render add
		}
		$this->resetAttributes();
		$this->renderRow();
	}

	// Activate account based on user
	protected function activateUser($usr)
	{
		global $UserTable, $Language;
		$filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);
		$sql = $this->getSql($filter);
		$conn = Conn($UserTable->Dbid);
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if (!$rs)
			return FALSE;
		if (!$rs->EOF) {
			$rsnew = $rs->fields;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
			$rsact = [Config("REGISTER_ACTIVATE_FIELD_NAME") => 1]; // Auto register
			$this->CurrentFilter = $filter;
			$res = $this->update($rsact);
			if ($res) { // Call User Activated event
				$rsnew[Config("REGISTER_ACTIVATE_FIELD_NAME")] = 1;
				$this->User_Activated($rsnew);
			}
			return $res;
		} else {
			$this->setFailureMessage($Language->phrase("NoRecord"));
			$rs->close();
			return FALSE;
		}
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idpessoa->CurrentValue = NULL;
		$this->idpessoa->OldValue = $this->idpessoa->CurrentValue;
		$this->idaula->CurrentValue = NULL;
		$this->idaula->OldValue = $this->idaula->CurrentValue;
		$this->Nome->CurrentValue = NULL;
		$this->Nome->OldValue = $this->Nome->CurrentValue;
		$this->CPF->CurrentValue = NULL;
		$this->CPF->OldValue = $this->CPF->CurrentValue;
		$this->Senha->CurrentValue = NULL;
		$this->Senha->OldValue = $this->Senha->CurrentValue;
		$this->Sexo->CurrentValue = NULL;
		$this->Sexo->OldValue = $this->Sexo->CurrentValue;
		$this->datanascimento->CurrentValue = NULL;
		$this->datanascimento->OldValue = $this->datanascimento->CurrentValue;
		$this->Funcao->CurrentValue = 0;
		$this->Sessao->CurrentValue = NULL;
		$this->Sessao->OldValue = $this->Sessao->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
		$this->Ativado->CurrentValue = NULL;
		$this->Ativado->OldValue = $this->Ativado->CurrentValue;
		$this->datadecadastro->CurrentValue = NULL;
		$this->datadecadastro->OldValue = $this->datadecadastro->CurrentValue;
		$this->Idade->CurrentValue = NULL;
		$this->Idade->OldValue = $this->Idade->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'Nome' first before field var 'x_Nome'
		$val = $CurrentForm->hasValue("Nome") ? $CurrentForm->getValue("Nome") : $CurrentForm->getValue("x_Nome");
		if (!$this->Nome->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Nome->Visible = FALSE; // Disable update for API request
			else
				$this->Nome->setFormValue($val);
		}

		// Check field name 'CPF' first before field var 'x_CPF'
		$val = $CurrentForm->hasValue("CPF") ? $CurrentForm->getValue("CPF") : $CurrentForm->getValue("x_CPF");
		if (!$this->CPF->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->CPF->Visible = FALSE; // Disable update for API request
			else
				$this->CPF->setFormValue($val);
		}

		// Check field name 'Senha' first before field var 'x_Senha'
		$val = $CurrentForm->hasValue("Senha") ? $CurrentForm->getValue("Senha") : $CurrentForm->getValue("x_Senha");
		if (!$this->Senha->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Senha->Visible = FALSE; // Disable update for API request
			else
				if (Config("ENCRYPTED_PASSWORD")) // Encrypted password, use raw value
					$this->Senha->setRawFormValue($val);
				else
					$this->Senha->setFormValue($val);
		}

		// Note: ConfirmValue will be compared with FormValue
		if (Config("ENCRYPTED_PASSWORD")) // Encrypted password, use raw value
			$this->Senha->ConfirmValue = $CurrentForm->getValue("c_Senha");
		else
			$this->Senha->ConfirmValue = RemoveXss($CurrentForm->getValue("c_Senha"));

		// Check field name 'Sexo' first before field var 'x_Sexo'
		$val = $CurrentForm->hasValue("Sexo") ? $CurrentForm->getValue("Sexo") : $CurrentForm->getValue("x_Sexo");
		if (!$this->Sexo->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Sexo->Visible = FALSE; // Disable update for API request
			else
				$this->Sexo->setFormValue($val);
		}

		// Check field name 'datanascimento' first before field var 'x_datanascimento'
		$val = $CurrentForm->hasValue("datanascimento") ? $CurrentForm->getValue("datanascimento") : $CurrentForm->getValue("x_datanascimento");
		if (!$this->datanascimento->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->datanascimento->Visible = FALSE; // Disable update for API request
			else
				$this->datanascimento->setFormValue($val);
			$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		}

		// Check field name 'Email' first before field var 'x__Email'
		$val = $CurrentForm->hasValue("Email") ? $CurrentForm->getValue("Email") : $CurrentForm->getValue("x__Email");
		if (!$this->_Email->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->_Email->Visible = FALSE; // Disable update for API request
			else
				$this->_Email->setFormValue($val);
		}

		// Check field name 'idpessoa' first before field var 'x_idpessoa'
		$val = $CurrentForm->hasValue("idpessoa") ? $CurrentForm->getValue("idpessoa") : $CurrentForm->getValue("x_idpessoa");
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->Nome->CurrentValue = $this->Nome->FormValue;
		$this->CPF->CurrentValue = $this->CPF->FormValue;
		$this->Senha->CurrentValue = $this->Senha->FormValue;
		$this->Sexo->CurrentValue = $this->Sexo->FormValue;
		$this->datanascimento->CurrentValue = $this->datanascimento->FormValue;
		$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		$this->_Email->CurrentValue = $this->_Email->FormValue;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->idpessoa->setDbValue($row['idpessoa']);
		$this->idaula->setDbValue($row['idaula']);
		$this->Nome->setDbValue($row['Nome']);
		$this->CPF->setDbValue($row['CPF']);
		$this->Senha->setDbValue($row['Senha']);
		$this->Sexo->setDbValue($row['Sexo']);
		$this->datanascimento->setDbValue($row['datanascimento']);
		$this->Funcao->setDbValue($row['Funcao']);
		$this->Sessao->setDbValue($row['Sessao']);
		$this->_Email->setDbValue($row['Email']);
		$this->Ativado->setDbValue($row['Ativado']);
		$this->datadecadastro->setDbValue($row['datadecadastro']);
		$this->Idade->setDbValue($row['Idade']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idpessoa'] = $this->idpessoa->CurrentValue;
		$row['idaula'] = $this->idaula->CurrentValue;
		$row['Nome'] = $this->Nome->CurrentValue;
		$row['CPF'] = $this->CPF->CurrentValue;
		$row['Senha'] = $this->Senha->CurrentValue;
		$row['Sexo'] = $this->Sexo->CurrentValue;
		$row['datanascimento'] = $this->datanascimento->CurrentValue;
		$row['Funcao'] = $this->Funcao->CurrentValue;
		$row['Sessao'] = $this->Sessao->CurrentValue;
		$row['Email'] = $this->_Email->CurrentValue;
		$row['Ativado'] = $this->Ativado->CurrentValue;
		$row['datadecadastro'] = $this->datadecadastro->CurrentValue;
		$row['Idade'] = $this->Idade->CurrentValue;
		return $row;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idpessoa
		// idaula
		// Nome
		// CPF
		// Senha
		// Sexo
		// datanascimento
		// Funcao
		// Sessao
		// Email
		// Ativado
		// datadecadastro
		// Idade

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// idpessoa
			$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
			$this->idpessoa->ViewCustomAttributes = "";

			// idaula
			$curVal = strval($this->idaula->CurrentValue);
			if ($curVal != "") {
				$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
				if ($this->idaula->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->idaula->ViewValue = $this->idaula->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idaula->ViewValue = $this->idaula->CurrentValue;
					}
				}
			} else {
				$this->idaula->ViewValue = NULL;
			}
			$this->idaula->ViewCustomAttributes = "";

			// Nome
			$this->Nome->ViewValue = $this->Nome->CurrentValue;
			$this->Nome->ViewCustomAttributes = "";

			// CPF
			$this->CPF->ViewValue = $this->CPF->CurrentValue;
			$this->CPF->ViewCustomAttributes = "";

			// Senha
			$this->Senha->ViewValue = $Language->phrase("PasswordMask");
			$this->Senha->ViewCustomAttributes = "";

			// Sexo
			if (strval($this->Sexo->CurrentValue) != "") {
				$this->Sexo->ViewValue = $this->Sexo->optionCaption($this->Sexo->CurrentValue);
			} else {
				$this->Sexo->ViewValue = NULL;
			}
			$this->Sexo->ViewCustomAttributes = "";

			// datanascimento
			$this->datanascimento->ViewValue = $this->datanascimento->CurrentValue;
			$this->datanascimento->ViewValue = FormatDateTime($this->datanascimento->ViewValue, 7);
			$this->datanascimento->ViewCustomAttributes = "";

			// Funcao
			if ($Security->canAdmin()) { // System admin
				$curVal = strval($this->Funcao->CurrentValue);
				if ($curVal != "") {
					$this->Funcao->ViewValue = $this->Funcao->lookupCacheOption($curVal);
					if ($this->Funcao->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->Funcao->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->Funcao->ViewValue = $this->Funcao->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->Funcao->ViewValue = $this->Funcao->CurrentValue;
						}
					}
				} else {
					$this->Funcao->ViewValue = NULL;
				}
			} else {
				$this->Funcao->ViewValue = $Language->phrase("PasswordMask");
			}
			$this->Funcao->ViewCustomAttributes = "";

			// Email
			$this->_Email->ViewValue = $this->_Email->CurrentValue;
			$this->_Email->ViewCustomAttributes = "";

			// Ativado
			if (strval($this->Ativado->CurrentValue) != "") {
				$this->Ativado->ViewValue = $this->Ativado->optionCaption($this->Ativado->CurrentValue);
			} else {
				$this->Ativado->ViewValue = NULL;
			}
			$this->Ativado->ViewCustomAttributes = "";

			// datadecadastro
			$this->datadecadastro->ViewValue = $this->datadecadastro->CurrentValue;
			$this->datadecadastro->ViewValue = FormatDateTime($this->datadecadastro->ViewValue, 0);
			$this->datadecadastro->ViewCustomAttributes = "";

			// Idade
			$this->Idade->ViewValue = $this->Idade->CurrentValue;
			$this->Idade->ViewValue = FormatNumber($this->Idade->ViewValue, 0, -2, -2, -2);
			$this->Idade->ViewCustomAttributes = "";

			// Nome
			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";
			$this->Nome->TooltipValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";
			$this->CPF->TooltipValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";
			$this->Senha->TooltipValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";
			$this->Sexo->TooltipValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";
			$this->datanascimento->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// Nome
			$this->Nome->EditAttrs["class"] = "form-control";
			$this->Nome->EditCustomAttributes = "";
			if (!$this->Nome->Raw)
				$this->Nome->CurrentValue = HtmlDecode($this->Nome->CurrentValue);
			$this->Nome->EditValue = HtmlEncode($this->Nome->CurrentValue);
			$this->Nome->PlaceHolder = RemoveHtml($this->Nome->caption());

			// CPF
			$this->CPF->EditAttrs["class"] = "form-control";
			$this->CPF->EditCustomAttributes = "";
			if (!$this->CPF->Raw)
				$this->CPF->CurrentValue = HtmlDecode($this->CPF->CurrentValue);
			$this->CPF->EditValue = HtmlEncode($this->CPF->CurrentValue);
			$this->CPF->PlaceHolder = RemoveHtml($this->CPF->caption());

			// Senha
			$this->Senha->EditAttrs["class"] = "form-control ew-password-strength";
			$this->Senha->EditCustomAttributes = "";
			$this->Senha->EditValue = HtmlEncode($this->Senha->CurrentValue);
			$this->Senha->PlaceHolder = RemoveHtml($this->Senha->caption());

			// Sexo
			$this->Sexo->EditCustomAttributes = "";
			$this->Sexo->EditValue = $this->Sexo->options(FALSE);

			// datanascimento
			$this->datanascimento->EditAttrs["class"] = "form-control";
			$this->datanascimento->EditCustomAttributes = "";
			$this->datanascimento->EditValue = HtmlEncode(FormatDateTime($this->datanascimento->CurrentValue, 7));
			$this->datanascimento->PlaceHolder = RemoveHtml($this->datanascimento->caption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			if (!$this->_Email->Raw)
				$this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
			$this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

			// Add refer script
			// Nome

			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Initialize form error message
		$FormError = "";

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->Nome->Required) {
			if (!$this->Nome->IsDetailKey && $this->Nome->FormValue != NULL && $this->Nome->FormValue == "") {
				AddMessage($FormError, $Language->phrase("EnterUserName"));
			}
		}
		if ($this->CPF->Required) {
			if (!$this->CPF->IsDetailKey && $this->CPF->FormValue != NULL && $this->CPF->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->CPF->caption(), $this->CPF->RequiredErrorMessage));
			}
		}
		if ($this->Senha->Required) {
			if (!$this->Senha->IsDetailKey && $this->Senha->FormValue != NULL && $this->Senha->FormValue == "") {
				AddMessage($FormError, $Language->phrase("EnterPassword"));
			}
		}
		if ($this->Sexo->Required) {
			if ($this->Sexo->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Sexo->caption(), $this->Sexo->RequiredErrorMessage));
			}
		}
		if ($this->datanascimento->Required) {
			if (!$this->datanascimento->IsDetailKey && $this->datanascimento->FormValue != NULL && $this->datanascimento->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->datanascimento->caption(), $this->datanascimento->RequiredErrorMessage));
			}
		}
		if (!CheckEuroDate($this->datanascimento->FormValue)) {
			AddMessage($FormError, $this->datanascimento->errorMessage());
		}
		if ($this->_Email->Required) {
			if (!$this->_Email->IsDetailKey && $this->_Email->FormValue != NULL && $this->_Email->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->_Email->caption(), $this->_Email->RequiredErrorMessage));
			}
		}
		if (!CheckEmail($this->_Email->FormValue)) {
			AddMessage($FormError, $this->_Email->errorMessage());
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check if valid User ID
		$validUser = FALSE;
		if ($Security->currentUserID() != "" && !EmptyValue($this->idpessoa->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->idpessoa->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->idpessoa->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}

		// Check if valid key values for master user
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$masterFilter = $this->sqlMasterFilter_aulas();
			if (strval($this->idaula->CurrentValue) != "") {
				$masterFilter = str_replace("@idaulas@", AdjustSql($this->idaula->CurrentValue, "DB"), $masterFilter);
			} else {
				$masterFilter = "";
			}
			if ($masterFilter != "") {
				$rsmaster = $GLOBALS["aulas"]->loadRs($masterFilter);
				$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
				$validMasterKey = TRUE;
				if ($this->MasterRecordExists) {
					$validMasterKey = $Security->isValidUserID($rsmaster->fields['idaluno']);
				} elseif ($this->getCurrentMasterTable() == "aulas") {
					$validMasterKey = FALSE;
				}
				if (!$validMasterKey) {
					$masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
					$masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
					$this->setFailureMessage($masterUserIdMsg);
					return FALSE;
				}
				if ($rsmaster)
					$rsmaster->close();
			}
		}
		$conn = $this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// Nome
		$this->Nome->setDbValueDef($rsnew, $this->Nome->CurrentValue, NULL, FALSE);

		// CPF
		$this->CPF->setDbValueDef($rsnew, $this->CPF->CurrentValue, "", FALSE);

		// Senha
		$this->Senha->setDbValueDef($rsnew, $this->Senha->CurrentValue, "", FALSE);

		// Sexo
		$this->Sexo->setDbValueDef($rsnew, $this->Sexo->CurrentValue, NULL, FALSE);

		// datanascimento
		$this->datanascimento->setDbValueDef($rsnew, UnFormatDateTime($this->datanascimento->CurrentValue, 7), NULL, FALSE);

		// Email
		$this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, FALSE);

		// idpessoa
		// idaula

		if ($this->idaula->getSessionValue() != "") {
			$rsnew['idaula'] = $this->idaula->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = "";
			if ($addRow) {
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
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);

			// Call User Registered event
			$this->User_Registered($rsnew);
		}

		// Clean upload path if any
		if ($addRow) {
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// Get default connection and filter
			$conn = $this->getConnection();
			$lookupFilter = "";

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL and connection
			switch ($fld->FieldVar) {
				case "x_idaula":
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					break;
				case "x_Sexo":
					break;
				case "x_Funcao":
					break;
				case "x_Ativado":
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
				$totalCnt = $this->getRecordCount($sql, $conn);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_idaula":
							break;
						case "x_Funcao":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User Registered event
	function User_Registered(&$rs) {

		//echo "User_Registered";
	}

	// User Activated event
	function User_Activated(&$rs) {

		//echo "User_Activated";
	}
} // End class
?>