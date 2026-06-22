document.addEventListener("DOMContentLoaded", function () {
    var collapseElements = document.querySelectorAll(".collapse");
    var arrowIcons = document.querySelectorAll(".arrow-icon");

    collapseElements.forEach(function (collapseElement, index) {
      var arrowIcon = arrowIcons[index - 1];

      collapseElement.addEventListener("show.bs.collapse", function () {
        arrowIcon.classList.remove("bi-chevron-left");
        arrowIcon.classList.add("bi-chevron-down");
      });

      collapseElement.addEventListener("hide.bs.collapse", function () {
        arrowIcon.classList.remove("bi-chevron-down");
        arrowIcon.classList.add("bi-chevron-left");
      });
    });
  });