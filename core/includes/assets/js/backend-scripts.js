"use strict";
window.addEventListener("load", (e) => {
  let viewport,
    content,
    columnStyle,
    gridStyle,
    container,
    containerStyle,
    active = false,
    gridContainer = false,
    gridCount = 0,
    width = ongridlayout.width,
    color = ongridlayout.color,
    zindex,
    zindexOne = ongridlayout.zindex,
    zindexTwo,
    gap = ongridlayout.gap,
    gapPX,
    gapMinuxPX,
    widthCalc,
    numberOfGrids = 4;

  zindexOne === "0" ? (zindexTwo = -1) : (zindexTwo = 0);

  // Creates buttons inside Oxygen UI Toolbar
  let ui = `<div id="grid-layout-ui-buttons"><div class="grid-layout-ui-column">
  <div id="grid-layout-ui-box-1"class="grid-layout-ui-box">
  <input id="ogl-ui-color" style="background-color: ${color}" type="color" value="${color}">
  </div><div class="grid-layout-ui-long">
  <input id="ogl-input-width" onfocus="this.value=''" type="number" value="${width}"/>
  </div></div><div class="grid-layout-ui-column"><div class="grid-layout-ui-box">
  <select id="ogl-input-z"><option value="${zindexTwo}">${zindexTwo}</option>
  <option value="${zindexOne}">${zindexOne}</option></select></div><div class="grid-layout-ui-box">
  <input id="ogl-layout-gap" onfocus="this.value=''" type="number" value="${gap}">
  </div><div id="gridOK" class="grid-layout-ui-box" onclick="$scope.setGridLayout()">${numberOfGrids}
  </div></div></div>`;

  document
    .querySelector(".oxygen-toolbar-panels")
    .insertAdjacentHTML("beforeend", ui);

  if (!active) {
    viewport = document.getElementById("ct-artificial-viewport");
    content = viewport.contentWindow || viewport.contentDocument;
    columnStyle = content.document.querySelectorAll(".ogl_column");
    gridStyle = content.document.getElementsByClassName("ogl_grid")[0];

    document
      .querySelector("#ogl-ui-color")
      .addEventListener("change", function () {
        color = this.value;
        document
          .getElementById("ogl-ui-color")
          .style.setProperty("background-color", color);
        columnStyle.forEach((pcs) => {
          pcs.style.setProperty("background-color", color);
        });
      });

    document
      .querySelector("#ogl-input-z")
      .addEventListener("change", function () {
        zindex = this.value;
        containerStyle = content.document.getElementsByClassName(
          "ogl_container",
        )[0];
        containerStyle.style.setProperty("z-index", zindex);
      });

    document
      .querySelector("#ogl-layout-gap")
      .addEventListener("change", function () {
        gap = this.value;
        gapPX = `0 ${gap / 2}px`;
        gapMinuxPX = `0 -${gap / 2}px`;
        gridStyle.style.setProperty("margin", gapMinuxPX);
        columnStyle.forEach((pcs) => {
          pcs.style.setProperty("margin", gapPX);
        });
      });

    document
      .querySelector("#ogl-input-width")
      .addEventListener("change", function () {
        width = this.value;
        if (width === "100" || width === "1") {
          width = "100%";
          widthCalc = `calc(${width} + ${gap}px)`;
        } else {
          widthCalc = `calc(${width}px + ${gap}px)`;
        }
        gridStyle.style.setProperty("width", widthCalc);
      });
  }

  // Checks input fields for values and set them + deploy grid
  $scope.setGridLayout = () => {
    gap = document.getElementById("ogl-layout-gap").value;
    gapPX = `0 ${gap / 2}px`;
    gapMinuxPX = `0 -${gap / 2}px`;
    color = document.getElementById("ogl-ui-color").value;
    zindex = document.getElementById("ogl-input-z").value;
    width = document.getElementById("ogl-input-width").value;
    if (width === "100" || width === "1") {
      width = "100%";
      widthCalc = `calc(${width} + ${gap}px)`;
    } else {
      widthCalc = `calc(${width}px + ${gap}px)`;
    }
    gridLayout();
  };

  function gridLayout() {
    // Find ct-builder (Waldo)
    viewport = document.getElementById("ct-artificial-viewport");
    content = viewport.contentWindow || viewport.contentDocument;
    let builder = content.document.getElementById("ct-builder");
    let div = document.createElement("div");
    if (!active) {
      if (!gridContainer) {
        // Insert ogl_container inside ct-builder
        div.className = "ogl_container";
        builder.appendChild(div);
        // Insert style for ogl_container
        containerStyle = content.document.getElementsByClassName(
          "ogl_container",
        )[0];
        containerStyle.style.setProperty("display", "flex");
        containerStyle.style.setProperty("justify-content", "center");
        containerStyle.style.setProperty("width", "100%");
        containerStyle.style.setProperty("position", "fixed");
        containerStyle.style.setProperty("height", "100vh");
        containerStyle.style.setProperty("pointer-events", "none");
        containerStyle.style.setProperty("z-index", zindex);
        containerStyle.style.setProperty("top", "0");
        // Insert div ogl_grid inside ogl_container
        container = content.document.querySelector(".ogl_container");
        div = document.createElement("div");
        div.className = "ogl_grid";
        container.appendChild(div);
        // Insert style for ogl_grid
        gridStyle = content.document.getElementsByClassName("ogl_grid")[0];
        gridStyle.style.setProperty("display", "flex");
        gridStyle.style.setProperty("justify-content", "space-between");
        gridStyle.style.setProperty("width", widthCalc);
        gridStyle.style.setProperty("margin", gapMinuxPX);
        gridContainer = true;
      }
      if (gridContainer) {
        // Create 6x ogl_column inside ogl_grid
        for (var i = 0; i < 4; i++) {
          let ogl_gridColumn = content.document.querySelector(".ogl_grid");
          div = document.createElement("div");
          div.className = "ogl_column";
          ogl_gridColumn.appendChild(div);
          numberOfGrids = numberOfGrids + 1;
          if (gridCount === 2) {
            numberOfGrids = 0;
          }
          document.getElementById("gridOK").textContent = numberOfGrids;
        }
        // Insert style for each ogl_column
        columnStyle = content.document.querySelectorAll(".ogl_column");
        columnStyle.forEach((pcs) => {
          pcs.style.setProperty("width", "100%");
          pcs.style.setProperty("background-color", color);
          pcs.style.setProperty("opacity", "35%");
          pcs.style.setProperty("margin", gapPX);
          pcs.style.setProperty("hight", "100vh");
        });
        if (gridCount === 2) {
          // Stops creating other columns
          active = true;
          gridContainer = false;
        }
        gridCount++;
      }
    } else if (active) {
      // Remove whole grid if var active is true
      const elements = content.document.getElementsByClassName("ogl_container");
      while (elements.length > 0) elements[0].remove();
      active = false;
      gridCount = 0;
      numberOfGrids = 4;
      document.getElementById("gridOK").textContent = numberOfGrids;
    }
  }
});
