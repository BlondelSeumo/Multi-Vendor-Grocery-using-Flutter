import 'package:flutter/material.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:flutter_map/plugin_api.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/shop/new_shop_provider.dart';
import 'package:fluttermultigrocery/ui/common/dialog/confirm_dialog_view.dart';
import 'package:fluttermultigrocery/ui/common/ps_textfield_with_icon_widget.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';
import 'package:geocoder/geocoder.dart';
import 'package:geolocator/geolocator.dart';
import 'package:latlong/latlong.dart';
import 'package:provider/provider.dart';

class HomeLocationWidget extends StatefulWidget {
  const HomeLocationWidget(
      {Key key,

      /// If set, enable the FusedLocationProvider on Android
      @required this.androidFusedLocation,
      @required this.textEditingController,
      // @required this.newShopProvider,
      @required this.searchTextController,
      @required this.valueHolder})
      : super(key: key);

  final bool androidFusedLocation;
  final TextEditingController textEditingController;
  // final NewShopProvider newShopProvider;
  final TextEditingController searchTextController;
  final PsValueHolder valueHolder;

  @override
  _LocationState createState() => _LocationState();
}

class _LocationState extends State<HomeLocationWidget> {
  String address = '';
  Position _currentPosition;
  NewShopProvider newShopProvider;
  final MapController mapController = MapController();

  @override
  void initState() {
    super.initState();

    _initCurrentLocation();
  }

  @override
  void didUpdateWidget(Widget oldWidget) {
    super.didUpdateWidget(oldWidget);

    setState(() {
      // _lastKnownPosition = null;
      _currentPosition = null;
    });
  }

  // Platform messages are asynchronous, so we initialize in an async method.

  // dynamic loadAddress() async {
  //   if (newShopProvider != null && _currentPosition != null) {
  //     try {
  //       final List<Address> addresses = await Geocoder.local
  //           .findAddressesFromCoordinates(Coordinates(
  //               _currentPosition.latitude, _currentPosition.longitude));
  //       final Address first = addresses.first;
  //       address = '${first.adminArea} : ${first.addressLine}';
  //       setState(() {
  //         widget.textEditingController.text = address;
  //       });
  //     } catch (e) {
  //       print(e.toString());
  //     }
  //   }
  // }

