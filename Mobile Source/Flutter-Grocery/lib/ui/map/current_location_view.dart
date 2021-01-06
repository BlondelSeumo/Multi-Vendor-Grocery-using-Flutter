import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/user/user_provider.dart';
import 'package:fluttermultigrocery/ui/common/dialog/warning_dialog_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/holder/map_pin_call_back_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/map_pin_intent_holder.dart';
import 'package:geocoder/geocoder.dart';
import 'package:geolocator/geolocator.dart';
import 'package:latlong/latlong.dart';
import 'package:provider/provider.dart';

class CurrentLocationWidget extends StatefulWidget {
  const CurrentLocationWidget({
    Key key,

    /// If set, enable the FusedLocationProvider on Android
    @required this.androidFusedLocation,
    @required this.textEditingController,
    // @required this.userLatLng
  }) : super(key: key);

  final bool androidFusedLocation;
  final TextEditingController textEditingController;
  // final LatLng userLatLng;

  @override
  _LocationState createState() => _LocationState();
}

class _LocationState extends State<CurrentLocationWidget> {
  // Position _lastKnownPosition;
  Position _currentPosition;
  String address = '';
  LatLng _latlng;
  UserProvider userProvider;
  bool bindDataFirstTime = true;
  final MapController mapController = MapController();
  final double zoomLevel = 17;
  @override
  void initState() {
    super.initState();

    _initLastKnownLocation();
    _initCurrentLocation();
  }

  @override
  void didUpdateWidget(Widget oldWidget) {
    super.didUpdateWidget(oldWidget);

    setState(() {
      // _lastKnownPosition = null;
      _currentPosition = null;
    });

    _initLastKnownLocation().then((_) => _initCurrentLocation());
  }

  // Platform messages are asynchronous, so we initialize in an async method.
  Future<void> _initLastKnownLocation() async {}

  dynamic loadAddress() async {
    if (_currentPosition != null) {
      _latlng ??= LatLng(_currentPosition.latitude, _currentPosition.longitude);
      userProvider.setUserLatLng(_latlng);
      if (widget.textEditingController.text == '') {
        final List<Address> addresses = await Geocoder.local
            .findAddressesFromCoordinates(Coordinates(
                _currentPosition.latitude, _currentPosition.longitude));
        final Address first = addresses.first;
        address = '${first.addressLine}, ${first.countryName}';
        widget.textEditingController.text = address;
      } else {
        address = widget.textEditingController.text;
      }
    }
  }

  // Platform messages are asynchronous, so we initialize in an async method.
  dynamic _initCurrentLocation() {
    Geolocator()
      ..forceAndroidLocationManager = !widget.androidFusedLocation
      ..getCurrentPosition(
        desiredAccuracy: LocationAccuracy.medium,
      ).then((Position position) {
        if (mounted) {
          setState(() {
            _currentPosition = position;
            if (!userProvider.hasLatLng()) {
              _latlng =
                  LatLng(_currentPosition.latitude, _currentPosition.longitude);
              userProvider.setUserLatLng(_latlng);
              mapController.move(_latlng, zoomLevel);
            }
          });
        }
      }).catchError((Object e) {
        //
      });
  }

