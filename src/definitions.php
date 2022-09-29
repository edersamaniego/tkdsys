<?php

namespace PHPMaker2022\school;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("logs/audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "logs/log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "conf_city" => \DI\create(ConfCity::class),
    "conf_country" => \DI\create(ConfCountry::class),
    "conf_memberstatus" => \DI\create(ConfMemberstatus::class),
    "conf_news" => \DI\create(ConfNews::class),
    "conf_permissions" => \DI\create(ConfPermissions::class),
    "conf_marketingsource" => \DI\create(ConfMarketingsource::class),
    "conf_membertype" => \DI\create(ConfMembertype::class),
    "conf_scholarity" => \DI\create(ConfScholarity::class),
    "conf_schooltype" => \DI\create(ConfSchooltype::class),
    "conf_testestatus" => \DI\create(ConfTestestatus::class),
    "conf_testtype" => \DI\create(ConfTesttype::class),
    "conf_uf" => \DI\create(ConfUf::class),
    "conf_userlevels" => \DI\create(ConfUserlevels::class),
    "conf_users" => \DI\create(ConfUsers::class),
    "fed_applicationschool" => \DI\create(FedApplicationschool::class),
    "fed_rank" => \DI\create(FedRank::class),
    "fed_federation" => \DI\create(FedFederation::class),
    "fed_files" => \DI\create(FedFiles::class),
    "fed_filescategory" => \DI\create(FedFilescategory::class),
    "fed_filestype" => \DI\create(FedFilestype::class),
    "fed_instructorlevels" => \DI\create(FedInstructorlevels::class),
    "fed_judgelevel" => \DI\create(FedJudgelevel::class),
    "fed_licenseschool" => \DI\create(FedLicenseschool::class),
    "fed_martialarts" => \DI\create(FedMartialarts::class),
    "fed_memberlevel" => \DI\create(FedMemberlevel::class),
    "fed_registermember" => \DI\create(FedRegistermember::class),
    "fed_school" => \DI\create(FedSchool::class),
    "fed_video" => \DI\create(FedVideo::class),
    "fed_videosection" => \DI\create(FedVideosection::class),
    "fed_videosubsection" => \DI\create(FedVideosubsection::class),
    "fin_accountspayable" => \DI\create(FinAccountspayable::class),
    "fin_accountsreceivable" => \DI\create(FinAccountsreceivable::class),
    "fin_checkingaccount" => \DI\create(FinCheckingaccount::class),
    "fin_costcenter" => \DI\create(FinCostcenter::class),
    "fin_creditors" => \DI\create(FinCreditors::class),
    "fin_credit" => \DI\create(FinCredit::class),
    "fin_debit" => \DI\create(FinDebit::class),
    "fin_department" => \DI\create(FinDepartment::class),
    "fin_discount" => \DI\create(FinDiscount::class),
    "fin_employee" => \DI\create(FinEmployee::class),
    "fin_order" => \DI\create(FinOrder::class),
    "fin_orderdetails" => \DI\create(FinOrderdetails::class),
    "fin_paymentmethod" => \DI\create(FinPaymentmethod::class),
    "fin_type" => \DI\create(FinType::class),
    "school_class" => \DI\create(SchoolClass::class),
    "school_modality" => \DI\create(SchoolModality::class),
    "school_member" => \DI\create(SchoolMember::class),
    "school_program" => \DI\create(SchoolProgram::class),
    "school_users" => \DI\create(SchoolUsers::class),
    "tes_aproved" => \DI\create(TesAproved::class),
    "tes_candidate" => \DI\create(TesCandidate::class),
    "tes_certificate" => \DI\create(TesCertificate::class),
    "tes_resultamount" => \DI\create(TesResultamount::class),
    "tes_test" => \DI\create(TesTest::class),
    "tes_test_judge" => \DI\create(TesTestJudge::class),
    "audittrail" => \DI\create(Audittrail::class),
    "view_alljudgemembers" => \DI\create(ViewAlljudgemembers::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "view_news" => \DI\create(ViewNews::class),
    "userlevels" => \DI\create(Userlevels::class),
    "view_test_aproveds" => \DI\create(ViewTestAproveds::class),
    "view_certificate_data" => \DI\create(ViewCertificateData::class),

    // User table
    "usertable" => \DI\get("school_users"),
];