  dynamic loadAddress() async {
    if (_currentPosition != null) {
      // _latlng ??= LatLng(_currentPosition.latitude, _currentPosition.longitude);
      // userProvider.setUserLatLng(_latlng);
      if (widget.textEditingController.text == '') {
        final List<Address> addresses = await Geocoder.local
            .findAddressesFromCoordinates(Coordinates(
                _currentPosition.latitude, _currentPosition.longitude));
        final Address first = addresses.first;
        address = '${first.addressLine}, ${first.countryName}';
        setState(() {
          widget.textEditingController.text = address;
        });
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
          });
          newShopProvider.shopNearYouParameterHolder.lat =
              _currentPosition.latitude.toString();
          newShopProvider.shopNearYouParameterHolder.lng =
              _currentPosition.longitude.toString();
          newShopProvider
              .loadShopList(newShopProvider.shopNearYouParameterHolder);
        }
      }).catchError((Object e) {
        //
      });
  }

  @override
  Widget build(BuildContext context) {
    loadAddress();
    newShopProvider = Provider.of<NewShopProvider>(context);
    return Column(
      children: <Widget>[
        Container(
          color: PsColors.backgroundColor,
          margin: const EdgeInsets.only(
            left: PsDimens.space6,
            right: PsDimens.space6,
            // bottom: PsDimens.space8
          ),
          child: Card(
            elevation: 0.0,
            shape: const BeveledRectangleBorder(
              borderRadius: BorderRadius.all(Radius.circular(PsDimens.space8)),
            ),
            color: PsColors.baseLightColor,
            child: Padding(
              padding: const EdgeInsets.all(12.0),
              child: Row(
                children: <Widget>[
                  Expanded(
                    child: Padding(
                      padding: const EdgeInsets.only(right: 8.0),
                      child: Text(
                        (widget.textEditingController.text == '')
                            ? Utils.getString(context, 'dashboard__open_gps')
                            : widget.textEditingController.text,
                        style: Theme.of(context).textTheme.bodyText1.copyWith(
                            letterSpacing: 0.8, fontSize: 16, height: 1.3),
                      ),
                    ),
                  ),
                  InkWell(
                    child: Container(
                      height: PsDimens.space44,
                      width: PsDimens.space44,
                      child: Icon(
                        Icons.gps_fixed,
                        color: PsColors.mainColor,
                        size: PsDimens.space20,
                      ),
                    ),
                    onTap: () {
                      if (newShopProvider.shopNearYouParameterHolder.lat ==
                          null) {
                        showDialog<dynamic>(
                            context: context,
                            builder: (BuildContext context) {
                              return ConfirmDialogView(
                                  description: Utils.getString(
                                      context, 'map_pin__open_gps'),
                                  leftButtonText: Utils.getString(context,
                                      'home__logout_dialog_cancel_button'),
                                  rightButtonText: Utils.getString(
                                      context, 'home__logout_dialog_ok_button'),
                                  onAgreeTap: () async {
                                    Navigator.pop(context);
                                  });
                            });
                      } else {
                        loadAddress();
                      }
                    },
                  ),
                ],
              ),
            ),
          ),
        ),
        _SearchWidget(
            addressController: widget.searchTextController,
            valueHolder: widget.valueHolder,
            newShopProvider: newShopProvider),
        const SizedBox(height: PsDimens.space8),
      ],
    );
  }
}

class _SearchWidget extends StatelessWidget {
  const _SearchWidget(
      {@required this.addressController,
      @required this.valueHolder,
      @required this.newShopProvider});
  final TextEditingController addressController;
  final PsValueHolder valueHolder;
  final NewShopProvider newShopProvider;
  @override
  Widget build(BuildContext context) {
    if (newShopProvider != null)
      return Container(
        color: PsColors.backgroundColor,
        child: Row(
          children: <Widget>[
            const SizedBox(
              width: PsDimens.space4,
            ),
            Flexible(
                child: PsTextFieldWidgetWithIcon(
                    hintText:
                        Utils.getString(context, 'home__bottom_app_bar_search'),
                    textEditingController: addressController,
                    psValueHolder: valueHolder,
                    textInputAction: TextInputAction.search,
                    currentPosition: (newShopProvider != null &&
                            newShopProvider.shopNearYouParameterHolder !=
                                null &&
                            newShopProvider.shopNearYouParameterHolder.lat !=
                                null &&
                            newShopProvider.shopNearYouParameterHolder.lat !=
                                '')
                        ? LatLng(
                            double.parse(
                                newShopProvider.shopNearYouParameterHolder.lat),
                            double.parse(
                                newShopProvider.shopNearYouParameterHolder.lng),
                          )
                        : LatLng(0, 0))),
            Container(
              height: PsDimens.space44,
              alignment: Alignment.center,
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
                      Octicons.settings,
                      color: PsColors.mainColor,
                      size: PsDimens.space20,
                    ),
                  ),
                  onTap: () async {
                    final ProductParameterHolder productParameterHolder =
                        ProductParameterHolder().getLatestParameterHolder();
                    productParameterHolder.searchTerm = addressController.text;
                    Utils.psPrint(productParameterHolder.searchTerm);
                    Navigator.pushNamed(context, RoutePaths.dashboardsearchFood,
                        arguments: ProductListIntentHolder(
                            appBarTitle: Utils.getString(
                                context, 'home_search__app_bar_title'),
                            productParameterHolder: productParameterHolder));
                  }),
            ),
            const SizedBox(
              width: PsDimens.space16,
            ),
          ],
        ),
      );
    else
      return Container();
  }
}
