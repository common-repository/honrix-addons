function honrix_close_menus(node) {
  var nodes = node.querySelectorAll(".sub-menu-display");
  nodes.forEach(function (item) {
    item.classList.remove("sub-menu-display");
  });
  node.classList.remove("sub-menu-display");

  var nodes = node.querySelectorAll(".rotate-after");
  nodes.forEach(function (item) {
    item.classList.remove("rotate-after");
  });
}

function open_honrix_menu(e) {
  if (e.className == "hrix-navbar-toggler collapsed") {
    e.classList.remove("collapsed");
    var menu = e.nextElementSibling;
    menu.classList.add("collapsed");
    honrix_menu_state = 1;
  } else {
    e.classList.add("collapsed");
    var menu = e.nextElementSibling;
    menu.classList.remove("collapsed");
    honrix_close_menus(menu);
    honrix_menu_state = 0;
  }
}

jQuery(document).ready(function () {
  if (window.innerWidth > 767) {
    var submenus = document.querySelectorAll(".hrix-menu .sub-menu");
    var offset = 0;
    submenus.forEach(function (submenu) {
      if (
        submenu.getBoundingClientRect().left + submenu.clientWidth >
        window.innerWidth
      ) {
        if (offset == 0) {
          submenu.style.left = "-100%";
          offset = 1;
        } else {
          submenu.style.left = "100%";
          offset = 0;
        }
      }
    });
  }

  if (window.innerWidth < 992) {
    document.addEventListener("click", function () {
      var nodes = document.querySelectorAll(".hrix-menu .sub-menu-display");
      nodes.forEach(function (item) {
        item.classList.remove("sub-menu-display");
      });

      open_honrix_menu(
        document.querySelector(".hrix-menu .hrix-navbar-toggler")
      );
    });

    document
      .querySelector(".hrix-menu")
      .addEventListener("click", function (event) {
        event.stopPropagation();
      });
    jQuery(".hrix-menu .hrix-navbar-nav li.menu-item-has-children > a").on(
      "click",
      function (e) {
        e.preventDefault();
        var node = this.nextElementSibling;
        if (node.className == "sub-menu") {
          node.classList.add("sub-menu-display");
          this.classList.add("rotate-after");
        } else {
          honrix_close_menus(node);
          this.classList.remove("rotate-after");
        }
      }
    );
  }
});
