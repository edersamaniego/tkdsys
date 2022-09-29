/*!
 * Detail Preview for PHPMaker v2022.11.0
 * Copyright (c) e.World Technology Limited. All rights reserved.
 */
(function ($, ew) {
  'use strict';

  function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

  var $__default = /*#__PURE__*/_interopDefaultLegacy($);
  var ew__default = /*#__PURE__*/_interopDefaultLegacy(ew);

  ew__default["default"].PREVIEW_TEMPLATE = "<div class=\"ew-nav\"><!-- .ew-nav -->\n    <ul class=\"nav nav-tabs\" role=\"tablist\"></ul>\n    <div class=\"tab-content\"><!-- .tab-content -->\n        <div class=\"tab-pane fade\" role=\"tabpanel\"></div>\n    </div><!-- /.tab-content -->\n</div><!-- /.ew-nav -->";
  ew__default["default"].PREVIEW_LOADING_HTML = '<div class="' + ew__default["default"].spinnerClass + ' m-3 ew-loading" role="status"><span class="visually-hidden">' + ew__default["default"].language.phrase("Loading") + '</span></div>';
  ew__default["default"].PREVIEW_MODAL_HTML = '<div id="ew-preview-dialog" class="' + ew__default["default"].PREVIEW_MODAL_CLASS + '" role="dialog" aria-hidden="true"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' + ew__default["default"].language.phrase("CloseBtn") + '</button></div></div></div></div>';
  ew__default["default"].PREVIEW_MODAL_OPTIONS = {};
  ew__default["default"].PREVIEW_MODAL_DIALOG = null;
  ew__default["default"].PREVIEW_OFFCANVAS_HTML = "<div id=\"ew-preview-offcanvas\" class=\"offcanvas offcanvas-" + ew__default["default"].PREVIEW_OFFCANVAS_PLACEMENT + "\" data-bs-scroll=\"true\" tabindex=\"-1\" aria-labelledby=\"ew-preview-offcanvas-label\"><div class=\"offcanvas-header\"><h5 id=\"ew-preview-offcanvas-label\">" + ew__default["default"].language.phrase("Details") + "</h5><button type=\"button\" class=\"btn-close text-reset\" data-bs-dismiss=\"offcanvas\" aria-label=\"Close\"></button></div><div class=\"offcanvas-body\"></div></div>";
  ew__default["default"].PREVIEW_OFFCANVAS_OPTIONS = {};
  ew__default["default"].PREVIEW_OFFCANVAS_SIDEBAR = null; // Add preview row

  let addRowToTable = function (r) {
    let $r = $__default["default"](r),
        $tb = $r.closest("tbody"),
        row;

    if (ew__default["default"].PREVIEW_SINGLE_ROW) {
      $tb.find("tr.ew-table-preview-row").remove();
      $tb.find("tr[aria-expanded]").not(r).attr("aria-expanded", "false");
    }

    let colSpan = Array.from(r.cells).reduce((acc, cur) => acc + cur.colSpan, 0),
        $sr = $r.nextAll("tr[data-rowindex!=" + $r.data("rowindex") + "]").first();

    if ($sr.hasClass("ew-table-preview-row")) {
      // Preview row exists
      return $sr[0];
    } else if (row = $tb[0].insertRow($sr[0] ? $sr[0].sectionRowIndex : -1)) {
      // Insert a new row
      $__default["default"](row).addClass("ew-table-preview-row expandable-body");
      $__default["default"](row.insertCell(0)).addClass("ew-table-last-col").prop("colSpan", colSpan);
    }

    return row;
  }; // Show preview row

  let showPreviewRow = function () {
    let $el = $__default["default"](this).closest("tr"),
        isRow = $el.is("tr[data-rowindex]"),
        $r = isRow ? $el : $el.closest("tr[data-rowindex]"),
        $content = $r.find("[class$=_preview] .ew-preview"),
        $tbl = $r.closest("table");
    if (!$r[0] || !$content[0]) return;

    if ($r.attr("aria-expanded") === "true") {
      let row = addRowToTable($r[0]),
          $cell = $__default["default"](row.cells[0]),
          id = "target" + ew__default["default"].random();
      $cell.empty(); // Note: do not chain

      $cell.append(ew__default["default"].PREVIEW_TEMPLATE); // Append the contents

      $cell.children().slideUp(0);
      $cell.find(".nav-tabs, .nav-pills").append($content.find(".nav-item").clone(true)); // Append tabs

      $cell.find(".tab-pane").attr("id", id);
      $cell.find("[data-bs-toggle='tab']").attr({
        "data-bs-target": "#" + id,
        "aria-controls": id
      }) // Setup tabs
      .first().tab("show"); // Show the first tab

      $cell.children().slideDown(500); // Match AdminLTE ExpandableTable
    }

    ew__default["default"].setupTable(-1, $tbl[0], true); // ew.fixLayoutHeight();
  }; // Setup preview popover

  let detailPopover = function (i, btn) {
    var _bootstrap$Tooltip$ge;

    if (bootstrap.Popover.getInstance(btn)) return;
    let $parent = $__default["default"](btn.closest(".ew-list-option-body"));
    (_bootstrap$Tooltip$ge = bootstrap.Tooltip.getInstance(btn)) == null ? void 0 : _bootstrap$Tooltip$ge.dispose(); // Dispose tooltip, if any

    btn = btn.closest(ew__default["default"].PREVIEW_SELECTOR);
    if (!btn) return;
    if (!btn.classList.contains("ew-preview-btn")) btn.classList.add("ew-preview-btn");
    let inst = new bootstrap.Popover(btn, {
      html: true,
      delay: ew__default["default"].PREVIEW_POPOVER_DELAY,
      placement: ew__default["default"].PREVIEW_POPOVER_PLACEMENT,
      container: document.getElementById("ew-tooltip"),
      content: ew__default["default"].PREVIEW_LOADING_HTML,
      sanitizeFn: ew__default["default"].sanitizeFn,
      customClass: "ew-preview-popover",
      trigger: ew__default["default"].PREVIEW_POPOVER_TRIGGER == "click" ? "click" : "manual"
    });
    let $tip = $__default["default"](inst.getTipElement());
    btn.addEventListener("show.bs.popover", () => {
      var _getActivePopover;

      return (_getActivePopover = getActivePopover()) == null ? void 0 : _getActivePopover.hide();
    });
    btn.addEventListener("shown.bs.popover", () => {
      let id = "target" + ew__default["default"].random();
      $tip.find(".popover-body").empty().html(ew__default["default"].PREVIEW_TEMPLATE); // Add the preview template

      $tip.find(".nav-tabs, .nav-pills").append($parent.find(".nav-item").clone(true)); // Append tabs

      $tip.find(".tab-pane").attr("id", id);
      $tip.find("[data-bs-toggle='tab']").attr({
        "data-bs-target": "#" + id,
        "aria-controls": id
      }) // Setup tabs
      .first().tab("show"); // Show the first tab
    });

    if (ew__default["default"].PREVIEW_POPOVER_TRIGGER != "click") {
      btn.addEventListener(ew__default["default"].PREVIEW_POPOVER_TRIGGER, function () {
        var _bootstrap$Popover$ge;

        if (this.getAttribute("aria-describedby")) // Showing
          return;
        (_bootstrap$Popover$ge = bootstrap.Popover.getInstance(this)) == null ? void 0 : _bootstrap$Popover$ge.show();
      });
    }
  }; // Setup preview modal

  let detailModal = function (i, btn) {
    var _bootstrap$Tooltip$ge2;

    (_bootstrap$Tooltip$ge2 = bootstrap.Tooltip.getInstance(btn)) == null ? void 0 : _bootstrap$Tooltip$ge2.dispose(); // Dispose tooltip, if any

    btn = btn.closest(ew__default["default"].PREVIEW_SELECTOR);
    if (!btn) return;
    if (!btn.classList.contains("ew-preview-btn")) btn.classList.add("ew-preview-btn");
    btn.addEventListener("click", () => {
      ew__default["default"].PREVIEW_MODAL_DIALOG.attr("data-parent-id", this.closest("[id^=el]").id).modal("hide"); // Find id="el<n>_tablename_preview"

      ew__default["default"].PREVIEW_MODAL_DIALOG.modal("show");
    });
  }; // Setup preview offcanvas

  let detailOffcanvas = function (i, btn) {
    var _bootstrap$Tooltip$ge3;

    (_bootstrap$Tooltip$ge3 = bootstrap.Tooltip.getInstance(btn)) == null ? void 0 : _bootstrap$Tooltip$ge3.dispose(); // Dispose tooltip, if any

    btn = btn.closest(ew__default["default"].PREVIEW_SELECTOR);
    if (!btn) return;
    if (!btn.classList.contains("ew-preview-btn")) btn.classList.add("ew-preview-btn");
    btn.addEventListener("click", () => {
      ew__default["default"].PREVIEW_OFFCANVAS_SIDEBAR.attr("data-parent-id", this.closest("[id^=el]").id).offcanvas("hide"); // Find id="el<n>_tablename_preview"

      ew__default["default"].PREVIEW_OFFCANVAS_SIDEBAR.offcanvas("show");
    });
  }; // Tab "show" event

  let tabShow = function (e) {
    let el = e.currentTarget,
        target = el.dataset.bsTarget || el.closest(".tab-pane"); // Tab or Paging/Sorting links

    if (!target) return;
    let $el = $__default["default"](el),
        $target = $__default["default"](target),
        url = el.dataset.url,
        start = $el.data("start"),
        // Get as number
    table = el.dataset.table,
        sort = el.dataset.sort,
        sortOrder = el.dataset.sortOrder,
        params = "",
        data;

    if (url) {
      // Tab
      data = $target.data(table) || {};
      data.url = url;
      start = data.start || 1;
      sort = data.sort;
      sortOrder = data.sortOrder;
    } else if (start) {
      // Paging link
      $el.tooltip("hide");
      data = $target.data(table);
      url = data.url;
      data.start = start || 1;
      sort = data.sort;
      sortOrder = data.sortOrder;
    } else if (sort) {
      // Sorting link
      data = $target.data(table);
      url = data.url;
      if (sort !== data.sort || sortOrder !== data.sortOrder) // Reset
        data.start = start = 1;else start = data.start;
      data.sort = sort;
      data.sortOrder = sortOrder;
    }

    $target.data(table, data).empty().html(ew__default["default"].PREVIEW_LOADING_HTML);
    if ($__default["default"].isNumber(start)) params += "&start=" + start;

    if (sort) {
      params += "&sort=" + encodeURIComponent(sort);
      if (["ASC", "DESC", "NO"].includes(sortOrder)) params += "&sortorder=" + sortOrder;
      if (e.shiftKey && !e.ctrlKey) params += "&cmd=resetsort";else if (e.ctrlKey && $el.data("sortType") == 2) params += "&ctrl=1";
    }

    $__default["default"].get(url + params, data => {
      $target.empty().html(data); // Append the detail records

      let selector = ".ew-detail-btn-group[data-table='" + table + "'][data-url='" + url + "']",
          $btns = $target.closest(".ew-nav").find(selector); // Detail buttons

      if (!$btns[0]) // Maybe moved to body
        $btns = $__default["default"]("body").children(selector);

      if ($btns.is("div")) {
        // Buttons
        $target.append($btns.removeClass("d-none")); // Append the buttons
      } else if ($btns.is("ul")) {
        // Dropdown menu
        let $navitem = $el.closest(".nav-item").addClass("dropdown"),
            $dropbtn = $navitem.find(".dropdown-toggle").addClass("active").removeClass("d-none");

        if (!$dropbtn[0]) {
          $dropbtn = $el.clone();
          $dropbtn.addClass("dropdown-toggle") // Change nav link to dropdown button
          .attr({
            "data-bs-toggle": "dropdown",
            "data-bs-target": null,
            "role": "button"
          }); // Note: Remove data-bs-target attribute

          $navitem.prepend($dropbtn); // Note: Use .prepend()

          $el.on("hide.bs.tab", () => {
            $navitem.removeClass("dropdown").find($el).removeClass("d-none active");
            $navitem.find(".dropdown-toggle").addClass("d-none").removeClass("active show");
          });
        }

        $el.addClass("d-none");
      }

      $target.find(".ew-pager .btn:not(.disabled), .ew-table-header > th > div[data-sort]").data({
        "target": target,
        "table": table
      }).on("click", tabShow); // Setup buttons for paging/sorting

      $__default["default"](document).trigger($__default["default"].Event("preview", {
        target: $target[0],
        $tabpane: $target
      }));
    }).done(() => {
      var _getActivePopover2, _bootstrap$Modal$getI;

      (_getActivePopover2 = getActivePopover()) == null ? void 0 : _getActivePopover2.update(); // Update popover

      let modal = document.querySelector("#ew-preview-dialog");
      if (modal != null && modal.classList.contains("show")) (_bootstrap$Modal$getI = bootstrap.Modal.getInstance(modal)) == null ? void 0 : _bootstrap$Modal$getI.handleUpdate(); // Update modal
    });
  }; // Tab "hide" event

  let tabHide = function (e) {
    // Dispose dropdowns inside the tab
    $__default["default"](e.currentTarget.dataset.bsTarget).find(".dropdown-toggle[id]").dropdown("dispose"); // Hide all other dropdown menus

    let container = e.currentTarget.closest(".popover, .modal, .nav");
    if (container) $__default["default"](container).find(".dropdown-toggle").dropdown("hide");
  }; // Get active preview button

  let getActivePopover = () => {
    let popover = document.querySelector(".ew-preview-popover.show");
    if (!popover) // Popover closed
      return null;
    let btn = document.querySelector(".ew-preview-btn[aria-describedby='" + popover.id + "']");
    if (btn) return bootstrap.Popover.getInstance(btn);
    return null;
  }; // Default preview event

  let preview = function (e) {
    ew__default["default"].lazyLoad(e); // Load images

    ew__default["default"].initPanels(e.$tabpane[0]); // Init panels

    e.$tabpane.find("table.ew-table").each(ew__default["default"].setupTable); // Setup the table

    ew__default["default"].initTooltips(e); // Init tooltips

    ew__default["default"].initLightboxes(e); // Init lightboxes

    ew__default["default"].initIcons(e); // Init icons
  }; // Init expandable table

  let initExpandableTable = function (e) {
    var _e$target;

    let el = (_e$target = e == null ? void 0 : e.target) != null ? _e$target : document;
    $__default["default"](el).find("tr[data-rowindex][data-widget='expandable-table']").on("expanded.lte.expandableTable", showPreviewRow); // Add "expanded" handler to rows
  }; // Init tabs

  let initTabs = function (e) {
    var _e$target2;

    let el = (_e$target2 = e == null ? void 0 : e.target) != null ? _e$target2 : document;
    $__default["default"](el).find(".ew-preview [data-bs-toggle='tab']").on("show.bs.tab", tabShow).on("hide.bs.tab", tabHide);
  }; // Extend

  Object.assign(ew__default["default"], {
    showPreviewRow,
    detailPopover,
    detailModal,
    detailOffcanvas
  }); // Init preview

  $__default["default"](function () {
    // Handle "preview" event
    $__default["default"](document).on("preview", preview); // Setup events and tab links

    if (ew__default["default"].PREVIEW_POPOVER) {
      // Popover
      $__default["default"](".ew-preview-btn").each(detailPopover);
      document.addEventListener("click", evt => {
        var _getActivePopover3;

        if (!evt.target.closest(".ew-preview-popover")) // Outside popover
          (_getActivePopover3 = getActivePopover()) == null ? void 0 : _getActivePopover3.hide(); // Outside popover
      });
    } else if (ew__default["default"].PREVIEW_MODAL) {
      // Modal
      if (!document.getElementById("ew-preview-dialog")) $__default["default"]("body").append(ew__default["default"].PREVIEW_MODAL_HTML);
      ew__default["default"].PREVIEW_MODAL_DIALOG = $__default["default"]("#ew-preview-dialog").modal(ew__default["default"].PREVIEW_MODAL_OPTIONS);
      $__default["default"]("#ew-preview-dialog").on("show.bs.modal", function () {
        $__default["default"](this).find(".modal-body").empty().html(ew__default["default"].PREVIEW_TEMPLATE); // Add the preview template
      }).on("shown.bs.modal", function (e) {
        let $this = $__default["default"](this),
            id = "target" + ew__default["default"].random();
        $this.find(".nav-tabs, .nav-pills").append($__default["default"]("#" + this.dataset.parentId).find(".nav-item").clone(true)); // Append tabs

        $this.find(".tab-pane").attr("id", id);
        $this.find("[data-bs-toggle='tab']").attr({
          "data-bs-target": "#" + id,
          "aria-controls": id
        }) // Setup tabs
        .first().tab("show"); // Show the first tab
      });
      $__default["default"](".ew-preview-btn").each(detailModal);
    } else if (ew__default["default"].PREVIEW_OFFCANVAS) {
      // Offcanvas
      if (!document.getElementById("ew-preview-offcanvas")) $__default["default"]("body").append(ew__default["default"].PREVIEW_OFFCANVAS_HTML);
      ew__default["default"].PREVIEW_OFFCANVAS_SIDEBAR = $__default["default"]("#ew-preview-offcanvas").offcanvas(ew__default["default"].PREVIEW_OFFCANVAS_OPTIONS);
      $__default["default"]("#ew-preview-offcanvas").on("show.bs.offcanvas", function () {
        $__default["default"](this).find(".offcanvas-body").empty().html(ew__default["default"].PREVIEW_TEMPLATE); // Add the preview template
      }).on("shown.bs.offcanvas", function () {
        let $this = $__default["default"](this),
            id = "target" + ew__default["default"].random();
        $this.find(".nav-tabs, .nav-pills").append($__default["default"]("#" + this.dataset.parentId).find(".nav-item").clone(true)); // Append tabs

        $this.find(".tab-pane").attr("id", id);
        $this.find("[data-bs-toggle='tab']").attr({
          "data-bs-target": "#" + id,
          "aria-controls": id
        }) // Setup tabs
        .first().tab("show"); // Show the first tab
      });
      $__default["default"](".ew-preview-btn").each(detailOffcanvas);
    } else if (ew__default["default"].PREVIEW_ROW) {
      // Preview rows
      initExpandableTable();
    }

    initTabs();
    $__default["default"](".ew-multi-column-grid").on("layout", function (e) {
      if (ew__default["default"].PREVIEW_ROW) initExpandableTable(e);
      initTabs(e);
    });
  });

})(jQuery, ew);
