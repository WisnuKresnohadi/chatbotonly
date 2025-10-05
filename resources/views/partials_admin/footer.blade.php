<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl px-0">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                Crafted with PASSION by <a href="https://technoinfinity.co.id/" target="_blank" class="fw-semibold"
                    style="color:#4EA971;">Techno Infinity</a>
            </div>
            <!-- <div>
        <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank">License</a>
        <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4">More Themes</a>

        <a href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

        <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block">Support</a>
      </div> -->
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('app-assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('app-assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/node-waves/node-waves.js') }}"></script>

<script src="{{ asset('app-assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('app-assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('app-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('app-assets/js/forms-selects.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('app-assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<script src="{{ url('app-assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('app-assets/js/main.js') }}"></script>


<script src="{{ url('js/content.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('app-assets/js/dashboards-analytics.js') }}"></script>
<script src="{{ asset('app-assets/js/form-wizard-numbered.js') }}"></script>
<script src="{{ asset('app-assets/js/form-wizard-validation.js') }}"></script>

@yield('page_script')
</body>

</html>
