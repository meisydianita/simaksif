<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Script JS</title>
</head>

<body>
  <!--begin::Script-->
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {
      $(document).on('submit', 'form[data-confirm]', function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
          title: 'Apakah Anda Yakin?',
          text: "Data ini akan dihapus secara permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#003580',
          cancelButtonColor: '#F25922',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          didOpen: () => {
            Swal.getPopup().style.fontSize = '13px';
            Swal.getTitle().style.fontSize = '16px';
            Swal.getHtmlContainer().style.fontSize = '13px';
          }
        }).then((result) => {
          if (result.isConfirmed) {

            Swal.fire({
              title: "Berhasil!",
              text: "Data berhasil dihapus.",
              icon: "success",
              confirmButtonText: "OK",
              timer: 3000,
              confirmButtonColor: "#003580",
              timerProgressBar: true,
              didOpen: () => {
                Swal.getPopup().style.fontSize = '13px';
                Swal.getTitle().style.fontSize = '16px';
                Swal.getHtmlContainer().style.fontSize = '13px';
              }
            }).then((result) => {
              if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                form.submit();
              }
            });


          }
        });
      });
    });
  </script>

  @if (session('success'))
  <script>
    Swal.fire({
      title: "Berhasil!",
      text: "{{ session('success') }}",
      icon: "success",
      confirmButtonText: "OK",
      confirmButtonColor: "#003580",
      timer: 3000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.getPopup().style.fontSize = '13px';
        Swal.getTitle().style.fontSize = '16px';
        Swal.getHtmlContainer().style.fontSize = '13px';
      }
    });
  </script>
  @endif

  @if (session('info'))
  <script>
    Swal.fire({
      title: "Info",
      text: "{{ session('info') }}",
      icon: "info",
      confirmButtonText: "OK",
      confirmButtonColor: "#003580",
      timer: 3000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.getPopup().style.fontSize = '13px';
        Swal.getTitle().style.fontSize = '16px';
        Swal.getHtmlContainer().style.fontSize = '13px';
      }
    });
  </script>
  @endif

  @if (session('error'))
  <script>
    Swal.fire({
      title: "Gagal!",
      html: `{!! session('error') !!}`,
      icon: "error",
      confirmButtonText: "OK",
      confirmButtonColor: "#003580",
      didOpen: () => {
        Swal.getPopup().style.fontSize = '13px';
        Swal.getTitle().style.fontSize = '16px';
        Swal.getHtmlContainer().style.fontSize = '13px';
      }
    });
  </script>
  @endif
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });


    (() => {
      "use strict";

      const storedTheme = localStorage.getItem("theme");

      const getPreferredTheme = () => {
        if (storedTheme) {
          return storedTheme;
        }

        return window.matchMedia("(prefers-color-scheme: dark)").matches ?
          "dark" :
          "light";
      };

      const setTheme = function(theme) {
        if (
          theme === "auto" &&
          window.matchMedia("(prefers-color-scheme: dark)").matches
        ) {
          document.documentElement.setAttribute("data-bs-theme", "dark");
        } else {
          document.documentElement.setAttribute("data-bs-theme", theme);
        }
      };

      setTheme(getPreferredTheme());

      const showActiveTheme = (theme, focus = false) => {
        const themeSwitcher = document.querySelector("#bd-theme");
        if (!themeSwitcher) return;

        const themeSwitcherText = document.querySelector("#bd-theme-text");
        const activeThemeIcon = document.querySelector(".theme-icon-active i");
        const btnToActive = document.querySelector(
          `[data-bs-theme-value="${theme}"]`
        );

        for (const element of document.querySelectorAll("[data-bs-theme-value]")) {
          element.classList.remove("active");
          element.setAttribute("aria-pressed", "false");
        }

        btnToActive.classList.add("active");
        btnToActive.setAttribute("aria-pressed", "true");
        activeThemeIcon.className =
          btnToActive.querySelector("i").className;

        if (focus) themeSwitcher.focus();
      };

      window.addEventListener("DOMContentLoaded", () => {
        showActiveTheme(getPreferredTheme());

        for (const toggle of document.querySelectorAll("[data-bs-theme-value]")) {
          toggle.addEventListener("click", () => {
            const theme = toggle.getAttribute("data-bs-theme-value");
            localStorage.setItem("theme", theme);
            setTheme(theme);
            showActiveTheme(theme, true);
          });
        }
      });
    })();

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');

      // CEK DULU APAKAH ELEMENTNYA ADA
      if (searchInput) {
        // Enter = submit
        searchInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            this.form.submit();
          }
        });

        // Ketik = delay 50ms lalu submit (debounce)
        let timeout;
        searchInput.addEventListener('input', function() {
          clearTimeout(timeout);
          timeout = setTimeout(() => {
            if (this.value.length >= 0) {
              this.form.submit();
            }
          }, 50);
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->
  <!--end::Script-->
  <style>
    .toast-white {
      background-color: #ffffff;
      color: #212529;
      box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
      border-left: 5px solid transparent;
    }

    .toast-white.success {
      border-left-color: #198754;
    }

    .toast-white.danger {
      border-left-color: #dc3545;
    }

    .toast-white.info {
      border-left-color: #003580;
    }

    .toast-white .btn-close {
      filter: invert(0);
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const toastMessages = [{
          message: "{{ session('login_success_dashboard') }}",
          type: "success"
        },
        {
          message: "{{ session('error_dashboard') }}",
          type: "danger"
        },
        {
          message: "{{ session('logout') }}",
          type: "info"
        }
      ];

      toastMessages
        .filter(t => t.message !== "")
        .forEach(t => {
          const container = document.createElement('div');
          container.className = 'toast-container position-fixed top-0 end-0 p-3';

          container.innerHTML = `
          <div class="toast toast-white ${t.type}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body">${t.message}</div>
              <button type="button"
                class="btn-close me-2 m-auto"
                data-bs-dismiss="toast"></button>
            </div>
          </div>
        `;

          document.body.appendChild(container);

          bootstrap.Toast
            .getOrCreateInstance(container.querySelector('.toast'), {
              delay: 3000,
              autohide: true
            })
            .show();
        });

    });
  </script>

  <script>
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: "Cari nama penanggungjawab",
        allowClear: true,
        width: '100%',
        language: {
          noResults: function() {
            return "Data tidak ditemukan";
          },
          searching: function() {
            return "Mencari...";
          }
        }
      });
    });
  </script>



</body>

</html>