<?php

namespace PHPMaker2022\school;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // conf_city
    $app->map(["GET","POST","OPTIONS"], '/ConfCityList[/{id}]', ConfCityController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfCityList-conf_city-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfCityAdd[/{id}]', ConfCityController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfCityAdd-conf_city-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfCityAddopt', ConfCityController::class . ':addopt')->add(PermissionMiddleware::class)->setName('ConfCityAddopt-conf_city-addopt'); // addopt
    $app->map(["GET","POST","OPTIONS"], '/ConfCityView[/{id}]', ConfCityController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfCityView-conf_city-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfCityEdit[/{id}]', ConfCityController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfCityEdit-conf_city-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfCityDelete[/{id}]', ConfCityController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfCityDelete-conf_city-delete'); // delete
    $app->group(
        '/conf_city',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfCityController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_city/list-conf_city-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfCityController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_city/add-conf_city-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADDOPT_ACTION") . '', ConfCityController::class . ':addopt')->add(PermissionMiddleware::class)->setName('conf_city/addopt-conf_city-addopt-2'); // addopt
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfCityController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_city/view-conf_city-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfCityController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_city/edit-conf_city-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfCityController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_city/delete-conf_city-delete-2'); // delete
        }
    );

    // conf_country
    $app->map(["GET","POST","OPTIONS"], '/ConfCountryList[/{id}]', ConfCountryController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfCountryList-conf_country-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfCountryAdd[/{id}]', ConfCountryController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfCountryAdd-conf_country-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfCountryAddopt', ConfCountryController::class . ':addopt')->add(PermissionMiddleware::class)->setName('ConfCountryAddopt-conf_country-addopt'); // addopt
    $app->map(["GET","POST","OPTIONS"], '/ConfCountryView[/{id}]', ConfCountryController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfCountryView-conf_country-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfCountryEdit[/{id}]', ConfCountryController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfCountryEdit-conf_country-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfCountryDelete[/{id}]', ConfCountryController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfCountryDelete-conf_country-delete'); // delete
    $app->group(
        '/conf_country',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfCountryController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_country/list-conf_country-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfCountryController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_country/add-conf_country-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADDOPT_ACTION") . '', ConfCountryController::class . ':addopt')->add(PermissionMiddleware::class)->setName('conf_country/addopt-conf_country-addopt-2'); // addopt
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfCountryController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_country/view-conf_country-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfCountryController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_country/edit-conf_country-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfCountryController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_country/delete-conf_country-delete-2'); // delete
        }
    );

    // conf_memberstatus
    $app->map(["GET","POST","OPTIONS"], '/ConfMemberstatusList[/{id}]', ConfMemberstatusController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfMemberstatusList-conf_memberstatus-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfMemberstatusAdd[/{id}]', ConfMemberstatusController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfMemberstatusAdd-conf_memberstatus-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfMemberstatusView[/{id}]', ConfMemberstatusController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfMemberstatusView-conf_memberstatus-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfMemberstatusEdit[/{id}]', ConfMemberstatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfMemberstatusEdit-conf_memberstatus-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfMemberstatusDelete[/{id}]', ConfMemberstatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfMemberstatusDelete-conf_memberstatus-delete'); // delete
    $app->group(
        '/conf_memberstatus',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfMemberstatusController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_memberstatus/list-conf_memberstatus-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfMemberstatusController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_memberstatus/add-conf_memberstatus-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfMemberstatusController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_memberstatus/view-conf_memberstatus-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfMemberstatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_memberstatus/edit-conf_memberstatus-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfMemberstatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_memberstatus/delete-conf_memberstatus-delete-2'); // delete
        }
    );

    // conf_news
    $app->map(["GET","POST","OPTIONS"], '/ConfNewsList[/{id}]', ConfNewsController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfNewsList-conf_news-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfNewsAdd[/{id}]', ConfNewsController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfNewsAdd-conf_news-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfNewsView[/{id}]', ConfNewsController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfNewsView-conf_news-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfNewsEdit[/{id}]', ConfNewsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfNewsEdit-conf_news-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfNewsDelete[/{id}]', ConfNewsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfNewsDelete-conf_news-delete'); // delete
    $app->group(
        '/conf_news',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfNewsController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_news/list-conf_news-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfNewsController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_news/add-conf_news-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfNewsController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_news/view-conf_news-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfNewsController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_news/edit-conf_news-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfNewsController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_news/delete-conf_news-delete-2'); // delete
        }
    );

    // conf_marketingsource
    $app->map(["GET","POST","OPTIONS"], '/ConfMarketingsourceList[/{id}]', ConfMarketingsourceController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfMarketingsourceList-conf_marketingsource-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfMarketingsourceAdd[/{id}]', ConfMarketingsourceController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfMarketingsourceAdd-conf_marketingsource-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfMarketingsourceView[/{id}]', ConfMarketingsourceController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfMarketingsourceView-conf_marketingsource-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfMarketingsourceEdit[/{id}]', ConfMarketingsourceController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfMarketingsourceEdit-conf_marketingsource-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfMarketingsourceDelete[/{id}]', ConfMarketingsourceController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfMarketingsourceDelete-conf_marketingsource-delete'); // delete
    $app->group(
        '/conf_marketingsource',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfMarketingsourceController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_marketingsource/list-conf_marketingsource-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfMarketingsourceController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_marketingsource/add-conf_marketingsource-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfMarketingsourceController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_marketingsource/view-conf_marketingsource-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfMarketingsourceController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_marketingsource/edit-conf_marketingsource-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfMarketingsourceController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_marketingsource/delete-conf_marketingsource-delete-2'); // delete
        }
    );

    // conf_membertype
    $app->map(["GET","POST","OPTIONS"], '/ConfMembertypeList[/{id}]', ConfMembertypeController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfMembertypeList-conf_membertype-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfMembertypeAdd[/{id}]', ConfMembertypeController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfMembertypeAdd-conf_membertype-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfMembertypeView[/{id}]', ConfMembertypeController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfMembertypeView-conf_membertype-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfMembertypeEdit[/{id}]', ConfMembertypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfMembertypeEdit-conf_membertype-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfMembertypeDelete[/{id}]', ConfMembertypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfMembertypeDelete-conf_membertype-delete'); // delete
    $app->group(
        '/conf_membertype',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfMembertypeController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_membertype/list-conf_membertype-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfMembertypeController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_membertype/add-conf_membertype-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfMembertypeController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_membertype/view-conf_membertype-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfMembertypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_membertype/edit-conf_membertype-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfMembertypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_membertype/delete-conf_membertype-delete-2'); // delete
        }
    );

    // conf_scholarity
    $app->map(["GET","POST","OPTIONS"], '/ConfScholarityList[/{id}]', ConfScholarityController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfScholarityList-conf_scholarity-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfScholarityAdd[/{id}]', ConfScholarityController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfScholarityAdd-conf_scholarity-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfScholarityView[/{id}]', ConfScholarityController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfScholarityView-conf_scholarity-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfScholarityEdit[/{id}]', ConfScholarityController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfScholarityEdit-conf_scholarity-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfScholarityDelete[/{id}]', ConfScholarityController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfScholarityDelete-conf_scholarity-delete'); // delete
    $app->group(
        '/conf_scholarity',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfScholarityController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_scholarity/list-conf_scholarity-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfScholarityController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_scholarity/add-conf_scholarity-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfScholarityController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_scholarity/view-conf_scholarity-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfScholarityController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_scholarity/edit-conf_scholarity-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfScholarityController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_scholarity/delete-conf_scholarity-delete-2'); // delete
        }
    );

    // conf_schooltype
    $app->map(["GET","POST","OPTIONS"], '/ConfSchooltypeList[/{id}]', ConfSchooltypeController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfSchooltypeList-conf_schooltype-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfSchooltypeAdd[/{id}]', ConfSchooltypeController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfSchooltypeAdd-conf_schooltype-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfSchooltypeView[/{id}]', ConfSchooltypeController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfSchooltypeView-conf_schooltype-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfSchooltypeEdit[/{id}]', ConfSchooltypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfSchooltypeEdit-conf_schooltype-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfSchooltypeDelete[/{id}]', ConfSchooltypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfSchooltypeDelete-conf_schooltype-delete'); // delete
    $app->group(
        '/conf_schooltype',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfSchooltypeController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_schooltype/list-conf_schooltype-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfSchooltypeController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_schooltype/add-conf_schooltype-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfSchooltypeController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_schooltype/view-conf_schooltype-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfSchooltypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_schooltype/edit-conf_schooltype-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfSchooltypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_schooltype/delete-conf_schooltype-delete-2'); // delete
        }
    );

    // conf_testestatus
    $app->map(["GET","POST","OPTIONS"], '/ConfTestestatusList[/{id}]', ConfTestestatusController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfTestestatusList-conf_testestatus-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfTestestatusAdd[/{id}]', ConfTestestatusController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfTestestatusAdd-conf_testestatus-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfTestestatusView[/{id}]', ConfTestestatusController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfTestestatusView-conf_testestatus-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfTestestatusEdit[/{id}]', ConfTestestatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfTestestatusEdit-conf_testestatus-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfTestestatusDelete[/{id}]', ConfTestestatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfTestestatusDelete-conf_testestatus-delete'); // delete
    $app->group(
        '/conf_testestatus',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfTestestatusController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_testestatus/list-conf_testestatus-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfTestestatusController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_testestatus/add-conf_testestatus-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfTestestatusController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_testestatus/view-conf_testestatus-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfTestestatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_testestatus/edit-conf_testestatus-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfTestestatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_testestatus/delete-conf_testestatus-delete-2'); // delete
        }
    );

    // conf_testtype
    $app->map(["GET","POST","OPTIONS"], '/ConfTesttypeList[/{id}]', ConfTesttypeController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfTesttypeList-conf_testtype-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfTesttypeAdd[/{id}]', ConfTesttypeController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfTesttypeAdd-conf_testtype-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfTesttypeView[/{id}]', ConfTesttypeController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfTesttypeView-conf_testtype-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfTesttypeEdit[/{id}]', ConfTesttypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfTesttypeEdit-conf_testtype-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfTesttypeDelete[/{id}]', ConfTesttypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfTesttypeDelete-conf_testtype-delete'); // delete
    $app->group(
        '/conf_testtype',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfTesttypeController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_testtype/list-conf_testtype-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfTesttypeController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_testtype/add-conf_testtype-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfTesttypeController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_testtype/view-conf_testtype-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfTesttypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_testtype/edit-conf_testtype-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfTesttypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_testtype/delete-conf_testtype-delete-2'); // delete
        }
    );

    // conf_uf
    $app->map(["GET","POST","OPTIONS"], '/ConfUfList[/{id}]', ConfUfController::class . ':list')->add(PermissionMiddleware::class)->setName('ConfUfList-conf_uf-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/ConfUfAdd[/{id}]', ConfUfController::class . ':add')->add(PermissionMiddleware::class)->setName('ConfUfAdd-conf_uf-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/ConfUfAddopt', ConfUfController::class . ':addopt')->add(PermissionMiddleware::class)->setName('ConfUfAddopt-conf_uf-addopt'); // addopt
    $app->map(["GET","POST","OPTIONS"], '/ConfUfView[/{id}]', ConfUfController::class . ':view')->add(PermissionMiddleware::class)->setName('ConfUfView-conf_uf-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/ConfUfEdit[/{id}]', ConfUfController::class . ':edit')->add(PermissionMiddleware::class)->setName('ConfUfEdit-conf_uf-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/ConfUfDelete[/{id}]', ConfUfController::class . ':delete')->add(PermissionMiddleware::class)->setName('ConfUfDelete-conf_uf-delete'); // delete
    $app->group(
        '/conf_uf',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ConfUfController::class . ':list')->add(PermissionMiddleware::class)->setName('conf_uf/list-conf_uf-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ConfUfController::class . ':add')->add(PermissionMiddleware::class)->setName('conf_uf/add-conf_uf-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADDOPT_ACTION") . '', ConfUfController::class . ':addopt')->add(PermissionMiddleware::class)->setName('conf_uf/addopt-conf_uf-addopt-2'); // addopt
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ConfUfController::class . ':view')->add(PermissionMiddleware::class)->setName('conf_uf/view-conf_uf-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ConfUfController::class . ':edit')->add(PermissionMiddleware::class)->setName('conf_uf/edit-conf_uf-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ConfUfController::class . ':delete')->add(PermissionMiddleware::class)->setName('conf_uf/delete-conf_uf-delete-2'); // delete
        }
    );

    // fed_applicationschool
    $app->map(["GET","POST","OPTIONS"], '/FedApplicationschoolList[/{id}]', FedApplicationschoolController::class . ':list')->add(PermissionMiddleware::class)->setName('FedApplicationschoolList-fed_applicationschool-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedApplicationschoolAdd[/{id}]', FedApplicationschoolController::class . ':add')->add(PermissionMiddleware::class)->setName('FedApplicationschoolAdd-fed_applicationschool-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedApplicationschoolView[/{id}]', FedApplicationschoolController::class . ':view')->add(PermissionMiddleware::class)->setName('FedApplicationschoolView-fed_applicationschool-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedApplicationschoolEdit[/{id}]', FedApplicationschoolController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedApplicationschoolEdit-fed_applicationschool-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedApplicationschoolDelete[/{id}]', FedApplicationschoolController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedApplicationschoolDelete-fed_applicationschool-delete'); // delete
    $app->group(
        '/fed_applicationschool',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedApplicationschoolController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_applicationschool/list-fed_applicationschool-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedApplicationschoolController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_applicationschool/add-fed_applicationschool-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedApplicationschoolController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_applicationschool/view-fed_applicationschool-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedApplicationschoolController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_applicationschool/edit-fed_applicationschool-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedApplicationschoolController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_applicationschool/delete-fed_applicationschool-delete-2'); // delete
        }
    );

    // fed_rank
    $app->map(["GET","POST","OPTIONS"], '/FedRankList[/{id}]', FedRankController::class . ':list')->add(PermissionMiddleware::class)->setName('FedRankList-fed_rank-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedRankAdd[/{id}]', FedRankController::class . ':add')->add(PermissionMiddleware::class)->setName('FedRankAdd-fed_rank-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedRankView[/{id}]', FedRankController::class . ':view')->add(PermissionMiddleware::class)->setName('FedRankView-fed_rank-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedRankEdit[/{id}]', FedRankController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedRankEdit-fed_rank-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedRankDelete[/{id}]', FedRankController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedRankDelete-fed_rank-delete'); // delete
    $app->map(["GET","POST","OPTIONS"], '/FedRankSearch', FedRankController::class . ':search')->add(PermissionMiddleware::class)->setName('FedRankSearch-fed_rank-search'); // search
    $app->map(["GET","OPTIONS"], '/FedRankPreview', FedRankController::class . ':preview')->add(PermissionMiddleware::class)->setName('FedRankPreview-fed_rank-preview'); // preview
    $app->group(
        '/fed_rank',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedRankController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_rank/list-fed_rank-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedRankController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_rank/add-fed_rank-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedRankController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_rank/view-fed_rank-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedRankController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_rank/edit-fed_rank-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedRankController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_rank/delete-fed_rank-delete-2'); // delete
            $group->map(["GET","POST","OPTIONS"], '/' . Config("SEARCH_ACTION") . '', FedRankController::class . ':search')->add(PermissionMiddleware::class)->setName('fed_rank/search-fed_rank-search-2'); // search
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FedRankController::class . ':preview')->add(PermissionMiddleware::class)->setName('fed_rank/preview-fed_rank-preview-2'); // preview
        }
    );

    // fed_federation
    $app->map(["GET","POST","OPTIONS"], '/FedFederationList[/{id}]', FedFederationController::class . ':list')->add(PermissionMiddleware::class)->setName('FedFederationList-fed_federation-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedFederationAdd[/{id}]', FedFederationController::class . ':add')->add(PermissionMiddleware::class)->setName('FedFederationAdd-fed_federation-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedFederationView[/{id}]', FedFederationController::class . ':view')->add(PermissionMiddleware::class)->setName('FedFederationView-fed_federation-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedFederationEdit[/{id}]', FedFederationController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedFederationEdit-fed_federation-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedFederationDelete[/{id}]', FedFederationController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedFederationDelete-fed_federation-delete'); // delete
    $app->group(
        '/fed_federation',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedFederationController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_federation/list-fed_federation-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedFederationController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_federation/add-fed_federation-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedFederationController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_federation/view-fed_federation-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedFederationController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_federation/edit-fed_federation-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedFederationController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_federation/delete-fed_federation-delete-2'); // delete
        }
    );

    // fed_files
    $app->map(["GET","POST","OPTIONS"], '/FedFilesList[/{id}]', FedFilesController::class . ':list')->add(PermissionMiddleware::class)->setName('FedFilesList-fed_files-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedFilesAdd[/{id}]', FedFilesController::class . ':add')->add(PermissionMiddleware::class)->setName('FedFilesAdd-fed_files-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedFilesView[/{id}]', FedFilesController::class . ':view')->add(PermissionMiddleware::class)->setName('FedFilesView-fed_files-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedFilesEdit[/{id}]', FedFilesController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedFilesEdit-fed_files-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedFilesDelete[/{id}]', FedFilesController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedFilesDelete-fed_files-delete'); // delete
    $app->group(
        '/fed_files',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedFilesController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_files/list-fed_files-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedFilesController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_files/add-fed_files-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedFilesController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_files/view-fed_files-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedFilesController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_files/edit-fed_files-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedFilesController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_files/delete-fed_files-delete-2'); // delete
        }
    );

    // fed_filescategory
    $app->map(["GET","POST","OPTIONS"], '/FedFilescategoryList[/{id}]', FedFilescategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('FedFilescategoryList-fed_filescategory-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedFilescategoryAdd[/{id}]', FedFilescategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('FedFilescategoryAdd-fed_filescategory-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedFilescategoryView[/{id}]', FedFilescategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('FedFilescategoryView-fed_filescategory-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedFilescategoryEdit[/{id}]', FedFilescategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedFilescategoryEdit-fed_filescategory-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedFilescategoryDelete[/{id}]', FedFilescategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedFilescategoryDelete-fed_filescategory-delete'); // delete
    $app->group(
        '/fed_filescategory',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedFilescategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_filescategory/list-fed_filescategory-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedFilescategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_filescategory/add-fed_filescategory-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedFilescategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_filescategory/view-fed_filescategory-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedFilescategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_filescategory/edit-fed_filescategory-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedFilescategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_filescategory/delete-fed_filescategory-delete-2'); // delete
        }
    );

    // fed_filestype
    $app->map(["GET","POST","OPTIONS"], '/FedFilestypeList[/{id}]', FedFilestypeController::class . ':list')->add(PermissionMiddleware::class)->setName('FedFilestypeList-fed_filestype-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedFilestypeAdd[/{id}]', FedFilestypeController::class . ':add')->add(PermissionMiddleware::class)->setName('FedFilestypeAdd-fed_filestype-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedFilestypeView[/{id}]', FedFilestypeController::class . ':view')->add(PermissionMiddleware::class)->setName('FedFilestypeView-fed_filestype-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedFilestypeEdit[/{id}]', FedFilestypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedFilestypeEdit-fed_filestype-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedFilestypeDelete[/{id}]', FedFilestypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedFilestypeDelete-fed_filestype-delete'); // delete
    $app->group(
        '/fed_filestype',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedFilestypeController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_filestype/list-fed_filestype-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedFilestypeController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_filestype/add-fed_filestype-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedFilestypeController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_filestype/view-fed_filestype-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedFilestypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_filestype/edit-fed_filestype-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedFilestypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_filestype/delete-fed_filestype-delete-2'); // delete
        }
    );

    // fed_licenseschool
    $app->map(["GET","POST","OPTIONS"], '/FedLicenseschoolList[/{id}]', FedLicenseschoolController::class . ':list')->add(PermissionMiddleware::class)->setName('FedLicenseschoolList-fed_licenseschool-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedLicenseschoolAdd[/{id}]', FedLicenseschoolController::class . ':add')->add(PermissionMiddleware::class)->setName('FedLicenseschoolAdd-fed_licenseschool-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedLicenseschoolView[/{id}]', FedLicenseschoolController::class . ':view')->add(PermissionMiddleware::class)->setName('FedLicenseschoolView-fed_licenseschool-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedLicenseschoolEdit[/{id}]', FedLicenseschoolController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedLicenseschoolEdit-fed_licenseschool-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedLicenseschoolDelete[/{id}]', FedLicenseschoolController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedLicenseschoolDelete-fed_licenseschool-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FedLicenseschoolPreview', FedLicenseschoolController::class . ':preview')->add(PermissionMiddleware::class)->setName('FedLicenseschoolPreview-fed_licenseschool-preview'); // preview
    $app->group(
        '/fed_licenseschool',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedLicenseschoolController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_licenseschool/list-fed_licenseschool-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedLicenseschoolController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_licenseschool/add-fed_licenseschool-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedLicenseschoolController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_licenseschool/view-fed_licenseschool-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedLicenseschoolController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_licenseschool/edit-fed_licenseschool-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedLicenseschoolController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_licenseschool/delete-fed_licenseschool-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FedLicenseschoolController::class . ':preview')->add(PermissionMiddleware::class)->setName('fed_licenseschool/preview-fed_licenseschool-preview-2'); // preview
        }
    );

    // fed_martialarts
    $app->map(["GET","POST","OPTIONS"], '/FedMartialartsList[/{id}]', FedMartialartsController::class . ':list')->add(PermissionMiddleware::class)->setName('FedMartialartsList-fed_martialarts-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedMartialartsAdd[/{id}]', FedMartialartsController::class . ':add')->add(PermissionMiddleware::class)->setName('FedMartialartsAdd-fed_martialarts-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedMartialartsView[/{id}]', FedMartialartsController::class . ':view')->add(PermissionMiddleware::class)->setName('FedMartialartsView-fed_martialarts-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedMartialartsEdit[/{id}]', FedMartialartsController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedMartialartsEdit-fed_martialarts-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedMartialartsDelete[/{id}]', FedMartialartsController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedMartialartsDelete-fed_martialarts-delete'); // delete
    $app->group(
        '/fed_martialarts',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedMartialartsController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_martialarts/list-fed_martialarts-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedMartialartsController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_martialarts/add-fed_martialarts-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedMartialartsController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_martialarts/view-fed_martialarts-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedMartialartsController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_martialarts/edit-fed_martialarts-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedMartialartsController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_martialarts/delete-fed_martialarts-delete-2'); // delete
        }
    );

    // fed_registermember
    $app->map(["GET","POST","OPTIONS"], '/FedRegistermemberList[/{id}]', FedRegistermemberController::class . ':list')->add(PermissionMiddleware::class)->setName('FedRegistermemberList-fed_registermember-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedRegistermemberAdd[/{id}]', FedRegistermemberController::class . ':add')->add(PermissionMiddleware::class)->setName('FedRegistermemberAdd-fed_registermember-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedRegistermemberView[/{id}]', FedRegistermemberController::class . ':view')->add(PermissionMiddleware::class)->setName('FedRegistermemberView-fed_registermember-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedRegistermemberEdit[/{id}]', FedRegistermemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedRegistermemberEdit-fed_registermember-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedRegistermemberDelete[/{id}]', FedRegistermemberController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedRegistermemberDelete-fed_registermember-delete'); // delete
    $app->group(
        '/fed_registermember',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedRegistermemberController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_registermember/list-fed_registermember-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedRegistermemberController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_registermember/add-fed_registermember-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedRegistermemberController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_registermember/view-fed_registermember-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedRegistermemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_registermember/edit-fed_registermember-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedRegistermemberController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_registermember/delete-fed_registermember-delete-2'); // delete
        }
    );

    // fed_school
    $app->map(["GET","POST","OPTIONS"], '/FedSchoolList[/{id}]', FedSchoolController::class . ':list')->add(PermissionMiddleware::class)->setName('FedSchoolList-fed_school-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedSchoolAdd[/{id}]', FedSchoolController::class . ':add')->add(PermissionMiddleware::class)->setName('FedSchoolAdd-fed_school-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedSchoolView[/{id}]', FedSchoolController::class . ':view')->add(PermissionMiddleware::class)->setName('FedSchoolView-fed_school-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedSchoolEdit[/{id}]', FedSchoolController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedSchoolEdit-fed_school-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedSchoolDelete[/{id}]', FedSchoolController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedSchoolDelete-fed_school-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FedSchoolPreview', FedSchoolController::class . ':preview')->add(PermissionMiddleware::class)->setName('FedSchoolPreview-fed_school-preview'); // preview
    $app->group(
        '/fed_school',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedSchoolController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_school/list-fed_school-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedSchoolController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_school/add-fed_school-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedSchoolController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_school/view-fed_school-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedSchoolController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_school/edit-fed_school-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedSchoolController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_school/delete-fed_school-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FedSchoolController::class . ':preview')->add(PermissionMiddleware::class)->setName('fed_school/preview-fed_school-preview-2'); // preview
        }
    );

    // fed_video
    $app->map(["GET","POST","OPTIONS"], '/FedVideoList[/{id}]', FedVideoController::class . ':list')->add(PermissionMiddleware::class)->setName('FedVideoList-fed_video-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedVideoAdd[/{id}]', FedVideoController::class . ':add')->add(PermissionMiddleware::class)->setName('FedVideoAdd-fed_video-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedVideoView[/{id}]', FedVideoController::class . ':view')->add(PermissionMiddleware::class)->setName('FedVideoView-fed_video-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedVideoEdit[/{id}]', FedVideoController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedVideoEdit-fed_video-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedVideoDelete[/{id}]', FedVideoController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedVideoDelete-fed_video-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FedVideoPreview', FedVideoController::class . ':preview')->add(PermissionMiddleware::class)->setName('FedVideoPreview-fed_video-preview'); // preview
    $app->group(
        '/fed_video',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedVideoController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_video/list-fed_video-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedVideoController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_video/add-fed_video-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedVideoController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_video/view-fed_video-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedVideoController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_video/edit-fed_video-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedVideoController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_video/delete-fed_video-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FedVideoController::class . ':preview')->add(PermissionMiddleware::class)->setName('fed_video/preview-fed_video-preview-2'); // preview
        }
    );

    // fed_videosection
    $app->map(["GET","POST","OPTIONS"], '/FedVideosectionList[/{id}]', FedVideosectionController::class . ':list')->add(PermissionMiddleware::class)->setName('FedVideosectionList-fed_videosection-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedVideosectionAdd[/{id}]', FedVideosectionController::class . ':add')->add(PermissionMiddleware::class)->setName('FedVideosectionAdd-fed_videosection-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedVideosectionView[/{id}]', FedVideosectionController::class . ':view')->add(PermissionMiddleware::class)->setName('FedVideosectionView-fed_videosection-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedVideosectionEdit[/{id}]', FedVideosectionController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedVideosectionEdit-fed_videosection-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedVideosectionDelete[/{id}]', FedVideosectionController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedVideosectionDelete-fed_videosection-delete'); // delete
    $app->group(
        '/fed_videosection',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedVideosectionController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_videosection/list-fed_videosection-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedVideosectionController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_videosection/add-fed_videosection-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedVideosectionController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_videosection/view-fed_videosection-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedVideosectionController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_videosection/edit-fed_videosection-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedVideosectionController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_videosection/delete-fed_videosection-delete-2'); // delete
        }
    );

    // fed_videosubsection
    $app->map(["GET","POST","OPTIONS"], '/FedVideosubsectionList[/{id}]', FedVideosubsectionController::class . ':list')->add(PermissionMiddleware::class)->setName('FedVideosubsectionList-fed_videosubsection-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FedVideosubsectionAdd[/{id}]', FedVideosubsectionController::class . ':add')->add(PermissionMiddleware::class)->setName('FedVideosubsectionAdd-fed_videosubsection-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FedVideosubsectionView[/{id}]', FedVideosubsectionController::class . ':view')->add(PermissionMiddleware::class)->setName('FedVideosubsectionView-fed_videosubsection-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FedVideosubsectionEdit[/{id}]', FedVideosubsectionController::class . ':edit')->add(PermissionMiddleware::class)->setName('FedVideosubsectionEdit-fed_videosubsection-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FedVideosubsectionDelete[/{id}]', FedVideosubsectionController::class . ':delete')->add(PermissionMiddleware::class)->setName('FedVideosubsectionDelete-fed_videosubsection-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FedVideosubsectionPreview', FedVideosubsectionController::class . ':preview')->add(PermissionMiddleware::class)->setName('FedVideosubsectionPreview-fed_videosubsection-preview'); // preview
    $app->group(
        '/fed_videosubsection',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FedVideosubsectionController::class . ':list')->add(PermissionMiddleware::class)->setName('fed_videosubsection/list-fed_videosubsection-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FedVideosubsectionController::class . ':add')->add(PermissionMiddleware::class)->setName('fed_videosubsection/add-fed_videosubsection-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FedVideosubsectionController::class . ':view')->add(PermissionMiddleware::class)->setName('fed_videosubsection/view-fed_videosubsection-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FedVideosubsectionController::class . ':edit')->add(PermissionMiddleware::class)->setName('fed_videosubsection/edit-fed_videosubsection-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FedVideosubsectionController::class . ':delete')->add(PermissionMiddleware::class)->setName('fed_videosubsection/delete-fed_videosubsection-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FedVideosubsectionController::class . ':preview')->add(PermissionMiddleware::class)->setName('fed_videosubsection/preview-fed_videosubsection-preview-2'); // preview
        }
    );

    // fin_accountspayable
    $app->map(["GET","POST","OPTIONS"], '/FinAccountspayableList[/{id}]', FinAccountspayableController::class . ':list')->add(PermissionMiddleware::class)->setName('FinAccountspayableList-fin_accountspayable-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinAccountspayableAdd[/{id}]', FinAccountspayableController::class . ':add')->add(PermissionMiddleware::class)->setName('FinAccountspayableAdd-fin_accountspayable-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinAccountspayableView[/{id}]', FinAccountspayableController::class . ':view')->add(PermissionMiddleware::class)->setName('FinAccountspayableView-fin_accountspayable-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinAccountspayableEdit[/{id}]', FinAccountspayableController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinAccountspayableEdit-fin_accountspayable-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinAccountspayableDelete[/{id}]', FinAccountspayableController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinAccountspayableDelete-fin_accountspayable-delete'); // delete
    $app->group(
        '/fin_accountspayable',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinAccountspayableController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_accountspayable/list-fin_accountspayable-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinAccountspayableController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_accountspayable/add-fin_accountspayable-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinAccountspayableController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_accountspayable/view-fin_accountspayable-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinAccountspayableController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_accountspayable/edit-fin_accountspayable-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinAccountspayableController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_accountspayable/delete-fin_accountspayable-delete-2'); // delete
        }
    );

    // fin_accountsreceivable
    $app->map(["GET","POST","OPTIONS"], '/FinAccountsreceivableList[/{id}]', FinAccountsreceivableController::class . ':list')->add(PermissionMiddleware::class)->setName('FinAccountsreceivableList-fin_accountsreceivable-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinAccountsreceivableAdd[/{id}]', FinAccountsreceivableController::class . ':add')->add(PermissionMiddleware::class)->setName('FinAccountsreceivableAdd-fin_accountsreceivable-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinAccountsreceivableView[/{id}]', FinAccountsreceivableController::class . ':view')->add(PermissionMiddleware::class)->setName('FinAccountsreceivableView-fin_accountsreceivable-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinAccountsreceivableEdit[/{id}]', FinAccountsreceivableController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinAccountsreceivableEdit-fin_accountsreceivable-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinAccountsreceivableDelete[/{id}]', FinAccountsreceivableController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinAccountsreceivableDelete-fin_accountsreceivable-delete'); // delete
    $app->group(
        '/fin_accountsreceivable',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinAccountsreceivableController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_accountsreceivable/list-fin_accountsreceivable-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinAccountsreceivableController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_accountsreceivable/add-fin_accountsreceivable-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinAccountsreceivableController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_accountsreceivable/view-fin_accountsreceivable-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinAccountsreceivableController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_accountsreceivable/edit-fin_accountsreceivable-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinAccountsreceivableController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_accountsreceivable/delete-fin_accountsreceivable-delete-2'); // delete
        }
    );

    // fin_checkingaccount
    $app->map(["GET","POST","OPTIONS"], '/FinCheckingaccountList[/{id}]', FinCheckingaccountController::class . ':list')->add(PermissionMiddleware::class)->setName('FinCheckingaccountList-fin_checkingaccount-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinCheckingaccountAdd[/{id}]', FinCheckingaccountController::class . ':add')->add(PermissionMiddleware::class)->setName('FinCheckingaccountAdd-fin_checkingaccount-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinCheckingaccountView[/{id}]', FinCheckingaccountController::class . ':view')->add(PermissionMiddleware::class)->setName('FinCheckingaccountView-fin_checkingaccount-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinCheckingaccountEdit[/{id}]', FinCheckingaccountController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinCheckingaccountEdit-fin_checkingaccount-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinCheckingaccountDelete[/{id}]', FinCheckingaccountController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinCheckingaccountDelete-fin_checkingaccount-delete'); // delete
    $app->group(
        '/fin_checkingaccount',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinCheckingaccountController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_checkingaccount/list-fin_checkingaccount-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinCheckingaccountController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_checkingaccount/add-fin_checkingaccount-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinCheckingaccountController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_checkingaccount/view-fin_checkingaccount-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinCheckingaccountController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_checkingaccount/edit-fin_checkingaccount-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinCheckingaccountController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_checkingaccount/delete-fin_checkingaccount-delete-2'); // delete
        }
    );

    // fin_costcenter
    $app->map(["GET","POST","OPTIONS"], '/FinCostcenterList[/{id}]', FinCostcenterController::class . ':list')->add(PermissionMiddleware::class)->setName('FinCostcenterList-fin_costcenter-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinCostcenterAdd[/{id}]', FinCostcenterController::class . ':add')->add(PermissionMiddleware::class)->setName('FinCostcenterAdd-fin_costcenter-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinCostcenterView[/{id}]', FinCostcenterController::class . ':view')->add(PermissionMiddleware::class)->setName('FinCostcenterView-fin_costcenter-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinCostcenterEdit[/{id}]', FinCostcenterController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinCostcenterEdit-fin_costcenter-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinCostcenterDelete[/{id}]', FinCostcenterController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinCostcenterDelete-fin_costcenter-delete'); // delete
    $app->group(
        '/fin_costcenter',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinCostcenterController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_costcenter/list-fin_costcenter-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinCostcenterController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_costcenter/add-fin_costcenter-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinCostcenterController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_costcenter/view-fin_costcenter-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinCostcenterController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_costcenter/edit-fin_costcenter-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinCostcenterController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_costcenter/delete-fin_costcenter-delete-2'); // delete
        }
    );

    // fin_creditors
    $app->map(["GET","POST","OPTIONS"], '/FinCreditorsList[/{id}]', FinCreditorsController::class . ':list')->add(PermissionMiddleware::class)->setName('FinCreditorsList-fin_creditors-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinCreditorsAdd[/{id}]', FinCreditorsController::class . ':add')->add(PermissionMiddleware::class)->setName('FinCreditorsAdd-fin_creditors-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinCreditorsAddopt', FinCreditorsController::class . ':addopt')->add(PermissionMiddleware::class)->setName('FinCreditorsAddopt-fin_creditors-addopt'); // addopt
    $app->map(["GET","POST","OPTIONS"], '/FinCreditorsView[/{id}]', FinCreditorsController::class . ':view')->add(PermissionMiddleware::class)->setName('FinCreditorsView-fin_creditors-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinCreditorsEdit[/{id}]', FinCreditorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinCreditorsEdit-fin_creditors-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinCreditorsDelete[/{id}]', FinCreditorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinCreditorsDelete-fin_creditors-delete'); // delete
    $app->group(
        '/fin_creditors',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinCreditorsController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_creditors/list-fin_creditors-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinCreditorsController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_creditors/add-fin_creditors-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADDOPT_ACTION") . '', FinCreditorsController::class . ':addopt')->add(PermissionMiddleware::class)->setName('fin_creditors/addopt-fin_creditors-addopt-2'); // addopt
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinCreditorsController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_creditors/view-fin_creditors-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinCreditorsController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_creditors/edit-fin_creditors-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinCreditorsController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_creditors/delete-fin_creditors-delete-2'); // delete
        }
    );

    // fin_credit
    $app->map(["GET","POST","OPTIONS"], '/FinCreditList[/{id}]', FinCreditController::class . ':list')->add(PermissionMiddleware::class)->setName('FinCreditList-fin_credit-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinCreditAdd[/{id}]', FinCreditController::class . ':add')->add(PermissionMiddleware::class)->setName('FinCreditAdd-fin_credit-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinCreditView[/{id}]', FinCreditController::class . ':view')->add(PermissionMiddleware::class)->setName('FinCreditView-fin_credit-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinCreditEdit[/{id}]', FinCreditController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinCreditEdit-fin_credit-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinCreditDelete[/{id}]', FinCreditController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinCreditDelete-fin_credit-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FinCreditPreview', FinCreditController::class . ':preview')->add(PermissionMiddleware::class)->setName('FinCreditPreview-fin_credit-preview'); // preview
    $app->group(
        '/fin_credit',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinCreditController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_credit/list-fin_credit-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinCreditController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_credit/add-fin_credit-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinCreditController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_credit/view-fin_credit-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinCreditController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_credit/edit-fin_credit-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinCreditController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_credit/delete-fin_credit-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FinCreditController::class . ':preview')->add(PermissionMiddleware::class)->setName('fin_credit/preview-fin_credit-preview-2'); // preview
        }
    );

    // fin_debit
    $app->map(["GET","POST","OPTIONS"], '/FinDebitList[/{id}]', FinDebitController::class . ':list')->add(PermissionMiddleware::class)->setName('FinDebitList-fin_debit-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinDebitAdd[/{id}]', FinDebitController::class . ':add')->add(PermissionMiddleware::class)->setName('FinDebitAdd-fin_debit-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinDebitView[/{id}]', FinDebitController::class . ':view')->add(PermissionMiddleware::class)->setName('FinDebitView-fin_debit-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinDebitEdit[/{id}]', FinDebitController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinDebitEdit-fin_debit-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinDebitDelete[/{id}]', FinDebitController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinDebitDelete-fin_debit-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FinDebitPreview', FinDebitController::class . ':preview')->add(PermissionMiddleware::class)->setName('FinDebitPreview-fin_debit-preview'); // preview
    $app->group(
        '/fin_debit',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinDebitController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_debit/list-fin_debit-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinDebitController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_debit/add-fin_debit-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinDebitController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_debit/view-fin_debit-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinDebitController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_debit/edit-fin_debit-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinDebitController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_debit/delete-fin_debit-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FinDebitController::class . ':preview')->add(PermissionMiddleware::class)->setName('fin_debit/preview-fin_debit-preview-2'); // preview
        }
    );

    // fin_department
    $app->map(["GET","POST","OPTIONS"], '/FinDepartmentList[/{id}]', FinDepartmentController::class . ':list')->add(PermissionMiddleware::class)->setName('FinDepartmentList-fin_department-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinDepartmentAdd[/{id}]', FinDepartmentController::class . ':add')->add(PermissionMiddleware::class)->setName('FinDepartmentAdd-fin_department-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinDepartmentView[/{id}]', FinDepartmentController::class . ':view')->add(PermissionMiddleware::class)->setName('FinDepartmentView-fin_department-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinDepartmentEdit[/{id}]', FinDepartmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinDepartmentEdit-fin_department-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinDepartmentDelete[/{id}]', FinDepartmentController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinDepartmentDelete-fin_department-delete'); // delete
    $app->group(
        '/fin_department',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinDepartmentController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_department/list-fin_department-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinDepartmentController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_department/add-fin_department-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinDepartmentController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_department/view-fin_department-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinDepartmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_department/edit-fin_department-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinDepartmentController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_department/delete-fin_department-delete-2'); // delete
        }
    );

    // fin_discount
    $app->map(["GET","POST","OPTIONS"], '/FinDiscountList[/{id}]', FinDiscountController::class . ':list')->add(PermissionMiddleware::class)->setName('FinDiscountList-fin_discount-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinDiscountAdd[/{id}]', FinDiscountController::class . ':add')->add(PermissionMiddleware::class)->setName('FinDiscountAdd-fin_discount-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinDiscountView[/{id}]', FinDiscountController::class . ':view')->add(PermissionMiddleware::class)->setName('FinDiscountView-fin_discount-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinDiscountEdit[/{id}]', FinDiscountController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinDiscountEdit-fin_discount-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinDiscountDelete[/{id}]', FinDiscountController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinDiscountDelete-fin_discount-delete'); // delete
    $app->group(
        '/fin_discount',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinDiscountController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_discount/list-fin_discount-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinDiscountController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_discount/add-fin_discount-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinDiscountController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_discount/view-fin_discount-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinDiscountController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_discount/edit-fin_discount-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinDiscountController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_discount/delete-fin_discount-delete-2'); // delete
        }
    );

    // fin_employee
    $app->map(["GET","POST","OPTIONS"], '/FinEmployeeList[/{id}]', FinEmployeeController::class . ':list')->add(PermissionMiddleware::class)->setName('FinEmployeeList-fin_employee-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinEmployeeAdd[/{id}]', FinEmployeeController::class . ':add')->add(PermissionMiddleware::class)->setName('FinEmployeeAdd-fin_employee-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinEmployeeView[/{id}]', FinEmployeeController::class . ':view')->add(PermissionMiddleware::class)->setName('FinEmployeeView-fin_employee-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinEmployeeEdit[/{id}]', FinEmployeeController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinEmployeeEdit-fin_employee-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinEmployeeDelete[/{id}]', FinEmployeeController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinEmployeeDelete-fin_employee-delete'); // delete
    $app->group(
        '/fin_employee',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinEmployeeController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_employee/list-fin_employee-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinEmployeeController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_employee/add-fin_employee-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinEmployeeController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_employee/view-fin_employee-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinEmployeeController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_employee/edit-fin_employee-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinEmployeeController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_employee/delete-fin_employee-delete-2'); // delete
        }
    );

    // fin_order
    $app->map(["GET","POST","OPTIONS"], '/FinOrderList[/{id}]', FinOrderController::class . ':list')->add(PermissionMiddleware::class)->setName('FinOrderList-fin_order-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinOrderAdd[/{id}]', FinOrderController::class . ':add')->add(PermissionMiddleware::class)->setName('FinOrderAdd-fin_order-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinOrderView[/{id}]', FinOrderController::class . ':view')->add(PermissionMiddleware::class)->setName('FinOrderView-fin_order-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinOrderEdit[/{id}]', FinOrderController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinOrderEdit-fin_order-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinOrderDelete[/{id}]', FinOrderController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinOrderDelete-fin_order-delete'); // delete
    $app->group(
        '/fin_order',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinOrderController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_order/list-fin_order-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinOrderController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_order/add-fin_order-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinOrderController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_order/view-fin_order-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinOrderController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_order/edit-fin_order-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinOrderController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_order/delete-fin_order-delete-2'); // delete
        }
    );

    // fin_orderdetails
    $app->map(["GET","POST","OPTIONS"], '/FinOrderdetailsList[/{id}]', FinOrderdetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('FinOrderdetailsList-fin_orderdetails-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinOrderdetailsAdd[/{id}]', FinOrderdetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('FinOrderdetailsAdd-fin_orderdetails-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinOrderdetailsView[/{id}]', FinOrderdetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('FinOrderdetailsView-fin_orderdetails-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinOrderdetailsEdit[/{id}]', FinOrderdetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinOrderdetailsEdit-fin_orderdetails-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinOrderdetailsDelete[/{id}]', FinOrderdetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinOrderdetailsDelete-fin_orderdetails-delete'); // delete
    $app->map(["GET","OPTIONS"], '/FinOrderdetailsPreview', FinOrderdetailsController::class . ':preview')->add(PermissionMiddleware::class)->setName('FinOrderdetailsPreview-fin_orderdetails-preview'); // preview
    $app->group(
        '/fin_orderdetails',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinOrderdetailsController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_orderdetails/list-fin_orderdetails-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinOrderdetailsController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_orderdetails/add-fin_orderdetails-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinOrderdetailsController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_orderdetails/view-fin_orderdetails-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinOrderdetailsController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_orderdetails/edit-fin_orderdetails-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinOrderdetailsController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_orderdetails/delete-fin_orderdetails-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', FinOrderdetailsController::class . ':preview')->add(PermissionMiddleware::class)->setName('fin_orderdetails/preview-fin_orderdetails-preview-2'); // preview
        }
    );

    // fin_paymentmethod
    $app->map(["GET","POST","OPTIONS"], '/FinPaymentmethodList[/{id}]', FinPaymentmethodController::class . ':list')->add(PermissionMiddleware::class)->setName('FinPaymentmethodList-fin_paymentmethod-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinPaymentmethodAdd[/{id}]', FinPaymentmethodController::class . ':add')->add(PermissionMiddleware::class)->setName('FinPaymentmethodAdd-fin_paymentmethod-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinPaymentmethodView[/{id}]', FinPaymentmethodController::class . ':view')->add(PermissionMiddleware::class)->setName('FinPaymentmethodView-fin_paymentmethod-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinPaymentmethodEdit[/{id}]', FinPaymentmethodController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinPaymentmethodEdit-fin_paymentmethod-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinPaymentmethodDelete[/{id}]', FinPaymentmethodController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinPaymentmethodDelete-fin_paymentmethod-delete'); // delete
    $app->group(
        '/fin_paymentmethod',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinPaymentmethodController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_paymentmethod/list-fin_paymentmethod-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinPaymentmethodController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_paymentmethod/add-fin_paymentmethod-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinPaymentmethodController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_paymentmethod/view-fin_paymentmethod-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinPaymentmethodController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_paymentmethod/edit-fin_paymentmethod-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinPaymentmethodController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_paymentmethod/delete-fin_paymentmethod-delete-2'); // delete
        }
    );

    // fin_type
    $app->map(["GET","POST","OPTIONS"], '/FinTypeList[/{id}]', FinTypeController::class . ':list')->add(PermissionMiddleware::class)->setName('FinTypeList-fin_type-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/FinTypeAdd[/{id}]', FinTypeController::class . ':add')->add(PermissionMiddleware::class)->setName('FinTypeAdd-fin_type-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/FinTypeAddopt', FinTypeController::class . ':addopt')->add(PermissionMiddleware::class)->setName('FinTypeAddopt-fin_type-addopt'); // addopt
    $app->map(["GET","POST","OPTIONS"], '/FinTypeView[/{id}]', FinTypeController::class . ':view')->add(PermissionMiddleware::class)->setName('FinTypeView-fin_type-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/FinTypeEdit[/{id}]', FinTypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('FinTypeEdit-fin_type-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/FinTypeDelete[/{id}]', FinTypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('FinTypeDelete-fin_type-delete'); // delete
    $app->group(
        '/fin_type',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', FinTypeController::class . ':list')->add(PermissionMiddleware::class)->setName('fin_type/list-fin_type-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', FinTypeController::class . ':add')->add(PermissionMiddleware::class)->setName('fin_type/add-fin_type-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADDOPT_ACTION") . '', FinTypeController::class . ':addopt')->add(PermissionMiddleware::class)->setName('fin_type/addopt-fin_type-addopt-2'); // addopt
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', FinTypeController::class . ':view')->add(PermissionMiddleware::class)->setName('fin_type/view-fin_type-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', FinTypeController::class . ':edit')->add(PermissionMiddleware::class)->setName('fin_type/edit-fin_type-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', FinTypeController::class . ':delete')->add(PermissionMiddleware::class)->setName('fin_type/delete-fin_type-delete-2'); // delete
        }
    );

    // school_class
    $app->map(["GET","POST","OPTIONS"], '/SchoolClassList[/{id}]', SchoolClassController::class . ':list')->add(PermissionMiddleware::class)->setName('SchoolClassList-school_class-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SchoolClassAdd[/{id}]', SchoolClassController::class . ':add')->add(PermissionMiddleware::class)->setName('SchoolClassAdd-school_class-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/SchoolClassView[/{id}]', SchoolClassController::class . ':view')->add(PermissionMiddleware::class)->setName('SchoolClassView-school_class-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SchoolClassEdit[/{id}]', SchoolClassController::class . ':edit')->add(PermissionMiddleware::class)->setName('SchoolClassEdit-school_class-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SchoolClassDelete[/{id}]', SchoolClassController::class . ':delete')->add(PermissionMiddleware::class)->setName('SchoolClassDelete-school_class-delete'); // delete
    $app->group(
        '/school_class',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SchoolClassController::class . ':list')->add(PermissionMiddleware::class)->setName('school_class/list-school_class-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', SchoolClassController::class . ':add')->add(PermissionMiddleware::class)->setName('school_class/add-school_class-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', SchoolClassController::class . ':view')->add(PermissionMiddleware::class)->setName('school_class/view-school_class-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', SchoolClassController::class . ':edit')->add(PermissionMiddleware::class)->setName('school_class/edit-school_class-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', SchoolClassController::class . ':delete')->add(PermissionMiddleware::class)->setName('school_class/delete-school_class-delete-2'); // delete
        }
    );

    // school_modality
    $app->map(["GET","POST","OPTIONS"], '/SchoolModalityList[/{id}]', SchoolModalityController::class . ':list')->add(PermissionMiddleware::class)->setName('SchoolModalityList-school_modality-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SchoolModalityAdd[/{id}]', SchoolModalityController::class . ':add')->add(PermissionMiddleware::class)->setName('SchoolModalityAdd-school_modality-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/SchoolModalityView[/{id}]', SchoolModalityController::class . ':view')->add(PermissionMiddleware::class)->setName('SchoolModalityView-school_modality-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SchoolModalityEdit[/{id}]', SchoolModalityController::class . ':edit')->add(PermissionMiddleware::class)->setName('SchoolModalityEdit-school_modality-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SchoolModalityDelete[/{id}]', SchoolModalityController::class . ':delete')->add(PermissionMiddleware::class)->setName('SchoolModalityDelete-school_modality-delete'); // delete
    $app->group(
        '/school_modality',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SchoolModalityController::class . ':list')->add(PermissionMiddleware::class)->setName('school_modality/list-school_modality-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', SchoolModalityController::class . ':add')->add(PermissionMiddleware::class)->setName('school_modality/add-school_modality-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', SchoolModalityController::class . ':view')->add(PermissionMiddleware::class)->setName('school_modality/view-school_modality-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', SchoolModalityController::class . ':edit')->add(PermissionMiddleware::class)->setName('school_modality/edit-school_modality-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', SchoolModalityController::class . ':delete')->add(PermissionMiddleware::class)->setName('school_modality/delete-school_modality-delete-2'); // delete
        }
    );

    // school_member
    $app->map(["GET","POST","OPTIONS"], '/SchoolMemberList[/{id}]', SchoolMemberController::class . ':list')->add(PermissionMiddleware::class)->setName('SchoolMemberList-school_member-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SchoolMemberAdd[/{id}]', SchoolMemberController::class . ':add')->add(PermissionMiddleware::class)->setName('SchoolMemberAdd-school_member-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/SchoolMemberView[/{id}]', SchoolMemberController::class . ':view')->add(PermissionMiddleware::class)->setName('SchoolMemberView-school_member-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SchoolMemberEdit[/{id}]', SchoolMemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('SchoolMemberEdit-school_member-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SchoolMemberDelete[/{id}]', SchoolMemberController::class . ':delete')->add(PermissionMiddleware::class)->setName('SchoolMemberDelete-school_member-delete'); // delete
    $app->map(["GET","OPTIONS"], '/SchoolMemberPreview', SchoolMemberController::class . ':preview')->add(PermissionMiddleware::class)->setName('SchoolMemberPreview-school_member-preview'); // preview
    $app->group(
        '/school_member',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SchoolMemberController::class . ':list')->add(PermissionMiddleware::class)->setName('school_member/list-school_member-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', SchoolMemberController::class . ':add')->add(PermissionMiddleware::class)->setName('school_member/add-school_member-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', SchoolMemberController::class . ':view')->add(PermissionMiddleware::class)->setName('school_member/view-school_member-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', SchoolMemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('school_member/edit-school_member-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', SchoolMemberController::class . ':delete')->add(PermissionMiddleware::class)->setName('school_member/delete-school_member-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', SchoolMemberController::class . ':preview')->add(PermissionMiddleware::class)->setName('school_member/preview-school_member-preview-2'); // preview
        }
    );

    // school_program
    $app->map(["GET","POST","OPTIONS"], '/SchoolProgramList[/{id}]', SchoolProgramController::class . ':list')->add(PermissionMiddleware::class)->setName('SchoolProgramList-school_program-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SchoolProgramAdd[/{id}]', SchoolProgramController::class . ':add')->add(PermissionMiddleware::class)->setName('SchoolProgramAdd-school_program-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/SchoolProgramView[/{id}]', SchoolProgramController::class . ':view')->add(PermissionMiddleware::class)->setName('SchoolProgramView-school_program-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SchoolProgramEdit[/{id}]', SchoolProgramController::class . ':edit')->add(PermissionMiddleware::class)->setName('SchoolProgramEdit-school_program-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SchoolProgramDelete[/{id}]', SchoolProgramController::class . ':delete')->add(PermissionMiddleware::class)->setName('SchoolProgramDelete-school_program-delete'); // delete
    $app->group(
        '/school_program',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SchoolProgramController::class . ':list')->add(PermissionMiddleware::class)->setName('school_program/list-school_program-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', SchoolProgramController::class . ':add')->add(PermissionMiddleware::class)->setName('school_program/add-school_program-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', SchoolProgramController::class . ':view')->add(PermissionMiddleware::class)->setName('school_program/view-school_program-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', SchoolProgramController::class . ':edit')->add(PermissionMiddleware::class)->setName('school_program/edit-school_program-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', SchoolProgramController::class . ':delete')->add(PermissionMiddleware::class)->setName('school_program/delete-school_program-delete-2'); // delete
        }
    );

    // school_users
    $app->map(["GET","POST","OPTIONS"], '/SchoolUsersList[/{id}]', SchoolUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('SchoolUsersList-school_users-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SchoolUsersAdd[/{id}]', SchoolUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('SchoolUsersAdd-school_users-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/SchoolUsersView[/{id}]', SchoolUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('SchoolUsersView-school_users-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SchoolUsersEdit[/{id}]', SchoolUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('SchoolUsersEdit-school_users-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SchoolUsersDelete[/{id}]', SchoolUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('SchoolUsersDelete-school_users-delete'); // delete
    $app->map(["GET","OPTIONS"], '/SchoolUsersPreview', SchoolUsersController::class . ':preview')->add(PermissionMiddleware::class)->setName('SchoolUsersPreview-school_users-preview'); // preview
    $app->group(
        '/school_users',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SchoolUsersController::class . ':list')->add(PermissionMiddleware::class)->setName('school_users/list-school_users-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', SchoolUsersController::class . ':add')->add(PermissionMiddleware::class)->setName('school_users/add-school_users-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', SchoolUsersController::class . ':view')->add(PermissionMiddleware::class)->setName('school_users/view-school_users-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', SchoolUsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('school_users/edit-school_users-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', SchoolUsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('school_users/delete-school_users-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', SchoolUsersController::class . ':preview')->add(PermissionMiddleware::class)->setName('school_users/preview-school_users-preview-2'); // preview
        }
    );

    // tes_aproved
    $app->map(["GET","POST","OPTIONS"], '/TesAprovedList[/{id}]', TesAprovedController::class . ':list')->add(PermissionMiddleware::class)->setName('TesAprovedList-tes_aproved-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TesAprovedAdd[/{id}]', TesAprovedController::class . ':add')->add(PermissionMiddleware::class)->setName('TesAprovedAdd-tes_aproved-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TesAprovedView[/{id}]', TesAprovedController::class . ':view')->add(PermissionMiddleware::class)->setName('TesAprovedView-tes_aproved-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TesAprovedEdit[/{id}]', TesAprovedController::class . ':edit')->add(PermissionMiddleware::class)->setName('TesAprovedEdit-tes_aproved-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TesAprovedDelete[/{id}]', TesAprovedController::class . ':delete')->add(PermissionMiddleware::class)->setName('TesAprovedDelete-tes_aproved-delete'); // delete
    $app->group(
        '/tes_aproved',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', TesAprovedController::class . ':list')->add(PermissionMiddleware::class)->setName('tes_aproved/list-tes_aproved-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', TesAprovedController::class . ':add')->add(PermissionMiddleware::class)->setName('tes_aproved/add-tes_aproved-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', TesAprovedController::class . ':view')->add(PermissionMiddleware::class)->setName('tes_aproved/view-tes_aproved-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', TesAprovedController::class . ':edit')->add(PermissionMiddleware::class)->setName('tes_aproved/edit-tes_aproved-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', TesAprovedController::class . ':delete')->add(PermissionMiddleware::class)->setName('tes_aproved/delete-tes_aproved-delete-2'); // delete
        }
    );

    // tes_candidate
    $app->map(["GET","POST","OPTIONS"], '/TesCandidateList[/{id}]', TesCandidateController::class . ':list')->add(PermissionMiddleware::class)->setName('TesCandidateList-tes_candidate-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TesCandidateView[/{id}]', TesCandidateController::class . ':view')->add(PermissionMiddleware::class)->setName('TesCandidateView-tes_candidate-view'); // view
    $app->map(["GET","OPTIONS"], '/TesCandidatePreview', TesCandidateController::class . ':preview')->add(PermissionMiddleware::class)->setName('TesCandidatePreview-tes_candidate-preview'); // preview
    $app->group(
        '/tes_candidate',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', TesCandidateController::class . ':list')->add(PermissionMiddleware::class)->setName('tes_candidate/list-tes_candidate-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', TesCandidateController::class . ':view')->add(PermissionMiddleware::class)->setName('tes_candidate/view-tes_candidate-view-2'); // view
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', TesCandidateController::class . ':preview')->add(PermissionMiddleware::class)->setName('tes_candidate/preview-tes_candidate-preview-2'); // preview
        }
    );

    // tes_certificate
    $app->map(["GET","POST","OPTIONS"], '/TesCertificateList[/{id}]', TesCertificateController::class . ':list')->add(PermissionMiddleware::class)->setName('TesCertificateList-tes_certificate-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TesCertificateAdd[/{id}]', TesCertificateController::class . ':add')->add(PermissionMiddleware::class)->setName('TesCertificateAdd-tes_certificate-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TesCertificateView[/{id}]', TesCertificateController::class . ':view')->add(PermissionMiddleware::class)->setName('TesCertificateView-tes_certificate-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TesCertificateEdit[/{id}]', TesCertificateController::class . ':edit')->add(PermissionMiddleware::class)->setName('TesCertificateEdit-tes_certificate-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TesCertificateDelete[/{id}]', TesCertificateController::class . ':delete')->add(PermissionMiddleware::class)->setName('TesCertificateDelete-tes_certificate-delete'); // delete
    $app->group(
        '/tes_certificate',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', TesCertificateController::class . ':list')->add(PermissionMiddleware::class)->setName('tes_certificate/list-tes_certificate-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', TesCertificateController::class . ':add')->add(PermissionMiddleware::class)->setName('tes_certificate/add-tes_certificate-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', TesCertificateController::class . ':view')->add(PermissionMiddleware::class)->setName('tes_certificate/view-tes_certificate-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', TesCertificateController::class . ':edit')->add(PermissionMiddleware::class)->setName('tes_certificate/edit-tes_certificate-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', TesCertificateController::class . ':delete')->add(PermissionMiddleware::class)->setName('tes_certificate/delete-tes_certificate-delete-2'); // delete
        }
    );

    // tes_resultamount
    $app->map(["GET","POST","OPTIONS"], '/TesResultamountList[/{id}]', TesResultamountController::class . ':list')->add(PermissionMiddleware::class)->setName('TesResultamountList-tes_resultamount-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TesResultamountAdd[/{id}]', TesResultamountController::class . ':add')->add(PermissionMiddleware::class)->setName('TesResultamountAdd-tes_resultamount-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TesResultamountView[/{id}]', TesResultamountController::class . ':view')->add(PermissionMiddleware::class)->setName('TesResultamountView-tes_resultamount-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TesResultamountEdit[/{id}]', TesResultamountController::class . ':edit')->add(PermissionMiddleware::class)->setName('TesResultamountEdit-tes_resultamount-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TesResultamountDelete[/{id}]', TesResultamountController::class . ':delete')->add(PermissionMiddleware::class)->setName('TesResultamountDelete-tes_resultamount-delete'); // delete
    $app->group(
        '/tes_resultamount',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', TesResultamountController::class . ':list')->add(PermissionMiddleware::class)->setName('tes_resultamount/list-tes_resultamount-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', TesResultamountController::class . ':add')->add(PermissionMiddleware::class)->setName('tes_resultamount/add-tes_resultamount-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', TesResultamountController::class . ':view')->add(PermissionMiddleware::class)->setName('tes_resultamount/view-tes_resultamount-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', TesResultamountController::class . ':edit')->add(PermissionMiddleware::class)->setName('tes_resultamount/edit-tes_resultamount-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', TesResultamountController::class . ':delete')->add(PermissionMiddleware::class)->setName('tes_resultamount/delete-tes_resultamount-delete-2'); // delete
        }
    );

    // tes_test
    $app->map(["GET","POST","OPTIONS"], '/TesTestList[/{id}]', TesTestController::class . ':list')->add(PermissionMiddleware::class)->setName('TesTestList-tes_test-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TesTestAdd[/{id}]', TesTestController::class . ':add')->add(PermissionMiddleware::class)->setName('TesTestAdd-tes_test-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TesTestView[/{id}]', TesTestController::class . ':view')->add(PermissionMiddleware::class)->setName('TesTestView-tes_test-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TesTestEdit[/{id}]', TesTestController::class . ':edit')->add(PermissionMiddleware::class)->setName('TesTestEdit-tes_test-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TesTestDelete[/{id}]', TesTestController::class . ':delete')->add(PermissionMiddleware::class)->setName('TesTestDelete-tes_test-delete'); // delete
    $app->group(
        '/tes_test',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', TesTestController::class . ':list')->add(PermissionMiddleware::class)->setName('tes_test/list-tes_test-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', TesTestController::class . ':add')->add(PermissionMiddleware::class)->setName('tes_test/add-tes_test-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', TesTestController::class . ':view')->add(PermissionMiddleware::class)->setName('tes_test/view-tes_test-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', TesTestController::class . ':edit')->add(PermissionMiddleware::class)->setName('tes_test/edit-tes_test-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', TesTestController::class . ':delete')->add(PermissionMiddleware::class)->setName('tes_test/delete-tes_test-delete-2'); // delete
        }
    );

    // tes_test_judge
    $app->map(["GET","POST","OPTIONS"], '/TesTestJudgeList[/{id}]', TesTestJudgeController::class . ':list')->add(PermissionMiddleware::class)->setName('TesTestJudgeList-tes_test_judge-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/TesTestJudgeAdd[/{id}]', TesTestJudgeController::class . ':add')->add(PermissionMiddleware::class)->setName('TesTestJudgeAdd-tes_test_judge-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/TesTestJudgeView[/{id}]', TesTestJudgeController::class . ':view')->add(PermissionMiddleware::class)->setName('TesTestJudgeView-tes_test_judge-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/TesTestJudgeEdit[/{id}]', TesTestJudgeController::class . ':edit')->add(PermissionMiddleware::class)->setName('TesTestJudgeEdit-tes_test_judge-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/TesTestJudgeDelete[/{id}]', TesTestJudgeController::class . ':delete')->add(PermissionMiddleware::class)->setName('TesTestJudgeDelete-tes_test_judge-delete'); // delete
    $app->group(
        '/tes_test_judge',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', TesTestJudgeController::class . ':list')->add(PermissionMiddleware::class)->setName('tes_test_judge/list-tes_test_judge-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', TesTestJudgeController::class . ':add')->add(PermissionMiddleware::class)->setName('tes_test_judge/add-tes_test_judge-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', TesTestJudgeController::class . ':view')->add(PermissionMiddleware::class)->setName('tes_test_judge/view-tes_test_judge-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', TesTestJudgeController::class . ':edit')->add(PermissionMiddleware::class)->setName('tes_test_judge/edit-tes_test_judge-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', TesTestJudgeController::class . ':delete')->add(PermissionMiddleware::class)->setName('tes_test_judge/delete-tes_test_judge-delete-2'); // delete
        }
    );

    // audittrail
    $app->map(["GET","POST","OPTIONS"], '/AudittrailList[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('AudittrailList-audittrail-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/AudittrailAdd[/{id}]', AudittrailController::class . ':add')->add(PermissionMiddleware::class)->setName('AudittrailAdd-audittrail-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/AudittrailView[/{id}]', AudittrailController::class . ':view')->add(PermissionMiddleware::class)->setName('AudittrailView-audittrail-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/AudittrailEdit[/{id}]', AudittrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('AudittrailEdit-audittrail-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/AudittrailDelete[/{id}]', AudittrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('AudittrailDelete-audittrail-delete'); // delete
    $app->group(
        '/audittrail',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('audittrail/list-audittrail-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', AudittrailController::class . ':add')->add(PermissionMiddleware::class)->setName('audittrail/add-audittrail-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', AudittrailController::class . ':view')->add(PermissionMiddleware::class)->setName('audittrail/view-audittrail-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', AudittrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('audittrail/edit-audittrail-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', AudittrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('audittrail/delete-audittrail-delete-2'); // delete
        }
    );

    // view_alljudgemembers
    $app->map(["GET","POST","OPTIONS"], '/ViewAlljudgemembersList[/{id}]', ViewAlljudgemembersController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewAlljudgemembersList-view_alljudgemembers-list'); // list
    $app->group(
        '/view_alljudgemembers',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ViewAlljudgemembersController::class . ':list')->add(PermissionMiddleware::class)->setName('view_alljudgemembers/list-view_alljudgemembers-list-2'); // list
        }
    );

    // userlevelpermissions
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsList[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsAdd[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsView[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsEdit[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsDelete[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // view_news
    $app->map(["GET","POST","OPTIONS"], '/ViewNewsList[/{id}]', ViewNewsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewNewsList-view_news-list'); // list
    $app->group(
        '/view_news',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ViewNewsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_news/list-view_news-list-2'); // list
        }
    );

    // userlevels
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // view_test_aproveds
    $app->map(["GET","POST","OPTIONS"], '/ViewTestAprovedsList[/{id}]', ViewTestAprovedsController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewTestAprovedsList-view_test_aproveds-list'); // list
    $app->map(["GET","OPTIONS"], '/ViewTestAprovedsPreview', ViewTestAprovedsController::class . ':preview')->add(PermissionMiddleware::class)->setName('ViewTestAprovedsPreview-view_test_aproveds-preview'); // preview
    $app->group(
        '/view_test_aproveds',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ViewTestAprovedsController::class . ':list')->add(PermissionMiddleware::class)->setName('view_test_aproveds/list-view_test_aproveds-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', ViewTestAprovedsController::class . ':preview')->add(PermissionMiddleware::class)->setName('view_test_aproveds/preview-view_test_aproveds-preview-2'); // preview
        }
    );

    // view_certificate_data
    $app->map(["GET","POST","OPTIONS"], '/ViewCertificateDataList[/{testId}]', ViewCertificateDataController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewCertificateDataList-view_certificate_data-list'); // list
    $app->group(
        '/view_certificate_data',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{testId}]', ViewCertificateDataController::class . ':list')->add(PermissionMiddleware::class)->setName('view_certificate_data/list-view_certificate_data-list-2'); // list
        }
    );

    // error
    $app->map(["GET","POST","OPTIONS"], '/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->map(["GET","POST","OPTIONS"], '/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->map(["GET","POST","OPTIONS"], '/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // reset_password
    $app->map(["GET","POST","OPTIONS"], '/resetpassword', OthersController::class . ':resetpassword')->add(PermissionMiddleware::class)->setName('resetpassword');

    // change_password
    $app->map(["GET","POST","OPTIONS"], '/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // register
    $app->map(["GET","POST","OPTIONS"], '/register', OthersController::class . ':register')->add(PermissionMiddleware::class)->setName('register');

    // userpriv
    $app->map(["GET","POST","OPTIONS"], '/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        if (Route_Action($app) === false) {
            return;
        }
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
