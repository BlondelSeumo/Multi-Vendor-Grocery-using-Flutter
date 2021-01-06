import 'package:flutter/cupertino.dart';
import 'package:latlong/latlong.dart';

class MapPinCallBackHolder {
  const MapPinCallBackHolder({
    @required this.address,
    @required this.latLng,
  });
  final String address;
  final LatLng latLng;
}