  dynamic _handleTap(
      MapController mapController, bool isUserCurrentLocation) async {
    String _tmpLat =
        _latlng != null ? _latlng.latitude.toString() : PsConfig.lat;
    String _tmpLng =
        _latlng != null ? _latlng.longitude.toString() : PsConfig.lng;
    if (isUserCurrentLocation) {
      _tmpLat = _currentPosition.latitude.toString();
      _tmpLng = _currentPosition.longitude.toString();
    }

    final dynamic result = await Navigator.pushNamed(context, RoutePaths.mapPin,
        arguments: MapPinIntentHolder(
            flag: PsConst.PIN_MAP, mapLat: _tmpLat, mapLng: _tmpLng));
    if (result != null && result is MapPinCallBackHolder) {
      setState(() {
        _latlng = result.latLng;
        userProvider.setUserLatLng(_latlng);
        mapController.move(result.latLng, zoomLevel);
        widget.textEditingController.text = result.address;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    userProvider = Provider.of<UserProvider>(context, listen: false);
    _latlng = userProvider.getUserLatLng();
    loadAddress();

    final Widget _addressHeaderWidget = Row(
      children: <Widget>[
        Text(Utils.getString(context, 'edit_profile__address'),
            style: Theme.of(context).textTheme.bodyText1),
        Text(' *',
            style: Theme.of(context)
                .textTheme
                .bodyText1
                .copyWith(color: PsColors.mainColor))
      ],
    );

    return FutureBuilder<GeolocationStatus>(
        future: Geolocator().checkGeolocationPermissionStatus(),
        builder:
            (BuildContext context, AsyncSnapshot<GeolocationStatus> snapshot) {
          if (!snapshot.hasData) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.data == GeolocationStatus.denied) {
            // return const Text('Allow access to the location services for this App using the device settings.');
          }

          return Center(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.start,
              children: <Widget>[
                Container(
                  margin: const EdgeInsets.all(
                    PsDimens.space12,
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: <Widget>[
                      _addressHeaderWidget,
                      _GpsButtonWidget(
                          currentPosition: _currentPosition,
                          mapController: mapController,
                          handleTap: _handleTap),
                    ],
                  ),
                ),
                if (_latlng != null)
                  _MapViewWidget(
                    mapController: mapController,
                    latlng: _latlng,
                    handleTap: _handleTap,
                    zoomLevel: zoomLevel,
                  )
                // else if (userProvider.userLatLng != null &&
                //     widget.userLatLng.latitude != 0 &&
                //     widget.userLatLng.longitude != 0)
                //   _MapViewWidget(
                //     mapController: mapController,
                //     latlng: widget.userLatLng,
                //     handleTap: _handleTap,
                //   )
                else
                  _MapViewWidget(
                    mapController: mapController,
                    latlng: LatLng(
                        double.parse(PsConfig.lat), double.parse(PsConfig.lng)),
                    handleTap: _handleTap,
                    zoomLevel: zoomLevel,
                  )

                // if (_latlng == null && _currentPosition == null)
                //   Padding(
                //       padding: const EdgeInsets.only(
                //           right: PsDimens.space8,
                //           left: PsDimens.space8,
                //           bottom: PsDimens.space12),
                //       child: Container(
                //         height: 250,
                //         child: FlutterMap(
                //           mapController: mapController,
                //           options: MapOptions(
                //               center: widget.userLatLng,
                //               zoom: 15.0,
                //               onTap: (LatLng latLng) {
                //                 FocusScope.of(context)
                //                     .requestFocus(FocusNode());
                //                 _handleTap(mapController);
                //               }),
                //           layers: <LayerOptions>[
                //             TileLayerOptions(
                //               urlTemplate:
                //                   'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                //             ),
                //             MarkerLayerOptions(markers: <Marker>[
                //               Marker(
                //                 width: 80.0,
                //                 height: 80.0,
                //                 point: widget.userLatLng,
                //                 builder: (BuildContext ctx) => Container(
                //                   child: IconButton(
                //                     icon: Icon(
                //                       Icons.location_on,
                //                       color: Colors.red,
                //                     ),
                //                     iconSize: 45,
                //                     onPressed: () {},
                //                   ),
                //                 ),
                //               )
                //             ])
                //           ],
                //         ),
                //       ))
                // else
                //   Container()
                // ,Text( _lastKnownPosition.toString()),
                // Text(_currentPosition.toString()),
                // Text(address),
              ],
            ),
          );
        });
  }
}

class _MapViewWidget extends StatelessWidget {
  const _MapViewWidget(
      {Key key,
      @required this.mapController,
      @required LatLng latlng,
      @required this.handleTap,
      @required this.zoomLevel})
      : _latlng = latlng,
        super(key: key);

  final MapController mapController;
  final LatLng _latlng;
  final Function handleTap;
  final double zoomLevel;

  @override
  Widget build(BuildContext context) {
    return Padding(
        padding: const EdgeInsets.only(
            right: PsDimens.space8,
            left: PsDimens.space8,
            bottom: PsDimens.space12),
        child: Container(
          height: 250,
          child: FlutterMap(
            mapController: mapController,
            options: MapOptions(
                center: _latlng,
                zoom: zoomLevel,
                onTap: (LatLng latLng) {
                  FocusScope.of(context).requestFocus(FocusNode());
                  handleTap(mapController, false);
                }),
            layers: <LayerOptions>[
              TileLayerOptions(
                urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
              ),
              MarkerLayerOptions(markers: <Marker>[
                Marker(
                  width: 80.0,
                  height: 80.0,
                  point: _latlng,
                  builder: (BuildContext ctx) => Container(
                    child: IconButton(
                      icon: const Icon(
                        Icons.location_on,
                        color: Colors.red,
                      ),
                      iconSize: 45,
                      onPressed: () {},
                    ),
                  ),
                )
              ])
            ],
          ),
        ));
  }
}

class _GpsButtonWidget extends StatelessWidget {
  const _GpsButtonWidget(
      {Key key,
      @required Position currentPosition,
      @required this.mapController,
      @required this.handleTap})
      : _currentPosition = currentPosition,
        super(key: key);

  final Position _currentPosition;
  final MapController mapController;
  final Function handleTap;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: PsDimens.space44,
      alignment: Alignment.center,
      margin: const EdgeInsets.only(right: PsDimens.space4),
      decoration: BoxDecoration(
        color: PsColors.baseDarkColor,
        borderRadius: BorderRadius.circular(PsDimens.space4),
        border: Border.all(color: PsColors.mainDividerColor),
      ),
      child: InkWell(
        child: Container(
          height: double.infinity,
          width: PsDimens.space44,
          child: Icon(
            Icons.gps_fixed,
            color: PsColors.iconColor,
            size: PsDimens.space20,
          ),
        ),
        onTap: () {
          if (_currentPosition == null) {
            showDialog<dynamic>(
                context: context,
                builder: (BuildContext context) {
                  return WarningDialog(
                    message: Utils.getString(context, 'map_pin__open_gps'),
                    onPressed: () {},
                    // leftButtonText: Utils.getString(
                    //     context, 'home__logout_dialog_cancel_button'),
                    // rightButtonText: Utils.getString(
                    //     context, 'home__logout_dialog_ok_button'),
                    // onAgreeTap: () async {
                    //   Navigator.pop(context);
                    // }
                  );
                });
          } else {
            handleTap(mapController, true);
          }
        },
      ),
    );
  }
}
