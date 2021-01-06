        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" />
        <script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
          $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo base_url( 'assets/plugins/bootstrap/js/bootstrap.bundle.min.js' ); ?>"></script>

        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php echo base_url( 'assets/plugins/morris/morris.min.js' ); ?>"></script>
        <!-- Sparkline -->
        <script src="<?php echo base_url( 'assets/plugins/sparkline/jquery.sparkline.min.js' ); ?>"></script>
        <!-- jvectormap -->
        <script src="<?php echo base_url( 'assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js' ); ?>"></script>
        <script src="<?php echo base_url( 'assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js' ); ?>"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo base_url( 'assets/plugins/knob/jquery.knob.js' ); ?>"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="<?php echo base_url( 'assets/plugins/daterangepicker/daterangepicker.js' ); ?>"></script>
        <!-- color picker -->
        <script src="<?php echo base_url( 'assets/plugins/colorpicker/bootstrap-colorpicker.min.js' ); ?>"></script>
        <!-- datepicker -->
        <script src="<?php echo base_url( 'assets/plugins/datepicker/bootstrap-datepicker.js' ); ?>"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url( 'assets/ckeditor4/ckeditor.js');?>"></script>
        
        <!-- AdminLTE App(This is sidebar and nav action) -->
        <script src="<?php echo base_url( 'assets/dist/js/adminlte.js' ); ?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url( 'assets/dist/js/demo.js' ); ?>"></script>
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url('assets/select2/select2.min.css'); ?>">
        <script src="<?php echo base_url( 'assets/select2/select2.full.min.js' ); ?>"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();                                    
            });
        </script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url( 'assets/plugins/jquery/jquery.dropdown.css' ); ?>">
        <script src="<?php echo base_url( 'assets/plugins/jquery/jquery.dropdown.js' ); ?>"></script>
        <!-- For Calendar -->
        <script src="<?php echo base_url('assets/fullcalendar/js/moment.min.js');?>"></script>
        <script src="<?php echo base_url('assets/fullcalendar/js/fullcalendar.min.js');?>"></script>
        <script src="<?php echo base_url('assets/fullcalendar/js/icheck.min.js');?>"></script>
        <!-- openstreetmap leaflet js -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
        <!-- Load Esri Leaflet from CDN -->
        <script src="https://unpkg.com/esri-leaflet"></script>

        <!-- Esri Leaflet Geocoder -->
        <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css">
        <script src="https://unpkg.com/esri-leaflet-geocoder"></script>
        <script>
        <?php
                if (isset($shop)) {
                    $lat = $shop->lat;
                    $lng = $shop->lng;
            ?>
                    var citymap = L.map('restaurant_map').setView([<?php echo $lat;?>, <?php echo $lng;?>], 5);
            <?php
                } else {
            ?>
                    var citymap = L.map('restaurant_map').setView([0, 0], 5);
            <?php
                }
            ?>

            const city_attribution =
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            const city_tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const city_tiles = L.tileLayer(city_tileUrl, { city_attribution });
            city_tiles.addTo(citymap);
            <?php if(isset($shop)) {?>
                var marker2 = new L.Marker(new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>));
                citymap.addLayer(marker2);
                // results = L.marker([<?php echo $lat;?>, <?php echo $lng;?>]).addTo(mymap);

            <?php } else { ?>
                var marker2 = new L.Marker(new L.LatLng(0, 0));
                //mymap.addLayer(marker2);
            <?php } ?>
            var searchControl = L.esri.Geocoding.geosearch().addTo(citymap);
            var results = L.layerGroup().addTo(citymap);

            searchControl.on('results',function(data){
                results.clearLayers();

                for(var i= data.results.length -1; i>=0; i--) {
                    citymap.removeLayer(marker2);
                    results.addLayer(L.marker(data.results[i].latlng));
                    var search_str = data.results[i].latlng.toString();
                    var search_res = search_str.substring(search_str.indexOf("(") + 1, search_str.indexOf(")"));
                    var searchArr = new Array();
                    searchArr = search_res.split(",");

                    document.getElementById("lat").value = searchArr[0].toString();
                    document.getElementById("lng").value = searchArr[1].toString(); 
                   
                }
            })
            var popup = L.popup();

            function onMapClick(e) {

                var str = e.latlng.toString();
                var str_res = str.substring(str.indexOf("(") + 1, str.indexOf(")"));
                citymap.removeLayer(marker2);
                results.clearLayers();
                results.addLayer(L.marker(e.latlng));   

                var tmpArr = new Array();
                tmpArr = str_res.split(",");

                document.getElementById("lat").value = tmpArr[0].toString(); 
                document.getElementById("lng").value = tmpArr[1].toString();
            }

            citymap.on('click', onMapClick);
        </script>
        <script>
            <?php
                if (isset($transaction)) {
                    $lat = $transaction->trans_lat;
                    $lng = $transaction->trans_lng;
            ?>
                    var trans_map = L.map('transaction_map').setView([<?php echo $lat;?>, <?php echo $lng;?>], 5);
            <?php
                } else {
            ?>
                    var trans_map = L.map('transaction_map').setView([0, 0], 5);
            <?php
                }
            ?>

            const trans_attribution =
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            const trans_tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const trans_tiles = L.tileLayer(trans_tileUrl, { trans_attribution });
            trans_tiles.addTo(trans_map);
            <?php if(isset($transaction)) {?>
                var trans_marker = new L.Marker(new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>));
                trans_map.addLayer(trans_marker);
                // results = L.marker([<?php echo $lat;?>, <?php echo $lng;?>]).addTo(mymap);

            <?php } else { ?>
                var trans_marker = new L.Marker(new L.LatLng(0, 0));
                //mymap.addLayer(marker2);
            <?php } ?>
            var trans_searchControl = L.esri.Geocoding.geosearch().addTo(trans_map);
            var results = L.layerGroup().addTo(trans_map);

            trans_searchControl.on('results',function(data){
                results.clearLayers();

                for(var i= data.results.length -1; i>=0; i--) {
                    trans_map.removeLayer(trans_marker);
                    results.addLayer(L.marker(data.results[i].latlng));
                    var trans_search_str = data.results[i].latlng.toString();
                    var trans_search_res = trans_search_str.substring(trans_search_str.indexOf("(") + 1, trans_search_str.indexOf(")"));
                    var trans_searchArr = new Array();
                    trans_searchArr = trans_search_res.split(",");

                    document.getElementById("lat").value = trans_searchArr[0].toString();
                    document.getElementById("lng").value = trans_searchArr[1].toString(); 
                   
                }
            })
            var popup = L.popup();

            function onMapClick(e) {

                var trans = e.latlng.toString();
                var trans_res = trans.substring(trans.indexOf("(") + 1, trans.indexOf(")"));
                trans_map.removeLayer(trans_marker);
                results.clearLayers();
                results.addLayer(L.marker(e.latlng));   

                var trans_tmpArr = new Array();
                trans_tmpArr = trans_res.split(",");

                document.getElementById("lat").value = trans_tmpArr[0].toString(); 
                document.getElementById("lng").value = trans_tmpArr[1].toString();
            }

            trans_map.on('click', onMapClick);
        </script>
        <?php show_analytic(); ?>
        <script src="<?php echo base_url( 'assets/validator/jquery.validate.js' ); ?>"></script>
        <script type="text/javascript">
          
          // functions to run after jquery is loaded
          if ( typeof runAfterJQ == "function" ) runAfterJQ();

          <?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
            
            // functions to run after jquery is loaded
            if ( typeof jqvalidate == "function" ) jqvalidate();

          <?php endif; ?>

                $('.page-sidebar-menu li').removeClass('active');

                // highlight submenu item
                $('li a[href="' + this.location.pathname + '"]').parent().addClass('active');

                // Highlight parent menu item.
                $('ul a[href="' + this.location.pathname + '"]').parents('li').addClass('active');

                

        </script>


    <?php if ( isset( $load_gallery_js )) : ?>

      <?php $this->load->view( $template_path .'/components/gallery_script' ); ?> 

    <?php endif; ?>

  </div>
 <!-- ./ wrapper -->
</body>
</html>